<?php
// Include Config
require_once("config.php");

if (!isset($_SESSION['LVL'])) {
    header("Location: login.php");
    exit();
} else if ($_SESSION['LVL'] == 1) {
    header("Location: login.php");
    exit();
}

if(isset($_POST['submit'])){
    if ($_POST['submit'] == "Create") {
        $q = mysqli_query($conn, "INSERT INTO `event` (`eventId`, `event`, `date`, `lat`, `lon`, `userID`) VALUES (NULL,'".$_POST['eventname']."','".$_POST['eventdate']."', '".$_POST['lat']."', '".$_POST['lon']."', '".$_SESSION['ID']."');");
        if (!$q){
            $alert = "danger";
            $alertmsg = "There was an internal error: ". mysqli_error($conn)."| ".$_SESSION['ID'].' '.$_POST['truckid'];
        } else {
            $alert = "success";
            $alertmsg = "Event successfully created";
        }
    } else if ($_POST['submit'] == "Add Trucks") {
        $trucks = array_unique(explode(',', $_POST['trucks']));
        // echo var_dump($trucks);
        foreach ($trucks as $x) {
            $q2 = mysqli_query($conn, "INSERT INTO `eventTruckAllocation`(`eventId`, `truckId`) VALUES ('".$_POST['actionTruck']."','".$x."')");
            if (!$q2) {
                echo mysqli_error($conn);
            }
        }
        $alert = "success";
        $alertmsg = "Trucks successfully Appended";
        
    }   else if ($_POST['submit'] == "Delete Truck") {
    mysqli_query($conn, "DELETE FROM `event` WHERE `eventId` = ".$_POST['actionTruck']);
    mysqli_query($conn, "DELETE FROM `eventTruckAllocation` WHERE `eventId` = ".$_POST['actionTruck']);
    $alert = "success";
    $alertmsg = "Event Successfully Deleted";
    }
    $test = mysqli_query($conn, "DELETE FROM `eventTruckAllocation` WHERE `truckId` = 0");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>
</head>

<body>
    <?php include("nav.php") ?>
    <!--Page Content-->
    <main>
        <div class="px-3 py-5 img1" style="background-size: cover;">
            <div class="container px-3 py-3 text-white">
                <h1 class="display-1">Welcome <?php echo $_SESSION['UID']?>!</h1>
                <p class="lead">Hey <?php echo $_SESSION['UID']?>! Here you can <?php
                if ($_SESSION['LVL'] == 2){
                    echo 'create and manage events.';
                } else if ($_SESSION['LVL'] == 3) {
                    echo 'manage events, as well as appoint food trucks for events!';
                }
                ?></p>
            </div>
        </div>
        <!--Create Event-->
        <?php
        if(isset($_GET['assign'])){
            if($_GET['assign'] == "manage") { 
                    echo '
                    <div class="container my-3">
                        <h1 class="display-1">Manage Trucks</h1>
                        <form class="container" action="eventmanagement.php" method="POST">
                            <input type="text" class="form-control my-3" name="trucks" id="trucklist">
                            <input type="submit" class="btn btn-primary" name="submit" value="Add Trucks">
                            <input type="hidden" name="actionTruck" value='.$_GET['id'].'>
                        </form>
                        <div class="grid" id="trucks">
                        </div>
                    </div>
                    ';
            } else if ($_GET['assign'] == "delete"){
                echo '
                    <div class="container my-3">
                        <h1 class="display-1 text-danger">Delete Event</h1>
                        <form class="container" action="eventmanagement.php" method="POST">
                            <h1 class="text-danger">Are you sure you want to delete this event?</h1>
                            <input type="submit" class="btn btn-danger" name="submit" value="Delete Truck">
                            <input type="hidden" name="actionTruck" value='.$_GET['id'].'>
                        </form>
                    </div>
                    ';
            }
        } else {
            echo '
            <div class="container my-3">
                <h1 class="display-1">Create New Event</h1>
                <form class="container" action="eventmanagement.php" method="POST">
                    <div class="form-group">
                        <label for="eventname">Name of Event</label>
                        <input type="text" name="eventname" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="eventname">Date</label>
                        <input type="date" name="eventdate" class="form-control">
                    </div>
                    <p id="locationName">Click on the map</p>
                    <input type="hidden" name="lat" id="latinp">
                    <input type="hidden" name="lon" id="loninp">
                    <input type="submit" name="submit" value="Create" class="btn btn-outline-success my-2">
                </form>
            </div>
            ';
        }
        
        ?>
        <div id="map3" style="z-index: 1;"></div>
        <!--Current Events-->
        <div class="container my-3">
            <h1 class="display-1">Current Event List</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Event</th>
                        <th scope="col">Date</th>
                        <th scope="col">Trucks Allocated</th>
                        <th scope="col">Location</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    if ($result = mysqli_query($conn, 'SELECT * FROM event ORDER BY date ASC')) {
                        // Fetch one and one row
                        $x = 0;
                        while ($row = mysqli_fetch_row($result)) {
                            // echo var_dump($row);
                            echo "<tr>";
                            echo "<th scope='row'>".$row[0]."</th>";
                            echo "<td>".$row[1]."</td>";
                            echo "<td>".$row[2]."</td>";
                            echo "<td id='sl".$x."'>";
                            if ($result2 = mysqli_query($conn, 'SELECT `truckId` FROM `eventTruckAllocation` WHERE `eventId` = '. $row[0])){
                                while ($row2 = mysqli_fetch_row($result2)) {
                                    echo $row2[0]." ";
                                }
                            }
                            echo "<td onClick='map.flyTo([".$row[3].",".$row[4]."], 15); var marker = L.marker([".$row[3].",".$row[4]."]).addTo(map);' style='cursor: pointer'>Click</td>";
                            echo "<td>";
                            if($_SESSION['LVL'] == 3) {
                                echo "<a class='btn btn-primary' href='?assign=manage&id=".$row[0]."'>Manage Trucks</a>";
                            }
                            echo "<a class='btn btn-danger' href='?assign=delete&id=".$row[0]."'>Delete Event</a>";
                            echo "<td>";
                            echo "</tr>";
                            $x++;
                        }
                        mysqli_free_result($result);
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <?php include("footer.php") ?>
    <!-- End of content -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script type="text/javascript">
        var map = L.map('map3').setView([-24, 133], 5);
        L.tileLayer('https://api.mapbox.com/styles/v1/zachtl/cl49vflg1000115ljhl7ubnta/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiemFjaHRsIiwiYSI6ImNsMXczNnJqMjFybjAzYnM2MzBpY2NtdXoifQ.403YTFq9aBWL-BYxVDO6NA', {
            attribution: '© <a href="https://www.mapbox.com/map-feedback/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        }).addTo(map);
        map.touchZoom.enable();
        
        map.on('click', function(e) {
          console.log(e.latlng.lat,e.latlng.lng);
          document.getElementById('latinp').value = e.latlng.lat;
          document.getElementById('loninp').value = e.latlng.lng;
          
          var settings = {
              "url": "https://api.mapbox.com/geocoding/v5/mapbox.places/" + e.latlng.lng + "," + e.latlng.lat + ".json?access_token=pk.eyJ1IjoiemFjaHRsIiwiYSI6ImNsMXczNnJqMjFybjAzYnM2MzBpY2NtdXoifQ.403YTFq9aBWL-BYxVDO6NA",
              "method": "GET",
              "timeout": 0,
            };
            
            $.ajax(settings).done(function (response) {
                console.log(response);
            //   console.log(response.features[0].place_name);
                document.getElementById('locationName').innerText = response.features[0].place_name;
            });
        
        });
        
        var settings1 = {
            "url": "https://www.bnefoodtrucks.com.au/api/1/trucks",
            "method": "GET",
            "timeout": 0,
        };
        
        $.ajax(settings1).done(function (response) {
            console.log(response);
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
        });
        
        var settings = {
            "url": "https://www.bnefoodtrucks.com.au/api/1/trucks",
            "method": "GET",
            "timeout": 0,
          };
          
          $.ajax(settings).done(function (response) {
            
            for (var i = 0; i < response.length; i++) {
                var newTruck = document.createElement("a");
                newTruck.classList.add('square', 'fullImg');
                newTruck.id = i;
                // newTruck.setAttribute('data-aos', 'fade');
                newTruck.addEventListener('click', function displayInfo(event){
                    document.getElementById('trucklist').value += response[this.id].truck_id + ",";
                });
                var newImg = document.createElement("img");
                newImg.src = response[i].avatar.src;
                document.getElementById("trucks").appendChild(newTruck).appendChild(newImg);
            }
        });
        
    </script>
</body>

</html>