<?php 
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">

<!--WI_MILESTONES_TABLE-->
<div class="row">
<div class="col-lg-12">
  
<div class="widget wtabs">
<div class="widget-content">';
//--------------------------------------
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
} 


// course info
	$sqllmsinfo  = $dblms->querylms("SELECT id, introduction, objectives, outlines, objectives_date, introduction_date, outlines_date, 
											outcomes, outcomes_date, strategies, strategies_date, effectiveness, effectiveness_date 
											FROM ".COURSES_INFO."   										 
											WHERE id_campus 	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
											AND id_curs = '".cleanvars($_GET['id'])."' LIMIT 1");
	$rowscinfo = mysqli_fetch_array($sqllmsinfo);

	if(mysqli_num_rows($sqllmsinfo) == 0){

		// course Info Archive Check
		$sqllmsInfoArchive  = $dblms->querylms("SELECT id, id_teacher
													FROM ".COURSES_INFO."   										 
													WHERE id_campus 	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
													AND academic_session != '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
													AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
													AND id_curs = '".cleanvars($_GET['id'])."' ORDER BY id DESC LIMIT 1");
		if (mysqli_num_rows($sqllmsInfoArchive) > 0) {
			$rowInfoArchive = mysqli_fetch_array($sqllmsInfoArchive);

			$importInfo = '<form method="post">
							<input type="hidden" id="info_id" name="info_id" value="'.$rowInfoArchive['id'].'">
							<input type="hidden" id="id_teacher" name="id_teacher" value="'.$rowInfoArchive['id_teacher'].'">
							<input type="submit" id="import_introduction" name="import_introduction" style="margin-left:10px;" class="btn btn-xs btn-success pull-right" onclick="return confirm(\'Are you sure want to Import the Course Introduction, Objectives, Outline?\')" value="Import">
						</form>';

		} else{

			$importInfo = '';

		}	

	} else{

		$importInfo = '';

	}

	if(isset($rowscinfo['introduction'])) { 
		$introduction = html_entity_decode($rowscinfo['introduction'], ENT_QUOTES);
		$btnintto = '<a class="btn btn-xs btn-info pull-right" href="courses.php?id='.$_GET['id'].'&view=Introduction"><i class="icon-edit"></i></a>';

	} else {
		$introduction = '';
		$btnintto = '<div style="margin-bottom:20px;">'.$importInfo.'<a class="btn btn-xs btn-info pull-right" href="courses.php?id='.$_GET['id'].'&view=Introduction"><i class="icon-plus"></i> Add </a><div>';

	}

	if(($rowscinfo['introduction_date']) != '0000-00-00 00:00:00' && mysqli_num_rows($sqllmsinfo)>0) {
		$intodate = '<span class="pull-right style="color:#fff !important;">Last Update: <i class="icon-time"></i> '. date("j F, Y h:i A", strtotime($rowscinfo['introduction_date'])).'</span>';
	} else {
		$intodate = '';
	}

	if(isset($rowscinfo['outlines'])) { 
		$outlines = html_entity_decode($rowscinfo['outlines'], ENT_QUOTES);
		$btnoutline = '<a class="btn btn-xs btn-info pull-right" href="courses.php?id='.$_GET['id'].'&view=Outlines"><i class="icon-edit"></i></a>';
	} else {
		$outlines = '';
		$btnoutline = '<a class="btn btn-xs btn-info pull-right" href="courses.php?id='.$_GET['id'].'&view=Outlines"><i class="icon-plus"></i> Add </a>';
	}

	if(($rowscinfo['outlines_date']) != '0000-00-00 00:00:00' && mysqli_num_rows($sqllmsinfo)>0) {
		$outlidate = '<span class="pull-right style="color:#fff !important;">Last Update: <i class="icon-time"></i> '. date("j F, Y h:i A", strtotime($rowscinfo['outlines_date'])).'</span>';
	} else {
		$outlidate = '';
	}

	if(isset($rowscinfo['objectives'])) {
		$objectives = html_entity_decode($rowscinfo['objectives'], ENT_QUOTES);
		$btnoject = '<a class="btn btn-xs btn-info pull-right" href="courses.php?id='.$_GET['id'].'&view=Objectives"><i class="icon-edit"></i></a>';
	} else {
		$objectives = '';
		$btnoject = '<a class="btn btn-xs btn-info pull-right" href="courses.php?id='.$_GET['id'].'&view=Objectives"><i class="icon-plus"></i> Add </a>';
	}

	if(($rowscinfo['objectives_date']) != '0000-00-00 00:00:00' && mysqli_num_rows($sqllmsinfo)>0) {
		$objetdate = '<span class="pull-right style="color:#fff !important;">Last Update: <i class="icon-time"></i> '. date("j F, Y h:i A", strtotime($rowscinfo['objectives_date'])).'</span>';
	} else {
		$objetdate = '';
	}

	if(isset($rowscinfo['outcomes'])) {
		$outcomes 	 = html_entity_decode($rowscinfo['outcomes'], ENT_QUOTES);
		$btnoutcomes = '<a class="btn btn-xs btn-info pull-right" href="courses.php?id='.$_GET['id'].'&view=Outcomes"><i class="icon-edit"></i></a>';
	} else {
		$outcomes 	 = '';
		$btnoutcomes = '<a class="btn btn-xs btn-info pull-right" href="courses.php?id='.$_GET['id'].'&view=Outcomes"><i class="icon-plus"></i> Add </a>';
	}

	if(($rowscinfo['outcomes_date']) != '0000-00-00 00:00:00' && mysqli_num_rows($sqllmsinfo)>0) {
		$outcomesdate = '<span class="pull-right style="color:#fff !important;">Last Update: <i class="icon-time"></i> '. date("j F, Y h:i A", strtotime($rowscinfo['outcomes_date'])).'</span>';
	} else {
		$outcomesdate = '';
	}

	if(isset($rowscinfo['strategies'])) {
		$strategies 	 = html_entity_decode($rowscinfo['strategies'], ENT_QUOTES);
		$btnstrategies = '<a class="btn btn-xs btn-info pull-right" href="courses.php?id='.$_GET['id'].'&view=Strategies"><i class="icon-edit"></i></a>';
	} else {
		$strategies 	 = '';
		$btnstrategies = '<a class="btn btn-xs btn-info pull-right" href="courses.php?id='.$_GET['id'].'&view=Strategies"><i class="icon-plus"></i> Add </a>';
	}

	if(($rowscinfo['strategies_date']) != '0000-00-00 00:00:00' && mysqli_num_rows($sqllmsinfo)>0) {
		$strategiesdate = '<span class="pull-right style="color:#fff !important;">Last Update: <i class="icon-time"></i> '. date("j F, Y h:i A", strtotime($rowscinfo['strategies_date'])).'</span>';
	} else {
		$strategiesdate = '';
	}

	if(isset($rowscinfo['effectiveness'])) {
		$effectiveness 	 = html_entity_decode($rowscinfo['effectiveness'], ENT_QUOTES);
		$btneffectiveness = '<a class="btn btn-xs btn-info pull-right" href="courses.php?id='.$_GET['id'].'&view=Effectiveness"><i class="icon-edit"></i></a>';
	} else {
		$effectiveness 	 = '';
		$btneffectiveness = '<a class="btn btn-xs btn-info pull-right" href="courses.php?id='.$_GET['id'].'&view=Effectiveness"><i class="icon-plus"></i> Add </a>';
	}

	if(($rowscinfo['effectiveness_date']) != '0000-00-00 00:00:00' && mysqli_num_rows($sqllmsinfo)>0) {
		$effectivenessdate = '<span class="pull-right style="color:#fff !important;">Last Update: <i class="icon-time"></i> '. date("j F, Y h:i A", strtotime($rowscinfo['effectiveness_date'])).'</span>';
	} else {
		$effectivenessdate = '';
	}

//-----------------------------------------
echo '
<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th colspan="10">
		<h4 class="modal-title" style="font-weight:700;">Course Info</h4>
	</th>
</tr>
</thead>
<tbody>
<tr>
    <th width="13%"><strong>Course Code:</strong></th>
    <td idth="29%"><span class="label label-info" style="font-size:14px;">'.$rowsurs['curs_code'].'</span></td>
    <th width="18%"><strong>Credit Hours</strong></th>
    <td width="31%">'.$rowsurs['curs_credit_hours'].' (Theory: '.$rowsurs['cur_credithours_theory'].', Practical: '.$rowsurs['cur_credithours_practical'].')</td>
</tr>
<tr>
    <th><strong>Title</strong></th>
    <td colspan="3">'.$rowsurs['curs_name'].'</td>
</tr>
<tr>
    <th><strong>Prerequisite</strong></th>
    <td colspan="3">'.$prerequisite.'</td>
</tr>

</tbody>
</table>

<div id="project-brief">

	<h4 class="modal-title" style="font-weight:700; margin-top:15px;margin-top:5px; border-bottom: 1px dotted #999; padding-bottom: 5px;">Course Introduction / Description '.$btnintto.'</h4>
	<p>'.$introduction.' </p>'.$intodate.'
	
	<div style="clear:both;"></div>
	<h4 class="modal-title" style="font-weight:700; margin-top:15px; border-bottom: 1px dotted #999; padding-bottom: 5px;">Course Objectives '.$btnoject.'</h4>
	<p>'.$objectives.'</p>'.$objetdate.'
	<div style="clear:both;"></div>
	<h4 class="modal-title" style="font-weight:700; margin-top:15px; border-bottom: 1px dotted #999; padding-bottom: 5px;">Learning Outcomes '.$btnoutcomes.'</h4>
	<p>'.$outcomes.'</p>'.$outcomesdate.'
	
	<div style="clear:both;"></div>
	<h4 class="modal-title" style="font-weight:700; margin-top:15px; border-bottom: 1px dotted #999; padding-bottom: 5px;">Teaching & Learning Strategies '.$btnstrategies.'</h4>
	<p>'.$strategies.'</p>'.$strategiesdate.'
	
	<div style="clear:both;"></div>
	<h4 class="modal-title" style="font-weight:700; margin-top:15px; border-bottom: 1px dotted #999; padding-bottom: 5px;">Soft Skills & Personal Effectiveness '.$btneffectiveness.'</h4>
	<p>'.$effectiveness.'</p>'.$effectivenessdate;
//------------------------------------------------
if(isset($rowscinfo['outlines'])) {
	echo '
	<div style="clear:both;"></div>
	<h4 class="modal-title" style="font-weight:700; margin-top:15px; border-bottom: 1px dotted #999; padding-bottom: 5px;">Course Outline'.$btnoutline.'</h4>	
	<p>'.$outlines.'</p>'.$outlidate ;

} else {
echo '
	<div style="clear:both;"></div>
	<h4 class="modal-title" style="font-weight:700; margin-top:15px; border-bottom: 1px dotted #999; padding-bottom: 5px;">Course Outline <a class="btn btn-xs btn-info pull-right" href="courses.php?id='.$_GET['id'].'&view=Outlines"><i class="icon-edit"></i></a></h4>
<p>'.nl2br(html_entity_decode ($rowsurs['curs_detail'], ENT_QUOTES)).'</p>';

}

//------------------------------------------------
if(isset($rowsurs['curs_references'])) { 
echo '<h4 class="modal-title" style="font-weight:700; margin-top:15px; border-bottom: 1px dotted #999; padding-bottom: 5px;">Course References</h4>
<p>'.nl2br(html_entity_decode($rowsurs['curs_references'], ENT_QUOTES)).'</p>';
}

echo '
</div>
<h4 class="modal-title" style="font-weight:700; margin-top:15px; border-bottom: 1px dotted #999; padding-bottom: 5px;">Timetable</h4>'; 

// start liberal arts
	$sqllmslacrustimee  = $dblms->querylms("SELECT DISTINCT(d.id_curs), d.id_setup,   
										t.section, t.timing , t.semester, t.id_prg       
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.status = '1' AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND d.id_curs = '".cleanvars($_GET['id'])."' AND t.is_liberalarts = '1' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										 ORDER BY t.section ASC, t.id ASC");
//----------------------------------------------------------------
if(mysqli_num_rows($sqllmslacrustimee)>0) { 
//----------------------------------------------------------------
while($rowslacurstime = mysqli_fetch_array($sqllmslacrustimee)) {  
 if($rowslacurstime['section']) { 
	$sectlacaption = 'Section: '.$rowslacurstime['section'];
	$sectlahref 	 = '&section='.$rowslacurstime['section'];
 } else { 
 	$sectlacaption = '';
	$sectlahref 	 = '';
 }
	

	
echo '
<h5 class="modal-title" style="font-weight:700; margin-top:10px; color:blue; font-size:13px;">'.$sectlacaption.' Semester: '.addOrdinalNumberSuffix($rowslacurstime['semester']).' ('.get_programtiming($rowslacurstime['timing']).')</h5>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600; text-align:center;">Sr.#</th>
	<th style="font-weight:600;">Day '.$rowslacurstime['id_setup'].'</th>
	<th style="font-weight:600;">Period '.$rowsstd['emply_id'].'</th>
	<th style="font-weight:600;">Class Room</th>
</tr>
</thead>
<tbody>';
if($_SESSION['userlogininfo']['LOGINIDCOM'] != 1) { 
	$sqllmslatimetable  = $dblms->querylms("SELECT d.period_no, d.time_start, d.time_end, d.days, r.room_no, r.room_type        
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup  
										INNER JOIN ".TIMETABLE_ROOMS." r ON r.room_id = d.id_room   
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'  
										AND d.id_curs = '".cleanvars($_GET['id'])."' AND t.timing =  '".cleanvars($rowslacurstime['timing'])."'
										AND t.status = '1' 
										AND t.section = '".cleanvars($rowslacurstime['section'])."' 
										AND d.id_teacher = '".cleanvars($rowsurs['id_teacher'])."' 
										AND t.semester =  '".cleanvars($rowslacurstime['semester'])."'
										 ORDER BY d.period_no ASC");


$srlatime = 0;
//------------------------------------------------
while($rowcurlatime = mysqli_fetch_assoc($sqllmslatimetable)) { 
//------------------------------------------------
$srlatime++;
//------------------------------------------------
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$srlatime.'</td>
	<td style="width:150px;">'.$rowcurlatime['days'].'</td>
	<td>'.$rowcurlatime['period_no'].' ('.$rowcurlatime['time_start'].' - '.$rowcurlatime['time_end'].')</td>
	<td style="width:210px;">'.$rowcurlatime['room_no'].' ('.get_classroomtypes($rowcurlatime['room_type']).')</td>
</tr>';
//------------------------------------------------

}
	
} else {
	
if($rowslacurstime['timing'] == 1) { 
	$sqllmslatimetable  = $dblms->querylms("SELECT p.period_no, d.time_start, d.time_end, d.days, r.room_no, r.room_type      
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup  
										INNER JOIN ".TIMETABLE_ROOMS." r ON r.room_id = d.id_room   
										INNER JOIN ".TIMETABLE_PERIODS." p ON p.period_id = d.id_period  
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'  
										AND d.id_curs = '".cleanvars($_GET['id'])."' AND t.timing =  '".cleanvars($rowslacurstime['timing'])."'
										AND t.status = '1' 
										AND t.section = '".cleanvars($rowslacurstime['section'])."' 
										AND d.id_teacher = '".cleanvars($rowsurs['id_teacher'])."' 
										AND t.semester =  '".cleanvars($rowslacurstime['semester'])."'
										 ORDER BY d.id ASC");

$srlatime = 0;
//------------------------------------------------
while($rowcurlatime = mysqli_fetch_assoc($sqllmslatimetable)) { 
//------------------------------------------------
$srlatime++;
//------------------------------------------------
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$srlatime.'</td>
	<td style="width:150px;">'.$rowcurlatime['days'].'</td>
	<td>'.$rowcurlatime['period_no'].' ('.date("H:i A", strtotime($rowcurlatime['time_start'])).' - '.date("H:i A", strtotime($rowcurlatime['time_end'])).')</td>
	<td style="width:170px;">'.$rowcurlatime['room_no'].' ('.get_classroomtypes($rowcurlatime['room_type']).')</td>
</tr>';
//------------------------------------------------
} 
} else if($rowslacurstime['timing'] == 2) {  
	$sqllmslatimetable  = $dblms->querylms("SELECT d.period_no, d.time_start, d.time_end, d.days, r.room_no, r.room_type        
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup  
										INNER JOIN ".TIMETABLE_ROOMS." r ON r.room_id = d.id_room   
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'  
										AND d.id_curs = '".cleanvars($_GET['id'])."' AND t.timing =  '".cleanvars($rowslacurstime['timing'])."'
										AND t.status = '1' AND t.id_prg =  '".cleanvars($rowslacurstime['id_prg'])."'
										AND t.section = '".cleanvars($rowslacurstime['section'])."' 
										AND d.id_teacher = '".cleanvars($rowsurs['id_teacher'])."' 
										AND t.semester =  '".cleanvars($rowslacurstime['semester'])."'
										 ORDER BY d.period_no ASC");


$srlatime = 0;
//------------------------------------------------
while($rowcurlatime = mysqli_fetch_assoc($sqllmslatimetable)) { 
//------------------------------------------------
$srlatime++;
//------------------------------------------------
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$srlatime.'</td>
	<td style="width:150px;">'.$rowcurlatime['days'].'</td>
	<td>'.$rowcurlatime['period_no'].' ('.date("H:i A", strtotime($rowcurlatime['time_start'])).' - '.date("H:i A", strtotime($rowcurlatime['time_end'])).')</td>
	<td style="width:170px;">'.$rowcurlatime['room_no'].' ('.get_classroomtypes($rowcurlatime['room_type']).')</td>
</tr>';
//------------------------------------------------
}
}
}
echo '</tbody>
</table>';
}
//----------------------------------------

}
// end liberal arts

	$sqllmscrustimee  = $dblms->querylms("SELECT DISTINCT(d.id_curs), d.id_setup, p.prg_id, p.prg_name,   
										t.section, t.timing , t.semester, t.id_prg       
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										LEFT JOIN ".PROGRAMS." p ON p.prg_id = t.id_prg  
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.status = '1' AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND d.id_curs = '".cleanvars($_GET['id'])."' AND t.is_liberalarts != '1' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										 ORDER BY t.section ASC, t.id ASC");
//----------------------------------------------------------------
if(mysqli_num_rows($sqllmscrustimee)>0) { 
//----------------------------------------------------------------
while($rowscurstime = mysqli_fetch_array($sqllmscrustimee)) {  
 if($rowscurstime['section']) { 
	$sectcaption = 'Section: '.$rowscurstime['section'];
	$secthref 	 = '&section='.$rowscurstime['section'];
 } else { 
 	$sectcaption = '';
	$secthref 	 = '';
 }
	
	if($rowscurstime['prg_name']) {
		$prgname = $rowscurstime['prg_name'].': ';
	} else {
		$prgname = '';
	}
	
echo '
<h5 class="modal-title" style="font-weight:700; margin-top:10px; color:blue; font-size:13px;">'.$prgname.$sectcaption.' Semester: '.addOrdinalNumberSuffix($rowscurstime['semester']).' ('.get_programtiming($rowscurstime['timing']).')</h5>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600; text-align:center;">Sr.#</th>
	<th style="font-weight:600;">Day</th>
	<th style="font-weight:600;">Period</th>
	<th style="font-weight:600;">Class Room</th>
</tr>
</thead>
<tbody>';
if($_SESSION['userlogininfo']['LOGINIDCOM'] != 1) { 
	$sqllmstimetable  = $dblms->querylms("SELECT d.period_no, d.time_start, d.time_end, d.days, r.room_no, r.room_type        
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup  
										INNER JOIN ".TIMETABLE_ROOMS." r ON r.room_id = d.id_room   
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'  
										AND d.id_curs = '".cleanvars($_GET['id'])."' AND t.timing =  '".cleanvars($rowscurstime['timing'])."'
										AND t.status = '1' AND t.id_prg =  '".cleanvars($rowscurstime['id_prg'])."'
										AND t.section = '".cleanvars($rowscurstime['section'])."' 
										AND d.id_teacher = '".cleanvars($rowsurs['id_teacher'])."' 
										AND t.semester =  '".cleanvars($rowscurstime['semester'])."'
										 ORDER BY d.period_no ASC");


$srtime = 0;
//------------------------------------------------
while($rowcurtime = mysqli_fetch_assoc($sqllmstimetable)) { 
//------------------------------------------------
$srtime++;
//------------------------------------------------
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$srtime.'</td>
	<td style="width:150px;">'.$rowcurtime['days'].'</td>
	<td>'.$rowcurtime['period_no'].' ('.$rowcurtime['time_start'].' - '.$rowcurtime['time_end'].')</td>
	<td style="width:210px;">'.$rowcurtime['room_no'].' ('.get_classroomtypes($rowcurtime['room_type']).')</td>
</tr>';
//------------------------------------------------

}
} else {
	
if($rowscurstime['timing'] == 1) { 
	$sqllmstimetable  = $dblms->querylms("SELECT p.period_no, d.time_start, d.time_end, d.days, r.room_no, r.room_type      
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup  
										INNER JOIN ".TIMETABLE_ROOMS." r ON r.room_id = d.id_room   
										INNER JOIN ".TIMETABLE_PERIODS." p ON p.period_id = d.id_period  
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'  
										AND d.id_curs = '".cleanvars($_GET['id'])."' AND t.timing =  '".cleanvars($rowscurstime['timing'])."'
										AND t.status = '1' AND t.id_prg =  '".cleanvars($rowscurstime['id_prg'])."' 
										AND t.section = '".cleanvars($rowscurstime['section'])."' 
										AND d.id_teacher = '".cleanvars($rowsurs['id_teacher'])."' 
										AND t.semester =  '".cleanvars($rowscurstime['semester'])."'
										 ORDER BY d.id ASC");

$srtime = 0;
//------------------------------------------------
while($rowcurtime = mysqli_fetch_assoc($sqllmstimetable)) { 
//------------------------------------------------
$srtime++;
//------------------------------------------------
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$srtime.'</td>
	<td style="width:150px;">'.$rowcurtime['days'].'</td>
	<td>'.$rowcurtime['period_no'].' ('.date("H:i A", strtotime($rowcurtime['time_start'])).' - '.date("H:i A", strtotime($rowcurtime['time_end'])).')</td>
	<td style="width:170px;">'.$rowcurtime['room_no'].' ('.get_classroomtypes($rowcurtime['room_type']).')</td>
</tr>';
//------------------------------------------------
} 
} else if($rowscurstime['timing'] == 2) {  
	$sqllmstimetable  = $dblms->querylms("SELECT d.period_no, d.time_start, d.time_end, d.days, r.room_no, r.room_type        
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup  
										INNER JOIN ".TIMETABLE_ROOMS." r ON r.room_id = d.id_room   
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'  
										AND d.id_curs = '".cleanvars($_GET['id'])."' AND t.timing =  '".cleanvars($rowscurstime['timing'])."'
										AND t.status = '1' AND t.id_prg =  '".cleanvars($rowscurstime['id_prg'])."'
										AND t.section = '".cleanvars($rowscurstime['section'])."' 
										AND d.id_teacher = '".cleanvars($rowsurs['id_teacher'])."' 
										AND t.semester =  '".cleanvars($rowscurstime['semester'])."'
										 ORDER BY d.period_no ASC");


$srtime = 0;
//------------------------------------------------
while($rowcurtime = mysqli_fetch_assoc($sqllmstimetable)) { 
//------------------------------------------------
$srtime++;
//------------------------------------------------
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$srtime.'</td>
	<td style="width:150px;">'.$rowcurtime['days'].'</td>
	<td>'.$rowcurtime['period_no'].' ('.date("H:i A", strtotime($rowcurtime['time_start'])).' - '.date("H:i A", strtotime($rowcurtime['time_end'])).')</td>
	<td style="width:170px;">'.$rowcurtime['room_no'].' ('.get_classroomtypes($rowcurtime['room_type']).')</td>
</tr>';
//------------------------------------------------
}
}
}
echo '</tbody>
</table>';
}
//----------------------------------------

}


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