<?php
if (($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'add' => '1'))) {
   if (!LMS_VIEW && isset($_GET['id'])) {
      $queryParaticlas = $dblms->querylms("SELECT pp_id, pp_number, pp_status, pp_date, pp_marks, id_kpi 
                                    FROM ".OBE_PARACTICAL_PERFORMANCES." 
                                    WHERE pp_id = ".cleanvars($_GET['id'])." ");
      $value_paractical = mysqli_fetch_assoc($queryParaticlas);
      $formattedDate = date('Y-m-d', strtotime($value_paractical['pp_date']));
      echo '
      <div class="row">
         <div class="modal-dialog" style="width:90%;">
            <form class="form-horizontal" action="obeparacticals.php?id='.$_GET['id'].'" method="post" enctype="multipart/form-data">
               <div class="modal-content">
                  <div class="modal-header">
                     <h4 class="modal-title" style="font-weight:700;"> Edit Paractical</h4>
                  </div>
                  <div class="modal-body">
                     <div class="col-sm-61">
                        <div class="form-sep" style="margin-top:5px;">
                           <label for="pp_number" class="req"><b>Paractical Number</b></label>
                           <input type="number" class="form-control" id="pp_number" name="pp_number" value="'.$value_paractical['pp_number'].'" required>
                        </div>
                     </div>
                     <div class="col-sm-61">
                        <div class="form-sep" style="margin-top:5px;">
                           <label for= pp_status" class="req" style="width:100px;"> <b>Status</b></label>';
                           echo '
                           <select id= pp_status" class="form-control" name= pp_status" style="width:100%" required>
                              <option value="">Select Status</option>';
                              foreach ($status as $itemadm_status) {
                                 if ($value_paractical['pp_status'] == $itemadm_status['id']) {
                                    echo "<option value='$itemadm_status[id]' selected>$itemadm_status[name]</option>";
                                 } else {
                                    echo "<option value='$itemadm_status[id]'>$itemadm_status[name]</option>";
                                 }
                              }
                              echo '
                           </select>
                        </div>
                     </div>';
                     $kpi_sqllms = $dblms->querylms("SELECT sum(kpi_marks) as paractical_marks, GROUP_CONCAT(kpi_id) as kpiIds
                                                         FROM ".OBE_KPIS."
                                                         Where kpi_id != '' AND  id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                                                   ");
                     $row_kpi_sqllms = mysqli_fetch_array($kpi_sqllms);
                     echo '
                     <input type="hidden" class="form-control" id="kpi_ids" name="kpi_ids" value="'.$row_kpi_sqllms['kpiIds'].'" readonly >
                     <div style="clear:both;"></div>
                     <div class="col-sm-61">
                        <div class="form-sep" style="margin-top:5px;">
                           <label for="pp_marks" class="req"><b>Paractical Marks</b></label>
                           <input type="text" class="form-control" id="pp_marks" name="pp_marks" value="'.$value_paractical['pp_marks'].'" readonly required>
                        </div>
                     </div>
                     <input type="hidden" class="form-control" id="questionId" name="questionId">
                     <div class="col-sm-61">
                        <div class="form-sep" style="margin-top:5px;">
                           <label for="pp_date" class="req"><b>Paractical Date</b></label>
                           <input type="date" class="form-control" id="pp_date" name="pp_date" value="'.$formattedDate.'" required>
                        </div>
                     </div>
                     <div style="clear:both;"></div>                  
                  </div>
   
                  <div class="modal-footer">
                     <button type="button" class="btn btn-default" onclick="location.href=\'obeparacticals.php\'">Close</button>
                     <input type="submit" name="edit_paractical" value="Update Paractical" class="btn btn-primary">
                  </div>
               </div>
            </form>
         </div>
      </div>   
      <script src="js/add_question/add_question.js"></script>
      <script>
            window.addEventListener("DOMContentLoaded", function() {
               calculateTotalMarks();
            });
   
            // Calculate total marks
            function calculateTotalMarks() {
               var marksElements = document.querySelectorAll("#ques_marks");
               var totalMarks = 0;
               marksElements.forEach(function(element) {
                  totalMarks += parseInt(element.value);
               });
               document.getElementById("marks").value = totalMarks;
            }
   
            // Update total marks when ques_marks is changed
            var quesMarksElements = document.querySelectorAll("#ques_marks");
            quesMarksElements.forEach(function(element) {
               element.addEventListener("change", function() {
                  calculateTotalMarks();
               });
            });
            
            $deleteid = [];
            function remove(questionId) {
               $deleteid.push(questionId);
               document.getElementById("ques_Container["+questionId+"]").remove();
               document.getElementById("questionId").value =  $deleteid;
               calculateTotalMarks();
            }
   
         $(".select2").select2({
            placeholder: "Select Any Option"
         })
   
      </script>';
   }
}
