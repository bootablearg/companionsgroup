@extends('layouts.app')

@section('title', 'Buscar Modelos')

@section('page_style')
.filter-label { font-size:.75rem; font-weight:600; text-transform:uppercase; letter-spacing:.05em; color:#6B7280; margin-bottom:.25rem; display:block; }
.filter-select { width:100%; padding:.5rem .75rem; border:1px solid #E5E7EB; border-radius:.75rem; font-size:.875rem; background:#fff; color:#111827; }
.filter-select:focus { outline:none; border-color:#7C3AED; box-shadow:0 0 0 3px rgba(124,58,237,.1); }
.filter-input { width:100%; padding:.5rem .75rem; border:1px solid #E5E7EB; border-radius:.75rem; font-size:.875rem; background:#fff; color:#111827; }
.filter-input:focus { outline:none; border-color:#7C3AED; box-shadow:0 0 0 3px rgba(124,58,237,.1); }
.active-filter { display:inline-flex; align-items:center; gap:.35rem; padding:.2rem .65rem; background:#EDE9FE; color:#5B21B6; border-radius:9999px; font-size:.75rem; font-weight:600; }
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Buscar modelos</h1>
        <p class="text-sm text-gray-500 mt-1">
            {{ $results->total() }} {{ $results->total() === 1 ? 'resultado' : 'resultados' }} encontrados
        </p>
    </div>

    {{-- Active filters --}}
    @if(count($filters) > 0)
    <div class="flex flex-wrap gap-2 mb-5">
        @foreach($filters as $key => $value)
            @if($key !== 'sort_by')
            <span class="active-filter">
                {{ str_replace('_', ' ', $key) }}: {{ is_array($value) ? implode(', ', $value) : $value }}
                <a href="{{ request()->fullUrlWithQuery([$key => null]) }}" class="ml-1 text-violet-400 hover:text-violet-700">×</a>
            </span>
            @endif
        @endforeach
        <a href="{{ route('search') }}" class="active-filter" style="background:#FEE2E2;color:#991B1B;">
            Limpiar filtros ×
        </a>
    </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-6">

        {{-- ============================================================ --}}
        {{-- SIDEBAR FILTROS --}}
        {{-- ============================================================ --}}
        <aside class="w-full lg:w-72 flex-shrink-0">
            <form method="GET" action="{{ route('search') }}" id="searchForm">

                {{-- Buscador texto --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-4">
                    <label class="filter-label">Buscar</label>
                    <div class="relative">
                        <input type="text" name="q" value="{{ $filters['q'] ?? '' }}"
                               placeholder="Nombre, descripción..."
                               class="filter-input pr-9">
                        <button type="submit" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-violet-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Ordenar --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-4">
                    <label class="filter-label">Ordenar por</label>
                    <select name="sort_by" class="filter-select" onchange="this.form.submit()">
                        @foreach($filterOptions['sort_options'] as $val => $label)
                            <option value="{{ $val }}" {{ ($filters['sort_by'] ?? 'recent') === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Ubicación --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-4 space-y-3">
                    <p class="text-xs font-bold text-gray-700 uppercase tracking-wider">Ubicación</p>

                    <div>
                        <label class="filter-label">Provincia</label>
                        <select name="province" class="filter-select">
                            <option value="">Todas</option>
                            @foreach($provinces as $prov)
                                <option value="{{ $prov }}" {{ ($filters['province'] ?? '') === $prov ? 'selected' : '' }}>
                                    {{ $prov }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="filter-label">Ciudad</label>
                        <input type="text" name="city" value="{{ $filters['city'] ?? '' }}"
                               placeholder="Ej: Buenos Aires" class="filter-input">
                    </div>

                    <div>
                        <label class="filter-label">Barrio</label>
                        <input type="text" name="neighborhood" value="{{ $filters['neighborhood'] ?? '' }}"
                               placeholder="Ej: Palermo" class="filter-input">
                    </div>
                </div>

                {{-- Perfil --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-4 space-y-3">
                    <p class="text-xs font-bold text-gray-700 uppercase tracking-wider">Perfil</p>

                    <div>
                        <label class="filter-label">Género</label>
                        <select name="gender" class="filter-select">
                            <option value="">Todos</option>
                            @foreach($filterOptions['genders'] as $val => $label)
                                <option value="{{ $val }}" {{ ($filters['gender'] ?? '') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="filter-label">Orientación sexual</label>
                        <select name="sexual_orientation" class="filter-select">
                            <option value="">Cualquiera</option>
                            @foreach($filterOptions['sexual_orientations'] as $val => $label)
                                <option value="{{ $val }}" {{ ($filters['sexual_orientation'] ?? '') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="filter-label">Edad mín.</label>
                            <input type="number" name="age_min" value="{{ $filters['age_min'] ?? '' }}"
                                   min="18" max="80" placeholder="18" class="filter-input">
                        </div>
                        <div>
                            <label class="filter-label">Edad máx.</label>
                            <input type="number" name="age_max" value="{{ $filters['age_max'] ?? '' }}"
                                   min="18" max="80" placeholder="80" class="filter-input">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="filter-label">Alt. mín. (cm)</label>
                            <input type="number" name="height_min" value="{{ $filters['height_min'] ?? '' }}"
                                   min="140" max="210" placeholder="150" class="filter-input">
                        </div>
                        <div>
                            <label class="filter-label">Alt. máx. (cm)</label>
                            <input type="number" name="height_max" value="{{ $filters['height_max'] ?? '' }}"
                                   min="140" max="210" placeholder="190" class="filter-input">
                        </div>
                    </div>
                </div>

                {{-- Apariencia --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-4 space-y-3">
                    <p class="text-xs font-bold text-gray-700 uppercase tracking-wider">Apariencia</p>

                    <div>
                        <label class="filter-label">Color de cabello</label>
                        <select name="hair_color" class="filter-select">
                            <option value="">Cualquiera</option>
                            @foreach($filterOptions['hair_colors'] as $val => $label)
                                <option value="{{ $val }}" {{ ($filters['hair_color'] ?? '') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="filter-label">Color de ojos</label>
                        <select name="eye_color" class="filter-select">
                            <option value="">Cualquiera</option>
                            @foreach($filterOptions['eye_colors'] as $val => $label)
                                <option value="{{ $val }}" {{ ($filters['eye_color'] ?? '') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="filter-label">Tono de piel</label>
                        <select name="skin_color" class="filter-select">
                            <option value="">Cualquiera</option>
                            @foreach($filterOptions['skin_colors'] as $val => $label)
                                <option value="{{ $val }}" {{ ($filters['skin_color'] ?? '') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Precio --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-4 space-y-3">
                    <p class="text-xs font-bold text-gray-700 uppercase tracking-wider">Tarifa (USD)</p>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="filter-label">Mín.</label>
                            <input type="number" name="rate_min" value="{{ $filters['rate_min'] ?? '' }}"
                                   min="0" placeholder="0" class="filter-input">
                        </div>
                        <div>
                            <label class="filter-label">Máx.</label>
                            <input type="number" name="rate_max" value="{{ $filters['rate_max'] ?? '' }}"
                                   min="0" placeholder="999" class="filter-input">
                        </div>
                    </div>
                </div>

                {{-- Características --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-4 space-y-2">
                    <p class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">Características</p>
                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input type="checkbox" name="is_waxed" value="1"
                               {{ isset($filters['is_waxed']) ? 'checked' : '' }}
                               class="rounded text-violet-600">
                        Depilada
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input type="checkbox" name="is_smoker" value="1"
                               {{ isset($filters['is_smoker']) ? 'checked' : '' }}
                               class="rounded text-violet-600">
                        Fumadora
                    </label>
                </div>

                {{-- Servicios --}}
                @if($serviceTypes->isNotEmpty())
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-4">
                    <p class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">Servicios</p>
                    <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                        @foreach($serviceTypes as $st)
                        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                            <input type="checkbox" name="service_types[]" value="{{ $st->id }}"
                                   {{ in_array($st->id, (array)($filters['service_types'] ?? [])) ? 'checked' : '' }}
                                   class="rounded text-violet-600">
                            {{ $st->name }}
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Botones --}}
                <div class="flex gap-2">
                    <button type="submit"
                            class="btn-gradient flex-1 text-white text-sm font-semibold py-2.5 rounded-xl">
                        Aplicar filtros
                    </button>
                    <a href="{{ route('search') }}"
                       class="flex-1 text-center text-sm font-semibold py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 transition">
                        Limpiar
                    </a>
                </div>

            </form>
        </aside>

        {{-- ============================================================ --}}
        {{-- RESULTADOS --}}
        {{-- ============================================================ --}}
        <div class="flex-1 min-w-0">

            @if($results->isEmpty())
                <div class="flex flex-col items-center justify-center py-24 text-center">
                    <div class="w-16 h-16 bg-violet-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-violet-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-1">Sin resultados</h3>
                    <p class="text-sm text-gray-400 mb-5">No encontramos modelos con esos filtros.</p>
                    <a href="{{ route('search') }}"
                       class="btn-gradient text-white text-sm font-semibold px-6 py-2.5 rounded-xl">
                        Ver todos los perfiles
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                    @foreach($results as $aviso)
                        <x-aviso-card :aviso="$aviso" />
                    @endforeach
                </div>

                {{-- Paginación --}}
                @if($results->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $results->appends($filters)->links() }}
                </div>
                @endif
            @endif

        </div>
    </div>
</div>
@endsection
