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
			<span class="pull-left"><h3  style="font-weight:700;">Enrolled Students</h3></span>
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
$countstudents = 0;
//--------------------------------------------------
	$sqllmscurs  = $dblms->querylms("SELECT *      
										FROM ".SUMMER_COURSES." ca  
										INNER JOIN ".SUMMER_REGISTRATION." c ON c.id = ca.id_setup  
										INNER JOIN ".STUDENTS." s ON s.std_id = c.id_std  
										INNER JOIN ".PROGRAMS." p ON p.prg_id = c.id_prg  
										WHERE c.id_campus	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
										AND ca.id_curs = '".cleanvars($_GET['id'])."'  AND c.academic_session = '".ARCHIVE_SESS."'
										GROUP BY c.id_std ORDER BY s.std_session ASC, s.std_rollno ASC, s.std_regno ASC ");
	while($rowcurstds = mysqli_fetch_array($sqllmscurs)) { 
		$cursstudents[] = $rowcurstds;
	}
//--------------------------------------------------
if (mysqli_num_rows($sqllmscurs) > 0) {
echo '
<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;"> 
	Total Students: ('.number_format(mysqli_num_rows($sqllmscurs)).')
</div>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th style="font-weight:600; text-align:center;">Sr.#</th>
	<th style="font-weight:600; text-align:center;">Roll #</th>
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
foreach($cursstudents as $itemstd) { 
//------------------------------------------------
$srbk++;
//------------------------------------------------
if($itemstd['std_photo']) { 
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$itemstd['std_photo'].'" alt="'.$itemstd['std_name'].'"/>';
} else {
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$itemstd['std_name'].'"/>';
}
//------------------------------------------------
echo '
<tr>
	<td style="width:30px; text-align:center;vertical-align:middle;">'.$srbk.'</td>
	<td style="width:55px;text-align:center;vertical-align:middle;">'.$itemstd['std_rollno'].'</td>
	<td style="vertical-align:middle;">'.$itemstd['std_regno'].'</td>
	<td style="vertical-align:middle;">'.$stdphoto.'</td>
	<td style="vertical-align:middle;"><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$rowcurstds['std_name'].' ('.$itemstd['std_session'].')</b>" data-src="studentdetail.php?std_id='.$itemstd['std_id'].'" href="#">'.$itemstd['std_name'].'</a> </td>
	<td style="vertical-align:middle;">'.$itemstd['std_session'].'</td>
	<td style="vertical-align:middle;">'.$itemstd['prg_name'].'</td>
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