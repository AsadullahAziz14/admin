<?php
include_once("attendance/query.php");

if(!isset($_GET['prgid'])) { 
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
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
			<span class="pull-left"><h3  style="font-weight:700;">Attendance</h3></span>
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
	$arrayprgms = array();
	while($rowprgs = mysqli_fetch_array($sqllmscursrelated)) { 
		$arrayprgms[] = $rowprgs;
	}

//----------------------For Theory Credit Hours----------------------------
if($rowsurs['cur_credithours_theory']>0) { 
if($countrelted>0){
echo '
<h3 style="font-weight:600; margin-top:10px; margin-bottom:2px; font-size:15px; color:blue;">Theory </h3>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center; ">Sr #</th>
	<th style="font-weight:600;">Program</th>
	<th style="font-weight:600;text-align:center;">Semester</th>
	<th style="font-weight:600;text-align:center;">Timing</th>
	<th style="font-weight:600;text-align:center;">Students</th>
	<th style="font-weight:600;text-align:center;">Lectures</th>	
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srbk = 0;
	foreach($arrayprgms as $rowrelted) { 
	$srbk++; 
	//------------------------------------------------
	if($rowrelted['section']) { 
		$seccaption		= ' ('.$rowrelted['section'].')';
		$secthref 		= '&section='.$rowrelted['section'];
		$sectionstd 	= " AND std.std_section = '".cleanvars($rowrelted['section'])."'";
		$sectlcture1 	= " AND section = '".cleanvars($rowrelted['section'])."'";
	} else  { 
		$seccaption		= '';
		$secthref 		= '';
		$sectionstd 	= " AND std.std_section = ''";
		$sectlcture1 	= " AND section = ''";
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
												WHERE rc.id_curs = '".cleanvars($_GET['id'])."' AND rc.id_timetable =  '".$rowrelted['id_setup']."'
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
//------------------------------------------------
	$sqllmsLectures  = $dblms->querylms("SELECT COUNT(id) AS TotalLectures
											FROM ".COURSES_ATTENDANCE."  
											WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND id_curs = '".cleanvars($_GET['id'])."' 
											AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
											AND semester = '".cleanvars($rowrelted['semester'])."' 
											$sectlcture1 
											AND id_prg = '".cleanvars($rowrelted['id_prg'])."' 
											AND theorypractical = '1' 
											AND timing = '".cleanvars($rowrelted['timing'])."'");
	$rowLectures = mysqli_fetch_array($sqllmsLectures);
//------------------------------------------------
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$srbk.'</td>
	<td>'.$rowrelted['prg_name'].'</td>
	<td style="width:70px; text-align:center;">'.addOrdinalNumberSuffix($rowrelted['semester']).$seccaption.'</td>
	<td style="width:70px; text-align:center;">'.get_programtiming($rowrelted['timing']).'</td>
	<td style="width:70px; text-align:center;">'.($rowcurstds['Totalstds'] + $rowRepeatStds['totalRepeat'] + $sndarystds).'</td>
	<td style="width:70px; text-align:center;">'.$rowLectures['TotalLectures'].'</td>
	<td style="width:50px;text-align:center;">
		<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid='.$rowrelted['id_prg'].'&timing='.$rowrelted['timing'].'&semester='.$rowrelted['semester'].$secthref.'&view=Attendance&tpl=1"><i class="icon-zoom-in"></i></a></td>
</tr>';

//--------------------------------------------------
	}
echo ' 
</tbody>
</table>';

}

/*
if(($_SESSION['userlogininfo']['LOGINIDA'] == 15807)){
	echo "SELECT ca.semester, ca.section, ca.timing 
	FROM ".LA_COURSES_ALLOCATION." ca
	WHERE  ca.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
	AND ca.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
	AND ca.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
	AND ca.status = '1' AND ca.id_curs = '".cleanvars($_GET['id'])."' 
	AND ca.is_deleted != '1' 
	GROUP BY ca.id_curs, ca.section
	ORDER BY ca.semester ASC, ca.section ASC";
}
*/
	
	//Start Liberal Arts
	$sqllmsCoursesAllocation  = $dblms->querylms("SELECT ca.semester, ca.section, ca.timing 
														FROM ".LA_COURSES_ALLOCATION." ca
														WHERE  ca.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
														AND ca.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
														AND ca.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
														AND ca.status = '1' AND ca.id_curs = '".cleanvars($_GET['id'])."' 
														AND ca.is_deleted != '1' 
														GROUP BY ca.id_curs, ca.section
														ORDER BY ca.semester ASC, ca.section ASC");
	if(mysqli_num_rows($sqllmsCoursesAllocation) > 0) {
		
		echo '
		<h3 style="font-weight:600; color:orangered;">Liberal Arts</h3>
		<div style="clear:both;"></div>
		<table class="footable table table-bordered table-hover">
		<thead>
		<tr>
			<th style="font-weight:600;text-align:center; ">Sr. #</th>
			<th style="font-weight:600;text-align:center;">Section</th>
			<th style="font-weight:600;text-align:center;">Timing</th>
			<th style="font-weight:600;text-align:center;">Students</th>
			<th style="font-weight:600;text-align:center;">Lectures</th>
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
																AND od.id_curs =  '".cleanvars($_GET['id'])."'  
																AND od.section =  '".cleanvars($valueCourseAllocation['section'])."'  
																AND od.timing =  '".cleanvars($valueCourseAllocation['timing'])."'  
																AND od.confirm_status = '2'
																AND oc.is_deleted != '1'
																AND (std.std_status = '2' OR std.std_status = '7') 
																AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
																ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC");

			$valuetotalstudents = mysqli_fetch_array($sqllmslatotalstudents);

			$sqllmslaLectures  = $dblms->querylms("SELECT COUNT(id) AS TotalLectures
													FROM ".COURSES_ATTENDANCE."  
													WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
													AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
													AND id_curs = '".cleanvars($_GET['id'])."' 
													AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
													AND section =  '".cleanvars($valueCourseAllocation['section'])."'  
													AND timing =  '".cleanvars($valueCourseAllocation['timing'])."'  
													AND theorypractical = '1' ");
			$rowlaLectures = mysqli_fetch_array($sqllmslaLectures);

			echo '
			<tr>
				<td style="width:50px; text-align:center;">'.$srca.'</td>
				<td style="text-align:center;">'.$valueCourseAllocation['section'].'</td>
				<td style="width:70px; text-align:center;">'.get_programtiming($valueCourseAllocation['timing']).'</td>
				<td style="width:70px; text-align:center;">'.number_format($valuetotalstudents['Totalstudents']).'</td>
				<td style="width:70px; text-align:center;">'.$rowlaLectures['TotalLectures'].'</td>
				<td style="width:50px;text-align:center;">
					<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid=la&timing='.$valueCourseAllocation['timing'].'&semester='.$valueCourseAllocation['semester'].'&section='.$valueCourseAllocation['section'].'&view=Attendance&tpl=1"><i class="icon-zoom-in"></i></a></td>
			</tr>';
			
		}
		//End while loop
		
		echo ' 
		</tbody>
		</table>';
	}
	//End Liberal Arts

}
//End Count Check

//For Practical Credit Hours
if($rowsurs['cur_credithours_practical']>0) { 

	echo '
	<h3 style="font-weight:600; margin-top:10px; margin-bottom:2px; font-size:15px; color:blue;">Practical / Lab</h3>
	<div style="clear:both;"></div>';

	if($countrelted>0){
		echo '
		<table class="footable table table-bordered table-hover">
		<thead>
		<tr>
			<th style="font-weight:600;text-align:center; ">Sr #</th>
			<th style="font-weight:600;">Program</th>
			<th style="font-weight:600;text-align:center;">Semester</th>
			<th style="font-weight:600;text-align:center;">Timing</th>
			<th style="font-weight:600;text-align:center;">Students</th>
			<th style="font-weight:600;text-align:center;">Lectures</th>
			
			<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
		</tr>
		</thead>
		<tbody>';
		$srbk = 0;
	
		foreach($arrayprgms as $prowrelted) { 

			$srbk++;
			if($prowrelted['section']) { 
				$pseccaption	= ' ('.$prowrelted['section'].')';
				$psecthref 		= '&section='.$prowrelted['section'];
				$psectionstd 	= " AND std.std_section = '".cleanvars($prowrelted['section'])."'";
				$psectlcture 	= " AND section = '".cleanvars($prowrelted['section'])."'";
			} else  { 
				$pseccaption	= '';
				$psecthref 		= '';
				$psectionstd 	= '';
				$psectlcture 	= '';
			}		
			
			$sqllmspstds  = $dblms->querylms("SELECT COUNT(std.std_id) AS Totalstds
													FROM ".STUDENTS." std 
													WHERE (std.std_status = '2' OR std.std_status = '7') 
													AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
													AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
													AND std.id_prg = '".cleanvars($prowrelted['id_prg'])."' 
													AND std.std_timing = '".cleanvars($prowrelted['timing'])."' 
													$psectionstd 
													AND std.std_semester = '".cleanvars($prowrelted['semester'])."' ");
			$prowcurstds = mysqli_fetch_array($sqllmspstds);

			//Count Repeat Students
			$sqllmsRepeatStds  = $dblms->querylms("SELECT COUNT(rr.id) AS totalRepeat
														FROM ".REPEAT_REGISTRATION." rr 
														INNER JOIN ".REPEAT_COURSES." rc ON rc.id_setup = rr.id   
														INNER JOIN ".STUDENTS." std ON std.std_id = rr.id_std   
														WHERE rc.id_curs = '".cleanvars($_GET['id'])."' AND rc.id_timetable =  '".$prowrelted['id_setup']."'
														AND (rr.type = '1' OR rr.type = '3')
														AND rr.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
														AND (std.std_status = '2' OR std.std_status = '7') 
														AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
														AND std.id_prg = '".cleanvars($prowrelted['id_prg'])."' 
														AND std.std_timing = '".cleanvars($prowrelted['timing'])."' 
														AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'");
			$rowRepeatStds = mysqli_fetch_array($sqllmsRepeatStds);
				
			//Students of 2ndary Program
			if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) !=1) { 
				
				$sqllmsstd2ndary  = $dblms->querylms("SELECT COUNT(std.std_id) AS Total2ndarystds
														FROM ".STUDENTS." std 
														WHERE (std.std_status = '2' OR std.std_status = '7') 
														AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
														AND std.id_campus 		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
														AND std.id_prgsecondary = '".cleanvars($prowrelted['id_prg'])."' 
														AND std.std_timing 		= '".cleanvars($prowrelted['timing'])."' 
														$psectionstd 
														AND std.std_secondarysemester = '".cleanvars($prowrelted['semester'])."' ");
				
				$rowcur2ndary 	= mysqli_fetch_array($sqllmsstd2ndary);
				$psndarystds 	= $rowcur2ndary['Total2ndarystds'];
				
			} else {
				$psndarystds 	= 0;
			}				

			$sqllmspLectures  = $dblms->querylms("SELECT COUNT(id) AS TotalLectures
													FROM ".COURSES_ATTENDANCE."  
													WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
													AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
													AND id_curs = '".cleanvars($_GET['id'])."' 
													AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
													AND semester = '".cleanvars($prowrelted['semester'])."' 
													$psectlcture 
													AND id_prg = '".cleanvars($prowrelted['id_prg'])."' 
													AND theorypractical = '2'
													AND timing = '".cleanvars($prowrelted['timing'])."'");
			$prowLectures = mysqli_fetch_array($sqllmspLectures);

			echo '
			<tr>
				<td style="width:50px; text-align:center;">'.$srbk.'</td>
				<td>'.$prowrelted['prg_name'].'</td>
				<td style="width:70px; text-align:center;">'.addOrdinalNumberSuffix($prowrelted['semester']).$pseccaption.'</td>
				<td style="width:70px; text-align:center;">'.get_programtiming($prowrelted['timing']).'</td>
				<td style="width:70px; text-align:center;">'.($prowcurstds['Totalstds'] + $rowRepeatStds['totalRepeat'] + $psndarystds).'</td>
				<td style="width:70px; text-align:center;">'.$prowLectures['TotalLectures'].'</td>
				<td style="width:50px;text-align:center;">
					<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid='.$prowrelted['id_prg'].'&timing='.$prowrelted['timing'].'&semester='.$prowrelted['semester'].$psecthref.'&view=Attendance&tpl=2"><i class="icon-zoom-in"></i></a></td>
			</tr>';
		}
		echo ' 
		</tbody>
		</table>';
	}
	
	//Start Liberal Arts
	$sqllmsPracticalCoursesAllocation  = $dblms->querylms("SELECT t.semester, t.section, t.timing  
																FROM ".TIMETABLE_DETAILS." d  
																INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup    
																WHERE t.status =  '1' AND t.is_liberalarts = '1'
																AND t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
																AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
																AND d.id_curs = '".cleanvars($_GET['id'])."' 
																AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."'
																GROUP BY t.section
																ORDER BY t.section ASC");
	if(mysqli_num_rows($sqllmsPracticalCoursesAllocation) == 0) {

		$sqllmsPracticalCoursesAllocation  = $dblms->querylms("SELECT ca.semester, ca.section, ca.timing 
																	FROM ".LA_COURSES_ALLOCATION." ca
																	WHERE  ca.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
																	AND ca.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
																	AND ca.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
																	AND ca.status = '1' AND ca.id_curs = '".cleanvars($_GET['id'])."' 
																	AND ca.is_deleted != '1' 
																	GROUP BY ca.id_curs, ca.section
																	ORDER BY ca.section ASC");

	}
	if(mysqli_num_rows($sqllmsPracticalCoursesAllocation) > 0) {
		echo '
		<h3 style="font-weight:600; color:orangered;">Liberal Arts</h3>
		<div style="clear:both;"></div>
		<table class="footable table table-bordered table-hover">
		<thead>
		<tr>
			<th style="font-weight:600;text-align:center; ">Sr. #</th>
			<th style="font-weight:600;text-align:center;">Section</th>
			<th style="font-weight:600;text-align:center;">Timing</th>
			<th style="font-weight:600;text-align:center;">Students</th>
			<th style="font-weight:600;text-align:center;">Lectures</th>
			<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
		</tr>
		</thead>
		<tbody>';
		$srpca = 0;

		//Start While Loop
		while($valuePracticalCourseAllocation = mysqli_fetch_array($sqllmsPracticalCoursesAllocation)) {

			$srpca++;

			$sqllmsPracticalStudents  = $dblms->querylms("SELECT COUNT(od.id) as total 
																FROM ".LA_STUDENT_REGISTRATION_DETAIL." od
																INNER JOIN ".LA_STUDENT_REGISTRATION." oc ON oc.id = od.id_setup 
																INNER JOIN ".STUDENTS." std ON std.std_id = oc.id_std 
																WHERE oc.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
																AND oc.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
																AND od.id_curs =  '".cleanvars($_GET['id'])."'  
																AND od.section =  '".cleanvars($valuePracticalCourseAllocation['section'])."'  
																AND od.timing =  '".cleanvars($valuePracticalCourseAllocation['timing'])."'  
																AND od.confirm_status = '2'
																AND oc.is_deleted != '1'
																AND (std.std_status = '2' OR std.std_status = '7') 
																AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
																ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC");
			$valuePracticalStudents = mysqli_fetch_array($sqllmsPracticalStudents);

			$sqllmsPracticalLectures  = $dblms->querylms("SELECT COUNT(id) AS total
																FROM ".COURSES_ATTENDANCE."  
																WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
																AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
																AND id_curs = '".cleanvars($_GET['id'])."' 
																AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
																AND section =  '".cleanvars($valuePracticalCourseAllocation['section'])."'  
																AND timing =  '".cleanvars($valuePracticalCourseAllocation['timing'])."'  
																AND theorypractical = '2' ");
			$valuePracticalLectures = mysqli_fetch_array($sqllmsPracticalLectures);

			echo '
			<tr>
				<td style="width:50px; text-align:center;">'.$srpca.'</td>
				<td style="text-align:center;">'.$valuePracticalCourseAllocation['section'].'</td>
				<td style="width:70px; text-align:center;">'.get_programtiming($valuePracticalCourseAllocation['timing']).'</td>
				<td style="width:70px; text-align:center;">'.number_format($valuePracticalStudents['total']).'</td>
				<td style="width:70px; text-align:center;">'.$valuePracticalLectures['total'].'</td>
				<td style="width:50px;text-align:center;">
					<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid=la&timing='.$valuePracticalCourseAllocation['timing'].'&semester='.$valuePracticalCourseAllocation['semester'].'&section='.$valuePracticalCourseAllocation['section'].'&view=Attendance&tpl=2"><i class="icon-zoom-in"></i></a>
				</td>
			</tr>';
			
		}
		//End While Loop
		
		echo ' 
		</tbody>
		</table>';
	}
	//End Liberal Arts
	
}
//End Count Check
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
} else {

//--------------------------------------
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
	
/*if($_GET['timing'] == '2') { 
	echo '<div class="alert-box error" style="font-size:20px; font-weight:600;margin-top:100px;">Please contact with Director Academic.</div>';
} else {*/
//--------------------------------------

if(isset($_GET['section'])) {  
	$sectcapion		= " ".$_GET['section'];
	$section 		= $_GET['section'];
	$seccursquery 	= " AND at.section = '".$_GET['section']."'";
	$secLecture 	= " AND t.section = '".$_GET['section']."'";
	$secthref 	 	= '&section='.$_GET['section'];
} else { 
	$sectcapion		= '';
	$section 		= '';
	$seccursquery 	= " AND at.section = ''";
	$secLecture 	= " AND t.section = ''";
	$secthref 	 	= '';
}


if($rowsetting['teacher_attendance'] == 1) { 
	$attendaceallow = '<a class="btn btn-mid btn-info pull-right" href="courses.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Attendance&add&tpl='.$_GET['tpl'].'"><i class="icon-plus"></i> Add Attendance </a>';
} else { 
	$attendaceallow = '';
}
	
if($_GET['prgid'] == 'la') {
	$captionprgms 	= '('.$sectcapion.') '.get_programtiming($_GET['timing']);
	$programname	= '';
} else {
//------------------------------------------------
	$sqllmsprgname  = $dblms->querylms("SELECT p.prg_name, p.prg_code  
										FROM ".PROGRAMS." p  
										WHERE p.prg_id = '".cleanvars($_GET['prgid'])."' LIMIT 1");
	$valuepname = mysqli_fetch_array($sqllmsprgname);

	$captionprgms = '('.strtoupper($valuepname['prg_code']).' - '.addOrdinalNumberSuffix($_GET['semester']).$sectcapion.') '.get_programtiming($_GET['timing']);
	$programname	= $valuepname['prg_name'];
}
//------------------------------------------------
echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Attendance - <font style="color:blue;">'.get_theorypractical($_GET['tpl']).'</font>'.$captionprgms.'</h3></span>
			<span class="pull-right"><a class="btn btn-mid btn-success" href="courses.php?id='.$_GET['id'].'&view=Attendance"> Back </a></span> 
			<a class="btn btn-mid btn-warning pull-right" href="courseattendanceprint.php?id='.$_GET['id'].'&teacherid='.$rowsstd['emply_id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&tpl='.$_GET['tpl'].'&sess='.cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR']).'" target="_blank"><i class="fa fa-print"></i> Print Report </a>'.$attendaceallow.'
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
	include_once("attendance/list.php");
	include_once("attendance/add.php");
	include_once("attendance/edit.php");

//}
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
}