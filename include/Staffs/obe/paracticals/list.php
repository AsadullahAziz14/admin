<?php
if(!LMS_VIEW && !isset($_GET['id'])) {
   $page = (int)$page;
   $sql2 = '';
   $sqlstring = "";
   $search_term = (isset($_REQUEST['search_term'])  && $_REQUEST['search_term'] != '')  ? $_REQUEST['search_term']  : '';
   $searchFeild = (isset($_REQUEST['searchFeild'])  && $_REQUEST['searchFeild'] != '')  ? $_REQUEST['searchFeild']  : '';
   $searchOP = (isset($_REQUEST['searchOP'])     && $_REQUEST['searchOP'] != '')     ? $_POST['searchOP']        : '';

   if(isset($_GET['srch'])) {
      $srch = $_GET['srch'];
      $stdsrch = $srch;
      $sql2 = "AND pp_number LIKE '".$stdsrch."%'";
      $sqlstring = "&srch=".$stdsrch."";
   } else {
      $srch = "";
      $sqlstring = "";
      $sql2 = '';
   }

   if(!($Limit)) 	{ $Limit = 50; } 
   if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}

   $queryParactical = $dblms->querylms("SELECT pp_id 
                                       FROM ".OBE_PARACTICAL_PERFORMANCES." 
                                       WHERE id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg= ".ID_PRG." AND semester = ".SEMESTER." AND section  = '".SECTION."' AND timing= ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus =  ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                              ");

   $count = mysqli_num_rows($queryParactical);
   if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
   $prev = $page - 1;							//previous page is page - 1
   $next = $page + 1;							//next page is page + 1
   $lastpage = ceil($count/$Limit);				//lastpage is = total pages / items per page, rounded up.
   $lpm1 = $lastpage - 1;

   if(mysqli_num_rows($queryParactical) > 0) {
      $queryParactical = $dblms->querylms("SELECT pp_id, pp_status, pp_number, pp_marks, pp_date, id_kpi, 
                                              id_teacher, id_course, id_prg, semester, semester, section,
                                              timing, academic_session, id_campus
                                                FROM ".OBE_PARACTICAL_PERFORMANCES." 
                                                WHERE id_teacher = ".ID_TEACHER." AND id_course = ".ID_COURSE." AND id_prg= ".ID_PRG." AND semester = ".SEMESTER." AND section  = '".SECTION."' AND timing= ".TIMING." AND academic_session = '".ACADEMIC_SESSION."' AND id_campus =  ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."
                                                ORDER BY pp_id DESC LIMIT ".($page-1)*$Limit .",$Limit
                                    ");
      include ("include/page_title.php"); 
      echo'
      <div class="table-responsive" style="overflow: auto;">
         <table class="footable table table-bordered table-hover table-with-avatar">
            <thead>
            <tr>
               <th style="vertical-align: middle;" nowrap="nowrap"> Sr.#</th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Paractical No.</th>
               <th style="vertical-align: middle;" nowrap="nowrap"> KPI No.</th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Teacher</th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Course</th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Program</th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Semester</th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Section</th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Academic Session</th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Paractical Date</th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Marks</th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Status</th>
               <th style="width:70px; text-align:center; font-size:14px;">Paractical  Actions</th>
               <th style="width:70px; text-align:center; font-size:14px;">Result Actions</th>
            </tr>
            </thead>
            <tbody>';
            $srno = 0;
            while($valueParactical = mysqli_fetch_array($queryParactical)) {
               $srno++;
               if($valueParactical['id_kpi'] != '') {
                  $queryKPI = $dblms->querylms('SELECT GROUP_CONCAT(kpi_number) AS kpiNumbers, GROUP_CONCAT(id_clo) AS clo_ids
                                                   FROM '.OBE_KPIS.' 
                                                   WHERE kpi_id IN ('.$valueParactical['id_kpi'].')');
                  $valueKPI = mysqli_fetch_array($queryKPI); 
               }
               else {
                  $valueKPI['kpiNumbers'] = '';
               }

               $canEditParactical = ' ';
               if (($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'edit' => '1'))) {
                  $canEditParactical = '<a class="btn btn-xs btn-info" href="obeparacticals.php?id='.$valueParactical['mt_id'].'"><i class="icon-pencil"></i></a>';
               }
      
               $canDeleteParactical = ' ';
               if (($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'delete' => '1'))) {
                  $canDeleteParactical = '<a href="?deleteParacticalId='.$valueParactical['mt_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>';
               }
      
               $canAddResult = ' ';
               if (($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'print' => '1'))) {
                  $canAddResult = '<a class="btn btn-xs btn-info" href="obeparacticals.php?view=addresult&id='.$valueParactical['pp_id'].'"><i class="icon-plus"></i></a>
                  ';
               }
      
               $canEditResult = ' ';
               if (($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'edit' => '1'))) {
                  $canEditResult = '<a class="btn btn-xs btn-info" href="obeparacticals.php?view=editresult&id='.$valueParactical['pp_id'].'"><i class="icon-pencil"></i></a>';
               }

               $canViewResult = ' ';
               if (($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'delete' => '1'))) {
                  $canViewResult = '<a class="btn btn-xs btn-info" href="obeparacticals.php?view=report&id='.$valueParactical['pp_id'].'"><i class="icon-eye-open"></i></a>';
               }
      
               $canDeleteResult = ' ';
               if (($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'delete' => '1'))) {
                  $canDeleteResult = '<a href="?deleteresultId='.$valueParactical['pp_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>';
               }
               echo '
                  <form class="form-horizontal" action="obeparacticals.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                     <tr>
                        <td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
                        <td style="vertical-align: middle;" nowrap="nowrap">'.$valueParactical['pp_number'].'</td>
                        <td style="vertical-align: middle;" nowrap="nowrap">'.$valueKPI['kpiNumbers'].'</td>
                        <td style="vertical-align: middle;" nowrap="nowrap">'.ID_TEACHER_ARRAY[$valueParactical['id_teacher']].'</td>
                        <td style="vertical-align: middle;" nowrap="nowrap">'.ID_COURSE_ARRAY[$valueParactical['id_course']].'</td>
                        <td style="vertical-align: middle;" nowrap="nowrap">'.ID_PRG_ARRAY[$valueParactical['id_prg']].'</td>
                        <td style="vertical-align: middle;" nowrap="nowrap">'.SEMESTER_ARRAY[$valueParactical['semester']].'</td>
                        <td style="vertical-align: middle;" nowrap="nowrap"> '.$valueParactical['section'].'</td>
                        <td style="vertical-align: middle;" nowrap="nowrap">'.$valueParactical['academic_session'].'</td>
                        <td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($valueParactical['pp_date'])).'</td>
                        <td style="vertical-align: middle;" nowrap="nowrap">'.$valueParactical['pp_marks'].'</td>
                        <td style="vertical-align: middle; width:70px; text-align:center;" nowrap="nowrap">'.get_status($valueParactical['pp_status']).'</td>
                        <td style="vertical-align: middle; text-align:center;" nowrap="nowrap">
                           '.$canEditParactical.'
                           '.$canDeleteParactical.' 
                        </td>
                        <td style="vertical-align: middle; width:70px; text-align:center;" nowrap="nowrap">
                           '.$canAddResult.'
                           '.$canEditResult.'
                           '.$canViewResult.'
                           '.$canDeleteResult.'
                        </td>
                     </tr>
                  </form>';
            }
            echo '
            </tbody>
         </table>
      </div>';
      if($count > $Limit) 
      {
         echo '
         <div class="widget-foot">
         <!--WI_PAGINATION-->
         <ul class="pagination pull-right">';

         $pagination = "";
         if($lastpage > 1) 
         {	
            //previous button
            if ($page > 1) {
               $pagination.= '<li><a href="obekpis.php?page='.$prev.$sqlstring.'">Prev</a></li>';
            }
            //pages	
            if ($lastpage < 7 + ($adjacents * 3)) {	
               //not enough pages to bother breaking it up
               for ($counter = 1; $counter <= $lastpage; $counter++) {
                  if ($counter == $page) {
                     $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                  } else {
                     $pagination.= '<li><a href="obekpis.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
                  }
               }
            } else if($lastpage > 5 + ($adjacents * 3))	{ 
               //enough pages to hide some
               //close to beginning; only hide later pages
               if($page < 1 + ($adjacents * 3)) {
                  for ($counter = 1; $counter < 4 + ($adjacents * 3); $counter++)	{
                     if ($counter == $page) {
                        $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                     } else {
                        $pagination.= '<li><a href="obekpis.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
                     }
                  }
                  $pagination.= '<li><a href="#"> ... </a></li>';
                  $pagination.= '<li><a href="obekpis.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
                  $pagination.= '<li><a href="obekpis.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
               } else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
                     $pagination.= '<li><a href="obekpis.php?page=1'.$sqlstring.'">1</a></li>';
                     $pagination.= '<li><a href="obekpis.php?page=2'.$sqlstring.'">2</a></li>';
                     $pagination.= '<li><a href="obekpis.php?page=3'.$sqlstring.'">3</a></li>';
                     $pagination.= '<li><a href="#"> ... </a></li>';
                  for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                     if ($counter == $page) {
                        $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                     } else {
                        $pagination.= '<li><a href="obekpis.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
                     }
                  }
                  $pagination.= '<li><a href="#"> ... </a></li>';
                  $pagination.= '<li><a href="obekpis.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
                  $pagination.= '<li><a href="obekpis.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
               } else { //close to end; only hide early pages
                  $pagination.= '<li><a href="obekpis.php?page=1'.$sqlstring.'">1</a></li>';
                  $pagination.= '<li><a href="obekpis.php?page=2'.$sqlstring.'">2</a></li>';
                  $pagination.= '<li><a href="obekpis.php?page=3'.$sqlstring.'">3</a></li>';
                  $pagination.= '<li><a href="#"> ... </a></li>';
                  for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
                     if ($counter == $page) {
                        $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                     } else {
                        $pagination.= '<li><a href="obekpis.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
                     }
                  }
               }
            }
            //next button
            if ($page < $counter - 1) {
               $pagination.= '<li><a href="obekpis.php?page='.$next.$sqlstring.'">Next</a></li>';
            } else {
               $pagination.= "";
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