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
            echo 'tempWasteTypes = [...tempWasteTypes, {name : "' . $wasteName . '", area : ' . $amount . '}];';
        }
        ?>

        const wasteTypes = tempWasteTypes;
    </script>

    <script defer src="scripts/wasteInputJS.js"></script>
    <link rel="stylesheet" href="styles/wasteInput.css">
    <?php require("attachments/links.php") ?>
</head>

<body>

    <?php $filename = basename(__FILE__, '.php');
    require("attachments/navbar.php"); ?>

    <span class="notification"></span>
    <div class="container-fluid">
        <div class="inner">
            <h1 class="display-4">Wybierz</h1>
            <div class="types">

            </div>
            <div class="basket" style="display:none">
                <h1 class="display-4">Wybrane elementy</h1>
                <div class="basket-inner">
                </div>
                <button type="button" class="submit-button"><b>Zatwierdź dodanie</b></button>
            </div>
        </div>
    </div>
</body>

</html>