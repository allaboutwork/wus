<!-- index.php -->

<?php 

include("./user/wus.php");

$object = new wus();

// if($object->is_login())
// {
//     header("location:".$object->base_url."user/dashboard.php");
// }

include("header.php");
?>


<!--  Subheader Section Starts -->
<section id="subheader" class="d-flex justify-content-center align-items-center">
  <!-- <div class="container position-relative" data-aos="zoom-in" data-aos-delay="100"> -->
  <div class="container position-relative" data-aos="zoom-in">
    <h1>Welcome to WakeUpStream</h1>
    <h2>Happy to serve you as a member of our online learning family.</h2>
    <a href="./user/index.php" class="btn-get-started">Get Started</a>
  </div>
</section><!-- Subheader Section Ends -->


<!--  Main Section Starts -->
<main id="main">

<!--  About Section  -->
<section id="about" class="about">
  <!-- <div class="container" data-aos="fade-up"> -->
  <div class="container">

    <div class="row">
      <div class="col-lg-6 pt-1 pt-lg-0 order-1 order-lg-1 content">
        <h3>WakeUpStream is an online learning platform.</h3>
        <ul>
          <li><i class="bi bi-check-square"></i>Anybody can take courses for free or publish their own courses for free.</li>
          <li><i class="bi bi-check-square"></i> Complete courses and get certified.</li>
          <li><i class="bi bi-check-square"></i> We have dual certfication policy for most of our courses.</li>
          <li><i class="bi bi-check-square"></i> You can rank up or rank down the courses if you like or dislike it.</li>
          <li class="color-danger"><i class="bi bi-check-square"></i> Only <strong> pay once </strong> for the certficate after completing the course.</li>
        </ul>
        <p>
            Most of our courses are in accordence with the syllabus of AMU Aligarh.
        </p>
      </div>

      <!-- <div class="col-lg-6 order-2 order-lg-2" data-aos="fade-up" data-aos-delay="300"> -->
      <div class="col-lg-6 order-2 order-lg-2" data-aos="fade-up">
        <img src="./assets/image/about.jpg" class="img-fluid" alt="">
      </div>
    </div>

  </div>
</section><!-- End About Section -->

<!--  Features/Category Section  -->
<section id="features" class="features">
  <div class="container" data-aos="fade-up">
  <!-- <div class="container"> -->

    <div class="section-title">
      <br>
      <h2>Categories</h2>
      <p>Popular Categories</p>
    </div>
    
    <div class="row d-flex justify-content-center" data-aos="fade-up" data-aos-delay="350">
    <?php
      $object->query = "
      SELECT * FROM category_wus 
      WHERE category_status = 'Enable'
      ";
      $result = $object->get_result();
      
      $category_id = '';
      $category_name = '';

      foreach($result as $row)
      {
          $category_id = $row['category_id'];
          $category_name = $row['category_name'];
          ?>
            <div class="col-lg-3 col-md-3 mt-1 mb-1">
              <div class="icon-box">
                <i class="ri-heart-2-line" style="color: #5f6acf;"></i>
                <ul>
                <!-- '<a href="subject.php?action=view&category_id='.$row["category_id"].'" class="btn btn-secondary btn-sm"> Subject</a>' -->
                <a href="category.php?action=view&category_id=<?php echo "$category_id"; ?>">
                <?php
                    echo "$category_name";
                ?>
                </a>
                <ul>
              </div>
      </div>
      <?php
      }
      ?>
      <div class="col-lg-3 col-md-3 mt-1 mb-1">
              <div class="icon-box">
                <i class="ri-search-line" style="color: #5f6acf;"></i>
                <h3><a href="all-category.php">Click here to explore all Categories</a></h3>
              </div>
      </div>
      </div>
    </div>
      
    <!-- </div> -->

  </div>
</section><!-- End Features Section -->

