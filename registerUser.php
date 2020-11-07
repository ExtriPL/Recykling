<?php
session_start();
include("Systems/schoolClass.php");
if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
    $currentuserName = $_SESSION["userName"];
    $currentUser = User::loadUser($_SESSION["userName"]);
    if ($currentUser->isStudent()) {
        header("location:index.php");
        exit();
    }
} else if (!isset($_SESSION["isMaster"]) || !$_SESSION["isMaster"]) {
    header("location:index.php");
    exit();
}
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

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script defer src="script.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Recykling</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <?php if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
                    echo '
                <li class="nav-item">
                    <a class="nav-link" href="homePage.php">Główna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="userPage.php">Strona użytkownika </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="wasteInput.php">Dodaj odpadki</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="registerUser.php">Zarejestruj uczniów</a>
                </li>
                ';
                } else {
                    echo '
                    <li class="nav-item">
                        <a class="nav-link" href="adminPanel.php">Panel administracyjny</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="registerUser.php">Rejestracja użytkowników</a>
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
    <div class="container" style="width:fit-content; margin-top:10%">
        <div class="row">
            <div class="col">
                <div class="jumbotron">
                    <h1 class="center">Rejestracja</h1><br><br>
                    <form autocomplete="off" action="register.php" method="post">

                        <!-- <div class="form-group"> -->
                        <input autocomplete="false" required placeholder="Nazwa użytkownika" aria-label="Nazwa użytkownika" aria-describedby="basic-addon1" class="form-control" type="text" name="nickname"><br>
                        <input autocomplete="false" required placeholder="Hasło" aria-label="Hasło" aria-describedby="basic-addon1" class="form-control" type="password" name="password"><br>


                        <label class="text-black">Rola:</label>
                        <input type="radio" id="role1" name="role" value="student" checked><label class="text-black" for="role1">Uczeń</label>
                        <input type="radio" id="role2" name="role" value="teacher"><label class="text-black" for="role2">Nauczyciel</label><br>

                        <input placeholder="Kod klasy" aria-label="Kod klasy" aria-describedby="basic-addon1" class="form-control addTeacher" type="text" id="classCode1" name="classCode"><br>
                        <input placeholder="Nazwa szkoły" aria-label="Nazwa szkoły" aria-describedby="basic-addon1" class="form-control addTeacher" type="text" id="schoolName" name="schoolName"><br>
                        <input placeholder="Adres szkoły" aria-label="Adres szkoły" aria-describedby="basic-addon1" class="form-control addTeacher" type="text" id="schoolLocation" name="schoolLocation">
                        <select class="form-control addStudent" name="classCode" id="classCode2">
                            <?php
                            $classNames = SchoolClass::getAllClassCodes();
                            if (count($classNames != 0)) 
                            {
                                foreach ($classNames as $c) 
                                {
                                    echo "<option value='$c'>$c</option>";
                                }
                            }

                            ?>
                        </select>
                        <br>
                        <!-- </div> -->


                        <div class="center"><button type="submit" class="btn btn-primary">Zarejestruj</button></div>
                        <div><b>

                                <?php
                                if (isset($_SESSION["back-message"])) {
                                    echo "<br>" . $_SESSION["back-message"];
                                    unset($_SESSION["back-message"]);
                                }
                                ?>
                            </b>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>