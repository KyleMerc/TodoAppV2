<?php
require "../model/config.php";

$check = [
    $user = $_POST["username"] ?? null,
    $pass = $_POST["password"] ?? null
];

check($user, $pass, $mysqli);

function check($user, $pass, $conn) {
    if ($user != null && $pass != null) {
        $query = "SELECT * FROM users WHERE username='$user' AND password='$pass'";
        
        $result = query($query, $conn);

        var_dump($result->fetch_assoc());
    }
}