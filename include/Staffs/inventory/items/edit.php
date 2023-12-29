<?php 

if (!LMS_VIEW && isset($_GET['id'])) {
	$queryItem = $dblms->querylms("SELECT itm.item_title, itm.item_description, itm.item_article_number, itm.item_image,
									itm.item_style_number, itm.item_model_number, itm.item_dimensions, cat.category_id,
									cat.category_name, sub.sub_category_id, sub.sub_category_name
									FROM ".SMS_ITEMS." itm LEFT JOIN ".SMS_CATEGORIES." cat
									ON itm.id_category = cat.category_id 
									LEFT JOIN ".SMS_SUB_CATEGORIES." sub ON itm.id_sub_category = sub.sub_category_id
									WHERE itm.item_id = '".cleanvars($_GET['id'])."'");
	$valueItem = mysqli_fetch_array($queryItem);

	if($valueItem['item_image']) { 
		$itemImage = '<img class="avatar-large image-boardered" src="images/item_images/'.$valueItem['item_image'].'" alt="'.$valueItem['item_title'].'"/>';
	} else { 
		$itemImage = '';
	}

	echo '
	<!--WI_ADD_NEW_TASK_MODAL-->
	<div class="row">
		<div class="modal-dialog" style="width:95%;">
			<form class="form-horizontal" method="post" enctype="multipart/form-data">
				<input type="hidden" name="item_id" value="'.$_GET['id'].'">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" style="font-weight:700;"> Edit Item</h4>
					</div>

					<div class="modal-body">
						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="item_title" class="req"><b>Item Title</b></label>
								<input type="text" class="form-control" id="item_title" name="item_title" value="'.$valueItem['item_title'].'" required>	
							</div>
						</div>

						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="item_description" class="req"><b>Item Description</b></label>
								<textarea class="form-control" name="item_description" id="item_description" cols="" rows="2"  required>'.$valueItem['item_description'].'</textarea>
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="id_category" class="req"><b>Category</b></label>
								<select id="id_category" class="form-control" name="id_category" onchange="selectSubCategory()" required>
									<option value="'.$valueItem['category_id'].'">'.$valueItem['category_name'].'</option>';
									$queryCategories = $dblms->querylms("SELECT category_id, category_name 
																FROM ".SMS_CATEGORIES." 
																WHERE category_status = 1");
									while($valueCategory = mysqli_fetch_array($queryCategories)) { 
										if($valueCategory['category_id'] == $valueItem['category_id']) { continue; }
										echo '<option value="'.$valueCategory['category_id'].'">'.$valueCategory['category_name'].'</option>';
									}	
								echo '
								</select>
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="id_sub_category" class="req"><b>Sub-Category</b></label>
								<select id="id_sub_category" class="form-control" name="id_sub_category" required>
									<option value="'.$valueItem['sub_category_id'].'">'.$valueItem['sub_category_name'].'</option>
								</select>
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="item_article_number" class="req"><b>Article Number</b></label>
								<input type="text" class="form-control" id="item_article_number" name="item_article_number" value="'.$valueItem['item_article_number'].'">
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="item_style_number" class="req"><b>Style Number</b></label>
								<input type="text" class="form-control" id="item_style_number" name="item_style_number" value="'.$valueItem['item_style_number'].'">
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="item_model_number" class="req"><b>Model Number</b></label>
								<input type="text" class="form-control" id="item_model_number" name="item_model_number" value="'.$valueItem['item_model_number'].'">
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="item_dimensions" class="req"><b>Dimensions (l x w x h)</b></label>
								<input type="text" class="form-control" id="item_dimensions" name="item_dimensions" value="'.$valueItem['item_dimensions'].'">
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="item_uom" class="req"><b>UOM</b></label>
								<select name="item_uom" class="form-control" id="item_uom">
									<option value="">Select UOM</option>';
									foreach ($units_of_measurement as $uom) {
										if($valueItem['item_uom'] == $uom['id']) { 
											echo '<option value='.$uom['id'].' selected>'.$uom['name'].'</option>';
										} else {
											echo '<option value='.$uom['id'].'>'.$uom['name'].'</option>';
										}
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
									foreach($status as $itemStatus) {
										if($valueItem['item_status'] == $itemStatus['id']) {
											echo "<option value='$itemStatus[id]' selected>$itemStatus[name]</option>";
										} else {
											echo "<option value='$itemStatus[id]'>$itemStatus[name]</option>";
										}
									}
									echo'
								</select>
							</div>
						</div>

						<div class="col-sm-41">
							<div class="form-sep" style="margin-top:5px;">
								<label class="req">Photo</label>
								<input id="item_image" name="item_image" class="form-control btn-mid btn-primary clearfix" type="file" >'.$itemImage.'Size: <span style="color:red;">(450px X 338px)</span>
							</div> 
						</div>
						<div style="clear:both;"></div>
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-default" onclick="location.href=\'inventory-items.php\'" >Close</button>
						<input class="btn btn-primary" type="submit" value="Save Changes" id="edit_item" name="edit_item">
					</div>
				</div>
			</form>
		</div>
	</div>
	<!--WI_ADD_NEW_TASK_MODAL-->';
}

?>