<?php

namespace App\Http\Controllers;

use App\Models\Payment;

class PaymentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('payments.index', [
            'payments' => Payment::with('customer:id,name')->latest('id')->paginate(),
        ]);
    }

    public function show(Payment $payment)
    {
        return view('payments.show', [
            'payment' => $payment,
        ]);
    }
}
