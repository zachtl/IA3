AOS.init();

cookie = document.cookie;
console.log(cookie);

var settings = {
    "url": "https://www.bnefoodtrucks.com.au/api/1/trucks",
    "method": "GET",
    "timeout": 0,
  };
  
  $.ajax(settings).done(function (response) {
    // console.log(response);
    // console.log($.grep(response, function( n, i ) {return n.truck_id == document.getElementById("rev1").innerText})[0].name);
    var x = 0;
            while(document.querySelector('td#sl'+x) != null) {
                indivtruck = (document.querySelector('td#sl'+x).innerText).trim().split(/\s+/);
                trucksavail="";
                x1 = 0;
                indivtruck.forEach(function(){
                    trucksavail+= ($.grep(response, function( n, i ) {return n.truck_id == indivtruck[x1]})[0].name)+ ", ";
                    x1++;
                })
                document.querySelector('td#sl'+x).innerText =  trucksavail;
                x++
            }
    
    for (x = 0; x < 10; x ++){
        if (document.getElementById("rev"+x)) {
            document.getElementById("rev"+x).innerText = $.grep(response, function( n, i ) {return n.truck_id == document.getElementById("rev"+x).innerText})[0].name;
        }
    }
    
    for (var i = 0; i < response.length; i++) {
        var newTruck = document.createElement("a");
        newTruck.classList.add('square', 'fullImg');
        newTruck.href = "#truckinfo";
        newTruck.id = i;
        // newTruck.setAttribute('data-aos', 'fade');
        newTruck.addEventListener('click', function displayInfo(event){
            document.getElementById("truckpage").setAttribute('href', 'truck.php?truckid='+ response[this.id].truck_id);
            document.getElementById("truckName").innerText = response[this.id].name;
            if (response[this.id].bio != "") {
              document.getElementById("truckDesc").innerText = response[this.id].bio;
            } else {
              document.getElementById("truckDesc").innerText = "No Description Available";
            }
            // document.getElementById("reviewform").setAttribute('action', 'truck.php?truckid='+ response[this.id].truck_id);
            document.cookie = "truckid="+ response[this.id].truck_id;
            document.getElementById("truckinfo").style.backgroundSize = "cover";
            document.getElementById("truckinfo").style.background = "linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('"+response[this.id].cover_photo.src+"')";
            document.getElementById("truckinfo").style.display = "block";
            document.getElementById("truckinfoDesc").style.display = "block";
            document.getElementById("truckweb").href = response[this.id].website;
            document.getElementById("truckidform").setAttribute('value', response[this.id].truck_id);
            if (response[this.id].facebook_url !== "") {
                document.getElementById("facebook").style.display = "block";
                document.getElementById("facebook").href = response[this.id].facebook_url;
            } else {
                document.getElementById("facebook").style.display = "none";
            }
            if (response[this.id].instagram_handle !== "") {
                document.getElementById("instagram").style.display = "block";
                document.getElementById("instagram").href = "https://www.instagram.com/"+response[this.id].instagram_handle;
            } else {
                document.getElementById("instagram").style.display = "none";
            }
            if (response[this.id].twitter_handle) {
                document.getElementById("twitter").style.display = "block";
                document.getElementById("twitter").href = "https://www.twitter.com/"+response[this.id].twitter_handle;
            } else {
                document.getElementById("twitter").style.display = "none";
            }
        });
        var newImg = document.createElement("img");
        newImg.src = response[i].avatar.src;
        document.getElementById("trucks").appendChild(newTruck).appendChild(newImg);
    }
});

var map = L.map('map2').setView([-27.470125, 153.021072], 9);
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
