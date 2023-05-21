<?php

// user/wus.php

// Most important file 

// Class wus starts
class wus 
{
    // general variable declarations starts
    public  $base_url = 'http://localhost/wus/';
    public  $connect;
    public  $query;
    public  $statement;
    public  $now;
    // general variable declarations ends

// GENERAL FUNCTIONS STARTS
// 1. Construct starts
    function __construct()
    {
        $this->connect = new PDO("mysql:host=localhost;dbname=wus", "root", "");

        if (session_start() == 'True') {
            # code...
        } else {
            # code...
            session_start();
        }

        $this->now = date("d-m-Y H:i:s", STRTOTIME(date("h:i:sa")));
    }   // Construct ends

// 2. Function execute starts
    function execute($data = null)
    {

        $this->statement = $this->connect->prepare($this->query);

        if ($data) 
        {
            $this->statement->execute($data);
        } 
        else 
        {
            $this->statement->execute();
        }
        
    }   // Function execute ends

// 3. Function get result starts
    function get_result()
    {
        return $this->connect->query($this->query, PDO::FETCH_ASSOC);
    }   // Function get result ends

// 4. Function row count starts
    function row_count()
    {
        return $this->statement->rowCount();
    }   // Function row count ends

// 5. Function statement result starts
    function statement_result()
    {
        return $this->statement->fetchAll();
    }   // Function statement result ends

// 6. Function is_login starts
    function is_login()
    {
        if (isset($_SESSION['user_id'])) 
        {
            return true;
        }
        else {
            return false;
        }
    }   // Function is_login ends

// 7. Function is_master_user starts
    function is_master_user()
    {
        if (isset($_SESSION["user_type"])) 
        {
            if ($_SESSION["user_type"] == 'Master') 
            {
                return true;
            }
            return false;
        }
        return false;
    }   // Function is_master_user ends

// 8. Function is_staff_user starts
    function is_staff_user()
    {
        if (isset($_SESSION["user_type"])) 
        {
            if ($_SESSION["user_type"] == 'Staff') 
            {
                return true;
            }
            return false;
        }
        return false;
    }   // Function is_staff_user ends

// 9. Function is_teacher_user starts
    function is_teacher_user()
    {
        if (isset($_SESSION["user_type"])) 
        {
            if ($_SESSION["user_type"] == 'Teacher') 
            {
                return true;
            }
            return false;
        }
        return false;
    }   // Function is_teacher_user ends

// 10. Function is_student_user starts
    function is_student_user()
    {
        if (isset($_SESSION["user_type"])) 
        {
            if ($_SESSION["user_type"] == 'Student') 
            {
                return true;
            }
            return false;
        }
        return false;
    }   // Function is_teacher_user ends

// 11. Function clean_input starts
    function clean_input($string)
    {
        $string = trim($string);
        $string = stripslashes($string);
        $string = htmlspecialchars($string);
        return $string;
    }   // Function clean_input ends
// GENERAL FUNCTIONS ENDS

// Get names from different tables starts 

// 1. Get_category_name

    function Get_category_name($category_id)
    {
        $this->query = "
        SELECT category_name FROM category_wus
        WHERE category_id = '$category_id'
        ";
        
        $result = $this->get_result();
        
        foreach ($result as $row) 
        {
            return  $row["category_name"];
        }
    }
// 2. Get_sub_category_name

    function Get_sub_category_name($sub_category_id)
    {
        $this->query = "
        SELECT sub_category_name FROM sub_category_wus
        WHERE sub_category_id = '$sub_category_id'
        ";
        
        $result = $this->get_result();
        
        foreach ($result as $row) 
        {
            return  $row["sub_category_name"];
        }
    }

// 3. Get_course_name

    function Get_course_name($course_id)
    {
        $this->query = "
        SELECT course_name FROM course_wus
        WHERE course_id = '$course_id'
        ";
    
        $result = $this->get_result();
    
        foreach ($result as $row) 
        {
            return  $row["course_name"];
        }
    }

// 4. Get_module_name

