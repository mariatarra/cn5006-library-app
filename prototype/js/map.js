/**
 * Creates the map and puts a marker on the library's location.
 * Uses the Leaflet library and OpenStreetMap tiles.
 *
 * @return {void}
 */
function initMap() {
    var lat = 37.9838;
    var lng = 23.7275;

    var map = L.map("map").setView([lat, lng], 15);

    L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([lat, lng]).addTo(map).bindPopup("Municipal Library").openPopup();
}

initMap();