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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

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
    if(isset($_SESSION["back-message"])) 
    {
        echo "<div class='alert alert-info alert-dismissable fade show'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".$_SESSION["back-message"]."</div>";
        unset($_SESSION["back-message"]);
    }
    ?>
    <div class="container">
        <h1 class="display center">Wszyscy użytkownicy</h1>
        <div class="row">

            <div class="col">
                <table class="table table-striped table-inverse">
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
                            echo "<td>".$user->userName."</td>";
                            echo "<td>".($user->role == "teacher" ? "Nauczyciel" : "Uczeń")."</td>";
                            echo "<td>".$schoolClass->name."</td>";
                            echo "<td>".$schoolClass->location."</td>";
                            echo "<td>".$schoolClass->teacher."</td>";
                            echo "<td>".$user->classCode."</td>";
                            echo "<td><a href='removeUser.php?username=".$user->userName."'><button class='btn btn-danger'>Usuń</button></a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</body>

</html>