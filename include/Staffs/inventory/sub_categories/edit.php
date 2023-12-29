<?php

if (!LMS_VIEW && isset($_GET['id'])) {

   $sqllms = $dblms->querylms("SELECT * FROM " .SMS_SUB_CATEGORIES. " WHERE sub_category_id =  ".cleanvars($_GET['id'])." ");
   $rowstd = mysqli_fetch_array($sqllms);

   echo '

   <!--WI_ADD_NEW_TASK_MODAL-->
   <div class="row">
      <div class="modal-dialog" style="width:95%;">
         <form class="form-horizontal" action="inventory-sub_categories.php?id='.$_GET['id'].'" method="post" enctype="multipart/form-data">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title" style="font-weight:700;"> Edit Sub-Category</h4>
               </div>

               <div class="modal-body">

						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="sub_category_name" class="req"><b>Sub-Category Name</b></label>
								<input type="text" class="form-control" id="sub_category_name" name="sub_category_name" value="'.$rowstd['sub_category_name'].'" required>	
							</div>
						</div>

						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="sub_category_description" class="req"><b>Sub-Category Description</b></label>
								<input type="text" class="form-control" id="sub_category_description" name="sub_category_description" value="'.$rowstd['sub_category_description'].'" required>
							</div>
						</div>

                  <div class="col-sm-91">
							<div style="margin-top:5px;">
							<label for="id_category" class="req"><b>Mapped Category</b></label>
								<select id="id_category" class="form-control" name="id_category" required>
									<option value="">Select Status</option>';
									$sqllms1 = $dblms->querylms("SELECT category_id, category_name FROM " .SMS_CATEGORIES. " WHERE category_status = 1");
									while($rowstd1 = mysqli_fetch_array($sqllms1))
									{
                              if($rowstd['id_category'] == $rowstd1['category_id'])
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

						<div class="col-sm-91">
							<div style="margin-top:5px;">
							<label for="sub_category_status" class="req"><b>Status</b></label>
								<select id="sub_category_status" class="form-control" name="sub_category_status" required>
                        <option value="">Select Status</option>';
                        foreach($status as $itemadm_status) 
                        {
                           if($rowstd['sub_category_status'] == $itemadm_status['id']) {
                              echo "<option value='$itemadm_status[id]' selected>$itemadm_status[name]</option>";
                           } else {
                              echo "<option value='$itemadm_status[id]'>$itemadm_status[name]</option>";
                           }
                        }
                        echo'
								</select>
							</div>
						</div>

						<div style="clear:both;"></div>

					</div>
            
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" onclick="location.href=\'inventory-sub_categories.php\'" >Close</button>
                  <input class="btn btn-primary" type="submit" value="Save Changes" id="edit_sub_category" name="edit_sub_category">
               </div>
            
            </div>
         </form>
      </div>
   </div>
   <!--WI_ADD_NEW_TASK_MODAL-->



<script type="text/javascript" src="assets/js/ckeditor/ckeditor.js"></script>
<script>
   $(".select2").select2({

      placeholder: "Select Any Option"

   })

</script>';
}