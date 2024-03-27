<?php 
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
	$sqllmsbook  = $dblms->querylms("INSERT INTO ".COURSES_ATTENDANCE." (
																		lectureno							, 
																		id_curs								,
																		section								,  
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
																		'".cleanvars($section)."'					,
																		'".cleanvars($_GET['prgid'])."'				,
																		'".cleanvars($_POST['id_teacher'])."'		, 
																		'".cleanvars($_POST['dated'])."'			, 
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
//--------------------------------------
}
//--------------------------------------
if(isset($_POST['changes_attendance'])) { 
//------------------------------------------------
	$sqllmsbook  = $dblms->querylms("UPDATE ".COURSES_ATTENDANCE." SET 
															lectureno		= '".cleanvars($_POST['lectureno'])."'
														  , id_curs			= '".cleanvars($_POST['id_curs'])."'
														  , section			= '".cleanvars($section)."'
														  , id_prg			= '".cleanvars($_GET['prgid'])."'
														  , id_teacher		= '".cleanvars($_POST['id_teacher'])."'
														  , dated			= '".cleanvars($_POST['dated'])."' 
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

		$sqllmsdelte  = $dblms->querylms("DELETE FROM ".COURSES_ATTENDANCE_DETAIL." WHERE id_setup = '".$_POST['id_setup']."'");

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
																				'".cleanvars($_POST['id_setup'])."'			, 
																				'".cleanvars($_POST['id_std'][$ichk])."'	, 
																				'".cleanvars($status)."'					, 
																				'".cleanvars($_POST['remarks'][$ichk])."'	
																			)
										");
		}
//------------------------------------------------
			echo '<div id="infoupdated" class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		}
//--------------------------------------
	}
//------------------------------------------------
echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Student Attendance</h3></span>
			<a data-toggle="modal" class="btn btn-mid btn-info pull-right" href="#cursAddAttendanceModal"><i class="icon-plus"></i> Add Attendance </a>
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
	$sqllmsassign  = $dblms->querylms("SELECT at.id, at.lectureno, at.id_curs, at.id_teacher, at.dated    
										FROM ".COURSES_ATTENDANCE_DETAIL." dt
										INNER JOIN ".COURSES_ATTENDANCE." at ON at.id = dt.id_setup 
										INNER JOIN ".STUDENTS." std  ON std.std_id = dt.id_std  
										WHERE at.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND at.id_curs = '".cleanvars($_GET['id'])."' $seccursquery 
										AND std.id_prg = '".cleanvars($rowsurs['id_prg'])."' AND (std.std_status = '2' OR std.std_status = '7')  
										AND std.std_semester = '".cleanvars($rowsurs['semester'])."'
										GROUP BY dt.id_setup ORDER BY at.lectureno DESC");
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
	$sqllmsprsent  = $dblms->querylms("SELECT COUNT(id) AS ttoalpresent     
										FROM ".COURSES_ATTENDANCE_DETAIL." 
										WHERE status = '2' AND id_setup = '".cleanvars($rowassign['id'])."'");
	$valuepresent = mysqli_fetch_array($sqllmsprsent);
//------------------------------------------------
	$sqllmsabsent  = $dblms->querylms("SELECT COUNT(id) AS ttoalabsent    
										FROM ".COURSES_ATTENDANCE_DETAIL." 
										WHERE status = '1' AND id_setup = '".cleanvars($rowassign['id'])."'");
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
		<a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>'.$rowsurs['curs_code'].' - '.$rowsurs['curs_name'].' (Lecture #: '.$rowassign['lectureno'].') Detail</b>" data-src="include/Teachers/courses/attendanceview.php?id='.$rowassign['id'].'&present='.$valuepresent['ttoalpresent'].'&absent='.$valueabsent['ttoalabsent'].'" href="#"><i class="icon-zoom-in"></i></a>  
		<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].$secthref.'&view=Attendance&editid='.$rowassign['id'].'"><i class="icon-pencil"></i></a> 
		<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="courses.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].$secthref.'&view=Attendance&delid='.$rowassign['id'].'" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a>
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
	$sqllmsassign  = $dblms->querylms("SELECT id, lectureno, id_curs, id_teacher, dated    
										FROM ".COURSES_ATTENDANCE." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND id = '".cleanvars($_GET['editid'])."' AND id_curs = '".cleanvars($_GET['id'])."' LIMIT 1");
	$valueedit = mysqli_fetch_array($sqllmsassign);
//--------------------------------------------------
	$sqllmsstds  = $dblms->querylms("SELECT *   
											FROM ".COURSES_ATTENDANCE_DETAIL." da 
										  	INNER JOIN ".STUDENTS." std  ON std.std_id = da.id_std  
											INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
										  	INNER JOIN ".DEPTS." dept ON prg.id_dept = dept.dept_id 
										  	WHERE std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										  	AND da.id_setup = '".cleanvars($_GET['editid'])."' 
										  	ORDER BY std.std_rollno ASC, std.std_regno ASC");	
//--------------------------------------------------
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<form class="form-horizontal" action="courses.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].$secthref.'s&view=Attendance" method="post" id="editAssign" enctype="multipart/form-data">
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
while($rowcurstds = mysqli_fetch_array($sqllmsstds)) { 
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
<input type="hidden" name="id_std['.$srbk.']" id="id_std['.$srbk.']" value="'.$rowcurstds['std_id'].'">';
//------------------------------------------------
}
//------------------------------------------------
echo '
</tbody>
</table>
	<div style="clear:both;"></div>
	

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'courses.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].$secthref.'&view=Attendance\'" >Closed</button>
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
'; 

?>