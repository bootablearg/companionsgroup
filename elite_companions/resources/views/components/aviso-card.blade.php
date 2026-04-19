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

<article class="border border-gray-800 rounded-2xl bg-gray-900 shadow-xl shadow-black/40 overflow-hidden transition hover:-translate-y-0.5 hover:border-rose-500/30">
    <a href="{{ route('aviso.show', $aviso->id) }}" class="block relative h-52 w-full overflow-hidden bg-gradient-to-br from-gray-900 to-gray-800">
        <img
            src="{{ $coverPhoto }}"
            alt="{{ $aviso->display_name ?? $modelo->display_name ?? 'Perfil' }}"
            class="w-full h-full object-cover transition duration-300 ease-in-out group-hover:scale-105"
            loading="lazy"
        >
        <span class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></span>
        <div class="absolute bottom-4 left-4 text-white text-xs uppercase tracking-[0.2em]">
            {{ $aviso->is_featured ? 'Destacado' : 'Escort verificado' }}
        </div>
    </a>
    <div class="p-5 space-y-3">
        <div class="flex items-start justify-between gap-3">
            <div>
                <h3 class="text-lg font-semibold text-gray-100">{{ $modelo->display_name ?? $aviso->title }}</h3>
                @if($location)
                    <p class="text-xs text-gray-500 uppercase tracking-wider">{{ $location }}</p>
                @endif
            </div>
            @if($price)
                <div class="text-right">
                    <p class="text-sm text-gray-400">Desde</p>
                    <p class="text-rose-400 font-semibold text-lg">${{ number_format($price, 0, ',', '.') }}</p>
                </div>
            @endif
        </div>

        <p class="text-sm text-gray-400 leading-relaxed">{{ $summary }}</p>

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <x-rating-stars :rating="$rating" />
                <span class="text-xs text-gray-500">{{ $ratingCount }} reseñas</span>
            </div>
            <span class="text-xs text-gray-500">{{ $aviso->views_count ?? 0 }} vistas</span>
        </div>

        @if($serviceNames->isNotEmpty())
            <div class="flex flex-wrap gap-2 text-xs">
                @foreach($serviceNames as $service)
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-800/70 text-gray-300 border border-gray-800">
                        {{ $service }}
                    </span>
                @endforeach
            </div>
        @endif

        <div class="pt-2">
            <a href="{{ route('aviso.show', $aviso->id) }}"
               class="inline-flex items-center justify-center w-full rounded-xl border border-rose-600 text-rose-400 hover:bg-rose-600/10 px-4 py-2 text-sm font-semibold transition">
                Ver perfil completo
            </a>
        </div>
    </div>
</article>
