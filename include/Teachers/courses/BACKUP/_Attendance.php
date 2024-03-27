<?php 
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
			<span class="pull-left"><h3  style="font-weight:700;">Student Attendance</h3></span>
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
	<th style="font-weight:600;text-align:center;">Lectures</th>
	
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
} else  { 
	$secthref 	= '';
}
//------------------------------------------------
		$sqllmsstds  = $dblms->querylms("SELECT COUNT(std.std_id) AS Totalstds
											FROM ".STUDENTS." std 
											WHERE (std.std_status = '2' OR std.std_status = '7') AND std.std_struckoffresticate != '1' 
											AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND std.id_prg = '".cleanvars($rowrelted['id_prg'])."' 
											AND std.std_timing = '".cleanvars($rowrelted['timing'])."' 
											AND std.std_section = '".cleanvars($rowrelted['section'])."' 
											AND std.std_semester = '".cleanvars($rowrelted['semester'])."' ");
	$rowcurstds = mysqli_fetch_array($sqllmsstds);
//------------------------------------------------
	$sqllmsLectures  = $dblms->querylms("SELECT COUNT(id) AS TotalLectures
											FROM ".COURSES_ATTENDANCE." std 
											WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND id_curs = '".cleanvars($_GET['id'])."' 
											AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
											AND semester = '".cleanvars($rowrelted['semester'])."' 
											AND section = '".cleanvars($rowrelted['section'])."' 
											AND id_prg = '".cleanvars($rowrelted['id_prg'])."' 
											AND timing = '".cleanvars($rowrelted['timing'])."'");
	$rowLectures = mysqli_fetch_array($sqllmsLectures);
//------------------------------------------------
echo '
<tr>
	<td style="width:30px; text-align:center;">'.$srbk.'</td>
	<td>'.$rowrelted['prg_name'].'</td>
	<td style="width:70px; text-align:center;">'.addOrdinalNumberSuffix($rowrelted['semester']).' '.$rowrelted['section'].'</td>
	<td style="width:70px; text-align:center;">'.get_programtiming($rowrelted['timing']).'</td>
	<td style="width:70px; text-align:center;">'.$rowcurstds['Totalstds'].'</td>
	<td style="width:70px; text-align:center;">'.$rowLectures['TotalLectures'].'</td>
	<td style="width:50px;text-align:center;">
		<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid='.$rowrelted['id_prg'].'&timing='.$rowrelted['timing'].'&semester='.$rowrelted['semester'].$secthref.'&view=Attendance"><i class="icon-zoom-in"></i></a></td>
</tr>';
//--------------------------------------------------
	}
echo ' 
</tbody>
</table>

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
if(isset($_GET['delid'])) {
	$sqllms  	= $dblms->querylms("DELETE FROM ".COURSES_ATTENDANCE." WHERE id ='".$_GET['delid']."'");
	$sqllmsprt  = $dblms->querylms("DELETE FROM ".COURSES_ATTENDANCE_DETAIL." WHERE id_setup ='".$_GET['delid']."'");
	header('location:'.$_SERVER['HTTP_REFERER'].'&del=1');
}
//--------------------------------------
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">';
if($_GET['timing'] == '2') { 
	echo '<div class="alert-box error" style="font-size:20px; font-weight:600;margin-top:100px;">Please contact with Director Academic.</div>';
} else {
//--------------------------------------
if(isset($_GET['del']) == 1) {
//--------------------------------------
	echo '<div id="infoupdated" class="alert-box warning"><span>Warning: </span>Record delete successfully.</div>';
}

if(isset($_GET['section'])) {  
	$section 		= $_GET['section'];
	$seccursquery 	= " AND at.section = '".$_GET['section']."'";
} else { 
	$section 		= '';
	$seccursquery 	= "";
}

//--------------------------------------
if(isset($_POST['submit_attendance'])) { 
//------------------------------------------------
	$sqllmscheck  = $dblms->querylms("SELECT at.id  
										FROM ".COURSES_ATTENDANCE."  at 
										WHERE at.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND at.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND at.id_curs = '".cleanvars($_GET['id'])."' 
										AND at.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND at.semester = '".cleanvars($_GET['semester'])."' 
										AND at.id_prg = '".cleanvars($_GET['prgid'])."' AND at.timing = '".cleanvars($_GET['timing'])."' 
										 $seccursquery 
										AND at.dated = '".date('Y-m-d' , strtotime(cleanvars($_POST['dated'])))."' LIMIT 1");

if(mysqli_num_rows($sqllmscheck)>0) { 
	echo '<div class="alert-box warning"><span>Notice: </span>Record already exists.</div>';
} else { 
//------------------------------------------------
	$sqllmsbook  = $dblms->querylms("INSERT INTO ".COURSES_ATTENDANCE." (
																		lectureno							, 
																		id_curs								,
																		semester							,  
																		section								,  
																		timing								, 
																		id_prg								, 
																		id_teacher							,
																		dated								,
																		academic_session					,
																		id_campus							,
																		id_added							, 
																		date_added 
																   )
	   														VALUES (
																		'".cleanvars($_POST['lectureno'])."'		,
																		'".cleanvars($_POST['id_curs'])."'			,
																		'".cleanvars($_GET['semester'])."'			,
																		'".cleanvars($section)."'					,
																		'".cleanvars($_GET['timing'])."'			,
																		'".cleanvars($_GET['prgid'])."'				,
																		'".cleanvars($_POST['id_teacher'])."'		, 
																		'".date('Y-m-d' , strtotime(cleanvars($_POST['dated'])))."'			, 
																		'".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' , 
																		'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
																		'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
																		NOW() 
													 			 )"
							);
//--------------------------------------
if($sqllmsbook) {
$idsetup = $dblms->lastestid();
//--------------------------------------
	$logremarks = 'Add Student Attendance of Lecture #: '.$_POST['lectureno'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
if(!empty($_POST['status'][$ichk])) { 
	$status = '1';
} else { 
	$status = '2';
}
//------------------------------------------------
			$sqllmsmulti  = $dblms->querylms("INSERT INTO ".COURSES_ATTENDANCE_DETAIL."( 
																				id_setup									,
																				id_std										, 
																				status										, 
																				remarks										
																			)
	   																VALUES (
																				'".$idsetup."'								, 
																				'".cleanvars($_POST['id_std'][$ichk])."'	, 
																				'".cleanvars($status)."'					, 
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
}
//--------------------------------------
if(isset($_POST['changes_attendance'])) { 
//------------------------------------------------
	$sqllmsbook  = $dblms->querylms("UPDATE ".COURSES_ATTENDANCE." SET 
															lectureno		= '".cleanvars($_POST['lectureno'])."'
														  , id_curs			= '".cleanvars($_POST['id_curs'])."'
														  , semester		= '".cleanvars($_GET['semester'])."'
														  , section			= '".cleanvars($section)."'
														  , timing			= '".cleanvars($_GET['timing'])."'
														  , id_prg			= '".cleanvars($_GET['prgid'])."'
														  , id_teacher		= '".cleanvars($_POST['id_teacher'])."'
														  , dated			= '".date('Y-m-d' , strtotime(cleanvars($_POST['dated'])))."' 
														  , id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
														  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														  , date_modify		= NOW()
													  WHERE id				= '".cleanvars($_POST['id_setup'])."'");
//--------------------------------------
		if($sqllmsbook) {
//--------------------------------------
	$logremarks = 'Update Student Attendance of Lecture #: '.$_POST['lectureno'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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

//		$sqllmsdelte  = $dblms->querylms("DELETE FROM ".COURSES_ATTENDANCE_DETAIL." WHERE id_setup = '".$_POST['id_setup']."'");

//--------------------------------------
	$arraychecked = $_POST['id_std'];
//--------------------------------------
	for($ichk=1; $ichk<=sizeof($arraychecked); $ichk++){
		if(!empty($_POST['status'][$ichk])) { 
			$status = '1';
		} else { 
			$status = '2';
		}
if(!empty($_POST['id_attendance'][$ichk])) { 
//------------------------------------------------
	$sqllmsmulti  = $dblms->querylms("UPDATE ".COURSES_ATTENDANCE_DETAIL." SET 
															id_std		= '".cleanvars($_POST['id_std'][$ichk])."'
														  , status		= '".cleanvars($status)."'
														  , remarks		= '".cleanvars($_POST['remarks'][$ichk])."'
														  
													  WHERE id_setup	= '".cleanvars($_POST['id_setup'])."' 
													  AND id	= '".cleanvars($_POST['id_attendance'][$ichk])."' ");
} else { 
//------------------------------------------------
			$sqllmsmulti  = $dblms->querylms("INSERT INTO ".COURSES_ATTENDANCE_DETAIL."( 
																				id_setup									,
																				id_std										, 
																				status										, 
																				remarks										
																			)
	   																VALUES (
																				'".cleanvars($_POST['id_setup'])."'			, 
																				'".cleanvars($_POST['id_std'][$ichk])."'	, 
																				'".cleanvars($status)."'					, 
																				'".cleanvars($_POST['remarks'][$ichk])."'	
																			)
										");

}



		}
//------------------------------------------------
			echo '<div id="infoupdated" class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		}
//--------------------------------------
	}
if($rowsetting['teacher_attendance'] == 1) { 
	$attendaceallow = '<a data-toggle="modal" class="btn btn-mid btn-info pull-right" href="#cursAddAttendanceModal"><i class="icon-plus"></i> Add Attendance </a>';
} else { 
	$attendaceallow = '';
}
	
//------------------------------------------------
echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Student Attendance</h3></span>
			<span class="pull-right"><a class="btn btn-mid btn-success" href="courses.php?id='.$_GET['id'].'&view=Attendance"> Back </a></span> '.$attendaceallow.'
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
if(!isset($_GET['editid'])) { 
//--------------------------------------------------
	$sqllmsassign  = $dblms->querylms("SELECT *  
										FROM ".COURSES_ATTENDANCE." at 										
										WHERE at.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND at.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND at.id_curs = '".cleanvars($_GET['id'])."' AND at.timing = '".cleanvars($_GET['timing'])."' 
										$seccursquery AND at.id_prg = '".cleanvars($_GET['prgid'])."'
										AND at.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND at.semester = '".cleanvars($_GET['semester'])."'
										ORDER BY at.lectureno DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsassign) > 0) {
echo '
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600; text-align:center;">Sr.#</th>
	<th style="font-weight:600;">Lecture #</th>
	<th style="font-weight:600;">Dated</th>
	<th style="font-weight:600;">Total Students</th>
	<th style="font-weight:600; text-align:center;">Present</th>
	<th style="font-weight:600; text-align:center;">Absent</th>
	<th style="width:80px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
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
										AND (std.std_status = '2' OR std.std_status = '7') AND std.std_struckoffresticate !='1' ");
	$valuepresent = mysqli_fetch_array($sqllmsprsent);
//------------------------------------------------
	$sqllmsabsent  = $dblms->querylms("SELECT COUNT(dt.id) AS ttoalabsent    
										FROM ".COURSES_ATTENDANCE_DETAIL." dt 
										INNER JOIN ".STUDENTS." std  ON std.std_id = dt.id_std  
										WHERE dt.status = '1' AND dt.id_setup = '".cleanvars($rowassign['id'])."' 
										AND (std.std_status = '2' OR std.std_status = '7') AND std.std_struckoffresticate !='1' ");
	$valueabsent = mysqli_fetch_array($sqllmsabsent);
//------------------------------------------------
echo '
<tr>
	<td style="width:50px;text-align:center;">'.$srbk.'</td>
	<td>Lecture: '.$rowassign['lectureno'].'</td>
	<td style="width:100px;">'.date("d/m/Y", strtotime($rowassign['dated'])).'</td>
	<td style="text-align:center;width:110px;">'.($valuepresent['ttoalpresent'] + $valueabsent['ttoalabsent']).'</td>
	<td style="text-align:center;width:80px;">'.$valuepresent['ttoalpresent'].'</td>
	<td style="text-align:center;width:80px;">'.$valueabsent['ttoalabsent'].'</td>
	<td style="width:80px; text-align:center;">
		<a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>'.$rowsurs['curs_code'].' - '.$rowsurs['curs_name'].' (Lecture #: '.$rowassign['lectureno'].') Detail</b>" data-src="include/Teachers/courses/attendanceview.php?id='.$rowassign['id'].'&present='.$valuepresent['ttoalpresent'].'&absent='.$valueabsent['ttoalabsent'].'" href="#"><i class="icon-zoom-in"></i></a>';
//if($rowassign['dated'] == date("Y-m-d")) { 
	echo ' <a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Attendance&editid='.$rowassign['id'].'"><i class="icon-pencil"></i></a> 
		<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="courses.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].$secthref.'&view=Attendance&delid='.$rowassign['id'].'" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a>';
//}
echo '
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
//------------------------------------------------
if($_GET['editid']) {  
//------------------------------------------------
	$sqllmsassign  = $dblms->querylms("SELECT *   
										FROM ".COURSES_ATTENDANCE." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND id = '".cleanvars($_GET['editid'])."' AND id_curs = '".cleanvars($_GET['id'])."' LIMIT 1");
	$valueedit = mysqli_fetch_array($sqllmsassign);
//--------------------------------------------------

//--------------------------------------------------
$cursstudents = array();
$countstudents = 0;

if(isset($_GET['section'])) {
	$stdsection 	= " AND std.std_section =  '".cleanvars($_GET['section'])."'"; 
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
											AND std.id_prg = '".cleanvars($_GET['prgid'])."' 
											AND std.std_timing = '".cleanvars($_GET['timing'])."' 
											AND std.std_semester = '".cleanvars($_GET['semester'])."' $stdsection 
											ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC");
	while($rowcurstds = mysqli_fetch_array($sqllmsstds)) { 
		$cursstudents[] = $rowcurstds;
		$countstudents++;
	}
//--------------------------------------------------
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<form class="form-horizontal" action="courses.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Attendance" method="post" id="editAssign" enctype="multipart/form-data">
<input type="hidden" name="id_curs" name="id_curs" value="'.$_GET['id'].'">
<input type="hidden" name="id_teacher" name="id_teacher" value="'.$rowsurs['id_teacher'].'">
<input type="hidden" name="id_setup" name="id_setup" value="'.$_GET['editid'].'">
<div class="modal-content">
<!--WI_MILESTONES_NAVIGATION-->
<div class="modal-header">	
	<h4 class="modal-title" style="font-weight:700;">Edit Student Attendance</h4>
</div>
<!--WI_MILESTONES_NAVIGATION-->

<div class="modal-body">

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Lecture: #</label>
			<select id="lecturenoid" name="lectureno" style="width:100%" autocomplete="off" required>
				<option value="">Select Lecture</option>';
			for($isem = 1; $isem<=40; $isem ++) {
				if($valueedit['lectureno'] == $isem) { 
					echo '<option value="'.$isem.'" selected>Lecture: '.$isem.'</option>';
				} else { 
					echo '<option value="'.$isem.'">Lecture: '.$isem.'</option>';
				}
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Dated </label>
			<input type="text" name="dated" id="dated" class="form-control pickadate" value="'.$valueedit['dated'].'" required autocomplete="off" >
		</div> 
	</div>


	<div style="clear:both;"></div>
<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;"> 
	Total Students: ('.mysqli_num_rows($sqllmsstds).')
</div>
<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th style="font-weight:600; vertical-align:middle; text-align:center;">Sr.#</th>
	<th style="font-weight:600; vertical-align:middle; text-align:center;">Roll #</th>
	<th style="font-weight:600; vertical-align:middle;">Reg #</th>
	<th width="35px" style="font-weight:600; vertical-align:middle;">Pic</th>
	<th style="font-weight:600; vertical-align:middle;">Student Name</th>
	<th style="font-weight:600; text-align:center;">Status<div style="color:red; font-size:10px;">Just Check Absant</div></th>
	<th style="font-weight:600; vertical-align:middle;">Remarks</th>
</tr>
</thead>
<tbody>';
$srbk = 0;
//------------------------------------------------
foreach($cursstudents as $rowcurstds) { 
$srbk++;
//------------------------------------------------
if($rowcurstds['std_photo']) { 
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$rowcurstds['std_photo'].'" alt="'.$rowcurstds['std_name'].'"/>';
} else {
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$rowcurstds['std_name'].'"/>';
}
//------------------------------------------------
	$sqllmsattendance  = $dblms->querylms("SELECT id, id_setup, id_std, status, remarks    
										FROM ".COURSES_ATTENDANCE_DETAIL." 
										WHERE id_setup = '".cleanvars($_GET['editid'])."' 
										AND id_std = '".cleanvars($rowcurstds['std_id'])."' LIMIT 1");
	$valueattendance 	= mysqli_fetch_array($sqllmsattendance);
//------------------------------------------------
if($valueattendance['id']) { 
if($valueattendance['status'] == 1) { 
	$checked = 'checked="checked"';
} else { 
	$checked = '';
}
//------------------------------------------------
echo '
<tr>
	<td style="width:40px; text-align:center;">'.$srbk.'</td>
	<td style="width:60px; text-align:center;">'.$rowcurstds['std_rollno'].'</td>
	<td style="width:150px;">'.$rowcurstds['std_regno'].'</td>
	<td>'.$stdphoto.'</td>
	<td><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$rowcurstds['std_name'].' ('.$rowcurstds['std_session'].')</b>" data-src="studentdetail.php?std_id='.$rowcurstds['std_id'].'" href="#">'.$rowcurstds['std_name'].'</a> </td>
	<td style="width:110px; text-align:center;"><input '.$checked.' name="status['.$srbk.']" type="checkbox" id="status['.$srbk.']" value="1" class="checkbox-inline"></td>
	<td style="width:150px;"><input type="text" value="'.$valueattendance['remarks'].'" class="form-control col-lg-12" id="remarks['.$srbk.']" name="remarks['.$srbk.']" autocomplete="off"></td>
</tr>
<input type="hidden" name="id_std['.$srbk.']" id="id_std['.$srbk.']" value="'.$rowcurstds['std_id'].'">
<input type="hidden" name="id_attendance['.$srbk.']" id="id_attendance['.$srbk.']" value="'.$valueattendance['id'].'">';
//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<tr>
	<td style="width:40px; text-align:center;">'.$srbk.'</td>
	<td style="width:60px; text-align:center;">'.$rowcurstds['std_rollno'].'</td>
	<td style="width:150px;">'.$rowcurstds['std_regno'].'</td>
	<td>'.$stdphoto.'</td>
	<td><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$rowcurstds['std_name'].' ('.$rowcurstds['std_session'].')</b>" data-src="studentdetail.php?std_id='.$rowcurstds['std_id'].'" href="#">'.$rowcurstds['std_name'].'</a> </td>
	<td style="width:110px; text-align:center;"><input  name="status['.$srbk.']" type="checkbox" id="status['.$srbk.']" value="1" class="checkbox-inline"></td>
	<td style="width:150px;"><input type="text" value="" class="form-control col-lg-12" id="remarks['.$srbk.']" name="remarks['.$srbk.']" autocomplete="off"></td>
</tr>
<input type="hidden" name="id_std['.$srbk.']" id="id_std['.$srbk.']" value="'.$rowcurstds['std_id'].'">
<input type="hidden" name="id_attendance['.$srbk.']" id="id_attendance['.$srbk.']" value="">';
}

}
//------------------------------------------------
echo '
</tbody>
</table>
	<div style="clear:both;"></div>
	

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'courses.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].$secthref.'&view=Attendance\'" >Close</button>
	<input class="btn btn-primary" type="submit" value="Change Record" id="changes_attendance" name="changes_attendance">
	</button>
</div>

</div>
</form>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
	$("#lecturenoid").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
	$("#editAssign").validate({
		rules: {
             lectureno		: "required",
			 dated			: "required"
		},
		messages: {
			lectureno		: "This field is required",
			dated			: "This field is required"
		},
		submitHandler: function(form) {
        //alert("form submitted");
		form.submit();
        }
	});
});
</script>';
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
}
?>