<?php 
//--------------------------------------
	include_once("query.php");
//--------------------------------------
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-12">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">';
//--------------------------------------
	$datetime 	= date('Y-m-d H');
	$activedate = "2018-09-11 17";
//--------------------------------------------
	$disable = "";	
	$style = ' ';
//--------------------------------------
echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Final Term Award List</h3></span>
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

if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
} 
//--------------------------------------
	$sqllmsstds  = $dblms->querylms("SELECT *      
										FROM ".SUMMER_COURSES." ca  
										INNER JOIN ".SUMMER_REGISTRATION." c ON c.id = ca.id_setup  
										INNER JOIN ".STUDENTS." s ON s.std_id = c.id_std  
										INNER JOIN ".PROGRAMS." p ON p.prg_id = c.id_prg  
										WHERE c.id_campus	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
										AND ca.id_curs = '".cleanvars($_GET['id'])."' 
										AND c.academic_session = '".ARCHIVE_SESS."' 
										GROUP BY c.id_std  ORDER BY s.std_session ASC, s.std_rollno ASC, s.std_regno ASC");
	$countstudents = 0;
	while($rowcurstds = mysqli_fetch_array($sqllmsstds)) { 
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
												 fd.midterm, fd.finalterm, fd.gradepoint, fd.lettergrade, fd.remarks, f.exam_date, 
												 f.forward_to, f.section  
												FROM ".SUMMER_FINALTERM_DETAILS." fd 
												INNER JOIN ".SUMMER_FINAL." f ON f.id = fd.id_finalterm  
												WHERE fd.id_std 	= '".cleanvars($itemstd['std_id'])."' 
												AND f.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										  		AND f.id_teacher = '".cleanvars($rowsurs['id_teacher'])."'
												AND f.id_curs 	= '".cleanvars($_GET['id'])."'  
												AND f.academic_session = '".ARCHIVE_SESS."'
												AND f.theory_practical 	= '1'   LIMIT 1");
	$valfinalterm 	= mysqli_fetch_array($sqllmsfinalterm);
if($valfinalterm['id_finalterm']) { 
	$printaward = '<div style="float:right;"><a class="btn btn-mid btn-info" href="summerfinaltermawardprint.php?id='.$valfinalterm['id_finalterm'].'" target="_blank"><i class="icon-print"></i> Print Sheet</a></div>';
} else { 
	$printaward = '';
}
//----------------------------------------------------
if($valfinalterm['finalterm']) 		{ $stdfinalmarks 	= $valfinalterm['finalterm']; 		} else {  $stdfinalmarks 	= ''; }
//----------------------------------------------------
if($valfinalterm['midterm']) 		{ $stdmidmarks 		= $valfinalterm['midterm']; 		} else {  $stdmidmarks 		= ''; }
//----------------------------------------------------
if($valfinalterm['assignment']) 	{ $stdassignment 	= $valfinalterm['assignment']; 		} else {  $stdassignment 	= ''; }
//----------------------------------------------------
if($valfinalterm['quiz']) 			{ $stdquiz 			= $valfinalterm['quiz']; 			} else {  $stdquiz 			= ''; }
//----------------------------------------------------
if($valfinalterm['attendance']) 	{ $stdattendance 	= $valfinalterm['attendance']; 		} else {  $stdattendance 	= ''; }
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
	<span class="req" style="font-weight:600;">Examination Date</span> <input class="pickadate" name="exam_date" id="exam_date" type="text" value="'.$examdate.'" required autocomplete="off" class="form-control" '.$disable.'> 
	<span style="margin-right:20px; float:right; font-weight:600;"> Forward to :
		<select id="forward_to" name="forward_to" style="width:150px;"  autocomplete="off" '.$disable.'>
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
	<th style="font-weight:600; font-size:11px; text-align:center;">Assignment (10)</th>
	<th style="font-weight:600; font-size:11px; text-align:center;">Quiz/pres (10)</th>
	<th style="font-weight:600; font-size:11px; text-align:center;">Attendance (5)</th>
	<th style="font-weight:600; font-size:11px; text-align:center;">Mid Term 25%</th>
	<th style="font-weight:600; font-size:11px; text-align:center;">Final Term 50%</th>
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
	<td style="width:70px;"><input type="number" class="form-control col-lg-12 jQinv_item_assign" min="0" max="10" id="assignment['.$srbk.']" name="assignment['.$srbk.']" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;"  value="'.$stdassignment.'"  '.$disable.'></td>
	<td style="width:70px;"><input type="number" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" class="form-control col-lg-12 jQinv_item_quiz" min="0" max="10" id="quiz['.$srbk.']" name="quiz['.$srbk.']" required autocomplete="off" style="text-align:center;" value="'.$stdquiz.'" '.$disable.'></td>
	<td style="width:70px;"><input type="number" class="form-control col-lg-12 jQinv_item_attendance" min="0" max="5" id="attendance['.$srbk.']" name="attendance['.$srbk.']" autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;" value="'.$stdattendance.'"  ></td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_midterm" min="1" max="25" id="midterm['.$srbk.']" name="midterm['.$srbk.']" style="text-align:center;" value="'.$stdmidmarks.'"></td>
	<td style="width:90px;"><input type="number" class="form-control col-lg-12 jQinv_item_finalterm" min="0" max="50" id="finalterm['.$srbk.']" name="finalterm['.$srbk.']" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;" value="'.$stdfinalmarks.'" '.$disable.'></td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_obtained" min="1" max="25" id=marks_obtained['.$srbk.']" name="marks_obtained['.$srbk.']" readonly style="text-align:center;" value="'.$stdmarksobtained.'"></td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_numerical" min="1" max="25" id="numerical['.$srbk.']" name="numerical['.$srbk.']" readonly style="text-align:center;" value="'.$stdnumerical.'"></td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_credithour" id="credithour['.$srbk.']" name="credithour['.$srbk.']" readonly style="text-align:center;" value="'.$rowsurs['cur_credithours_theory'].'"></td>
	<td style="width:60px;"><input type="text" class="form-control col-lg-12 jQinv_item_gradepoint" id="gradepoint['.$srbk.']" name="gradepoint['.$srbk.']" readonly value="'.$stdgradepoint.'"></td>
	<td style="width:60px;"><input type="text" class="form-control col-lg-12 jQinv_item_lettergrade" id="lettergrade['.$srbk.']" name="lettergrade['.$srbk.']" readonly style="text-align:center;" value="'.$stdlettergrade.'"></td>
	<td style="width:90px;"><input type="text" class="form-control col-lg-12 jQinv_item_remarks" id="remarks['.$srbk.']" name="remarks['.$srbk.']"  value="'.$stdremarks.'"  '.$disable.'></td>

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
<div class="modal-footer" '.$style.'>
	<button class="btn btn-success" type="submit" value="saveonly" id="submit_marks" name="submit_marks"> Save </button>
	<button class="btn btn-primary" type="submit" value="saveforward" id="submit_marks" name="submit_marks"> Save & Forward </button>
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