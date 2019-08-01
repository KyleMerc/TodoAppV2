<?php

require "../model/config.php";

$user = $_POST["username"] ?? null;
$pass = $_POST["password"] ?? null;

// var_dump($user,$encPass);die;
check($user, $pass, $mysqli);

function check($user, $pass, $conn) {
    $query = "SELECT * FROM users WHERE username='$user'";
    
    $result = query($query, $conn);

    $data = mysqli_fetch_assoc($result);

    $chk_pass = $data["password"];
    $v_pass = password_verify($pass, $chk_pass);

    $exist = mysqli_num_rows($result);
    // var_dump($exist, $data);die;
    // var_dump(mysqli_fetch_assoc($result)); die;
    if($exist && $v_pass) {
        session_start();
        // unset($_SESSION);
        // var_dump($_SESSION); die;
        // var_dump($role_id["user_role_id"]); die;
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
        header("Location: ../index.php");        
    }   
}

