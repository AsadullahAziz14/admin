<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">';
//--------------------------------------

echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Mid Term Award List</h3></span>
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
//-----------------------Mid term Examination-------------------------
if($_GET['timing'] == 1) { 
$sqllmsfeecats  = $dblms->querylms("SELECT d.id, d.id_setup, d.id_cat, d.date_start, d.date_end, d.remarks  
										FROM ".ACALENDAR_DETAILS." d 
										INNER JOIN ".ACALENDAR." c ON c.id = d.id_setup
										WHERE c.status = '1' AND c.published = '1' AND c.for_program = '1'
										AND c.id_campus	= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
										AND c.session = '".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 
										AND d.id_cat = '7' LIMIT 1");
//------------------------------------------------
$rowfeecats = mysqli_fetch_array($sqllmsfeecats);
} else if($_GET['timing'] == 2) {
$sqllmsfeecats  = $dblms->querylms("SELECT d.id, d.id_setup, d.id_cat, d.date_start, d.date_end, d.remarks  
										FROM ".ACALENDAR_DETAILS." d 
										INNER JOIN ".ACALENDAR." c ON c.id = d.id_setup
										WHERE c.status = '1' AND c.published = '1' AND c.for_program = '2'
										AND c.id_campus	= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
										AND c.session = '".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 
										AND d.id_cat = '7' LIMIT 1");
//------------------------------------------------
$rowfeecats = mysqli_fetch_array($sqllmsfeecats);
}
//-----------------------Mid term Examination-------------------------
if($rowfeecats['date_start']>date("Y-m-d")) { 
//--------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification" style="font-weight:600; color:blue;">After Mid term exam, you will be able to upload students award list.</div>
</div>';
//--------------------------------------
} else { 
//-----------------------Mid term Result Submission-------------------------
if($_GET['timing'] == 1) { 
$sqllmsmidresult  = $dblms->querylms("SELECT d.id, d.id_setup, d.id_cat, d.date_start, d.date_end, d.remarks  
										FROM ".ACALENDAR_DETAILS." d 
										INNER JOIN ".ACALENDAR." c ON c.id = d.id_setup
										WHERE c.status = '1' AND c.published = '1' AND c.for_program = '1'
										AND c.id_campus	= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
										AND c.session = '".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 
										AND d.id_cat = '8' LIMIT 1");
//------------------------------------------------
$rowmidres = mysqli_fetch_array($sqllmsmidresult);
} else if($_GET['timing'] == 2) {
$sqllmsmidresult  = $dblms->querylms("SELECT d.id, d.id_setup, d.id_cat, d.date_start, d.date_end, d.remarks  
										FROM ".ACALENDAR_DETAILS." d 
										INNER JOIN ".ACALENDAR." c ON c.id = d.id_setup
										WHERE c.status = '1' AND c.published = '1' AND c.for_program = '2'
										AND c.id_campus	= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
										AND c.session = '".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 
										AND d.id_cat = '8' LIMIT 1");
//------------------------------------------------
$rowmidres = mysqli_fetch_array($sqllmsmidresult);
}

if(isset($_GET['section'])) {  
	$section 		= $_GET['section'];
	$seccursquery 	= " AND at.section = '".$_GET['section']."'";
} else { 
	$section 		= '';
	$seccursquery 	= "";
}
//--------------------------------------
if(isset($_POST['submit_marks'])) { 

//------------------------------------------------
if(empty($_POST['id_setup'])) { 
	$sqllmschecker  = $dblms->querylms("SELECT * 
												FROM ".MIDTERM." m 
												WHERE m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										  		AND m.id_prg 	= '".cleanvars($_GET['prgid'])."' 
												AND m.timing 	= '".cleanvars($_GET['timing'])."' 
											  	AND m.semester 	= '".cleanvars($_GET['semester'])."' 
												AND m.id_teacher = '".cleanvars($_POST['id_teacher'])."'
												AND m.section 	= '".cleanvars($section)."'
												AND m.id_curs 	= '".cleanvars($_POST['id_curs'])."' LIMIT 1");
	$valuemarks 		= mysqli_fetch_array($sqllmschecker);
if($valuemarks['id']) { 
	echo '<div class="alert-box warning"><span>warning: </span>Record already added.</div>';
} else {
	$sqllms = $dblms->querylms("INSERT INTO ".MIDTERM." (
															status										,
															forward_to									,
															id_curs										,
															section										, 
															semester									, 
															timing										, 
															id_prg										, 
															id_teacher									, 
															dated										, 
															exam_date									,
															academic_session							, 
															id_campus									,
															id_added									,
															date_added
														)
												VALUES (
															'1'											, 
															'".cleanvars($_POST['forward_to'])."'		, 
															'".cleanvars($_POST['id_curs'])."'			, 
															'".cleanvars($_POST['stdsection'])."'			, 
															'".cleanvars($_POST['stdsemester'])."'			, 
															'".cleanvars($_POST['stdtiming'])."'			, 
															'".cleanvars($_POST['prgid'])."'			, 
															'".cleanvars($_POST['id_teacher'])."'		, 
															'".date('Y-m-d')."'								, 
															'".date('Y-m-d', strtotime($_POST['exam_date']))."'				, 
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'	,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'		,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'			, 
															NOW()			
														)
							");

//--------------------------------------
if($sqllms) {
$idsetup = $dblms->lastestid();
//--------------------------------------
	$logremarks = 'Add Student Mid Term Award List #: '.$idsetup.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGS." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															id_campus				
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'				,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."'			, 
															'1'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($logremarks)."'						,
															'".cleanvars(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']))."'			
														  )
									");
//--------------------------------------
	$arraychecked = $_POST['id_std'];
//--------------------------------------
	for($ichk=1; $ichk<=sizeof($arraychecked); $ichk++){
//------------------------------------------------
		if($_POST['attendance'][$ichk] == 1) { 
			$marks = $_POST['marks'][$ichk];
		} else { 
			$marks = 0;
		}
//------------------------------------------------
			$sqllmsmulti  = $dblms->querylms("INSERT INTO ".MIDTERM_DETAILS."( 
																				id_midterm									,
																				id_std										, 
																				marks										,
																				attendance								
																			)
	   																VALUES (
																				'".$idsetup."'									, 
																				'".cleanvars($_POST['id_std'][$ichk])."'		, 
																				'".cleanvars($marks)."'							,
																				'".cleanvars($_POST['attendance'][$ichk])."'	
																			)
										");
		}
//------------------------------------------------
	echo '<div id="infoupdated" class="alert-box success"><span>success: </span>Record added successfully.</div>';
//------------------------------------------------
}
}
//--------------------------------------
} else { 
//--------------------------------------
	$sqllms  = $dblms->querylms("UPDATE ".MIDTERM." SET status		= '1'
													, forward_to	= '".cleanvars($_POST['forward_to'])."' 
													, dated			= '".date("Y-m-d")."' 
													, exam_date		= '".date('Y-m-d', strtotime($_POST['exam_date']))."' 
													, id_modify		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' 
													, date_modify	= NOW() 
												WHERE id			= '".cleanvars($_POST['id_setup'])."'");

//--------------------------------------
if($sqllms) {
//--------------------------------------
	$logremarks = 'Update Student Mid Term Award List #: '.$_POST['id_setup'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGS." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															id_campus				
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'				,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."'			, 
															'2'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($logremarks)."'						,
															'".cleanvars(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']))."'			
														  )
									");

//--------------------------------------
//	$sqllmsdelte  = $dblms->querylms("DELETE FROM ".MIDTERM_DETAILS." WHERE id_midterm = '".$_POST['id_setup']."'");
//--------------------------------------
	$arraychecked = $_POST['id_std'];

//--------------------------------------
	for($ichk=1; $ichk<=sizeof($arraychecked); $ichk++){
//------------------------------------------------
	if($_POST['attendance'][$ichk] == 1) { 
		$marks = $_POST['marks'][$ichk];
	} else { 
		$marks = 0;
	}
if(!empty($_POST['id_edited'][$ichk])) { 
//------------------------------------------------
	$sqllmsmulti  = $dblms->querylms("UPDATE ".MIDTERM_DETAILS." SET 
															marks		= '".cleanvars($marks)."'
														  , attendance	= '".cleanvars($_POST['attendance'][$ichk])."'
													  WHERE  id	= '".cleanvars($_POST['id_edited'][$ichk])."' ");
} else { 
//------------------------------------------------
			$sqllmsmulti  = $dblms->querylms("INSERT INTO ".MIDTERM_DETAILS."( 
																				id_midterm									,
																				id_std										, 
																				marks										,
																				attendance									
																			)
	   																VALUES (
																				'".$_POST['id_setup']."'					, 
																				'".cleanvars($_POST['id_std'][$ichk])."'	, 
																				'".cleanvars($marks)."'						,
																				'".cleanvars($_POST['attendance'][$ichk])."'	
																			)
										");
		}
}
//------------------------------------------------
	echo '<div id="infoupdated" class="alert-box success"><span>success: </span>Record Update successfully.</div>';
//------------------------------------------------
}
//--------------------------------------
}
//--------------------------------------
} 

$cursstudents = array();
$countstudents = 0;

if(isset($_GET['section'])) {
	$stdsection 	= " AND std.std_section =  '".cleanvars($_GET['section'])."'"; 
	$seccursquery 	= " AND at.section = '".$_GET['section']."'";
} else { 
	$stdsection 	= " "; 
	$seccursquery 	= "";
}
//echo 'Time: '.$rowtsurs['timing'].' Prg: '.$rowtsurs['id_prg'].' semester: '.$rowtsurs['semester'];
//--------------------------------------------------
		$sqllmsstds  = $dblms->querylms("SELECT std.std_id, std.std_photo, std.std_name, std.std_rollno, std.std_regno, std.std_session, 
											std.std_timing, prg.prg_name  
											FROM ".STUDENTS." std 
											INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
											WHERE (std.std_status = '2' OR std.std_status = '7') AND std.std_struckoffresticate != '1' 
											AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND std.id_prg = '".cleanvars($_GET['prgid'])."' 
											AND std.std_timing = '".cleanvars($_GET['timing'])."' 
											AND std.std_semester = '".cleanvars($_GET['semester'])."' $stdsection 
											ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC");
	while($rowcurstds = mysqli_fetch_array($sqllmsstds)) { 
		$cursstudents[] = $rowcurstds;
		$countstudents++;
	}

//--------------------------------------------------
if ($countstudents>0) {
//$valuecount1  = mysqli_fetch_array($sqllmsstds);
$srbk = 0;

	$sqllmssetup  = $dblms->querylms("SELECT m.id   
												FROM ".MIDTERM." m 
												WHERE m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										  		AND m.id_prg 	= '".cleanvars($_GET['prgid'])."' 
												AND m.timing 	= '".cleanvars($_GET['timing'])."' 
											  	AND m.semester 	= '".cleanvars($_GET['semester'])."' 
												AND m.section 	= '".cleanvars($section)."' 
												AND m.id_curs 	= '".cleanvars($_GET['id'])."' LIMIT 1");
	$valuesetup = mysqli_fetch_array($sqllmssetup);
//------------------------------------------------
foreach($cursstudents as $itemstd) { 
//-----------------Fee Status-------------------------------
	$sqllmspayable  = $dblms->querylms("SELECT SUM(total_amount) AS Totalpayable, SUM(arrears) AS Totalpayarrears  
											FROM ".FEES." 
											WHERE id_std = '".$itemstd['std_id']."' ");
	$valuepayable	= mysqli_fetch_array($sqllmspayable);
//------------------------------------------------
	$sqllmspaid  	= $dblms->querylms("SELECT SUM(total_amount) AS Totalpaid, SUM(arrears) AS Totalarrears   
											FROM ".FEES." 
											WHERE id_std = '".$itemstd['std_id']."'
											AND paid_date != '0000-00-00' ");
	$valuepaid		= mysqli_fetch_array($sqllmspaid);
	$totalbalance 	= (($valuepayable['Totalpayable'] + $valuepayable['Totalpayarrears']) - ($valuepaid['Totalpaid'] + $valuepaid['Totalarrears']));
//----------------Attendance--------------------------------
if($_GET['timing'] == 1) {
//------------------------------------------------
	$sqllmsattendance  = $dblms->querylms("SELECT at.lectureno, at.dated, dt.status, dt.remarks     
										FROM ".COURSES_ATTENDANCE_DETAIL." dt
										INNER JOIN ".COURSES_ATTENDANCE." at ON at.id = dt.id_setup 
										WHERE at.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND at.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
										AND at.id_curs = '".cleanvars($_GET['id'])."' 
										AND at.semester = '".cleanvars($_GET['semester'])."' 
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
	$attendanceper = round(($totalpresent/$totallecture) * 100);

} else if($_GET['timing'] == 2) {
//------------------------------------------------
	$sqllmsattendance  = $dblms->querylms("SELECT at.total_lectures, dt.lecture_percent         
										FROM ".STUDENTS_ATTENDANCEDETAILS." dt
										INNER JOIN ".STUDENTS_ATTENDANCE." at ON at.id = dt.id_setup 
										WHERE at.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND at.id_curs = '".cleanvars($_GET['id'])."' $seccursquery 
										AND at.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
										AND dt.id_std = '".cleanvars($itemstd['std_id'])."'");
	$rowattendance = mysqli_fetch_assoc($sqllmsattendance);
	$attendanceper = round(($rowattendance['lecture_percent']/$rowattendance['total_lectures']) * 100);
}
//------------------------------------------------
$srbk++;
	$sqllmschecker  = $dblms->querylms("SELECT d.id, d.id_midterm, d.marks, d.attendance, d.remarks, m.exam_date, m.forward_to   
												FROM ".MIDTERM_DETAILS." d 
												INNER JOIN ".MIDTERM." m ON m.id = d.id_midterm  
												WHERE d.id_std 	= '".cleanvars($itemstd['std_id'])."' 
												AND m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										  		AND m.id_prg 	= '".cleanvars($_GET['prgid'])."' 
												AND m.timing 	= '".cleanvars($_GET['timing'])."' 
											  	AND m.semester 	= '".cleanvars($_GET['semester'])."' 
												AND m.section 	= '".cleanvars($section)."' 
												AND m.id_curs 	= '".cleanvars($_GET['id'])."' LIMIT 1");
	$valuemarks 		= mysqli_fetch_array($sqllmschecker);
if($valuemarks['id_midterm']) {
	$printaward = '<a class="btn btn-mid btn-info" href="midtermawardprint.php?id='.$valuemarks['id_midterm'].'" target="_blank"><i class="icon-print"></i> Print Sheet</a>';
} else { 
	$printaward = ' ';
}
if(date("Y-m-d")>$rowmidres['date_start']) { 
	$examdisabled = 'disabled';
	$marksdisabled = 'readonly';
	$submitdisabled = 'display:none;';
} else { 
	$examdisabled = '';
	$marksdisabled = '';
	$submitdisabled = '';
}
if($valuemarks['marks']) {
	$stdmarks = $valuemarks['marks'];
} else { 
	$stdmarks = '';
}

if($valuemarks['exam_date'] != '0000-00-00') {
	$exmdate = $valuemarks['exam_date'];
} else { 
	$exmdate = '';
}
//--------------------------------------------
if($valuemarks['attendance'] == 1) { 
	$attendance = '<input name="attendance['.$srbk.']" type="radio" id="attendance['.$srbk.']" checked="checked" value="1" class="checkbox-inline"> Present <input name="attendance['.$srbk.']" value="2" type="radio" id="attendance['.$srbk.']" class="checkbox-inline"> Absent';
} else if($valuemarks['attendance'] == 2) { 
	$attendance = '<input name="attendance['.$srbk.']" type="radio" id="attendance['.$srbk.']" value="1" class="checkbox-inline"> Present <input name="attendance['.$srbk.']"  checked="checked" value="2" type="radio" id="attendance['.$srbk.']" class="checkbox-inline"> Absent';
} else { 
	$attendance = '<input name="attendance['.$srbk.']" type="radio" id="attendance['.$srbk.']" checked="checked" value="1" class="checkbox-inline"> Present <input name="attendance['.$srbk.']" value="2" type="radio" id="attendance['.$srbk.']" class="checkbox-inline"> Absent';
} 
//--------------------------------------------
if($srbk == 1) {
echo '
<div style="clear:both;"></div>
<form class="form-horizontal" action="#" method="post" id="addNewUsr" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="id_curs" id="id_curs" value="'.$_GET['id'].'">
<input type="hidden" name="stdsection" id="stdsection" value="'.$section.'">
<input type="hidden" name="stdsemester" id="stdsemester" value="'.$_GET['semester'].'">
<input type="hidden" name="stdtiming" id="stdtiming" value="'.$_GET['timing'].'">
<input type="hidden" name="prgid" id="prgid" value="'.$_GET['prgid'].'">
<input type="hidden" name="id_teacher" id="id_teacher" value="'.$rowsurs['id_teacher'].'">
<div style="margin-top:10px;">
	Subject:  <span style="width:80%; display: inline-block; border-bottom:1px dashed #666;">'.$rowsurs['curs_code'].' - '.$rowsurs['curs_name'].'</span> 
</div>
<div style="clear:both;"></div>
<div style="margin-top:10px;">
	<span class="req" style="font-weight:600;">Examination Date</span> <input name="exam_date" id="exam_date" type="date" value="'.$exmdate.'" required autocomplete="off" '.$examdisabled.'> 
	<span style="margin-left:250px;font-weight:600;"> Forward to :
		<select id="forward_to" name="forward_to" style="width:150px;"  autocomplete="off">
				<option value="">Select Forward</option>';
				if($valuemarks['forward_to'] == 4) {
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
	Total Students: ('.number_format($countstudents).') '.$printaward.' 
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
if($totalbalance == 0 && $valuepayable['Totalpayable']>0) { 
if($itemstd['std_timing'] == 1) {
if(($attendanceper>=$rowsetting['midterm_mattendance'])) { 
//------------------------------------------------
echo '
<tr>
	<td style="width:40px;">'.$srbk.'</td>
	<td style="width:60px; text-align:center;">'.$itemstd['std_rollno'].'</td>
	<td style="width:150px;">'.$itemstd['std_regno'].'</td>
	<td>'.$stdphoto.'</td>
	<td><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$itemstd['std_name'].' ('.$itemstd['std_session'].')</b>" data-src="studentdetail.php?std_id='.$itemstd['std_id'].'" href="#">'.$itemstd['std_name'].'</a> </td>
	<td style="width:90px;"><input type="number" class="form-control col-lg-12" min="0" max="25" id="marks['.$srbk.']" name="marks['.$srbk.']" tabindex="'.$srbk.'" value="'.$valuemarks['marks'].'" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;" '.$marksdisabled.'></td>
	<td style="width:150px;">'.$attendance.'</td>
</tr>
<input type="hidden" name="id_edited['.$srbk.']" id="id_edited['.$srbk.']" value="'.$valuemarks['id'].'">
<input type="hidden" name="id_std['.$srbk.']" id="id_std['.$srbk.']" value="'.$itemstd['std_id'].'">
<input type="hidden" name="id_setup" id="id_setup" value="'.$valuesetup['id'].'">';
//------------------------------------------------
}
} else if($itemstd['std_timing'] == 2) { 
if(($attendanceper>=$rowsetting['midterm_eattendance'])) { 
//------------------------------------------------
echo '
<tr>
	<td style="width:40px;">'.$srbk.'</td>
	<td style="width:60px; text-align:center;">'.$itemstd['std_rollno'].'</td>
	<td style="width:150px;">'.$itemstd['std_regno'].'</td>
	<td>'.$stdphoto.'</td>
	<td><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$itemstd['std_name'].' ('.$itemstd['std_session'].')</b>" data-src="studentdetail.php?std_id='.$itemstd['std_id'].'" href="#">'.$itemstd['std_name'].'</a> </td>
	<td style="width:90px;"><input type="number" class="form-control col-lg-12" min="0" max="25" id="marks['.$srbk.']" name="marks['.$srbk.']" tabindex="'.$srbk.'" value="'.$valuemarks['marks'].'" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;" '.$marksdisabled.'></td>
	<td style="width:150px;">'.$attendance.'</td>
</tr>
<input type="hidden" name="id_edited['.$srbk.']" id="id_edited['.$srbk.']" value="'.$valuemarks['id'].'">
<input type="hidden" name="id_std['.$srbk.']" id="id_std['.$srbk.']" value="'.$itemstd['std_id'].'">
<input type="hidden" name="id_setup" id="id_setup" value="'.$valuesetup['id'].'">';
//------------------------------------------------
}
}
}
}
//------------------------------------------------
echo '
</tbody>
</table>
<div class="modal-footer" style="'.$submitdisabled .'">
	<input class="btn btn-primary" type="submit" value="Submit Marks" id="submit_marks" name="submit_marks">
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
}
//------------------------------------------------
echo '

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
</div>
<script>
	evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script> 
<script>
    $("#forward_to").select2({
        allowClear: true
    });
	
</script>'; 

?>