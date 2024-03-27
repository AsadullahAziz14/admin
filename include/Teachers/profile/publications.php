<?php 

echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Publications</h3></span>
			<a data-toggle="modal" class="btn btn-mid btn-info pull-right" href="profile.php?view=publications&add"><i class="icon-plus"></i> Add Record </a>
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

if(!isset($_GET['add']) && !isset($_GET['id'])){

	$sqllmsdeg  = $dblms->querylms("SELECT ed.id, ed.id_employee, ed.id_type, ed.title, ed.co_author, 
											ed.author, ed.year_date, ed.url 
											FROM ".EMPLYS_PUBLICATIONS." ed  
											INNER JOIN ".EMPLYS." emp ON emp.emply_id = ed.id_employee  
											WHERE emp.id_campus	= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
											AND ed.id_employee = '".cleanvars($rowempid['emply_id'])."' ORDER BY ed.id DESC");
	//--------------------------------------------------
	if (mysqli_num_rows($sqllmsdeg) > 0) {
	echo '
	<table class="footable table table-bordered table-hover">
	<thead>
	<tr>
		<th style="text-align:center; font-weight:600;">Sr.#</th>
		<th style="font-weight:600;">Title</th>
		<th style="font-weight:600;">Author</th>
		<th style="font-weight:600;">Date/Year</th>
		<th style="font-weight:600;">Type</th>
		<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
	</tr>
	</thead>
	<tbody>';
	$srl = 0;
	//------------------------------------------------
	while($rowsdeg = mysqli_fetch_array($sqllmsdeg)) { 
	//------------------------------------------------
	$srl++;
	//------------------------------------------------
	echo '
	<tr>
		<td style="width:50px;text-align:center;">'.$srl.'</td>
		<td>'.$rowsdeg['title'].'</td>
		<td>'.$rowsdeg['author'].'</td>
		<td>'.$rowsdeg['year_date'].'</td>
		<td>'.get_publishtype($rowsdeg['id_type']).'</td>
		<td style="width:50px; text-align:center;">
			<a class="btn btn-xs btn-info" href="profile.php?view=publications&id='.$rowsdeg['id'].'"><i class="icon-pencil"></i></a>
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

} else{

	include_once("modals/add_publication.php");
	include_once("modals/edit_publication.php");

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