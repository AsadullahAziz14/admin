<?php
if(!LMS_VIEW && !isset($_GET['id'])) {
   $adjacents 	= 3;
   if(!($Limit)) { $Limit = 100; } 
   if($page) { $start = ($page - 1) * $Limit; } else {	$start = 0;	}
   $page = (int)$page;

   $queryCategory = $dblms->querylms("SELECT category_id
                                          FROM ".SMS_CATEGORY." 
                                          WHERE category_id != ''
                                          $sql2
                                    ");
   $count = mysqli_num_rows($queryCategory);
   if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
   $prev 		= $page - 1;							//previous page is page - 1
   $next 		= $page + 1;							//next page is page + 1
   $lastpage	= ceil($count/$Limit);				//lastpage is = total pages / items per page, rounded up.
   $lpm1 		= $lastpage - 1;

   if(mysqli_num_rows($queryCategory) > 0) {
		require_once("include/page_title.php"); 
      $queryCategory  = $dblms->querylms("SELECT category_id, category_code, category_name,
                                          category_description, category_status
                                          FROM ".SMS_CATEGORY." 
                                          WHERE category_id != ''
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
                  <th style="vertical-align: middle;" nowrap="nowrap"> Category Name </th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Category Code </th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Description </th>
                  <th style="vertical-align: middle;" nowrap="nowrap"> Status</th>
                  <th style="width:90px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
               </tr>
            </thead>
            <tbody>';
            if($page == 1) { $srno = 0; } else { $srno = ($Limit * ($page-1));}

            while($valueCategory = mysqli_fetch_array($queryCategory)) {
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
                     <a class="btn btn-xs btn-info" href="inventory-category.php?id='.$valueCategory['category_id'].'"><i class="icon-pencil"></i></a>
                     <a href="?deleteId='.$valueCategory['category_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>
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
                  $pagination.= '<li><a href="inventory-category.php?page='.$prev.$sqlstring.'">Prev</a></li>';
               }
               //pages	
               if ($lastpage < 7 + ($adjacents * 3)) {	
                  //not enough pages to bother breaking it up
                  for ($counter = 1; $counter <= $lastpage; $counter++) {
                     if ($counter == $page) {
                        $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                     } else {
                        $pagination.= '<li><a href="inventory-category.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
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
                           $pagination.= '<li><a href="inventory-category.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
                        }
                     }
                     $pagination.= '<li><a href="#"> ... </a></li>';
                     $pagination.= '<li><a href="inventory-category.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
                     $pagination.= '<li><a href="inventory-category.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
                  } else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
                        $pagination.= '<li><a href="inventory-category.php?page=1'.$sqlstring.'">1</a></li>';
                        $pagination.= '<li><a href="inventory-category.php?page=2'.$sqlstring.'">2</a></li>';
                        $pagination.= '<li><a href="inventory-category.php?page=3'.$sqlstring.'">3</a></li>';
                        $pagination.= '<li><a href="#"> ... </a></li>';
                     for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page) {
                           $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                        } else {
                           $pagination.= '<li><a href="inventory-category.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
                        }
                     }
                     $pagination.= '<li><a href="#"> ... </a></li>';
                     $pagination.= '<li><a href="inventory-category.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
                     $pagination.= '<li><a href="inventory-category.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
                  } else { //close to end; only hide early pages
                     $pagination.= '<li><a href="inventory-category.php?page=1'.$sqlstring.'">1</a></li>';
                     $pagination.= '<li><a href="inventory-category.php?page=2'.$sqlstring.'">2</a></li>';
                     $pagination.= '<li><a href="inventory-category.php?page=3'.$sqlstring.'">3</a></li>';
                     $pagination.= '<li><a href="#"> ... </a></li>';
                     for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page) {
                           $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                        } else {
                           $pagination.= '<li><a href="inventory-category.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
                        }
                     }
                  }
               }
            //next button
            if ($page < $counter - 1) {
               $pagination.= '<li><a href="inventory-category.php?page='.$next.$sqlstring.'">Next</a></li>';
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