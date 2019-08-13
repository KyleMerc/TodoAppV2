<?php

require "loadFunction.php";


$conn = $mysqli;

register($conn);

function register($conn) {
    if(isset($_POST["register"])) {
        $firstName = htmlspecialchars($_POST['firstName']);
        $lastName = htmlspecialchars($_POST['lastName']);
        $email = htmlspecialchars($_POST['email']);
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

        // $verify_sql = "SELECT * FROM users WHERE username='$user'";
        // $result = query($verify_sql, $conn);
        $exist = check_username($user);


        //encrypt password
        $encPass = password_hash($pass, PASSWORD_DEFAULT);

        if( ! $exist) {
            
            $vkey = md5(time().$user);
            $insert_sql = "INSERT INTO users(username, password, user_role_id, firstname, lastname, email, vkey) 
                            VALUES('$user', '$encPass', 2, '$firstName', '$lastName', '$email', '$vkey')";
            query($insert_sql, $conn);
            
            send_verification($email, $vkey);

            header("Location: ../views/user/thankyou.php");
            die;
        } else {
            $_SESSION["v_user"] = 'existUser';
            header("Location: ../views/user/view_register.php");
            die;
        }

    } else {
        header("Location: ../index.php");
    }
}
