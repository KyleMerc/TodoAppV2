<?php
session_start();

require "../../model/config.php";

    if( ! isset($_SESSION["status"]["is_login"]) || $_SESSION["status"]["is_login"] == null) {
        header("Location: ../../index.php");
    }
    
    $user_id = $_GET["v_id"] ?? false;

    $sql = "SELECT * FROM users";
    $result = query($sql, $mysqli);

    $user_sql = "SELECT todo_id, status, title, content, u.user_id, username
                 FROM users u LEFT JOIN todos t
                 ON t.user_id = u.user_id
                 WHERE u.user_id='$user_id'
                 UNION
                 SELECT todo_id, status, title, content, u.user_id, username
                 FROM users u RIGHT JOIN todos t
                 ON t.user_id = u.user_id
                 WHERE u.user_id='$user_id'";

    $user_data = query($user_sql, $mysqli);
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

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="row">
        <div class="col-md-6">
            <h3>Admin Panel</h3>
        </div>
        
        <div class="col-md-6">
            <form action="../../controller/Logout.php" method="post">
                <button class="btn btn-primary float-right" type="submit">Log Out</button>
            </form>
        </div>
    </div>
    

    <?php
        if($user_id != false) {
            $user = mysqli_fetch_assoc($user_data);  
            echo "<h3>Todos from " . $user["username"] . " </h3>";
        }
    ?>
    
    <?php if( ! $user_id) : ?>      <!--- USER list shown --->
        <table class="table table-borderless table-hover">
            <tr class="thead-dark">
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
                <td><?php echo date('M j Y g:i A', strtotime($data["date_created"])); ?></td>
                <td><?php echo date('M j Y g:i A', strtotime($data["date_updated"])); ?></td>
                <td>
                    <form action="../../controller/Todo.php" method="post">
                        <a href="<?php echo $_SERVER["PHP_SELF"]; ?>?v_id=<?php echo $data["user_id"];?>" class="btn btn-primary"><span data-feather="info"></span></a> |
                        <a href="view_admin_edit_user.php?id=<?php echo $data["user_id"];?>" class="btn btn-primary"><span data-feather="edit"></span></a> |

                        <input type="hidden" value="<?php echo $data["user_id"]; ?>" name="userDelId">
                        <button class="btn btn-danger"><span data-feather="delete"></span></button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else : ?> <!--- Users TODO list shown ---->
        <table class="table table-borderless table-hover">
            <tr class="thead-dark">
                <th>Todo ID</th>
                <th>Status</th>
                <th>Title</th>
                <th>Action</th>
            </tr>
            <?php
                mysqli_data_seek($user_data, 0);
                $verify = mysqli_fetch_assoc($user_data);
                if($verify['username'] == null) {
                    header("Location: view_admin_home.php");
                }

                mysqli_data_seek($user_data, 0);
                while($result = mysqli_fetch_assoc($user_data)) :
                    if($result["content"] == null) {
                        continue;
                    }
            ?>
            <tr>
                <td><?php echo $result["todo_id"]; ?></td>
                <td>
                    <?php
                        if($result["status"] == "DONE") {
                            echo "<span class='text-success'>DONE</span>";
                        } else {
                            echo "<span class='text-primary'>IN PROGRESS</span>";
                        }
                    ?>
                </td>
                <td><?php echo $result["title"]; ?></td>
                <td>
                    <form action="../../controller/Todo.php" method="post">
                        <a href="../user/view_todo.php?t_id=<?php echo $result["todo_id"];?>&u_id=<?php echo $result["user_id"];?>" class="btn btn-primary"><span data-feather="info"></span></a> |
                          
                        <a href="../user/view_edit_todo.php?adminUserId=<?php echo $result['user_id']; ?>&id=<?php echo $result['todo_id']; ?>" class="btn btn-primary"><span data-feather="edit"></span></a> |
                        
                        <input type="hidden" value="<?php echo $result["todo_id"]; ?>" name="adminDelTodoId">
                        <input type="hidden" value="<?php echo $user_id ?>" name="adminUserId">
                        <button class="btn btn-danger" type="submit"><span data-feather="delete"></span></button>
                    </form>        
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    
    <div class="row">
        <div class="col-md-6">
            <a href="view_admin_home.php" class="btn btn-primary">Go back</a>       
        </div>
        <div class="col-md-6">
            <a href="../user/view_add_todo.php?v_id=<?php echo $_GET["v_id"]; ?>" class="btn btn-primary float-right">Add Task</a>
        </div>
    </div>
    <?php endif; ?>
    </main>
    </div>
<?php require "../template/footer.php"; ?>