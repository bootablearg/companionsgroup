@props(['aviso'])

@php
    use Illuminate\Support\Str;
    $modelo = $aviso->escortProfile;
    $coverPhoto = $aviso->photos->first()?->getUrl() ?? $modelo?->getDisplayPhotoUrl() ?? asset('favicon.png');
    $location = trim(implode(', ', array_filter([$aviso->city, $aviso->province])));
    $rating = optional($modelo)->rating_avg ?? 0;
    $ratingCount = optional($modelo)->rating_count ?? 0;
    $price = optional($aviso->rates)->min('price') ?? optional($modelo)->rates?->min('price');
    $summary = Str::limit(
        $aviso->short_description ?? $aviso->description ?? optional($modelo)->bio ?? 'Perfil sin descripción pública.',
        110
    );
    $serviceNames = collect($aviso->services ?? optional($modelo)->services ?? [])
        ->map(fn($service) => is_string($service) ? $service : ($service->name ?? $service))
        ->unique()
        ->take(3);
@endphp

<article class="group rounded-2xl overflow-hidden transition-all duration-200 hover:-translate-y-1"
         style="background:#2C1C0E;border:1.5px solid #4A3018;box-shadow:0 2px 12px rgba(0,0,0,.30);"
         onmouseover="this.style.borderColor='#C8A235';this.style.boxShadow='0 8px 32px rgba(200,162,53,.18)';"
         onmouseout="this.style.borderColor='#4A3018';this.style.boxShadow='0 2px 12px rgba(0,0,0,.30)';">

    <a href="{{ route('aviso.show', $aviso->id) }}" class="block relative overflow-hidden" style="aspect-ratio:3/4;">
        <img
            src="{{ $coverPhoto }}"
            alt="{{ $aviso->display_name ?? optional($modelo)->display_name ?? 'Perfil' }}"
            class="w-full h-full object-cover object-top transition-transform duration-300 group-hover:scale-105"
            loading="lazy"
        >
        {{-- Gradient overlay --}}
        <span class="absolute inset-0" style="background:linear-gradient(to top, rgba(22,14,6,.85) 0%, rgba(22,14,6,.20) 50%, transparent 100%);"></span>

        {{-- Badge destacado --}}
        @if($aviso->is_featured)
        <span class="absolute text-xs font-bold px-2 py-0.5 rounded-full"
              style="top:8px;left:8px;background:#2C1C0E;color:#C8A235;border:1px solid #4A3018;">★ Destacada</span>
        @endif

        {{-- Badge verificada --}}
        @if(optional($modelo)->is_verified)
        <span class="absolute text-xs font-bold px-2 py-0.5 rounded-full flex items-center gap-1"
              style="top:8px;right:8px;background:#2C1C0E;color:#C8A235;border:1px solid #4A3018;">
            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            VIP
        </span>
        @endif

        {{-- Precio --}}
        @if($price)
        <span class="absolute text-xs font-semibold px-2 py-0.5 rounded-full"
              style="bottom:8px;left:8px;background:rgba(22,14,6,.75);color:#E8BE50;border:1px solid rgba(200,162,53,.3);">
            Desde ${{ number_format($price, 0, ',', '.') }}
        </span>
        @endif
    </a>

    <div class="p-4 space-y-2">
        <h3 class="font-bold text-base" style="color:#F5EDD8;">
            {{ optional($modelo)->display_name ?? $aviso->title }}
        </h3>

        @if($location)
        <p class="text-xs flex items-center gap-1" style="color:#8A6848;">
            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            {{ $location }}
        </p>
        @endif

        @if($ratingCount > 0)
        <div class="flex items-center gap-1">
            <svg class="w-3.5 h-3.5 fill-current" style="color:#C8A235;" viewBox="0 0 20 20">
                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
            </svg>
            <span class="text-xs font-semibold" style="color:#C8A235;">{{ number_format($rating, 1) }}</span>
            <span class="text-xs" style="color:#8A6848;">({{ $ratingCount }})</span>
        </div>
        @endif

        @if($summary)
        <p class="text-xs leading-relaxed line-clamp-2" style="color:#8A6848;">{{ $summary }}</p>
        @endif

        @if($serviceNames->isNotEmpty())
        <div class="flex flex-wrap gap-1.5 pt-1">
            @foreach($serviceNames as $service)
            <span class="text-xs px-2.5 py-0.5 rounded-full" style="background:rgba(200,162,53,.10);color:#C0946A;border:1px solid rgba(200,162,53,.20);">
                {{ $service }}
            </span>
            @endforeach
        </div>
        @endif

        <div class="pt-2">
            <a href="{{ route('aviso.show', $aviso->id) }}"
               class="inline-flex items-center justify-center w-full rounded-xl py-2 text-sm font-semibold transition-all duration-200"
               style="background:linear-gradient(135deg,#7A5A18,#C8A235);color:#160E06;"
               onmouseover="this.style.background='linear-gradient(135deg,#C8A235,#E8BE50)';"
               onmouseout="this.style.background='linear-gradient(135deg,#7A5A18,#C8A235)';">
                Ver perfil completo
            </a>
        </div>
    </div>
</article>
