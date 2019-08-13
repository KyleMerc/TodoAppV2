<?php
session_start();
require_once "../model/config.php";

//Email verification
function send_verification() {
    
}

function verify_key($vkey){
    $sql = "SELECT * FROM users WHERE verified = 0 AND vkey = '$vkey";

    $check = $GLOBALS['mysqli']->query($sql);

    if($check->num_rows() == 1) {
        $update_sql = "UPDATE users SET verified = 1 WHERE vkey = '$vkey";
        $GLOBALS['mysqli']->query($update_sql);

        return true;
    }

    return false;
}

// Check Users
function is_verified($username) {
    $sql = "SELECT verified FROM users WHERE username='$username'";

    $result = $GLOBALS['mysqli']->query($sql);
    $check = mysqli_fetch_assoc($result);

    if($check['verified']) return true;
    
    return false;
}

function exist_user($user, $pass) {
    $sql = "SELECT * FROM users WHERE username='$user'";
    
    $result = $GLOBALS['mysqli']->query($sql);

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
            return 1;
        }

        if($data["user_role_id"] == 2) {
            return 2;
        }
    } else return null;
}

// Admin side

function check_username($user_id, $username, $conn) {
    $sql = "SELECT user_id, username FROM users";

    $result = query($sql, $conn);

    if(empty($username)) {
        $_SESSION['error']['emptyUsername'] = true;
        header("Location: ../views/admin/view_admin_edit_user.php?id=$user_id");
        die;
    }

    while($data = mysqli_fetch_assoc($result)) {
        $data_check[] = $data;
    }
    foreach($data_check as $row){
        if($username == $row['username']) {
            if($row['user_id'] == $user_id) continue;
            
            $_SESSION['error']['errorUsername'] = true;
            header("Location: ../views/admin/view_admin_edit_user.php?id=$user_id");
            die;
        }
    }
}