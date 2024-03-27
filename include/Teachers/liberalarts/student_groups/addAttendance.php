<?php  
if(LMS_VIEW == 'addAttendance' && isset($_GET['id'])) { 

	$sqllmsEdit  = $dblms->querylms("SELECT ag.*
											FROM ".LA_ADVISORAPPOINTMENTS_GROUP." ag
											WHERE ag.group_id = '".cleanvars($_GET['id'])."'
											AND ag.id_advisor = '".cleanvars($rowsstd['emply_id'])."'
											AND ag.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND ag.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' LIMIT 1"); 
	$valueEdit = mysqli_fetch_array($sqllmsEdit);

    //Students
    $sqllmsStudents = $dblms->querylms("SELECT ag.id, ag.attendance,  std.std_id, std.std_regno, std.std_name, std.std_rollno, 
                                        std.std_session, std.std_semester, std.std_section, std.std_photo, std.std_timing
                                        FROM ".LA_ADVISORAPPOINTMENTS_GROUP_DETAIL." ag
                                        INNER JOIN ".STUDENTS." std ON std.std_id = ag.id_std
                                        WHERE ag.id_group = '".cleanvars($valueEdit['group_id'])."'
                                        AND (std.std_status = '2' OR std.std_status = '7') 
                                        AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1'
                                        ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC");

echo '
<!--WI_ADD_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:90%;">
<form class="form-horizontal" action="lateacherappointmentsgroup.php" method="post" id="editGroup" enctype="multipart/form-data">
	<input type="hidden" name="id_group" value="'.cleanvars($_GET['id']).'">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'lateacherappointmentsgroup.php\'"><span>Close</span></button>
	<h4 class="modal-title" style="font-weight:700;"> Add/Edit Student Attendance Group</h4>
</div>

<div class="modal-body">

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Group Name</label>
			<input type="text" class="form-control" id="group_name" name="group_name" autocomplete="off" value="'.$valueEdit['group_name'].'" readonly>
		</div> 
	</div>

	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Date</label>
			<input type="text" class="form-control pickadate" id="group_date" name="group_date" autocomplete="off" value="'.date('Y-m-d', strtotime($valueEdit['group_date'])).'" readonly>
		</div> 
	</div>

	<div class="col-sm-32">
		<div class="form_sep">
			<label class="req">Time Duration</label>
			<input type="text" class="form-control" id="group_timeduration" name="group_timeduration" autocomplete="off" value="'.$valueEdit['group_timeduration'].'" readonly>
		</div> 
	</div>

	<div style="clear:both;padding-top:5px !important;"></div>

	<div class="col-lg-12 heading-modal" style="margin-top:5px; margin-bottom:0px;"> Students List</div>
	<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;"> 
		Total Students: '.mysqli_num_rows($sqllmsStudents).'
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
			<th style="font-weight:600; text-align:center;">Status<div style="color:red; font-size:10px;">Just Check Absent</div></th>
		</tr>
		</thead>
		<tbody>';
		$sr = 0;
    
		while($valueStudent = mysqli_fetch_array($sqllmsStudents)){

            $sr++;
            $checked = '';
            if($valueStudent['attendance'] == '1'){
                $checked = 'checked';
            }		
			
			if($valueStudent['std_photo']) { 
				$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$valueStudent['std_photo'].'" alt="'.$valueStudent['std_name'].'"/>';
			} else {
				$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$valueStudent['std_name'].'"/>';
			}
			echo '
			<tr>
				<td style="width:50px; text-align:center;">'.$sr.'</td>
				<td>'.$stdphoto.'</td>
				<td style="width:150px;">'.$valueStudent['std_regno'].'</td>
				<td><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$valueStudent['std_name'].' ('.$valueStudent['std_session'].')</b>" data-src="studentdetail.php?std_id='.$valueStudent['std_id'].'" href="#">'.$valueStudent['std_name'].'</a> </td>
				<td style="width:70px; text-align:center;">'.$valueStudent['std_rollno'].'</td>			
				<td style="width:90px; text-align:center;">'.$valueStudent['std_session'].'</td>
				<td style="width:110px; text-align:center;"><input name="status['.$sr.']" type="checkbox" id="status['.$sr.']" value="1" class="checkbox-inline" '.$checked.'></td>
			</tr>
			<input type="hidden" name="id_std['.$sr.']" id="id_std['.$sr.']" value="'.$valueStudent['std_id'].'">
			<input type="hidden" name="id_detail['.$sr.']" id="id_detail['.$sr.']" value="'.$valueStudent['id'].'">';

		}
		echo '
		</tbody>
	</table>
	<div style="clear:both;"></div>
	
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'lateacherappointmentsgroup.php\'">Close</button>
	<input class="btn btn-primary" type="submit" value="Submit Attendance" id="add_attendance" name="add_attendance">
</div>
</div>
</form>
</div>
</div>';
}