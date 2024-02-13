<?php
if(!LMS_VIEW && !isset($_GET['id'])) { 
   $adjacents 	= 3;
   if(!($Limit)) { $Limit = 100; } 
   if($page) { $start = ($page - 1) * $Limit; } else {	$start = 0;	}
   $page = (int)$page;

   $queryDemand = $dblms->querylms("SELECT demand_id
                                          FROM ".SMS_DEMAND." 
                                          WHERE demand_id != ''
                                    ");
   $count 		= mysqli_num_rows($queryDemand);
   if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
   $prev 		= $page - 1;							//previous page is page - 1
   $next 		= $page + 1;							//next page is page + 1
   $lastpage	= ceil($count/$Limit);				//lastpage is = total pages / items per page, rounded up.
   $lpm1 		= $lastpage - 1;

   if(mysqli_num_rows($queryDemand) > 0) {
      $queryDemand = $dblms->querylms("SELECT demand_id, demand_status, demand_code, demand_type,
                                                demand_date, demand_due_date, forwarded_by,
                                                forwarded_to, id_department, id_added, date_forwarded
                                             FROM ".SMS_DEMAND." 
                                             WHERE demand_id != ''
                                             $sql2
                                             LIMIT ".($page-1)*$Limit .",$Limit
                                       ");
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
                  <th style="vertical-align: middle;" nowrap="nowrap"> Sr.# </th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Demand Code </th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Demand Type </th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Demand Quantity </th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Demand Date </th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Due Date </th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Demand Department </th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Added By </th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Status</th>
                  <th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
               </tr>
            </thead>
            <tbody>';
               if($page == 1) { $srno = 0; } else { $srno = ($Limit * ($page-1));}
            while($valueDemand = mysqli_fetch_array($queryDemand)) {
               $srno++;
               echo '
               <tr>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.$valueDemand['demand_code'].'</td>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.DEMAND_TYPES[$valueDemand['demand_type']].'</td>
                  <td style="vertical-align: middle;" nowrap="nowrap"></td>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($valueDemand['demand_date'])).'</td>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($valueDemand['demand_due_date'])).'</td>';
                  $queryDepartments = $dblms->querylms("SELECT dept_name
                                                         FROM ".DEPARTMENTS." 
                                                         WHERE dept_id = ".$valueDemand['id_department']."
                                                      ");
                  $valueDepartments = mysqli_fetch_array($queryDepartments);
                  echo '<td style="vertical-align: middle;" nowrap="nowrap">'.$valueDepartments['dept_name'].'</td>';
                  $queryEmployees  = $dblms->querylms("SELECT emply_id, emply_name
                                                         FROM ".EMPLOYEES." 
                                                         WHERE emply_id = ".$valueDemand['id_added']."
                                                      ");
                  $valueEmployees = mysqli_fetch_array($queryEmployees);
                  echo '
                  <td style="vertical-align: middle;" nowrap="nowrap">'.$valueEmployees['emply_name'].'</td>
                  <td nowrap="nowrap" style="width:70px; text-align:center;">'.get_sms_status($valueDemand['demand_status']).'</td>
                  <td nowrap="nowrap" style="text-align:center;">
                     <a class="btn btn-xs btn-warning view-demand-modal" data-toggle="modal" data-target="#viewDemandModal" 
                        data-modal-window-title="Demand Details" data-height="350" data-width="100%" 
                        data-demand-id="'.$valueDemand['demand_id'].'" data-demand-status="'.$valueDemand['demand_status'].'" 
                        data-demand-code="'.$valueDemand['demand_code'].'" data-demand-type="'.$valueDemand['demand_type'].'"
                        data-demand-date="'.$valueDemand['demand_date'].'"
                        data-demand-due-date="'.$valueDemand['demand_due_date'].'" data-forwarded-by="'.$valueDemand['forwarded_by'].'"
                        data-forwarded-to="'.$valueDemand['forwarded_to'].'" data-id-department="'.$valueDemand['id_department'].'"
                        data-date-forwarded="'.$valueDemand['date_forwarded'].'"
                        >
                        <i class="icon-zoom-in"></i>
                     </a>
                     ';
                     if($valueDemand['demand_status'] <= 1) {
                        echo '
                        <a class="btn btn-xs btn-info" href="inventory-demand.php?id='.$valueDemand['demand_id'].'"><i class="icon-pencil"></i></a>
                        <a href="?deleteId='.$valueDemand['demand_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>';
                     }
                     echo '
                  </td>
               </tr>';
            }
            echo '
            </tbody>
         </table>
      </div>';
      if($count > $Limit) {
         echo '
         <div class="widget-foot">
            <!--WI_PAGINATION-->
            <ul class="pagination pull-right">';
   
            $pagination = "";
            
            if($lastpage > 1) {	
   
               //previous button
               if ($page > 1) {
                  $pagination.= '<li><a href="inventory-demand.php?page='.$prev.$sqlstring.'">Prev</a></li>';
               }
               //pages	
               if ($lastpage < 7 + ($adjacents * 3)) {	
                  //not enough pages to bother breaking it up
                  for ($counter = 1; $counter <= $lastpage; $counter++) {
                     if ($counter == $page) {
                        $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                     } else {
                        $pagination.= '<li><a href="inventory-demand.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
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
                           $pagination.= '<li><a href="inventory-demand.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
                        }
                     }
                     $pagination.= '<li><a href="#"> ... </a></li>';
                     $pagination.= '<li><a href="inventory-demand.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
                     $pagination.= '<li><a href="inventory-demand.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
                  } else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
                        $pagination.= '<li><a href="inventory-demand.php?page=1'.$sqlstring.'">1</a></li>';
                        $pagination.= '<li><a href="inventory-demand.php?page=2'.$sqlstring.'">2</a></li>';
                        $pagination.= '<li><a href="inventory-demand.php?page=3'.$sqlstring.'">3</a></li>';
                        $pagination.= '<li><a href="#"> ... </a></li>';
                     for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page) {
                           $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                        } else {
                           $pagination.= '<li><a href="inventory-demand.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
                        }
                     }
                     $pagination.= '<li><a href="#"> ... </a></li>';
                     $pagination.= '<li><a href="inventory-demand.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
                     $pagination.= '<li><a href="inventory-demand.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
                  } else { //close to end; only hide early pages
                     $pagination.= '<li><a href="inventory-demand.php?page=1'.$sqlstring.'">1</a></li>';
                     $pagination.= '<li><a href="inventory-demand.php?page=2'.$sqlstring.'">2</a></li>';
                     $pagination.= '<li><a href="inventory-demand.php?page=3'.$sqlstring.'">3</a></li>';
                     $pagination.= '<li><a href="#"> ... </a></li>';
                     for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page) {
                           $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                        } else {
                           $pagination.= '<li><a href="inventory-demand.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
                        }
                     }
                  }
               }
            //next button
            if ($page < $counter - 1) {
               $pagination.= '<li><a href="inventory-demand.php?page='.$next.$sqlstring.'">Next</a></li>';
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