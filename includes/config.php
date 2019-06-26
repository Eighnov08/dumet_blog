<?php
    global $connection;
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dumet_blog";

    $connection = mysqli_connect($servername,$username,$password,$dbname);

    if(!$connection){
        die("Connection Failed: ".mysqli_connect_error());
    }
?>