<?php 
//------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add']) && LMS_VIEW == "QuizBank") { 
//------------------------------------------------	
	$sql2 		= '';
	$sqlstring	= "";
	$srch	 	= (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
	$level	 	= (isset($_GET['level']) && $_GET['level'] != '') ? $_GET['level'] : '';
	$term	 	= (isset($_GET['term']) && $_GET['term'] != '') ? $_GET['term'] : '';
//----------------------------------------
if(($srch)) { 
	$sql2 		.= " AND question_title LIKE '%".$srch."%'"; 
	$sqlstring	.= "&srch=".$srch."";
}
	
if(($level)) { 
	$sql2 		.= " AND question_level = '".$level."'"; 
	$sqlstring	.= "&level=".$level."";
}
if(($term)) { 
	$sql2 		.= " AND question_term = '".$term."'"; 
	$sqlstring	.= "&term=".$term."";
}
	$sqllmsquestion  = $dblms->querylms("SELECT question_id, question_status, question_title, question_file, 
												question_type, question_level, question_marks, question_term  
										FROM ".QUIZ_QUESTION." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."'  
										AND id_curs = '".cleanvars($_GET['id'])."' $sql2 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										ORDER BY question_id DESC");
//--------------------------------------------------

echo '
<div class="pull-right">
			
	<form class="navbar-form navbar-left form-small" action="courses.php" method="get">
		<input type="hidden" name="id" id="id" value="'.cleanvars($_GET['id']).'">
		<input type="hidden" name="view" id="view" value="QuizBank">
		<div class="form-group">
			<input type="text" class="form-control" name="srch" placeholder="Question Title" style="width:200px; " >
		</div>
		<div class="form-group">
			<select id="projects-list7" data-placeholder="Exam Term" name="term" style="width:150px; text-align:left !important;" >
			<option></option>';
			foreach($examterm as $itemterm) {
				echo '<option value="'.$itemterm['id'].'">'.$itemterm['name'].'</option>';
			}
echo '		</select>
		</div> 
		<div class="form-group">
			<select id="projects-list6" data-placeholder="Difficulty Level" name="level" style="width:150px; text-align:left !important;" >
			<option></option>';
			foreach($difficultylevel as $itemlevel) {
				echo '<option value="'.$itemlevel['id'].'">'.$itemlevel['name'].'</option>';
			}
echo '		</select>
		</div> 
		<button type="submit" class="btn btn-mid btn-primary">Search</button> 
		<script>

			$("#projects-list6").select2({
				allowClear: true
			});
			$("#projects-list7").select2({
				allowClear: true
			});


		</script>
</form>
			
</div>';
if (mysqli_num_rows($sqllmsquestion) > 0) { 

	
echo '
<div style="clear:both;"></div>
<div style=" float:right; text-align:right; font-weight:700; color:blue; margin-right:10px;margin-top:10px;"> 
Total Recods: ('.number_format(mysqli_num_rows($sqllmsquestion)).') 
	 
</div>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center;vertical-align: middle; ">Sr.#</th>
	<th style="font-weight:600;vertical-align: middle;">Question</th>
	<th style="font-weight:600;text-align:center;vertical-align: middle; ">Type</th>
	<th style="font-weight:600;text-align:center; vertical-align: middle;"> Difficulty Level</th>
	<th style="font-weight:600;text-align:center; vertical-align: middle;">Marks</th>
	<th style="font-weight:600;text-align:center; vertical-align: middle;">Term</th>
	<th style="font-weight:600;text-align:center; vertical-align: middle;">Status</th>
	<th style="width:60px; text-align:center; font-size:14px;vertical-align: middle;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srbk = 0;
//------------------------------------------------
while($value_question = mysqli_fetch_assoc($sqllmsquestion)) { 
//------------------------------------------------
$srbk++;
	
	if($value_question['question_file']) { 
		
		$fileimgs = '
					<a class="btn btn-xs btn-success" href="downloads/exams/questions/'.$value_question['question_file'].'" target="_blank"><i class="icon-download"></i></a></a> ';
		
	} else {
		
		$fileimgs = '';
	}

	$sqllmsAttempted  = $dblms->querylms("SELECT id_question
												FROM ".QUIZ_EXAMSQUESTIONS." 
												WHERE id_question = '".cleanvars($value_question['question_id'])."' 
												LIMIT 1");
	if(mysqli_num_rows($sqllmsAttempted) == 0) {
		$editLink = '<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&view=QuizBank&editid='.$value_question['question_id'].'"><i class="icon-edit"></i></a> 
		<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="#" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a>';

	} else{
		$editLink = '';
	}
//------------------------------------------------
echo '
<tr>
	<td style="width:50px;text-align:center;vertical-align: middle;">'.$srbk.'</td>
	<td>'.html_entity_decode($value_question['question_title'], ENT_QUOTES).'</td>
	<td style="text-align:center; width:120px;vertical-align: middle;">
		'.get_questiontype($value_question['question_type']).'
	</td>
	<td style="text-align:center; width:70px;vertical-align: middle;">
		'.get_difficultylevel($value_question['question_level']).'
	</td>
	<td style="width:50px; text-align:center;vertical-align: middle;">
		'.$value_question['question_marks'].'
	</td>
	<td style="width:50px; text-align:center;vertical-align: middle;">
		'.get_examterm($value_question['question_term']).'
	</td>
	<td style="width:60px; text-align:center;vertical-align: middle;">
		'.get_admstatus($value_question['question_status']).'
	</td>
	<td style="width:70px; text-align:center;vertical-align: middle;"> '.$fileimgs.$editLink.'
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
	<div class="widget-tabs-notification" style="text-align:center;">No Result Found</div>
</div>';
//------------------------------------------------
}
}