export default class MapHandler {
    constructor(mapConfigs) {
        this.mapConfigs = mapConfigs;
        this.maps = {};
        this.markerLayers = {};

        console.log("Maphandler woke");
        Object.keys(this.mapConfigs).forEach((mapType) => {
            this.initializeMap(this.mapConfigs[mapType]);
            
        });
        document.addEventListener("DOMContentLoaded", () => {
            document
                .getElementById("getLocationButton")
                ?.addEventListener("click", () => {
                    this.getGeolocation();
                });
        });
    }

    getGeolocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    this.handleLocationSelection(latitude, longitude);
                    this.updateMap("pick-location-map", latitude, longitude);
                },
                (error) => {
                    console.error("Error getting location: ", error);
                }
            );
        } else {
            console.error("Geolocation is not supported by this browser.");
        }
    }

    storeCurrentLocation(latitude, longitude) {
        localStorage.setItem("currentLatitude", latitude);
        localStorage.setItem("currentLongitude", longitude);
    }

    handleLocationSelection(latitude, longitude) {
        this.getAddressName(latitude, longitude);
        this.storeCurrentLocation(latitude, longitude);
    }

    getAddressName(latitude, longitude) {
        const apiUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`;

        fetch(apiUrl)
            .then((response) => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error("Failed to retrieve address information.");
                }
            })
            .then((data) => {
                const addressName = data.display_name;
                document
                    .querySelectorAll(".addressDisplay")
                    .forEach((element) => {
                        element.textContent = `[${latitude}, ${longitude}]: ${addressName}`;
                    });
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    }

    initializeMap({ target, zoom, getCenter }) {
        const [longitude, latitude] = getCenter();
        const map = new ol.Map({
            target: target,
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM(),
                }),
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([longitude, latitude]),
                zoom: zoom,
            }),
        });

        const markerLayer = new ol.layer.Vector({
            source: new ol.source.Vector({
                features: [
                    new ol.Feature({
                        geometry: new ol.geom.Point(
                            ol.proj.fromLonLat([longitude, latitude])
                        ),
                    }),
                ],
            }),
            style: new ol.style.Style({
                image: new ol.style.Icon({
                    anchor: [0.5, 1],
                    src: "https://cdn4.iconfinder.com/data/icons/small-n-flat/24/map-marker-512.png",
                    scale: 0.1,
                }),
            }),
        });

        map.addLayer(markerLayer);
        this.maps[target] = map;
        this.markerLayers[target] = markerLayer;

        this.addMarker(target, longitude, latitude);

        if (target === "pick-location-map") {
            map.on("click", (event) => {
                const coordinates = event.coordinate;
                const lonlat = ol.proj.toLonLat(coordinates);
                this.addMarker(target, lonlat[0], lonlat[1]);
                this.handleLocationSelection(lonlat[1], lonlat[0]);
            });
        }

        this.handleLocationSelection(latitude, longitude);
    }

    addMarker(target, longitude, latitude) {
        const marker = new ol.Feature({
            geometry: new ol.geom.Point(
                ol.proj.fromLonLat([longitude, latitude])
            ),
        });
        const markerLayer = this.markerLayers[target];
        markerLayer.getSource().clear();
        markerLayer.getSource().addFeature(marker);
    }

    updateMap(target, latitude, longitude) {
        const map = this.maps[target];
        if (!map) {
            console.error("Map is not initialized");
            return;
        }

        const view = map.getView();
        view.setCenter(ol.proj.fromLonLat([longitude, latitude]));

        const markerLayer = this.markerLayers[target];
        const markerSource = markerLayer.getSource();
        if (markerSource.getFeatures().length > 0) {
            const marker = markerSource.getFeatures()[0];
            marker
                .getGeometry()
                .setCoordinates(ol.proj.fromLonLat([longitude, latitude]));
        } else {
            console.warn("Marker not found");
        }
    }
}
