<?php
$sqllmsstds  = $dblms->querylms("SELECT od.*, std.std_id, std.std_name, std.std_rollno, std.std_regno, std.std_photo, std.std_session, oc.semester 
									FROM ".LA_STUDENT_REGISTRATION_DETAIL." od
									INNER JOIN ".LA_STUDENT_REGISTRATION." oc ON oc.id = od.id_setup 
									INNER JOIN ".STUDENTS." std ON std.std_id = oc.id_std 
									WHERE oc.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
									AND oc.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
									AND oc.is_deleted != '1' AND od.confirm_status = '2'
									AND od.id_curs =  '".cleanvars($_GET['id'])."'  
									AND od.section =  '".cleanvars($_GET['section'])."'  
									AND od.timing =  '".cleanvars($_GET['timing'])."'  
									AND (std.std_status = '2' OR std.std_status = '7') 
									AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
									ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC");
while($rowcurstds = mysqli_fetch_array($sqllmsstds)) {
	
	$cursstudents[] = array (
								"std_id"		=> $rowcurstds['std_id']		,
								"std_photo"		=> $rowcurstds['std_photo']		,
								"std_name"		=> $rowcurstds['std_name']		,
								"std_session"	=> $rowcurstds['std_session']	,
								"std_rollno"	=> $rowcurstds['std_rollno']	,
								"std_regno"		=> $rowcurstds['std_regno']		,
								"prg_name"		=> ''							,
								"maxmarks"		=> 25
							);
	
	$countstudents++;
	//echo '<h1>'.$rowcurstds['prg_midterm'].'</h1>';
}

//--------------------------------------------------
if ($countstudents>0) {
//$valuecount1  = mysqli_fetch_array($sqllmsstds);
	$srbk = 0;
	$srno = 0;

	$sqllmssetup  = $dblms->querylms("SELECT m.status,  m.id, m.exam_date, m.forward_to    
												FROM ".MIDTERM." m 
												WHERE  m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
												AND m.timing 	= '".cleanvars($_GET['timing'])."' 
												AND m.section 	= '".cleanvars($_GET['section'])."' 
												AND m.is_liberalarts = '1' 
												AND m.id_curs 	= '".cleanvars($_GET['id'])."' LIMIT 1");
	$valuesetup = mysqli_fetch_array($sqllmssetup);
//------------------------------------------------
if($valuesetup['exam_date'] != '0000-00-00') {
	$exmdate = $valuesetup['exam_date'];
} else { 
	$exmdate = '';
}
//------------------------------------------------
foreach($cursstudents as $itemstd) { 
//-----------------Fee Status-------------------------------
	$sqllmspayable  = $dblms->querylms("SELECT 
											SUM(CASE WHEN due_date <= '".$rowfeecats['date_end']."' then total_amount end) as Totalpayable, 
											SUM(CASE WHEN due_date <= '".$rowfeecats['date_end']."' then arrears end) as Totalpayarrears, 
											SUM(CASE WHEN paid_date != '0000-00-00' AND due_date <= '".$rowfeecats['date_end']."' then total_amount end) as Totalpaid, 
											SUM(CASE WHEN paid_date != '0000-00-00' AND due_date <= '".$rowfeecats['date_end']."' then arrears end) as Totalarrears
											FROM ".FEES." 
											WHERE id_std = '".$itemstd['std_id']."' 
											AND is_deleted != '1'  ");
	$valuepayable	= mysqli_fetch_array($sqllmspayable); 
	$totalbalance 	= (($valuepayable['Totalpayable'] + $valuepayable['Totalpayarrears']) - ($valuepayable['Totalpaid'] + $valuepayable['Totalarrears']));

//--------------------------------------------
	$sqllmsclearance  = $dblms->querylms("SELECT ca.allowed         
										FROM ".EXAMS_ALLOWED_DETAIL." ca  
										INNER JOIN ".EXAMS_ALLOWED." ea ON ea.id = ca.id_setup  
										WHERE ea.id_campus	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
										AND ea.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND ea.id_term = '1' 
										AND ca.id_curs = '".cleanvars($_GET['id'])."' 
										AND ea.timing = '".cleanvars($_GET['timing'])."'
										AND ea.id_std = '".$itemstd['std_id']."' ");
	$valueclearance	= mysqli_fetch_array($sqllmsclearance);
if($rowsetting ['exclude_attendance'] == $itemstd['std_session']) { 
	$attendanceper = 100;
} else {
//-----------------------Attendance Checker-------------------------
if($_GET['timing'] == 1 || $_GET['timing'] == 4) { 


	$sqllmsattendance  = $dblms->querylms("SELECT at.lectureno, at.dated, dt.status, dt.remarks     
										FROM ".COURSES_ATTENDANCE_DETAIL." dt
										INNER JOIN ".COURSES_ATTENDANCE." at ON at.id = dt.id_setup 
										WHERE at.theorypractical = '1'
										AND at.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND at.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
										AND at.id_curs = '".cleanvars($_GET['id'])."' 
										AND at.dated <= '".cleanvars($rowfeecats['date_start'])."' 
										AND at.section = '".cleanvars($_GET['section'])."'
										AND at.timing = '".cleanvars($_GET['timing'])."' 
										AND dt.id_std = '".cleanvars($itemstd['std_id'])."' ORDER BY at.lectureno ASC");
	$totallecture = mysqli_num_rows($sqllmsattendance);
	$totalpresent = 0;
	$arrayattendance = array();
	while($rowattendance = mysqli_fetch_assoc($sqllmsattendance)) { 
		$arrayattendance[] = $rowattendance;
		if($rowattendance['status'] == 2) { 
			$totalpresent++;
		}
	}
	if($totallecture>0) { 
		$attendanceper = round(($totalpresent/$totallecture) * 100);
	} else { 
		$attendanceper = 0;
	}

} else if($_GET['timing'] == 2) { 

//------------------------------------------------
		$sqllmsattendance  = $dblms->querylms("SELECT at.lectureno, at.dated, dt.status, dt.remarks     
										FROM ".COURSES_ATTENDANCE_DETAIL." dt
										INNER JOIN ".COURSES_ATTENDANCE." at ON at.id = dt.id_setup 
										WHERE at.theorypractical = '1'
										AND at.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND at.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
										AND at.id_curs = '".cleanvars($_GET['id'])."' 
										AND at.section = '".cleanvars($_GET['section'])."' 
										AND at.dated <= '".cleanvars($rowfeecats['date_start'])."' 
										AND at.timing = '".cleanvars($_GET['timing'])."' 
										AND dt.id_std = '".cleanvars($itemstd['std_id'])."' ORDER BY at.lectureno ASC");
	$totallecture = mysqli_num_rows($sqllmsattendance);
	$totalpresent = 0;
	$arrayattendance = array();
	while($rowattendance = mysqli_fetch_assoc($sqllmsattendance)) { 
		$arrayattendance[] = $rowattendance;
		if($rowattendance['status'] == 2) { 
			$totalpresent++;
		}
	}
	if($totallecture>0) { 
		$attendanceper = round(($totalpresent/$totallecture) * 100);
	} else { 
		$attendanceper = 0;
	}
//------------------------------------------------
}
}
//------------------------------------------------

$srno++;

if($valuesetup['id']) {
	$printaward = '<a class="btn btn-mid btn-info" href="midtermawardprint.php?id='.$valuesetup['id'].'" target="_blank"><i class="icon-print"></i> Print Sheet</a>';
} else { 
	$printaward = ' ';
}
	
if(($valuesetup['forward_to'] == 4)) {
	
	$examdisabled 	= 'disabled';
	$marksdisabled 	= 'readonly';
	$submitdisabled = 'display:none;';
	
} else { 
	
	$examdisabled 	= '';
	$marksdisabled	= '';
	$submitdisabled = '';
	
}


//------------Max Marks------------------------------------
	
	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) == 1) {

		$maxmarks  = 25;

	} else {

		if($itemstd['maxmarks']>0) {
			
			$maxmarks = $itemstd['maxmarks'];
			
		} else {
			
			$maxmarks = 25;

		}

	}
	


//--------------------------------------------
if($srno == 1) { 
echo '
<div style="clear:both;"></div>
<form class="form-horizontal" action="#" method="post" id="addNewUsr" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="id_curs" id="id_curs" value="'.$_GET['id'].'">
<input type="hidden" name="stdsection" id="stdsection" value="'.$_GET['section'].'">
<input type="hidden" name="stdsemester" id="stdsemester" value="'.$_GET['semester'].'">
<input type="hidden" name="stdtiming" id="stdtiming" value="'.$_GET['timing'].'">
<input type="hidden" name="prgid" id="prgid" value="0">
<input type="hidden" name="id_teacher" id="id_teacher" value="'.$rowsurs['id_teacher'].'">
<input type="hidden" name="id_setup" id="id_setup" value="'.$valuesetup['id'].'">
<input type="hidden" name="maxmarks" id="maxmarks" value="'.$maxmarks.'">
<div style="margin-top:10px; font-weight:600;">
	Subject:  <span style="width:80%; display: inline-block; border-bottom:1px dashed #666; color:#00f;">'.$rowsurs['curs_code'].' - '.$rowsurs['curs_name'].' (Section: '.$_GET['section'].')</span>
</div>
<div style="clear:both;"></div>
<div style="margin-top:10px;">
	<span class="req" style="font-weight:600;">Examination Date</span> <input name="exam_date" id="exam_date" type="date" value="'.$exmdate.'" required autocomplete="off" '.$examdisabled.'> 
	<span style="margin-left:200px;font-weight:600;"> Forward to : 
		<select id="forward_to" name="forward_to" style="width:150px;"  autocomplete="off">
				<option value="">Select Forward</option>';
				if($valuesetup['forward_to'] == 4) {
					echo '<option value="4" selected>HODs / Dean </option>';
				} else {
					echo '<option value="4">HODs / Dean </option>';
				}
echo '
			</select>
	</span>
</div>

<div style="clear:both;"></div>
<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;"> 
	 '.$printaward.' 
</div>
<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th style="font-weight:600;">Sr.#</th>
	<th style="font-weight:600;">Roll No</th>
	<th style="font-weight:600;">Reg #</th>
	<th width="35px" style="font-weight:600;">Pic</th>
	<th style="font-weight:600;">Student Name</th>
	<th style="font-weight:600; text-align:center;">Marks</th>
	<th style="font-weight:600; text-align:center;">Status</th>
	<th style="font-weight:600; text-align:center;">Remarks</th>
</tr>
</thead>
<tbody>';
}
//------------------------------------------------
if($itemstd['std_photo']) { 
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$itemstd['std_photo'].'" alt="'.$itemstd['std_name'].'"/>';
} else {
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$itemstd['std_name'].'"/>';
}



$srbk++;

	$sqllmsstdmarks  = $dblms->querylms("SELECT d.id, d.id_midterm, d.marks, d.attendance, d.remarks, m.exam_date, m.forward_to   
												FROM ".MIDTERM_DETAILS." d 
												INNER JOIN ".MIDTERM." m ON m.id = d.id_midterm  
												WHERE d.id_std 	= '".cleanvars($itemstd['std_id'])."' 
												AND m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
												AND m.timing 	= '".cleanvars($_GET['timing'])."' 
												AND m.section 	= '".cleanvars($_GET['section'])."' 
												AND m.id_curs 	= '".cleanvars($_GET['id'])."' LIMIT 1");
	$valuemarks 		= mysqli_fetch_array($sqllmsstdmarks);
//--------------------------------------------
	if($valuemarks['attendance'] == 1 && (($totalbalance == 0 && $valuepayable['Totalpayable']>0 ) && ($attendanceper>=$attendancereq)) || ($valueclearance['allowed'] == 1)) { 
		$attendance = '<input name="attendance['.$srbk.']" type="radio" id="attendance['.$srbk.']" checked="checked" value="1" class="checkbox-inline"> Present <input name="attendance['.$srbk.']" value="2" type="radio" id="attendance['.$srbk.']" class="checkbox-inline"> Absent';		
		$markbsfiled = '<input type="text" class="form-control col-lg-12" min="0" max="'.$maxmarks.'" id="marks['.$srbk.']" name="marks['.$srbk.']" tabindex="'.$srbk.'" value="'.$valuemarks['marks'].'" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;" '.$marksdisabled.'>';
	} else if($valuemarks['attendance'] == 2 && (($totalbalance == 0 && $valuepayable['Totalpayable']>0 ) && ($attendanceper>=$attendancereq)) || ($valueclearance['allowed'] == 1)) { 
		$attendance = '<input name="attendance['.$srbk.']" type="radio" id="attendance['.$srbk.']" value="1" class="checkbox-inline"> Present <input name="attendance['.$srbk.']"  checked="checked" value="2" type="radio" id="attendance['.$srbk.']" class="checkbox-inline"> Absent';
		$markbsfiled = '<input type="text" class="form-control col-lg-12" min="0" max="'.$maxmarks.'" id="marks['.$srbk.']" name="marks['.$srbk.']" tabindex="'.$srbk.'" value="'.$valuemarks['marks'].'" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;" '.$marksdisabled.'>';
	} else { 
		if((($totalbalance == 0 && $valuepayable['Totalpayable']>0 ) && ($attendanceper>=$attendancereq)) || ($valueclearance['allowed'] == 1)) { 
			$markbsfiled = '<input type="text" class="form-control col-lg-12" min="0" max="'.$maxmarks.'" id="marks['.$srbk.']" name="marks['.$srbk.']" tabindex="'.$srbk.'" value="'.$valuemarks['marks'].'" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;" '.$marksdisabled.'>';
			$attendance = '<input name="attendance['.$srbk.']" type="radio" id="attendance['.$srbk.']" checked="checked" value="1" class="checkbox-inline"> Present <input name="attendance['.$srbk.']" value="2" type="radio" id="attendance['.$srbk.']" class="checkbox-inline"> Absent';
		} else { 
			$attendance = '<input name="attendance['.$srbk.']" type="radio" id="attendance['.$srbk.']" value="1" class="checkbox-inline" disabled > Present <input name="attendance['.$srbk.']"  checked="checked" value="2" type="radio" id="attendance['.$srbk.']" class="checkbox-inline"> Absent';
			$markbsfiled = '<input type="text" class="form-control col-lg-12" min="0" max="'.$maxmarks.'" id="marks['.$srbk.']" name="marks['.$srbk.']" tabindex="'.$srbk.'" value="0" disabled required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;" '.$marksdisabled.'>';
		}
	} 
//------------------------------------------------
echo '
<tr>
	<td style="width:40px;">'.$srbk.'</td>
	<td style="width:60px; text-align:center;">'.$itemstd['std_rollno'].'</td>
	<td style="width:150px;">'.$itemstd['std_regno'].'</td>
	<td>'.$stdphoto.'</td>
	<td><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$itemstd['std_name'].' ('.$itemstd['std_session'].')</b>" data-src="studentdetail.php?std_id='.$itemstd['std_id'].'" href="#">'.$itemstd['std_name'].'</a> </td>
	<td style="width:90px;">'.$markbsfiled.'</td>
	<td style="width:150px;">'.$attendance.'</td>
	<td><input type="text" class="form-control col-lg-12" id="remarks['.$srbk.']" name="remarks['.$srbk.']" tabindex="'.$srbk.'" value="'.$valuemarks['remarks'].'" style="text-align:left;" '.$marksdisabled.'></td>
</tr>
<input type="hidden" name="id_edited['.$srbk.']" id="id_edited['.$srbk.']" value="'.$valuemarks['id'].'">
<input type="hidden" name="id_std['.$srbk.']" id="id_std['.$srbk.']" value="'.$itemstd['std_id'].'">';
//------------------------------------------------

}
//------------------------------------------------
echo '
</tbody>
</table>
<div class="modal-footer" style="'.$submitdisabled .'">
	<button class="btn btn-success" type="submit" value="saveonly" id="submit_lamarks" name="submit_lamarks"> Save </button>
	<button class="btn btn-primary" type="submit" value="saveforward" id="submit_lamarks" name="submit_lamarks"> Save & Forward </button>
</div>

</form>';
//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}