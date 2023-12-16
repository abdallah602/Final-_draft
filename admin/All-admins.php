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
      <link rel="stylesheet" href="../css/All-admins.css" />
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
      <title>Admins</title>
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
              <a href="profile.php">
                <i class="fas fa-solid fa-user"></i>
                <span class="nav-item">profile</span>
              </a>
            </li>

            <li>
              <a href="#">
                <i
                  class="fas fa-solid fa-users"
                  style="color: #34af6d !important"
                ></i>
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
            <h1>All admins</h1>
            <i class="fas fa-user-cog" style="font-size: 1.5rem"></i>
          </div>
          <div class="users"></div>
          <section class="attendance">
            <div class="attendance-list">
              <h1>Admins</h1>
              <!--____start_____table__________-->
              <table class="table">
                
                <thead>
                  <tr>
                    <th class="head">ID</th>
                    <th class="head">image</th>
                    <th class="head">name</th>
                    <th class="head">gmail</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                include("../user/include/connect.php");
                $select = $db->query("SELECT name,email from admin");
                $select = $select->fetchAll(pdo::FETCH_ASSOC);
                $n = 0;
                foreach($select as $sel){
                  $n++;
                ?>
                  <tr>
                    <td><?php echo $n?></td>
                    <td> <i class="fas fa-solid fa-user-shield"></i></td>
                    <td><?php echo $sel['name']?></td>
                    <td><?php echo $sel['email']?></td>
                  </tr>
                <?php }?>
                </tbody>
              </table>
              <!--____start_____table__________-->
            </div>
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
      <script src="../js/main.js"></script>
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
      <?phP }?>