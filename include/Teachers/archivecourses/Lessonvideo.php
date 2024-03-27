<?php 
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">';
//--------------------------------------
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
			<span class="pull-left"><h3  style="font-weight:700;">Lesson Videos</h3></span>
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
	$sqllmsvides  = $dblms->querylms("SELECT * 
										FROM ".COURSES_VIDEOLESSONS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".ARCHIVE_SESS."' 
										AND id_curs = '".cleanvars($_GET['id'])."' AND timing = '".cleanvars($_GET['timing'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' $seccursquery 
										AND id_prg = '".cleanvars($_GET['prgid'])."' ORDER BY id ASC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsvides) > 0) {
echo '
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center;">Sr.#</th>
	<th style="font-weight:600;">Title</th>
	<th style="font-weight:600;">Detail</th>
	<th style="font-weight:600;text-align:center;">Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$svido = 0;
//------------------------------------------------
while($rowvideos = mysqli_fetch_assoc($sqllmsvides)) { 
//------------------------------------------------
$svido++;
//------------------------------------------------
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$svido.'</td>
	<td>'.$rowvideos['caption'].'</td>
	<td>'.$rowvideos['detail'].'</td>
	<td style="width:70px; text-align:center;">'.get_admstatus($rowvideos['status']).'</td>
	<td style="width:70px; text-align:center;">
		<a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>'.$rowvideos['caption'].'</b>" data-src="coursevideoview.php?id='.$rowvideos['id'].'" href="#"><i class="icon-facetime-video"></i></a> 
	</td>
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