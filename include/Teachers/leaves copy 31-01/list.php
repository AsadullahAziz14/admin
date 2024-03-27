<?php

if(!isset($_GET['add']) && !isset($_GET['edit'])) {

    $adjacents = 3;
	if(!($Limit)) 	{ $Limit = 50; } 
	if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
	$page = (int)$page;

	$queryLeaves  = $dblms->querylms("SELECT l.id
                                            FROM ".SALARY_EMPLYS_LEAVES." l 
                                            INNER JOIN ".SALARY_EMPLYS_LEAVES_CATS." c ON l.id_cat = c.cat_id 
                                            INNER JOIN ".SALARY_EMPLYS." e ON l.id_emply = e.emply_id 
                                            INNER JOIN ".DESIGNATIONS." d ON d.designation_id = e.id_designation 
                                            WHERE l.id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])." $sql $sql2
                                            ORDER BY l.id DESC");

	$count = mysqli_num_rows($queryLeaves);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;

    $queryLeaves = $dblms->querylms("SELECT l.* , c.cat_name , c.cat_leaves_allowed , e.emply_name, d.designation_name 
                                            FROM ".SALARY_EMPLYS_LEAVES." l 
                                            INNER JOIN ".SALARY_EMPLYS_LEAVES_CATS." c ON l.id_cat = c.cat_id 
                                            INNER JOIN ".SALARY_EMPLYS." e ON l.id_emply = e.emply_id 
                                            INNER JOIN ".DESIGNATIONS." d ON d.designation_id = e.id_designation 
                                            WHERE l.id_campus = ".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])." $sql $sql2
                                            ORDER BY l.id DESC
                                            LIMIT ".($page-1)*$Limit .",$Limit");

    if(mysqli_num_rows($queryLeaves) > 0) {

        echo '
        <div style=" float:right; text-align:right; font-weight:700; color:red; margin-top:10px; margin-bottom:10px; margin-right:10px;">
            <span style="font-weight:600;color:blue; margin-right:20px;">Total Records ('.mysqli_num_rows($queryLeaves).')</span>
        </div>
        <div style="clear:both;"></div>
        <table class="footable table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="font-weight:600;width:50px;text-align:center;">Sr. #</th>
                    <th style="font-weight:600;width:250px;text-align:;">Employee Name</th>
                    <th style="font-weight:600;width:220px;text-align:;">Designation</th>
                    <th style="font-weight:600;width:90px;text-align:center;">From</th>
                    <th style="font-weight:600;width:90px;text-align:center;">To</th>
                    <th style="font-weight:600;width:;text-align:center;">Category</th>
                    <th style="font-weight:600;width:;text-align:center;">Applied For</th>
                    <th style="font-weight:600;width:300px;text-align:;">Reason</th>
                    <th style="font-weight:600;width:50px;text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody>';

            $srno = 0;
            while($valueLeave = mysqli_fetch_array($queryLeaves)) {
                
                $srno++;
                
                $canEdit = '';
                /*
                if(($_SESSION['userlogininfo']['LOGINIDA'] == 4) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '189', 'edit' => '1'))) { 
                    $canEdit = '<a href="salaryleaves.php?id='.$valueLeave['id'].'&edit" class="btn btn-xs btn-info"><i class="icon-pencil"></i></a>';
                }
                */

                echo '
                <tr>
                    <td style="text-align: center;">'.$srno.'</td>
                    <td style="font-weight:600;">'.$valueLeave['emply_name'].'</td>
                    <td>'.$valueLeave['designation_name'].'</td>
                    <td style="text-align:center;">'.date('d-m-Y', strtotime($valueLeave['leave_start_date'])).'</td>
                    <td style="text-align: center;">'.date('d-m-Y', strtotime($valueLeave['leave_end_date'])).'</td>
                    <td style="text-align: center;">'.$valueLeave['cat_name'].'</td>
                    <td style="text-align: center;">'.$valueLeave['leave_applied_for'].'</td>
                    <td>'.$valueLeave['leave_reason'].'</td>
                    <td style="text-align: center;">'.$canEdit.'</td>
                </tr>';

            }

            echo '
            </tbody>
        </table>';

        if($count > $Limit) {
            echo '
            <div class="widget-foot">
            <!--WI_PAGINATION-->
            <ul class="pagination pull-right">';
                $pagination = "";
            
                if($lastpage > 1) {	
                    //previous button
                    if ($page > 1) {
                        $pagination.= '<li><a href="salaryleaves.php?page='.$prev.$sqlstring.'">Prev</a></li>';
                    }
                    //pages	
                    if ($lastpage < 7 + ($adjacents * 3)) {	//not enough pages to bother breaking it up
                        for ($counter = 1; $counter <= $lastpage; $counter++) {
                            if ($counter == $page) {
                                $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                            } else {
                                $pagination.= '<li><a href="salaryleaves.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
                            }
                        }
                    } else if($lastpage > 5 + ($adjacents * 3))	{ //enough pages to hide some
                    //close to beginning; only hide later pages
                        if($page < 1 + ($adjacents * 3)) {
                            for ($counter = 1; $counter < 4 + ($adjacents * 3); $counter++)	{
                                if ($counter == $page) {
                                    $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                                } else {
                                    $pagination.= '<li><a href="salaryleaves.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
                                }
                            }
                            $pagination.= '<li><a href="#"> ... </a></li>';
                            $pagination.= '<li><a href="salaryleaves.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
                            $pagination.= '<li><a href="salaryleaves.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
                    } else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
                            $pagination.= '<li><a href="salaryleaves.php?page=1'.$sqlstring.'">1</a></li>';
                            $pagination.= '<li><a href="salaryleaves.php?page=2'.$sqlstring.'">2</a></li>';
                            $pagination.= '<li><a href="salaryleaves.php?page=3'.$sqlstring.'">3</a></li>';
                            $pagination.= '<li><a href="#"> ... </a></li>';
                        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                            if ($counter == $page) {
                                $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                            } else {
                                $pagination.= '<li><a href="salaryleaves.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
                            }
                        }
                        $pagination.= '<li><a href="#"> ... </a></li>';
                        $pagination.= '<li><a href="salaryleaves.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
                        $pagination.= '<li><a href="salaryleaves.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
                    } else { //close to end; only hide early pages
                        $pagination.= '<li><a href="salaryleaves.php?page=1'.$sqlstring.'">1</a></li>';
                        $pagination.= '<li><a href="salaryleaves.php?page=2'.$sqlstring.'">2</a></li>';
                        $pagination.= '<li><a href="salaryleaves.php?page=3'.$sqlstring.'">3</a></li>';
                        $pagination.= '<li><a href="#"> ... </a></li>';
                        for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
                            if ($counter == $page) {
                                $pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
                            } else {
                                $pagination.= '<li><a href="salaryleaves.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
                            }
                        }
                    }
                }
                //next button
                if ($page < $counter - 1) {
                    $pagination.= '<li><a href="salaryleaves.php?page='.$next.$sqlstring.'">Next</a></li>';
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
            <div class="widget-tabs-notification">No Result Found!</div>
        </div>';
    }

}

?>