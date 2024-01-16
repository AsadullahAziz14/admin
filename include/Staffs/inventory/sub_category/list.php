<?php

if(!LMS_VIEW && !isset($_GET['id'])) {  
   $querySubCategory  = $dblms->querylms("SELECT sub_category_id, sub_category_code, sub_category_name, 
                                                   sub_category_description, sub_category_status, id_category
                                             FROM ".SMS_SUB_CATEGORIE." 
                                             WHERE sub_category_id != ''
                                             $sql2
                                       ");
   include ("include/page_title.php"); 

   echo'    
   <div class="table-responsive" style="overflow: auto;">
      <table class="footable table table-bordered table-hover table-with-avatar">
         <thead>
            <tr>
               <th style="vertical-align: middle;" nowrap="nowrap"> Sr.# </th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Sub-Category Code </th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Sub-Category Name </th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Category </th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Description </th>
               <th style="vertical-align: middle;" nowrap="nowrap"> Status</th>
               <th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
            </tr>
         </thead>
         <tbody>';
            $srno = 0;
            while($valueSubCategory = mysqli_fetch_array($querySubCategory)) {
               $srno++;
               echo '
               <tr>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.$valueSubCategory['sub_category_name'].'</td>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.$valueSubCategory['sub_category_code'].'</td>
                  '; 
                  $queryCategory = $dblms->querylms("SELECT category_id, category_name 
                                                      FROM " .SMS_CATEGORIE." 
                                                      WHERE category_id = ".$valueSubCategory['id_category']."");
                  $valueCategory = mysqli_fetch_array($queryCategory);
                  echo '
                  <td style="vertical-align: middle;" nowrap="nowrap">'.$valueCategory['category_name'].'</td>
                  <td style="vertical-align: middle;" nowrap="nowrap">'.$valueSubCategory['sub_category_description'].'</td>
                  <td nowrap="nowrap" style="width:70px; text-align:center;">'.get_status($valueSubCategory['sub_category_status']).'</td>
                  <td nowrap="nowrap" style="text-align:center;">
                     <a class="btn btn-xs btn-info" href="inventory-sub_category.php?id='.$valueSubCategory['sub_category_id'].'"><i class="icon-pencil"></i></a>
                     <a href="?deleteId='.$valueSubCategory['sub_category_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>
                  </td>
               </tr>';
            }
            echo '
         </tbody>
      </table>
   </div>  
   '; 
}