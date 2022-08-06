<?php
require_once("config.php");

if(isset($_POST['submit']) && isset($_SESSION['ID'])){
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `review` WHERE `userId` = '".$_SESSION['ID']."' AND `truckId` = '".$_POST['truckid']."'")) == 0){
        $q = mysqli_query($conn, "INSERT INTO `zlual_IA3`.`review` (`reviewId`, `userId`, `truckId`, `rating`, `img`, `comment`, `timestamp`) VALUES (NULL, ".$_SESSION['ID'].", ".$_POST['truckid'].", ".$_POST['rating'].", '".addslashes(file_get_contents($_FILES['image']['tmp_name']))."', '".$comment."', CURRENT_TIMESTAMP);");
        if (!$q){
            $alert = "danger";
            $alertmsg = "There was an internal error: ". mysqli_error($conn)."| ".$_SESSION['ID'].' '.$_POST['truckid'];
        } else {
            $alert = "success";
            $alertmsg = "Review successfully created";
        }
    } else {
        $alert = "danger";
        $alertmsg = "You have already left a review for this truck";
    }
}

setcookie('truckid', $_GET['truckid']);

if(!isset($_COOKIE['truckid'])){
    header('Refresh: 1;URL=./main.php');
    exit();
} else {
    unset($_COOKIE['truckid']);
}



?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truck</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
    <?php include("nav.php") ?>
    <main>
        <div id="background" class="px-3 py-5 text-white" data-aos="fade-up" style='background-size: cover;background-position: center;'>
            <h1 class="display-1" id="title">Truck Name</h1>
            <p class="lead" id="description">Truck Description</p>
            <p id="info"></p>
        </div>
        <div class="px-3 py-5 img">
                <h1 class="display-1">Recent Reviews</h1>
                <p class="lead">View the latest of what people have to say</p>
                <p><?php
            echo"<strong>This truck has recieved an average rating of ".round(mysqli_fetch_row(mysqli_query($conn, "SELECT AVG(rating) FROM `review` WHERE `truckId` = ".$_GET['truckid']))[0], 2)."/5</strong>"
            ?></p>
            </div>
            <div class="slider" data-aos="fade">
              <div class="text-white" >
                <?php
                    $reviews = mysqli_query($conn, "SELECT DISTINCT review.truckid,review.reviewId, review.img, review.comment, review.rating, review.timestamp ,user.userName FROM `review`,`user` WHERE review.userID = user.userId AND review.truckId = ".$_GET['truckid']." ORDER BY timestamp DESC");
                    $n = 1;
                    while($row = mysqli_fetch_array($reviews)) {
                        $r="";
                        for ($x = 0; $x != intval($row['rating']); $x++){
                            $r .='<i class="bi bi-star-fill" style="font-size:2.5rem"></i>';
                        }
                            echo'<div style="padding: 1rem 10rem;background-position: center !important; background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(data:image/jpeg;base64,'.base64_encode($row['img']).'); background-size: cover;">
                                    <div>
                                      <h1 class="display-1">From '.$row['userName'].'</h1>
                                      <p class="lead">'.$row['comment'].'<br><em>at '.$row['timestamp'].'</em></p>
                                      <div>'.$r.'</div>
                                    </div>
                                </div>';
                                $n ++;
                                unset($r);
                        }
                ?>
              </div>
            </div>
    </main>
    <?php include("footer.php") ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js" type="text/javascript"></script>
    <script src="./js/truck.js" type="text/javascript"></script>
</body>

</html>