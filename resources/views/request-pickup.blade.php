@extends('layouts.template')
@section('title')
    Home
@endsection
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
<section class="masthead text-center">
    <div class="container">
        <!-- <img src="{{ asset('assets/img/map.png') }}" alt="map"> -->
        <!-- Outlet List -->
        <div class="list-group">
            <div class="list-group-item d-flex justify-content-between align-items-center bg-primary text-white">
                <h5 class="mb-0">Outlet Info</h5>
            </div>
            <li class="list-group-item">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-1">Outlet 1</h5>
                    </div>
                    <div class="col">
                        <p class="mb-1"><span>Gg. Durian, RT.3/RW.12, Penggilingan, Kec. Cakung, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13940</span></p>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary open-map-btn" data-bs-toggle="modal" data-bs-target="#outletMapModal">
                            Open Map
                        </button>
                    </div>
                </div>
            </li>
        </div>
        
        <div class="page-section container">
            @php
                $serviceNames = [];
            @endphp

            @foreach ($selectedServices as $key => $value)
                @php
                    $serviceNames[] = config('prices')[$key]['name'] . ' (' . config('prices')[$value]['name'] . ')';
                @endphp
            @endforeach
            <p>Selected Services:</p>
            <p>{{ implode(', ', $serviceNames) }}</p>
            <div>
                <button type="button" class="btn btn-primary" id="getLocationButton" data-bs-toggle="modal" data-bs-target="#mapModal">Pick location</button>
            </div>   
        </div>
    </div>
</section>
@include('layouts.modal', [
    'modalId' => 'mapModal',
    'modalTitle' => 'Pick Location',
    'modalContent' => view('modals.pick-location-map')->render()
            ])
@include('layouts.modal', [
    'modalId' => 'confirmPickupModal',
    'modalTitle' => 'Summary',
    'modalContent' => view('modals.pickup-bill')->render()
            ])
@include('layouts.modal', [
    'modalId' => 'outletMapModal',
    'modalTitle' => 'Outlet',
    'modalContent' => view('modals.outlet-map')->render()
])
            
<script>
    window.config = {
        'outlets': {!! json_encode($outlets) !!},
    };
</script>
<script type="module">
    let userLocation;
    let notes;
    import {getCurrentLocation} from '{{asset("./js/pick-address.js")}}';
    document.addEventListener('DOMContentLoaded', function () {
        const selectedServices = {!! json_encode($selectedServices) !!};
        const prices = {!! json_encode($prices) !!};
        const minimumTotalPrice = null;
        document.getElementById('openBillModalButton').addEventListener('click', function () {
            notes = document.getElementById('notes').value;
            console.log(notes);
            updateBillModal();
        });

        document.getElementById('confirmRequestPickup').addEventListener('click', function () {
            // Send the selected services to the server and navigate to the order tracking page
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("save.selected.services") }}';
            form.innerHTML = `
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="selected_services" value='${JSON.stringify(selectedServices)}'>
                <input type="hidden" name="user_location" value='${JSON.stringify(userLocation)}'>
                <input type="hidden" name="notes" value='${JSON.stringify(notes)}'>
            `;
            document.body.appendChild(form);
            form.submit();
        });

        function updateBillModal() {
            userLocation = getCurrentLocation();
            const billDetails = document.getElementById('billDetails');
            const billTotal = document.getElementById('billTotal');
            billDetails.innerHTML = '';
            let total = 0;

            for (const service in selectedServices) {
                const serviceType = selectedServices[service];
                const price = prices[`${service}`][serviceType]['price'];
                const description = prices[`${service}`][serviceType]['description'];
                billDetails.innerHTML += `<li>${prices[`${service}`]['name']}: ${description}</li>`;
                total += price * prices[`${service}`][serviceType]['minKg'];
            }

            billTotal.textContent = `Rp ${total.toLocaleString('id-ID')}`;

            axios.get('/calculate-distance', {
                params: {
                    lat2: userLocation.latitude,
                    lon2: userLocation.longitude,
                }
            })
            .then(function (response) {
                const resultDiv = document.getElementById('result');
                const { distance, travel_time } = response.data;
                const formattedTravelTime = formatDuration(travel_time);
                resultDiv.innerHTML = `
                    <p>Distance: ${distance.toFixed(2)} km</p>
                    <p>ETA: ${formattedTravelTime}</p>
                `;
            })
            .catch(function (error) {
                console.error(error);
            });
        }

         // Function to format travel time in hours and minutes
        function formatDuration(hours) {
            // Split hours into integer part and fractional part
            const wholeHours = Math.floor(hours);
            const fractionalHours = hours - wholeHours;

            // Calculate minutes from fractional part
            const minutes = Math.round(fractionalHours * 60);

            // Construct formatted string
            let formattedTime = '';
            if (wholeHours > 0) {
                formattedTime += `${wholeHours} hour${wholeHours > 1 ? 's' : ''}`;
            }
            if (minutes > 0) {
                formattedTime += ` ${minutes} minute${minutes > 1 ? 's' : ''}`;
            }

            return formattedTime.trim();
        }
    });
</script>
@endsection