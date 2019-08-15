<?php
$root = $_SERVER['DOCUMENT_ROOT'];

require $root . "/TODOapp/controller/loadFunction.php";


if( ! isset($_SESSION)) {
    header("Location: ../index.php");
}

$conn = $mysqli;

//Delete Todo from admin
admin_del_todo($conn);

function admin_del_todo($conn) {
    if(isset($_POST["adminDelTodoId"])) {
        $todo_id = htmlspecialchars($_POST["adminDelTodoId"]);
        $user_id = htmlspecialchars($_POST["adminUserId"]);
    
        $sql = "DELETE FROM todos WHERE todo_id='$todo_id' AND user_id='$user_id'";
        query($sql, $conn);
    
        header("Location: ../views/admin/view_admin_home.php?v_id=$user_id");
        die;
    }
}
//---------------

//Edit Todo from admin
admin_edit_todo($conn);

function admin_edit_todo($conn) {
    if(isset($_POST["adminEditContent"])) {
        $todo_id = $_POST["adminEditTodoId"];
        $user_id = htmlspecialchars($_POST["adminUserId"]);
        $title = strip_tags(addslashes( $_POST["title"]));
        $content = strip_tags(addslashes($_POST["adminEditContent"]));
        $status = $_POST["editRadStatus"];

        $sql = "UPDATE todos 
                SET date_updated=CURRENT_TIMESTAMP, title='$title', content='$content', status='$status'
                WHERE todo_id='$todo_id'";

        query($sql, $conn);
        header("Location: ../views/admin/view_admin_home.php?v_id=$user_id");
        die;
    }
}
//---------------------

//Add Todo from admin
admin_add_todo($conn);

function admin_add_todo($conn) {
    if(isset($_POST["adminAddContent"])) {
        $title = strip_tags($_POST["title"]);
        $content = strip_tags(addslashes($_POST["adminAddContent"]));
        $user_id = $_POST["v_id"];
        $sql = "INSERT INTO todos(title, content, user_id, status) 
                VALUES('$title', '$content', '$user_id', 'IN PROGRESS')";

    query($sql, $conn);

    header("Location: ../views/admin/view_admin_home.php?v_id=$user_id");
    die;
    }
}
//----------------

//Delete user from admin
admin_del_user($conn);

function admin_del_user($conn){
    if(isset($_POST["userDelId"])) {
        $userDelId = htmlspecialchars($_POST["userDelId"]);

        $sql = "DELETE FROM users WHERE user_id='$userDelId'";

        query($sql, $conn);
    }
}
//----------------

//Add Todo from user
user_add_todo($conn);

function user_add_todo($conn) {
    if(isset($_POST["addContent"])) {
        $title = strip_tags(addslashes($_POST["title"]));
        $content = strip_tags(addslashes($_POST["addContent"]));
        $user_id = $_SESSION["status"]["user_id"];
        $sql = "INSERT INTO todos(title, content, user_id, status) 
                VALUES('$title', '$content', '$user_id', 'IN PROGRESS')";
    
        query($sql, $conn);
    }
}
//---------------

//Edit Todo from user
user_edit_todo($conn);

function user_edit_todo($conn) {
    if(isset($_POST["editContent"])) {
        $title = strip_tags($_POST["title"]);
        $content = strip_tags($_POST["editContent"]);
        $status = $_POST["editRadStatus"];
        $todo_id = $_POST["todoId"];
        $sql = "UPDATE todos 
                SET date_updated=CURRENT_TIMESTAMP, title='$title' ,content='$content', status='$status'
                WHERE todo_id='$todo_id'";

        query($sql, $conn);
    }
}
//-----------------

//Delete Todo from user
user_del_todo($conn);

function user_del_todo($conn) {
    if(isset($_POST["delId"])) {
        $id = htmlspecialchars($_POST["delId"]);
        $user_id = htmlspecialchars($_POST["userId"]);

        $sql = "DELETE FROM todos WHERE todo_id='$id'";
        query($sql, $conn);
    }
}
//---------------

if($_SESSION["status"]["user_role_id"] == 2) {
    header("Location: ../views/user/view_user_home.php");
} elseif($_SESSION["status"]["user_role_id"] == 1) {
    header("Location: ../views/admin/view_admin_home.php");
}