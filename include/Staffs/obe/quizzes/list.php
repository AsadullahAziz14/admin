<?php
if (!LMS_VIEW && !isset($_GET['id'])) {
   $adjacents = 3;
   if (!($Limit)) {
      $Limit = 100;
   }
   if ($page) {
      $start = ($page - 1) * $Limit;
   } else {
      $start = 0;
   }
   $page = (int) $page;

   $queryQuiz = $dblms->querylms("SELECT quiz_id 
                                       FROM ".OBE_QUIZZES." 
                                       WHERE id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus =  ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                                    ");
   $count = mysqli_num_rows($queryQuiz);
   if ($page == 0) {
      $page = 1;
   }						                     //if no page var is given, default to 1.
   $prev = $page - 1;							//previous page is page - 1
   $next = $page + 1;							//next page is page + 1
   $lastpage = ceil($count / $Limit);		//lastpage is = total pages / items per page, rounded up.
   $lpm1 = $lastpage - 1;

   if (mysqli_num_rows($queryQuiz) > 0) {
      $queryQuiz = $dblms->querylms("SELECT quiz_id, quiz_status, quiz_number, quiz_date, quiz_marks, id_ques,
                                             id_teacher, id_course, id_prg, semester, section, academic_session
                                          FROM ".OBE_QUIZZES."
                                          WHERE id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg = ".ID_PRG." AND semester = ".SEMESTER." AND section = '".SECTION."' AND timing = ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus =  ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                                          ORDER BY quiz_id DESC LIMIT ".($page - 1) * $Limit.",$Limit");
      echo '    
      <div style=" float:right; text-align:right; font-weight:700; color:blue; margin-right:10px;"> 
         <form class="navbar-form navbar-left form-small" action="#" method="POST">
            Total : ('.number_format($count).')
         </form>
      </div>
      <div class="table-responsive" style="overflow: auto;">
         <table class="footable table table-bordered table-hover table-with-avatar">
            <thead>
               <tr>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Sr.#</th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Quiz No.</th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Questions</th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Teacher</th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Course</th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Program</th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Semester</th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Section</th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Academic Session</th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Quiz Date</th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Marks</th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Status</th>
                  <th style="width:70px; text-align:center; font-size:14px;">Quiz  Actions</th>
                  <th style="width:70px; text-align:center; font-size:14px;">Result Actions</th>
               </tr>
            </thead>
            <tbody>';
      if ($page == 1) {
         $srno = 0;
      } else {
         $srno = ($Limit * ($page - 1));
      }

      while ($valueQuiz = mysqli_fetch_array($queryQuiz)) {
         $srno++;
         if ($valueQuiz['id_ques'] != '') {
            $queryQues = $dblms->querylms('SELECT GROUP_CONCAT(ques_number) AS result 
                                                      FROM '.OBE_QUESTIONS.' 
                                                      WHERE ques_id IN ('.$valueQuiz['id_ques'].')');
            $valueQues = mysqli_fetch_array($queryQues);
         } else {
            $valueQues['result'] = '';
         }

         $canEditQuiz = ' ';
         if (($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'edit' => '1'))) {
            $canEditQuiz = '<a class="btn btn-xs btn-info" href="obequizzes.php?id='.$valueQuiz['quiz_id'].'"><i class="icon-pencil"></i></a>';
         }

         $canPrintQuiz = ' ';
         if (($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'print' => '1'))) {
            $canPrintQuiz = '<a class="btn btn-xs btn-info" target="_blank" href="obeprint.php?print=quiz&id='.$valueQuiz['quiz_id'].'"><i class="icon-print"></i></a>';
         }

         $canDeleteQuiz = ' ';
         if (($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'delete' => '1'))) {
            $canDeleteQuiz = '<a href="?deletequizId='.$valueQuiz['quiz_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>';
         }

         $canAddResult = ' ';
         if (($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'print' => '1'))) {
            $canAddResult = '<a class="btn btn-xs btn-info" href="obequizzes.php?view=addresult&id='.$valueQuiz['quiz_id'].'"><i class="icon-plus"></i></a>';
         }

         $canEditResult = ' ';
         if (($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'edit' => '1'))) {
            $canEditResult = '<a class="btn btn-xs btn-info" href="obequizzes.php?view=editresult&id='.$valueQuiz['quiz_id'].'"><i class="icon-pencil"></i></a>';
         }

         $canDeleteResult = ' ';
         if (($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'delete' => '1'))) {
            $canDeleteResult = '<a href="?deleteresultId='.$valueQuiz['quiz_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>';
         }

         echo '
               <tr>
               <td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
               <td style="vertical-align: middle;" nowrap="nowrap">'.$valueQuiz['quiz_number'].'</td>
               <td style="vertical-align: middle;" nowrap="nowrap">'.$valueQues['result'].'</td>
               <td style="vertical-align: middle;" nowrap="nowrap">'.ID_TEACHER_ARRAY[$valueQuiz['id_teacher']].'</td>
               <td style="vertical-align: middle;" nowrap="nowrap">'.ID_COURSE_ARRAY[$valueQuiz['id_course']].'</td>
               <td style="vertical-align: middle;" nowrap="nowrap">'.ID_PRG_ARRAY[$valueQuiz['id_prg']].'</td>
               <td style="vertical-align: middle;" nowrap="nowrap">'.SEMESTER_ARRAY[$valueQuiz['semester']].'</td>
               <td style="vertical-align: middle;" nowrap="nowrap"> '.$valueQuiz['section'].'</td>
               <td style="vertical-align: middle;" nowrap="nowrap">'.$valueQuiz['academic_session'].'</td>
               <td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($valueQuiz['quiz_date'])).'</td>
               <td style="vertical-align: middle;" nowrap="nowrap">'.$valueQuiz['quiz_marks'].'</td>
               <td style="width:80px;text-align:center;" nowrap="nowrap">'.get_status($valueQuiz['quiz_status']).'</td>
               <td style="vertical-align: middle;" nowrap="nowrap" style="text-align:center;">
                  '.$canEditQuiz.'
                  '.$canPrintQuiz.'
                  '.$canDeleteQuiz.'
               </td>
               <td style="vertical-align: middle;" nowrap="nowrap" style="text-align:center;">
                  '.$canAddResult.'
                  '.$canEditResult.'
                  '.$canDeleteResult.'
               </td>
               </tr>';
      }
      echo '
            </tbody>
         </table>';
      if ($count > $Limit) {
         echo '
         <div class="widget-foot">
            <!--WI_PAGINATION-->
            <ul class="pagination pull-right">';
            $pagination = "";
            if ($lastpage > 1) {
               //previous button
               if ($page > 1) {
                  $pagination .= '<li><a href="obequizzes.php?page='.$prev.$sqlstring.'">Prev</a></li>';
               }
               //pages	
               if ($lastpage < 7 + ($adjacents * 3)) {
                  //not enough pages to bother breaking it up
                  for ($counter = 1; $counter <= $lastpage; $counter++) {
                     if ($counter == $page) {
                        $pagination .= '<li class="active"><a href="">'.$counter.'</a></li>';
                     } else {
                        $pagination .= '<li><a href="obequizzes.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
                     }
                  }
               } else if ($lastpage > 5 + ($adjacents * 3)) {
                  //enough pages to hide some
                  //close to beginning; only hide later pages
                  if ($page < 1 + ($adjacents * 3)) {
                     for ($counter = 1; $counter < 4 + ($adjacents * 3); $counter++) {
                        if ($counter == $page) {
                           $pagination .= '<li class="active"><a href="">'.$counter.'</a></li>';
                        } else {
                           $pagination .= '<li><a href="obequizzes.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
                        }
                     }
                     $pagination .= '<li><a href="#"> ... </a></li>';
                     $pagination .= '<li><a href="obequizzes.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
                     $pagination .= '<li><a href="obequizzes.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';
                  } else if ($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
                     $pagination .= '<li><a href="obequizzes.php?page=1'.$sqlstring.'">1</a></li>';
                     $pagination .= '<li><a href="obequizzes.php?page=2'.$sqlstring.'">2</a></li>';
                     $pagination .= '<li><a href="obequizzes.php?page=3'.$sqlstring.'">3</a></li>';
                     $pagination .= '<li><a href="#"> ... </a></li>';
                     for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page) {
                           $pagination .= '<li class="active"><a href="">'.$counter.'</a></li>';
                        } else {
                           $pagination .= '<li><a href="obequizzes.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
                        }
                     }
                     $pagination .= '<li><a href="#"> ... </a></li>';
                     $pagination .= '<li><a href="obequizzes.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
                     $pagination .= '<li><a href="obequizzes.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';
                  } else { //close to end; only hide early pages
                     $pagination .= '<li><a href="obequizzes.php?page=1'.$sqlstring.'">1</a></li>';
                     $pagination .= '<li><a href="obequizzes.php?page=2'.$sqlstring.'">2</a></li>';
                     $pagination .= '<li><a href="obequizzes.php?page=3'.$sqlstring.'">3</a></li>';
                     $pagination .= '<li><a href="#"> ... </a></li>';
                     for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page) {
                           $pagination .= '<li class="active"><a href="">'.$counter.'</a></li>';
                        } else {
                           $pagination .= '<li><a href="obequizzes.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
                        }
                     }
                  }
               }
               //next button
               if ($page < $counter - 1) {
                  $pagination .= '<li><a href="obequizzes.php?page='.$next.$sqlstring.'">Next</a></li>';
               } else {
                  $pagination .= "";
               }
               echo $pagination;
            }
            echo '
            </ul>
            <!--WI_PAGINATION-->
            <div class="clearfix"></div>
         </div>';
      }
   } else {
      echo '
      <div class="col-lg-12">
         <div class="widget-tabs-notification">No Result Found</div>
      </div>';
   }
}
