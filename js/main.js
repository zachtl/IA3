AOS.init();

cookie = document.cookie;

function fadeIn() {
  $("#main").fadeIn(3000);
}

var settings = {
    "url": "https://www.bnefoodtrucks.com.au/api/1/trucks",
    "method": "GET",
    "timeout": 0,
  };
  
  $.ajax(settings).done(function (response) {
    console.log(response);
    for (var i = 0; i < response.length; i++) {
        var newTruck = document.createElement("a");
        newTruck.classList.add('square', 'fullImg');
        newTruck.href = "#truckinfo";
        newTruck.id = i;
        newTruck.addEventListener('click', function displayInfo(event){
            document.getElementById("truckName").innerText = response[this.id].name;
            if (response[this.id].bio != "") {
              document.getElementById("truckDesc").innerText = response[this.id].bio;
            } else {
              document.getElementById("truckDesc").innerText = "No Description Available";
            }
            document.getElementById("truckinfo").style.backgroundSize = "cover";
            document.getElementById("truckinfo").style.background = "linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('"+response[this.id].cover_photo.src+"')";
            document.getElementById("truckinfo").style.display = "block";
            document.getElementById("truckinfoDesc").style.display = "block";
            document.getElementById("truckweb").href = response[this.id].website;
            // if (response[this.id].facebook_url !== "") {
            //     console.log("Facebook detected");
            //     document.getElementById("facebook").style.display = "block";
            //     document.getElementById("facebook").href = response[this.id].facebook_url;
            // } else {
            //     document.getElementById("facebook").style.display = "none";
            // }
            // if (response[this.id].instagram_handle !== "") {
            //     console.log("Instagram detected");
            //     document.getElementById("instagram").style.display = "block";
            //     document.getElementById("instagram").href = "www.instagram.com/"+response[this.id].facebook_url;
            // } else {
            //     document.getElementById("instagram").style.display = "none";
            // }
            // if (response[this.id].twitter_handle) {
            //     console.log("Twitter detected");
            //     document.getElementById("twitter").style.display = "block";
            //     document.getElementById("twitter").href = "www.twitter.com/"+response[this.id].facebook_url;
            // } else {
            //     document.getElementById("twitter").style.display = "none";
            // }
        });
        var newImg = document.createElement("img");
        newImg.src = response[i].avatar.src;
        document.getElementById("trucks").appendChild(newTruck).appendChild(newImg);
    }
});


