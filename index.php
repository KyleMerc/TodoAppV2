<?php require_once "views/template/header.php"; ?>

<div class="row justify-content-center mt-5">
    <form action="controller/Login.php" method="post">
        <div class="form-group">
            <label for="">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
        </div>
        <div class="form-group">
            <label for="">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        

        <button class="btn btn-primary btn-lg btn-block" type="submit" name="login">Log In</button>
    </form>
</div>





<?php require_once "views/template/footer.php"; ?>
