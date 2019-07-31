<?php
session_start();

    if( ! isset($_SESSION)) {
        header("Location: ../../index.php");
    }
?>

<?php require "../template/header.php"; ?>
    <h3>Add Todo / Task</h3>

    <form action="../../controller/Todo.php" method="post" class="form justify-content-center">
        <textarea name="addContent" class="form-control" id="" cols="30" rows="10"></textarea>
        
        <input type="submit" value="Submit" name="submit" class="btn btn-primary">
    </form>

<?php require "../template/footer.php"; ?>