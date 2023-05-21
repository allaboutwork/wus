<!-- user/header.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <title>WakeUpStream | An Online Education Platform</title>

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="../assets/vendor/parsley/parsley.css"/>
    <!-- <link rel="stylesheet" type="text/css" href="../assets/vendor/bootstrap/css/bootstrap.min.css"/> -->
    <link rel="stylesheet" type="text/css" href="../assets/vendor/bootstrap-select/bootstrap-select.min.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/vendor/bootstrap-icons/bootstrap-icons.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/vendor/datepicker/bootstrap-datepicker.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/vendor/fontawesome-free/css/all.min.css"/>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    
                </div>
                
            <?php
            
            if($object->is_master_user())
            {
            ?>
                <div class="sidebar-brand-text mx-3">Master User</div>
            
            <?php
            }
            ?>

            <?php
        
            if($object->is_staff_user())
            {
            ?>
                <div class="sidebar-brand-text mx-3">Staff User</div>
            
            <?php
            }
            ?>
        
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item">
            <a class="nav-link" href="profile.php">
                <i class="fas fa-user"></i>
                <span>Profile</span></a>
            </li>

            <!-- Nav Item - Dashboard -->
            <?php
            if($object->is_master_user())
            {
            ?>
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-chart-bar"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="category.php">
                    <i class="fas fa-list"></i>
                    <span>Categories</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="sub_category.php">
                    <i class="fas fa-list"></i>
                    <span>Sub categories</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="course.php">
                    <i class="fas fa-video"></i>
                    <span>Courses</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="teacher.php">
                    <i class="fas fa-user"></i>
                    <span>Teachers</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="staff.php">
                    <i class="fas fa-user-tie"></i>
                    <span>Staff Members</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="student.php">
                    <i class="fas fa-user-graduate"></i>
                    <span>Students</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="enrollment.php">
                    <i class="fas fa-check-square"></i>
                    <span>Enrollments</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="certification.php">
                    <i class="fas fa-medal"></i>
                    <span>Certificates</span></a>
            </li>
            <?php
            }
            ?>

            <?php
            if($object->is_staff_user())
            {
            ?>
            <li class="nav-item">
                <a class="nav-link" href="course.php">
                    <i class="fas fa-video"></i>
                    <span>Courses</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="teacher.php">
                    <i class="fas fa-user"></i>
                    <span>Teachers</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="student.php">
                    <i class="fas fa-user-graduate"></i>
                    <span>Students</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="enrollment.php">
                    <i class="fas fa-check-square"></i>
                    <span>Enrollments</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="certification.php">
                    <i class="fas fa-medal"></i>
                    <span>Certificates</span></a>
            </li>
            <?php
            }
            ?>

            <li class="nav-item">
                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <!-- <i class="fas fa-right "></i> -->
                    <i class="fas fa-arrow-right"></i>
                    <span>Logout</span></a>
            </li>


            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0 " id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar Starts -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fas fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- <div class="topbar-divider d-none d-sm-block"></div> -->

                        <?php
                        $object->query = "
                        SELECT * FROM user_wus
                        WHERE user_id = '".$_SESSION['user_id']."'
                        ";

                        $user_result = $object->get_result();

                        $user_name = '';
                        $user_profile_image = '';
                        foreach($user_result as $row)
                        {
                            if($row['user_name'] != '')
                            {
                                $user_name = $row['user_name'];
                            }
                            else
                            {
                                $user_name = 'Master';
                            }

                            if($row['user_profile'] != '')
                            {
                                $user_profile_image = $row['user_profile'];
                            }
                            else
                            {
                                $user_profile_image = '../assets/image/general-user.png';
                            }
                        }
                        ?>

                        <!-- Nav Item - User Information -->
                        <!-- <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small" id="user_profile_name"><?php echo $user_name; ?></span>
                                <i class="fas fa-user"></i>
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            </a> -->
                            <!-- Dropdown - User Information -->
                            <!-- <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                    Logout
                                </a>
                            </div>
                        </li> -->

                    </ul>

                </nav>
                <!-- Topbar Ends-->

                <!-- Begin Page Content -->
                <div class="container-fluid">