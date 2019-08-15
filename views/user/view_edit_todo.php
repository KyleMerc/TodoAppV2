<?php
session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

require $root . "/TODOapp/model/config.php";

if( ! isset($_SESSION["status"]["is_login"]) || $_SESSION["status"]["is_login"] == null) {
    header("Location: ../../index.php");
}

if( ! isset($_GET)) {
    header("Location: view_user_home.php");
}

$userCountTodo = $_GET['c'];

//Lack checking of GET parameters for admin
$todoId = $_GET["id"];
$user_id = $_SESSION["status"]["user_role_id"] == 1? $_GET["adminUserId"] : $_SESSION["status"]["user_id"];
$sql = "SELECT * FROM todos WHERE todo_id='$todoId' AND user_id='$user_id'";

$result = query($sql, $mysqli);

$data = mysqli_fetch_array($result);

$role_id = $_SESSION['status']['user_role_id'];
$todo_check = $todoId == $data["todo_id"];

$user_verify = ($role_id == 2 && $todo_check)? 'user' : 
                ($role_id == 1 && $todo_check)? 'admin' : false;
?>

<?php require "../template/header.php"; ?>
<div class="container-fluid">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <span data-feather="home"></span>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span data-feather="settings"></span>
                        Settings
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <main role="main" class="col-md-9 col-lg-10 ml-sm-auto px-4">
    <?php if($user_verify == 'user' || $user_verify == 'admin') : ?>
        <h3>Edit Todo # <?php echo $userCountTodo; ?></h3>

        <?php if($_SESSION["status"]["user_role_id"] == 2) : ?> <!-- User Edit Todo -->
            <form action="../../controller/Todo.php" class="form" method="post">
                <input type="hidden" name="todoId" value="<?php echo $_GET["id"]; ?>">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="" class="font-weight-bold">Date Created</label>
                        <input type="text" value="<?php echo date('M j Y g:i A', strtotime($data["date_created"])); ?>" class="form-control-plaintext" disabled>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="" class="font-weight-bold">Date Updated</label>
                        <input type="text" name="updateTime" value="<?php echo date('M j Y g:i A', strtotime($data["date_updated"])); ?>" class="form-control-plaintext" disabled>
                    </div>
                </div>

                <div class="form-group">
                        <label for="" class="font-weight-bold">Title</label>
                        <input type="text" class="form-control" name="title" value="<?php echo $data["title"]; ?>">
                </div>

                <div class="form-group">
                    <label for="" class="font-weight-bold">Status</label>
                </div>
                <div class="form-group form-check-inline">
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="editRadStatus" value="IN PROGRESS" checked>
                        <label for="" class="form-check-label">IN PROGRESS</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="editRadStatus" value="DONE">
                        <label for="" class="form-check-label">DONE</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="font-weight-bold">Todo</label>
                    <textarea cols="30" rows="10" class="form-control" name="editContent"><?php echo $data["content"]; ?></textarea>
                </div>

                <input type="submit" class="btn btn-primary" value="Submit" name="submit">
            </form>
         <?php elseif($_SESSION["status"]["user_role_id"] == 1) : ?> <!-- Admin Edit Todo -->
            <form action="../../controller/Todo.php" class="form" method="post">
                <input type="hidden" name="adminEditTodoId" value="<?php echo $_GET["id"]; ?>">
                <input type="hidden" name="adminUserId" value="<?php echo $user_id; ?>">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="" class="font-weight-bold">Date Created</label>
                        <input type="text" value="<?php echo date('M j Y g:i A', strtotime($data["date_created"])); ?>" class="form-control-plaintext" disabled>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="" class="font-weight-bold">Date Updated</label>
                        <input type="text" name="updateTime" value="<?php echo date('M j Y g:i A', strtotime($data["date_updated"])); ?>" class="form-control-plaintext" disabled>
                    </div>
                </div>

                <div class="form-group">
                        <label for="" class="font-weight-bold">Title</label>
                        <input type="text" class="form-control" name="title" value="<?php echo $data["title"]; ?>">
                </div>

                <div class="form-group">
                    <label for="" class="font-weight-bold">Status</label>
                </div>
                <div class="form-group form-check-inline">
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="editRadStatus" value="IN PROGRESS" checked>
                        <label for="" class="form-check-label">IN PROGRESS</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="editRadStatus" value="DONE">
                        <label for="" class="form-check-label">DONE</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="font-weight-bold">Todo</label>
                    <textarea cols="30" rows="10" class="form-control" name="adminEditContent"><?php echo $data["content"]; ?></textarea>
                </div>

                <input type="submit" class="btn btn-primary" value="Submit" name="submit">
            </form>
         <?php endif; ?>
    <?php else: ?>
        <div class="jumbotron">
            <div class="display-3 text-danger">Todo does not exist</div>
        </div>  
    <?php endif; ?>

    <?php 
        if($_SESSION["status"]["user_role_id"] == 1) {
            echo "<a href='../admin/view_admin_home.php?v_id=$user_id' class='btn btn-primary'>Go back</a>";
        } elseif($_SESSION["status"]["user_role_id"] == 2) {
            echo "<a href='view_user_home.php' class='btn btn-primary'>Go back</a>";
        }
    ?>
    </main>
</div>

<?php require "../template/footer.php"; ?>