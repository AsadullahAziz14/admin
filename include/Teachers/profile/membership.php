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
			<span class="pull-left"><h3  style="font-weight:700;">Membership</h3></span>
			<a data-toggle="modal" class="btn btn-mid btn-info pull-right" href="#empNewMemModal"><i class="icon-plus"></i> Add Record </a>
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
$sqllmsdeg  = $dblms->querylms("SELECT ed.id, ed.id_employee, ed.designation, ed.memno, ed.organization, 
										ed.startdate, ed.enddate  
										FROM ".EMPLYS_MEMBERSHIP." ed  
										INNER JOIN ".EMPLYS." emp ON emp.emply_id = ed.id_employee    
										WHERE emp.id_campus	= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
										AND ed.id_employee = '".cleanvars($rowempid['emply_id'])."' ORDER BY ed.startdate DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsdeg) > 0) {
echo '
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center; font-weight:600;">Sr.#</th>
	<th style="font-weight:600;">Mem #</th>
	<th style="font-weight:600;">Designation</th>
	<th style="font-weight:600;">Organization</th>
	<th style="text-align:center;font-weight:600;">Start Date</th>
	<th style="text-align:center;font-weight:600;">End Date</th>
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
	<td>'.$rowsdeg['memno'].'</td>
	<td>'.$rowsdeg['designation'].'</td>
	<td>'.$rowsdeg['organization'].'</td>
	<td style="width:90px; text-align:center;">'.$rowsdeg['startdate'].'</td>
	<td style="width:90px; text-align:center;">'.$rowsdeg['enddate'].'</td>
	<td style="width:50px; text-align:center;">
		<a class="btn btn-xs btn-info edit-mem-modal" data-toggle="modal" data-modal-window-title="Edit Membership" data-height="350" data-width="100%" data-mem-no="'.$rowsdeg['memno'].'" data-mem-des="'.$rowsdeg['designation'].'" data-mem-org="'.$rowsdeg['organization'].'" data-mem-sdate="'.$rowsdeg['startdate'].'" data-mem-edate="'.$rowsdeg['enddate'].'" data-memid="'.$rowsdeg['id'].'" data-target="#empEditMemModal"><i class="icon-pencil"></i></a>
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