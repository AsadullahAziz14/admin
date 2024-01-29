<?php 

//Require Vars, DB Connection and Function Files
require_once('dbsetting/lms_vars_config.php');
require_once('dbsetting/classdbconection.php');
$dblms = new dblms();
require_once('functions/login_func.php');
require_once('functions/functions.php');

//User Authentication
checkCpanelLMSALogin();

//If User Type isn't Admin
if(($_SESSION['userlogininfo']['LOGINAFOR'] != 1)) {
	//Redirects to Index
	header('location: index.php');

//Check If User has rights
} else if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 8) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 9) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '191')) {
	
	require_once("include/Staffs/inventory/demand/query.php");
	require_once("include/header.php");

	$sql2 			= '';
	$sqlstring		= "";
	$srch			= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
	$status_srch	= (isset($_GET['status_srch']) && $_GET['status_srch'] != '') ? $_GET['status_srch'] : '';
	$faculty		= (isset($_GET['faculty']) && $_GET['faculty'] != '') ? $_GET['faculty'] : '';
	$dept			= (isset($_GET['dept']) && $_GET['dept'] != '') ? $_GET['dept'] : '';
	$liberalArts	= (isset($_GET['la']) && $_GET['la'] != '') ? $_GET['la'] : '';

	if(($srch)) { 
		$sql2 		.= " AND (demand_code LIKE '%".$srch."%')"; 
		$sqlstring	.= "&srch=".$srch."";
	}
    if(($status_srch)) { 
		$sql2 		.= " AND demand_status = '".$status_srch."'"; 
		$sqlstring	.= "&status_srch=".$status_srch."";
	}

	if((($_SESSION['userlogininfo']['LOGINTYPE'] == 8) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 9))) { 
		$sql2 		.= " AND demand_status = 2"; 
	}
				echo '
				<title>Manage Demands - '.TITLE_HEADER.'</title>
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
										<input type="text" class="form-control" name="srch" placeholder="Search by Item Name" style="width:250px;">
									</div>

									<button type="submit" class="btn btn-primary">Search</button>
									<a href="inventory-demand.php" class="btn btn-purple"><i class="icon-list"></i> All</a>';
									if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '191', 'add' => '1'))) { 
										echo ' <a class="btn btn-success" href="inventory-demand.php?view=add"><i class="icon-plus"></i> Add Demand</a>';
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
							<div class="col-lg-12">
									<div class="widget">
										<div class="widget-content">';
											if(isset($_SESSION['msg'])) { 
												echo $_SESSION['msg']['status'];
												unset($_SESSION['msg']);
											}
											require_once("include/Staffs/inventory/demand/list.php");
											require_once("include/Staffs/inventory/demand/add.php");
											require_once("include/Staffs/inventory/demand/edit.php");
										echo'
									</div>
								</div>
							</div>
						</div>
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
		require_once("include/Staffs/inventory/demand/forward.php");
		echo '
		<!--WI_IFRAME_Start_MODAL-->
		<div class="row">
			<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<form action="" method="post">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
								<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
								<h4 class="modal-title" id="modal-iframe-title">Delete Activity</h4>
								<div class="clearfix"></div>
							</div>
							<div class="modal-body">
								<h2>Are you sure to delete?</h2>
								<input type="hidden" id="deleted_id" name="deleted_id" value="">
								<input type="hidden" id="deleted_val" name="deleted_val" value="">
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
								<button type="submit" id="delete_activity" name="delete_activity" class="btn btn-danger">Delete</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

		<script src="js/jquery.validate.js"></script>
		<script type="text/javascript" src="js/summer.js"></script>
		<script type="text/javascript" src="js/ebro_form_validate.js"></script>

		<script type="text/javascript" src="js/custom/all-vendors.js"></script>
		<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>

		<script>
			//USED BY: All date picking forms
			$(document).ready(function(){
				$(".pickadate").datepicker({
					format: "yyyy-mm-dd",
					language: "lang",
					autoclose: true,
					todayHighlight: true
				});	
			});
		</script>

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

















