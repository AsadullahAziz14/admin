<?php

if(!LMS_VIEW && !isset($_GET['id'])) {  
	$queryRequistion  = $dblms->querylms("SELECT requisition_id, requisition_status, requisition_code, requisition_date,
												requisition_type, forwarded_to, id_location, id_department, id_requester
											FROM ".SMS_REQUISITION." 
											WHERE requisition_id != ''
											$sql2
										");
	include ("include/page_title.php"); 
	echo'  
	<div class="row">
		<div class="col-sm-91">
			<a href="inventory-requisition.php?view=forward_requisition" class="btn btn-primary" style="float: right; margin: 10px;"><b>Forward Requisition</b></a>
		</div>
	</div>  
	<div class="table-responsive" style="overflow: auto;">
		<table class="footable table table-bordered table-hover table-with-avatar">
			<thead>
				<tr>
					<th style="vertical-align: middle;" nowrap="nowrap"> Sr.# </th>
					<th style="vertical-align: middle;" nowrap="nowrap"> Requisition Code </th>
					<th style="vertical-align: middle;" nowrap="nowrap"> Requisition Date </th>
					<th style="vertical-align: middle;" nowrap="nowrap"> Requisition Type </th>
					<th style="vertical-align: middle;" nowrap="nowrap"> Store </th>
					<th style="vertical-align: middle;" nowrap="nowrap"> Department </th>
					<th style="vertical-align: middle;" nowrap="nowrap"> Requester </th>
					<th style="vertical-align: middle;" nowrap="nowrap"> Status</th>
					<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
				</tr>
			</thead>
			<tbody>';
				$srno = 0;
				while($valueRequisition = mysqli_fetch_array($queryRequistion)) {
					$srno++;
					echo '
					<tr>
						<td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
						<td style="vertical-align: middle;" nowrap="nowrap">'.$valueRequisition['requisition_code'].'</td>
						<td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($valueRequisition['requisition_date'])).'</td>
						<td style="vertical-align: middle;" nowrap="nowrap">'.REQUISITION_TYPES[$valueRequisition['requisition_type']].'</td>';
						$queryStores = $dblms->querylms("SELECT location_id, location_address
															From ".SMS_LOCATION."
															Where location_id = ".$valueRequisition['id_location']."
														");
						$valueStore = mysqli_fetch_array($queryStores);
						echo '
						<td style="vertical-align: middle;" nowrap="nowrap">'.$valueStore['location_address'].'</td>';
						$queryDepartments = $dblms->querylms("SELECT dept_name
																FROM ".DEPARTMENTS." 
																WHERE dept_id = ".$valueRequisition['id_department']."
															");
						$valueDepartments = mysqli_fetch_array($queryDepartments);
						echo '
						<td style="vertical-align: middle;" nowrap="nowrap">'.$valueDepartments['dept_name'].'</td>';
						
						$queryEmployees  = $dblms->querylms("SELECT emply_name
																FROM ".EMPLOYEES."
																WHERE emply_id = ".$valueRequisition['id_requester']."
															");
						$valueEmployees = mysqli_fetch_array($queryEmployees);
						echo '
						<td style="vertical-align: middle;" nowrap="nowrap">'.$valueEmployees['emply_name'].'</td>
						<td nowrap="nowrap" style="width:70px; text-align:center;">'.get_status($valueRequisition['requisition_status']).'</td>
						<td nowrap="nowrap" style="text-align:center;">';
						if($valueRequisition['forwarded_to'] == NULL){
							echo '
							<a class="btn btn-xs btn-info" href="inventory-requisition.php?id='.$valueRequisition['requisition_id'].'"><i class="icon-pencil"></i></a>
							<a href="?deleteId='.$valueRequisition['requisition_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>';
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