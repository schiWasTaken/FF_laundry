@extends('layouts.template')

@section('title', 'Order Tracking')

@section('content')
<section class="masthead page-section">
    <div class="container page">
        <h1>Order Tracking</h1>

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
                        <th>Selected Services</th>
                        <!-- <th>Notes</th> -->
                        <th>Status</th>
                        <th>ETA</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
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
                            <!-- <td>{{ json_decode($order->notes, true) }}</td> -->
                            <td>{{ $order->status }}</td>
                            <td>
                                @if(in_array($order->status, ['Scheduled', 'On the way']))
                                    {{ $order->eta }}
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                            <td>
                                @if($order->status == 'Requesting pickup' || $order->status == 'Scheduled')
                                    <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Cancel Order</button>
                                    </form>
                                @endif
                                @if($order->status == 'Ready')
                                    <form action="{{ route('order.requestFinished', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Request Finished Laundry</button>
                                    </form>
                                @elseif($order->status == 'Scheduling')
                                    <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Cancel Scheduling</button>
                                    </form>
                                @endif

                                @if(!in_array($order->status, ['Requesting pickup', 'Scheduled', 'On the way', 'Ready', 'Scheduling']))
                                    <span>-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</section>
@endsection
