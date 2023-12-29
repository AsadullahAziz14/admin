<?php
if (($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'add' => '1'))) {
   if (!LMS_VIEW && isset($_GET['id'])) {
      $sqllms = $dblms->querylms("SELECT pac_id, pac_status, pac_number, pac_weightage, pac_statement, id_prg FROM ".OBE_PACS." WHERE pac_id = ".cleanvars($_GET['id'])."");
      $value_pac = mysqli_fetch_assoc($sqllms);

      echo '
      <div class="row">
         <div class="modal-dialog" style="width:95%;">
            <form class="form-horizontal" action="obepacs.php?id='.$_GET['id'].'" method="post" enctype="multipart/form-data">
               <div class="modal-content">
                  <div class="modal-header">
                     <h4 class="modal-title" style="font-weight:700;"> Edit PAC</h4>
                  </div>
                  <div class="modal-body">
                     <div class="col-sm-61" style="margin-bottom:10px;">
                        <label for="pac_number" class="req" style="width:150px;"> <b>PAC Number</b></label>
                        <input type="text" class="form-control" id="pac_number" name="pac_number" value="'.$value_pac['pac_number'].'" autofocus autocomplete="off" required>
                     </div>
                     <div class="col-sm-61" style="margin-bottom:10px;">
                        <label for="pac_weightage" class="req" style="width:150px;"> <b>PAC Weightage</b></label>
                        <input type="number" class="form-control" id="pac_weightage" name="pac_weightage" value="'.$value_pac['pac_weightage'].'" data-required="true">
                     </div>  
                     <div style="clear:both;"></div>
                     <div class="col-sm-91" style="margin-bottom:10px;">
                        <label for="pac_statement" class="control-label req" style="width:150px;"> <b>PAC Statement</b></label>
                        <textarea class="form-control" name="pac_statement" id="pac_statement" cols="20" rows="3" required>'.$value_pac['pac_statement'].'</textarea>
                     </div>
                     <div style="clear:both;"></div>
                     <div class="col-sm-61" style="margin-bottom:10px;">
                        <label for="program" class="control-label req" style="width:150px;"> <b>PAC Program</b></label>
                        <select id="program" class="form-control" name="program" style="width:100%" autocomplete="off" required>
                           <option value="">Select Program</option>';
                           foreach($programs as $item_program) {
                              if($value_pac['id_prg'] == $item_program['id']) {
                                 echo "<option value='$item_program[id]' selected>$item_program[name]</option>";
                              } else {
                                 echo "<option value='$item_program[id]'>$item_program[name]</option>";
                              }
                           }
                           echo'
                        </select>
                     </div>
                     <div class="col-sm-61" style="margin-bottom:10px;">
                        <label for="pac_status" class="control-label req" style="width:150px;"> <b>Status</b></label>
                        <select id="pac_status" class="form-control" name="pac_status" style="width:100%" required>
                           <option value="">Select Status</option>';
                           foreach($status as $pacStatus) {
                              if($value_pac['pac_status'] == $pacStatus['id']) {
                                 echo "<option value='$pacStatus[id]' selected>$pacStatus[name]</option>";
                              } else {
                                 echo "<option value='$pacStatus[id]'>$pacStatus[name]</option>";
                              }
                           }
                           echo'
                        </select>
                     </div>
                     <div style="clear:both;"></div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-default" onclick="location.href=\'obepacs.php\'" >Close</button>
                     <input class="btn btn-primary" type="submit" value="Save Changes" id="edit_pac" name="edit_pac">
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
}
