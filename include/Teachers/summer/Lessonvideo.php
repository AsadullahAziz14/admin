<?php 
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">';
//--------------------------------------
if(isset($_GET['section'])) {  
	$section 		= $_GET['section'];
	$seccursquery 	= " AND section = '".$_GET['section']."'";
} else { 
	$section 		= '';
	$seccursquery 	= "";
}
if(isset($_POST['submit_video'])) { 
//------------------------------------------------
	$sqllmscheck  = $dblms->querylms("SELECT id  
										FROM ".COURSES_VIDEOLESSONS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' AND caption = '".cleanvars($_POST['caption'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' $seccursquery 
										AND id_prg = '".cleanvars($_GET['prgid'])."' AND timing = '".cleanvars($_GET['timing'])."' LIMIT 1");
if(mysqli_num_rows($sqllmscheck)>0) { 
	echo '<div class="alert-box warning"><span>Notice: </span>Record already exists.</div>';
} else { 
	$sqllmsvideos  = $dblms->querylms("INSERT INTO ".COURSES_VIDEOLESSONS." (
																		status								, 
																		caption								, 
																		detail								,
																		embedcode							,
																		id_curs								,
																		section								,
																		timing								,
																		id_prg								,
																		id_teacher							,
																		academic_session					,
																		id_campus							,
																		id_added							, 
																		date_added 
																   )
	   														VALUES (
																		'".cleanvars($_POST['status'])."'			,
																		'".cleanvars($_POST['caption'])."'			,
																		'".cleanvars($_POST['detail'])."'			, 
																		'".cleanvars($_POST['embedcode'])."'		, 
																		'".cleanvars($_POST['id_curs'])."'			, 
																		'".cleanvars($section)."'					, 
																		'".cleanvars($_GET['timing'])."'			, 
																		'".cleanvars($_GET['prgid'])."'				, 
																		'".cleanvars($rowsstd['emply_id'])."'		, 
																		'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
																		'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
																		'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
																		NOW() 
													 			 )"
							);
//--------------------------------------
		if($sqllmsvideos) {
//--------------------------------------
	$logremarks = 'Add Lesson Video #: '.$dblms->lastestid().' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGS." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															id_campus				
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'				,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."'			, 
															'1'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($logremarks)."'						,
															'".cleanvars(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']))."'			
														  )
									");
			echo '<div id="infoupdated" class="alert-box success"><span>success: </span>Record added successfully.</div>';
		} 
}
//--------------------------------------
}
//--------------------------------------
if(isset($_POST['changes_video'])) { 
//------------------------------------------------
$sqllmsvideo  = $dblms->querylms("UPDATE ".COURSES_VIDEOLESSONS." SET  status	= '".cleanvars($_POST['status_edit'])."' 
														, caption			= '".cleanvars($_POST['caption_edit'])."' 
														, detail			= '".cleanvars($_POST['detail_edit'])."' 
														, embedcode			= '".cleanvars($_POST['embedcode_edit'])."' 
														, section			= '".cleanvars($section)."' 
														, timing			= '".cleanvars($_GET['timing'])."' 
														, id_campus			= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
														, id_modify			= '".$_SESSION['userlogininfo']['LOGINIDA']."' 
														, date_modify		= NOW()
													WHERE id				= '".cleanvars($_POST['videoid_edit'])."'");
//--------------------------------------
		if($sqllmsvideo) {
//--------------------------------------
	$logremarks = 'Update Lesson Video #:'.$_POST['videoid_edit'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGS." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															id_campus				
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'				,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."'			, 
															'2'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($logremarks)."'						,
															'".cleanvars(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']))."'			
														  )
									");
			echo '<div id="infoupdated" class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		}
//--------------------------------------
	}

echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Lesson Videos</h3></span>
			<a data-toggle="modal" class="btn btn-mid btn-info pull-right" href="#cursAddVideoModal"><i class="icon-plus"></i> Add Video </a>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<!--WI_MILESTONES_NAVIGATION-->

<!--WI_MILESTONES_TABLE-->
<div class="row">
<div class="col-lg-12">
  
<div class="widget wtabs">
<div class="widget-content">';
	$sqllmsvides  = $dblms->querylms("SELECT * 
										FROM ".COURSES_VIDEOLESSONS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' AND timing = '".cleanvars($_GET['timing'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' $seccursquery 
										AND id_prg = '".cleanvars($_GET['prgid'])."' ORDER BY id ASC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsvides) > 0) {
echo '
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center;">Sr.#</th>
	<th style="font-weight:600;">Title</th>
	<th style="font-weight:600;">Detail</th>
	<th style="font-weight:600;text-align:center;">Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$svido = 0;
//------------------------------------------------
while($rowvideos = mysqli_fetch_assoc($sqllmsvides)) { 
//------------------------------------------------
$svido++;
//------------------------------------------------
echo '
<tr>
	<td style="width:50px; text-align:center;">'.$svido.'</td>
	<td>'.$rowvideos['caption'].'</td>
	<td>'.$rowvideos['detail'].'</td>
	<td style="width:70px; text-align:center;">'.get_admstatus($rowvideos['status']).'</td>
	<td style="width:70px; text-align:center;">
		<a class="btn btn-xs btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>'.$rowvideos['caption'].'</b>" data-src="coursevideoview.php?id='.$rowvideos['id'].'" href="#"><i class="icon-facetime-video"></i></a> 
		<a class="btn btn-xs btn-info edit-lessonvideo-modal" data-toggle="modal" data-modal-window-title="Edit Course Announcement" data-height="350" data-width="100%" data-video-status="'.$rowvideos['status'].'" data-video-embed="'.$rowvideos['embedcode'].'" data-video-detail="'.$rowvideos['detail'].'" data-video-caption="'.$rowvideos['caption'].'" data-videoid="'.$rowvideos['id'].'" data-target="#cursEditVideoModal"><i class="icon-pencil"></i></a>
		<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="#" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a>
	</td>
</tr>';
//------------------------------------------------
}
//------------------------------------------------
echo '
</tbody>
</table>';
//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}
//------------------------------------------------
echo '

</div>
</div>
</div>
</div>

<!--WI_MILESTONES_TABLE-->
<!--WI_TABS_NOTIFICATIONS-->

</div>
<div class="clearfix"></div>
</div>
</div>
</div>'; 

?>