<?php 
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">';

echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Languages Skill</h3></span>
			<a data-toggle="modal" class="btn btn-mid btn-info pull-right" href="#empNewLangModal"><i class="icon-plus"></i> Add Skill </a>
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
$sqllmslngs  = $dblms->querylms("SELECT sk.id, sk.speaking, sk.reading, sk.writing, sk.id_language, sk.id_employee, lng.lang_name  
										FROM ".EMPLYS_LANGS_SKILLS." sk 
										INNER JOIN ".EMPLYS." emp ON emp.emply_id = sk.id_employee  
										INNER JOIN ".LANGS." lng ON lng.lang_id = sk.id_language   
										WHERE emp.id_campus	= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
										AND sk.id_employee = '".cleanvars($rowempid['emply_id'])."' ORDER BY lng.lang_name ASC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmslngs) > 0) {
echo '
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center; font-weight:600;">Sr.#</th>
	<th style="font-weight:600;">Language</th>
	<th style="font-weight:600;">Speaking</th>
	<th style="font-weight:600;">Writing</th>
	<th style="font-weight:600;">Reading</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srl = 0;
//------------------------------------------------
while($rowslngs = mysqli_fetch_array($sqllmslngs)) { 
//------------------------------------------------
$srl++;
//------------------------------------------------
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$srl.'</td>
	<td style="font-weight:600;">'.$rowslngs['lang_name'].'</td>
	<td style="width:85px; text-align:center;">'.get_levels($rowslngs['speaking']).'</td>
	<td style="width:85px; text-align:center;">'.get_levels($rowslngs['writing']).'</td>
	<td style="width:85px; text-align:center;">'.get_levels($rowslngs['reading']).'</td>
	<td style="width:50px; text-align:center;">
		<a class="btn btn-xs btn-info edit-skill-modal" data-toggle="modal" data-modal-window-title="Edit Language Skill" data-height="350" data-width="100%" data-skl-lng="'.$rowslngs['id_language'].'" data-skl-speak="'.$rowslngs['speaking'].'" data-skl-write="'.$rowslngs['writing'].'" data-skl-read="'.$rowslngs['reading'].'" data-skl-id="'.$rowslngs['id'].'" data-target="#empEditSkillModal"><i class="icon-pencil"></i></a>
		<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="#" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a>
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
