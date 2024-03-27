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
if(isset($_POST['submit_weblink'])) { 
$sqllmscheck  = $dblms->querylms("SELECT id 
										FROM ".COURSES_LINKS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' AND timing = '".cleanvars($_GET['timing'])."' 
										AND url = '".cleanvars($_POST['url'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' $seccursquery  
										AND id_prg = '".cleanvars($_GET['prgid'])."' LIMIT 1");
if(mysqli_num_rows($sqllmscheck)>0) { 
	echo '<div class="alert-box warning"><span>Notice: </span>Record already exists.</div>';
} else { 
//------------------------------------------------
	$sqllmsweblink  = $dblms->querylms("INSERT INTO ".COURSES_LINKS." (
																		status								, 
																		url									, 
																		detail								,
																		id_curs								,
																		section 							,
																		timing	 							,
																		id_prg								,
																		id_teacher							,
																		academic_session					,
																		id_campus							,
																		id_added							, 
																		date_added 
																   )
	   														VALUES (
																		'".cleanvars($_POST['status'])."'			,
																		'".cleanvars($_POST['url'])."'				,
																		'".cleanvars($_POST['detail'])."'			, 
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
		if($sqllmsweblink) {
//--------------------------------------
	$logremarks = 'Add Web Link #: '.$dblms->lastestid().' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
if(isset($_POST['changes_weblink'])) { 
//------------------------------------------------
$sqllmsweblink  = $dblms->querylms("UPDATE ".COURSES_LINKS." SET  status	= '".cleanvars($_POST['status_edit'])."'
														, url				= '".cleanvars($_POST['url_edit'])."'
														, detail			= '".cleanvars($_POST['detail_edit'])."'
														, section			= '".cleanvars($section)."'		
														, timing			= '".cleanvars($_GET['timing'])."'		
														, id_campus			= '".$_SESSION['userlogininfo']['LOGINIDCOM']."'
														, id_modify			= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														, date_modify		= NOW()
													WHERE id				= '".cleanvars($_POST['weblid_edit'])."'");
//--------------------------------------
		if($sqllmsweblink) {
//--------------------------------------
	$logremarks = 'Update Web Link #:'.$_POST['weblid_edit'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			<span class="pull-left"><h3  style="font-weight:700;">Course Web Links</h3></span>
			<a data-toggle="modal" class="btn btn-mid btn-info pull-right" href="#cursAddWeblinkModal"><i class="icon-plus"></i> Add More </a>
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
	$sqllmsweblink  = $dblms->querylms("SELECT id, status, id_curs, url, detail 
										FROM ".COURSES_LINKS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' AND timing = '".cleanvars($_GET['timing'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' $seccursquery  
										AND id_prg = '".cleanvars($_GET['prgid'])."' ORDER BY id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsweblink) > 0) {
echo '
<div style="clear:both;"></div>
<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;"> 
	Total: ('.number_format(mysqli_num_rows($sqllmsweblink)).') 
</div>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;">Sr.#</th>
	<th style="font-weight:600;">URL</th>
	<th style="font-weight:600;">detail</th>
	<th style="font-weight:600;">Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srwl = 0;
//------------------------------------------------
while($rowweblink = mysqli_fetch_assoc($sqllmsweblink)) { 
//------------------------------------------------
$srwl++;
//------------------------------------------------
echo '
<tr>
	<td style="width:50px;">'.$srwl.'</td>
	<td>'.$rowweblink['url'].'</td>
	<td>'.$rowweblink['detail'].'</td>
	<td style="width:80px; text-align:center;">'.get_admstatus($rowweblink['status']).'</td>
	<td style="width:90px; text-align:center;">
		<a class="btn btn-xs btn-info edit-weblink-modal" data-toggle="modal" data-modal-window-title="Edit Web Link" data-height="350" data-width="100%" data-weblink-status="'.$rowweblink['status'].'" data-weblink-detail="'.$rowweblink['detail'].'" data-weblink-url="'.$rowweblink['url'].'" data-weblid="'.$rowweblink['id'].'" data-target="#cursEditWeblinkModal"><i class="icon-pencil"></i></a>
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