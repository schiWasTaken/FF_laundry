<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')
    <body id="page-top">
        @include('layouts.nav')
        <main>
            @yield('content')
        </main>
        @include('layouts.footer')
        <!-- Core theme JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
        @yield('extra', '')
    </body>
</html>
