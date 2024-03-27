<?php 
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-12">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">';
//--------------------------------------

echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Final Term Award List</h3></span>
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

	$sqllms = $dblms->querylms("INSERT INTO ".FINALTERM." (
															status										,
															id_dept										, 
															id_prg										, 
															section										, 
															semester									, 
															id_curs										, 
															dated										, 
															exam_date									, 
															id_campus									,
															id_added									,
															date_added
														)
												VALUES (
															'1'											, 
															'".cleanvars($_POST['id_dept'])."'			, 
															'".cleanvars($_POST['id_prg'])."'			, 
															'".cleanvars($_POST['section'])."'			, 
															'".cleanvars($_POST['semester'])."'			, 
															'".cleanvars($_POST['id_curs'])."'			, 
															'2017-07-29'								, 
															'2017-07-15'								, 
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'	,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
															NOW()			
														)
							");

//--------------------------------------
if($sqllms) {
$idsetup = $dblms->lastestid();
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
//--------------------------------------
} else { 
//--------------------------------------
	$sqllms  = $dblms->querylms("UPDATE ".FINALTERM." SET status		= '2'
													, id_dept		= '".cleanvars($_POST['id_dept'])."' 
													, id_prg		= '".cleanvars($_POST['id_prg'])."' 
													, section		= '".cleanvars($_POST['section'])."' 
													, semester		= '".cleanvars($_POST['semester'])."' 
													, id_curs		= '".cleanvars($_POST['id_curs'])."' 
													, dated			= '".date("Y-m-d")."' 
													, exam_date		= '".date("Y-m-d")."' 
													, id_modify		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' 
													, date_modify	= NOW() 
												WHERE id			= '".cleanvars($_POST['id_setup'])."'");

//--------------------------------------
if($sqllms) {
//--------------------------------------
	$sqllmsdelte  = $dblms->querylms("DELETE FROM ".FINALTERM_DETAILS." WHERE id_finalterm = '".$_POST['id_setup']."'");
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
																				'".$_POST['id_setup']."'							, 
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
	echo '<div id="infoupdated" class="alert-box success"><span>success: </span>Record Update successfully.</div>';
//------------------------------------------------
}
//--------------------------------------
}
//--------------------------------------
}
//--------------------------------------
	$sqllmsstds  = $dblms->querylms("SELECT std.std_id, std.std_rollno, std.std_regno, std.std_section, std.std_photo, std.std_name, std.std_session,  
											prg.prg_id, prg.prg_name, dept.dept_id, dept.dept_name   
											FROM ".STUDENTS." std 
										  	INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
										  	INNER JOIN ".DEPTS." dept ON prg.id_dept = dept.dept_id 
										  	WHERE std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										  	AND std.id_prg = '".cleanvars($rowsurs['id_prg'])."' AND std.std_status = '2' 
										  	AND std.std_semester = '".cleanvars($rowsurs['semester'])."'
										  	ORDER BY std.std_rollno ASC, std.std_regno ASC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsstds)>0) {
//$valuecount1  = mysqli_fetch_array($sqllmsstds);

//------------------------------------------------
	$sqllmstotallecture = $dblms->querylms("SELECT COUNT(at.lectureno) as Totallecture
										FROM ".COURSES_ATTENDANCE_DETAIL." dt
										INNER JOIN ".COURSES_ATTENDANCE." at ON at.id = dt.id_setup 
										INNER JOIN ".STUDENTS." std ON std.std_id = dt.id_std  
										WHERE at.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND at.id_curs = '".cleanvars($_GET['id'])."'
										AND std.id_prg = '".cleanvars($rowsurs['id_prg'])."' AND std.std_status = '2'
										AND std.std_semester = '".cleanvars($rowsurs['semester'])."' GROUP BY dt.id_std");
	$valuetotallecture 	= mysqli_fetch_array($sqllmstotallecture);
//------------------------------------------------
$srbk = 0;
//------------------------------------------------
while($rowcurstds = mysqli_fetch_array($sqllmsstds)) { 
//------------------------------------------------
	$sqllmschecker  = $dblms->querylms("SELECT d.id, d.marks, d.id_std, m.id_curs, m.id
												FROM ".MIDTERM_DETAILS." d 
												INNER JOIN ".MIDTERM." m ON m.id = d.id_midterm  
												WHERE d.id_std 	= '".cleanvars($rowcurstds['std_id'])."' 
												AND m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										  		AND m.id_prg 	= '".cleanvars($rowsurs['id_prg'])."' 
											  	AND m.semester 	= '".cleanvars($rowsurs['semester'])."' 
												AND m.id_curs 	= '".cleanvars($_GET['id'])."' LIMIT 1");
	$valuemarks 	= mysqli_fetch_array($sqllmschecker);
if($valuemarks['marks']) {
	$stdmidmarks = $valuemarks['marks'];
} else { 
	$stdmidmarks = '';
}
//------------------------------------------------
	$sqllmsprsent  = $dblms->querylms("SELECT COUNT(ad.id) AS toalpresent     
										FROM ".COURSES_ATTENDANCE_DETAIL." ad 
										INNER JOIN ".COURSES_ATTENDANCE." at ON at.id = ad.id_setup 
										WHERE ad.status = '2' AND at.id_curs = '".cleanvars($_GET['id'])."'
										AND ad.id_std 	= '".cleanvars($rowcurstds['std_id'])."'");
	$valuepresent = mysqli_fetch_array($sqllmsprsent);
//------------------------------------------------
	$attendanceper = (($valuepresent['toalpresent'] * 100)/$valuetotallecture['Totallecture']);
if($attendanceper>=90) { 
	$attendancemarks = 5;
} else if($attendanceper>=80) { 
	$attendancemarks = 4;

} else if($attendanceper>=75) { 
	$attendancemarks = 3;
} else { 
	$attendancemarks = 0;
}
//------------------------------------------------
	$sqllmfinalterm  = $dblms->querylms("SELECT fd.id, fd.id_std, fd.finalterm, fd.assignment, fd.quiz, fd.attendance, fd.marks_obtained, 
												fd.numerical, fd.credithour, fd.gradepoint, fd.lettergrade, fd.remarks, f.id_curs, f.id
												FROM ".FINALTERM_DETAILS." fd 
												INNER JOIN ".FINALTERM." f ON f.id = fd.id_finalterm  
												WHERE fd.id_std 	= '".cleanvars($rowcurstds['std_id'])."' 
												AND f.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										  		AND f.id_prg 	= '".cleanvars($rowsurs['id_prg'])."' 
											  	AND f.semester 	= '".cleanvars($rowsurs['semester'])."' 
												AND f.id_curs 	= '".cleanvars($_GET['id'])."' LIMIT 1");
	$valfinalterm 	= mysqli_fetch_array($sqllmfinalterm);
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
//--------------------------------------------
$srbk++;
if($srbk == 1) {
echo '
<div style="clear:both;"></div>
<form class="form-horizontal" action="#" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="semester" id="semester" value="'.$rowsurs['semester'].'">
<input type="hidden" name="id_prg" id="id_prg" value="'.$rowsurs['id_prg'].'">
<input type="hidden" name="id_dept" id="id_dept" value="'.$rowcurstds['dept_id'].'">
<input type="hidden" name="section" id="section" value="'.$rowcurstds['std_section'].'">
<input type="hidden" name="id_curs" id="id_curs" value="'.$_GET['id'].'">

<p>
	Name of the Deparment: <span style="width:550px; display: inline-block; border-bottom:1px dashed #666;">'.$rowcurstds['dept_name'].'</span> 
</p>

<p style="margin-top:10px;">
	Class/Degree Program:  <span style="width:400px; display: inline-block; border-bottom:1px dashed #666;">'.$rowcurstds['prg_name'].'</span> 
	<span style="margin-left:10px;">Semester: </span>
	<span style="width:80px; display: inline-block; border-bottom:1px dashed #666; text-align:center;">'.$rowsurs['semester'].'</span> 
</p>


<p style="margin-top:10px;">
	Subject:  <span style="width:500px; display: inline-block; border-bottom:1px dashed #666;">'.$rowsurs['curs_code'].' - '.$rowsurs['curs_name'].'</span> 
	<span style="margin-left:5px;">Dated: </span>
	<span style="width:100px; display: inline-block; border-bottom:1px dashed #666;">2017-07-29</span> 
</p>

<p style="margin-top:10px;">
	Examination held in the month of <span style="width:500px; display: inline-block; border-bottom:1px dashed #666;">Augest</span> 
</p>

<div style="clear:both;"></div>
<div class="navbar-form navbar-right" style="font-weight:700; color:red; margin-right:10px; margin-top:0px;"> 
	Total Students: ('.number_format(mysqli_num_rows($sqllmsstds)).')
</div>
<table class="table table-bordered table-with-avatar invE_table">
<thead>
<tr>
	<th style="font-weight:600; font-size:11px; vertical-align:middle;">Sr.#</th>
	<th style="font-weight:600; font-size:11px;vertical-align:middle;">Roll No</th>
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
if($rowcurstds['std_photo']) { 
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$rowcurstds['std_photo'].'" alt="'.$rowcurstds['std_name'].'"/>';
} else {
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$rowcurstds['std_name'].'"/>';
}
//------------------------------------------------
echo '
<tr class="inv_row">
	<td style="width:40px;">'.$srbk.'</td>
	<td style="width:75px;">'.$rowcurstds['std_rollno'].'</td>
	<td>'.$stdphoto.'</td>
	<td><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$rowcurstds['std_name'].' ('.$rowcurstds['std_session'].')</b>" data-src="studentdetail.php?std_id='.$rowcurstds['std_id'].'" href="#">'.$rowcurstds['std_name'].'</a> </td>
	<td style="width:70px;"><input type="number" class="form-control col-lg-12 jQinv_item_assign" min="0" max="10" id="assignment['.$srbk.']" name="assignment['.$srbk.']" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;"  value="'.$stdassignment.'"></td>
	<td style="width:70px;"><input type="number" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" class="form-control col-lg-12 jQinv_item_quiz" min="0" max="10" id="quiz['.$srbk.']" name="quiz['.$srbk.']" required autocomplete="off" style="text-align:center;" value="'.$stdquiz.'"></td>
	<td style="width:70px;"><input type="number" class="form-control col-lg-12 jQinv_item_attendance" min="0" max="5" id="attendance['.$srbk.']" name="attendance['.$srbk.']" autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;" value="'.$stdattendance.'" ></td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_midterm" min="1" max="25" id="midterm['.$srbk.']" name="midterm['.$srbk.']" readonly style="text-align:center;" value="'.$stdmidmarks.'"></td>
	<td style="width:70px;"><input type="number" class="form-control col-lg-12 jQinv_item_finalterm" min="0" max="50" id="finalterm['.$srbk.']" name="finalterm['.$srbk.']" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;" value="'.$stdfinalmarks.'"></td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_obtained" min="1" max="25" id=marks_obtained['.$srbk.']" name="marks_obtained['.$srbk.']" readonly style="text-align:center;" value="'.$stdmarksobtained.'"></td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_numerical" min="1" max="25" id="numerical['.$srbk.']" name="numerical['.$srbk.']" readonly style="text-align:center;" value="'.$stdnumerical.'"></td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_credithour" id="credithour['.$srbk.']" name="credithour['.$srbk.']" readonly style="text-align:center;" value="'.$rowsurs['curs_credit_hours'].'"></td>
	<td style="width:60px;"><input type="text" class="form-control col-lg-12 jQinv_item_gradepoint" id="gradepoint['.$srbk.']" name="gradepoint['.$srbk.']" readonly value="'.$stdgradepoint.'"></td>
	<td style="width:60px;"><input type="text" class="form-control col-lg-12 jQinv_item_lettergrade" id="lettergrade['.$srbk.']" name="lettergrade['.$srbk.']" readonly style="text-align:center;" value="'.$stdlettergrade.'"></td>
	<td style="width:90px;"><input type="text" class="form-control col-lg-12 jQinv_item_remarks" id="remarks['.$srbk.']" name="remarks['.$srbk.']"  value="'.$stdremarks.'" ></td>

</tr>
<input type="hidden" name="id_std['.$srbk.']" id="id_std['.$srbk.']" value="'.$rowcurstds['std_id'].'">
<input type="hidden" name="id_setup" id="id_setup" value="'.$valfinalterm['id'].'">';
//------------------------------------------------
}
//------------------------------------------------
echo '
</tbody>
<tr class="last_row">
	<td colspan="20" style="text-align:right;">
</tr>
</table>
<div class="modal-footer">
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
</script> '; 

?>