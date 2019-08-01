<?php
session_start();
// var_dump($_SESSION);
?>

<?php require "../template/header.php"; ?>
<h3 class="text-center">REGISTER</h3>

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