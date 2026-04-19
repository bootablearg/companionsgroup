@extends('layouts.app')
@section('title', 'Planes de Suscripción — VIP Companions Argentina')
@section('meta_description', 'Conocé los planes de suscripción de VIP Companions. Accedé a perfiles profesionales y beneficios exclusivos para eventos corporativos y reuniones.')
@section('canonical', 'https://vipcompanions.cc/planes')

@section('page_style')
body { background-color: #160E06 !important; }
.ec-gradient-text {
    background: linear-gradient(135deg, #C8A235, #E8BE50);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.plan-card {
    border: 2px solid transparent;
    border-radius: 16px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    transition: all .2s ease;
    position: relative;
    background:
        linear-gradient(#2C1C0E, #2C1C0E) padding-box,
        linear-gradient(135deg, #4A3018, #C8A235) border-box;
}
.plan-card--badge {
    padding-bottom: 52px;
}
.plan-card:hover {
    background:
        linear-gradient(#2C1C0E, #2C1C0E) padding-box,
        linear-gradient(135deg, #C8A235, #E8BE50) border-box;
    box-shadow: 0 5px 18px rgba(200,162,53,.18);
    transform: translateY(-2px);
}
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4" style="padding-top:48px;padding-bottom:60px;">

    {{-- Header --}}
    <div class="text-center mb-10">
        <h1 class="text-3xl font-extrabold ec-gradient-text" style="display:inline-block;">Planes de Suscripción</h1>
        <p class="mt-3 text-sm" style="color:#8A6848;">Elegí el plan que mejor se adapte a tu perfil y comenzá a destacarte en la plataforma.</p>
    </div>

    @if($plans->isNotEmpty())
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px;">
        @foreach($plans as $plan)
        <div class="plan-card{{ $plan->is_featured_included ? ' plan-card--badge' : '' }}">

            {{-- Nombre --}}
            <div style="font-size:15px;font-weight:700;color:#F5EDD8;margin-bottom:12px;">{{ $plan->name }}</div>

            {{-- Precio + duración --}}
            <div style="display:flex;align-items:baseline;gap:6px;margin-bottom:4px;">
                <span style="font-size:28px;font-weight:800;background:linear-gradient(135deg,#C8A235,#E8BE50);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1;">
                    ${{ number_format($plan->price, 0) }}
                </span>
                <span style="font-size:12px;color:#8A6848;font-weight:500;">{{ $plan->currency }} / {{ $plan->duration_days }} días</span>
            </div>

            {{-- Descripción --}}
            @if($plan->description)
            <p style="font-size:12px;color:#C0946A;margin:8px 0 0;line-height:1.55;">{{ $plan->description }}</p>
            @endif

            {{-- Features --}}
            @if($plan->features && count($plan->features) > 0)
            <ul style="list-style:none;padding:0;margin:12px 0 0;font-size:12px;color:#C0946A;">
                @foreach($plan->features as $feat)
                <li style="display:flex;align-items:center;gap:6px;margin-bottom:6px;">
                    <svg width="12" height="12" fill="none" stroke="#C8A235" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    {{ $feat }}
                </li>
                @endforeach
            </ul>
            @endif

            {{-- Badge DESTACADO --}}
            @if($plan->is_featured_included)
            <span style="position:absolute;bottom:16px;left:20px;display:inline-flex;align-items:center;gap:4px;background:linear-gradient(135deg,#C8A235,#E8BE50);color:#1A1510;font-size:10px;font-weight:700;padding:3px 10px;border-radius:999px;letter-spacing:.03em;">
                <svg width="9" height="9" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                DESTACADO
            </span>
            @endif

        </div>
        @endforeach
    </div>

    {{-- CTA --}}
    <div class="text-center mt-10">
        <p style="font-size:14px;color:#8A6848;margin-bottom:16px;">¿Ya tenés cuenta? Ingresá para suscribirte directamente.</p>
        <a href="{{ route('login') }}" class="btn-gradient inline-flex items-center gap-2 text-sm font-bold px-6 py-3 rounded-full shadow-md">
            Iniciar sesión y elegir plan
        </a>
    </div>

    @else
    <div style="background:#2C1C0E;border:1px solid #4A3018;border-radius:18px;padding:40px;text-align:center;">
        <p style="color:#8A6848;font-size:14px;margin:0;">No hay planes disponibles en este momento.</p>
    </div>
    @endif

</div>
@endsection
