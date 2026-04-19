@extends('layouts.app')
@section('title', 'Error del servidor')
@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center">
        <div class="text-8xl font-black text-gray-200 mb-4">500</div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Error interno del servidor</h1>
        <p class="text-gray-500 mb-8">Algo salió mal. Nuestro equipo ya fue notificado.</p>
        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 bg-[#C09830] hover:bg-[#7A5A18] text-white font-semibold px-6 py-3 rounded-xl transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Volver al inicio
        </a>
    </div>
</div>
@endsection
