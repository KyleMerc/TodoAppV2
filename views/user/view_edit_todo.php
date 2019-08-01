<?php
session_start();

require "../../model/config.php";

if( ! isset($_SESSION["status"]["is_login"]) || $_SESSION["status"]["is_login"] == null) {
    header("Location: ../../index.php");
}

if( ! isset($_GET)) {
    header("Location: view_user_home.php");
}

$todoId = $_GET["id"];
$sql = "SELECT * FROM todos WHERE todo_id='$todoId'";

$result = query($sql, $mysqli);

$data = mysqli_fetch_array($result);
?>

<?php require "../template/header.php"; ?>
    <h3>Edit Todo # <?php echo $_GET["id"]; ?></h3>
    <h6> *read only </h6>

    <form action="../../controller/Todo.php" class="form" method="post">
        <input type="hidden" name="todoId" value="<?php echo $_GET["id"]; ?>">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="" class="font-weight-bold">Date Created</label>
                <input type="text" value="<?php echo $data["date_created"]; ?>" class="form-control-plaintext">
            </div>
            <div class="form-group col-md-6">
                <label for="" class="font-weight-bold">Date Updated</label>
                <input type="text" name="updateTime" value="<?php echo $data["date_updated"]; ?>" class="form-control-plaintext">
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="editRadStatus" value="IN PROGRESS" checked>
                    <label for="" class="form-check-label">IN PROGRESS</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="editRadStatus" value="DONE">
                    <label for="" class="form-check-label">DONE</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="font-weight-bold">Todo</label>
            <textarea cols="30" rows="10" class="form-control" name="editContent"><?php echo $data["content"]; ?></textarea>
        </div>

        <input type="submit" class="btn btn-primary" value="Submit" name="submit">
    </form>

    <a href="view_user_home.php" class="btn btn-primary">Go back</a>

<?php require "../template/footer.php"; ?>