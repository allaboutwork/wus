<?php

// teacher/module_section.php

include('wus.php');

$object = new wus();

// List of Actions for Module Starts
if(isset($_POST["action"]))
{

// Working = 

// Not Working = 

//	1.a. Action Fetch Starts

	if($_POST["action"] == 'fetch')
	{
		$order_column = array('module_wus.module_name', 'course_wus.course_name','module_wus.module_description','module_wus.module_status' , 'module_wus.module_added_by'
		// , 'module_updated_on', 'module_updated_by'
		);

		$output = array();

		$main_query = "
		SELECT * FROM module_wus 
		INNER JOIN course_wus ON course_wus.course_id = module_wus.course_id
		";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE module_wus.module_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR course_wus.course_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR module_wus.module_description LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR module_wus.module_status LIKE "%'.$_POST["search"]["value"].'%" ';
			// $search_query .= 'OR module_created_on LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR module_wus.module_added_by	 LIKE "%'.$_POST["search"]["value"].'%" ';
			// $search_query .= 'OR module_updated_on LIKE "%'.$_POST["search"]["value"].'%" ';
			// $search_query .= 'OR module_updated_by LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY module_id DESC ';
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
			if($row["module_added_by"] === $_SESSION["user_id"])
			{
				$sub_array = array();
				// $sub_array[] = $row["module_name"];
				$sub_array[] = $object->Get_module_name($row["module_id"]);
				$sub_array[] = $object->Get_course_name($row["course_id"]);
				// $sub_array[] = html_entity_decode($row["course_name"]);
				$sub_array[] = html_entity_decode($row["module_description"]);
				// $sub_array[] = $row["module_duration"];
				// $sub_array[] = $row["module_level"];
				// $sub_array[] = $row["module_created_on"];

				$status = '';
				if($row["module_status"] == 'Enable')
				{
					$status = '<button type="button" name="status_button" class="btn btn-primary btn-sm status_button" data-id="'.$row["module_id"].'" data-status="'.$row["module_status"].'">Enable</button>';
				}
				else
				{
					$status = '<button type="button" name="status_button" class="btn btn-danger btn-sm status_button" data-id="'.$row["module_id"].'" data-status="'.$row["module_status"].'">Disable</button>';
				}
				$sub_array[] = $status;
				// $sub_array[] = $row["module_added_on"];
				$sub_array[] = $object->Get_user_name($row["module_added_by"]);
				// $sub_array[] = $row["course_updated_on"];
				// $sub_array[] = $object->Get_user_name($row["module_updated_by"]);
				$sub_array[] = '
				<div align="center">
				<button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$row["module_id"].'"><i class="fas fa-edit"></i></button>
				</div>
				';
				$sub_array[] = '
				<div align="center">
				<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["module_id"].'"><i class="fas fa-times"></i></button>
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
	// 	$module_data = array();

	// 	$object->query = "
	// 	SELECT *  FROM module_wus
	// 	WHERE course_id = '".$_POST["course_id"]."' 
	// 	AND module_status = 'Enable' 
	// 	ORDER BY module_name ASC
	// 	";

	// 	$module_detail = $object->get_result();

	// 	foreach($module_detail as $row)
	// 	{
	// 		$module_duration[] = array(
	// 			'module_id'			=>	$row['module_id'],
	// 			'module_name'		=>	html_entity_decode($row['module_name'])
	// 		);
	// 	}

	// 	$data = array(
	// 		'module_data'		=>	$module_data,
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
			':module_name'	=>	$_POST["module_name"]
		);

		$object->query = "
		SELECT * FROM module_wus
		WHERE module_name = :module_name

		";

		$object->execute($data);

		if($object->row_count() > 1)
		{
			$error = '<div class="alert alert-danger">Module Name Already Exists</div>';
		}
		else
		{

			$data = array(
				':course_id'				=>	$object->clean_input($_POST["course_id"]),
				':module_name'				=>	$object->clean_input($_POST["module_name"]),
				':module_description'		=>	$object->clean_input($_POST["module_description"]),
				// ':module_duration'			=>	$object->clean_input($_POST["module_duration"]),
				// ':module_level'				=>	$object->clean_input($_POST["module_level"]),
				':module_status'			=>	'Enable',
				// ':module_created_on'		=>	$object->now,
				':module_added_by'			=>	$object->clean_input($_SESSION['user_id']),
				// ':module_updated_on'		=>	$object->now,
				':module_updated_by'		=>	$object->clean_input($_SESSION['user_id'])
			);

			$object->query = "
			INSERT INTO module_wus 
			(course_id, module_name, module_description, module_status, module_added_by, module_updated_by) 
			VALUES (:course_id, :module_name, :module_description, :module_status, :module_added_by, :module_updated_by)
			";

			$object->execute($data);

			$success = '<div class="alert alert-success">Module Added in <b>'.$object->Get_course_name($_POST["course_id"]).'</b> course</div>';
			
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
		SELECT * FROM module_wus 
		WHERE module_id = '".$_POST["module_id"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			if($row["module_added_by"] === $_SESSION["user_id"])
			{
				$data['course_id'] = $row['course_id'];
				$data['module_name'] = $row['module_name'];
				$data['module_description'] = $row['module_description'];
				// $data['module_duration'] = $row['module_duration'];
				// $data['module_level'] = $row['module_level'];
			}
		}

		echo json_encode($data);
	}	// Action fetch_single Ends

//	4.	Action Edit Starts
	if($_POST["action"] == 'Edit')
	{
		$error = '';
		$success = '';

		$data = array(
			':module_name'	=>	$_POST["module_name"],
			':module_id'	=>	$_POST["hidden_id"]
		);

		$object->query = "
		SELECT * FROM module_wus 
		WHERE module_name = :module_name 
		AND module_id != :module_id
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">module Name Already Exists <b>'.$object->Get_course_name($_POST["course_id"]).'</b> Catgeory</div>';
		}
		else
		{

			$data = array(
				':course_id'				=>	$object->clean_input($_POST["course_id"]),
				':module_name'				=>	$object->clean_input($_POST["module_name"]),
				':module_description'		=>	$object->clean_input($_POST["module_description"]),
				// ':module_duration'			=>	$object->clean_input($_POST["module_duration"]),
				// ':module_level'				=>	$object->clean_input($_POST["module_level"]),
				':module_updated_by'		=>	$object->clean_input($_SESSION['user_id'])
			);

			$object->query = "
			UPDATE module_wus 
			SET course_id = :course_id,
			module_name = :module_name,
			module_description = :module_description,
			module_updated_by = :module_updated_by
			WHERE module_id = '".$_POST["hidden_id"]."'
			";

			$object->execute($data);

			$success = '<div class="alert alert-success">module <b>'.$object->Get_module_name($_POST["hidden_id"]).'</b> Data Updated</div>';
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
		// 	':course_id'		=>	$_POST['course_id']
		// );

		$data = array(
			':module_status'		=>	$_POST['next_status']
		);

		$object->query = "
		UPDATE module_wus 
		SET module_status = :module_status 
		WHERE module_id = '".$_POST["id"]."'
		";

		$object->execute($data);

		echo '<div class="alert alert-success">module <b>'.$object->Get_module_name($_POST["id"]).'</b> status change to '.$_POST['next_status'].'</div>';
	}	// Action action_status starts


//	6.	Action delete starts
	if($_POST["action"] == 'delete')
	{
		$object->query = "
		DELETE FROM module_wus 
		WHERE module_id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">module <b>'.$object->Get_module_name($_POST["id"]).'</b> Data Deleted</div>';
	}	// Action delete ends
}	// List of Actions for module Ends

?>