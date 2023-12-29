<?php
if (($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'add' => '1'))) {
   if (!LMS_VIEW && isset($_GET['id'])) {
      $queryKPI = $dblms->querylms("SELECT kpi_id, kpi_status, kpi_number, kpi_marks, kpi_statement, id_pac, id_clo 
                                       FROM ".OBE_KPIS." 
                                       WHERE kpi_id =  ".cleanvars($_GET['id'])."
                                 ");
      $valueKPI = mysqli_fetch_assoc($queryKPI);
      $kpiClO = explode(',', $valueKPI['id_clo']);

      $queryCLO = $dblms->querylms("SELECT cl.clo_id, cl.clo_number
                                       FROM ".OBE_CLOS." as cl
                                       INNER JOIN ".OBE_CLOS_PROGRAMS." as cp ON cl.clo_id = cp.id_clo
                                       WHERE cl.id_teacher = ".ID_TEACHER." AND cl.id_course = ".ID_COURSE." AND cp.id_prg = ".ID_PRG." AND cp.semester = ".SEMESTER." AND cp.section = '".SECTION."' AND cl.academic_session = '".ACADEMIC_SESSION."' AND cl.id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                                 "); 
      $queryPAC = $dblms->querylms("SELECT pac_id
                                       FROM ".OBE_PACS."
                                       Where id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."	
                                 ");
      echo '
      <div class="row">
         <div class="modal-dialog" style="width:95%;">
            <form class="form-horizontal" action="obekpis.php?id='.$_GET['id'].'" method="post" enctype="multipart/form-data">
               <div class="modal-content">
                  <div class="modal-header">
                     <h4 class="modal-title" style="font-weight:700;"> Edit KPI</h4>
                  </div>
                  <div class="modal-body">
                     <div class="col-sm-61" style="margin-bottom:10px;">
                        <div style="margin-top:5px;">
                           <label for="kpi_number" class="req"> <b>KPI Number</b></label>
                           <input type="text" class="form-control" id="kpi_number" name="kpi_number" value="'.$valueKPI['kpi_number'].'" autofocus autocomplete="off" required>
                        </div>
                     </div>
                     <div class="col-sm-61" style="margin-bottom:10px;">
                        <div style="margin-top:5px;">
                           <label for="Kpi_marks" class="req"> <b>KPI Marks</b></label>
                           <input type="number" class="form-control" id="Kpi_marks" name="Kpi_marks" value="'.$valueKPI['kpi_marks'].'" required="true">
                        </div>
                     </div>
                     <div class="col-sm-91" style="margin-bottom:10px;">
                        <div style="margin-top:5px;">
                           <label for="kpi_statement" class="req"> <b>KPI Statement</b></label>
                           <textarea class="form-control" name="kpi_statement" id="kpi_statement" cols="20" rows="3" required>'.$valueKPI['kpi_statement'].'</textarea>
                        </div>
                     </div>
                     <div class="col-sm-91" style="margin-bottom:10px;">
                        <div style="margin-top:5px;">
                           <label for="clo" class="req"> <b>Mapped ClOs</b></label>
                           <select class="select2" name="clo[]" style="width:100%" id="clo"  multiple required>';
                              while ($valueCLO = mysqli_fetch_array($queryCLO)) {
                                 if (in_array($valueCLO['clo_id'], $kpiClO)) {
                                    echo '<option value = "'.$valueCLO['clo_id'].'" selected>'.$valueCLO['clo_number'].'</option>';
                                 } else {
                                    echo '<option value = "'.$valueCLO['clo_id'].'">'.$valueCLO['clo_number'].'</option>';
                                 }
                              }
                              echo '
                           </select>
                        </div>
                     </div>
                     <div class="col-sm-61" style="margin-bottom:10px;">
                        <div style="margin-top:5px;">
                           <label for="id_pac" class="req"><b>Mapped PAC</b></label>
                           <select id="id_pac" class="form-control" name="id_pac"  required>
                              <option value="">Select PAC</option>';
                              while ($valuePAC = mysqli_fetch_array($queryPAC)) {
                                 if($valueKPI['id_pac'] == $valuePAC['pac_id']) {
                                    echo "<option value='$valuePAC[pac_id]' selected>$valuePAC[pac_id]</option>";
                                 } else {
                                    echo "<option value='$valuePAC[pac_id]'>$valuePAC[pac_id]</option>";
                                 }
                              }
                              echo'
                           </select>
                        </div>
                     </div>
   
                     <div class="col-sm-61" style="margin-bottom:10px;">
                        <div style="margin-top:5px;">
                           <label for="kpi_status" class="req"> <b>Status</b></label>
                           <select id="kpi_status" class="form-control" name="kpi_status" required>
                              <option value="">Select Status</option>';
                              foreach($status as $kpiStatus) {
                                 if($valueKPI['kpi_status'] == $kpiStatus['id']) {
                                    echo "<option value='$kpiStatus[id]' selected>$kpiStatus[name]</option>";
                                 } else {
                                    echo "<option value='$kpiStatus[id]'>$kpiStatus[name]</option>";
                                 }
                              }
                              echo'
                           </select>
                        </div>
                     </div>
                     <div style="clear:both;"></div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-default" onclick="location.href=\'obekpis.php\'" >Close</button>
                     <input class="btn btn-primary" type="submit" value="Save Changes" id="edit_kpi" name="edit_kpi">
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
