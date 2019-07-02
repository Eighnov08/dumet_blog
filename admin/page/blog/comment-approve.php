<?php
    if(isset($_GET["comment-approve"])){
        $comment_id = $_GET["comment-approve"];
        mysqli_query($connection, "UPDATE comment SET status = '1' WHERE id = '$comment_id'");
        if($comment_id==""){
            header("location:index.php?failed");
        } else{
            header("location:index.php?success");
        }
    } 
?>