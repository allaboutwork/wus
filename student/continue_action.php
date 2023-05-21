<?php

// teacher/material_section.php

include('wus.php');

$object = new wus();

// List of Actions for material Starts
if(isset($_POST["action"]))
{

// Working = 

// Not Working = 

//	1.a. Action Fetch Starts
	if($_POST["action"] == 'fetch')
	{
		$order_column = array(
								'material_wus.material_name', 
								'course_wus.course_name', 
								'module_wus.module_name', 
								'material_wus.material_description',
								'material_wus.material_status' , 
								'material_wus.material_added_by'
							);

		$output = array();

		$main_query = "
		SELECT * FROM(( material_wus 
		INNER JOIN course_wus ON course_wus.course_id = material_wus.course_id)
		INNER JOIN module_wus ON module_wus.module_id = material_wus.module_id)
		WHERE course_wus.course_id = '".$_GET['course_id']."'
		";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE material_wus.material_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR course_wus.course_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR module_wus.module_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR material_wus.material_description LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR material_wus.material_status LIKE "%'.$_POST["search"]["value"].'%" ';
			// $search_query .= 'OR material_created_on LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR material_wus.material_added_by	 LIKE "%'.$_POST["search"]["value"].'%" ';
			// $search_query .= 'OR material_updated_on LIKE "%'.$_POST["search"]["value"].'%" ';
			// $search_query .= 'OR material_updated_by LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY material_id DESC ';
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
			if($row["material_added_by"] === $_SESSION["user_id"])
			{
				$sub_array = array();
				// $sub_array[] = $row["material_name"];
				$sub_array[] = $object->Get_material_name($row["material_id"]);
				$sub_array[] = $object->Get_course_name($row["course_id"]);
				$sub_array[] = $object->Get_module_name($row["module_id"]);
				$sub_array[] = $row["material_position"];
				// $sub_array[] = html_entity_decode($row["course_name"]);
				$sub_array[] = html_entity_decode($row["material_description"]);
				// $sub_array[] = $row["material_level"];
				// $sub_array[] = $row["material_created_on"];
                
				$status = '';
				if($row["material_status"] == 'Enable')
				{
					$status = '<button type="button" name="status_button" class="btn btn-primary btn-sm status_button" data-id="'.$row["material_id"].'" data-status="'.$row["material_status"].'">Enable</button>';
				}
				else
				{
                    $status = '<button type="button" name="status_button" class="btn btn-danger btn-sm status_button" data-id="'.$row["material_id"].'" data-status="'.$row["material_status"].'">Disable</button>';
				}
				$sub_array[] = $status;
                $sub_array[] = html_entity_decode($row["material_type"]);
                $sub_array[] = html_entity_decode($row["material_data"]);
				// $material_data = '';
				// if($row["material_data"] == '')
				// {
				// 	$material_data = '<button type="button" name="material_data" class="btn btn-primary btn-sm material_data_button" data-id="'.$row["material_id"].'" material_data-status="'.$row["material_data"].'">Add Data</button>';
				// }
				// $sub_array[] = $material_data;
				// $sub_array[] = $row["material_added_on"];
				$sub_array[] = $object->Get_user_name($row["material_added_by"]);
				// $sub_array[] = $row["course_updated_on"];
				// $sub_array[] = $object->Get_user_name($row["material_updated_by"]);
				$sub_array[] = '
				<div align="center">
				<button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$row["material_id"].'"><i class="fas fa-edit"></i></button>
				</div>
				';
				$sub_array[] = '
				<div align="center">
				<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["material_id"].'"><i class="fas fa-times"></i></button>
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

	}	// 1.a Action Fetch Ends

// 1.b.Action Fetch Details Start
	if($_POST["action"] == 'fetch_details')
	{
		$module_data = array();

		$object->query = "
		SELECT module_id, module_name FROM module_wus 
		WHERE course_id = '".$_POST["course_id"]."' 
		AND module_status = 'Enable' 
		AND module_added_by = '".$_SESSION['user_id']."'
		ORDER BY module_name ASC
		";

		$module_result = $object->get_result();

		foreach($module_result as $row)
		{
			$module_data[] = array(
				'module_id'		=>	$row['module_id'],
				'module_name'	=>	html_entity_decode($row['module_name'])
			);
		}

		$data = array(
			'module_data'	=>	$module_data
		);

		echo json_encode($data);
	}	// 1.b. Action Fetch Details Ends

//	2.	Action Add Starts
	if($_POST["action"] == 'Add')
	{
		$error = '';
		$success = '';

		$data = array(
			':material_name'	=>	$_POST["material_name"]
		);

		$object->query = "
		SELECT * FROM material_wus
		WHERE material_name = :material_name

		";

		$object->execute($data);

		if($object->row_count() > 1)
		{
			$error = '<div class="alert alert-danger">Material Name Already Exists</div>';
		}
		else
		{

			$data = array(
				':course_id'				=>	$object->clean_input($_POST["course_id"]),
				':module_id'				=>	$object->clean_input($_POST["module_id"]),
				':material_name'			=>	$object->clean_input($_POST["material_name"]),
				':material_description'		=>	$object->clean_input($_POST["material_description"]),
				':material_position'		=>	$object->clean_input($_POST["material_position"]),
				':material_type'			=>	$object->clean_input($_POST["material_type"]),
				':material_data'			=>	$object->clean_input($_POST["material_data"]),
				':material_status'			=>	'Enable',
				':material_added_by'		=>	$object->clean_input($_SESSION['user_id']),
				':material_updated_by'		=>	$object->clean_input($_SESSION['user_id'])
			);

			$object->query = "
			INSERT INTO material_wus (
										course_id, 
										module_id, 
										material_name, 
										material_description, 
										material_position, 
										material_type, 
										material_data, 
										material_status, 
										material_added_by, 
										material_updated_by
									) 
			VALUES (
						:course_id, 
						:module_id, 
						:material_name, 
						:material_description, 
						:material_position, 
						:material_type, 
						:material_data, 
						:material_status, 
						:material_added_by, 
						:material_updated_by
					)
			";

			$object->execute($data);

			$success = '<div class="alert alert-success">Material Added in <b>'.$object->Get_course_name($_POST["course_id"]).'</b> course</div>';
			
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
		SELECT * FROM material_wus 
		WHERE material_id = '".$_POST["material_id"]."'
		";

		$result = $object->get_result();

		$data = array();

		$module_data = array();

		foreach($result as $row)
		{
			if($row["material_added_by"] === $_SESSION["user_id"])
			{
				$object->query = "
				SELECT * FROM material_wus 
				WHERE material_id = '".$_POST["material_id"]."'
				";
				
				$result = $object->get_result();
				
				
				foreach($result as $row)
				{
					$data['course_id'] = $row['course_id'];
					$data['module_id'] = $row['module_id'];
					$data['material_name'] = $row['material_name'];
					$data['material_description'] = $row['material_description'];
					$data['material_position'] = $row['material_position'];
					$data['material_type'] = $row['material_type'];
					$data['material_data'] = html_entity_decode($row['material_data']);
				}


				// $module_id = $row['module_id'];
				// $data['module_id'] = $module_id;

				$object->query = "
				SELECT module_id, module_name FROM module_wus 
				WHERE course_id = '".$row['course_id']."' 
				AND module_status = 'Enable' 
				AND module_added_by = '".$_SESSION['user_id']."'
				ORDER BY module_name ASC
				";

				$module_result = $object->get_result();

				foreach($module_result as $row)
				{
					$module_data[] = array(
						'module_id'		=>	$row['module_id'],
						'module_name'	=>	html_entity_decode($row['module_name'])
					);
				}
				$data['module_data'] = $module_data;
				

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
			':material_name'	=>	$_POST["material_name"],
			':material_id'		=>	$_POST["hidden_id"]
		);

		$object->query = "
		SELECT * FROM material_wus 
		WHERE material_name = :material_name 
		AND material_id != :material_id
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Material Name Already Exists <b>'.$object->Get_course_name($_POST["course_id"]).'</b> Catgeory</div>';
		}
		else
		{

			$data = array(
				':course_id'				=>	$object->clean_input($_POST["course_id"]),
				':module_id'				=>	$object->clean_input($_POST["module_id"]),
				':material_name'			=>	$object->clean_input($_POST["material_name"]),
				':material_description'		=>	$object->clean_input($_POST["material_description"]),
				':material_position'		=>	$object->clean_input($_POST["material_position"]),
				':material_type'			=>	$object->clean_input($_POST["material_type"]),
				':material_data'			=>	$object->clean_input($_POST["material_data"]),
				':material_status'			=>	'Enable',
				':material_updated_by'		=>	$object->clean_input($_SESSION['user_id'])
			);

			$object->query = "
			UPDATE material_wus 
			SET course_id = :course_id,
			module_id = :module_id,
			material_name = :material_name,
			material_description = :material_description,
			material_position = :material_position,
			material_type = :material_type,
			material_data = :material_data,
			material_status = :material_status,
			material_updated_by = :material_updated_by
			WHERE material_id = '".$_POST["hidden_id"]."'
			";

			$object->execute($data);

			$success = '<div class="alert alert-success">material <b>'.$object->Get_material_name($_POST["hidden_id"]).'</b> Data Updated</div>';
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
			':material_status'		=>	$_POST['next_status']
		);

		$object->query = "
		UPDATE material_wus 
		SET material_status = :material_status 
		WHERE material_id = '".$_POST["id"]."'
		";

		$object->execute($data);

		echo '<div class="alert alert-success">material <b>'.$object->Get_material_name($_POST["id"]).'</b> status change to '.$_POST['next_status'].'</div>';
	}	// Action action_status starts


//	6.	Action delete starts
	if($_POST["action"] == 'delete')
	{
		$object->query = "
		DELETE FROM material_wus 
		WHERE material_id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">material <b>'.$object->Get_material_name($_POST["id"]).'</b> Data Deleted</div>';
	}	// Action delete ends
}	// List of Actions for material Ends

?>