import MapHandler from "./MapHandler.js";

let initializedMaps = {}; // Track initialized map targets

document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".open-map-button");
    buttons.forEach((button) => {
        button.addEventListener("click", function () {
            const orderId = this.getAttribute("data-order-id");
            const location = this.getAttribute("data-location");
            const target = `map-${orderId}`;

            if (!initializedMaps[target]) { // Check if map target is already initialized
                const { latitude, longitude } = JSON.parse(location);
                const mapConfig = {
                    [target]: {
                        target: target,
                        zoom: 15,
                        getCenter: () => [longitude, latitude],
                    },
                };
                new MapHandler(mapConfig);
                initializedMaps[target] = true; // Mark target as initialized
            }
        });
    });
});
