<?php
session_start();

if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
    header("location:homePage.php");
    exit();
}
if (isset($_SESSION["isMaster"]) && $_SESSION["isMaster"]) {
    header("location:adminPanel.php");
    exit();
}

?>

<html lang='pl'>

<head>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <?php require("attachments/links.php") ?>
</head>

<body>
    <h1 class="display-1 center text-white">
        <?php  ?>
        Recykling</h1>
    <div class="container-fluid col-lg-4 col-xs-12 login-panel center">

        <form action="login.php" method="post">
            <input placeholder="Nazwa użytkownika" aria-label="Nazwa użytkownika" aria-describedby="basic-addon1" class="form-control" type="text" name="nazwa1"><br>
            <input placeholder="Hasło" aria-label="Hasło" aria-describedby="basic-addon1" class="form-control" type="password" name="nazwa2"><br>
            <button class="btn btn-info" action="submit">ZALOGUJ</button>
        </form>
        <span class='error-msg'><b>
                <?php
                if (isset($_SESSION["back-message"])) {
                    echo $_SESSION["back-message"];
                    unset($_SESSION["back-message"]);
                }
                ?>
            </b>
        </span>
    </div>
</body>

</html>