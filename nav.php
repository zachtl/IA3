    <header>    
        <nav class="navbar navbar-expand-md navbar-dark navbar-fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Brand Name</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link<?php if ((substr((basename($_SERVER['PHP_SELF'])), 0, -4)) == "index") echo (" active") ?>" href="./index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?php if ((substr((basename($_SERVER['PHP_SELF'])), 0, -4)) == "review") echo (" active") ?>" href="./review.php">Reviews</a>
                        </li>
                    </ul>
                    <button type="button" class="btn btn-light">Sign In</button>
                </div>
            </div>
        </nav>
    </header>