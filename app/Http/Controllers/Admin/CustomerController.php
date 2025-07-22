<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('admin.customer.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        return view('admin.customer.show', compact('customer'));
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('admin.customer.index')->with('success', 'Customer deleted successfully.');
    }
}
