@extends('layouts.app')

@section('title', $aviso->display_name . ' — ' . ($aviso->city ?: 'Argentina') . ' | Elite Companions')
@section('meta_description', 'Conocé el perfil de ' . $aviso->display_name . ($aviso->city ? ' en ' . $aviso->city : '') . ', Argentina. Escort elite independiente verificada, fotos reales y contacto directo en Elite Companions.')
@section('canonical', route('aviso.show', $aviso->id))
@section('og_type', 'profile')
@section('og_title', $aviso->display_name . ' — Elite Companions Argentina')
@section('og_description', 'Conocé el perfil de ' . $aviso->display_name . ($aviso->city ? ' en ' . $aviso->city : '') . '. Escort elite independiente verificada. Fotos reales y contacto directo.')
@section('og_image', $aviso->photos->first()?->url ?? asset('images/logo.webp'))
@section('meta_keywords', ($aviso->display_name ?? 'Escort Elite') . ', ' . ($aviso->city ?: 'Buenos Aires') . ', escort argentina, escorts elite argentina, escorts buenos aires, escorts capital federal, acompañante argentina, escorts independientes argentina, Elite Companions')
@section('twitter_title', $aviso->display_name . ' — Elite Companions')
@section('twitter_description', 'Escort elite independiente en ' . ($aviso->city ?: 'Argentina') . '. Fotos reales, discreción total. Elite Companions Argentina.')

@push('json_ld')
@php
    $seoPhoto = $aviso->photos->first()?->url ?? null;
    $seoCity  = $aviso->city ?? null;
    $seoName  = $aviso->display_name ?? 'Acompañante, Modelo Elite';
