<?php
if(!isset($_REQUEST["d"]))
{
    header("location:index.php");
    exit();
}
else
{
$data = $_REQUEST["d"];

session_start();
include("Systems/user.php");

$user = User::loadUser($_SESSION["userName"]);
$waste = json_decode($data, true);
$user->addWastesAndSave($waste);

echo "Dodano wybrane elementy do twojej listy zebranych odpadków.";
}

?>