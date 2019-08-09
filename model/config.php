<?php
//This is for those who want to access the controllers
if( ! isset($_SESSION)) {
    header("Location: ../index.php");
}

$localhost = "127.0.0.1";
$user = "root";
$password = "";
$db = "tododb";

$mysqli = mysqli_connect($localhost, $user, $password, $db);

if (mysqli_connect_error()) {
    $logMessage = 'MySQL Error: ' . mysqli_connect_error();
    die('Could not connect to the database');
}

function query($query, $con) {
    return $con->query($query);
}