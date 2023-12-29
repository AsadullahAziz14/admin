<?php
if(!LMS_VIEW && !isset($_GET['id'])) { 

	$queryItems  = $dblms->querylms("SELECT item_id, item_code, item_image, 
										item_title, item_status
										FROM ".SMS_ITEMS." WHERE item_id != '' 
										$sql2 
										ORDER BY item_id DESC");
	echo '
	<div style="clear:both;"></div>
	<table class="footable table table-bordered table-hover">
		<thead>
			<tr>
				<th style="font-weight:700; width: 50px; vertical-align: middle;" nowrap="nowrap"> Sr.# </th>
				<th style="font-weight:700; width: 100px; vertical-align: middle;" nowrap="nowrap"> Code </th>
				<th style="font-weight:700; width: 90px; vertical-align: middle;" nowrap="nowrap"> Pic </th>
				<th style="font-weight:700; width: ; vertical-align: middle;" nowrap="nowrap"> Item Name </th>
				<th style="font-weight:700; width: 100px; text-align: center; vertical-align: middle;" nowrap="nowrap"> Status</th>
				<th style="width:90px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
			</tr>
		</thead>
		<tbody>';
		$srno = 0;	
		while($valueItem = mysqli_fetch_array($queryItems)) {
			$srno++;
			echo '
			<tr>
				<td style="vertical-align: middle;">'.$srno.'</td>
				<td style="vertical-align: middle;">'.$valueItem['item_code'].'</td>
				<td style="vertical-align: middle;"><img src="images/item_images/'.$valueItem['item_image'].'" style="width: 80px; border-radius: 8px;" alt=""></td>
				<td style="vertical-align: middle;">'.$valueItem['item_title'].'</td>
				<td style="text-align:center;">'.get_status($valueItem['item_status']).'</td>
				<td style="text-align:center;">
					<a class="btn btn-xs btn-info" href="inventory-items.php?id='.$valueItem['item_id'].'"><i class="icon-pencil"></i></a>
					<a href="?deleteId='.$valueItem['item_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>
				</td>
			</tr>';
		}	
		echo '
		</tbody>
	</table>';
}
?>