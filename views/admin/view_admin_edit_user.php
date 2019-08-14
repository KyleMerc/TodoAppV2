<?php
session_start();
// var_dump($_SESSION);
require "../../model/config.php";

$user_id = $_GET['id'] ?? false;

$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = query($sql, $mysqli);

$data = mysqli_fetch_assoc($result);
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
    <?php if(mysqli_num_rows($result) > 0 && $data['user_role_id'] != 1) : ?>
        <h3>Edit User <?php echo $data["username"]; ?></h3>

        <form action="../../controller/Admin.php" class="form" method="post">
            <input type="hidden" name="oldUsername" value="<?php echo $data['username']; ?>">
            <input type="hidden" name="oldPassword" value="<?php echo $data['password']; ?>">
            <input type="hidden" name="userId" value="<?php echo $data['user_id']; ?>">

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="" class="font-weight-bold">Date Created</label>
                    <input type="text" class="form-control-plaintext" value="<?php echo date('M j Y g:i A', strtotime($data["date_created"])); ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="" class="font-weight-bold">Date Updated</label>
                    <input type="text" class="form-control-plaintext" value="<?php echo date('M j Y g:i A', strtotime($data["date_updated"]));?>">
                </div>
            </div>

            <!-- Username Error -->
            <div class="form-row">
                <div class="form-group">
                <?php if(isset($_SESSION['error']['emptyUsername'])) : ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                            <strong>Username is empty</strong> 
                    </div>       
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                <?php if(isset($_SESSION['error']['errorUsername'])) : ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                            <strong>Username is already taken</strong>   
                    </div>     
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                </div>
            </div>
            <!------------------>

            <div class="form-row">
                <div class="form-group col-auto">
                    <label for="" class="font-weight-bold">Username</label>
                    <input type="text" class="form-control" value="<?php echo $data['username']; ?>" name="newUsername">
                </div>
            </div>

            <!-- Password Error -->
            <div class="form-group">
                <div class="form-row">
                <?php if(isset($_SESSION['error']['errorPass'])) : ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                            <strong>Wrong Password</strong> 
                    </div>       
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                </div>
            </div>
            <!------------------>

            <div class="form-row">
                <div class="form-group col-auto">
                    <label for="" class="font-weight-bold">Password</label>
                    <input type="password" class="form-control" name="newPassword">
                </div>
                <div class="form-group col-auto">
                    <label for="" class="font-weight-bold">Confirm Password</label>
                    <input type="password" class="form-control" name="confNewPassword">
                </div>
            </div>
            
            <div class="row">
                <div class="form-group col">
                    <input name="actionAdminGoBack" value="Go Back" class="btn btn-primary" type="submit">
                </div>
                <div class="form-group col-9">
                    <button type="submit" class="btn btn-primary" type="submit" name="editUser">Save</button>
                </div>
            </div>
        </form>
    <?php else : ?>
        <div class="jumbotron">
            <div class="display-3 text-danger">No user found!</div>
        </div>
        <a href="view_admin_home.php" class="btn btn-primary">Go back</a>
    <?php endif; ?>
    </main>

</div>
<?php require "../template/footer.php"; ?>
