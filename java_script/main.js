function myFunction() {
    var x = document.getElementById("myInput");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }
  /*_________form_login_Dashboard*/
  $("#signup").click(function() {
    $(".message").css("transform", "translateX(100%)");
    if ($(".message").hasClass("login")) {
      $(".message").removeClass("login");
    }
    $(".message").addClass("signup");
  });
  
  $("#login").click(function() {
    $(".message").css("transform", "translateX(0)");
    if ($(".message").hasClass("login")) {
      $(".message").removeClass("signup");
    }
    $(".message").addClass("login");
  });
  
  /*_________form_login_Dashboard*/

  