<?php

// user/student_action.php

include('wus.php');

$object = new wus();

//  List of Actions Starts
if(isset($_POST["action"]))
{
    if($_POST["action"] == 'Add')
        {
            $error = '';

            $success = '';

            $data = array(
                ':user_email'	=>	$_POST["user_email"]
            );

            $object->query = "
            SELECT * FROM user_wus 
            WHERE user_email = :user_email
            ";

            $object->execute($data);

            if($object->row_count() > 0)
            {
                $error = '<div class="alert alert-danger">User Email Already Exists</div>';
            }
            else
            {
                // $user_image = '';
                // if($_FILES["user_image"]["name"] != '')
                // {
                // 	$user_image = upload_image();
                // }
                // else
                // {
                //  $user_image = make_avatar(strtoupper($_POST["user_name"][0]));
                // }

                $data = array(
                    ':user_name'		=>	$_POST["user_name"],
                    ':user_contact_no'	=>	$_POST["user_contact_no"],
                    ':user_email'		=>	$_POST["user_email"],
                    // ':user_password'	=>	md5(uniqid($_POST["user_password"])),
                    ':user_password'	=>	$_POST["user_password"],
                    ':user_type'		=>	'Student',
                    ':user_status'		=>	'Enable',
                    ':user_created_by'	=>	'1',
                    ':user_updated_by'	=>	'1'
                );

                $object->query = "
                INSERT INTO user_wus (
                    user_name, 
                    user_contact_no, 
                    user_email, 
                    user_password, 
                    user_type, 
                    user_status, 
                    user_created_by, 
                    user_updated_by) 
                VALUES (
                    :user_name, 
                    :user_contact_no, 
                    :user_email, 
                    :user_password, 
                    :user_type, 
                    :user_status, 
                    :user_created_by, 
                    :user_updated_by
                    )
                ";

                $object->execute($data);

                // print_r(var_dump($object));

                $success = '<div class="alert alert-success">User <b>'.$_POST["user_name"].'</b> Added.<br>Please Login Now</div>';
            }

            $output = array(
                'error'		=>	$error,
                'success'	=>	$success
            );

            echo json_encode($output);

        }
}
?> 