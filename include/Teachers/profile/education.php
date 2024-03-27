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
			<span class="pull-left"><h3  style="font-weight:700;">Qualification</h3></span>
			<a data-toggle="modal" class="btn btn-mid btn-info pull-right" href="#empNewEduModal"><i class="icon-plus"></i> Add Record </a>
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
$sqllmsdeg  = $dblms->querylms("SELECT ed.id, ed.id_employee, ed.id_degree, ed.program, ed.subjects, 
										ed.institute, ed.grade, ed.year, ed.resultcard, de.degree_name  
										FROM ".EMPLYS_EDUCATION." ed  
										INNER JOIN ".EMPLYS." emp ON emp.emply_id = ed.id_employee  
										INNER JOIN ".HRM_DEGREES." de ON de.degree_id = ed.id_degree   
										WHERE emp.id_campus	= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
										AND ed.id_employee = '".cleanvars($rowempid['emply_id'])."' ORDER BY de.degree_name ASC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsdeg) > 0) {
echo '
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="text-align:center; font-weight:600;">Sr.#</th>
	<th style="font-weight:600;">Degree</th>
	<th style="font-weight:600;">Program</th>
	<th style="font-weight:600;">Subjects</th>
	<th style="font-weight:600;">Institute</th>
	<th style="font-weight:600;text-align:center;">Grade</th>
	<th style="font-weight:600;text-align:center;">Year</th>
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
	<td>'.$rowsdeg['degree_name'].'</td>
	<td>'.$rowsdeg['program'].'</td>
	<td>'.$rowsdeg['subjects'].'</td>
	<td>'.$rowsdeg['institute'].'</td>
	<td style="text-align:center;">'.$rowsdeg['grade'].'</td>
	<td style="text-align:center;">'.$rowsdeg['year'].'</td>
	<td style="width:50px; text-align:center;">
		<a class="btn btn-xs btn-info edit-edu-modal" data-toggle="modal" data-modal-window-title="Edit Qualification" data-height="350" data-width="100%" data-edu-degree="'.$rowsdeg['id_degree'].'" data-edu-prg="'.$rowsdeg['program'].'" data-edu-subjs="'.$rowsdeg['subjects'].'" data-edu-inst="'.$rowsdeg['institute'].'" data-edu-grade="'.$rowsdeg['grade'].'" data-edu-year="'.$rowsdeg['year'].'" data-edu-card="'.$rowsdeg['resultcard'].'" data-eduid="'.$rowsdeg['id'].'" data-target="#empEditEduModal"><i class="icon-pencil"></i></a>
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
