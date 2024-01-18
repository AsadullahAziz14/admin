<?php
if(!LMS_VIEW && !isset($_GET['id'])) {  
	$queryInventory  = $dblms->querylms("SELECT inventory_id, inventory_status, inventory_code, inventory_description,
												inventory_reorder_point, inventory_date, id_item
											FROM ".SMS_INVENTORY." 
											WHERE inventory_id != ''
											$sql2
										");
	include ("include/page_title.php"); 

	echo'  
	<div class="table-responsive" style="overflow: auto;">
		<table class="footable table table-bordered table-hover table-with-avatar">
			<thead>
				<tr>
					<th style="vertical-align: middle;" nowrap="nowrap"> Sr.# </th>
					<th style="vertical-align: middle;" nowrap="nowrap"> Inventory Code </th>
					<th style="vertical-align: middle;" nowrap="nowrap"> Reorder Point </th>
					<th style="vertical-align: middle;" nowrap="nowrap"> Inventory Date </th>
					<th style="vertical-align: middle;" nowrap="nowrap"> Item </th>
					<th style="vertical-align: middle;" nowrap="nowrap"> In-Stock </th>
					<th style="vertical-align: middle;" nowrap="nowrap"> Issued </th>
					<th style="vertical-align: middle;" nowrap="nowrap"> Remaining </th>
					<th style="vertical-align: middle;" nowrap="nowrap"> Status</th>
					<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
				</tr>
			</thead>
			<tbody>';
				$srno = 0;
				while($valueInventory = mysqli_fetch_array($queryInventory)) {
					$srno++;
					echo '
					<tr>
						<td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
						<td style="vertical-align: middle;" nowrap="nowrap">'.$valueInventory['inventory_code'].'</td>
						<td style="vertical-align: middle;" nowrap="nowrap">'.$valueInventory['inventory_reorder_point'].'</td>
						<td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($valueInventory['inventory_date'])).'</td>
						';
						$queryItem  = $dblms->querylms("SELECT item_id, item_code, item_title
																FROM ".SMS_ITEM." 
																WHERE item_id = ".$valueInventory['id_item']."
																$sql2
															");
						$valueItem = mysqli_fetch_array($queryItem);
						echo '
						<td style="vertical-align: middle;" nowrap="nowrap">'.$valueItem['item_title'].'</td>
						';
						$queryInventoryItem = $dblms->querylms("SELECT distinct id_item, sum(quantity_added) as quantity_instock
															FROM ".SMS_INVENTORY_RECEIVING_ITEM_JUNCTION."
															Where id_item = ".$valueInventory['id_item']."
														");
						$valueInventoryItem = mysqli_fetch_array($queryInventoryItem);
						echo '
						<td style="vertical-align: middle;" nowrap="nowrap">'.$valueInventoryItem['quantity_instock'].'</td>
						'; 
						$queryIssuanceItem = $dblms->querylms("SELECT distinct id_item, sum(quantity_issued) as quantity_issued
															FROM ".SMS_ISSUANCE_REQUISITION_ITEM_JUNCTION."
															Where id_item = ".$valueInventory['id_item']."
														");
						$valueIssuanceItem = mysqli_fetch_array($queryIssuanceItem);
						echo '
						<td style="vertical-align: middle;" nowrap="nowrap">'.$valueIssuanceItem['quantity_issued'].'</td>
						<td style="vertical-align: middle;" nowrap="nowrap">'.($valueInventoryItem['quantity_instock'] - $valueIssuanceItem['quantity_issued']).'</td>
						<td nowrap="nowrap" style="width:70px; text-align:center;">'.get_status($valueInventory['inventory_status']).'</td>
						<td nowrap="nowrap" style="text-align:center;">
							<a class="btn btn-xs btn-info" href="inventory-inventory.php?id='.$valueInventory['inventory_id'].'"><i class="icon-pencil"></i></a>
							<a href="?deleteId='.$valueInventory['inventory_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>
						</td>
					</tr>';
				}
				echo '
			</tbody>
		</table>
	</div>  
   '; 
}