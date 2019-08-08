<?php
 session_start();

require "../model/config.php";

$user = $_POST["username"] ?? null;
$pass = $_POST["password"] ?? null;


check($user, $pass, $mysqli);

function check($user, $pass, $conn) {
    $query = "SELECT * FROM users WHERE username='$user'";
    
    $result = query($query, $conn);

    $data = mysqli_fetch_assoc($result);

    $chk_pass = $data["password"];
    $v_pass = password_verify($pass, $chk_pass);

    $exist = mysqli_num_rows($result);
    if($exist && $v_pass) {
        $_SESSION["status"] = [
            "is_login" => true,
            "user" => $user,
            "user_id" => $data["user_id"],
            "user_role_id" => $data["user_role_id"]
        ];

        if($data["user_role_id"] == 1) {
            header("Location: ../views/admin/view_admin_home.php");
        }

        if($data["user_role_id"] == 2) {
            header("Location: ../views/user/view_user_home.php");
        }
    } else {
        $_SESSION["status"]["is_login"] = false;
        header("Location: ../index.php");        
    }   
}

