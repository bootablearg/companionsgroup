<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="var(--brand-primary)">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mi Panel') - Elite Companions</title>

    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/png" href="/favicon.png">

    {{-- Alpine.js is bundled with Livewire 3 — do NOT load it separately --}}
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if(isset($theme) && is_array($theme) && isset($theme['colors']) && count($theme['colors']) > 0)
<style>
    :root {
        @foreach($theme['colors'] as $name => $value)
        --{{ $name }}: {{ $value }};
        @endforeach
    }
</style>
@endif
    <style>
        [x-cloak] { display: none !important; }
        body { background-color: var(--page-background); color: var(--text-primary); }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--border-subtle); }
        ::-webkit-scrollbar-thumb { background: var(--scrollbar-thumb); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--brand-primary); }
        .btn-gradient {
            background: var(--gradient-accent-brand);
            color: var(--text-inverted);
            transition: opacity .2s;
        }
        .btn-gradient:hover { opacity: .9; }
        .nav-link-active {
            background: var(--border-default);
            color: var(--text-link);
            border: 1px solid var(--input-border-default);
        }
        .nav-link-inactive {
            color: var(--text-secondary);
            border: 1px solid transparent;
        }
        .nav-link-inactive:hover {
            background: var(--surface-brand-selection);
            color: var(--brand-primary);
        }
    </style>

    @stack('head')
</head>
<body class="min-h-screen antialiased" style="background:var(--page-background);"
      x-data="{ sidebarOpen: false }">

    <!-- Mobile overlay -->
    <div
        x-show="sidebarOpen"
        @click="sidebarOpen = false"
        x-cloak
        class="fixed inset-0 z-20 md:hidden"
        style="background:var(--overlay-modal-soft);"
    ></div>

    <!-- Sidebar -->
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed top-0 left-0 z-30 h-full w-64 transform transition-transform duration-200 ease-in-out md:translate-x-0"
        style="background:var(--surface-card);border-right:1px solid var(--border-default);"
    >
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between h-16 px-6" style="border-bottom:1px solid var(--border-default);">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg flex items-center justify-center btn-gradient">
                    <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                    </svg>
                </span>
                <span class="text-base font-bold tracking-tight" style="color:var(--text-primary);">Elite Companions</span>
            </a>
            <button @click="sidebarOpen = false" class="md:hidden" style="color:var(--text-muted);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- User Info -->
        <div class="px-6 py-4" style="border-bottom:1px solid var(--border-default);">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0"
                     style="background:var(--border-default);border:1px solid var(--input-border-default);">
                    <svg class="w-5 h-5" style="color: var(--brand-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    @php $kycName = auth()->user()->kycSubmission?->getRealName(); @endphp
                    <p class="text-sm font-medium truncate" style="color:var(--text-dark);">
                        {{ $kycName ?: (auth()->user()->name ?? auth()->user()->email) }}
                    </p>
                    <p class="text-xs font-medium" style="color:var(--text-brand-soft);">Modelo</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="px-4 py-4 space-y-1">
            @php
                $navItems = [
                    ['route' => 'modelo.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['route' => 'modelo.aviso.edit', 'label' => 'Mi Aviso', 'active' => 'modelo.aviso*', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                    ['route' => 'modelo.kyc', 'label' => 'Verificación KYC', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                    ['route' => 'modelo.subscription', 'label' => 'Suscripcion', 'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                    ['route' => 'modelo.notifications', 'label' => 'Notificaciones', 'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
                    ['route' => 'modelo.reviews.index', 'label' => 'Reseñas', 'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
                ];
            @endphp

            @foreach($navItems as $item)
                @php $isActive = request()->routeIs($item['active'] ?? ($item['route'] . '*')); @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ $isActive ? 'nav-link-active' : 'nav-link-inactive' }}">

                    <span class="relative flex-shrink-0">
                        <span class="w-7 h-7 rounded-lg flex items-center justify-center btn-gradient">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $item['icon'] }}"/>
                            </svg>
                        </span>
                        @if($item['route'] === 'modelo.notifications')
                            @php try { $unread = auth()->user()?->notifications()->whereNull('read_at')->count() ?? 0; } catch(\Exception $e) { $unread = 0; } @endphp
                            @if($unread > 0)
                                <span class="absolute -top-1 -right-1 w-2 h-2 rounded-full border border-white" style="background:var(--action-secondary);"></span>
                            @endif
                        @endif
                    </span>
                    <span>{{ $item['label'] }}</span>
                    @if($item['route'] === 'modelo.notifications' && ($unread ?? 0) > 0)
                        <span class="ml-auto btn-gradient text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                            {{ $unread > 9 ? '9+' : $unread }}
                        </span>
                    @endif
                </a>
            @endforeach
        </nav>

        <!-- Logout at bottom -->
        <div class="absolute bottom-0 left-0 right-0 p-4" style="border-top:1px solid var(--border-default);">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors" style="color:var(--text-muted);"
                        style="hover:background:var(--status-error-light-bg-soft);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Cerrar Sesion</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="md:pl-64 flex flex-col min-h-screen">

        <!-- Top Bar -->
        <header class="sticky top-0 z-10 h-16 flex items-center px-4 sm:px-6"
                style="background:var(--surface-card);border-bottom:1px solid var(--border-default);">
            <button
                @click="sidebarOpen = true"
                class="md:hidden mr-4" style="color:var(--text-muted);"
                aria-label="Abrir menu"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <div class="flex-1">
                <h1 class="text-base font-semibold" style="color:var(--text-dark);">@yield('page-title', 'Mi Panel')</h1>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}"
                   class="text-sm font-medium transition-colors"
                   style="color: var(--brand-primary);">
                    Ver sitio
                </a>
            </div>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 x-transition
                 class="mx-4 sm:mx-6 mt-4 px-4 py-3 rounded-xl text-sm text-green-700"
                 style="background:var(--status-success-light-bg);border:1px solid var(--status-success-light-border);">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 x-transition
                 class="mx-4 sm:mx-6 mt-4 px-4 py-3 rounded-xl text-sm text-red-600"
                 style="background:var(--status-error-light-bg-soft);border:1px solid var(--status-error-light-border);">
                {{ session('error') }}
            </div>
        @endif

        @if(session('warning'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
                 x-transition
                 class="mx-4 sm:mx-6 mt-4 px-4 py-3 rounded-xl text-sm text-flash-warning-text"
                 style="background:var(--status-pending-light-bg);border:1px solid var(--status-pending-light-border);">
                {{ session('warning') }}
            </div>
        @endif

        @if(session('info'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)"
                 x-transition
                 class="mx-4 sm:mx-6 mt-4 px-4 py-3 rounded-xl text-sm text-blue-700"
                 style="background:var(--status-info-light-bg);border:1px solid var(--status-info-light-border);">
                {{ session('info') }}
            </div>
        @endif

        <!-- Page Content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="px-4 sm:px-6 py-4" style="border-top:1px solid var(--border-default);">
            <p class="text-xs text-center" style="color:var(--text-muted);">
                &copy; {{ date('Y') }} Elite Companions. Panel exclusivo para modelos verificadas.
            </p>
        </footer>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>
