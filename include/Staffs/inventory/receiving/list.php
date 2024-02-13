<?php
if(!LMS_VIEW && !isset($_GET['id'])) { 
	$adjacents 	= 3;
	if(!($Limit)) { $Limit = 100; } 
	if($page) { $start = ($page - 1) * $Limit; } else {	$start = 0;	}
	$page = (int)$page;
 
	$queryReceiving = $dblms->querylms("SELECT receiving_id
										   FROM ".SMS_RECEIVING." 
										   WHERE receiving_id != ''
									 ");
	$count 		= mysqli_num_rows($queryReceiving);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);				//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
 
	if(mysqli_num_rows($queryReceiving) > 0) {
		require_once("include/page_title.php"); 
		$queryReceiving  = $dblms->querylms("SELECT receiving_id, receiving_code, receiving_date,
												receiving_status, delivery_chalan_num, id_vendor
											FROM ".SMS_RECEIVING." 
											WHERE receiving_id != '' 
											$sql2 
											ORDER BY receiving_id DESC
											LIMIT ".($page-1)*$Limit .",$Limit
										");
		echo '
		<div style=" float:right; text-align:right; font-weight:700; color:blue; margin-right:10px;"> 
			<form class="navbar-form navbar-left form-small" action="#" method="POST">
				Total : ('.number_format($count).')
			</form>
		</div> 
		<div class="table-responsive" style="overflow: auto;">
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
               if($page == 1) { $srno = 0; } else { $srno = ($Limit * ($page-1));}	
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
					 $pagination.= '<li><a href="inventory-receiving.php?page='.$prev.$sqlstring.'">Prev</a></li>';
				  }
				  //pages	
				  if ($lastpage < 7 + ($adjacents * 3)) {	
					 //not enough pages to bother breaking it up
					 for ($counter = 1; $counter <= $lastpage; $counter++) {
						if ($counter == $page) {
						   $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
						} else {
						   $pagination.= '<li><a href="inventory-receiving.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
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
							  $pagination.= '<li><a href="inventory-receiving.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
						   }
						}
						$pagination.= '<li><a href="#"> ... </a></li>';
						$pagination.= '<li><a href="inventory-receiving.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
						$pagination.= '<li><a href="inventory-receiving.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
					 } else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
						   $pagination.= '<li><a href="inventory-receiving.php?page=1'.$sqlstring.'">1</a></li>';
						   $pagination.= '<li><a href="inventory-receiving.php?page=2'.$sqlstring.'">2</a></li>';
						   $pagination.= '<li><a href="inventory-receiving.php?page=3'.$sqlstring.'">3</a></li>';
						   $pagination.= '<li><a href="#"> ... </a></li>';
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
						   if ($counter == $page) {
							  $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
						   } else {
							  $pagination.= '<li><a href="inventory-receiving.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
						   }
						}
						$pagination.= '<li><a href="#"> ... </a></li>';
						$pagination.= '<li><a href="inventory-receiving.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
						$pagination.= '<li><a href="inventory-receiving.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
					 } else { //close to end; only hide early pages
						$pagination.= '<li><a href="inventory-receiving.php?page=1'.$sqlstring.'">1</a></li>';
						$pagination.= '<li><a href="inventory-receiving.php?page=2'.$sqlstring.'">2</a></li>';
						$pagination.= '<li><a href="inventory-receiving.php?page=3'.$sqlstring.'">3</a></li>';
						$pagination.= '<li><a href="#"> ... </a></li>';
						for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
						   if ($counter == $page) {
							  $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
						   } else {
							  $pagination.= '<li><a href="inventory-receiving.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
						   }
						}
					 }
				  }
			   //next button
			   if ($page < $counter - 1) {
				  $pagination.= '<li><a href="inventory-receiving.php?page='.$next.$sqlstring.'">Next</a></li>';
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