<?php
if (!LMS_VIEW && isset($_GET['id'])) {

   $sqllms = $dblms->querylms("SELECT * FROM " .SMS_ITEM_ISSUANCE. " WHERE issuance_id =  ".cleanvars($_GET['id'])." ");
   $rowstd = mysqli_fetch_array($sqllms);
//    $sqllms1 = $dblms->querylms("SELECT GROUP_CONCAT(id_item) as id_item FROM " .SMS_ISSUANCE_ITEM_JUNCTION. " WHERE id_issuance =  ".cleanvars($_GET['id'])." ");
//    $rowstd1 = mysqli_fetch_array($sqllms);


   echo '

   <!--WI_ADD_NEW_TASK_MODAL-->
   <div class="row">
      <div class="modal-dialog" style="width:90%;">
         <form class="form-horizontal" action="issuance.php?id='.$_GET['id'].'" method="post" enctype="multipart/form-data">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title" style="font-weight:700;"> Edit Issuance</h4>
               </div>

               <div class="modal-body">

			   			<!-- <div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="issuance_quantity" class="req"><b>Issuance Quantity</b></label>
								<input type="text" class="form-control" id="issuance_quantity" name="issuance_quantity" required>
							</div>
						</div> -->

						<div class="col-sm-91">
							<div style="margin-top:5px;">
								<label for="issuance_remarks" class="req"><b>Remarks</b></label>
								<input type="text" class="form-control" id="issuance_remarks" name="issuance_remarks" value="'.$rowstd['issuance_remarks'].'" required>
							</div>
						</div>

						';
						$sqllms1 = $dblms->querylms("SELECT GROUP_CONCAT(id_item) as id_item
													FROM ".SMS_ISSUANCE_ITEM_JUNCTION."  
													WHERE ".SMS_ISSUANCE_ITEM_JUNCTION.".id_issuance = ".$rowstd['issuance_id']."");
						$rowstd1 = mysqli_fetch_array($sqllms1);
						$issuanceItemArray = explode(',',$rowstd1['id_item']);

						$sqllms2 = $dblms->querylms("SELECT item_id, item_title
													FROM ".SMS_ITEMS." 
													WHERE ".SMS_ITEMS.".item_status = '1'");
						echo '
						<div class="col-sm-61">
							<div style="margin-top:5px;">
							<label for="id_item" class="req"><b>Items</b></label>
								<select id="id_item" class="form-control" name="id_item" required>
								<option value="">Select Status</option>';
								while($rowstd2 = mysqli_fetch_array($sqllms2)) 
								{
									if(in_array($rowstd2['item_id'],$issuanceItemArray)) {
										echo "<option value='".$rowstd2['item_id']."' selected>".$rowstd2['item_title']."</option>";
									} else {
										echo "<option value='".$rowstd2['item_id']."'>".$rowstd2['item_title']."</option>";
									}
								}
								echo'
								</select>
							</div>
						</div>

						<div class="col-sm-61">
							<div style="margin-top:5px;">
							<label for="issuance_status" class="req"><b>Status</b></label>
								<select id="issuance_status" class="form-control" name="issuance_status" required>
								<option value="">Select Status</option>';
								foreach($status as $itemadm_status) 
								{
								if($rowstd['issuance_status'] == $itemadm_status['id']) {
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
                  <button type="button" class="btn btn-default" onclick="location.href=\'issuance.php\'" >Close</button>
                  <input class="btn btn-primary" type="submit" value="Save Changes" id="edit_issuance" name="edit_issuance">
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