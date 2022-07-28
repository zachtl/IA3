<?php
session_start();
$_SESSION["UID"] = "PetiteChick";
$_SESSION["ID"] = 123;
$_SESSION["lvl"] = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>
</head>

<body>
    <?php include("nav.php") ?>
    <!--Page Content-->
    <main>
        <div class="px-4 text-center align-items-center index-back text-white">
            <video autoplay muted loop id="video">
                <source src="./assets/Replay_2022-05-20_15-00-32.mp4" type="video/mp4" id="vidsource">
            </video>
            <div class="align-self-center blackgrad" style="text-shadow: 0 0 10px #000000">
                <h1 class="display-5 fw-bold">Brand Name</h1>
                <div class="col-lg-6 mx-auto">
                    <p class="lead mb-4">View food trucks in Queensland</p>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                        <a type="button" class="btn btn-primary btn-lg px-4 gap-3" href="./venue.php">Lets have a look!</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include("footer.php") ?>
    <script src="./js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="./js/index.js" type="text/javascript"></script>
</body>
</html>