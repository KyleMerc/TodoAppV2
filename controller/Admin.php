<?php
session_start();
// var_dump($_POST);die;
require "../model/config.php";

// var_dump($_POST);die;
if( ! isset($_SESSION)) {
    header("Location: ../index.php");
}

$user_id = $_POST['userId'];
$username = $_POST['newUsername'] == $_POST['oldUsername']? $_POST['oldUsername'] : $_POST['newUsername'];

//Check other usernames if it already exists 
$sql = "SELECT user_id, username FROM users";

$result = query($sql, $mysqli);

while($data = mysqli_fetch_assoc($result)) {
    $data_check[] = $data;
}
foreach($data_check as $row){
    if($username == $row['username']) {
        if($row['user_id'] == $user_id || $row['username'] == 'admin') {
            continue;
        }

        $_SESSION['errorUsername'] = true;
        header("Location: ../views/admin/view_admin_edit_user.php?id=$user_id");
        die;
    }
}
//---------------

//Check new password for edited user
if($_POST['newPassword'] !== $_POST['confNewPassword']) {
    $_SESSION['errorPass'] = true;
    
    header("Location: ../views/admin/view_admin_edit_user.php?id=$user_id");
    die;
}
//------------

if(isset($_POST['editGoBack'])) {
    unset($_SESSION['errorPass'], $_SESSION['errorUsername']);
}

if(isset($_POST["editUser"])) {
    $password = $_POST["newPassword"] == ''? $_POST['oldPassword'] : password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
    
    //$user_id = $_POST['userId'];
    $sql = "UPDATE users
            SET username='$username', password='$password', date_updated=CURRENT_TIMESTAMP
            WHERE user_id='$user_id'";
            

   query($sql, $mysqli);
}

header("Location: ../views/admin/view_admin_home.php");