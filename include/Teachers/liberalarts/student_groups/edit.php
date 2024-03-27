<?php  
if(!LMS_VIEW && isset($_GET['id'])) { 

	$sqllmsEdit  = $dblms->querylms("SELECT ag.*
											FROM ".LA_ADVISORAPPOINTMENTS_GROUP." ag
											WHERE ag.group_id = '".cleanvars($_GET['id'])."'
											AND ag.id_advisor = '".cleanvars($rowsstd['emply_id'])."'
											AND ag.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND ag.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' LIMIT 1"); 
	$valueEdit = mysqli_fetch_array($sqllmsEdit);

	if($valueEdit['group_wayforwarddate'] == '0000-00-00'){
		$valueEdit['group_wayforwarddate'] = date('Y-m-d');
	}

echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:90%;">
<form class="form-horizontal" action="lateacherappointmentsgroup.php" method="post" id="editGroup" enctype="multipart/form-data">
	<input type="hidden" name="id_group" value="'.cleanvars($_GET['id']).'">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'lateacherappointmentsgroup.php\'"><span>Close</span></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Student Appointment Group</h4>
</div>

<div class="modal-body">

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Title</label>
			<input type="text" class="form-control" id="group_name" name="group_name" autocomplete="off" value="'.$valueEdit['group_name'].'" required>
		</div> 
	</div>

	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Date</label>
			<input type="text" class="form-control pickadate" id="group_date" name="group_date" autocomplete="off" value="'.date('Y-m-d', strtotime($valueEdit['group_date'])).'" required>
		</div> 
	</div>

	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Time Duration</label>
			<input type="text" class="form-control" id="group_timeduration" name="group_timeduration" autocomplete="off" value="'.$valueEdit['group_timeduration'].'" required>
		</div> 
	</div>

	<div style="clear:both;padding-top:5px !important;"></div>

	<div class="form-group" style="margin-bottom:5px;">
		<label class="control-label col-lg-12 req" style="width:150px;"><b>Agenda</b></label>
		<div class="col-lg-12">
			<textarea id="group_agenda" name="group_agenda" class="ckeditor" style="height:100px;" required>'.html_entity_decode($valueEdit['group_agenda'], ENT_QUOTES).'</textarea>
		</div>
	</div>
	
	<div style="clear:both;padding-top:5px !important;"></div>

	<div class="form-group" style="margin-bottom:5px;">
		<label class="control-label col-lg-12" style="width:250px;"><b>Minutes of the Meeting</b></label>
		<div class="col-lg-12">
			<textarea id="group_meetingminutes" name="group_meetingminutes" class="ckeditor" style="height:100px;">'.html_entity_decode($valueEdit['group_meetingminutes'], ENT_QUOTES).'</textarea>
			
		</div>
	</div>

	<div style="clear:both;padding-top:5px !important;"></div>

	<div class="form-group" style="margin-bottom:5px;">
		<label class="control-label col-lg-12 req" style="width:150px;"><b>Status</b></label>
		<div class="col-lg-12">
			<select id="group_status" name="group_status" required style="width:100%;">';
			foreach($appointstatus as $status) {
				
				echo '<option value="'.$status['id'].'"';if($status['id'] == $valueEdit['group_status']) {echo' selected';} echo '>'.$status['name'].'</option>';
				
			}
			echo '
		</select>
		</div>
	</div>

	<div style="clear:both;"></div>

	<div class="col-lg-12 heading-modal" style="margin-top:5px; margin-bottom:0px;"> Students List</div>
	<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;"> 
		Total Students: '.$countStudents.'
	</div>

	<table class="footable table table-bordered table-hover table-with-avatar">
		<thead>
		<tr class="heading-modal">
			<th style="font-weight:600; vertical-align:middle; text-align:center;">Sr.#</th>
			<th width="35px" style="font-weight:600; vertical-align:middle;">Pic</th>
			<th style="font-weight:600; vertical-align:middle;">Reg #</th>
			<th style="font-weight:600; vertical-align:middle;">Student Name</th>
			<th style="font-weight:600; vertical-align:middle; text-align:center;">Roll No</th>
			<th style="font-weight:600; vertical-align:middle; text-align:center;">Session</th>
			<th style="font-weight:600; text-align:center;">Status<div style="color:red; font-size:10px;">Un-Check those not be added</div></th>
		</tr>
		</thead>
		<tbody>';
		$sr = 0;
		//Iterate over Students Array
		foreach($studentsArray as $student) { 

			$checked = '';
			$sqllmsStudent = $dblms->querylms("SELECT id
													FROM ".LA_ADVISORAPPOINTMENTS_GROUP_DETAIL." ag
													WHERE id_group = '".cleanvars($valueEdit['group_id'])."'
													AND id_std = '".cleanvars($student['std_id'])."'");
			if(mysqli_num_rows($sqllmsStudent) == 1){
				$checked = 'checked';
			}
		
			$sr++;
			if($student['std_photo']) { 
				$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$student['std_photo'].'" alt="'.$student['std_name'].'"/>';
			} else {
				$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$student['std_name'].'"/>';
			}
			echo '
			<tr>
				<td style="width:50px; text-align:center;">'.$sr.'</td>
				<td>'.$stdphoto.'</td>
				<td style="width:150px;">'.$student['std_regno'].'</td>
				<td><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$student['std_name'].' ('.$student['std_session'].')</b>" data-src="studentdetail.php?std_id='.$student['std_id'].'" href="#">'.$student['std_name'].'</a> </td>
				<td style="width:70px; text-align:center;">'.$student['std_rollno'].'</td>			
				<td style="width:90px; text-align:center;">'.$student['std_session'].'</td>
				<td style="width:110px; text-align:center;"><input name="status['.$sr.']" type="checkbox" id="status['.$sr.']" value="1" class="checkbox-inline" '.$checked.'></td>
			</tr>
			<input type="hidden" name="id_std['.$sr.']" id="id_std['.$sr.']" value="'.$student['std_id'].'">
			<input type="hidden" name="semester['.$sr.']" id="semester['.$sr.']" value="'.$student['std_semester'].'">
			<input type="hidden" name="section['.$sr.']" id="section['.$sr.']" value="'.$student['std_section'].'">
			<input type="hidden" name="timing['.$sr.']" id="timing['.$sr.']" value="'.$student['std_timing'].'">';

		}
		echo '
		</tbody>
	</table>
	<div style="clear:both;"></div>
	
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'lateacherappointmentsgroup.php\'">Close</button>
	<input class="btn btn-primary" type="submit" value="Edit Group" id="edit_group" name="edit_group">
</div>
</div>
</form>
</div>
</div>
<!--JS_ADD_TASK_MODAL-->
<script>
	$("#group_status").select2({
        allowClear: true
    });
</script>';
}