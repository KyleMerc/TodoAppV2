<?php
session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

require $root . "/TODOapp/model/config.php";

    if( ! isset($_SESSION["status"]["is_login"]) || $_SESSION["status"]["is_login"] == null) {
        header("Location: ../../index.php");
    }
$userCountTodo = 0;
$user = $_SESSION["status"]["user"];
$user_id = $_SESSION["status"]["user_id"];

$sql = "SELECT * FROM todos WHERE user_id='$user_id'";

$result = query($sql, $mysqli);
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
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Action</span>
            </h6>
            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a href="../../controller/Logout.php" class="nav-link">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>

<main class="col-md-9 col-lg-10 ml-sm-auto px-4" role="main">
    <h3>Welcome <?php echo $user; ?></h3>

            <div class="row">
                <div class="col-md-6">
                    <a href="view_add_todo.php" class="btn btn-primary">Add Task <span data-feather="plus"></span></a>
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
                        <td><?php $count = ++$userCountTodo; 
                                    echo $count;
                            ?>
                        </td>
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
                                <a href="view_todo.php?t_id=<?php echo $data["todo_id"];?>&u_id=<?php echo $data["user_id"]; ?>&c=<?php echo $count; ?>" class="btn btn-primary"><span data-feather="info"></span></a> |
                                <a href="view_edit_todo.php?id=<?php echo $data["todo_id"];?>&c=<?php echo $count; ?>" class="btn btn-primary"><span data-feather="edit"></span></a> |
                                
                                <input type="hidden" value="<?php echo $data["todo_id"]; ?>" name="delId">
                                
                                <button type="submit" class="btn btn-danger" value="Delete"><span data-feather="delete"></span></button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </table>
</main>
</div>
<?php require "../template/footer.php"; ?>