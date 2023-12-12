<?php
//----------------------------------------
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
	require_once("thumbnail_images.class.php");
	include_once("include/header.php");
//----------------------------------------
if($srch) {
	$stdsrch	= $srch;
	$sql2 		= "WHERE caption LIKE '".$stdsrch."%'";
	$sqlstring	= "&srch=".$stdsrch."";
} else {
	$srch 		= "";
	$sqlstring	= "";
	$sql2  		= '';
}
//----------------------------------------
echo '<title>Manage Gallery - '.TITLE_HEADER.'</title>
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
	
	<button type="submit" class="btn btn-primary">Search</button>
	<a href="gallery.php" class="btn btn-purple"><i class="icon-list"></i> All</a>
	<button data-toggle="modal" class="btn btn-success" href="#addNewCountryModal"><i class="icon-plus"></i> Add Gallery Photo</button>
</div>
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
if(isset($_POST['submit_gallery'])) { 
//------------------------------------------------
$sqllms  = $dblms->querylms("INSERT INTO ".GALLERY." (
														status										, 
														ordering									, 
														caption																	 
													)
	   										VALUES (
														'".cleanvars($_POST['status'])."'			, 
														'".cleanvars($_POST['ordering'])."'			, 
														'".cleanvars($_POST['caption'])."'
													)
						");
	if($sqllms) { 
//--------------------------------------
$std_id = $dblms->lastestid();
//--------------------------------------
if(!empty($_FILES['photo']['name'])) { 
//--------------------------------------
	$img 			= explode('.', $_FILES['photo']['name']);
	$extension 		= strtolower($img[1]);
//--------------------------------------
	$img_dir		= "images/gallery/";
	$originalImage	= $img_dir.cleanvars(to_seo_url($_POST['caption'])).'_'.$std_id.".".strtolower($img[1]);
	$img_fileName	= cleanvars(to_seo_url($_POST['caption'])).'_'.$std_id.".".strtolower($img[1]);
//--------------------------------------
	if(in_array($extension , array('jpg','jpeg', 'gif', 'png'))) { 
//--------------------------------------
		$sqllmsupload  = $dblms->querylms("UPDATE ".GALLERY."
														SET photo = '".$img_fileName."'
												 WHERE  id		  = '".cleanvars($std_id)."'");
		unset($sqllmsupload);
		$mode = '0644'; 
//--------------------------------------	
		move_uploaded_file($_FILES['photo']['tmp_name'],$originalImage);
		chmod ($originalImage, octdec($mode));

		$tpath1 = '../images/gallery/'.$img_fileName;
		$thumbpath = '../images/gallery/thumb/'.$img_fileName;
		create_thumb_image($tpath1,$thumbpath,'200','150'); 
//--------------------------------------
	}
//--------------------------------------
}
//--------------------------------------
		echo '<div id="infoupdated" class="alert-box success"><span>success: </span>Record added successfully.</div>';
//--------------------------------------
	}
}

//------------------------------------------------
if (!($Limit))   { $Limit = 50; }  
if ($page == "") { $page  = 1;  } 
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT *
										FROM ".GALLERY." $sql2 ORDER BY caption ASC");
//--------------------------------------------------
	$count 		   = mysqli_num_rows($sqllms);
	$NumberOfPages = ceil($count/$Limit);
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT *
										FROM ".GALLERY." $sql2 ORDER BY caption ASC LIMIT ".($page-1)*$Limit .",$Limit");
//--------------------------------------------------
if (mysqli_num_rows($sqllms) > 0) {
//------------------------------------------------
echo '
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center;">Sr. #</th>
	<th width="40px">Pic</th>
	<th> Title</th>
	<th style="text-align:center;">Ordering</th>
	<th style="text-align:center;">Status</th>
	<th style="width:60px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
</tr>
</thead>
<tbody>';
$srno = 0;
//------------------------------------------------
while($rowstd = mysqli_fetch_array($sqllms)) {
//------------------------------------------------
$ctystatus = get_status($rowstd['status']);
$srno++;
//------------------------------------------------
if($rowstd['photo']) { 
	$stdphoto = '<img class="avatar-smallest image-boardered" src="../images/gallery/'.$rowstd['photo'].'" alt="'.$rowstd['caption'].'"/>';
} else {
	$stdphoto = '<img class="avatar-smallest image-boardered" src="../images/gallery/default.png" alt="'.$rowstd['caption'].'"/>';
}
//------------------------------------------------
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$srno.'</td>
	<td>'.$stdphoto.'</td>
	<td><a class="links-blue" href="gallery.php?id='.$rowstd['id'].'">'.$rowstd['caption'].'</a> </td>
	<td style="width:100px; text-align:center;">'.$rowstd['ordering'].'</td>
	<td style="width:60px;">'.$ctystatus.'</td>
	<td style="text-align:center;"><a class="btn btn-xs btn-info" href="gallery.php?id='.$rowstd['id'].'" data-target="#editCountryModal"><i class="icon-pencil"></i></a>
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
	$Nav .= '<li><a href="gallery.php?page='.($page-1).$sqlstring.'">Prev</a></li>'; 
} 
for($i = 1 ; $i <= $NumberOfPages ; $i++) { 
if($i == $page) { 
	$Nav .= '<li class="active"><a href="">'.$i.'</a></li>'; 
} else { 
	$Nav .= '<li><a href="gallery.php?page='.$i.$sqlstring.'">'.$i.'</a></li>';
} } 
if($page < $NumberOfPages) { 
	$Nav .= '<li><a href="gallery.php?page='.($page+1).$sqlstring.'">Next</a><li>'; 
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
if(isset($_GET['id'])) { 
//--------------------------------------
if(isset($_POST['submit_changes'])) { 
//------------------------------------------------
	$sqllms  = $dblms->querylms("UPDATE ".GALLERY." SET  
													status		= '".cleanvars($_POST['status'])."'
												  , ordering	= '".cleanvars($_POST['ordering'])."'
												  , caption		= '".cleanvars($_POST['caption'])."'
											  WHERE id			= '".cleanvars($_GET['id'])."'");
	if($sqllms) { 
//--------------------------------------
if(!empty($_FILES['photo']['name'])) { 
//--------------------------------------
	$img 			= explode('.', $_FILES['photo']['name']);
	$extension 		= strtolower($img[1]);
//--------------------------------------
	$img_dir		= "../images/gallery/";
	$originalImage	= $img_dir.cleanvars(to_seo_url($_POST['caption'])).'_'.$_GET['id'].".".strtolower($img[1]);
	$img_fileName	= cleanvars(to_seo_url($_POST['caption'])).'_'.$_GET['id'].".".strtolower($img[1]);
//--------------------------------------
	if(in_array($extension , array('jpg','jpeg', 'gif', 'png'))) { 
//--------------------------------------
		$sqllmsupload  = $dblms->querylms("UPDATE ".GALLERY."
														SET photo = '".$img_fileName."'
												 WHERE  id = '".cleanvars($_GET['id'])."'");
		unset($sqllmsupload);
		$mode = '0644'; 
//--------------------------------------	
		move_uploaded_file($_FILES['photo']['tmp_name'],$originalImage);
		chmod ($originalImage, octdec($mode));

		$tpath1 = '../images/gallery/'.$img_fileName;
		$thumbpath = '../images/gallery/thumb/'.$img_fileName;
		create_thumb_image($tpath1,$thumbpath,'200','150'); 
//--------------------------------------
	}
//--------------------------------------
}
//--------------------------------------
		echo '<div id="infoupdated" class="alert-box notice"><span>success: </span>Record update successfully.</div>';
//--------------------------------------
	}
}
//------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT * FROM ".GALLERY." WHERE id = '".cleanvars($_GET['id'])."' LIMIT 1");
	$rowstd = mysqli_fetch_array($sqllms);
	if($rowstd['photo']) { 
		$stdphoto = '<img class="avatar-large image-boardered" src="../images/gallery/'.$rowstd['photo'].'" alt="'.$rowstd['caption'].'"/>';
	} else {
		$stdphoto = '';
	}
//------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:90%;">
<form class="form-horizontal" action="gallery.php?id='.$_GET['id'].'" method="post" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<h4 class="modal-title" style="font-weight:700;"> Edit Gallery Post Detail </h4>
</div>

<div class="modal-body">

   <div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:200px;"><b>Title</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="caption" name="caption" value="'.$rowstd['caption'].'" autofocus autocomplete="off" required>
		</div>
	</div>
	
	<div style="clear:both;"></div>

	<div class="col-LG-12">
		<div class="form-sep" style="margin-top:5px;">
			<label class="req">Status</label>
			<select id="status" name="status" style="width:100%" autocomplete="off">
				<option value="">Select Status</option>';
			foreach($status as $itemadm_status) {
				if($rowstd['status'] == $itemadm_status['id']) {
					echo "<option value='$itemadm_status[id]' selected>$itemadm_status[name]</option>";
				} else {
					echo "<option value='$itemadm_status[id]'>$itemadm_status[name]</option>";
				}
			}
	echo'</select>
		</div> 
	</div>
	
	<div style="clear:both;"></div>	
	
	<div class="col-sm-61">
		<div class="form-sep" style="margin-top:5px;">
			<label class="req">Ordering</label>
			<input type="text" class="form-control" id="ordering" name="ordering" value="'.$rowstd['ordering'].'" autofocus autocomplete="off">
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form-sep" style="margin-top:5px;">
			<label class="req">Photo</label>
			<input id="photo" name="photo" class="btn btn-mid btn-primary clearfix" type="file">'.$stdphoto.'Size: <span style="color:red;">(450px X 338px)</span>
		</div> 
	</div>
	
	<div style="clear:both;"></div>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'gallery.php\'" >Close</button>
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
	<h4 class="modal-title" style="font-weight:700;"> Add Gallery Post Detail</h4>
</div>

<div class="modal-body">

   <div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:200px;"><b>Title</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="caption" name="caption" required autofocus autocomplete="off">
		</div>
	</div>
	
	<div style="clear:both;"></div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:180px;"><b>Status</b></label>
		<div class="col-lg-12">
			<select id="status" name="status" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($status as $itemadm_status) {
				echo "<option value='$itemadm_status[id]'>$itemadm_status[name]</option>";
			}
	echo'
			</select>
		</div>
	</div>	
	
	<div style="clear:both;"></div>
	
	<div class="col-sm-61">
		<div class="form-sep" style="margin-top:5px;">
			<label class="req">Ordering</label>
			<input type="text" class="form-control" id="ordering" name="ordering" autofocus autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form-sep" style="margin-top:5px;">
			<label class="req">Photo</label>
			<input id="photo" name="photo" class="btn btn-mid btn-primary clearfix" type="file" required>Size: <span style="color:red;">(450px X 338px)</span>
		</div> 
	</div>
	
	<div style="clear:both;"></div>	

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
		<input class="btn btn-primary" type="submit" value="Create Gallery Post" id="submit_gallery" name="submit_gallery">
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
    $("#status").select2({
        allowClear: true
    });
	$("#status_edit").select2({
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
             dept_name		: "required",
			 dept_status	: "required"
		},
		messages: {
			dept_name		: "This field is required",
			dept_status		: "This field is required"
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