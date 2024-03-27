<?php 
//--------------------------------------------
if(!LMS_VIEW && isset($_GET['id'])) { 
//-------------------------------------------- 
	$sqllmsEdit  = $dblms->querylms("SELECT ap.*, cr.curs_code, cr.curs_name, cr.cur_credithours_theory, cr.cur_credithours_practical, std.std_id, std.std_name, std.std_regno, std.std_photo 
											FROM ".LA_ADVISORAPPOINTMENTS." ap
											INNER JOIN ".STUDENTS." std ON std.std_id = ap.id_std 
											LEFT JOIN ".COURSES." cr ON cr.curs_id = ap.id_curs
											WHERE ap.id = '".cleanvars($_GET['id'])."'
											AND ap.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND ap.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' LIMIT 1"); 
	$valueEdit = mysqli_fetch_array($sqllmsEdit);

	$appointmentDate = date('Y-m-d');
	if($valueEdit['appointment_date'] != '0000-00-00 00:00:00'){

		$appointmentDate = $valueEdit['appointment_date'];
	}
//--------------------------------------------
echo '
<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:90%;">
<form class="form-horizontal" action="lateacherappointments.php?id='.$valueEdit['id'].'" method="post" id="editDeatil" enctype="multipart/form-data">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'lateacherappointments.php\'"><span>close</span></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Student Appointment request</h4>
</div>

<div class="modal-body">

	<div class="col-sm-43">
		<div class="form_sep">
			<label class="req">Student Name</label>
			<input type="text" class="form-control" id="std_name" name="std_name" autocomplete="off" value="'.$valueEdit['std_regno'].' - '.$valueEdit['std_name'].'" readonly>
		</div> 
	</div>

	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Semester</label>
			<input type="text" class="form-control" id="semester" name="semester" autocomplete="off" value="'.$valueEdit['semester'].'" readonly>
		</div> 
	</div>

	<div class="col-sm-31">
		<div class="form_sep">
			<label class="req">Section</label>
			<input type="text" class="form-control" id="section" name="section" autocomplete="off" value="'.$valueEdit['section'].'" readonly>
		</div> 
	</div>
	
	<div class="col-sm-31">
		<div class="form_sep">
			<label>Time Duration</label>
			<input type="text" class="form-control" id="time_duration" name="time_duration" autocomplete="off" value="'.$valueEdit['time_duration'].'">
		</div> 
	</div>

	<div style="clear:both;padding-top:5px !important;"></div>

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Course Name</label>
			<input type="text" class="form-control" id="curs_name" name="curs_name" autocomplete="off" value="'.$valueEdit['curs_code'].' - '.$valueEdit['curs_name'].'" readonly>
		</div> 
	</div>

	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Request Date</label>
			<input type="text" class="form-control" id="request_date" name="request_date" autocomplete="off" value="'.$valueEdit['request_date'].'" readonly>
		</div> 
	</div>

	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Appointment Date</label>
			<input type="text" class="form-control pickadate" id="appointment_date" name="appointment_date" autocomplete="off" value="'.$appointmentDate.'">
		</div> 
	</div>

	<div style="clear:both;padding-top:5px !important;"></div>

	<div class="form-group" style="margin-bottom:5px;">
		<label class="control-label col-lg-12" style="width:150px;"><b>Request Details</b></label>
		<div class="col-lg-12">
			<textarea id="details" name="details" class="ckeditor" style="height:100px;" readonly>'.html_entity_decode($valueEdit['details'], ENT_QUOTES).'</textarea>
			
		</div>
	</div>
	
	
	<div style="clear:both;padding-top:5px !important;"></div>

	<div class="form-group" style="margin-bottom:5px;">
		<label class="control-label col-lg-12" style="width:150px;"><b>Issue(s)</b></label>
		<div class="col-lg-12">
			<textarea id="issues_id" name="issues" class="ckeditor" style="height:100px;">'.html_entity_decode($valueEdit['issues'], ENT_QUOTES).'</textarea>
			
		</div>
	</div>
	
	<div style="clear:both;padding-top:5px !important;"></div>

	<div class="form-group" style="margin-bottom:5px;">
		<label class="control-label col-lg-12" style="width:150px;"><b>Way Forward</b></label>
		<div class="col-lg-12">
			<textarea id="way_forward" name="way_forward" class="ckeditor" style="height:100px;">'.html_entity_decode($valueEdit['way_forward'], ENT_QUOTES).'</textarea>
			
		</div>
	</div>

	
	<div style="clear:both;padding-top:5px !important;"></div>

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Way Forward Date</label>
			<input type="text" class="form-control pickadate" id="wayforward_date" name="wayforward_date" autocomplete="off" value="'.$valueEdit['wayforward_date'].'">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Status</label>
			<select id="status" name="status" required style="width:100%;">';
				foreach($appointstatus as $status) {
					
					echo '<option value="'.$status['id'].'"';if($status['id'] == $valueEdit['status']) {echo' selected';} echo '>'.$status['name'].'</option>';
					
				}
				echo '
			</select>
		</div> 
	</div>

	

	<div style="clear:both;"></div>
	
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'lateacherappointments.php\'">Close</button>
	<input class="btn btn-primary" type="submit" value="Save Changes" id="appointment_changes" name="appointment_changes">
</div>
</div>
</form>
</div>
</div>
<!--JS_EDIT_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
    //USED BY: WI_EDIT_NEW_TASK_MODAL
	//ACTIONS: validates the form and submits it
	//REQUIRES: jquery.validate.js
	$("#editDeatil").validate({
		rules: {
			appointment_date	: "required",
			status				: "required"
		},
		messages: {
			appointment_date	: "This field is required",
			status				: "This field is required"
		},
		submitHandler: function(form) {
        //alert("form submitted");
		form.submit();
        }
	});
});
</script>
<script>
	$("#status").select2({
        allowClear: true
    });
</script>';
}