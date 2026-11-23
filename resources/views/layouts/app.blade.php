@extends('layouts.base')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
@endpush

@section('body')
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <div class="admin-sidebar-inner">
                <a class="admin-brand" href="{{ route('home') }}">Fish Happy</a>
                @include('layouts.admin-navigation')
            </div>
        </aside>

        <div class="admin-workspace">
            <header class="admin-topbar">
                <div class="admin-wrap admin-topbar-inner">
                    <button type="button" class="admin-menu-toggle" id="admin-menu-toggle"
                            aria-controls="admin-menu" aria-expanded="false" aria-haspopup="dialog">
                        <span class="admin-menu-icon" aria-hidden="true"></span>
                        Menu
                    </button>
                    <span class="admin-workspace-label">Fish Happy Admin</span>
                    <div class="admin-account">
                        <span class="admin-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr(auth('web')->user()?->name ?? 'A', 0, 1)) }}</span>
                        <span class="admin-account-name">{{ auth('web')->user()?->name }}</span>
                    </div>
                </div>
            </header>

            <main class="admin-wrap admin-main">
                @yield('content')
            </main>
        </div>
    </div>

    <dialog class="admin-drawer" id="admin-menu" aria-labelledby="admin-menu-title">
        <div class="admin-sidebar-inner">
            <div class="admin-drawer-heading">
                <h2 class="admin-brand" id="admin-menu-title">Fish Happy</h2>
                <form method="dialog">
                    <button class="admin-drawer-close" type="submit" autofocus>Close</button>
                </form>
            </div>
            @include('layouts.admin-navigation')
        </div>
    </dialog>

    <script>
        (() => {
            const toggle = document.getElementById('admin-menu-toggle');
            const drawer = document.getElementById('admin-menu');
            const desktop = window.matchMedia('(min-width: 48rem)');

            toggle.addEventListener('click', () => {
                drawer.showModal();
                toggle.setAttribute('aria-expanded', 'true');
            });
            drawer.addEventListener('close', () => toggle.setAttribute('aria-expanded', 'false'));
            drawer.addEventListener('click', (event) => {
                if (event.target === drawer) drawer.close();
            });
            desktop.addEventListener('change', (event) => {
                if (event.matches && drawer.open) drawer.close();
            });
        })();
    </script>
@endsection
