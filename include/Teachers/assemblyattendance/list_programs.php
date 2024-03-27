<?php
if(!isset($_GET['prgid'])) { 

echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-12">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">

<!--WI_MILESTONES_TABLE-->
<div class="row">
<div class="col-lg-12">
  
<div class="widget wtabs">
<div class="widget-content">';
if(mysqli_num_rows($sqllmsInchargeTimetable) > 0) {
echo '
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

while($valueProgram = mysqli_fetch_array($sqllmsInchargeTimetable)) {

	$srbk++; 

	if($valueProgram['section']) { 
		$captionStudent		= ' ('.$valueProgram['section'].')';
		$stdSection 	= " AND std.std_section = '".cleanvars($valueProgram['section'])."'";
		$sectionAttendance 	= " AND section = '".cleanvars($valueProgram['section'])."'";
		$sectionHref 		= '&section='.$valueProgram['section'];
	} else  { 
		$captionStudent		= '';
		$stdSection 	= " AND std.std_section = ''";
		$sectionAttendance 	= " AND section = ''";
		$sectionHref		= '';
	}

	//Count Total Students in Primary Program 
	$sqllmsStudents  = $dblms->querylms("SELECT COUNT(std.std_id) AS totalStds
											FROM ".STUDENTS." std 
											WHERE (std.std_status = '2' OR std.std_status = '7') 
											AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
											AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND std.id_prg = '".cleanvars($valueProgram['id_prg'])."' 
											AND std.std_timing = '".cleanvars($valueProgram['timing'])."' 
											$stdSection 
											AND std.std_semester = '".cleanvars($valueProgram['semester'])."' ");
	$rowStudents = mysqli_fetch_array($sqllmsStudents);

	//Count Total Students in Secondary Program
	$sqllmsStudentsSecondary  = $dblms->querylms("SELECT COUNT(std.std_id) AS total2ndaryStds
													FROM ".STUDENTS." std 
													WHERE (std.std_status = '2' OR std.std_status = '7') 
													AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
													AND std.id_campus 		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
													AND std.id_prgsecondary = '".cleanvars($valueProgram['id_prg'])."' 
													AND std.std_timing 		= '".cleanvars($valueProgram['timing'])."' 
													$stdSection 
													AND std.std_secondarysemester = '".cleanvars($valueProgram['semester'])."'");
	$rowStudentsSecondary = mysqli_fetch_array($sqllmsStudentsSecondary);			

	//Count Total Attendance already Marked
	$sqllmsLectures  = $dblms->querylms("SELECT COUNT(id) AS totalLectures
											FROM ".ASSEMBLY_ATTENDANCE."  
											WHERE id_prg = '".cleanvars($valueProgram['id_prg'])."' 
											AND semester = '".cleanvars($valueProgram['semester'])."' 
											$sectionAttendance
											AND timing = '".cleanvars($valueProgram['timing'])."' 
											AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
											AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
											AND id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'");
	$rowLectures = mysqli_fetch_array($sqllmsLectures);

echo '
<tr>
	<td style="width:50px; text-align:center;">'.$srbk.'</td>
	<td>'.$valueProgram['prg_name'].'</td>
	<td style="width:70px; text-align:center;">'.addOrdinalNumberSuffix($valueProgram['semester']).$captionStudent.'</td>
	<td style="width:70px; text-align:center;">'.get_programtiming($valueProgram['timing']).'</td>
	<td style="width:70px; text-align:center;">'.($rowStudents['totalStds'] + $rowStudentsSecondary['total2ndaryStds']).'</td>
	<td style="width:70px; text-align:center;">'.$rowLectures['totalLectures'].'</td>
	<td style="width:50px;text-align:center;">
		<a class="btn btn-xs btn-info" href="assemblyattendance.php?prgid='.$valueProgram['id_prg'].'&semester='.$valueProgram['semester'].$sectionHref.'&timing='.$valueProgram['timing'].'"><i class="icon-zoom-in"></i></a></td>
</tr>';
}
//End While Loop
echo ' 
</tbody>
</table>';
}
echo '
</div>
</div>
</div>
</div>

<!--WI_MILESTONES_TABLE-->

</div>
<div class="clearfix"></div>
</div>
</div>
</div>';
}