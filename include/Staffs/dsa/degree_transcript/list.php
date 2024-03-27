<?php 
if(!LMS_VIEW && !isset($_GET['id']) && !isset($_GET['issue_id'])) {  

	$adjacents = 3;
	if(!($Limit)) { $Limit = 50; } 
	if($page) { $start = ($page - 1) * $Limit; } else {	$start = 0;	}
	$page = (int)$page;
	
	$sqllmsStudentApplications = $dblms->querylms("SELECT sa.id 
													FROM ".DSA_APPLICATIONS." sa
													INNER JOIN ".STUDENTS." std ON std.std_id = sa.id_std 
                                                    WHERE sa.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
                                                    AND sa.is_deleted != '1' 
                                                    ORDER BY sa.status ASC, sa.dated DESC");
	$count = mysqli_num_rows($sqllmsStudentApplications);
	
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;

	if(mysqli_num_rows($sqllmsStudentApplications) > 0) {

		$sqlExport  = "SELECT sa.*, std.std_id, std.std_name, std.std_regno, std.std_photo, std.std_session, std.std_semester, std.std_timing, prg.prg_name
							FROM ".DSA_APPLICATIONS." sa
							LEFT JOIN ".DSA_APPLICATIONS_FORWARD." af ON af.id_application = sa.id
							INNER JOIN ".STUDENTS." std ON std.std_id = sa.id_std
							INNER JOIN ".PROGRAMS." prg ON prg.prg_id = std.id_prg
							WHERE sa.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
							AND sa.is_deleted != '1' 
							GROUP BY sa.id
							ORDER BY sa.status ASC, sa.dated DESC";

		//Update Application Start Date from Fee Paid Date
		$sqllmsUpdateApplicationDate  = $dblms->querylms("UPDATE ".DSA_APPLICATIONS." sa
																WHERE sa.dated = '0000-00-00' 
																AND sa.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'
																AND sa.is_deleted != '1'");

		// 13-03-2024 Start
		$sqllmsStudentApplications  = $dblms->querylms("SELECT sa.*, std.std_id, std.std_name, std.std_regno, std.std_photo, std.std_session, std.std_semester, std.std_timing
															FROM ".DSA_APPLICATIONS." sa
															LEFT JOIN ".DSA_APPLICATIONS_FORWARD." af ON af.id_application = sa.id
															INNER JOIN ".STUDENTS." std ON std.std_id = sa.id_std
															WHERE sa.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' AND sa.is_deleted != '1'
															$sql2
															GROUP BY sa.id
															ORDER BY 
																CASE 
																	WHEN sa.status = '3' THEN 1 -- Objection should come last
																	WHEN sa.status = '5' THEN 2 -- Delivered should come after Objection
																	ELSE 0 -- all other rows come before Objection and Delivered
																END,
																sa.dated DESC -- then sort by dated column in descending order
															LIMIT 
																".($page-1)*$Limit .",$Limit
													");
		// 13-03-2024 End
		if($_SESSION['userlogininfo']['LOGINTYPE'] != 8 && $_SESSION['userlogininfo']['LOGINTYPE'] != 9) {

			/*
			$queryTodayPaidApplications  = $dblms->querylms("SELECT COUNT(sa.id) as totalTodayPaid
																FROM ".DSA_APPLICATIONS." sa
																INNER JOIN ".STUDENTS." std ON std.std_id = sa.id_std
																WHERE sa.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
																AND sa.is_deleted != '1'");
			$valueTodayPaidApplications = mysqli_fetch_array($queryTodayPaidApplications);
			if($valueTodayPaidApplications['totalTodayPaid'] > 0){

				echo '
				<div class="flashmsgs" style="margin-bottom:50px; text-align:center;">
					<span class="nortification animateOpen">'.$valueTodayPaidApplications['totalTodayPaid'].' application(s) challans have been paid today.<br>
						<a href="dsadegreetranscript.php?paid_date='.date('Y-m-d').'" style="color: yellow; text-decoration: none;">Click to View</a>
					</span>
				</div>
				<div style="clear:both;"></div>';
			}
			*/
		}
		if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '190', 'add' => '1'))) { 

			
			$queryStatusWiseApplications = $dblms->querylms("SELECT COUNT(CASE WHEN sa.status = '1' then 1 else null end) totalPending,
																COUNT(CASE WHEN sa.status = '2' then 1 else null end) totalInProcess,
																COUNT(CASE WHEN sa.status = '3' then 1 else null end) totalObjection,
																COUNT(CASE WHEN sa.status IN('4','5') then 1 else null end) totalIssuedAndDelivered
																FROM ".DSA_APPLICATIONS." sa
																INNER JOIN ".STUDENTS." std ON std.std_id = sa.id_std 
																WHERE sa.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
																AND sa.is_deleted != '1'
																ORDER BY sa.dated DESC");
			$valueStatusWiseApplications = mysqli_fetch_array($queryStatusWiseApplications);
			
			echo '
			<div class="row row-sm">

				<div class="col-lg-3 col-sm-6 col-xs-12">
					<div class="bg-orange rounded overflow-hidden">
						<div class="pd-25 d-flex align-items-center">
							<i class="icon-group tx-40 lh-0 tx-white op-7"></i>
							<div class="mg-l-20">
								<p class="tx-10 tx-bold tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Total Pending</p>
								<p class="tx-30 tx-white tx-lato tx-bold mg-b-2 lh-1">'.$valueStatusWiseApplications['totalPending'].'</p>
							</div>
						</div>
					</div>
				</div>
				<!-- col-3 -->

				<div class="col-lg-3 col-sm-6 col-xs-12">
					<div class="bg-primary rounded overflow-hidden">
						<div class="pd-25 d-flex align-items-center">
							<i class="icon-group tx-40 lh-0 tx-white op-7"></i>
							<div class="mg-l-20">
								<p class="tx-10 tx-bold tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Total In-Process</p>
								<p class="tx-30 tx-white tx-lato tx-bold mg-b-2 lh-1">'.$valueStatusWiseApplications['totalInProcess'].'</p>
							</div>
						</div>
					</div>
				</div>
				<!-- col-3 -->
				
				<div class="col-lg-3 col-sm-6 col-xs-12 mg-t-20 mg-xl-t-0">
					<div class="bg-danger rounded overflow-hidden">
						<div class="pd-25 d-flex align-items-center">
							<i class="icon-group tx-40 lh-0 tx-white op-7"></i>
							<div class="mg-l-20">
								<p class="tx-10 tx-spacing-1 tx-bold tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Total Objection</p>
								<p class="tx-30 tx-white tx-lato tx-bold mg-b-2 lh-1">'.$valueStatusWiseApplications['totalObjection'].'</p>
							</div>
						</div>
					</div>
				</div>
				<!-- col-3 -->
				
				<div class="col-lg-3 col-sm-6 col-xs-12 mg-t-20 mg-sm-t-0">
					<div class="bg-success rounded overflow-hidden">
						<div class="pd-25 d-flex align-items-center">
							<i class="icon-group tx-40 lh-0 tx-white op-7"></i>
							<div class="mg-l-20">
								<p class="tx-10 tx-bold tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white mg-b-10">Total Issued/Delivered</p>
								<p class="tx-30 tx-white tx-lato tx-bold mg-b-2 lh-1">'.$valueStatusWiseApplications['totalIssuedAndDelivered'].'</p>
							</div>
						</div>
					</div>
				</div>
				<!-- col-3 -->
					
			</div>
			<!-- row -->';
		}

		echo '
		<div class="widget">
		<div class="widget-content">

		<div style=" float:right; text-align:right; font-weight:700; color:royalblue; margin-right:10px;"> 
			<span class="navbar-form navbar-left form-small">
				Total Records: ('.number_format($count).')
			</span>
			<form class="navbar-form navbar-left form-small" action="export.php" method="post" target="_blank">
				<input type="hidden" name="type" value="dsa_transcript_degree_applications">
				<input type="hidden" name="print_sql" value="'.$sqlExport.'">
				<button type="submit" class="btn btn-info">Export</button>
			</form>
		</div>
		<div style="clear:both;"></div>
		<table class="table table-bordered">
		<thead>
		<tr>
			<th style="font-weight:600;text-align:center;">Sr. #</th>
			<th style="font-weight:600;">Ref #</th>
			<th style="font-weight:700; text-align:center;" width="35px">Pic</th>
			<th style="font-weight:600;">Student Name</th>
			<th style="font-weight:600;">Application For</th>
			<th style=" font-weight:600;text-align:center;">Normal/Urgent</th>
			<th style=" font-weight:600;text-align:center;">Application Type</th>
			<th style="font-weight:600;text-align:center;">Request Date</th>
			<th style="font-weight:600;text-align:center;">Remaining Days</th>
			<th style="text-align:center;font-weight:600;">Status</th>
			<th style="width:70px; text-align:center; font-size:14px;"><i class="icon-reorder"></i></th>
		</tr>
		</thead>
		<tbody>';
		if($page ==1) { $srno = 0;} else { $srno = ($Limit * ($page-1));}
		while($valueApplication = mysqli_fetch_array($sqllmsStudentApplications)) { 

			$srno++;
			if($valueApplication['photo']){
				$studentPhoto = '<img class="avatar-smallest image-boardered" src="downloads/dsa/pictures/'.$valueApplication['photo'].'" alt="'.$valueApplication['std_name'].'"/>';

			} // 13-03-2024 start
			else {
				$studentPhoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$valueApplication['std_name'].'"/>';
			}
			
			// else{
			// 	if($valueApplication['std_photo']) { 
			// 		$studentPhoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$valueApplication['std_photo'].'" alt="'.$valueApplication['std_name'].'"/>';
			// 	} 
				

			// }
			// 13-03-2024 End

			$completePartialTranscript = '';
			if($valueApplication['degree_transcript'] == 1){
				if($valueApplication['complete_partial'] == 1){
					$completePartialTranscript = 'Final ';
				} elseif($valueApplication['complete_partial'] == 2){
					$completePartialTranscript = 'Partial ';
				}
			}

			$canEdit 			= ' ';
			$notifiedApplicant 	 = '';
			$issueLetter 		= '';
			$printLetter 		= '';
			if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '190', 'edit' => '1'))) { 

				if($valueApplication['status'] != 5){
					$canEdit = '<a class="btn btn-xs btn-info" href="dsadegreetranscript.php?id='.$valueApplication['id'].'" title="Edit Details"><i class="fa fa-edit"></i></a> ';
				}

				if($valueApplication['status'] == 4){
	
					if($valueApplication['notified_applicant'] == 1){
	
						$notifiedApplicant = '
								<form class="form-vertical" action="dsadegreetranscript.php?view=notify" method="post">
									<input type="hidden" name="id_application" id="id_application" value="'.$valueApplication['id'].'">
									<input type="hidden" name="reference_no" id="reference_no" value="'.$valueApplication['reference_no'].'">
									<input type="hidden" name="degree_transcript" id="degree_transcript" value="'.$valueApplication['degree_transcript'].'">
									<input type="hidden" name="ap_name" id="ap_name" value="'.$valueApplication['full_name'].'">
									<input type="hidden" name="ap_email" id="ap_email" value="'.$valueApplication['email'].'">
									<button class="btn btn-xs btn-success" type="submit" id="notify_applicant" name="notify_applicant" title="Re-Notify Applicant" onclick="return confirm(\'Are you sure want to re notify?\')" >Re-Send Email</button>
								</form>';
	
					} else {
	
						$notifiedApplicant = '
								<form class="form-vertical" action="dsadegreetranscript.php?view=notify" method="post">
									<input type="hidden" name="id_application" id="id_application" value="'.$valueApplication['id'].'">
									<input type="hidden" name="reference_no" id="reference_no" value="'.$valueApplication['reference_no'].'">
									<input type="hidden" name="degree_transcript" id="degree_transcript" value="'.$valueApplication['degree_transcript'].'">
									<input type="hidden" name="ap_name" id="ap_name" value="'.$valueApplication['full_name'].'">
									<input type="hidden" name="ap_email" id="ap_email" value="'.$valueApplication['email'].'">
									<button class="btn btn-xs btn-success" type="submit" id="notify_applicant" name="notify_applicant" title="Notify Applicant" onclick="return confirm(\'Are you sure want to notify?\')" >Send Email</button>
								</form>';
					}
				}
			}

			$canDelete = '';
			if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '190', 'delete' => '1'))) { 
				if($valueApplication['status'] != 4 && $valueApplication['status'] != 5){
					$canDelete = ' <a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="dsadegreetranscript.php?dc_id='.$valueApplication['id'].'&view=delete" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a>';
				}
			}
					
			$forwardTo = '';
			if($valueApplication['status'] != 5){

				$valuePendingComments['total'] = 0;
				$queryLastComment = $dblms->querylms("SELECT id
															FROM ".DSA_APPLICATIONS_FORWARD." 
															WHERE id_application = '".$valueApplication['id']."'
															AND id_added = '".$_SESSION['userlogininfo']['LOGINIDA']."'
															ORDER BY id DESC LIMIT 1");    
				if(mysqli_num_rows($queryLastComment) == 1) {

					$valueLastComment = mysqli_fetch_array($queryLastComment);

					$queryPendingComments = $dblms->querylms("SELECT COUNT(id) as total
																	FROM ".DSA_APPLICATIONS_FORWARD." 
																	WHERE id > '".$valueLastComment['id']."'
																	AND id_application = '".$valueApplication['id']."'"); 
					$valuePendingComments = mysqli_fetch_array($queryPendingComments);
				}

				$pendingComments = '';
				if($valuePendingComments['total'] > 0){
					$pendingComments = '<span style="font-weight:10px;">'.$valuePendingComments['total'].'</span>';
				}

				if($_SESSION['userlogininfo']['LOGINTYPE'] == 8 || $_SESSION['userlogininfo']['LOGINTYPE'] == 9){

					$queryHoDDeanRemarks = $dblms->querylms("SELECT id
																FROM ".DSA_APPLICATIONS_FORWARD." 
																WHERE id_application = '".$valueApplication['id']."'
																AND forwaded_to IN(".cleanvars($_SESSION['userlogininfo']['LOGINIDA']).")
																ORDER BY id DESC LIMIT 1");    
					if(mysqli_num_rows($queryHoDDeanRemarks) == 1) {
						$forwardTo = '<a class="btn btn-xs btn-warning" href="dsadegreetranscript.php?id='.$valueApplication['id'].'&view=hod_forward" title="Forward Application"><i class="fa fa-share"></i> '.$pendingComments.'</a> ';
					}

				} else {

					//$forwardTo = '<a class="btn btn-xs btn-warning edit-bcat-modal" href="#id='.$valueApplication['id'].'" data-toggle="modal" data-modal-window-title="Forward Application" data-height="350" data-width="100%" data-cat-refno="'.$valueApplication['reference_no'].'" data-cat-stdregno="'.$valueApplication['std_regno'].'" data-cat-stdname="'.$valueApplication['full_name'].'" data-cat-status="'.$valueApplication['status'].'" data-cat-semester="'.$valueApplication['std_semester'].'" data-cat-timing="'.get_programtiming($valueApplication['std_timing']).'" data-cat-for="'.$valueApplication['degree_transcript'].'" data-cat-normal-urgent="'.$valueApplication['normal_urgent'].'" data-cat-original-duplicate="'.$valueApplication['original_duplicate'].'" data-cat-id="'.$valueApplication['id'].'" data-target="#editBcatModal" title="Forward Application To"><i class="icon-reply"></i></a> ';
					$forwardTo = '<a class="btn btn-xs btn-warning" href="dsadegreetranscript.php?id='.$valueApplication['id'].'&view=forward" title="Forward Application"><i class="fa fa-share"></i> '.$pendingComments.'</a>';

				}
			}
			
			if($valueApplication['dated'] != '0000-00-00' && $valueApplication['due_date'] == '0000-00-00'){

				$sqllmsCheckDays = $dblms->querylms("SELECT type_normal_within_days, type_urgent_within_days
															FROM ".DSA_PROCESSING_FEE." 
															WHERE type_id = '".cleanvars($valueApplication['id_type'])."' AND type_status = '1'
															AND id_campus	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'
															LIMIT 1");    
				$valueCheckDays = mysqli_fetch_array($sqllmsCheckDays);

				$dueInDays = 10;
				if($valueApplication['normal_urgent'] == 1){
					$dueInDays = $valueCheckDays['type_normal_within_days'];
				} elseif($valueApplication['normal_urgent'] == 2){
					$dueInDays = $valueCheckDays['type_urgent_within_days'];
				}

				$dueDate = getWorkingDaysDate($dueInDays, $valueApplication['dated']);
	
				//Update Application Due Date
				$sqllmsUpdateApplicationDueDate  = $dblms->querylms("UPDATE ".DSA_APPLICATIONS." sa
																		SET sa.due_date = '".$dueDate."'
																		WHERE sa.id = '".$valueApplication['id']."' 
																		AND sa.due_date = '0000-00-00' 
																		AND sa.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'
																		AND sa.is_deleted != '1'");

				$valueApplication['due_date'] = $dueDate;

			}

			$dateDifference = strtotime(date('Y-m-d')) - strtotime($valueApplication['dated']);
			$applicationInProcessDays =  round( $dateDifference / (60 * 60 * 24) );

			$dateDifferenceDeliver =  (strtotime($valueApplication['due_date']) - strtotime(date('Y-m-d')));
			$applicationDeliverDays =  (int)round( $dateDifferenceDeliver / (60 * 60 * 24) );

			if($valueApplication['status'] == 3 || $valueApplication['status'] == 4 || $valueApplication['status'] == 5){
				$applicationDeliverDays = '-';
			}

			$bgColor = '';
			if($valueApplication['hod_verified'] == 1 && $valueApplication['accounts_verified'] == 2){
				$bgColor = 'style="background-color:#ECEC00 !important;"';
			} elseif($valueApplication['hod_verified'] == 1 && $valueApplication['accounts_verified'] == 1){
				$bgColor = 'style="background-color:orange !important;"';
			}

			if($applicationDeliverDays < 5 && $applicationDeliverDays != '-'){
				$bgColor = 'style="background-color:#FF7F7F !important; color:#ffffff;"';
			}

			if($valueApplication['status'] == 4){
				$bgColor = 'style="background-color:lightblue !important;"';
			}

			if($valueApplication['status'] == 5){
				$bgColor = 'style="background-color:lightgreen !important;"';
			}

			$applicationCurrentlyAt = '';
			if($valueApplication['currently_at'] != 0){
				$applicationCurrentlyAt = get_dsa_current_loc($valueApplication['currently_at']).' ';
			}

			echo '
			<tr '.$bgColor.'>
				<td style="width:50px;text-align:center;vertical-align:middle;">'.$srno.'</td>
				<td  style="width:100px;vertical-align:middle;">'.$valueApplication['reference_no'].'</td>
				<td style="vertical-align:middle;">'.$studentPhoto.'</td>
				<td  style="vertical-align:middle; font-weight:600; min-width:190px;">
					'.$valueApplication['std_regno'].'
					<div><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$valueApplication['std_name'].' ('.$valueApplication['std_session'].')</b>" data-src="studentdetail.php?std_id='.$valueApplication['std_id'].'" href="#">'.$valueApplication['full_name'].'</a></div>
					<div class="smallfont11px" style="font-weight:normal;">'.$valueApplication['mobile'].', '.$valueApplication['email'].'</div>
				</td>
				<td style="width:150px;text-align:center;vertical-align:middle;">'.$completePartialTranscript.($valueApplication['degree_transcript']).'</td>
				<td style="width:150px;text-align:center;vertical-align:middle;">'.get_dsa_regular_urgent1($valueApplication['normal_urgent']).'</td>
				<td style="width:150px;text-align:center;vertical-align:middle;">'.get_dsa_original_duplicate1($valueApplication['original_duplicate']).'</td>
				<td style="width:100px; vertical-align:middle; text-align:center;">'.date('d-m-Y', strtotime($valueApplication['dated'])).'</td>
				<td style="width:120px; vertical-align:middle; text-align:center;">'.$applicationDeliverDays.'</td>
				<td style="width:55px; vertical-align:middle; text-align:center;">'.$applicationCurrentlyAt.get_dsa_status($valueApplication['status']).'
				';
				// 13-03-2024 Start
				$sqllmsLog  = $dblms->querylms("SELECT max(l.id), l.date_added
													FROM ".DSA_APPLICATIONS_LOG." l
													WHERE l.id_application =  '".$valueApplication['id']."'
                                    		");
				if(mysqli_num_rows($sqllmsLog) > 0) {
					$valueLog = mysqli_fetch_array($sqllmsLog);	
					if($valueLog['date_added'] != NULL)
					{
						echo '<div class="smallfont11px" style="font-weight:normal;">Status Changed on: '.date('d-M-Y', strtotime($valueLog['date_added'])).'</div>';
					}
				}
				// 13-03-2024 End
				echo '</td>
				<td style="text-align:center; vertical-align:middle;">
					<a class="btn btn-xs btn-success iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe" data-modal-window-title="<b>Profile: '.$valueApplication['std_name'].' </b>" data-src="dsaapplicationview.php?id='.$valueApplication['id'].'" href="#"><i class="icon-zoom-in"></i></a>
					<a class="btn btn-xs btn-information" href="dsaforwardlogprint.php?id='.$valueApplication['id'].'" target="_blank" title="Print Forwaded Log"><i class="icon-print"></i></a>
					'.$canEdit.$forwardTo.$notifiedApplicant.$canDelete;
				echo '
				</td>
			</tr>';
		}
		//End While Loop

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
					$pagination.= '<li><a href="dsadegreetranscript.php?page='.$prev.$sqlstring.'">Prev</a></li>';
				}
				//pages	
				if ($lastpage < 7 + ($adjacents * 3)) {	//not enough pages to bother breaking it up
					for ($counter = 1; $counter <= $lastpage; $counter++) {
						if ($counter == $page) {
							$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
						} else {
							$pagination.= '<li><a href="dsadegreetranscript.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
						}
					}
				} else if($lastpage > 5 + ($adjacents * 3))	{ //enough pages to hide some
				//close to beginning; only hide later pages
					if($page < 1 + ($adjacents * 3)) {
						for ($counter = 1; $counter < 4 + ($adjacents * 3); $counter++)	{
							if ($counter == $page) {
								$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
							} else {
								$pagination.= '<li><a href="dsadegreetranscript.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
							}
						}
						$pagination.= '<li><a href="#"> ... </a></li>';
						$pagination.= '<li><a href="dsadegreetranscript.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
						$pagination.= '<li><a href="dsadegreetranscript.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
					} else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
							$pagination.= '<li><a href="dsadegreetranscript.php?page=1'.$sqlstring.'">1</a></li>';
							$pagination.= '<li><a href="dsadegreetranscript.php?page=2'.$sqlstring.'">2</a></li>';
							$pagination.= '<li><a href="dsadegreetranscript.php?page=3'.$sqlstring.'">3</a></li>';
							$pagination.= '<li><a href="#"> ... </a></li>';
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
							if ($counter == $page) {
								$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
							} else {
								$pagination.= '<li><a href="dsadegreetranscript.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
							}
						}
						$pagination.= '<li><a href="#"> ... </a></li>';
						$pagination.= '<li><a href="dsadegreetranscript.php?page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
						$pagination.= '<li><a href="dsadegreetranscript.php?page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
					} else { //close to end; only hide early pages
						$pagination.= '<li><a href="dsadegreetranscript.php?page=1'.$sqlstring.'">1</a></li>';
						$pagination.= '<li><a href="dsadegreetranscript.php?page=2'.$sqlstring.'">2</a></li>';
						$pagination.= '<li><a href="dsadegreetranscript.php?page=3'.$sqlstring.'">3</a></li>';
						$pagination.= '<li><a href="#"> ... </a></li>';
						for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
							if ($counter == $page) {
								$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
							} else {
								$pagination.= '<li><a href="dsadegreetranscript.php?page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
							}
						}
					}
				}
				//next button
				if ($page < $counter - 1) {
					$pagination.= '<li><a href="dsadegreetranscript.php?page='.$next.$sqlstring.'">Next</a></li>';
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
		<div class="widget">
			<div class="widget-content">
				<div class="col-lg-12">
					<div class="widget-tabs-notification">No Result Found</div>
				</div>
			</div>
		</div>';
	}

	echo '
	</div>
	</div>';
}