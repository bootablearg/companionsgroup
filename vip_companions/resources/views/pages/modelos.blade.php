@extends('layouts.app')

@section('title', 'Modelos — VIP Companions | Listado de Companions Profesionales')
@section('meta_description', 'Explorá el listado completo de companions profesionales en VIP Companions Argentina. Perfiles para reuniones corporativas, cenas ejecutivas y eventos empresariales.')
@section('canonical', 'https://vipcompanions.cc/modelo')
@section('og_title', 'Listado de Companions Profesionales — VIP Companions')
@section('og_description', 'Encontrá companions profesionales en Argentina. Perfiles para reuniones, cenas ejecutivas y eventos corporativos. Confiables y verificados.')

@section('content')

{{-- Header --}}
<div style="background:#160E06;" class="pt-14 pb-10 text-center">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-extrabold mb-3"
            style="background:linear-gradient(135deg,#C8A235,#E8BE50);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
            Listado de modelos
        </h1>
        <p class="font-medium mb-1" style="color:#C0946A;">
            Descubrí perfiles exclusivos y conectá con ellas
        </p>
        <p class="text-sm font-medium" style="color:#8A6848;">
            {{ $modelos->count() }} companion{{ $modelos->count() !== 1 ? 's' : '' }} disponible{{ $modelos->count() !== 1 ? 's' : '' }}
        </p>
    </div>
</div>

{{-- Listing --}}
<div style="background:#160E06;" class="pb-16 min-h-screen">
    <div class="max-w-7xl mx-auto px-4">

        @if($modelos->isEmpty())
        <div class="text-center py-24">
            <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-5"
                 style="background:#2C1C0E;border:1px solid #4A3018;">
                <svg class="w-10 h-10" style="color:#C0946A;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
            </div>
            <p class="text-lg font-medium mb-2" style="color:#8A6848;">No hay companions disponibles en este momento.</p>
            <a href="{{ route('home') }}" class="text-sm font-semibold transition-colors" style="color:#C8A235;">Volver al inicio</a>
        </div>

        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($modelos as $modelo)
            @php
                $allPhotos   = $modelo->avisos->flatMap(fn($a) => $a->photos)->values();
                $photoSrc    = $modelo->profile_photo_path
                    ? $modelo->getDisplayPhotoUrl()
                    : ($allPhotos->isNotEmpty()
                        ? ($allPhotos->firstWhere('is_cover', true) ?? $allPhotos->first())->getUrl()
                        : asset('images/logo.webp'));
                $firstName   = explode(' ', $modelo->display_name ?? $modelo->alias ?? '')[0];
                $rate1h      = $modelo->rates->firstWhere('duration', 'Una hora (1 hs)');
                $isFeatured  = $modelo->avisos->where('is_featured', true)->where('status', 'active')->isNotEmpty();
                $activeAviso = $modelo->avisos->where('status', 'active')->first();
                $cardUrl     = $activeAviso ? route('aviso.show', $activeAviso->id) : route('modelos.show', $modelo);
            @endphp

            <a href="{{ $cardUrl }}"
               class="group rounded-2xl overflow-hidden block transition-all duration-200 hover:-translate-y-1"
               style="background:#2C1C0E;border:1.5px solid #4A3018;box-shadow:0 2px 12px rgba(0,0,0,.30);"
               onmouseover="this.style.borderColor='#C8A235';this.style.boxShadow='0 8px 32px rgba(200,162,53,.18)';"
               onmouseout="this.style.borderColor='#4A3018';this.style.boxShadow='0 2px 12px rgba(0,0,0,.30)';">

                {{-- Foto --}}
                <div class="relative overflow-hidden" style="aspect-ratio:3/4;">
                    <img src="{{ $photoSrc }}" alt="{{ $firstName }}"
                         class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-300">

                    {{-- Overlay gradient --}}
                    <span class="absolute inset-0" style="background:linear-gradient(to top, rgba(22,14,6,.80) 0%, transparent 50%);"></span>

                    {{-- Badge verificado --}}
                    @if($modelo->is_verified)
                    <span class="absolute text-xs font-bold px-2 py-0.5 rounded-full flex items-center gap-1"
                          style="top:8px;right:8px;background:rgba(44,28,14,.90);color:#C8A235;border:1px solid #4A3018;">
                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        VIP
                    </span>
                    @endif

                    {{-- Badge destacado --}}
                    @if($isFeatured)
                    <span class="absolute text-xs font-bold px-2 py-0.5 rounded-full"
                          style="top:8px;left:8px;background:rgba(44,28,14,.90);color:#C8A235;border:1px solid #4A3018;">★</span>
                    @endif

                    {{-- Tarifa --}}
                    @if($rate1h)
                    <span class="absolute text-xs font-semibold px-2 py-0.5 rounded-full"
                          style="bottom:8px;left:8px;background:rgba(22,14,6,.75);color:#E8BE50;border:1px solid rgba(200,162,53,.3);">
                        {{ $rate1h->currency ?? 'USD' }} {{ number_format($rate1h->price_usd, 0) }}/hr
                    </span>
                    @endif
                </div>

                {{-- Info --}}
                <div class="p-4 space-y-1.5">
                    <h3 class="font-bold text-base" style="color:#F5EDD8;">
                        {{ $firstName }}@if($modelo->age), {{ $modelo->age }}@endif
                    </h3>

                    @if($modelo->city)
                    <p class="text-xs flex items-center gap-1" style="color:#8A6848;">
                        <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $modelo->neighborhood ? $modelo->neighborhood.', ' : '' }}{{ $modelo->city }}
                    </p>
                    @endif

                    @if($modelo->rating_count > 0)
                    <div class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 fill-current" style="color:#C8A235;" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                        <span class="text-xs font-semibold" style="color:#C8A235;">{{ number_format($modelo->rating_avg, 1) }}</span>
                        <span class="text-xs" style="color:#8A6848;">({{ $modelo->rating_count }})</span>
                    </div>
                    @endif

                    @if($modelo->bio)
                    <p class="text-xs leading-relaxed line-clamp-2" style="color:#8A6848;">{{ $modelo->bio }}</p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
        @endif

    </div>
</div>
@endsection
