<?php
if(!LMS_VIEW && !isset($_GET['id'])) {  
	$queryPO  = $dblms->querylms("SELECT po_id, po_status, po_code, po_date, po_delivery_date,
										po_quantity, po_amount, id_vendor, ordered_by, date_ordered, po_tax_perc, 
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
															FROM ".SMS_VENDOR." 
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
							<a class="btn btn-xs btn-warning view-po-modal" data-toggle="modal" data-target="#viewPOModal" 
								data-modal-window-title="PO Details" data-height="350" data-width="100%" 
								data-po-id="'.$valuePO['po_id'].'" data-po-code="'.$valuePO['po_code'].'"
								data-po-quantity="'.$valuePO['po_quantity'].'" data-po-amount="'.$valuePO['po_amount'].'"
								data-po-status="'.$valuePO['po_status'].'" data-po-delivery-date="'.$valuePO['po_delivery_date'].'"
								data-po-delivery-address="'.$valuePO['po_delivery_address'].'" data-po-tax-perc="'.$valuePO['po_tax_perc'].'"
								data-po-payment-terms="'.$valuePO['po_payment_terms'].'" data-po-lead-time="'.$valuePO['po_lead_time'].'"
								data-date-ordered="'.$valuePO['date_ordered'].'" data-po-remarks="'.$valuePO['po_remarks'].'"
								data-id-vendor="'.$valuePO['id_vendor'].'" data-forwarded-by="'.$valuePO['forwarded_by'].'"
								data-forwarded-to="'.$valuePO['forwarded_to'].'" data-date-forwarded="'.$valuePO['date_forwarded'].'"
								>
								<i class="icon-zoom-in"></i>
							</a>
							<a class="btn btn-xs btn-info" href="inventory-purchase_order.php?id='.$valuePO['po_id'].'"><i class="icon-pencil"></i></a>
							<a href="?deleteId='.$valuePO['po_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>
						</td>
					</tr>';
				}
				echo '
			</tbody>
		</table>
	</div>  
   '; 
}