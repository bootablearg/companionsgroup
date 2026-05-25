<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController as WebHomeController;
use App\Http\Controllers\Web\AvisoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\Web\ModeloDashboardController;
use App\Http\Controllers\Web\SubscriberDashboardController;
use App\Http\Controllers\Web\ReviewController;
use App\Http\Controllers\Web\ModeloReviewController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Web\TelegramBotWebhookController;
use App\Http\Controllers\Web\ContactTrackController;
use App\Models\SubscriptionPlan;
use App\Http\Controllers\Web\PasswordChangeController;
use App\Http\Controllers\Web\VideoUploadController;
use App\Http\Controllers\Web\AccountDeletionController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Web\BlogController;

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// ── Canonical URLs: /avisos ────────────────────────────────────────────────
Route::get('/avisos', [HomeController::class, 'escorts'])->name('modelos.index');
Route::get('/modelo', fn() => redirect('/avisos', 301));
Route::get('/modelos', [HomeController::class, 'modelosList'])->name('modelos.list');
// NOTE: /modelo/{escort} is defined AFTER all static /modelo/* routes to avoid
// the dynamic segment capturing "dashboard", "kyc", etc. (see bottom of file)

// ── SEO slug routes ───────────────────────────────────────────────────────
Route::get('/escorts/{slug}', [AvisoController::class, 'showBySlug'])->name('aviso.show.slug');
Route::get('/escorts', fn() => redirect('/avisos', 301));

// ── Landing pages por barrio CABA ─────────────────────────────────────────
Route::get('/modelos-premium-{barrio}', [\App\Http\Controllers\Web\LandingBarrioController::class, 'showElite'])->name('landing.barrio.elite');

// ── Review submission (authenticated subscribers only) ────────────────────
Route::middleware(['auth', 'verified'])->post(
    '/modelo/{modelo}/resena',
    [ReviewController::class, 'store']
)->name('reviews.store');

// ── Contact tracking (subscribers only, silent fail) ─────────────────────
Route::middleware(['auth', 'verified', 'throttle:60,1'])->post(
    '/aviso/{aviso}/contacto',
    [ContactTrackController::class, 'store']
)->name('contact.track');

// ── Favorite toggle ───────────────────────────────────────────────────────
Route::middleware(['auth', 'verified'])->post(
    '/modelo/{modelo}/favorito',
    [\App\Http\Controllers\Web\FavoriteController::class, 'toggle']
)->name('favorites.toggle');

Route::get('/search', [SearchController::class, 'index'])->name('search');

// /buscar → /search (redirect 301)
Route::get('/buscar', fn() => redirect('/search', 301))->name('buscar');

// ── Aviso public routes ───────────────────────────────────────────────────
Route::get('/aviso/{id}', [AvisoController::class, 'show'])->name('aviso.show');
Route::get('/aviso/{id}/details', [AvisoController::class, 'details'])->name('aviso.details');
Route::post('/aviso/{id}/report', [AvisoController::class, 'report'])->name('aviso.report')->middleware(['auth', 'verified', 'role:subscriber']);
Route::get('/terminos', function () {
    $page = App\Models\LegalPage::find('terms');
    return view('pages.terms', compact('page'));
})->name('terms');
Route::get('/privacidad', function () {
    $page = App\Models\LegalPage::find('privacy');
    return view('pages.privacy', compact('page'));
})->name('privacy');
Route::get('/faq', function () {
    $user = auth()->user();
    $allowedAudiences = ['all'];
    if ($user) {
        if ($user->isModelo())     $allowedAudiences[] = 'escort';
        if ($user->isSubscriber()) $allowedAudiences[] = 'subscriber';
        if ($user->role === 'admin') $allowedAudiences = ['all', 'escort', 'subscriber', 'admin'];
    }
    $faqItems = \App\Models\FaqItem::active()->ordered()
        ->whereIn('audience', $allowedAudiences)
        ->get();
    return view('pages.faq', compact('faqItems'));
})->name('faq');
Route::get('/soporte', fn() => view('pages.support'))->name('support');
Route::get('/planes', function () {
    $plans = SubscriptionPlan::active()->orderBy('price')->get();
    return view('pages.planes', compact('plans'));
})->name('planes');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/registro', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/registro', [RegisterController::class, 'register'])->middleware('throttle:5,10');
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,2');

    // Password reset — solicitud (solo guest)
    Route::get('/recuperar-contrasena', [PasswordResetController::class, 'showRequestForm'])->name('password.request');
    Route::post('/recuperar-contrasena', [PasswordResetController::class, 'sendResetLink'])->name('password.email')->middleware('throttle:5,10');
});

// Password reset — formulario y guardado (accesible aunque esté logueado, el link del email debe funcionar siempre)
Route::get('/nueva-contrasena/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/nueva-contrasena', [PasswordResetController::class, 'resetPassword'])->name('password.update')->middleware('throttle:5,10');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/verificar-email/{token}', [EmailVerificationController::class, 'verify'])->name('verify.email');
Route::get('/verificar-email', fn() => view('auth.verify-notice'))->name('verification.notice')->middleware('auth');
Route::post('/reenviar-verificacion', [EmailVerificationController::class, 'resend'])->name('verify.resend')->middleware(['auth', 'throttle:3,10']);

