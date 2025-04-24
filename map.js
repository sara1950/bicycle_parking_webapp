

let map = L.map('map').setView([45.805384, 15.971799],13);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

L.control.scale().addTo(map);


async function addPoints(){

var geojsonMarkerOptions = {
        radius: 5,
        fillColor: "#28a84f",
        color: "#000",
        weight: 1,
        opacity: 1,
        fillOpacity: 0.9
    };
fetch("data/parkiralista.geojson")
.then (response => response.json())
.then(data =>{
    L.geoJSON(data,{
        pointToLayer: function (feature, latlng) {
            return L.circleMarker(latlng, geojsonMarkerOptions);
        },
        onEachFeature: function (feature, layer) {
            layer.bindPopup('<p><b>ID:</p>'+ feature.properties.OBJECTID +'<p><b>Lokacija:</p>'+ feature.properties.lokacija);
        }
      
    }).addTo(map);
})
.catch(error=>console.log(error))

}

addPoints();