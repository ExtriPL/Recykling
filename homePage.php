<?php
session_start();
if (isset($_SESSION["isMaster"]) && $_SESSION["isMaster"]) {
    header("location:adminPanel.php");
    exit();
} else if (!isset($_SESSION["loggedIn"]) || !$_SESSION["loggedIn"]) {
    header("location:index.php");

    exit();
}
include("Systems/schoolClass.php");
?>

<!-- <!DOCTYPE html> -->
<html lang='pl'>

<head>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
    <script src="scripts/datapoints.js"></script>
    <?php require("attachments/links.php") ?>
    <title>Strona główna</title>

</head>

<body>

    <?php $filename = basename(__FILE__, '.php');
    require("attachments/navbar.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="jumbotron">
                    <h1 class="display-4 center">Razem zebraliśmy do tej pory:</h1>
                    <div class="display-1 center" style="display:flex;justify-content:center;align-items:center">
                        <?php
                        $data = SchoolClass::getWastesAreaOfAll();
                        $cel = 1000000;
                        echo $data;
                        echo "<script>let data = $data, cel = $cel</script>"
                        //suma pól odpadków wszystkich klas

                        //suma pól odpadków danego użytkownika w ostatnim dniu, tygodniu, miesiacu, roku
                        //to samo do klasy
                        //to samo do wszystkich
                        ?>
                        m2
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="row">
                    <div class="col">
                        <div class="jumbotron">
                            <h1 class="display-3 center">Ile zostało nam do celu?</h1>
                            <canvas id="cel" width="400" height="100"></canvas>
                            <script>
                                let min = 0;
                                var ctx = document.getElementById('cel').getContext('2d');
                                var myChart = new Chart(ctx, {
                                    type: 'horizontalBar',
                                    data: {
                                        labels: ['Progress'],
                                        datasets: [{
                                            label: 'Pole zebranych odpadków',
                                            data: [data],
                                            backgroundColor: [
                                                'rgba(97, 147, 255, 0.2)'
                                            ],
                                            borderColor: [
                                                'rgba(97, 147, 255, 1)'
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            xAxes: [{
                                                ticks: {
                                                    suggestedMin: min,
                                                    // suggestedMax: cel,
                                                    beginAtZero: true
                                                }
                                            }]
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="jumbotron">
                            <h1 class="display-3 center">Ilość zebrana przez wszystkich</h1><br>
                            <button class="btn btn-primary" id="all">Cały okres zbierania</button> <button class="btn btn-primary" id="month">Miesiąc</button> <button class="btn btn-primary" id="week">Tydzień</button>
                            <canvas id="wgCzasu" width="400" height="200"></canvas>
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

                            for ($i = 0; $i < 30; $i++) {
                                //  echo floor($i*($diff/30));
                                $startDate = new DateTime("2020-9-1");
                                $t = floor($i * ($diff / 30));
                                $date = date_add($startDate, new DateInterval("P" . $t . "D"));
                                $date = $date->format("Y-m-d");
                                $allTimeDatapoints = array_push_assoc($allTimeDatapoints, $date, SchoolClass::getWastesAreaToDateOfAll($date));
                            }
                            $allTimeDatapoints = JSON_encode($allTimeDatapoints);
                            // echo $datapoints;

                            //miesiac
                            for ($i = 30; $i >= 0; $i--) {
                                $endDate = new DateTime();
                                $date = date_sub($endDate, new DateInterval("P" . $i . "D"));
                                $date = $date->format("Y-m-d");
                                // SchoolClass::getWastesAreaToDateOfAll($date)
                                $thisMonthDatapoints = array_push_assoc($thisMonthDatapoints, $date, SchoolClass::getWastesAreaToDateOfAll($date));
                            }

                            $thisMonthDatapoints = JSON_encode($thisMonthDatapoints);

                            //tydzien
                            for ($i = 7; $i >= 0; $i--) {
                                $endDate = new DateTime();
                                $date = date_sub($endDate, new DateInterval("P" . $i . "D"));
                                $date = $date->format("Y-m-d");
                                // SchoolClass::getWastesAreaToDateOfAll($date)
                                $thisWeekDatapoints = array_push_assoc($thisWeekDatapoints, $date, SchoolClass::getWastesAreaToDateOfAll($date));
                            }
                            $thisWeekDatapoints = JSON_encode($thisWeekDatapoints);

                            ?>

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
        </div>
    </div>
</body>

</html>