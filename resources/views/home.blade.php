@extends('layouts.app')

@section('title', 'Admin dashboard')

@section('content')
    <div class="admin-heading">
        <h1>Admin dashboard</h1>
        <a class="admin-button" href="{{ route('products.create') }}">Add product</a>
    </div>

    <div class="admin-metrics">
        <a class="admin-metric admin-metric-priority" href="{{ route('orders.index', ['status' => 'pending']) }}">
            <span>Pending orders</span>
            <strong>{{ number_format($pendingCount) }}</strong>
        </a>
        <a class="admin-metric" href="{{ route('orders.index') }}">
            <span>Total orders</span>
            <strong>{{ number_format($orderCount) }}</strong>
        </a>
        <a class="admin-metric" href="{{ route('products.index') }}">
            <span>Products</span>
            <strong>{{ number_format($productCount) }}</strong>
        </a>
        <a class="admin-metric" href="{{ route('customers.index') }}">
            <span>Customers</span>
            <strong>{{ number_format($customerCount) }}</strong>
        </a>
        <a class="admin-metric" href="{{ route('payments.index') }}">
            <span>Completed payments</span>
            <strong><small>TZS</small> {{ number_format($completedPaymentTotal, 2) }}</strong>
        </a>
    </div>

    <section class="admin-panel" aria-labelledby="recent-orders">
        <div class="admin-panel-heading">
            <h2 id="recent-orders">Recent orders</h2>
            <a href="{{ route('orders.index') }}">View all orders</a>
        </div>
        <div class="admin-table-wrap">
            <table class="admin-table" aria-labelledby="recent-orders">
                <thead>
                    <tr><th scope="col">#</th><th scope="col">Order</th><th scope="col">Customer</th><th scope="col">Products</th><th scope="col">Status</th><th scope="col">Placed</th></tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="{{ route('orders.index', ['order' => $order->id]) }}">#{{ $order->id }}</a></td>
                            <td><a href="{{ route('customers.show', $order->customer_id) }}">{{ $order->customer->name }}</a></td>
                            <td>{{ number_format($order->products_count) }}</td>
                            <td><span class="admin-status" data-status="{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                            <td>{{ $order->created_at?->format('d M Y, H:i') ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="admin-empty">Customer orders will appear here.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
