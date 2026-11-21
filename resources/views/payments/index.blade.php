@extends('layouts.app')

@section('title', 'Payments')

@section('content')
    <div class="admin-heading"><h1>Payments</h1></div>

    <section class="admin-panel" aria-label="Customer payments">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr><th scope="col">#</th><th scope="col">Order</th><th scope="col">Customer</th><th scope="col">Transaction</th><th scope="col">Amount</th><th scope="col">Status</th><th scope="col">Date</th></tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payments->firstItem() + $loop->index }}</td>
                            <td><a href="{{ route('orders.index', ['order' => $payment->order_id]) }}">#{{ $payment->order_id }}</a></td>
                            <td><a href="{{ route('customers.show', $payment->customer_id) }}">{{ $payment->customer->name }}</a></td>
                            <td>{{ $payment->transaction_id ?? $payment->tracking_id ?? '—' }}</td>
                            <td>{{ $payment->amount === null ? '—' : 'TZS '.number_format($payment->amount, 2) }}</td>
                            <td><span class="admin-status" data-status="{{ strtolower($payment->status ?? 'pending') }}">{{ ucfirst(strtolower($payment->status ?? 'pending')) }}</span></td>
                            <td>{{ $payment->created_at?->format('d M Y, H:i') ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="admin-empty">Customer payments will appear here.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($payments->hasPages())
            <div class="admin-pagination">{{ $payments->links() }}</div>
        @endif
    </section>
@endsection
