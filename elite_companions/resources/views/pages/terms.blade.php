@extends('layouts.app')

@section('title', 'Términos y Condiciones — Elite Companions Argentina')
@section('meta_description', 'Términos y condiciones de uso de Elite Companions Argentina. Plataforma de compañía premium para adultos mayores de 18 años.')
@section('canonical', 'https://elitecompanions.cc/terminos')

@section('page_style')
body { background-color: #F7F5FF !important; }
.ec-card {
    border: 2px solid transparent;
    background: linear-gradient(#fff, #fff) padding-box,
                linear-gradient(135deg, #C4B5FD 0%, #F9A8D4 100%) border-box;
}
.ec-gradient-text {
    background: linear-gradient(135deg, #7C3AED, #EC4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.ec-section-title {
    background: linear-gradient(135deg, #7C3AED, #EC4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4" style="padding-top:40px;padding-bottom:40px;">

    <div class="mb-8">
        <h1 class="text-3xl ec-gradient-text" style="display:inline-block;">{{ $page->title ?? 'Términos y Condiciones' }}</h1>
        <p class="text-sm text-gray-400 mt-2">Última actualización: {{ $page?->updated_at?->format('d/m/Y') ?? 'Enero de 2026' }}</p>
    </div>

    <div class="ec-card rounded-2xl shadow-sm p-8 space-y-8 text-gray-700 leading-relaxed text-sm">

        {!! $page->content ?? '' !!}
    </div>
</div>
@endsection
