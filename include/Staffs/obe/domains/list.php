<?php
if(!LMS_VIEW && !isset($_GET['id'])) {

$adjacents 	= 3;
if(!($Limit)) { $Limit = 100; } 
if($page) { $start = ($page - 1) * $Limit; } else {	$start = 0;	}
$page = (int)$page;

$queryDomain  = $dblms->querylms("SELECT domain_id
                                 FROM ".OBE_DOMAINS."
                                 WHERE domain_id != ''
                                 $sql2
                                 ");
$count 		= mysqli_num_rows($queryDomain);
if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
$prev 		= $page - 1;							//previous page is page - 1
$next 		= $page + 1;							//next page is page + 1
$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
$lpm1 		= $lastpage - 1;

if(mysqli_num_rows($queryDomain) > 0) {     
   $queryDomain  = $dblms->querylms("SELECT domain_id, domain_name, id_prg, domain_status
                              FROM ".OBE_DOMAINS."
                              WHERE domain_id != ''
                              $sql2
                              ORDER BY domain_id DESC 
                              LIMIT ".($page-1)*$Limit .",$Limit");                         
   echo'    
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
               <th style="vertical-align: middle;" nowrap="nowrap"> Domain Name</th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Programs</th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Status</th>
               <th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
            </tr>
         </thead>
         <tbody>';
         if($page == 1) { $srno = 0; } else { $srno = ($Limit * ($page-1));}

         while($valueDomain = mysqli_fetch_array($queryDomain)) {
            $srno++;

            $canEdit = ' ';
            if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'edit' => '1'))) { 
               $canEdit = '<a class="btn btn-xs btn-info" href="obedomains.php?id='.$valueDomain['domain_id'].'"><i class="icon-pencil"></i></a>';
            }

            $canDelete = ' ';
            if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'delete' => '1'))) { 
               $canDelete =  ' <a class="btn btn-xs btn-danger delete-domain-modal bootbox-confirm" href="obedomains.php?id='.$valueDomain['domain_id'].'&view=delete" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a>';
            }

            echo '
            <tr>
               <td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
               <td style="vertical-align: middle;" nowrap="nowrap">'.$valueDomain['domain_name'].'</td>
               ';
               $queryPRG  = $dblms->querylms("SELECT GROUP_CONCAT(prg_name) as prg_name
                                                   FROM ".PROGRAMS."
                                                   WHERE prg_id IN (".$valueDomain['id_prg'].")
                                                ");
               $valuePRG = mysqli_fetch_array($queryPRG);
               echo '
               <td style="vertical-align: middle;" nowrap="nowrap">'.$valuePRG['prg_name']  .'</td>
               <td style="vertical-align: middle;" nowrap="nowrap" style="width:70px; text-align:center;">'.get_status($valueDomain['domain_status']).'</td>
               <td style="text-align:center;">'.$canEdit.$canDelete;
                  echo '
               </td>
            </tr>';
         } // End while loop

         echo '
         </tbody>
      </table>';
   if($count>$Limit) {
      echo '
      <div class="widget-foot">
         <!--WI_PAGINATION-->
         <ul class="pagination pull-right">';

         $pagination = "";
         
         if($lastpage > 1) {	
         //previous button
         if ($page > 1) {
            $pagination.= '<li><a href="obedomains.php?page='.$prev.$sqlstring.'">Prev</a></li>';
         }
         //pages	
         if ($lastpage < 7 + ($adjacents * 3)) {	
            //not enough pages to bother breaking it up
            for ($counter = 1; $counter <= $lastpage; $counter++) {
               if ($counter == $page) {
                  $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
               } else {
                  $pagination.= '<li><a href="obedomains.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
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
                     $pagination.= '<li><a href="obedomains.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
                  }
               }
               $pagination.= '<li><a href="#"> ... </a></li>';
               $pagination.= '<li><a href="obedomains.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
               $pagination.= '<li><a href="obedomains.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
            } else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
                  $pagination.= '<li><a href="obedomains.php?page=1'.$sqlstring.'">1</a></li>';
                  $pagination.= '<li><a href="obedomains.php?page=2'.$sqlstring.'">2</a></li>';
                  $pagination.= '<li><a href="obedomains.php?page=3'.$sqlstring.'">3</a></li>';
                  $pagination.= '<li><a href="#"> ... </a></li>';
               for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                  if ($counter == $page) {
                     $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                  } else {
                     $pagination.= '<li><a href="obedomains.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
                  }
               }
               $pagination.= '<li><a href="#"> ... </a></li>';
               $pagination.= '<li><a href="obedomains.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
               $pagination.= '<li><a href="obedomains.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
            } else { //close to end; only hide early pages
               $pagination.= '<li><a href="obedomains.php?page=1'.$sqlstring.'">1</a></li>';
               $pagination.= '<li><a href="obedomains.php?page=2'.$sqlstring.'">2</a></li>';
               $pagination.= '<li><a href="obedomains.php?page=3'.$sqlstring.'">3</a></li>';
               $pagination.= '<li><a href="#"> ... </a></li>';
               for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
                  if ($counter == $page) {
                     $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                  } else {
                     $pagination.= '<li><a href="obedomains.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
                  }
               }
            }
         }
         //next button
         if ($page < $counter - 1) {
            $pagination.= '<li><a href="obedomains.php?page='.$next.$sqlstring.'">Next</a></li>';
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
               