    function Get_module_name($module_id)
    {
        # code...
        $this->query = "
        SELECT module_name FROM module_wus
        WHERE module_id = '$module_id'
        ";
    
        $result = $this->get_result();
    
        foreach ($result as $row) 
        {
            return  $row["module_name"];
        }
    }

// 5. Get_material_name

    function Get_material_name($material_id)
    {
        $this->query = "
        SELECT material_name FROM material_wus
        WHERE material_id = '$material_id'
        ";
        
        $result = $this->get_result();
        
        foreach ($result as $row) 
        {
            return  $row["material_name"];
        }
    }
  
// 6. Get_user_name

    function Get_user_name($user_id)
    {
        $this->query = "
        SELECT user_name FROM user_wus
        WHERE user_id = '$user_id'
        ";
    
        $result = $this->get_result();
    
        foreach ($result as $row) 
        {
            return  $row["user_name"];
        }
    }
// 7. Get_staff_name

    function Get_staff_name($user_id)
    {
        $this->query = "
        SELECT user_name FROM user_wus
        WHERE user_id = '$user_id'
        AND user_type = 'Staff'
        ";
    
        $result = $this->get_result();
    
        foreach ($result as $row) 
        {
            return  $row["user_name"];
        }
    }
// 8. Get_teacher_name

    function Get_teacher_name($user_id)
    {
        $this->query = "
        SELECT user_name FROM user_wus
        WHERE user_id = '$user_id'
        AND user_type = 'Teacher'
        ";
    
        $result = $this->get_result();
    
        foreach ($result as $row) 
        {
            return  $row["user_name"];
        }
    }
// 9. Get_student_name

    function Get_student_name($user_id)
    {
        $this->query = "
        SELECT user_name FROM user_wus
        WHERE user_id = '$user_id'
        AND user_type = 'Student'
        ";
    
        $result = $this->get_result();
    
        foreach ($result as $row) 
        {
            return  $row["user_name"];
        }
    }

// 10. Get_certificate_name

    function Get_certificate_name($certificate_id)
    {
        $this->query = "
        SELECT certificate_name FROM certificate_wus
        WHERE certificate_id = '$certificate_id'
        ";

        $result = $this->get_result();

        foreach ($result as $row) 
        {
            return  $row["certificate_name"];
        }
    }

// Get names from different tables ends 


// Get total count from different tables starts

// 1. get_total_category

    function get_total_category()
    {
        $this->query = "
        SELECT COUNT(category_id) as Total
        FROM category_wus
        where category_status = 'Enable'
        ";

        $result = $this->get_result();

        // Foreach starts
        foreach ($result as $row) 
        {
            return $row["Total"];
        }   // End foreach
    }

// 2. get_total_sub_category

    function get_total_sub_category()
    {
        $this->query = "
        SELECT COUNT(sub_category_id) as Total
        FROM sub_category_wus
        where sub_category_status = 'Enable'
        ";

        $result = $this->get_result();

        // Foreach starts
        foreach ($result as $row) 
        {
            return $row["Total"];
        }   // End foreach
    }

// 3.a get_total_course

    function get_total_course()
    {
        $this->query = "
        SELECT COUNT(course_id) as Total
        FROM course_wus
        where course_status = 'Enable'
        ";

        $result = $this->get_result();

        // Foreach starts
        foreach ($result as $row) 
        {
            return $row["Total"];
        }   // End foreach
    }

// 3.b get_my_total_course

    function get_my_total_course($user)
    {
        $this->query = "
        SELECT COUNT(course_id) as Total
        FROM course_wus
        WHERE course_status = 'Enable'
        AND course_added_by	 = $user
        ";

        $result = $this->get_result();

        // Foreach starts
        foreach ($result as $row) 
        {
            return $row["Total"];
        }   // End foreach
    }

// 4.a get_total_module

