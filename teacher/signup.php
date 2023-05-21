<?php

// user/signup.php

include('wus.php');

$object = new wus();

// if(!$object->is_login())
// {
//     header("location:".$object->base_url."user");
// }

if($object->is_master_user())
{
    header("location:".$object->base_url."user/index.php");
}

if($object->is_staff_user())
{
    header("location:".$object->base_url."user/index.php");
}

// if($object->is_teacher_user())
// {
//     header("location:".$object->base_url."teacher/index.php");
// }

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

      <h1 class="logo me-auto"><a class="active" href="../user/index.php">WakeUpStream</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a href="../user/event.php">Events</a></li>
          <li><a href="../user/trainers.php">Instructors</a></li>
          <li><a href="../user/whatsnew.php">What's New</a></li>

        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

      <a href="../user/index.php" class="get-started-btn">Get Started</a>

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
        <!-- <form method="post" id="signup_form" >
            <div class="card-header">
                <h1 class="h3 mt-2 mb-2 fw-normal text-center">Sign Up To Start Learning</h1>
            </div>
            <span id="error"></span>
            <div class="card-body">
              <div class="form-floating form-group">
                <input type="text" name="user_name" id="user_name" class="form-control" required autofocus data-parsley-type="name" data-parsley-trigger="keyup" placeholder="Name" />
                <label for="user_name"><b>Name</b></label>
              </div>
              <br />
              <div class="form-floating form-group">
                <input type="text" name="user_email" id="user_email" class="form-control" required autofocus data-parsley-type="email" data-parsley-trigger="keyup" placeholder="Email" />
                <label for="user_email"><b>Email</b></label>
              </div>
              <br />
              <div class="form-floating form-group">
                <input type="password" name="user_password" id="user_password" class="form-control" required  data-parsley-trigger="keyup" placeholder="Password" />
                <label for="user_password"><b>Password</b></label>
              </div> -->
              <!-- Afshan make this tick working -->
              <!-- <div class="form-check form-group">
                <input class="form-check-input" type="checkbox" value="" id="flexCheck" required>
                <label class="form-check-label" for="flexCheck">I agree the terms and conditons.</label>
            </div>
            </div>
            
            <div class="card-footer text-right">
              <div class="form-group">
                  <button type="submit" name="signup_button" id="signup_button" class="btn btn-primary">signup</button>
              </div>
            </div>
        </form> -->
        <form method="post" id="user_form">
      		<div class="card-content">
        		<div class="card-header">
            <h1 class="h3 mt-2 mb-2 fw-normal text-center">Signup as Teacher</h1>
        		</div>
        		<div class="card-body">
        			<span id="form_message"></span>
                    <div class="form-group">
                          <label for="user_name"><b>Name</b></label>
                          <input type="text" name="user_name" id="user_name" class="form-control" required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150" data-parsley-trigger="keyup" placeholder="Name" />
                    </div>
                    <div class="form-group">
                          <label for="user_contact_no"><b>User Contact No.</b></label>
                          <input type="text" name="user_contact_no" id="user_contact_no" class="form-control" required data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup" placeholder="Contact"/>
                    </div>
                    <div class="form-group">
                            <label for="user_email"><b>Email</b></label>
                            <input type="text" name="user_email" id="user_email" class="form-control" required data-parsley-type="email" data-parsley-maxlength="150" data-parsley-trigger="keyup" placeholder="Email"/>
                    </div>

                    <div class="form-group">
                            <label for="user_password"><b>User Password</b></label>
                            <input type="password" name="user_password" id="user_password" class="form-control" required data-parsley-minlength="6" data-parsley-maxlength="16" data-parsley-trigger="keyup" placeholder="Password"/>
                    </div>                  
                    <div class="card-footer">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="submit" name="submit" id="submit_button" class="btn btn-primary" value="Create" />
                    </div>
      		</div>
    	</form>
        <div class="align-item-center">
          <br />
          <h5>Already have an account?
          <a href="../user/index.php">Login</a> Now.
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
   // Click event for element with id="add_user" starts  
   $('#add_user').click(function(){
		
        // Reset the element with id="user_form"
		$('#user_form')[0].reset();

        // Reset the element with id="user_form"
		$('#user_form').parsley().reset();

        // Make value="Add" to element with id="action"
    	$('#action').val('Add');

    	$('#submit_button').val('Add');

    	// $('#userModal').modal('show');

    	$('#form_message').html('');

        // $('#user_uploaded_image').html('');
        
        }
    );
    // Click event for element with id="add_user" Ends  

	$('#user_form').parsley();

	$('#user_form').on('submit', function(event){
		event.preventDefault();
		if($('#user_form').parsley().isValid())
		{		
			$.ajax({
                // Will send the uploaded data to student_action.php
				url:"signup_action.php",
				method:"POST",
				data:new FormData(this),
				dataType:'json',
        contentType:false,
        processData:false,
				beforeSend:function()
				{
					$('#submit_button').attr('disabled', 'disabled');
					// $('#submit_button').val('wait...');
				},
				success:function(data)
				{
           // $('#submit_button').val('Done');
           $('#submit_button').attr('disabled', false);
					if(data.error != '')
					{
						$('#form_message').html(data.error);
						// $('#submit_button').val('Not Created');

            setTimeout(function(){

                  $('#form_message').html('');

            }, 5000);
					}
					else
					{
						// $('#userModal').modal('hide');
						$('#form_message').html(data.success);
            // $('#submit_button').val('Created');

						// ajax.reload();

						setTimeout(function(){

				            $('#form_message').html('');

				        }, 5000);
					}
          $('#user_form')[0].reset();
          $('#user_form').parsley().reset();
				}
			})
		}
	});

</script>