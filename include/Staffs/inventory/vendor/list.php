<?php
$adjacents 	= 3;
if(!($Limit)) { $Limit = 100; } 
if($page) { $start = ($page - 1) * $Limit; } else {	$start = 0;	}
$page = (int)$page;

$queryItem = $dblms->querylms("SELECT vendor_id 
								FROM ".SMS_VENDOR." 
								WHERE vendor_id != '' 
								$sql2
                            ");

$count 		= mysqli_num_rows($queryItem);
if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
$prev 		= $page - 1;							//previous page is page - 1
$next 		= $page + 1;							//next page is page + 1
$lastpage	= ceil($count/$Limit);				//lastpage is = total pages / items per page, rounded up.
$lpm1 		= $lastpage - 1;

if(mysqli_num_rows($queryItem) > 0) {
	$queryVendor = $dblms->querylms("SELECT vendor_id, vendor_name, vendor_code, vendor_address, vendor_contact_email, 
											vendor_contact_phone1, vendor_contact_phone2, vendor_contact_name, vendor_status 
									FROM ".SMS_VENDOR." 
									WHERE vendor_id != ''
									$sql2
									LIMIT ".($page-1)*$Limit .",$Limit");
	include ("include/page_title.php"); 
	echo'    
		<div class="table-responsive" style="overflow: auto;">
			<table class="footable table table-bordered table-hover table-with-avatar">
				<thead>
					<tr>
						<th style="vertical-align: middle;" nowrap="nowrap"> Sr.# </th>
						<th style="vertical-align: middle;" nowrap="nowrap"> Vendor Name </th>
						<th style="vertical-align: middle;" nowrap="nowrap"> Vendor Code </th>
						<th style="vertical-align: middle;" nowrap="nowrap"> Vendor Address </th>
						<th style="vertical-align: middle;" nowrap="nowrap"> Contact Person </th>
						<th style="vertical-align: middle;" nowrap="nowrap"> Email </th>
						<th style="vertical-align: middle;" nowrap="nowrap"> Phone 1 </th>
						<th style="vertical-align: middle;" nowrap="nowrap"> Phone 2 </th>
						<th style="vertical-align: middle;" nowrap="nowrap"> Status</th>
						<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
					</tr>
				</thead>
				<tbody>';
					$srno = 0;
					while($valueVendor = mysqli_fetch_array($queryVendor)) {
						$srno++;
						echo '
						<tr>
							<td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
							<td style="vertical-align: middle;" nowrap="nowrap">'.$valueVendor['vendor_name'].'</td>
							<td style="vertical-align: middle;" nowrap="nowrap">'.$valueVendor['vendor_code'].'</td>
							<td style="vertical-align: middle;" nowrap="nowrap">'.$valueVendor['vendor_address'].'</td>
							<td style="vertical-align: middle;" nowrap="nowrap">'.$valueVendor['vendor_contact_name'].'</td>
							<td style="vertical-align: middle;" nowrap="nowrap">'.$valueVendor['vendor_contact_email'].'</td>
							<td style="vertical-align: middle;" nowrap="nowrap">'.$valueVendor['vendor_contact_phone1'].'</td>
							<td style="vertical-align: middle;" nowrap="nowrap">'.$valueVendor['vendor_contact_phone2'].'</td>
							<td nowrap="nowrap" style="width:70px; text-align:center;">'.get_status($valueVendor['vendor_status']).'</td>
							<td nowrap="nowrap" style="text-align:center;">
								<a class="btn btn-xs btn-info" href="inventory-vendor.php?id='.$valueVendor['vendor_id'].'"><i class="icon-pencil"></i></a>
								<a href="?deleteId='.$valueVendor['vendor_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>
							</td>
						</tr>';
					}
					echo '
				</tbody>
			</table>
		</div>
'; 
}