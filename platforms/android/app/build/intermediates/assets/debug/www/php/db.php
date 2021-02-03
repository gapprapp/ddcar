<?php
    header("Access-Control-Allow-Origin: *");
    $conn = mysqli_connect("localhost", "root", "admin", "ddcar");
    mysqli_set_charset($conn, "utf8");
?>
