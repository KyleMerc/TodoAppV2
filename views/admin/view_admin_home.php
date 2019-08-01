<?php
session_start();

require "../../model/config.php";

// unset($_SESSION);

    if( ! isset($_SESSION["status"]["is_login"]) || $_SESSION["status"]["is_login"] == null) {
        header("Location: ../../index.php");
    }
    
    $sql = "SELECT u.user_id, username, todo_id, status, content, t.date_created, t.date_updated  
            FROM users u
            JOIN todos t ON u.user_id = t.user_id";
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
            <th>Todo ID</th>
            <th>Status</th>
            <th>Content</th>
            <th>Date Created</th>
            <th>Date Updated</th>
            <th>Action</th>
        </tr>
        <?php
            while($data = mysqli_fetch_assoc($result)) :
        ?>
        <tr>
            <td><?php echo $data["user_id"]; ?></td>
            <td><?php echo $data["username"]; ?></td>
            <td><?php echo $data["todo_id"]; ?></td>
            <td>
            <?php
                if($data["status"] == "DONE") {
                    echo "<span class='text-success'>DONE</span>";
                } else {
                    echo "<span class='text-primary'>IN PROGRESS</span>";
                }
            ?>
            </td>
            <td>
                <span class="d-inline-block text-truncate" style="max-width: 80px;"><?php echo $data["content"]; ?></span> 
            </td>
            <td><?php echo $data["date_created"]; ?></td>
            <td><?php echo $data["date_updated"]; ?></td>
            <td>
                <a href="../user/view_todo.php?id=<?php echo $data["todo_id"];?>" class="btn btn-primary">View</a> |
                <a href="../../controller/Todo.php?delId=<?php echo $data["todo_id"];?>" class="btn btn-danger">DELETE</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php require "../template/footer.php"; ?>