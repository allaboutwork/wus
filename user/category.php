<?php

// user/category.php

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
                    <h1 class="mt-2 h3 mb-4 text-gray-800 d-flex justify-content-center">Category Section</h1>

                    <!-- DataTables Example -->
                    <span id="message"></span>

					<!-- Card Header Starts -->
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<div class="row">
								<div class="col">
									<h6 class="m-0 font-weight-bold text-primary">Category List</h6>
								</div>
								<div class="col" align="right">
									<button type="button" name="add_category" id="add_category" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-plus"></i></button>
								</div>
							</div>
						</div>
					<!-- Card Header Ends -->

					<!-- Card Body Starts -->
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered" id="category_table" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>Category Name</th>
										<th>Description</th>
										<th>Status</th>
										<!-- <th>Created On</th> -->
										<th>Created By</th>
										<!-- <th>Updated On</th> -->
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

                <?php
                include('footer.php');
                ?>

<!-- Modal To Add Category Starts -->
<div id="categoryModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="category_form">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add Category</h4>
          			<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
		          	<div class="form-group">
		          		<label>Category Name <span class="text-danger">*</span></label>
		          		<input type="text" name="category_name" id="category_name" class="form-control" required data-parsley-pattern="/^[a-zA-Z0-9 \s]+$/" data-parsley-trigger="keyup" />
		          	</div>
		          	<div class="form-group">
		          		<label>Category Description </label>
		          		<input type="text" name="category_description" id="category_description" class="form-control" data-parsley-pattern="/^[a-zA-Z0-9 \s]+$/" data-parsley-trigger="keyup" />
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
</div>	<!-- Modal To Add Category Ends -->


<script>
// Start of Main Script

// Working = 1, 2, 3, 4, 5 

// Not Working = 

$(document).ready(function(){

// 1. Connect datatable Starts
	var dataTable = $('#category_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"category_action.php",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
				"targets":[1, 5, 6],
				"orderable":false,
			},
		],
	}); // 1. Connect datatable Ends

// 2. Add Category Starts
	// On click of add button
	$('#add_category').click(function(){
		// reset the form in modal
		$('#category_form')[0].reset();
		// reset the parsley validation
		$('#category_form').parsley().reset();
		// add title to modal 
    	$('#modal_title').text('Add Category');
		
    	$('#action').val('Add');

    	$('#submit_button').val('Add');

    	$('#categoryModal').modal('show');

    	$('#form_message').html('');

	});

	$('#category_form').parsley();

	$('#category_form').on('submit', function(event){
		event.preventDefault();
		if($('#category_form').parsley().isValid())
		{		
			$.ajax({
				url:"category_action.php",
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
						$('#categoryModal').modal('hide');

						$('#message').html(data.success);
						dataTable.ajax.reload();

						setTimeout(function(){

				            $('#message').html('');

				        }, 5000);
					}
				}
			})
		}
	});	// 2. Add Category Ends
	
// 3. Edit Button Starts
	$(document).on('click', '.edit_button', function(){

	var category_id = $(this).data('id');

	$('#category_form').parsley().reset();
	
	$('#form_message').html('');

	$.ajax({

		url:"category_action.php",
		
		method:"POST",
		
		data:{category_id:category_id, action:'fetch_single'},
		
		dataType:'JSON',

		success:function(data)
		{
			$('#category_name').val(data.category_name);

			$('#category_description').val(data.category_description);

			$('#modal_title').text('Edit Category');
			
			$('#action').val('Edit');
			
			$('#submit_button').val('Edit');
			
			$('#categoryModal').modal('show');
			
			$('#hidden_id').val(category_id);
		}

	})

	}); // 3. Edit Button Ends

// 4. Status Button Starts
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

        		url:"category_action.php",

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
	}); // 4. Status Button Ends

// 5. Delete Button Starts
	$(document).on('click', '.delete_button', function(){

    	var id = $(this).data('id');

    	if(confirm("Are you sure you want to remove it?"))
    	{

      		$.ajax({

        		url:"category_action.php",

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

  	}); // 5. Delete Button Ends
});

// End of Main Script
</script>