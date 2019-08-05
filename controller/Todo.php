<?php
require "../model/config.php";
// var_dump($_POST);die;
session_start();

if( ! isset($_SESSION)) {
    header("Location: ../index.php");
}

// if( ! isset($_POST) || ! isset($_GET)) {
//     header("Location: ../views/user/view_user_home.php");
// }

// echo getcwd(); die; 
// var_dump($_SESSION); die;

// $sql = "SELECT * FROM todos WHERE user_id='$user_id'";
// $result = getAllTodo($sql, $mysqli);
// $data = [];

    // var_dump(mysqli_fetch_assoc($result));
    // var_dump(mysqli_fetch_assoc($result)); die;

    // while($res = mysqli_fetch_assoc($result)) {
        // echo $res["user_id"] . "<br />" . $res["content"] . "<br />" . $res["status"] . "<br />";
    //     $data[] = $res;
    // }   
    // die;
    // print_r($data); die;
    
// var_dump($_SESSION["list"]);die;
// var_dump($_POST, $_GET);die;
if(isset($_POST["adminDelTodo"])) {
    $todo_id = htmlspecialchars($_POST["adminDelTodo"]);
    $user_id = htmlspecialchars($_POST["userId"]);

    $sql = "DELETE FROM todos WHERE todo_id='$todo_id' AND user_id='$user_id'";
    query($sql, $mysqli);

    header("Location: ../views/admin/view_admin_home.php?v_id=$user_id");
    die;
}

if(isset($_POST["adminAddContent"])) {
    $title = htmlspecialchars($_POST["title"]);
    $content = htmlspecialchars($_POST["adminAddContent"]);
    $user_id = $_POST["v_id"];
    $sql = "INSERT INTO todos(title, content, user_id, status) 
            VALUES('$title', '$content', '$user_id', 'IN PROGRESS')";

   query($sql, $mysqli);

   header("Location: ../views/admin/view_admin_home.php?v_id=$user_id");
   die;
}

if(isset($_POST["userDelId"])) {
    $userDelId = htmlspecialchars($_POST["userDelId"]);

    $sql = "DELETE FROM users WHERE user_id='$userDelId'";

    query($sql, $mysqli);
}




if(isset($_POST["addContent"])) {
    $title = htmlspecialchars($_POST["title"]);
    $content = htmlspecialchars($_POST["addContent"]);
    $user_id = $_SESSION["status"]["user_id"];
    $sql = "INSERT INTO todos(title, content, user_id, status) 
            VALUES('$title', '$content', '$user_id', 'IN PROGRESS')";
    // var_dump($sql);die;
   query($sql, $mysqli);
}

if(isset($_POST["editContent"])) {
    // var_dump($_POST); die;
    $title = htmlspecialchars($_POST["title"]);
    $content = htmlspecialchars($_POST["editContent"]);
    $status = $_POST["editRadStatus"];
    $todoID = $_POST["todoId"];
    $user_id = $_SESSION["status"]["user_id"];
    $sql = "UPDATE todos 
            SET date_updated=CURRENT_TIMESTAMP, title='$title' ,content='$content', status='$status'
            WHERE todo_id='$todoID'";

    query($sql, $mysqli);
}

if(isset($_POST["delId"])) {
    $id = htmlspecialchars($_POST["delId"]);
    $user_id = htmlspecialchars($_POST["userId"]);

    $sql = "DELETE FROM todos WHERE todo_id='$id'";
    query($sql, $mysqli);
}

if($_SESSION["status"]["user_role_id"] == 2) {
    header("Location: ../views/user/view_user_home.php");
} elseif($_SESSION["status"]["user_role_id"] == 1) {
    header("Location: ../views/admin/view_admin_home.php");
}