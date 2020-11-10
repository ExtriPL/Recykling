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
} else if (!isset($_SESSION["isMaster"]) || !$_SESSION["isMaster"]) {
    header("location:index.php");
    exit();
}


if (isset($_GET["username"])) {
    SchoolClass::removeUser($_GET["username"]);
    $_SESSION["back-message"] = "Pomyślnie usunięto użytkownika " . $_GET["username"] . ".";
}
if (isset($_GET["classCode"])) {
    SchoolClass::removeClass($_GET["classCode"]);
    $_SESSION["back-message"] = "Pomyślnie klasę " . $_GET["classCode"] . ".";
}
if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
    header("location:teacherPanel.php");
    exit();
}
else
{
    header("location:adminPanel.php");
    exit();
}
