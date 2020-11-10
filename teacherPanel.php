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
} else {
    header("location:index.php");
    exit();
}


?>

<!-- <!DOCTYPE html> -->
<html lang='pl'>

<head>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://www.pomysly-na.pl/wp-content/uploads/inspiracje/jak-kreatywnie-820x546.jpg');
        }
    </style> -->

    <!-- Bootstrap CSS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/8175c427fe.js"></script>
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
                    <a class="nav-link active" href="homePage.php">Główna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="userPage.php">Strona użytkownika </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="wasteInput.php">Dodaj odpadki</a>
                </li>
                <?php
                $currentuserName = $_SESSION["userName"];
                $currentUser = User::loadUser($_SESSION["userName"]);
                if (!($currentUser->isStudent())) {
                    echo '
                        <li class="nav-item">
                            <a class="nav-link active" href="teacherPanel.php">Panel klasy</a>
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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-auto">
                <h1 class="display center">Twoja klasa: <?php echo $currentUser->classCode ?></h1>
                <form id="tableForm" action="register.php" method="POST">
                    <table class="table table-striped table-inverse table-responsive table-bordered">
                        <thead class="thead-inverse">
                            <tr>
                                <th colspan="2">Nazwa ucznia / hasło</th>
                                <th>Klasa</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody><?php


                                $class = SchoolClass::loadClass($currentUser->classCode);
                                $students = $class->getStudents();
                                foreach ($students as $user) {
                                    if ($user->role != "teacher") {
                                        $schoolClass = SchoolClass::loadClass($user->classCode);
                                        echo "<tr>";
                                        echo "<td colspan='2'>" . $user->userName . "</td>";
                                        echo "<td>" . $schoolClass->classCode . "</td>";
                                        echo "<td><a href='userPage.php?userName=" . $user->userName . "'><button type='button' class='btn btn-outline-info'>Pokaż wyniki</button></a>&nbsp&nbsp";
                                        echo "<a href='removeUser.php?username=" . $user->userName . "'><button type='button' class='btn btn-danger'>Usuń</button></a></td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            <tr>
                                <td>
                                    <input form="tableForm" autocomplete="off" required placeholder="Nazwa użytkownika" aria-label="Nazwa użytkownika" aria-describedby="basic-addon1" class="form-control" type="text" name="nickname">
                                </td>
                                <td>
                                    <input form="tableForm" autocomplete="false" required placeholder="Hasło" aria-label="Hasło" aria-describedby="basic-addon1" class="form-control" type="password" name="password">

                                </td>
                                <td>
                                    <input form="tableForm" style="display:none" type="radio" id="role1" name="role" value="student" checked>
                                    <input form="tableForm" style="display:none" type="radio" id="role1" name="classCode" value="<?php echo $currentUser->classCode ?>" checked>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary">Dodaj</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <div class="backMsg"><b>

                                <?php
                                if (isset($_SESSION["back-message"])) {
                                    echo "<br>" . $_SESSION["back-message"];
                                    unset($_SESSION["back-message"]);
                                }
                                ?>
                            </b>
                        </div>
            </div>
        </div>
    </div>

</body>

</html>