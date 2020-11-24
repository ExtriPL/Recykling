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

    <?php require("attachments/links.php") ?>
</head>

<body>
    <?php $filename = basename(__FILE__, '.php');
    require("attachments/navbar.php"); ?>

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