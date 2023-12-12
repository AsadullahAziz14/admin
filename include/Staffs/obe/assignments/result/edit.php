<?php

if (LMS_VIEW == 'editresult' && isset($_GET['id'])) {
   $sqllms  = $dblms->querylms("SELECT id_ques 
                                    FROM ".OBE_ASSIGNMENTS." 
                                    WHERE assignment_id = ".$_GET['id']." AND id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                              ");
   $value_assignmentsqllms = mysqli_fetch_array($sqllms);

   if($value_assignmentsqllms['id_ques'] == "") {
      echo "
      <script>
         alert('Please Enter the Questions First.');
         window.location.href = 'obeassignments.php';
      </script>";
   } else {
      $quesResult_sqllms = $dblms->querylms("SELECT id_ques,id_result 
                                                FROM ".OBE_QUESTIONS_RESULTS." 
                                                WHERE id_ques IN (".$value_assignmentsqllms['id_ques'].")");
      if(mysqli_num_rows($quesResult_sqllms) <= 0) {
         echo "
            <script>
               alert('Please Enter the Result First.');
               window.location.href = 'obeassignments.php';
            </script>";
      } else {
         $value_quesResult_sqllms = mysqli_fetch_array($quesResult_sqllms);
         $result_sqllms = $dblms->querylms("SELECT result_id,result_status
                                             FROM ".OBE_RESULTS." 
                                             WHERE result_id = (".$value_quesResult_sqllms['id_result'].")");
         $value_result_sqllms = mysqli_fetch_array($result_sqllms);

         $quessqllms = $dblms->querylms("SELECT ques_number, ques_marks
                                             FROM ".OBE_QUESTIONS." 
                                             WHERE ques_id IN (".$value_assignmentsqllms['id_ques'].") 
                                             ORDER BY ques_number ASC");
         echo'
         <div class="container">
            <div class="form-sep" style="margin-top: 10px; margin-bottom: 10px;">
               <h4  style="font-weight:700;"> Edit Result</h4>
            </div>
            <div style="clear:both;"></div>
            <form class="form-horizontal" action="obeassignments.php" method="POST" enctype="multipart/form-data">
               <input type="hidden" name="result_id" value="'.$value_result_sqllms['result_id'].'">
               <div style="margin-top: 5px; margin-bottom: 10px; display: flex; align-items: center; float: right;">
                  <label class="req" style="width: auto;"><b>Status:</b></label>
                  <select id="result_status" class="form-control" name="result_status" style="width: 100%; margin-left: 5px;" required>
                     <option>Select Status</option>';
                     foreach ($status as $resultStatus) {
                        if ($value_result_sqllms['result_status'] == $resultStatus['id']) {
                           echo "<option value='$resultStatus[id]' selected>$resultStatus[name]</option>";
                        } else {
                           echo "<option value='$resultStatus[id]'>$resultStatus[name]</option>";
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
                           while($value_quessqllms = mysqli_fetch_array($quessqllms)) {
                              echo '<th style="vertical-align: middle;" nowrap="nowrap" style="width:150px ;"> Q. '.$value_quessqllms["ques_number"].' &nbsp; (M. Marks: '.$value_quessqllms["ques_marks"].') </th>';
                           }
                           echo '
                        </tr>
                        <tr>';
                        for($i = 0; $i < mysqli_num_rows($quessqllms); $i++) {
                           echo '<th style="vertical-align: middle;" nowrap="nowrap">Obt. Marks</th>';
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
                        $resultsqllms = $dblms->querylms("SELECT qr.id_ques,qr.id_std, qr.obt_marks, qu.ques_id,qu.ques_number,qu.ques_marks
                                                            FROM ".OBE_QUESTIONS_RESULTS." as qr INNER JOIN ".OBE_QUESTIONS." as qu ON qr.id_ques = qu.ques_id 
                                                            WHERE qr.id_ques IN (".$value_assignmentsqllms['id_ques'].") AND qr.id_std IN (".$key.") ORDER BY qu.ques_number ASC;");
                        while($row = mysqli_fetch_array($resultsqllms)) {
                           echo '<td style="vertical-align: middle;" nowrap="nowrap"><input name="obt_marks['.$key.']['.$row['id_ques'].'][]" value="'.$row['obt_marks'].'" class="form-control" type="number" min="0" max="'.$row['ques_marks'].'"></td>';
                        }
                        echo '
                        </tr>';
                     }
                     echo '
                     </tbody>
                  </table>
               </div>
               <div style="margin-top: 10px; margin-bottom: 10px;  float: right;">
                  <button type="button" class="btn btn-default" onclick="location.href=\'obeassignments.php\'">Close</button>
                  <input class="btn btn-primary" type="submit" value="Update Result" id="edit_result" name="edit_result">
               </div>
            </form>
         </div>';
      }
   }
}      