<?php
if (($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'add' => '1'))) {
	if(LMS_VIEW == 'add' && !isset($_GET['id'])) {
		$queryCLO = $dblms->querylms("SELECT cl.clo_id, cl.clo_number
										FROM ".OBE_CLOS." as cl
										INNER JOIN ".OBE_CLOS_PROGRAMS." as cp ON cl.clo_id = cp.id_clo
										WHERE cl.id_teacher = ".ID_TEACHER." AND cl.id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."AND cp.id_prg = ".ID_PRG." AND cp.semester = ".SEMESTER." AND cp.section = '".SECTION."'AND cl.id_course = ".ID_COURSE." AND cl.academic_session = '".ACADEMIC_SESSION."'  
									");
		$queryPAC = $dblms->querylms("SELECT pac_id, pac_statement
										FROM " .OBE_PACS."
										Where id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."	
									");
		echo '
		<div class="row">
			<div class="modal-dialog" style="width:95%;">
				<form class="form-horizontal" action="obekpis.php" method="POST"enctype="multipart/form-data" autocomplete="off">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" style="font-weight:700;">Add KPI</h4>
						</div>
						<div class="modal-body">
							<div class="col-sm-61" style="margin-bottom:10px;">
								<div style="margin-top:5px;">
									<label for="kpi_number" class="req"> <b>KPI Number</b></label>
									<input type="number" class="form-control" id="kpi_number" name="kpi_number" data-required="true" min="0">
								</div>
							</div>
							<div class="col-sm-61" style="margin-bottom:10px;">
								<div style="margin-top:5px;">
									<label for="kpi_marks" class="req"> <b>KPI Marks</b></label>
									<input type="number" class="form-control" id="kpi_marks" name="kpi_marks" data-required="true" min="0">
								</div>
							</div>
							<div class="col-sm-91" style="margin-bottom:10px;">
								<div style="margin-top:5px;">
									<label for="kpi_statement" class="req"> <b>KPI Statement</b></label>
									<textarea class="form-control" name="kpi_statement" id="kpi_statement" cols="30" rows="10" required></textarea>
								</div>
							</div>
							<div class="col-sm-91" style="margin-bottom:10px;">
								<div style="margin-top:5px;">
									<label for="clo" class="req"> <b>Mapped CLOs</b></label>
									<select id="clo" class="select2" name="clo[]" style="width:100%" multiple required>
										<option value="">Select CLOs</option>';
										while ($valueCLO = mysqli_fetch_array($queryCLO)) {
											echo '<option value="'.$valueCLO['clo_id'].'">'.$valueCLO['clo_number'].'</option>';
										}
										echo'
									</select>
								</div>
							</div>
							<div class="col-sm-61" style="margin-bottom:10px;">
								<div style="margin-top:5px;">
									<label for="id_pac" class="req"> <b>Mapped PACs</b></label>
									<select id="id_pac" class="form-control" name="id_pac" style="padding: 0%; width:100%; height:100%" autocomplete="off" required>
										<option value="">Select PACs</option>';
										while ($valuePAC = mysqli_fetch_array($queryPAC)) {
											echo '<option value="'.$valuePAC['pac_id'].'">'.$valuePAC['pac_statement'].'</option>';
										}
										echo'
									</select>
								</div>
							</div>
							
							<div class="col-sm-61" style="margin-bottom:10px;">
								<div style="margin-top:5px;">
									<label for="kpi_status" class="req"> <b>Status</b></label>
									<select id="kpi_status" class="form-control" name="kpi_status" required>
										<option value="">Select Status</option>';
										foreach ($status as $kpiStatus) {
											echo '<option value="'.$kpiStatus['id'].'">'.$kpiStatus['name'].'</option>';
										}
										echo'
									</select>
								</div>
							</div>
							<div style="clear:both;"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" onclick="location.href=\'obekpis.php\'">Close</button>
							<input class="btn btn-primary" type="submit" value="Add Record" id="submit_kpi" name="submit_kpi">
						</div>
					</div>
				</form>
			</div>
		</div>

		<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
		<script>
			$(".select2").select2({
				placeholder: "Select Any Option"
			})
		</script>';
	}
}
?>
