<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-12">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">';
//--------------------------------------

echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Practical Award List</h3></span> 
			<span class="pull-right"><a class="btn btn-success" href="summer.php?id='.$_GET['id'].'"> Back to Course </a></span>
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
$sqllmschecker  = $dblms->querylms("SELECT * 
												FROM ".SUMMER_FINAL." m 
												WHERE m.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND m.id_teacher 	= '".cleanvars($_POST['id_teacher'])."'
												AND m.theory_practical = '2'
												AND m.id_curs 	= '".cleanvars($_POST['id_curs'])."' 
												AND m.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' LIMIT 1");
	$valuemarks 		= mysqli_fetch_array($sqllmschecker);
if($valuemarks['id']) { 
	echo '<div class="alert-box warning"><span>warning: </span>Record already added.</div>';
} else {
	$sqllms = $dblms->querylms("INSERT INTO ".SUMMER_FINAL." (
															status										,
															forward_to									, 
															id_curs										,
															theory_practical							, 
															timing										,
															id_teacher									, 
															dated										, 
															exam_date									, 
															academic_session							,
															id_campus									,
															id_added									,
															date_added
														)
												VALUES (
															'2'											, 
															'".cleanvars($_POST['forward_to'])."'		, 
															'".cleanvars($_POST['id_curs'])."'			, 
															'2'											, 
															'".cleanvars($_GET['timing'])."'			, 
															'".cleanvars($_POST['id_teacher'])."'		, 
															'".date("Y-m-d")."'							, 
															'".date('Y-m-d', strtotime($_POST['exam_date']))."'				, 
															'".ARCHIVE_SESS."'							,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'	,
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
															NOW()			
														)
							");

//--------------------------------------
if($sqllms) {
$idsetup = $dblms->lastestid();
//--------------------------------------
	$logremarks = 'Add Student Summer Practical Award List #: '.$idsetup.' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			$sqllmsmulti  = $dblms->querylms("INSERT INTO ".SUMMER_FINALTERM_DETAILS."( 
																				id_finalterm									,
																				id_std											, 
																				marks_obtained									, 
																				numerical										, 
																				credithour										, 
																				gradepoint										, 
																				lettergrade										, 
																				remarks										
																			)
	   																VALUES (
																				'".$idsetup."'										, 
																				'".cleanvars($_POST['id_std'][$ichk])."'			, 
																				'".cleanvars($_POST['marks_obtained'][$ichk])."'	, 
																				'".cleanvars($_POST['numerical'][$ichk])."'			, 
																				'".cleanvars($_POST['credithour'][$ichk])."'		, 
																				'".cleanvars($_POST['gradepoint'][$ichk])."'		, 
																				'".cleanvars($_POST['lettergrade'][$ichk])."'		, 
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
} else if($_POST['id_setup']) { 
//--------------------------------------
	$sqllms  = $dblms->querylms("UPDATE ".SUMMER_FINAL." SET status	= '2'
													, forward_to	= '".cleanvars($_POST['forward_to'])."' 
													, id_curs		= '".cleanvars($_POST['id_curs'])."' 
													, theory_practical	= '2' 
													, dated			= '".date("Y-m-d")."' 
													, exam_date		= '".date('Y-m-d', strtotime($_POST['exam_date']))."' 
													, id_modify		= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' 
													, date_modify	= NOW() 
												WHERE id			= '".cleanvars($_POST['id_setup'])."'");

//--------------------------------------
if($sqllms) {
//--------------------------------------
	$logremarks = 'Update Student Summer Practical  Award List #: '.$_POST['id_setup'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
//	$sqllmsdelte  = $dblms->querylms("DELETE FROM ".FINALTERM_DETAILS." WHERE id_finalterm = '".$_POST['id_setup']."'");
//--------------------------------------
	$arraychecked = $_POST['id_std'];
//--------------------------------------
	for($ichk=1; $ichk<=sizeof($arraychecked); $ichk++){
//------------------------------------------------
if(!empty($_POST['id_edit'][$ichk])) {
//------------------------------------------------
				$sqllmsmulti  = $dblms->querylms("UPDATE ".FINALTERM_DETAILS." SET 
													, marks_obtained	= '".cleanvars($_POST['marks_obtained'][$ichk])."' 
													, numerical			= '".cleanvars($_POST['numerical'][$ichk])."' 
													, credithour		= '".cleanvars($_POST['credithour'][$ichk])."' 
													, gradepoint		= '".cleanvars($_POST['gradepoint'][$ichk])."' 
													, lettergrade		= '".cleanvars($_POST['lettergrade'][$ichk])."' 
													, remarks			= '".cleanvars($_POST['remarks'][$ichk])."' 	
												WHERE id				= '".cleanvars($_POST['id_edit'][$ichk])."' 
													AND id_finalterm 	= '".cleanvars($_POST['id_setup'])."'
													AND id_std 			= '".cleanvars($_POST['id_std'][$ichk])."'"); 			
} else { 
	$sqllmsmulti  = $dblms->querylms("INSERT INTO ".SUMMER_FINALTERM_DETAILS."( 
																				id_finalterm									,
																				id_std											, 
																				marks_obtained									, 
																				numerical										, 
																				credithour										, 
																				gradepoint										, 
																				lettergrade										, 
																				remarks										
																			)
	   																VALUES (
																				'".$_POST['id_setup']."'							, 
																				'".cleanvars($_POST['id_std'][$ichk])."'			, 
																				'".cleanvars($_POST['marks_obtained'][$ichk])."'	, 
																				'".cleanvars($_POST['numerical'][$ichk])."'			, 
																				'".cleanvars($_POST['credithour'][$ichk])."'		, 
																				'".cleanvars($_POST['gradepoint'][$ichk])."'		, 
																				'".cleanvars($_POST['lettergrade'][$ichk])."'		, 
																				'".cleanvars($_POST['remarks'][$ichk])."'	
																			)
										");

}
//------------------------------------------------
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
//--------------------------------------------------
	$countstudents = 0;
	$sqllmsstds  = $dblms->querylms("SELECT *      
										FROM ".SUMMER_COURSES." ca  
										INNER JOIN ".SUMMER_REGISTRATION." c ON c.id = ca.id_setup  
										INNER JOIN ".STUDENTS." s ON s.std_id = c.id_std  
										INNER JOIN ".PROGRAMS." p ON p.prg_id = c.id_prg  
										WHERE c.id_campus	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
										AND ca.id_curs = '".cleanvars($_GET['id'])."' 
										AND c.academic_session = '".ARCHIVE_SESS."' 
										ORDER BY s.std_session ASC, s.std_rollno ASC, s.std_regno ASC");
	while($rowcurstds = mysqli_fetch_assoc($sqllmsstds)) { 
		$cursstudents[] = $rowcurstds;
		$countstudents++;
	}

//--------------------------------------------------
if ($countstudents>0) {
//------------------------------------------------
$srbk = 0;
//------------------------------------------------
foreach($cursstudents as $itemstd) { 
//------------------------------------------------
	$sqllmsfinalterm  = $dblms->querylms("SELECT fd.id, fd.id_finalterm, fd.assignment, fd.quiz, fd.attendance, fd.marks_obtained, fd.numerical, 
												 fd.finalterm, fd.gradepoint, fd.lettergrade, fd.remarks, f.exam_date, f.forward_to, f.section  
												FROM ".SUMMER_FINALTERM_DETAILS." fd 
												INNER JOIN ".SUMMER_FINAL." f ON f.id = fd.id_finalterm  
												WHERE fd.id_std 	= '".cleanvars($itemstd['std_id'])."' 
												AND f.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND f.id_teacher = '".cleanvars($rowsurs['id_teacher'])."'
												AND f.id_curs 	= '".cleanvars($_GET['id'])."' 
												AND f.theory_practical 	= '2' LIMIT 1");
	$valfinalterm 	= mysqli_fetch_array($sqllmsfinalterm);
if($valfinalterm['id_finalterm']) { 
	$printaward = '<div style="float:right;"><a class="btn btn-mid btn-info" href="summerfinaltermawardprint.php?id='.$valfinalterm['id_finalterm'].'" target="_blank"><i class="icon-print"></i> Print Sheet</a></div>';
} else { 
	$printaward = '';
}
//----------------------------------------------------
if($valfinalterm['marks_obtained']) { $stdmarksobtained = $valfinalterm['marks_obtained']; 	} else {  $stdmarksobtained = ''; }
//----------------------------------------------------
if($valfinalterm['numerical']) 		{ $stdnumerical 	= $valfinalterm['numerical']; 		} else {  $stdnumerical 	= ''; }
//----------------------------------------------------
if($valfinalterm['gradepoint']) 	{ $stdgradepoint 	= $valfinalterm['gradepoint']; 		} else {  $stdgradepoint 	= ''; }
//----------------------------------------------------
if($valfinalterm['lettergrade']) 	{ $stdlettergrade 	= $valfinalterm['lettergrade']; 	} else {  $stdlettergrade 	= ''; }
//----------------------------------------------------
if($valfinalterm['remarks']) 		{ $stdremarks 		= $valfinalterm['remarks']; 		} else {  $stdremarks 		= ''; }
//----------------------------------------------------
if($valfinalterm['exam_date']) 		{ $examdate 		= $valfinalterm['exam_date']; 		} else {  $examdate 		= ''; }
//--------------------------------------------
$srbk++;
if($srbk == 1) {
echo '

<div style="clear:both;"></div>
<form class="form-horizontal" action="#" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="id_curs" id="id_curs" value="'.$_GET['id'].'">
<input type="hidden" name="id_setup" id="id_setup" value="'.$valfinalterm['id_finalterm'].'">
<input type="hidden" name="id_teacher" id="id_teacher" value="'.$rowsurs['id_teacher'].'">
<div style="margin-top:10px;">
	Subject:  <span style="width:80%; display: inline-block; border-bottom:1px dashed #666;">'.$rowsurs['curs_code'].' - '.$rowsurs['curs_name'].'</span> 
</div>
<div style="clear:both;"></div>
<div style="margin-top:10px;">
	<span class="req" style="font-weight:600;">Practical Date</span> <input class="pickadate" name="exam_date" id="exam_date" type="text" value="'.$examdate.'" required autocomplete="off" class="form-control" tabindex="'.$srbk.'"> 
	<span style="margin-right:20px; float:right; font-weight:600;"> Forward to :
		<select id="forward_to" name="forward_to" style="width:150px;"  autocomplete="off">
				<option value="">Select Forward</option>';
				if($valfinalterm['forward_to'] == 4) {
					echo '<option value="4" selected>HODs / Dean </option>';
				} else {
					echo '<option value="4">HODs / Dean </option>';
				}
echo '
			</select>
	</span>
</div>

<div style="clear:both;"></div>
<br>
'.$printaward.'
<div style="clear:both;"></div>

<table class="table table-bordered table-with-avatar invE_table">
<thead>
<tr>
	<th style="font-weight:600; font-size:11px; vertical-align:middle;">Sr.# </th>
	<th style="font-weight:600; font-size:11px;vertical-align:middle;">Roll #</th>
	<th width="35px" style="font-weight:600; font-size:11px;vertical-align:middle;">Pic</th>
	<th style="font-weight:600; font-size:11px;vertical-align:middle;">Student Name</th>
	<th style="font-weight:600; font-size:11px; text-align:center;">Marks Obtained</th>
	<th style="font-weight:600; font-size:11px; text-align:center;">Numerical Point (A)</th>
	<th style="font-weight:600; font-size:11px; text-align:center;">Credit Hours (B)</th>
	<th style="font-weight:600; font-size:11px; text-align:center;">Grade Points(AxB)</th>
	<th style="font-weight:600; font-size:11px; text-align:center;">Letter Grade</th>
	<th style="font-weight:600; font-size:11px; text-align:center;vertical-align:middle;">Remarks</th>
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
<tr class="inv_row">
	<td style="width:40px;">'.$srbk.'</td>
	<td style="width:50px; text-align:center;">'.$itemstd['std_rollno'].'</td>
	<td>'.$stdphoto.'</td>
	<td><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$rowcurstds['std_name'].' ('.$itemstd['std_session'].')</b>" data-src="studentdetail.php?std_id='.$itemstd['std_id'].'" href="#">'.$itemstd['std_name'].'</a> </td>
	<td style="width:100px;"><input type="number" class="form-control col-lg-12 jQinv_item_obtained" min="0" max="100" id="marks_obtained['.$srbk.']" name="marks_obtained['.$srbk.']" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;" value="'.$stdmarksobtained.'" tabindex="'.$srbk.'"></td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_numerical" min="1" max="25" id="numerical['.$srbk.']" name="numerical['.$srbk.']" readonly style="text-align:center;" value="'.$stdnumerical.'"></td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_credithour" id="credithour['.$srbk.']" name="credithour['.$srbk.']" readonly style="text-align:center;" value="'.$rowsurs['cur_credithours_practical'].'"></td>
	<td style="width:60px;"><input type="text" class="form-control col-lg-12 jQinv_item_gradepoint" id="gradepoint['.$srbk.']" name="gradepoint['.$srbk.']" readonly value="'.$stdgradepoint.'"></td>
	<td style="width:60px;"><input type="text" class="form-control col-lg-12 jQinv_item_lettergrade" id="lettergrade['.$srbk.']" name="lettergrade['.$srbk.']" readonly style="text-align:center;" value="'.$stdlettergrade.'"></td>
	<td style="width:90px;"><input type="text" class="form-control col-lg-12 jQinv_item_remarks" id="remarks['.$srbk.']" name="remarks['.$srbk.']"  value="'.$stdremarks.'" ></td>

</tr>
<input type="hidden" name="id_std['.$srbk.']" id="id_std['.$srbk.']" value="'.$itemstd['std_id'].'">
<input type="hidden" name="id_edit['.$srbk.']" id="id_edit['.$srbk.']" value="'.$valfinalterm['id'].'">';
//------------------------------------------------
}
//------------------------------------------------
echo '
</tbody>
<tr class="last_row">
	<td colspan="20" style="text-align:right;">
</tr>
</table>
<div class="modal-footer">
	<input class="btn btn-primary" type="submit" value="Submit Marks" id="submit_marks" name="submit_marks"  tabindex="'.($srbk+1).'">
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