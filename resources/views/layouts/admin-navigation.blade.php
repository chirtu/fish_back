<nav class="admin-nav" aria-label="Admin navigation">
    @foreach([
        ['home', 'home', 'Dashboard'],
        ['orders.index', 'orders.*', 'Orders'],
        ['products.index', 'products.*', 'Products'],
        ['productCategories.index', 'productCategories.*', 'Categories'],
        ['payments.index', 'payments.*', 'Payments'],
        ['customers.index', 'customers.*', 'Customers'],
        ['users.index', 'users.*', 'Users'],
    ] as [$route, $pattern, $label])
        <a href="{{ route($route) }}" @if(request()->routeIs($pattern)) aria-current="page" @endif>{{ $label }}</a>
    @endforeach
</nav>

<form action="{{ route('logout') }}" method="POST" class="admin-sidebar-footer">
    @csrf
    <button class="admin-signout" type="submit">Sign out</button>
</form>
