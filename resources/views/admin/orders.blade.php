@extends('layouts.template')

@section('title', 'Manage Orders')
@section('extra')
<script type="module" src='{{asset("./js/admin-map.js")}}'></script>
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

        @if($orders->isEmpty())
        <p>No orders found.</p>
        @else
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Order ID</th>
                    <th>User Name</th>
                    <th>Selected Services</th>
                    <th>Status</th>
                    <th>Change Status</th>
                    <th>Map</th>
                    <th>Created at</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
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
                    <td>{{ $order->status }}</td>
                    <td>
                        <form action="{{ route('admin.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
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
                    <td>
                        <button type="button" class="btn btn-primary btn-sm open-map-button" data-bs-toggle="modal" data-bs-target="#mapModal-{{ $order->id }}" data-order-id="{{ $order->id }}" data-location="{{ json_decode(json_encode($order->user_location), true) }}">Open Map</button>


                    </td>
                    <td>{{ $order->created_at }}</td>
                </tr>

                <!-- Modal -->
                <div class="modal fade" id="mapModal-{{ $order->id }}" tabindex="-1" aria-labelledby="mapModalLabel-{{ $order->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mapModalLabel-{{ $order->id }}">Order {{ $order->id }} Location</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="map-{{ $order->id }}" style="width: 100%; height: 400px;"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</section>
@endsection