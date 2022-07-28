<?php
// Include Config
require_once("config.php");

if (isset($_SESSION['broadcast'])) {
    $alert = "success";
    if ($_SESSION['broadcast'] == "accountCreated"){
        $alertmsg = "Account Successfully Created. Please login now";
    } 
}

//Define Vars
$uidInput = $password = "";

if (isset($_POST['submit'])) {
    if (empty(trim($_POST['uidInput']))) {
        $alert = "danger";
        $alertmsg = "Please enter your username or email";
    } else {
        if (empty(trim($_POST['password']))) {
            $alert = "danger";
            $alertmsg = "Please enter a password";
        } else {
            if (filter_var(($_POST['uidInput']),FILTER_VALIDATE_EMAIL)){
                $find = "email";
            } else {
                $find = "userName";
            }
            if (password_verify($_POST['password'],(mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `user` WHERE ".$find." = '".$_POST['uidInput']."'"))['password']))){
                $_SESSION['UID'] = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `user` WHERE ".$find." = '".$_POST['uidInput']."'"))['userName'];
                $_SESSION['ID'] = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `user` WHERE ".$find." = '".$_POST['uidInput']."'"))['userID'];
                header("Location: main.php");
                exit();
            } else {
                $alert = "danger";
                $alertmsg = "Incorrect Credentials";
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>
</head>

<body>
    <!--Page Content-->
    <main>
        <div class="sidenav">
            <div class="login-main-text">
                <h2>Food On Wheels<br> Login Page</h2>
                <p>Login or register from here to access.</p>
            </div>
        </div>
        <div class="main">
            <div class="col-md-6 col-sm-12 form mx-5 my-5">
                <form name="form" action="./login.php" method="POST">
                    <h1>Login</h1>
                    <div class="form-group my-2">
                        <label for="uidInput">Username Or Email</label>
                        <input type="text" class="form-control" id="uidInput" name="uidInput" placeholder="Enter Username or Email" <?php if (isset($_POST['uidInput'])) echo ('value="' . $_POST['uidInput'] . '"') ?>>
                    </div>
                    <div class="form-group my-2">
                        <label for="passwordInput">Password</label>
                        <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Enter Password">
                    </div>
                    <br>
                    <input name="submit" class="btn btn-success text-white" type="submit" value="Login">
                    <a class="btn btn-secondary" href="signup.php">Dont have an account?</a>
                </form>
                <a href="main.php" class="my-3">Go Back</a>
                <br>
                <?php
                if (isset($alert) && isset($alertmsg)) {
                    echo '<div class="alert alert-' . $alert . '" role="alert">' . $alertmsg . '</div>';
                }
                ?>
            </div>
        </div>
    </main>
    <!-- End of content -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="./js/login.js" type="text/javascript"></script>
</body>

</html>