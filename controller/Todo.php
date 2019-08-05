<?php
require "../model/config.php";
// var_dump($_POST);die;
session_start();

if( ! isset($_SESSION)) {
    header("Location: ../index.php");
}

if(isset($_POST["adminDelTodoId"])) {
    $todo_id = htmlspecialchars($_POST["adminDelTodoId"]);
    $user_id = htmlspecialchars($_POST["adminUserId"]);

    $sql = "DELETE FROM todos WHERE todo_id='$todo_id' AND user_id='$user_id'";
    query($sql, $mysqli);

    header("Location: ../views/admin/view_admin_home.php?v_id=$user_id");
    die;
}

if(isset($_POST["adminEditContent"])) {
    $todo_id = $_POST["adminEditTodoId"];
    $user_id = htmlspecialchars($_POST["adminUserId"]);
    $title = htmlspecialchars($_POST["title"]);
    $content = htmlspecialchars($_POST["adminEditContent"]);
    $status = $_POST["editRadStatus"];

    $sql = "UPDATE todos 
            SET date_updated=CURRENT_TIMESTAMP, title='$title', content='$content', status='$status'
            WHERE todo_id='$todo_id'";
    // var_dump($sql);die;
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
    $todo_id = $_POST["todoId"];
    $sql = "UPDATE todos 
            SET date_updated=CURRENT_TIMESTAMP, title='$title' ,content='$content', status='$status'
            WHERE todo_id='$todo_id'";

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