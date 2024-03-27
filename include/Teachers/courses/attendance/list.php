<?php
//--------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add'])) { 
//--------------------------------------------------

	if($_GET['prgid'] == 'la') {
		$addSQLConditions = "";
	} else{
		$addSQLConditions = "AND at.id_prg = '".cleanvars($_GET['prgid'])."' AND at.semester = '".cleanvars($_GET['semester'])."'";
	}

	$sqllmsassign  = $dblms->querylms("SELECT *  
										FROM ".COURSES_ATTENDANCE." at 										
										WHERE at.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND at.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND at.id_curs = '".cleanvars($_GET['id'])."' AND at.timing = '".cleanvars($_GET['timing'])."' 
										$addSQLConditions $seccursquery 
										AND at.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND at.theorypractical = '".cleanvars($_GET['tpl'])."' 
										ORDER BY at.lectureno DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsassign) > 0) {
echo '
<span style="font-weight:700; color:blue; margin-right:10px; margin-top:0px; float:right;"> 
	Total Lectures: ('.(mysqli_num_rows($sqllmsassign)).')
</span>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600; text-align:center;">Sr.#</th>
	<th style="font-weight:600;">Lecture #</th>
	<th style="font-weight:600;">Dated</th>
	<th style="font-weight:600;">Total Students</th>
	<th style="font-weight:600; text-align:center;">Present</th>
	<th style="font-weight:600; text-align:center;">Absent</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srbk = 0;
//------------------------------------------------
while($rowassign = mysqli_fetch_assoc($sqllmsassign)) { 
//------------------------------------------------
$srbk++;
//------------------------------------------------
	$sqllmsprsent  = $dblms->querylms("SELECT COUNT(dt.id) AS ttoalpresent     
										FROM ".COURSES_ATTENDANCE_DETAIL." dt 
										INNER JOIN ".STUDENTS." std  ON std.std_id = dt.id_std  
										WHERE dt.status = '2' AND dt.id_setup = '".cleanvars($rowassign['id'])."' 
										AND (std.std_status = '2' OR std.std_status = '7') 
										AND std.std_struckoffresticate !='1' AND std.std_regconfirmed = '1' ");
	$valuepresent = mysqli_fetch_array($sqllmsprsent);
//------------------------------------------------
	$sqllmsabsent  = $dblms->querylms("SELECT COUNT(dt.id) AS ttoalabsent    
										FROM ".COURSES_ATTENDANCE_DETAIL." dt 
										INNER JOIN ".STUDENTS." std  ON std.std_id = dt.id_std  
										WHERE dt.status = '1' AND dt.id_setup = '".cleanvars($rowassign['id'])."' 
										AND (std.std_status = '2' OR std.std_status = '7') 
										AND std.std_struckoffresticate !='1' AND std.std_regconfirmed = '1'  ");
	$valueabsent = mysqli_fetch_array($sqllmsabsent);
//------------------------------------------------
echo '
<tr>
	<td style="width:50px;text-align:center;vertical-align: middle;">'.$srbk.'</td>
	<td style="vertical-align: middle;">Lecture: '.$rowassign['lectureno'].'</td>
	<td style="width:100px;vertical-align: middle;">'.date("d/m/Y", strtotime($rowassign['dated'])).'</td>
	<td style="text-align:center;width:110px;vertical-align: middle;">'.($valuepresent['ttoalpresent'] + $valueabsent['ttoalabsent']).'</td>
	<td style="text-align:center;width:80px;vertical-align: middle;">'.$valuepresent['ttoalpresent'].'</td>
	<td style="text-align:center;width:80px;vertical-align: middle;">'.$valueabsent['ttoalabsent'].'</td>
	<td style="width:50px; text-align:center;vertical-align: middle;">
		<a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>'.$rowsurs['curs_code'].' - '.$rowsurs['curs_name'].' (Lecture #: '.$rowassign['lectureno'].')</b>" data-src="include/Teachers/courses/attendanceview.php?id='.$rowassign['id'].'&present='.$valuepresent['ttoalpresent'].'&absent='.$valueabsent['ttoalabsent'].'&prgname='.$programname.'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'" href="#"><i class="icon-zoom-in"></i></a>';
if($rowassign['dated'] == date("Y-m-d")) { 
	echo ' <a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Attendance&editid='.$rowassign['id'].'&tpl='.$_GET['tpl'].'"><i class="icon-pencil"></i></a> 
		<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="courses.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].$secthref.'&view=Attendance&delid='.$rowassign['id'].'" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a>';
}
	
echo ' <a class="btn btn-xs btn-information" href="studentattendanceprint.php?id='.$rowassign['id'].'" target="_blank"><i class="icon-print"></i></a>
	</td>
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
}