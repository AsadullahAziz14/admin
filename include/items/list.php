<?php

$page = (int)$page;
$sql2 		    = '';
$sqlstring	    = "";
$search_term 	= (isset($_REQUEST['search_term'])  && $_REQUEST['search_term'] != '')  ? $_REQUEST['search_term']  : '';
$searchFeild 	= (isset($_REQUEST['searchFeild'])  && $_REQUEST['searchFeild'] != '')  ? $_REQUEST['searchFeild']  : '';
$searchOP 	    = (isset($_REQUEST['searchOP'])     && $_REQUEST['searchOP'] != '')     ? $_POST['searchOP']        : '';
// $type 		= (isset($_GET['type']) && $_GET['type'] != '') ? $_GET['type'] : '';
// $category 	= (isset($_GET['category']) && $_GET['category'] != '') ? $_GET['category'] : '';

if(isset($_GET['srch'])) {
   $srch = $_GET['srch'];
	$stdsrch	= $srch;
	$sql2 		= "AND item_title LIKE '".$stdsrch."%'";
	$sqlstring	= "&srch=".$stdsrch."";
} else {
	$srch 		= "";
	$sqlstring	= "";
	$sql2  		= '';
}

if(!LMS_VIEW && !isset($_GET['id'])) {  

if(!($Limit)) 	{ $Limit = 50; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}

$sqllms  = $dblms->querylms("SELECT *
                                    FROM ".SMS_ITEMS." 
                                    WHERE item_id != ''
                                    $sql2
                                    ");
$count = mysqli_num_rows($sqllms);
if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
$prev 		= $page - 1;							//previous page is page - 1
$next 		= $page + 1;							//next page is page + 1
$lastpage	= ceil($count/$Limit);				//lastpage is = total pages / items per page, rounded up.
$lpm1 		= $lastpage - 1;
    
$sqllms  = $dblms->querylms("SELECT * 
                                    FROM ".SMS_ITEMS." 
                                    WHERE item_id != ''
                                    $sql2
                                    ORDER BY item_id DESC LIMIT ".($page-1)*$Limit .",$Limit");
   
include ("include/page_title.php"); 

echo'    
            <div class="table-responsive" style="overflow: auto;">
               <table class="footable table table-bordered table-hover table-with-avatar">
                  <thead>
                  <tr>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Sr.# </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Title </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Code </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Description </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Article </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Style </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Model </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Pic. </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Status</th>
                     <th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
                  </tr>
                  </thead>
                  <tbody>';
                  $srno = 0;
                 
                  while($rowstd = mysqli_fetch_array($sqllms)) {
                 
                  $ctystatus = get_status($rowstd['item_status']);
                  $srno++;
                  
                  echo '
                  <tr>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$rowstd['item_title'].'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$rowstd['item_code'].'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$rowstd['item_description'].'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$rowstd['item_article_number'].'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$rowstd['item_style_number'].'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$rowstd['item_model_number'].'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap"></td>
                     <td nowrap="nowrap" style="width:70px; text-align:center;">'.$ctystatus.'</td>
                     <td nowrap="nowrap" style="text-align:center;">
                        <a class="btn btn-xs btn-info" href="items.php?id='.$rowstd['item_id'].'"><i class="icon-pencil"></i></a>
                        <a href="?deleteId='.$rowstd['item_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>
                     </td>
                  </tr>';
                  
                  }
                 
                  echo '
                  </tbody>
                  </table>
            ';
            // $pagenam = array();
            $pagename = explode('/',$_SERVER['REQUEST_URI']);
            pagination($count, $Limit,$page, $lastpage,$sqlstring,$pagename[2]);
            
            
            echo'
         </div>
         
     
'; 
}