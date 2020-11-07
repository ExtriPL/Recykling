<?php
session_start();
if (isset($_SESSION["isMaster"]) && $_SESSION["isMaster"]) {
    header("location:adminPanel.php");
    exit();
}
else if (!isset($_SESSION["loggedIn"]) || !$_SESSION["loggedIn"]) {
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

    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://www.pomysly-na.pl/wp-content/uploads/inspiracje/jak-kreatywnie-820x546.jpg');
        }
    </style>

    <!-- Bootstrap CSS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

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
                            <a class="nav-link" href="registerUser.php">Zarejestruj uczniów</a>
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
        <div class="row">
            <div class="col-lg-6 col-sm-12">
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
            <div class="col-lg-6 col-sm-12">
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
                                                    suggestedMax: cel,
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
                            <canvas id="wgCzasu" width="400" height="200"></canvas>
                            <script>
                                // let labels = [];

                                let dates = [new Date(2020, 9, 20), new Date(2020, 9, 21), new Date(2020, 9, 22), new Date()];
                                let days = ['Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela'];
                                let months = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];

                                function getLabel(date) {
                                    return days[date.getDay()] + " " + date.getDate() + " " + months[date.getMonth()];
                                }


                                var ctx = document.getElementById('wgCzasu').getContext('2d');
                                let chart = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        datasets: [{
                                            label: 'First dataset',
                                            data: [{
                                                x: dates[0],
                                                y: 100
                                            }, {
                                                x: dates[1],
                                                y: 400
                                            }, {
                                                x: dates[2],
                                                y: 700
                                            }, {
                                                x: dates[3],
                                                y: 1000
                                            }]
                                        }],
                                        labels: [getLabel(dates[0]), getLabel(dates[1]), getLabel(dates[2]), getLabel(dates[3])]
                                    },
                                    options: {
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    suggestedMin: 50,
                                                    suggestedMax: cel,
                                                    stepSize: 500
                                                }
                                            }]
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>