<?php
$adjacents 	= 3;
if(!($Limit)) { $Limit = 100; } 
if($page) { $start = ($page - 1) * $Limit; } else {	$start = 0;	}
$page = (int)$page;

$queryCategory = $dblms->querylms("SELECT sub_category_id, sub_category_code, sub_category_name, 
                                          sub_category_description, sub_category_status, id_category
                                    FROM ".SMS_SUB_CATEGORY." 
                                    WHERE sub_category_id != ''
                                    $sql2
                                    LIMIT ".($page-1)*$Limit .",$Limit");

$count 		= mysqli_num_rows($queryCategory);
if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
$prev 		= $page - 1;							//previous page is page - 1
$next 		= $page + 1;							//next page is page + 1
$lastpage	= ceil($count/$Limit);				//lastpage is = total pages / items per page, rounded up.
$lpm1 		= $lastpage - 1;

if(mysqli_num_rows($queryCategory) > 0) { 
   $querySubCategory  = $dblms->querylms("SELECT sub_category_id, sub_category_code, sub_category_name, 
                                                   sub_category_description, sub_category_status, id_category
                                             FROM ".SMS_SUB_CATEGORY." 
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
                                                      FROM " .SMS_CATEGORY." 
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
   </div>  '; 
   if($count>$Limit) {
      echo '
      <div class="widget-foot">
         <!--WI_PAGINATION-->
         <ul class="pagination pull-right">';

         $pagination = "";
         
         if($lastpage > 1) {	
         //previous button
         if ($page > 1) {
            $pagination.= '<li><a href="obeclos.php?page='.$prev.$sqlstring.'">Prev</a></li>';
         }
         //pages	
         if ($lastpage < 7 + ($adjacents * 3)) {	
            //not enough pages to bother breaking it up
            for ($counter = 1; $counter <= $lastpage; $counter++) {
               if ($counter == $page) {
                  $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
               } else {
                  $pagination.= '<li><a href="obeclos.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
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
                     $pagination.= '<li><a href="obeclos.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
                  }
               }
               $pagination.= '<li><a href="#"> ... </a></li>';
               $pagination.= '<li><a href="obeclos.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
               $pagination.= '<li><a href="obeclos.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
            } else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
                  $pagination.= '<li><a href="obeclos.php?page=1'.$sqlstring.'">1</a></li>';
                  $pagination.= '<li><a href="obeclos.php?page=2'.$sqlstring.'">2</a></li>';
                  $pagination.= '<li><a href="obeclos.php?page=3'.$sqlstring.'">3</a></li>';
                  $pagination.= '<li><a href="#"> ... </a></li>';
               for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                  if ($counter == $page) {
                     $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                  } else {
                     $pagination.= '<li><a href="obeclos.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
                  }
               }
               $pagination.= '<li><a href="#"> ... </a></li>';
               $pagination.= '<li><a href="obeclos.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
               $pagination.= '<li><a href="obeclos.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
            } else { //close to end; only hide early pages
               $pagination.= '<li><a href="obeclos.php?page=1'.$sqlstring.'">1</a></li>';
               $pagination.= '<li><a href="obeclos.php?page=2'.$sqlstring.'">2</a></li>';
               $pagination.= '<li><a href="obeclos.php?page=3'.$sqlstring.'">3</a></li>';
               $pagination.= '<li><a href="#"> ... </a></li>';
               for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
                  if ($counter == $page) {
                     $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                  } else {
                     $pagination.= '<li><a href="obeclos.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
                  }
               }
            }
         }
         //next button
         if ($page < $counter - 1) {
            $pagination.= '<li><a href="obeclos.php?page='.$next.$sqlstring.'">Next</a></li>';
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