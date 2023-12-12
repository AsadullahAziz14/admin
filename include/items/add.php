<?php
if(LMS_VIEW == 'add' && !isset($_GET['id'])) 
{ 
	echo '
	</pre>
	<div class="row">
		<div class="modal-dialog" style="width:90%;">
			<form class="form-horizontal" action="items.php" method="POST" enctype="multipart/form-data" autocomplete="off">
				<div class="modal-content">
					<div class="modal-header"> 
						<h4 class="modal-title" style="font-weight:700;">Add Item</h4>
					</div>

					<div class="modal-body">

						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="item_title" class="req"><b>Item Title</b></label>
								<input type="text" class="form-control" id="item_title" name="item_title" required>	
							</div>
						</div>

						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="item_description" class="req"><b>Item Description</b></label>
								<textarea class="form-control" name="item_description" id="item_description" cols="" rows="2" required></textarea>
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="id_category" class="req"><b>Category</b></label>
								<select id="id_category" class="form-control" name="id_category" onchange="selectSubCategory()" required>
									<option value="">Select Category</option>';
									$sqllms1 = $dblms->querylms("SELECT category_id, category_name 
															FROM " .SMS_CATEGORIES. " 
															WHERE category_status = 1");
									while($rowstd1 = mysqli_fetch_array($sqllms1)) {
										echo '<option value="'.$rowstd1['category_id'].'">'.$rowstd1['category_name'].'</option>';
									}	
								echo '
								</select>
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="id_sub_category" class="req"><b>Sub-Category</b></label>
								<select id="id_sub_category" class="form-control" name="id_sub_category" required>
									 <!-- Options are populated dynamically using AJAx onchange of category_id selector which is above -->
								</select>
							</div>
						</div>


						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="item_article_number" class="req"><b>Article Number</b></label>
								<input type="text" class="form-control" id="item_article_number" name="item_article_number" required>
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="item_style_number" class="req"><b>Style Number</b></label>
								<input type="text" class="form-control" id="item_style_number" name="item_style_number" required>
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="item_model_number" class="req"><b>Model Number</b></label>
								<input type="text" class="form-control" id="item_model_number" name="item_model_number" required>
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="item_dimensions" class="req"><b>Dimensions (l x w x h)</b></label>
								<input type="text" class="form-control" id="item_dimensions" name="item_dimensions" required>
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="item_uom" class="req"><b>UOM</b></label>
								<select name="item_uom" class="form-control" id="item_uom">
									<option value="">Select UOM</option>';
									foreach ($units_of_measurement as $uom) {
										echo '<option value='.$uom['id'].'>'.$uom['name'].'</option>';
									}
									echo '
								</select>
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
							<label for="item_status" class="req"><b>Status</b></label>
								<select id="item_status" class="form-control" name="item_status" required>
									<option value="">Select Status</option>';
									foreach ($status as $adm_status) {
										echo '
											<option value="'.$adm_status['id'].'">'.$adm_status['name'].'</option>
										';
									}
						echo '
								</select>
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label>Photo (Optional)</label>
								<input id="item_image" name="item_image" class="form-control btn btn-mid btn-primary clearfix" type="file" accept=".jpg, .jpeg, .png ">Size: <span style="color:red;">(450px X 338px)</span>
							</div> 
						</div>

						<div style="clear:both;"></div>

					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" onclick="location.href=\'items.php\'">Close</button>
						<input class="btn btn-primary" type="submit" value="Add Record" id="submit_item" name="submit_item">
					</div>
				</div>
				
			</form>
		</div>
	</div>

	<script>
		function selectSubCategory() 
		{
			var id_category = document.getElementById("id_category").value;

			var ajaxReq = new XMLHttpRequest();
			var method = "GET";
			var url = "include/ajax/getSubCategory.php?selectedValue=" + id_category;
			var asynchronous = true;

			ajaxReq.open(method, url,asynchronous);
			ajaxReq.send();

			ajaxReq.onreadystatechange = function() 
			{
				if (ajaxReq.readyState === 4 && ajaxReq.status === 200) {
					const options = ajaxReq.responseText;
					var id_sub_category = document.getElementById("id_sub_category");
					
					id_sub_category.innerHTML = options;
					console.log(options);
				}
			};
		}
	</script>


	<script src="js/select2/jquery.select2.js"></script>

	<script>
		$(".select2").select2({

			placeholder: "Select Any Option"

		})

	</script>
	';
}

?>