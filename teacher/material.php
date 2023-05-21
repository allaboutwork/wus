<?php

// teacher/material.php

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
// SELECT * FROM material_wus 
// WHERE material_status = 'Enable' 
// ORDER BY material_name ASC
// ";

// $new_result = $new_object->get_result();

include('header.php');

?>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800 d-flex justify-content-center">Material Section</h1>

                    <!-- DataTales Example -->
                    <span id="message"></span>

					<!-- Card Header Starts -->
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<div class="row">
								<div class="col">
									<h6 class="m-0 font-weight-bold text-primary">Material List</h6>
								</div>
								<?php
								if($object->is_teacher_user())
								{
								?>
								<div class="col" align="right">
									<button type="button" name="add_material" id="add_material" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-plus"></i></button>
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
							<table class="table table-bordered" id="material_table" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>Material Name</th>
										<th>Course Name</th>
										<th>Module Name</th>
										<th>Material Position</th>
										<th>Description</th>									
										<th>Status</th>
										<th>Type</th>
										<th>Material Data</th>
										<th>Created By</th>
										<th>Edit</th>
										<th>Delete</th>

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

<!-- Modal To Add material Starts -->
<div id="materialModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="material_form">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add Material</h4>
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
                        <select name="module_id" id="module_id" class="form-control" required>
                            <option value="">Select Module</option>
                        </select>
                    </div>
		          	<div class="form-group">
		          		<label>Material Name</label>
		          		<input type="text" name="material_name" id="material_name" class="form-control" data-parsley-pattern="/^[a-zA-Z0-9 \s]+$/" data-parsley-trigger="keyup" />
		          	</div>
		          	<div class="form-group">
		          		<label>Material Description</label>
		          		<input type="text" name="material_description" id="material_description" class="form-control" data-parsley-pattern="/^[a-zA-Z0-9 \s]+$/" data-parsley-trigger="keyup" />
		          	</div>
		          	<div class="form-group">
		          		<label>Material Position</label>
		          		<input type="text" name="material_position" id="material_position" class="form-control" required data-parsley-pattern="/^[0-9 \s]+$/" data-parsley-trigger="keyup" />
		          	</div>
		          	<!-- <div class="form-group">
		          		<label>Material Source</label>
		          		<input type="text" name="material_source" id="material_source" class="form-control" data-parsley-pattern="/^[a-zA-Z0-9 \s]+$/" data-parsley-trigger="keyup" />
		          	</div> -->
					<div class="form-group">
                        <label>Material Type</label>
                        <select name="material_type" id="material_type" class="form-control" required>
                            <option value="material_duration">Select Type</option>
                            <option value="Text">Text</option>
                            <!-- <option value="Audio">Audio</option>
                            <option value="Video">Video</option> -->
                        </select>
                    </div>
					<div class="form-group">
		          		<label>Material Data</label>
		          		<input type="text" name="material_data" id="material_data" class="form-control" required/>
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
  	</div>
</div>	<!-- Modal To Add material Ends -->

<!-- Modal To Add material Data Starts -->
<!-- <div id="newMaterialModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="material_form">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add Material</h4>
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
                        <label>Module Name</label>
                        <select name="module_id" id="module_id" class="form-control" required>
                            <option value="">Select Module</option>
                        </select>
                    </div>
		          	<div class="form-group">
		          		<label>Material Name</label>
		          		<input type="text" name="material_name" id="material_name" class="form-control" data-parsley-pattern="/^[a-zA-Z0-9 \s]+$/" data-parsley-trigger="keyup" />
		          	</div>
		          	<div class="form-group">
		          		<label>Material Description</label>
		          		<input type="text" name="material_description" id="material_description" class="form-control" data-parsley-pattern="/^[a-zA-Z0-9 \s]+$/" data-parsley-trigger="keyup" />
		          	</div>
		          	<div class="form-group">
		          		<label>Material Position</label>
		          		<input type="text" name="material_position" id="material_position" class="form-control" required data-parsley-pattern="/^[0-9 \s]+$/" data-parsley-trigger="keyup" />
		          	</div>
					<div class="form-group">
                        <label>Material Type</label>
                        <select name="material_type" id="material_type" class="form-control" required>
                            <option value="material_duration">Select Type</option>
                            <option value="Text">Text</option>
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
  	</div>
</div>	 -->
<!-- Modal To Add material  Data Ends -->


<script>
// Start of Main Script

$(document).ready(function(){

	<?php
		if($object->is_teacher_user())
		{
	?>
// Connect DataTable Starts
	var dataTable = $('#material_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"material_action.php",
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

// Add material Starts
	$('#add_material').click(function(){
		
		$('#material_form')[0].reset();

		$('#material_form').parsley().reset();

    	$('#modal_title').text('Add material');

    	$('#action').val('Add');

    	$('#submit_button').val('Add');

    	$('#materialModal').modal('show');

    	$('#form_message').html('');

	});	// Add material Ends

    $(document).on('change', '#course_id', function(){
        var course_id = $('#course_id').val();
        var action = 'fetch_details';
        $.ajax({
            url:"material_action.php",
            method:"POST",
            data:{course_id:course_id, action:action},
            dataType:"JSON",
            success:function(data)
            {

                if(data.module_data.length > 0)
                {
					var module_html = '<option value="">Select Module</option>';
                    for(var i = 0; i < data.module_data.length; i++)
                    {
						module_html += '<option value="'+data.module_data[i].module_id+'">'+data.module_data[i].module_name+'</option>';
                    }
                    $('#module_id').html(module_html);
                }
			
				data.module_html.reset();
            }
        });
    });

// Parsley validation Starts
	$('#material_form').parsley(); // Parsley validation Ends

// Submit Event Starts
	$('#material_form').on('submit', function(event){
		event.preventDefault();
		if($('#material_form').parsley().isValid())
		{		
			$.ajax({
				url:"material_action.php",
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
						$('#materialModal').modal('hide');
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

		// $('#material_form')[0].reset();

		var material_id = $(this).data('id');

		$('#material_form').parsley().reset();

		$('#form_message').html('');

		$.ajax({

	      	url:"material_action.php",

	      	method:"POST",

	      	data:{material_id:material_id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{

				if(data.module_data.length > 0)
                {
					var module_html = '<option value="">Select Module</option>';
                    for(var i = 0; i < data.module_data.length; i++)
                    {
						module_html += '<option value="'+data.module_data[i].module_id+'">'+data.module_data[i].module_name+'</option>';
                    }
                    $('#module_id').html(module_html);
                }
			
				// data.module_html.reset();

	        	$('#course_id').val(data.course_id);
	        	$('#module_id').val(data.module_id);
	        	$('#material_name').val(data.material_name);
	        	$('#material_description').val(data.material_description);
	        	$('#material_position').val(data.material_position);
	        	$('#material_type').val(data.material_type);
	        	$('#material_data').val(data.material_data);

	        	$('#modal_title').text('Edit Material');

	        	$('#action').val('Edit');

	        	$('#submit_button').val('Edit');

	        	$('#materialModal').modal('show');

	        	$('#hidden_id').val(material_id);

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

        		url:"material_action.php",

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

        		url:"material_action.php",

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