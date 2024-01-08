<?php
if(!LMS_VIEW && !isset($_GET['id'])) {  
   if(!($Limit)) 	{ $Limit = 50; } 
   if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
      
   $queryIssuance  = $dblms->querylms("SELECT issuance_id, issuance_code, issuance_date, issuance_to, issuance_by,
                                              issuance_remarks, issuance_status 
                                       FROM ".SMS_ITEM_ISSUANCES." 
                                       WHERE issuance_id != ''
                                       $sql2
                                       ");
      
   include ("include/page_title.php"); 

   echo'    
   <div class="table-responsive" style="overflow: auto;">
      <table class="footable table table-bordered table-hover table-with-avatar">
         <thead>
            <tr>
               <th style="vertical-align: middle;" nowrap="nowrap"> Sr.# </th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Issuance Code</th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Issuance Date </th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Items Issued </th>
               <!-- <th style="vertical-align: middle;" nowrap="nowrap"> Issued Quantity </th> -->
               <th style="vertical-align: middle;" nowrap="nowrap"> Issued To </th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Issued By </th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Remarks </th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Status</th>
               <th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
            </tr>
         </thead>
         <tbody>';
            $srno = 0;
            
            while($valueIssuance = mysqli_fetch_array($queryIssuance)) {
               $srno++;
               echo '
               <tr>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.$valueIssuance['issuance_code'].'</td>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.$valueIssuance['issuance_date'].'</td>'; 
                  
                  $queryIssuanceItemJunction = $dblms->querylms("SELECT GROUP_CONCAT(item_title) as item_title
                                                                     FROM ".SMS_ITEMS." it,".SMS_ISSUANCE_ITEM_JUNCTION." itemj  
                                                                     WHERE itemj.id_item = it.item_id
                                                                     AND itemj.id_issuance = ".$valueIssuance['issuance_id']."");
                  $valueIssuanceItemJunction = mysqli_fetch_array($queryIssuanceItemJunction);
                  echo '<td style="vertical-align: middle;" nowrap="nowrap">'.$valueIssuanceItemJunction['item_title'].'</td>';
                  
                  $queryEmployees = $dblms->querylms("Select emply_id, emply_name
                                                      From ".EMPLOYEES."
                                                      Where emply_id IN (".$valueIssuance['issuance_to'].")
                                                   ");
                  $valueEmployees = mysqli_fetch_array($queryEmployees);
                  echo '<td style="vertical-align: middle;" nowrap="nowrap">'.$valueEmployees['emply_name'].'</td>';
                  $queryEmployees = $dblms->querylms("Select emply_id, emply_name
                                                      From ".EMPLOYEES."
                                                      Where emply_id IN (".$valueIssuance['issuance_by'].")
                                                   ");
                  $valueEmployees = mysqli_fetch_array($queryEmployees);
                  echo '
                  <td style="vertical-align: middle;" nowrap="nowrap">'.$valueEmployees['emply_name'].'</td>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.$valueIssuance['issuance_remarks'].'</td>
                  <td nowrap="nowrap" style="width:70px; text-align:center;">'.get_status($valueIssuance['issuance_status']).'</td>
                  <td nowrap="nowrap" style="text-align:center;">
                     <a class="btn btn-xs btn-info" href="inventory-issuance.php?id='.$valueIssuance['issuance_id'].'"><i class="icon-pencil"></i></a>
                     <a href="?deleteId='.$valueIssuance['issuance_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>
                  </td>
               </tr>';
            }
            echo '
         </tbody>
      </table>
   </div> '; 
}