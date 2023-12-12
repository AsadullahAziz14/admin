<?php

if (LMS_VIEW == 'editresult' && isset($_GET['id'])) {
   $sqllms  = $dblms->querylms("SELECT id_kpi 
                                       FROM ".OBE_PARACTICAL_PERFORMANCES."
                                       WHERE pp_id        = ".$_GET['id']."
                                       && id_teacher     = ".ID_TEACHER."
                                       && id_course         = ".ID_COURSE."
                                       && id_prg            = ".ID_PRG."
                                       && semester          = ".SEMESTER."
                                       && section           = '".SECTION."'
                                       && timing            = ".TIMING."
                                       && academic_session  = '".ACADEMIC_SESSION."'
                                       && id_campus         =  ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                              ");
   $value_sqllms = mysqli_fetch_array($sqllms);
   if($value_sqllms['id_kpi'] == "") {
      echo "
      <script>
         alert('Please Enter the OBE_KPIS First.');
         window.location.href = 'obeparacticals.php';
      </script>";
   } else {
      $sqllms  = $dblms->querylms("SELECT result_id 
                                       FROM ".OBE_RESULTS."
                                       WHERE id_paractical  = ".$_GET['id']." AND id_teacher        = ".ID_TEACHER." AND id_course         = ".ID_COURSE." AND id_prg            = ".ID_PRG." AND semester          = ".SEMESTER." AND section           = '".SECTION."' AND timing            = ".TIMING." AND academic_session  = '".ACADEMIC_SESSION."' AND id_campus         =  ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                                 ");
      if($row = mysqli_fetch_array($sqllms)) {
         $resultId = $row['result_id'];
         $kpiResult_sqllms = $dblms->querylms("SELECT id_ques,id_result 
                                                FROM ".OBE_QUESTIONS_RESULTS." 
                                                WHERE id_ques IN (".$value_sqllms['id_kpi'].")
                                                AND id_result = ".$resultId."");
         if(mysqli_num_rows($kpiResult_sqllms) <= 0) {
            echo "
               <script>
                  alert('Please Enter the Result First.');
                  window.location.href = 'obeparacticals.php';
               </script>";
         } else {
            $value_kpiResult_sqllms = mysqli_fetch_array($kpiResult_sqllms);
      
            $result_sqllms = $dblms->querylms("SELECT result_id,result_status
                                                FROM ".OBE_RESULTS." 
                                                WHERE result_id      = ".$value_kpiResult_sqllms['id_result']."
                                                AND id_paractical     = ".$_GET['id']." ");
            $value_result_sqllms = mysqli_fetch_array($result_sqllms);
      
            $kpisqllms = $dblms->querylms("SELECT kpi_id, kpi_number, kpi_statement, kpi_marks 
                                          FROM ".OBE_KPIS." 
                                          WHERE kpi_id IN (".$value_sqllms['id_kpi'].") ORDER BY kpi_number ASC");
            echo'
               <div class="container">
                  <div class="form-sep" style="margin-top: 10px; margin-bottom: 10px;">
                     <h4  style="font-weight:700;"> Edit Result</h4>
                  </div>
                  <div style="clear:both;"></div>
                  <form class="form-horizontal" action="obeparacticals.php" method="POST" enctype="multipart/form-data">
                     <input type="hidden" name="result_id" value="'.$value_result_sqllms['result_id'].'">
                     <div style="margin-top: 5px; margin-bottom: 10px; display: flex; align-items: center; float: right;">
                        <label for="result_status" class="req" style="width: auto;"><b>Status:</b></label>
                        <select id="result_status" class="form-control" name="result_status" style="width: 100%; margin-left: 5px;" required>
                        <option>Select Status</option>';
                        foreach ($status as $itemadm_status) {
                           if ($value_result_sqllms['result_status'] == $itemadm_status['id']) {
                              echo "<option value='$itemadm_status[id]' selected>$itemadm_status[name]</option>";
                           } else {
                              echo "<option value='$itemadm_status[id]'>$itemadm_status[name]</option>";
                           }
                        }
                        echo '
                        </select>
                     </div>
                     <div style="clear:both;"></div>
                     <div class="table-responsive" style="overflow: auto;">
                        <table class="footable table table-bordered table-hover table-with-avatar" >
                           <thead>
                              <tr>
                                 <th style="vertical-align: middle;" nowrap="nowrap" rowspan="2"> Sr.#</th>
                                 <th style="vertical-align: middle;" nowrap="nowrap" rowspan="2"> Roll No.</th>
                                 <th style="vertical-align: middle;" nowrap="nowrap" rowspan="2"> Reg #.</th>
                                 <th style="vertical-align: middle;" nowrap="nowrap" rowspan="2"> Student Name</th>';
                                 $kpi_marks = [];
                                 while($value_kpisqllms = mysqli_fetch_array($kpisqllms)) {
                                    echo '<th style="vertical-align: middle;">'.$value_kpisqllms["kpi_statement"].'</th>';
                                    $kpi_marks[$value_kpisqllms['kpi_id']] = $value_kpisqllms['kpi_marks'];
                                 }
                                 echo '
                              </tr>
                              <tr>';
                              for($i = 1; $i <= mysqli_num_rows($kpisqllms); $i++) {
                                 echo '<th style="vertical-align: middle;" nowrap="nowrap">(Marks: '.$kpi_marks[$i].') <br>Obt. Marks ▼</th>';
                              }
                              echo '
                              </tr>
                           </thead>
                        <tbody>';
                        $srno = 0;
                        foreach (STUDENTS as $key => $value) {
                           $srno++;
                           echo '
                           <tr class="form-gruop">
                              <td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
                              <td style="vertical-align: middle;" nowrap="nowrap">'.$key.'</td>
                              <td style="vertical-align: middle;" nowrap="nowrap">'.$value['id'].'</td>
                              <td style="vertical-align: middle;" nowrap="nowrap">'.$value['name'].'</td>';

                           $resultsqllms = $dblms->querylms("SELECT qr.id_ques,qr.id_std, qr.obt_marks, ".OBE_KPIS.".kpi_id,".OBE_KPIS.".kpi_number,".OBE_KPIS.".kpi_marks
                                                               FROM ".OBE_QUESTIONS_RESULTS." as qr INNER JOIN ".OBE_KPIS." ON qr.id_ques = ".OBE_KPIS.".kpi_id 
                                                               WHERE qr.id_ques IN (".$value_sqllms['id_kpi'].") && qr.id_std IN (".$key.") && qr.id_result = ".$value_result_sqllms['result_id']." ORDER BY ".OBE_KPIS.".kpi_number ASC;");
                           while($row = mysqli_fetch_array($resultsqllms)) {
                              echo '<td style="vertical-align: middle;"><input name="obt_marks['.$key.']['.$row['id_ques'].']" value="'.$row['obt_marks'].'" class="form-control" type="number" min="0" max="'.$row['kpi_marks'].'"></td>';
                           }
                           echo '
                           </tr>';
                        }
                        echo '
                           </tbody>
                        </table>
                     </div>
                     <div style="margin-top: 10px; margin-bottom: 10px;  float: right;">
                        <button type="button" class="btn btn-default" onclick="location.href=\'obeparacticals.php\'">Close</button>
                        <input class="btn btn-primary" type="submit" value="Update Result" id="edit_result" name="edit_result">
                     </div>
                  </form>
               </div>';
         }
      } else {
         echo "
         <script>
            alert('Please Enter the Result First.');
            window.location.href = 'obeparacticals.php';
         </script>";
      }
   }
}      