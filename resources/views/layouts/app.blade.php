@extends('layouts.base')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('body')
    <div class="admin-shell">
        <header class="admin-header">
            <div class="admin-wrap admin-header-inner">
                <a class="admin-brand" href="{{ route('home') }}">Fish Happy</a>
                <nav class="admin-nav" aria-label="Admin navigation">
                    @foreach([
                        ['home', 'home', 'Dashboard'],
                        ['orders.index', 'orders.*', 'Orders'],
                        ['products.index', 'products.*', 'Products'],
                        ['productCategories.index', 'productCategories.*', 'Categories'],
                        ['customers.index', 'customers.*', 'Customers'],
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
        </header>
        <main class="admin-wrap admin-main">
            @yield('content')
        </main>
    </div>
@endsection
