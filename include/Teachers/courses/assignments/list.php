<?php 
//------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add']) && !isset($_GET['archive'])) { 


//------------------------------------------------
	$sqllmsassign  = $dblms->querylms("SELECT id, status, id_curs, caption, detail, date_start, date_end, 
										is_midterm, total_marks, passing_marks, fileattach, timing    
										FROM ".COURSES_ASSIGNMENTS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'
										AND id_prg = '".cleanvars($_GET['prg_id'])."'										
										ORDER BY id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsassign) > 0) {

echo '
<div style=" float:right; text-align:right; font-weight:700; color:#00f; margin:0 10px 0 0;">
	Total Records: ('.number_format(mysqli_num_rows($sqllmsassign)).')
</div>
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
	<td style="width:40px;text-align:center;">'.$srbk.'</td>
	<td>'.$rowassign['caption'].'</td>
	<td style="text-align:center; width:90px;">'.$rowassign['total_marks'].'</td>
	<td style="text-align:center; width:100px;">'.date("d/m/Y", strtotime($rowassign['date_start'])).'</td>
	<td style="text-align:center; width:100px;">'.date("d/m/Y", strtotime($rowassign['date_end'])).'</td>
	<td style="width:60px; text-align:center;">'.get_admstatus($rowassign['status']).'</td>
	<td style="width:70px; text-align:center;">'.$filedownload;
if($rowassign['is_midterm'] != 1) { 
echo '
		<a class="btn btn-xs btn-info edit-assignment-modal" data-toggle="modal" data-modal-window-title="Edit Course Assignment" data-height="350" data-width="100%" data-assignstatus="'.$rowassign['status'].'" data-assignname="'.$rowassign['caption'].'" data-assignsdat="'.$rowassign['date_start'].'" data-assignedate="'.$rowassign['date_end'].'" data-assigntotalmarks="'.$rowassign['total_marks'].'" data-assignpassingmarks="'.$rowassign['passing_marks'].'" data-assigndetail="'.$rowassign['detail'].'" data-assignid="'.$rowassign['id'].'" data-target="#cursEditAssignModal"><i class="icon-pencil"></i></a>
		<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="#" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a>';
}
echo '
	</td>
</tr>';
//------------------------------------------------
	$sqllmslessonprgs  = $dblms->querylms("SELECT DISTINCT(clp.id_prg), clp.id, clp.id_setup, clp.semester, clp.section, clp.timing, 
										p.prg_name, p.prg_code, p.prg_id   
										FROM ".COURSES_ASSIGNMENTSPROGRAM." clp 
										LEFT JOIN ".PROGRAMS." p ON p.prg_id = clp.id_prg  
										WHERE clp.id_setup = '".cleanvars($rowassign['id'])."' ORDER BY clp.id ASC");
//------------------------------------------------
echo '
<tr>
	<td colspan="6">';
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
	<td style="width:50px; text-align:center;">';
	if($rowassign['is_midterm'] != 1) { 
echo '
		<a class="btn btn-xs btn-warning" href="courses.php?id='.$_GET['id'].'&view=Assignments&editid='.$rowassign['id'].'"><i class="icon-edit"></i></a> ';
	}
echo '
		<a class="btn btn-xs btn-purple iframeModal"data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>'.$rowassign['caption'].'</b>" data-src="courseassignmentview.php?id='.$rowassign['id'].'" href="#"><i class="icon-zoom-in"></i></a> 
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