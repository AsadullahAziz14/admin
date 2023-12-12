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

if(LMS_VIEW == 'forward_po') {   

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
            
            <div class="table-responsive" style="overflow: auto;">
               <table class="footable table table-bordered table-hover table-with-avatar">
                  <thead>
                  <tr>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Sr.# </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> PO Code </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> PO Date </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Delivery Date </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Ordered By </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Date Ordered </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Forward By </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Date Forwarded </th>
                     <th style="vertical-align: middle;" nowrap="nowrap"> Forward To </th>
                     <th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
                  </tr>
                  </thead>
                  <tbody>';
                  $srno = 0;
                 
                  while($rowstd1 = mysqli_fetch_array($sqllms1)) 
                  {
                    $ctystatus = get_status($rowstd1['po_status']);
                    $srno++;
                    
                    echo '
                    <tr>
                        <td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
                        <td style="vertical-align: middle;" nowrap="nowrap">'.$rowstd1['po_code'].'</td>
                        <td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($rowstd1['po_date'])).'</td>
                        <td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($rowstd1['po_delivery_date'])).'</td>';
                        $emp_sqllms  = $dblms->querylms("SELECT emply_name
                                                    FROM ".EMOBE_PLOSYEES."
                                                    WHERE emply_id = ".$rowstd1['ordered_by']."
                                                    $sql2
                                                ");
                        $value_emp = mysqli_fetch_array($emp_sqllms);
                        echo '
                        <td style="vertical-align: middle;" nowrap="nowrap">'.$value_emp['emply_name'].'</td>
                        <td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($rowstd1['date_ordered'])).'</td>
                        ';
                        if($rowstd1['forwarded_by'] != NULL)
                        {
                            $emp_sqllms  = $dblms->querylms("SELECT emply_name
                                                        FROM ".EMOBE_PLOSYEES."
                                                        WHERE emply_id = ".$rowstd1['forwarded_by']."
                                                        $sql2
                                                    ");
                            $emp_sqllms = mysqli_fetch_array($emp_sqllms);

                            echo '
                            <td style="vertical-align: middle;" nowrap="nowrap">'.$value_emp['emply_name'].'</td>
                            ';
                        }
                        else
                        {
                            echo '<td style="vertical-align: middle;" nowrap="nowrap"></td>';
                        }

                        if($rowstd1['date_forwarded'] != NULL)
                        {
                            echo '<td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($rowstd1['date_forwarded'])).'</td>';
                        }
                        else
                        {
                            echo '<td style="vertical-align: middle;" nowrap="nowrap"></td>';
                        }
                        echo '
                        <td style="vertical-align: middle;" nowrap="nowrap">
                            ';
                            if($rowstd1['forwarded_to'] == NULL)
                            {
                                echo'
                                <div class="">
                                    <div class="form-sep" style=" width: 100%">
                                <form class="form-horizontal" action="purchase_order.php" method="POST" enctype="multipart/form-data">
                                   

                                    <input class="form-control" type="hidden" value="'.$rowstd1['po_id'].'" id="po_id" name="po_id" readonly>
                                    <select class="form-control col-sm-70" name="forwarded_to" id="forwarded_to">
                                       
                                            <option value="">Select</option>
                                            ';
                                            $sqllms5  = $dblms->querylms("SELECT adm_id,adm_fullname
                                                                        FROM ".ADMINS."
                                                                        WHERE adm_id IN (1,2,3,4,5)
                                                                        $sql2
                                                                    ");
                                            while($rowstd5 = mysqli_fetch_array($sqllms5))
                                            {
                                                echo '<option value="'.$rowstd5['adm_id'].'">'.$rowstd5['adm_fullname'].'</option> ';
                                            }
                                        echo '
                                    </select>
                                    <input class="btn btn-primary" style="float: right;" type="submit" value="Forward" id="forward_po" name="forward_po">
                                </form>
                            </div>
                            </div>
                            ';
                            }
                            else
                            {
                                $sqllms6  = $dblms->querylms("SELECT adm_id,adm_fullname
                                                                FROM ".ADMINS."
                                                                WHERE adm_id IN (".$rowstd1['forwarded_to'].")
                                                                $sql2
                                                            ");
                                $rowstd6 = mysqli_fetch_array($sqllms6);

                                echo ' '.$rowstd6['adm_fullname'].' ';
                            }
                            echo '
                        </td>
                        <td nowrap="nowrap" style="text-align:center;">
                            <a class="btn btn-xs btn-info" href="print_sms.php?print=po&id='.$rowstd1['po_id'].'"><i class="icon-print"></i></a>
                        </td>
                    </tr>
                    ';
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