<?php

// student/enrollment.php

include('wus.php');

$object = new wus();


if(!$object->is_login())
{
    header("location:".$object->base_url."user");
}

if($object->is_master_user())
{
    header("location:".$object->base_url."user/index.php");
}

if($object->is_staff_user())
{
    header("location:".$object->base_url."user/index.php");
}

if($object->is_teacher_user())
{
    header("location:".$object->base_url."teacher/index.php");
}

// if($object->is_student_user())
// {
//     header("location:".$object->base_url."student/index.php");
// }

// $object->query = "
// SELECT * FROM course_wus
// WHERE course_status = 'Enable' 
// ORDER BY course_name ASC
// ";

// $result = $object->get_result();

include('header.php');

?>

                    <!-- Page Heading -->
                    <h1 class="mt-2 h3 mb-4 text-gray-800 d-flex justify-content-center">Courses in Progress</h1>

                    <!-- DataTables Example -->
                    <span id="message"></span>

					<!-- Card Header Starts -->
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<div class="row">
								<div class="col">
									<h6 class="m-0 font-weight-bold text-primary">Course List</h6>
								</div>
							</div>
						</div>
					<!-- Card Header Ends -->

					<!-- Card Body Starts -->
					<div class="card-body">
						<div class="table-responsive align-item-center ">
							<table class="table table-bordered text-center" id="enrollment_table" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>Course Name</th>
										<th>Progress</th>
										<th>Continue</th>
										<th>Unenroll</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
					</div>
					<!-- Card Body Ends -->
				</div>

                <?php
                include('footer.php');
                ?>

<!-- Modal To Add Enrollment Starts -->
<!-- <div id="enrollmentModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="enrollment_form">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add Enrollment</h4>
          			<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
					<div class="form-group">
                        <label>Course</label>
                        <select name="course_id" id="course_id" class="form-control" required>
                            <option value="">Select Course</option>
                            <?php
                            // foreach($result as $row)
                            // {
                            //     echo '
                            //     <option value="'.$row["course_id"].'">'.$row["course_name"].'</option>
                            //     ';
                            // }
                            ?>
                        </select>
		          	</div>
					<div class="form-group">
                        <label>User</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">Select User</option>
                            <?php

							// $object->query = "
							// SELECT * FROM user_wus
							// WHERE user_status = 'Enable'
							// AND  user_type = 'Student'
							// ORDER BY user_name ASC
							// ";

							// $new_result = $object->get_result();


                            // foreach($new_result as $row)
                            // {
                            //     echo '
                            //     <option value="'.$row["user_id"].'">'.$row["user_name"].'</option>
                            //     ';
                            // }
                            ?>
                        </select>
		          	</div>
        		</div>
        		<div class="modal-footer">
          			<input type="hidden" name="hidden_id" id="hidden_id" />
          			<input type="hidden" name="action" id="action" value="Add" />
          			<input type="submit" name="submit" id="submit_button" class="btn btn-primary" value="Add" />
          			<button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div> -->
</div>	<!-- Modal To Add Enrollment Ends -->


<script>
// Start of Main Script

$(document).ready(function(){

	<?php
	if($object->is_student_user())
	{
	?>
// 1. Connect Datatable Starts
	var dataTable = $('#enrollment_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"enrollment_action.php",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
				"targets":[2, 3],
				"orderable":false,
			},
		],
	});	// 1. Connect Datatable Starts

	<?php
	}
	?>

// Status Button Starts
	$(document).on('click', '.status_button', function(){
		var id = $(this).data('id');
    	var status = $(this).data('status');
		var next_status = 'Enable';
		if(status == 'Enable')
		{
			next_status = 'Disable';
		}
		if(confirm("Are you sure you want to "+next_status+" it?"))
    	{

      		$.ajax({

        		url:"enrollment_action.php",

        		method:"POST",

        		data:{id:id, action:'change_status', status:status, next_status:next_status},

        		success:function(data)
        		{

          			$('#message').html(data);

          			dataTable.ajax.reload();

          			setTimeout(function(){

            			$('#message').html('');

          			}, 5000);

        		}

      		})

    	}
	});

// Delete Button Starts
	$(document).on('click', '.delete_button', function(){

    	var id = $(this).data('id');

    	if(confirm("Are you sure you want to remove it?"))
    	{

      		$.ajax({

        		url:"enrollment_action.php",

        		method:"POST",

        		data:{id:id, action:'delete'},

        		success:function(data)
        		{

          			$('#message').html(data);

          			dataTable.ajax.reload();

          			setTimeout(function(){

            			$('#message').html('');

          			}, 5000);

        		}

      		})

    	}

  	});	// Delete Button Ends

});

// End of Main Script
</script>