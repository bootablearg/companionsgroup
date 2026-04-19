@extends('layouts.app')

@section('title', $aviso->display_name . ' - ' . $aviso->city)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" style="background:#160E06;min-height:100vh;">

    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-xs mb-6" style="color:#8A6848;">
        <a href="{{ route('home') }}" class="transition-colors"
           onmouseover="this.style.color='#C8A235';" onmouseout="this.style.color='#8A6848';">Inicio</a>
        <span>/</span>
        <a href="{{ route('search', ['province' => $aviso->province]) }}" class="transition-colors"
           onmouseover="this.style.color='#C8A235';" onmouseout="this.style.color='#8A6848';">{{ $aviso->province }}</a>
        <span>/</span>
        <a href="{{ route('search', ['city' => $aviso->city]) }}" class="transition-colors"
           onmouseover="this.style.color='#C8A235';" onmouseout="this.style.color='#8A6848';">{{ $aviso->city }}</a>
        <span>/</span>
        <span style="color:#C0946A;">{{ $aviso->display_name }}</span>
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
                <div class="relative rounded-lg overflow-hidden aspect-[3/4] group" style="background:#201408;">
                    <template x-if="photos.length > 0">
                        <img
                            :src="photos[currentIndex]"
                            :alt="'Foto ' + (currentIndex + 1)"
                            class="w-full h-full object-cover object-top cursor-pointer"
                            @click="openLightbox(currentIndex)"
                        >
                    </template>
                    <template x-if="photos.length === 0">
                        <div class="w-full h-full flex items-center justify-center" style="background:linear-gradient(135deg,#201408,#2C1C0E);">
                            <svg class="w-16 h-16" style="color:#4A3018;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </template>

                    <!-- Nav Arrows -->
                    <template x-if="photos.length > 1">
                        <div>
                            <button @click.stop="prev()" class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/80 text-white p-2 rounded-full transition-opacity opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button @click.stop="next()" class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/80 text-white p-2 rounded-full transition-opacity opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </template>

                    <!-- Photo counter -->
                    <template x-if="photos.length > 1">
                        <div class="absolute bottom-3 right-3 bg-black/60 text-white text-xs px-2 py-1 rounded">
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
                                :style="currentIndex === index ? 'outline:2px solid #C8A235;opacity:1;' : 'opacity:0.5;'"
                                class="flex-shrink-0 w-16 h-16 rounded-md overflow-hidden transition-all hover:opacity-75"
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
                    <button @click="lightboxOpen = false" class="absolute top-4 right-4 text-white/70 hover:text-white">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    <button @click="lightboxIndex = (lightboxIndex - 1 + photos.length) % photos.length" class="absolute left-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white p-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <img :src="photos[lightboxIndex]" class="max-w-full max-h-full object-contain px-16" alt="Foto ampliada">
                    <button @click="lightboxIndex = (lightboxIndex + 1) % photos.length" class="absolute right-4 top-1/2 -translate-y-1/2 text-white/70 hover:text-white p-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Videos Section -->
            @if($aviso->videos && $aviso->videos->count() > 0)
                <div class="mt-8">
                    <h2 class="text-lg font-semibold mb-4" style="color:#F5EDD8;">Videos</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($aviso->videos->take(3) as $video)
                            <div class="rounded-lg overflow-hidden aspect-video" style="background:#2C1C0E;border:1px solid #4A3018;">
                                <video controls class="w-full h-full object-cover" preload="metadata">
                                    <source src="{{ $video->url }}" type="video/mp4">
                                </video>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Description -->
            <div class="mt-8 rounded-lg p-6" style="background:#2C1C0E;border:1px solid #4A3018;">
                <h2 class="text-lg font-semibold mb-4" style="color:#F5EDD8;">Sobre mi</h2>
                <div class="prose prose-sm max-w-none">
                    <p class="leading-relaxed whitespace-pre-line" style="color:#C0946A;">{{ $aviso->introduction }}</p>
                </div>
            </div>

            <!-- Physical Attributes -->
            <div class="mt-6 rounded-lg p-6" style="background:#2C1C0E;border:1px solid #4A3018;">
                <h2 class="text-lg font-semibold mb-4" style="color:#F5EDD8;">Atributos fisicos</h2>
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
                        <div class="rounded-md p-3" style="background:#201408;">
                            <p class="text-xs uppercase tracking-wider mb-1" style="color:#7A6040;">{{ $label }}</p>
                            <p class="text-sm font-medium" style="color:#C0946A;">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Habits -->
                <div class="flex flex-wrap gap-2 mt-4">
                    @if($aviso->smoker)
                        <span class="text-xs px-3 py-1 rounded-full" style="background:#201408;border:1px solid #4A3018;color:#8A6848;">Fumadora</span>
                    @endif
                    @if($aviso->waxed)
                        <span class="text-xs px-3 py-1 rounded-full" style="background:#201408;border:1px solid #4A3018;color:#8A6848;">Depilada</span>
                    @endif
                    @if($aviso->orientation)
                        <span class="text-xs px-3 py-1 rounded-full" style="background:#201408;border:1px solid #4A3018;color:#8A6848;">{{ ucfirst($aviso->orientation) }}</span>
                    @endif
                </div>
            </div>

            <!-- Services -->
            @if($aviso->services && count($aviso->services) > 0)
                <div class="mt-6 rounded-lg p-6" style="background:#2C1C0E;border:1px solid #4A3018;">
                    <h2 class="text-lg font-semibold mb-4" style="color:#F5EDD8;">Servicios</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($aviso->services as $service)
                            <span class="text-sm px-3 py-1.5 rounded-full" style="background:rgba(200,162,53,.10);color:#C0946A;border:1px solid rgba(200,162,53,.20);">
                                {{ $service }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Languages -->
            @if($aviso->languages && count($aviso->languages) > 0)
                <div class="mt-6 rounded-lg p-6" style="background:#2C1C0E;border:1px solid #4A3018;">
                    <h2 class="text-lg font-semibold mb-4" style="color:#F5EDD8;">Idiomas</h2>
                    <div class="flex flex-wrap gap-3">
                        @foreach($aviso->languages as $lang)
                            <div class="flex items-center space-x-2 rounded-md px-3 py-2" style="background:#201408;border:1px solid #4A3018;">
                                <span class="text-sm" style="color:#C0946A;">{{ $lang['language'] ?? $lang }}</span>
                                @if(isset($lang['level']))
                                    <span class="text-xs" style="color:#7A6040;">{{ $lang['level'] }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Rates -->
            @if($aviso->rates && $aviso->rates->count() > 0)
                <div class="mt-6 rounded-lg p-6" style="background:#2C1C0E;border:1px solid #4A3018;">
                    <h2 class="text-lg font-semibold mb-4" style="color:#F5EDD8;">Tarifas</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr style="border-bottom:1px solid #4A3018;">
                                    <th class="text-left text-xs uppercase tracking-wider pb-3" style="color:#8A6848;">Duracion</th>
                                    <th class="text-right text-xs uppercase tracking-wider pb-3" style="color:#8A6848;">Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aviso->rates as $rate)
                                    <tr style="border-top:1px solid #4A3018;">
                                        <td class="py-3" style="color:#C0946A;">{{ $rate->duration }}</td>
                                        <td class="py-3 text-right font-semibold" style="color:#C8A235;">
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
                    <h2 class="text-lg font-semibold mb-4" style="color:#F5EDD8;">
                        Reseñas
                        <span class="text-sm font-normal ml-2" style="color:#7A6040;">({{ $aviso->reviews->count() }})</span>
                    </h2>
                    <div class="space-y-4">
                        @foreach($aviso->reviews->take(10) as $review)
                            <div class="rounded-lg p-5" style="background:#2C1C0E;border:1px solid #4A3018;">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <p class="text-sm font-medium" style="color:#C0946A;">{{ $review->reviewer_name ?? 'Anonimo' }}</p>
                                        <p class="text-xs mt-0.5" style="color:#7A6040;">{{ $review->created_at->format('d/m/Y') }}</p>
                                    </div>
                                    <x-rating-stars :rating="$review->rating" />
                                </div>
                                @if($review->comment)
                                    <p class="text-sm leading-relaxed" style="color:#8A6848;">{{ $review->comment }}</p>
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
                <div class="rounded-lg p-6" style="background:#2C1C0E;border:1px solid #4A3018;">
                    <div class="flex items-start justify-between mb-1">
                        <h1 class="text-2xl font-bold" style="color:#F5EDD8;">{{ $aviso->display_name }}</h1>
                        @if($aviso->is_verified)
                            <span class="flex items-center space-x-1 text-xs px-2 py-1 rounded-full" style="background:rgba(200,162,53,.10);color:#C8A235;border:1px solid rgba(200,162,53,.30);">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Verificada</span>
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center space-x-3 text-sm mt-2" style="color:#8A6848;">
                        <span>{{ $aviso->age }} años</span>
                        <span style="color:#4A3018;">&bull;</span>
                        <span>{{ $aviso->city }}, {{ $aviso->province }}</span>
                    </div>

                    @if($aviso->neighborhood)
                        <p class="text-xs mt-1" style="color:#7A6040;">{{ $aviso->neighborhood }}</p>
                    @endif

                    @if($aviso->reviews_avg_rating ?? false)
                        <div class="flex items-center space-x-2 mt-3">
                            <x-rating-stars :rating="round($aviso->reviews_avg_rating)" />
                            <span class="text-xs" style="color:#8A6848;">{{ number_format($aviso->reviews_avg_rating, 1) }} ({{ $aviso->reviews_count ?? 0 }} reseñas)</span>
                        </div>
                    @endif

                    <!-- Starting Rate -->
                    @if($aviso->rates && $aviso->rates->count() > 0)
                        <div class="mt-4 pt-4" style="border-top:1px solid #4A3018;">
                            <p class="text-xs uppercase tracking-wider" style="color:#7A6040;">Desde</p>
                            <p class="text-2xl font-bold mt-1" style="color:#C8A235;">
                                ${{ number_format($aviso->rates->min('price'), 0, ',', '.') }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Availability -->
                @if($aviso->availability)
                    <div class="rounded-lg p-5" style="background:#2C1C0E;border:1px solid #4A3018;">
                        <h3 class="text-sm font-semibold mb-3" style="color:#C0946A;">Disponibilidad</h3>
                        <div class="grid grid-cols-7 gap-1 text-center">
                            @php
                                $days = ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do'];
                                $availability = is_array($aviso->availability) ? $aviso->availability : json_decode($aviso->availability, true) ?? [];
                            @endphp
                            @foreach($days as $i => $day)
                                @php $available = in_array($i, $availability) || isset($availability[$i]); @endphp
                                <div class="rounded py-1.5 text-xs font-medium"
                                     style="{{ $available ? 'background:rgba(200,162,53,.15);color:#C8A235;border:1px solid rgba(200,162,53,.30);' : 'background:#201408;color:#4A3018;' }}">
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
                       class="inline-flex items-center space-x-1.5 text-xs transition-colors"
                       style="color:#7A6040;"
                       onmouseover="this.style.color='#8A6848';" onmouseout="this.style.color='#7A6040';">
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
