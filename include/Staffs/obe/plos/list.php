<?php 
$adjacents 	= 3;
if(!($Limit)) { $Limit = 100; } 
if($page) { $start = ($page - 1) * $Limit; } else {	$start = 0;	}
$page = (int)$page;

$queryPLO = $dblms->querylms("SELECT plo.plo_id 
									FROM ".OBE_PLOS." as plo
									INNER JOIN ".PROGRAMS." as prg ON prg.prg_id = plo.id_prg 
									WHERE plo.plo_id != '' 
									$sql2 
									AND plo.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
									ORDER BY plo.id_prg ASC, plo.plo_number ASC");

$count 		= mysqli_num_rows($queryPLO);
if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
$prev 		= $page - 1;							//previous page is page - 1
$next 		= $page + 1;							//next page is page + 1
$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
$lpm1 		= $lastpage - 1;

if(mysqli_num_rows($queryPLO) > 0) 
{

	$queryPLO = $dblms->querylms("SELECT plo.plo_id, plo.plo_status, plo.plo_number, plo.plo_statement, plo.id_prg, prg.prg_name 
										FROM ".OBE_PLOS." as plo
										INNER JOIN ".PROGRAMS." as prg ON prg.prg_id = plo.id_prg 
										WHERE plo.plo_id != '' $sql2 
										AND plo.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										ORDER BY plo.id_prg ASC, plo.plo_number ASC LIMIT ".($page-1)*$Limit .",$Limit");
	echo '
	<div style=" float:right; text-align:right; font-weight:700; color:blue; margin-right:10px;"> 
		<form class="navbar-form navbar-left form-small" action="#" method="POST">
			Total : ('.number_format($count).')
		</form>
	</div>
	<div style="clear:both;"></div>
	<table class="table table-bordered table-hover">
	<thead>
	<tr>
		<th style="font-weight:600; text-align:center;">Sr. #</th>
		<th style="font-weight:600;">PLO #</th>
		<th style="font-weight:600;">PLO Statement</th>
		<th style="font-weight:600;">Program</th>
		<th style="font-weight:600; text-align:center;">Status</th>
		<th style="width:50px; text-align:center; font-size:14px;"><i class="icon-reorder"></i></th>
	</tr>
	</thead>
	<tbody>';
	if($page == 1) { $srno = 0; } else { $srno = ($Limit * ($page-1));}
	
	while($valuePLO = mysqli_fetch_array($queryPLO)) 
	{
		$srno++;

		$canEdit = ' ';
		if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'edit' => '1'))) 
		{ 
			$canEdit = '<a class="btn btn-xs btn-info edit-prgm-modal" data-toggle="modal" data-modal-window-title="Edit PLO" data-height="350" data-width="100%" data-plo-id="'.$valuePLO['plo_id'].'" data-plo-status="'.$valuePLO['plo_status'].'" data-plo-number="'.$valuePLO['plo_number'].'" data-plo-statement="'.$valuePLO['plo_statement'].'" data-plo-prg="'.$valuePLO['id_prg'].'" data-target="#editPLOModal"><i class="icon-pencil"></i></a> ';
		}

		$canDelete = ' ';
		if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '19', 'delete' => '1'))) 
		{ 
			$canDelete =  ' <a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="obeplos.php?id='.$valuePLO['plo_id'].'&view=delete" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a>';
		}
		
		echo '
		<tr>
			<td style="text-align:center; width:50px;">'.$srno.'</td>
			<td style="width:70px;text-align:center;">'.$valuePLO['plo_number'].'</td>
			<td>'.$valuePLO['plo_statement'].'</td>
			<td style="width:300px;">'.$valuePLO['prg_name'].'</td>
			<td style="width:80px;text-align:center;">'.get_status($valuePLO['plo_status']).'</td>
			<td style="text-align:center;">'.$canEdit.$canDelete;
			echo '
			</td>
		</tr>';
	}
	//End While Loop
	echo '
	</tbody>
	</table>';
	if($count>$Limit) 
	{
		echo '
		<div class="widget-foot">
			<!--WI_PAGINATION-->
			<ul class="pagination pull-right">';

			$pagination = "";
			
			if($lastpage > 1) {	
			//previous button
			if ($page > 1) {
				$pagination.= '<li><a href="obeplos.php?page='.$prev.$sqlstring.'">Prev</a></li>';
			}
			//pages	
			if ($lastpage < 7 + ($adjacents * 3)) {	
				//not enough pages to bother breaking it up
				for ($counter = 1; $counter <= $lastpage; $counter++) {
					if ($counter == $page) {
						$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
					} else {
						$pagination.= '<li><a href="obeplos.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
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
							$pagination.= '<li><a href="obeplos.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
						}
					}
					$pagination.= '<li><a href="#"> ... </a></li>';
					$pagination.= '<li><a href="obeplos.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
					$pagination.= '<li><a href="obeplos.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
				} else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
						$pagination.= '<li><a href="obeplos.php?page=1'.$sqlstring.'">1</a></li>';
						$pagination.= '<li><a href="obeplos.php?page=2'.$sqlstring.'">2</a></li>';
						$pagination.= '<li><a href="obeplos.php?page=3'.$sqlstring.'">3</a></li>';
						$pagination.= '<li><a href="#"> ... </a></li>';
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
						if ($counter == $page) {
							$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
						} else {
							$pagination.= '<li><a href="obeplos.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
						}
					}
					$pagination.= '<li><a href="#"> ... </a></li>';
					$pagination.= '<li><a href="obeplos.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
					$pagination.= '<li><a href="obeplos.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
				} else { //close to end; only hide early pages
					$pagination.= '<li><a href="obeplos.php?page=1'.$sqlstring.'">1</a></li>';
					$pagination.= '<li><a href="obeplos.php?page=2'.$sqlstring.'">2</a></li>';
					$pagination.= '<li><a href="obeplos.php?page=3'.$sqlstring.'">3</a></li>';
					$pagination.= '<li><a href="#"> ... </a></li>';
					for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
						if ($counter == $page) {
							$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
						} else {
							$pagination.= '<li><a href="obeplos.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
						}
					}
				}
			}
			//next button
			if ($page < $counter - 1) {
				$pagination.= '<li><a href="obeplos.php?page='.$next.$sqlstring.'">Next</a></li>';
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