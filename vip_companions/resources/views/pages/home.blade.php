@extends('layouts.app')

@section('title', 'Elite Companions - Argentina | Compañía Premium para Eventos Exclusivos')
@section('meta_description', 'Escorts elite y acompañantes reales en Buenos Aires. Perfiles verificados, fotos reales, discreción total. Alternativa premium a AreaVIP, ArgentinaBlack, Solo Independientes y Gemidos.')
@section('canonical', 'https://elitecompanions.cc/')
@section('og_title', 'Elite Companions - Argentina | Compañía Premium')
@section('og_description', 'Plataforma premium de compañía social en Argentina. Perfiles exclusivos para eventos, galas y networking. Discreción y elegancia garantizadas.')
@section('meta_keywords', 'escorts argentina, escorts en argentina, escorts buenos aires, escorts en buenos aires, escorts capital federal, escorts en capital federal, escorts ciudad de buenos aires, escorts en ciudad de buenos aires, putas argentina, putas en argentina, putas buenos aires, putas en buenos aires, putas capital federal, putas ciudad de buenos aires, trolas argentina, trolas en argentina, trolas buenos aires, trolas en buenos aires, atorrantas argentina, atorrantas en argentina, atorrantas buenos aires, atorrantas en buenos aires, mujeres argentina, mujeres buenos aires, mujeres capital federal, trans argentina, trans en argentina, trans buenos aires, trans en buenos aires, trans capital federal, trans ciudad de buenos aires, taxiboy argentina, taxiboy en argentina, taxiboy buenos aires, taxiboy en buenos aires, taxiboy capital federal, taxiboy ciudad de buenos aires, escorts vip argentina, escorts vip en argentina, escorts vip buenos aires, escorts vip en buenos aires, escorts vip capital federal, escorts vip ciudad de buenos aires, putas vip argentina, putas vip buenos aires, trolas vip argentina, trolas vip buenos aires, atorrantas vip argentina, atorrantas vip buenos aires, mujeres vip argentina, mujeres vip buenos aires, trans vip argentina, trans vip buenos aires, taxiboy vip argentina, taxiboy vip buenos aires, AreaVIP, Area-VIP, Area-Vip, areavip argentina, areavip escorts, ArgentinaBlack, argentina black escorts, argentina black vip, ArgentinaXP, argentina xp, argentinaxp escorts, Bairesgirls, Baires Girls, bairesgirls escorts, Gemidos, gemidos escorts argentina, Solo Independientes, SoloIndependientes, soloindependientes escorts, Soy Tuyo, soytuyo escorts, Tacos Altos, TacosAltos, Foro Escorts, ForoEscorts, ForoXP, Foro Pirata, acompañantes argentina, acompañantes buenos aires, acompañantes capital federal, acompañantes vip argentina, acompañantes independientes argentina, escorts independientes argentina, escorts independientes buenos aires, escorts de lujo argentina, escorts premium argentina')
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

{{-- ═══════════════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════════════ --}}
<section style="background:var(--page-background);" class="pt-6 pb-8 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center md:items-start gap-6">

        <!-- Logo — primer tercio izquierdo -->
        <div class="md:w-1/3 flex justify-center md:justify-start md:pl-4 md:pt-2 flex-shrink-0">
            <img src="/images/logo.webp" alt="Elite Companions" style="height:180px;width:auto;border-radius:50%;">
        </div>

        <!-- Texto — dos tercios restantes -->
        <div class="md:w-2/3 text-center md:text-left flex flex-col justify-center md:pt-8">
            <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6">
                <span style="background:var(--gradient-accent-brand);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                    Acompañantes de élite, a tu alcance.
                </span>
            </h1>
            <p class="text-lg font-semibold mb-6 leading-relaxed"
               style="background:var(--gradient-accent-brand);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                Filtrá por ciudad, servicio, disponibilidad, precio y más — encontrá exactamente lo que buscás.
            </p>
        </div>

    </div>
</section>


