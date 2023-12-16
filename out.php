<?php
    $name = $_COOKIE["user_name"];
    setcookie("user_name" , $name , 1 ,'/');
    setcookie("user_name" , $name , 1 );
    setcookie('cities' , $_COOKIE['cities'] , time());
    setcookie('type' , $_COOKIE['type'] , time());
    header("location:services.php");

		
?>