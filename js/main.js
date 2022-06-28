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
        newTruck.href = response[i].website;
        newTruck.target = "_blank";
        newTruck.rel = "noopener noreferrer";

        var newImg = document.createElement("img");
        newImg.src = response[i].avatar.src;
        document.getElementById("trucks").appendChild(newTruck).appendChild(newImg);
    }
  });