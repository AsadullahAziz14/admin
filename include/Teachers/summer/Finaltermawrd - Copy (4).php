<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-12">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">';
//--------------------------------------
if(isset($_GET['section'])) {  
	$section 		= $_GET['section'];
	$sectionlink	= '&section='.$_GET['section'];
} else { 
	$section 		= '';
	$sectionlink	= '';
}
//--------------------------------------
	$datetime 	= date('Y-m-d H');
	$activedate = "2018-09-11 17";
//--------------------------------------------
if($_GET['timing'] == 1) {  
	$disable = " disabled";
	$style = ' style="display:none;"';
} else { 
	$disable = "";	
	$style = ' ';
}
//--------------------------------------
echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Final Term Award List</h3></span>
			<span class="pull-right"><a class="btn btn-success" href="courses.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$sectionlink.'"> Back to Course </a></span>
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
if(isset($_POST['submit_marks'])) { 
//------------------------------------------------
if(empty($_POST['id_setup'])) { 
$sqllmschecker  = $dblms->querylms("SELECT * 
												FROM ".FINALTERM." m 
												WHERE m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										  		AND m.id_prg 	= '".cleanvars($_GET['prgid'])."' 
												AND m.timing 	= '".cleanvars($_GET['timing'])."' 
											  	AND m.semester 	= '".cleanvars($_GET['semester'])."' 
												AND m.id_teacher 	= '".cleanvars($_POST['id_teacher'])."'
												AND m.section = '".cleanvars($section)."' 
												AND m.theory_practical = '1'
												AND m.id_curs 	= '".cleanvars($_POST['id_curs'])."' LIMIT 1");
	$valuemarks 		= mysqli_fetch_array($sqllmschecker);
if($valuemarks['id']) { 
	echo '<div class="alert-box warning"><span>warning: </span>Record already added.</div>';
} else {
	$sqllms = $dblms->querylms("INSERT INTO ".FINALTERM." (
															status										,
															forward_to									, 
															id_curs										,
															theory_practical							, 
															semester									,
															section										,
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
															'2'											, 
															'".cleanvars($_POST['forward_to'])."'		, 
															'".cleanvars($_POST['id_curs'])."'			, 
															'1'											, 
															'".cleanvars($_POST['semester'])."'			, 
															'".cleanvars($section)."'					, 
															'".cleanvars($_GET['timing'])."'			, 
															'".cleanvars($_GET['prgid'])."'				, 
															'".cleanvars($_POST['id_teacher'])."'		, 
															'".date("Y-m-d")."'							, 
															'".date('Y-m-d', strtotime($_POST['exam_date']))."'				, 
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'	,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'	,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
															NOW()			
														)
							");

//--------------------------------------
if($sqllms) {
$idsetup = $dblms->lastestid();
//--------------------------------------
	$logremarks = 'Add Student Final Term Award List #: '.$idsetup.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			$sqllmsmulti  = $dblms->querylms("INSERT INTO ".FINALTERM_DETAILS."( 
																				id_finalterm									,
																				id_std											, 
																				assignment										, 
																				quiz											, 
																				attendance										, 
																				midterm											, 
																				finalterm										, 
																				marks_obtained									, 
																				numerical										, 
																				credithour										, 
																				gradepoint										, 
																				lettergrade										, 
																				remarks										
																			)
	   																VALUES (
																				'".$idsetup."'										, 
																				'".cleanvars($_POST['id_std'][$ichk])."'			, 
																				'".cleanvars($_POST['assignment'][$ichk])."'		, 
																				'".cleanvars($_POST['quiz'][$ichk])."'				, 
																				'".cleanvars($_POST['attendance'][$ichk])."'		, 
																				'".cleanvars($_POST['midterm'][$ichk])."'			, 
																				'".cleanvars($_POST['finalterm'][$ichk])."'			, 
																				'".cleanvars($_POST['marks_obtained'][$ichk])."'	, 
																				'".cleanvars($_POST['numerical'][$ichk])."'			, 
																				'".cleanvars($_POST['credithour'][$ichk])."'		, 
																				'".cleanvars($_POST['gradepoint'][$ichk])."'		, 
																				'".cleanvars($_POST['lettergrade'][$ichk])."'		, 
																				'".cleanvars($_POST['remarks'][$ichk])."'	
																			)
										");
		}
//------------------------------------------------
	echo '<div id="infoupdated" class="alert-box success"><span>success: </span>Record added successfully.</div>';
//------------------------------------------------
}
}
//--------------------------------------
} else if($_POST['id_setup']) { 
//--------------------------------------
	$sqllms  = $dblms->querylms("UPDATE ".FINALTERM." SET status	= '2'
													, forward_to	= '".cleanvars($_POST['forward_to'])."' 
													, id_curs		= '".cleanvars($_POST['id_curs'])."' 
													, theory_practical	= '1' 
													, semester		= '".cleanvars($_POST['semester'])."' 
													, section		= '".cleanvars($section)."' 
													, timing		= '".cleanvars($_GET['timing'])."' 
													, dated			= '".date("Y-m-d")."' 
													, exam_date		= '".date('Y-m-d', strtotime($_POST['exam_date']))."' 
													, id_modify		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' 
													, date_modify	= NOW() 
												WHERE id			= '".cleanvars($_POST['id_setup'])."'");

//--------------------------------------
if($sqllms) {
//--------------------------------------
	$logremarks = 'Update Student Final Term Award List #: '.$_POST['id_setup'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
//	$sqllmsdelte  = $dblms->querylms("DELETE FROM ".FINALTERM_DETAILS." WHERE id_finalterm = '".$_POST['id_setup']."'");
//--------------------------------------
	$arraychecked = $_POST['id_std'];
//--------------------------------------
	for($ichk=1; $ichk<=sizeof($arraychecked); $ichk++){
if(!empty($_POST['id_edit'][$ichk])) {
//------------------------------------------------
				$sqllmsmulti  = $dblms->querylms("UPDATE ".FINALTERM_DETAILS." SET 
													  assignment		= '".cleanvars($_POST['assignment'][$ichk])."' 
													, quiz				= '".cleanvars($_POST['quiz'][$ichk])."' 
													, attendance		= '".cleanvars($_POST['attendance'][$ichk])."' 
													, midterm			= '".cleanvars($_POST['midterm'][$ichk])."' 
													, finalterm			= '".cleanvars($_POST['finalterm'][$ichk])."' 
													, marks_obtained	= '".cleanvars($_POST['marks_obtained'][$ichk])."' 
													, numerical			= '".cleanvars($_POST['numerical'][$ichk])."' 
													, credithour		= '".cleanvars($_POST['credithour'][$ichk])."' 
													, gradepoint		= '".cleanvars($_POST['gradepoint'][$ichk])."' 
													, lettergrade		= '".cleanvars($_POST['lettergrade'][$ichk])."' 
													, remarks			= '".cleanvars($_POST['remarks'][$ichk])."' 	
												WHERE id				= '".cleanvars($_POST['id_edit'][$ichk])."' 
													AND id_finalterm 	= '".cleanvars($_POST['id_setup'])."'
													AND id_std 			= '".cleanvars($_POST['id_std'][$ichk])."'"); 			
} else { 
//------------------------------------------------
			$sqllmsmulti  = $dblms->querylms("INSERT INTO ".FINALTERM_DETAILS."( 
																				id_finalterm									,
																				id_std											, 
																				assignment										, 
																				quiz											, 
																				attendance										, 
																				midterm											, 
																				finalterm										, 
																				marks_obtained									, 
																				numerical										, 
																				credithour										, 
																				gradepoint										, 
																				lettergrade										, 
																				remarks										
																			)
	   																VALUES (
																				'".$_POST['id_setup']."'										, 
																				'".cleanvars($_POST['id_std'][$ichk])."'			, 
																				'".cleanvars($_POST['assignment'][$ichk])."'		, 
																				'".cleanvars($_POST['quiz'][$ichk])."'				, 
																				'".cleanvars($_POST['attendance'][$ichk])."'		, 
																				'".cleanvars($_POST['midterm'][$ichk])."'			, 
																				'".cleanvars($_POST['finalterm'][$ichk])."'			, 
																				'".cleanvars($_POST['marks_obtained'][$ichk])."'	, 
																				'".cleanvars($_POST['numerical'][$ichk])."'			, 
																				'".cleanvars($_POST['credithour'][$ichk])."'		, 
																				'".cleanvars($_POST['gradepoint'][$ichk])."'		, 
																				'".cleanvars($_POST['lettergrade'][$ichk])."'		, 
																				'".cleanvars($_POST['remarks'][$ichk])."'	
																			)
										");
//------------------------------------------------
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
//--------------------------------------
//--------------------------------------------------	
$sqllmsstdcurs  = $dblms->querylms("SELECT  DISTINCT(d.id_curs), t.section, t.id_prg, t.timing,  t.semester      
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										INNER JOIN ".COURSES." c ON c.curs_id = d.id_curs  
										INNER JOIN ".EMPLYS." e ON e.emply_id = d.id_teacher   
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' AND t.timing = '".cleanvars($_GET['timing'])."'  
										AND t.status = '1' AND t.id_prg = '".cleanvars($_GET['prgid'])."' 
										AND t.semester = '".cleanvars($_GET['semester'])."' $sqlsection 
										AND d.id_curs = '".cleanvars($_GET['id'])."' LIMIT 1");
$cursstudents = array();
$countstudents = 0;
//--------------------------------------------------
$rowtsurs = mysqli_fetch_array($sqllmsstdcurs);
if($_GET['section']) {
	$stdsection 	= " AND std.std_section =  '".cleanvars($rowtsurs['section'])."'"; 
} else { 
	$stdsection 	= " "; 
}
//--------------------------------------------------
	$sqllmsstds  = $dblms->querylms("SELECT *   
											FROM ".STUDENTS." std 
											INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
											WHERE (std.std_status = '2' OR std.std_status = '7') AND std.std_struckoffresticate != '1' 
											AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND std.id_prg = '".cleanvars($rowtsurs['id_prg'])."' 
											AND std.std_timing = '".cleanvars($rowtsurs['timing'])."'
											AND std.std_semester = '".cleanvars($rowtsurs['semester'])."' $stdsection 
											ORDER BY std.std_rollno ASC, std.std_regno ASC");
	while($rowcurstds = mysqli_fetch_assoc($sqllmsstds)) { 
		$cursstudents[] = $rowcurstds;
		$countstudents++;
	}

//--------------------------------------------------
if ($countstudents>0) {
//------------------------------------------------
$srbk = 0;
//------------------------------------------------
foreach($cursstudents as $itemstd) {  
//------------------------------------------------
	$sqllmschecker  = $dblms->querylms("SELECT d.id, d.marks, d.id_std, m.id_curs, m.id
											FROM ".MIDTERM_DETAILS." d 
											INNER JOIN ".MIDTERM." m ON m.id = d.id_midterm  
											WHERE d.id_std 	= '".cleanvars($itemstd['std_id'])."' 
											AND m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										  	AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND m.id_prg 	= '".cleanvars($itemstd['id_prg'])."' 
											AND d.semester 	= '".cleanvars($itemstd['std_semester'])."' 
											AND m.id_curs 	= '".cleanvars($_GET['id'])."' 
											AND m.timing 	= '".cleanvars($_GET['timing'])."' LIMIT 1");
	$valuemarks 	= mysqli_fetch_array($sqllmschecker);
if($valuemarks['marks']) {
	$stdmidmarks = $valuemarks['marks'];
} else { 
	$stdmidmarks = '';
}
//------------------------------------------------
	$sqllmsprsent  = $dblms->querylms("SELECT *   
										FROM ".STUDENTS_ATTENDANCEDETAILS." ad 
										INNER JOIN ".STUDENTS_ATTENDANCE." at ON at.id = ad.id_setup 
										WHERE at.id_curs = '".cleanvars($_GET['id'])."' 
										AND at.id_prg = '".cleanvars($_GET['prgid'])."' 
										AND at.timing = '".cleanvars($_GET['timing'])."'   
										AND ad.id_std 	= '".cleanvars($itemstd['std_id'])."'");
	$valuepresent = mysqli_fetch_array($sqllmsprsent);
//------------------------------------------------
	$attendanceper = round(($valuepresent['lecture_percent']/$valuepresent['total_lectures']) * 100); 
//------------------------------------------------
	$sqllmsarrears  = $dblms->querylms("SELECT SUM(fe.arrears) AS Totalpayarrears  
											FROM ".FEES." fe 
											INNER JOIN ".FEES_PARTICULARS." fp ON fp.challan_no = fe.challan_no  
											WHERE fe.id_std = '".$itemstd['std_id']."' 
											AND (fp.id_cat != '12' AND fp.id_cat != '32')  ");
	$valuearrears	= mysqli_fetch_array($sqllmsarrears);
	
	$sqllmspayable  = $dblms->querylms("SELECT SUM(fp.amount) AS Totalpayable 
											FROM ".FEES_PARTICULARS." fp 
											INNER JOIN ".FEES." fe ON fp.challan_no = fe.challan_no  
											WHERE fe.id_std = '".$itemstd['std_id']."' 
											AND (fp.id_cat != '12' AND fp.id_cat != '32') ");
	$valuepayable	= mysqli_fetch_array($sqllmspayable);
	
//------------------------------------------------
	$sqllmspaid  	= $dblms->querylms("SELECT SUM(total_amount) AS Totalpaid, SUM(arrears) AS Totalarrears   
											FROM ".FEES." 
											WHERE id_std = '".$itemstd['std_id']."' 
											AND paid_date != '0000-00-00' ");
	$valuepaid		= mysqli_fetch_array($sqllmspaid);
	$totalbalance 	= (($valuepayable['Totalpayable'] + $valuepayable['Totalpayablearrears']) - ($valuepaid['Totalpaid'] + $valuepaid['Totalarrears']));
if($attendanceper>=63 && ($totalbalance == 0) && $valuepayable['Totalpayable']>0) { 
//------------------------------------------------
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
	$sqllmsfinalterm  = $dblms->querylms("SELECT fd.id, fd.id_finalterm, fd.assignment, fd.quiz, fd.attendance, fd.marks_obtained, fd.numerical, 
												 fd.finalterm, fd.gradepoint, fd.lettergrade, fd.remarks, f.exam_date, f.forward_to, f.section  
												FROM ".FINALTERM_DETAILS." fd 
												INNER JOIN ".FINALTERM." f ON f.id = fd.id_finalterm  
												WHERE fd.id_std 	= '".cleanvars($itemstd['std_id'])."' 
												AND f.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										  		AND f.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
												AND f.id_prg 	= '".cleanvars($itemstd['id_prg'])."' 
											  	AND f.semester 	= '".cleanvars($itemstd['std_semester'])."' 
												AND f.id_teacher = '".cleanvars($rowsurs['id_teacher'])."'
												AND f.id_curs 	= '".cleanvars($_GET['id'])."' 
												AND f.theory_practical 	= '1'  
												AND f.timing 	= '".cleanvars($_GET['timing'])."' LIMIT 1");
	$valfinalterm 	= mysqli_fetch_array($sqllmsfinalterm);
if($valfinalterm['id_finalterm']) { 
	$printaward = '<div style="float:right;"><a class="btn btn-mid btn-info" href="finaltermawardprint.php?id='.$valfinalterm['id_finalterm'].'" target="_blank"><i class="icon-print"></i> Print Sheet</a></div>';
} else { 
	$printaward = '';
}
//----------------------------------------------------
if($valfinalterm['finalterm']) 		{ $stdfinalmarks 	= $valfinalterm['finalterm']; 		} else {  $stdfinalmarks 	= ''; }
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
if($valfinalterm['exam_date']) 		{ $examdate 		= $valfinalterm['exam_date']; 		} else {  $examdate 		= ''; }
//--------------------------------------------
$srbk++;
if($srbk == 1) {

echo '

<div style="clear:both;"></div>
<form class="form-horizontal" action="#" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="id_curs" id="id_curs" value="'.$_GET['id'].'">
<input type="hidden" name="stdsection" id="stdsection" value="'.$rowsurs['section'].'">
<input type="hidden" name="id_setup" id="id_setup" value="'.$valfinalterm['id_finalterm'].'">
<input type="hidden" name="id_teacher" id="id_teacher" value="'.$rowsurs['id_teacher'].'">
<input type="hidden" name="semester" id="semester" value="'.$rowsurs['semester'].'">
<div style="margin-top:10px;">
	Subject:  <span style="width:80%; display: inline-block; border-bottom:1px dashed #666;">'.$rowsurs['curs_code'].' - '.$rowsurs['curs_name'].'</span> 
</div>
<div style="clear:both;"></div>
<div style="margin-top:10px;">
	<span class="req" style="font-weight:600;">Examination Date</span> <input class="pickadate" name="exam_date" id="exam_date" type="text" value="'.$examdate.'" required autocomplete="off" class="form-control" '.$disable.'> 
	<span style="margin-right:20px; float:right; font-weight:600;"> Forward to :
		<select id="forward_to" name="forward_to" style="width:150px;"  autocomplete="off" '.$disable.'>
				<option value="">Select Forward</option>';
				if($valfinalterm['forward_to'] == 4) {
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
	<th style="font-weight:600; font-size:11px; text-align:center;">Final Term 50%</th>
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
//------------------------------------------------
if($itemstd['std_photo']) { 
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$itemstd['std_photo'].'" alt="'.$itemstd['std_name'].'"/>';
} else {
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$itemstd['std_name'].'"/>';
}
//------------------------------------------------
echo '
<tr class="inv_row">
	<td style="width:40px;">'.$srbk.'</td>
	<td style="width:50px; text-align:center;">'.$itemstd['std_rollno'].'</td>
	<td>'.$stdphoto.'</td>
	<td><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$rowcurstds['std_name'].' ('.$itemstd['std_session'].')</b>" data-src="studentdetail.php?std_id='.$itemstd['std_id'].'" href="#">'.$itemstd['std_name'].'</a> </td>
	<td style="width:70px;"><input type="number" class="form-control col-lg-12 jQinv_item_assign" min="0" max="10" id="assignment['.$srbk.']" name="assignment['.$srbk.']" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;"  value="'.$stdassignment.'"  '.$disable.'></td>
	<td style="width:70px;"><input type="number" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" class="form-control col-lg-12 jQinv_item_quiz" min="0" max="10" id="quiz['.$srbk.']" name="quiz['.$srbk.']" required autocomplete="off" style="text-align:center;" value="'.$stdquiz.'" '.$disable.'></td>
	<td style="width:70px;"><input type="number" class="form-control col-lg-12 jQinv_item_attendance" min="0" max="5" id="attendance['.$srbk.']" name="attendance['.$srbk.']" autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;" value="'.$stdattendance.'" readonly ></td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_midterm" min="1" max="25" id="midterm['.$srbk.']" name="midterm['.$srbk.']" readonly style="text-align:center;" value="'.$stdmidmarks.'"></td>
	<td style="width:90px;"><input type="number" class="form-control col-lg-12 jQinv_item_finalterm" min="0" max="50" id="finalterm['.$srbk.']" name="finalterm['.$srbk.']" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;" value="'.$stdfinalmarks.'" '.$disable.'></td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_obtained" min="1" max="25" id=marks_obtained['.$srbk.']" name="marks_obtained['.$srbk.']" readonly style="text-align:center;" value="'.$stdmarksobtained.'"></td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_numerical" min="1" max="25" id="numerical['.$srbk.']" name="numerical['.$srbk.']" readonly style="text-align:center;" value="'.$stdnumerical.'"></td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_credithour" id="credithour['.$srbk.']" name="credithour['.$srbk.']" readonly style="text-align:center;" value="'.$rowsurs['cur_credithours_theory'].'"></td>
	<td style="width:60px;"><input type="text" class="form-control col-lg-12 jQinv_item_gradepoint" id="gradepoint['.$srbk.']" name="gradepoint['.$srbk.']" readonly value="'.$stdgradepoint.'"></td>
	<td style="width:60px;"><input type="text" class="form-control col-lg-12 jQinv_item_lettergrade" id="lettergrade['.$srbk.']" name="lettergrade['.$srbk.']" readonly style="text-align:center;" value="'.$stdlettergrade.'"></td>
	<td style="width:90px;"><input type="text" class="form-control col-lg-12 jQinv_item_remarks" id="remarks['.$srbk.']" name="remarks['.$srbk.']"  value="'.$stdremarks.'"  '.$disable.'></td>

</tr>
<input type="hidden" name="id_std['.$srbk.']" id="id_std['.$srbk.']" value="'.$itemstd['std_id'].'">
<input type="hidden" name="id_edit['.$srbk.']" id="id_edit['.$srbk.']" value="'.$valfinalterm['id'].'">';
//------------------------------------------------
}
}
//------------------------------------------------
echo '
</tbody>
<tr class="last_row">
	<td colspan="20" style="text-align:right;">
</tr>
</table>
<div class="modal-footer" '.$style.'>
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