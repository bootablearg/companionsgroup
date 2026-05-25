<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="var(--admin-body-bg)">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Elite Companions</title>

    <link rel="icon" type="image/png" href="/favicon.png">

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        body { background-color: var(--admin-body-bg); }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--admin-scrollbar-track); }
        ::-webkit-scrollbar-thumb { background: var(--text-label-dark); border-radius: 3px; }
    </style>

    @stack('head')
</head>
<body class="bg-page-background text-text-primary min-h-screen antialiased"
      x-data="{ sidebarOpen: false }">

    @php
        $isFullAccess = session('admin_access_level') === 'full';
    @endphp

    <!-- Mobile overlay -->
    <div
        x-show="sidebarOpen"
        @click="sidebarOpen = false"
        x-cloak
        class="fixed inset-0 z-20 bg-black/60 md:hidden"
    ></div>

    <!-- Sidebar -->
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed top-0 left-0 z-30 h-full w-64 bg-page-background border-r border-border-default transform transition-transform duration-200 ease-in-out md:translate-x-0 flex flex-col"
    >
        <!-- Header -->
        <div class="flex items-center justify-between h-16 px-6 border-b border-border-default flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="text-lg font-bold">
                <span class="text-rose-600">Elite</span>
                <span class="text-text-primary">Admin</span>
            </a>
            <button @click="sidebarOpen = false" class="md:hidden text-gray-500 hover:text-text-secondary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Admin Info -->
        <div class="px-6 py-4 border-b border-border-default flex-shrink-0">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-full bg-amber-900/50 border border-amber-800 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-text-primary truncate">{{ auth()->user()->email ?? 'Admin' }}</p>
                    <p class="text-xs {{ $isFullAccess ? 'text-amber-500' : 'text-gray-500' }}">
                        {{ $isFullAccess ? 'Acceso Completo' : 'Acceso Limitado' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-1">
            @php
                $navItems = [
                    ['route' => 'admin.dashboard',       'label' => 'Dashboard',    'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'requiresFull' => false],
                    ['route' => 'admin.kyc.pending',     'label' => 'Cola KYC',     'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'requiresFull' => false],
                    ['route' => 'admin.users.index',     'label' => 'Usuarios',     'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'requiresFull' => false],
                    ['route' => 'admin.avisos.index',    'label' => 'Avisos',       'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z', 'requiresFull' => false],
                    ['route' => 'admin.reviews.index',   'label' => 'Reseñas',      'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z', 'requiresFull' => false],
                    ['route' => 'admin.reports.index',   'label' => 'Reportes',     'icon' => 'M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9', 'requiresFull' => false],
                    ['route' => 'admin.payments.index',  'label' => 'Pagos',        'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z', 'requiresFull' => true],
                    ['route' => 'admin.audit.index',     'label' => 'Auditoria',    'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'requiresFull' => true],
                    ['route' => 'admin.mora.index',      'label' => 'Mora',         'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 8v1m0 4a9 9 0 110-18 9 9 0 010 18z', 'requiresFull' => false],
                    ['route' => 'admin.faq.index',       'label' => 'FAQ',          'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'requiresFull' => false],
                    ['route' => 'admin.legal.index',       'label' => 'Legal',     'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'requiresFull' => false],
                    ['route' => 'admin.service-types.index', 'label' => 'Servicios', 'icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16', 'requiresFull' => false],
                ];
            @endphp

            @foreach($navItems as $item)
                @if($item['requiresFull'] && !$isFullAccess)
                    <!-- Hidden for limited access admins -->
                @else
                    @php $isActive = request()->routeIs($item['route'] . '*'); @endphp
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center space-x-3 px-3 py-2.5 rounded-md text-sm font-medium transition-colors
                              {{ $isActive ? 'bg-status-error-light-bg/30 text-rose-400 border border-rose-900/50' : 'text-gray-400 hover:text-text-primary hover:bg-surface-secondary' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $item['icon'] }}"/>
                        </svg>
                        <span>{{ $item['label'] }}</span>
                        @if($item['requiresFull'])
                            <svg class="w-3 h-3 text-amber-600 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </a>
                @endif
            @endforeach
        </nav>

        <!-- Logout -->
        <div class="p-4 border-t border-border-default flex-shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center space-x-3 px-3 py-2.5 rounded-md text-sm font-medium text-gray-500 hover:text-nav-logout-hover-text hover:bg-status-error-light-bg/20 transition-colors">
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
        <header class="sticky top-0 z-10 bg-page-background/95 backdrop-blur-sm border-b border-border-default h-16 flex items-center px-4 sm:px-6">
            <button
                @click="sidebarOpen = true"
                class="md:hidden text-gray-400 hover:text-text-primary mr-4"
                aria-label="Abrir menu"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <div class="flex-1">
                <h1 class="text-base font-semibold text-text-primary">@yield('page-title', 'Panel de Administracion')</h1>
            </div>

            <div class="flex items-center space-x-4">
                @if(!$isFullAccess)
                    <span class="hidden sm:flex items-center space-x-1 text-xs text-amber-600 bg-amber-900/20 border border-amber-900/40 px-2 py-1 rounded">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>Acceso Limitado</span>
                    </span>
                @endif
                <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-rose-500 transition-colors">
                    Ver sitio
                </a>
            </div>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 x-transition
                 class="mx-4 sm:mx-6 mt-4 bg-green-900/50 border border-green-700 text-contact-whatsapp-text px-4 py-3 rounded-md text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 x-transition
                 class="mx-4 sm:mx-6 mt-4 bg-status-error-light-bg/50 border border-status-error-light-border text-red-200 px-4 py-3 rounded-md text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Page Content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>

        <footer class="border-t border-border-default px-4 sm:px-6 py-4">
            <p class="text-xs text-gray-700 text-center">
                &copy; {{ date('Y') }} Elite Companions Admin. Acceso restringido - Solo personal autorizado.
            </p>
        </footer>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>
