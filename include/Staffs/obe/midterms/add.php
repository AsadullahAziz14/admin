<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'add' => '1'))) { 
	if(LMS_VIEW == 'add' && !isset($_GET['id'])) { 
		$queryMidterm = $dblms->querylms("SELECT mt_id 
											FROM " .OBE_MIDTERMS. " 
											WHERE id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND theory_paractical = ".COURSE_TYPE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])." AND id_added = ".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."
										");
		$valueMidterm = mysqli_fetch_array($queryMidterm);
		if($valueMidterm != '' ) {
			echo "
			<script>
				alert('You cann Only Add One MidTerm Paper.');
				window.location.href = 'obemidterms.php';
			</script>";
		} else {
			echo '
			<div class="row">
				<div class="modal-dialog" style="width:95%;">
					<form class="form-horizontal" action="obemidterms.php" method="POST" enctype="multipart/form-data" autocomplete="off">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" style="font-weight:700;">Add MidTerm</h4>
							</div>
							<div class="modal-body">
								<div class="col-sm-61">
									<div class="form-sep" style="margin-top:5px;">
										<label for="mt_number" class="req"><b>  MidTerm Number</b></label>
										<input type="number" class="form-control" id="mt_number" min="1" name="mt_number" required>
									</div>
								</div>
								<div class="col-sm-61">
									<div class="form-sep" style="margin-top:5px;">
									<label for="mt_status" class="req"><b>Status</b></label>
										<select id="mt_status" class="form-control" name="mt_status" style="width:100%" required>
											<option value="">Select Status</option>';
											foreach ($status as $midtermStatus) {
												echo '<option value="'.$midtermStatus['id'].'">'.$midtermStatus['name'].'</option>';
											}
										echo '
										</select>
									</div>
								</div>
								<div style="clear:both;"></div>
								<div class="col-sm-61">
									<div class="form-sep" style="margin-top:5px;">
										<label for="marks" class="req"><b>MidTerm Marks</b></label>
										<input type="number" class="form-control" id="marks" name="marks" value="0" readonly required>
									</div>
								</div>
								<div class="col-sm-61">
									<div class="form-sep" style="margin-top:5px;">
										<label for="mt_date" class="req"><b>MidTerm Date</b></label>
										<input type="date" class="form-control" id="mt_date" name="mt_date" required>
									</div>
								</div>
								<div style="clear:both;"></div>
								<div id="questionContainer" style="margin-top:10px; margin-bottom: 10px;" class="col-sm-91">
									<!-- Question will be added here -->
								</div>
								<div class="col-sm-91 item">
									<div class="form-sep" style="margin-top: 10px; width: 100%">
										<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
											<button type="button" class="btn btn-info" style="margin-right:15px; float:right;" onclick="addQuestion()">Add Question</button>	
										</div>
									</div>
								</div>
							</div>
							<div style="clear:both;"></div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" onclick="location.href=\'obemidterms.php\'">Close</button>
								<input class="btn btn-primary" type="submit" value="Add Record" id="submit_midterm" name="submit_midterm">
							</div>
						</div>
					</form>
				</div>
			</div>
			<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
			<script src="js/add_question/add_question.js"></script>
			<script src="js/select2/jquery.select2.js"></script>
			<script>
				$(".select2").select2({
					placeholder: "Select Any Option"
				})
			</script>';
		}
	}
}