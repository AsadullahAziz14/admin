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
			<span class="pull-left"><h3  style="font-weight:700;">Downloads</h3></span> 
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
	$sqllmsdwnlad  = $dblms->querylms("SELECT id, status, id_curs, file_name, file_size, open_with, detail, file   
										FROM ".COURSES_DOWNLOADS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".ARCHIVE_SESS."' 
										AND id_curs = '".cleanvars($_GET['id'])."' AND timing = '".cleanvars($_GET['timing'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND id_prg = '".cleanvars($_GET['prgid'])."' ORDER BY id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsdwnlad) > 0) {
echo '
<div style="clear:both;"></div>
<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;"> 
	Total: ('.number_format(mysqli_num_rows($sqllmsdwnlad)).') 
</div>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;">Sr.#</th>
	<th style="font-weight:600;">File Name</th>
	<th style="font-weight:600;">Size</th>
	<th style="font-weight:600;">Open With</th>
	<th style="font-weight:600; text-align:center;">Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srdn = 0;
//------------------------------------------------
while($rowdwnlad = mysqli_fetch_assoc($sqllmsdwnlad)) { 
//------------------------------------------------
$srdn++;

if($rowdwnlad['file']) { 
	$filedownload = '<a class="btn btn-xs btn-success" href="downloads/courses/'.$rowdwnlad['file'].'" target="_blank"> <i class="icon-download"></i></a> ';
} else  { 
	$filedownload = ' &nbsp;&nbsp;&nbsp;&nbsp;';
}

//------------------------------------------------
echo '
<tr>
	<td style="width:50px;">'.$srdn.'</td>
	<td>'.$rowdwnlad['file_name'].'</td>
	<td>'.$rowdwnlad['file_size'].'</td>
	<td>'.$rowdwnlad['open_with'].'</td>
	<td style="width:70px; text-align:center;">'.get_admstatus($rowdwnlad['status']).'</td>
	<td style="width:40px; text-align:center;">'.$filedownload.'</td>
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