import MapHandler from "./MapHandler.js";
export function getCurrentLocation() {
    const latitude = localStorage.getItem("currentLatitude");
    const longitude = localStorage.getItem("currentLongitude");
    return { latitude, longitude };
}

const mapConfigs = {
    pickLocationMap: {
        target: "pick-location-map",
        zoom: 15,
        getCenter: () => {
            const { latitude, longitude } = getCurrentLocation();
            return [longitude, latitude];
        },
    },
    outletMap: {
        target: "outlet-map",
        zoom: 15,
        getCenter: () => {
            let outlets;
            try {
                outlets = window.config.outlets;
                // TODO: outlet is set to key 0 for now
                let outletId = 0;
                const { 0: latitude, 1: longitude } =
                    outlets[outletId]["location"];
                return [longitude, latitude];
            } catch (error) {
                return [0, 0];
            }
        },
    },
};
console.log(mapConfigs);

new MapHandler(mapConfigs);
