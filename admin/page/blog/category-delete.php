<?php
    if(isset($_GET["category-delete"])){
        $category_id = $_GET["category-delete"];
        mysqli_query($connection, "DELETE FROM category WHERE id = '$category_id'");
        header("location:index.php?category");
    }
?>