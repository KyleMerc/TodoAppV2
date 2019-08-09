<?php
require "../model/config.php";

session_start();

$conn = $mysqli;

register($conn);

function register($conn) {
    if(isset($_POST["register"])) {
        $user = htmlspecialchars($_POST["username"]);
        $pass = htmlspecialchars($_POST["password"]);
        $confPass = htmlspecialchars($_POST["confPassword"]);

        if(empty($user)) {
            $_SESSION['emptyUser'] = 'emptyUser';
            header("Location: ../views/user/view_register.php");
            die;
        }

        if($pass != $confPass || empty($pass) || empty($confPass)) {
            $_SESSION["v_pass"] = true;
            header("Location: ../views/user/view_register.php");
            die;
        }

        $verify_sql = "SELECT * FROM users WHERE username='$user'";
        $result = query($verify_sql, $conn);
        $exist = mysqli_num_rows($result);

        //encrypt password
        $encPass = password_hash($pass, PASSWORD_DEFAULT);

        if( ! $exist) {
            $insert_sql = "INSERT INTO users(username, password, user_role_id) VALUES('$user', '$encPass', 2)";
            query($insert_sql, $conn);
            header("Location: ../index.php");
        } else {
            $_SESSION["v_user"] = 'existUser';
            header("Location: ../views/user/view_register.php");
            die;
        }

    } else {
        header("Location: ../index.php");
    }
}