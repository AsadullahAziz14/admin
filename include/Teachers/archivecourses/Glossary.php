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
			<span class="pull-left"><h3  style="font-weight:700;">Course Glossary</h3></span>
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
	$sqllmsglsary  = $dblms->querylms("SELECT id, status, id_curs, caption, detail, timing  
										FROM ".COURSES_GLOSSARY." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".ARCHIVE_SESS."' 
										AND id_curs = '".cleanvars($_GET['id'])."' AND timing = '".cleanvars($_GET['timing'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' $seccursquery 
										AND id_prg = '".cleanvars($_GET['prgid'])."'  ORDER BY id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsglsary) > 0) {
echo '
<div style="clear:both;"></div>
<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;"> 
	Total: ('.number_format(mysqli_num_rows($sqllmsglsary)).') 
</div>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;">Sr.#</th>
	<th style="font-weight:600;">Caption</th>
	<th style="font-weight:600;">detail</th>
	<th style="font-weight:600;">Status</th>	
</tr>
</thead>
<tbody>';
$srgls = 0;
//------------------------------------------------
while($rowglsary = mysqli_fetch_assoc($sqllmsglsary)) { 
//------------------------------------------------
$srgls++;
//------------------------------------------------
echo '
<tr>
	<td style="width:50px;">'.$srgls.'</td>
	<td>'.$rowglsary['caption'].'</td>
	<td>'.$rowglsary['detail'].'</td>
	<td style="width:80px; text-align:center;">'.get_admstatus($rowglsary['status']).'</td>

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