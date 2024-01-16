<?php
if(LMS_VIEW == 'add' && !isset($_GET['id'])) { 
	echo '
	<div class="row">
		<div class="modal-dialog" style="width:95%;">
			<form class="form-horizontal" action="inventory-sub_category.php" method="POST" enctype="multipart/form-data" autocomplete="off">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" style="font-weight:700;">Add Sub-Category</h4>
					</div>
					<div class="modal-body">

						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="sub_category_name" class="req"><b>Sub-Category Name</b></label>
								<input type="text" class="form-control" id="sub_category_name" name="sub_category_name" required>	
							</div>
						</div>

						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="sub_category_description" class="req"><b>Sub-Category Description</b></label>
								<input type="text" class="form-control" id="sub_category_description" name="sub_category_description" required>
							</div>
						</div>

						<div class="col-sm-91">
							<div style="margin-top:5px;">
							<label for="id_category" class="req"><b>Mapped Category</b></label>
								<select id="id_category" class="form-control" name="id_category" required>
									<option value="">Select Status</option>';
									$sqllms = $dblms->querylms("SELECT category_id, category_name FROM " .SMS_CATEGORIE." WHERE category_status = 1");
									while($rowstd = mysqli_fetch_array($sqllms))
									{
										echo '<option value="'.$rowstd['category_id'].'">'.$rowstd['category_name'].'</option>';
									}
									echo '
								</select>
							</div>
						</div>

						<div class="col-sm-91">
							<div style="margin-top:5px;">
							<label for="sub_category_status" class="req"><b>Status</b></label>
								<select id="sub_category_status" class="form-control" name="sub_category_status" required>
									<option value="">Select Status</option>';
									foreach ($status as $adm_status) {
										echo '<option value="'.$adm_status['id'].'">'.$adm_status['name'].'</option>';
									}
									echo '
								</select>
							</div>
						</div>
						<div style="clear:both;"></div>

					</div>

				
					<div class="modal-footer">
						<button type="button" class="btn btn-default" onclick="location.href=\'inventory-sub_category.php\'">Close</button>
						<input class="btn btn-primary" type="submit" value="Add Record" id="submit_sub_category" name="submit_sub_category">
					</div>
				</div>
			</form>
		</div>
	</div>

	<script src="js/select2/jquery.select2.js"></script>
	<script>
		$(".select2").select2({
			placeholder: "Select Any Option"
		})
	</script>
	';
}

?>