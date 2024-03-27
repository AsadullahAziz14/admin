<?php 
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">';
if(isset($_GET['section'])) {  
	$section 		= $_GET['section'];
	$seccursquery 	= " AND section = '".$_GET['section']."'";
} else { 
	$section 		= '';
	$seccursquery 	= "";
}
//--------------------------------------
if(isset($_POST['submit_lesson'])) { 
//------------------------------------------------
	$sqllmschecker  = $dblms->querylms("SELECT id, status, id_curs, weekno, detail, section  
										FROM ".COURSES_LESSONS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' AND timing = '".cleanvars($_GET['timing'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND weekno = '".cleanvars($_POST['weekno'])."'
										AND timing = '".cleanvars($_GET['timing'])."' LIMIT 1");
	if(mysqli_num_rows($sqllmschecker)>0) { 
			echo '<div class="alert-box warning"><span>Warning: </span>record already exists.</div>';
	} else { 
	$sqllmslesson = $dblms->querylms("INSERT INTO ".COURSES_LESSONS." (
																		status								, 
																		weekno								, 
																		detail								,
																		id_curs								,
																		timing								,
																		id_teacher							,
																		academic_session					,
																		id_campus							,
																		id_added							, 
																		date_added 
																   )
	   														VALUES (
																		'".cleanvars($_POST['status'])."'			,
																		'".cleanvars($_POST['weekno'])."'			,
																		'".cleanvars($_POST['detail'])."'			, 
																		'".cleanvars($_POST['id_curs'])."'			, 
																		'".cleanvars($_GET['timing'])."'			,  
																		'".cleanvars($rowsstd['emply_id'])."'		, 
																		'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
																		'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
																		'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
																		NOW() 
													 			 )"
							);
//--------------------------------------
		if($sqllmslesson) {
//--------------------------------------
	$logremarks = 'Add Weekly Lesson Plan #: '.$dblms->lastestid().' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
if(isset($_POST['changes_lesson'])) { 
//------------------------------------------------
$sqllmslesson  = $dblms->querylms("UPDATE ".COURSES_LESSONS." SET 
															status			= '".cleanvars($_POST['status_edit'])."'
														  , weekno			= '".cleanvars($_POST['weekno_edit'])."'
														  , detail			= '".cleanvars($_POST['detail_edit'])."' 
														  , timing			= '".cleanvars($_GET['timing'])."' 
														  , id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
														  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														  , date_modify		= NOW()
													  WHERE id				= '".cleanvars($_POST['lessonid_edit'])."'");
//--------------------------------------
		if($sqllmslesson) {
//--------------------------------------
	$logremarks = 'Update Weekly Lesson Plan #:'.$_POST['lessonid_edit'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
//--------------------------------------
			echo '<div id="infoupdated" class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		}
//--------------------------------------
	}

echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Weekly Lesson Plan</h3></span>
			<a data-toggle="modal" class="btn btn-mid btn-info pull-right" href="#cursAddLessonModal"><i class="icon-plus"></i> Add Lesson Plan </a>
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
	$sqllmslesson  = $dblms->querylms("SELECT id, status, id_curs, weekno, detail  
										FROM ".COURSES_LESSONS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' AND timing = '".cleanvars($_GET['timing'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' ORDER BY id ASC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmslesson) > 0) {
echo '
<div style="clear:both;"></div>
<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;"> 
	Total Weeks: ('.number_format(mysqli_num_rows($sqllmslesson)).') 
</div>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;">Week #</th>
	<th style="font-weight:600;">Lesson Detail</th>
	<th style="font-weight:600; text-align:center;">Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srbk = 0;
//------------------------------------------------
while($rowlesson = mysqli_fetch_assoc($sqllmslesson)) { 
//------------------------------------------------
$srbk++;
//------------------------------------------------
echo '
<tr>
	<td style="width:70px;">'.$rowlesson['weekno'].'</td>
	<td>'.$rowlesson['detail'].'</td>
	<td style="width:70px; text-align:center;">'.get_admstatus($rowlesson['status']).'</td>
	<td style="width:60px; text-align:center;">
		<a class="btn btn-xs btn-info edit-lesson-modal" data-toggle="modal" data-modal-window-title="Edit Weekly Lesson Plan" data-height="350" data-width="100%" data-lessonstatus="'.$rowlesson['status'].'" data-lessonweekno="'.$rowlesson['weekno'].'" data-lessondetail="'.$rowlesson['detail'].'" data-lessonid="'.$rowlesson['id'].'" data-target="#cursEditLessonModal"><i class="icon-pencil"></i></a>
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