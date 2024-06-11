<div class="mt-3">
    <label class="form-label">Select Pickup Location:</label>
    <p class="addressDisplay">Loading address...</p>
    <div id="map" style="width: 100%; height: 400px;"></div>
    <button type="button" class="getLocationButton btn btn-primary">Get Location</button>
</div>

<script>
    // Define your OpenRouteService API key
    window.config = {
        openRouteServiceApiKey: "{{ $openRouteServiceApiKey }}"
    };
</script>
<script>
    var getLocationButton = document.getElementById('getLocationButton');
    getLocationButton.addEventListener('click', function() {
        // Check if the Geolocation API is supported by the browser
        if ('geolocation' in navigator) {
            // Request the current position from the browser
            navigator.geolocation.getCurrentPosition(function(position) {
                // Get the latitude and longitude from the position object
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                
                // Call the function to initialize the map with the obtained coordinates
                initializeMap(latitude, longitude);
                handleLocationSelection(latitude, longitude);
                // You can use this information to update a map or perform other actions
                
                getLocationButton.style.display = 'none';
            }, function(error) {
                // Handle any errors that occur during the request
                console.error('Error getting location:', error);
            });
        } else {
            // Browser doesn't support geolocation
            console.error('Geolocation is not supported by this browser.');
        }
    });

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
                document.getElementById('addressDisplay').textContent = 'Address: ' + addressName;
            })
            .catch(function(error) {
                // Handle any errors that occur during the request
                console.error('Error:', error);
            });
    }

    // Function to handle selection of a new location and update the address display
    function handleLocationSelection(latitude, longitude) {
        // Call getAddressName with new coordinates
        getAddressName(latitude, longitude);
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
        // Add the marker layer to the map
        map.addLayer(markerLayer);
        // Event listener for map click
        map.on('click', function (event) {
            console.log(event)
            markerLayer.getSource().clear();

            var coordinates = event.coordinate;
            var lonlat = ol.proj.toLonLat(coordinates);

            let lat = lonlat[1];
            let lon = lonlat[0];
            console.log(lat, lon);
            // Create a marker at the clicked coordinates
            var marker = new ol.Feature({
                geometry: new ol.geom.Point(coordinates)
            });

            // Add the marker to the marker layer
            markerLayer.getSource().addFeature(marker);

            handleLocationSelection(lat, lon)
        });
    };
    
    

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