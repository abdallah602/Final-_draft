<?PHP
  include("../function/func.php");
  include("../user/include/connect.php");
  if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_POST["Name"]) &&isset($_POST["email"]) 
    && isset($_POST["pass"]) && isset($_POST["code"])&& isset($_POST["phone"])){
      $phone = $_POST["phone"];
      $name  = $_POST["Name"];
      $email = $_POST["email"];
      $pass  = $_POST["pass"];
      $code  = $_POST["code"];
      $error = [];
      if(strlen($phone) < 11){
        $error [] = "ادخل رقم الهاتف كامل";
      }else if(strlen($phone) > 11){
        $error [] ="الرقم اكبر من الطبيعي";
      }
      if(strlen($name) < 3)://error to user_name
        $error[] = "الاسم اقل  المطلوب";
        elseif(strlen($name) > 17):
          $error[] = "الاسم اكبر من المطلوب";
        else:
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
        $admin_Name     = false; 
        $admin_password = false;
        $admin_code     = false;
        $admin_phone    = false;
        $select = $db->query("SELECT name , id  
        from admin where name = '$name'");
        $select = $select->fetch(pdo::FETCH_ASSOC);
        if($select)://في حاله وجود الاسم في قاعده البيانات
          
            ?>
            <p>هذا الاسم موجود بالفعل</p>
            <p>هذا اقتراحات للاسم </p>
            <?php
          $count = $db->query("SELECT count(name)  as count from admin where name like'$name%'");
          $count = $count->fetch(pdo::FETCH_ASSOC);
          $num =  $count["count"];
            if($num < 10):
              do{
              $Nname = $name . "_" . rand(1,9);
            $sel = $db->query("SELECT name FROM admin where name = '$Nname'");
            $sel = $sel->fetch(pdo::FETCH_ASSOC);

              }while($sel);
              elseif($num < 100):
                do{
                  $Nname = $name . "_" . rand(10,99);
                $sel = $db->query("SELECT name FROM admin where name = '$Nname'");
                $sel = $sel->fetch(pdo::FETCH_ASSOC);
                  }while($sel);

                else:
                  do{
                    $Nname = $name . "_" . rand(1000,9999);
                  $sel = $db->query("SELECT name FROM admin where name = '$Nname'");
                  $sel = $sel->fetch(pdo::FETCH_ASSOC);
                    }while($sel);
              endif;
              ?>
                <p><?php echo $Nname; ?></p>
              <?php
            
        else://في حاله ان الاسم جديد 
          $admin_Name = true;
        endif;
        if(is_strong($pass)){// اختبار اذا كان رقم السر قوي
          $admin_password = true;
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
        if($code == "Admin_2024"){
          $admin_code = true;  
        }else{
          ?>
          <p><?php echo "هذا الكود غير صحيح"?></p><!--الرساله التي تظهر في حاله ان الكود غير صحيح-->
          <?php
        }
        if(is_mobilephone($phone)){
          $admin_phone = true;
        }else{
          ?>
          <p><?php echo "هذا الرقم غير صحيح"?></p>
          <?php
        }
          if($admin_Name && $admin_password && $admin_code && $admin_phone){
          $db->exec("INSERT INTO admin (name , password ,Email ,mobile) 
          values ('$name','$pass','$email' , '$phone')");
          setcookie("admin_name" , $name , 0,'/');
          header("location:index.php");
        }
      }
    }
    // login
    if(isset($_POST["old_name"])&& isset($_POST["old_pass"])){
      $old_name = $_POST["old_name"];
      $old_pass = $_POST["old_pass"];
      $sel  = $db->query("SELECT name from admin where 
      name = '$old_name' || email = '$old_name' && password = '$old_pass'");
      $sel  = $sel->fetch(pdo::FETCH_ASSOC);
      if($sel){
        setcookie("admin_name" , $sel['name'] , 0,'/');
        header("location:index.php");
      }else{
        ?>
        <!-- هنا رساله الخطا اذا ادخل قيم  خطا في  login-->
        <p>error data</p>
        <?php        
      }
    }
  }
  if(isset($error)){
    foreach($error as $r){
      ?>
        <p><?php echo $r?></p>
      <?php
    }
  }
?>

<span style="font-family: verdana, geneva, sans-serif"
  ><!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <link rel="stylesheet" href="../css_admin/DashBoard.css" />
      <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
      />
      <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
      />
      <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"
      />
      <link rel="stylesheet" href="../css_admin/bootstrap.min.css" />
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
      <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
      <title>Dashboard</title>
    </head>
    <body>
      <!--*___________________left-section-nav___________-->
      <div class="container">
        <?Php if(isset($_COOKIE["admin_name"])){?>
        <nav>
          <ul>
            <li>
              <a href="#" class="logo">
                <i class="fas fa-solid fa-user-shield"></i>
                <span class="nav-item">Admin</span>
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fas fa-menorah" style="color: #34af6d !important"></i>
                <span class="nav-item">Dashboard</span>
              </a>
            </li>
            <li>
              <a href="message.php">
                <i class="fas fa-comment"></i>
                <span class="nav-item">Message</span>
              </a>
            </li>
            <li>
              <a href="profile.php">
                <i class="fas fa-solid fa-user"></i>
                <span class="nav-item">Profile</span>
              </a>
            </li>
            <li>
              <a href="All-admins.php">
                <i class="fas fa-solid fa-users"></i>
                <span class="nav-item">All admins</span>
              </a>
            </li>
            <li>
              <a href="../user/services.php">
                <i class="fas fa-solid fa-house"></i>
                <span class="nav-item">Home</span>
              </a>
            </li>

            <li>
              <a href="out.php" class="logout">
                <i class="fas fa-sign-out-alt"></i>
                <span class="nav-item">Log out</span>
              </a>
            </li>
          </ul>
        </nav>

        <!--*___________________left-section-nav___________-->

        <!--*___________________right-section____________-->

        
        <section class="main">
          <div class="main-top">
            <h1>Dashboard</h1>
            <i class="fas fa-user-cog" style="font-size: 1.5rem"></i>
          </div>
          <div class="users">
            <!--_________counter________-->
            <?php
            // ااخرج عدد المنتجات
              $count = $db->query("SELECT category from  `products`");
              $count = $count->fetchAll(pdo::FETCH_ASSOC);
              $num_apart  = 0;
              $num_room   = 0;
              $num_bed    = 0;
              foreach($count as $c){
                if($c['category'] == "Apartment"){
                  $num_apart++;
                }else if($c['category'] == "Room"){
                  $num_room++;
                }else if($c['category'] == "Bed"){
                  $num_bed++;
                }
              }
            ?>
            <div class="card">
              <i class="fa-solid fa-people-roof"></i>
              <h2 class="counter"><?php echo $num_apart?></h2>
              <h4>Apartments</h4>
            </div>

            <div class="card">
              <i class="fa-solid fa-person-shelter"></i>
              <h2 class="counter"><?php echo $num_room?></h2>
              <h4>Rooms</h4>
            </div>

            <div class="card">
              <i class="fa-solid fa-bed"></i>
              <h2 class="counter"><?php echo $num_bed?></h2>
              <h4>Beds</h4>
            </div>
              <?Php
              // اخراج عدد المدن 
                $num = $db->query("SELECT count(citys) as num from  `products` group by citys");
                $num = $num->fetchall(pdo::FETCH_ASSOC);
                $n = count($num);
              ?>
            <div class="card">
              <i class="fa-solid fa-city"></i>
              <h2 class="counter"><?php echo $n?></h2>
              <h4>city</h4>
            </div>
          </div>
          <!--_________counter________-->
          <section class="attendance">
            <div class="attendance-list">
              <h1>upload requests</h1>
              <!--____start_____table__________-->
              <?php
                      $start = 1;
                      if(isset($_GET['start'])){$start =$_GET['start'];}
                      $sel = $db->query("SELECT id from test_uploade");
                      $sel = $sel->fetchAll(pdo::FETCH_ASSOC);
                      $number = 5;
                      $num_s = ceil((count($sel) / $number));
                      $limt = ($start - 1) * $number;
                      $all = $db->query("SELECT `test_uploade`.`id` as id_cat,`test_uploade`.`category`,
                      `test_uploade`.`citys`,`test_uploade`.`duration`
                      ,`test_uploade`.`price`, `users`.`User_name`,`users`.`id`,`test_uploade`.`C_date`as date
                      from test_uploade INNER JOIN users on test_uploade.id_user = users.id limit $limt , $number ");
                      $all = $all->fetchAll(pdo::FETCH_ASSOC);
                      $n = $limt;
                      
                        if($all) {//لو في اي طلب مش ها تظهر

                    ?> 
              <table class="table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>cite</th>
                    <th>Duration</th>
                    <th>price</th>
                    <th>date</th>
                    <th>owner</th>
                    <th>accept</th>
                    <th>deletion</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- هذه العمليات لا خراج  طلب الرفع-->
                     <?php
                     foreach($all as $a){
                      $date = date_create($a["date"]);
                      $date = date_format($date , "Y-m-j g:i:s a"); // التنسيق الخاص بالتاريخ
                      $n++
                     ?>
                  <tr>
                    <td><?php echo $n;?></td>
                    <td><?php echo $a["category"];?></td>
                    <td><?php echo $a["citys"];?></td>
                    <td><?php echo $a["price"];?></td>
                    <td><?php echo $a["duration"];?></td>
                    <td><?php echo $date;?></td>
                    <td><?php echo $a["User_name"];?></td>
                    <!--_____________add-product___________-->
                    <td><a href="delete.php?add=<?php echo $a['id_cat']?>">add</a></td>
                    <!--_____________add-product___________-->
  
                    <!--_____________delete-product________-->
                    <td><a href="delete.php?del=<?php echo $a['id_cat']?>" class="second_btn">delete</a></td>
                    <!--_____________delete-product________-->
                  </tr>
                      <?php }?>
                </tbody>
              </table>
              <!--____start_____table__________-->
              <div class="Mobility">
              <?php
                if($start > 1){//تظهر اذاكان هناك قوائمه قبل هذه القائمه 
                ?>
                <span><a href="index.php?start=<?php echo $start - 1?>">back</a></span>
                <?php }?>
                <?Php for($i =1; $i<=$num_s;$i++){?>
                <a href="index.php?start=<?php echo $i?>" class="number"><?php echo $i?></a>
                <?php }?>
                <?php
                if($start < $num_s){//تظهر اذاكان هناك قوائم بعد هذه القائمه
                ?>
                <span><a href="index.php?start=<?php echo $start + 1?>">Next</a></span>
                <?php }?>
            </div>
            </div>
                <?php }else{ ?>
                <?php echo "لايوجد طلبات للرفع" ;}?><!--في حاله عدم وجود طلبات-->
            <?php }else{?>
<!--________start________-form login_________-->


                <!-- ______start_الرساله_popup___--->
                <div class="container_popup">
              <div class="Popup_card">
                <div class="Iecon"><i class="fac fa-solid fa-circle-exclamation"></i></div>
                <!--___________اسم المشكله___________-->
                <div class="Name_Error">هذا الاسم موجود بالفعل</div>
                <!--___________اسم المشكله___________-->
                <!--___________اقتراح حل المشكله____________-->
                <div class="suggestion">
                  <!--_____اكتب الاقتراح بالعربي انا مظبط الدنيا___-->
                  <p>Abdallah12</p>
                  <p>Abdallah_samir</p>
                  <p>ahmed_25c</p>
                  <p>samy6F2</p>
                  <!--_____اكتب الاقتراح بالعربي انا مظبط الدنيا___-->
                </div>
                <!--___________اقتراح حل المشكله____________-->
                <!--_________زرار الاغلاق الرساله________-->
                <a href="#" class="close">ok</a>
                <!--_________زرار الاغلاق الرساله________-->
              </div>
            </div>
            <!--________end_الرساله_popup___- -->



<div class="container_form">
  <div class="message signup">
    <div class="btn-wrapper">
      <button class="button" id="signup">Sign Up</button>
      <button class="button" id="login"> Login</button>
    </div>
  </div>
  <div class="form form--signup">
    <div class="form--heading">Sign Up</div>
    <form autocomplete="off" method="POST">
      <input type="text" placeholder="Name" name="Name" required value="<?php if(isset($name)){echo $name;}?>">
      <input type="text" placeholder="phone" name="phone" required value="<?php if(isset($phone)){echo $phone;}?>">
      <input type="email" placeholder="Email" name="email" required value="<?php if(isset($email)){echo $email;}?>">
      <input type="password" placeholder="Password" name="pass" required value="<?php if(isset($pass)){echo $pass;}?>">
      <input type="password" placeholder="Code" name="code" required value="<?php if(isset($code)){echo $code;}?>">
      <button class="button" type="submit">Sign Up</button>
    </form>
  </div>
  <div class="form form--login">
    <div class="form--heading"> login </div>
    <form autocomplete="off" method="POST">
      <input type="text" placeholder="Name or Email" name ="old_name" required>
      <input type="password" placeholder="Password" name="old_pass" required>
      <button class="button" type="submit">Login</button>
    </form>
  </div>
</div>
            <?php }?>
<!--________end________-form login_________-->

          </section>
        </section>
      </div>

      <!--*___________________right-section____________-->

      <script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
      <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"
      ></script>
      <script src="../java_script/main.js"></script>
      <script src="../java_script/jquery-1.12.4.min.js"></script>
      <script src="../java_script/jquery.counterup.min.js"></script>
      <script src="../java_script/swiper-bundle.min.js"></script>
      <script>
        jQuery(document).ready(function ($) {
          $(".counter").counterUp({
            delay: 10,
            time: 1000,
          });
        });
      </script>
    </body>
  </html>
</span>
