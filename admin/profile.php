<?php

  if(!isset($_COOKIE["admin_name"])){
    header("location:index.php");
  }else{
    include("../user/include/connect.php");
    include("../function/func.php");
    if($_SERVER["REQUEST_METHOD"] === "POST"){
      $name   = $_POST['name'];
      $email  = $_POST['email'];
      $mobile = $_POST['mobile'];
      $pass   = $_POST['password'];
      $error  = [];
      if(strlen($pass) <8){
        ?>
        <p><?php echo "كلمه السر اقل من المطلوب"?></p>
        <?php
      }else{
      if(!is_strong($pass)){
        ?>
        <p><?php echo "كلمه السر ضعيفه"; ?></p>
        <?Php
        
      }else{
      if($name == $_COOKIE['admin_name']){
        $old = $_COOKIE['admin_name'];
        if(is_mobilephone($mobile)):
        $db->exec("UPDATE admin set email = '$email' ,password = '$pass' 
        , mobile = '$mobile' where name = '$old'");
        setcookie("admin_name" , $old , 0,'/');
        else:
          ?>
            <p><?php echo 'رقم التليفون غير صحيح'?></p>
            <?php
        endif;
      }else{
        $s = $db->query("SELECT name from admin where name = '$name'");
        $s = $s->fetch(pdo::FETCH_ASSOC);
        if($s){
          ?>
          <p><?php echo "هذا الاسم موجود بالفعل"?></p>
          <?php
        }else{
          if(is_mobilephone($mobile)){
            $old = $_COOKIE['admin_name'];
            $db->exec("UPDATE admin set name = '$name' ,email = '$email' ,
            password = '$pass' , mobile = '$mobile' where name = '$old'");
            setcookie("admin_name" , $name , 0,'/');
            header("location:profile.php");
          }else{
            ?>
            <p><?php echo 'رقم التليفون غير صحيح'?></p>
            <?php
          }
        }
      }
      }
    }
    }
?>
<span style="font-family: verdana, geneva, sans-serif"
  ><!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <link rel="stylesheet" href="../css/profile.css" />
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
      <link rel="stylesheet" href="css_admin/bootstrap.min.css" />
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
      <title>Profile</title>
    </head>
    <body>
      <!--*___________________left-section-nav___________-->
      <div class="container">
        <nav>
          <ul>
            <li>
              <a href="#" class="logo">
                <i class="fas fa-solid fa-user-shield"></i>
                <span class="nav-item">Admin</span>
              </a>
            </li>

            <li>
              <a href="index.php">
                <i class="fas fa-menorah"></i>
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
              <a href="#">
                <i
                  class="fas fa-solid fa-user"
                  style="color: #34af6d !important"
                ></i>
                <span class="nav-item">profile</span>
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
            <h1>Profile</h1>
            <i class="fas fa-user-cog" style="font-size: 1.5rem"></i>
          </div>
          <div class="users">
            <section class="attendance">
              <div class="container_profile">
                <div class="con">
                  <h2>personal information</h2>
                  <i class="fas fa-solid fa-user-shield"></i>
                </div>
                  <?php
                    $Admin_name = $_COOKIE["admin_name"];
                    $select = $db->query("SELECT * from admin where name = '$Admin_name'");
                    $select = $select->fetch(pdo::FETCH_ASSOC);
                  ?>
                  <form action="" method="POST">
                <div class="form-group">
                  <div class="in_group">
                    <label for="#">name</label>
                    <input
                      class="form-control"
                      placeholder="pleade type your name"
                      type="text"
                      name="name"
                      value="<?php echo $select['name']?>"
                      required
                    />
                  </div>

                  <div class="in_group">
                    <label for="#">gmail</label>
                    <input
                      class="form-control"
                      placeholder="email"
                      type="email"
                      name="email"
                      value="<?php echo $select['email']?>"
                      required
                    />
                  </div>

                  <div class="in_group">
                    <label for="#">phone</label>
                    <input
                      class="form-control"
                      placeholder="pleade type your name"
                      type="text"
                      name="mobile"
                      value="<?php echo $select['mobile']?>"
                      required
                    />
                  </div>
                  <div class="in_group">
                    <label for="#">password</label>
                    <input
                      class="form-control"
                      placeholder="pleade type your name"
                      type="password"
                      name="password"
                      value="<?php echo $select['password']?>"
                      id="myInput"
                      required
                    />
                    <i
                      class="show fa-regular fa-eye"
                      onclick="myFunction()"
                    ></i>
                  </div>
                  <input type="submit" value="update" class="mohamed">
              </form>
                </div>
                
              </div>
            </section>
          </div>
        </section>
      </div>

      <!--*___________________right-section____________-->

      <script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
      <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"
      ></script>
      <script src="../js/main_root.js"></script>
      <script src="../js/jquery-1.12.4.min.js"></script>
      <script src="../js/jquery.counterup.min.js"></script>
      <script src="../js/swiper-bundle.min.js"></script>
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
      <?Php }?>