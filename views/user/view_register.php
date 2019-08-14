<?php
session_start();
$v_user = $_SESSION['v_user'] ?? $_SESSION['emptyUser'] ?? false;
$v_pass = $_SESSION['v_pass'] ?? false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TODO Web App</title>

    <link rel="stylesheet" href="../styles/bootstrap.css">
</head>
<body>
<main class="container" role="main">
    
<h1 class="mark text-center text-bold">TODO Web App</h1>
    <div class="justify-content-center">
    <h3 class="text-center">REGISTER</h3>

    <?php if($v_pass) : ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
        <strong>Wrong Password</strong>

        <?php unset($_SESSION["v_pass"]); ?>
        </div>
    <?php endif; ?>

    <?php if($v_user == 'existUser') : ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
        <strong>Username is already taken</strong>
        
        <?php unset($_SESSION["v_user"]); ?>
        </div>
    <?php endif; ?>
    <?php if($v_user == 'emptyUser') : ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
        <strong>Username is empty</strong>
        
        <?php unset($_SESSION["emptyUser"]); ?>
        </div>
    <?php endif; ?>

        <form action="../../controller/Register.php" method="post">
            <div class="form-row">
                <div class="form-group col-6">
                    <label for="">First Name</label>
                    <input type="text" name="firstName" class="form-control" maxlength="30">
                </div>
                <div class="form-group col-5">
                    <label for="">Last Name</label>
                    <input type="text" name="lastName" class="form-control" maxlength="30">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-7">
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control" maxlength="40">
                </div>
            </div>
            <div class="form-group">
                <label for="">Username</label>
                <input type="text" name="username" class="form-control" maxlength="30">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control" maxlength="30">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Confirm Password</label>
                    <input type="password" name="confPassword" class="form-control" maxlength="30">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-auto">
                    <button class="btn btn-primary" name="register" type="submit">REGISTER</button>
                </div>
                <div class="form-group col-auto">
                    <a href="../../controller/Logout.php" class="btn btn-primary">Go back</a>
                </div>
            </div>
        </form> 
    </div>
</main>
<?php require "../template/footer.php"; ?>