<?php
session_start();
// var_dump($_SESSION);
// if(isset($_SESSION["status"]["is_login"]) || $_SESSION["status"]["is_login"] == null) {
//     header("Location: ../../index.php");
// }
?>

<?php require "../template/header.php"; ?>
<h3 class="text-center">REGISTER</h3>

<?php if(isset($_SESSION["v_pass"]) && $_SESSION["v_pass"] == true) : ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
    <strong>Wrong Password</strong>
    <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button> -->
    <?php unset($_SESSION["v_pass"]); ?>
    </div>

<?php elseif(isset($_SESSION["v_user"]) && $_SESSION["v_user"] == true) : ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
    <strong>Username is already taken</strong>
    <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button> -->
    <?php unset($_SESSION["v_user"]); ?>
    </div>
<?php endif; ?>

    <?php
        // if(isset($_SESSION["v_pass"])  == false) {
        //     echo "<div class='alert alert-danger'> Password did not matched </div>";
        // }

        // if(isset($_SESSION["v_user"])  == true  ) {
        //     echo "<div class='alert alert-danger'> Password did not matched </div>";
        // }
    ?>

    <form action="../../controller/Register.php" method="post">
        <div class="form-group">
            <label for="">Username</label>
            <input type="text" name="username" class="form-control">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="">Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label for="">Confirm Password</label>
                <input type="password" name="confPassword" class="form-control">
            </div>
        </div>
        <button class="btn btn-primary btn-block" name="register" type="submit">REGISTER</button>
    </form> 
    <br />
    <a href="../../controller/Logout.php" class="btn btn-primary">Go back</a>
<?php require "../template/footer.php"; ?>