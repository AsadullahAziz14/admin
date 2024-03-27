<?php 
if(isset($_GET['examid']) && !isset($_GET['edit']) && isset($_GET['reattempt'])) {
//------------------------------------------------
	$sqllmsexam = $dblms->querylms("SELECT std.std_id, std.std_name, std.std_regno, std.std_photo, c.curs_id, c.curs_name, 
										ex.date_attempt, ex.id_teacher, ex.semester, ex.timing, ex.section, prg.prg_id, 
										ex.id, c.curs_code, std.std_rollno, std.std_session, prg.prg_name, prg.prg_code, 
										ex.id_term, ex.published, emp.emply_name 
										FROM ".REPEAT_EXAM." ex  
										INNER JOIN ".STUDENTS." std ON ex.id_std = std.std_id 
										INNER JOIN ".COURSES." c ON c.curs_id = ex.id_curs  
										INNER JOIN ".PROGRAMS." prg ON std.id_prg = prg.prg_id 
										INNER JOIN ".EMPLYS." emp ON emp.emply_id = ex.id_teacher 
										WHERE ex.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
                                        AND ex.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
										AND ex.id = '".cleanvars($_GET['examid'])."' LIMIT 1");
	$valueexam = mysqli_fetch_array($sqllmsexam);
//------------------------------------------------
	$sqllmscheque = $dblms->querylms("SELECT * 
                                            FROM ".REPEAT_EXAMSQUESTIONS." a
                                            INNER JOIN ".QUIZ_QUESTION." q ON q.question_id = a.id_question
                                            WHERE a.id_exam = '".cleanvars($_GET['examid'])."'
                                            ORDER by a.id ASC  ");
	$countques = mysqli_num_rows($sqllmscheque);
//------------------------------------------------
echo '
<style>
.card:not(.clear-shadow) {
    box-shadow: 0 10px 25px 0 rgba(50,50,93,.07), 0 5px 15px 0 rgba(0,0,0,.07);
}
.card, .card-group {
    margin-bottom: 1.5rem;
}
@media (min-width: 992px)
.card {
    margin-bottom: 30px;
}
.card {
    margin-bottom: 15px;
    border: none;
}
.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid #efefef;
    border-radius: .25rem;
	margin-top:30px;
}
.card-header:first-child {
    border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0;
}
.card-header {
    background-color: #f7f8f9;
}
.card-header {
    padding: .75rem 1.25rem;
    margin-bottom: 0;
    background-color: rgba(0,0,0,.03);
    border-bottom: 1px solid #efefef;
}
.align-items-center {
    align-items: center!important;
}
.media {
    display: flex;
    align-items: flex-start;
}
.card .media-left {
    padding-right: .625rem;
}
.media-body {
    flex: 1;
}
.text-primary {
    color: #1377c9!important;
}
.mr-2, .mx-2 {
    margin-right: .5rem!important;
}
.m-0 {
    margin: 0!important;
}
.h4, h4 {
    font-size: 1.5rem;
}
.media-body {
    flex: 1;
}
.card-title:last-child {
    margin-bottom: 0;
}
.card-title {
    margin-bottom: .75rem;
	color:#333;
	font-weight:600;
	font-size:14px;
}
.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1.25rem;
	margin-bottom:20px;
}
.custom-control {
    position: relative;
    display: block;
    min-height: 1.5rem;
    padding-left: 1.5rem;
}
*, :after, :before {
    box-sizing: border-box;
}
input[type=checkbox], input[type=radio] {
    box-sizing: border-box;
    padding: 0;
}
.custom-control-input {
    position: absolute;
    left: 0;
    z-index: -1;
    width: 1rem;
    height: 1.25rem;
    opacity: 0;
}
custom-control-input:checked~.custom-control-label:before {
    color: #fff;
    border-color: #1377c9;
    background-color: #1377c9;
}
button, input {
    overflow: visible;
}
button, input, optgroup, select, textarea {
    margin: 0;
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
}
label {
    display: inline-block;
    margin-left: .7rem;
    margin-right: 1.7rem;
}

.countdown { 
		text-align: center;
		font-size: 30px; 
		font-weight: 600;
		color: #f00;
		margin-top:20px;
	}
</style>
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
</h4>

<h5 style="text-align:right; font-weight:600; color:blue;">
	Total Questions: ('.$countques.')
</h5>
<div style="clear:both;"></div>


		<div class="container page__container">

                <div class="row">

                    <div class="col-md-12">';
$srno = 0;
$totalcount = 0;
	while($value_question 	= mysqli_fetch_array($sqllmscheque)) {
//----------------------------------------------sqllmsattendance
$srno++;

	if($value_question['attempt_date'] != '0000-00-00 00:00:00') {	
		$dated 	= '<span class="pull-right style="color:#fff !important;"><i class="icon-time"></i> '. date("j F, Y H:i", strtotime($value_question['attempt_date'])).'</span>';
	} else {
		$dated 	= '';
	}
		
	if($value_question['is_answered'] == 1) { 

		$isansw = '<span class="label label-info" id="bns-status-badge">Yes</span>';

	} else {
		
		$isansw = '<span class="label label-danger" id="bns-status-badge">No</span>';
	}
//------------------------------------------------
echo '
					
                        
                        <div class="card">
                            <div class="card-header">
                                <div class="media align-items-center">
                                    
                                    <div class="media-body">
                                        <h4 class="card-title m-0"><span style="color:#26B1FF;">Question: '.$srno.'</span> '.html_entity_decode($value_question['question_title'], ENT_QUOTES).'</h4>
                                    </div>
                                </div>
                            </div>
							
                            <div class="card-body">';
                        if($value_question['question_file']){  
                            echo '<p style="text-align:center;">
                                        <a href="downloads/exams/questions/'.$value_question['question_file'].'" target="_blank">
                                            <img src="downloads/exams/questions/'.$value_question['question_file'].'" border="0" style="width:60%;height:60%;">
                                        </a>
                                    </p><br>';
                        }
                        //For MCQ and True False Questions
                        if($value_question['question_type'] == 1 || $value_question['question_type'] == 2){
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
							
								$correctanswe = '<span style="margin-left:30px; font-size:16px;color:#09DD22; font-weight:600">(Correct)</span>';
								$correcid = $value_option['id'];
								
							} else {
								
								$correctanswe = '';
								
							}
                                
                            echo '<p><span style="font-weight:600; margin-right:5px;">'.$req.'- <label>'.html_entity_decode($value_option['answer_option'], ENT_QUOTES).$correctanswe.'</label>
							 
							</p>';

                            }
						    // student answer
							$sqllmsanswer  = $dblms->querylms("SELECT qo.answer_option, so.id_option       
														FROM ".REPEAT_EXAMSQUESTIONANSWER." so
														INNER JOIN ".QUIZ_QUESTION_OPTION." qo ON qo.id = so.id_option  
														WHERE so.id_question = '".cleanvars($value_question['question_id'])."'
														AND so.id_setup = '".cleanvars($value_question['id'])."' ");
							$valueanswer = mysqli_fetch_array($sqllmsanswer); 
							//echo $correcid;
						if($valueanswer['answer_option']) { 
							if($valueanswer['id_option'] == $correcid) {
								echo '<div style="font-size:14px; font-weight:600; margin-top:20px;">Student Answer: <span style="color:#00f;">'.$valueanswer['answer_option'].'</span></div>';

							} else {
								echo '<div style="font-size:14px; font-weight:600; margin-top:20px;">Student Answer: <span style="color:#f00;">'.$valueanswer['answer_option'].'</span></div>';

							}
							
						} else {
							echo '<div style="font-size:14px; font-weight:600; color:#f00;">No Answer</div>';
							
						}
							
							echo '<div style="clear:both;"></div>
								<div style="float:right;font-size:14px; font-weight:600;">Attempted: '.$isansw.'</div>
								<div style="clear:both;"></div>
								<div style="float:right;font-size:11px; color:#666;">'.$dated.'</div>';
                            //------------------------------------------------
                        }
                        //------------------------------------------------
                        if($value_question['answer']){
                            echo '<p>'.html_entity_decode($value_question['answer'], ENT_QUOTES).'</p>';
							echo '<div style="float:right;font-size:14px; font-weight:600;">Attempted: '.$isansw.'</div>
							<div style="clear:both;"></div>
							<div style="float:right;font-size:11px; color:#666;">'.$dated.'</div>';
                        }
		
					if($value_question['attachment']){  

					 echo '<p style="text-align:center;">
								<a class="btn btn-large btn-info" href="downloads/exams/answers/repeat/'.$value_question['attachment'].'" target="_blank">
									Attachment 
								</a>
							</p><br>';
				    }
                    //------------------------------------------------
                        echo '
                            </div>
                        </div>';
                    }
                    
                echo '
                    </div>
                    
                </div>

            </div>
</div>
<!--WI_USER_PROFILE_TABLE-->';
	
}