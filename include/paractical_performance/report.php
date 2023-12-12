<?php
$page = (int)$page;
$sql2 		    = '';
$sqlstring	    = "";
$search_term 	= (isset($_REQUEST['search_term'])  && $_REQUEST['search_term'] != '')  ? $_REQUEST['search_term']  : '';
$searchFeild 	= (isset($_REQUEST['searchFeild'])  && $_REQUEST['searchFeild'] != '')  ? $_REQUEST['searchFeild']  : '';
$searchOP 	    = (isset($_REQUEST['searchOP'])     && $_REQUEST['searchOP'] != '')     ? $_POST['searchOP']        : '';

if(LMS_VIEW == 'report' && isset($_GET['id'])) 
{  
  if(!($Limit)) 	{ $Limit = 50; } 
  if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
  // $count = mysqli_num_rows($sqllms);
  // if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
  // $prev 		= $page - 1;							//previous page is page - 1
  // $next 		= $page + 1;							//next page is page + 1
  // $lastpage	= ceil($count/$Limit);				//lastpage is = total pages / items per page, rounded up.
  // $lpm1 		= $lastpage - 1;    

  $sqllms = $dblms->querylms("SELECT result_id
                              FROM ".OBE_RESULTS."
                              Where id_paractical = ".$_GET['id']." 
                              ");
  $row = mysqli_fetch_array($sqllms);
  $result_id = $row['result_id'];  
  include ("include/page_title.php"); 

  echo '
      <div class="table-responsive" style="overflow: auto;">
        <table class="footable table table-bordered table-hover table-with-avatar">
          <thead>
            <!-- First Row -->
            <tr>
              <th style="vertical-align: center;" rowspan= "5" nowrap="nowrap">Sr. NO.</th>
              <th style="vertical-align: middle;" rowspan= "2" colspan="3" nowrap="nowrap">Student Roll No. and Name▼</th>
              ';

              $pac_sqllms = $dblms->querylms("SELECT pac_id, pac_statement, COUNT(kpi_id) as countKpi
                                            FROM ".OBE_KPIS." , ".OBE_PACS." 
                                            Where ".OBE_KPIS.".id_pac = ".OBE_PACS.".pac_id 
                                            GROUP BY ".OBE_KPIS.".id_pac;");

              while($row_pac_sqllms = mysqli_fetch_array($pac_sqllms)) {
                echo '<th style="vertical-align: middle;" colspan= "'.$row_pac_sqllms['countKpi'].'" nowrap="nowrap">'.$row_pac_sqllms['pac_statement'].'</th>';
              }
              echo '
              <th style="vertical-align: middle;" rowspan= "4" nowrap="nowrap">Total Marks</th>
              <th style="vertical-align: middle;" rowspan= "4" nowrap="nowrap">Weightage (50/10)</th>
              ';
              $clo_sqllms = $dblms->querylms("SELECT kpi_id,kpi_marks,kpi_statement,id_clo
                                              FROM ".OBE_KPIS."
                                              Where kpi_id != ''
                                              &&  id_teacher = ".ID_TEACHER."
                                              && id_course = ".ID_COURSE."
                                              && id_prg = ".ID_PRG."
                                              && semester = ".SEMESTER."
                                              && section = '".SECTION."'
                                              && timing = ".TIMING."
                                              && academic_session = '".ACADEMIC_SESSION."'
                                              && id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                                            ");
              $kpiIdsArray = [];                             
              $kpiClosArray = [];
              $kpiMarksArray = [];
              $kpiStatementArray = [];
              $cloKpiMarksArray = [];
              while($row_clo_sqllms = mysqli_fetch_array($clo_sqllms)) {
                $kpiIdsArray[$row_clo_sqllms['kpi_id']] = $row_clo_sqllms['kpi_id'];
                $kpiClosArray[$row_clo_sqllms['kpi_id']] = $row_clo_sqllms['id_clo'];
                $kpiMarksArray[$row_clo_sqllms['kpi_id']] = $row_clo_sqllms['kpi_marks'];
                $kpiStatementArray[$row_clo_sqllms['kpi_id']] = $row_clo_sqllms['kpi_statement'];
                $clo_ids = explode(',',$row_clo_sqllms['id_clo']);
                if(count($clo_ids) > 1) {
                  foreach ($clo_ids as $cloId) {
                    $cloKpiMarksArray[$cloId][$row_clo_sqllms['kpi_id']] = $row_clo_sqllms['kpi_marks'];
                  }
                } else {
                  $cloKpiMarksArray[$row_clo_sqllms['id_clo']][$row_clo_sqllms['kpi_id']] = $row_clo_sqllms['kpi_marks'];
                }  
              }

              $countClos = 1;
              $countPlos = 1;
              if(!empty($kpiClosArray)) {
                $clo_str = implode(',',$kpiClosArray);
                $cloIdsArray = array_unique(explode(',',$clo_str));
                $countClos = count($cloIdsArray);
                
                $plo_sqllms = $dblms->querylms("SELECT GROUP_CONCAT(id_plo) as ploIds
                                  FROM ".OBE_CLOS."
                                  Where clo_id IN (".implode(',',$cloIdsArray).") 
                                  && clo_id != ''
                                  ");
                $row_plo_sqllms = mysqli_fetch_array($plo_sqllms);
                if($row_plo_sqllms['ploIds'] != NULL) {
                  $unique_ploIdsArray = array_unique(explode(',',$row_plo_sqllms['ploIds']));
                  $countPlos = count($unique_ploIdsArray);
                }
              }
              
              echo '
              <th style="vertical-align: middle;" rowspan= "2" colspan= "'.$countClos.'" nowrap="nowrap">Attainment of CLOs (%)</th>
              <th style="vertical-align: middle;" rowspan= "2" colspan= "'.$countPlos.'" nowrap="nowrap">Attainment of PLOs (%)</th>
            </tr>

            <!-- Second Row -->
            <tr>';
              foreach ($kpiStatementArray as $kpi => $statement) {
                echo '<th style="vertical-align: middle;" >'.$statement.'</th>';
              }
              echo '
            
            </tr>

            <!-- Third Row -->
            <tr>
              <th style="vertical-align: middle;" rowspan= "3" nowrap="nowrap">Roll No.  ▼</th>
              <th style="vertical-align: middle;" rowspan= "3" nowrap="nowrap">Name ▼</th>
              <th nowrap="nowrap">CLOs ►</th>';
              $kpiPloArray = [];
              foreach ($kpiClosArray as $kpi => $cloId) {
                $cloNum_sqllms = $dblms->querylms("SELECT GROUP_CONCAT(clo_id) as cloIds, GROUP_CONCAT(clo_number) as cloNumbers
                                                          ,GROUP_CONCAT(id_plo) as ploIds 
                                                          FROM ".OBE_CLOS." 
                                                          WHERE clo_id IN (".$cloId.")");
                $row_cloNum_sqllms = mysqli_fetch_array($cloNum_sqllms);
                echo '<th>'.$row_cloNum_sqllms['cloNumbers'].'</th>';

                $kpiPloArray[$kpi] = $row_cloNum_sqllms['ploIds'];
              }

              $cloPloArray = [];
              $sqllms = $dblms->querylms("SELECT  clo_id, clo_number, id_plo 
                                          FROM ".OBE_CLOS." 
                                          WHERE clo_id IN (".implode(',',$cloIdsArray).")");
              while($row_sqllms = mysqli_fetch_array($sqllms)) {
                $cloPloArray[$row_sqllms['clo_id']] = $row_sqllms['id_plo']; 
                $unique_cloIdsArray[$row_sqllms['clo_id']] = $row_sqllms['clo_id'];
                
                echo '<th style="vertical-align: middle;" rowspan= "3">OBE_CLOS'.$row_sqllms['clo_number'].'</th>';
              }

              $sqllms = $dblms->querylms("SELECT  plo_id, plo_number
                                          FROM ".OBE_PLOS." 
                                          WHERE plo_id IN (".implode(',',$unique_ploIdsArray).")");
              $unique_ploIdsArray = [];
              while($row_sqllms = mysqli_fetch_array($sqllms)) {
                $unique_ploIdsArray[$row_sqllms['plo_id']] = $row_sqllms['plo_id']; 
                
                echo '<th style="vertical-align: middle;" rowspan= "3">OBE_PLOS'.$row_sqllms['plo_number'].'</th>';              
              }
              echo '
            </tr>
            
            <!-- Fourth Row -->
            <tr>
              <th nowrap="nowrap" >PLOs ►</th>';
              foreach ($kpiPloArray as $kpi => $ploId) {
                $sqllms = $dblms->querylms("SELECT  GROUP_CONCAT(plo_id) as ploIds, GROUP_CONCAT(plo_number) as ploNumbers
                                            FROM ".OBE_PLOS." 
                                            WHERE plo_id IN (".$ploId.")");
                $row_sqllms = mysqli_fetch_array($sqllms);
                echo '<th>'.$row_sqllms['ploNumbers'].'</th>';
              }
              echo '
            </tr>

            <!-- Fifth Row -->
          <tr>
            <th nowrap="nowrap">Marks ►</th>';
            $total_paracticalMarks = 0;
            foreach ($kpiMarksArray as $kpi => $marks) {
              echo '
                <th style="vertical-align: middle;" >'.$marks.'</th>';
                $total_paracticalMarks = $total_paracticalMarks + $marks;
            }

            for ($i = 1; $i <= count($kpiMarksArray); $i++) {
              $normalized_mark = $kpiMarksArray[$i] / $total_paracticalMarks * 100;
            }
            $relative_paracticalMarks = array_sum($kpiMarksArray) / $total_paracticalMarks * 100;
            echo '
            <th>'.$relative_paracticalMarks.'</th>';

            $sqllms = $dblms->querylms("SELECT  count(pp_id) as countPP
                                        FROM ".OBE_PARACTICAL_PERFORMANCES."  
                                        Where pp_id != ''
                                        &&  id_teacher = ".ID_TEACHER."
                                        && id_course = ".ID_COURSE."
                                        && id_prg = ".ID_PRG."
                                        && semester = ".SEMESTER."
                                        && section = '".SECTION."'
                                        && timing = ".TIMING."
                                        && academic_session = '".ACADEMIC_SESSION."'
                                        && id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                                      ");
            $row = mysqli_fetch_array($sqllms);
            $paractical_weightage =  round(50 / $row['countPP'], 2);
            echo '
            <th>'.$paractical_weightage.'</th>
          </tr>
          </thead>
          <tbody>';
            $srno = 0;
          
            $stdCount = 0;
            if(count(STUDENTS) > 0) {
              $stdKpiMarksArray = [];

              foreach (STUDENTS as $stdRollnum => $student) {
                $columns = 4;
                $stdCount++;
                $srno++;
                echo '
                <!-- First Row -->
                <tr>
                  <td nowrap="nowrap">'.$srno.'</td>
                  <td nowrap="nowrap">'.$student['id'].'</td>
                  <td colspan="2" nowrap="nowrap">'.$student['name'].'</td>';
                  $obt_paracticalMarks = 0;
                  foreach ($kpiMarksArray as $kpi => $marks) {
                    if($kpi != NULL) {
                      $resultsqllms = $dblms->querylms("SELECT sum(obt_marks) as obt_marks, id_ques, id_std
                                                    FROM ".OBE_QUESTIONS_RESULTS."
                                                    Where id_ques IN (".$kpi.") 
                                                    && id_std = ".$stdRollnum."
                                                    && id_result = ".$result_id."
                                                    ");
                      $row = mysqli_fetch_array($resultsqllms);
                      
                      $stdKpiMarksArray[$row['id_std']][$row['id_ques']] = $row['obt_marks'];
                      echo '<td>'.$row['obt_marks'].'</td>';
                      $obt_paracticalMarks = $obt_paracticalMarks + $row['obt_marks'];
                    } else {
                      echo '<td></td>';
                    }
                  }

                  $relative_obt_paracticalMarks = $obt_paracticalMarks / $total_paracticalMarks * $relative_paracticalMarks;
                  echo '
                  <td>'.round($relative_obt_paracticalMarks,0).'</td>
                  <td>'.round(($relative_obt_paracticalMarks / $relative_paracticalMarks * $paractical_weightage),2).'</td>';
                  $sumOfTotalMarksByClo = [];
                  $sumOfObtMarksByKpiAndClo = [];

                  foreach ($cloKpiMarksArray as $clo => $kpiMarks) {
                      $totalMarks = array_sum($kpiMarks);
                      $sumOfTotalMarksByClo[$clo] = $totalMarks;

                      foreach ($kpiMarks as $kpiId => $mark) {
                        if (isset($stdKpiMarksArray[$stdRollnum][$kpiId])) {
                          if (!isset($sumOfObtMarksByKpiAndClo[$clo])) {
                              $sumOfObtMarksByKpiAndClo[$clo] = 0;
                          }
                          $sumOfObtMarksByKpiAndClo[$clo] += $stdKpiMarksArray[$stdRollnum][$kpiId];
                        }
                      } 
                  }

                  $percentageByClo = [];

                  foreach ($sumOfTotalMarksByClo as $clo => $totalMarks) {
                    if (isset($sumOfObtMarksByKpiAndClo[$clo])) {
                        $totalObtMarks = $sumOfObtMarksByKpiAndClo[$clo];
                        $percentage = ($totalObtMarks / $totalMarks) * 100;
                        $percentageByClo[$clo] = $percentage;
                    }
                  }

                  foreach ($unique_cloIdsArray as $cloId) {
                    echo '<td>'.$percentageByClo[$cloId].'%</td>';
                  }


                  $sumOfTotalMarksByPlo = [];
                  $sumOfObtMarksByKpiAndPlo = [];
                  foreach ($unique_ploIdsArray as $ploId) {
                    foreach ($cloPloArray as $clo => $plo) {
                      if($ploId == $plo) {
                        foreach ($cloKpiMarksArray as $cloId => $kpiMarks) {
                          if($clo == $cloId) {
                            $totalMarks = array_sum($kpiMarks);
                            $sumOfTotalMarksByPlo[$plo] = $totalMarks;

                            foreach ($kpiMarks as $kpiId => $mark) {
                              if (isset($stdKpiMarksArray[$stdRollnum][$kpiId])) {
                                if (!isset($sumOfObtMarksByKpiAndPlo[$ploId])) {
                                    $sumOfObtMarksByKpiAndPlo[$ploId] = 0;
                                }
                                $sumOfObtMarksByKpiAndPlo[$ploId] += $stdKpiMarksArray[$stdRollnum][$kpiId];
                              }
                            } 
                          }      
                        }
                        echo '<td>'.round((($sumOfObtMarksByKpiAndPlo[$plo] / $sumOfTotalMarksByPlo[$plo]) * 100),0).'%</td>';
                      }   
                    }
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