<?php
$adjacents 	= 3;
if(!($Limit)) { $Limit = 100; } 
if($page) { $start = ($page - 1) * $Limit; } else {	$start = 0;	}
$page = (int)$page;

$queryItem = $dblms->querylms("SELECT item_id, item_code, item_image, 
									item_title, item_status
								FROM ".SMS_ITEM." WHERE item_id != '' 
								$sql2
                            ");

$count 		= mysqli_num_rows($queryItem);
if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
$prev 		= $page - 1;							//previous page is page - 1
$next 		= $page + 1;							//next page is page + 1
$lastpage	= ceil($count/$Limit);				//lastpage is = total pages / items per page, rounded up.
$lpm1 		= $lastpage - 1;

if(mysqli_num_rows($queryItem) > 0) { 
	$queryItems  = $dblms->querylms("SELECT item_id, item_code, item_image, 
										item_title, item_status
										FROM ".SMS_ITEM." WHERE item_id != '' 
										$sql2 
										ORDER BY item_id DESC
										LIMIT ".($page-1)*$Limit .",$Limit");
	echo '
	<div style="clear:both;"></div>
	<table class="footable table table-bordered table-hover">
		<thead>
			<tr>
				<th style="font-weight:700; vertical-align: middle;" nowrap="nowrap"> Sr.# </th>
				<th style="font-weight:700; vertical-align: middle;" nowrap="nowrap"> Code </th>
				<th style="font-weight:700; vertical-align: middle;" nowrap="nowrap"> Pic </th>
				<th style="font-weight:700; vertical-align: middle;" nowrap="nowrap"> Item Name </th>
				<th style="font-weight:700; text-align: center; vertical-align: middle;" nowrap="nowrap"> Status</th>
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
					<a class="btn btn-xs btn-info" href="inventory-item.php?id='.$valueItem['item_id'].'"><i class="icon-pencil"></i></a>
					<a href="?deleteId='.$valueItem['item_id'].'" class="btn btn-xs btn-danger"><i class="icon-trash"></i></a>
				</td>
			</tr>';
		}	
		echo '
		</tbody>
	</table>';
	if($count>$Limit) {
		echo '
		<div class="widget-foot">
		   <!--WI_PAGINATION-->
		   <ul class="pagination pull-right">';
  
		   $pagination = "";
		   
		   if($lastpage > 1) {	
		   //previous button
		   if ($page > 1) {
			  $pagination.= '<li><a href="obeclos.php?page='.$prev.$sqlstring.'">Prev</a></li>';
		   }
		   //pages	
		   if ($lastpage < 7 + ($adjacents * 3)) {	
			  //not enough pages to bother breaking it up
			  for ($counter = 1; $counter <= $lastpage; $counter++) {
				 if ($counter == $page) {
					$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
				 } else {
					$pagination.= '<li><a href="obeclos.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
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
					   $pagination.= '<li><a href="obeclos.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
					}
				 }
				 $pagination.= '<li><a href="#"> ... </a></li>';
				 $pagination.= '<li><a href="obeclos.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
				 $pagination.= '<li><a href="obeclos.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
			  } else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
					$pagination.= '<li><a href="obeclos.php?page=1'.$sqlstring.'">1</a></li>';
					$pagination.= '<li><a href="obeclos.php?page=2'.$sqlstring.'">2</a></li>';
					$pagination.= '<li><a href="obeclos.php?page=3'.$sqlstring.'">3</a></li>';
					$pagination.= '<li><a href="#"> ... </a></li>';
				 for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
					if ($counter == $page) {
					   $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
					} else {
					   $pagination.= '<li><a href="obeclos.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
					}
				 }
				 $pagination.= '<li><a href="#"> ... </a></li>';
				 $pagination.= '<li><a href="obeclos.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
				 $pagination.= '<li><a href="obeclos.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
			  } else { //close to end; only hide early pages
				 $pagination.= '<li><a href="obeclos.php?page=1'.$sqlstring.'">1</a></li>';
				 $pagination.= '<li><a href="obeclos.php?page=2'.$sqlstring.'">2</a></li>';
				 $pagination.= '<li><a href="obeclos.php?page=3'.$sqlstring.'">3</a></li>';
				 $pagination.= '<li><a href="#"> ... </a></li>';
				 for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
					if ($counter == $page) {
					   $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
					} else {
					   $pagination.= '<li><a href="obeclos.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
					}
				 }
			  }
		   }
		   //next button
		   if ($page < $counter - 1) {
			  $pagination.= '<li><a href="obeclos.php?page='.$next.$sqlstring.'">Next</a></li>';
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