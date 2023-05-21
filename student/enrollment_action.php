<?php

// student/enrollment_action.php

include('wus.php');

$object = new wus();

// List of Actions for enrollment Starts
if(isset($_POST["action"]))
{
//	1.a. Action Fetch Starts
	if($_POST["action"] == 'fetch')
	{
		$order_column = array(
								'enrollment_wus.enrollment_id', 
								'enrollment_wus.course_id', 
								'enrollment_wus.user_id', 
								'enrollment_wus.enrollment_status', 
								'progress_wus.progress_value'
							);

		$output = array();

		// $main_query = "
		// SELECT * FROM enrollment_wus ";
		
		$main_query = "
		SELECT * FROM enrollment_wus
		INNER JOIN progress_wus ON progress_wus.enrollment_id = enrollment_wus.enrollment_id
		WHERE enrollment_wus.user_id =  '".$_SESSION['user_id']."'
		";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'AND enrollment_wus.enrollment_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR enrollment_wus.course_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR enrollment_wus.user_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR enrollment_wus.enrollment_status LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR progress_wus.progress_value LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY enrollment_wus.enrollment_id ASC ';
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
			if($row["user_id"] === $_SESSION["user_id"])
			{
				$sub_array = array();
				$sub_array[] = $object->Get_course_name($row["course_id"]);
				$sub_array[] = html_entity_decode($row["progress_value"]);
				$sub_array[] = '<a href="continue.php?action=view&course_id='.$row["course_id"].'" class="btn btn-success btn-sm">Continue</a>';

				// $status = '';
				// if($row["enrollment_status"] == 'Enable')
				// {
				// 	$status = '<button type="button" name="status_button" class="btn btn-primary btn-sm status_button" data-id="'.$row["enrollment_id"].'" data-status="'.$row["enrollment_status"].'">Continue</button>';
				// }
				// else
				// {
				// 	$status = '<button type="button" name="status_button" class="btn btn-danger btn-sm status_button" data-id="'.$row["enrollment_id"].'" data-status="'.$row["enrollment_status"].'">Disable</button>';
				// }
				// $sub_array[] = $status;

				$sub_array[] = '
				<div align="center">
				<button type="button" name="delete_button" class="btn btn-danger btn-sm delete_button" data-id="'.$row["enrollment_id"].'">Unenroll</button>
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

	}	// 1.a.	Action Fetch Ends






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