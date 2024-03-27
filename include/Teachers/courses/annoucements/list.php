<?php 

if(!isset($_GET['editid']) && !isset($_GET['add'])) {
	$sqllmsannouce  = $dblms->querylms("SELECT id, dated, caption, status, detail 
										FROM ".COURSES_ANNOUCEMENTS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										ORDER BY dated DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsannouce) > 0) {
echo '
<div style=" float:right; text-align:right; font-weight:700; color:#00f; margin:0 10px 0 0;">
	Total Records: ('.number_format(mysqli_num_rows($sqllmsannouce)).')
</div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center;">Sr.#</th>
	<th style="font-weight:600;text-align:center;">Date</th>
	<th style="font-weight:600;">Title</th>
	<th style="font-weight:600;text-align:center;">Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$sanus = 0;
//------------------------------------------------
while($rowanus = mysqli_fetch_assoc($sqllmsannouce)) { 
//------------------------------------------------
$sanus++;
//------------------------------------------------
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$sanus.'</td>
	<td style="width:80px;">'.date("d/m/Y", strtotime($rowanus['dated'])).'</td>
	<td>'.$rowanus['caption'].'</td>
	<td style="width:60px; text-align:center;">'.get_admstatus($rowanus['status']).'</td>
	<td style="width:70px; text-align:center;">
		<a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>'.$rowanus['caption'].'</b>" data-src="courseannouncementview.php?id='.$rowanus['id'].'" href="#"><i class="icon-zoom-in"></i></a> 
		<a class="btn btn-xs btn-info edit-annoucement-modal" data-toggle="modal" data-modal-window-title="Edit Course Announcement" data-height="350" data-width="100%" data-annoucement-status="'.$rowanus['status'].'" data-annoucement-detail="'.$rowanus['detail'].'" data-annoucement-caption="'.$rowanus['caption'].'" data-annoucementid="'.$rowanus['id'].'" data-target="#cursEditAnnoucementModal"><i class="icon-pencil"></i></a>
		<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="#" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a>
	</td>
</tr>';
	$sqllmslessonprgs  = $dblms->querylms("SELECT DISTINCT(clp.id_prg), clp.id, clp.id_setup, clp.semester, clp.section, clp.timing, 
										p.prg_name, p.prg_code, p.prg_id   
										FROM ".COURSES_ANNOUCEMENTSPROGRAM." clp 
										LEFT JOIN ".PROGRAMS." p ON p.prg_id = clp.id_prg  
										WHERE clp.id_setup = '".cleanvars($rowanus['id'])."' ORDER BY clp.id ASC");
//------------------------------------------------
echo '
<tr>
	<td colspan="4">';
//------------------------------------------------
while($rowprgams = mysqli_fetch_assoc($sqllmslessonprgs)) { 	
	
	if($rowprgams['prg_code']) {
		$prgcode = strtoupper($rowprgams['prg_code']).' Semester: '.addOrdinalNumberSuffix($rowprgams['semester']).' '.$rowprgams['section'].' ( '.get_programtiming($rowprgams['timing']).')';
	} else {
		$prgcode = 'LA: Section: '.$rowprgams['section'].' ( '.get_programtiming($rowprgams['timing']).')';
	}
	
	echo '<span style="font-weight:600; margin-right:20px; font-size:12px; color:blue;">'.$prgcode.'</span>';
	
}
//------------------------------------------------
echo '
	</td>
	<td style="width:70px; text-align:center;">
		<a class="btn btn-xs btn-warning" href="courses.php?id='.$_GET['id'].'&view=Annoucements&editid='.$rowanus['id'].'"><i class="icon-edit"></i></a> 
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