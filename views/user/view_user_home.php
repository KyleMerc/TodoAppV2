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
                        <th>Content</th>
                        <th colspan="2">Action</th>
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
                        <td>
                            <span class="d-inline-block text-truncate" style="max-width: 150px;"><?php echo $data["content"]; ?></span>
                        </td>
                        <td>
                            <a href="view_todo.php?id=<?php echo $data["todo_id"];?>" class="btn btn-primary">View</a> |
                            <a href="view_edit_todo.php?id=<?php echo $data["todo_id"];?>" class="btn btn-primary">EDIT</a> |
                            <a href="../../controller/Todo.php?delId=<?php echo $data["todo_id"];?>" class="btn btn-danger">DELETE</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </table>
    <?php
       // }
    ?>
<?php require "../template/footer.php"; ?>