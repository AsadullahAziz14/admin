<?php
if(!LMS_VIEW && !isset($_GET['id'])) { 
	$adjacents 	= 3;
	if(!($Limit)) { $Limit = 100; } 
	if($page) { $start = ($page - 1) * $Limit; } else {	$start = 0;	}
	$page = (int)$page;
 
	$queryRequisition = $dblms->querylms("SELECT requisition_id
									FROM ".SMS_REQUISITION." 
									WHERE requisition_id != ''
								");
	$count 		= mysqli_num_rows($queryRequisition);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);				//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
 
	if(mysqli_num_rows($queryRequisition) > 0) {
		require_once("include/page_title.php"); 
		$queryRequisition  = $dblms->querylms("SELECT requisition_id, requisition_status, requisition_code, requisition_date,
													requisition_type, requisition_purpose, requisition_remarks, id_department,
													id_requester, forwarded_by, forwarded_to, date_forwarded
												FROM ".SMS_REQUISITION." 
												WHERE requisition_id != ''
												$sql2
											");
		echo'
         <div style=" float:right; text-align:right; font-weight:700; color:blue; margin-right:10px;"> 
            <form class="navbar-form navbar-left form-small" action="#" method="POST">
               Total : ('.number_format($count).')
            </form>
         </div>
         <div class="table-responsive" style="overflow: auto;">
			<table class="footable table table-bordered table-hover table-with-avatar">
				<thead>
					<tr>
						<th style="vertical-align: middle;" nowrap="nowrap"> Sr.# </th>
						<th style="vertical-align: middle;" nowrap="nowrap"> Requisition Code </th>
						<th style="vertical-align: middle;" nowrap="nowrap"> Requisition Date </th>
						<th style="vertical-align: middle;" nowrap="nowrap"> Requisition Type </th>
						<th style="vertical-align: middle;" nowrap="nowrap"> Department </th>
						<th style="vertical-align: middle;" nowrap="nowrap"> Requester </th>
						<th style="vertical-align: middle;" nowrap="nowrap"> Status</th>
						<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i> </th>
					</tr>
				</thead>
				<tbody>';
               if($page == 1) { $srno = 0; } else { $srno = ($Limit * ($page-1));}
					while($valueRequisition = mysqli_fetch_array($queryRequisition)) {
						$srno++;
						echo '
						<tr>
							<td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
							<td style="vertical-align: middle;" nowrap="nowrap">'.$valueRequisition['requisition_code'].'</td>
							<td style="vertical-align: middle;" nowrap="nowrap">'.date('d-M-Y', strtotime($valueRequisition['requisition_date'])).'</td>
							<td style="vertical-align: middle;" nowrap="nowrap">'.REQUISITION_TYPES[$valueRequisition['requisition_type']].'</td>';
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
							<td nowrap="nowrap" style="width:70px; text-align:center;">'.get_sms_status($valueRequisition['requisition_status']).'</td>
							<td nowrap="nowrap" style="text-align:center;">
								<a class="btn btn-xs btn-warning view-requisition-modal" data-toggle="modal" data-target="#viewRequisitionModal" 
									data-modal-window-title="Requisition Details" data-height="350" data-width="100%" 
									data-requisition-id="'.$valueRequisition['requisition_id'].'" data-requisition-status="'.$valueRequisition['requisition_status'].'" 
									data-requisition-code="'.$valueRequisition['requisition_code'].'" data-requisition-date="'.$valueRequisition['requisition_date'].'"
									data-requisition-type="'.$valueRequisition['requisition_type'].'" data-requisition-purpose="'.$valueRequisition['requisition_purpose'].'"
									data-requisition-remarks="'.$valueRequisition['requisition_remarks'].'" data-id-department="'.$valueRequisition['id_department'].'"
									data-id-requester="'.$valueRequisition['id_requester'].'" data-forwarded-by="'.$valueRequisition['forwarded_by'].'" data-forwarded-to="'.$valueRequisition['forwarded_to'].'"
									data-date-forwarded="'.$valueRequisition['date_forwarded'].'"
									>
									<i class="icon-zoom-in"></i>
								</a>
								';
								if($valueRequisition['requisition_status'] <= 1) {
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
		</div>';
		if($count > $Limit) {
			echo '
			<div class="widget-foot">
			   <!--WI_PAGINATION-->
			   <ul class="pagination pull-right">';
   
			   $pagination = "";
			   
			   if($lastpage > 1) {	
   
				  //previous button
				  if ($page > 1) {
					 $pagination.= '<li><a href="inventory-requisition.php?page='.$prev.$sqlstring.'">Prev</a></li>';
				  }
				  //pages	
				  if ($lastpage < 7 + ($adjacents * 3)) {	
					 //not enough pages to bother breaking it up
					 for ($counter = 1; $counter <= $lastpage; $counter++) {
						if ($counter == $page) {
						   $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
						} else {
						   $pagination.= '<li><a href="inventory-requisition.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
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
							  $pagination.= '<li><a href="inventory-requisition.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
						   }
						}
						$pagination.= '<li><a href="#"> ... </a></li>';
						$pagination.= '<li><a href="inventory-requisition.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
						$pagination.= '<li><a href="inventory-requisition.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
					 } else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
						   $pagination.= '<li><a href="inventory-requisition.php?page=1'.$sqlstring.'">1</a></li>';
						   $pagination.= '<li><a href="inventory-requisition.php?page=2'.$sqlstring.'">2</a></li>';
						   $pagination.= '<li><a href="inventory-requisition.php?page=3'.$sqlstring.'">3</a></li>';
						   $pagination.= '<li><a href="#"> ... </a></li>';
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
						   if ($counter == $page) {
							  $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
						   } else {
							  $pagination.= '<li><a href="inventory-requisition.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
						   }
						}
						$pagination.= '<li><a href="#"> ... </a></li>';
						$pagination.= '<li><a href="inventory-requisition.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
						$pagination.= '<li><a href="inventory-requisition.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
					 } else { //close to end; only hide early pages
						$pagination.= '<li><a href="inventory-requisition.php?page=1'.$sqlstring.'">1</a></li>';
						$pagination.= '<li><a href="inventory-requisition.php?page=2'.$sqlstring.'">2</a></li>';
						$pagination.= '<li><a href="inventory-requisition.php?page=3'.$sqlstring.'">3</a></li>';
						$pagination.= '<li><a href="#"> ... </a></li>';
						for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
						   if ($counter == $page) {
							  $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
						   } else {
							  $pagination.= '<li><a href="inventory-requisition.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
						   }
						}
					 }
				  }
			   //next button
			   if ($page < $counter - 1) {
				  $pagination.= '<li><a href="inventory-requisition.php?page='.$next.$sqlstring.'">Next</a></li>';
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