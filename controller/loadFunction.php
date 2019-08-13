<?php
session_start();
require_once "../model/config.php";
require_once "../vendor/autoload.php";

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

function insert_user(){
    
}

// Admin side
// function check_username($user_id, $username, $conn) {
//     $sql = "SELECT user_id, username FROM users";

//     $result = query($sql, $conn);

//     if(empty($username)) {
//         $_SESSION['error']['emptyUsername'] = true;
//         header("Location: ../views/admin/view_admin_edit_user.php?id=$user_id");
//         die;
//     }

//     while($data = mysqli_fetch_assoc($result)) {
//         $data_check[] = $data;
//     }
//     foreach($data_check as $row){
//         if($username == $row['username']) {
//             if($row['user_id'] == $user_id) continue;
            
//             $_SESSION['error']['errorUsername'] = true;
//             header("Location: ../views/admin/view_admin_edit_user.php?id=$user_id");
//             die;
//         }
//     }
// }