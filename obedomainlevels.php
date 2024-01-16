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
} else if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '19')) {   
	require_once("include/header.php");
    require_once("include/Staffs/obe/domainlevels/query.php");
		
	$sql2 						= '';
	$sqlstring					= "";
	$srch						= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
	$domain_level_name_srch		= (isset($_GET['domain_level_name_srch']) && $_GET['domain_level_name_srch'] != '') ? $_GET['domain_level_name_srch'] : '';
	$status_srch				= (isset($_GET['status_srch']) && $_GET['status_srch'] != '') ? $_GET['status_srch'] : '';
	$faculty					= (isset($_GET['faculty']) && $_GET['faculty'] != '') ? $_GET['faculty'] : '';
	$dept						= (isset($_GET['dept']) && $_GET['dept'] != '') ? $_GET['dept'] : '';
	$liberalArts				= (isset($_GET['la']) && $_GET['la'] != '') ? $_GET['la'] : '';

	if(($srch)) { 
		$sql2 		.= " AND (".OBE_DOMAINS.".domain_name_code LIKE '%".$srch."%')"; 
		$sqlstring	.= "&srch=".$srch."";
	}
	if(($domain_level_name_srch)) { 
		$sql2 		.= " AND ".OBE_DOMAINS.".domain_level_name = '".$domain_level_name_srch."'"; 
		$sqlstring	.= "&domain_level_name_srch=".$domain_level_name_srch."";
	}
    if(($status_srch)) { 
		$sql2 		.= " AND ".OBE_DOMAINS.".domain_level_status = '".$status_srch."'"; 
		$sqlstring	.= "&status_srch=".$status_srch."";
	}
			echo '
			<title>Manage Domains - '.TITLE_HEADER.'</title>
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
									<input type="text" class="form-control" name="srch" placeholder="Domain Name" style="width:250px;">
								</div>
								<div class="form-group">
									<input type="text" class="form-control" name="domain_level_name_srch" placeholder="Domain Level Name" style="width:250px;">
								</div>
								<div class="form-group">
									<select id="list-status" data-placeholder="Status" name="status_srch" style="width:auto;">
										<option></option>';
										foreach($status as $valueStatus) { 
											echo '<option value="'.$valueStatus['id'].'">'.$valueStatus['name'].'</option>';
										}
									echo '
									</select>
								</div>
								<button type="submit" class="btn btn-primary">Search</button>
								<a href="obedomainlevels.php" class="btn btn-purple"><i class="icon-list"></i> All</a>';
								if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'add' => '1'))) { 
									echo '<button data-toggle="modal" class="btn btn-success" href="#addNewDOMAINModal"><i class="icon-plus"></i>Add Domain</button>';
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

								require_once("include/Staffs/obe/domainlevels/list.php");

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
	//------------------------------------------------
		require_once("include/Staffs/obe/domainlevels/add.php");
		require_once("include/Staffs/obe/domainlevels/edit.php");
	//------------------------------------------------
	echo '
	<!--WI_IFRAME_MODAL-->
	<div class="row">
		<div id="modalIframe" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
						<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
						<h4 class="modal-title" id="modal-iframe-title"> Edit</h4>
						<div class="clearfix"></div>
					</div>
					<div class="modal-body">
						<iframe frameborder="0" class="slimScrollBarModal----"></iframe>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--WI_IFRAME_MODAL-->
	<!--JS_SELECT_LISTS-->
	<script>
		$("#list-program").select2({
			allowClear: true
		});
		$("#list-status").select2({
			allowClear: true
		});
		$("#domain_level_number").select2({
			allowClear: true
		});
		$("#domain_level_number_edit").select2({
			allowClear: true
		});
		$("#id_domain_level").select2({
			allowClear: true
		});
		$("#id_domain_level_edit").select2({
			allowClear: true
		});
		$("#domain_level_status").select2({
			allowClear: true
		});
		$("#domain_level_status_edit").select2({
			allowClear: true
		});
		$("#id_cat").select2({
			allowClear: true
		});
		$("#id_cat_edit").select2({
			allowClear: true
		});
		$("#prg_timing").select2({
			allowClear: true
		});
		$("#prg_timing_edit").select2({
			allowClear: true
		});
		$("#prg_classdays").select2({
			allowClear: true
		});
		$("#prg_classdays_edit").select2({
			allowClear: true
		});
		$("#prg_liberalarts").select2({
			allowClear: true
		});
		$("#prg_liberalarts_edit").select2({
			allowClear: true
		});
	</script>
	<!--JS_SELECT_LISTS-->

	<script type="text/javascript" src="js/data.js"></script>
	<script type="text/javascript" src="js/custom/all-vendors.js"></script>
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
?>