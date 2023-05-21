<?php

// user/course_action.php

include('wus.php');

$object = new wus();

// List of Actions for course Starts
if(isset($_POST["action"]))
{

// Working = 

// Not Working = 

//	1.a. Action Fetch Starts

	if($_POST["action"] == 'fetch')
	{
		$order_column = array('course_wus.course_name', 'category_wus.category_name','course_wus.course_description','course_wus.course_status' , 'course_wus.course_added_by'
		// , 'course_updated_on', 'course_updated_by'
		);

		$output = array();

		$main_query = "
		SELECT * FROM course_wus 
		INNER JOIN category_wus ON category_wus.category_id = course_wus.category_id
		";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE course_wus.course_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR category_wus.category_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR course_wus.course_description LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR course_wus.course_status LIKE "%'.$_POST["search"]["value"].'%" ';
			// $search_query .= 'OR course_created_on LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR course_wus.course_added_by	 LIKE "%'.$_POST["search"]["value"].'%" ';
			// $search_query .= 'OR course_updated_on LIKE "%'.$_POST["search"]["value"].'%" ';
			// $search_query .= 'OR course_updated_by LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY course_id DESC ';
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
			if($row["course_added_by"] === $_SESSION["user_id"])
			{
				$sub_array = array();
				// $sub_array[] = $row["course_name"];
				$sub_array[] = $object->Get_course_name($row["course_id"]);
				$sub_array[] = html_entity_decode($row["category_name"]);
				$sub_array[] = html_entity_decode($row["course_description"]);
				$sub_array[] = $row["course_duration"];
				$sub_array[] = $row["course_level"];
				// $sub_array[] = $row["course_created_on"];

				$status = '';
				if($row["course_status"] == 'Enable')
				{
					$status = '<button type="button" name="status_button" class="btn btn-primary btn-sm status_button" data-id="'.$row["course_id"].'" data-status="'.$row["course_status"].'">Enable</button>';
				}
				else
				{
					$status = '<button type="button" name="status_button" class="btn btn-danger btn-sm status_button" data-id="'.$row["course_id"].'" data-status="'.$row["course_status"].'">Disable</button>';
				}
				$sub_array[] = $status;
				// $sub_array[] = $row["course_added_on"];
				$sub_array[] = $object->Get_user_name($row["course_added_by"]);
				// $sub_array[] = $row["category_updated_on"];
				// $sub_array[] = $object->Get_user_name($row["course_updated_by"]);
				$sub_array[] = '
				<div align="center">
				<button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$row["course_id"].'"><i class="fas fa-edit"></i></button>
				</div>
				';
				$sub_array[] = '
				<div align="center">
				<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["course_id"].'"><i class="fas fa-times"></i></button>
				</div>
				';
				$data[] = $sub_array;
			}
		}

		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
			
		echo json_encode($output);

	}
	//  1.a Action Fetch Ends







// Fetch Details Starts
	// if($_POST["action"] == 'fetch_details')
	// {
	// 	$course_data = array();

	// 	$object->query = "
	// 	SELECT *  FROM course_wus
	// 	WHERE category_id = '".$_POST["category_id"]."' 
	// 	AND course_status = 'Enable' 
	// 	ORDER BY course_name ASC
	// 	";

	// 	$course_detail = $object->get_result();

	// 	foreach($course_detail as $row)
	// 	{
	// 		$course_duration[] = array(
	// 			'course_id'			=>	$row['course_id'],
	// 			'course_name'		=>	html_entity_decode($row['course_name'])
	// 		);
	// 	}

	// 	$data = array(
	// 		'course_data'		=>	$course_data,
	// 	);
	// 	// print_r(var_dump($data));
	// 	echo json_encode($data);

	// }	
	// Fetch Details Ends

