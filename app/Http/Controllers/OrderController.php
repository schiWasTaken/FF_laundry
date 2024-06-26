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
        try {
            $user = Auth::user();

            // Validate request data
            $validatedData = $request->validate([
                'selected_services' => 'required|string|max:255',
                'user_location' => 'required|string|max:255',
                'notes' => 'string|max:255',
            ]);

            $selectedServices = json_decode($validatedData['selected_services'], true);
            $notes = json_decode($validatedData['notes'], true);
            $totalPrice = $this->calculateMinimumTotalPrice($selectedServices);

            // Create new order
            $order = new Order();
            $order->selected_services = json_encode($selectedServices);
            $order->status = 'Pending';
            $order->user_location = $validatedData['user_location'];
            $order->notes = json_encode($notes);
            $order->minimum_total_price = $totalPrice;
            $order->user_id = Auth::id();
            Log::info("Order Data: " . json_encode($order->toArray()));
            $order->user()->associate($user);
            $order->save();

            return redirect()->route('order.tracking');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Catch validation errors and redirect back with errors
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Error storing order: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }


    public function getOrderStatus($orderId)
    {
        $order = Order::findOrFail($orderId);
        return response()->json(['status' => $order->status]);
    }

    public function updateOrderStatus($orderId, Request $request)
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => $request->status]);

        return response()->json(['message' => 'Order status updated successfully']);
    }

    public function getUserOrder()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->where('status', '!=', 'Returned')->get();

        if ($orders) {
            return view('order-tracking', [
                'orders' => $orders
            ]);
        }
        else {
            return redirect()->route('order.tracking')->with('error', 'A weird error occurred.');
        }
    }

    public function destroy($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Check if the order is pending
        if ($order->status == 'Pending') {
            $order->delete();
            return redirect()->route('order.tracking')->with('message', 'Order canceled successfully.');
        }

        return redirect()->route('order.tracking')->with('error', 'Only pending orders can be canceled.');
    }
}
