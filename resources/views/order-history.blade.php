@extends('layouts.template')

@section('title', 'History')
@section('extra')
    <style>
        body {
            overflow: hidden;
        }
        .footer {
            display: none;
        }
    </style>
@endsection
@section('content')
<section class="masthead page-section">
    <div class="container page">
        <h1>History</h1>

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
                        <th>Completed at</th>
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
                                {{ $order->updated_at }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</section>
@endsection
