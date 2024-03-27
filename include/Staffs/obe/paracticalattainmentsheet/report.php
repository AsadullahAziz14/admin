<?php
$page           = (int)$page;
$sql2           = '';
$sqlstring      = "";
$search_term    = (isset($_REQUEST['search_term'])  && $_REQUEST['search_term'] != '')  ? $_REQUEST['search_term']  : '';
$searchFeild    = (isset($_REQUEST['searchFeild'])  && $_REQUEST['searchFeild'] != '')  ? $_REQUEST['searchFeild']  : '';
$searchOP 	    = (isset($_REQUEST['searchOP'])     && $_REQUEST['searchOP'] != '')     ?  cleanvars($_POST['searchOP']): '';

if(!LMS_VIEW && !isset($_GET['id'])) {  
  if(!($Limit)) 	{ $Limit = 50; } 
  if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
  
  require_once("include/page_title.php"); 
  echo '
      <div class="table-responsive" style="overflow: auto;">
        <table class="footable table table-bordered table-hover table-with-avatar">
          <thead>
            <!-- First Row -->
            <tr>
              <th style="vertical-align: center;" rowspan= "5" nowrap="nowrap">Sr. NO.</th>
              <th style="vertical-align: middle;" rowspan= "2" colspan="3" nowrap="nowrap">Student Roll No. and Name▼</th>
              <th style="vertical-align: middle;" rowspan= "2">Marks Obtained in Sessionals</th>';
              $sqllms = $dblms->querylms("SELECT ft_id, ft_number, id_ques, ft_marks
                                            FROM ".OBE_FINALTERMS."
                                            WHERE ft_id != '' AND id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND theory_paractical = ".COURSE_TYPE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                                        ");
              $finaltermQues = '';
              if($row = mysqli_fetch_array($sqllms)) {
                  if($row['id_ques'] != '') {
                    $noOfFinalTermQues = count(explode(',',$row['id_ques'])) + 1;
                    $finaltermQues = $row['id_ques'];
                  } else {
                    $noOfFinalTermQues = 1;
                  }
              } else {
                $noOfFinalTermQues = 1;
              }
            
              echo '
              <th style="vertical-align: middle;" colspan="'.$noOfFinalTermQues.'">Marks Obtained in Final Term</th>
              <th style="vertical-align: middle;" rowspan= "4" nowrap="nowrap">Total Marks</th>
              <th style="vertical-align: middle;" rowspan= "5" nowrap="nowrap">Grades</th>
              ';
              $sqllms = $dblms->querylms("SELECT GROUP_CONCAT(pp_id) as pp_id, GROUP_CONCAT(Distinct id_kpi) as id_kpi, sum(pp_marks) as sessional_marks,count(pp_id) as paractical_count
                                            FROM ".OBE_PARACTICAL_PERFORMANCES."
                                            Where pp_id != '' AND id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                                        ");
              if($row = mysqli_fetch_array($sqllms)) {
                $paracticals = $row['pp_id'];
                $kpi = $row['id_kpi'];
                $totalSessionalMarks = $row['sessional_marks'];

                $val = (50 * ($row['paractical_count']+1)) - $totalSessionalMarks;
                $relativeSessionalMarks = ($val + $totalSessionalMarks) / ($row['paractical_count'] + 1) ;
                
                if($paracticals != '') {
                  $sqllms = $dblms->querylms("SELECT kpi_id, kpi_marks, id_clo
                                              FROM ".OBE_KPIS."
                                              Where kpi_id IN (".$kpi.")
                                            ");
                  $kpiCloArray = [];
                  $clokpiArray = [];
                  $kpiMarksarray = [];
                  while($row_sqllms = mysqli_fetch_array($sqllms)) {
                    $kpiCloArray[$row_sqllms['kpi_id']] = $row_sqllms['id_clo'];
                    $cloKpiArray[$row_sqllms['id_clo']] = $row_sqllms['kpi_id'];
                    $kpiMarksarray[$row_sqllms['kpi_id']] = $row_sqllms['kpi_marks'];
                  }
                }
                
                $sessionalCloArray = [];
                $sessionalPloArray = [];
                
                if($kpi != '') {
                  $sqllms = $dblms->querylms("SELECT GROUP_CONCAT(DISTINCT id_clo) as id_clo
                                                FROM ".OBE_KPIS."
                                                Where kpi_id IN (".$kpi.")
                                            ");
                  if($row = mysqli_fetch_array($sqllms)) {
                    $sessionalCloArray = array_unique(explode(',',$row['id_clo']));
                    echo '<th style="vertical-align: middle;" rowspan= "2" colspan="'.count($sessionalCloArray).'">Attainment of CLOs in sessionals (%)</th>';

                    $sqllms = $dblms->querylms("SELECT GROUP_CONCAT(DISTINCT id_plo) as id_plo
                                                  FROM ".OBE_CLOS."
                                                  Where clo_id IN (".$row['id_clo'].")
                                                ");
                    $row = mysqli_fetch_array($sqllms);
                    $sessionalPloArray = array_unique(explode(',',$row['id_plo']));
                  
                    echo '<th style="vertical-align: middle;" rowspan= "2" colspan="'.count($sessionalPloArray).'">Attainment of PLOs in sessionals (%)</th>';
                  }
                } else {
                  echo '<th style="vertical-align: middle;" rowspan= "2" colspan="1">Attainment of CLOs in sessionals (%)</th>';
                  echo '<th style="vertical-align: middle;" rowspan= "2" colspan="1">Attainment of PLOs in sessionals (%)</th>';
                }
              }
              
              $finaltermQuesCloArray = [];
              $finaltermCloArray = [];
              $finaltermQuesMarksArray = [];
              $finaltermQuesNumberArray = [];
              $finaltermPloArray = [];
              if($finaltermQues != '') {
                $sqllms = $dblms->querylms("SELECT id_clo, ques_id, ques_number, ques_marks
                                            FROM ".OBE_QUESTIONS."
                                            Where ques_id IN (".$finaltermQues.")
                                        ");
                while($row = mysqli_fetch_array($sqllms)) {
                  $finaltermCloArray[] = $row['id_clo'];
                  $finaltermQuesCloArray[$row['ques_id']] = $row['id_clo'];
                  $finaltermQuesNumberArray[$row['ques_id']] = $row['ques_number'];                
                  $finaltermQuesMarksArray[$row['ques_id']] = $row['ques_marks'];
                }
              
                $sqllms = $dblms->querylms("SELECT GROUP_CONCAT(DISTINCT id_plo) as id_plo
                                              FROM ".OBE_CLOS."
                                              Where clo_id IN (".implode(',',$finaltermQuesCloArray).")
                                          ");
                $row = mysqli_fetch_array($sqllms);
                
                $finaltermPloArray = explode(',',$row['id_plo']);

                echo '<th style="vertical-align: middle;" rowspan= "2" colspan="'.count(array_unique(explode(',',implode(',',$finaltermQuesCloArray)))).'">Attainment of CLOs in Final Term Eaminations (%)</th>';
                echo '<th style="vertical-align: middle;" rowspan= "2" colspan="'.count($finaltermPloArray).'">Attainment of PLOs in Final Term Examinations (%)</th>';
                echo '<th style="vertical-align: middle;" rowspan= "2" colspan="'.count(array_unique(array_merge(array_unique(explode(',',implode(',',$finaltermQuesCloArray))),$sessionalCloArray))).'">Attainment of CLOs in Complete Course (%)</th>';
                echo '<th style="vertical-align: middle;" rowspan= "2" colspan="'.count(array_unique(array_merge($sessionalPloArray,$finaltermPloArray))).'">Attainment of PLOs in Complete Course(%)</th>';
              } else {
                echo '<th style="vertical-align: middle;" rowspan= "2" colspan="1">Attainment of CLOs in Final Term Eaminations (%)</th>';
                echo '<th style="vertical-align: middle;" rowspan= "2" colspan="1">Attainment of PLOs in Final Term Examinations (%)</th>';
                echo '<th style="vertical-align: middle;" rowspan= "2" colspan="'.count(array_unique(array_merge($sessionalCloArray))).'">Attainment of CLOs in Complete Course (%)</th>';
                echo '<th style="vertical-align: middle;" rowspan= "2" colspan="'.count(array_unique(array_merge($sessionalPloArray,$finaltermPloArray))).'">Attainment of PLOs in Complete Course(%)</th>';
              }
            echo '
            </tr>

            <!-- Second Row -->
            <tr>';
              if($finaltermQues != '') {
                foreach ($finaltermQuesNumberArray as $quesId => $quesNumber) {
                  echo '<th style="vertical-align: middle;">Question NO.'.$quesNumber.'</th>';
                }
              }
              
              echo '<th style="vertical-align: middle;">Total (Final)</th>
            </tr>
            <!-- Third Row -->
            <tr>
              <th style="vertical-align: middle;" rowspan="3" nowrap="nowrap">Roll No. ▼</th>
              <th style="vertical-align: middle;" rowspan="3" nowrap="nowrap">Name ▼</th> 
              <th style="vertical-align: middle;" nowrap="nowrap">CLOs ►</th>';

              $sessionalCloNumberArray = [];
              $completeCourseClosArray = [];
              if(count($sessionalCloArray) > 0) {
                $sqllms = $dblms->querylms("SELECT clo_id,clo_number,id_plo
                                              FROM ".OBE_CLOS."
                                              Where clo_id IN (".implode(',',$sessionalCloArray).")
                                          ");
                
                while($row = mysqli_fetch_array($sqllms)) {
                  $sessionalCloNumberArray[$row['clo_id']] = $row['clo_number']; 
                  $completeCourseClosArray[$row['clo_id']] = $row['clo_number'];
                }
                echo '<th style="vertical-align: middle;" nowrap="nowrap">'.implode(',',array_unique($sessionalCloNumberArray)).'</th>';
              } else {
                echo '<th style="vertical-align: middle;" nowrap="nowrap"></th>';
              }
             

              $finaltermCloNumberArray = [];
              $finaltermQuesPloArray = [];
              if(count($finaltermQuesCloArray) > 0) {
                foreach ($finaltermQuesCloArray as $quesId => $cloId) {
                  $finaltermquesClosArray = [];
                  $sqllms = $dblms->querylms("SELECT GROUP_CONCAT(id_plo) as id_plo
                                                FROM ".OBE_CLOS."
                                                Where clo_id IN (".$cloId.")
                                            ");
                  $row = mysqli_fetch_array($sqllms);
                  $finaltermQuesPloArray[$quesId] = $row['id_plo'];
                  
                  $sqllms = $dblms->querylms("SELECT clo_id,clo_number,id_plo
                                                FROM ".OBE_CLOS."
                                                Where clo_id IN (".$cloId.")
                                            ");          
                  $quesClosArray = [];
                  while($row = mysqli_fetch_array($sqllms)) {
                    $finaltermCloNumberArray[$row['clo_id']] = $row['clo_number'];
                    $completeCourseClosArray[$row['clo_id']] = $row['clo_number'];
                    $finaltermquesClosArray[] =  $row['clo_number'];
                  }
                  echo '<th style="vertical-align: middle;" nowrap="nowrap">'.implode(',',$finaltermquesClosArray).'</th>';
                }
              }
              

              if(count($finaltermCloNumberArray) > 0) {
                echo '<th style="vertical-align: middle;" nowrap="nowrap">'.implode(',',$finaltermCloNumberArray).'</th> ';
              } else {
                echo '<th style="vertical-align: middle;" nowrap="nowrap"></th> ';
              }
             
              if(count($sessionalCloNumberArray) > 0) {
                foreach ($sessionalCloNumberArray as $cloId => $cloNumber) {
                  echo '<th style="vertical-align: middle;" rowspan="3" nowrap="nowrap">CLO'.$cloNumber.'</th>';
                }
              } else {
                echo '<th style="vertical-align: middle;" rowspan="3" nowrap="nowrap"></th>';
              }
              
              $sessionalPloNumberArray = [];
              $completeCoursePlosArray = [];

              if(count($sessionalPloArray) > 0) {
                foreach ($sessionalPloArray as $ploId) {
                  $sqllms = $dblms->querylms("SELECT plo_id,plo_number
                                                FROM ".OBE_PLOS."
                                                Where plo_id IN (".$ploId.")
                                            ");
                  $row = mysqli_fetch_array($sqllms);
                  $sessionalPloNumberArray[$row['plo_id']] = $row['plo_number'];
                  $completeCoursePlosArray[$row['plo_id']] = $row['plo_number'];
                  echo '<th style="vertical-align: middle;" rowspan="3" nowrap="nowrap">PLO'.$row['plo_number'].'</th>'; 
                }
              } else {
                echo '<th style="vertical-align: middle;" rowspan="3" nowrap="nowrap"></th>'; 
              }
              

              if(count($finaltermCloNumberArray) > 0) {
                foreach ($finaltermCloNumberArray as $cloId => $cloNumber) {
                  echo '<th style="vertical-align: middle;" rowspan="3" nowrap="nowrap">CLO'.$cloNumber.'</th>'; 
                }
              } else {
                echo '<th style="vertical-align: middle;" rowspan="3" nowrap="nowrap"></th>'; 
              }
              

              $finaltermPloNumberArray = [];
              
              if(count($finaltermPloArray ) > 0) {
                foreach ($finaltermPloArray as $ploId) {
                  $sqllms = $dblms->querylms("SELECT plo_id,plo_number
                                                FROM ".OBE_PLOS."
                                                Where plo_id IN (".$ploId.")
                                              ");
                  $row = mysqli_fetch_array($sqllms);
                  $finaltermPloNumberArray[$row['plo_id']] = $row['plo_number'];
                  $completeCoursePlosArray[$row['plo_id']] = $row['plo_number'];
                  echo '<th style="vertical-align: middle;" rowspan="3" nowrap="nowrap">PLO'.$row['plo_number'].'</th>'; 
                }
              } else {
                echo '<th style="vertical-align: middle;" rowspan="3" nowrap="nowrap"></th>'; 
              }

              $countCourseClo = 0;
              if(count($completeCourseClosArray) > 0) {
                foreach ($completeCourseClosArray as $cloId => $cloNumber) {
                  $countCourseClo++;
                  echo '<th style="vertical-align: middle;" rowspan="3" nowrap="nowrap">CLO'.$cloNumber.'</th>'; 
                }
              } else {
                echo '<th style="vertical-align: middle;" rowspan="3" nowrap="nowrap"></th>'; 
              }  

              $countCoursePlo = 0;
              if(count($completeCoursePlosArray) > 0) {
                foreach ($completeCoursePlosArray as $ploId => $ploNumber) {
                  $countCoursePlo++;
                  echo '<th style="vertical-align: middle;" rowspan="3" nowrap="nowrap">PlO'.$ploNumber.'</th>';
                }
              } else {
                echo '<th style="vertical-align: middle;" rowspan="3" nowrap="nowrap"></th>'; 
              }
              
              echo '
            </tr>
            <!-- Fourth Row -->
            <tr>
              <th style="vertical-align: middle;" nowrap="nowrap">PLOs ►</th>';
              
              echo '<th style="vertical-align: middle;" nowrap="nowrap">'.implode(',',$sessionalPloNumberArray).'</th>';
            
              if(count($finaltermQuesPloArray) > 0) {
                foreach ($finaltermQuesPloArray as $quesId => $ploId) {
                  $sqllms = $dblms->querylms("SELECT GROUP_CONCAT(plo_number) as plo_number
                                                FROM ".OBE_PLOS."
                                                Where plo_id IN (".$ploId.")
                                            ");
                  $row = mysqli_fetch_array($sqllms);
                  echo '<th style="vertical-align: middle;" nowrap="nowrap">'.$row['plo_number'].'</th>';   
                }
              }
              
              echo '<th style="vertical-align: middle;" nowrap="nowrap">'.implode(',',$finaltermPloNumberArray).'</th> ';

              echo '
            </tr>
            <!-- Fifth Row -->
            <tr>
              <th style="vertical-align: middle;" nowrap="nowrap">Marks ►</th> 
              <th style="vertical-align: middle;" nowrap="nowrap">'.$relativeSessionalMarks.'</th>';
              $totalFinalTermMarks = 0;

              if(count($finaltermQuesMarksArray)) {
                foreach ($finaltermQuesMarksArray as $ques_id => $marks) {
                  $totalFinalTermMarks = $totalFinalTermMarks + $marks;
                  echo'<th style="vertical-align: middle;" nowrap="nowrap">'.$marks.'</th> ';
                }
              }

              $val = (50 * ($noOfFinalTermQues+1)) - $totalFinalTermMarks;
              $relativeFinalTermMarks = ($val + $totalFinalTermMarks) / ($noOfFinalTermQues + 1) ;

              echo'<th style="vertical-align: middle;" nowrap="nowrap">'.$relativeFinalTermMarks.'</th>';
              $totalmarks = $relativeFinalTermMarks + $relativeSessionalMarks;

              echo '<th style="vertical-align: middle;" nowrap="nowrap">'.$totalmarks.'</th> 
            </tr>           
          </thead>
          <tbody>';

          $attainedCloMarks = [];
          $attainedPloMarks = [];
          $srno = 0;
        
          $stdCount = 0;
          if(count(STUDENT) > 0) {
            $sqllms = $dblms->querylms("SELECT pp_id, id_kpi,pp_marks
                                          FROM ".OBE_PARACTICAL_PERFORMANCES."
                                          Where pp_id != '' AND id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                                      ");
            $paracticalArray = [];
            while($row = mysqli_fetch_array($sqllms)) {
              $paracticalArray[$row['pp_id']] = $row['id_kpi'];
            }

            $sessionalResultIdsArray = [];
            $countParacticalResult = 0;
            if($paracticals != '') {
              $result_sqllms = $dblms->querylms("SELECT result_id, id_paractical
                                                    FROM ".OBE_RESULTS."
                                                    Where id_paractical IN (".$paracticals.") AND theory_paractical = ".COURSE_TYPE." AND id_paractical > 0 AND  id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                                              ");
              $countParacticalResult = mysqli_num_rows($result_sqllms);
              while($row_result_sqllms = mysqli_fetch_array($result_sqllms)) {
                $sessionalResultIdsArray[$row_result_sqllms['id_paractical']] = $row_result_sqllms['result_id'];
              }
              $sessionalResultIdsString = implode(',',$sessionalResultIdsArray);
              $numofSessionalResults = count($sessionalResultIdsArray);
            }
            
                                              
            foreach (STUDENT as $stdRollNum => $student) {
              $columns = 4;
              $stdCount++;
              $srno++;
              echo '
            <tr>
              <td nowrap="nowrap">'.$srno.'</td>
              <td nowrap="nowrap">'.$student['id'].'</td>
              <td colspan="2" nowrap="nowrap">'.$student['name'].'</td>';

              $obtSessionalMarks = 0;
              if($countParacticalResult > 0) {
                foreach ($sessionalResultIdsArray as $resultId) {
                  if($kpi != '') {
                    $sqllms = $dblms->querylms("SELECT sum(obt_marks) as obt_marks, id_ques, id_std
                                                  FROM ".OBE_QUESTIONS_RESULTS."
                                                  Where id_ques IN (".$kpi.") AND id_result = ".$resultId." AND id_std = ".$stdRollNum."
                                              ");
                    $row = mysqli_fetch_array($sqllms);
                    $obtSessionalMarks = $obtSessionalMarks + $row['obt_marks'];
                  }
                }
              }
              
              $obtSessionalWeightage = 0;
              if($totalSessionalMarks) {
                $columns++;
                $obtSessionalWeightage = (($obtSessionalMarks / $totalSessionalMarks) * $relativeSessionalMarks);
                $columns++;
                echo '<td nowrap="nowrap">'.round($obtSessionalWeightage,1) .'</td>';
              } else {
                echo '<td nowrap="nowrap"></td>';
              }
              
              $obtFinaltermMarks = 0;
              foreach ($finaltermQuesNumberArray as $quesId => $quesNumber) {
                $sqllms = $dblms->querylms("SELECT obt_marks, id_ques, id_std
                                              FROM ".OBE_QUESTIONS_RESULTS."
                                              Where id_ques IN (".$quesId.") AND id_std = ".$stdRollNum."
                                          ");
                if($row = mysqli_fetch_array($sqllms)) {
                  $obtFinaltermMarks = $obtFinaltermMarks + $row['obt_marks'];
                  $columns++;
                  echo '<td style="vertical-align: middle;">'.$row['obt_marks'].'</td>';
                } else {
                  echo '<td style="vertical-align: middle;"></td>';
                }
              }

              $totalObtMarks = 0;
              if($totalFinalTermMarks > 0) {
                $obtFinaltermWeightage = (($obtFinaltermMarks / $totalFinalTermMarks) * $relativeFinalTermMarks);
              
                $columns++;
                echo '<td nowrap="nowrap">'.round($obtFinaltermWeightage,1).'</td>';
                $totalObtMarks =  round(($obtSessionalWeightage + $obtFinaltermWeightage),1);
                $columns++;
                echo '<td nowrap="nowrap">'.$totalObtMarks.'</td>';
              } else {
                $columns++;
                echo '<td nowrap="nowrap"></td>';
                $columns++;
                echo '<td nowrap="nowrap"></td>';
              }
              

              if($totalObtMarks < 50) {
                echo '<td>'.GRADES['f'].'</td>';
              }
              elseif ($totalObtMarks >= 50 && $totalObtMarks < 55) {
                echo '<td>'.GRADES['d'].'</td>';
              }
              elseif ($totalObtMarks >= 55 && $totalObtMarks < 58) {
                echo '<td>'.GRADES['c-'].'</td>';
              }
              elseif ($totalObtMarks >= 58 && $totalObtMarks < 61) {
                echo '<td>'.GRADES['c'].'</td>';
              }
              elseif ($totalObtMarks >= 61 && $totalObtMarks < 65) {
                echo '<td>'.GRADES['c+'].'</td>';
              }
              elseif ($totalObtMarks >= 65 && $totalObtMarks < 70) {
                echo '<td>'.GRADES['b-'].'</td>';
              }
              elseif ($totalObtMarks >= 70 && $totalObtMarks < 75) {
                echo '<td>'.GRADES['b'].'</td>';
              }
              elseif ($totalObtMarks >= 75 && $totalObtMarks < 80) {
                echo '<td>'.GRADES['b+'].'</td>';
              }
              elseif ($totalObtMarks >= 80 && $totalObtMarks < 85) {
                echo '<td>'.GRADES['a'].'</td>';
              }
              elseif ($totalObtMarks >= 85) {
                echo '<td>'.GRADES['a+'].'</td>';
              }

              $cloSessionalAttainment = [];
              if(count($sessionalCloNumberArray) > 0) {
                foreach ($sessionalCloNumberArray as $cloId => $cloNumber) {  
                  $obtMarks = 0;
                  $total = 0;
                  $sqllms = $dblms->querylms("SELECT GROUP_CONCAT(kpi_id) as kpi_id
                                              FROM ".OBE_KPIS."
                                              Where FIND_IN_SET(".$cloId.", id_clo)  
                                            ");
                  $rowstd = mysqli_fetch_array($sqllms);

                  foreach (explode(',',$rowstd['kpi_id']) as $kpiId) {
                    foreach ($paracticalArray as $paractical => $Kpi) { 
                      if(in_array($kpiId ,explode(',',$kpi))) {
                        foreach ($sessionalResultIdsArray as $paracticals => $item) {
                          if(isset($sessionalResultIdsArray[$paractical])) {
                            $sqllms = $dblms->querylms("SELECT sum(obt_marks) as obt_marks, GROUP_CONCAT(id_ques), id_std
                                                          FROM ".OBE_QUESTIONS_RESULTS."
                                                          Where id_ques IN (".$kpiId.") AND id_result IN (".$item.") AND id_std = ".$stdRollNum."
                                                      ");
                            $row = mysqli_fetch_array($sqllms);
                            $total = $total + $kpiMarksarray[$kpiId];
                            $obtMarks = $obtMarks + $row['obt_marks']; 
                          }
                        }
                      }
                    }
                  }

                  if($numofSessionalResults > 0) {
                    $columns++;
                    $cloSessionalAttainment[$cloId] = round(((($obtMarks / $total) * 100) / $numofSessionalResults),2);
                    echo '<td>'.$cloSessionalAttainment[$cloId].'</td>';
                  } else {
                    $cloSessionalAttainment[$cloId] = 0;
                    echo '<td></td>';
                  }
                }
              } else {
                $columns++;
                echo '<td></td>';
              }

              $ploSessionalAttainment = [];
              if(count($sessionalPloNumberArray)) {
                foreach ($sessionalPloNumberArray as $ploId => $ploNumber) {
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
                                                    Where FIND_IN_SET(".$clo.", id_clo)  
                                                ");
                      $rowstd = mysqli_fetch_array($sqllms);
                      foreach (explode(',',$rowstd['kpi_id']) as $kpiId) {
                        foreach ($paracticalArray as $paractical => $Kpi) { 
                          if(in_array($kpiId ,explode(',',$kpi))) {
                            foreach ($sessionalResultIdsArray as $paracticals => $item) {
                              if(isset($sessionalResultIdsArray[$paractical])) {
                                $sqllms = $dblms->querylms("SELECT sum(obt_marks) as obt_marks, GROUP_CONCAT(id_ques), id_std
                                                              FROM ".OBE_QUESTIONS_RESULTS."
                                                              Where id_ques IN (".$kpiId.") AND id_result IN (".$item.") AND id_std = ".$stdRollNum."
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

                  if($numofSessionalResults > 0) {
                    $columns++;
                    $ploSessionalAttainment[$ploId] = round(((($obtMarks / $total) * 100) / $numofSessionalResults),2);
                    echo '<td>'.$ploSessionalAttainment[$ploId].'</td>';
                  } else {
                    $ploSessionalAttainment[$ploId] = 0;
                    echo '<td></td>';
                  }    
                }
              } else {
                $columns++;
                echo '<td></td>';
              }
              

              $cloFinalAttainment = [];
              if(count($finaltermCloNumberArray)) {
                foreach ($finaltermCloNumberArray as $cloId => $cloNumber) {
                  $total = 0;
                  $obtMarks = 0; 
                  $cloPercentage = 0;    
                  $sqllms = $dblms->querylms("SELECT GROUP_CONCAT(ques_id) as ques_ids
                                                FROM ".OBE_QUESTIONS."
                                                Where FIND_IN_SET(".$cloId.", id_clo)  
                                            ");
                  $rowstd = mysqli_fetch_array($sqllms);
                  
                  if($rowstd['ques_ids'] != NULL) {
                    $ques_ids = explode(",",$rowstd['ques_ids']);
                    foreach ($ques_ids as $q_id) {
                      $sqllms = $dblms->querylms("SELECT id_ques
                                                    FROM ".OBE_FINALTERMS."
                                                    Where FIND_IN_SET(".$q_id.", id_ques) 
                                                ");
                      $record = mysqli_fetch_array($sqllms);
                      if($record) {
                        $sqllms = $dblms->querylms("SELECT ques_marks
                                                      FROM ".OBE_QUESTIONS."
                                                      Where ques_id IN (".$q_id.") 
                                                  ");
                        $result = mysqli_fetch_array($sqllms);
                        $total = $total + $result['ques_marks'];

                        $sqllms = $dblms->querylms("SELECT sum(obt_marks) as obtMarks
                                                      FROM ".OBE_QUESTIONS_RESULTS."
                                                      Where id_ques IN (".$q_id.") AND id_std = ".$stdRollNum." 
                                                  ");
                        $result = mysqli_fetch_array($sqllms);
                        $obtMarks = $obtMarks + $result['obtMarks'];
                      }
                    }
                  }

                  $cloPercentage = round((($obtMarks / $total)*100),2);
                  $cloFinalAttainment[$cloId] = $cloPercentage;
                  echo '<td>'.$cloPercentage.'</td>'; 
                }
              } else {
                echo '<td></td>'; 
              }
              
              $ploFinalAttainment = [];
              if(count($finaltermPloNumberArray)) {
                foreach ($finaltermPloNumberArray as $ploId => $ploNumber) {
                  $total = 0;
                  $obtMarks = 0;
                  $ploPercentage = 0;
                  $sqllms = $dblms->querylms("SELECT GROUP_CONCAT(clo_id) as clo_ids
                                                FROM ".OBE_CLOS."
                                                Where FIND_IN_SET(".$ploId.", id_plo)  
                                            ");
                  $rowstd = mysqli_fetch_array($sqllms);
                  $clo_ids = explode(",",$rowstd['clo_ids']);
                  foreach ($clo_ids as $cloId) {
                    $sqllms = $dblms->querylms("SELECT GROUP_CONCAT(ques_id) as ques_ids
                                                  FROM ".OBE_QUESTIONS."
                                                  Where FIND_IN_SET(".$cloId.", id_clo)  
                                              ");
                    $rowstd = mysqli_fetch_array($sqllms);
                    
                    if($rowstd['ques_ids'] != NULL) {
                      $ques_ids = explode(",",$rowstd['ques_ids']);
                      foreach ($ques_ids as $q_id) {
                        $sqllms = $dblms->querylms("SELECT id_ques
                                                      FROM ".OBE_FINALTERMS."
                                                      Where FIND_IN_SET(".$q_id.", id_ques) 
                                                  ");
                        $record = mysqli_fetch_array($sqllms);
                        if($record) {
                          $sqllms = $dblms->querylms("SELECT ques_marks
                                                        FROM ".OBE_QUESTIONS."
                                                        Where ques_id IN (".$q_id.") 
                                                    ");
                          $result = mysqli_fetch_array($sqllms);
                          $total = $total + $result['ques_marks'];

                          $sqllms = $dblms->querylms("SELECT sum(obt_marks) as obtMarks
                                                        FROM ".OBE_QUESTIONS_RESULTS."
                                                        Where id_ques IN (".$q_id.") AND id_std = ".$stdRollNum." 
                                                    ");
                          $result = mysqli_fetch_array($sqllms);
                          $obtMarks = $obtMarks + $result['obtMarks'];
                        }
                      }
                    }
                  }
                  $ploPercentage = round((($obtMarks / $total)*100),2);
                  $ploFinalAttainment[$ploId] = $ploPercentage;

                  echo '<td>'.$ploPercentage.'</td>'; 
                }
              } else {                 
                echo '<td></td>'; 
              }

              $averagesCloSessionalFinal = [];
              
              foreach (array_keys($cloSessionalAttainment + $cloFinalAttainment) as $index) {
                $sessionalValue = isset($cloSessionalAttainment[$index]) ? $cloSessionalAttainment[$index] : 0;
                $finalValue = isset($cloFinalAttainment[$index]) ? $cloFinalAttainment[$index] : 0;
                $averagesCloSessionalFinal[$index] = ($sessionalValue + $finalValue) / 2;
              }

              $countsClo = [];
              
              if(count($completeCourseClosArray) > 0) {
                foreach ($completeCourseClosArray as $cloId => $cloNumber) {
                  if(!isset($countsClo[$cloId])) {
                    $countsClo[$cloId] = 0;
                  }
                  $attainedCloMarks[$stdRollNum][$cloId] = $averagesCloSessionalFinal[$cloId];

                  if($averagesCloSessionalFinal[$cloId] >= 50) {
                    $countsClo[$cloId]++;
                  }
                  echo '<td>'.$averagesCloSessionalFinal[$cloId].'</td>';
                }
              } else {
                echo '<td></td>';
              }
              

              $averagesPloSessionalFinal = [];
              foreach (array_keys($ploSessionalAttainment + $ploFinalAttainment) as $index) {
                $sessionalValue = isset($ploSessionalAttainment[$index]) ? $ploSessionalAttainment[$index] : 0;
                $finalValue = isset($ploFinalAttainment[$index]) ? $ploFinalAttainment[$index] : 0;
                $averagesPloSessionalFinal[$index] = ($sessionalValue + $finalValue) / 2;
              }

              $countsPlo = [];
              if(count($completeCoursePlosArray) > 0) {
                foreach ($completeCoursePlosArray as $ploId => $ploNumber) {
                  if(!isset($countsPlo[$ploId])) {
                    $countsPlo[$ploId] = 0;
                  }
                  $attainedPloMarks[$stdRollNum][$ploId] = $averagesPloSessionalFinal[$ploId];

                  if($averagesPloSessionalFinal[$ploId] >= 50) {
                    $countsPlo[$ploId]++;
                  }
                  echo '<td>'.$averagesPloSessionalFinal[$ploId].'</td>';
                }
              } else {
                echo '<td></td>';
              }
          
              echo '
            </tr>';
            }
          }

          echo ' 
          <tr>
            <td colspan="" rowspan="8"></td>
            <td colspan="4" style="text-align: right;" nowrap="nowrap">No. of Students who Attained 50% in CLOs &#9658</td>';
            if(count($countsClo) > 0) {
              foreach ($countsClo as $cloId => $item) {
                echo '<td>'.$item.'</td>';
              }
            } else {
              echo '<td></td>';
              echo '<td rowspan="2"></td>';
            }
            if(isset($countCoursePlo) && $countCoursePlo > 0) {                
              echo '<td colspan="'.$countCoursePlo.'" rowspan="2"></td>';
            }
            echo '
            </tr>
            <tr>
              <td colspan="4" style="text-align: right;" nowrap="nowrap">Attainment of CLOs at Cohort Level &#9658</td>
              ';
              if(count($countsClo) > 0) {
                foreach ($countsClo as $cloId => $item) {
                  $cloattainmentcohort[$cloId] = round((($item/$stdCount)*100),0); 
                  echo '<td>'.round((($item/$stdCount)*100),0).'%</td>';
                }
              } else {
                echo '<td></td>';
              }
            
            echo '
            <tr>
              <td colspan="'.($countCourseClo + 5).'" style="text-align: right;" nowrap="nowrap">No. of Students who Attained 50% in PLOs &#9658</td>
            ';
          
            if(count($countsPlo) > 0) {
              foreach ($countsPlo as $ploId => $item) {
                echo '<td>'.$item.'</td>';
              }
            } else {
              echo '<td></td>';
            }
            echo '
          </tr>
          <tr>
            <td colspan="'.($countCourseClo + 5).'" style="text-align: right;" nowrap="nowrap">Attainment of PLOs at Cohort Level &#9658</td>
            ';
            if(count($countsPlo) > 0) {
              foreach ($countsPlo as $ploId => $item) {
                $ploattainmentcohort[$ploId] = round((($item/$stdCount)*100),0); 
                echo '<td>'.round((($item/$stdCount)*100),0).'%</td>';
              }
            } else {
              echo '<td></td>';
            }
              echo '
          </tbody>
        </table>
      </div>
      ';

       
  $stdIds = array_keys($attainedCloMarks);
  $studentIDs = array();
  foreach ($stdIds as $value) {
    if(isset(STUDENT[$value]['id'])) {
      $studentIDs[] = STUDENT[$value]['id'];
    }
  }

  $datasetsClo = array();
  if(count($attainedCloMarks) > 0) {
    foreach ($attainedCloMarks[1] as $key => $value) {
        $dataClo = array();
        foreach ($attainedCloMarks as $index => $item) {
          $dataClo[] = $item[$key];
        }

        $backgroundColors = [
          'rgba(58, 200, 225, 0.6)', 'rgba(255, 99, 132, 0.6)', 'rgba(255, 206, 86, 0.6)',
          'rgba(75, 192, 192, 0.6)', 'rgba(153, 102, 255, 0.6)', 'rgba(255, 159, 64, 0.6)',
          'rgba(54, 162, 235, 0.6)', 'rgba(255, 102, 102, 0.6)', 'rgba(255, 153, 204, 0.6)',
          'rgba(139, 0, 0, 0.6)', 'rgba(0, 100, 0, 0.6)', 'rgba(128, 0, 128, 0.6)',
          'rgba(128, 128, 0, 0.6)', 'rgba(0, 128, 128, 0.6)', 'rgba(0, 0, 128, 0.6)',
          'rgba(255, 165, 0, 0.6)', 'rgba(0, 128, 0, 0.6)', 'rgba(218, 112, 214, 0.6)',
          'rgba(128, 0, 0, 0.6)', 'rgba(255, 0, 0, 0.6)'
        ];
        $borderColors = [
                    'rgba(58, 200, 225, 1)', 'rgba(255, 99, 132, 1)', 'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)',
                    'rgba(54, 162, 235, 1)', 'rgba(255, 102, 102, 1)', 'rgba(255, 153, 204, 1)',
                    'rgba(139, 0, 0, 1)', 'rgba(0, 100, 0, 1)', 'rgba(128, 0, 128, 1)',
                    'rgba(128, 128, 0, 1)', 'rgba(0, 128, 128, 1)', 'rgba(0, 0, 128, 1)',
                    'rgba(255, 165, 0, 1)', 'rgba(0, 128, 0, 1)', 'rgba(218, 112, 214, 1)',
                    'rgba(128, 0, 0, 1)', 'rgba(255, 0, 0, 1)'
                  ];
        $backgroundColor = $backgroundColors[$key - 1]; // Assign a different color for each dataset
        $borderColor = $borderColors[$key - 1]; // Assign a different color for each dataset

        $dataset = array(
            'label' => 'CLO'.$key,
            'backgroundColor' => $backgroundColor,
            'borderColor' => $borderColor,
            'borderWidth' => 2,
            'data' => $dataClo,
            'datalabels' => [
              'color'=>'blue',
              'anchor'=>'end',
              'align'=>'top'
            ]
        );
        $datasetsClo[] = $dataset;
    }
  }

  $dataClo = array(
      'labels' => $studentIDs,
      'datasets' => $datasetsClo,
  );


  $datasetsPlo = array();
  if(count($attainedPloMarks) > 0) {
    foreach ($attainedPloMarks[1] as $key => $value) {
      $dataPlo = array();
      foreach ($attainedPloMarks as $index => $item) {
        $dataPlo[] = $item[$key];
      }
      $backgroundColors = [
                  'rgba(58, 200, 225, 0.6)', 'rgba(255, 99, 132, 0.6)', 'rgba(255, 206, 86, 0.6)',
                  'rgba(75, 192, 192, 0.6)', 'rgba(153, 102, 255, 0.6)', 'rgba(255, 159, 64, 0.6)',
                  'rgba(54, 162, 235, 0.6)', 'rgba(255, 102, 102, 0.6)', 'rgba(255, 153, 204, 0.6)',
                  'rgba(139, 0, 0, 0.6)', 'rgba(0, 100, 0, 0.6)', 'rgba(128, 0, 128, 0.6)',
                  'rgba(128, 128, 0, 0.6)', 'rgba(0, 128, 128, 0.6)', 'rgba(0, 0, 128, 0.6)',
                  'rgba(255, 165, 0, 0.6)', 'rgba(0, 128, 0, 0.6)', 'rgba(218, 112, 214, 0.6)',
                  'rgba(128, 0, 0, 0.6)', 'rgba(255, 0, 0, 0.6)'
                ];
      $borderColors = [
                        'rgba(58, 200, 225, 1)', 'rgba(255, 99, 132, 1)', 'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)',
                        'rgba(54, 162, 235, 1)', 'rgba(255, 102, 102, 1)', 'rgba(255, 153, 204, 1)',
                        'rgba(139, 0, 0, 1)', 'rgba(0, 100, 0, 1)', 'rgba(128, 0, 128, 1)',
                        'rgba(128, 128, 0, 1)', 'rgba(0, 128, 128, 1)', 'rgba(0, 0, 128, 1)',
                        'rgba(255, 165, 0, 1)', 'rgba(0, 128, 0, 1)', 'rgba(218, 112, 214, 1)',
                        'rgba(128, 0, 0, 1)', 'rgba(255, 0, 0, 1)'
                      ];
      $backgroundColor = $backgroundColors[$key - 1]; // Assign a different color for each dataset
      $borderColor = $borderColors[$key - 1]; // Assign a different color for each dataset

      $dataset = array(
          'label' => 'PLO'.$key,
          'backgroundColor' => $backgroundColor,
          'borderColor' => $borderColor,
          'borderWidth' => 2,
          'data' => $dataPlo,
          'datalabels' => [
            'color'=>'blue',
            'anchor'=>'end',
            'align'=>'top'
          ]
      );
      $datasetsPlo[] = $dataset;
    }
  }

  $dataPlo = array(
      'labels' => $studentIDs,
      'datasets' => $datasetsPlo,
  );

  echo '

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0-rc.1/chartjs-plugin-datalabels.min.js" integrity="sha512-+UYTD5L/bU1sgAfWA0ELK5RlQ811q8wZIocqI7+K0Lhh8yVdIoAMEs96wJAIbgFvzynPm36ZCXtkydxu1cs27w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <div style="overflow: auto;">
    <canvas id="chartCohort" height="100" style="margin-top: 20px; margin-bottom: 20px; overflow: auto;" ></canvas>
    <canvas id="chart_clo" height="100" style="margin-top: 20px; margin-bottom: 20px; overflow: auto;"></canvas>
    <canvas id="chart_plo" height="100" style="margin-top: 20px; margin-bottom: 20px; overflow: auto;"></canvas>
  </div>

  <script>
    var cloattainmentcohort = "";
    var ploattainmentcohort = "";
    ';
    if(!empty($cloattainmentcohort) && !empty($ploattainmentcohort)) {
      echo '
        var cloattainmentcohort = '.json_encode($cloattainmentcohort, JSON_NUMERIC_CHECK).'
        var ploattainmentcohort = '.json_encode($ploattainmentcohort, JSON_NUMERIC_CHECK).'
      ';
    }
    echo '
          var labels = Object.keys(cloattainmentcohort).map(Number);
          var clovalues = Object.values(cloattainmentcohort);
          var plovalues = Object.values(ploattainmentcohort);
          console.log(ploattainmentcohort);
          
          var datasets = [ {
              label: "CLOs",
              data: clovalues,
              backgroundColor: "rgba(58, 200, 225, 0.5)",
              borderColor: "rgba(58, 200, 225, 1)",
              borderWidth: 2,
              datalabels:{
                color:"blue",
                anchor:"end",
                align:"top"
              }        
            }, {
              label: "PLOs",
              data: plovalues,
              backgroundColor: "rgba(255, 99, 132, 0.5)",
              borderColor: "rgba(255, 99, 132, 1)",
              borderWidth: 2,
              datalabels:{
                color:"blue",
                anchor:"end",
                align:"top"
              }
            }
          ];

          var ctx = document.getElementById("chartCohort");
          var myChart = new Chart(ctx, {
            type: "bar",
            data: {
              labels : labels,
              datasets: datasets
            },
            options: {
              responsive: true,
              plugins: {
                legend: {
                  position: "top",
                },
                title: {
                  display: true,
                  text: "Attainment of CLOs & PLOs at Cohort Level ",
                },
              },
              scales: {
                x: {
                  display:false,
                },
                y: {
                  beginAtZero: true,
                  title: {
                    display: true,
                  },
                  ticks: {
                    callback: function(value){return value + "%"}
                  }
                }
              }
            }
          });
    
    var configClo = {
      type: "bar",
      data: '.json_encode($dataClo, JSON_NUMERIC_CHECK).',
      options: {
          responsive: true,
          plugins: {
            legend: {
              position: "top",
            },
            title: {
              display: true,
              text: "Attainment of CLOs at Individual Level"
            }
          },
        scales: {
          x: 
          {
            title: {
              display: true,
              barPercentage: 0.5,
            },
            ticks: {
              maxRotation: 45,
              minRotation: 45,
            }
          },
          y: 
          {
            beginAtZero: true,
            title:  {
              display: true,
              text: "Percentage Attainment",
              color: "#191",
              font: {
                family: "Comic Sans MS",
                size: 20,
                weight: "bold"
              }
            },
            ticks: {
              callback: function(value){return value + "%"}
            }
          }
        }
      }
    };
    
    var configPlo = {
      type: "bar",
      data: '.json_encode($dataPlo, JSON_NUMERIC_CHECK).',
      options: {
          responsive: true,
          plugins: {
            legend: {
              position: "top",
            },
            title: {
              display: true,
              text: "Attainment of PLOs at Individual Level"

            }
          },
        scales: {
          x: 
          {
            title:  {
              display: true,
            },
            ticks: {
              maxRotation: 45,
              minRotation: 45,
            }
          },
          y: 
          {
            beginAtZero: true,
            title:  {
              display: true,
              text: "Percentage Attainment",
              color: "#191",
              font: {
                family: "Comic Sans MS",
                size: 20,
                weight: "bold",
                lineHeight: 1.2
              },
            },
            ticks: {
              callback: function(value){return value + "%"}
            }
          }
        }
      }
    };
    
    new Chart("chart_clo", configClo);
    new Chart("chart_plo", configPlo);
  </script>';
}