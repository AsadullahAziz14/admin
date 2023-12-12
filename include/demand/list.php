<?php

$page = (int)$page;
$sql2 		    = '';
$sqlstring	    = "";
$search_term 	= (isset($_REQUEST['search_term'])  && $_REQUEST['search_term'] != '')  ? $_REQUEST['search_term']  : '';
$searchFeild 	= (isset($_REQUEST['searchFeild'])  && $_REQUEST['searchFeild'] != '')  ? $_REQUEST['searchFeild']  : '';
$searchOP 	    = (isset($_REQUEST['searchOP'])     && $_REQUEST['searchOP'] != '')     ? $_POST['searchOP']        : '';
// $type 		= (isset($_GET['type']) && $_GET['type'] != '') ? $_GET['type'] : '';
// $category 	= (isset($_GET['category']) && $_GET['category'] != '') ? $_GET['category'] : '';

if(isset($_GET['srch'])) 
{
   $srch = $_GET['srch'];
	$stdsrch	= $srch;
	$sql2 		= "AND demand_code LIKE '".$stdsrch."%'";
	$sqlstring	= "&srch=".$stdsrch."";
} else {
	$srch 		= "";
	$sqlstring	= "";
	$sql2  		= '';
}

if(!LMS_VIEW && !isset($_GET['id'])) 
{  
if(!($Limit)) 	{ $Limit = 50; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}

$sqllms  = $dblms->querylms("SELECT *
                                    FROM ".SMS_DEMAND." 
                                    WHERE demand_id != ''
                                    $sql2
                                    ");
$count = mysqli_num_rows($sqllms);
if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
$prev 		= $page - 1;							//previous page is page - 1
$next 		= $page + 1;							//next page is page + 1
$lastpage	= ceil($count/$Limit);				//lastpage is = total pages / items per page, rounded up.
$lpm1 		= $lastpage - 1;
    
$sqllms  = $dblms->querylms("SELECT * 
                                    FROM ".SMS_DEMAND." 
                                    WHERE demand_id != ''
                                    $sql2
                                    ORDER BY demand_id DESC LIMIT ".($page-1)*$Limit .",$Limit");
   
include ("include/page_title.php"); 

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
                 
                  while($rowstd1 = mysqli_fetch_array($sqllms)) {
                 
                  $ctystatus = get_status($rowstd1['demand_status']);
                  $srno++;
                  
                  echo '
                  <tr>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$rowstd1['demand_code'].'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.DEMAND_TYPES[$rowstd1['demand_type']].'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$rowstd1['demand_quantity'].'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($rowstd1['demand_date'])).'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($rowstd1['demand_due_date'])).'</td>
                     ';
                     $sqllms2  = $dblms->querylms("SELECT dept_name
                                                   FROM ".DEPARTMENTS." 
                                                   WHERE dept_id = ".$rowstd1['id_department']."
                                                   
                                                ");
                     $rowstd2 = mysqli_fetch_array($sqllms2);
                     echo '
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$rowstd2['dept_name'].'</td>
                     ';
                     $sqllms3  = $dblms->querylms("SELECT emply_name
                                                   FROM ".EMOBE_PLOSYEES." 
                                                   WHERE emply_id = ".$rowstd1['id_added']."
                                                   
                                                ");
                     $rowstd3 = mysqli_fetch_array($sqllms3);
                     
                     echo '
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$rowstd3['emply_name'].'</td>
                     <td nowrap="nowrap" style="width:70px; text-align:center;">'.$ctystatus.'</td>
                     <td nowrap="nowrap" style="text-align:center;">
                        <a class="btn btn-xs btn-info" href="demand.php?id='.$rowstd1['demand_id'].'"><i class="icon-pencil"></i></a>
                        <a href="?deleteId='.$rowstd1['demand_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>
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