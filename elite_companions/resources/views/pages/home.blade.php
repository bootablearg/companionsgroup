@extends('layouts.app')

@section('title', 'Elite Companions - Argentina | Compañía Premium para Eventos Exclusivos')
@section('meta_description', 'Elite Companions Argentina — Encontrá compañía premium para eventos exclusivos, galas, networking y presentaciones sociales de alto perfil. Perfiles selectos y verificados.')
@section('canonical', 'https://elitecompanions.cc/')
@section('og_title', 'Elite Companions - Argentina | Compañía Premium')
@section('og_description', 'Plataforma premium de compañía social en Argentina. Perfiles exclusivos para eventos, galas y networking. Discreción y elegancia garantizadas.')
@section('meta_keywords', 'eventos exclusivos buenos aires, acompañamiento elegante, galas, cenas formales, presentaciones sociales, etiqueta moderna, presencia elegante, experiencias premium, eventos culturales, networking social')
@section('twitter_title', 'Acompañamiento elegante para eventos exclusivos')
@section('twitter_description', 'Perfiles elegantes y verificados para galas, presentaciones y cenas formales.')

@push('json_ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Organization",
      "@id": "https://elitecompanions.cc/#organization",
      "name": "Elite Companions",
      "url": "https://elitecompanions.cc/",
      "logo": "https://elitecompanions.cc/images/logo.webp",
      "description": "Plataforma premium de compañía social para eventos exclusivos en Argentina.",
      "areaServed": "AR",
      "contactPoint": {
        "@type": "ContactPoint",
        "contactType": "customer support",
        "availableLanguage": "Spanish"
      }
    },
    {
      "@type": "WebSite",
      "@id": "https://elitecompanions.cc/#website",
      "url": "https://elitecompanions.cc/",
      "name": "Elite Companions",
      "publisher": {"@id": "https://elitecompanions.cc/#organization"},
      "potentialAction": {
        "@type": "SearchAction",
        "target": "https://elitecompanions.cc/search?q={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
  ]
}
</script>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════════════ --}}
<section style="background:#F7F5FF;" class="pt-6 pb-8 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center md:items-start gap-6">

        <!-- Logo — primer tercio izquierdo -->
        <div class="md:w-1/3 flex justify-center md:justify-start md:pl-4 md:pt-2 flex-shrink-0">
            <img src="/images/logo.webp" alt="Elite Companions" style="height:180px;width:auto;border-radius:50%;">
        </div>

        <!-- Texto — dos tercios restantes -->
        <div class="md:w-2/3 text-center md:text-left flex flex-col justify-center md:pt-8">
            <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6">
                <span style="background:linear-gradient(135deg,#7C3AED,#EC4899);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                    Bienvenido al mejor sitio de acompañantes.
                </span>
            </h1>
            <p class="text-lg font-semibold mb-6 leading-relaxed"
               style="background:linear-gradient(135deg,#7C3AED,#EC4899);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                Conectamos personas que valoran su tiempo.<br>
                Elite Companions es tu plataforma ideal.
            </p>
        </div>

    </div>
</section>


{{-- ═══════════════════════════════════════════════════════
     ESCORTS DESTACADAS
═══════════════════════════════════════════════════════ --}}
@if(!$modelos->isEmpty())
<section style="background:#F7F5FF;" class="pt-8 pb-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-3xl font-extrabold"
                    style="background:linear-gradient(135deg,#7C3AED,#EC4899,#F472B6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                    Modelos destacadas
                </h2>
            </div>
            <a href="{{ route('modelos.index') }}"
               class="text-sm font-semibold transition-colors hidden sm:block"
               style="color:#7C3AED;">
                Ver todas →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($modelos as $modelo)
            @php
                $allPhotos  = $modelo->avisos->flatMap(fn($a) => $a->photos)->values();
                $photoSrc   = $modelo->profile_photo_path
                    ? $modelo->getDisplayPhotoUrl()
                    : ($allPhotos->isNotEmpty()
                        ? ($allPhotos->firstWhere('is_cover', true) ?? $allPhotos->first())->getUrl()
                        : null);
                $firstName  = explode(' ', $modelo->display_name ?? $modelo->alias ?? '')[0];
                $rate1h     = $modelo->rates->firstWhere('duration', 'Una hora (1 hs)');
                $isFeatured = $modelo->avisos->where('is_featured', true)->where('status', 'active')->isNotEmpty();
                $activeAviso = $modelo->avisos->where('status', 'active')->first();
                $cardUrl    = $activeAviso ? route('aviso.show', $activeAviso->id) : route('modelos.show', $modelo);
            @endphp
            <a href="{{ $cardUrl }}"
               class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow block border border-gray-100">

                {{-- Foto --}}
                <div class="relative overflow-hidden bg-gray-100" style="aspect-ratio:3/4;">
                    @if($photoSrc)
                        <img src="{{ $photoSrc }}" alt="{{ $firstName }}"
                             class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center"
                             style="background:linear-gradient(135deg,#EDE9FE,#FCE7F3);">
                            <svg class="w-14 h-14 text-violet-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @endif

                    {{-- Badge verificado (top right) --}}
                    @if($modelo->is_verified)
                    <span class="absolute text-green-600 text-xs font-bold px-2 py-0.5 rounded-full shadow-sm flex items-center gap-0.5"
                          style="top:8px;right:8px;background:#fff;">
                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        ✓
                    </span>
                    @endif
                    {{-- Badge destacado (top left) --}}
                    @if($isFeatured)
                    <span class="absolute text-xs font-bold px-2 py-0.5 rounded-full"
                          style="top:8px;left:8px;background:#FEF3C7;color:#92400E;">★</span>
                    @endif
                    {{-- Badge tarifa (bottom left) --}}
                    @if($rate1h)
                    <span class="absolute text-white text-xs px-2 py-0.5 rounded-full font-semibold"
                          style="bottom:8px;left:8px;background:rgba(0,0,0,0.55);">
                        {{ $rate1h->currency ?? 'USD' }} {{ number_format($rate1h->price_usd, 0) }}/hr
                    </span>
                    @endif
                </div>

                {{-- Info --}}
                <div class="p-4">
                    <div class="flex items-start justify-between gap-2 mb-1">
                        <h3 class="font-bold text-gray-900 text-base">
                            {{ $firstName }}@if($modelo->age), {{ $modelo->age }}@endif
                        </h3>
                    </div>

                    @if($modelo->city)
                    <p class="text-xs text-gray-500 flex items-center gap-1 mb-2">
                        <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $modelo->neighborhood ? $modelo->neighborhood.', ' : '' }}{{ $modelo->city }}
                    </p>
                    @endif

                    @if($modelo->rating_count > 0)
                    <div class="flex items-center gap-1 mb-2">
                        <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <span class="text-xs font-semibold text-gray-700">{{ number_format($modelo->rating_avg,1) }}</span>
                        <span class="text-xs text-gray-400">({{ $modelo->rating_count }})</span>
                    </div>
                    @endif

                    @if($modelo->bio)
                    <p class="text-xs text-gray-500 leading-relaxed line-clamp-2 mb-3">{{ $modelo->bio }}</p>
                    @endif

                </div>
            </a>
            @endforeach
        </div>

        <div class="text-center mt-10 sm:hidden">
            <a href="{{ route('modelos.index') }}"
               class="inline-block btn-gradient text-white font-semibold px-8 py-3 rounded-full text-sm shadow-sm">
                Ver todas las companions
            </a>
        </div>
    </div>
</section>
@endif


@endsection
