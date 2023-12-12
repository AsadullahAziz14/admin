<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
	include_once("include/header.php");
//----------------------------------------
echo '<title>Manage Users '.TITLE_HEADER.'</title>
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
		<input type="text" class="form-control" name="srch" placeholder="User Name" >
	</div>
	<button type="submit" class="btn btn-primary">Search User</button>
	<a href="users.php" class="btn btn-purple"><i class="icon-list"></i> All</a>
	<button data-toggle="modal" class="btn btn-success" href="#addNewUsrModal"><i class="icon-plus"></i> Add User</button>
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
//--------------------------------------
if(isset($_POST['submit_usr'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".USERS." (
														status										,  
														name										, 
														phone										, 
														email										, 
														username									, 
														userpass									, 
														city										,
														id_added									,
														date_added 								
													)
	   										VALUES (
														'".cleanvars($_POST['status'])."'			,  
														'".cleanvars($_POST['name'])."'				, 
														'".cleanvars($_POST['phone'])."'			, 
														'".cleanvars($_POST['email'])."'			, 
														'".cleanvars($_POST['username'])."'			,
														'".md5(cleanvars($_POST['userpass']))."' 	, 
														'".cleanvars($_POST['city'])."'				, 
														'".cleanvars($_SESSION['LOGINIDA_SSS'])."'	,
														NOW()										
													)
						");
	if($sqllms) {
//--------------------------------------
		echo '<div id="infoupdated" class="alert-box success"><span>success: </span>Record added successfully.</div>';
//--------------------------------------
	}
}
//--------------------------------------
if(isset($_POST['submit_changes'])) { 
//------------------------------------------------
if(!empty($_POST['userpass_edit'])) {
	$sqllms  = $dblms->querylms("UPDATE ".USERS." SET userpass = '".md5(cleanvars($_POST['userpass_edit']))."' 
													WHERE id 	= '".cleanvars($_POST['id'])."'");
unset($sqllms);
}
//------------------------------------------------
	$sqllms  = $dblms->querylms("UPDATE ".USERS." SET status		 	= '".cleanvars($_POST['status_edit'])."'
													, name				= '".cleanvars($_POST['name_edit'])."'
													, phone				= '".cleanvars($_POST['phone_edit'])."'
													, email				= '".cleanvars($_POST['email_edit'])."'
													, username			= '".cleanvars($_POST['username_edit'])."'
													, city				= '".cleanvars($_POST['city_edit'])."'
													, id_modify			= '".cleanvars($_SESSION['LOGINIDA_SSS'])."' 
													, date_modify		= NOW() 
												WHERE id				= '".cleanvars($_POST['id'])."'");
	if($sqllms) {
//--------------------------------------
		echo '<div id="infoupdated" class="alert-box notice"><span>success: </span>Record update successfully.</div>';
//--------------------------------------
	}
unset($sqllms);
}
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT * FROM ".USERS."  WHERE id != ''  ORDER BY name ASC");
//--------------------------------------------------
if (mysql_num_rows($sqllms) > 0) {
//------------------------------------------------
echo '
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;"> Sr.#</th>
	<th style="font-weight:600;"> Name</th>
	<th style="font-weight:600;"> Login ID/ Email</th>
	<th style="font-weight:600;"> Phone #</th>
	<th style="font-weight:600;"> Email</th>
	<th style="font-weight:600;"> City</th>
	<th style="font-weight:600; text-align:center;"> Status</th>
	<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
while($rowstd = mysql_fetch_array($sqllms)) {
//------------------------------------------------
$status = get_status($rowstd['status']);
$srno++;
echo '
<tr>
	<td style="width:50px;">'.$srno.'</td>
	<td style="min-width:120px;"><a class="links-blue edit-adm-modal" data-toggle="modal" data-modal-window-title="Edit User" data-height="350" data-width="100%" data-adstats="'.$rowstd['status'].'" data-adcity="'.$rowstd['city'].'" data-adm-user="'.$rowstd['username'].'" data-adm-fullname="'.$rowstd['name'].'" data-adm-email="'.$rowstd['email'].'" data-adm-phone="'.$rowstd['phone'].'" data-adm-id="'.$rowstd['id'].'" data-target="#editAdmModal">'.$rowstd['name'].'</a> </td>
	<td>'.$rowstd['username'].'</td>
	<td>'.$rowstd['phone'].'</td>
	<td>'.$rowstd['email'].'</td>
	<td>'.$rowstd['city'].'</td>
	<td style="width:70px; text-align:center;">'.$status.'</td>
	<td style="text-align:center;"><a class="btn btn-xs btn-info edit-adm-modal" data-toggle="modal" data-modal-window-title="Edit User" data-height="350" data-width="100%" data-adstats="'.$rowstd['status'].'" data-adcity="'.$rowstd['city'].'" data-adm-user="'.$rowstd['username'].'" data-adm-fullname="'.$rowstd['name'].'" data-adm-email="'.$rowstd['email'].'" data-adm-phone="'.$rowstd['phone'].'" data-adm-id="'.$rowstd['id'].'" data-target="#editAdmModal"><i class="icon-pencil"></i></a>
		<button class="btn btn-xs btn-danger ajax-delete-record" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?" data-popconfirm-placement="left" data-mysql-record-id="2" data-mysql-record-id4="1" data-mysql-table-name="tasks" data-ajax-url=""> <i class="icon-trash"></i></button>
	</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}
//------------------------------------------------
echo '
</div>
</div>
</div>
</div>
<!--WI_MY_TASKS_TABLE-->
<!--WI_NOTIFICATION-->       
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
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="addNewUsrModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="addNewUsr" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add User Detail</h4>
</div>

<div class="modal-body">

   <div class="form-group">
		<label class="control-label req col-lg-12" style="width:auto;"><b>Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="name" name="name" required autofocus autocomplete="off">
		</div>
	</div>	

	<div class="col-sm-61">
		<div class="form-sep" style="margin-top:5px;">
			<label class="req">Login ID/ Email</label>
			<input type="text" class="form-control" id="username" name="username" required autocomplete="off">
		</div>
	</div>
	
	<div class="col-sm-61">
		<div class="form-sep" style="margin-top:5px;">
			<label class="req">Login Password</label>
			<input type="text" class="form-control" id="userpass" name="userpass" required autocomplete="off">
		</div> 
	</div>

	<div style="clear:both;"></div>	
	
	<div class="col-sm-61">
		<div class="form-sep" style="margin-top:5px;">
			<label>Email Address</label>
			<input type="email" class="form-control" id="email" name="email" autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form-sep" style="margin-top:5px;">
			<label>Phone No.</label>
			<input type="text" class="form-control" id="phone" name="phone" autocomplete="off">
		</div> 
	</div>
		
	<div style="clear:both;"></div>	
	
	<div class="col-sm-61">
		<div class="form-sep" style="margin-top:5px;">
			<label class="req">City</label>
			<input type="text" class="form-control" id="city" name="city" autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form-sep" style="margin-top:5px;">
			<label class="req">Status</label>
			<select id="status" name="status" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($ad_status as $itemadmstatus) {
				echo '<option value="'.$itemadmstatus['id'].'">'.$itemadmstatus['name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
		
	<div style="clear:both;"></div>	
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
		<input class="btn btn-primary" type="submit" value="Create User" id="submit_usr" name="submit_usr">
	</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->

<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div id="editAdmModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editUsr">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit User Detail</h4>
</div>

<div class="modal-body">

    <div class="form-group">
		<label class="control-label req col-lg-12" style="width:auto;"><b>Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="name_edit" name="name_edit" required autofocus autocomplete="off">
		</div>
	</div>	

	<div class="col-sm-61">
		<div class="form-sep" style="margin-top:5px;">
			<label class="req">Login ID/ Email</label>
			<input type="text" class="form-control" id="username_edit" name="username_edit" required autocomplete="off">
		</div>
	</div>
	
	<div class="col-sm-61">
		<div class="form-sep" style="margin-top:5px;">
			<label>Login Password</label>
			<input type="text" class="form-control" id="userpass_edit" name="userpass_edit" autocomplete="off">
		</div> 
	</div>

	<div style="clear:both;"></div>	
	
	<div class="col-sm-61">
		<div class="form-sep" style="margin-top:5px;">
			<label>Email Address</label>
			<input type="email" class="form-control" id="email_edit" name="email_edit" autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form-sep" style="margin-top:5px;">
			<label>Phone No.</label>
			<input type="text" class="form-control" id="phone_edit" name="phone_edit" autocomplete="off">
		</div> 
	</div>
		
	<div style="clear:both;"></div>	
	
	<div class="col-sm-61">
		<div class="form-sep" style="margin-top:5px;">
			<label class="req">City</label>
			<input type="text" class="form-control" id="city_edit" name="city_edit" autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form-sep" style="margin-top:5px;">
			<label class="req">Status</label>
			<select id="status_edit" name="status_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($ad_status as $itemadmstatus) {
				echo '<option value="'.$itemadmstatus['id'].'">'.$itemadmstatus['name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>
		
	<div style="clear:both;"></div>	

</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
	<input type="hidden" id="id_edit" name="id" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->

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
<!--WI_IFRAME_MODAL-->';
?>
<script type="text/javascript">
// close the div in 5 secs
window.setTimeout("closeHelpDiv();", 5000, 2500);

function closeHelpDiv(){
	document.getElementById("infoupdated").style.display=" none";
}
</script>
<!--JS_SELECT_LISTS-->
<script>

    $("#status").select2({
        allowClear: true
    });
	$("#status_edit").select2({
        allowClear: true
    });
	
	$("#adm_type").select2({
        allowClear: true
    });
	$("#adm_type_edit").select2({
        allowClear: true
    });

</script>
<!--JS_SELECT_LISTS-->
<!--JS_ADD_NEW_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {

	$("#addNewUsr").validate({
		rules: {
			 name: "required",
			 status: "required",
			 username: "required",
			 userpass: "required"
		},
		messages: {
			name: "This field is required",
			status: "This field is required",
			username: "This field is required",
			userpass: "This field is required"
		},
		submitHandler: function(form) {
        //alert('form submitted');
		form.submit();
        }
	});
});
</script>
<!--JS_ADD_NEW_TASK_MODAL-->
<!--JS_EDIT_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {

	$("#editUsr").validate({
		rules: {
             name_edit: "required",
			 username_edit: "required",
			 status_edit: "required"
		},
		messages: {
			name_edit: "This field is required",
			username_edit: "This field is required",
			status_edit: "This field is required"
		},
		submitHandler: function(form) {
        //alert('form submitted');
		form.submit();
        }
	});
});
</script>
<script type="text/javascript">
$(document).ready(function(){

    $(".edit-adm-modal").click(function(){
    
//get variables from "edit link" data attributes
		var status_edit 		= $(this).attr("data-adstats");
		var city_edit 			= $(this).attr("data-adcity");
        var name_edit 			= $(this).attr("data-adm-fullname");
		var username_edit 		= $(this).attr("data-adm-user");
		var email_edit 			= $(this).attr("data-adm-email");
		var phone_edit 			= $(this).attr("data-adm-phone");
		var id_edit 			= $(this).attr("data-adm-id");
//set modal input values dynamically
		$('#name_edit')			.val(name_edit);
		$('#username_edit')		.val(username_edit);
		$('#email_edit')		.val(email_edit);
		$('#phone_edit')		.val(phone_edit);
		$('#city_edit')			.val(city_edit);
		$('#id_edit')			.val(id_edit);

       //pre-select data in pull down lists
       $("#status_edit")		.select2().select2('val', status_edit); 
	   $("#adm_type_edit")		.select2().select2('val', adm_type_edit); 
  });
    
});
</script>
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script>
//USED BY: All date picking forms
$(document).ready(function(){
    $('.pickadate').datepicker({
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
		$('.footable').footable();
	});
</script>
<script type="text/javascript" src="js/custom/custom.js"></script>
<script type="text/javascript" src="js/custom/custom.general.js"></script>
</body>
</html>
