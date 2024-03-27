<?php 
include_once("assignments/query.php");
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>';
//----------------------------------------
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
} 
//----------------------------------------
	$sql2 = '';
	$sqlstring	 	= "";
	$srch	  	  	= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
	$idprg	  		= (isset($_GET['idprg']) && $_GET['idprg'] != '') ? $_GET['idprg'] : '';
	$idassignment	= (isset($_GET['idassignment']) && $_GET['idassignment'] != '') ? $_GET['idassignment'] : '';
//----------------------------------------
if(($srch)) { 
	$sql2 		.= " AND (std.std_name LIKE '%".$srch."%' 
						OR std.std_regno LIKE '".$srch."' 
						OR std.std_rollno LIKE '".$srch."'
						OR std.std_formno LIKE '".$srch."')"; 
	$sqlstring	.= "&srch=".$srch."";
}
//----------------------------------------
if(($idassignment)) { 
	$sql2 		.= " AND astd.id_assignment = '".$idassignment."'"; 
	$sqlstring	.= "&idassignment=".$idassignment."";
}

if(($idprg)) { 
	$sql2 		.= " AND std.id_prg = '".$idprg."'"; 
	$sqlstring	.= "&idprg=".$idprg."";
}

if(isset($_GET['section'])) {  
	$section 		= $_GET['section'];
	$seccursquery 	= " AND section = '".$_GET['section']."'";
} else { 
	$section 		= '';
	$seccursquery 	= "";
}


echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<span class="pull-left"><h3 style="font-weight:700;  padding-top:10px;"><i class="icon-group"></i> Student Assignments</h3></span>
			<form class="navbar-form navbar-right form-small" action="courses.php" method="get">
			<input type="hidden" value="'.$_GET['id'].'" id="id" name="id">
			<input type="hidden" value="StudentAssignments" id="view" name="view">
			
			<div class="form-group">
				<input type="text" class="form-control" name="srch" placeholder="Name, Roll No etc" style="width:200px; " >
			</div>
			<div class="form-group">
			<select id="projects-list7" data-placeholder="Select Program" name="idprg" style="width:200px; text-align:left !important;" >
			<option></option>';
			$sqllmsCursPrograms  = $dblms->querylms("SELECT DISTINCT(t.id_prg), p.prg_id, p.prg_name
														FROM ".TIMETABLE_DETAILS." d  
														INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
														INNER JOIN ".PROGRAMS." p ON p.prg_id = t.id_prg   
														WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
														AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
														AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
														AND d.id_curs = '".cleanvars($_GET['id'])."' AND t.status =  '1'");
			while($valueProgram = mysqli_fetch_array($sqllmsCursPrograms)) {
				echo '<option value="'.$valueProgram['prg_id'].'">'.$valueProgram['prg_name'].'</option>';
			}
			echo '</select>
			</div> 
			<div class="form-group">
			<select id="projects-list6" data-placeholder="Select Assignment" name="idassignment" style="width:200px; text-align:left !important;" >
			<option></option>';
			$sqllmsprgcats  = $dblms->querylms("SELECT id, status, id_curs, caption, detail, date_start, 
														date_end, total_marks, passing_marks, fileattach    
														FROM ".COURSES_ASSIGNMENTS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' AND timing = '".cleanvars($_GET['timing'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' $seccursquery AND semester = '".cleanvars($_GET['semester'])."' 
										AND id_prg = '".cleanvars($_GET['prgid'])."' ORDER BY id DESC");
			while($valueprgcats = mysqli_fetch_array($sqllmsprgcats)) {
				echo '<option value="'.$valueprgcats['id'].'">'.$valueprgcats['caption'].'</option>';
			}
			echo '</select>
			</div> 
			<button type="submit" class="btn btn-primary" style="height: 27px; margin-bottom:2px;">Search</button> 
<script>

    $("#projects-list6").select2({
        allowClear: true
    });
	$("#projects-list7").select2({
        allowClear: true
    });

</script>
			</form>
</div>
<!-- /.navbar-collapse -->
		</div>
	</div>
</div>
<!--WI_MILESTONES_NAVIGATION-->

<!--WI_MILESTONES_TABLE-->
<div class="row">
<div class="col-lg-12">
  
<div class="widget wtabs">
<div class="widget-content">';
	$sqllmsassign  = $dblms->querylms("SELECT std.std_id, std.std_name, std.std_regno, std.std_photo, std.std_session, 
										assign.caption, assign.is_midterm, astd.id_assignment,  
										assign.date_start, assign.date_end, assign.total_marks, astd.marks, astd.id, 
										astd.submit_date, astd.student_file, std.id_prg, std.std_semester, std.std_section, std.std_timing 
										FROM ".COURSES_ASSIGNMENTS_STUDENTS." astd  
										INNER JOIN ".COURSES_ASSIGNMENTS." assign ON assign.id = astd.id_assignment   
										INNER JOIN ".STUDENTS." std ON std.std_id = astd.id_std    
										WHERE assign.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND assign.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND assign.id_teacher = '".cleanvars($rowsstd['emply_id'])."' $sql2  
										AND assign.id_curs = '".cleanvars($_GET['id'])."' ORDER BY astd.id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsassign) > 0) {
echo '
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center;vertical-align:middle; ">Sr.#</th>
	<th width="50px" style="font-weight:600;vertical-align:middle;">Pic</th>
	<th style="font-weight:600;vertical-align:middle;">Student</th>
	<th style="font-weight:600;vertical-align:middle;">Reg. #</th>
	<th style="font-weight:600;text-align:center;vertical-align:middle; ">Assignment</th>
	<th style="font-weight:600;text-align:center; vertical-align:middle;">Due Date</th>
	<th style="font-weight:600;text-align:center;vertical-align:middle; ">Submit Date</th>
	<th style="font-weight:600;text-align:center;vertical-align:middle; ">Marks</th>
	<th style="width:50px; text-align:center; font-size:14px;vertical-align:middle;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srbk = 0;
//------------------------------------------------
while($rowassign = mysqli_fetch_assoc($sqllmsassign)) { 
//------------------------------------------------
$srbk++;

if($rowassign['std_photo']) { 
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$rowassign['std_photo'].'" alt="'.$rowassign['std_name'].'"/>';
} else {
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$rowassign['std_name'].'"/>';
}

if($rowassign['student_file']) { 
	$filedownload = '<a class="btn btn-xs btn-success" href="downloads/assignments/students/'.$rowassign['student_file'].'" target="_blank"> <i class="icon-download"></i></a> ';
} else  { 
	$filedownload = ' &nbsp;&nbsp;&nbsp;&nbsp;';
}
	
if($rowassign['is_midterm'] == 1) { 
	
//------------------------------------------------

	$sqllmslessonprgs  = $dblms->querylms("SELECT clp.id_prg, clp.id, clp.id_setup, clp.semester, clp.section, clp.timing, 
										p.prg_name, p.prg_code, p.prg_id   
										FROM ".COURSES_ASSIGNMENTSPROGRAM." clp 
										INNER JOIN ".PROGRAMS." p ON p.prg_id = clp.id_prg  
										WHERE clp.id_setup = '".cleanvars($rowassign['id_assignment'])."' 
										AND clp.id_prg = '".$rowassign['id_prg']."' AND clp.semester = '".$rowassign['std_semester']."'
										AND clp.section = '".$rowassign['std_section']."' AND clp.timing = '".$rowassign['std_timing']."'");
	$rowprgams = mysqli_fetch_assoc($sqllmslessonprgs);
//------------------------------------------------	
	$sqllmschecker  = $dblms->querylms("SELECT m.id 
												FROM ".MIDTERM." m 
												WHERE m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										  		AND m.id_prg = '".cleanvars($rowprgams['id_prg'])."' 
												AND m.section = '".cleanvars($rowprgams['section'])."'
												AND m.timing = '".cleanvars($rowprgams['timing'])."' 
												AND m.semester = '".cleanvars($rowprgams['semester'])."'
												AND m.id_curs = '".cleanvars($_GET['id'])."'  LIMIT 1");
if(mysqli_num_rows($sqllmschecker)>0) {
	$ismidterm = ' ';
} else {
	$ismidterm = ' <a class="btn btn-xs btn-info student-assignment-modal" data-toggle="modal" data-modal-window-title="'.$rowassign['caption'].'" data-height="350" data-width="100%" data-assignstdname="'.$rowassign['std_name'].'" data-assignstdregno="'.$rowassign['std_regno'].'" data-assignname="'.$rowassign['caption'].'" data-assignduedat="'.date("d/m/Y", strtotime($rowassign['date_end'])).'" data-assignsubmitdate="'.date("d/m/Y", strtotime($rowassign['submit_date'])).'" data-assigntotalmarks="'.$rowassign['total_marks'].'" data-assignobtainmarks="'.$rowassign['marks'].'" data-assignid="'.$rowassign['id'].'" data-target="#cursStudentAssignModal"><i class="icon-pencil"></i></a>';
}
	
	
} else  { 
	$ismidterm = ' <a class="btn btn-xs btn-info student-assignment-modal" data-toggle="modal" data-modal-window-title="'.$rowassign['caption'].'" data-height="350" data-width="100%" data-assignstdname="'.$rowassign['std_name'].'" data-assignstdregno="'.$rowassign['std_regno'].'" data-assignname="'.$rowassign['caption'].'" data-assignduedat="'.date("d/m/Y", strtotime($rowassign['date_end'])).'" data-assignsubmitdate="'.date("d/m/Y", strtotime($rowassign['submit_date'])).'" data-assigntotalmarks="'.$rowassign['total_marks'].'" data-assignobtainmarks="'.$rowassign['marks'].'" data-assignid="'.$rowassign['id'].'" data-target="#cursStudentAssignModal"><i class="icon-pencil"></i></a>';
}

//------------------------------------------------
echo '
<tr>
	<td style="width:40px; text-align:center; vertical-align:middle;">'.$srbk.'</td>
	<td style="vertical-align:middle;">'.$stdphoto.'</td>
	<td style="vertical-align:middle;"><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$rowassign['std_name'].' ('.$rowassign['std_session'].')</b>" data-src="studentdetail.php?std_id='.$rowassign['std_id'].'" href="#">'.$rowassign['std_name'].'</a></td>
	<td style="vertical-align:middle;">'.$rowassign['std_regno'].'</td>
	<td style="vertical-align:middle;">'.$rowassign['caption'].'</td>
	<td style="text-align:center; width:80px;vertical-align:middle;">'.date("d/m/Y", strtotime($rowassign['date_end'])).'</td>
	<td style="text-align:center; width:100px;vertical-align:middle;">'.date("d/m/Y", strtotime($rowassign['submit_date'])).'</td>
	<td style="text-align:center; width:50px;vertical-align:middle;">'.$rowassign['marks'].' </td>
	<td style="width:50px; text-align:center;vertical-align:middle;">'.$filedownload.$ismidterm.' 
		
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