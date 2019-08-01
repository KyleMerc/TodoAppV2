<?php
session_start();

require "../../model/config.php";

// unset($_SESSION);

    if( ! isset($_SESSION["status"]["is_login"]) || $_SESSION["status"]["is_login"] == null) {
        header("Location: ../../index.php");
    }
    
    $sql = "SELECT *  
            FROM users";
    $result = query($sql, $mysqli);

    // var_dump(mysqli_fetch_assoc($result));die;
?>

<?php require "../template/header.php"; ?>
    <h3>Admin Panel</h3>
    <form action="../../controller/Logout.php" method="post">
        <button class="btn btn-primary" type="submit">Log Out</button>
    </form>

    <table class="table table-borderless">
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Date Created</th>
            <th>Date Updated</th>
            <th>Action</th>
        </tr>
        <?php
            while($data = mysqli_fetch_assoc($result)) :
                if($data["user_role_id"] == 1) {
                    continue;
                }
        ?>
        <tr>
            <td><?php echo $data["user_id"]; ?></td>
            <td><?php echo $data["username"]; ?></td>
            <td><?php echo $data["date_created"]; ?></td>
            <td><?php echo $data["date_updated"]; ?></td>
            <td>
                <a href="../user/view_todo.php?id=<?php echo $data["user_id"];?>" class="btn btn-primary">View</a> |
                <a href="../../controller/Todo.php?delId=<?php echo $data["user_id"];?>" class="btn btn-danger">DELETE</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php require "../template/footer.php"; ?>