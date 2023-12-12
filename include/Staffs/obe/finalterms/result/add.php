<?php

if(LMS_VIEW == 'addresult' && isset($_GET['id'])) {
   $sqllms  = $dblms->querylms("SELECT id_ques 
                                       FROM ".OBE_FINALTERMS." 
                                       WHERE ft_id = ".$_GET['id']." AND id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND theory_paractical = ".COURSE_TYPE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                              ");
   $value_sqllms = mysqli_fetch_array($sqllms);
   if ($value_sqllms['id_ques'] == "") {
      echo "
      <script>
         alert('Please Enter the Questions First.');
         window.location.href = 'obefinalterms.php';
      </script>";
   } else {
      $quessqllms = $dblms->querylms("SELECT ques_id, ques_number, ques_marks 
                                          FROM ".OBE_QUESTIONS." 
                                          WHERE ques_id IN (".$value_sqllms['id_ques'].")
                                          Order BY ques_number ASC"); 
      echo'
      <div class="container">
         <div class="form-sep" style="margin-top: 10px; margin-bottom: 10px;">
            <h4  style="font-weight:700;"> Add Result</h4>
         </div>
         <div style="clear:both;"></div>
         <form class="form-horizontal" action="obefinalterms.php" method="POST" enctype="multipart/form-data">
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
                        while($value_quessqllms = mysqli_fetch_array($quessqllms)) {
                           echo '<th style="vertical-align: middle;" nowrap="nowrap"> Q. '.$value_quessqllms["ques_number"].' &nbsp; (M. Marks: '.$value_quessqllms["ques_marks"].') </th>';
                           $ques_ids[$value_quessqllms['ques_id']] = $value_quessqllms['ques_id'];
                           $ques_marks[$value_quessqllms['ques_id']] = $value_quessqllms['ques_marks'];
                        }
                        echo '
                     </tr>
                     <tr>';
                     for($i = 0; $i < mysqli_num_rows($quessqllms); $i++) {
                        echo ' <th style="vertical-align: middle;" nowrap="nowrap">Obt. Marks</th>';
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
            <button type="button" class="btn btn-default" onclick="location.href=\'obefinalterms.php\'">Close</button>
            <input class="btn btn-primary" type="submit" value="Add Record" id="submit_result" name="submit_result">
         </div>
         </form>
      </div>';
   }
} 
