<?php

if(isset($_COOKIE["user_name"])){
  header("location:services.php");
}else{
  include("include/connect.php");
  include("../function/func.php");

  if($_SERVER['REQUEST_METHOD'] === "POST"){
    // sign in
    if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["pass"])){
      $name = $_POST["name"];
      $email = $_POST["email"];
      $pass = $_POST["pass"];
      $error = [];
      if(strlen($name) < 3)://error to user_name
        $error[] = "الاسم اقل  المطلوب";
        elseif(strlen($name) > 17):
          $error[] = "الاسم اكبر من المطلوب";
          else :
            $er = false;
            for($i = 0;$i < strlen($name);$i++ ){
              if($name[$i] == " "){
                $name[$i] = "_";
                $er = true;
              }
            }
            if($er){
              $error []= "تم اضافه علامه '_' بسبب وجوج مسافه وهذه ممنوع";
            }
      endif;
      
      if(strlen($pass) < 8):// error to password
        $error[]= " كلمه السر اقم من المطلوب";
        elseif(strlen($pass) > 11):
          $error[] = "كلمه السر اكبر من الحد المطلوب";
      endif;
      
      if(!$error){//في حاله عدم وجود مشاكل في  في كلمه السر و الاسم 
        $user_Name_good = false; 
        $user_password  = false;
        $select = $db->query("SELECT User_name , id  
        from users where User_name = '$name'");
        $select = $select->fetch(pdo::FETCH_ASSOC);
        if($select)://في حاله وجود الاسم في قاعده البيانات
          
            ?>
            <p>هذا اقتراحات للاسم </p>
            <p>هذا  الاسم موجود بالفعل </p>
            <?php
          $count = $db->query("SELECT count(User_name)  as count from users where User_name like'$name%'");
          $count = $count->fetch(pdo::FETCH_ASSOC);
          $num =  $count["count"];
            if($num < 10):
              do{
              $Nname = $name . "_" . rand(1,9);
            $sel = $db->query("SELECT User_name FROM users where User_name = '$Nname'");
            $sel = $sel->fetch(pdo::FETCH_ASSOC);

              }while($sel);
              elseif($num < 100):
                do{
                  $Nname = $name . "_" . rand(10,99);
                $sel = $db->query("SELECT User_name FROM users where User_name = '$Nname'");
                $sel = $sel->fetch(pdo::FETCH_ASSOC);
                  }while($sel);

                else:
                  do{
                    $Nname = $name . "_" . rand(1000,9999);
                  $sel = $db->query("SELECT User_name FROM users where User_name = '$Nname'");
                  $sel = $sel->fetch(pdo::FETCH_ASSOC);
                    }while($sel);
              endif;
              ?>
                <p><?php echo $Nname; ?></p>
              <?php
            
        else://في حاله ان الاسم جديد 
          $user_Name_good = true;
        endif;
        if(is_strong($pass)){// اختبار اذا كان رقم السر قوي
          $user_password = true;
        }else{
          ?>
          <p>اقتراحات لرقم السر القوي </p>
          <?php
          for($c = 0;$c < 4;$c++){//اقتراحات ارق السر القوي
            ?>
            <p> <?php echo get_str_pass(); ?></p>
            <?php
          }
        }
        if($user_Name_good && $user_password){
          $db->exec("INSERT INTO users (User_name , password ,Email) values ('$name','$pass','$email')");
          setcookie("user_name" , $name , time() + 60*60*24*365,"/");
          header("location:services.php");
        }
      }
      
    }
    // login
    if(isset($_POST["old_name"])&& isset($_POST["old_pass"])){
      $old_name = $_POST["old_name"];
      $old_pass = $_POST["old_pass"];
      $sel  = $db->query("SELECT User_name from users where 
      User_name = '$old_name' || Email = '$old_name' && password = '$old_pass'");
      $sel  = $sel->fetch(pdo::FETCH_ASSOC);
      if($sel){

          setcookie("user_name" , $sel['User_name'] , strtotime("+1 year"),"/");
        header("location:services.php");
      }else{
  ?>
  <!-- هنا رساله الخطا اذا ادخل قيم  خطا في  login-->
  <p>error data</p>
  <?php        
      }
    }
  }

?>
<p> <?php if(isset($error)){// الرساله التي سوف تظهر في حاله قل او زاد الرقم السري او الاسم 
  foreach($error as $value){
    echo $value . "<BR>";
  }
  }?></p>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/normalize.css" />
    <link rel="stylesheet" href="../css/Login.css" />
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
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
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
    <link
          rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        />
        <link
          rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"
        />
    <title>login</title>
  </head>
      <body>
        <!--!_____________متلمسش الجزء ده_____________-->
        <canvas></canvas>
        <a class="btn-content" href="../index.php">
          <span class="btn-title">Home</span>
          <span class="icon-arrow">
            <svg
              width="66px"
              height="43px"
              viewBox="0 0 66 43"
              version="1.1"
              xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink"
            >
              <g
                id="arrow"
                stroke="none"
                stroke-width="1"
                fill="none"
                fill-rule="evenodd"
              >
                <path
                  id="arrow-icon-one"
                  d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z"
                  fill="#FFFFFF"
                ></path>
                <path
                  id="arrow-icon-two"
                  d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z"
                  fill="#FFFFFF"
                ></path>
                <path
                  id="arrow-icon-three"
                  d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z"
                  fill="#FFFFFF"
                ></path>
              </g>
            </svg>
          </span>
        </a>
        <!--!_____________متلمسش الجزء ده_____________-->

        <!--_____________ شغلك هناااا__________________-->
        <div class="main">
          <input type="checkbox" id="chk" aria-hidden="true" />

          <!--_____________ sign up ↓↓_________________-->
          <div class="signup">
            <form method="POST" action="">
              <label for="chk" aria-hidden="true">Sign up</label>
              <input
                type="text"
                name="name"
                placeholder="User name"
                required=""
                value = "<?php if(isset($name)){echo $name;}?>"
              />
              <input
                type="email"
                name="email"
                placeholder="Email"
                required=""
                value = "<?php if(isset($email)){echo $email;}?>"
              />
              <input
                type="password"
                name="pass"
                placeholder="Password"
                required=""
                value = "<?php if(isset($pass)){echo $pass;}?>"
              />
              <button href="#myModal" class="trigger-btn" data-toggle="modal">Sign up</button>
            </form>
          </div>
          <!--_____________ sign up ↑↑_________________-->

          <!--_____________ login ↓↓_________________-->
          <div class="login">
            <form method="POST">
              <label for="chk" aria-hidden="true">Login</label>
              <input
                type="text"
                name="old_name"
                placeholder="User name"
                required=""
                value = "<?php if(isset($old_name)){echo $old_name;}?>"
              />
              <input
                type="password"
                name="old_pass"
                placeholder="Password"
                required=""
                value ="<?php if(isset($old_pass)){echo $old_pass;}?>"
              />
              <button>Login</button>
            </form>
          </div>
        </div>
        <!--_____________ login ↑↑_________________-->


            <!-- ______start_الرساله_popup___--->
            <div class="container_popup">
              <div class="Popup_card">
                <div class="Iecon"><i class="fac fa-solid fa-circle-exclamation"></i></div>
                <!--___________اسم المشكله___________-->
                <div class="Name_Error">Error Name</div>
                <!--___________اسم المشكله___________-->
                <!--___________اقتراح حل المشكله____________-->
                <div class="suggestion">
                  <p>56FD54c4</p>
                  <p>5sxcv54d4df</p>
                  <p>56FD54c4</p>
                  <p>54sdsc4c4</p>
                </div>
                <!--___________اقتراح حل المشكله____________-->
                <!--_________زرار الاغلاق الرساله________-->
                <a href="#" class="close">close</a>
                <!--_________زرار الاغلاق الرساله________-->
              </div>
            </div>
            <!--________end_الرساله_popup___- -->
            

        <script src="../js/jquery-1.12.4.min.js"></script>
        <script src="../js/main.js"></script>
  </body>
</html>
<?php }?>