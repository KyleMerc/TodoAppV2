<?php
session_start();
// print_r($_POST);die;
require "../model/config.php";

// var_dump($_POST);die;
if( ! isset($_SESSION)) {
    header("Location: ../index.php");
}


if(isset($_POST["editUser"])) {
    $username = $_POST['newUsername'] == $_POST['oldUsername']? $_POST['oldUsername'] : $_POST['newUsername'];
    $password = $_POST["newPassword"] == ''? $_POST['oldPassword'] : password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
    $user_id = $_POST['userId'];
    $sql = "UPDATE users
            SET username='$username', password='$password', date_updated=CURRENT_TIMESTAMP
            WHERE user_id='$user_id'";
            

   query($sql, $mysqli);
}

header("Location: ../views/admin/view_admin_home.php");