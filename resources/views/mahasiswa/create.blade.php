@extends('layouts.template')
@section('content')
    <section class="masthead">
        <div class="container">
            <h2>Add New Student</h2>
            <form method="POST" action="{{ route('mahasiswa.store') }}">
                @csrf <!-- CSRF protection -->
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </section>
    
@endsection