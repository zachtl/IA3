console.log($.cookie("truckid"));
var settings1 = {
    "url": "https://www.bnefoodtrucks.com.au/api/1/trucks",
    "method": "GET",
    "timeout": 0,
};

$.ajax(settings1).done(function (response) {
    console.log(response);
    document.getElementById('title').innerText = $.grep(response, function( n, i ) {return n.truck_id == $.cookie("truckid")})[0].name;
    document.getElementById('description').innerText = $.grep(response, function( n, i ) {return n.truck_id == $.cookie("truckid")})[0].bio;
    document.getElementById('background').style = "background: linear-gradient(45deg, rgba(29, 38, 113, 0.8), rgba(195, 55, 100, 0.8)), url('"+$.grep(response, function( n, i ) {return n.truck_id == $.cookie("truckid")})[0].cover_photo.src+"');background-size: cover;background-position: center;";
    
    // NEVER USE INNERHTML, its a dumb idea and im only using it for developmental puposes
    document.getElementById('info').innerHTML = (
        "Catagory: " + $.grep(response, function( n, i ) {return n.truck_id == $.cookie("truckid")})[0].Catagory +
        "<br>Facebook: " + $.grep(response, function( n, i ) {return n.truck_id == $.cookie("truckid")})[0].facebook_url +
        "<br>instagram: @" + $.grep(response, function( n, i ) {return n.truck_id == $.cookie("truckid")})[0].instagram_handle +
        "<br>Twitter: " + $.grep(response, function( n, i ) {return n.truck_id == $.cookie("truckid")})[0].twitter_handle
    );
    
    console.log($.grep(response, function( n, i ) {return n.truck_id == $.cookie("truckid")})[0].cover_photo.src);
});