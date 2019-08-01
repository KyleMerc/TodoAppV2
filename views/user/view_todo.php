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

$data = mysqli_fetch_assoc($result);
?>

<?php require "../template/header.php"; ?>
    <h3>View Todo # <?php echo $_GET["id"]; ?></h3>
    <h6> *read only </h6>

    <form class="form">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="" class="font-weight-bold">Date Created</label>
                <input type="text" value="<?php echo $data["date_created"]; ?>" class="form-control-plaintext">
            </div>
            <div class="form-group col-md-6">
                <label for="" class="font-weight-bold">Date Updated</label>
                <input type="text" value="<?php echo $data["date_updated"]; ?>" class="form-control-plaintext">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="font-weight-bold">Todo</label>
            <textarea cols="30" rows="10" class="form-control-plaintext"><?php echo $data["content"]; ?></textarea>
        </div>
    </form>

    <a href="view_user_home.php" class="btn btn-primary">Go back</a>


<?php require "../template/footer.php"; ?>