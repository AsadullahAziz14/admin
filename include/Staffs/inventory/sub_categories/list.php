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
	$sql2 		= "AND sub_category_name LIKE '".$stdsrch."%'";
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
                                    FROM ".SMS_SUB_CATEGORIES." 
                                    WHERE sub_category_id != ''
                                    $sql2
                                    ");

$count = mysqli_num_rows($sqllms);
if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
$prev 		= $page - 1;							//previous page is page - 1
$next 		= $page + 1;							//next page is page + 1
$lastpage	= ceil($count/$Limit);				//lastpage is = total pages / items per page, rounded up.
$lpm1 		= $lastpage - 1;
    
$sqllms  = $dblms->querylms("SELECT * 
                                    FROM ".SMS_SUB_CATEGORIES." 
                                    WHERE sub_category_id != ''
                                    $sql2
                                    ORDER BY sub_category_id DESC LIMIT ".($page-1)*$Limit .",$Limit");
   
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
                  
                  while($rowstd = mysqli_fetch_array($sqllms)) {
                  
                  $ctystatus = get_status($rowstd['sub_category_status']);
                  $srno++;
                  
                  echo '
                  <tr>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$rowstd['sub_category_name'].'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$rowstd['sub_category_code'].'</td>
                     '; 
                     $sqllms1 = $dblms->querylms("SELECT category_id, category_name FROM " .SMS_CATEGORIES. " WHERE category_id = ".$rowstd['id_category']."");
							$rowstd1 = mysqli_fetch_array($sqllms1);
                     echo '
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$rowstd1['category_name'].'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$rowstd['sub_category_description'].'</td>
                     <td nowrap="nowrap" style="width:70px; text-align:center;">'.$ctystatus.'</td>
                     <td nowrap="nowrap" style="text-align:center;">
                        <a class="btn btn-xs btn-info" href="inventory-sub_categories.php?id='.$rowstd['sub_category_id'].'"><i class="icon-pencil"></i></a>
                        <a href="?deleteId='.$rowstd['sub_category_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>
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