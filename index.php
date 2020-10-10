<?php
    session_start();

    include("user.php");
    $user = User::loadUser("extripl");
    echo "Butelka: ".$user->getWasteAmount("butelka")."<br>";

    if(isset($_SESSION["loggedIn"]))
    {
        echo "Zalogowany jako: ".$_SESSION["userName"];
    }
?>

<html lang='pl'>
    <head>
        <meta charset = 'utf-8'>
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  
    </head>
    <body>
    <h1 class="display-1 center text-white">Recykling </h1>
        <div class = "container-fluid col-lg-4 col-xs-12 login-panel center">
        
            <form action="login.php" method = "post">
                <input  placeholder="Nazwa użytkownika" aria-label="Nazwa użytkownika" aria-describedby="basic-addon1" class = "form-control" type="text" name="nickname"><br>
                <input  placeholder="Hasło" aria-label="Hasło" aria-describedby="basic-addon1" class = "form-control" type="password" name="password"><br>
                <button class="btn btn-light" action = "submit">ZALOGUJ</button>
            </form>
        </div>
        <?php
            if(isset($_SESSION["back-message"]))
            {
                echo "<p style='color:red;'>".$_SESSION["back-message"]."</p>";
                unset($_SESSION["back-message"]);
            }
        ?>
    </body>
</html>