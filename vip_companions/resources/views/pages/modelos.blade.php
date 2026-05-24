@extends('layouts.app')

@section('title', 'Avisos — Elite Companions | Listado de Companions Premium')
@section('meta_description', 'Buscá las mejores escorts elite y acompañantes independientes en Argentina. Perfiles verificados. Toda Argentina, Buenos Aires, Ciudad de Buenos y CABA. Fotos reales.')
@section('canonical', 'https://elitecompanions.cc/avisos')
@section('og_title', 'Listado de Companions Premium — Elite Companions')
@section('og_description', 'Encontrá companions premium en Argentina. Perfiles verificados para eventos exclusivos, galas y networking social de alto perfil.')
@section('meta_keywords', 'escorts argentina, escorts en argentina, escorts buenos aires, escorts en buenos aires, escorts capital federal, escorts en capital federal, escorts ciudad de buenos aires, escorts en ciudad de buenos aires, putas argentina, putas en argentina, putas buenos aires, putas en buenos aires, putas capital federal, putas ciudad de buenos aires, trolas argentina, trolas en argentina, trolas buenos aires, trolas en buenos aires, atorrantas argentina, atorrantas en argentina, atorrantas buenos aires, atorrantas en buenos aires, mujeres argentina, mujeres buenos aires, mujeres capital federal, trans argentina, trans en argentina, trans buenos aires, trans en buenos aires, trans capital federal, trans ciudad de buenos aires, taxiboy argentina, taxiboy en argentina, taxiboy buenos aires, taxiboy en buenos aires, taxiboy capital federal, taxiboy ciudad de buenos aires, escorts vip argentina, escorts vip en argentina, escorts vip buenos aires, escorts vip en buenos aires, escorts vip capital federal, escorts vip ciudad de buenos aires, putas vip argentina, putas vip buenos aires, trolas vip argentina, trolas vip buenos aires, atorrantas vip argentina, atorrantas vip buenos aires, mujeres vip argentina, mujeres vip buenos aires, trans vip argentina, trans vip buenos aires, taxiboy vip argentina, taxiboy vip buenos aires, AreaVIP, Area-VIP, Area-Vip, areavip argentina, areavip escorts, ArgentinaBlack, argentina black escorts, argentina black vip, ArgentinaXP, argentina xp, argentinaxp escorts, Bairesgirls, Baires Girls, bairesgirls escorts, Gemidos, gemidos escorts argentina, Solo Independientes, SoloIndependientes, soloindependientes escorts, Soy Tuyo, soytuyo escorts, Tacos Altos, TacosAltos, Foro Escorts, ForoEscorts, ForoXP, Foro Pirata, acompañantes argentina, acompañantes buenos aires, acompañantes capital federal, acompañantes vip argentina, acompañantes independientes argentina, escorts independientes argentina, escorts independientes buenos aires, escorts de lujo argentina, escorts premium argentina')

@section('content')

{{-- Header --}}
<div style="background:var(--page-background);" class="pt-14 pb-10 text-center">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-extrabold mb-3"
            style="background:var(--gradient-accent-brand);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
            Listado de avisos
        </h1>
        <p class="font-medium mb-1" style="color: var(--brand-primary);">
            Descubrí perfiles exclusivos y conectá con ellas
        </p>
        <p class="text-sm font-medium" style="color:var(--brand-primary);">
            {{ $avisos->count() }} aviso{{ $avisos->count() !== 1 ? 's' : '' }} disponible{{ $avisos->count() !== 1 ? 's' : '' }}
        </p>
    </div>
</div>

