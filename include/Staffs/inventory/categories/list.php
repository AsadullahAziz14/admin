<?php
if(!LMS_VIEW && !isset($_GET['id'])) {  
   $queryCategory  = $dblms->querylms("SELECT category_id, category_code, category_name,
                                       category_description, category_status
                                       FROM ".SMS_CATEGORIES." 
                                       WHERE category_id != ''
                                       $sql2
                                       ORDER BY category_id DESC LIMIT ".($page-1)*$Limit .",$Limit");
   echo'    
	   <div style="clear:both;"></div>
         <table class="footable table table-bordered table-hover">
            <thead>
               <tr>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Sr.# </th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Category Code </th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Category Name </th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Description </th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Status</th>
                  <th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
               </tr>
            </thead>
            <tbody>';
            $srno = 0;
            while($valueCategory = mysqli_fetch_array($sqllms)) {
               $ctystatus = get_status($valueCategory['category_status']);
               $srno++;
               echo '
               <tr>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.$valueCategory['category_name'].'</td>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.$valueCategory['category_code'].'</td>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.$valueCategory['category_description'].'</td>
                  <td nowrap="nowrap" style="width:70px; text-align:center;">'.get_status($valueCategory['category_status']).'</td>
                  <td nowrap="nowrap" style="text-align:center;">
                     <a class="btn btn-xs btn-info" href="inventory-categories.php?id='.$valueCategory['category_id'].'"><i class="icon-pencil"></i></a>
                     <a href="?deleteId='.$valueCategory['category_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>
                  </td>
               </tr>';
            }
            echo '
            </tbody>
         </table>'; 
}