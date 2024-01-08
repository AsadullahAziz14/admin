<?php
include "dbsetting/lms_vars_config.php";
include "dbsetting/classdbconection.php";
$dblms = new dblms();
include "functions/login_func.php";
include "functions/functions.php";
checkCpanelLMSALogin();

//------------------------------------------------
      echo '
      <style>
         /* CSS styling for the question paper */
         body {
            font-family: Arial, sans-serif;
            margin: 20px;
         }

         h1 {
            text-align: center;
         }

         .header {
            margin-bottom: 20px;
         }

         .header-item {
            font-weight: bold;
         }

         .header-table {
            width: 100%;
            border-collapse: collapse;
         }

         .header-table td {
            padding: 5px;
            border: 1px solid #000;
         }

         .question {
            margin-bottom: 20px;
         }

         .question-number {
            font-weight: bold;
         }

         .question-statement {
            margin-top: 10px;
         }

         .options {
            margin-left: 20px;
         }
   </style>
      <div id="print" class="row">
         <div class="container">
            <div class="container">
               <div class="header">
                  <table class="header-table">
                           <tr>
                           ';
                           if(isset($_GET['print']))
                           {
                              
                              if ($_GET['print'] == 'quiz' && isset($_GET['id'])) 
                              {
                           
                                 $sqllms = $dblms->querylms("SELECT * FROM ".OBE_QUIZZES." WHERE quiz_id = ".cleanvars($_GET['id'])." ");
                                 $value_quiz = mysqli_fetch_assoc($sqllms);
                                 if(mysqli_num_rows($sqllms) > 0)
                                 {
                                    $quessqllms = $dblms->querylms("SELECT * FROM ".OBE_QUESTIONS." WHERE ques_id IN (".$value_quiz['id_ques'].")");
                                    echo '
                                       <td style="vertical-align: middle;" nowrap="nowrap" colspan="4" align="center">
                                          <h1 style="font-weight: bolder;">MINHAJ UNIVERSITY LAHORE</h1>
                                       </td>
                              </tr>
                              <tr>
                                 <td style="vertical-align: middle;" nowrap="nowrap">
                                    <span class="header-item">Program: </span>'.ID_PRG_ARRAY[ID_PRG].'
                                 </td>
                                 <td style="vertical-align: middle;" nowrap="nowrap">
                                    <span class="header-item">Semester: </span> '.SEMESTER_ARRAY[SEMESTER].'
                                 </td>
                                 <td style="vertical-align: middle;" nowrap="nowrap">
                                    <span class="header-item">Section: </span>'.SECTION.'
                                 </td>
                                 <td style="vertical-align: middle;" nowrap="nowrap">
                                    <span class="header-item">Academic Session: </span> '.ACADEMIC_SESSION.'
                                 </td>
                              </tr>
                              <tr>
                                 <td style="vertical-align: middle;" nowrap="nowrap">
                                    <span class="header-item">Course: </span>'.ID_COURSE_ARRAY[ID_COURSE].'
                                 </td>
                                 <td style="vertical-align: middle;" nowrap="nowrap">
                                    <span class="header-item">Marks: </span> '.$value_quiz['quiz_marks'].'
                                 </td>
                                 <td style="vertical-align: middle;" nowrap="nowrap">
                                    <span class="header-item">Teacher: </span>'.ID_TEACHER_ARRAY[ID_TEACHER].'
                                 </td>
                                 <td style="vertical-align: middle;" nowrap="nowrap">
                                    <span class="header-item">Date: </span>'.date('d-M-Y', strtotime($value_quiz['quiz_date'])).'
                                 </td>
                              </tr>
                           </table>
                        </div>
                        ';
                        while($value_ques = mysqli_fetch_array($quessqllms))
                        {
                           echo '
                           <div>
                              <div class="question-number">Question '.$value_ques['ques_number'].':</div>
                              <div class="question-statement">
                                    '.$value_ques['ques_statement'].'
                              </div>
                              ';
                              if($value_ques['ques_category'] === '2')
                              {
                                 $mcqoptionssql = $dblms->querylms("SELECT option1, option2, option3, option4, option5 FROM ".OBE_MCQS." WHERE id_ques IN (".$value_ques['ques_id'].")");
                                 $value_mcqOptions = mysqli_fetch_array($mcqoptionssql);
                                 
                                 echo '
                                 <div class="options">
                                    <div class="col-sm-61">a. '.$value_mcqOptions['option1'].'</div>
                                    <div class="col-sm-61">b. '.$value_mcqOptions['option2'].'</div>
                                    <div class="col-sm-61">c. '.$value_mcqOptions['option3'].'</div>
                                    <div class="col-sm-61">d. '.$value_mcqOptions['option4'].'</div>
                                    <div class="col-sm-91">e. '.$value_mcqOptions['option5'].'</div>
                                 </div>
                                 ';

                              }
                              echo '
                           </div>       
                           ';
                        }
                           echo '
                     </div>
                  </div>
               </div>
               ';
                              }  
                              }
                        
                              if ($_GET['print'] == 'assignment' && isset($_GET['id'])) 
                              {
                           
                                 $sqllms = $dblms->querylms("SELECT * FROM " .OBE_ASSIGNMENTS." WHERE assignment_id = ".cleanvars($_GET['id'])." ");
                                 $value_assignment = mysqli_fetch_assoc($sqllms);

                                 if(mysqli_num_rows($sqllms))
                                 {
                                    $quessqllms = $dblms->querylms("SELECT * FROM ".OBE_QUESTIONS." WHERE ques_id IN (".$value_assignment['id_ques'].")");

                                                   echo '
                                                      <td style="vertical-align: middle;" nowrap="nowrap" colspan="4" align="center">
                                                         <h1 style="font-weight: bolder;">MINHAJ UNIVERSITY LAHORE</h1>
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Program: </span>'.ID_PRG_ARRAY[ID_PRG].'
                                                      </td>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Semester: </span> '.SEMESTER_ARRAY[SEMESTER].'
                                                      </td>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Section: </span>'.SECTION.'
                                                      </td>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Academic Session: </span> '.ACADEMIC_SESSION.'
                                                      </td>
                                                      
                                                   </tr>
                                                   <tr>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Course: </span>'.ID_COURSE_ARRAY[ID_COURSE].'
                                                      </td>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Marks: </span> '.$value_assignment['assignment_marks'].'
                                                      </td>
                                                   
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Teacher: </span>'.ID_TEACHER_ARRAY[ID_TEACHER].'
                                                      </td>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Date: </span>'.date('d-M-Y', strtotime($value_assignment['assignment_date'])).'
                                                      </td>
                                                   </tr>
                                             </table>
                                          </div>

                                          ';
                                          while($value_ques = mysqli_fetch_array($quessqllms))
                                          {
                                             echo '
                                             <div>
                                                <div class="question-number">Question '.$value_ques['ques_number'].':</div>
                                                <div class="question-statement">
                                                      '.$value_ques['ques_statement'].'
                                                </div>
                                             ';
                                                if($value_ques['ques_category'] === '2')
                                                {
                                                   $mcqoptionssql = $dblms->querylms("SELECT option1, option2, option3, option4, option5 FROM ".OBE_MCQS." WHERE id_ques IN (".$value_ques['ques_id'].")");
                                                   $value_mcqOptions = mysqli_fetch_array($mcqoptionssql);
                                                   
                                                   echo '
                                                   <div class="options">
                                                      <div class="col-sm-61">a. '.$value_mcqOptions['option1'].'</div>
                                                      <div class="col-sm-61">b. '.$value_mcqOptions['option2'].'</div>
                                                      <div class="col-sm-61">c. '.$value_mcqOptions['option3'].'</div>
                                                      <div class="col-sm-61">d. '.$value_mcqOptions['option4'].'</div>
                                                      <div class="col-sm-91">e. '.$value_mcqOptions['option5'].'</div>
                                                   </div>
                                                   ';

                                                }
                                                echo '
                                          </div>       
                                             ';
                                          }
                                             echo '
                                       </div>
                                    </div>
                                 </div>
                                 ';
                                 }
                              }

                              if ($_GET['print'] == 'midterm' && isset($_GET['id'])) 
                              {
                           
                                 $sqllms = $dblms->querylms("SELECT * FROM " .OBE_MIDTERMS." WHERE mt_id = ".cleanvars($_GET['id'])." ");
                                 $value_midterm = mysqli_fetch_assoc($sqllms);

                                 if(mysqli_num_rows($sqllms))
                                 {
                                    $quessqllms = $dblms->querylms("SELECT * FROM ".OBE_QUESTIONS." WHERE ques_id IN (".$value_midterm['id_ques'].")");

                                                   echo '
                                                      <td style="vertical-align: middle;" nowrap="nowrap" colspan="4" align="center">
                                                         <h1 style="font-weight: bolder;">MINHAJ UNIVERSITY LAHORE</h1>
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Program: </span>'.ID_PRG_ARRAY[ID_PRG].'
                                                      </td>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Semester: </span> '.SEMESTER_ARRAY[SEMESTER].'
                                                      </td>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Section: </span>'.SECTION.'
                                                      </td>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Academic Session: </span> '.ACADEMIC_SESSION.'
                                                      </td>
                                                      
                                                   </tr>
                                                   <tr>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Course: </span>'.ID_COURSE_ARRAY[ID_COURSE].'
                                                      </td>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Marks: </span> '.$value_midterm['mt_marks'].'
                                                      </td>
                                                   
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Teacher: </span>'.ID_TEACHER_ARRAY[ID_TEACHER].'
                                                      </td>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Date: </span>'.date('d-M-Y', strtotime($value_midterm['mt_date'])).'
                                                      </td>
                                                   </tr>
                                             </table>
                                          </div>

                                          ';
                                          while($value_ques = mysqli_fetch_array($quessqllms))
                                          {
                                             echo '
                                             <div>
                                                <div class="question-number">Question '.$value_ques['ques_number'].':</div>
                                                <div class="question-statement">
                                                      '.$value_ques['ques_statement'].'
                                                </div>
                                             ';
                                                if($value_ques['ques_category'] === '2')
                                                {
                                                   $mcqoptionssql = $dblms->querylms("SELECT option1, option2, option3, option4, option5 FROM ".OBE_MCQS." WHERE id_ques IN (".$value_ques['ques_id'].")");
                                                   $value_mcqOptions = mysqli_fetch_array($mcqoptionssql);
                                                   
                                                   echo '
                                                   <div class="options">
                                                      <div class="col-sm-61">a. '.$value_mcqOptions['option1'].'</div>
                                                      <div class="col-sm-61">b. '.$value_mcqOptions['option2'].'</div>
                                                      <div class="col-sm-61">c. '.$value_mcqOptions['option3'].'</div>
                                                      <div class="col-sm-61">d. '.$value_mcqOptions['option4'].'</div>
                                                      <div class="col-sm-91">e. '.$value_mcqOptions['option5'].'</div>
                                                   </div>
                                                   ';

                                                }
                                                echo '
                                          </div>       
                                             ';
                                          }
                                             echo '
                                       </div>
                                    </div>
                                 </div>
                                 ';
                                 }
                              }

                              if ($_GET['print'] == 'finalterm' && isset($_GET['id'])) 
                              {
                           
                                 $sqllms = $dblms->querylms("SELECT * FROM " .OBE_FINALTERMS." WHERE ft_id = ".cleanvars($_GET['id'])." ");
                                 $value_finalterm = mysqli_fetch_assoc($sqllms);

                                 if(mysqli_num_rows($sqllms))
                                 {
                                    $quessqllms = $dblms->querylms("SELECT * FROM ".OBE_QUESTIONS." WHERE ques_id IN (".$value_finalterm['id_ques'].")");

                                                   echo '
                                                      <td style="vertical-align: middle;" nowrap="nowrap" colspan="4" align="center">
                                                         <h1 style="font-weight: bolder;">MINHAJ UNIVERSITY LAHORE</h1>
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Program: </span>'.ID_PRG_ARRAY[ID_PRG].'
                                                      </td>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Semester: </span> '.SEMESTER_ARRAY[SEMESTER].'
                                                      </td>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Section: </span>'.SECTION.'
                                                      </td>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Academic Session: </span> '.ACADEMIC_SESSION.'
                                                      </td>
                                                      
                                                   </tr>
                                                   <tr>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Course: </span>'.ID_COURSE_ARRAY[ID_COURSE].'
                                                      </td>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Marks: </span> '.$value_finalterm['ft_marks'].'
                                                      </td>
                                                   
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Teacher: </span>'.ID_TEACHER_ARRAY[ID_TEACHER].'
                                                      </td>
                                                      <td style="vertical-align: middle;" nowrap="nowrap">
                                                         <span class="header-item">Date: </span>'.date('d-M-Y', strtotime($value_finalterm['ft_date'])).'
                                                      </td>
                                                   </tr>
                                             </table>
                                          </div>

                                          ';
                                          while($value_ques = mysqli_fetch_array($quessqllms))
                                          {
                                             echo '
                                             <div>
                                                <div class="question-number">Question '.$value_ques['ques_number'].':</div>
                                                <div class="question-statement">
                                                      '.$value_ques['ques_statement'].'
                                                </div>
                                             ';
                                                if($value_ques['ques_category'] === '2')
                                                {
                                                   $mcqoptionssql = $dblms->querylms("SELECT option1, option2, option3, option4, option5 FROM ".OBE_MCQS." WHERE id_ques IN (".$value_ques['ques_id'].")");
                                                   $value_mcqOptions = mysqli_fetch_array($mcqoptionssql);
                                                   
                                                   echo '
                                                   <div class="options">
                                                      <div class="col-sm-61">a. '.$value_mcqOptions['option1'].'</div>
                                                      <div class="col-sm-61">b. '.$value_mcqOptions['option2'].'</div>
                                                      <div class="col-sm-61">c. '.$value_mcqOptions['option3'].'</div>
                                                      <div class="col-sm-61">d. '.$value_mcqOptions['option4'].'</div>
                                                      <div class="col-sm-91">e. '.$value_mcqOptions['option5'].'</div>
                                                   </div>
                                                   ';

                                                }
                                                echo '
                                          </div>       
                                             ';
                                          }
                                             echo '
                                       </div>
                                    </div>
                                 </div>
                                 ';
                                 }
                              }

                           }
?>

<script>
   window.print();
</script>
