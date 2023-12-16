<?php

  if(!isset($_COOKIE["admin_name"])){
    header("location:index.php");
  }else{

?>
<span style="font-family: verdana, geneva, sans-serif"
  ><!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <link rel="stylesheet" href="../css/message.css" />
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
      <title>Messages</title>
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
              <a href="#">
                <i class="fas fa-comment" style="color: #34af6d !important"></i>
                <span class="nav-item">Message</span>
              </a>
            </li>

            <li>
              <a href="profile.php">
                <i class="fas fa-solid fa-user"></i>
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
            <h1>Messages</h1>
            <i class="fas fa-user-cog" style="font-size: 1.5rem"></i>
          </div>
          <?php
                include("../user/include/connect.php");
                $select = $db->query('SELECT messege.id,text ,User_name,Mdate as date,Email
                from messege inner join users on messege.id_user = users.id order by date desc');
                $select = $select->fetchAll(pdo::FETCH_ASSOC);
                $n = 0;
                if($select){
                ?>
          <div class="users">
            <section class="attendance">
              <div class="attendance-list">
                <h1>Message management</h1>
                
                <table class="table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Gmail</th>
                      <th>message</th>
                      <th>date</th>
                      <th class="basket_">delete</th>
                    </tr>
                  </thead>
                  <?Php
                  include("../user/include/connect.php");
                  $select = $db->query('SELECT messege.id,text ,User_name,Mdate as date,Email
                  from messege inner join users on messege.id_user = users.id order by date desc');
                  $select = $select->fetchAll(pdo::FETCH_ASSOC);
                  $n = 0;
                  foreach($select as $s){
                    $date = date_create($s["date"]);
                    $date = date_format($date , "Y-m-j g:i:s a"); // التنسيق الخاص بالتاريخ
                    $n++;
                  ?>
                  <tbody>
                    <tr>
                      <td><?php echo $n?></td>
                      <td><?php echo $s["User_name"]?></td>
                      <td><?php echo $s["Email"]?></td>
                      <td class="message">
                        <?php echo $s["text"]?>
                      </td>
                      <td><?php echo $date?></td>
                      </td>
                      <td class="basket"><a href="delete.php?id_message=<?php echo $s["id"]?>"><i class="fa-solid fa-trash"></i></a></td>
                    </tr>
                  <?php }?>
                  </tbody>
                </table>
                  <?php } else{
                    ?>

                    <p> <?php echo "لاتوجد رسايل ";?></p> <!--في حاله عدم وجود رسايل-->

                    <?php
                    }?>
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
      <script src="../js/scripts.js"></script>
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
      <?php }?>