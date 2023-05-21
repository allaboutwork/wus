<?php

// user/certification_action.php

include('wus.php');

$object = new wus();

// List of Actions for certification Starts
if(isset($_POST["action"]))
{
//	1.	Action Fetch Starts
	if($_POST["action"] == 'fetch')
	{
		$order_column = array(
							'certificate_wus.certification_id', 
							'certificate_wus.enrollment_id', 
							'certificate_wus.certificate_name',
							'certificate_wus.certificate_description', 
							'certificate_wus.certification_issued',
							'progress_wus.progress_id',
							'progress_wus.progress_value',
							'enrollment_wus.course_id',
							'enrollment_wus.user_id', 
							'enrollment_wus.enrollment_status'
						);

		$output = array();

		$main_query = "
		SELECT * FROM ((certificate_wus 
		INNER JOIN progress_wus ON certificate_wus.enrollment_id = progress_wus.enrollment_id)
		INNER JOIN enrollment_wus ON certificate_wus.enrollment_id = enrollment_wus.enrollment_id)
		";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE certificate_wus.certificate_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR certificate_wus.enrollment_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR certificate_wus.certificate_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR certificate_wus.certificate_description LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR certificate_wus.certificate_issued LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR progress_wus.progress_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR progress_wus.progress_value LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR enrollment_wus.course_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR enrollment_wus.user_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR enrollment_wus.enrollment_status LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY certificate_id DESC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		// Add main query, 
		$object->query = $main_query . $search_query . $order_query;
		$object->execute();
		$filtered_rows = $object->row_count();
		$object->query .= $limit_query;
		$result = $object->get_result();
		$object->query = $main_query;
		$object->execute();
		$total_rows = $object->row_count();
		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();
			// $sub_array[] = $row["certification_id"];
			$sub_array[] = $object->Get_certificate_name($row["certificate_id"]);
			$sub_array[] = html_entity_decode($row["certificate_description"]);
			$sub_array[] = $object->Get_course_name($row["course_id"]);
			$sub_array[] = $object->Get_user_name($row["user_id"]);
			$sub_array[] = html_entity_decode($row["progress_value"] . "%");
			// $sub_array[] = html_entity_decode($row["certificate_issued"]);

			$status = '';
			if($row["certificate_issued"] == 'Yes')
			{
				$status = '<button type="button" name="status_button" class="btn btn-primary btn-sm status_button" data-id="'.$row["enrollment_id"].'" data-status="'.$row["certificate_issued"].'">Yes </button>';
			}
			else
			{
				$status = '<button type="button" name="status_button" class="btn btn-danger btn-sm status_button" data-id="'.$row["enrollment_id"].'" data-status="'.$row["certificate_issued"].'">No</button>';
			}
			$sub_array[] = $status;

			// $sub_array[] = '
			// <div align="center">
			// <button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$row["certificate_id"].'"><i class="fas fa-edit"></i></button>
			// </div>
			// ';
			// $sub_array[] = '
			// <div align="center">
			// <button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["certificate_id"].'"><i class="fas fa-times"></i></button>
			// </div>
			// ';
			$data[] = $sub_array;
		}

		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
			
		echo json_encode($output);

	}	// 1.	Action Fetch Ends

//	2.	Action Add Starts
	if($_POST["action"] == 'Add')
	{
		$error = '';
		$success = '';

		$data = array(
			':course_id'	=>	$_POST["course_id"],
			':user_id'		=>	$_POST["user_id"]
		);

		$object->query = "
		SELECT * FROM certification_wus
		WHERE course_id = :course_id
		AND user_id = :user_id
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">certification Already Exists</div>';
		}
		else
		{
			$data = array(
				':course_id'			=>	$object->clean_input($_POST["course_id"]),
				':user_id'				=>	$object->clean_input($_POST["user_id"]),
				':certification_status'	=>	'Enable'
			);

			$object->query = "
			INSERT INTO certification_wus 
			(course_id, user_id, certification_status) 
			VALUES (:course_id, :user_id, :certification_status)
			";

			$object->execute($data);

			$success = '<div class="alert alert-success">certification Added</div>';
		}

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}	// Action Add Ends

//	3.	Action fetch_single Starts
	if($_POST["action"] == 'fetch_single')
	{
		$object->query = "
		SELECT * FROM certification_wus 
		WHERE certification_id = '".$_POST["certification_id"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['course_id'] 	= $row['course_id'];
			$data['user_id'] 	= $row['user_id'];
		}

		echo json_encode($data);
	}	// Action fetch_single Ends

//	4.	Action Edit Starts
	if($_POST["action"] == 'Edit')
	{
		$error = '';

		$success = '';

		$data = array(
			':course_id'	=>	$_POST["course_id"],
			':user_id'		=>	$_POST["user_id"]
		);

		$object->query = "
		SELECT * FROM certification_wus
		WHERE course_id = :course_id
		AND user_id = :user_id
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">certification Already Exists</div>';
		}
		else
		{

			$data = array(
				':course_id'			=>	$object->clean_input($_POST["course_id"]),
				':user_id'				=>	$object->clean_input($_POST["user_id"]),
			);

			$object->query = "
			UPDATE certification_wus 
			SET course_id = :course_id,
			user_id = :user_id
			WHERE certification_id = '".$_POST['hidden_id']."'
			";

			$object->execute($data);

			$success = '<div class="alert alert-success">certification Data Updated</div>';
		}

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success,
		);

		echo json_encode($output);

	}	// Action Edit Ends


//	5.	Action change_status starts
	if($_POST["action"] == 'change_status')
	{
		$data = array(
			':certificate_issued'		=>	$_POST['next_status']
		);

		$object->query = "
		UPDATE certificate_wus 
		SET certificate_issued = :certificate_issued 
		WHERE certificate_id = '".$_POST["id"]."'
		";

		$object->execute($data);

		echo '<div class="alert alert-success"> '.$_POST['next_status'].' is set for certificate issued status.<b><b></div>';
	}	// Action action_status starts


//	6.	Action delete starts
	if($_POST["action"] == 'delete')
	{
		$object->query = "
		DELETE FROM certification_wus 
		WHERE certification_id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">certification Data Deleted</div>';
	}	// Action delete ends
}	// List of Actions for Category Ends

?>