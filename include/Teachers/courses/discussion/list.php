<?php 
//------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add']) && !isset($_GET['replyid']) && !isset($_GET['topicid'])) { 
//------------------------------------------------
	$sqllmsTopic  = $dblms->querylms("SELECT topic_id, topic_status, topic_title, topic_detail, topic_minwords, 
											 topic_weekno, topic_startdate, topic_enddate, id_curs   
											FROM ".COURSES_DISTOPIC." 
											WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
											AND id_curs = '".cleanvars($_GET['id'])."' ORDER BY topic_id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsTopic) > 0) {
echo '
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center; ">Week #</th>
	<th style="font-weight:600;">Topic</th>
</tr>';
$srbk = 0;
//------------------------------------------------
while($rowTopic = mysqli_fetch_assoc($sqllmsTopic)) { 
//------------------------------------------------
$srbk++;
//------------------------------------------------
echo '
<tr>
	<th style="font-weight:600;text-align:center;width:90px;vertical-align:middle;">'.$rowTopic['topic_weekno'].'</th>
	<td style="font-size:14px; line-height:25px;">'.$rowTopic['topic_title'].'
	<div class="pull-right">'.get_admstatus($rowTopic['topic_status']).'</div>
	<div style="clear:both;"></div>
	<div class="pull-right"><span style="color:#888; font-size:11px;"><i class="icon-calendar"></i> Date: '.$rowTopic['topic_startdate'].' - '.$rowTopic['topic_enddate'].'</span>
	</div>
	<div style="clear:both;"></div>
	<div>';
	
//------------------------------------------------
	$sqllmslessonprgs  = $dblms->querylms("SELECT DISTINCT(clp.id_prg), clp.id, clp.id_topic, clp.semester, clp.section, clp.timing, 
										p.prg_name, p.prg_code, p.prg_id   
										FROM ".COURSES_DISTOPICPROGRAM." clp 
										LEFT JOIN ".PROGRAMS." p ON p.prg_id = clp.id_prg  
										WHERE clp.id_topic = '".cleanvars($rowTopic['topic_id'])."' ORDER BY clp.id ASC");
//------------------------------------------------

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
	<span class="pull-right">
		<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&view=Discussion&editid='.$rowTopic['topic_id'].'"><i class="icon-edit"></i></a> 
		<a class="btn btn-xs btn-success iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe" data-modal-window-title="<b>Topic: '.$rowTopic['topic_title'].'</b>" data-src="discussiontopicview.php?id='.$rowTopic['topic_id'].'" href="#"><i class="icon-zoom-in"></i></a> 
		<a class="btn btn-xs btn-default" href="courses.php?id='.$_GET['id'].'&view=Discussion&topicid='.$rowTopic['topic_id'].'"><i class="icon-group"></i></a>  
	</span>
	</div>
	
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
}