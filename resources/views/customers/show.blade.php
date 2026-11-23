@extends('layouts.app')

@section('title', $customer->name)

@section('content')
    <div class="admin-heading">
        <h1>{{ $customer->name }}</h1>
        <a class="admin-button" href="{{ route('customers.index') }}">Back to customers</a>
    </div>

    <div class="admin-metrics">
        <div class="admin-metric">
            <span>Email</span>
            <a class="break-all" href="mailto:{{ $customer->email }}">{{ $customer->email }}</a>
        </div>
        <div class="admin-metric">
            <span>Phone</span>
            <a href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a>
        </div>
        <div class="admin-metric">
            <span>Total orders</span>
            <strong>{{ number_format($customer->orders_count) }}</strong>
        </div>
        <div class="admin-metric">
            <span>Customer since</span>
            <strong>{{ $customer->created_at?->format('d M Y') ?? '—' }}</strong>
        </div>
    </div>

    <section class="admin-panel mb-6" aria-labelledby="customer-orders">
        <div class="admin-panel-heading"><h2 id="customer-orders">Order history</h2></div>
        <div class="admin-table-wrap">
            <table class="admin-table" aria-labelledby="customer-orders">
                <thead>
                    <tr><th scope="col">#</th><th scope="col">Order</th><th scope="col">Products</th><th scope="col">Status</th><th scope="col">Placed</th></tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $orders->firstItem() + $loop->index }}</td>
                            <td><a href="{{ route('orders.index', ['order' => $order->id]) }}">#{{ $order->id }}</a></td>
                            <td>{{ $order->products_count }}</td>
                            <td><span class="admin-status" data-status="{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                            <td>{{ $order->created_at?->format('d M Y, H:i') ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="admin-empty">This customer has no orders yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
            <div class="admin-pagination">{{ $orders->links() }}</div>
        @endif
    </section>

    <section class="admin-panel" aria-labelledby="customer-addresses">
        <div class="admin-panel-heading"><h2 id="customer-addresses">Delivery addresses</h2></div>
        <div class="admin-table-wrap">
            <table class="admin-table" aria-labelledby="customer-addresses">
                <thead>
                    <tr><th scope="col">#</th><th scope="col">Contact</th><th scope="col">Phone</th><th scope="col">Address</th></tr>
                </thead>
                <tbody>
                    @forelse($addresses as $address)
                        <tr>
                            <td>{{ $addresses->firstItem() + $loop->index }}</td>
                            <td>
                                {{ $address->contact_name }}
                                @if($address->isDefault)
                                    <span class="admin-status">Default</span>
                                @endif
                            </td>
                            <td>{{ $address->phone_number }}</td>
                            <td>{{ implode(', ', array_filter([$address->number, $address->streetRoad?->name, $address->street?->name, $address->ward?->name, $address->district?->name, $address->region?->name], fn ($value) => filled($value))) ?: '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="admin-empty">This customer has no saved delivery addresses.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($addresses->hasPages())
            <div class="admin-pagination">{{ $addresses->links() }}</div>
        @endif
    </section>
@endsection
