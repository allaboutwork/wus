<?php

include('wus.php');

$object = new wus();

if(!$object->is_login())
{
    header("location:".$object->base_url."teacher");
}

if($object->is_master_user())
{
    header("location:".$object->base_url."user/index.php");
}

if($object->is_staff_user())
{
    header("location:".$object->base_url."user/index.php");
}

// if($object->is_teacher_user())
// {
//     header("location:".$object->base_url."teacher/index.php");
// }

if($object->is_student_user())
{
    header("location:".$object->base_url."student/index.php");
}

include('header.php');

?>

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

	<!-- Content Row -->
	<div class="row row-cols-1 row-cols-md-3 g-4">
		<?php
		if($object->is_teacher_user())
		{
		?>

		<!-- 1. Total Courses Starts -->
		<div class="col mb-6">
			<div class="card border-bottom-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-m font-weight-bold text-primary text-uppercase mb-1">My Total Courses</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_my_total_course($_SESSION['user_id']); ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>	<!-- Total Courses Ends -->
		
		<!-- 2. Total Module Starts -->
		<div class="col mb-6">
			<div class="card border-bottom-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-m font-weight-bold text-primary text-uppercase mb-1">My Total Module</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_my_total_module($_SESSION['user_id']); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	<!-- Total Courses Ends -->
		
		<!-- 3. Total Material Starts -->
		<div class="col mb-6">
			<div class="card border-bottom-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-m font-weight-bold text-primary text-uppercase mb-1">My Total Material</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_my_total_material($_SESSION['user_id']); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	<!-- Total Courses Ends -->
		
		<!-- 5. Total Students Starts -->
		<div class="col mb-6">
			<div class="card border-bottom-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-m font-weight-bold text-primary text-uppercase mb-1">My Total Students</div>
							<div class="row no-gutters align-items-center">
								<div class="col-auto">
									<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $object->get_my_total_student($_SESSION['user_id']); ?></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	<!-- Total Students Ends -->

	<?php
	}
	?>
	</div>

<?php
include('footer.php');
?>