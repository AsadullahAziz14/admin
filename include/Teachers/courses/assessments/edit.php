<?php 
if( isset($_GET['examid']) && isset($_GET['edit']) && !isset($_GET['reattempt'])) {
//------------------------------------------------
	$sqllmsexam = $dblms->querylms("SELECT std.std_id, std.std_name, std.std_regno, std.std_photo, c.curs_id, c.curs_name, 
										ex.date_attempt, ex.id_teacher, ex.semester, ex.timing, ex.section, prg.prg_id, 
										ex.published, ex.id, c.curs_code, std.std_rollno, std.std_session, 
										prg.prg_name, prg.prg_code, ex.id_term, emp.emply_name 
										FROM ".QUIZ_EXAMS." ex  
										INNER JOIN ".STUDENTS." std ON ex.id_std = std.std_id 
										INNER JOIN ".COURSES." c ON c.curs_id = ex.id_curs  
										INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
										INNER JOIN ".EMPLYS." emp ON emp.emply_id = ex.id_teacher 
										WHERE ex.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
                                        AND ex.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
										AND ex.id = '".cleanvars($_GET['examid'])."' LIMIT 1");
	 
	 $valueexam = mysqli_fetch_array($sqllmsexam);
 

echo '

<div style="text-align:left; margin:0px 20px 20px 20px;">
<h1 style="font-weight:600;text-align:left; color:#00f;">
	'.get_examterm($valueexam['id_term']).' Paper
</h1>

<h2 style="font-weight:600;text-align:left; color:#333; font-size:18px;">
	Course Name: '.$valueexam['curs_code'].' - '.$valueexam['curs_name'].'
</h2>
<h3 style="font-weight:600;text-align:left; color:#333; font-size:14px;">
	Teacher Name: <span style="color:#26B1FF;">'.$valueexam['emply_name'].'</span>
</h3>
<h4 style="font-weight:600;text-align:left; color:#666; font-size:12px;">
	'.$valueexam['std_name'].' ('.$valueexam['prg_name'].' '.addOrdinalNumberSuffix($valueexam['semester']).')
</h4>';
if($valueexam['published'] == 1) { 
	
echo '
	<div class="col-lg-12">
		<div class="widget-tabs-notification" style="color:#f00; font-weight:600;">You have not right to edit.</div>
	</div>';
	
} else {
	
//------------------------------------------------
	$sqllmscheque = $dblms->querylms("SELECT * 
                                                FROM ".QUIZ_EXAMSQUESTIONS." a
                                                INNER JOIN ".QUIZ_QUESTION." q ON q.question_id = a.id_question
                                                WHERE a.id_exam = '".cleanvars($_GET['examid'])."'
												AND q.question_type = '1'
												ORDER by a.id ASC  ");
	 
	 $countques = mysqli_num_rows($sqllmscheque);
//------------------------------------------------
	
//------------------------------------------------
	$sqllmssubjective = $dblms->querylms("SELECT * 
                                                FROM ".QUIZ_EXAMSQUESTIONS." a
                                                INNER JOIN ".QUIZ_QUESTION." q ON q.question_id = a.id_question
                                                WHERE a.id_exam = '".cleanvars($_GET['examid'])."' 
												AND q.question_type = '3'
												ORDER by a.id ASC  ");
	 
	 $countsubjective = mysqli_num_rows($sqllmssubjective);
	
if($_GET['prgid'] == 130 && $_GET['term'] == 2) {
	
	$ntotalmarks = 40;
} else if($_GET['prgid'] == 130 && $_GET['term'] == 1) {
	
	$ntotalmarks = 35;
}elseif($_GET['term'] == 2) {
	
	$ntotalmarks = 50;
}else {
	
	$ntotalmarks = 25;
}
//------------------------------------------------
echo '
	
<h5 style="text-align:left; font-weight:600; color:blue;">
	<span style="float:right;">Total Questions: ('.($countques + $countsubjective).')</span>
</h5>
<div style="clear:both;"></div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="#" method="post" id="addLesson" enctype="multipart/form-data">
<input type="hidden" name="examid" id="examid" value="'.cleanvars($valueexam['id']).'">
<input type="hidden" name="total_marks" id="total_marks" value="'.$ntotalmarks.'">

<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'courses.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].'&view=Assessments&term='.$valueexam['id_term'].'\'"><span>close</span></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Record Detail</h4>
</div>

<div class="modal-body">';
$srno = 0;
$totalcount = 0;
$mcqsmarks = 0;
	while($value_question 	= mysqli_fetch_array($sqllmscheque)) { 
if($value_question['question_type'] == 1) {
//----------------------------------------------sqllmsattendance
$srno++;


//For MCQ and True False Questions
                        
//------------------------------------------------
			$sqllmsoption  = $dblms->querylms("SELECT id, answer_option, answer_correct       
                                    		  FROM ".QUIZ_QUESTION_OPTION."
											  WHERE id_question = '".cleanvars($value_question['question_id'])."'
										      ORDER BY id ASC ");
            $req = 0;
			$correcid = 0;
//------------------------------------------------
			while($value_option = mysqli_fetch_array($sqllmsoption)) {
//------------------------------------------------
				$req++;
				if($value_option['answer_correct'] == 1) {
					$correcid = $value_option['id'];
								
				}  // end if
			} // end while loop
	
// student answer
		$sqllmsanswer  = $dblms->querylms("SELECT qo.answer_option, so.id_option       
												FROM ".QUIZ_EXAMSQUESTIONANSWER." so
												INNER JOIN ".QUIZ_QUESTION_OPTION." qo ON qo.id = so.id_option  
												WHERE so.id_question = '".cleanvars($value_question['question_id'])."'
												AND so.id_setup = '".cleanvars($value_question['id'])."' 
												AND so.answer_option = '1' ");
		$valueanswer = mysqli_fetch_array($sqllmsanswer); 
//echo $correcid;
		if($valueanswer['answer_option']) { 
			if($valueanswer['id_option'] == $correcid) {
				echo '<input type="hidden" name="idedit[]" id="idedit[]" value="'.cleanvars($value_question['id']).'">
				<input type="hidden" name="totalmarks[]" id="totalmarks[]" value="1">
				<input type="hidden" name="obtmarks[]" id="obtmarks[]" value="1">';
				$mcqsmarks++;

			} else {
				echo '<input type="hidden" name="idedit[]" id="idedit[]" value="'.cleanvars($value_question['id']).'">
				<input type="hidden" name="totalmarks[]" id="totalmarks[]" value="1">
				<input type="hidden" name="obtmarks[]" id="obtmarks[]" value="0">';
			}
		}

 //------------------------------------------------

	
	} // end mcqs
		
	} // end while loop

echo '<h4 style="font-weight:600; text-align:right; color:#00f;">Obtained Marks in MCQs: <span style="font-size:16px;">'.$mcqsmarks.'</span></h4>';

while($value_subjs 	= mysqli_fetch_array($sqllmssubjective)) { echo '
 	<h4 style="font-weight:600;"><span style="color:#26B1FF;">Question:</span> '.html_entity_decode($value_subjs['question_title'], ENT_QUOTES).'</h4>
	<div class="col-sm-32" style="float:right;">
		<div class="form_sep">
			<label class="req">Obtain Marks</label>';
			if($value_subjs['answer'] != '' || $value_subjs['attachment'] != ''){
				echo '<input type="text" class="form-control" min="0" max="'.$value_subjs['question_marks'].'" id="obtmarks[]" name="obtmarks[]" value="'.cleanvars($value_subjs['obtmarks']).'" required autocomplete="off" style="text-align:center; font-weight:600; font-size:16px !important; color:#00f;" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" >';
			} else{

				if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) == 1){
					echo '<input type="text" class="form-control" min="0" max="'.$value_subjs['question_marks'].'" id="obtmarks[]" name="obtmarks[]" value="'.cleanvars($value_subjs['obtmarks']).'" required autocomplete="off" style="text-align:center; font-weight:600; font-size:16px !important; color:#00f;" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"  >';
				} else{
					echo '<input type="text" class="form-control" min="0" max="0" id="obtmarks[]" name="obtmarks[]" value="0" required autocomplete="off" readonly style="text-align:center; font-weight:600; font-size:16px !important; color:#00f;" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"  >';
				}
				
			}
		echo '
		</div> 
	</div>

	<div style="clear:both;"></div>
	<input type="hidden" name="totalmarks[]" id="totalmarks[]" value="'.$value_subjs['question_marks'].'">
	<input type="hidden" name="idedit[]" id="idedit[]" value="'.cleanvars($value_subjs['id']).'">
	<div style="font-size:16px; font-weight:600; margin-top:20px; color:#1CB562;">Student Answer:</div>';
//------------------------------------------------
	if($value_subjs['answer']){
		echo '<p>'.html_entity_decode($value_subjs['answer'], ENT_QUOTES).'</p>';

	}

	if($value_subjs['attachment']){  

		if($valueexam['id_term'] == 2 && $valueexam['prg_id'] != 130){
			$folder = 'finalterm/';
	
		} else{
			$folder = '';
		}
		echo '<p style="text-align:center;">
				<a class="btn btn-large btn-info" href="downloads/exams/answers/'.$folder.''.$value_subjs['attachment'].'" target="_blank">
					Attachment 
				</a>
				</p><br>';
	 }
	
 echo '<hr style="border-top: 2px dashed #00f; margin:20px;">';
	
} // end subjective loop
	
echo '
	
</div>

<div class="modal-footer">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_detail" name="changes_detail">
	<button type="button" class="btn btn-default" onclick="location.href=\'courses.php?id='.$_GET['id'].'&prgid='.$_GET['prgid'].'&timing='.$_GET['timing'].'&semester='.$_GET['semester'].'&view=Assessments&term='.$valueexam['id_term'].'\'" >Close</button>
</div>

</div>
<input type="hidden" name="obtain_marks" id="obtain_marks" value="'.$mcqsmarks.'">
</form>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->';
}

echo '
</div>
<!--WI_USER_PROFILE_TABLE-->';
	
}
