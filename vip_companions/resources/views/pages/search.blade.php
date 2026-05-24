@extends('layouts.app')

@section('title', 'Buscar Companions — Elite Companions Argentina')
@section('meta_description', 'Encontrá escorts y acompañantes elite en Buenos Aires, Capital Federal y toda Argentina. Filtrá por zona, servicios, tarifas y disponibilidad. Discreción y seguridad garantizadas.')
@section('canonical', 'https://elitecompanions.cc/search')
@section('meta_keywords', 'escorts argentina, escorts en argentina, escorts buenos aires, escorts en buenos aires, escorts capital federal, escorts en capital federal, escorts ciudad de buenos aires, escorts en ciudad de buenos aires, putas argentina, putas en argentina, putas buenos aires, putas en buenos aires, putas capital federal, putas ciudad de buenos aires, trolas argentina, trolas en argentina, trolas buenos aires, trolas en buenos aires, atorrantas argentina, atorrantas en argentina, atorrantas buenos aires, atorrantas en buenos aires, mujeres argentina, mujeres buenos aires, mujeres capital federal, trans argentina, trans en argentina, trans buenos aires, trans en buenos aires, trans capital federal, trans ciudad de buenos aires, taxiboy argentina, taxiboy en argentina, taxiboy buenos aires, taxiboy en buenos aires, taxiboy capital federal, taxiboy ciudad de buenos aires, escorts vip argentina, escorts vip en argentina, escorts vip buenos aires, escorts vip en buenos aires, escorts vip capital federal, escorts vip ciudad de buenos aires, putas vip argentina, putas vip buenos aires, trolas vip argentina, trolas vip buenos aires, atorrantas vip argentina, atorrantas vip buenos aires, mujeres vip argentina, mujeres vip buenos aires, trans vip argentina, trans vip buenos aires, taxiboy vip argentina, taxiboy vip buenos aires, AreaVIP, Area-VIP, Area-Vip, areavip argentina, areavip escorts, ArgentinaBlack, argentina black escorts, argentina black vip, ArgentinaXP, argentina xp, argentinaxp escorts, Bairesgirls, Baires Girls, bairesgirls escorts, Gemidos, gemidos escorts argentina, Solo Independientes, SoloIndependientes, soloindependientes escorts, Soy Tuyo, soytuyo escorts, Tacos Altos, TacosAltos, Foro Escorts, ForoEscorts, ForoXP, Foro Pirata, acompañantes argentina, acompañantes buenos aires, acompañantes capital federal, acompañantes vip argentina, acompañantes independientes argentina, escorts independientes argentina, escorts independientes buenos aires, escorts de lujo argentina, escorts premium argentina')

@section('page_style')
.bg-white                          { background-color: var(--surface-card) !important; }
.text-gray-900, .text-gray-800     { color: var(--text-primary) !important; }
.text-gray-700, .text-gray-600     { color: var(--text-secondary) !important; }
.text-gray-500, .text-gray-400     { color: var(--text-muted) !important; }
.border-gray-100, .border-gray-200 { border-color: var(--border-default) !important; }
.bg-gray-100                       { background-color: var(--surface-tertiary) !important; }
input[type="text"], input[type="number"], select {
    background-color: var(--surface-tertiary) !important;
    color: var(--input-text) !important;
    border-color: var(--input-border-default) !important;
}
input[type="text"]::placeholder,
input[type="number"]::placeholder {
    color: var(--input-placeholder) !important;
    opacity: 1;
}
@endsection

@section('content')

{{-- Header --}}
<div style="background:var(--page-background);" class="py-14 text-center">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-extrabold"
            style="background:var(--gradient-accent-brand);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
            Buscar Modelos
        </h1>
        <p class="mt-3" style="color:var(--text-muted);">Filtrá por servicios, características, tarifas y mucho más</p>
    </div>
</div>

<div style="background:var(--page-background);" class="pb-16 min-h-screen">
<div class="max-w-7xl mx-auto px-4">

