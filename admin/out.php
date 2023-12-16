<?php
    $name = $_COOKIE["admin_name"];
    setcookie("admin_name" , $name ,time(),'/');
    header("location:index.php");

?>