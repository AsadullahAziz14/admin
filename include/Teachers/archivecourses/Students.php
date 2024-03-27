<?php 
echo '
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
			<span class="pull-left"><h3  style="font-weight:700;">Enrolled Students</h3></span>
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
$sqllmsstdcurs  = $dblms->querylms("SELECT DISTINCT(d.id_curs), t.section, t.id_prg, t.timing,  t.semester      
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										INNER JOIN ".COURSES." c ON c.curs_id = d.id_curs  
										INNER JOIN ".EMPLYS." e ON e.emply_id = d.id_teacher   
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.academic_session = '".ARCHIVE_SESS."' 
										AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' AND t.status = '1' 
										AND d.id_curs = '".cleanvars($_GET['id'])."' 
										AND t.timing = '".cleanvars($_GET['timing'])."' AND t.semester = '".cleanvars($_GET['semester'])."' 
										AND t.id_prg = '".cleanvars($_GET['prgid'])."' $sqlsection 
										 ORDER BY t.session ASC");
$cursstudents = array();
$countstudents = 0;
//--------------------------------------------------
while($rowtsurs = mysqli_fetch_array($sqllmsstdcurs)) {
if($rowtsurs['section']) {
	$stdsection 	= " AND std.std_section =  '".cleanvars($rowtsurs['section'])."'"; 
} else { 
	$stdsection 	= " "; 
}
//echo 'Time: '.$rowtsurs['timing'].' Prg: '.$rowtsurs['id_prg'].' semester: '.$rowtsurs['semester'];
//--------------------------------------------------
		$sqllmsstds  = $dblms->querylms("SELECT std.std_id, std.std_photo, std.std_name, std.std_rollno, std.std_regno, std.std_session, 
											prg.prg_name  
											FROM ".STUDENTS." std 
											INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
											WHERE (std.std_status = '2' OR std.std_status = '7') AND std.std_struckoffresticate != '1' 
											AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND std.id_prg = '".cleanvars($rowtsurs['id_prg'])."' 
											AND std.std_timing = '".cleanvars($rowtsurs['timing'])."' 
											AND std.std_semester = '".cleanvars($rowtsurs['semester'])."' $stdsection 
											ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC");
	while($rowcurstds = mysqli_fetch_array($sqllmsstds)) { 
		$cursstudents[] = $rowcurstds;
		$countstudents++;
	}
}
//--------------------------------------------------
if ($countstudents > 0) {
echo '
<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;"> 
	Total Students: ('.number_format($countstudents).')
</div>
<div style="clear:both;"></div>
<span style="float:right; font-weight:700;margin-right:10px;">Attendance</span>
<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th style="font-weight:600; text-align:center;">Sr.#</th>
	<th style="font-weight:600; text-align:center;">Roll #</th>
	<th style="font-weight:600;">Reg #</th>
	<th width="35px" style="font-weight:600;">Pic</th>
	<th style="font-weight:600;">Student Name</th>
	<th style="font-weight:600;">Session</th>
	<th style="font-weight:600;">Program</th>
	<th style="font-weight:600;">Final</th>
</tr>
</thead>
<tbody>';
$srbk = 0;
//------------------------------------------------
foreach($cursstudents as $itemstd) { 
//------------------------------------------------
$srbk++;
//------------------------------------------------
if($itemstd['std_photo']) { 
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$itemstd['std_photo'].'" alt="'.$itemstd['std_name'].'"/>';
} else {
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$itemstd['std_name'].'"/>';
}

		$sqllmsattendance  = $dblms->querylms("SELECT at.total_lectures, dt.lecture_percent         
										FROM ".STUDENTS_ATTENDANCEDETAILS." dt
										INNER JOIN ".STUDENTS_ATTENDANCE." at ON at.id = dt.id_setup 
										WHERE at.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND at.id_curs = '".cleanvars($_GET['id'])."' 
										AND at.academic_session = '".ARCHIVE_SESS."'
										AND dt.id_std = '".cleanvars($itemstd['std_id'])."'");
	$rowattendance = mysqli_fetch_assoc($sqllmsattendance);
if($rowattendance['lecture_percent']>0) {
	$attendanceper = round(($rowattendance['lecture_percent']/$rowattendance['total_lectures']) * 100);
} else {
	$attendanceper = '';
}
//------------------------------------------------
echo '
<tr>
	<td style="width:30px; text-align:center;vertical-align:middle;">'.$srbk.'</td>
	<td style="width:55px;text-align:center;vertical-align:middle;">'.$itemstd['std_rollno'].'</td>
	<td style="vertical-align:middle;">'.$itemstd['std_regno'].'</td>
	<td style="vertical-align:middle;">'.$stdphoto.'</td>
	<td style="vertical-align:middle;"><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$rowcurstds['std_name'].' ('.$itemstd['std_session'].')</b>" data-src="studentdetail.php?std_id='.$itemstd['std_id'].'" href="#">'.$itemstd['std_name'].'</a> </td>
	<td style="vertical-align:middle;">'.$itemstd['std_session'].'</td>
	<td style="vertical-align:middle;">'.$itemstd['prg_name'].'</td>
	<td style="text-align:center;vertical-align:middle;width:55px;">'.$attendanceper.'%</td>
</tr>';
//------------------------------------------------
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