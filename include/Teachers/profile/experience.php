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
			<span class="pull-left"><h3  style="font-weight:700;">Experience</h3></span>
			<a data-toggle="modal" class="btn btn-mid btn-info pull-right" href="#empNewExpModal"><i class="icon-plus"></i> Add Record </a>
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
$sqllmsdeg  = $dblms->querylms("SELECT ed.id, ed.id_employee, ed.designation, ed.jobfield, ed.organization, 
										ed.jobdetail, ed.date_start, ed.date_end, ed.salary_start, ed.salary_end   
										FROM ".EMPLYS_EXPERIENCE." ed  
										INNER JOIN ".EMPLYS." emp ON emp.emply_id = ed.id_employee    
										WHERE emp.id_campus	= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
										AND ed.id_employee = '".cleanvars($rowempid['emply_id'])."' ORDER BY ed.date_start DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsdeg) > 0) {
echo '
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center; font-weight:600;">Sr.#</th>
	<th style="font-weight:600;">Job Field</th>
	<th style="font-weight:600;">Designation</th>
	<th style="font-weight:600;">Organization</th>
	<th style="font-weight:600;text-align:center;">Start Date</th>
	<th style="font-weight:600;text-align:center;">End Date</th>
	<th style="text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
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
	<td>'.$rowsdeg['jobfield'].'</td>
	<td>'.$rowsdeg['designation'].'</td>
	<td>'.$rowsdeg['organization'].'</td>
	<td style="width:90px; text-align:center;">'.$rowsdeg['date_start'].'</td>
	<td style="width:90px; text-align:center;">'.$rowsdeg['date_end'].'</td>
	<td style="width:50px; text-align:center;">
		<a class="btn btn-xs btn-info edit-exp-modal" data-toggle="modal" data-modal-window-title="Edit Experience" data-height="350" data-width="100%" data-exp-job="'.$rowsdeg['jobfield'].'" data-exp-des="'.$rowsdeg['designation'].'" data-exp-detail="'.$rowsdeg['jobdetail'].'" data-exp-org="'.$rowsdeg['organization'].'" data-exp-sdate="'.$rowsdeg['date_start'].'" data-exp-edate="'.$rowsdeg['date_end'].'" data-exp-ssalary="'.$rowsdeg['salary_start'].'" data-exp-esalary="'.$rowsdeg['salary_end'].'" data-expid="'.$rowsdeg['id'].'" data-target="#empEditExpModal"><i class="icon-pencil"></i></a>
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
