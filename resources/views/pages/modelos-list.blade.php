@extends('layouts.app')

@section('title', 'Modelos — Elite Companions | Listado de Companions Profesionales')
@section('meta_description', 'Explorá el listado completo de companions profesionales en Elite Companions Argentina. Perfiles para reuniones corporativas, cenas ejecutivas y eventos empresariales.')
@section('canonical', 'https://elitecompanions.cc/modelos')
@section('og_title', 'Listado de Companions Profesionales — Elite Companions')
@section('og_description', 'Encontrá companions profesionales en Argentina. Perfiles para reuniones, cenas ejecutivas y eventos corporativos. Confiables y verificados.')

@section('content')

{{-- Header --}}
<div style="background:var(--page-background);" class="pt-14 pb-10 text-center">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-extrabold mb-3"
            style="background:var(--gradient-accent-brand);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
            Listado de modelos
        </h1>
        <p class="font-medium mb-1" style="color: var(--brand-primary);">
            Descubrí perfiles exclusivos y conectá con ellas
        </p>
        <p class="text-sm font-medium" style="color:var(--text-accent-violet);">
            {{ $modelos->count() }} modelo{{ $modelos->count() !== 1 ? 's' : '' }} disponible{{ $modelos->count() !== 1 ? 's' : '' }}
        </p>
    </div>
</div>

{{-- Listing --}}
<div style="background:var(--page-background);" class="pb-16 min-h-screen">
    <div class="max-w-7xl mx-auto px-4">

        @if($modelos->isEmpty())
        <div class="text-center py-24">
            <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-5"
                 style="background:var(--surface-card);border:1px solid var(--input-border-default);">
                <svg class="w-10 h-10" style="color: var(--text-secondary);" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
            </div>
            <p class="text-lg font-medium mb-2" style="color: var(--text-secondary);">No hay modelos disponibles en este momento.</p>
            <a href="{{ route('home') }}" class="text-sm font-semibold transition-colors" style="color: var(--brand-primary);">Volver al inicio</a>
        </div>

        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($modelos as $aviso)
            @php
                $profile   = $aviso->escortProfile;
                $photoSrc  = $profile?->profile_photo_path
                    ? asset('storage/' . $profile->profile_photo_path)
                    : asset('images/logo.webp');
                $name      = $aviso->title ?: ($aviso->alias ?? null) ?: ($profile?->display_name ?? '');
                $firstName = explode(' ', trim($name))[0];
                $ciudad    = $aviso->city_name ?: $aviso->city;
            @endphp

            <a href="{{ route('modelos.show', $profile) }}"
               class="group rounded-2xl overflow-hidden block transition-all duration-200 hover:-translate-y-1"
               style="background:var(--surface-card);border:1.5px solid var(--input-border-default);box-shadow:0 2px 12px var(--shadow-card-subtle);"
               onmouseover="this.style.borderColor='var(--brand-primary)';this.style.boxShadow='0 8px 32px var(--shadow-focus-brand)';"
               onmouseout="this.style.borderColor='var(--input-border-default)';this.style.boxShadow='0 2px 12px var(--shadow-card-subtle)';">

                {{-- Foto --}}
                <div class="relative overflow-hidden" style="aspect-ratio:3/4;">
                    <img src="{{ $photoSrc }}" alt="{{ $firstName }}"
                         class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-300">

                    {{-- Overlay gradient --}}
                    <span class="absolute inset-0" style="background:var(--overlay-image-gradient-medium);"></span>

                    {{-- Badge verificado --}}
                    @if($profile?->is_verified)
                    <span class="absolute text-xs font-bold px-2 py-0.5 rounded-full flex items-center gap-1"
                          style="top:8px;right:8px;background:var(--overlay-surface-white-95);color:var(--brand-primary);border:1px solid var(--input-border-default);">
                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Verificada
                    </span>
                    @endif
                </div>

                {{-- Info --}}
                <div class="p-4 space-y-1.5">
                    <h3 class="font-bold text-base" style="color: var(--text-primary);">
                        {{ $firstName }}@if($aviso->age), {{ $aviso->age }}@endif
                    </h3>

                    @if($ciudad)
                    <p class="text-xs flex items-center gap-1" style="color: var(--text-secondary);">
                        <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $aviso->neighborhood ? $aviso->neighborhood.', ' : '' }}{{ $ciudad }}
                    </p>
                    @endif

                    @if(($profile?->rating_count ?? 0) > 0)
                    <div class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 fill-current" style="color: var(--brand-primary);" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                        <span class="text-xs font-semibold" style="color: var(--brand-primary);">{{ number_format($profile->rating_avg, 1) }}</span>
                        <span class="text-xs" style="color: var(--text-secondary);">({{ $profile->rating_count }})</span>
                    </div>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
        @endif

    </div>
</div>
@endsection
