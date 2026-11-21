<?php

namespace App\Http\Controllers;

use App\Helper\FirebaseHelper;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrdersController extends Controller
{
    use FirebaseHelper;

    public function __construct()
    {
        $this->middleware('auth');
    }

    private const STATUSES = [
        'pending' => 'Pending',
        'confirmed' => 'Confirmed',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];

    public function index(Request $request): View
    {
        $filters = $request->validate([
            'order' => ['nullable', 'integer', 'min:1'],
            'status' => ['nullable', Rule::in(array_keys(self::STATUSES))],
        ]);
        $orders = Order::with([
            'customer:id,name,phone', 'products',
            'shippingAddress.region', 'shippingAddress.district', 'shippingAddress.ward',
            'shippingAddress.street', 'shippingAddress.streetRoad',
        ])
            ->when($filters['order'] ?? null, fn ($query, $id) => $query->whereKey($id))
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->latest('id')
            ->paginate()
            ->withQueryString();

        return view('orders.index', ['orders' => $orders, 'statuses' => self::STATUSES]);
    }

    public function show(Order $order)
    {
        return view('orders.show', [
            'order' => $order,
        ]);
    }

    public function updateStatus(Request $request)
    {
        $data = $request->validate(['order' => ['required', 'integer', 'exists:orders,id']]);
        $status = $request->route('status');
        abort_unless(array_key_exists($status, self::STATUSES), 422);
        $order = Order::findOrFail($data['order']);
        $order->status = $status;

        if ($status === 'confirmed') {
            $order->confirmed_at ??= now();
        }

        if ($status === 'completed') {
            $order->delivered_at ??= now();
        }

        $order->save();

        $device = Customer::whereKey($order->customer_id)->value('device_id');
        $this->pushNotification([$device], [
            'title' => 'Order updated',
            'body' => 'Order #'.$order->id.' is now '.strtolower(self::STATUSES[$status]).'.',
        ]);

        return redirect()->route('orders.index', ['order' => $order->id])->with('status', 'Order status updated.');
    }
}
