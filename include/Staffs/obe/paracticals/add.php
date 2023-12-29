<?php
if (($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'add' => '1'))) {
	if(LMS_VIEW == 'add' && !isset($_GET['id'])) { 
		$kpi_sqllms = $dblms->querylms("SELECT sum(kpi_marks) as paractical_marks, GROUP_CONCAT(kpi_id) as kpiIds
														FROM ".OBE_KPIS."
														Where kpi_id != '' AND id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
													");
		$row_kpi_sqllms = mysqli_fetch_array($kpi_sqllms);
		if($row_kpi_sqllms['kpiIds'] == "") {
			echo "
			<script>
				alert('Please Enter the KPIs First.');
				window.location.href = 'obehome.php';
			</script>";
		} else {
			echo '
			<div class="row">
				<div class="modal-dialog" style="width:95%;">
					<form class="form-horizontal" action="obeparacticals.php" method="POST" enctype="multipart/form-data" autocomplete="off">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" style="font-weight:700;">Add Paractical</h4>
							</div>
							<div class="modal-body">
								<div class="col-sm-61">
									<div class="form-sep" style="margin-top:5px;">
										<label for="pp_number" class="req"><b>  Paractical Number</b></label>
										<input type="number" class="form-control" id="pp_number" name="pp_number" min="0" required>
									</div>
								</div>
								<div class="col-sm-61">
									<div class="form-sep" style="margin-top:5px;">
									<label for="pp_status" class="req"><b>Status</b></label>
										<select id="pp_status" class="form-control" name="pp_status" style="width:100%" required>
											<option value="">Select Status</option>';
											foreach ($status as $adm_status) {
												echo '<option value="'.$adm_status['id'].'">'.$adm_status['name'].'</option>';
											}
										echo '
										</select>
									</div>
								</div>
								<div style="clear:both;"></div>
								<input type="hidden" class="form-control" id="kpi_ids" name="kpi_ids" value="'.$row_kpi_sqllms['kpiIds'].'" readonly>
								<div class="col-sm-61">
									<div class="form-sep" style="margin-top:5px;">
										<label for="pp_marks" class="req"><b>Paractical Marks</b></label>
										<input type="number" class="form-control" id="pp_marks" name="pp_marks" value="'.$row_kpi_sqllms['paractical_marks'].'" readonly required>
									</div>
								</div>
								<div class="col-sm-61">
									<div class="form-sep" style="margin-top:5px;">
									<label for="pp_date" class="req"><b>Paractical Date</b></label>
										<input type="date" class="form-control" id="pp_date" name="pp_date" required>
									</div>
								</div>
								<div style="clear:both;"></div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" onclick="location.href=\'obeparacticals.php\'">Close</button>
								<input class="btn btn-primary" type="submit" value="Add Record" id="submit_paractical" name="submit_paractical">
							</div>
						</div>
					</form>
				</div>
			</div>
			<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
			<script src="js/select2/jquery.select2.js"></script>
			<script>
				$(".select2").select2({
					placeholder: "Select Any Option"
				})
			</script>';
		}
	}
}
?>
