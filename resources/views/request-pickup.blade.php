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
        <img src="{{ asset('assets/img/map.png') }}" alt="map">
        <p>Selected Services:</p>
        <div class="container">
        @php
            $serviceNames = [];
        @endphp

        @foreach ($selectedServices as $key => $value)
            @php
                $serviceNames[] = config('prices')[$key]['name'] . ' (' . config('prices')[$value]['name'] . ')';
            @endphp
        @endforeach

        <p>{{ implode(', ', $serviceNames) }}</p>
        </div>
        <!-- <label class="form-label">Select Pickup Location:</label> -->
        <div>
            <div>
                <button type="button" class="btn btn-primary" id="getLocationButton" data-bs-toggle="modal" data-bs-target="#mapModal">Pick location</button>
            </div>   
        </div>
    </div>
</section>
@include('layouts.modal', [
                'modalId' => 'mapModal',
                'modalTitle' => 'Pick Location',
                'modalContent' => view('modals.map')->render()
            ])
@include('layouts.modal', [
                'modalId' => 'confirmPickupModal',
                'modalTitle' => 'Summary',
                'modalContent' => view('modals.pickup-bill')->render()
            ])
</script>           
<script type="module">
    let userLocation;
    import {getCurrentLocation} from '{{asset("./js/pick-address.js")}}';
    document.addEventListener('DOMContentLoaded', function () {
        const selectedServices = {!! json_encode($selectedServices) !!};
        const prices = {!! json_encode($prices) !!};
        const minimumTotalPrice = 1;
        document.getElementById('openBillModalButton').addEventListener('click', function () {
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
                    <p>Estimated Travel Time: ${formattedTravelTime}</p>
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