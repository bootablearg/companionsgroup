@extends('layouts.app')

@section('title', 'Buscar Companions — VIP Companions Argentina')
@section('meta_description', 'Buscá companions profesionales en VIP Companions Argentina. Filtrá por zona y disponibilidad para reuniones corporativas, cenas ejecutivas y eventos empresariales.')
@section('canonical', 'https://vipcompanions.cc/search')

@section('content')

{{-- Header --}}
<div style="background:#160E06;" class="py-14 text-center">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-extrabold"
            style="background:linear-gradient(135deg,#C8A235,#E8BE50);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
            Buscar Companions
        </h1>
        <p class="mt-3" style="color:#8A6848;">Filtrá por servicios, características y tarifas</p>
    </div>
</div>

<div style="background:#160E06;" class="pb-16 min-h-screen">
<div class="max-w-7xl mx-auto px-4">

{{-- ══ FILTER FORM ══════════════════════════════════════════════════════════ --}}
<form method="GET" action="{{ route('search') }}" id="search-form">
<input type="hidden" name="search" value="1">
<div class="rounded-2xl p-6 mb-8 space-y-6" style="background:#2C1C0E;border:1px solid #4A3018;">

    {{-- Row 1: Text + Province + Sort --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-semibold mb-1.5 uppercase tracking-wide" style="color:#8A6848;">Buscar por nombre o ciudad</label>
            <input type="text" name="q" value="{{ request('q') }}"
                   placeholder="Nombre, alias, ciudad..."
                   class="w-full rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C8A235]"
                   style="background:#201408;border:1px solid #4A3018;color:#F5EDD8;">
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1.5 uppercase tracking-wide" style="color:#8A6848;">Provincia</label>
            <select id="srch-province" name="province"
                    onchange="srchOnProvince(this.value)"
                    class="w-full rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C8A235]"
                    style="background:#201408;border:1px solid #4A3018;color:#F5EDD8;">
                <option value="">— Todas las provincias —</option>
                @foreach($provinces as $prov)
                <option value="{{ $prov }}" {{ request('province') === $prov ? 'selected' : '' }}>{{ $prov }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1.5 uppercase tracking-wide" style="color:#8A6848;">Ordenar por</label>
            <select name="sort_by" class="w-full rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C8A235]"
                    style="background:#201408;border:1px solid #4A3018;color:#F5EDD8;">
                <option value="recent"      {{ request('sort_by','recent')==='recent'      ? 'selected':'' }}>Más recientes</option>
                <option value="age_asc"     {{ request('sort_by')==='age_asc'     ? 'selected':'' }}>Edad — menor primero</option>
                <option value="age_desc"    {{ request('sort_by')==='age_desc'    ? 'selected':'' }}>Edad — mayor primero</option>
                <option value="height_asc"  {{ request('sort_by')==='height_asc'  ? 'selected':'' }}>Altura — menor primero</option>
                <option value="height_desc" {{ request('sort_by')==='height_desc' ? 'selected':'' }}>Altura — mayor primero</option>
                <option value="rate_asc"    {{ request('sort_by')==='rate_asc'    ? 'selected':'' }}>Tarifa — menor primero</option>
                <option value="rate_desc"   {{ request('sort_by')==='rate_desc'   ? 'selected':'' }}>Tarifa — mayor primero</option>
            </select>
        </div>
    </div>

    {{-- Row 2: Ciudad + Barrio (cascading, shown when province or city has data) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4" id="srch-location-row2">
        {{-- Ciudad --}}
        <div>
            <label class="block text-xs font-semibold mb-1.5 uppercase tracking-wide" style="color:#8A6848;">Ciudad</label>
            <select id="srch-city" name="city"
                    onchange="srchOnCity(this.value)"
                    class="w-full rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C8A235]"
                    style="background:#201408;border:1px solid #4A3018;color:#F5EDD8;">
                <option value="">— Todas las ciudades —</option>
            </select>
        </div>
        {{-- Barrio --}}
        <div id="srch-neighborhood-wrap" class="hidden">
            <label class="block text-xs font-semibold mb-1.5 uppercase tracking-wide" style="color:#8A6848;">Barrio</label>
            <select id="srch-neighborhood" name="neighborhood"
                    class="w-full rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C8A235]"
                    style="background:#201408;border:1px solid #4A3018;color:#F5EDD8;">
                <option value="">— Todos los barrios —</option>
            </select>
        </div>
    </div>

    {{-- Advanced filters (vanilla JS toggle) --}}
    @php
        $hasAdvanced = request()->anyFilled(['service_types','gender','sexual_orientation','age_min','age_max','height_min','height_max','hair_color','eye_color','skin_color','nationality','is_smoker','is_waxed','has_tattoos','has_piercings','price_min','price_max']);
    @endphp

    <div>
        <button type="button" onclick="searchToggleAdvanced()"
                class="flex items-center gap-2 text-sm font-semibold transition-colors" style="color:#C8A235;">
            <svg id="search-adv-arrow" class="w-4 h-4 transition-transform {{ $hasAdvanced ? 'rotate-90' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 4.293a1 1 0 011.414 0l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414-1.414L11.586 10 7.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
            <span style="background:linear-gradient(135deg,#C8A235,#E8BE50);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                Filtros avanzados (Servicios · Características · Datos adicionales · Tarifas)
            </span>
        </button>

        <div id="search-adv-panel" class="{{ $hasAdvanced ? '' : 'hidden' }} mt-5 space-y-6 pt-5" style="border-top:1px solid #2C1C0E;">

            {{-- Tipo de Servicio --}}
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-wider mb-3" style="color:#8A6848;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;">Tipo de Servicio</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2">
                    @foreach($serviceTypes as $st)
                    <label class="flex items-center gap-1.5 text-sm cursor-pointer">
                        <input type="checkbox" name="service_types[]" value="{{ $st->id }}"
                            {{ in_array($st->id, (array) request('service_types', [])) ? 'checked' : '' }}
                            class="rounded border-gray-300" style="accent-color:#C8A235;">
                        <span style="color:#C0946A;">{{ $st->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Características --}}
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-wider mb-3" style="color:#8A6848;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;">Características</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs mb-1" style="color:#8A6848;">Género</label>
                        <select name="gender" class="w-full rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C8A235]" style="background:#201408;border:1px solid #4A3018;color:#F5EDD8;">
                            <option value="">— Todos —</option>
                            <option value="female"   {{ request('gender')==='female'   ? 'selected':'' }}>Femenino</option>
                            <option value="male"     {{ request('gender')==='male'     ? 'selected':'' }}>Masculino</option>
                            <option value="trans" {{ request('gender')==='trans' ? 'selected':'' }}>Trans</option>
                            <option value="other"    {{ request('gender')==='other'    ? 'selected':'' }}>Otro</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs mb-1" style="color:#8A6848;">Orientación sexual</label>
                        <select name="sexual_orientation" class="w-full rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C8A235]" style="background:#201408;border:1px solid #4A3018;color:#F5EDD8;">
                            <option value="">— Todas —</option>
                            @foreach(['Hetero','Bisexual','Gay','Lesbiana'] as $or)
                            <option value="{{ $or }}" {{ request('sexual_orientation')===$or ? 'selected':'' }}>{{ $or }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs mb-1" style="color:#8A6848;">Edad</label>
                        <div class="flex gap-1 items-center">
                            <input type="number" name="age_min" value="{{ request('age_min') }}" placeholder="Min" min="18" max="99"
                                   class="w-full rounded-xl px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C8A235]" style="background:#201408;border:1px solid #4A3018;color:#F5EDD8;">
                            <span class="text-xs" style="color:#8A6848;">–</span>
                            <input type="number" name="age_max" value="{{ request('age_max') }}" placeholder="Máx" min="18" max="99"
                                   class="w-full rounded-xl px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C8A235]" style="background:#201408;border:1px solid #4A3018;color:#F5EDD8;">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs mb-1" style="color:#8A6848;">Altura (cm)</label>
                        <div class="flex gap-1 items-center">
                            <input type="number" name="height_min" value="{{ request('height_min') }}" placeholder="Min" min="100" max="220"
                                   class="w-full rounded-xl px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C8A235]" style="background:#201408;border:1px solid #4A3018;color:#F5EDD8;">
                            <span class="text-xs" style="color:#8A6848;">–</span>
                            <input type="number" name="height_max" value="{{ request('height_max') }}" placeholder="Máx" min="100" max="220"
                                   class="w-full rounded-xl px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C8A235]" style="background:#201408;border:1px solid #4A3018;color:#F5EDD8;">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs mb-1" style="color:#8A6848;">Color de cabello</label>
                        <select name="hair_color" class="w-full rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C8A235]" style="background:#201408;border:1px solid #4A3018;color:#F5EDD8;">
                            <option value="">— Todos —</option>
                            @foreach(['Caoba','Castaño','Castaño Oscuro','Negro','Pelirrojo','Rubio','Rubio Platinado'] as $c)
                            <option value="{{ $c }}" {{ request('hair_color')===$c ? 'selected':'' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs mb-1" style="color:#8A6848;">Color de ojos</label>
                        <select name="eye_color" class="w-full rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C8A235]" style="background:#201408;border:1px solid #4A3018;color:#F5EDD8;">
                            <option value="">— Todos —</option>
                            @foreach(['Azules','Café','Celestes','Grises','Marrones','Marrones Claros','Miel','Negros','Pardos','Verdes'] as $c)
                            <option value="{{ $c }}" {{ request('eye_color')===$c ? 'selected':'' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs mb-1" style="color:#8A6848;">Tono de piel</label>
                        <select name="skin_color" class="w-full rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C8A235]" style="background:#201408;border:1px solid #4A3018;color:#F5EDD8;">
                            <option value="">— Todos —</option>
                            @foreach(['Blanca','Bronceada','Morena','Negra','Trigueña'] as $c)
                            <option value="{{ $c }}" {{ request('skin_color')===$c ? 'selected':'' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Datos adicionales --}}
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-wider mb-3" style="color:#8A6848;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;">Datos Adicionales</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-xs mb-1" style="color:#8A6848;">Nacionalidad</label>
                        <select name="nationality" class="w-full rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C8A235]" style="background:#201408;border:1px solid #4A3018;color:#F5EDD8;">
                            <option value="">— Todas —</option>
                            @foreach($countries as $country)
                            <option value="{{ $country }}" {{ request('nationality') === $country ? 'selected' : '' }}>{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label class="flex items-center gap-2 text-sm cursor-pointer pt-5" style="color:#C0946A;">
                        <input type="checkbox" name="is_smoker" value="1" {{ request('is_smoker') ? 'checked' : '' }}
                               class="rounded border-gray-300" style="accent-color:#C8A235;">
                        Fumadora
                    </label>
                    <label class="flex items-center gap-2 text-sm cursor-pointer pt-5" style="color:#C0946A;">
                        <input type="checkbox" name="is_waxed" value="1" {{ request('is_waxed') ? 'checked' : '' }}
                               class="rounded border-gray-300" style="accent-color:#C8A235;">
                        Depilada
                    </label>
                    <label class="flex items-center gap-2 text-sm cursor-pointer pt-5" style="color:#C0946A;">
                        <input type="checkbox" name="has_tattoos" value="1" {{ request('has_tattoos') ? 'checked' : '' }}
                               class="rounded border-gray-300" style="accent-color:#C8A235;">
                        Con tatuajes
                    </label>
                    <label class="flex items-center gap-2 text-sm cursor-pointer pt-5" style="color:#C0946A;">
                        <input type="checkbox" name="has_piercings" value="1" {{ request('has_piercings') ? 'checked' : '' }}
                               class="rounded border-gray-300" style="accent-color:#C8A235;">
                        Con piercings
                    </label>
                </div>
            </div>

            {{-- Tarifas --}}
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-wider mb-3" style="color:#8A6848;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;">Tarifas (por 1 hora)</h3>
                <div class="flex gap-3 items-center max-w-xs">
                    <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Mín" min="0"
                           class="w-full rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C8A235]" style="background:#201408;border:1px solid #4A3018;color:#F5EDD8;">
                    <span style="color:#8A6848;">–</span>
                    <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Máx" min="0"
                           class="w-full rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C8A235]" style="background:#201408;border:1px solid #4A3018;color:#F5EDD8;">
                </div>
            </div>

        </div>
    </div>

    {{-- Submit --}}
    <div class="flex gap-3 items-center pt-2" style="border-top:1px solid #2C1C0E;">
        <button type="submit" class="btn-gradient px-6 py-2.5 rounded-full text-sm font-semibold shadow-sm">
            Buscar
        </button>
        @if($searched)
        <a href="{{ route('search') }}" class="text-sm transition-colors" style="color:#8A6848;"
           onmouseover="this.style.color='#C8A235'" onmouseout="this.style.color='#8A6848'">Limpiar filtros</a>
        @endif
    </div>

</div>
</form>

{{-- ══ RESULTS ══════════════════════════════════════════════════════════════ --}}
@if(!$searched)
<div class="text-center py-24">
    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-5" style="background:#2C1C0E;">
        <svg class="w-10 h-10 text-[#C0946A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
    </div>
    <p class="text-lg font-medium mb-1"
       style="background:linear-gradient(135deg,#C8A235,#E8BE50);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
        Usá los filtros para encontrar companions
    </p>
    <p class="text-sm" style="color:#8A6848;">Podés buscar por servicios, características, datos adicionales y tarifas</p>
</div>

@elseif($modelos->isEmpty())
<div class="text-center py-24">
    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-5" style="background:#2C1C0E;">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#4A3018;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>
    <p class="font-medium mb-1" style="color:#8A6848;font-size:1.125rem;">No se encontraron resultados</p>
    <p class="text-sm mb-4" style="color:#8A6848;">Probá con otros filtros o criterios de búsqueda</p>
    <a href="{{ route('search') }}" class="text-sm font-semibold transition-colors" style="color:#C8A235;">Limpiar filtros</a>
</div>

@else
<div class="flex items-center justify-between mb-5">
    <p class="text-sm" style="color:#8A6848;">
        <span style="color:#F5EDD8;font-weight:600;">{{ $modelos->total() }}</span>
        resultado{{ $modelos->total() !== 1 ? 's' : '' }} encontrado{{ $modelos->total() !== 1 ? 's' : '' }}
    </p>
</div>

<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
    @foreach($modelos as $modelo)
    @php
        $allPhotos  = $modelo->avisos->flatMap(fn($a) => $a->photos)->values();
        $photoSrc   = $modelo->profile_photo_path
            ? $modelo->getDisplayPhotoUrl()
            : ($allPhotos->isNotEmpty()
                ? ($allPhotos->firstWhere('is_cover', true) ?? $allPhotos->first())->getUrl()
                : null);
        $firstName  = $modelo->display_name ?? $modelo->alias ?? '';
        $rate1h     = $modelo->rates->firstWhere('duration', 'Una hora (1 hs)');
        $isFeatured  = $modelo->avisos->where('is_featured', true)->where('status', 'active')->isNotEmpty();
        $activeAviso = $modelo->avisos->where('status', 'active')->first();
        $cardUrl     = $activeAviso ? route('aviso.show', $activeAviso->id) : route('modelos.show', $modelo);
    @endphp
    <a href="{{ $cardUrl }}"
       class="group rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow block"
       style="background:#2C1C0E;border:1px solid #4A3018;">

        {{-- Foto --}}
        <div class="relative overflow-hidden" style="aspect-ratio:3/4;background:#201408;">
            @if($photoSrc)
                <img src="{{ $photoSrc }}" alt="{{ $firstName }}"
                     class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-300">
            @else
                <div class="w-full h-full flex items-center justify-center"
                     style="background:linear-gradient(135deg,#2C1C0E,#2C1C0E);">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20" style="color:#4A3018;">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
            @endif

            @if($rate1h)
            <span class="absolute bottom-2 right-2 text-white text-xs px-2 py-0.5 rounded-full font-semibold" style="background:rgba(0,0,0,0.55);">
                {{ $rate1h->currency ?? 'USD' }} {{ number_format($rate1h->price_usd, 0) }}/hr
            </span>
            @endif

            @if($modelo->is_verified)
            <span class="absolute top-2 right-2 text-xs font-bold px-2 py-0.5 rounded-full shadow-sm flex items-center gap-0.5" style="background:rgba(44,28,14,.90);color:#C8A235;border:1px solid #4A3018;">
                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                ✓
            </span>
            @endif

            @if($isFeatured)
            <span class="absolute top-2 left-2 text-xs font-bold px-2 py-0.5 rounded-full"
                  style="background:#2C1C0E; color:#C8A235;">★</span>
            @endif
        </div>

        {{-- Info --}}
        <div class="p-2.5">
            <p style="color:#F5EDD8;font-size:0.875rem;font-weight:700;" class="truncate">
                {{ $firstName }}@if($modelo->age), {{ $modelo->age }}@endif
            </p>
            @if($modelo->city)
            <p class="truncate mt-0.5" style="color:#8A6848;font-size:0.75rem;">
                {{ $modelo->neighborhood ? $modelo->neighborhood.' · ':'' }}{{ $modelo->city }}
            </p>
            @endif
            @if($modelo->height_cm)
            <p class="mt-0.5" style="color:#8A6848;font-size:0.75rem;">{{ $modelo->height_cm }} cm</p>
            @endif
        </div>
    </a>
    @endforeach
</div>

@if($modelos->hasPages())
<div class="mt-8">
    {{ $modelos->links() }}
</div>
@endif
@endif

</div>
</div>

@push('scripts')
<script>
/* ── Advanced filters toggle ── */
function searchToggleAdvanced() {
    var panel = document.getElementById('search-adv-panel');
    var arrow = document.getElementById('search-adv-arrow');
    var isHidden = panel.classList.contains('hidden');
    panel.classList.toggle('hidden', !isHidden);
    arrow.style.transform = isHidden ? 'rotate(90deg)' : '';
}

/* ── Cascading location dropdowns ── */
var srchCitiesByProvince    = @json($citiesByProvince ?? []);
var srchNeighborhoodsByCity = @json($neighborhoodsByCity ?? []);
var srchCurrentProvince     = @json(request('province', ''));
var srchCurrentCity         = @json(request('city', ''));
var srchCurrentNeighborhood = @json(request('neighborhood', ''));

function srchPopulateCities(province, selectedCity) {
    var sel = document.getElementById('srch-city');
    sel.innerHTML = '<option value="">— Todas las ciudades —</option>';
    var cities = [];
    if (province) {
        // Case-insensitive key lookup (handles accent/encoding differences)
        var keys = Object.keys(srchCitiesByProvince);
        for (var i = 0; i < keys.length; i++) {
            if (keys[i].toLowerCase() === province.toLowerCase()) {
                cities = srchCitiesByProvince[keys[i]];
                break;
            }
        }
    } else {
        // No province selected: show all cities across all provinces
        var allCities = [];
        Object.values(srchCitiesByProvince).forEach(function(arr) {
            arr.forEach(function(c) { if (allCities.indexOf(c) === -1) allCities.push(c); });
        });
        allCities.sort();
        cities = allCities;
    }
    cities.forEach(function(city) {
        var opt = document.createElement('option');
        opt.value = city;
        opt.textContent = city;
        if (city === selectedCity) opt.selected = true;
        sel.appendChild(opt);
    });
}

function srchPopulateNeighborhoods(city, selectedNeighborhood) {
    var wrap = document.getElementById('srch-neighborhood-wrap');
    var sel  = document.getElementById('srch-neighborhood');
    // Case-insensitive key lookup
    var neighborhoods = [];
    if (city) {
        var keys = Object.keys(srchNeighborhoodsByCity);
        for (var i = 0; i < keys.length; i++) {
            if (keys[i].toLowerCase() === city.toLowerCase()) {
                neighborhoods = srchNeighborhoodsByCity[keys[i]];
                break;
            }
        }
    }
    if (neighborhoods.length > 0) {
        sel.innerHTML = '<option value="">— Todos los barrios —</option>';
        neighborhoods.forEach(function(n) {
            var opt = document.createElement('option');
            opt.value = n;
            opt.textContent = n;
            if (n === selectedNeighborhood) opt.selected = true;
            sel.appendChild(opt);
        });
        wrap.classList.remove('hidden');
    } else {
        sel.innerHTML = '<option value="">— Todos los barrios —</option>';
        wrap.classList.add('hidden');
    }
}

function srchOnProvince(province) {
    srchPopulateCities(province, '');
    srchPopulateNeighborhoods('', '');
    document.getElementById('srch-neighborhood').value = '';
}

function srchOnCity(city) {
    srchPopulateNeighborhoods(city, '');
    document.getElementById('srch-neighborhood').value = '';
}

/* ── Init on page load (restore selected values after form submit) ── */
document.addEventListener('DOMContentLoaded', function() {
    srchPopulateCities(srchCurrentProvince, srchCurrentCity);
    if (srchCurrentCity) {
        srchPopulateNeighborhoods(srchCurrentCity, srchCurrentNeighborhood);
    }
});
</script>
@endpush

@endsection
