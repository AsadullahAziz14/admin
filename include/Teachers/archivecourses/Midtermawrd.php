<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
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
if(isset($_GET['section'])) {  
	$section 		= $_GET['section'];
	$seccursquery 	= " AND at.section = '".$_GET['section']."'";
} else { 
	$section 		= '';
	$seccursquery 	= "";
}
//--------------------------------------
if(isset($_POST['submit_marks'])) { 

//------------------------------------------------
if(empty($_POST['id_setup'])) { 
	$sqllmschecker  = $dblms->querylms("SELECT * 
												FROM ".MIDTERM." m 
												WHERE m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND m.academic_session = '".ARCHIVE_SESS."' 
										  		AND m.id_prg 	= '".cleanvars($_GET['prgid'])."' 
												AND m.timing 	= '".cleanvars($_GET['timing'])."' 
											  	AND m.semester 	= '".cleanvars($_GET['semester'])."' 
												AND m.id_teacher 	= '".cleanvars($_POST['id_teacher'])."'
												AND m.section = '".cleanvars($section)."'
												AND m.id_curs 	= '".cleanvars($_POST['id_curs'])."' LIMIT 1");
	$valuemarks 		= mysqli_fetch_array($sqllmschecker);
if($valuemarks['id']) { 
	echo '<div class="alert-box warning"><span>warning: </span>Record already added.</div>';
} else {
	$sqllms = $dblms->querylms("INSERT INTO ".MIDTERM." (
															status										,
															forward_to									,
															id_curs										,
															section										, 
															semester									, 
															timing										, 
															id_prg										, 
															id_teacher									, 
															dated										, 
															exam_date									,
															academic_session							, 
															id_campus									,
															id_added									,
															date_added
														)
												VALUES (
															'1'											, 
															'".cleanvars($_POST['forward_to'])."'		, 
															'".cleanvars($_POST['id_curs'])."'			, 
															'".cleanvars($section)."'					, 
															'".cleanvars($_GET['semester'])."'			, 
															'".cleanvars($_GET['timing'])."'			, 
															'".cleanvars($_GET['prgid'])."'				, 
															'".cleanvars($_POST['id_teacher'])."'		, 
															'".date('Y-m-d')."'								, 
															'".date('Y-m-d', strtotime($_POST['exam_date']))."'				, 
															'".ARCHIVE_SESS."'	,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'		,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'			, 
															NOW()			
														)
							");

//--------------------------------------
if($sqllms) {
$idsetup = $dblms->lastestid();
//--------------------------------------
	$logremarks = 'Add Student Mid Term Award List #: '.$idsetup.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
//------------------------------------------------
		if($_POST['attendance'][$ichk] == 1) { 
			$marks = $_POST['marks'][$ichk];
		} else { 
			$marks = 0;
		}
//------------------------------------------------
			$sqllmsmulti  = $dblms->querylms("INSERT INTO ".MIDTERM_DETAILS."( 
																				id_midterm									,
																				id_dept										,
																				id_prg										,
																				section										,
																				semester									,
																				id_std										, 
																				marks										,
																				attendance								
																			)
	   																VALUES (
																				'".$idsetup."'									, 
																				'".cleanvars($_POST['id_dept'][$ichk])."'		,
																				'".cleanvars($_POST['id_prg'][$ichk])."'		,
																				'".cleanvars($_POST['section'][$ichk])."'		,
																				'".cleanvars($_POST['semester'][$ichk])."'		,
																				'".cleanvars($_POST['id_std'][$ichk])."'		, 
																				'".cleanvars($marks)."'							,
																				'".cleanvars($_POST['attendance'][$ichk])."'	
																			)
										");
		}
//------------------------------------------------
	echo '<div id="infoupdated" class="alert-box success"><span>success: </span>Record added successfully.</div>';
//------------------------------------------------
}
}
//--------------------------------------
} else { 
//--------------------------------------
	$sqllms  = $dblms->querylms("UPDATE ".MIDTERM." SET status		= '1'
													, forward_to	= '".cleanvars($_POST['forward_to'])."' 
													, id_curs		= '".cleanvars($_POST['id_curs'])."' 
													, section		= '".cleanvars($section)."'
													, semester		= '".cleanvars($_GET['semester'])."'
													, timing		= '".cleanvars($_GET['timing'])."'
													, dated			= '".date("Y-m-d")."' 
													, exam_date		= '".date('Y-m-d', strtotime($_POST['exam_date']))."' 
													, id_modify		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' 
													, date_modify	= NOW() 
												WHERE id			= '".cleanvars($_POST['id_setup'])."'");

//--------------------------------------
if($sqllms) {
//--------------------------------------
	$logremarks = 'Update Student Mid Term Award List #: '.$_POST['id_setup'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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

//--------------------------------------
	$sqllmsdelte  = $dblms->querylms("DELETE FROM ".MIDTERM_DETAILS." WHERE id_midterm = '".$_POST['id_setup']."'");
//--------------------------------------
	$arraychecked = $_POST['id_std'];
//--------------------------------------
	for($ichk=1; $ichk<=sizeof($arraychecked); $ichk++){
//------------------------------------------------
	if($_POST['attendance'][$ichk] == 1) { 
		$marks = $_POST['marks'][$ichk];
	} else { 
		$marks = 0;
	}
//------------------------------------------------
			$sqllmsmulti  = $dblms->querylms("INSERT INTO ".MIDTERM_DETAILS."( 
																				id_midterm									,
																				id_dept										, 
																				id_prg										, 
																				section										, 
																				semester									, 
																				id_std										, 
																				marks										,
																				attendance									
																			)
	   																VALUES (
																				'".$_POST['id_setup']."'					, 
																				'".cleanvars($_POST['id_dept'][$ichk])."'	, 
																				'".cleanvars($_POST['id_prg'][$ichk])."'	, 
																				'".cleanvars($_POST['section'][$ichk])."'	, 
																				'".cleanvars($_POST['semester'][$ichk])."'	, 
																				'".cleanvars($_POST['id_std'][$ichk])."'	, 
																				'".cleanvars($marks)."'						,
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

//--------------------------------------------------	
$sqllmsstdcurs  = $dblms->querylms("SELECT  DISTINCT(d.id_curs), t.section, t.id_prg, t.timing,  t.semester    
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										INNER JOIN ".COURSES." c ON c.curs_id = d.id_curs  
										INNER JOIN ".EMPLYS." e ON e.emply_id = d.id_teacher   
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.academic_session = '".ARCHIVE_SESS."' 
										AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' AND t.timing = '".cleanvars($_GET['timing'])."' 
										AND t.status = '1' AND t.id_prg = '".cleanvars($_GET['prgid'])."' 
										AND t.semester = '".cleanvars($_GET['semester'])."' $sqlsection  
										AND d.id_curs = '".cleanvars($_GET['id'])."'  ORDER BY t.session ASC");
$cursstudents = array();
$countstudents = 0;
//--------------------------------------------------
while($rowtsurs = mysqli_fetch_array($sqllmsstdcurs)) {
if($rowtsurs['section']) {
	$stdsection 	= " AND std.std_section =  '".cleanvars($rowtsurs['section'])."'"; 
} else { 
	$stdsection 	= " "; 
}
//--------------------------------------------------
	$sqllmsstds  = $dblms->querylms("SELECT *   
											FROM ".STUDENTS." std 
											INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
											WHERE (std.std_status = '2' OR std.std_status = '7') AND std.std_struckoffresticate != '1' 
											AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND std.id_prg = '".cleanvars($rowtsurs['id_prg'])."' 
											AND std.std_timing = '".cleanvars($rowtsurs['timing'])."'
											AND std.std_semester = '".cleanvars($rowtsurs['semester'])."' $stdsection 
											ORDER BY std.std_rollno ASC, std.std_regno ASC");
	while($rowcurstds = mysqli_fetch_assoc($sqllmsstds)) { 
		$cursstudents[] = $rowcurstds;
		$countstudents++;
	}
}

//--------------------------------------------------
if ($countstudents>0) {
//$valuecount1  = mysqli_fetch_array($sqllmsstds);
$srbk = 0;
//------------------------------------------------
foreach($cursstudents as $itemstd) { 
//------------------------------------------------
$srbk++;
	$sqllmschecker  = $dblms->querylms("SELECT * 
												FROM ".MIDTERM_DETAILS." d 
												INNER JOIN ".MIDTERM." m ON m.id = d.id_midterm  
												WHERE d.id_std 	= '".cleanvars($itemstd['std_id'])."' 
												AND m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND m.academic_session = '".ARCHIVE_SESS."' 
										  		AND m.id_prg 	= '".cleanvars($_GET['prgid'])."' 
												AND m.timing 	= '".cleanvars($_GET['timing'])."' 
											  	AND d.semester 	= '".cleanvars($_GET['semester'])."' 
												AND m.id_curs 	= '".cleanvars($_GET['id'])."' LIMIT 1");
	$valuemarks 		= mysqli_fetch_array($sqllmschecker);
if($valuemarks['id_midterm']) {
	$printaward = '<a class="btn btn-mid btn-info" href="midtermawardprint.php?id='.$valuemarks['id'].'" target="_blank"><i class="icon-print"></i> Print Sheet</a>';
	$examdisabled = 'disabled';
	$marksdisabled = 'readonly';
	$submitdisabled = 'display:none;';
} else {
	$printaward = ' ';
	$examdisabled = '';
	$marksdisabled = '';
	$submitdisabled = '';
}
if($valuemarks['marks']) {
	$stdmarks = $valuemarks['marks'];
} else { 
	$stdmarks = '';
}

if($valuemarks['exam_date'] != '0000-00-00') {
	$exmdate = $valuemarks['exam_date'];
} else { 
	$exmdate = '';
}
//--------------------------------------------
if($valuemarks['attendance'] == 1) { 
	$attendance = '<input name="attendance['.$srbk.']" type="radio" id="attendance['.$srbk.']" checked="checked" value="1" class="checkbox-inline"> Present <input name="attendance['.$srbk.']" value="2" type="radio" id="attendance['.$srbk.']" class="checkbox-inline"> Absent';
} else if($valuemarks['attendance'] == 2) { 
	$attendance = '<input name="attendance['.$srbk.']" type="radio" id="attendance['.$srbk.']" value="1" class="checkbox-inline"> Present <input name="attendance['.$srbk.']"  checked="checked" value="2" type="radio" id="attendance['.$srbk.']" class="checkbox-inline"> Absent';
} else { 
	$attendance = '<input name="attendance['.$srbk.']" type="radio" id="attendance['.$srbk.']" checked="checked" value="1" class="checkbox-inline"> Present <input name="attendance['.$srbk.']" value="2" type="radio" id="attendance['.$srbk.']" class="checkbox-inline"> Absent';
} 
//--------------------------------------------
if($srbk == 1) {
echo '
<div style="clear:both;"></div>
<form class="form-horizontal" action="#" method="post" id="addNewUsr" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="id_curs" id="id_curs" value="'.$_GET['id'].'">
<input type="hidden" name="stdsection" id="stdsection" value="'.$rowsurs['section'].'">
<input type="hidden" name="stdsemester" id="stdsemester" value="'.$itemstd['std_semester'].'">
<input type="hidden" name="stdtiming" id="stdtiming" value="'.$itemstd['std_timing'].'">
<div style="margin-top:10px;">
	Subject:  <span style="width:80%; display: inline-block; border-bottom:1px dashed #666;">'.$rowsurs['curs_code'].' - '.$rowsurs['curs_name'].'</span> 
</div>
<div style="clear:both;"></div>
<div style="margin-top:10px;">
	<span class="req" style="font-weight:600;">Examination Date</span> <input name="exam_date" id="exam_date" type="date" value="'.$exmdate.'" required autocomplete="off" '.$examdisabled.'> 
	<span style="margin-left:250px;font-weight:600;"> Forward to :
		<select id="forward_to" name="forward_to" style="width:150px;"  autocomplete="off">
				<option value="">Select Forward</option>';
				if($valuemarks['forward_to'] == 4) {
					echo '<option value="4" selected>HODs / Dean </option>';
				} else {
					echo '<option value="4">HODs / Dean </option>';
				}
echo '
			</select>
	</span>
</div>

<div style="clear:both;"></div>
<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;"> 
	Total Students: ('.number_format($countstudents).') '.$printaward.' 
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
if($itemstd['std_photo']) { 
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$itemstd['std_photo'].'" alt="'.$itemstd['std_name'].'"/>';
} else {
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$itemstd['std_name'].'"/>';
}
//------------------------------------------------
echo '
<tr>
	<td style="width:40px;">'.$srbk.'</td>
	<td style="width:60px; text-align:center;">'.$itemstd['std_rollno'].'</td>
	<td style="width:150px;">'.$itemstd['std_regno'].'</td>
	<td>'.$stdphoto.'</td>
	<td><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$itemstd['std_name'].' ('.$itemstd['std_session'].')</b>" data-src="studentdetail.php?std_id='.$itemstd['std_id'].'" href="#">'.$itemstd['std_name'].'</a> </td>
	<td style="width:90px;"><input type="number" class="form-control col-lg-12" min="0" max="25" id="marks['.$srbk.']" name="marks['.$srbk.']" tabindex="'.$srbk.'" value="'.$valuemarks['marks'].'" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;" '.$marksdisabled.'></td>
	<td style="width:150px;">'.$attendance.'</td>
</tr>
<input type="hidden" name="id_std['.$srbk.']" id="id_std['.$srbk.']" value="'.$itemstd['std_id'].'">
<input type="hidden" name="id_setup" id="id_setup" value="'.$valuemarks['id'].'">
<input type="hidden" name="id_teacher" id="id_teacher" value="'.$rowsurs['id_teacher'].'">
<input type="hidden" name="semester['.$srbk.']" id="semester['.$srbk.']" value="'.$itemstd['std_semester'].'">
<input type="hidden" name="id_prg['.$srbk.']" id="id_prg['.$srbk.']" value="'.$itemstd['prg_id'].'">
<input type="hidden" name="id_dept['.$srbk.']" id="id_dept['.$srbk.']" value="'.$itemstd['id_dept'].'">
<input type="hidden" name="section['.$srbk.']" id="section['.$srbk.']" value="'.$itemstd['std_section'].'">';
//------------------------------------------------
}
//------------------------------------------------
echo '
</tbody>
</table>
<div class="modal-footer" style="'.$submitdisabled .'">
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
</script> 
<script>
    $("#forward_to").select2({
        allowClear: true
    });
	
</script>'; 

?>