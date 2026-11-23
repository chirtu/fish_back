@extends('layouts.base')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('body')
    <div class="admin-shell">
        <header class="admin-sidebar">
            <div class="admin-sidebar-inner">
                <a class="admin-brand" href="{{ route('home') }}">Fish Happy</a>
                <button type="button" class="admin-menu-toggle" id="admin-menu-toggle"
                        aria-controls="admin-sidebar-menu" aria-expanded="false">
                    Menu
                </button>
                <div class="admin-sidebar-menu" id="admin-sidebar-menu">
                    <nav class="admin-nav" aria-label="Admin navigation">
                        @foreach([
                            ['home', 'home', 'Dashboard'],
                            ['orders.index', 'orders.*', 'Orders'],
                            ['products.index', 'products.*', 'Products'],
                            ['productCategories.index', 'productCategories.*', 'Categories'],
                            ['customers.index', 'customers.*', 'Customers'],
                            ['users.index', 'users.*', 'Users'],
                            ['payments.index', 'payments.*', 'Payments'],
                        ] as [$route, $pattern, $label])
                            <a href="{{ route($route) }}" @if(request()->routeIs($pattern)) aria-current="page" @endif>{{ $label }}</a>
                        @endforeach
                    </nav>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="admin-signout" type="submit">Sign out</button>
                    </form>
                </div>
            </div>
        </header>
        <main class="admin-wrap admin-main">
            @yield('content')
        </main>
    </div>
    <script>
        (() => {
            const toggle = document.getElementById('admin-menu-toggle');
            toggle.addEventListener('click', () => {
                toggle.setAttribute('aria-expanded', toggle.getAttribute('aria-expanded') === 'false');
            });
        })();
    </script>
@endsection
