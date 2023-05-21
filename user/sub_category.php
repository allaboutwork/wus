<?php

//sub_category.php

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


$object->query = "
SELECT * FROM category_wus 
WHERE category_status = 'Enable' 
ORDER BY category_name ASC
";

$result = $object->get_result();

include('header.php');

?>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800 d-flex justify-content-center">Sub Category Section</h1>

                    <!-- DataTables Example -->
                    <span id="message"></span>

					<!-- Card Header Starts -->
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<div class="row">
								<div class="col">
									<h6 class="m-0 font-weight-bold text-primary">Sub Category List</h6>
								</div>
								<div class="col" align="right">
									<button type="button" name="add_sub_category" id="add_sub_category" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-plus"></i></button>
								</div>
							</div>
						</div>
					<!-- Card Header Ends -->

					<!-- Card Body Starts -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="sub_category_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Sub Category Name</th>
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
                    </div>

                <?php
                include('footer.php');
                ?>

<!-- Add sub_category modal starts -->
<div id="subcategoryModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="sub_category_form">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add Sub Category</h4>
          			<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
					  <div class="form-group">
                        <label>Category</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php
                            foreach($result as $row)
                            {
                                echo '
                                <option value="'.$row["category_id"].'">'.$row["category_name"].'</option>
                                ';
                            }
                            ?>
                        </select>
		          	</div>
		          	<div class="form-group">
		          		<label>Sub Category Name</label>
		          		<input type="text" name="sub_category_name" id="sub_category_name" class="form-control" required data-parsley-pattern="/^[a-zA-Z0-9 \s]+$/" data-parsley-trigger="keyup" />
		          	</div>
		          	<div class="form-group">
		          		<label>Sub Category Description</label>
		          		<input type="text" name="sub_category_description" id="sub_category_description" class="form-control" data-parsley-pattern="/^[a-zA-Z0-9 \s]+$/" data-parsley-trigger="keyup" />
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
</div>	
<!-- Add sub_category modal ends -->



<script>
$(document).ready(function(){

// 1. Connect to Datatable
	var dataTable = $('#sub_category_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"sub_category_action.php",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
				"targets":[2, 4, 5, 6, 7],
				"orderable":false,
			},
		],
	}); // 1. Connect to Datatable

// 2. Add Category Starts
	// On click of add button
	$('#add_sub_category').click(function(){
		// reset the form in modal
		$('#sub_category_form')[0].reset();
		// reset the parsley validation
		$('#sub_category_form').parsley().reset();
		// add title to modal 
    	$('#modal_title').text('Add Sub Category');
		
    	$('#action').val('Add');

    	$('#submit_button').val('Add');

    	$('#subcategoryModal').modal('show');

    	$('#form_message').html('');

	});

	$('#sub_category_form').parsley();

	$('#sub_category_form').on('submit', function(event){
		event.preventDefault();
		if($('#sub_category_form').parsley().isValid())
		{		
			$.ajax({
				url:"sub_category_action.php",
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
						$('#subcategoryModal').modal('hide');

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

	var sub_category_id = $(this).data('id');

	$('#sub_category_form').parsley().reset();

	$('#form_message').html('');

	$.ajax({

		url:"sub_category_action.php",

		method:"POST",

		data:{sub_category_id:sub_category_id, action:'fetch_single'},

		dataType:'JSON',

		success:function(data)
		{

			$('#category_id').val(data.category_id);

			$('#sub_category_name').val(data.sub_category_name);

			$('#sub_category_description').val(data.sub_category_description);

			$('#modal_title').text('Edit Sub Category Data');

			$('#action').val('Edit');

			$('#submit_button').val('Edit');

			$('#subcategoryModal').modal('show');

			$('#hidden_id').val(sub_category_id);

		}

	})

	});
	// 3. Edit Button Ends


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

			url:"sub_category_action.php",

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

        		url:"sub_category_action.php",

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
</script>