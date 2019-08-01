<?php
session_start();
// unset($_SESSION);

    // if( ! isset($_SESSION["status"]["is_login"]) || $_SESSION["status"]["is_login"] == null) {
    //     header("Location: ../../index.php");
    // }
    
?>

<?php require "../template/header.php"; ?>
    <h3>Admin Panel</h3>
    <form action="../../controller/Logout.php" method="post">
        <button class="btn btn-primary" type="submit">Log Out</button>
    </form>
<?php require "../template/footer.php"; ?>