<!--  Popular Courses Section  -->
<section id="popular-courses" class="features">
  <div class="container" data-aos="fade-up">
  <div class="container">

    <div class="section-title">
      <h2>Courses</h2>
      <p>Popular Courses</p>
    </div>

    <!-- <div class="row" data-aos="zoom-in" data-aos-delay="350"> -->

    <div class="row d-flex justify-content-center" data-aos="fade-up" data-aos-delay="350">
    <?php
    
      $object->query = "
      SELECT * FROM course_wus 
      WHERE course_status = 'Enable'
      ";
      $result = $object->get_result();
      
      $course_name = '';
      ?>

      <!-- <ul> -->
      
      <?php
      foreach($result as $row)
      {
          $course_id = $row['course_id'];
          $course_name = $row['course_name'];
          $course_duration = $row['course_duration'];
          $course_level = $row['course_level'];
          $course_added_by = $object->Get_user_name($row['course_added_by']);
          ?>
            <div class="col-lg-4 col-md-3 mt-1 mb-1">
              <div class="icon-box">
                <i class="ri-heart-2-line" style="color: #5f6acf;"></i>
                <ul>
                <a href="course-detail.php?action=view&course_id=<?php echo"$course_id"; ?>">
                  <?php
                    echo "<li>Name: $course_name</li>";
                    echo "<li>Duration: $course_duration</li>";
                    echo "<li>Level: $course_level</li>";
                    ?>
                </a>
                </ul>
              </div>
      </div>
      <?php
      }
      ?>
      <div class="col-lg-3 col-md-3 mt-1 mb-1">
              <div class="icon-box">
                <i class="ri-search-line" style="color: #5f6acf;"></i>
                <h3><a href="#">Click here to explore all Courses</a></h3>
              </div>
      </div>
      </div>
    </div>
  <!-- </div> -->
</section><!-- End Popular Courses Section -->

<!--  Popular Courses Section  -->
<!-- <section id="popular-courses" class="courses"> -->
  <!-- <div class="container" data-aos="fade-up"> -->
  <!-- <div class="container">

    <div class="section-title">
      <h2>Courses</h2>
      <p>Popular Courses</p>
    </div>

    <div class="row" data-aos="zoom-in" data-aos-delay="100">

      <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
        <div class="course-item">
          <div class="">
          <img src="./assets/image/course-1.jpg" class="img-fluid" alt="...">
          </div>
          <div class="course-content">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h4>Web Development</h4>
              <p class="price">$169</p>
            </div>

            <h3><a href="course-details.html">Website Design</a></h3>
            <p>Et architecto provident deleniti facere repellat nobis iste. Id facere quia quae dolores dolorem tempore.</p>
            <div class="trainer d-flex justify-content-between align-items-center">
              <div class="trainer-profile d-flex align-items-center">
                <img src="./assets/image/trainers/trainer-1.jpg" class="img-fluid" alt="">
                <span>Antonio</span>
              </div>
              <div class="trainer-rank d-flex align-items-center">
                <i class="bx bx-user"></i>&nbsp;50
                &nbsp;&nbsp;
                <i class="bx bx-heart"></i>&nbsp;65
              </div>
            </div>
          </div>
        </div>
      </div>  -->
      <!-- End Course Item-->

      <!-- <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
        <div class="course-item">
          <img src="./assets/image/course-2.jpg" class="img-fluid" alt="...">
          <div class="course-content">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h4>Marketing</h4>
              <p class="price">$250</p>
            </div>

            <h3><a href="course-details.html">Search Engine Optimization</a></h3>
            <p>Et architecto provident deleniti facere repellat nobis iste. Id facere quia quae dolores dolorem tempore.</p>
            <div class="trainer d-flex justify-content-between align-items-center">
              <div class="trainer-profile d-flex align-items-center">
                <img src="./assets/image/trainers/trainer-2.jpg" class="img-fluid" alt="">
                <span>Lana</span>
              </div>
              <div class="trainer-rank d-flex align-items-center">
                <i class="bx bx-user"></i>&nbsp;35
                &nbsp;&nbsp;
                <i class="bx bx-heart"></i>&nbsp;42
              </div>
            </div>
          </div>
        </div>
      </div>  -->
      <!-- End Course Item-->

      <!-- <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0">
        <div class="course-item">
          <img src="./assets/image/course-3.jpg" class="img-fluid" alt="...">
          <div class="course-content">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h4>Content</h4>
              <p class="price">$180</p>
            </div>

            <h3><a href="">Copywriting</a></h3>
            <p>Et architecto provident deleniti facere repellat nobis iste. Id facere quia quae dolores dolorem tempore.</p>
            <div class="trainer d-flex justify-content-between align-items-center">
              <div class="trainer-profile d-flex align-items-center">
                <img src="./assets/image/trainers/trainer-3.jpg" class="img-fluid" alt="">
                <span>Brandon</span>
              </div>
              <div class="trainer-rank d-flex align-items-center">
                <i class="bx bx-user"></i>&nbsp;20
                &nbsp;&nbsp;
                <i class="bx bx-heart"></i>&nbsp;85
              </div>
            </div>
          </div>
        </div>
      </div>  -->
      <!-- End Course Item-->

    </div>

  </div>
