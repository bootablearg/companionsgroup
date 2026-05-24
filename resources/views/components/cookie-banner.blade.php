@props([
    'message' => 'Usamos cookies propias y de terceros para mejorar la experiencia, analizar el uso y ofrecer funciones personalizadas. Al continuar navegando aceptas nuestra política de privacidad.',
])

<div
    x-data="{
        visible: localStorage.getItem('cookieBannerAccepted') !== 'true',
        accept() {
            localStorage.setItem('cookieBannerAccepted', 'true');
            this.visible = false;
        }
    }"
    x-show="visible"
    x-cloak
    x-transition
    class="fixed inset-x-4 bottom-4 lg:bottom-6 z-50 border border-border-default bg-page-background/95 text-text-primary rounded-2xl shadow-xl backdrop-blur-md px-5 py-4 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3"
>
    <p class="text-xs lg:text-sm leading-relaxed text-text-secondary max-w-3xl">
        {{ $message }}
        <a href="{{ route('privacy') }}" class="underline text-rose-400 hover:text-rose-300">Política de Privacidad</a>
    </p>

    <button
        type="button"
        @click="accept()"
        class="self-end lg:self-auto font-semibold text-xs lg:text-sm px-4 py-2 rounded-full shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2"
        style="background:var(--action-primary);color:var(--text-inverted);focus-ring-color:var(--action-primary)"
        onmouseover="this.style.filter='brightness(0.85)'" onmouseout="this.style.filter=''"
    >
        Entendido
    </button>
</div>
