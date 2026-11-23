<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\View\View;

class CustomersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('customers.index', [
            'customers' => Customer::withCount(['orders'])->latest()->paginate(),
        ]);
    }

    public function show(Customer $customer): View
    {
        return view('customers.show', [
            'customer' => $customer->loadCount('orders'),
            'orders' => $customer->orders()->withCount('products')->latest('id')->paginate(10, pageName: 'orders_page')->withQueryString(),
            'addresses' => Address::where('customer_id', $customer->id)
                ->with(['region', 'district', 'ward', 'street', 'streetRoad'])
                ->orderByDesc('isDefault')->latest('id')->paginate(5, pageName: 'addresses_page')->withQueryString(),
        ]);
    }
}
