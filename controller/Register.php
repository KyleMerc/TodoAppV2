<?php

require "loadFunction.php";
require_once "../vendor/autoload.php";

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

session_start();

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
        $mail = new PHPMailer(true);

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
            
            $vkey = md5(time().$user);
            $insert_sql = "INSERT INTO users(username, password, user_role_id, firstname, lastname, email, vkey) 
                            VALUES('$user', '$encPass', 2, '$firstName', '$lastName', '$email', '$vkey')";
            query($insert_sql, $conn);
            
            
            //----Send Mail
                //Server settings
                $mail->SMTPDebug = 2;                                       // Enable verbose debug output
                $mail->isSMTP();                                            // Set mailer to use SMTP
                $mail->Host       = 'smtp.mail.yahoo.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'kyle.fst@yahoo.com';                     // SMTP username
                $mail->Password   = 'CYK%BDcxJRm7Rwd';                               // SMTP password
                $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
                $mail->Port       = 465;                                    // TCP port to connect to
            
                //Recipients
                $mail->setFrom('kyle.fst@yahoo.com', 'TodoApp');
                $mail->addAddress($email, $firstName.' '.$lastName);     // Add a recipient
                
                //Body
                $body = "To verify your account <br /><a href='192.168.64.2/TODOapp/views/user/view_verify.php?vkey=$vkey'>Click Here</a>";
                
                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Email Verification';
                $mail->Body    = $body;
                // $mail->AltBody = strip_tags($body);
            
                $mail->send();

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
