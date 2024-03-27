<?php 
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">';
if(isset($_GET['section'])) {  
	$section 		= $_GET['section'];
	$seccursquery 	= " AND section = '".$_GET['section']."'";
} else { 
	$section 		= '';
	$seccursquery 	= "";
}

echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Course Annoucements</h3></span> 
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
	$sqllmsannouce  = $dblms->querylms("SELECT * 
										FROM ".COURSES_ANNOUCEMENTS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".ARCHIVE_SESS."' 
										AND id_curs = '".cleanvars($_GET['id'])."' AND timing = '".cleanvars($_GET['timing'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' $seccursquery  
										AND id_prg = '".cleanvars($_GET['prgid'])."' ORDER BY dated DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsannouce) > 0) {
echo '
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center;">Sr.#</th>
	<th style="font-weight:600;text-align:center;">Date</th>
	<th style="font-weight:600;">Title</th>
	<th style="font-weight:600;">Detail</th>
	<th style="font-weight:600;text-align:center;">Status</th>
</tr>
</thead>
<tbody>';
$sanus = 0;
//------------------------------------------------
while($rowanus = mysqli_fetch_assoc($sqllmsannouce)) { 
//------------------------------------------------
$sanus++;
//------------------------------------------------
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$sanus.'</td>
	<td style="width:90px;">'.$rowanus['dated'].'</td>
	<td>'.$rowanus['caption'].'</td>
	<td>'.$rowanus['detail'].'</td>
	<td style="width:70px; text-align:center;">'.get_admstatus($rowanus['status']).'</td>
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