<?php
session_start();
include("Systems/schoolClass.php");


if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
    $currentuserName = $_SESSION["userName"];
    $currentUser = User::loadUser($_SESSION["userName"]);
    if ($currentUser->isStudent()) {
        header("location:index.php");
        exit();
    } else {
        header("location:teacherPanel.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <?php require("attachments/links.php") ?>
    <script defer src="scripts/script.js"></script>
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
                    <form autocomplete="off" action="register.php" method="post" id="regForm">

                        <!-- <div class="form-group"> -->
                        <input autocomplete="false" required placeholder="Nazwa użytkownika" aria-label="Nazwa użytkownika" aria-describedby="basic-addon1" class="form-control" type="text" name="nickname"><br>
                        <input autocomplete="false" required placeholder="Hasło" aria-label="Hasło" aria-describedby="basic-addon1" class="form-control" type="password" name="password"><br>


                        <label class="text-black">Rola:</label>
                        <input type="radio" id="role1" name="role" value="student" checked><label class="text-black" for="role1">Uczeń</label>
                        <?php if (isset($_SESSION["isMaster"]) && $_SESSION["isMaster"]) echo '<input type="radio" id="role2" name="role" value="teacher"><label class="text-black" for="role2">Nauczyciel</label>'; ?>


                        <br><label for="classCode2" class="addSutdent text-black">Klasa:</label>

                        <select class="form-control addStudent" name="classCode" id="classCode2">
                            <?php
                            $classNames = SchoolClass::getAllClassCodes();
                            if (count($classNames != 0)) {
                                foreach ($classNames as $c) {
                                    echo "<option value='$c'>$c</option>";
                                }
                            }

                            ?>
                        </select>
                        <input placeholder="Kod klasy" aria-label="Kod klasy" aria-describedby="basic-addon1" class="form-control addTeacher" type="text" id="classCode1" name="classCode"><br>
                        <input placeholder="Nazwa szkoły" aria-label="Nazwa szkoły" aria-describedby="basic-addon1" class="form-control addTeacher" type="text" id="schoolName" name="schoolName"><br>
                        <input placeholder="Adres szkoły" aria-label="Adres szkoły" aria-describedby="basic-addon1" class="form-control addTeacher" type="text" id="schoolLocation" name="schoolLocation">
                        <br>
                        <!-- </div> -->


                        <div class="center"><button id="submitBtn" type="submit" class="btn btn-primary">Zarejestruj</button></div>
                        <div class="backMsg"><b>

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