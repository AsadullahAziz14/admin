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
	$sql2 		= "AND po_code LIKE '".$stdsrch."%'";
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
                                    FROM ".SMS_PO." 
                                    WHERE po_id != ''
                                    $sql2
                                    ");
$count = mysqli_num_rows($sqllms);
if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
$prev 		= $page - 1;							//previous page is page - 1
$next 		= $page + 1;							//next page is page + 1
$lastpage	= ceil($count/$Limit);				//lastpage is = total pages / items per page, rounded up.
$lpm1 		= $lastpage - 1;
    
$sqllms1  = $dblms->querylms("SELECT * 
                                    FROM ".SMS_PO." 
                                    WHERE po_id != ''
                                    $sql2
                                    ORDER BY po_id DESC LIMIT ".($page-1)*$Limit .",$Limit");
   
include ("include/page_title.php"); 

echo'  
         <div class="row">

            <div class="col-sm-91">
               <a href="purchase_order.php?view=forward_po" class="btn btn-primary" style="float: right; margin: 10px;"><b>Forward PO</b></a>
            </div>
         </div>  
          
            <div class="table-responsive" style="overflow: auto;">
               <table class="footable table table-bordered table-hover table-with-avatar">
                  <thead>
                  <tr>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Sr.# </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> PO Code </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> PO Date </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> PO Quantity </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> PO Amount </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Delivery Date </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Vendor </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Ordered By </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Date Ordered </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Status</th>
                     <th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
                  </tr>
                  </thead>
                  <tbody>';
                  $srno = 0;
                 
                  while($rowstd1 = mysqli_fetch_array($sqllms1)) {
                 
                  $ctystatus = get_status($rowstd1['po_status']);
                  $srno++;
                  
                  echo '
                  <tr>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$rowstd1['po_code'].'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($rowstd1['po_date'])).'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$rowstd1['po_quantity'].'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$rowstd1['po_amount'].'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($rowstd1['po_delivery_date'])).'</td>';
                        
                        $sqllms3  = $dblms->querylms("SELECT vendor_name
                                                      FROM ".SMS_VENDOR." 
                                                      WHERE vendor_id = ".$rowstd1['id_vendor']."
                                                   ");
                        $rowstd3 = mysqli_fetch_array($sqllms3);

                     echo '<td style="vertical-align: middle;" nowrap="nowrap">'.$rowstd3['vendor_name'].'</td>';

                        $sqllms4  = $dblms->querylms("SELECT emply_name
                                                      FROM ".EMOBE_PLOSYEES."
                                                      WHERE emply_id = ".$rowstd1['ordered_by']."
                                                   ");
                        $rowstd4 = mysqli_fetch_array($sqllms4);

                     echo '
                     <td style="vertical-align: middle;" nowrap="nowrap">'.$rowstd4['emply_name'].'</td>
                     <td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($rowstd1['date_ordered'])).'</td>
                     <td nowrap="nowrap" style="width:70px; text-align:center;">'.$ctystatus.'</td>
                     <td nowrap="nowrap" style="text-align:center;">
                        ';
                        if($rowstd1['forwarded_to'] == NULL)
                        {
                           echo '<a class="btn btn-xs btn-info" href="purchase_order.php?id='.$rowstd1['po_id'].'"><i class="icon-pencil"></i></a>
                           <a href="?deleteId='.$rowstd1['po_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>
                           ';
                        }
                        echo '
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