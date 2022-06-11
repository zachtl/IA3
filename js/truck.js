var map = L.map('map', {
    // center: [-27.470125, 153.021072],
    center: [-24, 133],
    zoom: 5,
    scrollWheelZoom: false,
    dragging: false,
});

L.tileLayer('https://api.mapbox.com/styles/v1/zachtl/cl49vflg1000115ljhl7ubnta/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiemFjaHRsIiwiYSI6ImNsMXczNnJqMjFybjAzYnM2MzBpY2NtdXoifQ.403YTFq9aBWL-BYxVDO6NA', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
}).addTo(map);

var settings = {
    "url": "https://www.bnefoodtrucks.com.au/api/1/trucks",
    "method": "GET",
    "timeout": 0,
    "headers": {
        "Access-Control-Allow-Origin": "https://www.bnefoodtrucks.com.au/api/1/trucks"
    },
};

$.ajax(settings).done(function (response) {
    console.log(response);
});

document.onload = map.flyTo([-27.470125, 153.021072], 10, {
    animate: true,
    duration: 5,
    easeLinearity: 0.5,
})