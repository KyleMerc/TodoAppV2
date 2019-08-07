<?php
session_start();

require "../../model/config.php";

if( ! isset($_SESSION["status"]["is_login"]) || $_SESSION["status"]["is_login"] == null) {
    header("Location: ../../index.php");
}

if( ! isset($_GET)) {
    header("Location: view_user_home.php");
}
// var_dump($_GET);die;
$todoId = htmlspecialchars($_GET["t_id"]);
$userId = htmlspecialchars($_GET["u_id"]);


$sql = "SELECT * FROM todos t 
        JOIN users u ON t.user_id = u.user_id 
        WHERE todo_id='$todoId' AND t.user_id='$userId'";

$result = query($sql, $mysqli);

$data = mysqli_fetch_assoc($result);
// var_dump($data);die;

// $sql_verify = "SELECT * FROM users WHERE user_id";
// $check_data = mysqli_fetch_assoc($result);
$role_id = $_SESSION['status']['user_role_id'];
$todo_check = $todoId == $data["todo_id"];
$username_check = $data['username'] == $_SESSION['status']['user'];

$user_verify = ($role_id == 2 && $todo_check && $username_check)? 'user' : 
                ($role_id == 1 && $todo_check)? 'admin' : false;
?>

<?php require "../template/header.php"; ?>
    <?php if($user_verify == 'user' || $user_verify == 'admin') : ?>
        <h3>View Todo # <?php echo $_GET["t_id"]; ?></h3>
        <h6> *read only </h6>

        <form class="form">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="" class="font-weight-bold">Date Created</label>
                    <input type="text" value="<?php echo date('M j Y g:i A', strtotime($data["date_created"])); ?>" class="form-control-plaintext" disabled>
                </div>
                <div class="form-group col-md-6">
                    <label for="" class="font-weight-bold">Date Updated</label>
                    <input type="text" value="<?php echo date('M j Y g:i A', strtotime($data["date_updated"])); ?>" class="form-control-plaintext" disabled>
                </div>
            </div>

            <div class="form-group">
                <label for="" class="font-weight-bold">Title</label>
                <input type="text" class="form-control-plaintext" value="<?php echo $data["title"]; ?>" disabled>
            </div>

            <div class="form-group">
                <label for="" class="font-weight-bold">Status</label>
                <div class="form-check form-check-inline">
                <?php
                    if($data["status"] == 'DONE') {
                        echo  "<input type='text' class='form-control-plaintext text-success' value='DONE' disabled>";
                    } else {
                        echo  "<input type='text' class='form-control-plaintext text-primary' value='IN PROGRESS' disabled>";
                    }
                ?>
                </div>
            </div>

            <div class="form-group">
                <label for="" class="font-weight-bold">Todo</label>
                <textarea cols="30" rows="10" class="form-control-plaintext" disabled><?php echo $data["content"]; ?></textarea>
            </div>
        </form>
    <?php else: ?>
        <div class="jumbotron">
            <div class="display-3 text-danger">Todo does not exist</div>
        </div> 
    <?php endif; ?>    

    <?php 
        if($_SESSION["status"]["user_role_id"] == 2) {
            echo "<a href='view_user_home.php' class='btn btn-primary'>Go back</a>";
        } elseif($_SESSION["status"]["user_role_id"] == 1) {
            $user_id = htmlspecialchars($_GET["u_id"]);
            echo "<a href='../admin/view_admin_home.php?v_id=$user_id' class='btn btn-primary'>Go back</a>";
        }
    ?>

<?php require "../template/footer.php"; ?>