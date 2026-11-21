@extends('layouts.app')

@section('title', 'Orders')

@section('content')
    <div class="admin-heading">
        <h1>Orders</h1>
        <form class="admin-inline-form" action="{{ route('orders.index') }}" method="GET">
            <label for="order-filter">Status</label>
            <select id="order-filter" name="status">
                <option value="">All statuses</option>
                @foreach($statuses as $status => $label)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ $label }}</option>
                @endforeach
            </select>
            <button class="admin-button" type="submit">Filter</button>
        </form>
    </div>
    @if(session('status'))
        <p class="admin-notice" role="status">{{ session('status') }}</p>
    @endif
    @if(request()->filled('order'))
        <p class="admin-notice">Order #{{ request('order') }} · <a href="{{ route('orders.index') }}">View all orders</a></p>
    @endif

    <section class="admin-panel" aria-label="Customer orders">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr><th scope="col">#</th><th scope="col">Order</th><th scope="col">Customer</th><th scope="col">Products</th><th scope="col">Status</th><th scope="col">Delivery address</th><th scope="col">Placed</th><th scope="col">Update status</th></tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $orders->firstItem() + $loop->index }}</td>
                            <td>#{{ $order->id }}</td>
                            <td><a href="{{ route('customers.show', $order->customer_id) }}">{{ $order->customer->name }}</a><br>{{ $order->customer->phone }}</td>
                            <td>
                                @forelse($order->products as $product)
                                    <div>{{ $product->pivot->quantity }} × {{ $product->name }} · TZS {{ number_format($product->price, 2) }} each</div>
                                @empty
                                    —
                                @endforelse
                                @if($order->products->isNotEmpty())
                                    <strong>Current total: TZS {{ number_format($order->products->sum(fn ($product) => $product->price * $product->pivot->quantity), 2) }}</strong>
                                @endif
                            </td>
                            <td><span class="admin-status" data-status="{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                            <td>
                                @if($address = $order->shippingAddress)
                                    <div>{{ $address->contact_name }} · {{ $address->phone_number }}</div>
                                    <div>{{ implode(', ', array_filter([$address->number, $address->streetRoad?->name, $address->street?->name, $address->ward?->name, $address->district?->name, $address->region?->name])) }}</div>
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $order->created_at?->format('d M Y, H:i') ?? '—' }}</td>
                            <td>
                                <details>
                                    <summary>Change status</summary>
                                    @foreach($statuses as $status => $label)
                                        @continue($status === $order->status)
                                        <form method="POST" action="{{ route('order.update.status', ['status' => $status]) }}" class="admin-status-form">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="order" value="{{ $order->id }}">
                                            <button type="submit">{{ $label }}</button>
                                        </form>
                                    @endforeach
                                </details>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="admin-empty">No orders match this view.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
            <div class="admin-pagination">{{ $orders->links() }}</div>
        @endif
    </section>
@endsection
