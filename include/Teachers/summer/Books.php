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
if(isset($_POST['submit_book'])) { 
$sqllmschecker  = $dblms->querylms("SELECT *   
										FROM ".COURSES_BOOKS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."' AND timing = '".cleanvars($_GET['timing'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' $seccursquery 
										$seccursquery AND book_name = '".cleanvars($_POST['book_name'])."'
										AND author_name = '".cleanvars($_POST['author_name'])."'  
										AND id_prg = '".cleanvars($_GET['prgid'])."' LIMIT 1");
	if(mysqli_num_rows($sqllmschecker)>0) { 
			echo '<div class="alert-box warning"><span>Warning: </span>record already exists.</div>';
	} else { 
//------------------------------------------------
	$sqllmsbook  = $dblms->querylms("INSERT INTO ".COURSES_BOOKS." (
																		status								, 
																		book_name							, 
																		author_name							,
																		edition								,
																		isbn								,
																		publisher							,
																		url									,
																		id_curs								,
																		section 							,
																		timing  							,
																		id_prg								,
																		id_teacher							,
																		academic_session					,
																		id_campus							,
																		id_added							, 
																		date_added 
																   )
	   														VALUES (
																		'".cleanvars($_POST['status'])."'			,
																		'".cleanvars($_POST['book_name'])."'		,
																		'".cleanvars($_POST['author_name'])."'		, 
																		'".cleanvars($_POST['edition'])."'			, 
																		'".cleanvars($_POST['isbn'])."'				, 
																		'".cleanvars($_POST['publisher'])."'		, 
																		'".cleanvars($_POST['url'])."'				, 
																		'".cleanvars($_POST['id_curs'])."'			,
																		'".cleanvars($section)."'					,
																		'".cleanvars($_GET['timing'])."'			, 
																		'".cleanvars($_GET['prgid'])."'				, 
																		'".cleanvars($rowsstd['emply_id'])."'		, 
																		'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 	,
																		'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 			,
																		'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'	, 
																		NOW() 
													 			 )"
							);
//--------------------------------------
		if($sqllmsbook) {
//--------------------------------------
	$logremarks = 'Add Reference Book: '.$dblms->lastestid().'-'.$_POST['book_name'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
if(isset($_POST['changes_book'])) { 
//------------------------------------------------
$sqllmsbook  = $dblms->querylms("UPDATE ".COURSES_BOOKS." SET 
															status			= '".cleanvars($_POST['status_edit'])."'
														  , book_name		= '".cleanvars($_POST['book_name_edit'])."'
														  , author_name		= '".cleanvars($_POST['author_name_edit'])."' 
														  , edition			= '".cleanvars($_POST['edition_edit'])."' 
														  , isbn			= '".cleanvars($_POST['isbn_edit'])."' 
														  , publisher		= '".cleanvars($_POST['publisher_edit'])."' 
														  , url				= '".cleanvars($_POST['url_edit'])."' 
														  , section			= '".cleanvars($section)."' 
														  , id_campus		= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
														  , id_modify		= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														  , date_modify		= NOW()
													  WHERE id				= '".cleanvars($_POST['bookid_edit'])."'");
//--------------------------------------
		if($sqllmsbook) {
//--------------------------------------
	$logremarks = 'Update Reference Book:'.$_POST['bookid_edit'].'-'.$_POST['book_name_edit'].'for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
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
			<span class="pull-left"><h3  style="font-weight:700;">Course Books</h3></span>
			<a data-toggle="modal" class="btn btn-mid btn-info pull-right" href="#cursAddBookModal"><i class="icon-plus"></i> Add Book </a>
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
	$sqllmsbook  = $dblms->querylms("SELECT id, status, id_curs, url, book_name, author_name, edition, isbn, publisher  
										FROM ".COURSES_BOOKS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  AND timing = '".cleanvars($_GET['timing'])."' 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' $seccursquery 
										AND id_prg = '".cleanvars($_GET['prgid'])."' ORDER BY id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsbook) > 0) {
echo '
<div style="clear:both;"></div>
<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;"> 
	Total: ('.number_format(mysqli_num_rows($sqllmsbook)).') 
</div>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;">Sr.#</th>
	<th style="font-weight:600;">Book Name</th>
	<th style="font-weight:600;">Author</th>
	<th style="font-weight:600;">Edition</th>
	<th style="font-weight:600;">Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srbk = 0;
//------------------------------------------------
while($rowbook = mysqli_fetch_assoc($sqllmsbook)) { 
//------------------------------------------------
$srbk++;
//------------------------------------------------
echo '
<tr>
	<td style="width:50px;">'.$srbk.'</td>
	<td>'.$rowbook['book_name'].'</td>
	<td>'.$rowbook['author_name'].'</td>
	<td>'.$rowbook['edition'].'</td>
	<td style="width:80px; text-align:center;">'.get_admstatus($rowbook['status']).'</td>
	<td style="width:90px; text-align:center;">
		<a class="btn btn-xs btn-info edit-book-modal" data-toggle="modal" data-modal-window-title="Edit Course Book" data-height="350" data-width="100%" data-bookstatus="'.$rowbook['status'].'" data-bookname="'.$rowbook['book_name'].'" data-bookauthor="'.$rowbook['author_name'].'" data-bookedition="'.$rowbook['edition'].'" data-bookisbn="'.$rowbook['isbn'].'" data-bookpublisher="'.$rowbook['publisher'].'" data-bookurl="'.$rowbook['url'].'" data-booklid="'.$rowbook['id'].'" data-target="#cursEditBookModal"><i class="icon-pencil"></i></a>
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