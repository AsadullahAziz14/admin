<?php 
//------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add']) && !isset($_GET['archive'])) {
	$sqllmsvides  = $dblms->querylms("SELECT * 
										FROM ".COURSES_VIDEOLESSONS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' ORDER BY id ASC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsvides) > 0) {
echo '
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center;">Sr.#</th>
	<th style="font-weight:600;">Title</th>
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
	<td style="width:50px; text-align:center;">'.get_admstatus($rowvideos['status']).'</td>
	<td style="width:70px; text-align:center;">
		<a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>'.$rowvideos['caption'].'</b>" data-src="coursevideoview.php?id='.$rowvideos['id'].'" href="#"><i class="icon-facetime-video"></i></a> 
		<a class="btn btn-xs btn-info edit-lessonvideo-modal" data-toggle="modal" data-modal-window-title="Edit Course Announcement" data-height="350" data-width="100%" data-video-status="'.$rowvideos['status'].'" data-video-embed="'.$rowvideos['embedcode'].'" data-video-detail="'.$rowvideos['detail'].'" data-video-caption="'.$rowvideos['caption'].'" data-videoid="'.$rowvideos['id'].'" data-target="#cursEditVideoModal"><i class="icon-pencil"></i></a>
		<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="#" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a>
	</td>
</tr>';
	$sqllmslessonprgs  = $dblms->querylms("SELECT DISTINCT(clp.id_prg), clp.id, clp.id_setup, clp.semester, clp.section, clp.timing, 
										p.prg_name, p.prg_code, p.prg_id   
										FROM ".COURSES_VIDEOLESSONSPROGRAM." clp 
										INNER JOIN ".PROGRAMS." p ON p.prg_id = clp.id_prg  
										WHERE clp.id_setup = '".cleanvars($rowvideos['id'])."' ORDER BY clp.id ASC");
//------------------------------------------------
echo '
<tr>
	<td colspan="3"><b>Programs:</b>';
//------------------------------------------------
while($rowprgams = mysqli_fetch_assoc($sqllmslessonprgs)) { 	
	
	echo '<span style="font-weight:600; margin-left:20px; font-size:12px; color:blue;">'.strtoupper($rowprgams['prg_code']).' '.addOrdinalNumberSuffix($rowprgams['semester']).' '.$rowprgams['section'].' ( '.get_programtiming($rowprgams['timing']).')</span>';
}
//------------------------------------------------
echo '
	</td>
	<td style="width:70px; text-align:center;">
		<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&view=Lessonvideo&editid='.$rowvideos['id'].'"><i class="icon-edit"></i></a> 
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