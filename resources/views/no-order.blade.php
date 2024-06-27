@extends('layouts.template')

@section('title', 'No Pending Order')
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
            <h1>Tidak Ada Pesanan</h1>
            <p>You do not have any pending orders at the moment. Weird. How did you even get here?</p>
        </div>
    </section>
@endsection
