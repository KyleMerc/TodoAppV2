<?php
// var_dump($_GET);
session_start();

require "../../model/config.php";

if( ! isset($_SESSION["status"]["is_login"]) || $_SESSION["status"]["is_login"] == null) {
    header("Location: ../../index.php");
}

if( ! isset($_GET)) {
    header("Location: view_user_home.php");
}
// var_dump($_GET);die;
$todoId = $_GET["id"];
$user_id = $_SESSION["status"]["user_role_id"] == 1? $_GET["adminUserId"] : $_SESSION["status"]["user_id"];
$sql = "SELECT * FROM todos WHERE todo_id='$todoId' AND user_id='$user_id'";
// var_dump($user_id);die;
$result = query($sql, $mysqli);

$data = mysqli_fetch_array($result);
?>

<?php require "../template/header.php"; ?>
    <?php if($todoId == $data["todo_id"]) : ?>
        <h3>Edit Todo # <?php echo $_GET["id"]; ?></h3>

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

<?php require "../template/footer.php"; ?>