<?php
    include("user.php");
    session_start(); 
    if(!isset($_SESSION["loggedIn"]) || !$_SESSION["loggedIn"])
    {
        header("location:index.php");
        exit();
    }
    ?>
<html lang='pl'>
   
    <head>
        <meta charset = 'utf-8'>
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <style>
        body
        {
        background:linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),url('https://www.pomysly-na.pl/wp-content/uploads/inspiracje/jak-kreatywnie-820x546.jpg');
        }
        </style>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Recykling</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="homePage.php">Główna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="userPage.php">Strona użytkownika </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="wasteInput.php">Dodaj odpadki</a>
                </li>
                </ul>
                <form class="form-inline my-2 my-lg-0" action="logout.php" method="POST">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Wyloguj się</button>
                </form>
            </div>
        </nav>


    <div class="jumbotron">
        <h4> 
        <?php
        if(isset($_SESSION["loggedIn"]))
        {
            echo "Zalogowany jako: ".$_SESSION["userName"];
        }
        ?>
        </h4>
    </div>
    <div class="container">
        <div class="row">
            <div class="col center">
                <div class="jumbotron">
                    <h1 class="">Suma zebranych przez Ciebie butelek</h1>
                    <p class="display-1"><?php
                        $currentUser = User::loadUser($_SESSION["userName"]);
                        $currentUser->getWasteAmount("butelka");
                    ?></p>
                </div>
            </div>
            <div class="col center">
            <div class="jumbotron">
                    <h1 class="">Suma zebranych przez Twoją klasę butelek</h1>
                    <p class="display-1">1000 m2</p>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col center">
                    <div class="jumbotron">
                        <a class="btn btn-primary btn-lg" href="wasteInput.php">Dodaj zebrane odpadki</a>
                    </div>
                </div>
            </div>
    </div>
    </body>
</html>