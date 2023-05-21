<?php

include("./user/wus.php");

$object = new wus();

$object->query = "
SELECT * FROM course_wus
INNER JOIN category_wus ON  category_wus.category_id = course_wus.category_id
WHERE course_id = '".$_GET['course_id']."'
";

$result = $object->get_result();

$course_name = '';
$category_name = '';

foreach($result as $row)
{
    $course_name = $object->Get_course_name($row['course_id']);
    $course_description = $row['course_description'];
    $course_duration = $row["course_duration"];
    $course_level = $row["course_level"];
    $course_added_by = $object->Get_user_name($row["course_added_by"]);
    $category_name = $object->Get_category_name($row['category_id']);
}

include('header.php');

?>

<h1 class="d-flex align-item-center justify-content-center mt-5">Course: <?php echo"$course_name";?></h1>
<h3 class="d-flex align-item-center justify-content-center">Detail Page</h3>

    <!-- ======= Breadcrumbs ======= -->
    <!-- <div class="breadcrumbs" data-aos="fade-in">
      <div class="container">
        <h2>Course Details</h2>
        <p>Est dolorum ut non facere possimus quibusdam eligendi voluptatem. Quia id aut similique quia voluptas sit quaerat debitis. Rerum omnis ipsam aperiam consequatur laboriosam nemo harum praesentium. </p>
      </div>
    </div> -->
    <!-- End Breadcrumbs -->

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
              <h5>Course Name</h5>
              <p><?php echo"$course_name";?></p>
            </div>

            <div class="course-info d-flex justify-content-between align-items-center">
              <h5>Category Name</h5>
              <p><?php echo"$category_name";?></p>
            </div>
            <div class="course-info d-flex justify-content-between align-items-center">
                <h5>Trainer</h5>
                <p><?php echo"$course_added_by";?></p>
            </div>
            
            <div class="course-info d-flex justify-content-between align-items-center">
                <h5>Course Duration</h5>
                <p><?php echo"$course_duration";?></p>
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
            </div>
          </div>
        </div>

      </div>
    </section>
    <!-- End Cource Details Section -->

<?php

include('footer.php')

?>

<script>
// Start of Main Script

$(document).ready(function(){

// 1. Add Enrollment Starts
	// On click of add button
	$('#action').click(function(){

    // Check if the user is login starts
    <?php
    if(!$object->is_login())
    {
      header("location:".$object->base_url."user");
    }
    ?>      // Check if the user is login starts

		// reset the form in modal
		$('#enrollment_form')[0].reset();
		// reset the parsley validation
		$('#enrollment_form').parsley().reset();
		// add title to modal 
    	$('#modal_title').text('Add Enrollment');
		
    	$('#action').val('Add');

    	$('#submit_button').val('Add');

    	// $('#enrollmentModal').modal('show');

    	$('#form_message').html('');

	});

	$('#enrollment_form').parsley();

	$('#enrollment_form').on('submit', function(event){
		
		event.preventDefault();
		if($('#enrollment_form').parsley().isValid())
		{		
			$.ajax({
				url:"enrollment_action.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:'json',
				beforeSend:function()
				{
					$('#submit_button').attr('disabled', 'disabled');
					$('#submit_button').val('wait...');
				},
				success:function(data)
				{
					$('#submit_button').attr('disabled', false);
					if(data.error != '')
					{
						$('#form_message').html(data.error);
						$('#submit_button').val('Add');

            setTimeout(function(){

            $('#message').html('');

            }, 5000);
					}
					else
					{
						// $('#enrollmentModal').modal('hide');
						$('#message').html(data.success);
						// dataTable.ajax.reload();

						setTimeout(function(){

				            $('#message').html('');

				        }, 5000);
					}
				}
			})
		}
	});	// 1. Add Enrollment Ends

});

// End of Main Script
</script>