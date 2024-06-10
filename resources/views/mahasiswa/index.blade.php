@extends('layouts.template')
@section('content')
    <section class="masthead page section portfolio" id="portfolio">
        <div class="container">
            <h1>List of students</h1>
            <div class="container">
                {{--button add--}}
                <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary mb-3">Add student</a>
            </div>            
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mahasiswa as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->phone }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection