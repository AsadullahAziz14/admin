<?php
$page = (int)$page;
$sql2 		    = '';
$sqlstring	    = "";
$search_term 	= (isset($_REQUEST['search_term'])  && $_REQUEST['search_term'] != '')  ? $_REQUEST['search_term']  : '';
$searchFeild 	= (isset($_REQUEST['searchFeild'])  && $_REQUEST['searchFeild'] != '')  ? $_REQUEST['searchFeild']  : '';
$searchOP 	    = (isset($_REQUEST['searchOP'])     && $_REQUEST['searchOP'] != '')     ? $_POST['searchOP']        : '';

if(!LMS_VIEW && !isset($_GET['id'])) {
  if(!($Limit)) 	{ $Limit = 50; } 
  if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}

  include ("include/page_title.php"); 
  echo '
  <div class="table-responsive" style="overflow: auto;">
    <table class="footable table table-bordered table-hover table-with-avatar">
      <thead>

        <!-- First Row -->
        <tr>
          <td style="vertical-align: center;" colspan= "4" nowrap="nowrap"></td>';
          $sqllms = $dblms->querylms("SELECT result_id
                                        FROM ".OBE_RESULTS."
                                        Where id_paractical != '' AND theory_paractical = ".COURSE_TYPE." AND id_paractical > 0 AND  id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                                    ");
          $numofSessionalResults = mysqli_num_rows($sqllms);
          echo '
          <th style="vertical-align: middle;" colspan= "10" nowrap="nowrap"><b>Total NO. of Practicals in Semester = '.$numofSessionalResults.'</b></th>
          <td style="vertical-align: middle;" colspan= "11" nowrap="nowrap"></td>
        </tr>

        <!-- Second Row -->
        <tr>
          <th style="vertical-align: middle;" rowspan= "2" nowrap="nowrap"></th>
          <th style="vertical-align: middle;" colspan= "3" nowrap="nowrap"></th>';
          $paracticalKpiArray = [];
          $paracticalKpiMarksArray = [];

          $sqllms = $dblms->querylms("SELECT pp_id, pp_number,pp_marks, id_kpi
                                        FROM ".OBE_PARACTICAL_PERFORMANCES."
                                        Where pp_id != '' AND  id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                                    ");
          $countParactical = mysqli_num_rows($sqllms);
          while($row_sqllms = mysqli_fetch_array($sqllms)) {
            $paracticalKpiArray[$row_sqllms['pp_id']] = $row_sqllms['id_kpi']; 
            $paracticalKpiMarksArray[$row_sqllms['pp_id']][$row_sqllms['id_kpi']] = $row_sqllms['pp_marks'];
            echo '<th style="vertical-align: middle;  writing-mode: vertical-lr;" nowrap="nowrap">Paractical No. '.$row_sqllms['pp_number'].'</th>';
          }
          echo '<th style="vertical-align: middle; " >Total weightage of Sessionals</th>';

          $unique_paracticalKpiArray = array_unique($paracticalKpiArray);
          $sqllms = $dblms->querylms("SELECT kpi_id, kpi_marks, id_clo
                                          FROM ".OBE_KPIS."
                                          Where kpi_id IN (".implode(',',$unique_paracticalKpiArray).")
                                      ");
          $kpiCloArray = [];
          $clokpiArray = [];
          $kpiMarksarray = [];
          while($row_sqllms = mysqli_fetch_array($sqllms)) {
            $kpiCloArray[$row_sqllms['kpi_id']] = $row_sqllms['id_clo'];
            $cloKpiArray[$row_sqllms['id_clo']] = $row_sqllms['kpi_id'];
            $kpiMarksarray[$row_sqllms['kpi_id']] = $row_sqllms['kpi_marks'];
          }

          $uniqueClosArray = array_unique(explode(',',implode(',',$kpiCloArray)));
          $countClo = count($uniqueClosArray);
          echo '<th style="vertical-align: middle; " colspan= "'.$countClo.'" nowrap="nowrap">Attainment of CLOss in Sessional</th>';

          $sqllms = $dblms->querylms("SELECT clo_id, clo_number, id_plo
                                          FROM ".OBE_CLOS."
                                          Where clo_id IN (".implode(',',$uniqueClosArray).")
                                      ");
          $cloIdNumbersArray = [];
          $cloPloArray = [];
          while($row_sqllms = mysqli_fetch_array($sqllms)) {
            $cloIdNumbersArray[$row_sqllms['clo_id']] = $row_sqllms['clo_number'];
            $cloPloArray[$row_sqllms['clo_id']] = $row_sqllms['id_plo'];
          }
          $uniquePlosArray = array_unique(explode(',',implode(',',$cloPloArray)));
          $countPlo = count($uniquePlosArray);
          
          echo '<th style="vertical-align: middle; " colspan= "'.$countPlo.'" nowrap="nowrap">Attainment of PLOs in Sessional</th>
        </tr>

        <!-- Third Row -->
        <tr>
          <th nowrap="nowrap">Roll No. ▼ </th>
          <th nowrap="nowrap">Name ▼</th>
          <th nowrap="nowrap">Weightage ►</th>';
          $paractical_weightage = 50 / $countParactical;
          $total_weightage = 0;
          for ($i=1; $i <= $countParactical; $i++){ 
            echo '<th>'.round(($paractical_weightage),2).'</th>';
            $total_weightage = $total_weightage + (50 / $countParactical);
          }
          echo '
          <th>'.round($total_weightage,2).'</th>';
          foreach ($cloIdNumbersArray as $cloId => $cloNumber) {
            echo '<th>CLO'.$cloNumber.'</th>';
          }

          $sqllms = $dblms->querylms("SELECT plo_id, plo_number
                                      FROM ".OBE_PLOS."
                                        Where plo_id IN (".implode(',',$uniquePlosArray).")
                                      ");
          $ploIdNumbersArray = [];
          while($row_sqllms = mysqli_fetch_array($sqllms)) {
            $ploIdNumbersArray[$row_sqllms['plo_id']] = $row_sqllms['plo_number'];
            echo '<th>PLO'.$row_sqllms['plo_number'].'</th>';
          }
          echo '
        </tr>
      </thead>
      <tbody>';
        $srno = 0;
        $stdCount = 0;
        if(count(STUDENTS) > 0) {
          $stdKpiMarksArray = [];

          foreach (STUDENTS as $stdRollnum => $student){
            $columns = 4;
            $stdCount++;
            $srno++;
            echo '
            <!-- First Row -->
            <tr>
              <td nowrap="nowrap">'.$srno.'</td>
              <td nowrap="nowrap">'.$student['id'].'</td>
              <td colspan="2" nowrap="nowrap">'.$student['name'].'</td>';

              $total_obtweightage = 0;
              foreach ($paracticalKpiMarksArray as $paractical => $kpiMarksArray) {
                $sqllms = $dblms->querylms("SELECT result_id
                                            FROM ".OBE_RESULTS."
                                            Where id_paractical = ".$paractical." AND theory_paractical = ".COURSE_TYPE." AND id_paractical > 0 AND  id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."'AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                                        ");
                if(mysqli_num_rows($sqllms) > 0) {
                  $row = mysqli_fetch_array($sqllms);
                  $result_id = $row['result_id'];
                  foreach ($kpiMarksArray as $kpi => $marks) {
                    $sqllms = $dblms->querylms("SELECT sum(obt_marks) as obt_marks, GROUP_CONCAT(id_ques), id_std
                                                FROM ".OBE_QUESTIONS_RESULTS."
                                                Where id_ques IN (".$kpi.") AND id_result = ".$result_id." AND id_std = ".$stdRollnum."
                                              ");
                    $row = mysqli_fetch_array($sqllms);
                    $stdKpiMarksArray[$row['id_std']][$kpi] = $row['obt_marks'];
                    echo '<td>'.round(($row['obt_marks'] / $marks) * ($paractical_weightage),2).'</td>';
                    $total_obtweightage = $total_obtweightage + ($row['obt_marks'] / $marks) * ($paractical_weightage);
                  }
                } else {
                  echo '<td></td>';
                }
              }
              echo '<td>'.round($total_obtweightage,2).'</td>';

              foreach ($cloIdNumbersArray as $cloId => $cloNumber) {   
                $obtMarks = 0;
                $total = 0;
                $sqllms = $dblms->querylms("SELECT GROUP_CONCAT(kpi_id) as kpi_id
                                              FROM ".OBE_KPIS."
                                              Where FIND_IN_SET(".$cloId.", id_clo)  
                                          ");
                while($rowstd = mysqli_fetch_array($sqllms)) {
                  foreach (explode(',',$rowstd['kpi_id']) as $key => $kpiId) {
                    foreach ($paracticalKpiArray as $paractical => $kpi) {
                      if(in_array($kpiId ,explode(',',$kpi))) {
                        $sqllms = $dblms->querylms("SELECT result_id
                                                      FROM ".OBE_RESULTS."
                                                      Where id_paractical = ".$paractical." AND theory_paractical = ".COURSE_TYPE." AND id_paractical > 0 AND  id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                                                  ");
                        if(mysqli_num_rows($sqllms) > 0) {
                          $row = mysqli_fetch_array($sqllms);
                          $result_id = $row['result_id'];

                          $sqllms = $dblms->querylms("SELECT sum(obt_marks) as obt_marks, GROUP_CONCAT(id_ques), id_std
                                                        FROM ".OBE_QUESTIONS_RESULTS."
                                                        Where id_ques IN (".$kpiId.") AND id_result = ".$result_id." AND id_std = ".$stdRollnum."
                                                    ");
                          $row = mysqli_fetch_array($sqllms);
                          $total = $total + $kpiMarksarray[$kpiId];
                          $obtMarks = $obtMarks + $row['obt_marks'];    
                        }
                      }
                    }
                  }                        
                }
                echo '<td>'.round(((($obtMarks / $total) * 100) / $numofSessionalResults),2) .'</td>';
              }

              foreach ($ploIdNumbersArray as $ploId => $ploNumber) {
                $obtMarks = 0;
                $total = 0;
                $sqllms = $dblms->querylms("SELECT GROUP_CONCAT(clo_id) as clo_id
                                              FROM ".OBE_CLOS."
                                              Where FIND_IN_SET(".$ploId.",id_plo)
                                          ");
                while($row = mysqli_fetch_array($sqllms)) {
                  $clos = explode(',',$row['clo_id']);
                  foreach ($clos as $clo) {
                    $sqllms = $dblms->querylms("SELECT GROUP_CONCAT(kpi_id) as kpi_id
                                                FROM ".OBE_KPIS."
                                                Where FIND_IN_SET(".$clo.",id_clo)
                                              ");
                    while($rowstd = mysqli_fetch_array($sqllms)) {
                      foreach (explode(',',$rowstd['kpi_id']) as $key => $kpiId)  {
                        foreach ($paracticalKpiArray as $paractical => $kpi) {
                          if(in_array($kpiId ,explode(',',$kpi))) {
                            $sqllms = $dblms->querylms("SELECT result_id
                                                FROM ".OBE_RESULTS."
                                                Where id_paractical = ".$paractical." AND theory_paractical = ".COURSE_TYPE." AND id_paractical > 0 AND  id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                                                ");
                            if(mysqli_num_rows($sqllms) > 0) {
                              $row = mysqli_fetch_array($sqllms);
                              $result_id = $row['result_id'];

                              $sqllms = $dblms->querylms("SELECT sum(obt_marks) as obt_marks, GROUP_CONCAT(id_ques), id_std
                                                    FROM ".OBE_QUESTIONS_RESULTS."
                                                    Where id_ques IN (".$kpiId.") AND id_result = ".$result_id." AND id_std = ".$stdRollnum."
                                                  ");
                              $row = mysqli_fetch_array($sqllms);
                              $total = $total + $kpiMarksarray[$kpiId];
                              $obtMarks = $obtMarks + $row['obt_marks'];    
                            }
                          }
                        }
                      }                        
                    }
                  }
                }
                echo '<td>'.round(((($obtMarks / $total) * 100) / $numofSessionalResults),2) .'</td>';
              }
              echo '
            </tr>';
          }
        }
          echo '
      </tbody>
    </table>
  </div>';
}
