<!-- resources/views/destination-page.blade.php -->

<h1>Destination Page</h1>

<p>Selected Services:</p>
<ul>
    @foreach ($selectedServices as $key => $value)
        <li>{{ $key }}: {{ $value }}</li>
    @endforeach
</ul>
