<?php

// user/enrollment_action.php

include('wus.php');

$object = new wus();

// List of Actions for enrollment Starts
if(isset($_POST["action"]))
{
//	1.a. Action Fetch Starts
	if($_POST["action"] == 'fetch')
	{
		$order_column = array('enrollment_id', 'course_id','user_id', 'enrollment_status');

		$output = array();

		$main_query = "
		SELECT * FROM enrollment_wus ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE enrollment_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR course_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR user_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR enrollment_status LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY enrollment_id DESC ';
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
			// $sub_array[] = $row["enrollment_id"];
			$sub_array[] = $object->Get_course_name($row["course_id"]);
			$sub_array[] = $object->Get_user_name($row["user_id"]);

			$status = '';
			if($row["enrollment_status"] == 'Enable')
			{
				$status = '<button type="button" name="status_button" class="btn btn-primary btn-sm status_button" data-id="'.$row["enrollment_id"].'" data-status="'.$row["enrollment_status"].'">Enable</button>';
			}
			else
			{
				$status = '<button type="button" name="status_button" class="btn btn-danger btn-sm status_button" data-id="'.$row["enrollment_id"].'" data-status="'.$row["enrollment_status"].'">Disable</button>';
			}
			$sub_array[] = $status;

			$sub_array[] = '
			<div align="center">
			<button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$row["enrollment_id"].'"><i class="fas fa-edit"></i></button>
			</div>
			';
			$sub_array[] = '
			<div align="center">
			<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["enrollment_id"].'"><i class="fas fa-times"></i></button>
			</div>
			';
			$data[] = $sub_array;
		}

		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
			
		echo json_encode($output);

	}	// 1.a.	Action Fetch Ends

//	1.b. Action Fetch Starts
	if($_POST["action"] == 'fetch_by_staff')
	{
		$order_column = array('enrollment_id', 'course_id','user_id', 'enrollment_status');

		$output = array();

		$main_query = "
		SELECT * FROM enrollment_wus ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE enrollment_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR course_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR user_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR enrollment_status LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY enrollment_id DESC ';
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
			// $sub_array[] = $row["enrollment_id"];
			$sub_array[] = $object->Get_course_name($row["course_id"]);
			$sub_array[] = $object->Get_user_name($row["user_id"]);

			// $status = '';
			// if($row["enrollment_status"] == 'Enable')
			// {
			// 	$status = '<button type="button" name="status_button" class="btn btn-primary btn-sm status_button" data-id="'.$row["enrollment_id"].'" data-status="'.$row["enrollment_status"].'">Enable</button>';
			// }
			// else
			// {
			// 	$status = '<button type="button" name="status_button" class="btn btn-danger btn-sm status_button" data-id="'.$row["enrollment_id"].'" data-status="'.$row["enrollment_status"].'">Disable</button>';
			// }
			// $sub_array[] = $status;

			// $sub_array[] = '
			// <div align="center">
			// <button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$row["enrollment_id"].'"><i class="fas fa-edit"></i></button>
			// </div>
			// ';
			// $sub_array[] = '
			// <div align="center">
			// <button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["enrollment_id"].'"><i class="fas fa-times"></i></button>
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

	}	// 1.b.	Action Fetch Ends

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
		SELECT * FROM enrollment_wus
		WHERE course_id = :course_id
		AND user_id = :user_id
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Enrollment Already Exists</div>';
		}
		else
		{
			$data = array(
				':course_id'			=>	$object->clean_input($_POST["course_id"]),
				':user_id'				=>	$object->clean_input($_POST["user_id"]),
				':enrollment_status'	=>	'Enable'
			);

			$object->query = "
			INSERT INTO enrollment_wus 
			(course_id, user_id, enrollment_status) 
			VALUES (:course_id, :user_id, :enrollment_status)
			";

			$object->execute($data);

			$success = '<div class="alert alert-success">Enrollment Added</div>';
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
		SELECT * FROM enrollment_wus 
		WHERE enrollment_id = '".$_POST["enrollment_id"]."'
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
		SELECT * FROM enrollment_wus
		WHERE course_id = :course_id
		AND user_id = :user_id
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Enrollment Already Exists</div>';
		}
		else
		{

			$data = array(
				':course_id'			=>	$object->clean_input($_POST["course_id"]),
				':user_id'				=>	$object->clean_input($_POST["user_id"]),
			);

			$object->query = "
			UPDATE enrollment_wus 
			SET course_id = :course_id,
			user_id = :user_id
			WHERE enrollment_id = '".$_POST['hidden_id']."'
			";

			$object->execute($data);

			$success = '<div class="alert alert-success">Enrollment Data Updated</div>';
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
			':enrollment_status'		=>	$_POST['next_status']
		);

		$object->query = "
		UPDATE enrollment_wus 
		SET enrollment_status = :enrollment_status 
		WHERE enrollment_id = '".$_POST["id"]."'
		";

		$object->execute($data);

		echo '<div class="alert alert-success">Enrollment status change to '.$_POST['next_status'].'</div>';
	}	// Action action_status starts


//	6.	Action delete starts
	if($_POST["action"] == 'delete')
	{
		$object->query = "
		DELETE FROM enrollment_wus 
		WHERE enrollment_id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">Enrollment Data Deleted</div>';
	}	// Action delete ends
}	// List of Actions for Category Ends

?>