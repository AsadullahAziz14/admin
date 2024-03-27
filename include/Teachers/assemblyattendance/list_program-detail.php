<?php
if(isset($_GET['prgid']) && !isset($_GET['editid'])) { 

	if(isset($_GET['section'])) { 
		$captionStudent		= ' ('.$_GET['section'].')';
		$addStdSectionSQL 	= " AND std.std_section = '".cleanvars($_GET['section'])."'";
		$sectionAttendance 	= " AND section = '".cleanvars($_GET['section'])."'";
		$sectionHref 		= '&section='.$_GET['section'];
	} else  { 
		$captionStudent		= '';
		$addStdSectionSQL 	= " AND std.std_section = ''";
		$sectionAttendance 	= " AND section = ''";
		$sectionHref		= '';
	}

	//Attendance Query
	$sqllmsAttendance  = $dblms->querylms("SELECT *  
											FROM ".ASSEMBLY_ATTENDANCE." at 										
											WHERE at.id_prg = '".cleanvars($_GET['prgid'])."'
											AND at.semester = '".cleanvars($_GET['semester'])."'
											$sectionAttendance AND at.timing = '".cleanvars($_GET['timing'])."'
											AND at.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
											AND at.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND at.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											ORDER BY at.dated DESC");

	//Program Name
	$sqllmsProgram  = $dblms->querylms("SELECT p.prg_code, p.prg_name  
											FROM ".PROGRAMS." p  
											WHERE p.prg_id = '".cleanvars($_GET['prgid'])."' LIMIT 1");
	$valueProgram = mysqli_fetch_array($sqllmsProgram);
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-12">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">

<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Attendance - ('.strtoupper($valueProgram['prg_code']).' - '.addOrdinalNumberSuffix($_GET['semester']).$captionStudent.') '.get_programtiming($_GET['timing']).'</h3></span>
			<span class="pull-right"><a class="btn btn-mid btn-success" href="assemblyattendance.php"> Back </a></span> 
			<a data-toggle="modal" class="btn btn-mid btn-info pull-right" href="#cursAddAttendanceModal"><i class="icon-plus"></i> Add Attendance </a>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<!--WI_MILESTONES_NAVIGATION-->';
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
} 
echo '
<!--WI_MILESTONES_TABLE-->
<div class="row">
<div class="col-lg-12">
  
<div class="widget wtabs">
<div class="widget-content">';
if(mysqli_num_rows($sqllmsAttendance) > 0) {
echo '
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center; ">Sr #</th>
	<th style="font-weight:600;">Dated</th>
	<th style="font-weight:600; text-align:center;">Total Students</th>
	<th style="font-weight:600; text-align:center;">Present</th>
	<th style="font-weight:600; text-align:center;">Absent</th>	
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srbk = 0;

while($valueAttendance = mysqli_fetch_array($sqllmsAttendance)) {

	$srbk++; 			

	//Count Total Present Students
	$sqllmsPresent  = $dblms->querylms("SELECT COUNT(dt.id) AS totalPresent     
											FROM ".ASSEMBLY_ATTENDANCE_DETAIL." dt 
											INNER JOIN ".STUDENTS." std  ON std.std_id = dt.id_std  
											WHERE dt.status = '2' AND dt.id_setup = '".cleanvars($valueAttendance['id'])."' 
											AND (std.std_status = '2' OR std.std_status = '7') 
											AND std.std_struckoffresticate !='1' AND std.std_regconfirmed = '1' ");
	$valuePresent = mysqli_fetch_array($sqllmsPresent);

	//Count Total Absent Students
	$sqllmsAbsent  = $dblms->querylms("SELECT COUNT(dt.id) AS totalAbsent    
											FROM ".ASSEMBLY_ATTENDANCE_DETAIL." dt 
											INNER JOIN ".STUDENTS." std  ON std.std_id = dt.id_std  
											WHERE dt.status = '1' AND dt.id_setup = '".cleanvars($valueAttendance['id'])."' 
											AND (std.std_status = '2' OR std.std_status = '7') 
											AND std.std_struckoffresticate !='1' AND std.std_regconfirmed = '1'  ");
	$valueAbsent = mysqli_fetch_array($sqllmsAbsent);

echo '
<tr>
	<td style="width:50px;text-align:center;vertical-align: middle;">'.$srbk.'</td>
	<td style="width:200px;vertical-align: middle;">'.date("d/m/Y", strtotime($valueAttendance['dated'])).'</td>
	<td style="text-align:center;width:110px;vertical-align: middle;">'.($valuePresent['totalPresent'] + $valueAbsent['totalAbsent']).'</td>
	<td style="text-align:center;width:80px;vertical-align: middle;">'.$valuePresent['totalPresent'].'</td>
	<td style="text-align:center;width:80px;vertical-align: middle;">'.$valueAbsent['totalAbsent'].'</td>
	<td style="width:50px; text-align:center;vertical-align: middle;">';
	if($valueAttendance['dated'] == date("Y-m-d")) { 
	echo ' <a class="btn btn-xs btn-info" href="assemblyattendance.php?prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$sectionHref.'&editid='.$valueAttendance['id'].'"><i class="icon-pencil"></i></a> 
		<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="assemblyattendance.php?prgid='.$_GET['prgid'].$sectionHref.'&delid='.$valueAttendance['id'].'" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a>';
	}
	echo '
	</td>
</tr>';
}
//End While Loop
echo ' 
</tbody>
</table>';
} else{
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
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