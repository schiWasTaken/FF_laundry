<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        // Retrieve orders for the authenticated user
        $user = Auth::user();
        $orders = $user->orders;

        return response()->json($orders);
    }

    private function calculateMinimumTotalPrice($selectedServices)
    {
        $services = config('prices');
        $totalPrice = 0;

        foreach ($selectedServices as $serviceKey => $serviceType) {
            if (isset($services[$serviceKey])) {
                // Logging to see which services and types are being processed
                Log::info("Service Key: $serviceKey, Service Type: $serviceType");

                if (isset($services[$serviceKey][$serviceType])) {
                    $service = $services[$serviceKey][$serviceType];
                    $pricePerKg = $service['price'];
                    $minKg = $service['minKg'];

                    // Logging to see the details of the service being calculated
                    Log::info("Price per Kg: $pricePerKg, Min Kg: $minKg");

                    // Calculate the price based on the minimum kilograms
                    $totalPrice += $pricePerKg * $minKg;
                } else {
                    Log::warning("Service type '$serviceType' not found for service '$serviceKey'");
                }
            } else {
                Log::warning("Service '$serviceKey' not found in services configuration");
            }
        }

        // Logging the total price calculated
        Log::info("Total Price: $totalPrice");

        return $totalPrice;
    }


    public function store(Request $request)
    {
        $user = Auth::user();

        // Validate request data
        $validatedData = $request->validate([
            'selected_services' => 'required|string|max:255',
            'user_location' => 'required|string|max:255',
        ]);
        $selectedServices = json_decode($validatedData['selected_services'], true);
        $totalPrice = $this->calculateMinimumTotalPrice($selectedServices);
        // Create new order
        $order = new Order();
        $order->selected_services = json_encode($selectedServices);
        $order->status = 'Pending';
        $order->user_location = $validatedData['user_location'];
        $order->minimum_total_price = $totalPrice;
        $order->user_id = Auth::id();
        Log::info("Order Data: " . json_encode($order->toArray()));
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
