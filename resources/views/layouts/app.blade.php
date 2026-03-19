<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <title>{{ $title ?? 'IBSEA | International Business and Startup Association' }}</title>
    @include('partials.head')
    @stack('styles')
</head>
@php
    $isUserRoute = request()->routeIs('user.*');
@endphp

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 font-sans antialiased">
    
    @include('partials.header')

    @if($isUserRoute)
        @include('partials.user_mobile_nav')
    @endif

    <div class="fixed top-6 right-6 z-[9999] max-w-sm w-full space-y-4">
        @if(session('error'))
            <div class="bg-red-500 text-white p-4 rounded-2xl shadow-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
                <span class="material-icons text-xl">error</span>
                <p class="text-xs font-black uppercase tracking-widest">{{ session('error') }}</p>
            </div>
        @endif
        @if(session('success'))
            <div class="bg-primary text-white p-4 rounded-2xl shadow-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-300">
                <span class="material-icons text-xl">check_circle</span>
                <p class="text-xs font-black uppercase tracking-widest">{{ session('success') }}</p>
            </div>
        @endif
    </div>

    <main>
        @yield('content')
    </main>

    @if(!$isUserRoute)
        @include('partials.footer')
    @endif

    @if(request()->is('/'))
        @include('partials.pwa_prompt')
    @endif
    @stack('scripts')
</body>
</html>
