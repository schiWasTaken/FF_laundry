@extends('layouts.template')

@section('title', 'Admin Orders')

@section('content')
<section class="masthead page-section">
    <div class="container page">
        <h1>Manage Orders</h1>

        @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Selected Services</th>
                    <th>Notes</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user_id }}</td>
                        <td>
                            @php
                                $serviceNames = [];
                            @endphp

                            @foreach (json_decode($order->selected_services, true) as $key => $value)
                                @php
                                    $serviceNames[] = config('prices')[$key]['name'] . ' (' . config('prices')[$value]['name'] . ')';
                                @endphp
                            @endforeach
                            {{ implode(', ', $serviceNames) }}
                        </td>
                        <td>{{ json_decode($order->notes, true) }}</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            <form action="{{ route('admin.updateOrderStatus', $order->id) }}" method="POST">
                                @csrf
                                <select name="status" class="form-control">
                                    <option value="Requesting pickup" {{ $order->status == 'Requesting pickup' ? 'selected' : '' }}>Requesting pickup</option>
                                    <option value="Scheduled" {{ $order->status == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    <option value="On the way" {{ $order->status == 'On the way' ? 'selected' : '' }}>On the way</option>
                                    <option value="Delivering to outlet" {{ $order->status == 'Delivering to outlet' ? 'selected' : '' }}>Delivering to outlet</option>
                                    <option value="Arrived at outlet" {{ $order->status == 'Arrived at outlet' ? 'selected' : '' }}>Arrived at outlet</option>
                                    <option value="Processing clothes" {{ $order->status == 'Processing clothes' ? 'selected' : '' }}>Processing clothes</option>
                                    <option value="Ready" {{ $order->status == 'Ready' ? 'selected' : '' }}>Ready</option>
                                    <option value="Scheduling" {{ $order->status == 'Scheduling' ? 'selected' : '' }}>Scheduling</option>
                                    <option value="Returning laundry" {{ $order->status == 'Returning laundry' ? 'selected' : '' }}>Returning laundry</option>
                                    <option value="Returned" {{ $order->status == 'Returned' ? 'selected' : '' }}>Returned</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm mt-2">Update Status</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
