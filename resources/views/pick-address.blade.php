<div class="mt-3">
    <label class="form-label">Select Pickup Location:</label>
    <p class="addressDisplay">Loading address...</p>
    <div>
        <button type="button" class="btn btn-primary" id="getLocationButton" data-bs-toggle="modal" data-bs-target="#mapModal">Pick location</button>
    </div>   
</div>

@include('layouts.modal', [
                'modalId' => 'mapModal',
                'modalTitle' => 'Pick Location',
                'modalContent' => view('modals.map')->render()
            ])

<script>
    // Define your OpenRouteService API key
    window.config = {
        openRouteServiceApiKey: "{{ $openRouteServiceApiKey }}"
    };
</script>
<script>
    // Function to perform reverse geocoding and get the address name
    function getAddressName(latitude, longitude) {
        // Construct the URL for the reverse geocoding API
        var apiUrl = 'https://nominatim.openstreetmap.org/reverse?format=json&lat=' + latitude + '&lon=' + longitude;

        // Send a GET request to the API
        fetch(apiUrl)
            .then(function(response) {
                // Check if the response is successful (status code 200)
                if (response.ok) {
                    // Parse the JSON response
                    return response.json();
                } else {
                    // If the response is not successful, throw an error
                    throw new Error('Failed to retrieve address information.');
                }
            })
            .then(function(data) {
                // Extract the address name from the response data
                var addressName = data.display_name;

                // Do something with the address name (e.g., display it)
                document.querySelectorAll('.addressDisplay').forEach(element => {
                    element.textContent = 'Address: ' + addressName;
                });
            })
            .catch(function(error) {
                // Handle any errors that occur during the request
                console.error('Error:', error);
            });
    }

    

    document.addEventListener('DOMContentLoaded', function () {
        let mapInitialized = false;
        function getGeolocation(callback) {
            let latitude, longitude = 0;
            // Check if the Geolocation API is supported by the browser
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    latitude = position.coords.latitude;
                    longitude = position.coords.longitude;
                    callback(latitude, longitude);
                    if (!mapInitialized) {
                        initializeMap(latitude, longitude);
                    } else {
                        updateMap(latitude, longitude);
                    }
                }, function (error) {
                    console.error("Error getting location: ", error);
                });
            } else {
                console.error("Geolocation is not supported by this browser.");
            }
            return latitude, longitude;
        };

        // Function to handle selection of a new location and update the address display
        function handleLocationSelection(latitude, longitude) {
            // Call getAddressName with new coordinates
            getAddressName(latitude, longitude);
        }
        
        function updateMap(latitude, longitude) {
            const view = map.getView();
            view.setCenter(ol.proj.fromLonLat([longitude, latitude]));
            addMarker(longitude, latitude);
        }

        // Initialize the map
        function initializeMap(latitude, longitude) {
            // Initialize the map here
            var map = new ol.Map({
                target: 'map', // The id of the map container
                layers: [
                    new ol.layer.Tile({
                        source: new ol.source.OSM() // Add OpenStreetMap as the base layer
                    })
                ],
                view: new ol.View({
                    center: ol.proj.fromLonLat([longitude, latitude]), // Initial map center [longitude, latitude]
                    zoom: 15 // Initial zoom level
                })
            });
            // Create a vector layer for the marker
            var markerLayer = new ol.layer.Vector({
                source: new ol.source.Vector({
                features: [
                    new ol.Feature({
                        geometry: new ol.geom.Point(ol.proj.fromLonLat([longitude, latitude]))
                    })
                ]
                }),
                style: new ol.style.Style({
                    image: new ol.style.Icon({
                    anchor: [0.5, 1],
                    src: 'https://cdn4.iconfinder.com/data/icons/small-n-flat/24/map-marker-512.png',
                    scale: 0.1
                    })
                })
            });

            function addMarker(longitude, latitude) {
                const marker = new ol.Feature({
                    geometry: new ol.geom.Point(ol.proj.fromLonLat([longitude, latitude]))
                });
                markerLayer.getSource().addFeature(marker);
            }
            // Add the marker layer to the map
            map.addLayer(markerLayer);
            
            addMarker(longitude, latitude);

            map.on('click', function (event) {
                markerLayer.getSource().clear();
                const coordinates = event.coordinate;
                const lonlat = ol.proj.toLonLat(coordinates);
                addMarker(lonlat[0], lonlat[1]);
                handleLocationSelection(lonlat[1], lonlat[0]);
            });
            mapInitialized = true;
        };
        let latitude, longitude;
        var getLocationButton = document.getElementById('getLocationButton');
        getLocationButton.addEventListener('click', function() {
            latitude, longitude = getGeolocation(function (latitude, longitude) {
                handleLocationSelection(latitude, longitude);
            });
        });
    });
    
    var apiKey = window.config.openRouteServiceApiKey;

    // // Define the origin and destination coordinates
    // var origin = '106.76339914553832, -6.15800900079455';
    // var destination = '106.75859262698363, -6.1607397276070515';

    // // Construct the URL for the routing request
    // var url = `https://api.openrouteservice.org/v2/directions/driving-car?api_key=${apiKey}&start=${origin}&end=${destination}`;

    // // Make a request to the OpenRouteService API
    // fetch(url)
    // .then(response => response.json())
    // .then(data => {
    //     // Check if the response is successful
    //     if (data.features && data.features.length > 0) {
    //     // Extract the estimated time of arrival (ETA) from the response
    //     var durationInSeconds = data.features[0].properties.summary.duration;
    //     var etaInMinutes = Math.round(durationInSeconds / 60);
    //     console.log('Estimated Time of Arrival:', etaInMinutes, 'minutes');
    //     } else {
    //     console.error('Routing request failed:', data.error.message);
    //     }
    // })
    // .catch(error => {
    //     console.error('Error:', error);
    // });


</script>