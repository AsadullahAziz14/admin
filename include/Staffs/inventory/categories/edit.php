<?php
if (!LMS_VIEW && isset($_GET['id'])) {
	$queryCategory = $dblms->querylms("SELECT category_id, category_name, category_description, category_status  
									FROM " .SMS_CATEGORIES. "
									WHERE category_id =  ".cleanvars($_GET['id'])." ");
	$valueCategory = mysqli_fetch_array($queryCategory);

	echo '
	<div class="row">
		<div class="modal-dialog" style="width:95%;">
			<form class="form-horizontal" method="post" enctype="multipart/form-data">
				<input type="hidden" name="category_id" value="'.$_GET['id'].'">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" style="font-weight:700;"> Edit Category</h4>
					</div>

					<div class="modal-body">
						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="category_name" class="req"><b>Category Name</b></label>
								<input type="text" class="form-control" id="category_name" name="category_name" value="'.$valueCategory['category_name'].'" required>	
							</div>
						</div>
						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="category_description" class="req"><b>Category Description</b></label>
								<input type="text" class="form-control" id="category_description" name="category_description" value="'.$valueCategory['category_description'].'" required>
							</div>
						</div>
						<div class="col-sm-91">
							<div style="margin-top:5px;">
							<label for="category_status" class="req"><b>Status</b></label>
								<select id="category_status" class="form-control" name="category_status" required>
									<option value="">Select Status</option>';
									foreach($status as $categoryStatus) {
										if($valueCategory['category_status'] == $categoryStatus['id']) {
											echo "<option value='$categoryStatus[id]' selected>$categoryStatus[name]</option>";
										} else {
											echo "<option value='$categoryStatus[id]'>$categoryStatus[name]</option>";
										}
									}
									echo'
								</select>
							</div>
						</div>
						<div style="clear:both;"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" onclick="location.href=\'inventory-categories.php\'" >Close</button>
						<input class="btn btn-primary" type="submit" value="Save Changes" id="edit_category" name="edit_category">
					</div>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript" src="assets/js/ckeditor/ckeditor.js"></script>
	<script>
		$(".select2").select2({
			placeholder: "Select Any Option"
		})
	</script>';
}