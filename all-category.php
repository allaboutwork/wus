<?php

include("./user/wus.php");

$object = new wus();

$object->query = "
SELECT * FROM category_wus
";

$result = $object->get_result();

// $category_id = '';
$category_name = '';

// foreach($result as $row)
// {
//     $category_name = $object->Get_category_name($row['category_id']);
//     // $sub_category_name = $object->Get_sub_category_name($row['sub_category_id']);
//     $category_description = $row['category_description'];
// }


include('header.php')

?>

<h1 class="d-flex align-item-center justify-content-center mt-5">Welcome to All Category Page</h1>

    <!-- ======= Cource Details Section ======= -->
    <section id="course-details" class="course-details">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-3">
            <!-- <img src="assets/image/hero-bg-4.jpg" class="img-fluid" alt=""> -->
          </div>
          <div class="col-lg-6">  
             <?php
             $object->query = "
             SELECT * FROM category_wus
             ";
             
             $result = $object->get_result();
             
             // $category_id = '';
             $category_name = '';

            foreach($result as $row)
            {
                $category_name = $object->Get_category_name($row['category_id']);
                $category_description = $row['category_description'];
             ?>             
            <div class="course-info d-flex justify-content-between align-items-center">
            <h5>Category Name</h5>
            <p><?php echo"$category_name";?></p>
            </div>
            <div class="course-info d-flex justify-content-between align-items-center">
                <h5>Category Description</h5>
                <p><?php echo"$category_description";?></p>
            </div>
            <br>
            <br>
            <?php
                }
            ?>
             <div class="col-lg-3"></div>

          </div>
        </div>

      </div>
    </section>


<?php

include('footer.php')

?>