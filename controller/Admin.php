<?php
session_start();
// var_dump($_POST);die;
// require "../model/config.php";
require "loadFunction.php";


if( ! isset($_SESSION)) {
    header("Location: ../index.php");
}

$user_id = $_POST['userId'];
$username = $_POST['newUsername'] == $_POST['oldUsername']? $_POST['oldUsername'] : $_POST['newUsername'];

//Check other usernames if it already exists 
check_other_username($user_id, $username, $mysqli);

function check_other_username($user_id, $username, $conn) {
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
//------------------

//Admin error sessions
erase_error_sess();

function erase_error_sess() {
    if(isset($_POST['actionAdminGoBack']) && $_POST['actionAdminGoBack'] == 'Go Back') {
        unset($_SESSION['error']);
        header("Location: ../views/admin/view_admin_home.php");
        die;
    }
}
//----------

//Check new password for edited user
check_password($user_id);

function check_password($user_id) {
    if(($_POST['newPassword'] !== $_POST['confNewPassword']) || empty($_POST['newPassword'])) {
        $_SESSION['error']['errorPass'] = true;
        header("Location: ../views/admin/view_admin_edit_user.php?id=$user_id");
        die;
    }
}
//------------

//Admin edit user account


if(isset($_POST["editUser"])) {
    $password = $_POST["newPassword"] == ''? $_POST['oldPassword'] : password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
    
    $data = [
        'username' => $username,
        'password' => $password,
        'user_id' => $user_id
    ];
    
    update_user($data);
    
    header("Location: ../views/admin/view_admin_home.php");
    die;
}

//------------