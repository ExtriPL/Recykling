<?php
    // include("Systems/schoolClass.php");
    // $class1 = new SchoolClass("1", "Klasa 1 zst", "Radomkowo");
    // $mrw = new User("mrw", password_hash("12345", PASSWORD_DEFAULT), "teacher", "1");
    // $class1->addStudent("mrw");
    // $class1->saveClass();
    // $mrw->saveUser();
    session_start();

    if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"])
    {
        header("location:homePage.php");
        exit();
    }
    else if(isset($_SESSION["isMaster"]) && $_SESSION["isMaster"])
    {
        header("Location: adminPanel.php");
        exit();
    }

    include("Systems/schoolClass.php");
    
    echo SchoolClass::getWastesAreaToDateOfAll("2020-10-26");
?>

<html lang='pl'>
    <head>
        <style>
        body
        {
        background:linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),url('https://www.pomysly-na.pl/wp-content/uploads/inspiracje/jak-kreatywnie-820x546.jpg');
        }
        </style>
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
    <h1 class="display-1 center text-white">
    <?php  ?>
    Recykling</h1>
        <div class = "container-fluid col-lg-4 col-xs-12 login-panel center">
        
            <form action="login.php" method = "post">
                <input  placeholder="Nazwa użytkownika" aria-label="Nazwa użytkownika" aria-describedby="basic-addon1" class = "form-control" type="text" name="nickname"><br>
                <input  placeholder="Hasło" aria-label="Hasło" aria-describedby="basic-addon1" class = "form-control" type="password" name="password"><br>
                <button class="btn btn-light" action = "submit">ZALOGUJ</button>
            </form>
            <span class='error-msg'><b>
            <?php
            if(isset($_SESSION["back-message"]))
            {
                echo $_SESSION["back-message"];
                unset($_SESSION["back-message"]);
            }
            ?>
            </b>
        </span>
        <span style="float:right"><a href="registerUser.php">Zarejestruj się</a></span>
        </div>
    </body>
</html>