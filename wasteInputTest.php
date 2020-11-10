<?php
session_start();
if (isset($_SESSION["isMaster"]) && $_SESSION["isMaster"]) {
    header("location:adminPanel.php");
    exit();
} else if (!isset($_SESSION["loggedIn"]) || !$_SESSION["loggedIn"]) {
    header("location:index.php");

    exit();
}
include("Systems/user.php");
if (isset($_POST["data"])) {
    $user = User::loadUser($_SESSION["userName"]);
    $waste = json_decode($_POST["data"], true);
    $user->addWastesAndSave($waste);
}
?>
<html lang='pl'>

<head>




    <meta charset='utf-8'>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <script>
        let tempWasteTypes = [];

        <?php
        foreach (Waste::loadWastes() as $wasteName => $amount) {
            // echo "<option value ='$wasteName'>$wasteName</option>";
            echo 'tempWasteTypes = [...tempWasteTypes, {name : "' . $wasteName . '", area : ' . $amount . '}];';
        }
        ?>

        const wasteTypes = tempWasteTypes;
    </script>

    <script defer src="wasteInputJSTest.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="wasteInput.css">
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
                    <a class="nav-link" href="homePage.php">Główna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="userPage.php">Strona użytkownika </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="wasteInput.php">Dodaj odpadki</a>
                </li>
                <?php
                $currentuserName = $_SESSION["userName"];
                $currentUser = User::loadUser($_SESSION["userName"]);
                if (!($currentUser->isStudent())) {
                    echo '
                        <li class="nav-item">
                            <a class="nav-link" href="teacherPanel.php">Panel klasy</a>
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



    <div class="container-fluid">
        <div class="inner">
            <h1 class="display-4">Wybierz</h1>
            <div class="types">

            </div>
            <div class="basket" style="display:none">
                <h1 class="display-4" >Wybrane elementy</h1>
                <div class="basket-inner">
                </div>
            </div>
        </div>
    </div>
</body>

</html>