<?php 
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">';
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
if($_GET['prgid'] != 'la') {
	$sqllmsprgname  = $dblms->querylms("SELECT p.prg_name, p.prg_code  
										FROM ".PROGRAMS." p  
										WHERE p.prg_id = '".cleanvars($_GET['prgid'])."' LIMIT 1");
	$valuepname = mysqli_fetch_array($sqllmsprgname);
	$prgname = '('.strtoupper($valuepname['prg_code']).' - '.addOrdinalNumberSuffix($_GET['semester']).$seccaption.') '.get_programtiming($_GET['timing']);
} else {
	$prgname = 'Section: '.$seccaption.' ('.get_programtiming($_GET['timing']).')';
}
//------------------------------------------------
	$banklink = '<a class="btn btn-mid btn-success" href="courses.php?id='.$_GET['id'].'&view=Students"> Back </a>';
}
//--------------------------------------
echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Enrolled Students '.$prgname.'</h3></span>
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
	$sqllmscursrelated  = $dblms->querylms("SELECT DISTINCT(t.id_prg), d.id_setup, d.theorypractical,
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
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center; ">Sr.#</th>
	<th style="font-weight:600;">Program</th>
	<th style="font-weight:600;text-align:center;">Semester</th>
	<th style="font-weight:600;text-align:center;">Timing</th>
	<th style="font-weight:600;text-align:center;">Students</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srbk = 0;
	while($rowrelted = mysqli_fetch_array($sqllmscursrelated)) { 
	$srbk++; 
	//------------------------------------------------
	if($rowrelted['section']) { 
		$secthref 	= '&section='.$rowrelted['section'];
		$sectcaps 	= ' ('.$rowrelted['section'].')';
		$sectionstd = " AND std.std_section = '".cleanvars($rowrelted['section'])."'";
	} else  { 
		$secthref 	= '';
		$sectionstd = " AND std.std_section = ''";
		$sectcaps 	= '';
	}
//------------------------------------------------
	$sqllmsstds  = $dblms->querylms("SELECT COUNT(std.std_id) AS Totalstds
											FROM ".STUDENTS." std 
											WHERE (std.std_status = '2' OR std.std_status = '7') 
											AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
											AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND std.id_prg = '".cleanvars($rowrelted['id_prg'])."' 
											AND std.std_timing = '".cleanvars($rowrelted['timing'])."' 
											$sectionstd 
											AND std.std_semester = '".cleanvars($rowrelted['semester'])."' ");
	$rowcurstds = mysqli_fetch_array($sqllmsstds);

	//Count Repeat Students
	$sqllmsRepeatStds  = $dblms->querylms("SELECT COUNT(rr.id) AS totalRepeat
												FROM ".REPEAT_REGISTRATION." rr 
												INNER JOIN ".REPEAT_COURSES." rc ON rc.id_setup = rr.id   
												INNER JOIN ".STUDENTS." std ON std.std_id = rr.id_std   
												WHERE rc.id_curs = '".cleanvars($_GET['id'])."' AND rc.theory_practical = '".cleanvars($rowrelted['theorypractical'])."' 
												AND rc.id_timetable =  '".$rowrelted['id_setup']."' AND rc.id_teacher = '".cleanvars($rowsstd['emply_id'])."'
												AND (rr.type = '1' OR rr.type = '3')
												AND rr.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
												AND (std.std_status = '2' OR std.std_status = '7')
												AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
												AND std.id_prg = '".cleanvars($rowrelted['id_prg'])."' 
												AND std.std_timing = '".cleanvars($rowrelted['timing'])."' 
												AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'");
	$rowRepeatStds = mysqli_fetch_array($sqllmsRepeatStds);

	//-----------------Students of 2ndary Program-------------------------------
	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) !=1) { 
		
		$sqllmsstd2ndary  = $dblms->querylms("SELECT COUNT(std.std_id) AS Total2ndarystds
												FROM ".STUDENTS." std 
												WHERE (std.std_status = '2' OR std.std_status = '7') 
												AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
												AND std.id_campus 		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND std.id_prgsecondary = '".cleanvars($rowrelted['id_prg'])."' 
												AND std.std_timing 		= '".cleanvars($rowrelted['timing'])."' 
												$sectionstd 
												AND std.std_secondarysemester = '".cleanvars($rowrelted['semester'])."' ");
		
		$rowcur2ndary 	= mysqli_fetch_array($sqllmsstd2ndary);
		$sndarystds 	= $rowcur2ndary['Total2ndarystds'];
		
	} else {
		$sndarystds 	= 0;
	}

	echo '
	<tr>
		<td style="width:40px; text-align:center;">'.$srbk.'</td>
		<td>'.$rowrelted['prg_name'].'</td>
		<td style="width:70px; text-align:center;">'.addOrdinalNumberSuffix($rowrelted['semester']).$sectcaps.'</td>
		<td style="width:70px; text-align:center;">'.get_programtiming($rowrelted['timing']).'</td>
		<td style="width:70px; text-align:center;">'.($rowcurstds['Totalstds'] + $rowRepeatStds['totalRepeat'] + $sndarystds).'</td>
		<td style="width:50px;text-align:center;">
			<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid='.$rowrelted['id_prg'].'&timing='.$rowrelted['timing'].'&semester='.$rowrelted['semester'].$secthref.'&view=Students"><i class="icon-zoom-in"></i></a></td>
	</tr>';
	}
echo ' 
</tbody>
</table>';
} // end count 

//Start Liberal Arts
$sqllmsCoursesAllocation  = $dblms->querylms("SELECT DISTINCT(ca.id_curs), ca.semester, ca.section, ca.timing 
													FROM ".LA_COURSES_ALLOCATION." ca
													WHERE  ca.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
													AND ca.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
													AND ca.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
													AND ca.status = '1' AND ca.id_curs = '".cleanvars($_GET['id'])."' 
													AND ca.is_deleted != '1' 
													ORDER BY ca.section ASC");

if(mysqli_num_rows($sqllmsCoursesAllocation) == 0) {

	$sqllmsCoursesAllocation  = $dblms->querylms("SELECT d.id_curs, t.semester, t.section, t.timing 
														FROM ".TIMETABLE_DETAILS." d  
														INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup    
														WHERE t.status =  '1' AND t.is_liberalarts = '1'
														AND t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
														AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
														AND d.id_curs = '".cleanvars($_GET['id'])."' 
														AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."'
														GROUP BY t.section
														ORDER BY t.section ASC");

}
if(mysqli_num_rows($sqllmsCoursesAllocation) > 0) {

	echo '
	<h3 style="font-weight:600; color:orangered;">Liberal Arts</h3>
	<div style="clear:both;"></div>
	<table class="footable table table-bordered table-hover">
	<thead>
	<tr>
		<th style="font-weight:600;text-align:center;">Sr. #</th>
		<th style="font-weight:600;text-align:center;">Section</th>
		<th style="font-weight:600;text-align:center;">Timing</th>
		<th style="font-weight:600;text-align:center;">Students</th>
		<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
	</tr>
	</thead>
	<tbody>';
	$srca = 0;
	while($valueCourseAllocation = mysqli_fetch_array($sqllmsCoursesAllocation)) { 
		
		$srca++;
		
		$sqllmslatotalstudents  = $dblms->querylms("SELECT COUNT(od.id) as Totalstudents 
															FROM ".LA_STUDENT_REGISTRATION_DETAIL." od
															INNER JOIN ".LA_STUDENT_REGISTRATION." oc ON oc.id = od.id_setup 
															INNER JOIN ".STUDENTS." std ON std.std_id = oc.id_std 
															WHERE oc.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
															AND oc.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
															AND od.id_curs =  '".cleanvars($valueCourseAllocation['id_curs'])."'  
															AND od.section =  '".cleanvars($valueCourseAllocation['section'])."'  
															AND od.timing =  '".cleanvars($valueCourseAllocation['timing'])."' 
															AND od.confirm_status = '2'
															AND (std.std_status = '2' OR std.std_status = '7') 
															AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
															AND oc.is_deleted != '1'");

		$valuetotalstudents = mysqli_fetch_array($sqllmslatotalstudents);

		echo '
		<tr>
			<td style="width:40px; text-align:center;">'.$srca.'</td>
			<td style="width:70px; text-align:center;">'.$valueCourseAllocation['section'].'</td>
			<td style="width:70px; text-align:center;">'.get_programtiming($valueCourseAllocation['timing']).'</td>
			<td style="width:70px; text-align:center;">'.number_format($valuetotalstudents['Totalstudents']).'</td>
			<td style="width:50px;text-align:center;">
				<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid=la&timing='.$valueCourseAllocation['timing'].'&semester='.$valueCourseAllocation['semester'].'&section='.$valueCourseAllocation['section'].'&view=Students"><i class="icon-zoom-in"></i></a></td>
		</tr>';
		
	}
	//End while loop
	
	echo ' 
	</tbody>
	</table>';
}
//End Count Check
	
// end liberal Arts
} else { 

	$cursstudents = array();
	$countstudents = 0;

		
	if(isset($_GET['section'])) {
		$stdsection 	= " AND std.std_section =  '".cleanvars($_GET['section'])."'"; 
		$sectcaps 		= ' ('.$_GET['section'].')';
		$seccursquery 	= " AND at.section = '".$_GET['section']."'";
	} else { 
		$stdsection 	= " AND std.std_section = ''"; 
		$seccursquery 	= " AND at.section = ''";
		$sectcaps 		= '';
	}
		
	if($_GET['prgid'] == 'la') { 
		
		$prg_id = 0;
		
		$sqllmsOfferedCourses  = $dblms->querylms("SELECT od.*, oc.semester, std.std_id, std.id_prg, std.std_name, std.std_rollno, std.std_regno, std.std_photo, std.std_session 
														FROM ".LA_STUDENT_REGISTRATION_DETAIL." od
														INNER JOIN ".LA_STUDENT_REGISTRATION." oc ON oc.id = od.id_setup 
														INNER JOIN ".STUDENTS." std ON std.std_id = oc.id_std 
														WHERE oc.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
														AND oc.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
														AND oc.is_deleted != '1'  
														AND od.id_curs =  '".cleanvars($_GET['id'])."'  
														AND od.section =  '".cleanvars($_GET['section'])."'  
														AND od.timing =  '".cleanvars($_GET['timing'])."'  
														AND od.confirm_status = '2'
														AND (std.std_status = '2' OR std.std_status = '7') 
														AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
														ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC");
		while($rowcurstds = mysqli_fetch_array($sqllmsOfferedCourses)) { 
			$cursstudents[] = $rowcurstds;
			$countstudents++;
		}
		
	} else {
		
		$prg_id = $_GET['prgid'];

		$sqllmsstds  = $dblms->querylms("SELECT std.std_id, std.id_prg, std.std_photo, std.std_name, std.std_rollno, std.std_regno, std.std_session, 
												prg.prg_name  
												FROM ".STUDENTS." std 
												INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
												WHERE (std.std_status = '2' OR std.std_status = '7') 
												AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
												AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND std.id_prg = '".cleanvars($_GET['prgid'])."' 
												AND std.std_timing = '".cleanvars($_GET['timing'])."' 
												AND std.std_semester = '".cleanvars($_GET['semester'])."' $stdsection 
												ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC");
		while($rowcurstds = mysqli_fetch_array($sqllmsstds)) { 
			$cursstudents[] = $rowcurstds;
			$countstudents++;
		}
	}

	//Count Repeat Students
	$sqllmsRepeat  = $dblms->querylms("SELECT std.std_id, std.id_prg, std.std_photo, std.std_name, std.std_rollno, std.std_regno, std.std_session, 
											prg.prg_name  
											FROM ".REPEAT_REGISTRATION." rr 
											INNER JOIN ".REPEAT_COURSES." rc ON rc.id_setup = rr.id   
											INNER JOIN ".STUDENTS." std ON std.std_id = rr.id_std   
											INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
											WHERE rc.id_curs = '".cleanvars($_GET['id'])."' 
											AND rc.id_teacher = '".cleanvars($rowsstd['emply_id'])."'
											AND rc.semester = '".cleanvars($_GET['semester'])."'
											AND rr.type 	= '1'
											AND rr.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
											AND (std.std_status = '2' OR std.std_status = '7') 
											AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
											AND std.id_prg = '".cleanvars($_GET['prgid'])."' 
											AND std.std_timing = '".cleanvars($_GET['timing'])."' 
											AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'");
	$countRepeatstudents = 0;
	while($rowRepeat = mysqli_fetch_array($sqllmsRepeat)) { 
		$cursRepeatstudents[] = array (
									"std_id"		=> $rowRepeat['std_id'],
									"std_photo"		=> $rowRepeat['std_photo'],
									"std_name"		=> $rowRepeat['std_name'],
									"std_session"	=> $rowRepeat['std_session'],
									"std_rollno"	=> $rowRepeat['std_rollno'],
									"std_regno"		=> $rowRepeat['std_regno'],
									"id_prg"		=> $rowRepeat['id_prg'],
									"prg_name"		=> $rowRepeat['prg_name']
								);
		$countRepeatstudents++;								
		$countstudents++;
	}
	//Count Migrate Students
	$sqllmsMigrate  = $dblms->querylms("SELECT std.std_id, std.id_prg, std.std_photo, std.std_name, std.std_rollno, std.std_regno, std.std_session, 
											prg.prg_name  
											FROM ".REPEAT_REGISTRATION." rr 
											INNER JOIN ".REPEAT_COURSES." rc ON rc.id_setup = rr.id   
											INNER JOIN ".STUDENTS." std ON std.std_id = rr.id_std   
											INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
											WHERE rc.id_curs = '".cleanvars($_GET['id'])."' 
											AND rc.semester = '".cleanvars($_GET['semester'])."'
											AND rr.type 	= '3'
											AND rr.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
											AND (std.std_status = '2' OR std.std_status = '7') 
											AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
											AND std.id_prg = '".cleanvars($_GET['prgid'])."' 
											AND std.std_timing = '".cleanvars($_GET['timing'])."' 
											AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'");
	$countMigratestudents = 0;
	//Stotre Migrate Students in $cursstudents array
	while($rowMigrate = mysqli_fetch_array($sqllmsMigrate)) { 
		$cursMigratestudents[] = array (
									"std_id"		=> $rowMigrate['std_id'],
									"std_photo"		=> $rowMigrate['std_photo'],
									"std_name"		=> $rowMigrate['std_name'],
									"std_session"	=> $rowMigrate['std_session'],
									"std_rollno"	=> $rowMigrate['std_rollno'],
									"std_regno"		=> $rowMigrate['std_regno'],
									"id_prg"		=> $rowMigrate['id_prg'],
									"prg_name"		=> $rowMigrate['prg_name']
								);
		$countMigratestudents++;								
		$countstudents++;
	}

	//Students of 2ndary Program
	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) !=1) { 
		
		$sqllmsstd2ndary  = $dblms->querylms("SELECT std.std_id, std.id_prg, std.std_photo, std.std_name, std.std_rollno, std.std_regno,
												std.std_secondarysession, std.std_session, prg.prg_name  
												FROM ".STUDENTS." std 
												INNER JOIN ".PROGRAMS." prg ON std.id_prgsecondary = prg.prg_id 
												WHERE (std.std_status = '2' OR std.std_status = '7') 
												AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
												AND std.id_campus 		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND std.id_prgsecondary = '".cleanvars($_GET['prgid'])."' 
												AND std.std_timing 		= '".cleanvars($_GET['timing'])."' 
												AND std.std_secondarysemester = '".cleanvars($_GET['semester'])."' $stdsection 
												ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC ");
		
		while($rowcur2ndary = mysqli_fetch_array($sqllmsstd2ndary)) { 
			$cursstudents[] = array (
										"std_id"		=> $rowcur2ndary['std_id'],
										"std_photo"		=> $rowcur2ndary['std_photo'],
										"std_name"		=> $rowcur2ndary['std_name'],
										"std_session"	=> $rowcur2ndary['std_secondarysession'],
										"std_rollno"	=> $rowcur2ndary['std_rollno'],
										"std_regno"		=> $rowcur2ndary['std_regno'],
										"id_prg"		=> $rowcur2ndary['id_prg'],
										"prg_name"		=> $rowcur2ndary['prg_name']
									);
			$countstudents++;
		}
	} 
//--------------------------------------------------
if ($countstudents > 0) { 
echo '
<div style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;"> 
	Total Students: ('.number_format($countstudents).')
	<span style="float:right; font-weight:700;margin-right:30px; color:#555;">Attendance</span>
</div>
<div style="clear:both;"></div>

<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th style="font-weight:600; text-align:center;">Sr.#</th>
	<th style="font-weight:600; text-align:center;">Roll #</th>
	<th style="font-weight:600;">Registration #</th>
	<th width="35px" style="font-weight:600;">Pic</th>
	<th style="font-weight:600;">Student Name</th>
	<th style="font-weight:600;text-align:center;">Session</th>
	<th style="font-weight:600;text-align:center;">Mid</th>
	<th style="font-weight:600;text-align:center;">Final</th>
</tr>
</thead>
<tbody>';

if(cleanvars($_GET['prgid']) == 'la'){
	$sqlAddProgramSemester  = "AND at.id_prg = '0' ";
} else{  
    $sqlAddProgramSemester  = "AND at.id_prg = '".cleanvars($_GET['prgid'])."' 
                            AND at.semester = '".cleanvars($_GET['semester'])."'";
}
	
$srbk = 0;
//------------------------------------------------
foreach($cursstudents as $itemstd) { 
//------------------------------------------------

	$srbk++;
	if($itemstd['std_photo']) { 
		$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$itemstd['std_photo'].'" alt="'.$itemstd['std_name'].'"/>';
	} else {
		$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$itemstd['std_name'].'"/>';
	}

	/*
	if($_SESSION['userlogininfo']['LOGINIDA'] == 5005){
		echo "SELECT paper_startdate as date_start, paper_enddate as date_end
		FROM ".SETTINGS_PAPERS."
		WHERE status = '1' AND examterm = '1' 
		AND (FIND_IN_SET('".cleanvars($itemstd['id_prg'])."', programs) OR programs LIKE'%all%')
		AND FIND_IN_SET('".cleanvars($_GET['semester'])."', semesters)
		AND (FIND_IN_SET('".get_loopsessionid($itemstd['std_session'])."', sessions) OR sessions LIKE'%all%')
		AND FIND_IN_SET('".cleanvars($_GET['timing'])."', timings)
		AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
		AND id_campus	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
		LIMIT 1";
	}
	*/

	$sqllmsfeecats  = $dblms->querylms("SELECT paper_startdate as date_start, paper_enddate as date_end
											FROM ".SETTINGS_PAPERS."
											WHERE status = '1' AND examterm = '1' 
											AND (FIND_IN_SET('".cleanvars($itemstd['id_prg'])."', programs) OR programs LIKE'%all%')
											AND FIND_IN_SET('".cleanvars($_GET['semester'])."', semesters)
											AND (FIND_IN_SET('".get_loopsessionid($itemstd['std_session'])."', sessions) OR sessions LIKE'%all%')
											AND FIND_IN_SET('".cleanvars($_GET['timing'])."', timings)
											AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND id_campus	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											LIMIT 1");
	if(mysqli_num_rows($sqllmsfeecats)>0) {

		$rowfeecats = mysqli_fetch_array($sqllmsfeecats);
		$datestart  = $rowfeecats['date_start'];

		//Student Attendance Percentage
		// $sqllmsAttendanceCount  = $dblms->querylms("SELECT COUNT(CASE WHEN at.theorypractical = '1' AND at.dated <= '".$rowfeecats['date_start']."' then 1 else null end) totalMidTheoryLectures,
		// 													COUNT(CASE WHEN at.theorypractical = '1' AND at.dated <= '".$rowfeecats['date_start']."' AND dt.status = '2' then 1 else null end) totalMidTheoryPresent,
		// 													COUNT(CASE WHEN at.theorypractical = '2' AND at.dated <= '".$rowfeecats['date_start']."' then 1 else null end) totalMidPracticalLectures,
		// 													COUNT(CASE WHEN at.theorypractical = '2' AND at.dated <= '".$rowfeecats['date_start']."' AND dt.status = '2' then 1 else null end) totalMidPracticalPresent,
		// 													COUNT(CASE WHEN at.theorypractical = '1' AND at.dated > '".$rowfeecats['date_start']."' then 1 else null end) totalFinalTheoryLectures,
		// 													COUNT(CASE WHEN at.theorypractical = '1' AND at.dated > '".$rowfeecats['date_start']."' AND dt.status = '2' then 1 else null end) totalFinalTheoryPresent,
		// 													COUNT(CASE WHEN at.theorypractical = '2' AND at.dated > '".$rowfeecats['date_start']."' then 1 else null end) totalFinalPracticalLectures,
		// 													COUNT(CASE WHEN at.theorypractical = '2' AND at.dated > '".$rowfeecats['date_start']."' AND dt.status = '2' then 1 else null end) totalFinalPracticalPresent
		// 													FROM ".COURSES_ATTENDANCE_DETAIL." dt
		// 													INNER JOIN ".COURSES_ATTENDANCE." at ON at.id = dt.id_setup 
		// 													INNER JOIN ".STUDENTS." std  ON std.std_id = dt.id_std  
		// 													WHERE at.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
		// 													AND at.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
		// 													AND at.id_curs = '".cleanvars($_GET['id'])."' 
		// 													AND at.id_teacher = '".cleanvars($rowsstd['emply_id'])."'
		// 													$sqlAddProgramSemester
		// 													$seccursquery
		// 													AND at.timing = '".cleanvars($_GET['timing'])."' 
		// 													AND dt.id_std = '".cleanvars($itemstd['std_id'])."'");

		$sqlSection = "";

        if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) != '1') { 
            $sqlSection = " AND at.section = '".cleanvars($_GET['section'])."'";
        }

		$sqllmsAttendanceCount  = $dblms->querylms("SELECT COUNT(CASE WHEN at.theorypractical = '1' AND at.dated <= '".$rowfeecats['date_start']."' then 1 else null end) totalMidTheoryLectures,
                                                            COUNT(CASE WHEN at.theorypractical = '1' AND at.dated <= '".$rowfeecats['date_start']."' AND dt.status = '2' then 1 else null end) totalMidTheoryPresent,
															COUNT(CASE WHEN at.theorypractical = '2' AND at.dated <= '".$rowfeecats['date_start']."' then 1 else null end) totalMidPracticalLectures,
		 													COUNT(CASE WHEN at.theorypractical = '2' AND at.dated <= '".$rowfeecats['date_start']."' AND dt.status = '2' then 1 else null end) totalMidPracticalPresent,
                                                            COUNT(CASE WHEN at.theorypractical = '1' AND at.dated > '".$rowfeecats['date_start']."' then 1 else null end) totalFinalTheoryLectures,
                                                            COUNT(CASE WHEN at.theorypractical = '1' AND at.dated > '".$rowfeecats['date_start']."' AND dt.status = '2' then 1 else null end) totalFinalTheoryPresent,
															COUNT(CASE WHEN at.theorypractical = '2' AND at.dated > '".$rowfeecats['date_start']."' then 1 else null end) totalFinalPracticalLectures,
															COUNT(CASE WHEN at.theorypractical = '2' AND at.dated > '".$rowfeecats['date_start']."' AND dt.status = '2' then 1 else null end) totalFinalPracticalPresent,
                                                            COUNT(CASE WHEN at.theorypractical = '2' then 1 else null end) totalPracticalLectures,
                                                            COUNT(CASE WHEN at.theorypractical = '2' AND dt.status = '2' then 1 else null end) totalPracticalPresent
                                                            FROM ".COURSES_ATTENDANCE_DETAIL." dt
                                                            INNER JOIN ".COURSES_ATTENDANCE." at ON at.id = dt.id_setup 
                                                            INNER JOIN ".STUDENTS." std  ON std.std_id = dt.id_std  
                                                            WHERE at.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
                                                            AND at.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
                                                            AND at.id_curs = '".$_GET['id']."' 
                                                            AND at.timing = '".$_GET['timing']."'  
                                                            $sqlSection
                                                            $sqlAddProgramSemester
                                                            AND dt.id_std = '".$itemstd['std_id']."'
                                                            ORDER BY at.lectureno ASC");



		$rowAttendanceCount = mysqli_fetch_assoc($sqllmsAttendanceCount);

	//------------------------------------------------
		if($rowAttendanceCount['totalMidTheoryLectures']) {
			$midtermTheory 	= round(($rowAttendanceCount['totalMidTheoryPresent']/$rowAttendanceCount['totalMidTheoryLectures']) * 100); 
		} else { 
			$midtermTheory 	= 0; 
		}

		if($rowAttendanceCount['totalMidPracticalLectures']) { 
			$midtermPractical = round(($rowAttendanceCount['totalMidPracticalPresent']/$rowAttendanceCount['totalMidPracticalLectures']) * 100);
		} else { 
			$midtermPractical = 0; 
		}
		if($rowAttendanceCount['totalFinalTheoryLectures']) { $finaltermTheory = round(($rowAttendanceCount['totalFinalTheoryPresent']/$rowAttendanceCount['totalFinalTheoryLectures']) * 100); } else { $finaltermTheory = 0; }
		if($rowAttendanceCount['totalFinalPracticalLectures']) { $finaltermPractical = round(($rowAttendanceCount['totalFinalPracticalPresent']/$rowAttendanceCount['totalFinalPracticalLectures']) * 100); } else { $finaltermPractical = 0; }

		$totalmidpresent = ($rowAttendanceCount['totalMidTheoryPresent'] + $rowAttendanceCount['totalMidPracticalPresent']);
		$totalmidabsent = (($rowAttendanceCount['totalMidTheoryLectures'] + $rowAttendanceCount['totalMidPracticalLectures']) - $totalmidpresent);
		$totalfinalpresent = ($rowAttendanceCount['totalFinalTheoryPresent'] + $rowAttendanceCount['totalFinalPracticalPresent']);
		$totalfinalabsent = (($rowAttendanceCount['totalFinalTheoryLectures'] + $rowAttendanceCount['totalFinalPracticalLectures']) - $totalfinalpresent);

		//Midterm Attendance Percentage
		$attendanceMidTheory = 'T 0';
		if($midtermTheory>0) {	
			$attendanceMidTheory = 'T '.$midtermTheory.'%';
		}


		//Finalterm Attendance Percentage
		$attendanceFinalTheory = 'T 0';
		if($finaltermTheory>0) {	
			$attendanceFinalTheory = 'T '.$finaltermTheory.'%';
		}
	} else {
		$attendanceFinalTheory 	= '';
		$attendanceMidTheory 	= '';
		$totalmidpresent 		= '';
		$totalmidabsent 		= '';
		$totalfinalpresent		= '';
		$totalfinalabsent 		= '';
		$datestart  			= '';
	}

	// For Campuses Other than MUL
	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) != '1' && $_GET['prgid'] != 'la'){

		$sqllmsProgram  = $dblms->querylms("SELECT prg_under_mul     
											FROM ".PROGRAMS."
											WHERE prg_id = '".$_GET['prgid']."'
											LIMIT 1");
		$valueProgram = mysqli_fetch_array($sqllmsProgram);

		if($valueProgram['prg_under_mul'] == 0){

			$attendanceMidTheory = '';
			$attendanceFinalTheory = round(( ($rowAttendanceCount['totalMidTheoryPresent'] + $rowAttendanceCount['totalFinalTheoryPresent']) / ($rowAttendanceCount['totalMidTheoryLectures'] + $rowAttendanceCount['totalFinalTheoryLectures']) ) * 100).'%';

			$attendanceFinalPracticalColor = '';

		}
	}

	echo '
	<tr>
		<td style="width:30px; text-align:center;vertical-align:middle;">'.$srbk.'</td>
		<td style="width:55px;text-align:center;vertical-align:middle;">'.$itemstd['std_rollno'].'</td>
		<td style="width:200px;vertical-align:middle;">'.$itemstd['std_regno'].'</td>
		<td style="vertical-align:middle;">'.$stdphoto.'</td>
		<td style="width:200px;vertical-align:middle;"><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$itemstd['std_name'].' ('.$itemstd['std_session'].')</b>" data-src="studentdetail.php?std_id='.$itemstd['std_id'].'" href="#">'.$itemstd['std_name'].'</a> </td>
		<td style="vertical-align:middle;width:75px;text-align:center;">'.$itemstd['std_session'].'</td><td style="width:70px;text-align:center;vertical-align:middle;">
			'.$attendanceMidTheory;
			if($attendanceMidTheory != ''){
				echo '<a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Mid Term Attendance Detail of '.$itemstd['std_name'].'</b>" data-src="include/studentprofile/attendancestudent.php?stdid='.$itemstd['std_id'].'&term=1&dated='.$datestart.'&cursid='.$_GET['id'].'&curscode='.$rowsurs['curs_code'].'&cursname='.$rowsurs['curs_name'].'&teacher='.cleanvars($rowsstd['emply_id']).'&present='.$totalmidpresent.'&absent='.$totalmidabsent.'" href="#"><i class="icon-zoom-in"></i></a>';
			}
			echo '
		</td>
		<td style="width:70px;text-align:center;vertical-align:middle;">
			'.$attendanceFinalTheory.'  <a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Final Term Attendance Detail of '.$itemstd['std_name'].'</b>" data-src="include/studentprofile/attendancestudent.php?stdid='.$itemstd['std_id'].'&term=2&dated='.$datestart.'&cursid='.$_GET['id'].'&curscode='.$rowsurs['curs_code'].'&cursname='.$rowsurs['curs_name'].'&teacher='.cleanvars($rowsstd['emply_id']).'&present='.$totalfinalpresent.'&absent='.$totalfinalabsent.'" href="#"><i class="icon-zoom-in"></i></a>
		</td>
	</tr>';

}
//------------------------------------------------
echo '
</tbody>
</table>';
//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}


if($countRepeatstudents > 0){

echo '
<h3 id="repeatStd" style="margin-top:20px; color:green; font-weight:600;">Students Repeating the Course </h3>
<div style="clear:both;"></div>

<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th style="font-weight:600; text-align:center;">Sr.#</th>
	<th style="font-weight:600; text-align:center;">Roll #</th>
	<th style="font-weight:600;">Reg #</th>
	<th width="35px" style="font-weight:600;">Pic</th>
	<th style="font-weight:600;">Student Name</th>
	<th style="font-weight:600;">Session</th>
	<th style="font-weight:600;text-align:center;">Mid</th>
	<th style="font-weight:600;text-align:center;">Final</th>
</tr>
</thead>
<tbody>';
$srbk = 0;
foreach ($cursRepeatstudents as $itemstd){

//------------------------------------------------
$srbk++;
//------------------------------------------------
if($itemstd['std_photo']) { 
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$itemstd['std_photo'].'" alt="'.$itemstd['std_name'].'"/>';
} else {
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$itemstd['std_name'].'"/>';
}
$sqllmsfeecats  = $dblms->querylms("SELECT d.id, d.id_setup, d.id_cat, d.date_start, d.date_end, d.remarks  
										FROM ".ACALENDAR_DETAILS." d 
										INNER JOIN ".ACALENDAR." c ON c.id = d.id_setup
										WHERE c.status = '1' AND c.published = '1' AND c.for_program = '".$_GET['timing']."'
										AND c.id_campus	= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
										AND c.session = '".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 
										AND d.id_cat = '7' LIMIT 1");
//------------------------------------------------
$rowfeecats 	= mysqli_fetch_array($sqllmsfeecats);
//------------------------------------------------
$sqllmsmidattendance  = $dblms->querylms("SELECT at.lectureno, at.dated,dt.status, dt.remarks     
										FROM ".COURSES_ATTENDANCE_DETAIL." dt
										INNER JOIN ".COURSES_ATTENDANCE." at ON at.id = dt.id_setup 
										INNER JOIN ".STUDENTS." std  ON std.std_id = dt.id_std  
										WHERE at.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND at.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND at.id_curs = '".cleanvars($_GET['id'])."' AND at.timing = '".cleanvars($_GET['timing'])."' 
										$seccursquery AND at.id_prg = '".cleanvars($_GET['prgid'])."'
										AND at.id_teacher = '".cleanvars($rowsstd['emply_id'])."'
										AND at.semester = '".cleanvars($_GET['semester'])."' 
										AND dt.id_std = '".cleanvars($itemstd['std_id'])."' ORDER BY at.lectureno ASC");
	$totalmidlecture = 0;
	$totalfinallecture = 0;
	$totalmidpresent = 0;
	$totalmidabsent = 0;
	$totalfinalpresent = 0;
	$totalfinalabsent = 0;
	while($rowmidattendance = mysqli_fetch_assoc($sqllmsmidattendance)) { 
		if($rowmidattendance['dated'] <= cleanvars($rowfeecats['date_start'])) {	
			if($rowmidattendance['status'] == 2) { 
				$totalmidpresent++;	
			} else { 
				$totalmidabsent++;
			}
			$totalmidlecture++;
		}
		if($rowmidattendance['dated'] > cleanvars($rowfeecats['date_start'])) {	
			if($rowmidattendance['status'] == 2) { 
				$totalfinalpresent++;
			} else { 
				$totalfinalabsent++;
			}
			$totalfinallecture++;
		}
	}
//------------------------------------------------
if($totalmidlecture)   { $midper 	= round(($totalmidpresent/$totalmidlecture) 	* 100); } else { $midper 	= 0; }
if($totalfinallecture) { $finalper 	= round(($totalfinalpresent/$totalfinallecture) * 100); } else { $finalper 	= 0; }
//------------------------------------------------
if($midper>0) 	{ $attendancemid 	= $midper.'%'; 	 } else { $attendancemid 	= 0; }
if($finalper>0) { $attendancefinal 	= $finalper.'%'; } else { $attendancefinal	= 0; }
//-----------------------------------------------
echo '
<tr>
	<td style="width:30px; text-align:center;vertical-align:middle;">'.$srbk.'</td>
	<td style="width:55px;text-align:center;vertical-align:middle;">'.$itemstd['std_rollno'].'</td>
	<td style="width:200px;vertical-align:middle;">'.$itemstd['std_regno'].'</td>
	<td style="vertical-align:middle;">'.$stdphoto.'</td>
	<td style="width:200px;vertical-align:middle;"><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$itemstd['std_name'].' ('.$itemstd['std_session'].')</b>" data-src="studentdetail.php?std_id='.$itemstd['std_id'].'" href="#">'.$itemstd['std_name'].'</a> </td>
	<td style="vertical-align:middle;">'.$itemstd['std_session'].'</td>
	<td style="width:70px;text-align:center;vertical-align:middle;">
		'.$attendancemid.' <a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Mid Term Attendance Detail of '.$itemstd['std_name'].'</b>" data-src="include/studentprofile/attendancestudent.php?stdid='.$itemstd['std_id'].'&term=1&dated='.$rowfeecats['date_start'].'&cursid='.$_GET['id'].'&curscode='.$rowsurs['curs_code'].'&cursname='.$rowsurs['curs_name'].'&teacher='.cleanvars($rowsstd['emply_id']).'&present='.$totalmidpresent.'&absent='.$totalmidabsent.'" href="#"><i class="icon-zoom-in"></i></a>
	</td>
	<td style="width:70px;text-align:center;vertical-align:middle;">
		'.$attendancefinal.'  <a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Final Term Attendance Detail of '.$itemstd['std_name'].'</b>" data-src="include/studentprofile/attendancestudent.php?stdid='.$itemstd['std_id'].'&term=2&dated='.$rowfeecats['date_start'].'&cursid='.$_GET['id'].'&curscode='.$rowsurs['curs_code'].'&cursname='.$rowsurs['curs_name'].'&teacher='.cleanvars($rowsstd['emply_id']).'&present='.$totalfinalpresent.'&absent='.$totalfinalabsent.'" href="#"><i class="icon-zoom-in"></i></a>
	</td>
</tr>';


}
//------------------------------------------------
echo '
</tbody>
</table>
';
//------------------------------------------------
}

if($countMigratestudents > 0){

echo '
<div style="clear:both;"></div>
<h3 id="migrateStd" style="margin-top:20px; color:#857198; font-weight:600;">Migrate Students </h3>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th style="font-weight:600; text-align:center;">Sr.#</th>
	<th style="font-weight:600; text-align:center;">Roll #</th>
	<th style="font-weight:600;">Reg #</th>
	<th width="35px" style="font-weight:600;">Pic</th>
	<th style="font-weight:600;">Student Name</th>
	<th style="font-weight:600;">Session</th>
	<th style="font-weight:600;text-align:center;">Mid</th>
	<th style="font-weight:600;text-align:center;">Final</th>
</tr>
</thead>
<tbody>';
$srbk = 0;
foreach ($cursMigratestudents as $itemstd){
//------------------------------------------------
$srbk++;
//------------------------------------------------
if($itemstd['std_photo']) { 
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$itemstd['std_photo'].'" alt="'.$itemstd['std_name'].'"/>';
} else {
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$itemstd['std_name'].'"/>';
}
$sqllmsfeecats  = $dblms->querylms("SELECT d.id, d.id_setup, d.id_cat, d.date_start, d.date_end, d.remarks  
										FROM ".ACALENDAR_DETAILS." d 
										INNER JOIN ".ACALENDAR." c ON c.id = d.id_setup
										WHERE c.status = '1' AND c.published = '1' AND c.for_program = '".$_GET['timing']."'
										AND c.id_campus	= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
										AND c.session = '".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 
										AND d.id_cat = '7' LIMIT 1");
//------------------------------------------------
$rowfeecats 	= mysqli_fetch_array($sqllmsfeecats);
//------------------------------------------------
$sqllmsmidattendance  = $dblms->querylms("SELECT at.lectureno, at.dated,dt.status, dt.remarks     
										FROM ".COURSES_ATTENDANCE_DETAIL." dt
										INNER JOIN ".COURSES_ATTENDANCE." at ON at.id = dt.id_setup 
										INNER JOIN ".STUDENTS." std  ON std.std_id = dt.id_std  
										WHERE at.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND at.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND at.id_curs = '".cleanvars($_GET['id'])."' AND at.timing = '".cleanvars($_GET['timing'])."' 
										$seccursquery AND at.id_prg = '".cleanvars($_GET['prgid'])."'
										AND at.id_teacher = '".cleanvars($rowsstd['emply_id'])."'
										AND at.semester = '".cleanvars($_GET['semester'])."' 
										AND dt.id_std = '".cleanvars($itemstd['std_id'])."' ORDER BY at.lectureno ASC");
	$totalmidlecture = 0;
	$totalfinallecture = 0;
	$totalmidpresent = 0;
	$totalmidabsent = 0;
	$totalfinalpresent = 0;
	$totalfinalabsent = 0;
	while($rowmidattendance = mysqli_fetch_assoc($sqllmsmidattendance)) { 
		if($rowmidattendance['dated'] <= cleanvars($rowfeecats['date_start'])) {	
			if($rowmidattendance['status'] == 2) { 
				$totalmidpresent++;	
			} else { 
				$totalmidabsent++;
			}
			$totalmidlecture++;
		}
		if($rowmidattendance['dated'] > cleanvars($rowfeecats['date_start'])) {	
			if($rowmidattendance['status'] == 2) { 
				$totalfinalpresent++;
			} else { 
				$totalfinalabsent++;
			}
			$totalfinallecture++;
		}
	}
//------------------------------------------------
if($totalmidlecture)   { $midper 	= round(($totalmidpresent/$totalmidlecture) 	* 100); } else { $midper 	= 0; }
if($totalfinallecture) { $finalper 	= round(($totalfinalpresent/$totalfinallecture) * 100); } else { $finalper 	= 0; }
//------------------------------------------------
if($midper>0) 	{ $attendancemid 	= $midper.'%'; 	 } else { $attendancemid 	= 0; }
if($finalper>0) { $attendancefinal 	= $finalper.'%'; } else { $attendancefinal	= 0; }
//-----------------------------------------------
echo '
<tr>
	<td style="width:30px; text-align:center;vertical-align:middle;">'.$srbk.'</td>
	<td style="width:55px;text-align:center;vertical-align:middle;">'.$itemstd['std_rollno'].'</td>
	<td style="width:200px;vertical-align:middle;">'.$itemstd['std_regno'].'</td>
	<td style="vertical-align:middle;">'.$stdphoto.'</td>
	<td style="width:200px;vertical-align:middle;"><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$itemstd['std_name'].' ('.$itemstd['std_session'].')</b>" data-src="studentdetail.php?std_id='.$itemstd['std_id'].'" href="#">'.$itemstd['std_name'].'</a> </td>
	<td style="vertical-align:middle;">'.$itemstd['std_session'].'</td>
	<td style="width:70px;text-align:center;vertical-align:middle;">
		'.$attendancemid.' <a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Mid Term Attendance Detail of '.$itemstd['std_name'].'</b>" data-src="include/studentprofile/attendancestudent.php?stdid='.$itemstd['std_id'].'&term=1&dated='.$rowfeecats['date_start'].'&cursid='.$_GET['id'].'&curscode='.$rowsurs['curs_code'].'&cursname='.$rowsurs['curs_name'].'&teacher='.cleanvars($rowsstd['emply_id']).'&present='.$totalmidpresent.'&absent='.$totalmidabsent.'" href="#"><i class="icon-zoom-in"></i></a>
	</td>
	<td style="width:70px;text-align:center;vertical-align:middle;">
		'.$attendancefinal.'  <a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Final Term Attendance Detail of '.$itemstd['std_name'].'</b>" data-src="include/studentprofile/attendancestudent.php?stdid='.$itemstd['std_id'].'&term=2&dated='.$rowfeecats['date_start'].'&cursid='.$_GET['id'].'&curscode='.$rowsurs['curs_code'].'&cursname='.$rowsurs['curs_name'].'&teacher='.cleanvars($rowsstd['emply_id']).'&present='.$totalfinalpresent.'&absent='.$totalfinalabsent.'" href="#"><i class="icon-zoom-in"></i></a>
	</td>
</tr>';


}
//------------------------------------------------
echo '
</tbody>
</table>';
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
</div>'; 

?>