<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('front.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:customers,phone',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $customerData = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];
        $customer = Customer::create($customerData);

        auth()->guard('customer')->login($customer);

        return redirect('/')->with('success', 'Welcome to the store!');
    }

    public function showLoginForm()
    {
        return view('front.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (
            auth()->guard('customer')->attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])
        ) {
            return redirect('/');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {
        auth()->guard('customer')->logout();
        return redirect('/customer/login');
    }

    public function profile()
    {
        $customer = auth()->guard('customer')->user();
        return view('front.customer.profile', compact('customer'));
    }

    public function orders()
    {
        $customer = auth()->guard('customer')->user();
        $orders = \App\Models\MarketplaceOrder::with('items')
            ->where('customer_id', $customer->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('front.customer.orders', compact('customer', 'orders'));
    }

    public function orderDetails($id)
    {
        $customer = auth()->guard('customer')->user();
        $order = \App\Models\MarketplaceOrder::with(['items.inventory'])
            ->where('id', $id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();
        return view('front.customer.order-details', compact('order'));
    }
}
