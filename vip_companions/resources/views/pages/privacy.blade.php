@extends('layouts.app')

@section('title', 'Política de Privacidad — VIP Companions Argentina')
@section('meta_description', 'Política de privacidad de VIP Companions. Conocé cómo protegemos tus datos personales y garantizamos la discreción en nuestra plataforma profesional.')
@section('canonical', 'https://vipcompanions.cc/privacidad')

@section('page_style')
body { background-color: #160E06 !important; }
.ec-card {
    border: 2px solid transparent;
    background: linear-gradient(#2C1C0E, #2C1C0E) padding-box,
                linear-gradient(135deg, #C8A235 0%, #C8A235 100%) border-box;
}
.ec-gradient-text {
    background: linear-gradient(135deg, #C8A235, #E8BE50);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.ec-section-title {
    background: linear-gradient(135deg, #C8A235, #E8BE50);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4" style="padding-top:40px;padding-bottom:40px;">

    <div class="mb-8">
        <h1 class="text-3xl ec-gradient-text" style="display:inline-block;">{{ $page->title ?? 'Política de Privacidad' }}</h1>
        <p class="text-sm mt-2" style="color:#8A6848;">Última actualización: {{ $page?->updated_at?->format('d/m/Y') ?? 'Enero de 2026' }}</p>
    </div>

    <div class="ec-card rounded-2xl shadow-sm p-8 space-y-8 leading-relaxed text-sm" style="color:#F5EDD8;">

        {!! $page->content ?? '' !!}
    </div>
</div>
@endsection
