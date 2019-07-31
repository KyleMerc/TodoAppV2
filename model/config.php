<?php
if( ! isset($_SESSION)) {
    header("Location: ../index.php");
}

$localhost = "127.0.0.1";
$user = "root";
$password = "";
$db = "tododb";

$mysqli = mysqli_connect($localhost, $user, $password, $db);

// if (!$mysqli) {
//     echo "Error: Unable to connect to MySQL." . PHP_EOL;
//     echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
//     echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
//     exit;
// }


if (mysqli_connect_error()) {
    $logMessage = 'MySQL Error: ' . mysqli_connect_error();
    // Call your logger here.
    die('Could not connect to the database');
}

//$result = $mysqli->query("SELECT * FROM users WHERE user='admin' AND password='admin'");
//$result = "SELECT * FROM users WHERE username='admin' AND password='admin'";
// $row = $result->fetch_assoc();
// echo htmlentities($row['_message']);
//var_dump(query($result, $mysqli));

function query($query, $con) {
    return $con->query($query);
}