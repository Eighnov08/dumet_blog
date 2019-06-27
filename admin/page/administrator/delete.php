<?php
    if(isset($_GET["administrator-delete"])){
        $admin_id = $_GET["administrator-delete"];
        mysqli_query($connection, "DELETE FROM admin WHERE id = '$admin_id'");
        header("location:index.php?administrator");
    }
?>