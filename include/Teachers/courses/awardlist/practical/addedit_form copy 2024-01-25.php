<?php 
if(isset($_GET['prgid'])) {  

	$AddProgramSemesterSQL = '';
	if(($_GET['prgid'] !='la')) { 

		$AddProgramSemesterSQL = "AND (FIND_IN_SET('".$_GET['prgid']."', programs) OR programs LIKE'%all%')";

	} 
	
	$sqllmsfeecats  = $dblms->querylms("SELECT paper_startdate as date_start, paper_enddate as date_end, awardlist_addfrom, awardlist_addto
											FROM ".SETTINGS_PAPERS."
											WHERE status = '1' AND examterm = '2' 
											$AddProgramSemesterSQL
											AND FIND_IN_SET('".$_GET['semester']."', semesters)
											AND FIND_IN_SET('".$_GET['timing']."', timings)
											AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND id_campus	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'
											ORDER BY id DESC LIMIT 1");
	$rowfeecats = mysqli_fetch_array($sqllmsfeecats);
	if($_GET['timing'] == 1 || $_GET['timing'] == 4) { 
		$attendancereq 	= $rowsetting['finalterm_mattendance'];
	} else if($_GET['timing'] == 2) {
		$attendancereq 	= $rowsetting['finalterm_eattendance'];
	}

	echo '
	<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
	<!--WI_PROJECT_NAV_CONTENT-->
	<div class="col-lg-12">
	<div class="widget">
	<div class="widget-content widget-content-project">
	<div class="project-info-tabs">
	<!--WI_MILESTONES_NAVIGATION-->
	<div class="row">
		<div class="col-lg-12">
			<div class="tabs-sub-nav">
				<span class="pull-left"><h3  style="font-weight:700;">Practical Award List</h3></span> 
				<span class="pull-right"><a class="btn btn-mid btn-success" href="courses.php?id='.$_GET['id'].'&view=Practicalmarks"> Back to Course </a></span>
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
	//Final Term Examination
	if($rowfeecats['date_start']>date("Y-m-d")) { 

		echo '
		<div class="col-lg-12">
			<div class="widget-tabs-notification" style="font-weight:600; color:blue;">After Final term exam, you will be able to upload students award list.</div>
		</div>';

	} else {
//-----------------------final term Result Submission-------------------------

if($rowfeecats['awardlist_addto']<date("Y-m-d") ) { 
echo '<div class="col-lg-12">
	<div class="widget-tabs-notification" style="font-weight:600; color:blue; font-size:30px;">Final Term Result Submission date are closed.<br>Please contact with CMS Coordinator.</div>';
} else {	 
//-----------------------final term Result Submission-------------------------


	//--------------------------------------
	if(isset($_SESSION['msg'])) { 
		echo $_SESSION['msg']['status'];
		unset($_SESSION['msg']);
	} 
	//--------------------------------------

	$cursstudents 	= array();
	$countstudents 	= 0;

	if(isset($_GET['section'])) {
		$stdsection 	= " AND std.std_section =  '".cleanvars($_GET['section'])."'"; 
		$seccursquery 	= " AND at.section = '".$_GET['section']."'";
		$section 		= $_GET['section'];
	} else { 
		$stdsection 	= " AND std.std_section =  ''"; 
		$seccursquery 	= " AND at.section = ''";
		$section 		= '';
	}

	if(($_GET['prgid'] !='la')) { 

		$sqllmsstds  = $dblms->querylms("SELECT std.std_id, std.std_photo, std.std_name, std.std_rollno, std.std_regno, std.std_session, 
												prg.prg_name, std.std_semester, std.std_section, std.id_prg, std.std_timing     
												FROM ".STUDENTS." std 
												INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
												WHERE (std.std_status = '2' OR std.std_status = '7') 
												AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
												AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
												AND std.id_prg = '".cleanvars($_GET['prgid'])."' 
												AND std.std_timing = '".cleanvars($_GET['timing'])."' 
												AND std.std_semester = '".cleanvars($_GET['semester'])."' $stdsection 
												ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC");
		while($rowcurstds = mysqli_fetch_array($sqllmsstds)) { 
			$cursstudents[] = array (
										"std_id"		=> $rowcurstds['std_id']		,
										"std_photo"		=> $rowcurstds['std_photo']		,
										"std_name"		=> $rowcurstds['std_name']		,
										"std_session"	=> $rowcurstds['std_session']	,
										"std_rollno"	=> $rowcurstds['std_rollno']	,
										"std_semester"	=> $rowcurstds['std_semester']	,
										"std_regno"		=> $rowcurstds['std_regno']		,
										"id_prg"		=> $rowcurstds['id_prg']		,
										"prg_name"		=> $rowcurstds['prg_name']		,
										"rep_mig"		=> 0	
									);
			$countstudents++;
		}

		//Repeat/Migration Courses
		$sqllmsRepeatCurs  = $dblms->querylms("SELECT std.std_id,std.std_photo,std.std_name,std.std_session, std.std_rollno, 
														rc.semester, std.std_regno, std.id_prg, rr.type, prg.prg_id, prg.prg_name    
													FROM ".REPEAT_COURSES." rc    
													INNER JOIN ".COURSES." c ON c.curs_id = rc.id_curs   
													INNER JOIN ".TIMETABLE." t ON t.id = rc.id_timetable
													INNER JOIN ".REPEAT_REGISTRATION." rr ON rr.id = rc.id_setup    
													INNER JOIN ".STUDENTS." std ON std.std_id = rr.id_std  
													INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
													WHERE rr.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
													AND rr.id_prg = '".cleanvars($_GET['prgid'])."'
													AND rc.id_curs = '".cleanvars($_GET['id'])."'   
													AND rc.semester = '".cleanvars($_GET['semester'])."'   
													AND rc.timing = '".cleanvars($_GET['timing'])."'    
													AND rc.id_teacher = '".cleanvars($rowsstd['emply_id'])."'     
													AND t.section = '".cleanvars($section)."'     
													AND rr.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'
													GROUP BY rc.id_curs ORDER BY c.curs_code ASC");
		if(mysqli_num_rows($sqllmsRepeatCurs)>0) {

			while($rowrepstds = mysqli_fetch_array($sqllmsRepeatCurs)) {
				$cursstudents[] = array (
											"std_id"		=> $rowrepstds['std_id']		,
											"std_photo"		=> $rowrepstds['std_photo']		,
											"std_name"		=> $rowrepstds['std_name']		,
											"std_session"	=> $rowrepstds['std_session']	,
											"std_rollno"	=> $rowrepstds['std_rollno']	,
											"std_semester"	=> $rowrepstds['semester']		,
											"std_regno"		=> $rowrepstds['std_regno']		,
											"id_prg"		=> $rowrepstds['id_prg']		,
											"prg_name"		=> $rowrepstds['prg_name']		,
											"rep_mig"		=> $rowrepstds['type']	
										);
				$countstudents++;
			}
		}

	} else{

		$sqllmsstds  = $dblms->querylms("SELECT od.*, std.std_id, std.std_name, std.std_rollno, std.std_regno, 
													std.std_photo, std.std_session, std.id_prg, oc.semester 
														FROM ".LA_STUDENT_REGISTRATION_DETAIL." od
														INNER JOIN ".LA_STUDENT_REGISTRATION." oc ON oc.id = od.id_setup 
														INNER JOIN ".STUDENTS." std ON std.std_id = oc.id_std 
														WHERE oc.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
														AND oc.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
														AND oc.is_deleted != '1'
														AND od.id_curs =  '".cleanvars($_GET['id'])."'  
														AND od.section =  '".cleanvars($_GET['section'])."'  
														AND od.timing =  '".cleanvars($_GET['timing'])."'  
														AND (std.std_status = '2' OR std.std_status = '7') 
														AND std.std_struckoffresticate != '1' AND std.std_regconfirmed = '1' 
														ORDER BY std.std_session ASC,std.std_rollno ASC, std.std_regno ASC");
		while($rowcurstds = mysqli_fetch_array($sqllmsstds)) { 

			$cursstudents[] = array (
										"std_id"		=> $rowcurstds['std_id']		,
										"std_photo"		=> $rowcurstds['std_photo']		,
										"std_name"		=> $rowcurstds['std_name']		,
										"std_session"	=> $rowcurstds['std_session']	,
										"std_rollno"	=> $rowcurstds['std_rollno']	,
										"std_semester"	=> $rowcurstds['semester']		,
										"std_regno"		=> $rowcurstds['std_regno']		,
										"id_prg"		=> $rowcurstds['id_prg']		,
										"prg_name"		=> ''							,
										"rep_mig"		=> 0	
									);
			
			$countstudents++;
		}

	}

//--------------------------------------------------
if ($countstudents>0) {

$srbk = 0;

foreach($cursstudents as $itemstd) { 

	$AddFinalProgramSQL = '';
	if(($_GET['prgid'] !='la')) { 

		$AddFinalProgramSQL = "AND f.id_prg 	= '".cleanvars($itemstd['id_prg'])."'";

	} 

	//-----------------Fee Status-------------------------------
	$sqllmspayable  = $dblms->querylms("SELECT 
											SUM(CASE WHEN total_amount != '0' AND due_date <= '".$rowfeecats['date_end']."' then total_amount end) as Totalpayable, 
											SUM(CASE WHEN total_amount != '0' AND due_date <= '".$rowfeecats['date_end']."'then arrears end) as Totalpayarrears, 
											SUM(CASE WHEN paid_date != '0000-00-00' AND due_date <= '".$rowfeecats['date_end']."' then total_amount end) as Totalpaid, 
											SUM(CASE WHEN paid_date != '0000-00-00' AND due_date <= '".$rowfeecats['date_end']."' then arrears end) as Totalarrears
											FROM ".FEES." 
											WHERE id_std = '".$itemstd['std_id']."' 
											AND is_deleted != '1'  ");
	$valuepayable	= mysqli_fetch_array($sqllmspayable); 
	$totalbalance 	= (($valuepayable['Totalpayable'] + $valuepayable['Totalpayarrears']) - ($valuepayable['Totalpaid'] + $valuepayable['Totalarrears']));
if(($totalbalance == 0) && $valuepayable['Totalpayable']>0) { 

	$sqllmsfinalterm  = $dblms->querylms("SELECT fd.id, fd.id_finalterm, fd.assignment, fd.quiz, fd.attendance, fd.marks_obtained, fd.numerical, 
												 fd.finalterm, fd.gradepoint, fd.lettergrade, fd.remarks, f.exam_date, f.forward_to, f.section  
												FROM ".FINALTERM_DETAILS." fd 
												INNER JOIN ".FINALTERM." f ON f.id = fd.id_finalterm  
												WHERE fd.id_std 	= '".cleanvars($itemstd['std_id'])."' 
												AND f.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										  		AND f.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
												$AddFinalProgramSQL
											  	AND f.semester 	= '".cleanvars($itemstd['std_semester'])."' 
												AND f.id_teacher = '".cleanvars($rowsurs['id_teacher'])."'
												AND f.id_curs 	= '".cleanvars($_GET['id'])."' 
												AND f.section 	= '".cleanvars($section)."' 
												AND f.theory_practical 	= '2'  
												AND f.timing 	= '".cleanvars($_GET['timing'])."' LIMIT 1");
	$valfinalterm 	= mysqli_fetch_array($sqllmsfinalterm);

	$sqllmsFinalTermID  = $dblms->querylms("SELECT f.id
												FROM ".FINALTERM_DETAILS." fd 
												INNER JOIN ".FINALTERM." f ON f.id = fd.id_finalterm  
												WHERE f.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										  		AND f.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
												  $AddFinalProgramSQL
											  	AND f.semester 	= '".cleanvars($itemstd['std_semester'])."' 
												AND f.id_teacher = '".cleanvars($rowsurs['id_teacher'])."'
												AND f.id_curs 	= '".cleanvars($_GET['id'])."' 
												AND f.section 	= '".cleanvars($section)."' 
												AND f.theory_practical 	= '2'  
												AND f.timing 	= '".cleanvars($_GET['timing'])."' LIMIT 1");
	$valueFinalTermID 	= mysqli_fetch_array($sqllmsFinalTermID);
	if($valfinalterm['id_finalterm']) { 
		$printaward = '<div style="float:right;"><a class="btn btn-mid btn-info" href="finaltermawardprint.php?id='.$valfinalterm['id_finalterm'].'" target="_blank"><i class="icon-print"></i> Print Sheet</a></div>';
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

$srbk++;
if($srbk == 1) {
	if(($valfinalterm['forward_to'] != 4) && $valfinalterm['id_finalterm']) {
		echo '<div  class="alert-box error" style="font-size:16px; font-weight:600;">Result is save local only not forward to HOD.</b></div>';
	} 
	
if($valfinalterm['forward_to'] == 4) {
	$readonly 	= "readonly";
	$disabled 	= 'disabled';
	$buttonlink = '';
} else {
	$readonly 	= "";
	$disabled 	= '';
	$buttonlink = '<div class="modal-footer">
	<button class="btn btn-success" type="submit" value="saveonly" id="submit_marks" name="submit_marks" tabindex="'.($srbk+1).'" onClick=\'return confirmSubmit()\'> Save </button>
	<button class="btn btn-primary" type="submit" value="saveforward" id="submit_marks" name="submit_marks" tabindex="'.($srbk+2).'" onClick=\'return confirmSubmit()\'> Save & Forward </button>
</div>';
}
echo '
<div style="clear:both;"></div>
<form class="form-horizontal" action="#" method="post" id="inv_form" name="inv_form" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="id_curs" id="id_curs" value="'.$_GET['id'].'">
<input type="hidden" name="stdsection" id="stdsection" value="'.$section.'">
<input type="hidden" name="id_setup" id="id_setup" value="'.$valueFinalTermID['id'].'">
<input type="hidden" name="id_teacher" id="id_teacher" value="'.$rowsurs['id_teacher'].'">
<input type="hidden" name="semester" id="semester" value="'.$rowsurs['semester'].'">
<div style="margin-top:10px; font-weight:600; font-size:16px;">
	Subject:  <span style="width:80%; display: inline-block; border-bottom:1px dashed #666;">'.$rowsurs['curs_code'].' - '.$rowsurs['curs_name'].'</span> 
</div>
<div style="clear:both;"></div>
<div style="margin-top:10px;">
	<span class="req" style="font-weight:600;">Practical Date</span> <input class="pickadate" name="exam_date" id="exam_date" type="text" value="'.$examdate.'" required autocomplete="off" tabindex="'.$srbk.'" '.$disabled.'> 
	<span style="margin-right:20px; float:right; font-weight:600;"> Forward to :
		<select id="forward_to" name="forward_to" style="width:150px;"  autocomplete="off" '.$disabled.'>
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
	<td style="width:100px;"><input type="text" class="form-control col-lg-12 jQinv_item_obtained" min="0" max="100" id="marks_obtained['.$srbk.']" name="marks_obtained['.$srbk.']" required autocomplete="off" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" style="text-align:center;" value="'.$stdmarksobtained.'" tabindex="'.$srbk.'" '.$readonly.'></td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_numerical" min="1" max="25" id="numerical['.$srbk.']" name="numerical['.$srbk.']" readonly style="text-align:center;" value="'.$stdnumerical.'"></td>
	<td style="width:70px;"><input type="text" class="form-control col-lg-12 jQinv_item_credithour" id="credithour['.$srbk.']" name="credithour['.$srbk.']" readonly style="text-align:center;" value="'.$rowsurs['cur_credithours_practical'].'"></td>
	<td style="width:60px;"><input type="text" class="form-control col-lg-12 jQinv_item_gradepoint" id="gradepoint['.$srbk.']" name="gradepoint['.$srbk.']" readonly value="'.$stdgradepoint.'"></td>
	<td style="width:60px;"><input type="text" class="form-control col-lg-12 jQinv_item_lettergrade" id="lettergrade['.$srbk.']" name="lettergrade['.$srbk.']" readonly style="text-align:center;" value="'.$stdlettergrade.'"></td>
	<td style="width:90px;"><input type="text" class="form-control col-lg-12 jQinv_item_remarks" id="remarks['.$srbk.']" name="remarks['.$srbk.']"  value="'.$stdremarks.'" '.$readonly.' ></td>

</tr>
<input type="hidden" name="id_std['.$srbk.']" id="id_std['.$srbk.']" value="'.$itemstd['std_id'].'">
<input type="hidden" name="rep_mig['.$srbk.']" id="rep_mig['.$srbk.']" value="'.$itemstd['rep_mig'].'">
<input type="hidden" name="id_edit['.$srbk.']" id="id_edit['.$srbk.']" value="'.$valfinalterm['id'].'">';
//------------------------------------------------
}
}
//------------------------------------------------
echo '
</tbody>
<tr class="last_row">
	<td colspan="20" style="text-align:right;">
</tr>
</table>
'.$buttonlink.'

</form>
<script LANGUAGE="JavaScript">
<!--
function confirmSubmit() {
	var agree=confirm("Are you sure you wish to continue?");
	if (agree)
	 return true ;
	else
	 return false ;
	}
// -->
</script>';
//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}
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
	
</script>
<script type="text/javascript" src="js/practicalaward.js"></script>'; 
}