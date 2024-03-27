<?php 
//----------------------------------------
echo '<title>Weekly Lecture Schedule - '.TITLE_HEADER.'</title>
<script type="text/javascript" src="js/jquery/jquery.js"></script>
<!-- Matter -->
<div class="matter">
<div class="widget headerbar-widget">
	<div class="pull-left dashboard-user-picture"><img class="avatar-small" src="'.$_SESSION['userlogininfo']['LOGINIDAPIC'].'" alt="'.$_SESSION['userlogininfo']['LOGINFNAMEA'].'"/></div>
	<div class="headerbar-project-title pull-left">
		<h3 style="font-weight:600;">'.$_SESSION['userlogininfo']['LOGINFNAMEA'].'</h3>
	</div>
	<div class="dashboard-user-group pull-right">
		<label class="label label-default">'.$_SESSION['userlogininfo']['LOGINFNAMEA'].'</label>
	</div>
	<div class="clearfix"></div>
</div>
<!--WI_CLIENTS_SEARCH END-->
<div class="container">
<!--WI_MY_TASKS_TABLE-->
<div class="row fullscreen-mode">
<div class="col-md-12">
<div class="widget">
<div class="widget-content">';

if($_SESSION['userlogininfo']['LOGINIDCOM'] != 1) {
echo '
<h3 class="modal-title" style="font-weight:700; margin:10px;"> 
	Weekly Lecture Schedule (<span style="color:blue;">Morning</span>)<span style="float:right; font-size:13px; color:#F00;"></span>
</h3>';

//---------------------------------------
echo '
<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
<th style="font-weight:600; text-align:center; vertical-align:middle;">Days</th>';
//--------------------------------------------
	$sqllms  = $dblms->querylms("SELECT emp.emply_id  
										FROM ".EMPLYS." emp  
										WHERE emp.id_campus	= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
										AND emp.emply_loginid = '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' LIMIT 1");
	$rowsstd = mysqli_fetch_array($sqllms);
//--------------------------------------------
	$sqllmsperiods  = $dblms->querylms("SELECT  *  
										FROM ".TIMETABLE_DETAILS." d 
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										WHERE t.id_campus	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND d.id_teacher 	= '".cleanvars($rowsstd['emply_id'])."' 
										AND t.status 		= '1' AND t.timing = '1' 
										GROUP BY d.period_no ORDER BY d.period_no ASC");
//------------------------------------------------
$counts = mysqli_num_rows($sqllmsperiods);
$periods = array();
//------------------------------------------------
while($rowperiod = mysqli_fetch_array($sqllmsperiods)) {
//--------------------------------------------
$periods[] = $rowperiod;
//--------------------------------------------
	echo '<th style="font-weight:600; text-align:center;vertical-align:middle;">
			Period: '.$rowperiod['period_no'].'
		</th>';
}
//--------------------------------------------
echo '</tr>';
//--------------------------------------------
foreach($daysname2 as $days) {
//--------------------------------------------
	echo '<tr>
			<th style="font-weight:600; text-align:center; vertical-align:middle; height:70px;">'.$days.'</th>';
//--------------------------------------------
foreach($periods as $itemperiod) { 
//--------------------------------------------
	$sqllmstimetable  = $dblms->querylms("SELECT c.curs_id, c.curs_code, c.curs_name, r.room_no, d.time_start, d.time_end, 
												d.theorypractical, t.id_prg, t.semester, t.section, t.timing      
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										INNER JOIN ".COURSES." c ON c.curs_id = d.id_curs 
										INNER JOIN ".TIMETABLE_ROOMS." r ON r.room_id = d.id_room    
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' AND t.status = '1' AND t.timing = '1'
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND d.period_no = '".cleanvars($itemperiod['period_no'])."'	AND d.days = '".cleanvars($days)."' LIMIT 1");
	$rowtimetable = mysqli_fetch_assoc($sqllmstimetable);
//--------------------------------------------	
	if(mysqli_num_rows($sqllmstimetable)>0) {

if($rowtimetable['section']) { 
	$hrefsection = "&section=".$rowtimetable['section'];
} else { 
	$hrefsection = "";
}

		echo '<td style="text-align:center; color:#00F; background-color:#FFFFBF; width:195px;">
				<span style="color:#444; font-weight:600;">
					('.date("H:i A", strtotime($rowtimetable['time_start'])).' - '.date("H:i A", strtotime($rowtimetable['time_end'])).')
				</span>
				<br>
				Room#: '.$rowtimetable['room_no'].'<br>
				<a href="courses.php?id='.$rowtimetable['curs_id'].'&prgid='.$rowtimetable['id_prg'].'&timing='.$rowtimetable['timing'].'&semester='.$rowtimetable['semester'].$hrefsection.'" style="color:#00F;">'.$rowtimetable['curs_code'].'-'.$rowtimetable['curs_name'].' ('.get_theorypractical($rowtimetable['theorypractical']).')</a><br>
				
			</td>';
	} else {
		echo '<td style="text-align:center; width:195px;"></td>';
	}
//--------------------------------------------
}
//--------------------------------------------
echo '</tr>';
//--------------------------------------------
}
//--------------------------------------------
echo '
</thead>
<tbody>
</tbody>
</table>';

//-----------------------------------------
} else {
echo '
<h3 class="modal-title" style="font-weight:700; margin:10px;"> 
	Weekly Lecture Schedule (<span style="color:blue;">Morning</span>)<span style="float:right; font-size:13px; color:#F00;"></span>
</h3>';

//---------------------------------------
echo '
<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
<th style="font-weight:600; text-align:center; vertical-align:middle;width:100px;">Days</th>';
//--------------------------------------------
	$sqllms  = $dblms->querylms("SELECT emp.emply_id  
										FROM ".EMPLYS." emp  
										WHERE emp.id_campus	= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
										AND emp.emply_loginid = '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."' LIMIT 1");
	$rowsstd = mysqli_fetch_array($sqllms);
//--------------------------------------------
	$sqllmsperiods  = $dblms->querylms("SELECT r.period_id, r.period_status, r.period_no, r.period_timestart, r.period_timeend 
										FROM ".TIMETABLE_PERIODS." r 
										WHERE r.id_campus	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND r.period_timing = '1'
										ORDER BY r.period_ordering ASC");
//------------------------------------------------
$counts = mysqli_num_rows($sqllmsperiods);
$periods = array();
//------------------------------------------------
while($rowperiod = mysqli_fetch_array($sqllmsperiods)) {
//--------------------------------------------
$periods[] = $rowperiod;
//--------------------------------------------
	echo '<th style="font-weight:600; text-align:center;">
			'.$rowperiod['period_no'].' 
		</th>';
}
//--------------------------------------------
echo '</tr>';
//--------------------------------------------
foreach($daysname as $days) {
//--------------------------------------------
	echo '<tr>
			<th style="font-weight:600; text-align:center; vertical-align:middle; height:70px;">'.$days.'</th>';
//--------------------------------------------
foreach($periods as $itemperiod) { 
//--------------------------------------------
	$sqllmstimetable  = $dblms->querylms("SELECT c.curs_id, c.curs_code, c.curs_name, r.room_no, d.time_end, d.time_start,
												d.theorypractical, t.id_prg, t.semester, t.section, t.timing      
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										INNER JOIN ".COURSES." c ON c.curs_id = d.id_curs 
										INNER JOIN ".TIMETABLE_ROOMS." r ON r.room_id = d.id_room    
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' AND t.status = '1' AND t.timing = '1'
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND d.id_period = '".cleanvars($itemperiod['period_id'])."'	AND d.days = '".cleanvars($days)."' LIMIT 1");
	$rowtimetable = mysqli_fetch_assoc($sqllmstimetable);
//--------------------------------------------	
	if(mysqli_num_rows($sqllmstimetable)>0) {

if($rowtimetable['section']) { 
	$hrefsection = "&section=".$rowtimetable['section'];
} else { 
	$hrefsection = "";
}

		echo '<td style="text-align:center; color:#00F; background-color:#FFFFBF; width:195px;">
				<span style="color:#444; font-weight:600;">
					('.date("H:i A", strtotime($rowtimetable['time_start'])).' - '.date("H:i A", strtotime($rowtimetable['time_end'])).')
				</span>
				<br>
				Room#: '.$rowtimetable['room_no'].'<br>
				<a href="courses.php?id='.$rowtimetable['curs_id'].'&prgid='.$rowtimetable['id_prg'].'&timing='.$rowtimetable['timing'].'&semester='.$rowtimetable['semester'].$hrefsection.'" style="color:#00F;">'.$rowtimetable['curs_code'].'-'.$rowtimetable['curs_name'].' ('.get_theorypractical($rowtimetable['theorypractical']).')</a><br>
			</td>';
	} else {
		echo '<td style="text-align:center; width:195px;"></td>';
	}
//--------------------------------------------
}
//--------------------------------------------
echo '</tr>';
//--------------------------------------------
}
//--------------------------------------------
echo '
</thead>
<tbody>
</tbody>
</table>';
//------------------------Evening--------------------
	$sqllmsevenperiods  = $dblms->querylms("SELECT  *  
										FROM ".TIMETABLE_DETAILS." d 
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' AND t.status = '1' AND t.timing = '4'										
										GROUP BY d.period_no ORDER BY d.period_no ASC");
//------------------------------------------------
if(mysqli_num_rows($sqllmsevenperiods)>0) {
echo '
<h3 class="modal-title" style="font-weight:700; margin:10px;"> 
	Weekly Lecture Schedule (<span style="color:blue;">Evening</span>)<span style="float:right; font-size:13px; color:#F00;"></span>
</h3>';

echo '
<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
<th style="font-weight:600; text-align:center; vertical-align:middle; width:3%;">Days</th>';

$evenperiods = array();
//------------------------------------------------
while($rowevenperiod = mysqli_fetch_array($sqllmsevenperiods)) {
//--------------------------------------------
$evenperiods[] = $rowevenperiod;
//--------------------------------------------
	echo '<th style="font-weight:600; text-align:center; width:20%">
			Period-'.$rowevenperiod['period_no'].'
		</th>';
}
//--------------------------------------------
echo '</tr>';
//--------------------------------------------
foreach($daysname as $days) {
//--------------------------------------------
	echo '<tr>
			<th style="font-weight:600; text-align:center; vertical-align:middle; height:75px;">'.$days.'</th>';
//--------------------------------------------
foreach($evenperiods as $itemperiod) { 
//--------------------------------------------
	$sqllmstimeeven  = $dblms->querylms("SELECT c.curs_id, c.curs_code, c.curs_name, r.room_no, d.time_end, d.time_start, 
												d.theorypractical, t.id_prg, t.semester, t.section, t.timing      
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										INNER JOIN ".COURSES." c ON c.curs_id = d.id_curs 
										INNER JOIN ".TIMETABLE_ROOMS." r ON r.room_id = d.id_room    
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' AND t.status = '1' AND t.timing = '4'
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND d.period_no = '".cleanvars($itemperiod['period_no'])."'	
										AND d.days = '".cleanvars($days)."' LIMIT 1");
//--------------------------------------------	
	if(mysqli_num_rows($sqllmstimeeven)>0) {
	$rowtimeeven = mysqli_fetch_assoc($sqllmstimeeven);
if($rowtimeeven['section']) { 
	$evhrefsection = "&section=".$rowtimeeven['section'];
} else { 
	$evhrefsection = "";
}
		echo '<td style="text-align:center; color:#00F; background-color:#FFFFBF;">
			('.date("H:i A", strtotime($rowtimeeven['time_start'])).' - '.date("H:i A", strtotime($rowtimeeven['time_end'])).')<br>
			Room#: '.$rowtimeeven['room_no'].'<br>
			<a href="courses.php?id='.$rowtimeeven['curs_id'].'&prgid='.$rowtimeeven['id_prg'].'&timing='.$rowtimeeven['timing'].'&semester='.$rowtimeeven['semester'].$evhrefsection.'" style="color:#00F;">'.$rowtimeeven['curs_code'].' - '.$rowtimeeven['curs_name'].' ('.get_theorypractical($rowtimeeven['theorypractical']).')</a></td>';
	} else {
		echo '<td style="text-align:center;"></td>';
	}
//--------------------------------------------
}
//--------------------------------------------
echo '</tr>';
//--------------------------------------------
}
//--------------------------------------------
echo '
</thead>
<tbody>
</tbody>
</table>';
	
}
	
//-------------Weekend-------------------------------
	$sqllmsperiods  = $dblms->querylms("SELECT  *  
										FROM ".TIMETABLE_DETAILS." d 
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' AND t.status = '1' AND t.timing = '2'										
										GROUP BY d.period_no ORDER BY d.period_no ASC");
//------------------------------------------------
if(mysqli_num_rows($sqllmsperiods)>0) {
echo '
<h3 class="modal-title" style="font-weight:700; margin:10px;"> 
	Weekly Lecture Schedule (<span style="color:blue;">Weekend</span>)<span style="float:right; font-size:13px; color:#F00;"></span>
</h3>';

echo '
<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
<th style="font-weight:600; text-align:center; vertical-align:middle; width:3%;">Days</th>';

$periods = array();
//------------------------------------------------
while($rowperiod = mysqli_fetch_array($sqllmsperiods)) {
//--------------------------------------------
$periods[] = $rowperiod;
//--------------------------------------------
	echo '<th style="font-weight:600; text-align:center; width:20%">
			Period-'.$rowperiod['period_no'].'
		</th>';
}
//--------------------------------------------
echo '</tr>';
//--------------------------------------------
foreach($dayweekend as $days) {
//--------------------------------------------
	echo '<tr>
			<th style="font-weight:600; text-align:center; vertical-align:middle; height:75px;">'.$days.'</th>';
//--------------------------------------------
foreach($periods as $itemperiod) { 
//--------------------------------------------
	$sqllmstimeevning  = $dblms->querylms("SELECT c.curs_id, c.curs_code, c.curs_name, r.room_no, d.time_end, d.time_start, 
												d.theorypractical, t.id_prg, t.semester, t.section, t.timing      
										FROM ".TIMETABLE_DETAILS." d  
										INNER JOIN ".TIMETABLE." t ON t.id = d.id_setup   
										INNER JOIN ".COURSES." c ON c.curs_id = d.id_curs 
										INNER JOIN ".TIMETABLE_ROOMS." r ON r.room_id = d.id_room    
										WHERE t.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND d.id_teacher = '".cleanvars($rowsstd['emply_id'])."' AND t.status = '1' AND t.timing = '2'
										AND t.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND d.period_no = '".cleanvars($itemperiod['period_no'])."'	
										AND d.days = '".cleanvars($days)."' LIMIT 1");
//--------------------------------------------	
	if(mysqli_num_rows($sqllmstimeevning)>0) {
	$rowtimeevening = mysqli_fetch_assoc($sqllmstimeevning);
if($rowtimeevening['section']) { 
	$ehrefsection = "&section=".$rowtimeevening['section'];
} else { 
	$ehrefsection = "";
}
		echo '<td style="text-align:center; color:#00F; background-color:#FFFFBF;">
			('.date("H:i A", strtotime($rowtimeevening['time_start'])).' - '.date("H:i A", strtotime($rowtimeevening['time_end'])).')<br>
			Room#: '.$rowtimeevening['room_no'].'<br>
			<a href="courses.php?id='.$rowtimeevening['curs_id'].'&prgid='.$rowtimeevening['id_prg'].'&timing='.$rowtimeevening['timing'].'&semester='.$rowtimeevening['semester'].$ehrefsection.'" style="color:#00F;">'.$rowtimeevening['curs_code'].' - '.$rowtimeevening['curs_name'].' ('.get_theorypractical($rowtimeevening['theorypractical']).')</a></td>';
	} else {
		echo '<td style="text-align:center;"></td>';
	}
//--------------------------------------------
}
//--------------------------------------------
echo '</tr>';
//--------------------------------------------
}
//--------------------------------------------
echo '
</thead>
<tbody>
</tbody>
</table>';
	
}
	
	
}




echo '
</div>
</div>
</div>
</div>
<!--WI_MY_TASKS_TABLE-->
<!--WI_NOTIFICATION-->       
<!--WI_NOTIFICATION-->
</div>
</div>
<!-- Matter ends -->
</div>
<!-- Mainbar ends -->
<div class="clearfix"></div>
</div>
<!-- Content ends -->
<!-- Footer starts -->
<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<p class="copy">Powered by: | <a href="'.COPY_RIGHTS_URL.'" target="_blank">'.COPY_RIGHTS.'</a> </p>
			</div>
		</div>
	</div>
</footer>
<!-- Footer ends -->

<!-- Scroll to top -->
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>';
echo '

<!--WI_IFRAME_MODAL-->
<div class="row">
	<div id="modalIframe" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
					<h4 class="modal-title" id="modal-iframe-title"> Edit</h4>
					<div class="clearfix"></div>
				</div>
				<div class="modal-body">
					<iframe frameborder="0" class="slimScrollBarModal----"></iframe>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!--WI_IFRAME_MODAL-->
<script type="text/javascript">
// close the div in 5 secs
window.setTimeout("closeHelpDiv();", 5000, 2500);

function closeHelpDiv(){
	document.getElementById("infoupdated").style.display=" none";
}
</script>
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>

<script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js"></script>
<script type="text/javascript">
	$(function () {
		$(".footable").footable();
	});
</script>
<script type="text/javascript" src="js/custom/custom.js"></script>
<script type="text/javascript" src="js/custom/custom.general.js"></script>
</body>
</html>'; 
//--------------------------------
?>