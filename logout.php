<?php
session_start();

if ((!isset($_SESSION["loggedIn"]) || !$_SESSION["loggedIn"]) && (!isset($_SESSION["isMaster"]) || !$_SESSION["isMaster"])) {
    header("location:index.php");
    exit();
}

unset($_SESSION["loggedIn"]);
unset($_SESSION["userName"]);
unset($_SESSION["isMaster"]);
?>

<html lang='pl'>

<head>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://www.pomysly-na.pl/wp-content/uploads/inspiracje/jak-kreatywnie-820x546.jpg');
        }
    </style>

    <?php require("attachments/links.php") ?>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="jumbotron center">
                    <h1 class="display-1">Wylogowano</h1>
                    <br><br>
                    <a class="btn btn-primary btn-lg" href="index.php">Przejdź na stronę logowania</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>