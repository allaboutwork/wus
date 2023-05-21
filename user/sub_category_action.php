<?php

// user/sub_category_action.php

include('wus.php');

$object = new wus();

// List of Actions for Sub Category Starts
if(isset($_POST["action"]))
{

// Working = 1, 2, 3, 4, 5, 6

// Not Working = 

// 1. Fetch Action Starts
	if($_POST["action"] == 'fetch')
	{
		$order_column = array(
                            'sub_category_wus.sub_category_name', 
                            'category_wus.category_name', 
                            'sub_category_wus.sub_category_description', 
                            'sub_category_wus.sub_category_status' ,
                            // 'sub_category_wus.sub_category_created_on', 
                            'sub_category_wus.sub_category_created_by', 
                            // 'sub_category_wus.sub_category_updated_on', 
                            'sub_category_wus.sub_category_updated_by'
                        );
  
		$output = array();

		$main_query = "
		SELECT * FROM sub_category_wus 
		INNER JOIN category_wus ON category_wus.category_id = sub_category_wus.category_id 
		";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE category_wus.category_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR sub_category_wus.sub_category_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR sub_category_wus.sub_category_description LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR sub_category_wus.sub_category_status LIKE "%'.$_POST["search"]["value"].'%" ';
			// $search_query .= 'OR sub_category_wus.sub_category_created_on LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR sub_category_wus.sub_category_created_by LIKE "%'.$_POST["search"]["value"].'%" ';
			// $search_query .= 'OR sub_category_wus.sub_category_updated_on LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR sub_category_wus.sub_category_updated_by LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY sub_category_wus.sub_category_id DESC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

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
			$sub_array[] = html_entity_decode($row["sub_category_name"]);
			$sub_array[] = html_entity_decode($row["category_name"]);
			$sub_array[] = $row["sub_category_description"];


			$status = '';
			if($row["sub_category_status"] == 'Enable')
			{
				$status = '<button type="button" name="status_button" class="btn btn-primary btn-sm status_button" data-id="'.$row["sub_category_id"].'" data-status="'.$row["sub_category_status"].'">Enable</button>';
			}
			else
			{
				$status = '<button type="button" name="status_button" class="btn btn-danger btn-sm status_button" data-id="'.$row["sub_category_id"].'" data-status="'.$row["sub_category_status"].'">Disable</button>';
			}
			$sub_array[] = $status;

            // $sub_array[] = $row["sub_category_created_on"];
			$sub_array[] = $object->Get_user_name($row["sub_category_created_by"]);
			// $sub_array[] = $row["category_updated_on"];
			$sub_array[] = $object->Get_user_name($row["sub_category_updated_by"]);
			// $sub_array[] = $row["student_email_id"];
			// $sub_array[] = $row["student_gender"];
			// $sub_array[] = $row["student_dob"];
			// $sub_array[] = $row["student_added_on"];

			$sub_array[] = '
			<div align="center">
			<button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$row["sub_category_id"].'"><i class="fas fa-edit"></i></button>
			</div>
			';
			$sub_array[] = '
			<div align="center">
			<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["sub_category_id"].'"><i class="fas fa-times"></i></button>
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
	}   // 1. Fetch Action Ends

// 2. Add Action Starts
	if($_POST["action"] == 'Add')
	{
		$error = '';

		$success = '';

		$data = array(
			':category_id'			=>	$_POST["category_id"],
			':sub_category_name'	=>	$_POST["sub_category_name"]
		);

		$object->query = "
		SELECT * FROM sub_category_wus 
		WHERE category_id = :category_id 
		AND sub_category_name = :sub_category_name
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Sub Category Already Exists in <b>'.$object->Get_category_name($_POST["category_id"]).'</b> Category</div>';
		}
		else
		{
			$data = array(
				':category_id'			        =>	$object->clean_input($_POST["category_id"]),
				':sub_category_name'	        =>	$object->clean_input($_POST["sub_category_name"]),
				':sub_category_description'	    =>	$object->clean_input($_POST["sub_category_description"]),
				':sub_category_status'	        =>	'Enable',
				// ':sub_category_created_on'		=>	$object->now,
                ':sub_category_created_by'		=>	$object->clean_input($_SESSION['user_id']),
				// ':sub_category_updated_on'		=>	$object->now,
				':sub_category_updated_by'		=>	$object->clean_input($_SESSION['user_id'])
			);

			$object->query = "
			INSERT INTO sub_category_wus (
                category_id, sub_category_name, sub_category_description, sub_category_status, sub_category_created_by, sub_category_updated_by
            ) 
			VALUES (
                :category_id, :sub_category_name,  :sub_category_description, :sub_category_status, :sub_category_created_by, :sub_category_updated_by
            )
			";

			$object->execute($data);

			$success = '<div class="alert alert-success">Sub Category Added in <b>'.$object->Get_category_name($_POST["category_id"]).'</b> Category</div>';
		}

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}   // 2. Add Action Ends

