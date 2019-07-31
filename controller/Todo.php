<?php
session_start();

require "../model/config.php";

if( ! isset($_SESSION)) {
    header("Location: ../index.php");
}

if( ! isset($_POST) || isset($_GET)) {
    header("Location: ../views/user/view_user_home.php");
}

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


if(isset($_POST["addContent"])) {
    $content = htmlspecialchars($_POST["addContent"]);
    $user_id = $_SESSION["status"]["user_id"];
    $sql = "INSERT INTO todos(content, user_id, status) 
            VALUES('$content', '$user_id', 'IN PROGRESS')";

   query($sql, $mysqli);
}

if(isset($_POST["editContent"])) {
    // var_dump($_POST); die;
    $content = htmlspecialchars($_POST["editContent"]);
    $status = $_POST["editRadStatus"];
    $todoID = $_POST["todoId"];
    $user_id = $_SESSION["status"]["user_id"];
    $sql = "UPDATE todos 
            SET date_updated=CURRENT_TIMESTAMP, content='$content', status='$status'
            WHERE todo_id='$todoID'";

    query($sql, $mysqli);
}

if(isset($_GET["delId"])) {
    $id = htmlspecialchars($_GET["delId"]);

    $sql = "DELETE FROM todos WHERE todo_id='$id'";
    query($sql, $mysqli);
}

header("Location: ../views/user/view_user_home.php");