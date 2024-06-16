@extends('layouts.template')

@section('title', 'Order Tracking')

@section('content')
    <section class="masthead page-section">
        <div class="container page">
            <h1>Order Tracking</h1>

            <p>Order Status: <span id="orderStatus">Loading...</span></p>

            <ul id="serviceList"></ul>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const orderId = '{{ $orderId }}'; // Pass the order ID to JavaScript

            function fetchOrderStatus() {
                fetch(`/order-status/${orderId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('orderStatus').textContent = data.status;
                    })
                    .catch(error => {
                        console.error('Error fetching order status:', error);
                    });
            }

            // Fetch order status initially and set interval to update
            fetchOrderStatus();
            setInterval(fetchOrderStatus, 5000); // Update status every 5 seconds

            // Load selected services
            const selectedServices = $selectedServices;
            const serviceList = document.getElementById('serviceList');
            for (const [service, type] of Object.entries(selectedServices)) {
                const li = document.createElement('li');
                li.textContent = `${service}: ${type}`;
                serviceList.appendChild(li);
            }
        });
    </script>
@endsection
