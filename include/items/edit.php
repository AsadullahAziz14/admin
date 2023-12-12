<?php
if (!LMS_VIEW && isset($_GET['id'])) {

   $sqllms = $dblms->querylms("SELECT * FROM " .SMS_ITEMS. " WHERE item_id =  ".cleanvars($_GET['id'])." ");
   $rowstd = mysqli_fetch_array($sqllms);
   if($rowstd['item_image'])
   {	
		$itemImage = '<img class="avatar-large image-boardered" src="images/item_images/'.$rowstd['item_image'].'" alt="'.$rowstd['item_title'].'"/>';
	} 
	else 
	{
		$itemImage = '';
	}
   echo '

   <!--WI_ADD_NEW_TASK_MODAL-->
   <div class="row">
      <div class="modal-dialog" style="width:90%;">
         <form class="form-horizontal" action="items.php?id='.$_GET['id'].'" method="post" enctype="multipart/form-data">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title" style="font-weight:700;"> Edit Item</h4>
               </div>

               <div class="modal-body">

						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="item_title" class="req"><b>Item Title</b></label>
								<input type="text" class="form-control" id="item_title" name="item_title" value="'.$rowstd['item_title'].'" required>	
							</div>
						</div>

						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="item_description" class="req"><b>Item Description</b></label>
								<textarea class="form-control" name="item_description" id="item_description" cols="" rows="2"  required>'.$rowstd['item_description'].'</textarea>
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="id_category" class="req"><b>Category</b></label>
								<select id="id_category" class="form-control" name="id_category" onchange="updateSecondSelector()" required>
									<option value="">Select Category</option>';
									$sqllms1 = $dblms->querylms("SELECT category_id, category_name 
															FROM " .SMS_CATEGORIES. " 
															WHERE category_status = 1");
									while($rowstd1 = mysqli_fetch_array($sqllms1)) {
										
										if($rowstd1['category_id'] == $rowstd['id_category'])
										{
											echo '<option value="'.$rowstd1['category_id'].'" selected>'.$rowstd1['category_name'].'</option>';
										}
										else
										{
											echo '<option value="'.$rowstd1['category_id'].'">'.$rowstd1['category_name'].'</option>';
										}
									}	
								echo '
								</select>
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="id_sub_category" class="req"><b>Sub-Category</b></label>
								<select id="id_sub_category" class="form-control" name="id_sub_category" required>
									<option value="">Select Category</option>';
									
									$sqllms2 = $dblms->querylms("SELECT sub_category_id, sub_category_name 
															FROM " .SMS_SUB_CATEGORIES. " 
															WHERE sub_category_status = 1
															");
									while($rowstd2 = mysqli_fetch_array($sqllms2)) 
									{	
										if($rowstd2['sub_category_id'] == $rowstd['id_sub_category'])
										{
											echo '<option value="'.$rowstd2['sub_category_id'].'" selected>'.$rowstd2['sub_category_name'].'</option>';
										}
										
									}	
								echo '
								</select>
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="item_article_number" class="req"><b>Article Number</b></label>
								<input type="text" class="form-control" id="item_article_number" name="item_article_number" value="'.$rowstd['item_article_number'].'">
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="item_style_number" class="req"><b>Style Number</b></label>
								<input type="text" class="form-control" id="item_style_number" name="item_style_number" value="'.$rowstd['item_style_number'].'">
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="item_model_number" class="req"><b>Model Number</b></label>
								<input type="text" class="form-control" id="item_model_number" name="item_model_number" value="'.$rowstd['item_model_number'].'">
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="item_dimensions" class="req"><b>Dimensions (l x w x h)</b></label>
								<input type="text" class="form-control" id="item_dimensions" name="item_dimensions" value="'.$rowstd['item_dimensions'].'">
							</div>
						</div>

						<div class="col-sm-41">
							<div style="margin-top:5px;">
								<label for="item_uom" class="req"><b>UOM</b></label>
								<select name="item_uom" class="form-control" id="item_uom">
									<option value="">Select UOM</option>';
									foreach ($units_of_measurement as $uom) 
									{
										if($rowstd['item_uom'] == $uom['id']) {
											echo '<option value='.$uom['id'].' selected>'.$uom['name'].'</option>';
										}
										else{
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
									foreach($status as $itemadm_status) 
									{
									if($rowstd['item_status'] == $itemadm_status['id']) {
										echo "<option value='$itemadm_status[id]' selected>$itemadm_status[name]</option>";
									} else {
										echo "<option value='$itemadm_status[id]'>$itemadm_status[name]</option>";
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
                  <button type="button" class="btn btn-default" onclick="location.href=\'items.php\'" >Close</button>
                  <input class="btn btn-primary" type="submit" value="Save Changes" id="edit_item" name="edit_item">
               </div>
            
            </div>
         </form>
      </div>
   </div>
   <!--WI_ADD_NEW_TASK_MODAL-->



<script type="text/javascript" src="assets/js/ckeditor/ckeditor.js"></script>
<script>
	function updateSecondSelector() 
	{
		var selectedValue = document.getElementById("id_category").value;

		var ajaxReq = new XMLHttpRequest();
		var method = "GET";
		var url = "include/ajax/get_Options.php?selectedValue=" + selectedValue;
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
<script>
   $(".select2").select2({

      placeholder: "Select Any Option"

   })

</script>';
}