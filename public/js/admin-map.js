import MapHandler from "./MapHandler.js";
let mapConfig;
// Function to open map modal and initialize map with specific location
function openMap(orderId, userLocation) {
    const { latitude, longitude } = JSON.parse(userLocation);
    const target = `map-${orderId}`;
    console.log(latitude, longitude);
    console.log(target);
    mapConfig = {
        something: {
            target: target,
            zoom: 15,
            getCenter: () => [longitude, latitude],
        },
    };
    console.log(mapConfig);
    new MapHandler(mapConfig);
}
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".open-map-button");
    buttons.forEach((button) => {
        button.addEventListener("click", function () {
            const orderId = this.getAttribute("data-order-id");
            const location = this.getAttribute("data-location");
            openMap(orderId, location);
        });
    });
});
