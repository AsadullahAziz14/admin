<?php

if(!LMS_VIEW && !isset($_GET['id'])) {  
	$queryPO  = $dblms->querylms("SELECT po_id, po_status, po_code, po_date, po_delivery_date, 
										po_quantity, po_amount, id_vendor, ordered_by, date_ordered, forwarded_by, forwarded_to, date_forwarded 
										FROM ".SMS_POS." 
										WHERE po_id != ''
										$sql2
								");
	include ("include/page_title.php"); 

	echo'  
	<div class="row">
		<div class="col-sm-91">
			<a href="inventory-purchase_order.php?view=forward_po" class="btn btn-primary" style="float: right; margin: 10px;"><b>Forward PO</b></a>
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
				while($valuePO = mysqli_fetch_array($queryPO)) {
					$srno++;
					echo '
					<tr>
						<td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
						<td style="vertical-align: middle;" nowrap="nowrap">'.$valuePO['po_code'].'</td>
						<td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($valuePO['po_date'])).'</td>
						<td style="vertical-align: middle;" nowrap="nowrap">'.$valuePO['po_quantity'].'</td>
						<td style="vertical-align: middle;" nowrap="nowrap">'.$valuePO['po_amount'].'</td>
						<td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($valuePO['po_delivery_date'])).'</td>';
						
						$queryVendor  = $dblms->querylms("SELECT vendor_name
															FROM ".SMS_VENDORS." 
															WHERE vendor_id = ".$valuePO['id_vendor']."
														");
						$valueVendor = mysqli_fetch_array($queryVendor);

						echo '<td style="vertical-align: middle;" nowrap="nowrap">'.$valueVendor['vendor_name'].'</td>';

						$queryEmployees  = $dblms->querylms("SELECT emply_name
																FROM ".EMPLOYEES."
																WHERE emply_id = ".$valuePO['ordered_by']."
															");
						$valueEmployees = mysqli_fetch_array($queryEmployees);
						echo '
						<td style="vertical-align: middle;" nowrap="nowrap">'.$valueEmployees['emply_name'].'</td>
						<td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($valuePO['date_ordered'])).'</td>
						<td nowrap="nowrap" style="width:70px; text-align:center;">'.get_status($valuePO['po_status']).'</td>
						<td nowrap="nowrap" style="text-align:center;">
						';
						if($valuePO['forwarded_to'] == NULL){
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
	</div>  
   '; 
}