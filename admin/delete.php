<?php

    if(isset($_GET["id_message"])){
			$id = $_GET["id_message"];
			include("../user/include/connect.php");
			$db->exec("DELETE from messege where id = $id");
			header("location:message.php");
		}
	if(isset($_GET['add'])){
		include("../function/func.php");
		include("../user/include/connect.php");
		$id = $_GET["add"];
		$Select = $db->query("SELECT * FROM test_uploade where id = $id");
		$Select = $Select->fetch(pdo::FETCH_ASSOC);
		
		$id = $Select['id'];
		$price = $Select['price'];
		$category = $Select['category'];
		$duration = $Select['duration'];
		$citys = $Select['citys'];
		$text = $Select['text'];
		$img_name = $Select['img_name'];
		$C_date = $Select['C_date'];
		$id_user = $Select['id_user'];
		$text = is_string_true($text);
		$db->exec("INSERT INTO `products`(`price`, `category`, `duration`,
		`citys`, `text`, `img_name`, `C_date`, `id_user`)
		VALUES ($price,'$category','$duration','$citys','$text','$img_name','$C_date','$id_user')");
		$db->exec("DELETE FROM test_uploade where id = $id");
		header("location:index.php");
	}

	if(isset($_GET['del'])){
		include("../user/include/connect.php");
		$id = $_GET["del"];
		$Select = $db->query("SELECT img_name FROM test_uploade where id = $id");
		$Select = $Select->fetch(pdo::FETCH_ASSOC);
		$img = explode("?",$Select['img_name']);
		

		foreach($img as $photo){
			unlink("../user/img/$photo");
		}
		$db->exec("DELETE FROM test_uploade where id = $id");
		header("location:index.php");
	}
?>