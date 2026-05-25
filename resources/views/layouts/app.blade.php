<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="var(--brand-primary)">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Elite Companions — Modelos y Acompañantes Verificadas en Argentina')</title>
    @if(app()->environment('production'))
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    @else
    <meta name="robots" content="noindex, nofollow">
    @endif
    <meta name="description" content="@yield('meta_description', 'Modelos y Escorts de élite premium en Argentina con verificación de identidad real. El único directorio de putas con KYC real. Filtrá por ciudad, disponibilidad, servicio y precio.')">
    <meta name="keywords" content="@yield('meta_keywords', 'modelos escorts argentina, acompañantes verificadas argentina, escorts de elite argentina, acompañantes premium argentina, escorts premium verificadas, escorts con identidad verificada, escorts verificadas argentina, escorts buenos aires, acompañantes premium argentina, companions verificadas argentina, putas argentina, trolas argentina, ArgentinaXP, BaireGirls, Gemidos, ArgentinaBlack')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Open Graph -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', 'Elite Companions — Modelos y Acompañantes Verificadas en Argentina')">
    <meta property="og:description" content="@yield('og_description', 'Modelos y Escorts de élite premium en Argentina con verificación de identidad real. El único directorio de putas con KYC real.')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:image" content="@yield('og_image', asset('images/og-preview.png'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="Elite Companions">
    <meta property="og:locale" content="es_AR">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'Elite Companions — Modelos y Acompañantes Verificadas en Argentina')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Modelos y Escorts de élite verificadas en Argentina. El único directorio de putas con KYC real.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-preview.png'))">

    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">

    @livewireStyles

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        body { background-color: var(--background, var(--page-background)); color: var(--text-dark, var(--text-primary)); }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--border-muted, var(--border-subtle)); }
        ::-webkit-scrollbar-thumb { background: var(--border-light); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--brand-primary, var(--brand-primary)); }
        .btn-gradient {
            background: linear-gradient(135deg, var(--brand-primary, var(--brand-primary)), var(--brand-accent, var(--action-secondary)));
            color: var(--btn-primary-text);
            transition: opacity .2s;
        }
        .btn-gradient:hover { opacity: .9; }
        .btn-nav-ghost {
            background: none;
            border: 1.5px solid var(--brand-primary-300);
            color: var(--brand-primary);
            transition: background .15s, color .15s, border-color .15s;
        }
        .btn-nav-ghost:hover { background: var(--surface-accent-soft-bg); border-color: var(--brand-primary); }
        /* Footer */
        .site-footer { background: var(--surface-card) !important; border-top: 1px solid var(--border-default) !important; }
        .site-footer p, .site-footer li, .site-footer span:not(.font-extrabold) { color: var(--text-secondary) !important; }
        .site-footer h3 { color: var(--text-empty-state) !important; }
        .site-footer a:not(.flex) { color: var(--text-secondary) !important; }
        .site-footer a:not(.flex):hover { color: var(--brand-primary) !important; }
        .site-footer .footer-divider { border-color: var(--border-default) !important; }
        /* Navbar responsive — avoids Tailwind CDN missing rules */
        .nav-desktop { display: inline-block; }
        .nav-mobile-toggle { display: none; }
        .nav-mobile-panel { display: none; }
        @media (max-width: 767px) {
            .nav-desktop { display: none; }
            .nav-mobile-toggle { display: block; }
            .nav-mobile-panel.nav-mobile-open { display: block; }
        }
        @yield('page_style')
    </style>

    @stack('head')
    @stack('json_ld')

    @if (isset($theme) && is_array($theme) && isset($theme['colors']) && count($theme['colors']) > 0)
        <!-- Theme colors loaded: {{ count($theme['colors']) }} tokens -->
        <style>
            :root {
                @foreach ($theme['colors'] as $name => $value)
                    --{{ str_replace('_', '-', $name) }}: {{ $value }};
                @endforeach
                @foreach ($theme['typography'] as $name => $value)
                    --{{ str_replace('_', '-', $name) }}: {{ $value }};
                @endforeach
            }

            /* Override Tailwind background colors */
            .bg-brand-primary { background-color: var(--brand-primary) !important; }
            .bg-brand-accent { background-color: var(--action-secondary) !important; }
            .bg-background { background-color: var(--page-background) !important; }
            .bg-surface-white { background-color: var(--surface-card) !important; }
            .bg-surface-light { background-color: var(--surface-secondary) !important; }
            .bg-surface-muted { background-color: var(--surface-tertiary) !important; }
            .bg-success { background-color: var(--success) !important; }
            .bg-warning { background-color: var(--warning) !important; }
            .bg-error { background-color: var(--error) !important; }
            .bg-info { background-color: var(--info) !important; }

            /* Override text colors */
            .text-brand-primary { color: var(--brand-primary) !important; }
            .text-brand-accent { color: var(--action-secondary) !important; }
            .text-dark { color: var(--text-primary) !important; }
            .text-muted { color: var(--text-secondary) !important; }
            .text-link { color: var(--text-link) !important; }
            .text-success { color: var(--success) !important; }
            .text-warning { color: var(--warning) !important; }
            .text-error { color: var(--error) !important; }
            .text-info { color: var(--info) !important; }

            /* Override border colors */
            .border-brand-primary { border-color: var(--brand-primary) !important; }
            .border-light { border-color: var(--border-default) !important; }
            .border-muted { border-color: var(--border-subtle) !important; }

            /* Override ring/focus colors */
            .ring-brand-primary { --tw-ring-color: var(--brand-primary) !important; }
            .focus\:ring-brand-primary:focus { --tw-ring-color: var(--brand-primary) !important; }

            /* Gradients */
            .gradient-primary {
                background: var(--gradient-accent-brand) !important;
            }

        </style>
    @endif
