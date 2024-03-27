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
			<span class="pull-left"><h3  style="font-weight:700;">Assignments</h3></span>
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
	$sqllmsassign  = $dblms->querylms("SELECT id, status, id_curs, caption, detail, date_start, date_end, 
										total_marks, passing_marks, fileattach, timing    
										FROM ".COURSES_ASSIGNMENTS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".ARCHIVE_SESS."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' AND timing = '".cleanvars($_GET['timing'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' $seccursquery 
										AND id_prg = '".cleanvars($_GET['prgid'])."' ORDER BY id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsassign) > 0) {
echo '
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center; ">Sr.#</th>
	<th style="font-weight:600;">Title</th>
	<th style="font-weight:600;text-align:center; ">Total Marks</th>
	<th style="font-weight:600;text-align:center; ">Start Date</th>
	<th style="font-weight:600;text-align:center; ">End Date</th>
	<th style="font-weight:600;text-align:center; ">Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srbk = 0;
//------------------------------------------------
while($rowassign = mysqli_fetch_assoc($sqllmsassign)) { 
//------------------------------------------------
$srbk++;
if($rowassign['fileattach']) { 
	$filedownload = '<a class="btn btn-xs btn-success" href="downloads/assignments/teachers/'.$rowassign['fileattach'].'" target="_blank"> <i class="icon-download"></i></a> ';
} else  { 
	$filedownload = ' &nbsp;&nbsp;&nbsp;&nbsp;';
}

//------------------------------------------------
echo '
<tr>
	<td style="width:40px;">'.$srbk.'</td>
	<td>'.$rowassign['caption'].'</td>
	<td style="text-align:center; width:90px;">'.$rowassign['total_marks'].'</td>
	<td style="text-align:center; width:100px;">'.date("d/m/Y", strtotime($rowassign['date_start'])).'</td>
	<td style="text-align:center; width:100px;">'.date("d/m/Y", strtotime($rowassign['date_end'])).'</td>
	<td style="width:70px; text-align:center;">'.get_admstatus($rowassign['status']).'</td>
	<td style="width:70px; text-align:center;">'.$filedownload.' 
		<a class="btn btn-xs btn-info edit-assignment-modal" data-toggle="modal" data-modal-window-title="Edit Course Assignment" data-height="350" data-width="100%" data-assignstatus="'.$rowassign['status'].'" data-assignname="'.$rowassign['caption'].'" data-assignsdat="'.$rowassign['date_start'].'" data-assignedate="'.$rowassign['date_end'].'" data-assigntotalmarks="'.$rowassign['total_marks'].'" data-assignpassingmarks="'.$rowassign['passing_marks'].'" data-assigndetail="'.$rowassign['detail'].'" data-assignid="'.$rowassign['id'].'" data-target="#cursEditAssignModal"><i class="icon-zoom-in"></i></a>
		
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