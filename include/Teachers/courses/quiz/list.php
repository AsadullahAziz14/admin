<?php 
//------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add'])) { 
//------------------------------------------------
	$sqllmsquiz  = $dblms->querylms("SELECT quiz_id, quiz_status, quiz_title, quiz_startdate, quiz_enddate, quiz_term, quiz_questions, quiz_time, 
										quiz_totalmarks, quiz_passingmarks   
										FROM ".QUIZ." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' ORDER BY quiz_id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsquiz) > 0) {
echo '
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center; ">Sr.#</th>
	<th style="font-weight:600;">Title</th>
	<th style="font-weight:600;text-align:center; ">Question(s)</th>
	<th style="font-weight:600;text-align:center; ">Marks</th>
	<th style="font-weight:600;text-align:center; ">Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srbk = 0;
//------------------------------------------------
while($value_quiz = mysqli_fetch_assoc($sqllmsquiz)) { 
//------------------------------------------------
$srbk++;
//------------------------------------------------
echo '
<tr>
	<td style="width:50px;text-align:center;vertical-align: middle;">'.$srbk.'</td>
	<td style="vertical-align: middle;">'.$value_quiz['quiz_title'].'</td>
	<td style="text-align:center; width:50px;vertical-align: middle;">'.$value_quiz['quiz_questions'].'</td>
	<td style="text-align:center; width:50px;vertical-align: middle;">'.$value_quiz['quiz_totalmarks'].'</td>
	<td style="width:60px; text-align:center;vertical-align: middle;">
		'.get_admstatus($value_quiz['quiz_status']).'
	</td>
	<td style="width:60px; text-align:center;vertical-align: middle;"> 
	<a class="btn btn-xs btn-purple iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Quiz Detail</b>" data-src="include/Teachers/courses/quizview.php?id='.$value_quiz['quiz_id'].'" href="#"><i class="icon-zoom-in"></i></a> 
	
	<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&view=Quiz&editid='.$value_quiz['quiz_id'].'"><i class="icon-edit"></i></a> 
		<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="#" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a> 
		<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&view=StudentQuiz&Quizid='.$value_quiz['quiz_id'].'"><i class="icon-group"></i></a>
	</td>
</tr>';
//------------------------------------------------
	$sqllmsquizprgs  = $dblms->querylms("SELECT DISTINCT(clp.id_prg), clp.id, clp.semester, clp.section, clp.timing, 
										p.prg_name, p.prg_code, p.prg_id   
										FROM ".QUIZ_PROGRAM." clp 
										INNER JOIN ".PROGRAMS." p ON p.prg_id = clp.id_prg  
										WHERE clp.id_setup = '".cleanvars($value_quiz['quiz_id'])."' ORDER BY clp.id ASC");
//------------------------------------------------
echo '
<tr>
	<td colspan="7"><b>Programs:</b>';
//------------------------------------------------
while($rowprgs = mysqli_fetch_assoc($sqllmsquizprgs)) { 	
	
	echo '<span style="font-weight:600; margin-left:20px; font-size:12px; color:blue;">'.strtoupper($rowprgs['prg_code']).' '.addOrdinalNumberSuffix($rowprgs['semester']).' '.$rowprgs['section'].' ( '.get_programtiming($rowprgs['timing']).')</span>';
}
//------------------------------------------------
echo '
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