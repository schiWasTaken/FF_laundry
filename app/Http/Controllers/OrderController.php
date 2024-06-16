<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Retrieve orders for the authenticated user
        $user = Auth::user();
        $orders = $user->orders;

        return response()->json($orders);
    }

    
    public function store(Request $request)
    {
        // Assuming selected services data is sent via POST request
        $data = $request->all();
        $user = Auth::user();

        // Create a new order with the selected services
        $order = new Order([
            'selected_services' => json_encode($data),
            'status' => 'Pending',
            // Other fields from the request or defaults
        ]);
        $order->user()->associate($user);
        $order->save();

        // Return the order ID to be used for tracking
        return response()->json(['message' => 'Selected services saved successfully', 'order_id' => $order->id]);
    }

    public function updateOrderStatus($orderId, Request $request)
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => $request->status]);

        return response()->json(['message' => 'Order status updated successfully']);
    }

    public function getOrderStatus($orderId)
    {
        $order = Order::findOrFail($orderId);

        return response()->json(['status' => $order->status]);
    }
}
