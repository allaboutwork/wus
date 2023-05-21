<?php

// teacher/module.php

include('wus.php');

$object = new wus();
// $new_object = new wus();


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

// if($object->is_teacher_user())
// {
//     header("location:".$object->base_url."teacher/index.php");
// }

if($object->is_student_user())
{
    header("location:".$object->base_url."student/index.php");
}

$object->query = "
SELECT * FROM course_wus
WHERE course_status = 'Enable'
AND course_added_by = '".$_SESSION['user_id']."'
ORDER BY course_name ASC;
";

$result = $object->get_result();

// $new_object->query = "
// SELECT * FROM module_wus 
// WHERE module_status = 'Enable' 
// ORDER BY module_name ASC
// ";

// $new_result = $new_object->get_result();

include('header.php');

?>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800 d-flex justify-content-center">Module Section</h1>

                    <!-- DataTales Example -->
                    <span id="message"></span>

					<!-- Card Header Starts -->
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<div class="row">
								<div class="col">
									<h6 class="m-0 font-weight-bold text-primary">Module List</h6>
								</div>
								<?php
								if($object->is_teacher_user())
								{
								?>
								<div class="col" align="right">
									<button type="button" name="add_module" id="add_module" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-plus"></i></button>
								</div>
								<?php 
								}			
								?>
							</div>
						</div>
					<!-- Card Header Ends -->

					<!-- Card Body Starts -->
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered" id="module_table" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>Module Name</th>
										<th>Course Name</th>
										<th>Description</th>
										<!-- <th>Duration</th>
										<th>Level</th> -->
										
										<?php
											if($object->is_teacher_user())
											{
										?>
										<th>Status</th>
										<!-- <th>Created On</th> -->
										<th>Created By</th>
										<!-- <th>Updated On</th> -->
										<!-- <th>Updated By</th> -->
										<th>Edit</th>
										<th>Delete</th>

										<?php
											}
										?>
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

<!-- Modal To Add Module Starts -->
<div id="moduleModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="module_form">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add Module</h4>
          			<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
					<div class="form-group">
                        <label>Course</label>
                        <select name="course_id" id="course_id" class="form-control" required>
                            <option value="">Select Course</option>
                            <?php
                            foreach($result as $row)
                            {

                                echo '
                                <option value="'.$row["course_id"].'">'.$row["course_name"].'</option>
                                ';
                            }
                            ?>
                        </select>
		          	</div>
		          	<div class="form-group">
		          		<label>Module Name</label>
		          		<input type="text" name="module_name" id="module_name" class="form-control" required data-parsley-pattern="/^[a-zA-Z0-9 \s]+$/" data-parsley-trigger="keyup" />
		          	</div>
		          	<div class="form-group">
		          		<label>Module Description</label>
		          		<input type="text" name="module_description" id="module_description" class="form-control" data-parsley-pattern="/^[a-zA-Z0-9 \s]+$/" data-parsley-trigger="keyup" />
		          	</div>
					<!-- <div class="form-group">
                        <label>Module Duration</label>
                        <select name="module_duration" id="module_duration" class="form-control" required>
                            <option value="module_duration">Select Duration</option>
                            <option value="1-3 hours">1 - 3 Hours</option>
                            <option value="4-6 hours">4 - 6 Hours</option>
                            <option value="9-12 hours">9 - 12 Hours</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Module Level</label>
                        <select name="module_level" id="module_level" class="form-control" required>
                            <option value="module_level">Select Level</option>
							<option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Expert">Expert</option>
                        </select>
                    </div> -->
        		</div>
        		<div class="modal-footer">
          			<input type="hidden" name="hidden_id" id="hidden_id" />
          			<input type="hidden" name="action" id="action" value="Add" />
          			<input type="submit" name="submit" id="submit_button" class="btn btn-primary" value="Add" />
          			<button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>	<!-- Modal To Add Module Ends -->


<script>
// Start of Main Script

$(document).ready(function(){

	<?php
		if($object->is_teacher_user())
		{
	?>
// Connect DataTable Starts
	var dataTable = $('#module_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"module_action.php",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
				// "targets":[2, 8, 9],
				"orderable":true,
			},
		],
	}); // Connect DataTable Ends


		<?php
		}
		?>

// Add Module Starts
	$('#add_module').click(function(){
		
		$('#module_form')[0].reset();

		$('#module_form').parsley().reset();

    	$('#modal_title').text('Add module');

    	$('#action').val('Add');

    	$('#submit_button').val('Add');

    	$('#moduleModal').modal('show');

    	$('#form_message').html('');

	});	// Add Module Ends

// Parsley validation Starts
	$('#module_form').parsley(); // Parsley validation Ends

// Submit Event Starts
	$('#module_form').on('submit', function(event){
		event.preventDefault();
		if($('#module_form').parsley().isValid())
		{		
			$.ajax({
				url:"module_action.php",
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
					}
					else
					{
						$('#moduleModal').modal('hide');
						$('#message').html(data.success);
						dataTable.ajax.reload();

						setTimeout(function(){

				            $('#message').html('');

				        }, 5000);
					}
				}
			})
		}
	}); // Submit Event Ends
	
// Edit Button Starts
	$(document).on('click', '.edit_button', function(){

		// $('#module_form')[0].reset();

		var module_id = $(this).data('id');

		$('#module_form').parsley().reset();

		$('#form_message').html('');

		$.ajax({

	      	url:"module_action.php",

	      	method:"POST",

	      	data:{module_id:module_id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{

	        	$('#course_id').val(data.course_id);
	        	$('#module_name').val(data.module_name);
	        	$('#module_description').val(data.module_description);
	        	$('#module_duration').val(data.module_duration);
	        	$('#module_level').val(data.module_level);

	        	$('#modal_title').text('Edit module');

	        	$('#action').val('Edit');

	        	$('#submit_button').val('Edit');

	        	$('#moduleModal').modal('show');

	        	$('#hidden_id').val(module_id);

	      	}

	    })

	}); // Edit Button Ends

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

        		url:"module_action.php",

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
	}); // Status Button Ends

// Delete Button Starts
	$(document).on('click', '.delete_button', function(){

    	var id = $(this).data('id');

    	if(confirm("Are you sure you want to remove it?"))
    	{

      		$.ajax({

        		url:"module_action.php",

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

  	}); // Delete Button Ends

});

// End of Main Script
</script>