{{-- Listing --}}
<div style="background:var(--page-background);" class="pb-16 min-h-screen">
    <div class="max-w-7xl mx-auto px-4">

        @if($avisos->isEmpty())
        <div class="text-center py-24">
            <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-5"
                 style="background:var(--border-default);border:1px solid var(--border-input-subtle);">
                <svg class="w-10 h-10" style="color: var(--brand-primary);" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
            </div>
            <p class="text-lg font-medium mb-2" style="color: var(--text-secondary);">No hay companions disponibles en este momento.</p>
            <a href="{{ route('home') }}" class="text-sm font-semibold transition-colors" style="color: var(--brand-primary);">Volver al inicio</a>
        </div>

        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($avisos as $aviso)
            @php
                $coverPhoto = $aviso->photos->first();
                $photoSrc   = $aviso->cover_photo_path
                    ? asset('storage/' . $aviso->cover_photo_path)
                    : ($coverPhoto
                        ? $coverPhoto->getUrl()
                        : ($aviso->escortProfile?->profile_photo_path
                            ? asset('storage/' . $aviso->escortProfile->profile_photo_path)
                            : asset('images/logo.webp')));
                $name       = $aviso->title ?: ($aviso->alias ?: ($aviso->escortProfile?->display_name ?? ''));
                $firstName  = explode(' ', trim($name))[0];
                $rate1h     = $aviso->rates->firstWhere('duration', '1 hs. - Convencional')
                    ?? $aviso->rates->firstWhere('duration', 'Una hora (1 hs)')
                    ?? $aviso->rates->first(fn($r) => str_contains($r->duration, '1 hs'));
            @endphp

            <a href="{{ route('aviso.show', $aviso->id) }}"
               class="group rounded-2xl overflow-hidden block transition-all duration-200 hover:-translate-y-1"
               style="background:var(--surface-card);border:1.5px solid var(--border-input-subtle);box-shadow:0 2px 12px var(--shadow-sm);"
               onmouseover="this.style.borderColor='var(--brand-primary)';this.style.boxShadow='0 8px 32px var(--shadow-modal-brand-soft)';"
               onmouseout="this.style.borderColor='var(--border-input-subtle)';this.style.boxShadow='0 2px 12px var(--shadow-sm)';">

                {{-- Foto --}}
                <div class="relative overflow-hidden" style="aspect-ratio:3/4;">
                    <img src="{{ $photoSrc }}" alt="{{ $firstName }}"
                         class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-300">

                    {{-- Overlay gradient --}}
                    <span class="absolute inset-0" style="background:linear-gradient(to top, var(--overlay-image-shadow) 0%, transparent 50%);"></span>

                    {{-- Badge verificado --}}
                    @if($aviso->escortProfile?->is_verified)
                    <span class="absolute text-xs font-bold px-2 py-0.5 rounded-full flex items-center gap-1"
                          style="top:8px;right:8px;background:var(--overlay-badge-white-bg);color:var(--brand-primary);border:1px solid var(--border-input-subtle);">
                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Verificada
                    </span>
                    @endif

                    {{-- Badge destacado --}}
                    @if($aviso->is_featured)
                    <span class="absolute text-xs font-bold px-2 py-0.5 rounded-full"
                          style="top:8px;left:8px;background:var(--overlay-badge-white-bg);color:var(--brand-primary);border:1px solid var(--border-input-subtle);">★</span>
                    @endif

                    {{-- Tarifa --}}
                    @if($rate1h)
                    <span class="absolute text-xs font-semibold px-2 py-0.5 rounded-full"
                          style="bottom:8px;left:8px;background:var(--overlay-image-shadow);color:var(--surface-card);">
                        {{ $rate1h->currency ?? 'USD' }} {{ number_format($rate1h->price_usd, 0) }}/hr
                    </span>
                    @endif
                </div>

                {{-- Info --}}
                <div class="p-4 space-y-1.5">
                    <h3 class="font-bold text-base" style="color: var(--text-primary);">
                        {{ $firstName }}@if($aviso->age), {{ $aviso->age }}@endif
                    </h3>

                    @php $ciudad = $aviso->city_name ?: $aviso->city; @endphp
                    @if($ciudad)
                    <p class="text-xs flex items-center gap-1" style="color: var(--text-secondary);">
                        <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $aviso->neighborhood ? $aviso->neighborhood.', ' : '' }}{{ $ciudad }}
                    </p>
                    @endif

                    @if(($aviso->escortProfile?->rating_count ?? 0) > 0)
                    <div class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 fill-current" style="color: var(--status-pending-icon);" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                        <span class="text-xs font-semibold" style="color: var(--brand-primary);">{{ number_format($aviso->escortProfile->rating_avg, 1) }}</span>
                        <span class="text-xs" style="color: var(--text-secondary);">({{ $aviso->escortProfile->rating_count }})</span>
                    </div>
                    @endif

                    @if($aviso->description)
                    <p class="text-xs leading-relaxed line-clamp-2" style="color: var(--text-secondary);">{{ $aviso->description }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
        @endif

    </div>
</div>
@endsection
