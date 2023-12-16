<?php
if(isset($_GET["cities"])){
    if(!($_GET["cities"] == "All")){
        setcookie("cities" ,$_GET["cities"]);
    }elseif($_GET["cities"] == "All"){
        if(isset($_COOKIE["cities"])){
            setcookie('cities' , $_COOKIE['cities'] , time());
        }
    }
}
if(isset($_GET["type"])){
    if(!($_GET["type"] == "All")){
        setcookie("type" ,$_GET["type"]);
    }elseif($_GET["type"] == "All"){
        if(isset($_COOKIE["type"])){
            setcookie('type' , $_COOKIE['type'] , time());
        }
    }
}
header("location:services.php");
?>