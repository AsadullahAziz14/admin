<?php
if(!LMS_VIEW && !isset($_GET['id'])) { 
	$queryReceiving  = $dblms->querylms("SELECT receiving_id, receiving_code, receiving_date,
										receiving_status, delivery_chalan_num, id_vendor
										FROM ".SMS_RECEIVING." 
										WHERE receiving_id != '' 
										$sql2 
										ORDER BY receiving_id DESC");
	echo '
	<div style="clear:both;"></div>
	<table class="footable table table-bordered table-hover">
		<thead>
			<tr>
				<th style="font-weight:700; vertical-align: middle;" nowrap="nowrap"> Sr.# </th>
				<th style="font-weight:700; vertical-align: middle;" nowrap="nowrap"> Code </th>
				<th style="font-weight:700; vertical-align: middle;" nowrap="nowrap"> Receiving Date </th>
				<th style="font-weight:700; vertical-align: middle;" nowrap="nowrap"> DC Num. </th>
				<th style="font-weight:700; vertical-align: middle;" nowrap="nowrap"> Vendor </th>
				<th style="font-weight:700; text-align: center; vertical-align: middle;" nowrap="nowrap"> Status</th>
				<th style="text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
			</tr>
		</thead>
		<tbody>';
		$srno = 0;	
		while($valueReceiving = mysqli_fetch_array($queryReceiving)) {
			$srno++;
			echo '
			<tr>
				<td style="vertical-align: middle;">'.$srno.'</td>
				<td style="vertical-align: middle;">'.$valueReceiving['receiving_code'].'</td>
				<td style="vertical-align: middle;">'.date('d-M-Y', strtotime($valueReceiving['receiving_date'])).'</td>
				<td style="vertical-align: middle;">'.$valueReceiving['delivery_chalan_num'].'</td>';
				$queryVendor = $dblms->querylms("SELECT vendor_id, vendor_name
													FROM ".SMS_VENDOR." 
													WHERE vendor_id = ".$valueReceiving['id_vendor']."
												");
				$valueVendor = mysqli_fetch_array($queryVendor);
				echo '
				<td style="vertical-align: middle;">'.$valueVendor['vendor_name'].'</td>
				<td style="text-align:center;">'.get_status($valueReceiving['receiving_status']).'</td>
				<td style="text-align:center;">
					<a class="btn btn-xs btn-info" href="inventory-receiving.php?id='.$valueReceiving['receiving_id'].'"><i class="icon-pencil"></i></a>
					<a href="?deleteId='.$valueReceiving['receiving_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>
				</td>
			</tr>';
		}	
		echo '
		</tbody>
	</table>';
}
?>