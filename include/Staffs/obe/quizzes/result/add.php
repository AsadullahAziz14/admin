<?php

if(LMS_VIEW == 'addresult' && isset($_GET['id'])) { 
   $queryQuiz  = $dblms->querylms("SELECT id_ques 
                                       FROM ".OBE_QUIZZES." 
                                       WHERE quiz_id        = ".$_GET['id']."    AND id_teacher     = ".ID_TEACHER."    AND id_course         = ".ID_COURSE."  AND id_prg            = ".ID_PRG."   AND semester          = ".SEMESTER."  AND section           = '".SECTION."'   AND timing            = ".TIMING."    AND academic_session  = '".ACADEMIC_SESSION."'  AND id_campus         =  ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                              ");
   $valueQuiz = mysqli_fetch_array($queryQuiz);
   if ($valueQuiz['id_ques'] == "") {
      echo "
      <script>
         alert('Please Enter the Questions First.');
         window.location.href = 'obequizzes.php';
      </script>";
   } else {
      $queryQues = $dblms->querylms("SELECT ques_id, ques_number, ques_marks 
                                          FROM ".OBE_QUESTIONS." 
                                          WHERE ques_id IN (".$valueQuiz['id_ques'].")
                                          Order BY ques_number ASC
                                 ");  
      echo'
      <div class="container">
         <div class="form-sep" style="margin-top: 10px; margin-bottom: 10px;">
            <h4  style="font-weight:700;"> Add Result</h4>
         </div>
         <div style="clear:both;"></div>
         <form class="form-horizontal" action="obequizzes.php" method="POST" enctype="multipart/form-data">
            <div style="margin-top: 5px; margin-bottom: 10px; display: flex; align-items: center; float: right;">
               <label class="req" style="width: auto;"><b>Status:</b></label>
               <select id="result_status" class="form-control" name="result_status" style="width: 100%; margin-left: 5px;" required>
                  <option value="">Select Status</option>';
                  foreach ($status as $resultStatus) {
                     echo '<option value="'.$resultStatus['id'].'">'.$resultStatus['name'].'</option>';
                  }
                  echo '
               </select>
            </div>
            <div style="clear:both;"></div>
            <div class="table-responsive" style="overflow: auto;">
               <table  class="footable table table-bordered table-hover table-with-avatar" >
                  <thead>
                     <tr>
                        <th style="vertical-align: middle;" nowrap="nowrap" rowspan="2"> Sr.#</th>
                        <th style="vertical-align: middle;" nowrap="nowrap" rowspan="2"> Roll No.</th>
                        <th style="vertical-align: middle;" nowrap="nowrap" rowspan="2"> Reg #.</th>
                        <th style="vertical-align: middle;" nowrap="nowrap" rowspan="2"> Student Name</th>';
                        $ques_ids = [];
                        $ques_marks = [];
                        while($valueQues = mysqli_fetch_array($queryQues)) {
                           echo '<th style="vertical-align: middle;" nowrap="nowrap"> Q. '.$valueQues["ques_number"].' &nbsp; (M. Marks: '.$valueQues["ques_marks"].') </th>';
                           $ques_ids[$valueQues['ques_id']] = $valueQues['ques_id'];
                           $ques_marks[$valueQues['ques_id']] = $valueQues['ques_marks'];
                        }
                        echo '
                     </tr>
                     <tr>';
                     for($i = 0; $i < mysqli_num_rows($queryQues); $i++) {
                        echo '<th style="vertical-align: middle;" nowrap="nowrap">Obt. Marks</th>';
                     }
                     echo '
                     </tr>
                  </thead>
                  <tbody>';
                  $srno = 0;
                  foreach (STUDENT as $key => $value) {
                     $srno++;
                     echo '
                     <tr class="form-gruop">
                        <td  nowrap="nowrap" style="vertical-align: middle;">'.$srno.'</td>
                        <td  nowrap="nowrap" style="vertical-align: middle;" nowrap="nowrap">'.$key.'</td>
                        <td  nowrap="nowrap" style="vertical-align: middle;" nowrap="nowrap">'.$value['id'].'</td>
                        <td  nowrap="nowrap" style="vertical-align: middle;" nowrap="nowrap">'.$value['name'].'</td>';
                        foreach($ques_ids as $item => $q_id) {
                           echo '<td style="vertical-align: middle;" nowrap="nowrap" style="vertical-align: middle;" nowrap="nowrap"><input type="number" name="obt_marks['.$key.']['.$q_id.'][]" class="form-control"  min="0" max="'.$ques_marks[$item].'"></td>';
                        }
                        echo '
                        </td>
                     </tr>';
                  }
                  echo '
               </tbody>
            </table>
         </div>
         <div style="margin-top: 10px; margin-bottom: 10px;  float: right;">
            <button type="button" class="btn btn-default" onclick="location.href=\'obequizzes.php\'">Close</button>
            <input class="btn btn-primary" type="submit" value="Add Record" id="submit_result" name="submit_result">
         </div>
         </form>
      </div>';
   }
} 
