<nav class="admin-nav" aria-label="Admin navigation">
    @foreach([
        'Overview' => [
            ['home', 'home', 'Dashboard'],
        ],
        'Store management' => [
            ['orders.index', 'orders.*', 'Orders'],
            ['products.index', 'products.*', 'Products'],
            ['productCategories.index', 'productCategories.*', 'Categories'],
            ['payments.index', 'payments.*', 'Payments'],
        ],
        'People' => [
            ['customers.index', 'customers.*', 'Customers'],
            ['users.index', 'users.*', 'Users'],
        ],
    ] as $group => $links)
        <div class="admin-nav-group">
            <p>{{ $group }}</p>
            @foreach($links as [$route, $pattern, $label])
                <a href="{{ route($route) }}" @if(request()->routeIs($pattern)) aria-current="page" @endif>{{ $label }}</a>
            @endforeach
        </div>
    @endforeach
</nav>

<form action="{{ route('logout') }}" method="POST" class="admin-sidebar-footer">
    @csrf
    <button class="admin-signout" type="submit">Sign out</button>
</form>
