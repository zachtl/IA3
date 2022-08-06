<header>
        <nav class="navbar navbar-expand-md navbar-dark navbar-fixed-top bg-black">
            <div class="container-fluid">
                <a class="navbar-brand display-6 text-centered" href="./index.php">Food on Wheels</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link<?php if ((substr((basename($_SERVER['PHP_SELF'])), 0, -4)) == "main") echo (" active") ?>" href="./main.php">Home</a>
                        </li>
                        <?php
                        if (isset($_SESSION['LVL'])){
                            if ($_SESSION['LVL'] > 1) {
                                if ((substr((basename($_SERVER['PHP_SELF'])), 0, -4)) == "eventmanagement") {
                                    $idkwhattonamethis = " active";
                                } else {
                                    $idkwhattonamethis = "";
                                }
                                echo '<li class="nav-item">
                                        <a class="nav-link'.$idkwhattonamethis.'" href="./eventmanagement.php">Event Management</a>
                                    </li>';
                            }
                        }
                        ?>
                    </ul>
                    <?php
                    if (!isset($_SESSION['UID'])) {
                        echo '<a type="button" class="btn btn-light" href="./login.php">Sign In</a>';
                    } else {
                        echo ('<a type="button" class="btn btn-danger mx-2" href="./logout.php">Logout</a>');
                        echo ('<a type="button" class="btn btn-dark" href="./account.php">'.$_SESSION['UID'].'</a>');
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>
    <?php
        if (isset($alert)){
            echo '<div class="alert alert-'.$alert.'" role="alert">'.$alertmsg.'</div>';
        }
    ?>