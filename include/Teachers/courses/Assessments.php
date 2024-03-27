<?php 
//--------------------------------------------
	include_once("assessments/query.php");
//--------------------------------------------
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">';

//--------------------------------------
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
} 
//--------------------------------------
if(isset($_GET['section'])) { 
		$seccaption	= ' '.$_GET['section'];
	} else  { 
		$seccaption	= '';
	}
//--------------------------------------
if(!isset($_GET['prgid'])) {  
	$banklink = '<a class="btn btn-mid btn-success" href="courses.php?id='.$_GET['id'].'"> Back to Course </a>';
	$prgname = '';
} else { 
//------------------------------------------------
	$sqllmsprgname  = $dblms->querylms("SELECT p.prg_name, p.prg_code  
										FROM ".PROGRAMS." p  
										WHERE p.prg_id = '".cleanvars($_GET['prgid'])."' LIMIT 1");
	$valuepname = mysqli_fetch_array($sqllmsprgname);
	$prgname = '('.strtoupper($valuepname['prg_code']).' - '.addOrdinalNumberSuffix($_GET['semester']).$seccaption.') '.get_programtiming($_GET['timing']);
//------------------------------------------------
	$banklink = '<a class="btn btn-mid btn-success" href="courses.php?id='.$_GET['id'].'&view=Assessments"> Back </a>';
}
//--------------------------------------
$sqllmsAssignment = $dblms->querylms("SELECT a.id 
										FROM ".COURSES_ASSIGNMENTS." a   
										INNER JOIN ".EMPLYS." emp ON emp.emply_id = a.id_teacher
										WHERE a.is_midterm = '1' 
										AND a.id_curs = '".cleanvars($_GET['id'])."'
										AND a.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND a.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
                                        AND a.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'");
$rowAssignment = mysqli_fetch_array($sqllmsAssignment);
//--------------------------------------
echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Semester Assessments '.$prgname.'</h3></span>
			<span class="pull-right">'.$banklink.'</span>
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
//--------------------------------------------------
if(!isset($_GET['prgid'])) {  
//------------------------------------------------
	$sqllmscursrelated  = $dblms->querylms("SELECT DISTINCT(t.id_prg), d.id_setup, 
										p.prg_id, p.prg_name, p.prg_code, t.section, t.timing , t.semester  
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										INNER JOIN ".PROGRAMS." p ON p.prg_id = t.id_prg   
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND d.id_curs = '".cleanvars($_GET['id'])."' AND t.status =  '1'");
	$countrelted = mysqli_num_rows($sqllmscursrelated);
	$arrayquery = array();
	while($rowrelted = mysqli_fetch_array($sqllmscursrelated)) { 
		$arrayquery[] = $rowrelted;
	}
//--------------------------------------------------
echo '
<h3 style="font-weight:600; color:#00f;">Midterm Paper</h3>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center; ">Sr.#</th>
	<th style="font-weight:600;">Program</th>
	<th style="font-weight:600;text-align:center;">Semester</th>
	<th style="font-weight:600;text-align:center;">Timing</th>
	<th style="font-weight:600;text-align:center;">Students</th>
	<th style="font-weight:600;text-align:center;">Papers</th>
	<th style="text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srbk = 0;
foreach($arrayquery as $listmidterm) { 
	$srbk++; 
//------------------------------------------------
	if($listmidterm['section']) { 
		$secthref 	= '&section='.$listmidterm['section'];
		$sectcaps 	= ' ('.$listmidterm['section'].')';
		$sectionstd = " AND std.std_section = '".cleanvars($listmidterm['section'])."'";
	} else  { 
		$secthref 	= '';
		$sectionstd = '';
		$sectcaps 	= '';
	}	
//------------------------------------------------
	$sqllmsstds  = $dblms->querylms("SELECT COUNT(std.std_id) AS Totalstds
											FROM ".STUDENTS." std 
											WHERE (std.std_status = '2' OR std.std_status = '7') 
											AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
											AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND std.id_prg = '".cleanvars($listmidterm['id_prg'])."' 
											AND std.std_timing = '".cleanvars($listmidterm['timing'])."' 
											$sectionstd 
											AND std.std_semester = '".cleanvars($listmidterm['semester'])."'
											AND std.std_session != '".cleanvars($_SESSION['userlogininfo']['LOGINIDADMISSION'])."'");
	$rowcurstds = mysqli_fetch_array($sqllmsstds);
//-----------------Students of 2ndary Program-------------------------------
	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) !=1) { 
		
		$sqllmsstd2ndary  = $dblms->querylms("SELECT COUNT(std.std_id) AS Total2ndarystds
												FROM ".STUDENTS." std 
												WHERE (std.std_status = '2' OR std.std_status = '7') 
												AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
												AND std.id_campus 		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND std.id_prgsecondary = '".cleanvars($listmidterm['id_prg'])."' 
												AND std.std_timing 		= '".cleanvars($listmidterm['timing'])."' 
												$sectionstd 
												AND std.std_secondarysemester = '".cleanvars($listmidterm['semester'])."'
												AND std.std_secondarysession != '".cleanvars($_SESSION['userlogininfo']['LOGINIDADMISSION'])."'");
		
		$rowcur2ndary 	= mysqli_fetch_array($sqllmsstd2ndary);
		$sndarystds 	= $rowcur2ndary['Total2ndarystds'];
		
	} else {
		$sndarystds 	= 0;
	}
	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) ==1){
		$addPrgSQL = "";

	} else{
		$addPrgSQL = "AND (std.id_prg = '".cleanvars($listmidterm['id_prg'])."' OR )";
	}
//------------------------------------------------
	$sqllmsexam = $dblms->querylms("SELECT s.id 
										FROM ".COURSES_ASSIGNMENTS_STUDENTS." s  
										INNER JOIN ".COURSES_ASSIGNMENTS." a ON a.id = s.id_assignment 
										INNER JOIN ".EMPLYS." emp ON emp.emply_id = a.id_teacher 
										INNER JOIN ".STUDENTS." std ON std.std_id = s.id_std  
										WHERE a.is_midterm = '1' 
										AND a.id_curs = '".cleanvars($_GET['id'])."'
										AND a.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND a.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
                                        AND a.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
										AND std.id_prg = '".cleanvars($listmidterm['id_prg'])."'
										AND std.std_semester = '".cleanvars($listmidterm['semester'])."'
										AND std.std_section = '".cleanvars($listmidterm['section'])."' 
										AND std.std_timing = '".cleanvars($listmidterm['timing'])."'");
	$countexam = mysqli_num_rows($sqllmsexam);

	$countSecondaryexam = 0;
	//For campuses other then MUL
	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) !=1) {
		
		$sqllmsSecondaryExam = $dblms->querylms("SELECT s.id 
										FROM ".COURSES_ASSIGNMENTS_STUDENTS." s  
										INNER JOIN ".COURSES_ASSIGNMENTS." a ON a.id = s.id_assignment 
										INNER JOIN ".EMPLYS." emp ON emp.emply_id = a.id_teacher 
										INNER JOIN ".STUDENTS." std ON std.std_id = s.id_std  
										WHERE a.is_midterm = '1' 
										AND a.id_curs = '".cleanvars($_GET['id'])."'
										AND a.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND a.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
                                        AND a.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
										AND std.id_prgsecondary = '".cleanvars($listmidterm['id_prg'])."'
										AND std.std_secondarysemester = '".cleanvars($listmidterm['semester'])."'
										AND std.std_section = '".cleanvars($listmidterm['section'])."' 
										AND std.std_timing = '".cleanvars($listmidterm['timing'])."'");
		$countSecondaryexam = mysqli_num_rows($sqllmsSecondaryExam);

	}
		
if(($countexam + $countSecondaryexam) >0) {
//------------------------------------------------
	$sqllmsexamcheck = $dblms->querylms("SELECT s.id, s.date_added 
											FROM ".COURSES_ASSIGNMENTS_STUDENTS." s  
											INNER JOIN ".COURSES_ASSIGNMENTS." a ON a.id = s.id_assignment 
											INNER JOIN ".EMPLYS." emp ON emp.emply_id = a.id_teacher 
											INNER JOIN ".STUDENTS." std ON std.std_id = s.id_std  
											WHERE s.id_modify != '0' 
											AND a.is_midterm = '1' 
											AND a.id_curs = '".cleanvars($_GET['id'])."'
											AND a.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
											AND a.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND a.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
											AND std.id_prg = '".cleanvars($listmidterm['id_prg'])."'
											AND std.std_semester = '".cleanvars($listmidterm['semester'])."'
											AND std.std_section = '".cleanvars($listmidterm['section'])."' 
											AND std.std_timing = '".cleanvars($listmidterm['timing'])."'");
	$countexamcheck = mysqli_num_rows($sqllmsexamcheck);

	$countSecondaryExamCheck = 0;
	//For campuses other then MUL
	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) !=1) {

		$sqllmsSecondaryExamCheck = $dblms->querylms("SELECT s.id, s.date_added 
											FROM ".COURSES_ASSIGNMENTS_STUDENTS." s  
											INNER JOIN ".COURSES_ASSIGNMENTS." a ON a.id = s.id_assignment 
											INNER JOIN ".EMPLYS." emp ON emp.emply_id = a.id_teacher 
											INNER JOIN ".STUDENTS." std ON std.std_id = s.id_std  
											WHERE s.id_modify != '0' 
											AND a.is_midterm = '1' 
											AND a.id_curs = '".cleanvars($_GET['id'])."'
											AND a.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
											AND a.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND a.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
											AND std.id_prgsecondary = '".cleanvars($listmidterm['id_prg'])."'
											AND std.std_secondarysemester = '".cleanvars($listmidterm['semester'])."'
											AND std.std_section = '".cleanvars($listmidterm['section'])."' 
											AND std.std_timing = '".cleanvars($listmidterm['timing'])."'");
		$countSecondaryExamCheck = mysqli_num_rows($sqllmsSecondaryExamCheck);
	}
	
 
if(($countexamcheck + $countSecondaryExamCheck) == ($countexam + $countSecondaryexam)) {
	$width = '110';
	 $valueexamcheck = mysqli_fetch_array($sqllmsexamcheck);
	
	$sqllmschecker  = $dblms->querylms("SELECT m.id 
												FROM ".MIDTERM." m 
												WHERE m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										  		AND m.id_prg = '".cleanvars($listmidterm['id_prg'])."' 
												AND m.section = '".cleanvars($listmidterm['section'])."'
												AND m.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
												AND m.timing = '".cleanvars($listmidterm['timing'])."' 
												AND m.semester = '".cleanvars($listmidterm['semester'])."'
												AND m.id_curs = '".cleanvars($_GET['id'])."'  LIMIT 1");
	if(mysqli_num_rows($sqllmschecker) == 1) {

		$valuemarks 	= mysqli_fetch_array($sqllmschecker);

		$publish = '<span class="btn btn-xs btn-purple">Published</span> 
					<a class="btn btn-xs btn-information" href="midtermawardprint.php?id='.$valuemarks['id'].'" target="_blank"><i class="icon-print"></i></a>';
	} else {
		
		$publish = '
				<form action="#" method="post" name="examform" id="examform">
					<input type="hidden" name="id_curs" id="id_curs" value="'.$_GET['id'].'">
					<input type="hidden" name="section" id="section" value="'.cleanvars($listmidterm['section']).'">
					<input type="hidden" name="prgid" id="prgid" value="'.cleanvars($listmidterm['id_prg']).'">
					<input type="hidden" name="semester" id="semester" value="'.cleanvars($listmidterm['semester']).'">
					<input type="hidden" name="id_teacher" id="id_teacher" value="'.cleanvars($rowsstd['emply_id']).'">
					<input type="hidden" name="timing" id="timing" value="'.cleanvars($listmidterm['timing']).'">
					<input type="hidden" name="exam_date" id="exam_date" value="'.cleanvars($valueexamcheck['date_added']).'">
					<button class="btn btn-xs btn-success confirmation" name="publish_result" id="publish_result">Add Award List</button>
				</form> 
		
				<script type="text/javascript">
					$(\'.confirmation\').on(\'click\', function () {
						return confirm(\'Do you really want to Add & publish Award List? Once it is added & published you will not have the option to edit the marks\');
					});
				</script>';
	}
} else {
	$width = '50';
	$publish = '';
}
	
} else {
	
	$width = '50';
	$publish = '';
	
}
	
//------------------------------------------------
echo '
<tr>
	<td style="width:40px; text-align:center;">'.$srbk.'</td>
	<td>'.$listmidterm['prg_name'].'</td>
	<td style="width:70px; text-align:center;">'.addOrdinalNumberSuffix($listmidterm['semester']).$sectcaps.'</td>
	<td style="width:70px; text-align:center;">'.get_programtiming($listmidterm['timing']).'</td>
	<td style="width:70px; text-align:center;">'.($rowcurstds['Totalstds'] + $sndarystds).'</td>
	<td style="width:60px; text-align:center;">'.($countexam + $countSecondaryexam).'</td>
	<td style="width:'.$width.'px;text-align:center;">
		'.$publish.'
	</td>
</tr>';
}

	echo ' 
</tbody>
</table>';

echo '
<h3 style="font-weight:600; margin-top:20px; color:green;">Finalterm Paper</h3>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center; ">Sr.#</th>
	<th style="font-weight:600;">Program</th>
	<th style="font-weight:600;text-align:center;">Semester</th>
	<th style="font-weight:600;text-align:center;">Timing</th>
	<th style="font-weight:600;text-align:center;">Students</th>
	<th style="font-weight:600;text-align:center;">Papers</th>
	<th style="text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
$srbk = 0;
	foreach($arrayquery as $listfinalterm) { 
$srbk++; 
//------------------------------------------------
if($listfinalterm['section']) { 
	$secthref 	= '&section='.$listfinalterm['section'];
	$sectcaps 	= ' ('.$listfinalterm['section'].')';
	$sectionstd = " AND std.std_section = '".cleanvars($listfinalterm['section'])."'";
} else  { 
	$secthref 	= '';
	$sectionstd = '';
	$sectcaps 	= '';
}
	
//------------------------------------------------
	$sqllmsfstds  = $dblms->querylms("SELECT COUNT(std.std_id) AS Totalstds
											FROM ".STUDENTS." std 
											WHERE (std.std_status = '2' OR std.std_status = '7') 
											AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
											AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND std.id_prg = '".cleanvars($listfinalterm['id_prg'])."' 
											AND std.std_timing = '".cleanvars($listfinalterm['timing'])."' 
											$sectionstd 
											AND std.std_semester = '".cleanvars($listfinalterm['semester'])."'
											AND std.std_session != '".cleanvars($_SESSION['userlogininfo']['LOGINIDADMISSION'])."'");
	$rowcurfstds = mysqli_fetch_array($sqllmsfstds);
//-----------------Students of 2ndary Program-------------------------------
if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) !=1) { 
	
	$sqllmsstdf2ndary  = $dblms->querylms("SELECT COUNT(std.std_id) AS Total2ndarystds
											FROM ".STUDENTS." std 
											WHERE (std.std_status = '2' OR std.std_status = '7') 
											AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
											AND std.id_campus 		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND std.id_prgsecondary = '".cleanvars($listfinalterm['id_prg'])."' 
											AND std.std_timing 		= '".cleanvars($listfinalterm['timing'])."' 
											$sectionstd 
											AND std.std_secondarysemester = '".cleanvars($listfinalterm['semester'])."'
											AND std.std_secondarysession != '".cleanvars($_SESSION['userlogininfo']['LOGINIDADMISSION'])."'");
	$rowcurf2ndary 	= mysqli_fetch_array($sqllmsstdf2ndary);
	$sndaryfstds 	= $rowcurf2ndary['Total2ndarystds'];
	
} else {
	$sndaryfstds 	= 0;
}

//------------------------------------------------
	$sqllmsfinalexam = $dblms->querylms("SELECT ex.id 
										FROM ".QUIZ_EXAMS." ex  
										INNER JOIN ".EMPLYS." emp ON emp.emply_id = ex.id_teacher 
										INNER JOIN ".STUDENTS." std ON std.std_id = ex.id_std  
										WHERE ex.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
                                        AND ex.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
										AND ex.id_prg = '".cleanvars($listfinalterm['id_prg'])."' 
										AND ex.section = '".cleanvars($listfinalterm['section'])."' 
										AND ex.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND ex.timing = '".cleanvars($listfinalterm['timing'])."' 
										AND ex.id_curs = '".cleanvars($_GET['id'])."' 
										AND ex.id_term = '2' 
										AND ex.semester = '".cleanvars($listfinalterm['semester'])."'");
	$countfinalexam = mysqli_num_rows($sqllmsfinalexam);

	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) !=1) { 

		$sqllmsFinalExamSecondary = $dblms->querylms("SELECT ex.id 
													FROM ".QUIZ_EXAMS." ex  
													INNER JOIN ".EMPLYS." emp ON emp.emply_id = ex.id_teacher 
													INNER JOIN ".STUDENTS." std ON std.std_id = ex.id_std  
													WHERE ex.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
													AND ex.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
													AND std.id_prgsecondary = '".cleanvars($listfinalterm['id_prg'])."'
													AND std.std_secondarysemester = '".cleanvars($listfinalterm['semester'])."'
													AND ex.section = '".cleanvars($listfinalterm['section'])."' 
													AND ex.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
													AND ex.timing = '".cleanvars($listfinalterm['timing'])."' 
													AND ex.id_curs = '".cleanvars($_GET['id'])."' 
													AND ex.id_term = '2' ");
		$countFinalExamSecondary = mysqli_num_rows($sqllmsFinalExamSecondary);

	} else{

		$countFinalExamSecondary = 0;

	}
		
if(($countfinalexam + $countFinalExamSecondary) >0) {
//------------------------------------------------
	$sqllmsfinalexamcheck = $dblms->querylms("SELECT ex.id, ex.date_attempt  
										FROM ".QUIZ_EXAMS." ex  
										INNER JOIN ".EMPLYS." emp ON emp.emply_id = ex.id_teacher 
										INNER JOIN ".STUDENTS." std ON std.std_id = ex.id_std  
										WHERE ex.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
                                        AND ex.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
										AND std.id_prg = '".cleanvars($listfinalterm['id_prg'])."' 
										AND std.std_semester = '".cleanvars($listfinalterm['semester'])."'
										AND std.std_section = '".cleanvars($listfinalterm['section'])."'
										AND ex.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND ex.timing = '".cleanvars($listfinalterm['timing'])."' 
										AND ex.id_curs = '".cleanvars($_GET['id'])."' 
										AND ex.id_term = '2' AND ex.paper_checked = '1'");
	$countfinalexamcheck = mysqli_num_rows($sqllmsfinalexamcheck);

	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) !=1) { 

		$sqllmsFinalExamCheckSecondary = $dblms->querylms("SELECT ex.id 
													FROM ".QUIZ_EXAMS." ex  
													INNER JOIN ".EMPLYS." emp ON emp.emply_id = ex.id_teacher 
													INNER JOIN ".STUDENTS." std ON std.std_id = ex.id_std  
													WHERE ex.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
													AND ex.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
													AND std.id_prgsecondary = '".cleanvars($listfinalterm['id_prg'])."'
													AND std.std_secondarysemester = '".cleanvars($listfinalterm['semester'])."'
													AND std.std_section = '".cleanvars($listfinalterm['section'])."' 
													AND ex.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
													AND ex.timing = '".cleanvars($listfinalterm['timing'])."' 
													AND ex.id_curs = '".cleanvars($_GET['id'])."' 
													AND ex.id_term = '2' AND ex.paper_checked = '1'");
		$countFinalExamCheckSecondary = mysqli_num_rows($sqllmsFinalExamCheckSecondary);
	
	} else{

		$countFinalExamCheckSecondary = 0;

	}

if(($countfinalexamcheck + $countFinalExamCheckSecondary) == ($countfinalexam + $countFinalExamSecondary)) {
	$fwidth = '110';	
	$valueexamcheck = mysqli_fetch_array($sqllmsfinalexamcheck);
//------------------------------------------------
	$sqllmsfinalterm  = $dblms->querylms("SELECT f.id 
												FROM ".FINALTERM." f 
												WHERE f.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										  		AND f.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
												AND f.id_prg = '".cleanvars($listfinalterm['id_prg'])."' 
												AND f.section = '".cleanvars($listfinalterm['section'])."'
												AND f.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
												AND f.timing = '".cleanvars($listfinalterm['timing'])."' 
												AND f.id_curs = '".cleanvars($_GET['id'])."' 
												AND f.semester = '".cleanvars($listfinalterm['semester'])."' 
												AND f.theory_practical 	= '1'   LIMIT 1");
	$valfinalterm 	= mysqli_fetch_array($sqllmsfinalterm);	
	
if($valfinalterm['id']) { 
	
	$fpublish = ' <a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid='.$listfinalterm['id_prg'].'&timing='.$listfinalterm['timing'].'&semester='.$listfinalterm['semester'].$secthref.'&view=Assessments&term=2"><i class="icon-zoom-in"></i></a> <a class="btn btn-xs btn-purple" href="finaltermawardprint.php?id='.$valfinalterm['id'].'" target="_blank"><i class="icon-print"></i> Print Sheet</a>';
} else { 
	
	$fpublish = '
				<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid='.$listfinalterm['id_prg'].'&timing='.$listfinalterm['timing'].'&semester='.$listfinalterm['semester'].$secthref.'&view=Assessments&term=2"><i class="icon-zoom-in"></i></a> 
				<a class="btn btn-xs btn-purple fconfirmation" href="courses.php?id='.$_GET['id'].'&prgid='.$listfinalterm['id_prg'].'&timing='.$listfinalterm['timing'].'&semester='.$listfinalterm['semester'].$secthref.'&view=Finaltermawrd&term=2"> Add Award </a>
			
		<script type="text/javascript">
		$(\'.fconfirmation\').on(\'click\', function () {
			return confirm(\'Do you really want to Add Final Term Award list?\');
		});
	</script>';
	
}
} else {
	
	$fwidth = '110';
	$fpublish = '<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid='.$listfinalterm['id_prg'].'&timing='.$listfinalterm['timing'].'&semester='.$listfinalterm['semester'].$secthref.'&view=Assessments&term=2"><i class="icon-zoom-in"></i></a>';
	
}
	
} else {
	
	$fwidth = '50';
	$fpublish = '';
	
}
//------------------------------------------------
echo '
<tr>
	<td style="width:40px; text-align:center;">'.$srbk.'</td>
	<td>'.$listfinalterm['prg_name'].'</td>
	<td style="width:70px; text-align:center;">'.addOrdinalNumberSuffix($listfinalterm['semester']).$sectcaps.'</td>
	<td style="width:70px; text-align:center;">'.get_programtiming($listfinalterm['timing']).'</td>
	<td style="width:70px; text-align:center;">'.($rowcurfstds['Totalstds'] + $sndaryfstds).'</td>
	<td style="width:60px; text-align:center;">'.($countfinalexam + $countFinalExamSecondary).'</td>
	<td style="width:'.$fwidth.'px;text-align:center;">
		'.$fpublish.'
	</td>
</tr>';	
	}
	echo ' 
</tbody>
</table>';

if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) == 1){
echo '<h2 style="font-weight:600; margin-top:20px; color:#555;">Re-attempt Paper</h3>';
//Re-attempt Paper
//------------------------------------------------
	$sqllmsPrograms  = $dblms->querylms("SELECT rr.id_prg, rr.current_semester, std.std_section, std.std_timing, p.prg_name 
											FROM ".REPEAT_REGISTRATION." rr  
											INNER JOIN ".STUDENTS." std ON std.std_id = rr.id_std
											INNER JOIN ".PROGRAMS." p ON p.prg_id = rr.id_prg   
											INNER JOIN ".REPEAT_COURSES." rc ON rc.id_setup = rr.id  
											WHERE rr.status =  '1' AND rr.term = '1'
											AND rr.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND rr.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND rc.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
											AND rc.id_curs = '".cleanvars($_GET['id'])."'
											GROUP BY rr.id_prg, rr.current_semester, std.std_section");
	$countPrgs = mysqli_num_rows($sqllmsPrograms);
	$arrayMidPrg = array();
	while($rowPrg = mysqli_fetch_array($sqllmsPrograms)) { 
		$arrayMidPrg[] = $rowPrg;
	}
//--------------------------------------------------
if($countPrgs > 0){
echo '
<h3 style="font-weight:600; margin-top:20px; color:#00f;">Midterm Paper</h3>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center; ">Sr.#</th>
	<th style="font-weight:600;">Program</th>
	<th style="font-weight:600;text-align:center;">Semester</th>
	<th style="font-weight:600;text-align:center;">Timing</th>
	<th style="font-weight:600;text-align:center;">Students</th>
	<th style="font-weight:600;text-align:center;">Papers</th>
	<th style="text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srbk = 0;
foreach($arrayMidPrg as $listMidReattempt) { 
	$srbk++; 

	if($listMidReattempt['std_section']) { 
		$secthref 	= '&section='.$listMidReattempt['std_section'];
		$sectcaps 	= ' ('.$listMidReattempt['std_section'].')';
		$sectionstd = " AND std.std_section = '".cleanvars($listMidReattempt['std_section'])."'";
	} else  { 
		$secthref 	= '';
		$sectionstd = '';
		$sectcaps 	= '';
	}
//------------------------------------------------
	$sqllmsstds  = $dblms->querylms("SELECT COUNT(std.std_id) AS Totalstds
											FROM ".STUDENTS." std 
											INNER JOIN ".REPEAT_REGISTRATION." rr ON rr.id_std = std.std_id
											WHERE (std.std_status = '2' OR std.std_status = '7') 
											AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
											AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND std.id_prg = '".cleanvars($listMidReattempt['id_prg'])."'
											AND std.std_semester = '".cleanvars($listMidReattempt['current_semester'])."' ");
	$rowcurstds = mysqli_fetch_array($sqllmsstds);
//------------------------------------------------
	$sqllmsexam = $dblms->querylms("SELECT ex.id 
										FROM ".REPEAT_EXAM." ex  
										INNER JOIN ".EMPLYS." emp ON emp.emply_id = ex.id_teacher 
										INNER JOIN ".STUDENTS." std ON std.std_id = ex.id_std  
										WHERE ex.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND ex.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
										AND ex.id_prg = '".cleanvars($listMidReattempt['id_prg'])."' 
										AND ex.section = '".cleanvars($listMidReattempt['std_section'])."' 
										AND ex.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND ex.timing = '".cleanvars($listMidReattempt['std_timing'])."' 
										AND ex.id_curs = '".cleanvars($_GET['id'])."' 
										AND ex.id_term = '1' 
										AND ex.semester = '".cleanvars($listMidReattempt['current_semester'])."'");
	$countexam = mysqli_num_rows($sqllmsexam);
		
	if(($countexam) >0) {
	//------------------------------------------------
		$sqllmsexamcheck = $dblms->querylms("SELECT ex.id, ex.date_attempt  
											FROM ".REPEAT_EXAM." ex  
											INNER JOIN ".EMPLYS." emp ON emp.emply_id = ex.id_teacher 
											INNER JOIN ".STUDENTS." std ON std.std_id = ex.id_std  
											WHERE ex.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND ex.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
											AND ex.id_prg = '".cleanvars($listMidReattempt['id_prg'])."' 
											AND ex.section = '".cleanvars($listMidReattempt['std_section'])."'
											AND ex.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
											AND ex.timing = '".cleanvars($listMidReattempt['std_timing'])."' 
											AND ex.id_curs = '".cleanvars($_GET['id'])."' 
											AND ex.id_term = '1' 
											AND ex.paper_checked = '1' 
											AND ex.semester = '".cleanvars($listMidReattempt['current_semester'])."'");
		$countexamcheck = mysqli_num_rows($sqllmsexamcheck);
		
	
		if($countexamcheck == $countexam) {
			$width = '110';
				$valueexamcheck = mysqli_fetch_array($sqllmsexamcheck);
			
			$sqllmschecker  = $dblms->querylms("SELECT m.id 
													FROM ".REPEAT_MIDTERM." m 
													WHERE m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
													AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
													AND m.id_prg = '".cleanvars($listMidReattempt['id_prg'])."' 
													AND m.section = '".cleanvars($listMidReattempt['std_section'])."'
													AND m.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
													AND m.timing = '".cleanvars($listMidReattempt['std_timing'])."' 
													AND m.semester = '".cleanvars($listMidReattempt['current_semester'])."'
													AND m.id_curs = '".cleanvars($_GET['id'])."'  LIMIT 1");
			$valuemarks 	= mysqli_fetch_array($sqllmschecker);

			if($valuemarks['id']) {
				$publish = '<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid='.$listMidReattempt['id_prg'].'&timing='.$listMidReattempt['std_timing'].'&semester='.$listMidReattempt['current_semester'].$secthref.'&view=Assessments&term=1&reattempt=1"><i class="icon-zoom-in"></i></a> <span class="btn btn-xs btn-purple">Published</span> 
							<a class="btn btn-xs btn-information" href="repeatmidtermawardprint.php?id='.$valuemarks['id'].'" target="_blank"><i class="icon-print"></i></a>';
			} else {
				
				$publish = '
						<form action="#" method="post" name="examform" id="examform">
						<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid='.$listMidReattempt['id_prg'].'&timing='.$listMidReattempt['std_timing'].'&semester='.$listMidReattempt['current_semester'].$secthref.'&view=Assessments&term=1&reattempt=1"><i class="icon-zoom-in"></i></a> 
							<input type="hidden" name="id_curs" id="id_curs" value="'.$_GET['id'].'">
							<input type="hidden" name="section" id="section" value="'.cleanvars($listMidReattempt['std_section']).'">
							<input type="hidden" name="prgid" id="prgid" value="'.cleanvars($listMidReattempt['id_prg']).'">
							<input type="hidden" name="semester" id="semester" value="'.cleanvars($listMidReattempt['current_semester']).'">
							<input type="hidden" name="id_teacher" id="id_teacher" value="'.cleanvars($rowsstd['emply_id']).'">
							<input type="hidden" name="timing" id="timing" value="'.cleanvars($listMidReattempt['std_timing']).'">
							<input type="hidden" name="exam_date" id="exam_date" value="'.cleanvars($valueexamcheck['date_attempt']).'">
							<button class="btn btn-xs btn-success confirmation" name="publish_reattempt_mid_result" id="publish_reattempt_mid_result">Publish</button>
						</form> 
				
				
				<script type="text/javascript">
				$(\'.confirmation\').on(\'click\', function () {
					return confirm(\'Do you really want to publish? Once it is published you will not have the option to edit the marks\');
				});
			</script>';
			}
		} else {
			$width = '50';
			$publish = '<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid='.$listMidReattempt['id_prg'].'&timing='.$listMidReattempt['std_timing'].'&semester='.$listMidReattempt['current_semester'].$secthref.'&view=Assessments&term=1&reattempt=1"><i class="icon-zoom-in"></i></a> ';
		}
		
	} else {
		
		$width = '50';
		$publish = '';
		
	}

	//------------------------------------------------
	echo '
	<tr>
		<td style="width:40px; text-align:center;">'.$srbk.'</td>
		<td>'.$listMidReattempt['prg_name'].'</td>
		<td style="width:70px; text-align:center;">'.addOrdinalNumberSuffix($listMidReattempt['current_semester']).$sectcaps.'</td>
		<td style="width:70px; text-align:center;">'.get_programtiming($listMidReattempt['std_timing']).'</td>
		<td style="width:70px; text-align:center;">'.($rowcurstds['Totalstds']).'</td>
		<td style="width:60px; text-align:center;">'.($countexam).'</td>
		<td style="width:'.$width.'px;text-align:center;">
			'.$publish.'
		</td>
	</tr>';
}

	echo ' 
</tbody>
</table>';
}

//------------------------------------------------
	$sqllmsPrograms  = $dblms->querylms("SELECT rr.id_prg, rr.current_semester, std.std_section, std.std_timing, p.prg_name 
											FROM ".REPEAT_REGISTRATION." rr  
											INNER JOIN ".STUDENTS." std ON std.std_id = rr.id_std
											INNER JOIN ".PROGRAMS." p ON p.prg_id = rr.id_prg   
											INNER JOIN ".REPEAT_COURSES." rc ON rc.id_setup = rr.id  
											WHERE rr.status =  '1' AND rr.term = '2'
											AND rr.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND rr.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND rc.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
											AND rc.id_curs = '".cleanvars($_GET['id'])."'
											GROUP BY rr.id_prg, rr.current_semester, std.std_section");
	$countPrgs = mysqli_num_rows($sqllmsPrograms);
	$arrayFinalPrg = array();
	while($rowPrg = mysqli_fetch_array($sqllmsPrograms)) { 
		$arrayFinalPrg[] = $rowPrg;
	}
//--------------------------------------------------
if($countPrgs > 0){
echo '
<h3 style="font-weight:600; margin-top:20px; color:green;">Finalterm Paper</h3>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center; ">Sr.#</th>
	<th style="font-weight:600;">Program</th>
	<th style="font-weight:600;text-align:center;">Semester</th>
	<th style="font-weight:600;text-align:center;">Timing</th>
	<th style="font-weight:600;text-align:center;">Students</th>
	<th style="font-weight:600;text-align:center;">Papers</th>
	<th style="text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srbk = 0;
foreach($arrayFinalPrg as $listFinalReattempt) { 
	$srbk++; 

	if($listFinalReattempt['std_section']) { 
		$secthref 	= '&section='.$listFinalReattempt['std_section'];
		$sectcaps 	= ' ('.$listFinalReattempt['std_section'].')';
		$sectionstd = " AND std.std_section = '".cleanvars($listFinalReattempt['std_section'])."'";
	} else  { 
		$secthref 	= '';
		$sectionstd = '';
		$sectcaps 	= '';
	}
//------------------------------------------------
	$sqllmsstds  = $dblms->querylms("SELECT COUNT(std.std_id) AS Totalstds
											FROM ".STUDENTS." std 
											INNER JOIN ".REPEAT_REGISTRATION." rr ON rr.id_std = std.std_id
											WHERE (std.std_status = '2' OR std.std_status = '7') 
											AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
											AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND std.id_prg = '".cleanvars($listFinalReattempt['id_prg'])."'
											AND std.std_semester = '".cleanvars($listFinalReattempt['current_semester'])."' ");
	$rowcurstds = mysqli_fetch_array($sqllmsstds);
//------------------------------------------------
	$sqllmsexam = $dblms->querylms("SELECT ex.id 
										FROM ".REPEAT_EXAM." ex  
										INNER JOIN ".EMPLYS." emp ON emp.emply_id = ex.id_teacher 
										INNER JOIN ".STUDENTS." std ON std.std_id = ex.id_std  
										WHERE ex.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND ex.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
										AND ex.id_prg = '".cleanvars($listFinalReattempt['id_prg'])."' 
										AND ex.section = '".cleanvars($listFinalReattempt['std_section'])."' 
										AND ex.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND ex.timing = '".cleanvars($listFinalReattempt['std_timing'])."' 
										AND ex.id_curs = '".cleanvars($_GET['id'])."' 
										AND ex.id_term = '2' 
										AND ex.semester = '".cleanvars($listFinalReattempt['current_semester'])."'");
	$countexam = mysqli_num_rows($sqllmsexam);
		
	if(($countexam) >0) {
	//------------------------------------------------
		$sqllmsexamcheck = $dblms->querylms("SELECT ex.id, ex.date_attempt  
											FROM ".REPEAT_EXAM." ex  
											INNER JOIN ".EMPLYS." emp ON emp.emply_id = ex.id_teacher 
											INNER JOIN ".STUDENTS." std ON std.std_id = ex.id_std  
											WHERE ex.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND ex.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
											AND ex.id_prg = '".cleanvars($listFinalReattempt['id_prg'])."' 
											AND ex.section = '".cleanvars($listFinalReattempt['std_section'])."'
											AND ex.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
											AND ex.timing = '".cleanvars($listFinalReattempt['std_timing'])."' 
											AND ex.id_curs = '".cleanvars($_GET['id'])."' 
											AND ex.id_term = '2' 
											AND ex.paper_checked = '1' 
											AND ex.semester = '".cleanvars($listFinalReattempt['current_semester'])."'");
		$countexamcheck = mysqli_num_rows($sqllmsexamcheck);
		
		if($countexamcheck == $countexam) {
			$width = '110';
			$valueexamcheck = mysqli_fetch_array($sqllmsexamcheck);
			
			$sqllmschecker  = $dblms->querylms("SELECT m.id 
													FROM ".REPEAT_FINALTERM." m 
													WHERE m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
													AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
													AND m.id_prg = '".cleanvars($listFinalReattempt['id_prg'])."' 
													AND m.section = '".cleanvars($listFinalReattempt['std_section'])."'
													AND m.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
													AND m.timing = '".cleanvars($listFinalReattempt['std_timing'])."' 
													AND m.semester = '".cleanvars($listFinalReattempt['current_semester'])."'
													AND m.id_curs = '".cleanvars($_GET['id'])."'  LIMIT 1");
			$valuemarks 	= mysqli_fetch_array($sqllmschecker);

			if($valuemarks['id']) {
				$publish = '<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid='.$listFinalReattempt['id_prg'].'&timing='.$listFinalReattempt['std_timing'].'&semester='.$listFinalReattempt['current_semester'].$secthref.'&view=Assessments&term=2&reattempt=1"><i class="icon-zoom-in"></i></a> <span class="btn btn-xs btn-purple">Published</span> 
							<a class="btn btn-xs btn-information" href="repeatfinaltermawardprint.php?id='.$valuemarks['id'].'" target="_blank"><i class="icon-print"></i></a>';
			} else {
				
				$publish = '
						<form action="#" method="post" name="examform" id="examform">
						<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid='.$listFinalReattempt['id_prg'].'&timing='.$listFinalReattempt['std_timing'].'&semester='.$listFinalReattempt['current_semester'].$secthref.'&view=Assessments&term=2&reattempt=1"><i class="icon-zoom-in"></i></a> 
							<input type="hidden" name="id_curs" id="id_curs" value="'.$_GET['id'].'">
							<input type="hidden" name="section" id="section" value="'.cleanvars($listFinalReattempt['std_section']).'">
							<input type="hidden" name="prgid" id="prgid" value="'.cleanvars($listFinalReattempt['id_prg']).'">
							<input type="hidden" name="semester" id="semester" value="'.cleanvars($listFinalReattempt['current_semester']).'">
							<input type="hidden" name="id_teacher" id="id_teacher" value="'.cleanvars($rowsstd['emply_id']).'">
							<input type="hidden" name="timing" id="timing" value="'.cleanvars($listFinalReattempt['std_timing']).'">
							<input type="hidden" name="exam_date" id="exam_date" value="'.cleanvars($valueexamcheck['date_attempt']).'">
							<button class="btn btn-xs btn-success confirmation" name="publish_reattempt_final_result" id="publish_reattempt_final_result">Publish</button>
						</form> 
				
				
				<script type="text/javascript">
					$(\'.confirmation\').on(\'click\', function () {
						return confirm(\'Do you really want to publish? Once it is published you will not have the option to edit the marks\');
					});
				</script>';
			}
		} else {
			$width = '50';
			$publish = '<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid='.$listFinalReattempt['id_prg'].'&timing='.$listFinalReattempt['std_timing'].'&semester='.$listFinalReattempt['current_semester'].$secthref.'&view=Assessments&term=2&reattempt=1"><i class="icon-zoom-in"></i></a> ';
		}
		
	} else {
		
		$width = '50';
		$publish = '';
		
	}
	//------------------------------------------------
	echo '
	<tr>
		<td style="width:40px; text-align:center;">'.$srbk.'</td>
		<td>'.$listFinalReattempt['prg_name'].'</td>
		<td style="width:70px; text-align:center;">'.addOrdinalNumberSuffix($listFinalReattempt['current_semester']).$sectcaps.'</td>
		<td style="width:70px; text-align:center;">'.get_programtiming($listFinalReattempt['std_timing']).'</td>
		<td style="width:70px; text-align:center;">'.($rowcurstds['Totalstds']).'</td>
		<td style="width:60px; text-align:center;">'.($countexam).'</td>
		<td style="width:'.$width.'px;text-align:center;">
			'.$publish.'
		</td>
	</tr>';
}

	echo ' 
</tbody>
</table>';
}
}

//--------------------------------------------------
} else { 
	
//------------------------------------------------
if(isset($_GET['section'])) { 
	$secthref 	= '&section='.$_GET['section'];
	
} else  { 
	$secthref 	= '';

}
//------------------------------------------------
	include_once("assessments/list.php");
	include_once("assessments/listReattempt.php");
	include_once("assessments/detail.php");
	include_once("assessments/detailReattempt.php");
	include_once("assessments/edit.php");
	include_once("assessments/editReattempt.php");
	
} // end check if program id
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
</div>'; 

?>