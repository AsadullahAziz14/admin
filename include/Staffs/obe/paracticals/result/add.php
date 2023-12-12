<?php
if(LMS_VIEW == 'addresult' && isset($_GET['id'])) {
   $sqllms  = $dblms->querylms("SELECT id_kpi, pp_id
                                       FROM ".OBE_PARACTICAL_PERFORMANCES." 
                                       WHERE pp_id = ".$_GET['id']." AND id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg            = ".ID_PRG." AND semester          = ".SEMESTER." AND section           = '".SECTION."' AND timing            = ".TIMING." AND academic_session  = '".ACADEMIC_SESSION."' AND id_campus         =  ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                              ");
   $value_sqllms = mysqli_fetch_array($sqllms);
   if ($value_sqllms['id_kpi'] == "") {
      echo "
      <script>
         alert('Please Enter the OBE_KPIS First.');
         window.location.href = 'obehome.php';
      </script>";
   } else {
      $kpisqllms = $dblms->querylms("SELECT kpi_id, kpi_number, kpi_marks, kpi_statement
                                          FROM ".OBE_KPIS." 
                                          WHERE kpi_id IN (".$value_sqllms['id_kpi'].")
                                          Order BY kpi_number ASC
                                    "); 
      echo'
      <div class="container">
         <div class="form-sep" style="margin-top: 10px; margin-bottom: 10px;">
            <h4  style="font-weight:700;"> Add Result</h4>
         </div>
         <div style="clear:both;"></div>
         <form class="form-horizontal" action="obeparacticals.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="pp_id" class="form-control" value="'.$value_sqllms['pp_id'].'">
            <div style="margin-top: 5px; margin-bottom: 10px; display: flex; align-items: center; float: right;">
               <label for="result_status" class="req" style="width: auto;"><b>Status:</b></label>
               <select id="result_status" class="form-control" name="result_status" style="width: 100%; margin-left: 5px;" required>
                  <option value="">Select Status</option>';
                  foreach ($status as $adm_status) {
                     echo '<option value="'.$adm_status['id'].'">'.$adm_status['name'].'</option>';
                  }
                  echo '
                  </select>
            </div>
            <div style="clear:both;"></div>
            </style>
            <div class="table-responsive" style="overflow: auto;">
               <table  class="footable table table-bordered table-hover table-with-avatar" >
                  <thead>
                     <tr>
                        <th style="vertical-align: middle;" nowrap="nowrap" rowspan="2"> Sr.#</th>
                        <th style="vertical-align: middle;" nowrap="nowrap" rowspan="2"> Roll No.</th>
                        <th style="vertical-align: middle;" nowrap="nowrap" rowspan="2"> Reg #.</th>
                        <th style="vertical-align: middle;" nowrap="nowrap" rowspan="2"> Student Name</th>';
                        $kpi_ids = [];
                        $kpi_marks = [];
                        while($value_kpisqllms = mysqli_fetch_array($kpisqllms)) {
                           echo '<th style="vertical-align: middle;">'.$value_kpisqllms["kpi_statement"].'</th>';
                           $kpi_ids[$value_kpisqllms['kpi_id']] = $value_kpisqllms['kpi_id'];
                           $kpi_marks[$value_kpisqllms['kpi_id']] = $value_kpisqllms['kpi_marks'];
                        }
                        echo '  
                     </tr>
                     <tr>';
                     for($i = 1; $i <= mysqli_num_rows($kpisqllms); $i++) {
                        echo ' <th style="vertical-align: middle;" nowrap="nowrap">(Marks: '.$kpi_marks[$i].') <br> Obt. Marks ▼</th>';
                     }
                     echo '
                     </tr>
                  </thead>
                  <tbody>';
                  $srno = 0;

                  foreach (STUDENTS as $key => $std) {
                     $srno++;
                     echo '
                     <tr class="form-gruop">
                        <td  nowrap="nowrap" style="vertical-align: middle;">'.$srno.'</td>
                        <td  nowrap="nowrap" style="vertical-align: middle;" nowrap="nowrap">'.$key.'</td>
                        <td  nowrap="nowrap" style="vertical-align: middle;" nowrap="nowrap">'.$std['id'].'</td>
                        <td  nowrap="nowrap" style="vertical-align: middle;" nowrap="nowrap">'.$std['name'].'</td>';
                        foreach($kpi_ids as $item => $kpi_id) {
                           echo '<td style="vertical-align: middle;" nowrap="nowrap" style="vertical-align: middle;" nowrap="nowrap"><input type="number" name="obt_marks['.$key.']['.$kpi_id.']" class="form-control"  min="0" max="'.$kpi_marks[$item].'"></td>';
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
            <button type="button" class="btn btn-default" onclick="location.href=\'obeparacticals.php\'">Close</button>
            <input class="btn btn-primary" type="submit" value="Add Record" id="submit_result" name="submit_result">
         </div>
         </form>
      </div>';
   }
} 
