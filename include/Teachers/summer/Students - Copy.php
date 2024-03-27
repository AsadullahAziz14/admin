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
			<span class="pull-left"><h3  style="font-weight:700;">Students</h3></span>
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
	
	$sqllmsstds  = $dblms->querylms("SELECT * FROM ".STUDENTS." std 
										  INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
										  WHERE std.std_status = '2' 
										  AND std.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										  AND std.id_prg = '".cleanvars($rowsurs['id_prg'])."'
										  AND std.std_semester = '".cleanvars($rowsurs['semester'])."'
										  ORDER BY std.std_rollno ASC, std.std_regno ASC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsstds) > 0) {
echo '
<div class="navbar-form navbar-right" style="font-weight:700; color:red; margin-right:10px; margin-top:0px;"> 
	Total Students: ('.number_format(mysqli_num_rows($sqllmsstds)).')
</div>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th style="font-weight:600;">Sr.#</th>
	<th style="font-weight:600;">Roll No</th>
	<th style="font-weight:600;">Reg #</th>
	<th width="35px" style="font-weight:600;">Pic</th>
	<th style="font-weight:600;">Student Name</th>
	<th style="font-weight:600;">Session</th>
	<th style="font-weight:600;">Program</th>
</tr>
</thead>
<tbody>';
$srbk = 0;
//------------------------------------------------
while($rowcurstds = mysqli_fetch_assoc($sqllmsstds)) { 
//------------------------------------------------
$srbk++;
//------------------------------------------------
if($rowcurstds['std_photo']) { 
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$rowcurstds['std_photo'].'" alt="'.$rowcurstds['std_name'].'"/>';
} else {
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$rowcurstds['std_name'].'"/>';
}
//------------------------------------------------
echo '
<tr>
	<td style="width:30px;">'.$srbk.'</td>
	<td>'.$rowcurstds['std_rollno'].'</td>
	<td>'.$rowcurstds['std_regno'].'</td>
	<td>'.$stdphoto.'</td>
	<td><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$rowcurstds['std_name'].' ('.$rowcurstds['std_session'].')</b>" data-src="studentdetail.php?std_id='.$rowcurstds['std_id'].'" href="#">'.$rowcurstds['std_name'].'</a> </td>
	<td>'.$rowcurstds['std_session'].'</td>
	<td>'.$rowcurstds['prg_name'].'</td>
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