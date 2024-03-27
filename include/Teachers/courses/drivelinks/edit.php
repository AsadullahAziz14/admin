<?php 
//------------------------------------------------
if(isset($_GET['editid']) && !isset($_GET['add']) && !isset($_GET['archive'])) { 
//------------------------------------------------
	$sqllmslesson  = $dblms->querylms("SELECT *   
										FROM ".COURSES_DRIVELINKS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND id = '".cleanvars($_GET['editid'])."' LIMIT 1");
	$rowlesson = mysqli_fetch_assoc($sqllmslesson);

//------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="courses.php?id='.$_GET['id'].'&view=Drivelinks" method="post" id="editDrivelinks" enctype="multipart/form-data">
<input type="hidden" name="editid" id="editid" value="'.cleanvars($_GET['editid']).'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=Drivelinks\'"><span>close</span></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Google Drive Detaill</h4>
</div>

<div class="modal-body">

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> URL</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="caption" name="caption" required autofocus autocomplete="off" value="'.$rowlesson['caption'].'">
		</div>
	</div>

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Detail</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="drive_link" name="drive_link" required autocomplete="off" style="height:70px !important;">'.$rowlesson['drive_link'].'</textarea>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Status</b></label>
		<div class="col-lg-12">
			<select id="status" name="status" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($admstatus as $itemadm_status) { 
				if($rowlesson['status'] == $itemadm_status['status_id']) { 
					echo '<option value="'.$itemadm_status['status_id'].'" selected>'.$itemadm_status['status_name'].'</option>';
				} else { 
					echo '<option value="'.$itemadm_status['status_id'].'">'.$itemadm_status['status_name'].'</option>';
				}
			}
	echo'
			</select>
		</div>
	</div>

	<div style="clear:both;"></div>
	
</div>

<div class="modal-footer">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_detaildrive" name="changes_detaildrive">
	<button type="button" class="btn btn-default" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=Drivelinks\'" >Close</button>
</div>

</div>
</form>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
	$("#status").select2({
        allowClear: true
    });
	

	
</script>
<script type="text/javascript">
$().ready(function() {
    //USED BY: WI_ADD_NEW_TASK_MODAL
	//ACTIONS: validates the form and submits it
	//REQUIRES: jquery.validate.js
	$("#editDrivelinks").validate({
		rules: {
             caption			: "required",
			 drive_link			: "required"
		},
		messages: {
			caption				: "This field is required",
			drive_link			: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';
}
//------------------------------------------------