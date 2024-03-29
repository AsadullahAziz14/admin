<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'edit' => '1'))) {
		$queryAssignment = $dblms->querylms("SELECT ques_id, ques_status, ques_number, ques_marks, ques_date, id_ques 
												FROM ".OBE_ASSIGNMENTS." 
												WHERE assignment_id = ".cleanvars($_GET['id'])." ");
		$valueAssignment = mysqli_fetch_assoc($queryAssignment);
		$formattedDate = date('Y-m-d', strtotime($valueAssignment['assignment_date']));
		echo '
		<div class="row">
		   	<div class="modal-dialog" style="width:95%;">
			  	<form class="form-horizontal" action="obeassignments.php?id='.$_GET['id'].'" method="post" id="" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" style="font-weight:700;">Edit Assignment</h4>
						</div>
						<div class="modal-body">
							<div class="col-sm-61">
								<div class="form-sep" style="margin-top:5px;">
									<label for="assignment_number" class="req"><b>Assignment Number</b></label>
									<input type="number" class="form-control" id="assignment_number" name="assignment_number" value="'.$valueAssignment['assignment_number'].'" required>
								</div>
							</div>
							<div class="col-sm-61">
								<div class="form-sep" style="margin-top:5px;">
									<label for="assignment_status" class="req" style="width:100px;"> <b>Status</b></label>
									<select id="assignment_status" class="form-control" name="assignment_status" style="width:100%" required>
										<option value="">Select Status</option>';
										foreach ($status as $assignmentStatus) {
											if ($valueAssignment['assignment_status'] == $assignmentStatus['id']) {
												echo "<option value='$assignmentStatus[id]' selected>$assignmentStatus[name]</option>";
											} else {
												echo "<option value='$assignmentStatus[id]'>$assignmentStatus[name]</option>";
											}
										}
										echo '
									</select>
								</div>
							</div>
							<div style="clear:both;"></div>
							<div class="col-sm-61">
								<div class="form-sep" style="margin-top:5px;">
									<label for="marks" class="req"><b>Assignment Marks</b></label>
									<input type="text" class="form-control" id="marks" name="marks" value="'.$valueAssignment['assignment_marks'].'" readonly required>
								</div>
							</div>  
							<div class="col-sm-61">
								<div class="form-sep" style="margin-top:5px;">
									<label for="date" class="req"><b>Assignment Date</b></label>
									<input type="date" class="form-control" id="assignment_date" name="assignment_date" value="'.$formattedDate.'" required>
								</div>
							</div>
							<input type="hidden" class="form-control" id="questionId" name="questionId">
							<div style="clear:both;"></div>
							<div id="questionContainer" style="margin-top:10px; margin-bottom: 10px;" class="col-sm-91">';
							if($valueAssignment['id_ques']) {
								$questionIds = explode(',', $valueAssignment['id_ques']);
								$i  =0;
								foreach ($questionIds as $key => $itemquestionIds) {
									$quessql = $dblms->querylms("SELECT ques_id, ques_number, ques_marks, ques_category, id_clo
																	FROM ".OBE_QUESTIONS." 
																	WHERE ques_id = (".$itemquestionIds.") ");
									$value_ques = mysqli_fetch_assoc($quessql);
									if($value_ques) {
										$quesClo = explode(',', $value_ques['id_clo']);
										$closql = $dblms->querylms("SELECT clo_id, clo_number
																		FROM ".OBE_CLOS." as cl
																		INNER JOIN ".OBE_CLOS_PROGRAMS." as cp ON cl.clo_id = cp.id_clo
																		WHERE cl.id_teacher = ".ID_TEACHER." AND cl.id_course = ".ID_COURSE." AND cl.academic_session = '".ACADEMIC_SESSION."' AND cl.id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])." AND cp.id_prg = ".ID_PRG." AND cp.semester = ".SEMESTER." AND cp.section = '".SECTION."'
																	");
										echo '
										<div class="form-sep" id="ques_Container['.$itemquestionIds.']" name="ques_Container" style="width: 100%; border: 1px solid rgb(231, 231, 231);">
											<div class="col-sm-31" style="margin-top: 5px;">
												<label class="req">Question Number:</label>
												<select class="form-control req" name="ques_number['.$key.']['.$itemquestionIds.']" style="width: 100%;" required>
													<option value="">Select Question No.</option>';
													for ($i = 1; $i <= 15; $i++) {
														if ($value_ques['ques_number'] == $i) {
															echo "<option value='$i' selected>$i</option>";
														} else {
															echo "<option value='$i'>$i</option>";
														}
													}
													echo '
												</select>
											</div>
											<div class="col-sm-31" style="margin-top: 5px;">
												<label class="req">Question Category:</label>                                 
												<select class="form-control req" name="ques_category['.$key.']['.$itemquestionIds.']" onchange="quesContianer(this,'.$itemquestionIds.')" style="width: 100%; margin-bottom: 10px;" required>
													<option value="">Select Question Cat.</option>';
													foreach ($ques_category as $cat) {
														if ($value_ques['ques_category'] == $cat['id']) {
															echo "<option value='$cat[id]' selected>$cat[name]</option>";
														} else {
															echo "<option value='$cat[id]' >$cat[name]</option>";
														}
													}
													echo '
												</select>
											</div>
								
											<div class="col-sm-31" style="margin-top: 5px;">
												<label class="req">Marks:</label>
												<select class="form-control req" id="ques_marks" name="ques_marks['.$key.']['.$itemquestionIds.']" style="width: 100%;"  required>
												<option value="">Select Marks</option>';
													for ($i = 1; $i <= 10; $i++) {
														if ($value_ques['ques_marks'] == $i) {
															echo "<option value='$i' selected>$i</option>";
														} else {
															echo "<option value='$i'>$i</option>";
														}
													}
													echo '
												</select>
											</div>
											<div class="col-sm-31" style="margin-top: 5px;">
												<label class="req">Mapped CLOs:</label>
												<select class="select2" name = "ques_clo['.$itemquestionIds.'][]" style="width: 100%;" multiple required>
													<option value="">Select CLOs</option>';
													while ($value_clo = mysqli_fetch_assoc($closql)) {
														if (in_array($value_clo['clo_id'], $quesClo)) {
															echo '<option value = "'.$value_clo['clo_id'].'" selected>'.$value_clo['clo_number'].'</option>';
														} else {
															echo '<option value = "'.$value_clo['clo_id'].'">'.$value_clo['clo_number'].'</option>';
														}
													}
													echo '
												</select>
											</div>
											<div class="col-sm-31" style="margin-top: 5px;">
												<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
													<button type="button" class="btn btn-danger" style="width: 50%; align-items: center;" onclick="remove('.$itemquestionIds.')"><i class="icon-trash"></i></button>
												</div>
											</div>
											<div style="clear: both;"></div>
											<div class="form_group questionStatementContainer" id="questionStatementContainer['.$itemquestionIds.']" style="margin-top: 5px;">
												<div style="margin-top: 5px;">';
													if($value_ques['ques_category'] == '1' || $value_ques['ques_category'] == 3 || $value_ques['ques_category'] == 4 || $value_ques['ques_category'] == 5) {
														echo '<textarea name="ques_statement['.$key.']['.$itemquestionIds.']" class="form-control"  placeholder="Question Statement" cols="20" rows="3" style="visibility:visible;">'.$value_ques['ques_statement'].'</textarea> ';
													} elseif ($value_ques['ques_category'] == '2') {
														echo '<input type="text" name="ques_statement['.$key.']['.$itemquestionIds.']" class="form-control" value="'.$value_ques['ques_statement'].'" style="margin-bottom: 10px;" placeholder="Question Statement">';
														$mcqoptionssql = $dblms->querylms("SELECT option1, option2, option3, option4, option5 
																								FROM ".OBE_MCQS." 
																								WHERE id_ques =  ".$itemquestionIds." ");
														$value_mcqoptionssql = mysqli_fetch_assoc($mcqoptionssql);
														if($value_mcqoptionssql) {
															echo '
															<div class="options" >
																<input type="text" name="option['.$key.']['.$itemquestionIds.'][1]" class="form-control" value="'.$value_mcqoptionssql['option1'].'" placeholder="option1" required>
																<input type="text" name="option['.$key.']['.$itemquestionIds.'][2]" class="form-control" value="'.$value_mcqoptionssql['option2'].'" placeholder="option2" required>
																<input type="text" name="option['.$key.']['.$itemquestionIds.'][3]" class="form-control" value="'.$value_mcqoptionssql['option3'].'" placeholder="option3" required>
																<input type="text" name="option['.$key.']['.$itemquestionIds.'][4]" class="form-control" value="'.$value_mcqoptionssql['option4'].'" placeholder="option4" required>
																<input type="text" name="option['.$key.']['.$itemquestionIds.'][5]" class="form-control" value="'.$value_mcqoptionssql['option5'].'" placeholder="option5" required>
															</div>';
														} else {
															echo '
															<div class="options">
																<input type="text" name="option['.$key.']['.$itemquestionIds.'][1]" class="form-control" value="" placeholder="option1" required>
																<input type="text" name="option['.$key.']['.$itemquestionIds.'][2]" class="form-control" value="" placeholder="option2" required>
																<input type="text" name="option['.$key.']['.$itemquestionIds.'][3]" class="form-control" value="" placeholder="option3" required>
																<input type="text" name="option['.$key.']['.$itemquestionIds.'][4]" class="form-control" value="" placeholder="option4" required>
																<input type="text" name="option['.$key.']['.$itemquestionIds.'][5]" class="form-control" value="" placeholder="option5" required>
															</div>';
														}
													}
													echo '                     
												</div>
											</div>
										</div>';
									}  
								}
							}
							echo '
							</div>
							<div class="col-sm-91 item">
								<div class="form-sep" style="margin-top: 10px; width: 100%">
									<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
									<button type="button" class="btn btn-info" style="margin-right:15px" onclick="addQuestion()">Add Question</button> 
									</div>
								</div>
							</div>
							<div style="clear:both;"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" onclick="location.href=\'obeassignments.php\'">Close</button>
							<input type="submit" name="submit_changes" value="Save Changes" class="btn btn-primary">
						</div>
				 	</div>
			  	</form>
		   	</div>
		</div>
		<script src="js/add_question/add_question.js"></script>
		<script>   
			window.addEventListener("DOMContentLoaded", function() {
				calculateTotalMarks();
			});
		
			// Calculate total marks
			function calculateTotalMarks() {
				var marksElements = document.querySelectorAll("#ques_marks");
				var totalMarks = 0;
				marksElements.forEach(function(element) {
					totalMarks += parseInt(element.value);
				});
				document.getElementById("marks").value = totalMarks;
			}

			// Update total marks when ques_marks is changed
			var quesMarksElements = document.querySelectorAll("#ques_marks");
			quesMarksElements.forEach(function(element) {
				element.addEventListener("change", function() {
					calculateTotalMarks();
				});
			});   
		
			$deleteid = [];
			function remove(questionId) {
				$deleteid.push(questionId);
				document.getElementById("ques_Container["+questionId+"]").remove();
				document.getElementById("questionId").value =  $deleteid;
				calculateTotalMarks();    
			}
		
			function quesContianer(selectValue,questionId) {
				questionContainer = document.getElementById("questionStatementContainer["+questionId+"]");
				showQuestionOptions(selectValue,questionContainer,questionId);          
			}
			
			$(".select2").select2({
				placeholder: "Select Any Option"
			})
		</script>';
	}
}