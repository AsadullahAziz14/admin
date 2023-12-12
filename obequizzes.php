<?php
//Require Vars, DB Connection and Function Files
require_once('dbsetting/lms_vars_config.php');
require_once('dbsetting/classdbconection.php');
$dblms = new dblms();
require_once('functions/login_func.php');
require_once('functions/functions.php');

//User Authentication
checkCpanelLMSALogin();

//If User Type isn't Staff
if(($_SESSION['userlogininfo']['LOGINAFOR'] != 1)) { 

	//Redirects to Index
	header('location: index.php');

//Check If User has rights
} else if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '19')) 
{   
	include_once("include/header.php");
    include_once("include/Staffs/obe/quizzes/query.php");
			
	$sql2 			= '';
	$sqlstring		= "";
	$srch			= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
	$status_srch	= (isset($_GET['status_srch']) && $_GET['status_srch'] != '') ? $_GET['status_srch'] : '';
	$faculty		= (isset($_GET['faculty']) && $_GET['faculty'] != '') ? $_GET['faculty'] : '';
	$dept			= (isset($_GET['dept']) && $_GET['dept'] != '') ? $_GET['dept'] : '';
	$liberalArts	= (isset($_GET['la']) && $_GET['la'] != '') ? $_GET['la'] : '';

	if(($srch)) { 
		$sql2 		.= " AND (".OBE_QUIZZES.".id_course LIKE '%".$srch."%')"; 
		$sqlstring	.= "&srch=".$srch."";
	}
    if(($status_srch)) { 
		$sql2 		.= " AND ".OBE_QUIZZES.".quiz_status = '".$status_srch."'"; 
		$sqlstring	.= "&status_srch=".$status_srch."";
	}

	echo '
	<title>Manage Quizzes - '.TITLE_HEADER.'</title>
	<!-- Matter -->
	<div class="matter">
	<!--WI_CLIENTS_SEARCH-->
	<div class="navbar navbar-default" role="navigation">
	<!-- .container-fluid -->
	<div class="container-fluid">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle Navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
	</div>
	<!-- .navbar-collapse -->
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	<form class="navbar-form navbar-left form-small" action="" method="get">
		<div class="form-group">
			<input type="text" class="form-control" name="srch" placeholder="Course" style="width:250px;">
		</div>
		<div class="form-group">
			<select id="list-status" data-placeholder="Status" name="status_srch" style="width:auto;">
				<option>Select Status</option>';
				foreach($status as $valueStatus) { 
					echo '<option value="'.$valueStatus['id'].'">'.$valueStatus['name'].'</option>';
				}
			echo '
			</select>
		</div>
		<button type="submit" class="btn btn-primary">Search</button>
		<a href="obequizzes.php" class="btn btn-purple"><i class="icon-list"></i> All</a>';
		if((($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'add' => '1')))) { 
			echo ' <a data-toggle="modal" class="btn btn-success" href="obequizzes.php?view=add"><i class="icon-plus"></i>Add Quiz</a>';
		}
	echo '
	</form>
	</div>
	<!-- /.navbar-collapse -->
	</div>
	<!-- /.container-fluid -->
	</div>
	<!--WI_CLIENTS_SEARCH END-->
	<div class="container">
	<!--WI_MY_TASKS_TABLE-->
	<div class="row fullscreen-mode">
	<div class="col-md-12">
	<div class="widget">
	<div class="widget-content">';

	if(isset($_SESSION['msg'])) { 
		echo $_SESSION['msg']['status'];
		unset($_SESSION['msg']);
	} 

	include_once("include/Staffs/obe/quizzes/list.php");
	include_once("include/Staffs/obe/quizzes/add.php");
	include_once("include/Staffs/obe/quizzes/edit.php");
	include_once("include/Staffs/obe/quizzes/result/add.php");
	include_once("include/Staffs/obe/quizzes//result/edit.php");

	echo '
	</div>
	</div>
	</div>
	</div>
	<!--WI_MY_TASKS_TABLE-->
	<!--WI_NOTIFICATION-->
	</div>
	</div>
	<!-- Matter ends -->
	</div>
	<!-- Mainbar ends -->
	<div class="clearfix"></div>
	</div>
	<!-- Content ends -->
	<!-- Footer starts -->
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p class="copy">Powered by: | <a href="'.COPY_RIGHTS_URL.'" target="_blank">'.COPY_RIGHTS.'</a> </p>
				</div>
			</div>
		</div>
	</footer>
	<!-- Footer ends -->

	<!-- Scroll to top -->
	<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>';
	echo '


	<script type="text/javascript" src="js/data.js"></script>
	<script type="text/javascript" src="js/custom/all-vendors.js"></script>
	<script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js"></script>
	<script type="text/javascript">
		$(function () {
			$(".footable").footable();
		});
	</script>
	<script type="text/javascript" src="js/custom/custom.js"></script>
	<script type="text/javascript" src="js/custom/custom.general.js"></script>
	</body>
	</html>';
}
?>