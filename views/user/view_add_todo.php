<?php
session_start();

if( ! isset($_SESSION["status"]["is_login"]) || $_SESSION["status"]["is_login"] == null) {
    header("Location: ../../index.php");
}

if( ! isset($_SESSION)) {
    header("Location: ../../index.php");
}
?>

<?php require "../template/header.php"; ?>
    <h3>Add Todo / Task</h3>

    <?php if($_SESSION["status"]["user_role_id"] == 2) : ?>
        <form action="../../controller/Todo.php" method="post" class="form justify-content-center">
            <textarea name="addContent" class="form-control" id="" cols="30" rows="10"></textarea>
            
            <input type="submit" value="Submit" name="submit" class="btn btn-primary">
        </form>
        <br />
        <a href="view_user_home.php" class="btn btn-primary">Go back</a>
    <?php endif ;?>
    <?php if($_SESSION["status"]["user_role_id"] == 1) : ?>
        <form action="../../controller/Todo.php" class="form justify-content-center" method="post">
            <input type="hidden" name="v_id" value="<?php echo $_GET['v_id']?>">
            <textarea name="adminAddContent" id="" cols="30" rows="10" class="form-control"></textarea>
           
            <input type="submit" value="Submit" name="submit" class="btn btn-primary">
        </form>
        <br />
        <a href="../admin/view_admin_home.php?v_id=<?php echo $_GET['v_id']?>" class="btn btn-primary">Go back</a>
    <?php endif; ?>
    
<?php require "../template/footer.php"; ?>