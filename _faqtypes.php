<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
	include_once("include/header.php");
//----------------------------------------
if(($_GET['srch'])) {
	$stdsrch	= $_GET['srch'];
	$sql2 		= "WHERE category_name LIKE '".$stdsrch."%'";
	$sqlstring	= "&srch=".$stdsrch."";
} else {
	$srch 		= "";
	$sqlstring	= "";
	$sql2  		= '';
}
//----------------------------------------
echo '<title>Manage FAQs Types - '.TITLE_HEADER.'</title>
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
		<input type="text" class="form-control" name="srch" placeholder="Name" style="width:200px;" >
	</div>
	<button type="submit" class="btn btn-primary">Search</button>
	<a href="teamcategory.php" class="btn btn-purple"><i class="icon-list"></i> All</a>
	<button data-toggle="modal" class="btn btn-success" href="#addNewCountryModal"><i class="icon-plus"></i> Add Type</button>
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
//------------------------------------------------
if(!isset($_GET['id'])) {
//--------------------------------------
if(isset($_POST['submit_country'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".FAQS_TYPE."(
														category_status								, 
														category_name								,
														category_detail								,
														category_href
													  )
	   											VALUES(
														'".cleanvars($_POST['category_status'])."'		, 
														'".cleanvars($_POST['category_name'])."'		,
														'".cleanvars($_POST['category_detail'])."'		,
														'".cleanvars($_POST['category_href'])."'
													  )"
							);
	if($sqllms) { 
//--------------------------------------
		echo '<div id="infoupdated" class="alert-box success"><span>success: </span>Record added successfully.</div>';
//--------------------------------------
	}
}

//------------------------------------------------
if (!($Limit))   { $Limit = 50; }  
if ($page == "") { $page  = 1;  } 
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT category_id, category_status, category_name, category_detail, category_href  
										FROM ".FAQS_TYPE." $sql2 ORDER BY category_name ASC");
//--------------------------------------------------
	$count 		   = mysql_num_rows($sqllms);
	$NumberOfPages = ceil($count/$Limit);
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT category_id, category_status, category_name, category_detail, category_href  
										FROM ".FAQS_TYPE." $sql2 ORDER BY category_name ASC LIMIT ".($page-1)*$Limit .",$Limit");
//--------------------------------------------------
if (mysql_num_rows($sqllms) > 0) {
//------------------------------------------------
echo '
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th> Sr.#</th>
	<th> Category Name</th>
	<th> Category Href</th>
	<th> Status</th>
	<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
while($rowstd = mysql_fetch_array($sqllms)) {
//------------------------------------------------
$ctystatus = get_status($rowstd['category_status']);
$srno++;
echo '
<tr>
	<td>'.$srno.'</td>
	<td><a class="links-blue" href="teamcategory.php?id='.$rowstd['category_id'].'">'.$rowstd['category_name'].'</a> </td>
	<td>'.$rowstd['category_href'].'</td>
	<td>'.$ctystatus.'</td>
	<td style="text-align:center;"><a class="btn btn-xs btn-info" href="teamcategory.php?id='.$rowstd['category_id'].'" data-target="#editCountryModal"><i class="icon-pencil"></i></a>
		<button class="btn btn-xs btn-danger ajax-delete-record" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?" data-popconfirm-placement="left" data-mysql-record-id="2" data-mysql-record-id4="1" data-mysql-table-name="tasks" data-ajax-url=""> <i class="icon-trash"></i></button>
	</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//-----------------------------------------
if($count>$Limit) {
echo '
<div class="widget-foot">
<!--WI_PAGINATION-->
<ul class="pagination pull-right">';
	$Nav= ""; 
if($page > 1) { 
	$Nav .= '<li><a href="teamcategory.php?page='.($page-1).$sqlstring.'">Prev</a></li>'; 
} 
for($i = 1 ; $i <= $NumberOfPages ; $i++) { 
if($i == $page) { 
	$Nav .= '<li class="active"><a href="">'.$i.'</a></li>'; 
} else { 
	$Nav .= '<li><a href="teamcategory.php?page='.$i.$sqlstring.'">'.$i.'</a></li>';
} } 
if($page < $NumberOfPages) { 
	$Nav .= '<li><a href="teamcategory.php?page='.($page+1).$sqlstring.'">Next</a><li>'; 
} 
	echo $Nav;
echo '
</ul>
<!--WI_PAGINATION-->
	<div class="clearfix"></div>
</div>';
}
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
}
//------------------------------------------------
if($_GET['id']) { 
//--------------------------------------
if(isset($_POST['submit_changes'])) { 
//------------------------------------------------
	$sqllms  = $dblms->querylms("UPDATE ".FAQS_TYPE." SET  
													category_status	= '".cleanvars($_POST['category_status'])."'
												  , category_name	= '".cleanvars($_POST['category_name'])."'
												  , category_detail	= '".cleanvars($_POST['category_detail'])."'
												  , category_href	= '".cleanvars($_POST['category_href'])."'
											  WHERE category_id		= '".cleanvars($_GET['id'])."'");
	if($sqllms) { 
//--------------------------------------
		echo '<div id="infoupdated" class="alert-box notice"><span>success: </span>Record update successfully.</div>';
//--------------------------------------
	}
}
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT * FROM ".FAQS_TYPE." WHERE category_id = '".cleanvars($_GET['id'])."' LIMIT 1");
	$rowstd = mysql_fetch_array($sqllms);
//------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:90%;">
<form class="form-horizontal" action="teamcategory.php?id='.$_GET['id'].'" method="post" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<h4 class="modal-title" style="font-weight:700;"> Edit Team Category</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:auto;"><b> Category Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="category_name" name="category_name" value="'.$rowstd['category_name'].'" required autofocus autocomplete="off">
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:auto;"><b> Category Detail</b></label>
		<div class="col-lg-12">
			<textarea name="category_detail" id="category_detail" cols="20" rows="3">'.$rowstd['category_detail'].'</textarea>
                                <script>
            document.addEventListener("DOMContentLoaded", function(){
             CKEDITOR.replace( "category_detail", {
                      toolbar: "Advanced",
                      uiColor: "#ffffff",
	                  height: "150px"
                      });
              });


           </script>
		</div>
	</div>

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:auto;"><b> Category Href</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="category_href" name="category_href" value="'.$rowstd['category_href'].'" required autocomplete="off">
		</div>
	</div>

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:auto;"><b> Status</b></label>
		<div class="col-lg-12">
			<select id="category_status" name="category_status" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($status as $itemadm_status) {
				if($rowstd['category_status'] == $itemadm_status['id']) {
					echo "<option value='$itemadm_status[id]' selected>$itemadm_status[name]</option>";
				} else {
					echo "<option value='$itemadm_status[id]'>$itemadm_status[name]</option>";
				}
			}
	echo'
			</select>
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'teamcategory.php\'" >Close</button>
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
</div>

</div>
</form>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->';
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
<div id="addNewCountryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="addNewCountry" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Team Member</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:auto;"><b> Category Name</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="category_name" name="category_name" required autofocus autocomplete="off">
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:auto;"><b> Category Detail</b></label>
		<div class="col-lg-12">
			<textarea name="category_detail" id="category_detail" cols="20" rows="3"></textarea>
                                <script>
            document.addEventListener("DOMContentLoaded", function(){
             CKEDITOR.replace( "category_detail", {
                      toolbar: "Advanced",
                      uiColor: "#ffffff",
	                  height: "150px"
                      });
              });


           </script>
		</div>
	</div>

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:auto;"><b> Category Href</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="category_href" name="category_href" required autocomplete="off">
		</div>
	</div>

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:auto;"><b> Status</b></label>
		<div class="col-lg-12">
			<select id="category_status" name="category_status" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($status as $itemadm_status) {
				echo "<option value='$itemadm_status[id]'>$itemadm_status[name]</option>";
			}
	echo'
			</select>
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
		<input class="btn btn-primary" type="submit" value="Create Category" id="submit_country" name="submit_country">
	</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->

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
<!--JS_SELECT_LISTS-->
<script type="text/javascript">
// close the div in 5 secs
window.setTimeout("closeHelpDiv();", 5000, 2500);

function closeHelpDiv(){
	document.getElementById("infoupdated").style.display=" none";
}
</script>
<script>
//USED BY: VARIOUS
//ACTIONS: creates a nice pull down/select for each specified field
//REQUIRES: select2.js
//NOTES: no need for '$().ready(function()' as this only need jquery & select2.js which are loaded up top
    $("#category_status").select2({
        allowClear: true
    });
	$("#category_status_edit").select2({
        allowClear: true
    });
</script>
<!--JS_SELECT_LISTS-->
<!--JS_ADD_NEW_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
    //USED BY: WI_ADD_NEW_TASK_MODAL
	//ACTIONS: validates the form and submits it
	//REQUIRES: jquery.validate.js
	$("#addNewCountry").validate({
		rules: {
             category_name		: "required",
		  	 category_detail	: "required",
			 designation_code	: "required",
			 category_status	: "required"
		},
		messages: {
			category_name		: "This field is required",
			category_detail		: "This field is required",
			category_status		: "This field is required"
		},
		submitHandler: function(form) {
        //alert('form submitted');
		form.submit();
        }
	});
});
</script>
<!--JS_ADD_NEW_TASK_MODAL-->
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