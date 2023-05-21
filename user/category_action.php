<?php

// user/category_action.php

include('wus.php');

$object = new wus();

// List of Actions for Category Starts

// Working = 1, 2, 3, 4, 5, 6

// Not Working = 


if(isset($_POST["action"]))
{
//	1.	Action Fetch Starts
	if($_POST["action"] == 'fetch')
	{
		$order_column = array(
								'category_name', 
								'category_description',
								'category_status', 
								// 'category_created_on', 
								'category_created_by', 
								// 'category_updated_on', 
								'category_updated_by'
							);

		$output = array();

		$main_query = "
		SELECT * FROM category_wus ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE category_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR category_description LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR category_status LIKE "%'.$_POST["search"]["value"].'%" ';
			// $search_query .= 'OR category_created_on LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR category_created_by LIKE "%'.$_POST["search"]["value"].'%" ';
			// $search_query .= 'OR category_updated_on LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR category_updated_by LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY category_id ASC ';
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
			// $sub_array[] = $row["category_name"];
			$sub_array[] = $object->Get_category_name($row["category_id"]);
			$sub_array[] = html_entity_decode($row["category_description"]);

			$status = '';
			if($row["category_status"] == 'Enable')
			{
				$status = '<button type="button" name="status_button" class="btn btn-primary btn-sm status_button" data-id="'.$row["category_id"].'" data-status="'.$row["category_status"].'">Enable</button>';
			}
			else
			{
				$status = '<button type="button" name="status_button" class="btn btn-danger btn-sm status_button" data-id="'.$row["category_id"].'" data-status="'.$row["category_status"].'">Disable</button>';
			}
			$sub_array[] = $status;
			// $sub_array[] = $row["category_created_on"];
			$sub_array[] = $object->Get_user_name($row["category_created_by"]);
			// $sub_array[] = $row["category_updated_on"];
			$sub_array[] = $object->Get_user_name($row["category_updated_by"]);
			$sub_array[] = '
			<div align="center">
			<button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$row["category_id"].'"><i class="fas fa-edit"></i></button>
			</div>
			';
			$sub_array[] = '
			<div align="center">
			<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["category_id"].'"><i class="fas fa-times"></i></button>
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

	}	// 1.	Action Fetch Ends

//	2.	Action Add Starts
	if($_POST["action"] == 'Add')
	{
		$error = '';
		$success = '';

		$data = array(
			':category_name'	=>	$_POST["category_name"]
		);

		$object->query = "
		SELECT * FROM category_wus
		WHERE category_name = :category_name
		
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div category="alert alert-danger">Category Name Already Exists</div>';
		}
		else
		{
			$data = array(
				':category_name'			=>	$object->clean_input($_POST["category_name"]),
				':category_description'		=>	$object->clean_input($_POST["category_description"]),
				':category_status'			=>	'Enable',
				// ':category_created_on'		=>	$object->now,
				':category_created_by'		=>	$object->clean_input($_SESSION['user_id']),
				// ':category_updated_on'		=>	$object->now,
				':category_updated_by'		=>	$object->clean_input($_SESSION['user_id'])

			);

			$object->query = "
			INSERT INTO category_wus 
			(category_name, 
			category_description, 
			category_status, 
			category_created_by, 
			category_updated_by
			) 
			VALUES (
				:category_name, 
				:category_description, 
				:category_status, 
				:category_created_by, 
				:category_updated_by
				)
			";

			$object->execute($data);

			$success = '<div class="alert alert-success">Category Added</div>';
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
		SELECT * FROM category_wus 
		WHERE category_id = '".$_POST["category_id"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['category_name'] = $row['category_name'];
			$data['category_description'] = $row['category_description'];
		}

		echo json_encode($data);
	}	// Action fetch_single Ends

//	4.	Action Edit Starts
	if($_POST["action"] == 'Edit')
	{
		$error = '';

		$success = '';

		$data = array(
			':category_name'	=>	$_POST["category_name"],
			':category_id'		=>	$_POST["hidden_id"]
		);

		$object->query = "
		SELECT * FROM category_wus 
		WHERE category_name = :category_name 
		AND category_id != :category_id
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Category Name Already Exists</div>';
		}
		else
		{

			$data = array(
				':category_name'			=>	$object->clean_input($_POST["category_name"]),
				':category_description'		=>	$object->clean_input($_POST["category_description"]),
				// ':category_updated_on'		=>  $object->now,
				':category_updated_by'		=>	$object->clean_input($_SESSION['user_id'])
			);

			$object->query = "
			UPDATE category_wus 
			SET category_name = :category_name
			, category_description = :category_description
			, category_updated_by = :category_updated_by
			WHERE category_id = '".$_POST['hidden_id']."'
			";

			$object->execute($data);

			$success = '<div class="alert alert-success">Category Data Updated</div>';
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
		$data = array(
			':category_status'	=>	$_POST['next_status']
		);

		$object->query = "
		UPDATE category_wus 
		SET category_status = :category_status 
		WHERE category_id = '".$_POST["id"]."'
		";

		$object->execute($data);

		echo '<div class="alert alert-success">Category status change to '.$_POST['next_status'].'</div>';
	}	// Action action_status starts


//	6.	Action delete starts
	if($_POST["action"] == 'delete')
	{
		$object->query = "
		DELETE FROM category_wus 
		WHERE category_id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">Category Data Deleted</div>';
	}	// Action delete ends
}	// List of Actions for Category Ends

?>