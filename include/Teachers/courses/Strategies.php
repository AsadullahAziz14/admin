<?php 

//--------------------------------------------
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">

<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Course Teaching & Learning Strategies</h3></span> <a class="btn btn-mid btn-purple pull-right" href="courses.php?id='.$_GET['id'].'"><i class="icon-list"></i> Back</a> 
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<!--WI_MILESTONES_NAVIGATION-->

<!--WI_MILESTONES_TABLE-->
<div class="row">
<div class="col-lg-12">
  
<div class="widget wtabs">
<div class="widget-content">';
//--------------------------------------
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
}

// course info
$sqllmsinfo  = $dblms->querylms("SELECT id, strategies, strategies_date
										FROM ".COURSES_INFO."   										 
										WHERE id_campus 	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' LIMIT 1");
$rowscinfo = mysqli_fetch_array($sqllmsinfo);

//------------------------------------------------
if($rowscinfo['strategies']) {
	$strategies = $rowscinfo['strategies'];
} else {
	$strategies = '';
}
//-----------------------------------------
echo '

<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<div class="row">
<div class="modal-dialog" style="width:90%">
<form class="form-horizontal" action="courses.php?id='.$_GET['id'].'" method="post" id="addIntro" enctype="multipart/form-data">
<input type="hidden" name="id_curs" name="id_curs" value="'.$_GET['id'].'">
<input type="hidden" name="id_teacher" name="id_teacher" value="'.$rowsstd['emply_id'].'">
<input type="hidden" name="editid" name="editid" value="'.$rowscinfo['id'].'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'courses.php?id='.$_GET['id'].'\'"><span>close</span></button>
	<h4 class="modal-title" style="font-weight:700;"> Course Teaching & Learning Strategies</h4>
</div>

<div class="modal-body">

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Strategies</b></label>
		<div class="col-lg-12">
			<textarea class="form-control ckeditor" id="strategies" name="strategies" style="height:150px !important;" required="required" autocomplete="off">'.$strategies.'</textarea>
		</div>
	</div>
	
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'courses.php?id='.$_GET['id'].'\'" >Close</button>
	<input class="btn btn-primary" type="submit" value="Save Record" id="strategies_submit" name="strategies_submit">
</div>

</div>
</form>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->';
	


echo '
<script>
	$("#status_edit").select2({
        allowClear: true
    });
	$("#weekno_edit").select2({
        allowClear: true
    });
	
	
</script>
<script type="text/javascript">
$().ready(function() {
	$("#addIntro").validate({
		rules: {
             status_edit			: "required",
			 weekno_edit			: "required",
			 detail_edit			: "required"
			 
		},
		messages: {
			status_edit			: "This field is required",
			weekno_edit			: "This field is required",
			date_start_edit		: "This field is required",
			date_end_edit		: "This field is required",
			detail_edit			: "This field is required" 
		},
		submitHandler: function(form) {
        //alert("form submitted");
		form.submit();
        }
	});
});
</script>


</div>
</div>
</div>
</div>

<!--WI_MILESTONES_TABLE-->
<!--WI_TABS_NOTIFICATIONS-->

</div>
<div class="clearfix"></div>
</div>
</div>
</div>'; 