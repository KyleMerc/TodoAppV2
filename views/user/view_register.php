<?php
?>

<?php require "../template/header.php"; ?>
<h3 class="text-center">REGISTER</h3>

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
        <button class="btn btn-primary btn-block">REGISTER</button>
    </form> 
<?php require "../template/footer.php"; ?>