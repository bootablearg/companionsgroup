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
    class="fixed inset-x-4 bottom-4 lg:bottom-6 z-50 border border-gray-800 bg-gray-900/95 text-gray-200 rounded-2xl shadow-xl backdrop-blur-md px-5 py-4 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3"
>
    <p class="text-xs lg:text-sm leading-relaxed text-gray-300 max-w-3xl">
        {{ $message }}
        <a href="{{ route('privacy') }}" class="underline text-rose-400 hover:text-rose-300">Política de Privacidad</a>
    </p>

    <button
        type="button"
        @click="accept()"
        class="self-end lg:self-auto bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs lg:text-sm px-4 py-2 rounded-full shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 focus:ring-offset-gray-900"
    >
        Entendido
    </button>
</div>
