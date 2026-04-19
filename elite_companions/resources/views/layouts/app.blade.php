<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#7C3AED">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Elite Companions - Argentina')</title>
    @if(app()->environment('production'))
    <meta name="robots" content="index, follow">
    @else
    <meta name="robots" content="noindex, nofollow">
    @endif
    <meta name="description" content="@yield('meta_description', 'Elite Companions Argentina — Plataforma premium de compañía para eventos exclusivos, galas y networking social de alto perfil.')">
    <meta name="keywords" content="@yield('meta_keywords', 'eventos exclusivos buenos aires, acompañamiento elegante, galas, cenas formales, presencia elegante, etiqueta moderna argentina, acompañantes para galas, networking social, experiencias premium')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Open Graph -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', 'Elite Companions - Argentina')">
    <meta property="og:description" content="@yield('og_description', 'Plataforma premium de compañía para eventos exclusivos, galas y networking social.')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:image" content="@yield('og_image', asset('images/logo.webp'))">
    <meta property="og:site_name" content="Elite Companions">
    <meta property="og:locale" content="es_AR">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'Elite Companions - Argentina')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Elegancia y presencia para eventos exclusivos.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/logo.webp'))">

    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">

    @livewireStyles

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        body { background-color: #F7F5FF; color: #111827; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #F3F0FF; }
        ::-webkit-scrollbar-thumb { background: #C4B5FD; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #7C3AED; }
        .btn-gradient {
            background: linear-gradient(135deg, #7C3AED, #EC4899);
            color: #fff;
            transition: opacity .2s;
        }
        .btn-gradient:hover { opacity: .9; }
        /* Navbar responsive — avoids Tailwind CDN missing rules */
        .nav-desktop { display: inline-block; }
        .nav-mobile-toggle { display: none; }
        .nav-mobile-panel { display: none; }
        @media (max-width: 767px) {
            .nav-desktop { display: none; }
            .nav-mobile-toggle { display: block; }
            .nav-mobile-panel.nav-mobile-open { display: block; }
        }
        @yield('page_style')
    </style>

    @stack('head')
    @stack('json_ld')
</head>
<body class="min-h-screen flex flex-col antialiased" style="background:#F7F5FF;">

    <!-- Cookie Banner -->
    <x-cookie-banner />

    <!-- Navigation -->
    <header class="sticky top-0 z-50 bg-white shadow-sm">
        <nav class="w-full px-3">
            <div class="flex items-center justify-between h-16">

                <!-- Left: Buscar modelo + Listado buttons -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('search') }}"
                       class="btn-gradient nav-desktop text-white text-sm font-semibold px-5 py-2 rounded-full shadow-sm">
                        Buscar modelo
                    </a>
                    <a href="{{ route('modelos.index') }}"
                       class="btn-gradient nav-desktop text-white text-sm font-semibold px-5 py-2 rounded-full shadow-sm">
                        Listado de Modelos
                    </a>
                </div>

                <!-- Center: Logo text only -->
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                    <span style="display:inline;font-size:1.44rem;font-weight:800;letter-spacing:-.025em;background:linear-gradient(135deg,#7C3AED,#EC4899);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                        Elite Companions
                    </span>
                </a>

                <!-- Right: Auth Buttons -->
                <div class="flex items-center gap-2">
                    @auth
                        @if(auth()->user()->role === 'modelo')
                            <a href="{{ route('modelo.dashboard') }}"
                               class="btn-gradient nav-desktop text-white text-sm font-semibold px-5 py-2 rounded-full shadow-sm">
                                Mi Panel
                            </a>
                        @elseif(auth()->user()->role === 'subscriber')
                            <a href="{{ route('subscriber.dashboard') }}"
                               class="btn-gradient nav-desktop text-white text-sm font-semibold px-5 py-2 rounded-full shadow-sm">
                                Mi Panel
                            </a>
                        @elseif(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                               class="btn-gradient nav-desktop text-white text-sm font-semibold px-5 py-2 rounded-full shadow-sm">
                                Admin
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                    class="btn-gradient nav-desktop text-white text-sm font-semibold px-5 py-2 rounded-full shadow-sm">
                                Salir
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                           class="btn-gradient nav-desktop text-white text-sm font-semibold px-5 py-2 rounded-full shadow-sm">
                            Iniciar sesión
                        </a>
                        <a href="{{ route('register') }}"
                           class="btn-gradient nav-desktop text-white text-sm font-semibold px-5 py-2 rounded-full shadow-sm">
                            Hacete miembro
                        </a>
                    @endauth

                    <!-- Mobile menu button -->
                    <button class="nav-mobile-toggle text-gray-500 hover:text-gray-700 p-1.5"
                            onclick="this.closest('nav').querySelector('.nav-mobile-panel').classList.toggle('nav-mobile-open')"
                            aria-label="Menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Nav -->
            <div class="nav-mobile-panel pb-3 border-t border-gray-100 pt-2">
                <div class="flex flex-col gap-2 px-1">
                    <a href="{{ route('search') }}"
                       class="btn-gradient text-white text-sm font-semibold px-5 py-2.5 rounded-full text-center shadow-sm">
                        Buscar modelo
                    </a>
                    <a href="{{ route('modelos.index') }}"
                       class="btn-gradient text-white text-sm font-semibold px-5 py-2.5 rounded-full text-center shadow-sm">
                        Listado de Modelos
                    </a>
                    @auth
                        @if(auth()->user()->role === 'modelo')
                            <a href="{{ route('modelo.dashboard') }}"
                               class="btn-gradient text-white text-sm font-semibold px-5 py-2.5 rounded-full text-center shadow-sm">
                                Mi Panel
                            </a>
                        @elseif(auth()->user()->role === 'subscriber')
                            <a href="{{ route('subscriber.dashboard') }}"
                               class="btn-gradient text-white text-sm font-semibold px-5 py-2.5 rounded-full text-center shadow-sm">
                                Mi Panel
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full btn-gradient text-white text-sm font-semibold px-5 py-2.5 rounded-full text-center shadow-sm">
                                Salir
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                           class="btn-gradient text-white text-sm font-semibold px-5 py-2.5 rounded-full text-center shadow-sm">
                            Iniciar sesión
                        </a>
                        <a href="{{ route('register') }}"
                           class="btn-gradient text-white text-sm font-semibold px-5 py-2.5 rounded-full text-center shadow-sm">
                            Hacete miembro
                        </a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <!-- Flash Messages -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             class="fixed top-20 right-4 z-50 bg-white border border-green-200 text-green-700 px-5 py-3 rounded-xl text-sm shadow-lg flex items-center gap-2">
            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-20 right-4 z-50 bg-white border border-red-200 text-red-600 px-5 py-3 rounded-xl text-sm shadow-lg flex items-center gap-2">
            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Brand -->
                <div>
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 mb-3">
                        <img src="/images/logo.webp" alt="Elite Companions" style="height:72px;width:auto;border-radius:50%;">
                        <span class="font-extrabold tracking-tight"
                              style="font-size:1.2rem;background:linear-gradient(135deg,#7C3AED,#EC4899);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                            Elite Companions
                        </span>
                    </a>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Plataforma de compañía premium para adultos mayores de 18 años.
                    </p>
                </div>

                <!-- Legal -->
                <div>
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Legal</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('terms') }}" class="text-sm text-gray-500 hover:text-violet-600 transition-colors">Términos y Condiciones</a></li>
                        <li><a href="{{ route('privacy') }}" class="text-sm text-gray-500 hover:text-violet-600 transition-colors">Política de Privacidad</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-violet-600 transition-colors">Política de Cookies</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Soporte</h3>
                    <ul class="space-y-2 mb-5">
                        <li><a href="{{ route('faq') }}" class="text-sm text-gray-500 hover:text-violet-600 transition-colors">Preguntas Frecuentes</a></li>
                        <li><a href="{{ route('support') }}" class="text-sm text-gray-500 hover:text-violet-600 transition-colors">Soporte</a></li>
                    </ul>
                    <!-- Contact channels -->
                    <div class="flex flex-col gap-2">
                        {{-- WhatsApp Soporte --}}
                        <a href="https://wa.me/541166300119" target="_blank" rel="noopener"
                           class="flex items-center gap-2 text-xs text-gray-500 transition-colors"
                           onmouseover="this.style.color='#25D366'" onmouseout="this.style.color=''">
                            <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#25D366" d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.978-1.405A9.953 9.953 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"/>
                                <path fill="#ffffff" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                            </svg>
                            <span>Soporte por WhatsApp</span>
                        </a>
                        {{-- WhatsApp Bot --}}
                        <a href="https://wa.me/541125545289" target="_blank" rel="noopener"
                           class="flex items-center gap-2 text-xs text-gray-500 transition-colors"
                           onmouseover="this.style.color='#25D366'" onmouseout="this.style.color=''">
                            <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#25D366" d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.978-1.405A9.953 9.953 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"/>
                                <path fill="#ffffff" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                            </svg>
                            <span>WhatsApp Bot</span>
                        </a>
                        {{-- WhatsApp Grupo --}}
                        <a href="https://chat.whatsapp.com/LdjpbC0cFpgF3wxavOjtyN?mode=gi_t" target="_blank" rel="noopener"
                           class="flex items-center gap-2 text-xs text-gray-500 transition-colors"
                           onmouseover="this.style.color='#25D366'" onmouseout="this.style.color=''">
                            <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#25D366" d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.978-1.405A9.953 9.953 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"/>
                                <path fill="#ffffff" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                            </svg>
                            <span>Grupo de WhatsApp</span>
                        </a>
                        {{-- WhatsApp Canal --}}
                        <a href="https://whatsapp.com/channel/0029Vb7xkd8LCoX5ALVXQI3X" target="_blank" rel="noopener"
                           class="flex items-center gap-2 text-xs text-gray-500 transition-colors"
                           onmouseover="this.style.color='#25D366'" onmouseout="this.style.color=''">
                            <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#25D366" d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.978-1.405A9.953 9.953 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"/>
                                <path fill="#ffffff" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                            </svg>
                            <span>Canal de WhatsApp</span>
                        </a>
                        {{-- Telegram Soporte --}}
                        <a href="https://t.me/elitecompanionsarg" target="_blank" rel="noopener"
                           class="flex items-center gap-2 text-xs text-gray-500 transition-colors"
                           onmouseover="this.style.color='#229ED9'" onmouseout="this.style.color=''">
                            <svg style="color:#229ED9" class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.944 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0a12 12 0 00-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 01.171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                            </svg>
                            <span>Soporte por Telegram</span>
                        </a>
                        {{-- Telegram Bot --}}
                        <a href="https://t.me/elitecompanionsarg_bot" target="_blank" rel="noopener"
                           class="flex items-center gap-2 text-xs text-gray-500 transition-colors"
                           onmouseover="this.style.color='#229ED9'" onmouseout="this.style.color=''">
                            <svg style="color:#229ED9" class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.944 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0a12 12 0 00-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 01.171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                            </svg>
                            <span>Telegram Bot</span>
                        </a>
                        {{-- Telegram Grupo --}}
                        <a href="https://t.me/+nISG7CVO29JmYWEx" target="_blank" rel="noopener"
                           class="flex items-center gap-2 text-xs text-gray-500 transition-colors"
                           onmouseover="this.style.color='#229ED9'" onmouseout="this.style.color=''">
                            <svg style="color:#229ED9" class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.944 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0a12 12 0 00-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 01.171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                            </svg>
                            <span>Grupo de Telegram</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-xs text-gray-400">
                    &copy; {{ date('Y') }} Elite Companions. Todos los derechos reservados. Solo para mayores de 18 años.
                </p>
                <p class="text-xs text-gray-400">
                    Al utilizar este sitio, confirmas tener 18 años o más.
                </p>
            </div>
        </div>
    </footer>

    @livewireScripts

    <!-- Service Worker -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').catch(function(){});
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
