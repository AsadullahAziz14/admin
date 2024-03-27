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
if(isset($_POST['submit_glossary'])) { 
//------------------------------------------------
$sqllmschecker  = $dblms->querylms("SELECT id, status, id_curs, weekno, detail, section  
										FROM ".COURSES_GLOSSARY." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' AND timing = '".cleanvars($_GET['timing'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										$seccursquery AND caption = '".cleanvars($_POST['caption'])."'
										AND id_prg = '".cleanvars($_GET['prgid'])."' LIMIT 1");
	if(mysqli_num_rows($sqllmschecker)>0) { 
			echo '<div class="alert-box warning"><span>Warning: </span>record already exists.</div>';
	} else { 
	$sqllmsglossary  = $dblms->querylms("INSERT INTO ".COURSES_GLOSSARY." (
																		status								, 
																		caption								, 
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
																		'".cleanvars($_POST['caption'])."'			,
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
		if($sqllmsglossary) {
//--------------------------------------
	$logremarks = 'Add Glossary #: '.$dblms->lastestid().' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
if(isset($_POST['changes_glossary'])) { 
//------------------------------------------------
$sqllmsglossary  = $dblms->querylms("UPDATE ".COURSES_GLOSSARY." SET  status	= '".cleanvars($_POST['status_edit'])."'
														, caption		= '".cleanvars($_POST['caption_edit'])."'
														, detail		= '".cleanvars($_POST['detail_edit'])."'
														, section		= '".cleanvars($section)."' 
														, timing		= '".cleanvars($_GET['timing'])."' 
														, id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."'
														, id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														, date_modify	= NOW()
													WHERE id			= '".cleanvars($_POST['glosryid_edit'])."'");
//--------------------------------------
		if($sqllmsglossary) {
//--------------------------------------
	$logremarks = 'Update Glossary #:'.$_POST['glosryid_edit'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			<span class="pull-left"><h3  style="font-weight:700;">Course Glossary</h3></span>
			<a data-toggle="modal" class="btn btn-mid btn-info pull-right" href="#cursAddGlosryModal"><i class="icon-plus"></i> Add More </a>
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
	$sqllmsglsary  = $dblms->querylms("SELECT id, status, id_curs, caption, detail, timing  
										FROM ".COURSES_GLOSSARY." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' AND timing = '".cleanvars($_GET['timing'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' $seccursquery 
										AND id_prg = '".cleanvars($_GET['prgid'])."'  ORDER BY id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsglsary) > 0) {
echo '
<div style="clear:both;"></div>
<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;"> 
	Total: ('.number_format(mysqli_num_rows($sqllmsglsary)).') 
</div>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;">Sr.#</th>
	<th style="font-weight:600;">Caption</th>
	<th style="font-weight:600;">detail</th>
	<th style="font-weight:600;">Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srgls = 0;
//------------------------------------------------
while($rowglsary = mysqli_fetch_assoc($sqllmsglsary)) { 
//------------------------------------------------
$srgls++;
//------------------------------------------------
echo '
<tr>
	<td style="width:50px;">'.$srgls.'</td>
	<td>'.$rowglsary['caption'].'</td>
	<td>'.$rowglsary['detail'].'</td>
	<td style="width:80px; text-align:center;">'.get_admstatus($rowglsary['status']).'</td>
	<td style="width:90px; text-align:center;">
		<a class="btn btn-xs btn-info edit-glsry-modal" data-toggle="modal" data-modal-window-title="Edit Glossary" data-height="350" data-width="100%" data-glsry-status="'.$rowglsary['status'].'" data-glsry-detail="'.$rowglsary['detail'].'" data-glsry-caption="'.$rowglsary['caption'].'" data-glsryid="'.$rowglsary['id'].'" data-target="#cursEditGlosryModal"><i class="icon-pencil"></i></a>
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