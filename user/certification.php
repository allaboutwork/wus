<?php

// user/certification.php

include('wus.php');

$object = new wus();


if(!$object->is_login())
{
    header("location:".$object->base_url."user");
}

// if($object->is_master_user())
// {
//     header("location:".$object->base_url."user/index.php");
// }

// if($object->is_staff_user())
// {
//     header("location:".$object->base_url."user/index.php");
// }

if($object->is_teacher_user())
{
    header("location:".$object->base_url."teacher/index.php");
}

if($object->is_student_user())
{
    header("location:".$object->base_url."student/index.php");
}

$object->query = "
SELECT * FROM course_wus
WHERE course_status = 'Enable' 
ORDER BY course_name ASC
";

$result = $object->get_result();

include('header.php');

?>

                    <!-- Page Heading -->
                    <h1 class="mt-2 h3 mb-4 text-gray-800 d-flex justify-content-center">Certification Section</h1>

                    <!-- DataTables Example -->
                    <span id="message"></span>

					<!-- Card Header Starts -->
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<div class="row">
								<div class="col">
									<h6 class="m-0 font-weight-bold text-primary">Certification List</h6>
								</div>
								<!-- <div class="col" align="right">
									<button type="button" name="add_certification" id="add_certification" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-plus"></i></button>
								</div> -->
							</div>
						</div>
					<!-- Card Header Ends -->

					<!-- Card Body Starts -->
					<div class="card-body">
						<div class="table-responsive align-item-center">
							<table class="table table-bordered" id="certification_table" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>Certificate Name</th>
										<th>Certificate Description</th>
										<th>Course Name</th>
										<th>Student Name</th>
										<th>Student Progress</th>
										<th>Certificate Isuued</th>
										<!-- <th>Edit</th>
										<th>Delete</th> -->
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

<!-- Modal To Add Certification Starts -->
<!-- <div id="certificationModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="certification_form">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add Certification</h4>
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
  	</div>
</div> -->
	<!-- Modal To Add Certification Ends -->


<script>
// Start of Main Script

$(document).ready(function(){

// 1. Connect Datatable Starts
	var dataTable = $('#certification_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"certification_action.php",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
				"targets":['_all'],
				"orderable":true,
			},
		],
	});	// 1. Connect Datatable Starts

// 2. Add Certification Starts
	// // On click of add button
	// $('#add_certification').click(function(){
	// 	// reset the form in modal
	// 	$('#certification_form')[0].reset();
	// 	// reset the parsley validation
	// 	$('#certification_form').parsley().reset();
	// 	// add title to modal 
    // 	$('#modal_title').text('Add certification');
		
    // 	$('#action').val('Add');

    // 	$('#submit_button').val('Add');

    // 	$('#certificationModal').modal('show');

    // 	$('#form_message').html('');

	// });

	// $('#certification_form').parsley();

	// $('#certification_form').on('submit', function(event){
		
	// 	event.preventDefault();
	// 	if($('#certification_form').parsley().isValid())
	// 	{		
	// 		$.ajax({
	// 			url:"certification_action.php",
	// 			method:"POST",
	// 			data:$(this).serialize(),
	// 			dataType:'json',
	// 			beforeSend:function()
	// 			{
	// 				$('#submit_button').attr('disabled', 'disabled');
	// 				$('#submit_button').val('wait...');
	// 			},
	// 			success:function(data)
	// 			{
	// 				$('#submit_button').attr('disabled', false);
	// 				if(data.error != '')
	// 				{
	// 					$('#form_message').html(data.error);
	// 					$('#submit_button').val('Add');
	// 				}
	// 				else
	// 				{
	// 					$('#certificationModal').modal('hide');
	// 					$('#message').html(data.success);
	// 					dataTable.ajax.reload();

	// 					setTimeout(function(){

	// 			            $('#message').html('');

	// 			        }, 5000);
	// 				}
	// 			}
	// 		})
	// 	}
	// });	// 1. Add Certification Ends
	
// 3. Edit Button Starts
	// $(document).on('click', '.edit_button', function(){

	// var certification_id = $(this).data('id');

	// $('#certification_form').parsley().reset();
	// $('#form_message').html('');

	// $.ajax({

	// 	url:"certification_action.php",
	// 	method:"POST",
	// 	data:{certification_id:certification_id, action:'fetch_single'},
	// 	dataType:'JSON',

	// 	success:function(data)
	// 	{
	// 		$('#modal_title').text('Edit certification');
	// 		$('#course_id').val(data.course_id);
	// 		$('#user_id').val(data.user_id);
	// 		$('#action').val('Edit');
	// 		$('#submit_button').val('Edit');
	// 		$('#certificationModal').modal('show');
	// 		$('#hidden_id').val(certification_id);
	// 	}

	// })

	// });	// Edit Button Ends

// Status Button Starts
	$(document).on('click', '.status_button', function(){
		var id = $(this).data('id');
    	var status = $(this).data('status');
		var next_status = 'Yes';
		if(status == 'Yes')
		{
			next_status = 'No';
		}
		if(confirm("Are you sure you want to "+next_status+" it?"))
    	{

      		$.ajax({

        		url:"certification_action.php",

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
	// $(document).on('click', '.delete_button', function(){

    // 	var id = $(this).data('id');

    // 	if(confirm("Are you sure you want to remove it?"))
    // 	{

    //   		$.ajax({

    //     		url:"certification_action.php",

    //     		method:"POST",

    //     		data:{id:id, action:'delete'},

    //     		success:function(data)
    //     		{

    //       			$('#message').html(data);

    //       			dataTable.ajax.reload();

    //       			setTimeout(function(){

    //         			$('#message').html('');

    //       			}, 5000);

    //     		}

    //   		})

    // 	}

  	// });	// Delete Button Ends

});

// End of Main Script
</script>