<?php 
if(!isset($_GET['editid']) && !isset($_GET['add']) && !isset($_GET['archive'])) {
	
	$sqllmslesson  = $dblms->querylms("SELECT id, status, id_curs, weekno, detail  
										FROM ".COURSES_LESSONS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'  
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										ORDER BY id ASC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmslesson) > 0) {
echo '
<div style="clear:both;"></div>
<div class="navbar-form navbar-right" style="font-weight:700; color:#00f; margin:0 10px 0 0;"> 
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
</tr>';
$srbk = 0;
//------------------------------------------------
while($rowlesson = mysqli_fetch_assoc($sqllmslesson)) { 
//------------------------------------------------
$srbk++;
//------------------------------------------------
echo '
<tr>
	<td style="font-weight:600;text-align:center;width:70px;vertical-align:top;">
<div class="tb_widget_recent_listpr clearfix">
<!-- Post item -->
	<div class="item clearfix">
		<div class="item_thumb clearfix">
			<span class="hpresstime">
				<span class="hpressmonthgreen" >Week</span>
				<span class="hpressday">'.substr($rowlesson['weekno'], 5).'</span>
			</span>
		</div>
		
	</div>
<!-- End Post item -->
</div>
	</td>
	<td style="font-size:16px; line-height:25px; font-family:Calibri, Calibri Light;">
		'.html_entity_decode($rowlesson['detail'], ENT_QUOTES).'
	</td>
	<td style="width:50px; text-align:center;">'.get_admstatus($rowlesson['status']).'</td>
	<td style="width:70px; text-align:center;">
		<a class="btn btn-xs btn-info edit-lesson-modal" data-toggle="modal" data-modal-window-title="Edit Weekly Lesson Plan" data-height="350" data-width="100%" data-lessonstatus="'.$rowlesson['status'].'" data-lessonweekno="'.$rowlesson['weekno'].'" data-lessondetail="" data-lessonid="'.$rowlesson['id'].'" data-target="#cursEditLessonModal"><i class="icon-pencil"></i></a>
		<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="#" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a>
	</td>
</tr>';
	$sqllmslessonprgs  = $dblms->querylms("SELECT DISTINCT(clp.id_prg), clp.id, clp.id_setup, clp.semester, clp.section, clp.timing, 
										p.prg_name, p.prg_code, p.prg_id   
										FROM ".COURSES_LESSONSPROGRAM." clp 
										LEFT JOIN ".PROGRAMS." p ON p.prg_id = clp.id_prg  
										WHERE clp.id_setup = '".cleanvars($rowlesson['id'])."' ORDER BY clp.id ASC");
//------------------------------------------------
echo '
<tr>
	<td colspan="3">';
//------------------------------------------------
while($rowprgams = mysqli_fetch_assoc($sqllmslessonprgs)) { 
	
	if($rowprgams['prg_code']) {
		$prgcode = strtoupper($rowprgams['prg_code']).' Semester: '.addOrdinalNumberSuffix($rowprgams['semester']).' '.$rowprgams['section'].' ( '.get_programtiming($rowprgams['timing']).')';
	} else {
		$prgcode = 'LA: Section: '.$rowprgams['section'].' ( '.get_programtiming($rowprgams['timing']).')';
	}
	
	echo '<span style="font-weight:600; margin-right:20px; font-size:12px; color:blue;">'.$prgcode.'</span>';
}
//------------------------------------------------
echo '
	</td>
	<td style="width:70px; text-align:center;">
		<a class="btn btn-xs btn-warning" href="courses.php?id='.$_GET['id'].'&view=Lessonplan&editid='.$rowlesson['id'].'"><i class="icon-edit"></i></a> 
	</td>
</tr>';
//------------------------------------------------
}
//------------------------------------------------
echo '
</thead>
</table>
';
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