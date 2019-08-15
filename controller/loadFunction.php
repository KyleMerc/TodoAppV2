<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];

require_once $root . "/TODOapp/model/config.php";
require_once $root . "/TODOapp/vendor/autoload.php";

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

//Email verification
function send_verification($email, $vkey) {
     //----Send Mail
     $mail = new PHPMailer(true);

    //Server settings
    $mail->SMTPDebug = 2;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.mail.yahoo.com';                  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'kyle.fst@yahoo.com';                   // SMTP username
    $mail->Password   = 'CYK%BDcxJRm7Rwd';                      // SMTP password
    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('kyle.fst@yahoo.com', 'TodoApp');
    $mail->addAddress($email);     // Add a recipient
    
    //Body
    $body = "To verify your account <br /><a href='192.168.64.2/TODOapp/views/user/view_verify.php?vkey=$vkey'>Click Here</a>";
    
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Email Verification';
    $mail->Body    = $body;
    // $mail->AltBody = strip_tags($body);

    $mail->send();

}

function verify_key($vkey){
    $sql = "SELECT * FROM users WHERE verified = 0 AND vkey = '$vkey";

    $check = $GLOBALS['mysqli']->query($sql);

    if(mysqli_num_rows($check) == 1) {
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

    //For log in
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

function check_username($username) {
    $sql = "SELECT username FROM users WHERE username = '$username'";

    $result = $GLOBALS['mysqli']->query($sql);
    
    if(mysqli_num_rows($result) == 1) return true;
    
    return false;
}


//Admin side

function insert_user($data){
    $user = $data['user'];
    $encPass = $data['pass'];
    $role_id = $data['user_role_id'];
    $firstName = $data['firstName'];
    $lastName = $data['lastName'];
    $email = $data['email'];
    $vkey = $data['vkey'];

    $sql = "INSERT INTO users(username, password, user_role_id, firstname, lastname, email, vkey) 
            VALUES('$user', '$encPass', '$role_id', '$firstName', '$lastName', '$email', '$vkey')";
    
    $GLOBALS['mysqli']->query($sql);
    return;
}

function update_user($data) {
    $firstName = $data['firstname'];
    $lastName = $data['lastname'];
    $username = $data['username'];
    $password = $data['password'];
    $user_id = $data['user_id'];

    $sql = "UPDATE users
            SET firstname='$firstName', lastname='$lastName', username='$username', password='$password', date_updated=CURRENT_TIMESTAMP
            WHERE user_id='$user_id'";
    
    $GLOBALS['mysqli']->query($sql);
    return;
}

function error_password() {
    return $_SESSION['error']['errorPass'] = true;
}

function unset_error_sess() {
    unset($_SESSION['error']);
    return;
}

// function check_other_username() {

// }