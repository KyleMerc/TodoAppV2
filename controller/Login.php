<?php
require "loadFunction.php";

$user = $_POST["username"] ?? null;
$pass = $_POST["password"] ?? null;

$role_id = exist_user($user,$pass);

if($role_id == 1) {
    header("Location: ../views/admin/view_admin_home.php");
} elseif($role_id == 2 && is_verified($user)) {
    header("Location: ../views/user/view_user_home.php");
} elseif( ! is_verified($user)) {
    $_SESSION['status']['is_verified'] = false;
    header("Location: ../index.php");
} else {
    $_SESSION['status']['is_login'] = false;
    header("Location: ../index.php");
}