    function get_total_module()
    {
        $this->query = "
        SELECT COUNT(module_id) as Total
        FROM module_wus
        where module_status = 'Enable'
        ";

        $result = $this->get_result();
        // Foreach starts
        foreach ($result as $row) 
        {
            return $row["Total"];
        }   // End foreach
    }

// 4.b get_my_total_module

    function get_my_total_module($user)
    {
        $this->query = "
        SELECT COUNT(module_id) as Total
        FROM module_wus
        where module_status = 'Enable'
        AND module_added_by	 = $user
        ";

        $result = $this->get_result();
        // Foreach starts
        foreach ($result as $row) 
        {
            return $row["Total"];
        }   // End foreach
    }

// 5.a get_total_material

    function get_total_material()
    {
        $this->query = "
        SELECT COUNT(material_id) as Total
        FROM material_wus
        where material_status = 'Enable'
        ";

        $result = $this->get_result();
        // Foreach starts
        foreach ($result as $row) 
        {
            return $row["Total"];
        }   // End foreach
    }

// 5.b get_my_total_material

    function get_my_total_material($user)
    {
        $this->query = "
        SELECT COUNT(material_id) as Total
        FROM material_wus
        where material_status = 'Enable'
        AND material_added_by	 = $user
        ";

        $result = $this->get_result();
        // Foreach starts
        foreach ($result as $row) 
        {
            return $row["Total"];
        }   // End foreach
    }

// 6. get_total_user

    function get_total_user()
    {
        $this->query = "
        SELECT COUNT(user_id) as Total
        FROM user_wus
        where user_status = 'Enable'
        ";

        $result = $this->get_result();
        // Foreach starts
        foreach ($result as $row) 
        {
            return $row["Total"];
        }   // End foreach
    }

// 7.a. get_total_student

    function get_total_student()
    {
        $this->query = "
        SELECT COUNT(user_id) as Total
        FROM user_wus
        where user_status = 'Enable'
        AND user_type = 'Student'
        ";

        $result = $this->get_result();
        // Foreach starts
        foreach ($result as $row) 
        {
            return $row["Total"];
        }   // End foreach
    }

// 7.b. get_my_total_student

    function get_my_total_student($user)
    {
        $this->query = "
        SELECT COUNT(enrollment_wus.user_id) as Total
        FROM ((enrollment_wus 
		INNER JOIN course_wus ON course_wus.course_id = enrollment_wus.course_id)
		INNER JOIN user_wus ON user_wus.user_id = enrollment_wus.user_id)
        WHERE enrollment_status = 'Enable'
        AND user_type = 'Student'
        AND course_added_by = $user
        ";

        $result = $this->get_result();
        // Foreach starts
        foreach ($result as $row) 
        {
            return $row["Total"];
        }   // End foreach
    }

// 8. get_total_staff

    function get_total_staff()
    {
        $this->query = "
        SELECT COUNT(user_id) as Total
        FROM user_wus
        WHERE user_status = 'Enable'
        AND user_type = 'Staff'
        ";

        $result = $this->get_result();
        // Foreach starts
        foreach ($result as $row) 
        {
            return $row["Total"];
        }   // End foreach
    }

// 9. get_total_teacher

    function get_total_teacher()
    {
        $this->query = "
        SELECT COUNT(user_id) as Total
        FROM user_wus
        WHERE user_status = 'Enable'
        AND user_type = 'Teacher'
        ";

        $result = $this->get_result();
        // Foreach starts
        foreach ($result as $row) 
        {
            return $row["Total"];
        }   // End foreach
    }

// 10. get_my_total_enrollment

    function get_my_total_enrollment($user)
    {
        $this->query = "
        SELECT COUNT(enrollment_id) as Total
        FROM enrollment_wus
        WHERE enrollment_status = 'Enable'
        AND user_id	 = $user
        ";

        $result = $this->get_result();

        // Foreach starts
        foreach ($result as $row) 
        {
            return $row["Total"];
        }   // End foreach
    }

// Get total count from different tables ends

}   // Class wus ends
?>