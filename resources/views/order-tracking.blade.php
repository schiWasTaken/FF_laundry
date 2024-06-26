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
                        <th>Notes</th>
                        <th>Status</th>
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
                            <td>{{ json_decode($order->notes, true) }}</td>
                            <td>{{ $order->status }}</td>
                            <td>
                                @if($order->status == 'Pending')
                                    <form action="{{ route('order.destroy', $order->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Cancel Order</button>
                                    </form>
                                @else
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
