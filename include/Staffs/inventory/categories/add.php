<?php
if(LMS_VIEW == 'add' && !isset($_GET['id'])) { 
	echo '
	<div class="row">
		<div class="modal-dialog" style="width:95%;">
			<form class="form-horizontal" action="#" method="post" id="addNewBcat" enctype="multipart/form-data">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" style="font-weight:700;">Add Category</h4>
					</div>
					<div class="modal-body">
						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="category_name" class="req"><b>Category Name</b></label>
								<input type="text" class="form-control" id="category_name" name="category_name" required>	
							</div>
						</div>

						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="category_description" class="req"><b>Category Description</b></label>
								<input type="text" class="form-control" id="category_description" name="category_description" >
							</div>
						</div>

						<div class="col-sm-91">
							<div style="margin-top:5px;">
							<label for="category_status" class="req"><b>Status</b></label>
								<select id="category_status" class="form-control" name="category_status" >
									<option value="">Select Status</option>';
									foreach ($status as $statusCategory) {
										echo '<option value="'.$statusCategory['id'].'">'.$statusCategory['name'].'</option>';
									}
									echo '
								</select>
							</div>
						</div>
						<div style="clear:both;"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" onclick="location.href=\'inventory-categories.php\'">Close</button>
						<input class="btn btn-primary" type="submit" value="Add Record" id="submit_category" name="submit_category">
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
	</script>';
}
?>