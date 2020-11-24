<script src="https://use.fontawesome.com/8175c427fe.js"></script>
<div class="banner">
    
    <span class="nickname"><?php echo $_SESSION["userName"] ?>&nbsp&nbsp<i class="fa fa-user"></i></span>
</div>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">
        <img src="assets/logo.png" width="50" height="50" class="d-inline-block align-top" alt="">
        <!-- Recykling -->
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link <?php if ($filename == "homePage") echo "active"; ?>" href="homePage.php">Główna</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($filename == "userPage") echo "active"; ?>" href="userPage.php">Strona użytkownika </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($filename == "wasteInput") echo "active"; ?>" href="wasteInput.php">Dodaj odpadki</a>
            </li>
            <?php
            $currentuserName = isset($_GET["userName"]) ? $_GET["userName"] : $_SESSION["userName"];
            $currentUser = User::loadUser($_SESSION["userName"]);
            if (!($currentUser->isStudent())) {
                $active = $filename == "teacherPanel" ? "active" : "";
                echo '
                        <li class="nav-item">
                            <a class="nav-link ' . $active . '" href="teacherPanel.php">Panel klasy</a>
                        </li>
                        ';
            }
            ?>
        </ul>
        <form class="form-inline my-2 my-lg-0" action="logout.php" method="POST">

            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Wyloguj się</button>
        </form>
    </div>
</nav>