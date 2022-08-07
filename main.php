<?php
require_once("config.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>

</head>

<body>
    <?php include("nav.php") ?>
    <!--Page Content-->
    <main>
        <!--Landing-->
        <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center text-white bg-light" style='background: linear-gradient(45deg, rgba(29, 38, 113, 0.8), rgba(195, 55, 100, 0.8)), url("https://www.onedayinacity.com/wp-content/uploads/2020/11/Brisbane-city-740x493.jpg");background-size: cover;background-position: center;'>
            <div class="col-md-5 p-lg-5 mx-auto my-5">
                <h1 class="display-4 fw-normal">Food on Wheels</h1>
                <p class="lead fw-normal">Find recent reviews users have left, as well as up and comming events where you can find food vans here and there.</p>
                <a class="btn btn-outline-light" href="#trucks">View trucks</a>
            </div>
        </div>
        <!--Event Section-->
        <div data-aos="fade-up">
            <div class="px-3 py-5 img container" >
                <h1 class="display-1">Events</h1>
                <p class="lead">View current and future events in Brisbane</p>
            </div>
            <div id="map2"></div>
            <table class="table table-striped container my-3">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Event</th>
                        <th scope="col">Date</th>
                        <th scope="col">Trucks Allocated</th>
                        <th scope="col">Location</th>
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
                            echo "<td onClick='map.flyTo([".$row[3].",".$row[4]."], 15);' style='cursor: pointer'>Click</td>";
                            echo "</tr>";
                            $x++;
                        }
                        mysqli_free_result($result);
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!--Recent Reviews-->
        <div data-aos="fade-up">
            <div class="px-3 py-5 img">
                <h1 class="display-1">Recent Reviews</h1>
                <p class="lead">View the latest of what people have to say</p>
            </div>
            <div class="slider" data-aos="fade">
                <?php
                $reviews = mysqli_query($conn, "SELECT DISTINCT review.reviewId, review.img, review.comment, review.rating ,user.userName FROM `review`,`user` WHERE review.userID = user.userId ORDER BY timestamp DESC");
                $n = 1;
                while($row = mysqli_fetch_array($reviews)) {
                    echo '<a href="#slide-'.$n.'">'.$n.'</a>';
                    $n ++;
                }
                $n = 1;
              ?>
              <div class="slides text-white" >
                <?php
                    $reviews = mysqli_query($conn, "SELECT DISTINCT review.truckid,review.reviewId, review.img, review.comment, review.rating, review.timestamp ,user.userName FROM `review`,`user` WHERE review.userID = user.userId ORDER BY timestamp DESC");
                    $n = 1;
                    while($row = mysqli_fetch_array($reviews)) {
                        $r="";
                        for ($x = 0; $x != intval($row['rating']); $x++){
                            $r .='<i class="bi bi-star-fill" style="font-size:2.5rem"></i>';
                        }
                            echo'<div id="slide-'.$n.'" style="scroll-margin-top: 2.5em; background-position: center !important; background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(data:image/jpeg;base64,'.base64_encode($row['img']).'); background-size: cover">
                                    <div>
                                      <h1 class="display-1" id="rev'.$n.'">'.$row['truckid'].'</h1>
                                      <p class="lead">'.$row['comment'].'<br><em>From '.$row['userName']. ' at '.$row['timestamp'].'</em></p>
                                      <div>'.$r.'</div>
                                    </div>
                                </div>';
                                $n ++;
                                unset($r);
                        }
                ?>
              </div>
            </div>
        </div>
        <!-- Truck Information Section -->
        <div data-aos="fade">
            <div class="px-3 py-5 img img2" id="truckinfo" style="display: none;">
                <div class="container px-3 py-3 text-white">
                    <h1 class="display-1" id="truckName">Empty</h1>
                </div>
            </div>
            <div id="truckinfoDesc" class="mx-5 my-3" style="display: none;">
                <div class="mx-3 my-3">
                    <a href="" id="truckpage" class="btn btn-dark" target="_blank" rel="noreferrer noopener">View More information</a>
                    <a href="" id="truckweb" class="btn btn-outline-secondary" target="_blank" rel="noreferrer noopener">View their website Here</a>
                    <div class="d-flex flex-row">
                        <a href="#" id="facebook" class="fa fa-facebook icon" style="display: none;" rel="noopener noreferrer" target="_blank"></a>  
                        <a href="#" id="instagram" class="fa fa-instagram icon" style="display: none;" rel="noopener noreferrer" target="_blank"></a>  
                        <a href="#" id="twitter" class="fa fa-twitter icon" style="display: none;" rel="noopener noreferrer" target="_blank"></a>
                    </div>
                </div>
                <p class="lead" id="truckDesc">Empty</p>
                <br>
                <div class="my-5">
                    <form action="truck.php" method="POST" enctype="multipart/form-data" class="container" id="reviewform">
                    <input type="hidden" name="truckid" id="truckidform">
                    <h1 class="display-4"><?php if(isset($_SESSION['ID'])) echo "Leave a review"; else echo "Please log in"?></h1>
                    <p class="lead"><?php if(isset($_SESSION['ID'])) echo "How would you rate your experience with the place?"; else echo "Please log in to post reviews"?></p>
                    <div style="<?php if(!isset($_SESSION['ID'])) echo "filter: blur(3px); pointer-events: none;";?>">
                        <div class="form-group my-3">
                            <ul class="rate-area">
                            	<input type="radio" id="5-star" name="rating" value="5" /><label for="5-star" title="Amazing">5 stars</label>
                            	<input type="radio" id="4-star" name="rating" value="4" /><label for="4-star" title="Good">4 stars</label>
                            	<input type="radio" id="3-star" name="rating" value="3" /><label for="3-star" title="Average">3 stars</label>
                            	<input type="radio" id="2-star" name="rating" value="2" /><label for="2-star" title="Not Good">2 stars</label>
                            	<input type="radio" id="1-star" name="rating" value="1" /><label for="1-star" title="Bad">1 star</label>
                            </ul>	
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" name="comment" maxlength="65000"></textarea>
                        </div>
                        <input type="file" name="image" class="form-control my-3" accept="image/*">
                        <input type="submit" class="btn btn-outline-success" name="submit" value="Submit">
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Truck Section -->
        <div class="px-3 py-5 img img1" data-aos="fade-up" style="background-size: cover;" id="truckgrid">
            <div class="container px-3 py-3 text-white">
                <h1 class="display-1">Find whats out there</h1>
                <p class="lead">Look through all the various trucks out and about right now</p>
            </div>
        </div>
        <div class="grid" id="trucks">
        </div>
    </main>
    <?php include("footer.php") ?>
    <!-- End of content -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="./js/main.js" type="text/javascript"></script>
    <script type="text/javascript">
        <?php
        if ($result = mysqli_query($conn, 'SELECT * FROM event ORDER BY date ASC')) {
            while ($row = mysqli_fetch_array($result)) {
                echo ("var marker = L.marker([".$row["lat"].",".$row["lon"]."]).addTo(map);");
            }
        }
        ?>
    </script>
</body>

</html>