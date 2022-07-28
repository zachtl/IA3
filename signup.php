<?php
// Include Config
require_once("config.php");

//Define Vars
$username = $password = $conf_password = $email = $lvl = "";

if (isset($_POST['submit'])) {
    //Validate Email
    if (empty(trim($_POST['email']))) {
        $alertmsg = "Please enter a email";
        $alert = "danger";
    } elseif(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `user` WHERE email = '". trim($_POST['email']."'")))!=0) {
        $alertmsg = "Email already taken";
        $alert = "danger";
    } else {
        // Validate Username
        if (empty(trim($_POST['username']))) {
            $alertmsg = "Please enter a username";
            $alert = "danger";
        } elseif (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `user` WHERE userName = '". trim($_POST['username']."'")))!=0) {
            $alertmsg = "Username already taken";
            $alert = "danger";
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST['username']))) {
            $alertmsg = "Username can only contain letters, numbers and underscores";
            $alert = "danger";
        } else {
            // Validate Password
            if (empty(trim($_POST['password']))) {
                $alertmsg = "Please enter a password";
                $alert = "danger";
            } else {
                $password = trim($_POST['password']);
                if (empty(trim($_POST['confpassword']))) {
                    $alertmsg = "Please confirm password";
                    $alert = "danger";
                } else {
                    $conf_password = trim($_POST['confpassword']);
                    if ($password != $conf_password) {
                        $alertmsg = "Passwords did not match";
                        $alert = "danger";
                    } else {
                        $alert = "success";
                        $alertmsg = "Good job, son - bang";
                        mysqli_query($conn, "INSERT INTO `user`(`userID`, `userName`, `password`, `email`, `accountLevel`, `creationDate`) VALUES (null,'".$_POST['username']."','".password_hash(($_POST['password']),PASSWORD_DEFAULT)."','".$_POST['email']."','".$_POST['accountType']."',current_timestamp())");
                        $_SESSION['broadcast'] = "accountCreated";
                        header("Location: login.php");
                        exit();
                    }
                }
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
</head>

<body>
    <!--Page Content-->
    <main>
        <div class="sidenav">
            <div class="login-main-text">
                <h2>Food On Wheels<br> Sign Up</h2>
                <p>Login or register from here to access.</p>
            </div>
        </div>
        <div class="main">
            <div class="col-md-6 col-sm-12 form mx-5 my-5">
                <form name="form" action="./signup.php" method="POST">
                    <h1>Sign Up</h1>
                    <div class="form-group my-2">
                        <label for="emailInput">Email</label>
                        <input type="email" class="form-control" id="emailInput" name="email" placeholder="Enter Email" <?php if(isset($_POST['email'])) echo ('value="'.$_POST['email'].'"')?>>
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else. Promise 🤲</small>
                    </div>
                    <div class="form-group my-2">
                        <label for="usernameInput">Username</label>
                        <input type="text" class="form-control" id="usernameInput" name="username" placeholder="Enter Username" <?php if(isset($_POST['username'])) echo ('value="'.$_POST['username'].'"')?>>
                    </div>
                    <br>
                    <div class="form-group my-2">
                        <label for="passwordInput">Password</label>
                        <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Enter Password">
                    </div>
                    <div class="form-group my-2">
                        <label for="confpasswordInput">Confirm Password</label>
                        <input type="password" class="form-control" id="confpasswordInput" name="confpassword" placeholder="Password Again">
                    </div>
                    <br>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="accountType" id="radioRegular" value="1" checked>
                        <label class="form-check-label" for="radioRegular">
                            Regular
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="accountType" id="radioTeacher" value="2">
                        <label class="form-check-label" for="radioTeacher">
                            Teacher
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="accountType" id="radioManagement" value="3">
                        <label class="form-check-label" for="radioManagement">
                            Management
                        </label>
                    </div>
                    <br>
                    <input name="submit" class="btn btn-success text-white" type="submit" value="Sign Up">
                    <a class="btn btn-secondary" href="login.php">Have an account?</a>
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