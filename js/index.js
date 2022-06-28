var map = L.map('map').setView([-24, 133], 5);
L.tileLayer('https://api.mapbox.com/styles/v1/zachtl/cl49vflg1000115ljhl7ubnta/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiemFjaHRsIiwiYSI6ImNsMXczNnJqMjFybjAzYnM2MzBpY2NtdXoifQ.403YTFq9aBWL-BYxVDO6NA', {
    attribution: '© <a href="https://www.mapbox.com/map-feedback/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    dragging: false,
    zoomControl: false
}).addTo(map);

map.touchZoom.disable();
map.doubleClickZoom.disable();
map.scrollWheelZoom.disable();
map.boxZoom.disable();
map.keyboard.disable();
$(".leaflet-control-zoom").css("visibility", "hidden");

var settings = {
    url: "https://www.bnefoodtrucks.com.au/api/1/private-bookings",
    method: "GET",
    headers: {
        "Content-Type": "application/json"
    }
}

function fly() {
    map.flyTo([-27.270125, 153.021072], 9, {
        animate: true,
        duration: 5,
    });

    $.ajax(settings).done(function (results) {
        console.log(results);
        for (var i = 0; i < results.length; i++) {
            var marker = L.marker([(((results[i].Geolocation).slice(31, -2)).split(/[, ]+/)[1]), (((results[i].Geolocation).slice(31, -2)).split(/[, ]+/)[0])]).addTo(map)
            marker.bindPopup("<h1>" + results[i].Title + "</h1>");
        }
    })
}

fly();