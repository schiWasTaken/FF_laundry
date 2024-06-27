<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $orders = Order::all();
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->status = $request->input('status');
            $order->save();
            return redirect()->route('admin.orders')->with('message', 'Order status updated successfully.');
        }
        return redirect()->route('admin.orders')->with('error', 'Order not found.');
    }
}
