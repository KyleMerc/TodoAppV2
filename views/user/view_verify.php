<?php
session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

require $root . "/TODOapp/model/config.php";

if( ! isset($_GET['vkey'])) {
    header("Location: ../../index.php");
}

$get_key = $_GET['vkey'];

function verify_key($vkey){
    $sql = "SELECT * FROM users WHERE verified = 0 AND vkey = '$vkey'";

    $check = $GLOBALS['mysqli']->query($sql);
    
    if(mysqli_num_rows($check) == 1) {
        $update_sql = "UPDATE users SET verified = 1 WHERE vkey = '$vkey'";
        $GLOBALS['mysqli']->query($update_sql);

        return true;
    }

    return false;
}
?>

<?php require "../template/header.php"; ?>
    <?php
        if(verify_key($get_key)) {
            echo "<div class='display-3 text-center'>Success verification</div>";
        } else {
            echo "<div class='display-3 text-center'>User is already verified</div>";
        }
    ?>
    <a href="../../index.php" class="btn btn-primary">Go home</a>
<?php require "../template/footer.php"; ?>