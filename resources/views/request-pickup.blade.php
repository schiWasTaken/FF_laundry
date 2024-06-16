@extends('layouts.template')
@section('title')
    Home
@endsection
@section('content')
<section class="masthead page-section">
    <div class="container page">
        <h1>Request Pickup</h1>

        <p>Selected Services:</p>
        <ul>
            @foreach ($selectedServices as $key => $value)
                <li>{{ $key }}: {{ $value }}</li>
            @endforeach
        </ul>
        <label class="form-label">Select Pickup Location:</label>
        @include('pick-address')
        @include('layouts.modal', [
                'modalId' => 'confirmPickupModal',
                'modalTitle' => 'Summary',
                'modalContent' => view('modals.pickup-bill')->render()
            ])
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectedServices = {!! json_encode($selectedServices) !!};
        const prices = {!! json_encode($prices) !!};
        const userLocation = "test";
        const minimumTotalPrice = 1;

        document.getElementById('openBillModalButton').addEventListener('click', function () {
            updateBillModal();
        });

        document.getElementById('confirmBillButton').addEventListener('click', function () {
            // Send the selected services to the server and navigate to the order tracking page
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("save.selected.services") }}';
            form.innerHTML = `
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="selected_services" value='${JSON.stringify(selectedServices)}'>
                <input type="hidden" name="user_location" value='${userLocation}'>
            `;
            document.body.appendChild(form);
            form.submit();
        });

        function updateBillModal() {
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
        }
    });
</script>
@endsection