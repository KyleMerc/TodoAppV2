<?php
require "../model/config.php";

$user = $_POST["username"] ?? null;
$pass = $_POST["password"] ?? null;

// var_dump($user,$pass);die;
check($user, $pass, $mysqli);

function check($user, $pass, $conn) {
    $query = "SELECT * FROM users WHERE username='$user' AND password='$pass'";
    
    $result = query($query, $conn);
    $exist = mysqli_num_rows($result);
    // var_dump(mysqli_fetch_assoc($result)); die;
    if($exist) {
        session_start();

        $role_id = mysqli_fetch_assoc($result);
        // unset($_SESSION);
        // var_dump($_SESSION); die;
        // var_dump($role_id["user_role_id"]); die;
        $_SESSION["status"] = [
            "is_login" => true,
            "user" => $user,
            "user_id" => $role_id["user_id"]
        ];

        if($role_id["user_role_id"] == 1) {
            header("Location: ../views/admin/view_admin_home.php");
        }

        if($role_id["user_role_id"] == 2) {
            header("Location: ../views/user/view_user_home.php");
        }
    } else {
        header("Location: ../index.php");        
    }

    

    //var_dump($result->fetch_assoc());
   
}

