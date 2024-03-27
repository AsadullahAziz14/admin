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
if(isset($_POST['submit_assignment'])) { 
//------------------------------------------------
	$sqllmsselect  = $dblms->querylms("SELECT id, status, id_curs, caption, detail, date_start, date_end, total_marks, passing_marks   
										FROM ".COURSES_ASSIGNMENTS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' AND timing = '".cleanvars($_GET['timing'])."' 
										AND id_prg = '".cleanvars($_GET['prgid'])."' $seccursquery 
										AND caption = '".cleanvars($_POST['caption'])."' 
										AND date_end = '".cleanvars($_POST['date_end'])."' 
										AND date_start = '".cleanvars($_POST['date_start'])."' LIMIT 1");
//------------------------------------------------
if(mysqli_num_rows($sqllmsselect)>0) { 
	echo '<div class="alert-box warning"><span>success: </span>Record already exists.</div>';
} else {
	$sqllmsassign  = $dblms->querylms("INSERT INTO ".COURSES_ASSIGNMENTS." (
																		status								, 
																		caption								, 
																		detail								,
																		date_start							,
																		date_end							,
																		total_marks							,
																		passing_marks						,
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
																		'".cleanvars($_POST['date_start'])."'		, 
																		'".cleanvars($_POST['date_end'])."'			, 
																		'".cleanvars($_POST['total_marks'])."'		, 
																		'".cleanvars($_POST['passing_marks'])."'	, 
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
		if($sqllmsassign) {
	$fileid  = $dblms->lastestid();
//--------------------------------------
if(!empty($_FILES['assign_file']['name'])) { 
//--------------------------------------
	$img_dir		= "downloads/assignments/teachers/";
	$filesize		= $_FILES['assign_file']['size'];
	$img 			= explode('.', $_FILES['assign_file']['name']);
	$originalImage	= $img_dir.to_seo_url($rowsurs['curs_code']).'-'.to_seo_url(cleanvars($_POST['caption'])).'_'.$fileid.".".strtolower($img[1]);
	$img_fileName	= to_seo_url($rowsurs['curs_code']).'-'.to_seo_url(cleanvars($_POST['caption'])).'_'.$fileid.".".strtolower($img[1]);
	$extension 		= strtolower($img[1]);
if(in_array($extension , array('jpg','jpeg', 'gif', 'png', 'pdf', 'docx', 'doc', 'xlsx', 'xls'))) { 
//--------------------------------------
		$sqllmsupload  = $dblms->querylms("UPDATE ".COURSES_ASSIGNMENTS."
														SET fileattach = '".$img_fileName."'
												 WHERE  id		= '".cleanvars($fileid)."'");
		unset($sqllmsupload);
		$mode = '0644'; 
//--------------------------------------	
		move_uploaded_file($_FILES['assign_file']['tmp_name'],$originalImage);
		chmod ($originalImage, octdec($mode));
}
//--------------------------------------
}
		echo '<div id="infoupdated" class="alert-box success"><span>success: </span>Record added successfully.</div>';
		}
}
//--------------------------------------
}
//--------------------------------------
if(isset($_POST['changes_assignment'])) { 
//------------------------------------------------
$sqllmsbook  = $dblms->querylms("UPDATE ".COURSES_ASSIGNMENTS." SET 
															status			= '".cleanvars($_POST['status_edit'])."'
														  , caption			= '".cleanvars($_POST['caption_edit'])."'
														  , detail			= '".cleanvars($_POST['detail_edit'])."' 
														  , date_start		= '".cleanvars($_POST['date_start_edit'])."' 
														  , date_end		= '".cleanvars($_POST['date_end_edit'])."' 
														  , total_marks		= '".cleanvars($_POST['total_marks_edit'])."' 
														  , passing_marks	= '".cleanvars($_POST['passing_marks_edit'])."' 
														  , section 		= '".cleanvars($section)."' 
														  , timing 			= '".cleanvars($_GET['timing'])."' 
														  , id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
														  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														  , date_modify		= NOW()
													  WHERE id				= '".cleanvars($_POST['assignid_edit'])."'");
//--------------------------------------
		if($sqllmsbook) {
if(!empty($_FILES['assign_file_edit']['name'])) { 
//--------------------------------------
	$img_dir		= "downloads/assignments/teachers/";
	$filesize		= $_FILES['assign_file_edit']['size'];
	$img 			= explode('.', $_FILES['assign_file_edit']['name']);
	$originalImage	= $img_dir.to_seo_url($rowsurs['curs_code']).'-'.to_seo_url(cleanvars($_POST['caption_edit'])).'_'.$_POST['assignid_edit'].".".strtolower($img[1]);
	$img_fileName	= to_seo_url($rowsurs['curs_code']).'-'.to_seo_url(cleanvars($_POST['caption_edit'])).'_'.$_POST['assignid_edit'].".".strtolower($img[1]);
	$extension 		= strtolower($img[1]);
if(in_array($extension , array('jpg','jpeg', 'gif', 'png', 'pdf', 'docx', 'doc', 'xlsx', 'xls'))) { 
//--------------------------------------
		$sqllmsupload  = $dblms->querylms("UPDATE ".COURSES_ASSIGNMENTS."
														SET fileattach = '".$img_fileName."'
												 WHERE  id		= '".cleanvars($_POST['assignid_edit'])."'");
		unset($sqllmsupload);
		$mode = '0644'; 
//--------------------------------------	
		move_uploaded_file($_FILES['assign_file_edit']['tmp_name'],$originalImage);
		chmod ($originalImage, octdec($mode));
}
//--------------------------------------
}
			echo '<div id="infoupdated" class="alert-box notice"><span>success: </span>Record update successfully.</div>';
		}
//--------------------------------------
	}

echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Assignments</h3></span>
			<a data-toggle="modal" class="btn btn-mid btn-info pull-right" href="#cursAddAssignModal"><i class="icon-plus"></i> Add Assignment </a>
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
	$sqllmsassign  = $dblms->querylms("SELECT id, status, id_curs, caption, detail, date_start, date_end, 
										total_marks, passing_marks, fileattach, timing    
										FROM ".COURSES_ASSIGNMENTS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' AND timing = '".cleanvars($_GET['timing'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' $seccursquery 
										AND id_prg = '".cleanvars($_GET['prgid'])."' ORDER BY id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsassign) > 0) {
echo '
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center; ">Sr.#</th>
	<th style="font-weight:600;">Title</th>
	<th style="font-weight:600;text-align:center; ">Total Marks</th>
	<th style="font-weight:600;text-align:center; ">Start Date</th>
	<th style="font-weight:600;text-align:center; ">End Date</th>
	<th style="font-weight:600;text-align:center; ">Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srbk = 0;
//------------------------------------------------
while($rowassign = mysqli_fetch_assoc($sqllmsassign)) { 
//------------------------------------------------
$srbk++;
if($rowassign['fileattach']) { 
	$filedownload = '<a class="btn btn-xs btn-success" href="downloads/assignments/teachers/'.$rowassign['fileattach'].'" target="_blank"> <i class="icon-download"></i></a> ';
} else  { 
	$filedownload = ' &nbsp;&nbsp;&nbsp;&nbsp;';
}

//------------------------------------------------
echo '
<tr>
	<td style="width:40px;">'.$srbk.'</td>
	<td>'.$rowassign['caption'].'</td>
	<td style="text-align:center; width:90px;">'.$rowassign['total_marks'].'</td>
	<td style="text-align:center; width:100px;">'.date("d/m/Y", strtotime($rowassign['date_start'])).'</td>
	<td style="text-align:center; width:100px;">'.date("d/m/Y", strtotime($rowassign['date_end'])).'</td>
	<td style="width:70px; text-align:center;">'.get_admstatus($rowassign['status']).'</td>
	<td style="width:70px; text-align:center;">'.$filedownload.' 
		<a class="btn btn-xs btn-info edit-assignment-modal" data-toggle="modal" data-modal-window-title="Edit Course Assignment" data-height="350" data-width="100%" data-assignstatus="'.$rowassign['status'].'" data-assignname="'.$rowassign['caption'].'" data-assignsdat="'.$rowassign['date_start'].'" data-assignedate="'.$rowassign['date_end'].'" data-assigntotalmarks="'.$rowassign['total_marks'].'" data-assignpassingmarks="'.$rowassign['passing_marks'].'" data-assigndetail="'.$rowassign['detail'].'" data-assignid="'.$rowassign['id'].'" data-target="#cursEditAssignModal"><i class="icon-pencil"></i></a>
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