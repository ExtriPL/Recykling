<?php
session_start();
if (!isset($_SESSION["isMaster"]) || !$_SESSION["isMaster"]) {
    header("location:index.php");
    exit();
}

include("Systems/schoolClass.php");

if(isset($_GET["username"])){
SchoolClass::removeUser($_GET["username"]);
$_SESSION["back-message"] = "Pomyślnie usunięto użytkownika ".$_GET["username"].".";
}
    header("location:adminPanel.php");
    exit();
?>