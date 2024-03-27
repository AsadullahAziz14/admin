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
			<span class="pull-left"><h3  style="font-weight:700;">Mid Term Award List</h3></span>
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

//--------------------------------------
if(isset($_POST['submit_marks'])) { 
//------------------------------------------------
if(empty($_POST['id_setup'])) { 

	$sqllms = $dblms->querylms("INSERT INTO ".MIDTERM." (
															status										,
															id_dept										, 
															id_prg										, 
															section										, 
															semester									, 
															id_curs										, 
															dated										, 
															exam_date									,
															academic_session							, 
															id_campus									,
															id_added									,
															date_added
														)
												VALUES (
															'1'											, 
															'".cleanvars($_POST['id_dept'])."'			, 
															'".cleanvars($_POST['id_prg'])."'			, 
															'".cleanvars($_POST['section'])."'			, 
															'".cleanvars($_POST['semester'])."'			, 
															'".cleanvars($_POST['id_curs'])."'			, 
															'2017-07-29'								, 
															'2017-07-15'								, 
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'	,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'		,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'			, 
															NOW()			
														)
							");

//--------------------------------------
if($sqllms) {
$idsetup = $dblms->lastestid();
//--------------------------------------
	$arraychecked = $_POST['id_std'];
//--------------------------------------
	for($ichk=1; $ichk<=sizeof($arraychecked); $ichk++){
//------------------------------------------------
			$sqllmsmulti  = $dblms->querylms("INSERT INTO ".MIDTERM_DETAILS."( 
																				id_midterm									,
																				id_std										, 
																				marks										,
																				attendance								
																			)
	   																VALUES (
																				'".$idsetup."'									, 
																				'".cleanvars($_POST['id_std'][$ichk])."'		, 
																				'".cleanvars($_POST['marks'][$ichk])."'			,
																				'".cleanvars($_POST['marks'][$ichk])."'	
																			)
										");
		}
//------------------------------------------------
	echo '<div id="infoupdated" class="alert-box success"><span>success: </span>Record added successfully.</div>';
//------------------------------------------------
}
//--------------------------------------
} else { 
//--------------------------------------
	$sqllms  = $dblms->querylms("UPDATE ".MIDTERM." SET status		= '2'
													, id_dept		= '".cleanvars($_POST['id_dept'])."' 
													, id_prg		= '".cleanvars($_POST['id_prg'])."' 
													, section		= '".cleanvars($_POST['section'])."' 
													, semester		= '".cleanvars($_POST['semester'])."' 
													, id_curs		= '".cleanvars($_POST['id_curs'])."' 
													, dated			= '".date("Y-m-d")."' 
													, exam_date		= '".date("Y-m-d")."' 
													, id_modify		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' 
													, date_modify	= NOW() 
												WHERE id			= '".cleanvars($_POST['id_setup'])."'");

//--------------------------------------
if($sqllms) {
//--------------------------------------
	$sqllmsdelte  = $dblms->querylms("DELETE FROM ".MIDTERM_DETAILS." WHERE id_midterm = '".$_POST['id_setup']."'");
//--------------------------------------
	$arraychecked = $_POST['id_std'];
//--------------------------------------
	for($ichk=1; $ichk<=sizeof($arraychecked); $ichk++){
//------------------------------------------------
			$sqllmsmulti  = $dblms->querylms("INSERT INTO ".MIDTERM_DETAILS."( 
																				id_midterm									,
																				id_std										, 
																				marks										,
																				attendance									
																			)
	   																VALUES (
																				'".$_POST['id_setup']."'					, 
																				'".cleanvars($_POST['id_std'][$ichk])."'	, 
																				'".cleanvars($_POST['marks'][$ichk])."'		,
																				'".cleanvars($_POST['attendance'][$ichk])."'	
																			)
										");
		}
//------------------------------------------------
	echo '<div id="infoupdated" class="alert-box success"><span>success: </span>Record Update successfully.</div>';
//------------------------------------------------
}
//--------------------------------------
}
//--------------------------------------
}
//--------------------------------------
	$sqllmsstds  = $dblms->querylms("SELECT std.std_id, std.std_rollno, std.std_regno, std.std_section, std.std_photo, std.std_name, std.std_session,  
											prg.prg_id, prg.prg_name, dept.dept_id, dept.dept_name   
											FROM ".STUDENTS." std 
										  	INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
										  	INNER JOIN ".DEPTS." dept ON prg.id_dept = dept.dept_id 
										  	WHERE std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										  	AND std.id_prg = '".cleanvars($rowsurs['id_prg'])."' AND std.std_status = '2' 
										  	AND std.std_semester = '".cleanvars($rowsurs['semester'])."'
										  	ORDER BY std.std_rollno ASC, std.std_regno ASC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsstds)>0) {
//$valuecount1  = mysqli_fetch_array($sqllmsstds);
$srbk = 0;
//------------------------------------------------
while($rowcurstds = mysqli_fetch_array($sqllmsstds)) { 
//------------------------------------------------
	$sqllmschecker  = $dblms->querylms("SELECT d.id, d.marks, d.id_std, m.id_curs, m.id
												FROM ".MIDTERM_DETAILS." d 
												INNER JOIN ".MIDTERM." m ON m.id = d.id_midterm  
												WHERE d.id_std 	= '".cleanvars($rowcurstds['std_id'])."' 
												AND m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										  		AND m.id_prg 	= '".cleanvars($rowsurs['id_prg'])."' 
											  	AND m.semester 	= '".cleanvars($rowsurs['semester'])."' 
												AND m.id_curs 	= '".cleanvars($_GET['id'])."' LIMIT 1");
	$valuemarks 		= mysqli_fetch_array($sqllmschecker);
if($valuemarks['marks']) {
	$stdmarks = $valuemarks['marks'];
} else { 
	$stdmarks = '';
}
//--------------------------------------------
$srbk++;
if($srbk == 1) {
echo '
<div style="clear:both;"></div>
<form class="form-horizontal" action="#" method="post" id="addNewUsr" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="semester" id="semester" value="'.$rowsurs['semester'].'">
<input type="hidden" name="id_prg" id="id_prg" value="'.$rowsurs['id_prg'].'">
<input type="hidden" name="id_dept" id="id_dept" value="'.$rowcurstds['dept_id'].'">
<input type="hidden" name="section" id="section" value="'.$rowcurstds['std_section'].'">
<input type="hidden" name="id_curs" id="id_curs" value="'.$_GET['id'].'">

<p>
	Name of the Deparment: <span style="width:550px; display: inline-block; border-bottom:1px dashed #666;">'.$rowcurstds['dept_name'].'</span> 
</p>

<p style="margin-top:10px;">
	Class/Degree Program:  <span style="width:400px; display: inline-block; border-bottom:1px dashed #666;">'.$rowcurstds['prg_name'].'</span> 
	<span style="margin-left:10px;">Semester: </span>
	<span style="width:80px; display: inline-block; border-bottom:1px dashed #666; text-align:center;">'.$rowsurs['semester'].'</span> 
</p>


<p style="margin-top:10px;">
	Subject:  <span style="width:500px; display: inline-block; border-bottom:1px dashed #666;">'.$rowsurs['curs_code'].' - '.$rowsurs['curs_name'].'</span> 
	<span style="margin-left:5px;">Dated: </span>
	<span style="width:100px; display: inline-block; border-bottom:1px dashed #666;">2017-07-29</span> 
</p>

<p style="margin-top:10px;">
	Examination held in the month of <span style="width:500px; display: inline-block; border-bottom:1px dashed #666;">Augest</span> 
</p>

<div style="clear:both;"></div>
<div class="navbar-form navbar-right" style="font-weight:700; color:red; margin-right:10px; margin-top:0px;"> 
	Total Students: ('.number_format(mysqli_num_rows($sqllmsstds)).')
</div>
<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th style="font-weight:600;">Sr.#</th>
	<th style="font-weight:600;">Roll No</th>
	<th style="font-weight:600;">Reg #</th>
	<th width="35px" style="font-weight:600;">Pic</th>
	<th style="font-weight:600;">Student Name</th>
	<th style="font-weight:600; text-align:center;">Marks</th>
	<th style="font-weight:600; text-align:center;">Status</th>
</tr>
</thead>
<tbody>';
}
//------------------------------------------------
if($rowcurstds['std_photo']) { 
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$rowcurstds['std_photo'].'" alt="'.$rowcurstds['std_name'].'"/>';
} else {
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$rowcurstds['std_name'].'"/>';
}
//------------------------------------------------
echo '
<tr>
	<td style="width:40px;">'.$srbk.'</td>
	<td style="width:60px; text-align:center;">'.$rowcurstds['std_rollno'].'</td>
	<td style="width:150px;">'.$rowcurstds['std_regno'].'</td>
	<td>'.$stdphoto.'</td>
	<td><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$rowcurstds['std_name'].' ('.$rowcurstds['std_session'].')</b>" data-src="studentdetail.php?std_id='.$rowcurstds['std_id'].'" href="#">'.$rowcurstds['std_name'].'</a> </td>
	<td style="width:90px;"><input type="number" class="form-control col-lg-12" min="0" max="25" id="marks['.$srbk.']" name="marks['.$srbk.']" tabindex="'.$srbk.'" value="'.$stdmarks.'" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"></td>
	<td style="width:150px;"><input name="attendance['.$srbk.']" type="radio" id="attendance['.$srbk.']" checked="checked" value="1" class="checkbox-inline"> Present <input name="attendance['.$srbk.']" value="2" type="radio" id="attendance['.$srbk.']" class="checkbox-inline"> Absent</td>
	
	

</tr>
<input type="hidden" name="id_std['.$srbk.']" id="id_std['.$srbk.']" value="'.$rowcurstds['std_id'].'">
<input type="hidden" name="id_setup" id="id_setup" value="'.$valuemarks['id'].'">';
//------------------------------------------------
}
//------------------------------------------------
echo '
</tbody>
</table>
<div class="modal-footer">
	<input class="btn btn-primary" type="submit" value="Submit Marks" id="submit_marks" name="submit_marks">
</div>

</form>';
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
</div>
<script>
	evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script> '; 

?>