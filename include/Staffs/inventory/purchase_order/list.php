<?php
if(!LMS_VIEW && !isset($_GET['id'])) { 
	$adjacents 	= 3;
	if(!($Limit)) { $Limit = 100; } 
	if($page) { $start = ($page - 1) * $Limit; } else {	$start = 0;	}
	$page = (int)$page;
 
	$queryPO = $dblms->querylms("SELECT po_id
									FROM ".SMS_PO." 
									WHERE po_id != ''
								");
	$count 		= mysqli_num_rows($queryPO);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
 
	if(mysqli_num_rows($queryPO) > 0) {
		$queryPO = $dblms->querylms("SELECT po_id, po_status, po_code, po_date, po_delivery_date,
											id_vendor, ordered_by, date_ordered, po_tax_perc, 
											po_remarks, po_payment_terms, po_credit_terms, po_lead_time, po_delivery_address,
											forwarded_by, forwarded_to, date_forwarded
											FROM ".SMS_PO." 
											WHERE po_id != ''
											$sql2
									");
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
						<th style="vertical-align: middle;" nowrap="nowrap"> Vendor </th>
						<th style="vertical-align: middle;" nowrap="nowrap"> Status</th>
						<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
					</tr>
				</thead>
				<tbody>';
					$srno = 0;
					while($valuePO = mysqli_fetch_array($queryPO)) {
						$srno++;
						echo '
						<tr>
							<td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
							<td style="vertical-align: middle;" nowrap="nowrap">'.$valuePO['po_code'].'</td>
							<td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($valuePO['po_date'])).'</td>
							<td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($valuePO['po_delivery_date'])).'</td>';
							
							$queryVendor  = $dblms->querylms("SELECT vendor_name
																FROM ".SMS_VENDOR." 
																WHERE vendor_id = ".$valuePO['id_vendor']."
															");
							$valueVendor = mysqli_fetch_array($queryVendor);

							echo '<td style="vertical-align: middle;" nowrap="nowrap">'.$valueVendor['vendor_name'].'</td>';

							echo '
							<td nowrap="nowrap" style="width:70px; text-align:center;">'.get_sms_status($valuePO['po_status']).'</td>
							<td nowrap="nowrap" style="text-align:center;">
								<a class="btn btn-xs btn-warning view-po-modal" data-toggle="modal" data-target="#viewPOModal" 
									data-modal-window-title="PO Details" data-height="350" data-width="100%" 
									data-po-id="'.$valuePO['po_id'].'" data-po-code="'.$valuePO['po_code'].'"
									data-po-status="'.$valuePO['po_status'].'" data-po-delivery-date="'.$valuePO['po_delivery_date'].'"
									data-po-delivery-address="'.$valuePO['po_delivery_address'].'" data-po-tax-perc="'.$valuePO['po_tax_perc'].'"
									data-po-payment-terms="'.$valuePO['po_payment_terms'].'" data-po-lead-time="'.$valuePO['po_lead_time'].'"
									data-date-ordered="'.$valuePO['date_ordered'].'" data-po-remarks="'.$valuePO['po_remarks'].'"
									data-id-vendor="'.$valuePO['id_vendor'].'" data-forwarded-by="'.$valuePO['forwarded_by'].'"
									data-forwarded-to="'.$valuePO['forwarded_to'].'" data-date-forwarded="'.$valuePO['date_forwarded'].'"
									>
									<i class="icon-zoom-in"></i>
								</a>
								';
								if($valuePO['po_status'] <= 1) {
									echo '
									<a class="btn btn-xs btn-info" href="inventory-purchase_order.php?id='.$valuePO['po_id'].'"><i class="icon-pencil"></i></a>
									<a href="?deleteId='.$valuePO['po_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>';
								}
								echo '
							</td>
						</tr>';
					}
					echo '
				</tbody>
			</table>
		</div>'; 
		if($count>$Limit) {
			echo '
			<div class="widget-foot">
			   <!--WI_PAGINATION-->
			   <ul class="pagination pull-right">';
   
			   $pagination = "";
			   
			   if($lastpage > 1) {	
			   //previous button
			   if ($page > 1) {
				  $pagination.= '<li><a href="inventory-purchase_order.php?page='.$prev.$sqlstring.'">Prev</a></li>';
			   }
			   //pages	
			   if ($lastpage < 7 + ($adjacents * 3)) {	
				  //not enough pages to bother breaking it up
				  for ($counter = 1; $counter <= $lastpage; $counter++) {
					 if ($counter == $page) {
						$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
					 } else {
						$pagination.= '<li><a href="inventory-purchase_order.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
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
						   $pagination.= '<li><a href="inventory-purchase_order.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
						}
					 }
					 $pagination.= '<li><a href="#"> ... </a></li>';
					 $pagination.= '<li><a href="inventory-purchase_order.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
					 $pagination.= '<li><a href="inventory-purchase_order.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
				  } else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
						$pagination.= '<li><a href="inventory-purchase_order.php?page=1'.$sqlstring.'">1</a></li>';
						$pagination.= '<li><a href="inventory-purchase_order.php?page=2'.$sqlstring.'">2</a></li>';
						$pagination.= '<li><a href="inventory-purchase_order.php?page=3'.$sqlstring.'">3</a></li>';
						$pagination.= '<li><a href="#"> ... </a></li>';
					 for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
						if ($counter == $page) {
						   $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
						} else {
						   $pagination.= '<li><a href="inventory-purchase_order.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
						}
					 }
					 $pagination.= '<li><a href="#"> ... </a></li>';
					 $pagination.= '<li><a href="inventory-purchase_order.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
					 $pagination.= '<li><a href="inventory-purchase_order.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
				  } else { //close to end; only hide early pages
					 $pagination.= '<li><a href="inventory-purchase_order.php?page=1'.$sqlstring.'">1</a></li>';
					 $pagination.= '<li><a href="inventory-purchase_order.php?page=2'.$sqlstring.'">2</a></li>';
					 $pagination.= '<li><a href="inventory-purchase_order.php?page=3'.$sqlstring.'">3</a></li>';
					 $pagination.= '<li><a href="#"> ... </a></li>';
					 for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
						if ($counter == $page) {
						   $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
						} else {
						   $pagination.= '<li><a href="inventory-purchase_order.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
						}
					 }
				  }
			   }
			   //next button
			   if ($page < $counter - 1) {
				  $pagination.= '<li><a href="inventory-purchase_order.php?page='.$next.$sqlstring.'">Next</a></li>';
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
