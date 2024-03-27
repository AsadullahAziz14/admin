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
if(isset($_POST['submit_dwnlad'])) { 
//------------------------------------------------
	$sqllmscheck  = $dblms->querylms("SELECT id  
										FROM ".COURSES_DOWNLOADS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' AND timing = '".cleanvars($_GET['timing'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND id_prg = '".cleanvars($_GET['prgid'])."' 
										AND file_name = '".cleanvars($_POST['file_name'])."' $seccursquery  LIMIT 1");

if(mysqli_num_rows($sqllmscheck)>0) { 
	echo '<div class="alert-box warning"><span>Notice: </span>Record already exists.</div>';
} else { 
	$sqllmsbook  = $dblms->querylms("INSERT INTO ".COURSES_DOWNLOADS." (
																		status								, 
																		file_name							, 
																		open_with							,
																		detail								,
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
																		'".cleanvars($_POST['file_name'])."'		,
																		'".cleanvars($_POST['open_with'])."'		, 
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
		if($sqllmsbook) {
	$fileid  = $dblms->lastestid();

//--------------------------------------
if(!empty($_FILES['dwnl_file']['name'])) { 
//--------------------------------------
	$img_dir		= "downloads/courses/";
	$filesize		= $_FILES['dwnl_file']['size'];
	$img 			= explode('.', $_FILES['dwnl_file']['name']);
	$originalImage	= $img_dir.to_seo_url($rowsurs['curs_code']).'-'.to_seo_url(cleanvars($_POST['file_name'])).'_'.$fileid.".".strtolower($img[1]);
	$img_fileName	= to_seo_url($rowsurs['curs_code']).'-'.to_seo_url(cleanvars($_POST['file_name'])).'_'.$fileid.".".strtolower($img[1]);
	$extension 		= strtolower($img[1]);
//--------------------------------------
		$sqllmsupload  = $dblms->querylms("UPDATE ".COURSES_DOWNLOADS."
														SET file_size = '".formatSizeUnits($filesize)."'
														, file  = '".$img_fileName."'
												 WHERE  id		= '".cleanvars($fileid)."'");
		unset($sqllmsupload);
		$mode = '0644'; 
//--------------------------------------	
		move_uploaded_file($_FILES['dwnl_file']['tmp_name'],$originalImage);
		chmod ($originalImage, octdec($mode));
//--------------------------------------
}
//--------------------------------------
	$logremarks = 'Add Download File: '.$fileid.'-'.$_POST['file_name'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
//--------------------------------------
			echo '<div id="infoupdated" class="alert-box success"><span>success: </span>Record added successfully.</div>';
		}
}
//--------------------------------------
}
//--------------------------------------
if(isset($_POST['changes_dwnlad'])) { 
//------------------------------------------------
$sqllmsdwnlad  = $dblms->querylms("UPDATE ".COURSES_DOWNLOADS." SET 
															status			= '".cleanvars($_POST['status_edit'])."'
														  , file_name		= '".cleanvars($_POST['file_name_edit'])."' 
														  , open_with		= '".cleanvars($_POST['open_with_edit'])."' 
														  , detail			= '".cleanvars($_POST['detail_edit'])."' 
														  , section			= '".cleanvars($section)."' 
														  , timing			= '".cleanvars($_GET['timing'])."' 
														  , id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
														  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														  , date_modify		= NOW()
													  WHERE id				= '".cleanvars($_POST['dwnldid_edit'])."'");
//--------------------------------------
		if($sqllmsdwnlad) {
//--------------------------------------
if(!empty($_FILES['dwnl_file']['name'])) { 
//--------------------------------------
	$img_dir		= "downloads/courses/";
	$filesize		= $_FILES['dwnl_file']['size'];
	$img 			= explode('.', $_FILES['dwnl_file']['name']);
	$originalImage	= $img_dir.to_seo_url($rowsurs['curs_code']).'-'.to_seo_url(cleanvars($_POST['file_name_edit'])).'_'.$_POST['dwnldid_edit'].".".strtolower($img[1]);
	$img_fileName	= to_seo_url($rowsurs['curs_code']).'-'.to_seo_url(cleanvars($_POST['file_name_edit'])).'_'.$_POST['dwnldid_edit'].".".strtolower($img[1]);
	$extension 		= strtolower($img[1]);
//--------------------------------------
		$sqllmsupload  = $dblms->querylms("UPDATE ".COURSES_DOWNLOADS."
														SET file_size = '".formatSizeUnits($filesize)."'
														, file  = '".$img_fileName."'
												 WHERE  id		= '".cleanvars($_POST['dwnldid_edit'])."'");
		unset($sqllmsupload);
		$mode = '0644'; 
//--------------------------------------	
		move_uploaded_file($_FILES['dwnl_file']['tmp_name'],$originalImage);
		chmod ($originalImage, octdec($mode));
//--------------------------------------
}
//--------------------------------------
	$logremarks = 'Update Download File:'.$_POST['dwnldid_edit'].'-'.$_POST['file_name_edit'].'for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'					,
															'".strstr(basename($_SERVER['REQUEST_URI']), '.php', true)."'			, 
															'2'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($logremarks)."'				,
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
			<span class="pull-left"><h3  style="font-weight:700;">Downloads</h3></span>
			<a data-toggle="modal" class="btn btn-mid btn-info pull-right" href="#cursAddDwnldModal"><i class="icon-plus"></i> Add Record </a>
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
	$sqllmsdwnlad  = $dblms->querylms("SELECT id, status, id_curs, file_name, file_size, open_with, detail, file   
										FROM ".COURSES_DOWNLOADS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' AND timing = '".cleanvars($_GET['timing'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND id_prg = '".cleanvars($_GET['prgid'])."' ORDER BY id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsdwnlad) > 0) {
echo '
<div style="clear:both;"></div>
<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;"> 
	Total: ('.number_format(mysqli_num_rows($sqllmsdwnlad)).') 
</div>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;">Sr.#</th>
	<th style="font-weight:600;">File Name</th>
	<th style="font-weight:600;">Size</th>
	<th style="font-weight:600;">Open With</th>
	<th style="font-weight:600; text-align:center;">Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srdn = 0;
//------------------------------------------------
while($rowdwnlad = mysqli_fetch_assoc($sqllmsdwnlad)) { 
//------------------------------------------------
$srdn++;

if($rowdwnlad['file']) { 
	$filedownload = '<a class="btn btn-xs btn-success" href="downloads/courses/'.$rowdwnlad['file'].'" target="_blank"> <i class="icon-download"></i></a> ';
} else  { 
	$filedownload = ' &nbsp;&nbsp;&nbsp;&nbsp;';
}

//------------------------------------------------
echo '
<tr>
	<td style="width:50px;">'.$srdn.'</td>
	<td>'.$rowdwnlad['file_name'].'</td>
	<td>'.$rowdwnlad['file_size'].'</td>
	<td>'.$rowdwnlad['open_with'].'</td>
	<td style="width:70px; text-align:center;">'.get_admstatus($rowdwnlad['status']).'</td>
	<td style="width:70px; text-align:center;">'.$filedownload.'
		<a class="btn btn-xs btn-info edit-Dwnld-modal" data-toggle="modal" data-modal-window-title="Edit Course Download" data-height="350" data-width="100%" data-Dwnldstatus="'.$rowdwnlad['status'].'" data-Dwnldfilename="'.$rowdwnlad['file_name'].'" data-Dwnldopenwith="'.$rowdwnlad['open_with'].'" data-Dwnlddetail="'.$rowdwnlad['detail'].'" data-Dwnldid="'.$rowdwnlad['id'].'" data-target="#cursEditDwnldModal"><i class="icon-pencil"></i></a>
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