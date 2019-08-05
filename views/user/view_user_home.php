<?php
session_start();

require "../../model/config.php";

// var_dump($_SESSION);
//unset($_SESSION);
    if( ! isset($_SESSION["status"]["is_login"]) || $_SESSION["status"]["is_login"] == null) {
        header("Location: ../../index.php");
    }

$user = $_SESSION["status"]["user"];
$user_id = $_SESSION["status"]["user_id"];

$sql = "SELECT * FROM todos WHERE user_id='$user_id'";

$result = query($sql, $mysqli);
// var_dump(mysqli_fetch_assoc($result));die;
?>

<?php require "../template/header.php"; ?>
    <h3>Welcome <?php echo $user; ?></h3>

            <div class="row">
                <div class="col-md-6">
                    <a href="view_add_todo.php" class="btn btn-primary" type="submit">Add Task</a>
                </div>
                <div class="col-md-6">
                    <form action="../../controller/Logout.php" method="post">
                        <button class="btn btn-primary float-right">Log Out</button>
                    </form>
                </div>
            </div>
    
            <table class="table table-borderless table-hover">
                <thead class="thead-dark">
                        <th>Todo ID</th>
                        <th>Status</th>
                        <th>Title</th>
                        <th colspan="4">Action</th>
                </thead>
                
                <?php if(mysqli_num_rows($result) > 0) : ?>
                    <?php while($data = mysqli_fetch_assoc($result)) :?>
                    <tr>
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
                        <td><?php echo $data["title"]; ?></td>
                        <td>
                            <form action="../../controller/Todo.php" method="post">
                                <a href="view_todo.php?t_id=<?php echo $data["todo_id"];?>&u_id=<?php echo $data["user_id"]; ?>" class="btn btn-primary">View</a> |
                                <a href="view_edit_todo.php?id=<?php echo $data["todo_id"];?>" class="btn btn-primary">EDIT</a> |
                                
                                <input type="hidden" value="<?php echo $data["todo_id"]; ?>" name="delId">
                                
                                <input type="submit" class="btn btn-danger" value="Delete">
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </table>
    <?php
       // }
    ?>
<?php require "../template/footer.php"; ?>