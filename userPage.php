<?php
include("Systems/schoolClass.php");
session_start();
if (isset($_SESSION["isMaster"]) && $_SESSION["isMaster"]) {
    header("location:adminPanel.php");
    exit();
} else if (!isset($_SESSION["loggedIn"]) || !$_SESSION["loggedIn"]) {
    header("location:index.php");

    exit();
} else if (isset($_GET["userName"])) {
    $currentUser = User::loadUser($_SESSION["userName"]);
    if ($currentUser->isStudent()) {
        header("location:userPage.php");
        exit();
    }
}
?>
<html lang='pl'>

<head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <script src="scripts/datapoints.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
    <?php require("attachments/links.php") ?>
</head>

<body>
    <?php $filename = basename(__FILE__, '.php');
    require("attachments/navbar.php"); ?>
    <?php
    function array_push_assoc($array, $key, $value)
    {
        $array[$key] = $value;
        return $array;
    }

    $startDate = new DateTime("2020-9-1");
    $endDate = new DateTime();
    $diff = date_diff($startDate, $endDate)->format('%a');

    $allTimeDatapoints = array();
    $thisMonthDatapoints = array();
    $thisWeekDatapoints = array();
    $user = User::loadUser($currentuserName);

    for ($i = 0; $i < 30; $i++) {
        //  echo floor($i*($diff/30));
        $startDate = new DateTime("2020-12-7");
        $t = floor($i * ($diff / 30));
        $date = date_add($startDate, new DateInterval("P" . $t . "D"));
        $date = $date->format("Y-m-d");
        $allTimeDatapoints = array_push_assoc($allTimeDatapoints, $date, $user->getWastesAreaToDate($date));
    }
    $allTimeDatapoints = JSON_encode($allTimeDatapoints);
    // echo $datapoints;

    //miesiac
    for ($i = 30; $i >= 0; $i--) {
        $endDate = new DateTime();
        $date = date_sub($endDate, new DateInterval("P" . $i . "D"));
        $date = $date->format("Y-m-d");
        // SchoolClass::getWastesAreaToDateOfAll($date)
        $thisMonthDatapoints = array_push_assoc($thisMonthDatapoints, $date, $user->getWastesAreaToDate($date));
    }

    $thisMonthDatapoints = JSON_encode($thisMonthDatapoints);

    //tydzien
    for ($i = 7; $i >= 0; $i--) {
        $endDate = new DateTime();
        $date = date_sub($endDate, new DateInterval("P" . $i . "D"));
        $date = $date->format("Y-m-d");
        // SchoolClass::getWastesAreaToDateOfAll($date)
        $thisWeekDatapoints = array_push_assoc($thisWeekDatapoints, $date, $user->getWastesAreaToDate($date));
    }
    $thisWeekDatapoints = JSON_encode($thisWeekDatapoints);

    ?>



    <?php
    if (isset($_SESSION["loggedIn"])) {
        if (isset($_GET["userName"])) echo "<div class='jumbotron'>
                <h4>Podgląd danych użytkownika " . $currentuserName . "</h4>
                </div>";
    }
    ?>

    <div class="container">
        <div class="row">
            <div class="col center">
                <div class="jumbotron">
                    <h1 class="">Suma zebranych przez Ciebie butelek</h1>
                    <p class="display-1">
                        <?php
                        $currentUser = User::loadUser($currentuserName);
                        echo $currentUser->getWastesArea() . " m2";
                        ?></p>
                </div>
            </div>
            <div class="col center">
                <div class="jumbotron">
                    <h1 class="">Suma zebranych przez Twoją klasę butelek</h1>
                    <p class="display-1">
                        <?php
                        $currentUser = User::loadUser($currentuserName);
                        $currentClass = SchoolClass::loadClass($currentUser->classCode);
                        echo $currentClass->getWastesArea() . " m2";
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <?php if (!isset($_GET["userName"])) echo
            '<div class="row">
            <div class="col center">
                <div class="jumbotron">
                    <a class="btn btn-primary btn-lg" href="wasteInput.php">Dodaj zebrane odpadki</a>
                </div>
            </div>
        </div>'
        ?>
        <div class="row">
            <div class="col">
                <div class="jumbotron">
                    <h1 class="display-3 center">Ilość zebrana przez użytkownika</h1><br>
                    <span style="text-align:center">
                    <button class="btn btn-primary" id="all">Cały okres zbierania</button> <button class="btn btn-primary" id="month">Miesiąc</button> <button class="btn btn-primary" id="week">Tydzień</button>
                    </span>
                    <canvas id="wgCzasu" width="400" height="200"></canvas>
                    <script>
                        const allTimeAmounts = <?php echo $allTimeDatapoints ?>;
                        const thisMonthAmounts = <?php echo $thisMonthDatapoints ?>;
                        const thisWeekAmounts = <?php echo $thisWeekDatapoints ?>;
                        let datapoints = [];
                        let labels = [];

                        document.querySelector("#all").addEventListener('click', () => {
                            prepareDatapoints(allTimeAmounts);
                        });

                        document.querySelector("#month").addEventListener('click', () => {
                            prepareDatapoints(thisMonthAmounts);
                        });

                        document.querySelector("#week").addEventListener('click', () => {
                            prepareDatapoints(thisWeekAmounts);
                        });

                        prepareChart();
                        prepareDatapoints(allTimeAmounts);
                    </script>
                </div>
            </div>
        </div>
    </div>
</body>

</html>