<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminController extends Controller
{
    public function index()
    {
        // Eager load the user relationship
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.orders', compact('orders'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if ($order) {
            $order->status = $request->input('status');
            $order->save();

            return redirect()->route('admin.orders')->with('message', 'Order status updated successfully.');
        }

        return redirect()->route('admin.orders')->with('error', 'Unable to update order status.');
    }
}
