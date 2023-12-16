<?php 
    if(isset($_COOKIE["user_name"]) || isset($_COOKIE["admin_name"])){

  include("include/connect.php");
    $id = $_GET['id'];
    $select = $db->query("SELECT 	`products`.* , users.User_name as us from users inner JOIN 
    products on products.id = '$id' where products.id_user = users.id");
    $select = $select->fetch(pdo::FETCH_ASSOC);
    $img    = explode("?",$select['img_name']);
    if($_SERVER['REQUEST_METHOD'] == "POST"){
      include("../function/func.php");
      $mss = $_POST['message'];
      $mss = is_string_true($mss);
      $user_name = $_COOKIE['user_name'];
      $id_user = $db->query("SELECT id from users where User_name = '$user_name'");
      $id_user = $id_user->fetch(pdo::FETCH_ASSOC);
      $id_user = $id_user['id'];
      $db->exec("INSERT INTO `comments`(`message`, `id_user`, `id_product`) 
      VALUES ('$mss' , $id_user,$id)");
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/normalize.css" />
    <link rel="stylesheet" href="../css/More_Details.css" />
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
            <li class="nav-item" >
              <a class="nav-link" href="services.php">Services</a>
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
    <a href="#" class="DElet_brn" data-aos="fade-buttom" data-aos-delay="400">Delete</a>
    <!--________start______main_product_________-->
    <div class="main">
      <div id="content-wrapper">
        <!--______start______img_card________right___________ -->
        <div class="column" data-aos="fade-right" data-aos-delay="500">
          <img id="featured" src="img/<?php echo $img[0]?>" />
          <div id="slide-wrapper">
            <?php for($i = 1;$i < count($img) ;$i++){?>
            <div id="slider">
              <img class="thumbnail" src="img/<?php echo $img[$i]?>" />
            </div>
            <?php }?>
          </div>
        </div>
        <!--______end______img_card___________________ -->
        <div class="right_contint" data-aos="fade-left" data-aos-delay="500">
          <h1>
            <i class="fas fa-solid fa-user"></i> <span>owner</span> :
            <?php echo $select['us']?>
          </h1>
          <h2>
            city :
            <span><?php echo $select['citys']?></span>
          </h2>
          <h2>
            Duration :
            <span><?php echo $select['duration']?></span>
          </h2>
          <h2>
            price :
            <span><?php echo $select['price']?> EGP</span>
          </h2>
          <p class="text_erea">
          <?php echo $select['text']?>.
          </p>
          <a href="#" alt="#"><span class="box"> Tell now </span></a>
        </div>

        <!--________end______main_product_________-->

        <!--____start____massege_section________________-->
              <?php 
                $sel = $db->query("SELECT `message` , `users`.`User_name`,`d_message` as date
                from comments inner JOIN users on comments.id_user = users.id
                where id_product = $id");
                $sel = $sel->fetchAll(pdo::FETCH_ASSOC);
                
              ?>
        <!-- May 27, 2015 at 3:14am  -->
        <div class="be-comment-block" data-aos="fade-up" data-aos-delay="500">
          <h1 class="comments-title">Comments</h1>
          <?php
          foreach($sel as $s){
            $date = date_create($s["date"]);
            $date = date_format($date ,"M -j-Y h:i a");
          ?>
          <div class="be-comment">
            <div class="be-img-comment">
              <a href="blog-detail-2.html">
                <i class="fas fa-solid fa-user"></i>
              </a>
            </div>
            <div class="be-comment-content">
              <span class="be-comment-name">
                <a href="blog-detail-2.html"><?Php echo $s["User_name"]?></a>
              </span>
              <span class="be-comment-time">
                <i class="fa fa-clock-o"></i>
                <?php echo $date ?>
              </span>

              <p class="be-comment-text"><?phP echo $s["message"]?></p>
            </div>
          </div>
                <?php }?>
          
          
          <!--____________form_message________________-->
          <form class="form-block" action="More_details.php?id=<?php echo $id?>" method="post">
            <div class="row">
              <div class="col-xs-12">
                <div class="form-group">
                  <textarea
                    class="form-input"
                    required=""
                    placeholder="Your comment"
                    maxlength="230"
                    rows="3"
                    name = "message"
                  ></textarea>
                </div>
              </div>
              <input type="submit" class="btn btn-primary pull-right" value="send">
            </div>
          </form>
          <!--____________form_message________________-->
        </div>
      </div>
    </div>

    <!--____end____massege_section________________-->

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
    <script src="../js/jquery-1.12.4.min.js"></script>
    <script src="../js/main_root.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            offset:150,
        });
    </script>
  </body>
</html>
<?php
    }else{
        header("location:login.php");
    }

?>