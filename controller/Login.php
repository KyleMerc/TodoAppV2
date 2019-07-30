<?php
require "../model/config.php";

$check = [
    $user = $_POST["username"] ?? null,
    $pass = $_POST["password"] ?? null
];
// var_dump($user,$pass);die;
check($user, $pass, $mysqli);

function check($user, $pass, $conn) {
    $query = "SELECT * FROM users WHERE username='$user' AND password='$pass'";
    
    $result = query($query, $conn);
    $exist = mysqli_num_rows($result);
    // var_dump($exist);
    if($exist) {
        session_start();


    } else {
        header("Location: ../index.php");        
    }

    

    //var_dump($result->fetch_assoc());
   
}

