<?php 
//------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add']) && !isset($_GET['archive'])) { 
//------------------------------------------------
	$sqllmsfaqs  = $dblms->querylms("SELECT id, status, id_curs, question, answer 
										FROM ".COURSES_FAQS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										ORDER BY id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsfaqs) > 0) {
echo '
<div style="clear:both;"></div>
<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;"> 
	Total FAQs: ('.number_format(mysqli_num_rows($sqllmsfaqs)).') 
</div>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center;">Sr.#</th>
	<th style="font-weight:600;">FAQs</th>
	<th style="font-weight:600;">Answer</th>
	<th style="font-weight:600;text-align:center;">Status</th>
	<th style="width:40px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srf = 0;
//------------------------------------------------
while($rowfaqs = mysqli_fetch_assoc($sqllmsfaqs)) { 
//------------------------------------------------
$srf++;
//------------------------------------------------
echo '
<tr>
	<td style="width:40px;text-align:center">'.$srf.'</td>
	<td style="width:200px;">'.$rowfaqs['question'].'</td>
	<td>'.$rowfaqs['answer'].'</td>
	<td style="width:50px; text-align:center;">'.get_admstatus($rowfaqs['status']).'</td>
	<td style="width:50px; text-align:center;">
		<a class="btn btn-xs btn-info edit-faqs-modal" data-toggle="modal" data-modal-window-title="Edit FAQs" data-height="350" data-width="100%" data-faqs-status="'.$rowfaqs['status'].'" data-faqs-answer="'.$rowfaqs['answer'].'" data-faqs-question="'.$rowfaqs['question'].'" data-faqid="'.$rowfaqs['id'].'" data-target="#cursEditFAQsModal"><i class="icon-pencil"></i></a>
		<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="#" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a>
	</td>
</tr>';
//------------------------------------------------
	$sqllmslessonprgs  = $dblms->querylms("SELECT DISTINCT(clp.id_prg), clp.id, clp.id_setup, clp.semester, clp.section, clp.timing, 
										p.prg_name, p.prg_code, p.prg_id   
										FROM ".COURSES_FAQSPROGRAM." clp 
										LEFT JOIN ".PROGRAMS." p ON p.prg_id = clp.id_prg  
										WHERE clp.id_setup = '".cleanvars($rowfaqs['id'])."' ORDER BY clp.id ASC");
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
		<a class="btn btn-xs btn-warning" href="courses.php?id='.$_GET['id'].'&view=FAQs&editid='.$rowfaqs['id'].'"><i class="icon-edit"></i></a> 
	</td>
</tr>';
//------------------------------------------------
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