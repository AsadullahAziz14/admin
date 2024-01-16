<?php
if(!LMS_VIEW && !isset($_GET['id'])) {  
   $queryDemand = $dblms->querylms("SELECT demand_id, demand_status, demand_code, demand_type,
                                             demand_quantity, demand_date, demand_due_date, forwarded_by,
                                             forwarded_to, id_department, id_added, date_forwarded
                                          FROM ".SMS_DEMAND." 
                                          WHERE demand_id != ''
                                          $sql2
                                    ");
   echo'    
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
         $srno = 0;
         while($valueDemand = mysqli_fetch_array($queryDemand)) {
            $srno++;
            echo '
            <tr>
               <td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
               <td style="vertical-align: middle;" nowrap="nowrap">'.$valueDemand['demand_code'].'</td>
               <td style="vertical-align: middle;" nowrap="nowrap">'.DEMAND_TYPES[$valueDemand['demand_type']].'</td>
               <td style="vertical-align: middle;" nowrap="nowrap">'.$valueDemand['demand_quantity'].'</td>
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
               <td nowrap="nowrap" style="width:70px; text-align:center;">'.get_status($valueDemand['demand_status']).'</td>
               <td nowrap="nowrap" style="text-align:center;">
                  <a class="btn btn-xs btn-warning view-demand-modal" data-toggle="modal" data-target="#viewDemandModal" 
                     data-modal-window-title="Demand Details" data-height="350" data-width="100%" 
                     data-demand-id="'.$valueDemand['demand_id'].'" data-demand-status="'.$valueDemand['demand_status'].'" 
                     data-demand-code="'.$valueDemand['demand_code'].'" data-demand-type="'.$valueDemand['demand_type'].'"
                     data-demand-quantity="'.$valueDemand['demand_quantity'].'" data-demand-date="'.$valueDemand['demand_date'].'"
                     data-demand-due-date="'.$valueDemand['demand_due_date'].'" data-forwarded-by="'.$valueDemand['forwarded_by'].'"
                     data-forwarded-to="'.$valueDemand['forwarded_to'].'" data-id-department="'.$valueDemand['id_department'].'"
                     data-date-forwarded="'.$valueDemand['date_forwarded'].'"
                     >
                     <i class="icon-zoom-in"></i>
                  </a>
                  <a class="btn btn-xs btn-info" href="inventory-demand.php?id='.$valueDemand['demand_id'].'"><i class="icon-pencil"></i></a>
                  <a href="?deleteId='.$valueDemand['demand_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>
               </td>
            </tr>';
         }
         echo '
         </tbody>
      </table>
   </div>';
}