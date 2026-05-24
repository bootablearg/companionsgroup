@extends('layouts.app')
@section('title', 'Planes de Suscripción — Elite Companions Argentina')
@section('meta_description', 'Conocé los planes de suscripción de Elite Companions. Accedé a perfiles premium, contacto directo y beneficios exclusivos para members.')
@section('canonical', 'https://elitecompanions.cc/planes')

@section('page_style')
.plan-card {
    border: 2px solid transparent;
    border-radius: 16px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    transition: all .2s ease;
    position: relative;
    background:
        linear-gradient(var(--card-bg), var(--card-bg)) padding-box,
        var(--gradient-plan-card-border) border-box;
}
.plan-card--badge {
    padding-bottom: 52px;
}
.plan-card:hover {
    background:
        linear-gradient(white, white) padding-box,
        var(--gradient-accent-brand) border-box;
    box-shadow: 0 5px 18px var(--shadow-brand-soft);
    transform: translateY(-2px);
}
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4" style="padding-top:48px;padding-bottom:60px;">

    {{-- Header --}}
    <div class="text-center mb-10">
        <h1 class="text-3xl font-extrabold bg-gradient-to-r from-rose-400 to-pink-300 bg-clip-text text-transparent">Planes de Suscripción</h1>
        <p class="mt-3 text-sm text-gray-400">Elegí el plan que mejor se adapte a tu perfil y comenzá a destacarte en la plataforma.</p>
    </div>

    @if($plans->isNotEmpty())
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px;">
        @foreach($plans as $plan)
        <div class="plan-card{{ $plan->is_featured_included ? ' plan-card--badge' : '' }}">

            {{-- Nombre --}}
            <div class="text-base font-bold text-gray-900" style="margin-bottom:12px;">{{ $plan->name }}</div>

            {{-- Precio + duración --}}
            <div style="display:flex;align-items:baseline;gap:6px;margin-bottom:4px;">
                <span class="text-3xl font-extrabold bg-gradient-to-r from-violet-600 to-pink-500 bg-clip-text text-transparent" style="line-height:1;">
                    ${{ number_format($plan->price, 0) }}
                </span>
                <span class="text-xs text-gray-500 font-medium">{{ $plan->currency }} / {{ $plan->duration_days }} días</span>
            </div>

            {{-- Descripción --}}
            @if($plan->description)
            <p class="text-xs text-gray-500 mt-2" style="line-height:1.55;">{{ $plan->description }}</p>
            @endif

            {{-- Features --}}
            @if($plan->features && count($plan->features) > 0)
            <ul style="list-style:none;padding:0;margin:12px 0 0;">
                @foreach($plan->features as $feat)
                <li class="flex items-center gap-2 text-xs text-gray-600 mb-1.5">
                    <svg width="12" height="12" fill="none" stroke="var(--brand-primary)" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    {{ $feat }}
                </li>
                @endforeach
            </ul>
            @endif

            {{-- Badge DESTACADO --}}
            @if($plan->is_featured_included)
            <span style="position:absolute;bottom:16px;left:20px;display:inline-flex;align-items:center;gap:4px;background:var(--gradient-accent-brand);color:var(--text-inverted);font-size:10px;font-weight:700;padding:3px 10px;border-radius:999px;letter-spacing:.03em;">
                <svg width="9" height="9" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                DESTACADO
            </span>
            @endif

        </div>
        @endforeach
    </div>

    {{-- CTA --}}
    <div class="text-center mt-10">
        <p class="text-sm text-gray-400 mb-4">¿Ya tenés cuenta? Ingresá para suscribirte directamente.</p>
        <a href="{{ route('login') }}" class="btn-primary inline-flex items-center gap-2 text-sm px-6 py-3 rounded-full">
            Iniciar sesión y elegir plan
        </a>
    </div>

    @else
    <div class="bg-white border border-gray-200 rounded-2xl p-10 text-center">
        <p class="text-sm text-gray-400">No hay planes disponibles en este momento.</p>
    </div>
    @endif

</div>
@endsection
