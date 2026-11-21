<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function __invoke(): View
    {
        $orderCounts = Order::query()
            ->selectRaw('status, COUNT(*) AS total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('home', [
            'orderCount' => $orderCounts->sum(),
            'pendingCount' => (int) $orderCounts->get('pending', 0),
            'customerCount' => Customer::count(),
            'productCount' => Product::count(),
            'completedPaymentTotal' => Payment::where('status', 'COMPLETED')->sum('amount'),
            'orders' => Order::with('customer:id,name')->withCount('products')->latest('id')->limit(8)->get(),
        ]);
    }
}