</section><!-- End Popular Courses Section -->

<!--  Counts Section  -->
<!-- <section id="counts" class="counts section-bg"> -->
<section id="counts" class="counts">
  <div class="container">
    <h3 class="text-center">Currently, these are our total family members.</h3>

    <div class="row counters">

      <div class="col-lg-3 col-6 text-center">
        <i class="bx bx-user"></i>
        <span data-purecounter-start="0" data-purecounter-end="<?php echo $object->get_total_student();?>" data-purecounter-duration="1" class="purecounter"></span>
        <p>Students</p>
      </div>

      <div class="col-lg-3 col-6 text-center">
        <i class="bx bx-video"></i>
        <span data-purecounter-start="0" data-purecounter-end="<?php echo $object->get_total_course();?>" data-purecounter-duration="1" class="purecounter"></span>
        <p>Courses</p>
      </div>

      <div class="col-lg-3 col-6 text-center">
        <i class="bx bx-globe"></i>
        
        <span data-purecounter-start="0" data-purecounter-end="<?php echo $object->get_total_category();?>" data-purecounter-duration="1" class="purecounter"></span>
        <p>Categories</p>
      </div>

      <div class="col-lg-3 col-6 text-center">
        <i class="bx bx-user"></i>
        <span data-purecounter-start="0" data-purecounter-end="<?php echo $object->get_total_teacher();?>" data-purecounter-duration="1" class="purecounter"></span>
        <p>Trainers</p>
      </div>

    </div>

    <h3 class="text-center">Much more joining soon.</h3>
  </div>
</section><!-- End Counts Section -->

<!--  Trainers Section  -->
<section id="trainers" class="features">
  <div class="container" data-aos="fade-up">
  <div class="container">

  <div class="section-title">
      <h2>Trainers</h2>
      <p>Popular Trainers</p>
    </div>

    <div class="row d-flex justify-content-center" data-aos="fade-up" data-aos-delay="350">
    <?php
      $object->query = "
      SELECT * FROM user_wus 
      WHERE user_type = 'Teacher'
      ";
      $result = $object->get_result();
      
      $course_name = '';
      ?>

      <!-- <ul> -->
      
      <?php
      foreach($result as $row)
      {
          $user_name = $row['user_name'];
          // $course_duration = $row['course_duration'];
          // $course_level = $row['course_level'];
          // $course_added_by = $row['course_added_by'];
          ?>
            <div class="col-lg-3 col-md-3 mt-1 mb-1">
              <div class="icon-box">
                <i class="ri-heart-2-line" style="color: #5f6acf;"></i>
                <ul>
                <a href="trainer-detail.php">
                  <?php
                    echo "<li>Name: $user_name</li>";
                    // echo "<li>Duration: $course_duration</li>";
                    // echo "<li>Level: $course_level</li>";
                    // echo "<li>Instructor: $course_added_by</li>";
                  ?>
                </a>
                </ul>
              </div>
      </div>
      <?php
      }
      ?>
      <div class="col-lg-3 col-md-3 mt-1 mb-1">
              <div class="icon-box">
                <i class="ri-search-line" style="color: #5f6acf;"></i>
                <h3><a href="all-category.php">Click here to explore all Trainers</a></h3>
              </div>
      </div>
      </div>

  </div>
  </div>
</section><!-- End Trainers Section -->