// Escort dashboard
Route::middleware(['auth', 'verified', 'role:modelo'])->prefix('modelo')->name('modelo.')->group(function () {
    Route::get('/dashboard', [ModeloDashboardController::class, 'index'])->name('dashboard');
    Route::get('/kyc', [ModeloDashboardController::class, 'kyc'])->name('kyc');

    // ── Mis Avisos (lista + edición) ──────────────────────────────────────
    Route::get('/avisos', [ModeloDashboardController::class, 'avisoIndex'])->middleware('kyc.approved')->name('aviso.index');
    Route::get('/avisos/crear', [ModeloDashboardController::class, 'createAviso'])->middleware('kyc.approved')->name('aviso.create');
    Route::post('/avisos', [ModeloDashboardController::class, 'storeAviso'])->middleware('kyc.approved')->name('aviso.store');
    Route::get('/avisos/{avisoId}/editar', [ModeloDashboardController::class, 'editAviso'])->middleware('kyc.approved')->name('aviso.edit.specific');
    Route::post('/avisos/{avisoId}/video', [VideoUploadController::class, 'store'])->middleware('kyc.approved')->name('aviso.video.upload');
    Route::delete('/video/{video}', [VideoUploadController::class, 'destroy'])->middleware('kyc.approved')->name('aviso.video.destroy');
    // Legacy: /aviso/editar → /avisos (list)
    Route::get('/aviso/editar', fn() => redirect()->route('modelo.aviso.index'))->name('aviso.edit');

    Route::get('/suscripcion', [ModeloDashboardController::class, 'subscription'])->name('subscription');
    Route::post('/suscripcion/pagar', [ModeloDashboardController::class, 'subscriptionPay'])->name('subscription.pay');
    Route::post('/suscripcion/mercadopago', [ModeloDashboardController::class, 'subscriptionMercadoPago'])->name('subscription.mercadopago');
    Route::get('/notificaciones', [ModeloDashboardController::class, 'notifications'])->name('notifications');
    Route::post('/notificaciones/leer-todas', [ModeloDashboardController::class, 'markAllRead'])->name('notifications.read-all');
    Route::patch('/notificaciones/{id}/leer', [ModeloDashboardController::class, 'markRead'])->name('notifications.read');
    Route::get('/suscripcion/exito', [ModeloDashboardController::class, 'subscriptionSuccess'])->name('subscription.success');
    Route::get('/suscripcion/error', [ModeloDashboardController::class, 'subscriptionFailure'])->name('subscription.failure');
    Route::get('/suscripcion/pendiente', [ModeloDashboardController::class, 'subscriptionPending'])->name('subscription.pending');

    // Cambio de contraseña
    Route::get('/seguridad', [PasswordChangeController::class, 'showEscort'])->name('security');
    Route::post('/seguridad', [PasswordChangeController::class, 'updateEscort'])->name('security.update');

    // Datos de contacto (email privado, teléfono, contacto público, ubicación, domicilio)
    Route::get('/perfil', [ModeloDashboardController::class, 'perfil'])->name('perfil');
    Route::patch('/contacto', [ModeloDashboardController::class, 'updateContact'])->name('contact.update');

    // Reseñas recibidas
    Route::get('/telegram/conectar', [ModeloDashboardController::class, 'telegramConnect'])->name('telegram.connect');
    Route::get('/resenas', [ModeloReviewController::class, 'index'])->name('reviews.index');
    Route::post('/resenas/{review}/publicar', [ModeloReviewController::class, 'publish'])->name('reviews.publish');
    Route::post('/resenas/{review}/ocultar', [ModeloReviewController::class, 'hide'])->name('reviews.hide');
});

// Subscriber dashboard
Route::middleware(['auth', 'verified', 'role:subscriber'])->prefix('suscriptor')->name('subscriber.')->group(function () {
    // Siempre accesibles (sin KYC requerido)
    Route::get('/dashboard', [SubscriberDashboardController::class, 'index'])->name('dashboard');
    Route::get('/kyc', [SubscriberDashboardController::class, 'kyc'])->name('kyc');
    Route::get('/seguridad', [PasswordChangeController::class, 'showSubscriber'])->name('security');
    Route::post('/seguridad', [PasswordChangeController::class, 'updateSubscriber'])->name('security.update');

    // Requieren KYC aprobado
    Route::middleware('kyc.approved')->group(function () {
        Route::patch('/perfil', [SubscriberDashboardController::class, 'updateContact'])->name('profile.update');
        Route::get('/favoritos', [SubscriberDashboardController::class, 'favorites'])->name('favorites');
        Route::delete('/favoritos/{avisoId}', [SubscriberDashboardController::class, 'removeFavorite'])->name('favorites.remove');
        Route::get('/resenas', [SubscriberDashboardController::class, 'reviews'])->name('reviews');
        Route::get('/notificaciones', [SubscriberDashboardController::class, 'notifications'])->name('notifications');
        Route::get('/reportes', [SubscriberDashboardController::class, 'reports'])->name('reports');
        Route::post('/reportes', [SubscriberDashboardController::class, 'storeReport'])->name('reports.store');
        Route::get('/historial-contactos', [SubscriberDashboardController::class, 'contactHistory'])->name('contact.history');
    });
});

// ── Public model profile (MUST be last among /modelo/* routes so that static
//    segments like /modelo/dashboard, /modelo/kyc etc. are matched first) ────
Route::get('/modelo/{modelo}', [ModeloController::class, 'show'])->name('modelos.show');

// Account deletion request (accessible to both modelo and subscriber)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/cuenta/eliminar', [AccountDeletionController::class, 'show'])->name('account.delete.show');
    Route::post('/cuenta/eliminar', [AccountDeletionController::class, 'store'])->name('account.delete.store');
});

// Telegram Bot Webhook — excluido del CSRF en bootstrap/app.php
Route::post('/telegram/webhook', [TelegramBotWebhookController::class, 'handle'])
    ->name('telegram.webhook');