// 3. Fetch Single Action Starts
	if($_POST["action"] == 'fetch_single')
	{
		$object->query = "
		SELECT * FROM sub_category_wus 
		WHERE sub_category_id = '".$_POST["sub_category_id"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['category_id']              	= $row['category_id'];
			$data['sub_category_name']          = $row['sub_category_name'];
			$data['sub_category_description']   = $row['sub_category_description'];
		}

		echo json_encode($data);
	}   // 3. Fetch Single Action Ends

// 4. Edit Action Starts
	if($_POST["action"] == 'Edit')
	{
		$error = '';

		$success = '';

		$data = array(
			':category_id'			=>	$_POST["category_id"],
			':sub_category_name'	=>	$_POST["sub_category_name"],
			':sub_category_id'		=>	$_POST['hidden_id']
		);

		$object->query = "
		SELECT * FROM sub_category_wus 
		WHERE category_id = :category_id 
		AND sub_category_name = :sub_category_name 
		AND sub_category_id != :sub_category_id
		";
		// print_r(var_dump($object));
		$object->execute($data);

		if($object->row_count() > 1)
		{
			$error = '<div class="alert alert-danger">Sub Category Already Exists in <b>'.$object->Get_category_name($_POST["category_id"]).'</b> Category</div>';
		}
		else
		{

			$data = array(
				':category_id'			        =>	$object->clean_input($_POST["category_id"]),
				':sub_category_name'	        =>	$object->clean_input($_POST["sub_category_name"]),
				':sub_category_description'	    =>	$object->clean_input($_POST["sub_category_description"]),
				// ':sub_category_status'	        =>	'Enable',
				// ':sub_category_created_on'		=>	$object->$_POST["sub_category_created_on"],
                // ':sub_category_created_by'		=>	$object->Get_user_name($_SESSION['user_id']),
				// ':sub_category_updated_on'		=>	$object->now,
				':sub_category_updated_by'		=>	$object->clean_input($_SESSION['user_id'])
			);

			$object->query = "
			UPDATE sub_category_wus 
			SET category_id = :category_id, 
			sub_category_name = :sub_category_name, 
			sub_category_description = :sub_category_description, 
			sub_category_updated_by = :sub_category_updated_by
			WHERE sub_category_id = '".$_POST['hidden_id']."'
			";

			$object->execute($data);

			$success = '<div class="alert alert-success">Sub Category Data Updated in <b>'.$object->Get_category_name($_POST["category_id"]).'</b> Category</div>';
			
		}

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}   // 4. Edit Action Ends

// 5. Change Status Action Starts
	if($_POST["action"] == 'change_status')
	{
		$data = array(
			':sub_category_status'		=>	$_POST['next_status']
		);

		$object->query = "
		UPDATE sub_category_wus 
		SET sub_category_status = :sub_category_status 
		WHERE sub_category_id = '".$_POST["id"]."'
		";

		$object->execute($data);

		echo '<div class="alert alert-success">Sub Category Status change to '.$_POST['next_status'].'</div>';
	}   // 5. Change Status Action Ends

// 6. Delete Action Starts
	if($_POST["action"] == 'delete')
	{
		$object->query = "
		DELETE FROM sub_category_wus 
		WHERE sub_category_id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">Sub Category Data Deleted</div>';
	}   // 6. Delete Action Ends

}   // List of Actions for Sub Category Ends

?>