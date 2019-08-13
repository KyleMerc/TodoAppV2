<?php
session_start();

    if( ! isset($_SESSION)) {
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TODO Web App</title>

    <link rel="stylesheet" href="views/styles/bootstrap.css">
    <link rel="stylesheet" href="views/styles/signin.css">
</head>
<body>
    <div class="container">
    <h1 class="mark text-center text-bold">TODO Web App</h1>

    <?php if(isset($_SESSION["status"]["is_login"]) && $_SESSION["status"]["is_login"] == false) : ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <strong>Wrong Usename/Password</strong>
        </div>
        <?php unset($_SESSION["status"]["is_login"]); ?>
    <?php endif; ?>
    <?php if(isset($_SESSION["status"]["is_verified"]) && $_SESSION["status"]["is_verified"] == false) : ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <strong>Unverified User</strong>
        </div>
        <?php unset($_SESSION["status"]["is_verified"]); ?>
    <?php endif; ?>

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

            <a href="views/user/view_register.php" class="btn btn-primary btn-lg btn-block" name="register">Register</a>
        </form>
    </div>

            
    </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
       <script src="views/styles/js/bootstrap.bundle.min.js"></script>
       <script src="views/styles/js/custom.js"></script>
    </body>
</html>
