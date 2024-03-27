<?php 
//------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add']) && !isset($_GET['archive'])) { 
//------------------------------------------------
	$sqllmsglsary  = $dblms->querylms("SELECT id, status, id_curs, caption, detail, timing  
										FROM ".COURSES_GLOSSARY." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										ORDER BY id DESC");
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
	<th style="font-weight:600;text-align:center;">Sr.#</th>
	<th style="font-weight:600;">Caption</th>
	<th style="font-weight:600;">Detail</th>
	<th style="font-weight:600; text-align:center;">Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
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
	<td style="width:40px;text-align:center;">'.$srgls.'</td>
	<td style="width:200px;">'.$rowglsary['caption'].'</td>
	<td>'.$rowglsary['detail'].'</td>
	<td style="width:60px; text-align:center;">'.get_admstatus($rowglsary['status']).'</td>
	<td style="width:50px; text-align:center;">
		<a class="btn btn-xs btn-info edit-glsry-modal" data-toggle="modal" data-modal-window-title="Edit Glossary" data-height="350" data-width="100%" data-glsry-status="'.$rowglsary['status'].'" data-glsry-detail="'.$rowglsary['detail'].'" data-glsry-caption="'.$rowglsary['caption'].'" data-glsryid="'.$rowglsary['id'].'" data-target="#cursEditGlosryModal"><i class="icon-pencil"></i></a>
		<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="#" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a>
	</td>
</tr>';
//------------------------------------------------
	$sqllmslessonprgs  = $dblms->querylms("SELECT DISTINCT(clp.id_prg), clp.id, clp.id_setup, clp.semester, clp.section, clp.timing, 
										p.prg_name, p.prg_code, p.prg_id   
										FROM ".COURSES_GLOSSARYPROGRAM." clp 
										LEFT JOIN ".PROGRAMS." p ON p.prg_id = clp.id_prg  
										WHERE clp.id_setup = '".cleanvars($rowglsary['id'])."' ORDER BY clp.id ASC");
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
	<td style="width:50px; text-align:center;">
		<a class="btn btn-xs btn-warning" href="courses.php?id='.$_GET['id'].'&view=Glossary&editid='.$rowglsary['id'].'"><i class="icon-edit"></i></a> 
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
//------------------------------------------------