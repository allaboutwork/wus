<?php

// user/staff.php

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

if($object->is_staff_user())
{
    header("location:".$object->base_url."user/index.php");
}

if($object->is_teacher_user())
{
    header("location:".$object->base_url."teacher/index.php");
}

if($object->is_student_user())
{
    header("location:".$object->base_url."student/index.php");
}

include('header.php');
                
?>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800 d-flex justify-content-center">Staff Section</h1>

                    <!-- DataTables Example -->
                    <span id="message"></span>

                    <!-- Card Starts -->
                    <div class="card shadow mb-4">

                        <!-- Card Header Starts -->
                        <div class="card-header py-3">
                        	<div class="row">
                            	<div class="col">
                            		<h6 class="m-0 font-weight-bold text-primary">Staff List</h6>
                            	</div>
                            	<div class="col" align="right">
                            		<button type="button" name="add_user" id="add_user" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                            	</div>
                            </div>
                        </div>
                        <!-- Card Header Ends -->

                        <!-- Card Body Starts -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="user_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <!-- <th>Image</th> -->
                                            <th>User Name</th>
                                            <th>User Contact No.</th>
                                            <th>User Email</th>
                                            <th>User Password</th>
                                            <th>Status</th>          
                                            <th>Created By</th>
                                            <th>Updated By</th>
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
                    <!-- Card Ends -->

                <?php
                include('footer.php');
                ?>

<div id="userModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="user_form">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add Data</h4>
          			<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
                    <div class="form-group">
                            <label>User Name <span class="text-danger">*</span></label>        
                            <input type="text" name="user_name" id="user_name" class="form-control" required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                    </div>
                    <div class="form-group">
                            <label>User Contact No. <span class="text-danger">*</span></label>
                            <input type="text" name="user_contact_no" id="user_contact_no" class="form-control" required data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup" />
                    </div>
                    <div class="form-group">
                            <label >User Email <span class="text-danger">*</span></label>
                            <input type="text" name="user_email" id="user_email" class="form-control" required data-parsley-type="email" data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                    </div>

                    <div class="form-group">
                            <label >User Password <span class="text-danger">*</span></label>
                            <input type="password" name="user_password" id="user_password" class="form-control" required data-parsley-minlength="6" data-parsley-maxlength="16" data-parsley-trigger="keyup" />
                    </div>
                    
                    <!-- <div class="form-group">
                            <label class="col-md-4 text-right">User Password <span class="text-danger">*</span></label>
                            <input type="password" name="user_password" id="user_password" class="form-control" required data-parsley-minlength="6" data-parsley-maxlength="16" data-parsley-trigger="keyup" />
                    </div> -->
                </div>
                    
                    <!-- <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">User Profile</label>
                            <div class="col-md-8">
                                <input type="file" name="user_image" id="user_image" />
                                <span id="user_uploaded_image"></span>
                            </div>
                        </div>
                    </div>
        		</div> -->
        		<div class="modal-footer">
          			<input type="hidden" name="hidden_id" id="hidden_id" />
          			<input type="hidden" name="action" id="action" value="Add" />
          			<input type="submit" name="submit" id="submit_button" class="btn btn-primary" value="Add" />
          			<button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>

<script>
// Document Ready Method Starts
$(document).ready(
    
    function(){

    // Variable dataTable Starts
	var dataTable = $('#user_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"staff_action.php",
			type:"POST",
			data:{action:'fetch_staff'}
		},
		"columnDefs":[
			{
				"targets":[1, 2, 3, 4, 7, 8],
				"orderable":false,
			},
		],
	});
    // Variable dataTable Ends

    // Click event for element with id="add_user" starts  
	$('#add_user').click(
    
        function(){
		
        // Reset the element with id="user_form"
		$('#user_form')[0].reset();

        // Reset the element with id="user_form"
		$('#user_form').parsley().reset();

        // Add text to modal with id="modal_title"
    	$('#modal_title').text('Add Staff User');

        // Make value="Add" to element with id="action"
    	$('#action').val('Add');

    	$('#submit_button').val('Add');

    	$('#userModal').modal('show');

    	$('#form_message').html('');

        // $('#user_uploaded_image').html('');
        
        }
    );
    // Click event for element with id="add_user" Ends  

    // Change User Image Starts for element with id="user_image"
    // $('#user_image').change(
        
    //     function(){

    //     // 1. Variable
    //     // store the extension of uploaded image in extention variable
    //     var extension = $('#user_image').val().split('.').pop().toLowerCase();

    //     // 1. Functionality
    //     // check the validity of extension of uploaded image.
    //     if(extension != '')
    //     {
    //         if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
    //         {
    //             alert("Invalid Image File");
    //             $('#user_image').val('');
    //             return false;
    //         }
    //     }

    //     // 2. Functionality
    //     // Afshan please Add functionality to check the uploaded image size and
    //     // alert the user if size is too big.
        
    //     } 
    // );
    // Change User Image Ends for element with id="user_image"


	$('#user_form').parsley();

	$('#user_form').on('submit', function(event){
		event.preventDefault();
		if($('#user_form').parsley().isValid())
		{		
			$.ajax({
                // Will send the uploaded data to staff_action.php
				url:"staff_action.php",
				method:"POST",
				data:new FormData(this),
				dataType:'json',
                contentType:false,
                processData:false,
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
						$('#userModal').modal('hide');
						$('#message').html(data.success);
						dataTable.ajax.reload();

						setTimeout(function(){

				            $('#message').html('');

				        }, 5000);
					}
				}
			})
		}
	});

	$(document).on('click', '.edit_button', function(){

		var user_id = $(this).data('id');

		$('#user_form').parsley().reset();

		$('#form_message').html('');

		$.ajax({

	      	url:"staff_action.php",

	      	method:"POST",

	      	data:{user_id:user_id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{

	        	$('#user_name').val(data.user_name);
                $('#user_email').val(data.user_email);
                $('#user_contact_no').val(data.user_contact_no);
                $('#user_password').val(data.user_password);

                // $('#user_uploaded_image').html('<img src="'+data.user_profile+'" class="img-fluid img-thumbnail" width="75" height="75" /><input type="hidden" name="hidden_user_image" value="'+data.user_profile+'" />');

	        	$('#modal_title').text('Edit Data');

	        	$('#action').val('Edit');

	        	$('#submit_button').val('Edit');

	        	$('#userModal').modal('show');

	        	$('#hidden_id').val(user_id);

	      	}

	    })

	});

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

        		url:"staff_action.php",

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

            url:"staff_action.php",

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
// Document Ready Method Ends
</script>