<!--  Trainers Section  -->
<!-- <section id="trainers" class="trainers"> -->
  <!-- <div class="container" data-aos="fade-up"> -->
  <!-- <div class="container">

  <div class="section-title">
      <h2>Trainers</h2>
      <p>Popular Trainers</p>
    </div>

    <div class="row" data-aos="zoom-in" data-aos-delay="100">
      <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
        <div class="member">
          <img src="./assets/image/trainers/trainer-1.jpg" class="img-fluid" alt="">
          <div class="member-content">
            <h4>Walter White</h4>
            <span>Web Development</span>
            <p>
              Magni qui quod omnis unde et eos fuga et exercitationem. Odio veritatis perspiciatis quaerat qui aut aut aut
            </p>
            <div class="social">
              <a href=""><i class="bi bi-twitter"></i></a>
              <a href=""><i class="bi bi-facebook"></i></a>
              <a href=""><i class="bi bi-instagram"></i></a>
              <a href=""><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
        <div class="member">
          <img src="./assets/image/trainers/trainer-2.jpg" class="img-fluid" alt="">
          <div class="member-content">
            <h4>Sarah Jhinson</h4>
            <span>Marketing</span>
            <p>
              Repellat fugiat adipisci nemo illum nesciunt voluptas repellendus. In architecto rerum rerum temporibus
            </p>
            <div class="social">
              <a href=""><i class="bi bi-twitter"></i></a>
              <a href=""><i class="bi bi-facebook"></i></a>
              <a href=""><i class="bi bi-instagram"></i></a>
              <a href=""><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
        <div class="member">
          <img src="./assets/image/trainers/trainer-3.jpg" class="img-fluid" alt="">
          <div class="member-content">
            <h4>William Anderson</h4>
            <span>Content</span>
            <p>
              Voluptas necessitatibus occaecati quia. Earum totam consequuntur qui porro et laborum toro des clara
            </p>
            <div class="social">
              <a href=""><i class="bi bi-twitter"></i></a>
              <a href=""><i class="bi bi-facebook"></i></a>
              <a href=""><i class="bi bi-instagram"></i></a>
              <a href=""><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
</section> -->
<!-- End Trainers Section -->

<!--  Why Us Section  -->
<section id="why-us" class="why-us">
  <div class="container" data-aos="fade-up" data-aos-delay="100">

  <div class="section-title">
      <h2>Addtion Benefits</h2>
      <p>And more to come</p>
    </div>
    
    <div class="row d-flex justify-content-center">
      <!-- <div class="col-lg-4 d-flex align-items-stretch">
        <div class="content">
          <h3>Why Choose WakeUpStream?</h3>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit
            Asperiores dolores sed et. Tenetur quia eos. Autem tempore quibusdam vel necessitatibus optio ad corporis.
          </p>
          <div class="text-center">
            <a href="" class="more-btn">Learn More <i class="bx bx-chevron-right"></i></a>
          </div>
        </div>
      </div> -->
      <div class="col-lg-12 d-flex align-items-stretch" data-aos="fade-right" data-aos-delay="150">
        <div class="icon-boxes d-flex flex-column justify-content-center">
          <div class="row">
            <div class="col-xl-4 d-flex align-items-stretch" data-aos="fade-right" data-aos-delay="200">
              <div class="icon-box mt-4 mt-xl-0">
                <i class="bx bx-cube-alt"></i>
                  <a href="event.php">
                    <h4>Events</h4>
                    <p>Join all our upcoming and live events worldwide.</p>
                  </a>
              </div>
            </div>
            <div class="col-xl-4 d-flex align-items-stretch" data-aos="fade-right" data-aos-delay="500">
              <div class="icon-box mt-4 mt-xl-0">
                <i class="bx bx-images"></i>
                  <a href="whatsnew.php">
                    <h4>What's New</h4>
                    <p>You would like to explore our new recipes</p>
                  </a>
                </div>
            </div>
            <div class="col-xl-4 d-flex align-items-stretch" data-aos="fade-right" data-aos-delay="800">
              <div class="icon-box mt-4 mt-xl-0">
                <i class="bx bx-receipt"></i>
                  <a href="#">
                    <h4>Still have questions?</h4>
                    <p>See Our FAQ Section for more information.</p>
                  </a>
                </div>
            </div>
          </div>
        </div><!-- End .content-->
      </div>
    </div>

  </div>
</section><!-- End Why Us Section -->

</main><!-- Main Section Ends -->

<?php

include("footer.php");

?>