@endphp
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Person",
  "name": "{{ $seoName }}",
  "url": "{{ route('aviso.show', $aviso->id) }}",
  @if($seoPhoto)
  "image": "{{ $seoPhoto }}",
  @endif
  @if($seoCity)
  "homeLocation": {
    "@type": "Place",
    "name": "{{ $seoCity }}, Argentina"
  },
  @endif
  "description": "Escort elite independiente en Argentina. Perfil verificado con fotos reales en Elite Companions.",
  "worksFor": {
    "@type": "Organization",
    "name": "Elite Companions",
    "url": "https://elitecompanions.cc/"
  }
}
</script>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-xs text-gray-600 mb-6">
        <a href="{{ route('home') }}" class="hover:text-gray-400 transition-colors">Inicio</a>
        <span>/</span>
        <a href="{{ route('search', ['province' => $aviso->province]) }}" class="hover:text-gray-400 transition-colors">{{ $aviso->province }}</a>
        <span>/</span>
        <a href="{{ route('search', ['city' => $aviso->city]) }}" class="hover:text-gray-400 transition-colors">{{ $aviso->city }}</a>
        <span>/</span>
        <span class="text-gray-400">{{ $aviso->display_name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left Column: Photos -->
        <div class="lg:col-span-2">

            <!-- Main Photo Gallery -->
            <div x-data="{
                    currentIndex: 0,
                    photos: {{ $aviso->photos->pluck('url')->toJson() }},
                    lightboxOpen: false,
                    lightboxIndex: 0,
                    prev() { this.currentIndex = (this.currentIndex - 1 + this.photos.length) % this.photos.length; },
                    next() { this.currentIndex = (this.currentIndex + 1) % this.photos.length; },
                    openLightbox(i) { this.lightboxIndex = i; this.lightboxOpen = true; },
                 }"
                 class="relative"
            >
                <!-- Main Photo -->
                <div class="relative bg-page-background rounded-lg overflow-hidden aspect-[3/4] group">
                    <template x-if="photos.length > 0">
                        <img
                            :src="photos[currentIndex]"
                            :alt="'Foto ' + (currentIndex + 1)"
                            class="w-full h-full object-cover object-top cursor-pointer"
                            @click="openLightbox(currentIndex)"
                        >
                    </template>
                    <template x-if="photos.length === 0">
                        <div class="w-full h-full flex items-center justify-center bg-white">
                            <img src="{{ asset('images/logo.webp') }}" alt="Elite Companions" class="w-32 h-32 object-contain opacity-60">
                        </div>
                    </template>

                    <!-- Nav Arrows -->
                    <template x-if="photos.length > 1">
                        <div>
                            <button @click.stop="prev()" class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/80 text-text-primary p-2 rounded-full transition-opacity opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button @click.stop="next()" class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/80 text-text-primary p-2 rounded-full transition-opacity opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </template>

                    <!-- Photo counter -->
                    <template x-if="photos.length > 1">
                        <div class="absolute bottom-3 right-3 bg-black/60 text-text-primary text-xs px-2 py-1 rounded">
                            <span x-text="(currentIndex + 1) + ' / ' + photos.length"></span>
                        </div>
                    </template>
                </div>

                <!-- Thumbnails -->
                <template x-if="photos.length > 1">
                    <div class="flex gap-2 mt-3 overflow-x-auto pb-1">
                        <template x-for="(photo, index) in photos" :key="index">
                            <button
                                @click="currentIndex = index"
                                :class="currentIndex === index ? 'ring-2 ring-rose-600 opacity-100' : 'opacity-50 hover:opacity-75'"
                                class="flex-shrink-0 w-16 h-16 rounded-md overflow-hidden transition-all"
                            >
                                <img :src="photo" :alt="'Miniatura ' + (index+1)" class="w-full h-full object-cover">
                            </button>
                        </template>
                    </div>
                </template>

                <!-- Lightbox -->
                <div
                    x-show="lightboxOpen"
                    x-cloak
                    @keydown.escape.window="lightboxOpen = false"
                    class="fixed inset-0 z-50 bg-black/95 flex items-center justify-center"
                    @click.self="lightboxOpen = false"
                >
                    <button @click="lightboxOpen = false" class="absolute top-4 right-4 text-text-primary/70 hover:text-text-primary">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    <button @click="lightboxIndex = (lightboxIndex - 1 + photos.length) % photos.length" class="absolute left-4 top-1/2 -translate-y-1/2 text-text-primary/70 hover:text-text-primary p-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <img :src="photos[lightboxIndex]" class="max-w-full max-h-full object-contain px-16" alt="Foto ampliada">
                    <button @click="lightboxIndex = (lightboxIndex + 1) % photos.length" class="absolute right-4 top-1/2 -translate-y-1/2 text-text-primary/70 hover:text-text-primary p-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Videos Section -->
            @if($aviso->videos && $aviso->videos->count() > 0)
                <div class="mt-8">
                    <h2 class="text-lg font-semibold text-text-primary mb-4">Videos</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($aviso->videos->take(3) as $video)
                            <div class="bg-page-background border border-border-default rounded-lg overflow-hidden aspect-video">
                                <video controls class="w-full h-full object-cover" preload="metadata">
                                    <source src="{{ $video->url }}" type="video/mp4">
                                </video>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Description -->
            <div class="mt-8 bg-page-background border border-border-default rounded-lg p-6">
                <h2 class="text-lg font-semibold text-text-primary mb-4">Sobre mi</h2>
                <div class="prose prose-invert prose-sm max-w-none">
                    <p class="text-gray-400 leading-relaxed whitespace-pre-line">{{ $aviso->introduction }}</p>
                </div>
            </div>

            <!-- Physical Attributes -->
            <div class="mt-6 bg-page-background border border-border-default rounded-lg p-6">
                <h2 class="text-lg font-semibold text-text-primary mb-4">Atributos fisicos</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @php
                        $attributes = [
                            'Edad' => $aviso->age . ' años',
                            'Genero' => $aviso->gender ?? 'N/D',
                            'Altura' => $aviso->height ? $aviso->height . ' cm' : 'N/D',
                            'Cabello' => $aviso->hair_color ?? 'N/D',
                            'Ojos' => $aviso->eye_color ?? 'N/D',
                            'Piel' => $aviso->skin_color ?? 'N/D',
                        ];
                        if($aviso->measurements) {
                            $attributes['Medidas'] = $aviso->measurements;
                        }
                    @endphp
                    @foreach($attributes as $label => $value)
                        <div class="bg-surface-secondary/50 rounded-md p-3">
                            <p class="text-xs text-gray-600 uppercase tracking-wider mb-1">{{ $label }}</p>
                            <p class="text-sm text-text-secondary font-medium">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Habits -->
                <div class="flex flex-wrap gap-2 mt-4">
                    @if($aviso->smoker)
                        <span class="bg-surface-secondary border border-border-subtle text-gray-400 text-xs px-3 py-1 rounded-full">Fumadora</span>
                    @endif
                    @if($aviso->waxed)
                        <span class="bg-surface-secondary border border-border-subtle text-gray-400 text-xs px-3 py-1 rounded-full">Depilada</span>
                    @endif
                    @if($aviso->orientation)
                        <span class="bg-surface-secondary border border-border-subtle text-gray-400 text-xs px-3 py-1 rounded-full">{{ ucfirst($aviso->orientation) }}</span>
                    @endif
                </div>
            </div>

            <!-- Services -->
            @if($aviso->services && count($aviso->services) > 0)
                <div class="mt-6 bg-page-background border border-border-default rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-text-primary mb-4">Servicios</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($aviso->services as $service)
                            <span class="bg-rose-950/30 border border-rose-900/40 text-rose-400 text-sm px-3 py-1.5 rounded-full">
                                {{ $service }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Languages -->
            @if($aviso->languages && count($aviso->languages) > 0)
                <div class="mt-6 bg-page-background border border-border-default rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-text-primary mb-4">Idiomas</h2>
                    <div class="flex flex-wrap gap-3">
                        @foreach($aviso->languages as $lang)
                            <div class="flex items-center space-x-2 bg-surface-secondary rounded-md px-3 py-2">
                                <span class="text-sm text-text-secondary">{{ $lang['language'] ?? $lang }}</span>
                                @if(isset($lang['level']))
                                    <span class="text-xs text-gray-600">{{ $lang['level'] }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Rates -->
            @if($aviso->rates && $aviso->rates->count() > 0)
                <div class="mt-6 bg-page-background border border-border-default rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-text-primary mb-4">Tarifas</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-border-default">
                                    <th class="text-left text-xs text-gray-500 uppercase tracking-wider pb-3">Duracion</th>
                                    <th class="text-right text-xs text-gray-500 uppercase tracking-wider pb-3">Precio</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @foreach($aviso->rates as $rate)
                                    <tr>
                                        <td class="py-3 text-gray-400">{{ $rate->duration }}</td>
                                        <td class="py-3 text-right font-semibold text-rose-400">
                                            ${{ number_format($rate->price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Reviews -->
            @if($aviso->reviews && $aviso->reviews->count() > 0)
                <div class="mt-8">
                    <h2 class="text-lg font-semibold text-text-primary mb-4">
                        Reseñas
                        <span class="text-sm font-normal text-gray-600 ml-2">({{ $aviso->reviews->count() }})</span>
                    </h2>
                    <div class="space-y-4">
                        @foreach($aviso->reviews->take(10) as $review)
                            <div class="bg-page-background border border-border-default rounded-lg p-5">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <p class="text-sm font-medium text-text-secondary">{{ $review->reviewer_name ?? 'Anonimo' }}</p>
                                        <p class="text-xs text-gray-600 mt-0.5">{{ $review->created_at->format('d/m/Y') }}</p>
                                    </div>
                                    <x-rating-stars :rating="$review->rating" />
                                </div>
                                @if($review->comment)
                                    <p class="text-sm text-gray-400 leading-relaxed">{{ $review->comment }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        <!-- Right Column: Info & Contact -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-4">

                <!-- Main Info Card -->
                <div class="bg-page-background border border-border-default rounded-lg p-6">
                    <div class="flex items-start justify-between mb-1">
                        <h1 class="text-2xl font-bold text-text-primary">{{ $aviso->display_name }}</h1>
                        @if($aviso->is_verified)
                            <span class="flex items-center space-x-1 text-xs text-emerald-500 bg-emerald-950/30 border border-emerald-900/40 px-2 py-1 rounded-full">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Verificada</span>
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center space-x-3 text-sm text-gray-500 mt-2">
                        <span>{{ $aviso->age }} años</span>
                        <span class="text-gray-700">&bull;</span>
                        <span>{{ $aviso->city }}, {{ $aviso->province }}</span>
                    </div>

                    @if($aviso->neighborhood)
                        <p class="text-xs text-gray-600 mt-1">{{ $aviso->neighborhood }}</p>
                    @endif

                    @if($aviso->reviews_avg_rating ?? false)
                        <div class="flex items-center space-x-2 mt-3">
                            <x-rating-stars :rating="round($aviso->reviews_avg_rating)" />
                            <span class="text-xs text-gray-500">{{ number_format($aviso->reviews_avg_rating, 1) }} ({{ $aviso->reviews_count ?? 0 }} reseñas)</span>
                        </div>
                    @endif

                    <!-- Starting Rate -->
                    @if($aviso->rates && $aviso->rates->count() > 0)
                        <div class="mt-4 pt-4 border-t border-border-default">
                            <p class="text-xs text-gray-600 uppercase tracking-wider">Desde</p>
                            <p class="text-2xl font-bold text-rose-500 mt-1">
                                ${{ number_format($aviso->rates->min('price'), 0, ',', '.') }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Availability -->
                @if($aviso->availability)
                    <div class="bg-page-background border border-border-default rounded-lg p-5">
                        <h3 class="text-sm font-semibold text-text-secondary mb-3">Disponibilidad</h3>
                        <div class="grid grid-cols-7 gap-1 text-center">
                            @php
                                $days = ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do'];
                                $availability = is_array($aviso->availability) ? $aviso->availability : json_decode($aviso->availability, true) ?? [];
                            @endphp
                            @foreach($days as $i => $day)
                                @php $available = in_array($i, $availability) || isset($availability[$i]); @endphp
                                <div class="rounded py-1.5 text-xs font-medium {{ $available ? 'bg-status-error-light-bg/40 text-rose-400 border border-rose-900/50' : 'bg-surface-secondary text-gray-700' }}">
                                    {{ $day }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Contact Buttons -->
                <x-contact-buttons :aviso="$aviso" />

                <!-- Report -->
                <div class="text-center">
                    <a href="{{ route('avisos.report', $aviso) }}"
                       class="inline-flex items-center space-x-1.5 text-xs text-gray-700 hover:text-gray-500 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                        </svg>
                        <span>Reportar aviso</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
