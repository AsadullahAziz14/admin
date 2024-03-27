<?php 
//------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add']) && !isset($_GET['archive'])) { 
//------------------------------------------------
	$sqllmsdrive  = $dblms->querylms("SELECT * 
										FROM ".COURSES_DRIVELINKS." cl 
										WHERE cl.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND cl.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND cl.id_curs = '".cleanvars($_GET['id'])."' 
										AND cl.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										ORDER BY cl.id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsdrive) > 0) {
echo '
<div style="clear:both;"></div>
<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;padding:0;"> 
	Total: ('.number_format(mysqli_num_rows($sqllmsdrive)).') 
</div>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;">Sr.#</th>
	<th style="font-weight:600;">Title</th>
	<th style="font-weight:600;">Drive Link</th>
	<th style="font-weight:600;text-align:center">Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srdr = 0;
//------------------------------------------------
while($rowdrive = mysqli_fetch_assoc($sqllmsdrive)) { 
//------------------------------------------------
$srdr++;
//------------------------------------------------
echo '
<tr>
	<td style="width:40px;text-align:center;">'.$srdr.'</td>
	<td style="width:200px;">'.$rowdrive['caption'].'</td> 
	<td>
		<a href="'.$rowdrive['drive_link'].'" target="_blank" class="links-blue">'.$rowdrive['drive_link'].'</a>
	</td>
	<td style="width:50px; text-align:center;">'.get_admstatus($rowdrive['status']).'</td>
	<td style="width:50px; text-align:center;">
		<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&view=Drivelinks&editid='.$rowdrive['id'].'"><i class="icon-edit"></i>
		</a> 
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
}