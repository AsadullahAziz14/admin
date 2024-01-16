<?php

if(!LMS_VIEW && !isset($_GET['id'])) {  
	$queryRequistion  = $dblms->querylms("SELECT requisition_id, requisition_status, requisition_code, requisition_date,
												requisition_type, requisition_purpose, requisition_remarks, id_department,
												id_requester, id_location, forwarded_by, forwarded_to, id_approved, date_forwarded
											FROM ".SMS_REQUISITION." 
											WHERE requisition_id != ''
											$sql2
										");
	include ("include/page_title.php"); 
	echo'  
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
						<td nowrap="nowrap" style="text-align:center;">
							<a class="btn btn-xs btn-warning view-requisition-modal" data-toggle="modal" data-target="#viewRequisitionModal" 
								data-modal-window-title="Requisition Details" data-height="350" data-width="100%" 
								data-requisition-id="'.$valueRequisition['requisition_id'].'" data-requisition-status="'.$valueRequisition['requisition_status'].'" 
								data-requisition-code="'.$valueRequisition['requisition_code'].'" data-requisition-date="'.$valueRequisition['requisition_date'].'"
								data-requisition-type="'.$valueRequisition['requisition_type'].'" data-requisition-purpose="'.$valueRequisition['requisition_purpose'].'"
								data-requisition-remarks="'.$valueRequisition['requisition_remarks'].'" data-id-department="'.$valueRequisition['id_department'].'"
								data-id-requester="'.$valueRequisition['id_requester'].'" data-forwarded-by="'.$valueRequisition['forwarded_by'].'" data-forwarded-to="'.$valueRequisition['forwarded_to'].'"
								data-date-forwarded="'.$valueRequisition['date_forwarded'].'" data-id-approved="'.$valueRequisition['id_approved'].'"
								>
								<i class="icon-zoom-in"></i>
							</a>
							<a class="btn btn-xs btn-info" href="inventory-requisition.php?id='.$valueRequisition['requisition_id'].'"><i class="icon-pencil"></i></a>
							<a href="?deleteId='.$valueRequisition['requisition_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>
						</td>
					</tr>';
				}
				echo '
			</tbody>
		</table>
	</div>  
   '; 
}