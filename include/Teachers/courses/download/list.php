<?php 
//------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add']) && !isset($_GET['archive'])) { 
//------------------------------------------------
	$sqllmsdwnlad  = $dblms->querylms("SELECT id, status, id_curs, lecture_slides, file_name, file_size, open_with, detail, file   
										FROM ".COURSES_DOWNLOADS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."'  
										ORDER BY id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsdwnlad) > 0) {
echo '
<div style="clear:both;"></div>
<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;"> 
	Total: ('.number_format(mysqli_num_rows($sqllmsdwnlad)).') 
</div>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center;">Sr.#</th>
	<th style="font-weight:600;">File Name</th>
	<th style="font-weight:600;">Size</th>
	<th style="font-weight:600;">Open With</th>
	<th style="font-weight:600;">Lecture Slides</th>
	<th style="font-weight:600; text-align:center;">Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srdn = 0;
//------------------------------------------------
while($rowdwnlad = mysqli_fetch_assoc($sqllmsdwnlad)) { 
//------------------------------------------------
$srdn++;

if($rowdwnlad['file']) { 
	$filedownload = '<a class="btn btn-xs btn-success" href="downloads/courses/'.$rowdwnlad['file'].'" target="_blank"> <i class="icon-download"></i></a> ';
} else  { 
	$filedownload = ' &nbsp;&nbsp;&nbsp;&nbsp;';
}

//------------------------------------------------
echo '
<tr>
	<td style="width:40px;text-align:center;">'.$srdn.'</td>
	<td>'.$rowdwnlad['file_name'].'</td>
	<td>'.$rowdwnlad['file_size'].'</td>
	<td>'.$rowdwnlad['open_with'].'</td>
	<td style="width:110px;text-align:center;">'.get_statusyesno($rowdwnlad['lecture_slides']).'</td>
	<td style="width:60px; text-align:center;">'.get_admstatus($rowdwnlad['status']).'</td>
	<td style="width:70px; text-align:center;">'.$filedownload.'
		<a class="btn btn-xs btn-info edit-Dwnld-modal" data-toggle="modal" data-modal-window-title="Edit Course Download" data-height="350" data-width="100%" data-Dwnldstatus="'.$rowdwnlad['status'].'" data-Dwnldfilename="'.$rowdwnlad['file_name'].'" data-Dwnldopenwith="'.$rowdwnlad['open_with'].'" data-Dwnlddetail="'.$rowdwnlad['detail'].'" data-Dwnldslides="'.$rowdwnlad['lecture_slides'].'" data-Dwnldid="'.$rowdwnlad['id'].'" data-target="#cursEditDwnldModal"><i class="icon-pencil"></i></a>
		<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="#" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a>
	</td>
</tr>';
//------------------------------------------------
	$sqllmslessonprgs  = $dblms->querylms("SELECT DISTINCT(clp.id_prg), clp.id, clp.id_setup, clp.semester, clp.section, clp.timing, 
										p.prg_name, p.prg_code, p.prg_id   
										FROM ".COURSES_DOWNLOADSPROGRAM." clp 
										INNER JOIN ".PROGRAMS." p ON p.prg_id = clp.id_prg  
										WHERE clp.id_setup = '".cleanvars($rowdwnlad['id'])."' ORDER BY clp.id ASC");
//------------------------------------------------
echo '
<tr>
	<td colspan="5"><b>Programs:</b>';
//------------------------------------------------
while($rowprgams = mysqli_fetch_assoc($sqllmslessonprgs)) { 	
	
	echo '<span style="font-weight:600; margin-left:20px; font-size:12px; color:blue;">'.strtoupper($rowprgams['prg_code']).' '.addOrdinalNumberSuffix($rowprgams['semester']).' '.$rowprgams['section'].' ( '.get_programtiming($rowprgams['timing']).')</span>';
}
//------------------------------------------------
echo '
	</td>
	<td style="width:50px; text-align:center;">
		<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&view=Downloads&editid='.$rowdwnlad['id'].'"><i class="icon-edit"></i></a> 
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