{{-- ═══════════════════════════════════════════════════════
     AVISOS DESTACADOS
═══════════════════════════════════════════════════════ --}}
@if(!$avisos->isEmpty())
<section style="background:var(--page-background);" class="pt-8 pb-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-3xl font-extrabold"
                    style="background:linear-gradient(135deg,var(--brand-primary),var(--action-secondary),var(--brand-accent-400));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                    Modelos destacadas
                </h2>
            </div>
            <a href="{{ route('modelos.index') }}"
               class="text-sm font-semibold transition-colors hidden sm:block"
               style="color: var(--brand-primary);">
                Ver todas →
            </a>
        </div>

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
               class="aviso-card group rounded-2xl overflow-hidden block"
               style="animation-delay:{{ min($loop->index * 55, 440) }}ms">

                {{-- Foto --}}
                <div class="relative overflow-hidden" style="aspect-ratio:3/4;background:var(--surface-input);">
                    @if($photoSrc)
                        <img src="{{ $photoSrc }}" alt="{{ $firstName }}"
                             class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center"
                             style="background:linear-gradient(135deg,var(--border-default),var(--pink-100));">
                            <svg class="w-14 h-14" style="color:var(--brand-primary-300);" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @endif

                    {{-- Badge verificado (top right) --}}
                    @if($aviso->escortProfile?->is_verified)
                    <span class="absolute text-xs font-bold px-2 py-0.5 rounded-full shadow-sm flex items-center gap-0.5"
                          style="top:8px;right:8px;background:var(--verified-badge-bg);color:var(--verified-badge-text);border:1px solid var(--verified-badge-border);">
                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        ✓
                    </span>
                    @endif
                    {{-- Badge destacado (top left) --}}
                    @if($aviso->is_featured)
                    <span class="absolute text-xs font-bold px-2 py-0.5 rounded-full"
                          style="top:8px;left:8px;background:var(--featured-badge-bg);color:var(--featured-badge-text);">★</span>
                    @endif
                    {{-- Badge tarifa (bottom left) --}}
                    @if($rate1h)
                    <span class="absolute text-white text-xs px-2 py-0.5 rounded-full font-semibold"
                          style="bottom:8px;left:8px;background:var(--overlay-image-badge);">
                        {{ $rate1h->currency ?? 'USD' }} {{ number_format($rate1h->price_usd, 0) }}/hr
                    </span>
                    @endif
                </div>

                {{-- Info --}}
                <div class="p-4">
                    <div class="flex items-start justify-between gap-2 mb-1">
                        <h3 class="font-bold text-base" style="color:var(--text-primary);">
                            {{ $firstName }}@if($aviso->age), {{ $aviso->age }}@endif
                        </h3>
                    </div>

                    @php $ciudad = $aviso->city_name ?: $aviso->city; @endphp
                    @if($ciudad)
                    <p class="text-xs flex items-center gap-1 mb-2" style="color:var(--text-secondary);">
                        <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $aviso->neighborhood ? $aviso->neighborhood.', ' : '' }}{{ $ciudad }}
                    </p>
                    @endif

                    @if(($aviso->escortProfile?->rating_count ?? 0) > 0)
                    <div class="flex items-center gap-1 mb-2">
                        <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <span class="text-xs font-semibold" style="color:var(--text-primary);">{{ number_format($aviso->escortProfile->rating_avg, 1) }}</span>
                        <span class="text-xs" style="color:var(--text-tertiary);">({{ $aviso->escortProfile->rating_count }})</span>
                    </div>
                    @endif

                    @if($aviso->description)
                    <p class="text-xs leading-relaxed line-clamp-2 mb-3" style="color:var(--text-secondary);">{{ $aviso->description }}</p>
                    @endif

                </div>
            </a>
            @endforeach
        </div>

        <div class="text-center mt-10 sm:hidden">
            <a href="{{ route('modelos.index') }}"
               class="inline-block btn-gradient font-semibold px-8 py-3 rounded-full text-sm">
                Ver todas las companions
            </a>
        </div>
    </div>
</section>
@endif


@endsection
