<?php 
//------------------------------------------------
if(!isset($_GET['prgid'])) { 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-12">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">';
//-------------------------------------------------- 
	
	$banklink = '<a class="btn btn-mid btn-success" href="courses.php?id='.$_GET['id'].'"> Back to Course </a>';
 
//--------------------------------------
echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Final Term Award List </h3></span>
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
	
if($countrelted>0) {
//--------------------------------------------------
echo '
<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;"> 
	Total Records: ('.number_format($countrelted).')
</div>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center; ">Sr.#</th>
	<th style="font-weight:600;">Program</th>
	<th style="font-weight:600;text-align:center;">Semester</th>
	<th style="font-weight:600;text-align:center;">Timing</th>
	<th style="font-weight:600;text-align:center;">Students</th>
	<th style="font-weight:600;text-align:center;">Forward To</th>
	<th style="font-weight:600;text-align:center;">Award List</th>
</tr>
</thead>
<tbody>';
$srbk = 0;

//------------------------------------------------
	while($rowrelted = mysqli_fetch_array($sqllmscursrelated)) { 
$srbk++; 
//------------------------------------------------
if($rowrelted['section']) { 
	$secthref 	= '&section='.$rowrelted['section'];
	$sectstd 	= " AND std.std_section = '".cleanvars($rowrelted['section'])."'";
	$sectmid 	= " AND m.section = '".cleanvars($rowrelted['section'])."'";
} else  { 
	$secthref 	= '';
	$sectstd 	= " AND std.std_section = ''";
	$sectmid 	= " AND m.section = ''";
}

//------------------------------------------------
	$sqllmsstds  = $dblms->querylms("SELECT COUNT(std.std_id) AS Totalstds
											FROM ".STUDENTS." std 
											WHERE (std.std_status = '2' OR std.std_status = '7') 
											AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 						
											AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND std.id_prg = '".cleanvars($rowrelted['id_prg'])."' 
											AND std.std_timing = '".cleanvars($rowrelted['timing'])."' 
											$sectstd 
											AND std.std_semester = '".cleanvars($rowrelted['semester'])."' ");
	$rowcurstds = mysqli_fetch_array($sqllmsstds);

	$secondaryStudents = 0;
	//For Secondary Program other then MUL
	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) !=1) { 
		
		$sqllmsSecondaryStudents  = $dblms->querylms("SELECT COUNT(std.std_id) AS totalSecondaryStudents
												FROM ".STUDENTS." std 
												WHERE (std.std_status = '2' OR std.std_status = '7') 
												AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
												AND std.id_campus 		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND std.id_prgsecondary = '".cleanvars($rowrelted['id_prg'])."' 
												AND std.std_timing 		= '".cleanvars($rowrelted['timing'])."' 
												$sectionstd 
												AND std.std_secondarysemester = '".cleanvars($rowrelted['semester'])."'
												AND std.std_secondarysession != '".cleanvars($_SESSION['userlogininfo']['LOGINIDADMISSION'])."'");
		$valueSecondaryStudents 	= mysqli_fetch_array($sqllmsSecondaryStudents);
		$secondaryStudents 	= $valueSecondaryStudents['totalSecondaryStudents'];
		
	}

	//Repeat/Migration Courses
	$sqllmsRepeatCurs  = $dblms->querylms("SELECT std.std_id, std.std_section, std.std_semester, std.std_name, std.std_photo,
												std.std_timing, std.id_prg, std.std_rollno, std.std_session, rc.semester, 
												rc.timing, rr.type   
												FROM ".REPEAT_COURSES." rc    
												INNER JOIN ".COURSES." c ON c.curs_id = rc.id_curs   
												INNER JOIN ".REPEAT_REGISTRATION." rr ON rr.id = rc.id_setup    
												INNER JOIN ".STUDENTS." std ON std.std_id = rr.id_std     
												WHERE rr.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
												AND rc.id_timetable = '".cleanvars($rowrelted['id_setup'])."'       
												AND rr.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
												GROUP BY rr.id_std");
	$valuerepstd = mysqli_num_rows($sqllmsRepeatCurs);
//------------------------------------------------
	$sqllmssetup  = $dblms->querylms("SELECT m.id, m.exam_date, m.forward_to   
												FROM ".FINALTERM." m  
												WHERE  m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										  		AND m.id_prg 	= '".cleanvars($rowrelted['id_prg'])."' 
												AND m.timing 	= '".cleanvars($rowrelted['timing'])."' 
											  	AND m.semester 	= '".cleanvars($rowrelted['semester'])."' 
												$sectmid 
												AND m.theory_practical = '1' 
												AND m.is_liberalarts != '1' 
												AND m.id_curs 	= '".cleanvars($_GET['id'])."' LIMIT 1");
	$valuesetup = mysqli_fetch_array($sqllmssetup); 
	if($valuesetup['id']) { 
	//------------------------------------------------
		if($valuesetup['forward_to'] == 4) {  
			$forwardto = 'HODs / Dean';
		} else { 
			$forwardto = 'Pending';
		}

//------------------------------------------------
		$linkhref = '<a class="btn btn-xs btn-success iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>FINAL TERM AWARD LIST '.$rowrelted['prg_name'].' '.addOrdinalNumberSuffix($rowrelted['semester']).' ('.$cursename.')</b>" data-src="finaltermawardlistview.php?id='.$valuesetup['id'].'&timing='.$rowrelted['timing'].'&curse='.$cursename.'&la=2" href="#"><i class="icon-zoom-in"></i></a> 
			<a class="btn btn-xs btn-information" href="finaltermawardprint.php?id='.$valuesetup['id'].'" target="_blank"><i class="icon-print"></i></a> ';
		
		if($valuesetup['forward_to'] != 4) { 
				$linkhref .=  '<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid='.$rowrelted['id_prg'].'&timing='.$rowrelted['timing'].'&semester='.$rowrelted['semester'].$secthref.'&view=Finaltermawrd&term=2"><i class="icon-pencil"></i></a>';
		}
		
	}  else { 
		$linkhref = '<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid='.$rowrelted['id_prg'].'&timing='.$rowrelted['timing'].'&semester='.$rowrelted['semester'].$secthref.'&view=Finaltermawrd"><i class="icon-plus"></i> Add</a>';
		$forwardto = '';
	}
//------------------------------------------------
echo '
<tr>
	<td style="width:30px; text-align:center;">'.$srbk.'</td>
	<td>'.$rowrelted['prg_name'].'</td>
	<td style="width:70px; text-align:center;">'.addOrdinalNumberSuffix($rowrelted['semester']).' '.$rowrelted['section'].'</td>
	<td style="width:70px; text-align:center;">'.get_programtiming($rowrelted['timing']).'</td>
	<td style="width:70px; text-align:center;">'.($rowcurstds['Totalstds'] + $secondaryStudents + $valuerepstd).'</td>
	<td style="width:100px; text-align:center;">'.$forwardto.'</td>
	<td style="width:85px; text-align:center;">'.$linkhref.'</td>
</tr>';

//--------------------------------------------------
	}
echo ' 
</tbody>
</table>';
	
} // end count check timetable
	
// start Liberal Arts
	
$sqllmsCoursesAllocation  = $dblms->querylms("SELECT ca.id_curs, ca.semester, ca.section, ca.timing 
													FROM ".LA_COURSES_ALLOCATION." ca
													WHERE  ca.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
													AND ca.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
													AND ca.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
													AND ca.status = '1' AND ca.id_curs = '".cleanvars($_GET['id'])."' 
													AND ca.is_deleted != '1'
													GROUP BY ca.id_curs, ca.section
													ORDER BY ca.section ASC");
if (mysqli_num_rows($sqllmsCoursesAllocation) > 0) {
echo '
<h3 style="font-weight:600; color:orangered;">Liberal Arts</h3>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center; ">Sr.#</th>
	<th style="font-weight:600;text-align:center;">Section</th>
	<th style="font-weight:600;text-align:center;">Timing</th>
	<th style="font-weight:600;text-align:center;">Students</th>
	<th style="font-weight:600;text-align:center;">Forward To</th>
	<th style="font-weight:600;text-align:center;">Award List</th>
	
</tr>
</thead>
<tbody>';
$srca = 0;
while($valueCourseAllocation = mysqli_fetch_array($sqllmsCoursesAllocation)) { 
	$srca++;
	
	// students 
	$sqllmslatotalstudents  = $dblms->querylms("SELECT COUNT(od.id) as Totalstudents 
														FROM ".LA_STUDENT_REGISTRATION_DETAIL." od
														INNER JOIN ".LA_STUDENT_REGISTRATION." oc ON oc.id = od.id_setup 
														WHERE oc.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
														AND oc.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'
														AND od.id_curs =  '".cleanvars($valueCourseAllocation['id_curs'])."'  
														AND od.section =  '".cleanvars($valueCourseAllocation['section'])."'  
														AND od.timing =  '".cleanvars($valueCourseAllocation['timing'])."'  
														AND oc.is_deleted != '1'");
	$valuetotalstudents = mysqli_fetch_array($sqllmslatotalstudents);

	
	//Check Finalterm award list is added
	$sqllmsLAsetup  = $dblms->querylms("SELECT f.id, f.exam_date, f.forward_to 
												FROM ".FINALTERM." f  
												WHERE f.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND f.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
												AND f.is_liberalarts = '1' AND f.theory_practical = '1' 
												AND f.timing 	= '".cleanvars($valueCourseAllocation['timing'])."' 	
												AND f.section 	= '".cleanvars($valueCourseAllocation['section'])."' 				
												AND f.id_curs 	= '".cleanvars($valueCourseAllocation['id_curs'])."' LIMIT 1");
	$valueLAsetup = mysqli_fetch_array($sqllmsLAsetup); 
	$forwardLAto = '';
	if($valueLAsetup['id']) {

		if($valueLAsetup['forward_to'] == 4) {  
			$forwardLAto = 'HODs / Dean';
		} else { 
			$forwardLAto = 'Pending';
		}

		$linkhrefLA = '<a class="btn btn-xs btn-success iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>FINAL TERM AWARD LIST  '.addOrdinalNumberSuffix($valueCourseAllocation['semester']).' ('.$cursename.')</b>" data-src="finaltermawardlistview.php?id='.$valueLAsetup['id'].'&timing='.$valueCourseAllocation['timing'].'&section='.$valueCourseAllocation['section'].'&curse='.$cursename.'&la=1" href="#"><i class="icon-zoom-in"></i></a>   
		<a class="btn btn-xs btn-information" href="finaltermawardprint.php?id='.$valueLAsetup['id'].'" target="_blank"><i class="icon-print"></i></a>';
		
		if($valueLAsetup['forward_to'] != 4) { 
				$linkhrefLA .=  ' <a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid=la&timing='.$valueCourseAllocation['timing'].'&semester='.$valueCourseAllocation['semester'].'&section='.$valueCourseAllocation['section'].'&view=Finaltermawrd"><i class="icon-pencil"></i></a> ';
		}
		
	}  else { 
		$linkhrefLA = '<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid=la&timing='.$valueCourseAllocation['timing'].'&semester='.$valueCourseAllocation['semester'].'&section='.$valueCourseAllocation['section'].'&view=Finaltermawrd"><i class="icon-plus"></i> Add</a>';
		$forwardto = '';
	}
	// end check midterm award list is added

	echo '
	<tr>
		<td style="width:40px; text-align:center;">'.$srca.'</td>
		<td style="text-align:center;"> '.$valueCourseAllocation['section'].'</td>
		<td style="width:70px; text-align:center;">'.get_programtiming($valueCourseAllocation['timing']).'</td>
		<td style="width:70px; text-align:center;">'.number_format($valuetotalstudents['Totalstudents']).'</td>
		<td style="width:100px; text-align:center;">'.$forwardLAto.'</td>
		<td style="width:85px; text-align:center;">'.$linkhrefLA.'</td>
	</tr>';
	
} // end while loop
	
echo ' 
</tbody>
</table>';
//--------------------------------------------------
} // end count check
	
// end liberal Arts
//--------------------------------------------------
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
//--------------------------------------------------
}