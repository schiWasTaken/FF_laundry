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
    <script>
        const mapConfigs = {
            pickLocationMap: {
                target: 'pick-location-map',
                zoom: 15,
                getCenter: () => {
                    const {
                        latitude,
                        longitude
                    } = getCurrentLocation();
                    return [longitude, latitude];
                }
            },
            outletMap: {
                target: 'outlet-map',
                zoom: 15,
                getCenter: () => {
                    const outlets = window.config.outlets;
                    // TODO: outlet is set to key 0 for now
                    let outletId = 0;
                    const {
                        0: latitude,
                        1: longitude
                    } = outlets[outletId]['location'];
                    return [longitude, latitude];
                }
            }
        };
    </script>
    @yield('extra', '')
</body>

</html>