</head>
<body class="min-h-screen flex flex-col antialiased" style="background:var(--background, var(--page-background));">

    <!-- Cookie Banner -->
    <x-cookie-banner />

    <!-- Navigation -->
    <header class="sticky top-0 z-50" style="background:var(--surface-card);border-bottom:1px solid var(--border-default);">
        <nav class="w-full px-3">
            <div class="relative flex items-center justify-between h-16">

                <!-- Left: Buscar modelo + Listado buttons -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('search') }}"
                       class="btn-gradient nav-desktop text-sm font-semibold px-5 py-2 rounded-full">
                        Buscar modelo
                    </a>
                    <a href="{{ route('modelos.index') }}"
                       class="btn-gradient nav-desktop text-sm font-semibold px-5 py-2 rounded-full">
                        Listado de Avisos
                    </a>
                    <a href="{{ route('modelos.list') }}"
                       class="btn-gradient nav-desktop text-sm font-semibold px-5 py-2 rounded-full">
                        Listado de Modelos
                    </a>
                </div>

                <!-- Center: absolutamente centrado -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <a href="{{ route('home') }}" class="pointer-events-auto">
                        <span style="font-size:1.44rem;font-weight:800;letter-spacing:-.025em;background:linear-gradient(135deg,var(--brand-primary, var(--brand-primary)),var(--brand-accent, var(--action-secondary)));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                            Elite Companions
                        </span>
                    </a>
                </div>

                <!-- Right: Auth Buttons -->
                <div class="flex items-center gap-2">
                    @auth
                        @if(auth()->user()->role === 'modelo')
                            <a href="{{ route('modelo.dashboard') }}"
                               class="btn-gradient nav-desktop text-sm font-semibold px-5 py-2 rounded-full">
                                Mi Panel
                            </a>
                        @elseif(auth()->user()->role === 'subscriber')
                            <a href="{{ route('subscriber.dashboard') }}"
                               class="btn-gradient nav-desktop text-sm font-semibold px-5 py-2 rounded-full">
                                Mi Panel
                            </a>
                        @elseif(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                               class="btn-gradient nav-desktop text-sm font-semibold px-5 py-2 rounded-full">
                                Admin
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                    class="btn-gradient nav-desktop text-sm font-semibold px-5 py-2 rounded-full">
                                Salir
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                           class="btn-gradient nav-desktop text-sm font-semibold px-5 py-2 rounded-full">
                            Iniciar sesión
                        </a>
                        <a href="{{ route('register') }}"
                           class="btn-gradient nav-desktop text-sm font-semibold px-5 py-2 rounded-full">
                            Hacete miembro
                        </a>
                    @endauth

                    <!-- Mobile menu button -->
                    <button class="nav-mobile-toggle p-1.5" style="color:var(--text-secondary);"
                            onclick="this.closest('nav').querySelector('.nav-mobile-panel').classList.toggle('nav-mobile-open')"
                            aria-label="Menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Nav -->
            <div class="nav-mobile-panel pb-3 pt-2" style="border-top:1px solid var(--border-default);">
                <div class="flex flex-col gap-2 px-1">
                    <a href="{{ route('search') }}"
                       class="btn-gradient text-sm font-semibold px-5 py-2.5 rounded-full text-center">
                        Buscar modelo
                    </a>
                    <a href="{{ route('modelos.index') }}"
                       class="btn-gradient text-sm font-semibold px-5 py-2.5 rounded-full text-center">
                        Listado de Avisos
                    </a>
                    <a href="{{ route('modelos.list') }}"
                       class="btn-gradient text-sm font-semibold px-5 py-2.5 rounded-full text-center">
                        Listado de Modelos
                    </a>
                    @auth
                        @if(auth()->user()->role === 'modelo')
                            <a href="{{ route('modelo.dashboard') }}"
                               class="btn-gradient text-sm font-semibold px-5 py-2.5 rounded-full text-center">
                                Mi Panel
                            </a>
                        @elseif(auth()->user()->role === 'subscriber')
                            <a href="{{ route('subscriber.dashboard') }}"
                               class="btn-gradient text-sm font-semibold px-5 py-2.5 rounded-full text-center">
                                Mi Panel
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full btn-gradient text-sm font-semibold px-5 py-2.5 rounded-full text-center">
                                Salir
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                           class="btn-gradient text-sm font-semibold px-5 py-2.5 rounded-full text-center">
                            Iniciar sesión
                        </a>
                        <a href="{{ route('register') }}"
                           class="btn-gradient text-sm font-semibold px-5 py-2.5 rounded-full text-center">
                            Hacete miembro
                        </a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <!-- Flash Messages -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             class="fixed top-20 right-4 z-50 px-5 py-3 rounded-xl text-sm shadow-lg flex items-center gap-2"
             style="background:var(--status-success-light-bg);border:1px solid var(--status-success-light-border);color:var(--status-success-text-dark);">
            <svg class="w-4 h-4 flex-shrink-0" style="color:var(--status-success-text);" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-20 right-4 z-50 px-5 py-3 rounded-xl text-sm shadow-lg flex items-center gap-2"
             style="background:var(--status-error-light-bg-soft);border:1px solid var(--status-error-light-border);color:var(--status-error-text-strong);">
            <svg class="w-4 h-4 flex-shrink-0" style="color:var(--status-error-text-strong);" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-20 right-4 z-50 px-5 py-3 rounded-xl text-sm shadow-lg flex items-center gap-2"
             style="background:var(--status-error-light-bg-soft);border:1px solid var(--status-error-light-border);color:var(--status-error-text-strong);">
            <svg class="w-4 h-4 flex-shrink-0" style="color:var(--status-error-text-strong);" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="site-footer mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Brand -->
                <div>
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 mb-3">
                        <img src="/images/logo.webp" alt="Elite Companions" style="height:72px;width:auto;border-radius:50%;">
                        <span class="font-extrabold tracking-tight"
                              style="font-size:1.2rem;background:linear-gradient(135deg,var(--brand-primary, var(--brand-primary)),var(--brand-accent, var(--action-secondary)));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                            Elite Companions
                        </span>
                    </a>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Plataforma de compañía premium para adultos mayores de 18 años.
                    </p>
                </div>

                <!-- Legal -->
                <div>
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Legal</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('terms') }}" class="text-sm text-gray-500 hover:text-violet-600 transition-colors">Términos y Condiciones</a></li>
                        <li><a href="{{ route('privacy') }}" class="text-sm text-gray-500 hover:text-violet-600 transition-colors">Política de Privacidad</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-violet-600 transition-colors">Política de Cookies</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Soporte</h3>
                    <ul class="space-y-2 mb-5">
                        <li><a href="{{ route('faq') }}" class="text-sm text-gray-500 hover:text-violet-600 transition-colors">Preguntas Frecuentes</a></li>
                        <li><a href="{{ route('support') }}" class="text-sm text-gray-500 hover:text-violet-600 transition-colors">Soporte</a></li>
                    </ul>
                                        <!-- Contact channels - dinamico desde DB -->
                    @php
                        try {
                            $footerLinks = \App\Models\ContactLink::active()->get()->groupBy('platform');
                        } catch (\Exception $e) {
                            $footerLinks = collect();
                        }
                    @endphp
                    @if($footerLinks->isNotEmpty())
                    <div class="flex flex-col gap-2">
                        @foreach($footerLinks as $platform => $platformLinks)
                        @foreach($platformLinks as $cl)
                        @if($platform === 'whatsapp')
                        <a href="{{ $cl->url }}" target="_blank" rel="noopener"
                           class="flex items-center gap-2 text-xs text-gray-500 transition-colors"
                           onmouseover="this.style.color='var(--social-whatsapp-bg)'" onmouseout="this.style.color=''">
                            <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill="var(--social-whatsapp-bg)" d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.978-1.405A9.953 9.953 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"/>
                                <path fill="var(--text-inverted)" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                            </svg>
                            <span>{{ $cl->label }}</span>
                        </a>
                        @elseif($platform === 'telegram')
                        <a href="{{ $cl->url }}" target="_blank" rel="noopener"
                           class="flex items-center gap-2 text-xs text-gray-500 transition-colors"
                           onmouseover="this.style.color='var(--social-telegram-bg)'" onmouseout="this.style.color=''">
                            <svg style="color:var(--social-telegram-bg)" class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.944 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0a12 12 0 00-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 01.171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                            </svg>
                            <span>{{ $cl->label }}</span>
                        </a>
                        @elseif($platform === 'discord')
                        <a href="{{ $cl->url }}" target="_blank" rel="noopener"
                           class="flex items-center gap-2 text-xs text-gray-500 transition-colors"
                           onmouseover="this.style.color='var(--social-discord-bg)'" onmouseout="this.style.color=''">
                            <svg style="color:var(--social-discord-bg)" class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.317 4.37a19.791 19.791 0 00-4.885-1.515.074.074 0 00-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 00-5.487 0 12.64 12.64 0 00-.617-1.25.077.077 0 00-.079-.037A19.736 19.736 0 003.677 4.37a.07.07 0 00-.032.027C.533 9.046-.32 13.58.099 18.057c.002.022.015.043.031.056a19.9 19.9 0 005.993 3.03.078.078 0 00.084-.028 14.09 14.09 0 001.226-1.994.076.076 0 00-.041-.106 13.107 13.107 0 01-1.872-.892.077.077 0 01-.008-.128 10.2 10.2 0 00.372-.292.074.074 0 01.077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 01.078.01c.12.098.246.198.373.292a.077.077 0 01-.006.127 12.299 12.299 0 01-1.873.892.077.077 0 00-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 00.084.028 19.839 19.839 0 006.002-3.03.077.077 0 00.032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 00-.031-.03z"/>
                            </svg>
                            <span>{{ $cl->label }}</span>
                        </a>
                        @endif
                        @endforeach
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <div class="footer-divider mt-8 pt-6 border-t flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-xs text-gray-400">
                    &copy; {{ date('Y') }} Elite Companions. Todos los derechos reservados. Solo para mayores de 18 años.
                </p>
                <p class="text-xs text-gray-400">
                    Al utilizar este sitio, confirmas tener 18 años o más.
                </p>
            </div>
        </div>
    </footer>

    @livewireScripts

    <!-- Service Worker -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').catch(function(){});
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
