<?php
if(!LMS_VIEW && !isset($_GET['id'])) {
   $page = (int)$page;
   $sql2 = '';
   $sqlstring = "";
   $search_term = (isset($_REQUEST['search_term']) && $_REQUEST['search_term'] != '') ? $_REQUEST['search_term'] : '';
   $searchFeild = (isset($_REQUEST['searchFeild']) && $_REQUEST['searchFeild'] != '') ? $_REQUEST['searchFeild'] : '';
   $searchOP = (isset($_REQUEST['searchOP']) && $_REQUEST['searchOP'] != '') ? $_POST['searchOP'] : '';
   $type = (isset($_GET['type']) && $_GET['type'] != '') ? $_GET['type'] : '';
   $category = (isset($_GET['category']) && $_GET['category'] != '') ? $_GET['category'] : '';

   if(isset($_GET['srch'])) {
      $srch = $_GET['srch'];
      $stdsrch	= $srch;
      $sql2 = "AND pac_number LIKE '".$stdsrch."%'";
      $sqlstring	= "&srch=".$stdsrch."";
   } else {
      $srch = "";
      $sqlstring	= "";
      $sql2 = '';
   }

   if(!($Limit)) 	{ $Limit = 50; } 
   if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}

   $queryPAC = $dblms->querylms("SELECT pac_id
                                    FROM ".OBE_PACS." 
                                    WHERE pac_id != ''
                                    $sql2
                              ");
   $count = mysqli_num_rows($queryPAC);
   if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
   $prev = $page - 1;							      //previous page is page - 1
   $next = $page + 1;							      //next page is page + 1
   $lastpage	= ceil($count/$Limit);				//lastpage is = total pages / items per page, rounded up.
   $lpm1 = $lastpage - 1;

   if(mysqli_num_rows($queryPAC) > 0) {
      $queryPAC = $dblms->querylms("SELECT pac_id, pac_status, pac_number, pac_statement, id_prg 
                                       FROM ".OBE_PACS." 
                                       WHERE pac_id != ''
                                       $sql2
                                       ORDER BY pac_id DESC LIMIT ".($page-1)*$Limit .",$Limit
                                 ");
         
      include ("include/page_title.php"); 
      echo'    
      <div class="table-responsive" style="overflow: auto;">
         <table class="footable table table-bordered table-hover table-with-avatar">
            <thead>
               <tr>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Sr.#</th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> PAC Number</th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Statement</th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Program</th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Status</th>
                  <th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
               </tr>
            </thead>
            <tbody>';
      $srno = 0;
      while($valuePAC = mysqli_fetch_array($queryPAC)) {
         $srno++;
         $canEdit = ' ';
         if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'edit' => '1'))) { 
            $canEdit = '<a class="btn btn-xs btn-info" href="obepacs.php?id='.$valuePAC['pac_id'].'"><i class="icon-pencil"></i></a>';
         }

         $canDelete = ' ';
         if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'delete' => '1'))) { 
            $canDelete =  '<a href="?deleteId='.$valuePAC['pac_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>';
         }
         echo '
               <tr>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.$valuePAC['pac_number'].'</td>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.$valuePAC['pac_statement'].'</td>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.ID_PRG_ARRAY[$valuePAC['id_prg']].'</td>
                  <td nowrap="nowrap" style="width:70px; text-align:center;">'.get_status($valuePAC['pac_status']).'</td>
                  <td style="text-align:center;">'.$canEdit.$canDelete;
                  echo '</td>
               </tr>';
            }
            echo '
            </tbody>
         </table>';
      if($count > $Limit) {
         echo '
         <div class="widget-foot">
         <!--WI_PAGINATION-->
         <ul class="pagination pull-right">';

         $pagination = "";
         if($lastpage > 1) {	
            //previous button
            if ($page > 1) {
               $pagination.= '<li><a href="obepacs.php?page='.$prev.$sqlstring.'">Prev</a></li>';
            }
            //pages	
            if ($lastpage < 7 + ($adjacents * 3)) {	
               //not enough pages to bother breaking it up
               for ($counter = 1; $counter <= $lastpage; $counter++) {
                  if ($counter == $page) {
                     $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                  } else {
                     $pagination.= '<li><a href="obepacs.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
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
                        $pagination.= '<li><a href="obepacs.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
                     }
                  }
                  $pagination.= '<li><a href="#"> ... </a></li>';
                  $pagination.= '<li><a href="obepacs.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
                  $pagination.= '<li><a href="obepacs.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
               } else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
                     $pagination.= '<li><a href="obepacs.php?page=1'.$sqlstring.'">1</a></li>';
                     $pagination.= '<li><a href="obepacs.php?page=2'.$sqlstring.'">2</a></li>';
                     $pagination.= '<li><a href="obepacs.php?page=3'.$sqlstring.'">3</a></li>';
                     $pagination.= '<li><a href="#"> ... </a></li>';
                  for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                     if ($counter == $page) {
                        $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                     } else {
                        $pagination.= '<li><a href="obepacs.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
                     }
                  }
                  $pagination.= '<li><a href="#"> ... </a></li>';
                  $pagination.= '<li><a href="obepacs.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
                  $pagination.= '<li><a href="obepacs.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
               } else { //close to end; only hide early pages
                  $pagination.= '<li><a href="obepacs.php?page=1'.$sqlstring.'">1</a></li>';
                  $pagination.= '<li><a href="obepacs.php?page=2'.$sqlstring.'">2</a></li>';
                  $pagination.= '<li><a href="obepacs.php?page=3'.$sqlstring.'">3</a></li>';
                  $pagination.= '<li><a href="#"> ... </a></li>';
                  for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
                     if ($counter == $page) {
                        $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                     } else {
                        $pagination.= '<li><a href="obepacs.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
                     }
                  }
               }
            }
            //next button
            if ($page < $counter - 1) {
               $pagination.= '<li><a href="obepacs.php?page='.$next.$sqlstring.'">Next</a></li>';
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
   }
   else {
      echo '
      <div class="col-lg-12">
         <div class="widget-tabs-notification">No Result Found</div>
      </div>';
   }
}