<?php

    $id = $_GET['id'];
    include("include/connect.php");
    $db->exec("DELETE FROM products where id = $id");
    header("location:services.php");

?>