{{-- ══ FILTER FORM ══════════════════════════════════════════════════════════ --}}
<form method="GET" action="{{ route('search') }}" id="search-form">
<input type="hidden" name="search" value="1">
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8 space-y-6">

    {{-- Row 1: Text + Province + Sort --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Buscar por nombre o ciudad</label>
            <input type="text" name="q" value="{{ request('q') }}"
                   placeholder="Nombre, alias, ciudad..."
                   class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent"
                   style="--tw-ring-color:var(--brand-primary);">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Provincia</label>
            <select id="srch-province" name="province"
                    onchange="srchOnProvince(this.value)"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent"
                    style="--tw-ring-color:var(--brand-primary);">
                <option value="">— Todas las provincias —</option>
                @foreach($provinces as $prov)
                <option value="{{ $prov }}" {{ request('province') === $prov ? 'selected' : '' }}>{{ $prov }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Ordenar por</label>
            <select name="sort_by" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent"
                    style="--tw-ring-color:var(--brand-primary);">
                <option value="recent"      {{ request('sort_by','recent')==='recent'      ? 'selected':'' }}>— Ordenar —</option>
                <option value="age_asc"     {{ request('sort_by')==='age_asc'     ? 'selected':'' }}>Edad — menor primero</option>
                <option value="age_desc"    {{ request('sort_by')==='age_desc'    ? 'selected':'' }}>Edad — mayor primero</option>
                <option value="height_asc"  {{ request('sort_by')==='height_asc'  ? 'selected':'' }}>Altura — menor primero</option>
                <option value="height_desc" {{ request('sort_by')==='height_desc' ? 'selected':'' }}>Altura — mayor primero</option>
                <option value="rate_asc"    {{ request('sort_by')==='rate_asc'    ? 'selected':'' }}>Tarifa — menor primero</option>
                <option value="rate_desc"   {{ request('sort_by')==='rate_desc'   ? 'selected':'' }}>Tarifa — mayor primero</option>
                <option value="published_at" {{ request('sort_by')==='published_at' ? 'selected':'' }}>Más recientes</option>
                <option value="rating_desc" {{ request('sort_by')==='rating_desc' ? 'selected':'' }}>Mejor valoradas</option>
            </select>
        </div>
    </div>

    {{-- Row 2: Ciudad + Barrio (cascading, shown when province or city has data) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4" id="srch-location-row2">
        {{-- Ciudad --}}
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Ciudad</label>
            <select id="srch-city" name="city"
                    onchange="srchOnCity(this.value)"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent"
                    style="--tw-ring-color:var(--brand-primary);">
                <option value="">— Todas las ciudades —</option>
            </select>
        </div>
        {{-- Barrio --}}
        <div id="srch-neighborhood-wrap" class="hidden">
            <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Barrio</label>
            <select id="srch-neighborhood" name="neighborhood"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent"
                    style="--tw-ring-color:var(--brand-primary);">
                <option value="">— Todos los barrios —</option>
            </select>
        </div>
    </div>

    {{-- Advanced filters (vanilla JS toggle) --}}
    @php
        $hasAdvanced = request()->anyFilled(['service_types','gender','sexual_orientation','age_min','age_max','height_min','height_max','bust_min','bust_max','hair_color','eye_color','skin_color','nationality','is_smoker','is_waxed','has_tattoos','has_piercings','price_min','price_max','idioma','dia']);
    @endphp

    <div>
        <button type="button" onclick="searchToggleAdvanced()"
                class="flex items-center gap-2 text-sm font-semibold transition-colors" style="color: var(--brand-primary);">
            <svg id="search-adv-arrow" class="w-4 h-4 transition-transform {{ $hasAdvanced ? 'rotate-90' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 4.293a1 1 0 011.414 0l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414-1.414L11.586 10 7.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
            <span style="background:var(--gradient-accent-brand);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                Filtros avanzados (Servicios · Características · Datos adicionales · Tarifas)
            </span>
        </button>

        <div id="search-adv-panel" class="{{ $hasAdvanced ? '' : 'hidden' }} mt-5 space-y-6 border-t border-gray-100 pt-5">

            {{-- Tipo de Servicio --}}
            <div>
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Tipo de Servicio</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2">
                    @foreach($serviceTypes as $st)
                    <label class="flex items-center gap-1.5 text-sm cursor-pointer">
                        <input type="checkbox" name="service_types[]" value="{{ $st->id }}"
                            {{ in_array($st->id, (array) request('service_types', [])) ? 'checked' : '' }}
                            class="rounded border-gray-300" style="accent-color:var(--brand-primary);">
                        <span class="text-gray-700">{{ $st->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Características --}}
            <div>
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Características</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Género</label>
                        <select name="gender" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2" style="--tw-ring-color:var(--brand-primary);">
                            <option value="">— Todos —</option>
                            <option value="female"   {{ request('gender')==='female'   ? 'selected':'' }}>Femenino</option>
                            <option value="male"     {{ request('gender')==='male'     ? 'selected':'' }}>Masculino</option>
                            <option value="trans" {{ request('gender')==='trans' ? 'selected':'' }}>Trans</option>
                            <option value="other"    {{ request('gender')==='other'    ? 'selected':'' }}>Otro</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Orientación sexual</label>
                        <select name="sexual_orientation" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2" style="--tw-ring-color:var(--brand-primary);">
                            <option value="">— Todas —</option>
                            @foreach(['Hetero','Bisexual','Gay','Lesbiana'] as $or)
                            <option value="{{ $or }}" {{ request('sexual_orientation')===$or ? 'selected':'' }}>{{ $or }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Edad</label>
                        <div class="flex gap-1 items-center">
                            <input type="number" name="age_min" value="{{ request('age_min') }}" placeholder="Min" min="18" max="99"
                                   class="w-full border border-gray-200 rounded-xl px-2 py-2 text-sm focus:outline-none focus:ring-2" style="--tw-ring-color:var(--brand-primary);">
                            <span class="text-gray-400 text-xs">–</span>
                            <input type="number" name="age_max" value="{{ request('age_max') }}" placeholder="Máx" min="18" max="99"
                                   class="w-full border border-gray-200 rounded-xl px-2 py-2 text-sm focus:outline-none focus:ring-2" style="--tw-ring-color:var(--brand-primary);">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Altura (cm)</label>
                        <div class="flex gap-1 items-center">
                            <input type="number" name="height_min" value="{{ request('height_min') }}" placeholder="Min" min="100" max="220"
                                   class="w-full border border-gray-200 rounded-xl px-2 py-2 text-sm focus:outline-none focus:ring-2" style="--tw-ring-color:var(--brand-primary);">
                            <span class="text-gray-400 text-xs">–</span>
                            <input type="number" name="height_max" value="{{ request('height_max') }}" placeholder="Máx" min="100" max="220"
                                   class="w-full border border-gray-200 rounded-xl px-2 py-2 text-sm focus:outline-none focus:ring-2" style="--tw-ring-color:var(--brand-primary);">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Color de cabello</label>
                        <select name="hair_color" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2" style="--tw-ring-color:var(--brand-primary);">
                            <option value="">— Todos —</option>
                            @foreach(['Caoba','Castaño','Castaño Oscuro','Negro','Pelirrojo','Rubio','Rubio Platinado'] as $c)
                            <option value="{{ $c }}" {{ request('hair_color')===$c ? 'selected':'' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Color de ojos</label>
                        <select name="eye_color" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2" style="--tw-ring-color:var(--brand-primary);">
                            <option value="">— Todos —</option>
                            @foreach(['Azules','Café','Celestes','Grises','Marrones','Marrones Claros','Miel','Negros','Pardos','Verdes'] as $c)
                            <option value="{{ $c }}" {{ request('eye_color')===$c ? 'selected':'' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Tono de piel</label>
                        <select name="skin_color" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2" style="--tw-ring-color:var(--brand-primary);">
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
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Datos Adicionales</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Nacionalidad</label>
                        <select name="nationality" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2" style="--tw-ring-color:var(--brand-primary);">
                            <option value="">— Todas —</option>
                            @foreach($countries as $country)
                            <option value="{{ $country }}" {{ request('nationality') === $country ? 'selected' : '' }}>{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Idioma</label>
                        <select name="idioma" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2" style="--tw-ring-color:var(--brand-primary);">
                            <option value="">— Todos —</option>
                            @foreach(['Español','Inglés','Portugués','Francés','Italiano','Alemán','Chino','Japonés','Árabe','Ruso'] as $lang)
                            <option value="{{ $lang }}" {{ request('idioma')===$lang ? 'selected':'' }}>{{ $lang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Busto (cm)</label>
                        <div class="flex gap-1">
                            <input type="number" name="bust_min" value="{{ request("bust_min") }}" placeholder="Min"
                                   class="w-full border border-gray-200 rounded-xl px-2 py-2 text-sm focus:outline-none focus:ring-2" style="--tw-ring-color:var(--brand-primary);">
                            <input type="number" name="bust_max" value="{{ request("bust_max") }}" placeholder="Max"
                                   class="w-full border border-gray-200 rounded-xl px-2 py-2 text-sm focus:outline-none focus:ring-2" style="--tw-ring-color:var(--brand-primary);">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Disponibilidad</label>
                        <select name="dia" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2" style="--tw-ring-color:var(--brand-primary);">
                            <option value="">— Cualquier día —</option>
                            @foreach(["Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo"] as $dia)
                            <option value="{{ $dia }}" {{ request("dia")===$dia ? "selected":"" }}>{{ $dia }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label class="flex items-center gap-2 text-sm cursor-pointer pt-5 text-gray-700">
                        <input type="checkbox" name="is_smoker" value="1" {{ request('is_smoker') ? 'checked' : '' }}
                               class="rounded border-gray-300" style="accent-color:var(--brand-primary);">
                        Fumadora
                    </label>
                    <label class="flex items-center gap-2 text-sm cursor-pointer pt-5 text-gray-700">
                        <input type="checkbox" name="is_waxed" value="1" {{ request('is_waxed') ? 'checked' : '' }}
                               class="rounded border-gray-300" style="accent-color:var(--brand-primary);">
                        Depilada
                    </label>
                    <label class="flex items-center gap-2 text-sm cursor-pointer pt-5 text-gray-700">
                        <input type="checkbox" name="has_tattoos" value="1" {{ request('has_tattoos') ? 'checked' : '' }}
                               class="rounded border-gray-300" style="accent-color:var(--brand-primary);">
                        Con tatuajes
                    </label>
                    <label class="flex items-center gap-2 text-sm cursor-pointer pt-5 text-gray-700">
                        <input type="checkbox" name="has_piercings" value="1" {{ request('has_piercings') ? 'checked' : '' }}
                               class="rounded border-gray-300" style="accent-color:var(--brand-primary);">
                        Con piercings
                    </label>
                </div>
            </div>

            {{-- Tarifas --}}
            <div>
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Tarifas (por 1 hora)</h3>
                <div class="flex gap-3 items-center max-w-xs">
                    <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Mín" min="0"
                           class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2" style="--tw-ring-color:var(--brand-primary);">
                    <span class="text-gray-400">–</span>
                    <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Máx" min="0"
                           class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2" style="--tw-ring-color:var(--brand-primary);">
                </div>
            </div>

        </div>
    </div>

    {{-- Submit --}}
    <div class="flex gap-3 items-center pt-2 border-t border-gray-100">
        <button type="submit" class="btn-gradient px-6 py-2.5 rounded-full text-sm font-semibold shadow-sm">
            Buscar
        </button>
        @if($searched)
        <a href="{{ route('search') }}" class="text-sm text-gray-400 hover:text-gray-600 transition-colors">Limpiar filtros</a>
        @endif
    </div>

</div>
</form>

{{-- ══ RESULTS ══════════════════════════════════════════════════════════════ --}}
@if(!$searched)
<div class="text-center py-24">
    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-5" style="background:var(--border-default);">
        <svg class="w-10 h-10 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
    </div>
    <p class="text-lg font-medium mb-1"
       style="background:var(--gradient-accent-brand);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
        Usá los filtros para encontrar companions
    </p>
    <p class="text-gray-400 text-sm">Podés buscar por servicios, características, datos adicionales y tarifas</p>
</div>

@elseif($avisos->isEmpty())
<div class="text-center py-24">
    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-5" style="background:var(--border-default);">
        <svg class="w-10 h-10 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>
    <p class="text-gray-600 text-lg font-medium mb-1">No se encontraron resultados</p>
    <p class="text-gray-400 text-sm mb-4">Probá con otros filtros o criterios de búsqueda</p>
    <a href="{{ route('search') }}" class="text-sm font-semibold transition-colors" style="color: var(--brand-primary);">Limpiar filtros</a>
</div>

@else
<div class="flex items-center justify-between mb-5">
    <p class="text-sm text-gray-500">
        <span class="font-semibold text-gray-800">{{ $avisos->total() }}</span>
        resultado{{ $avisos->total() !== 1 ? 's' : '' }} encontrado{{ $avisos->total() !== 1 ? 's' : '' }}
    </p>
</div>

<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
    @foreach($avisos as $aviso)
    @php
        $coverPhoto = $aviso->photos->first();
        $photoSrc = $aviso->cover_photo_path
            ? asset("storage/" . $aviso->cover_photo_path)
            : ($coverPhoto ? $coverPhoto->getUrl()
                : ($aviso->escortProfile?->profile_photo_path
                    ? asset("storage/" . $aviso->escortProfile->profile_photo_path)
                    : asset("images/logo.webp")));
        $name = $aviso->title ?: ($aviso->alias ?: ($aviso->escortProfile?->display_name ?? ""));
        $firstName = explode(" ", trim($name))[0];
        $rate1h     = $aviso->rates->firstWhere('duration', '1 hs. - Convencional')
                    ?? $aviso->rates->firstWhere('duration', 'Una hora (1 hs)')
                    ?? $aviso->rates->first(fn($r) => str_contains($r->duration, '1 hs'));
        $isFeatured = $aviso->is_featured;
    @endphp
    <a href="{{ route("aviso.show", $aviso->id) }}"
       class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow block border border-gray-100">

        {{-- Foto --}}
        <div class="relative overflow-hidden bg-gray-100" style="aspect-ratio:3/4;">
            @if($photoSrc)
                <img src="{{ $photoSrc }}" alt="{{ $firstName }}"
                     class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-300">
            @endif

            @if($rate1h)
            <span class="absolute bottom-2 right-2 text-white text-xs px-2 py-0.5 rounded-full font-semibold" style="background:var(--overlay-image-badge);">
                {{ $rate1h->currency ?? 'USD' }} {{ number_format($rate1h->price_usd, 0) }}/hr
            </span>
            @endif

            @if($aviso->escortProfile?->is_verified)
            <span class="absolute top-2 right-2 bg-white text-green-600 text-xs font-bold px-2 py-0.5 rounded-full shadow-sm flex items-center gap-0.5">
                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                ✓
            </span>
            @endif

            @if($isFeatured)
            <span class="absolute top-2 left-2 text-xs font-bold px-2 py-0.5 rounded-full"
                  style="background:var(--yellow-100); color:var(--yellow-800);">★</span>
            @endif
        </div>

        {{-- Info --}}
        <div class="p-2.5">
            <p class="font-bold text-gray-900 text-sm truncate">
                {{ $firstName }}@if($aviso->age), {{ $aviso->age }}@endif
            </p>
            @php $ciudad = $aviso->city_name ?: $aviso->city; @endphp
            @if($ciudad)
            <p class="text-gray-500 text-xs truncate mt-0.5">
                {{ $aviso->neighborhood ? $aviso->neighborhood.' · ':'' }}{{ $ciudad }}
            </p>
            @endif
            @if($aviso->height_cm)
            <p class="text-gray-400 text-xs mt-0.5">{{ $aviso->height_cm }} cm</p>
            @endif
        </div>
    </a>
    @endforeach
</div>

@if($avisos->hasPages())
<div class="mt-8">
    {{ $avisos->links() }}
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
