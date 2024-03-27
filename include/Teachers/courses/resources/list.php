<?php 
//------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add']) && !isset($_GET['archive'])) { 
	
	$sqlstring	= "";
	$sqltype	= "";
	
	$idtype	  = (isset($_GET['idtype']) && $_GET['idtype'] != '') ? $_GET['idtype'] : '';
	
	if($idtype) { $sqltype .= " AND id_type = '".$idtype."'"; $sqlstring .= "&idtype=".$idtype.""; }
//------------------------------------------------
$adjacents = 3;
if(!($Limit)) 	{ $Limit = 20; } 
if($page)		{ $start = ($page - 1) * $Limit; } else {	$start = 0;	}
//------------------------------------------------
	$sqllmsdwnlad  = $dblms->querylms("SELECT *    
										FROM ".COURSES_DOWNLOADS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  $sqltype 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."'  
										ORDER BY id DESC");
//--------------------------------------------------
	$count = mysqli_num_rows($sqllmsdwnlad);
	if($page == 0) { $page = 1; }						//if no page var is given, default to 1.
	$prev 		= $page - 1;							//previous page is page - 1
	$next 		= $page + 1;							//next page is page + 1
	$lastpage	= ceil($count/$Limit);					//lastpage is = total pages / items per page, rounded up.
	$lpm1 		= $lastpage - 1;
//------------------------------------------------
	$sqllmsdwnlad  = $dblms->querylms("SELECT *    
										FROM ".COURSES_DOWNLOADS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  $sqltype 
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."'  
										ORDER BY id DESC LIMIT ".($page-1)*$Limit .",$Limit");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsdwnlad) > 0) {
echo '
<div style="clear:both;"></div>
<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-top:0px;border-bottom: 1px dotted #999; padding-bottom: 5px;"> 
	Total Records: ('.number_format($count).') 
</div>
<div style="clear:both;"></div>
<!-- Row -->
<div class="tb_widget_recent_listpr clearfix">';
$srdn = 0;
//------------------------------------------------
while($rowdwnlad = mysqli_fetch_assoc($sqllmsdwnlad)) { 
//------------------------------------------------
$srdn++;

if($rowdwnlad['file']) { 
	$filedownload = '<a class="btn btn-xs btn-success" href="downloads/courses/'.$rowdwnlad['file'].'" target="_blank"> <i class="icon-download"></i></a> ';
} else  { 
	$filedownload = '';
}
	
if($rowdwnlad['id_type'] == 5) { 
	$detail = 'File Size: '.$rowdwnlad['file_size'].' Open With: '.$rowdwnlad['open_with'];
} else {
	$detail = $rowdwnlad['detail'];
}
	
if($rowdwnlad['url']) { 
	$urls = '<div><b>URL:</b> <a class="links-blue" href="'.$rowdwnlad['url'].'" target="_blank">'.$rowdwnlad['url'].'</a></div>';
} else {
	$urls = '';
}
	
if($rowdwnlad['date_modify'] != '0000-00-00 00:00:00') {
	$objetdate = '<span class="pull-right style="color:#fff !important;">Last Update: <i class="icon-time"></i> '. date("j F, Y h:i A", strtotime($rowdwnlad['date_modify'])).'</span>';
} elseif($rowdwnlad['date_added'] != '0000-00-00 00:00:00') {
	$objetdate = '<span class="pull-right style="color:#fff !important;">Last Update: <i class="icon-time"></i> '. date("j F, Y h:i A", strtotime($rowdwnlad['date_added'])).'</span>';
} else {
	$objetdate = '';
}
//------------------------------------------------
echo '
<!-- Post item -->
	<div class="item clearfix">

		<div class="item_content">
			<div class="pull-right">'.get_admstatus($rowdwnlad['status']).'</div>
			<div style="clear:both;"></div>
			<div class="pull-right" style="font-size:13px;font-weight:600;border-bottom: 1px dashed #999; padding-bottom: 5px;">
				'.get_CourseResources1($rowdwnlad['id_type']).'
			</div>
			<h3 style="font-weight:600; font-size:14px;">'.$rowdwnlad['file_name'].'</h3>
			'.$urls.'
			<div style="clear:both;"></div>
			<p>'.$detail.'</p>
			<p class="pull-right">
				'.$filedownload.'
				<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&view=Resources&editid='.$rowdwnlad['id'].'"><i class="icon-edit"></i></a> 
				<a class="btn btn-xs btn-purple iframeModal"data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>'.$rowdwnlad['file_name'].'</b>" data-src="courseresourcesview.php?id='.$rowdwnlad['id'].'" href="#"><i class="icon-zoom-in"></i></a> 
			</p>
			<div style="clear:both;"></div>';
//------------------------------------------------
	$sqllmslessonprgs  = $dblms->querylms("SELECT DISTINCT(clp.id_prg), clp.id, clp.id_setup, clp.semester, clp.section, clp.timing, 
										p.prg_name, p.prg_code, p.prg_id   
										FROM ".COURSES_DOWNLOADSPROGRAM." clp 
										LEFT JOIN ".PROGRAMS." p ON p.prg_id = clp.id_prg  
										WHERE clp.id_setup = '".cleanvars($rowdwnlad['id'])."' ORDER BY clp.id ASC");
if(mysqli_num_rows($sqllmslessonprgs)>0) {
//------------------------------------------------
echo '<div>';
//------------------------------------------------
while($rowprgams = mysqli_fetch_assoc($sqllmslessonprgs)) { 	
	if($rowprgams['prg_code']) {
		$prgcode = strtoupper($rowprgams['prg_code']).' Semester: '.addOrdinalNumberSuffix($rowprgams['semester']).' '.$rowprgams['section'].' ( '.get_programtiming($rowprgams['timing']).')';
	} else {
		$prgcode = 'LA: Section: '.$rowprgams['section'].' ( '.get_programtiming($rowprgams['timing']).')';
	}
	
	echo '<span style="font-weight:600; margin-right:20px; font-size:12px; color:blue;">'.$prgcode.'</span>';
	
}
echo '</div>';
}
//------------------------------------------------
echo '	<div style="font-size:11px;">'.$objetdate.'</div>
</div>
</div>
<!-- End Post item -->';
//------------------------------------------------
}
//------------------------------------------------
echo '
</div>';
//-----------------------------------------
if($count>$Limit) {
echo '
<div class="widget-foot">
<!--WI_PAGINATION-->
<ul class="pagination pull-right">';
//--------------------------------------------------
$pagination = "";

if($lastpage > 1) {	
//previous button
if ($page > 1) {
	$pagination.= '<li><a href="courses.php?id='.$_GET['id'].'&view=Resources&page='.$prev.$sqlstring.'">Prev</a></li>';
}
//pages	
if ($lastpage < 7 + ($adjacents * 3)) {	//not enough pages to bother breaking it up
	for ($counter = 1; $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="courses.php?id='.$_GET['id'].'&view=Resources&page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
		}
	}
} else if($lastpage > 5 + ($adjacents * 3))	{ //enough pages to hide some
//close to beginning; only hide later pages
	if($page < 1 + ($adjacents * 3)) {
		for ($counter = 1; $counter < 4 + ($adjacents * 3); $counter++)	{
			if ($counter == $page) {
				$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
			} else {
				$pagination.= '<li><a href="courses.php?id='.$_GET['id'].'&view=Resources&page='.$counter.$sqlstring.'">'.$counter.'</a></li>';
			}
		}
		$pagination.= '<li><a href="#"> ... </a></li>';
		$pagination.= '<li><a href="courses.php?id='.$_GET['id'].'&view=Resources&page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
		$pagination.= '<li><a href="courses.php?id='.$_GET['id'].'&view=Resources&page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
} else if($lastpage - ($adjacents * 3) > $page && $page > ($adjacents * 3)) { //in middle; hide some front and some back
		$pagination.= '<li><a href="courses.php?id='.$_GET['id'].'&view=Resources&page=1'.$sqlstring.'">1</a></li>';
		$pagination.= '<li><a href="courses.php?id='.$_GET['id'].'&view=Resources&page=2'.$sqlstring.'">2</a></li>';
		$pagination.= '<li><a href="courses.php?id='.$_GET['id'].'&view=Resources&page=3'.$sqlstring.'">3</a></li>';
		$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="courses.php?id='.$_GET['id'].'&view=Resources&page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
		}
	}
	$pagination.= '<li><a href="#"> ... </a></li>';
	$pagination.= '<li><a href="courses.php?id='.$_GET['id'].'&view=Resources&page='.$lpm1.$sqlstring.'">'.$lpm1.'</a></li>';
	$pagination.= '<li><a href="courses.php?id='.$_GET['id'].'&view=Resources&page='.$lastpage.$sqlstring.'">'.$lastpage.'</a></li>';	
} else { //close to end; only hide early pages
	$pagination.= '<li><a href="courses.php?id='.$_GET['id'].'&view=Resources&page=1'.$sqlstring.'">1</a></li>';
	$pagination.= '<li><a href="courses.php?id='.$_GET['id'].'&view=Resources&page=2'.$sqlstring.'">2</a></li>';
	$pagination.= '<li><a href="courses.php?id='.$_GET['id'].'&view=Resources&page=3'.$sqlstring.'">3</a></li>';
	$pagination.= '<li><a href="#"> ... </a></li>';
	for ($counter = $lastpage - (3 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
		if ($counter == $page) {
			$pagination.= '<li class="active"><a href="">'.$counter.'</a></li>';
		} else {
			$pagination.= '<li><a href="courses.php?id='.$_GET['id'].'&view=Resources&page='.$counter.$sqlstring.'">'.$counter.'</a></li>';					
		}
	}
}
}
//next button
if ($page < $counter - 1) {
	$pagination.= '<li><a href="courses.php?id='.$_GET['id'].'&view=Resources&page='.$next.$sqlstring.'">Next</a></li>';
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
//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}
}