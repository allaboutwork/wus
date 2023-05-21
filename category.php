<?php

include("./user/wus.php");

$object = new wus();

$object->query = "
SELECT * FROM sub_category_wus
INNER JOIN category_wus ON category_wus.category_id = sub_category_wus.category_id
WHERE sub_category_wus.category_id = '".$_GET['category_id']."'
";

$result = $object->get_result();

// $category_id = '';
$category_name = '';

foreach($result as $row)
{
    $category_name = $object->Get_category_name($row['category_id']);
    $sub_category_name = $object->Get_sub_category_name($row['sub_category_id']);
    $category_description = $row['category_description'];
}

include('header.php');

?>

<h1 class="d-flex align-item-center justify-content-center mt-5">Category : <?php echo" $category_name"; ?></h1>
<h3 class="d-flex align-item-center justify-content-center">Detail Page</h3>

    <!-- ======= Cource Details Section ======= -->
    <section id="course-details" class="course-details">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-5">
            <img src="assets/image/hero-bg-4.jpg" class="img-fluid" alt="">
          </div>
          <div class="col-lg-1"></div>
          <div class="col-lg-6">              
            <div class="course-info d-flex justify-content-between align-items-center">
            <h5>Category Name</h5>
            <p><?php echo"$category_name";?></p>
            </div>
            <div class="course-info d-flex justify-content-between align-items-center">
            <h5>Sub Category Name</h5>
            <p><?php echo"$sub_category_name";?></p>
            </div>
            <div class="course-info d-flex justify-content-between align-items-center">
                <h5>Category Description</h5>
                <p><?php echo"$category_description";?></p>
            </div>
            <!-- <div class="course-info d-flex justify-content-between align-items-center">
              <h5>Course Name</h5>
              <p><?php echo"$course_name";?></p>
            </div>
            <div class="course-info d-flex justify-content-between align-items-center">
                <h5>Trainer</h5>
                <p><?php echo"$course_added_by";?></p>
            </div>
            
            <div class="course-info d-flex justify-content-between align-items-center">
                <h5>Course Level</h5>
                <p><?php echo"$course_level";?></p>
            </div>
            <div class="course-info d-flex justify-content-between align-items-center">
              <h5>Course Description</h5>
              <p><?php echo"$course_description";?></p>
            </div>
            <div class="course-info d-flex justify-content-between align-items-center">
                <input type="hidden" name="hidden_id" id="hidden_id" />
                <input type="hidden" name="action" id="action" value="Add" />
                <input type="submit" name="submit" id="submit_button" class="btn btn-primary" value="Add" />
            </div> -->
          </div>
        </div>

      </div>
    </section>

<?php

include('footer.php');

?>