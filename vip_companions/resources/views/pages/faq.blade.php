@extends('layouts.app')

@section('title', 'Preguntas Frecuentes — Elite Companions Argentina')
@section('meta_description', 'Respondemos las preguntas más frecuentes sobre Elite Companions: cómo funciona la plataforma, cómo registrarse, seguridad y privacidad.')
@section('canonical', 'https://elitecompanions.cc/faq')

@section('page_style')
body { background-color: var(--page-background) !important; }
.ec-card {
    border: 2px solid transparent;
    background: linear-gradient(var(--card-bg), var(--card-bg)) padding-box,
                var(--gradient-plan-card-border) border-box;
}
.ec-gradient-text {
    background: var(--gradient-accent-brand);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
@endsection

@section('content')
<div class="max-w-3xl mx-auto px-4" style="padding-top:40px;padding-bottom:40px;">

    <div class="mb-8 text-center">
        <h1 class="text-3xl ec-gradient-text" style="display:inline-block;">Preguntas Frecuentes</h1>
        <p class="text-gray-500 mt-3 text-sm">Encontrá respuestas a las dudas más comunes sobre la Plataforma.</p>
    </div>

    @if(isset($faqItems) && $faqItems->count() > 0)
        <div class="space-y-3" x-data="{ activeItem: null }">
            @foreach($faqItems as $index => $faq)
                <div class="ec-card rounded-xl overflow-hidden shadow-sm">
                    <button
                        @click="activeItem = activeItem === {{ $index }} ? null : {{ $index }}"
                        class="w-full flex items-center justify-between px-5 py-4 text-left bg-white"
                        :aria-expanded="activeItem === {{ $index }}"
                    >
                        <span class="text-sm pr-4" style="color: var(--brand-primary);">{{ $faq->question }}</span>
                        <svg
                            class="w-5 h-5 flex-shrink-0 transition-transform duration-200"
                            :class="activeItem === {{ $index }} ? 'rotate-180' : ''"
                            style="color: var(--brand-primary);"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div
                        x-show="activeItem === {{ $index }}"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 transform -translate-y-1"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-cloak
                        class="px-5 pb-5 bg-white border-t border-gray-100"
                    >
                        <p class="text-sm text-gray-400 leading-relaxed" style="white-space:pre-line;">{!! $faq->answer !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        @php
            $staticFaqs = [
                [
                    'q' => '¿Quien puede registrarse en Elite Companions?',
                    'a' => 'Cualquier persona mayor de 18 años puede registrarse como suscriptor para explorar perfiles. Para publicar un aviso como modelo, es necesario completar el proceso de verificacion de identidad (KYC) que confirma la mayoria de edad.'
                ],
                [
                    'q' => '¿Que es el proceso KYC y por que es necesario?',
                    'a' => 'KYC (Know Your Customer o Conoce a tu Cliente) es un proceso de verificacion de identidad obligatorio para quienes desean publicar avisos. Consiste en cargar una fotografia de tu documento de identidad y una selfie sosteniendo el documento. Este proceso garantiza que todos los anunciantes sean mayores de edad y hayan sido identificados, protegiendo tanto a los anunciantes como a los usuarios de la plataforma.'
                ],
                [
                    'q' => '¿Cuanto tiempo tarda la verificacion KYC?',
                    'a' => 'El equipo de moderacion revisa las solicitudes KYC dentro de las 24-48 horas habiles. En periodos de alto volumen puede extenderse hasta 72 horas. Recibiras una notificacion por email cuando tu verificacion sea aprobada o rechazada.'
                ],
                [
                    'q' => '¿Como se protegen mis documentos de identidad?',
                    'a' => 'Todos los documentos de identidad y fotografias de verificacion son cifrados con AES-256 antes de ser almacenados. Solo los administradores con nivel de acceso completo pueden visualizarlos, y cada acceso queda registrado en el log de auditoria. Los documentos son eliminados de forma segura una vez cumplido el periodo de retencion legal.'
                ],
                [
                    'q' => '¿Cuales son los planes de suscripcion disponibles?',
                    'a' => 'Contamos con varias opciones de suscripción para que elijas la que mejor se adapte a tu estilo y a la visibilidad que querés lograr dentro de la plataforma.<br><br>Actualmente ofrecemos:<br><br>• <strong>Plan Base</strong><br>• <strong>Plan con Destaque</strong><br>• <strong>Plan con Destaque + Verificación</strong><br><br>Cada uno incluye diferentes niveles de exposición y beneficios adicionales.<br><br>Podés ver la tabla completa y actualizada de planes en el siguiente enlace:<br>👉 <a href="' . route('planes') . '" style="color: var(--brand-primary);text-decoration:underline;">Ingresá acá para ver los planes disponibles</a>'
                ],
                [
                    'q' => '¿Que metodos de pago aceptan?',
                    'a' => 'Aceptamos pagos a traves de Mercado Pago (tarjetas de credito/debito, transferencias bancarias, efectivo en puntos de pago), transferencia bancaria directa y tarjetas de credito internacionales. Todos los pagos son procesados de forma segura por pasarelas de pago certificadas.'
                ],
                [
                    'q' => '¿Puedo cancelar mi suscripcion en cualquier momento?',
                    'a' => 'Si, puedes cancelar tu suscripcion en cualquier momento desde el panel de Suscripcion. Tu aviso permanecera activo hasta el vencimiento del periodo suscrito. No realizamos reintegros por periodos no utilizados.'
                ],
                [
                    'q' => '¿Cuantas fotos y videos puedo publicar en mi aviso?',
                    'a' => 'Puedes publicar hasta 10 fotografias y hasta 3 videos en tu aviso. Las fotos deben ser en formato JPG, PNG o WebP con un tamaño maximo de 5MB cada una. Los videos en formato MP4 con un maximo de 50MB cada uno.'
                ],
                [
                    'q' => '¿Como reporto un aviso o usuario inapropiado?',
                    'a' => 'En cada perfil publico encontraras el enlace "Reportar aviso" al pie de la pagina. Al hacer clic podras seleccionar el motivo del reporte. Nuestro equipo revisa todos los reportes en un plazo de 24-48 horas y toma las acciones correspondientes.'
                ],
                [
                    'q' => '¿La plataforma es accesible desde celular?',
                    'a' => 'Si, Elite Companions esta completamente optimizada para dispositivos moviles. Tambien puedes instalarla como aplicacion web progresiva (PWA) desde tu navegador para acceder sin conexion y recibir notificaciones push.'
                ],
                [
                    'q' => '¿Como contacto a soporte?',
                    'a' => 'Puedes contactar a soporte por correo electronico a elitecompanions.arg@gmail.com. El horario de atencion es de lunes a viernes de 9 a 20 horas (hora Argentina). Los suscriptores activos tienen prioridad en la cola de atencion.'
                ],
                [
                    'q' => '¿Mis datos de contacto son publicos?',
                    'a' => 'Solo la informacion que eliges incluir en tu aviso es publica: nombre artistico, ciudad, descripcion, fotos y los medios de contacto que configures (telefono, WhatsApp, Telegram). Tu email de registro, datos KYC y datos personales nunca son publicos y no son accesibles por otros usuarios.'
                ],
            ];
        @endphp

        <div class="space-y-3" x-data="{ activeItem: null }">
            @foreach($staticFaqs as $index => $faq)
                <div class="ec-card rounded-xl overflow-hidden shadow-sm">
                    <button
                        @click="activeItem = activeItem === {{ $index }} ? null : {{ $index }}"
                        class="w-full flex items-center justify-between px-5 py-4 text-left bg-white"
                        :aria-expanded="activeItem === {{ $index }}"
                    >
                        <span class="text-sm pr-4" style="color: var(--brand-primary);">{{ $faq['q'] }}</span>
                        <svg
                            class="w-5 h-5 flex-shrink-0 transition-transform duration-200"
                            :class="activeItem === {{ $index }} ? 'rotate-180' : ''"
                            style="color: var(--brand-primary);"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div
                        x-show="activeItem === {{ $index }}"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 transform -translate-y-1"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-cloak
                        class="px-5 pb-5 bg-white border-t border-gray-100"
                    >
                        <p class="text-sm text-gray-400 leading-relaxed">{!! $faq['a'] !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Contact CTA --}}
    <div class="mt-10 ec-card rounded-2xl shadow-sm p-6 text-center bg-white">
        <p class="text-gray-700 mb-1">¿No encontraste respuesta a tu pregunta?</p>
        <p class="text-sm text-gray-500 mb-5">Nuestro equipo de soporte está disponible para ayudarte.</p>
        <a href="{{ route('support') }}"
           class="inline-block text-white text-sm font-semibold px-6 py-2.5 rounded-full transition"
           style="background:var(--gradient-accent-brand);">
            Contactar soporte
        </a>
    </div>

</div>
@endsection
