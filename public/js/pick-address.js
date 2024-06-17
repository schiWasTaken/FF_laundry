
// Function to perform reverse geocoding and get the address name
function getAddressName(latitude, longitude) {
    // Construct the URL for the reverse geocoding API
    let apiUrl = 'https://nominatim.openstreetmap.org/reverse?format=json&lat=' + latitude + '&lon=' + longitude;

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
            let addressName = data.display_name;

            // Do something with the address name (e.g., display it)
            document.querySelectorAll('.addressDisplay').forEach(element => {
                element.textContent = 
                `[${latitude}, ${longitude}]: ${addressName}`;
            });
        })
        .catch(function(error) {
            // Handle any errors that occur during the request
            console.error('Error:', error);
        });
}

export function getCurrentLocation() {
    const latitude = localStorage.getItem('currentLatitude');
    const longitude = localStorage.getItem('currentLongitude');
    return { latitude, longitude };
}

document.addEventListener('DOMContentLoaded', function () {
    let mapInitialized = false;
    function getGeolocation() {
        let latitude, longitude;
        // Check if the Geolocation API is supported by the browser
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                latitude = position.coords.latitude;
                longitude = position.coords.longitude;
                if (!mapInitialized) {
                    initializeMap(latitude, longitude);
                    handleLocationSelection(latitude, longitude);
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

    function storeCurrentLocation(latitude, longitude) {
        localStorage.setItem('currentLatitude', latitude);
        localStorage.setItem('currentLongitude', longitude);
    }

    // Function to handle selection of a new location and update the address display
    function handleLocationSelection(latitude, longitude) {
        // Call getAddressName with new coordinates
        getAddressName(latitude, longitude);
        storeCurrentLocation(latitude, longitude);
    }
    
    // Define map and markerLayer variables globally
    let map;
    let markerLayer;

    // Initialize the map
    function initializeMap(latitude, longitude) {
        // Initialize the map here
        map = new ol.Map({
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
        markerLayer = new ol.layer.Vector({
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

        // Function to add a marker
        function addMarker(longitude, latitude) {
            const marker = new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.fromLonLat([longitude, latitude]))
            });
            markerLayer.getSource().clear(); // Clear previous markers
            markerLayer.getSource().addFeature(marker);
        }

        // Initial marker
        addMarker(longitude, latitude);

        // Handle click event to add marker
        map.on('click', function (event) {
            const coordinates = event.coordinate;
            const lonlat = ol.proj.toLonLat(coordinates);
            addMarker(lonlat[0], lonlat[1]);
            handleLocationSelection(lonlat[1], lonlat[0]); // Assuming handleLocationSelection function exists
        });

        // Flag indicating map initialization
        mapInitialized = true;
    }

    // Update the map with new coordinates
    function updateMap(latitude, longitude) {
        if (!map) {
            console.error('Map is not initialized');
            return;
        }

        const view = map.getView();
        view.setCenter(ol.proj.fromLonLat([longitude, latitude]));

        // Update the marker position
        const markerSource = markerLayer.getSource();
        if (markerSource.getFeatures().length > 0) {
            const marker = markerSource.getFeatures()[0];
            marker.getGeometry().setCoordinates(ol.proj.fromLonLat([longitude, latitude]));
        } else {
            console.warn('Marker not found');
        }
    }

    let latitude, longitude;
    let getLocationButton = document.getElementById('getLocationButton');
    getLocationButton.addEventListener('click', function() {
        latitude, longitude = getGeolocation();
    });
});