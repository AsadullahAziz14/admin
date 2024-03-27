<?php 
//------------------------------------------------
if(isset($_GET['editid']) && !isset($_GET['add'])) { 
	
$sqllmsAttempted  = $dblms->querylms("SELECT id_question
												FROM ".QUIZ_EXAMSQUESTIONS." 
												WHERE id_question = '".cleanvars($_GET['editid'])."' 
												LIMIT 1");
	if(mysqli_num_rows($sqllmsAttempted) >0) {
		
		echo '<h1 style="color:#f00; font-weight:600; text-align:center;">You have not right to edit.</h1>';
	

	} else {
		
//------------------------------------------------
	$sqllmsquestion  = $dblms->querylms("SELECT *   
										FROM ".QUIZ_QUESTION." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  
										AND question_id = '".cleanvars($_GET['editid'])."' LIMIT 1");
	$value_question = mysqli_fetch_assoc($sqllmsquestion);
		
if(mysqli_num_rows($sqllmsquestion) == 0) {
	
	echo '<h1 style="color:#f00; font-weight:600; text-align:center;">No result found.</h1>';
} else {
	
if($value_question['question_file']) { 
	
	$fileimgs = '<p style="text-align:center;">
		 			<a href="downloads/exams/questions/'.$value_question['question_file'].'" target="_blank">
						<img src="downloads/exams/questions/'.$value_question['question_file'].'" border="0" style="width:60%;height:60%;">
					</a>
				</p>';
	
} else {
	
	$fileimgs = '';
}
//------------------------------------------------
echo '
<!--WI_ADD_NEW_TASK_MODAL-->
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="courses.php?id='.$_GET['id'].'&view=QuizBank" method="post" name="editquestion" id="editquestion" enctype="multipart/form-data">
<input type="hidden" name="editid" id="editid" value="'.cleanvars($_GET['editid']).'">
<input type="hidden" name="questiontype" id="questiontype" value="'.cleanvars($value_question['question_type']).'">
<input type="hidden" name="question_term" id="question_term" value="'.cleanvars($value_question['question_term']).'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=QuizBank\'"><span>close</span></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Question Detail</h4>
</div>

<div class="modal-body">

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Question</b></label>
		<div class="col-lg-12">
		<textarea  type="text" class="form-control ckeditor" id="question_title" name="question_title" required autofocus autocomplete="off">'.$value_question['question_title'].'</textarea>
		</div>
	</div>
	
	
	
	<div class="form-group">
		<label class="control-label col-lg-12" style="width:250px; margin-top:10px;"><b> Attach File</b></label>
		<div class="col-lg-12">
			<input id="ques_file" name="ques_file" class="btn btn-mid btn-primary clearfix" type="file"> 
			<div style="font-weight:500; margin-top:5px;">File extension must be: (<span style="color:blue; font-weight:700;">jpg, jpeg, gif, png</span>)</div>
		</div>
	</div>
	
	<div class="form-group">
		'.$fileimgs.';
	</div>

	<div style="clear:both;"></div>

	<div class="col-sm-32" style="margin-top:10px;">
		<div class="form_sep">
			<label class="req">Status</label>
			<select id="question_status" name="question_status" style="width:100%" autocomplete="off" required>';
			foreach($admstatus as $itemadm_status) {
				echo '<option value="'.$itemadm_status['status_id'].'"'; if($value_question['question_status'] == $itemadm_status['status_id']){echo ' selected';}echo '>'.$itemadm_status['status_name'].'</option>';
			}
		echo'
			</select>
		</div> 
	</div>

	<div class="col-sm-32" style="margin-top:10px;">
		<div class="form_sep">
			<label class="req">Difficulty Level</label>
			<select id="question_level" name="question_level" style="width:100%" autocomplete="off" min="1" max="5" required>
			<option value="">Select</option>';
			foreach($difficultylevel as $itemlevel) { 
				if($value_question['question_level'] == $itemlevel['id']) {
					echo '<option value="'.$itemlevel['id'].'" selected>'.$itemlevel['name'].'</option>';
				} else {
					echo '<option value="'.$itemlevel['id'].'">'.$itemlevel['name'].'</option>';
				}
			}
	echo'
			</select>
		</div> 
	</div>
	
	<div class="col-sm-32" style="margin-top:10px;">
		<div class="form_sep">
			<label class="req">Weeek # </label>
			<select id="questionweekno" name="question_weekno" style="width:100%" autocomplete="off" required>
				<option value="">Select Week</option>';
			for($iwk=1; $iwk <=50; $iwk++) { 
				$weekname = "Week: $iwk";
				if($value_question['question_weekno'] == $weekname) {
					echo '<option value="'.$weekname.'" selected>'.$weekname.'</option>';
				} else {
					echo '<option value="'.$weekname.'">'.$weekname.'</option>';
				}
				
			}
	echo'
			</select>
		</div> 
	</div>
<script>
	
	
	$("#questionweekno").select2({
        allowClear: true
    });
</script>
	
	<div style="clear:both;"></div>

	
	
	<div class="col-sm-61" style="margin-top:10px;">
		<div class="form_sep">
			<label class="req">Question  Type</label>
			<input type="text" class="form-control" id="question_type" name="question_type" value="'.get_questiontype($value_question['question_type']).'" readonly required autocomplete="off">
		</div> 
	</div>';
if($value_question['question_type'] == 1 || $value_question['question_type'] == 2) {
	
echo '
	<div class="col-sm-61" style="margin-top:10px;">
		<div class="form_sep">
			<label class="req">Marks</label>
			<input type="text" class="form-control" id="question_marks" name="question_marks" value="'.$value_question['question_marks'].'" required readonly autocomplete="off">
		</div> 
	</div>';
	
} else {
	
		
echo '
	<div class="col-sm-61" style="margin-top:10px;">
		<div class="form_sep">
			<label class="req">Marks</label>
			<select id="mark_ssect" name="question_marks" style="width:100%" autocomplete="off" required>
			<option value="">Selec Mark</option>';
			for($mkrs =5; $mkrs <=5; $mkrs++) { 
				if($value_question['question_marks'] == $mkrs) {
					echo '<option value="'.$mkrs.'" selected>'.$mkrs.'</option>';
				} else {
					echo '<option value="'.$mkrs.'">'.$mkrs.'</option>';
				}
			}
	echo'
			</select>
		</div> 
	</div>
<script>
	
	
	$("#mark_ssect").select2({
        allowClear: true
    });
</script>';
	
}
	
echo '
	<div style="clear:both;"></div>';

if($value_question['question_type'] == 1 || $value_question['question_type'] == 2){
echo '
	<div id="getquestionoption">
	<div class="col-lg-12 heading-modal" style="margin-top:10px; margin-bottom:5px;">Question Options</div>';
		if($value_question['question_type'] == 1){
			echo '
			<table class="table table-bordered invE_tableed">
			<thead>
			<tr class="heading-modal">
				<th style="font-weight:600;text-align:center;vertical-align: middle;"> #</th>
				<th style="font-weight:600;vertical-align: middle;"> Option</th>
				<th style="font-weight:600;text-align:center;vertical-align: middle;"> Is Option Correct?<div style="color:red; font-size:10px;">Check Correct One</div></th>	
			</tr>
			</thead>
			<tbody>';
		$sqllmsoption  = $dblms->querylms("SELECT id, answer_option, answer_correct  
												FROM ".QUIZ_QUESTION_OPTION." 
												WHERE id_question = '".$value_question['question_id']."' ORDER BY id ASC");
		$sr = 0;
		$count = mysqli_num_rows($sqllmsoption);
		while($value_option = mysqli_fetch_assoc($sqllmsoption)) {
		$sr++;
			echo '
			<tr>
				<td style="text-align:center;"><span style="font-weight:600; color:#666; font-size:12px;">'.$sr.'</span></td>
				<td><input type="text" class="form-control" id="answer_option[]" required name="answer_option['.$sr.']" value="'.$value_option['answer_option'].'"></td>	
				<td style="width:150px; text-align:center;vertical-align:middle;"><input id="answer_correct" name="answer_correct" type="radio"'; if($value_option['answer_correct'] == 1){echo ' checked';}echo ' value="'.$sr.'" class="checkbox-inline"></td>
				<input type="hidden" name="id_edit['.$sr.']"  id="id_edit['.$sr.']" value="'.$value_option['id'].'">	
			</tr>';
		}
		if($count < 4){
			for($i = $count+1; $i<=4; $i++){
				echo '
				<tr>
					<td style="text-align:center;"><span style="font-weight:600; color:#666; font-size:12px;">'.$i.'</span></td>
					<td><input type="text" class="form-control" id="answer_option[]" required name="answer_option['.$i.']" value=""></td>	
					<td style="width:150px; text-align:center;vertical-align:middle;"><input id="answer_correct" name="answer_correct" type="radio" value="'.$i.'" class="checkbox-inline"></td>
				</tr>';
			}
		}
			echo '
			</tbody>
			</table>';
		}
	
		if($value_question['question_type'] == 2){ 
			
			echo '
		
		<div class="col-sm-61" style="margin-top:10px;margin-bottom:10px;margin-left:20%;">
		<div class="form_sep">
		<label class="req">Choose</label><br>';
			$sqllmsoption  = $dblms->querylms("SELECT id, answer_option, answer_correct  
														FROM ".QUIZ_QUESTION_OPTION." 
														WHERE id_question = '".$value_question['question_id']."' ORDER BY id ASC");
				$sr = 0;
				while($value_option = mysqli_fetch_assoc($sqllmsoption)) {
				$sr++;
					echo '<input type="hidden" id="answer_option['.$sr.']" name="answer_option['.$sr.']" value="'.$value_option['answer_option'].'">';
					echo $value_option['answer_option'].' <input type="radio" id="answer_correct" name="answer_correct" value="'.$sr.'" class="checkbox-inline" style="margin-right:30px;"'; if($value_option['answer_correct'] == 1){echo ' checked';}echo '>
					<input type="hidden" name="id_edit['.$sr.']"  id="id_edit['.$sr.']" value="'.$value_option['id'].'">';
				}
	echo'
			
		</div> 
	</div>
	<div style="clear:both;"></div>';
			
		}
		echo '
		
	</div>';
}
echo '

	
<div style="clear:both;"></div>
	
</div>

<div class="modal-footer">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_question" name="changes_question">
	<button type="button" class="btn btn-default" onclick="location.href=\'courses.php?id='.$_GET['id'].'&view=QuizBank\'" >Close</button>
</div>

</div>
</form>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
	$("#question_status").select2({
        allowClear: true
    });
	$("#question_level").select2({
        allowClear: true
    });
	$("#question_type").select2({
        allowClear: true
    });
	$("#question_options").select2({
        allowClear: true
    });
	
	$("#markssect").select2({
        allowClear: true
    });
	
</script>
<script type="text/javascript"> 

$("#ques_file").change(function () {
        var fileExtension = ["png", "jpg", "jpeg", "gif"];
        if ($.inArray($(this).val().split(\'.\').pop().toLowerCase(), fileExtension) == -1) {
            alert("Only formats are allowed : "+fileExtension.join(\', \'));
        }
    });
        $(\'#ques_file\').on(\'change\', function() { 
  
            const size = (this.files[0].size / 1024 / 1024).toFixed(2); 
  
            if (size > 2) { 
                alert("Try to upload file less than 2MB!"); 
            } else { 
                $("#output").html(\'<b>\' + \'This file size is: \' + size + " MB" + \'</b>\'); 
            } 
        }); 
    </script>
<script type="text/javascript">
$().ready(function() {
    //USED BY: WI_ADD_NEW_TASK_MODAL
	//ACTIONS: validates the form and submits it
	//REQUIRES: jquery.validate.js
	$("#editquestion").validate({
		rules: {
             question_status: "required",
			 question_title: "required",
			 question_type: "required",
			 question_marks: "required",
			 id_chapter: "required"
		},
		messages: {
			question_status: "This field is required",
			question_title: "This field is required",
			question_type: "This field is required",
			question_marks: "This field is required",
			id_chapter: "This field is required"
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';
}
}
}