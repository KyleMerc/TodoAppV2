<?php
// Admin side

function check_username($user_id, $username, $conn) {
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