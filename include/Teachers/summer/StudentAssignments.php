<?php 
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>';
	$sql2 = '';
	$sqlstring	  = "";
	$srch	  	  = (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
	$idassignment	  = (isset($_GET['idassignment']) && $_GET['idassignment'] != '') ? $_GET['idassignment'] : '';
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
//--------------------------------------
if(isset($_POST['submit_stdassignment'])) { 
//------------------------------------------------
	$sqllmsstdassign  = $dblms->querylms("UPDATE ".COURSES_ASSIGNMENTS_STUDENTS." SET 
															marks			= '".cleanvars($_POST['obtain_marks'])."' 
														  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														  , date_modify		= NOW()
													  WHERE id				= '".cleanvars($_POST['assignid_edit'])."'");
//--------------------------------------
		if($sqllmsstdassign) {
			echo '<div id="infoupdated" class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		}
//--------------------------------------
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
				<input type="text" class="form-control" name="srch" placeholder="Name, Roll No etc" style="width:250px; " >
			</div>
			<div class="form-group">
			<select id="projects-list6" data-placeholder="Select Assignment" name="idassignment" style="width:200px; text-align:left !important;" >
			<option></option>';
			$sqllmsprgcats  = $dblms->querylms("SELECT id, status, id_curs, caption, detail, date_start, 
														date_end, total_marks, passing_marks, fileattach    
														FROM ".COURSES_ASSIGNMENTS." 
														WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
														AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
														AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
														AND id_curs = '".cleanvars($_GET['id'])."' ORDER BY id DESC");
			while($valueprgcats = mysqli_fetch_array($sqllmsprgcats)) {
				echo '<option value="'.$valueprgcats['id'].'">'.$valueprgcats['caption'].'</option>';
			}
echo '	</select>
	</div> 
	<button type="submit" class="btn btn-xl btn-primary">Search</button> 
<script>

    $("#projects-list6").select2({
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
	$sqllmsassign  = $dblms->querylms("SELECT std.std_id, std.std_name, std.std_regno, std.std_photo, std.std_session,assign.caption, 
										assign.date_start, assign.date_end, assign.total_marks, astd.marks, astd.id, 
										astd.submit_date, astd.student_file       
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
	<th style="font-weight:600;text-align:center; ">Sr.#</th>
	<th width="50px" style="font-weight:600;">Pic</th>
	<th style="font-weight:600;">Student Name</th>
	<th style="font-weight:600;">Reg. #</th>
	<th style="font-weight:600;text-align:center; ">Assignment</th>
	<th style="font-weight:600;text-align:center; ">Due Date</th>
	<th style="font-weight:600;text-align:center; ">Submit Date</th>
	<th style="font-weight:600;text-align:center; ">Marks</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
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

//------------------------------------------------
echo '
<tr>
	<td style="width:50px; text-align:center; vertical-align:middle;">'.$srbk.'</td>
	<td>'.$stdphoto.'</td>
	<td><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$rowassign['std_name'].' ('.$rowassign['std_session'].')</b>" data-src="studentdetail.php?std_id='.$rowassign['std_id'].'" href="#">'.$rowassign['std_name'].'</a></td>
	<td>'.$rowassign['std_regno'].'</td>
	<td>'.$rowassign['caption'].'</td>
	<td style="text-align:center; width:80px;">'.date("d/m/Y", strtotime($rowassign['date_end'])).'</td>
	<td style="text-align:center; width:100px;">'.date("d/m/Y", strtotime($rowassign['submit_date'])).'</td>
	<td style="text-align:center; width:90px;">'.$rowassign['marks'].' </td>
	<td style="width:50px; text-align:center;">'.$filedownload.' 
		<a class="btn btn-xs btn-info student-assignment-modal" data-toggle="modal" data-modal-window-title="'.$rowassign['caption'].'" data-height="350" data-width="100%" data-assignstdname="'.$rowassign['std_name'].'" data-assignstdregno="'.$rowassign['std_regno'].'" data-assignname="'.$rowassign['caption'].'" data-assignduedat="'.date("d/m/Y", strtotime($rowassign['date_end'])).'" data-assignsubmitdate="'.date("d/m/Y", strtotime($rowassign['submit_date'])).'" data-assigntotalmarks="'.$rowassign['total_marks'].'" data-assignobtainmarks="'.$rowassign['marks'].'" data-assignid="'.$rowassign['id'].'" data-target="#cursStudentAssignModal"><i class="icon-pencil"></i></a> 
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