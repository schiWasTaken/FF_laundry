@extends('layouts.template')
@section('title')
    Home
@endsection
@section('content')
<section class="masthead page-section">
    <div class="container page">
        <h1>Destination Page</h1>

        <p>Selected Services:</p>
        <ul>
            @foreach ($selectedServices as $key => $value)
                <li>{{ $key }}: {{ $value }}</li>
            @endforeach
        </ul>
        <label class="form-label">Select Pickup Location:</label>
        @include('pick-address')
    </div>
</section>
@endsection