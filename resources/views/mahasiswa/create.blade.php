@extends('layouts.template')
@section('content')
    <section class="page section portfolio" id="portfolio">
        <div class="container">
            <h1>Add student</h1>
            {{--button add--}}
            <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary mb-3">Add student</a>
        </div>
    </section>
@endsection