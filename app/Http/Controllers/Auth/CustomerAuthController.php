<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CustomerAuthController extends Controller
{
    public function register(Request $request): RedirectResponse
    {
        $validator = Customer::validate($request->only('name', 'email', 'phone', 'password', 'password_confirmation'));
        $validator->addRules(['password' => ['confirmed']]);
        $customer = Customer::create($validator->validate());

        Auth::guard('customer')->login($customer);

        return redirect()->route('customer.account');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);
        $customer = Customer::where('email', $credentials['email'])->first();

        if (! $customer || ! Hash::check($credentials['password'], $customer->password)) {
            throw ValidationException::withMessages(['email' => __('auth.failed')]);
        }

        Auth::guard('customer')->login($customer);

        return redirect()->route('customer.account');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('customer')->logout();
        $request->session()->regenerate(true);

        return redirect()->route('customer.login');
    }
}
