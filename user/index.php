<?php

// user/index.php

include('wus.php');

$object = new wus();

// if(!$object->is_login())
// {
//     header("location:".$object->base_url."user");
// }

if($object->is_master_user())
{
    header("location:".$object->base_url."user/dashboard.php");
}

if($object->is_staff_user())
{
    header("location:".$object->base_url."user/staff-dashboard.php");
}

if($object->is_teacher_user())
{
    header("location:".$object->base_url."teacher/index.php");
}

if($object->is_student_user())
{
    header("location:".$object->base_url."student/index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <title>WakeUpStream | An Online Education Platform</title>

    <!-- Favicons -->
    <!-- <link href="assets/image/favicon.png" rel="icon"> -->
    <!-- <link href="assets/image/apple-touch-icon.png" rel="apple-touch-icon"> -->

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cabin&family=Playfair+Display&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="../assets/vendor/animate.css/animate.min.css">
    <link rel="stylesheet" href="../assets/vendor/aos/aos.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-select/bootstrap-select.min.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="../assets/vendor/remixicon/remixicon.css">
    <link rel="stylesheet" href="../assets/vendor/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="../assets/vendor/parsley/parsley.css"/>
    <!-- <link rel="stylesheet" href=""> -->

    <!-- Enternal CSS Files -->
    <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>

  <!-- ======= Header ======= -->
  <header id="header">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a class="active" href="../index.php">WakeUpStream</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <!-- <li class="dropdown"><a href="#"><span>Categories</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
                <li class="dropdown"><a href="#"><span>IT</span><i class="bi bi-chevron-right"></i></a>
                  <ul>
                    <li><a href="#">C Programing</a></li>
                    <li><a href="#">Python</a></li>
                    <li><a href="#">Java</a></li>
                  </ul>
                </li>
                <li class="dropdown"><a href="#"><span>Languages</span><i class="bi bi-chevron-right"></i></a>
                  <ul>
                    <li><a href="#">Arabic</a></li>
                    <li><a href="#">English</a></li>
                    <li><a href="#">Hindi</a></li>
                    <li><a href="#">Urdu</a></li>
                  </ul>
                </li>
                <li><a href="#">Drop Down 3</a></li>
                <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li> -->
          <li><a href="../event.php">Events</a></li>
          <li><a href="../trainers.php">Instructors</a></li>
          <li><a href="../whatsnew.php">What's New</a></li>

        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

      <a href="" class="get-started-btn">Get Started</a>

    </div>
  </header><!-- End Header -->

  <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <h1 class="display-4">Welcome to WakeUpStream </h1><br>
  <h4>An Online Education Platform.</h4>
  </div>
  <br />
  <br />
  <div class="container mb-5 " style="width: 24rem;">
    <main class="form-signin">
        <form method="post" id="login_form" >
            <div class="card-header">
                <h1 class="h3 mt-2 mb-2 fw-normal text-center">Login To Continue</h1>
            </div>
            <span id="error"></span>
            <div class="card-body">
              <div class="form-floating form-group">
                <input type="text" name="user_email" id="user_email" class="form-control" required autofocus data-parsley-type="email" data-parsley-trigger="keyup" placeholder="Email" />
                <label for="user_email"><b>Email</b></label>
              </div>
              <br />
              <div class="form-floating form-group">
                <input type="password" name="user_password" id="user_password" class="form-control" required  data-parsley-trigger="keyup" placeholder="Password" />
                <label for="user_password"><b>Password</b></label>
              </div>
            </div>
            <div class="card-footer text-right">
              <div class="form-group">
                  <button type="submit" name="login_button" id="login_button" class="btn btn-primary">Login</button>
              </div>
            </div>
        </form>
        <div class="text-center">
          <br />
          <h5>Don't have a Student account?<br>
          <a href="../student/signup.php">SignUp as student</a>
          </h5>
          <br>
          <h5>Create a Teacher account?<br>
          <a href="../teacher/signup.php">SignUp as teacher</a>
          </h5>
        </div>
    </main>

    </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../assets/js/sb-admin-2.min.js"></script>

  <script type="text/javascript" src="../assets/vendor/parsley/dist/parsley.min.js"></script>

</body>

</html>

<script>

$(document).ready(function(){

  $('#login_form').parsley();

  $('#login_form').on('submit', function(event){
      event.preventDefault();
      if($('#login_form').parsley().isValid())
      {       
          $.ajax({
              url:"login_action.php",
              method:"POST",
              data:$(this).serialize(),
              dataType:'json',
              beforeSend:function()
              {
                  $('#login_button').attr('disabled', 'disabled');
                  $('#login_button').val('wait...');
              },
              success:function(data)
              {
                  $('#login_button').attr('disabled', false);
                  if(data.error != '')
                  {
                      $('#error').html(data.error);
                      $('#login_button').val('Login');
                  }
                  else
                  {
                      window.location.href = data.url;
                  }
              }
          })
      }
  });

});

</script>