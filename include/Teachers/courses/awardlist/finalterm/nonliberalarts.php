<?php 
$cursstudents 	= array();
$countstudents 	= 0;

$sqllmsmidtermdate  = $dblms->querylms("SELECT paper_startdate as date_start, paper_enddate as date_end, 
											awardlist_addfrom, awardlist_addto
											FROM ".SETTINGS_PAPERS."
											WHERE status = '1' AND examterm = '1' 
											AND (FIND_IN_SET('".$_GET['prgid']."', programs) OR programs LIKE'%all%')
											AND FIND_IN_SET('".$_GET['semester']."', semesters) 	
											AND FIND_IN_SET('".$_GET['timing']."', timings)
											AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND id_campus	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											LIMIT 1");
$rowmidtermdate = mysqli_fetch_array($sqllmsmidtermdate);

//--------------------------------------------------
$sqllmsstds  = $dblms->querylms("SELECT std.std_id, std.std_photo, std.std_name, std.std_rollno, std.std_regno, std.std_session, 
										prg.prg_name, std.std_semester, std.std_section, std.id_prg, std.std_timing     
										FROM ".STUDENTS." std 
										INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
										WHERE (std.std_status = '2' OR std.std_status = '7') 
										AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
										AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND std.id_prg = '".cleanvars($_GET['prgid'])."' 
										AND std.std_timing = '".cleanvars($_GET['timing'])."' 
										AND std.std_semester = '".cleanvars($_GET['semester'])."'
										AND std.std_section =  '".cleanvars($section)."'
										ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC");
while($rowcurstds = mysqli_fetch_array($sqllmsstds)) { 
	$cursstudents[] = array (
								"std_id"		=> $rowcurstds['std_id']		,
								"std_photo"		=> $rowcurstds['std_photo']		,
								"std_name"		=> $rowcurstds['std_name']		,
								"std_session"	=> $rowcurstds['std_session']	,
								"std_rollno"	=> $rowcurstds['std_rollno']	,
								"std_semester"	=> $rowcurstds['std_semester']	,
								"std_regno"		=> $rowcurstds['std_regno']		,
								"id_prg"		=> $rowcurstds['id_prg']		,
								"prg_name"		=> $rowcurstds['prg_name']		,
								"rep_mig"		=> 0	
							);
	$countstudents++;
}

//Repeat/Migration Courses
$sqllmsRepeatCurs  = $dblms->querylms("SELECT std.std_id,std.std_photo,std.std_name,std.std_session, std.std_rollno, 
												rc.semester, std.std_regno, std.id_prg, rr.type, prg.prg_id, prg.prg_name    
											FROM ".REPEAT_COURSES." rc    
											INNER JOIN ".COURSES." c ON c.curs_id = rc.id_curs   
											INNER JOIN ".TIMETABLE." t ON t.id = rc.id_timetable
											INNER JOIN ".REPEAT_REGISTRATION." rr ON rr.id = rc.id_setup    
											INNER JOIN ".STUDENTS." std ON std.std_id = rr.id_std  
											INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
											WHERE rr.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
											AND rr.id_prg = '".cleanvars($_GET['prgid'])."'
											AND rc.id_curs = '".cleanvars($_GET['id'])."'   
											AND rc.semester = '".cleanvars($_GET['semester'])."'   
											AND rc.timing = '".cleanvars($_GET['timing'])."'    
											AND rc.id_teacher = '".cleanvars($rowsstd['emply_id'])."'
											AND t.section = '".cleanvars($_GET['section'])."'
											AND rr.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
											GROUP BY rr.id_std, rc.id_curs ORDER BY c.curs_code ASC");
if(mysqli_num_rows($sqllmsRepeatCurs)>0) {
	//------------------------------------------------
	while($rowrepstds = mysqli_fetch_array($sqllmsRepeatCurs)) {
		$cursstudents[] = array (
									"std_id"		=> $rowrepstds['std_id']		,
									"std_photo"		=> $rowrepstds['std_photo']		,
									"std_name"		=> $rowrepstds['std_name']		,
									"std_session"	=> $rowrepstds['std_session']	,
									"std_rollno"	=> $rowrepstds['std_rollno']	,
									"std_semester"	=> $rowrepstds['semester']		,
									"std_regno"		=> $rowrepstds['std_regno']		,
									"id_prg"		=> $rowrepstds['id_prg']		,
									"prg_name"		=> $rowrepstds['prg_name']		,
									"rep_mig"		=> $rowrepstds['type']	
								);
		$countstudents++;
	}
}
//--------------------Students of Secondary Program--------------------
if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) !=1) { 
	
	$sqllmsstd2ndary  = $dblms->querylms("SELECT std.std_id, std.std_photo, std.std_name, std.std_rollno, std.std_regno,
											std.std_secondarysemester, std.std_secondarysession, std.std_session, 
											std.id_prgsecondary, prg.prg_name  
											FROM ".STUDENTS." std 
											INNER JOIN ".PROGRAMS." prg ON std.id_prgsecondary = prg.prg_id 
											WHERE (std.std_status = '2' OR std.std_status = '7') 
											AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
											AND std.id_campus 		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND std.id_prgsecondary = '".cleanvars($_GET['prgid'])."' 
											AND std.std_timing 		= '".cleanvars($_GET['timing'])."' 
											AND std.std_secondarysemester = '".cleanvars($_GET['semester'])."'
											AND std.std_section =  '".cleanvars($section)."'
											ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC ");
	
	while($rowcur2ndary = mysqli_fetch_array($sqllmsstd2ndary)) { 
		$cursstudents[] = array (
									"std_id"		=> $rowcur2ndary['std_id']				,
									"std_photo"		=> $rowcur2ndary['std_photo']			,
									"std_name"		=> $rowcur2ndary['std_name']			,
									"std_session"	=> $rowcur2ndary['std_secondarysession'],
									"std_rollno"	=> $rowcur2ndary['std_rollno']			,
									"std_semester"	=> $rowcur2ndary['std_secondarysemester'] ,
									"std_regno"		=> $rowcur2ndary['std_regno']			,
									"id_prg"		=> $rowcur2ndary['id_prgsecondary']		,
									"prg_name"		=> $rowcur2ndary['prg_name']			,
									"rep_mig"		=> 0	
								);
		$countstudents++;
	}
	
} 
//--------------------------------------------------
if ($countstudents>0) { 

	$sqllmssetup  = $dblms->querylms("SELECT d.id, d.id_finalterm,  m.exam_date, m.forward_to   
												FROM ".FINALTERM_DETAILS." d 
												INNER JOIN ".FINALTERM." m ON m.id = d.id_finalterm  
												WHERE  m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
												AND m.id_prg = '".cleanvars($_GET['prgid'])."'
												AND m.semester = '".cleanvars($_GET['semester'])."'
												AND m.section 	= '".cleanvars($section)."'
												AND m.timing 	= '".cleanvars($_GET['timing'])."'  
												AND m.theory_practical = '1' 
												AND m.is_liberalarts != '1' 
												AND m.id_curs 	= '".cleanvars($_GET['id'])."' LIMIT 1");
	$valuesetup = mysqli_fetch_array($sqllmssetup);
//------------------------------------------------
$srbk = 0;
$srfin = 0;
//------------------------------------------------
foreach($cursstudents as $itemstd) {  
//------------------------------------------------
	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) == 1) { 


		$addAssignmentPrgSemester = "AND ap.id_prg = '".cleanvars($itemstd['id_prg'])."'
							   AND ap.semester = '".cleanvars($itemstd['std_semester'])."'";

	} else{
		
		$addAssignmentPrgSemester = "";
	}

	$sqllmschecker  = $dblms->querylms("SELECT d.id, d.marks, d.id_std, m.id_curs, m.id
											FROM ".MIDTERM_DETAILS." d 
											INNER JOIN ".MIDTERM." m ON m.id = d.id_midterm  
											WHERE d.id_std 	= '".cleanvars($itemstd['std_id'])."' 
											AND m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										  	AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND m.id_prg = '".cleanvars($_GET['prgid'])."'
											AND m.semester = '".cleanvars($_GET['semester'])."'
											AND m.section 	= '".cleanvars($section)."'
											AND m.timing 	= '".cleanvars($_GET['timing'])."'
											AND m.id_curs 	= '".cleanvars($_GET['id'])."'  LIMIT 1");
	$valuemarks 	= mysqli_fetch_array($sqllmschecker);
	if($valuemarks['marks']) {
		$stdmidmarks = $valuemarks['marks'];
	} else { 
		$stdmidmarks = '';
	}
	
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
										AND ea.id_term = '2' 
										AND ca.id_curs = '".cleanvars($_GET['id'])."' 
										AND ea.timing = '".cleanvars($_GET['timing'])."' 
										AND ea.id_std = '".$itemstd['std_id']."' ");
	$valueclearance	= mysqli_fetch_array($sqllmsclearance);
	
//-----------------------Attendance Checker-------------------------
if($rowsstd['emply_id'] == '1016') { 
	$attendanceper = 100;
} elseif($rowsetting['exclude_attendance'] == $itemstd['std_session']) {
	$attendanceper = 100;
} else {

	$attendanceCheckSQL = " AND at.dated > '".$rowmidtermdate['date_start']."'";

	//For Campuses Other than MUL
	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) != '1'){

		$sqllmsProgram  = $dblms->querylms("SELECT prg_under_mul     
												FROM ".PROGRAMS."
												WHERE prg_id = '".cleanvars($itemstd['id_prg'])."'
												LIMIT 1");
		$valueProgram = mysqli_fetch_array($sqllmsProgram);

		if($valueProgram['prg_under_mul'] == 0){

			$attendanceCheckSQL = " AND at.dated != '0000-00-00'";

		}

	}

	//Student Attendance Percentage
	$sqllmsAttendanceCount  = $dblms->querylms("SELECT 
														COUNT(CASE WHEN at.theorypractical = '1' $attendanceCheckSQL then 1 else null end) totalFinalTheoryLectures,
														COUNT(CASE WHEN at.theorypractical = '1' $attendanceCheckSQL AND dt.status = '2' then 1 else null end) totalFinalTheoryPresent
														FROM ".COURSES_ATTENDANCE_DETAIL." dt
														INNER JOIN ".COURSES_ATTENDANCE." at ON at.id = dt.id_setup 
														INNER JOIN ".STUDENTS." std  ON std.std_id = dt.id_std  
														WHERE at.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
														AND at.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
														AND at.id_curs = '".cleanvars($_GET['id'])."' 
														AND at.id_prg  = '".cleanvars($_GET['prgid'])."' 
														AND at.semester = '".cleanvars($_GET['semester'])."' 
														AND at.timing = '".cleanvars($_GET['timing'])."' 
														AND dt.id_std = '".cleanvars($itemstd['std_id'])."'");
	
	$rowAttendanceCount = mysqli_fetch_assoc($sqllmsAttendanceCount);
	if($rowAttendanceCount['totalFinalTheoryLectures']) { 
		$attendanceper = round(($rowAttendanceCount['totalFinalTheoryPresent']/$rowAttendanceCount['totalFinalTheoryLectures']) * 100); 
	} else { 
		$attendanceper = 0; 
	}
	
}
	if($attendanceper>=90) { 

		$attendancemarks = 5;
	} else if($attendanceper>=80) { 
		$attendancemarks = 4;
	} else if($attendanceper>=70) { 
		$attendancemarks = 3;
	} else if($attendanceper>=63) { 
		$attendancemarks = 2;
	} else { 
		$attendancemarks = 0;
	}

//------------------------------------------------
	$sqllmsfinalterm  = $dblms->querylms("SELECT fd.id, fd.id_finalterm, fd.assignment, fd.quiz, fd.attendance, 
												fd.marks_obtained, fd.numerical, 
												 fd.finalterm, fd.viva, fd.gradepoint, fd.lettergrade, fd.remarks, f.exam_date, f.forward_to, f.section  
												FROM ".FINALTERM_DETAILS." fd 
												INNER JOIN ".FINALTERM." f ON f.id = fd.id_finalterm  
												WHERE fd.id_std 	= '".cleanvars($itemstd['std_id'])."' 
												AND f.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										  		AND f.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
												AND f.id_prg 	= '".cleanvars($itemstd['id_prg'])."' 
												AND f.semester 	= '".cleanvars($_GET['semester'])."' 
												AND f.timing 	= '".cleanvars($_GET['timing'])."'
												AND f.id_teacher = '".cleanvars($rowsurs['id_teacher'])."'
												AND f.id_curs 	= '".cleanvars($_GET['id'])."' 
												AND f.is_liberalarts 	!= '1' 
												AND f.theory_practical 	= '1'
												ORDER BY f.id DESC LIMIT 1");
	$valfinalterm 	= mysqli_fetch_array($sqllmsfinalterm);
	
if($valuesetup['id_finalterm']) { 
	
	$printaward = '<div style="float:right;"><a class="btn btn-mid btn-info" href="finaltermawardprint.php?id='.$valuesetup['id_finalterm'].'" target="_blank"><i class="icon-print"></i> Print Sheet</a></div>';
} else { 
	$printaward = '';
}
//----------------------------------------------------
if($valfinalterm['finalterm']) 		{ $stdfinalmarks 	= $valfinalterm['finalterm']; 		} else {  $stdfinalmarks 	= ''; }
//----------------------------------------------------
if($valfinalterm['viva']) 			{ $stdvivamarks 	= $valfinalterm['viva'];} else { $stdvivamarks = ''; }
//----------------------------------------------------
if($valfinalterm['assignment']) 	{ $stdassignment 	= $valfinalterm['assignment']; 		} else {  $stdassignment 	= ''; }
//----------------------------------------------------
if($valfinalterm['quiz']) 			{ $stdquiz 			= $valfinalterm['quiz']; 			} else {  $stdquiz 			= ''; }
//----------------------------------------------------
if($valfinalterm['attendance']) 	{ $stdattendance 	= $valfinalterm['attendance']; 		} else {  $stdattendance 	= $attendancemarks; }
//----------------------------------------------------
if($valfinalterm['marks_obtained']) { $stdmarksobtained = $valfinalterm['marks_obtained']; 	} else {  $stdmarksobtained = ''; }
//----------------------------------------------------
if($valfinalterm['numerical']) 		{ $stdnumerical 	= $valfinalterm['numerical']; 		} else {  $stdnumerical 	= ''; }
//----------------------------------------------------
if($valfinalterm['gradepoint']) 	{ $stdgradepoint 	= $valfinalterm['gradepoint']; 		} else {  $stdgradepoint 	= ''; }
//----------------------------------------------------
if($valfinalterm['lettergrade']) 	{ $stdlettergrade 	= $valfinalterm['lettergrade']; 	} else {  $stdlettergrade 	= ''; }
//----------------------------------------------------
if($valfinalterm['remarks']) 		{ $stdremarks 		= $valfinalterm['remarks']; 		} else {  $stdremarks 		= ''; }
//----------------------------------------------------
if($valuesetup['exam_date']) 		{ $examdate 		= $valuesetup['exam_date']; 		} else {  $examdate 		= ''; }
//--------------------------------------------
$srfin++;
if($srfin == 1) {
//--------------------------------------------
	if(($valuesetup['forward_to'] != 4) && $valuesetup['id_finalterm']) {
		echo '<div  class="alert-box error" style="font-size:16px; font-weight:600;">Result is save local only not forward to HOD.</b></div>';
		$readonly = "";
	}  else {
		$readonly = "";
	}
	
	if($valuesetup['forward_to'] == 4) {
		$readonly 	= "readonly";
		$disabled 	= 'disabled';
		$buttonlink = '';
	} else {
		$readonly 	= "";

		$disabled 	= '';
		$buttonlink = '<div class="modal-footer" '.$style.'>
	<button class="btn btn-success" type="submit" value="saveonly" id="submit_marks" name="submit_marks" onClick=\'return confirmSubmit()\'> Save </button>
	<button class="btn btn-primary" type="submit" value="saveforward" id="submit_marks" name="submit_marks" onClick=\'return confirmSubmit()\'> Save & Forward </button>
</div>';
	}
//--------------------------------------------
echo ' 
<div style="clear:both;"></div>
<form class="form-horizontal" action="#" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="id_curs" id="id_curs" value="'.$_GET['id'].'">
<input type="hidden" name="id_setup" id="id_setup" value="'.$valuesetup['id_finalterm'].'">
<input type="hidden" name="id_teacher" id="id_teacher" value="'.$rowsurs['id_teacher'].'">
<div style="margin-top:10px; font-weight:600; font-size:14px; ">
	Subject:  <span style="width:80%; display: inline-block; border-bottom:1px dashed #666;color:#00f;">'.$rowsurs['curs_code'].' - '.$rowsurs['curs_name'].'</span> 
</div>
<div style="clear:both;"></div>
<div style="margin-top:10px;">
	<span class="req" style="font-weight:600;">Examination Date</span> <input class="pickadate" name="exam_date" id="exam_date" type="text" value="'.$examdate.'" required autocomplete="off" class="form-control" '.$disabled.'> 
	<span style="margin-right:20px; float:right; font-weight:600;"> Forward to :
		<select id="forward_to" name="forward_to" style="width:150px;"  autocomplete="off" '.$disabled.'>
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
<br>
'.$printaward.'
<div style="clear:both;"></div>

<table class="table table-bordered table-with-avatar invE_table">
<thead>
<tr>
	<th style="font-weight:600; font-size:11px; vertical-align:middle;">Sr.# </th>
	<th style="font-weight:600; font-size:11px;vertical-align:middle;">Roll #</th>
	<th width="35px" style="font-weight:600; font-size:11px;vertical-align:middle;">Pic</th>
	<th style="font-weight:600; font-size:11px;vertical-align:middle;">Student Name</th>
	<th style="font-weight:600; font-size:11px; text-align:center;">Assignment (10)</th>
	<th style="font-weight:600; font-size:11px; text-align:center;">Quiz/pres (10)</th>
	<th style="font-weight:600; font-size:11px; text-align:center;">Attendance (5)</th>
	<th style="font-weight:600; font-size:11px; text-align:center;">Mid Term 25%</th>
	<th style="font-weight:600; font-size:11px; text-align:center;">Final Term 50%</th>';
	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) != 1) { 
	echo '
	<th style="font-weight:600; font-size:11px; text-align:center;">Viva</th>';
	}
	echo '
	<th style="font-weight:600; font-size:11px; text-align:center;">Marks Obtained</th>
	<th style="font-weight:600; font-size:11px; text-align:center;">Numerical Point (A)</th>
	<th style="font-weight:600; font-size:11px; text-align:center;">Credit Hours (B)</th>
	<th style="font-weight:600; font-size:11px; text-align:center;">Grade Points(AxB)</th>
	<th style="font-weight:600; font-size:11px; text-align:center;">Letter Grade</th>
	<th style="font-weight:600; font-size:11px; text-align:center;vertical-align:middle;">Remarks</th>
</tr>
</thead>
<tbody>';
}
if(($totalbalance == 0 && $valuepayable['Totalpayable']>0) || $valueclearance['allowed'] == 1) { 
if(($attendanceper>=$attendancereq) || $valueclearance['allowed'] == 1) {  

//------------------------------------------------
$srbk++;
if($itemstd['std_photo']) { 
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$itemstd['std_photo'].'" alt="'.$itemstd['std_name'].'"/>';
} else {
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$itemstd['std_name'].'"/>';
}
	
if($stdfinalmarks) {
	
	$finaltermmarks = $stdfinalmarks;
	
} else {
	
	$finaltermmarks = '';
}

if($stdassignment) { 
	
	$assignmarks = $stdassignment;
	
} else {
	
	$sqllmstotalassign  = $dblms->querylms("SELECT SUM(ad.total_marks) AS Totalmarks 
										FROM ".COURSES_ASSIGNMENTS." ad  
										INNER JOIN ".COURSES_ASSIGNMENTSPROGRAM." ap ON ad.id = ap.id_setup    
										WHERE ad.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND ad.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND ad.id_curs = '".cleanvars($_GET['id'])."'
										$addAssignmentPrgSemester 
										AND ap.timing = '".cleanvars($_GET['timing'])."'
										AND ad.is_midterm != '1' 
										AND ap.section = '".cleanvars($quesec)."' ");
	$rowassign 			= mysqli_fetch_assoc($sqllmstotalassign);
	$assigntotalmarks 	= $rowassign['Totalmarks'];
	
	
	$sqllmsassignstd  = $dblms->querylms("SELECT SUM(astd.marks) AS TotalStudentMarks     
										FROM ".COURSES_ASSIGNMENTS_STUDENTS." astd  
										INNER JOIN ".COURSES_ASSIGNMENTS." assign ON assign.id = astd.id_assignment     
										WHERE assign.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND assign.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND assign.id_curs = '".cleanvars($_GET['id'])."' 
										AND assign.is_midterm != '1' 
										AND astd.id_std = '".cleanvars($itemstd['std_id'])."' ");
	
	$rowstdassign 	= mysqli_fetch_assoc($sqllmsassignstd);
	$assigstdnmarks = $rowstdassign['TotalStudentMarks'];
	if($rowassign['Totalmarks']>0) {
		$assignmarks 	= round(($rowstdassign['TotalStudentMarks']/$rowassign['Totalmarks'])*10);
	} else {
		$assignmarks 	= '';
	}
} 
	
if($stdquiz) { 
	
	$quickmarks = $stdquiz;
} else {
//------------------------------------------------
		$quickmarks = '';
	
	
}
//------------------------------------------------
echo '
<tr class="inv_row">
	<td style="width:40px;">'.$srbk.' </td>
	<td style="width:50px; text-align:center;">'.$itemstd['std_rollno'].'</td>
	<td>'.$stdphoto.'</td>
	<td><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$rowcurstds['std_name'].' ('.$itemstd['std_session'].')</b>" data-src="studentdetail.php?std_id='.$itemstd['std_id'].'" href="#">'.$itemstd['std_name'].'</a> </td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_assign" min="0" max="10" id="assignment['.$srbk.']" name="assignment['.$srbk.']" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;"  value="'.$assignmarks.'" '.$readonly.'></td>
	<td style="width:70px;"><input type="text" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" class="form-control col-lg-12 jQinv_item_quiz" min="0" max="10" id="quiz['.$srbk.']" name="quiz['.$srbk.']" required autocomplete="off" style="text-align:center;" value="'.$quickmarks.'" '.$readonly.'></td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_attendance" min="0" max="5" id="attendance['.$srbk.']" name="attendance['.$srbk.']" autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;" value="'.$stdattendance.'" '.$readonly.$attendancelock.'></td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_midterm" min="1" max="25" id="midterm['.$srbk.']" name="midterm['.$srbk.']" readonly style="text-align:center;" value="'.$stdmidmarks.'"></td>
	<td style="width:75px;"><input type="text" class="form-control col-lg-12 jQinv_item_finalterm" min="0" max="50" id="finalterm['.$srbk.']" name="finalterm['.$srbk.']" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;" value="'.$finaltermmarks.'" '.$readonly.' ></td>';
	
	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) != 1) { 
	echo '
	<td style="width:80px;"><input type="number" class="form-control col-lg-12 jQinv_item_viva" min="0" max="50" id="viva['.$srbk.']" name="viva['.$srbk.']" autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;" value="'.$stdvivamarks.'"></td>';
	}
	
	echo '
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_obtained" min="1" max="25" id=marks_obtained['.$srbk.']" name="marks_obtained['.$srbk.']" readonly style="text-align:center;" value="'.$stdmarksobtained.'"></td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_numerical" min="1" max="25" id="numerical['.$srbk.']" name="numerical['.$srbk.']" readonly style="text-align:center;" value="'.$stdnumerical.'"></td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_credithour" id="credithour['.$srbk.']" name="credithour['.$srbk.']" readonly style="text-align:center;" value="'.$rowsurs['cur_credithours_theory'].'"></td>
	<td style="width:60px;"><input type="text" class="form-control col-lg-12 jQinv_item_gradepoint" id="gradepoint['.$srbk.']" name="gradepoint['.$srbk.']" readonly value="'.$stdgradepoint.'"></td>
	<td style="width:60px;"><input type="text" class="form-control col-lg-12 jQinv_item_lettergrade" id="lettergrade['.$srbk.']" name="lettergrade['.$srbk.']" readonly style="text-align:center;" value="'.$stdlettergrade.'"></td>
	<td style="width:90px;"><input type="text" class="form-control col-lg-12 jQinv_item_remarks" id="remarks['.$srbk.']" name="remarks['.$srbk.']"  value="'.$stdremarks.'"  '.$readonly.'></td>

</tr>
<input type="hidden" name="id_std['.$srbk.']" id="id_std['.$srbk.']" value="'.$itemstd['std_id'].'">
<input type="hidden" name="rep_mig['.$srbk.']" id="rep_mig['.$srbk.']" value="'.$itemstd['rep_mig'].'">
<input type="hidden" name="assignment_default['.$srbk.']" id="assignment_default['.$srbk.']" value="'.$assignmarks.'">
<input type="hidden" name="quiz_default['.$srbk.']" id="quiz_default['.$srbk.']" value="'.$quickmarks.'">
<input type="hidden" name="finalterm_default['.$srbk.']" id="finalterm_default['.$srbk.']" value="'.$finaltermmarks.'">
<input type="hidden" name="id_edit['.$srbk.']" id="id_edit['.$srbk.']" value="'.$valfinalterm['id'].'">';
}
//------------------------------------------------

}
//------------------------------------------------
}
//------------------------------------------------
echo '
</tbody>
<tr class="last_row">
	<td colspan="20" style="text-align:right;">
</tr>
</table>
'.$buttonlink.'

</form>
<script LANGUAGE="JavaScript">
<!--
function confirmSubmit() {
	var agree=confirm("Are you sure you wish to continue?");
	if (agree)
	 return true ;
	else
	 return false ;
	}
// -->
</script>';

} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}
