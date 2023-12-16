<?php
	if(isset($_GET['update_id'])){//اذا اتي للتعديل
		include("include/connect.php");
		$id = $_GET['update_id'];
		$all_data = $db->query("SELECT * from products where id = '$id'");
		$all_data = $all_data->fetch(pdo::FETCH_ASSOC);
	$text  = $all_data['text'];
	$price = $all_data['price'];
	$type  = $all_data['category'];
	$city  = $all_data['citys'];
  $date  = $all_data['duration'];
  $old_name_img = $all_data['img_name'];
	}
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $img = $_FILES['images'];
    $img_name = $img['name'];
    $img_tmp = $img['tmp_name'];
    $img_size = $img['size'];
    $img_error = $img['error'];
    $text = $_POST["text"];
    $price = $_POST['price'];
    $type  = $_POST['type'];
    $city  = $_POST['city'];
    $date = $_POST['date'];
    $error = false;
    if(empty($text)||empty($price)){
      ?>
      <p><?php echo "يجب ان تملأ الحقول" ?></p><!--في حاله نسيان ملأ الحقول-->
      <?php
      $error = true;
    }else{
      $n= 0;//اختربار ان السعر رقم فقط
		  for($i = 0;$i<strlen($price);$i++){
			if((int)$price[$i] != 0){
				$n++;
			}else if($price[$i] === '0'){
				$n++;
      }
    }
      if($n != strlen($price)){
        ?>
        <p><?php echo "يجب ان يكون السعر رقم وليس اي شئ اخر"?></p>
        <?php
        $error = true;
    }
    
    if(!$error){
      if($img_error[0] == 4){// في حاله عدم ارسال صوره
        $db->exec("UPDATE products SET text ='$text',price='$price',category = '$type',
        citys = '$city',duration = '$date' where id = $id");
        ?>
        <p><?php echo "تم التعديل بنجاح"?></p>
        <?php
      }else{
        
        if(count($img_name) < 3){
          ?>
          <p><?Php echo "يجب ان لا يقل الصور عن ثلاث صور"?></p>
          <?php
        }else{
          $num_img = 0;  
          $exten = ['bmp','jpg','gif'];//امتدادات الصور
        for($i = 0;$i < count($img_name);$i++){
          $photo_type = explode(".",$img_name[$i]);
          $photo_type = end($photo_type);
            if(in_array($photo_type , $exten)){
              $num_img ++;
            }else{
              ?>
            <p><?php echo "حدث خطا في الملف رقم : " . $i +1 . "<bR>" .
            " لانه ليس صوره " .$img_name[$i] . " : الذي اسمه"?></p>
            <?php
            }
        }
        if($num_img == count($img_name)){
          include("../function/func.php");
          $photo_names = [];//اسم الصور التي سوف تخزن في قاعده البايانات
          $count = 0;
          for($i = 0;$i < count($img_name);$i++){
            $Nimg = rand(10,9999). "_" . $img_name[$i];
          if(move_uploaded_file($img_tmp[$i] , "img/".$Nimg)){
            $photo_names[] = $Nimg;
            $count++;
          }
          }
          $photo_names = implode("?",$photo_names);
          $text = is_string_true($text);
          $old_name_img = explode("?",$old_name_img);
          foreach($old_name_img as $old){
            unlink("img/$old");
          }
          $db->exec("UPDATE products SET text ='$text',price='$price',category = '$type',
        citys = '$city',duration = '$date', img_name = '$photo_names' where id = $id");
        ?>
        <p><?php echo "تم التعديل بنجاح"?></p>
        <?php
        }
      }
    }
    }
    }
    }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/normalize.css" />
    <link rel="stylesheet" href="../css/upload_product.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="/css/bootstrap.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Changa:wght@300&family=Kufam:ital,wght@1,500&family=Marhey&family=Reem+Kufi:wght@500;600&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0"
    />
    <title>Petco</title>
  </head>
  <body>
    <!--_______header_______________-->
    <header>
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="#" data-aos="fade-right" data-aos-delay="400"> <span>Pet</span>co </a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span><i class="fa-solid fa-bars-staggered"></i></span>
          </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav" data-aos="fade-left" data-aos-delay="400">
            <li class="nav-item">
              <a class="nav-link" href="services.php">services</a>
            </li>
            
            
          </ul>
        </div>
      
          <div class="c-button__blobs">
            <div></div>
            <div></div>
            <div></div></div
        ></a>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          version="1.1"
          style="display: block; height: 0; width: 0"
        >
          <defs>
            <filter id="goo">
              <feGaussianBlur
                in="SourceGraphic"
                stdDeviation="10"
                result="blur"
              ></feGaussianBlur>
              <feColorMatrix
                in="blur"
                mode="matrix"
                values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7"
                result="goo"
              ></feColorMatrix>
              <feBlend in="SourceGraphic" in2="goo"></feBlend>
            </filter>
          </defs>
        </svg>
      </nav>
    </header>
    <!--_______header_______________-->

    <!---_____________________________main__start_____________________-->
    <div class="main">
      <!--*-_______start_form_________-->
      <form method="post" enctype="multipart/form-data">
        <!--____form_img_____-->
        <div class="container" data-aos="fade-right" data-aos-delay="500">
          <div class="header">
            <label for="file">
              <i class="icon fa-solid fa-cloud-arrow-up"></i>
              <input id="file" type="file" name ='images[]'  multiple= "multiple"/>
            </label>
          </div>
          <div class="footer">
            <i class="small_icon_left fa-solid fa-file-image"></i>
            <p class="text_center">Selected image</p>
            <i class="small_icon_right fa-solid fa-trash-can"></i>
          </div>
        </div>
        <!--____form_img_____-->
        <!--____________مدخلات المستخدم____________-->
        <div class="form-group" data-aos="fade-left" data-aos-delay="500">
          <div class="in_group">
            <label for="currency">Enter Amoun</label>
            <input type="currency" value="<?php echo $price;?>" name = "price" placeholder="price" />
          </div>

          <div class="in_group">
            <label for="cars">Category</label>
            <select name="type" id="cars">
            <option value="<?php echo $type;?>"><?php echo $type;?></option>
              <option value="Apartment">Apartment</option>
              <option value="Room">Room</option>
              <option value="Bed">Bed</option>
            </select>
          </div>

          <div class="in_group">
            <label for="cars">Duration</label>
            <select name="date" id="cars">
            <option value="<?php echo $date;?>"><?php echo $date;?></option>
              <option value="Month">Month</option>
              <option value="Three_months">Three months</option>
              <option value="Six_months">Six months</option>
              <option value="Year">Year</option>
            </select>
          </div>

          <div class="in_group">
            <label for="cars">citys</label>
            <select name="city" id="cars">
              <option value="<?php echo $city;?>"><?php echo $city;?></option>
              <option value="cairo">cairo</option>
              <option value="ismailia">ismailia</option>
              <option value="Asyut">Asyut</option>
            </select>
          </div>

          <div class="last_group">
            <label for="UploadTextArea">Advertisement detailsa</label>
            <textarea
              name = "text"
              class="form-control"
              id="UploadTextArea"
              placeholder="Your text"
              maxlength="230"
              rows="3"
            ><?php echo $text;?></textarea>
          </div>
        </div>
        <div class="btn pull-right" >
          <input type="submit" value="Upload"/>
          <i class="small_icon_right fa-solid fa-upload"></i> 
      </div>
         <!--<a href="#" class="btn pull-right">Upload</a>-->
        <!--____________مدخلات المستخدم____________-->
      </form>
      <!--*-_______end_form_________-->
    </div>
    <!---_____________________________main__end_____________________-->

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
    <script src="js/jquery-1.12.4.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            offset:150,
        });
    </script>
  </body>
</html>
