@extends('layouts.app')

@section('title', $titulo)
@section('meta_description', $metaDesc)
@section('canonical', $canonical)
@section('og_title', $titulo)
@section('og_description', "Escorts y modelos verificadas en {$barrio}, CABA. Identidad real confirmada. Filtrá por disponibilidad, servicio y precio.")

@push('json_ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "CollectionPage",
      "@id": "{{ $canonical }}#collectionpage",
      "url": "{{ $canonical }}",
      "name": "{{ $titulo }}",
      "description": "Escorts y modelos verificadas en {{ $barrio }}, Buenos Aires. Identidad real confirmada.",
      "isPartOf": {"@id": "{{ $websiteId }}"},
      "breadcrumb": {
        "@type": "BreadcrumbList",
        "itemListElement": [
          {"@type": "ListItem", "position": 1, "name": "Inicio", "item": "{{ url('/') }}"},
          {"@type": "ListItem", "position": 2, "name": "Modelos", "item": "{{ url('/avisos') }}"},
          {"@type": "ListItem", "position": 3, "name": "{{ $barrio }}", "item": "{{ $canonical }}"}
        ]
      }
    }
  ]
}
</script>
@endpush

@section('page_style')
<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
.aviso-card {
    background: var(--surface-card);
    border: 1px solid var(--border-default);
    box-shadow: 0 1px 3px var(--shadow-sm);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    animation: fadeInUp 0.4s ease-out both;
}
.aviso-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--card-hover-shadow);
    border-color: var(--border-muted);
}
</style>
@endsection

@section('content')

{{-- HERO --}}
<section style="background:var(--page-background);" class="pt-6 pb-8">
    <div class="max-w-7xl mx-auto px-4">

        {{-- Breadcrumb --}}
        <nav class="text-xs mb-4 flex items-center gap-1" style="color:var(--text-secondary);">
            <a href="{{ route('home') }}" style="color:var(--brand-primary);">Inicio</a>
            <span>/</span>
            <a href="{{ route('modelos.index') }}" style="color:var(--brand-primary);">Modelos</a>
            <span>/</span>
            <span>{{ $barrio }}</span>
        </nav>

        <h1 class="text-3xl md:text-4xl font-extrabold mb-3 leading-tight">
            <span style="background:var(--gradient-accent-brand);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                {{ $h1 }}
            </span>
        </h1>
        <p class="text-base mb-0 leading-relaxed max-w-2xl" style="color:var(--text-secondary);">
            {{ $h1Sub }}
        </p>

    </div>
</section>

{{-- GRID DE AVISOS --}}
<section style="background:var(--page-background);" class="pb-16 pt-2">
    <div class="max-w-7xl mx-auto px-4">

        @if($fallbackMsg ?? false)
        <div class="mb-8 px-4 py-3 rounded-xl text-sm font-medium"
             style="background:var(--surface-muted);border:1px solid var(--border-default);color:var(--text-secondary);">
            {{ $fallbackMsg }}
        </div>
        @endif

        @if($avisos->isEmpty())
        <div class="text-center py-16" style="color:var(--text-secondary);">
            <p class="text-lg font-semibold mb-3">Sin modelos disponibles por el momento.</p>
            <a href="{{ route('modelos.index') }}"
               class="inline-block btn-gradient font-semibold px-8 py-3 rounded-full text-sm">
                Ver todas las modelos
            </a>
        </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($avisos as $aviso)
            @php
                $coverPhoto = $aviso->photos->first();
                $photoSrc   = $aviso->cover_photo_path
                    ? asset('storage/' . $aviso->cover_photo_path)
                    : ($coverPhoto
                        ? asset('storage/' . $coverPhoto->file_path)
                        : ($aviso->escortProfile?->profile_photo_path
                            ? asset('storage/' . $aviso->escortProfile->profile_photo_path)
                            : asset('images/logo.webp')));
                $name      = $aviso->title ?: ($aviso->alias ?: ($aviso->escortProfile?->display_name ?? ''));
                $firstName = explode(' ', trim($name))[0];
                $rate1h    = $aviso->rates->firstWhere('duration', '1 hs. - Convencional')
                    ?? $aviso->rates->firstWhere('duration', 'Una hora (1 hs)')
                    ?? $aviso->rates->first(fn($r) => str_contains($r->duration, '1 hs'));
                $href = $aviso->slug
                    ? route('aviso.show.slug', $aviso->slug)
                    : route('aviso.show', $aviso->id);
            @endphp
            <a href="{{ $href }}"
               class="aviso-card group rounded-2xl overflow-hidden block"
               style="animation-delay:{{ min($loop->index * 55, 440) }}ms">

                {{-- Foto --}}
                <div class="relative overflow-hidden" style="aspect-ratio:3/4;background:var(--surface-input);">
                    <img src="{{ $photoSrc }}" alt="{{ $firstName }}"
                         class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-300">

                    @if($aviso->escortProfile?->is_verified)
                    <span class="absolute text-xs font-bold px-2 py-0.5 rounded-full shadow-sm flex items-center gap-0.5"
                          style="top:8px;right:8px;background:var(--verified-badge-bg);color:var(--verified-badge-text);border:1px solid var(--verified-badge-border);">
                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        ✓
                    </span>
                    @endif
                    @if($aviso->is_featured)
                    <span class="absolute text-xs font-bold px-2 py-0.5 rounded-full"
                          style="top:8px;left:8px;background:var(--featured-badge-bg);color:var(--featured-badge-text);">★</span>
                    @endif
                    @if($rate1h)
                    <span class="absolute text-xs px-2 py-0.5 rounded-full font-semibold"
                          style="bottom:8px;left:8px;background:var(--overlay-image-badge);color:#fff;">
                        {{ $rate1h->currency ?? 'USD' }} {{ number_format($rate1h->price_usd, 0) }}/hr
                    </span>
                    @endif
                </div>

                {{-- Info --}}
                <div class="p-4">
                    <h3 class="font-bold text-base mb-1" style="color:var(--text-primary);">
                        {{ $firstName }}@if($aviso->age), {{ $aviso->age }}@endif
                    </h3>
                    @php $ciudad = $aviso->neighborhood ?: ($aviso->city_name ?: $aviso->city); @endphp
                    @if($ciudad)
                    <p class="text-xs flex items-center gap-1 mb-1" style="color:var(--text-secondary);">
                        <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $ciudad }}
                    </p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('modelos.index') }}"
               class="inline-block btn-gradient font-semibold px-8 py-3 rounded-full text-sm">
                Ver todas las modelos
            </a>
        </div>
        @endif

    </div>
</section>

@endsection
