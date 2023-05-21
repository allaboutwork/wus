<?php

// user/dashboard.php

include('wus.php');

$object = new wus();

if(!$object->is_login())
{
    header("location:".$object->base_url."user");
}

// if($object->is_master_user())
// {
//     header("location:".$object->base_url."user/index.php");
// }

if($object->is_staff_user())
{
    header("location:".$object->base_url."user/index.php");
}

if($object->is_teacher_user())
{
    header("location:".$object->base_url."teacher/index.php");
}

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
		if($object->is_master_user())
		{
		?>
		<!-- 1. Total Category Publish Starts -->
		<div class="col mb-6">
			<div class="card border-bottom-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-m font-weight-bold text-primary text-uppercase mb-1">Total Category Publish</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_category(); ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>	<!-- Total Category Publish Ends -->

		<!-- 2. Total Sub-Category Starts -->
		<div class="col mb-6">
			<div class="card border-bottom-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-m font-weight-bold text-primary text-uppercase mb-1">Total Sub-Category</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_sub_category();?></div>
						</div>
					</div>
				</div>
			</div>
		</div>	<!-- Total Sub-Category Ends -->

		<!-- 3. Total Courses Starts -->
		<div class="col mb-6">
			<div class="card border-bottom-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-m font-weight-bold text-primary text-uppercase mb-1">Total Courses</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_course(); ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>	<!-- Total Courses Ends -->
		
		<!-- 4. Total Instructors Starts -->
		<div class="col mb-6">
			<div class="card border-bottom-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-m font-weight-bold text-primary text-uppercase mb-1">
								Total Teachers</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800">
								<?php
								 echo $object->get_total_teacher();
								?>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
		<!-- Total Instructors Ends -->

		<!-- 5. Total Students Starts -->
		<div class="col mb-6">
			<div class="card border-bottom-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-m font-weight-bold text-primary text-uppercase mb-1">Total Students</div>
							<div class="row no-gutters align-items-center">
								<div class="col-auto">
									<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $object->get_total_student(); ?></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	<!-- Total Students Ends -->

		<!-- 6. Total Staff Starts -->
		<div class="col mb-6">
			<div class="card border-bottom-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-m font-weight-bold text-primary text-uppercase mb-1">Total Staff</div>
							<div class="row no-gutters align-items-center">
								<div class="col-auto">
									<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
										<?php echo $object->get_total_staff(); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
		<!-- Total Staff Ends -->

	<?php
	}
	?>
	</div>

<?php
include('footer.php');
?>