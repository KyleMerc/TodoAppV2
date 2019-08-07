<?php
session_start();
// var_dump($_POST['newPassword'] === $_POST['confNewPassword']);die;
require "../model/config.php";
$user_id = $_POST['userId'];
// var_dump($_POST);die;
if( ! isset($_SESSION)) {
    header("Location: ../index.php");
}

if($_POST['newPassword'] !== $_POST['confNewPassword']) {
    $_SESSION['errorPass'] = true;
    
    header("Location: ../views/admin/view_admin_edit_user.php?id=$user_id");
    die;
} //Punan pag verification


if(isset($_POST["editUser"])) {
    $username = $_POST['newUsername'] == $_POST['oldUsername']? $_POST['oldUsername'] : $_POST['newUsername'];
    $password = $_POST["newPassword"] == ''? $_POST['oldPassword'] : password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
    //$user_id = $_POST['userId'];
    $sql = "UPDATE users
            SET username='$username', password='$password', date_updated=CURRENT_TIMESTAMP
            WHERE user_id='$user_id'";
            

   query($sql, $mysqli);
}

header("Location: ../views/admin/view_admin_home.php");