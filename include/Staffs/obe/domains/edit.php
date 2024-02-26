<?php 
if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'edit' => '1'))) {
	if (!LMS_VIEW && isset($_GET['id'])) {
		$queryDomain = $dblms->querylms("SELECT domain_id, domain_status, domain_name, id_prg 
											FROM ".OBE_DOMAINS." WHERE domain_id = ".cleanvars($_GET['id'])."");
		$valueDomain = mysqli_fetch_assoc($queryDomain);
		echo '
		<div class="row">
			<div class="modal-dialog" style="width:95%;">
				<form class="form-horizontal" action="obedomains.php?id='.$_GET['id'].'" method="POST" id="editRecord">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
							<h4 class="modal-title" style="font-weight:700;">Edit DOMAIN Details</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label class="control-label req col-lg-12" style="width:auto;"> <b>Domain Name</b></label>
								<div class="col-lg-12">
									<input type="text" class="form-control" value="'.$valueDomain['domain_name'].'" id="domain_name" name="domain_name" required></input>
								</div>
							</div>';

							$queryPRG = $dblms->querylms("SELECT GROUP_CONCAT(prg_id) as prg_id, GROUP_CONCAT(prg_name) as prg_name 
															FROM ".PROGRAMS." 
															WHERE prg_id != ''
														");
							$valuePRG = mysqli_fetch_array($queryPRG);
							$id_prgArray = explode(',',$valuePRG['prg_id']);
							$prg_nameArray = explode(',',$valuePRG['prg_name']);	
							$domian_idPrg = explode(',',$valueDomain['id_prg']);
							echo '
							<div class="form-group">
								<label class="control-label req col-lg-12" style="width:150px;"><b>Programs</b></label>
								<div class="col-lg-12">
									<select id="id_prg" class="select2" name="id_prg[]" style="width:100%" multiple>
									';
									foreach($id_prgArray as $key => $prg_id) {
										if(in_array($prg_id,$domian_idPrg)) {
											echo '<option value="'.$prg_id.'" selected>'.$prg_nameArray[$key].'</option>';
										} else {
											echo '<option value="'.$prg_id.'">'.$prg_nameArray[$key].'</option>';
										}
									}
									echo '
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label req col-lg-12" style="width:auto;"><b>Status</b></label>
								<div class="col-lg-12">
									<select id="domain_status" name="domain_status" style="width:100%" autocomplete="off" required>
										<option value="">Select Status</option>';
										foreach($status as $domainStatus) {
										   if($valueDomain['domain_status'] == $domainStatus['id']) {
											  echo "<option value='$domainStatus[id]' selected>$domainStatus[name]</option>";
										   } else {
											  echo "<option value='$domainStatus[id]'>$domainStatus[name]</option>";
										   }
										}
										echo'
									</select>
								</div>
							</div>

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" onclick="location.href=\'obedomains.php\'"  aria-hidden="true">Close</button>
							<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes">
						</div>
					</div>
				</form>
			</div>
		</div>
		<!--WI_EDIT_NEW_TASK_MODAL-->
		<script type="text/javascript">
			$(".select2").select2({
				placeholder : "Select Any Option"
			});
		</script>
		';
	}
}