//	2.	Action Add Starts
	if($_POST["action"] == 'Add')
	{
		$error = '';
		$success = '';

		$data = array(
			':course_name'	=>	$_POST["course_name"]
		);

		$object->query = "
		SELECT * FROM course_wus
		WHERE course_name = :course_name

		";

		$object->execute($data);

		if($object->row_count() > 1)
		{
			$error = '<div class="alert alert-danger">Course Name Already Exists</div>';
		}
		else
		{
			$data = array(
				':category_id'				=>	$object->clean_input($_POST["category_id"]),
				':course_name'				=>	$object->clean_input($_POST["course_name"]),
				':course_description'		=>	$object->clean_input($_POST["course_description"]),
				':course_duration'			=>	$object->clean_input($_POST["course_duration"]),
				':course_level'				=>	$object->clean_input($_POST["course_level"]),
				':course_status'			=>	'Enable',
				// ':course_created_on'		=>	$object->now,
				':course_added_by'			=>	$object->clean_input($_SESSION['user_id']),
				// ':course_updated_on'		=>	$object->now,
				':course_updated_by'		=>	$object->clean_input($_SESSION['user_id'])
			);

			$object->query = "
			INSERT INTO course_wus 
			(category_id, course_name, course_description, course_duration, course_level, course_status, course_added_by, course_updated_by) 
			VALUES (:category_id, :course_name, :course_description, :course_duration, :course_level, :course_status, :course_added_by, :course_updated_by)
			";

			$object->execute($data);

			$success = '<div class="alert alert-success">Course Added in <b>'.$object->Get_category_name($_POST["category_id"]).'</b> Category</div>';
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
		SELECT * FROM course_wus 
		WHERE course_id = '".$_POST["course_id"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['category_id'] = $row['category_id'];
			$data['course_name'] = $row['course_name'];
			$data['course_description'] = $row['course_description'];
			$data['course_duration'] = $row['course_duration'];
			$data['course_level'] = $row['course_level'];
		}

		echo json_encode($data);
	}	// Action fetch_single Ends

//	4.	Action Edit Starts
	if($_POST["action"] == 'Edit')
	{
		$error = '';
		$success = '';

		$data = array(
			':course_name'	=>	$_POST["course_name"],
			':course_id'	=>	$_POST["hidden_id"]
		);

		$object->query = "
		SELECT * FROM course_wus 
		WHERE course_name = :course_name 
		AND course_id != :course_id
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Course Name Already Exists <b>'.$object->Get_category_name($_POST["category_id"]).'</b> Catgeory</div>';
		}
		else
		{

			$data = array(
				':category_id'				=>	$object->clean_input($_POST["category_id"]),
				':course_name'				=>	$object->clean_input($_POST["course_name"]),
				':course_description'		=>	$object->clean_input($_POST["course_description"]),
				':course_duration'			=>	$object->clean_input($_POST["course_duration"]),
				':course_level'				=>	$object->clean_input($_POST["course_level"]),
				':course_updated_by'		=>	$object->clean_input($_SESSION['user_id'])
			);

			$object->query = "
			UPDATE course_wus 
			SET category_id = :category_id,
			course_name = :course_name,
			course_description = :course_description,
			course_duration = :course_duration,
			course_level = :course_level,
			course_updated_by = :course_updated_by
			WHERE course_id = '".$_POST["hidden_id"]."'
			";

			$object->execute($data);

			$success = '<div class="alert alert-success">Course <b>'.$object->Get_course_name($_POST["hidden_id"]).'</b> Data Updated</div>';
		}

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}	// Action Edit Ends


//	5.	Action change_status starts
	if($_POST["action"] == 'change_status')
	{
		// $new_data = array(
		// 	':category_id'		=>	$_POST['category_id']
		// );

		$data = array(
			':course_status'		=>	$_POST['next_status']
		);

		$object->query = "
		UPDATE course_wus 
		SET course_status = :course_status 
		WHERE course_id = '".$_POST["id"]."'
		";

		$object->execute($data);

		echo '<div class="alert alert-success">Course <b>'.$object->Get_course_name($_POST["id"]).'</b> status change to '.$_POST['next_status'].'</div>';
	}	// Action action_status starts


//	6.	Action delete starts
	if($_POST["action"] == 'delete')
	{
		$object->query = "
		DELETE FROM course_wus 
		WHERE course_id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">Course <b>'.$object->Get_course_name($_POST["id"]).'</b> Data Deleted</div>';
	}	// Action delete ends
}	// List of Actions for course Ends

?>