<?php
session_start();
if (!isset($_SESSION["isMaster"]) || !$_SESSION["isMaster"]) {
    header("location:index");
    exit();
}
include("Systems/schoolClass.php");
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("attachments/links.php") ?>
    <title>Panel administracyjny</title>
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
                    <a class="nav-link active" href="adminPanel.php">Panel administracyjny</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="registerUser.php">Rejestracja użytkowników</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="logout.php" method="POST">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Wyloguj się</button>
            </form>
        </div>
    </nav>
    <?php
    if (isset($_SESSION["back-message"])) {
        echo "<div class='alert alert-info alert-dismissable fade show'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>" . $_SESSION["back-message"] . "</div>";
        unset($_SESSION["back-message"]);
    }
    ?>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-auto">
                <h1 class="display center">Wszyscy użytkownicy</h1>
                <table class="table table-striped table-inverse table-responsive">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Nazwa</th>
                            <th>Typ użytkownika</th>
                            <th>Szkoła</th>
                            <th>Lokalizacja</th>
                            <th>Nauczyciel</th>
                            <th>Klasa</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $allUsers = User::loadAllUsers();
                        foreach ($allUsers as $user) {
                            $schoolClass = SchoolClass::loadClass($user->classCode);
                            echo "<tr>";
                            echo "<td>" . $user->userName . "</td>";
                            echo "<td>" . ($user->role == "teacher" ? "Nauczyciel" : "Uczeń") . "</td>";
                            echo "<td>" . $schoolClass->name . "</td>";
                            echo "<td>" . $schoolClass->location . "</td>";
                            echo "<td>" . $schoolClass->teacher . "</td>";
                            echo "<td>" . $user->classCode . "</td>";
                            echo "<td><a href='removeUser.php?username=" . $user->userName . "'><button class='btn btn-danger'>Usuń</button></a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

            </div>

        </div>
        <div class="row justify-content-center">
            <div class="col-auto">
                <h1 class="display center">Nauczyciele</h1>
                <table class="table table-striped table-inverse table-responsive">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Nazwa użytkownika</th>
                            <th>Szkoła</th>
                            <th>Lokalizacja</th>
                            <th>Klasa</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $allUsers = User::loadAllUsers();
                        foreach ($allUsers as $user) {
                            if ($user->role == "teacher") {
                                $schoolClass = SchoolClass::loadClass($user->classCode);
                                echo "<tr>";
                                echo "<td>" . $user->userName . "</td>";
                                echo "<td>" . $schoolClass->name . "</td>";
                                echo "<td>" . $schoolClass->location . "</td>";
                                echo "<td>" . $user->classCode . "</td>";
                                echo "<td><a href='removeUser.php?username=" . $user->userName . "'><button class='btn btn-danger'>Usuń</button></a></td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-auto">
                <h1 class="display center">Klasy</h1>
                <span class='text-danger'> Usunięcie klasy powoduje usunięcie jej nauczyciela!</span>
                <table class="table table-striped table-inverse table-responsive">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Klasa</th>
                            <th>Nauczyciel</th>
                            <th>Szkoła</th>
                            <th>Lokalizacja</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $schoolClasses = SchoolClass::getAllClasses();
                        foreach ($schoolClasses as $schoolClass) {
                            echo "<tr>";
                            echo "<td>" . $schoolClass->classCode . "</td>";
                            echo "<td>" . $schoolClass->teacher . "</td>";
                            echo "<td>" . $schoolClass->name . "</td>";
                            echo "<td>" . $schoolClass->location . "</td>";
                            echo "<td><a href='adminPanel.php?classCode=" . $schoolClass->classCode . "'><button class='btn btn-outline-info'>Pokaż uczniów</button></a>&nbsp&nbsp";
                            echo "<a href='removeUser.php?classCode=" . $schoolClass->classCode . "'><button class='btn btn-danger'>Usuń</button></a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        if (isset($_GET["classCode"])) {
            echo '<div class="row justify-content-center">
            <div class="col-auto">
                <h1 class="display center">Klasa '.$_GET["classCode"].'</h1>
                <table class="table table-striped table-inverse table-responsive">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Nazwa ucznia</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>';


            $class = SchoolClass::loadClass($_GET["classCode"]);
            $students = $class->getStudents();
            foreach ($students as $user) {
                if ($user->role != "teacher") {
                    $schoolClass = SchoolClass::loadClass($user->classCode);
                    echo "<tr>";
                    echo "<td>" . $user->userName . "</td>";
                    // echo "<td><a href='userPage.php?classCode=" . $schoolClass->classCode . "'><button class='btn btn-outline-info'>Pokaż wyniki</button></a>&nbsp&nbsp";
                    echo "<td><a href='removeUser.php?username=" . $user->userName . "'><button class='btn btn-danger'>Usuń</button></a></td>";
                    echo "</tr>";
                }
            }
            echo "</tbody>
            </table>
        </div>
    </div>";
        }
        ?>
    </div>
</body>

</html>