<?php 
//------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add']) && !isset($_GET['topicid'])) { 
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
<div style="clear:both;"></div>
<!-- Row -->
<div class="tb_widget_recent_listpr clearfix">

<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;text-align:center; ">Sr.#</th>
	<th style="font-weight:600;">Topic</th>
	<th style="font-weight:600;text-align:center; ">Week #</th>
	<th style="font-weight:600;text-align:center; ">Start Date</th>
	<th style="font-weight:600;text-align:center; ">End Date</th>
	<th style="font-weight:600;text-align:center; ">Min Words</th>
	<th style="font-weight:600;text-align:center; ">Status</th>
	<th style="width:55px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srbk = 0;
//------------------------------------------------
while($rowTopic = mysqli_fetch_assoc($sqllmsTopic)) { 
//------------------------------------------------
$srbk++;
//------------------------------------------------
echo '
<tr>
	<td style="width:40px;text-align:center;vertical-align: middle;">'.$srbk.'</td>
	<td style="vertical-align: middle;">'.$rowTopic['topic_title'].'</td>
	<td style="text-align:center; width:80px;vertical-align: middle;">'.$rowTopic['topic_weekno'].'</td>
	<td style="text-align:center; width:90px;vertical-align: middle;">'.date("d/m/Y", strtotime($rowTopic['topic_startdate'])).'</td>
	<td style="text-align:center; width:90px;vertical-align: middle;">'.date("d/m/Y", strtotime($rowTopic['topic_enddate'])).'</td>
	<td style="width:90px; text-align:center;vertical-align: middle;">'.($rowTopic['topic_minwords']).'</td>
	<td style="width:60px; text-align:center;vertical-align: middle;">'.get_admstatus($rowTopic['topic_status']).'</td>
	<td style="text-align:center;vertical-align: middle;"> 
		<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&view=Discussion&editid='.$rowTopic['topic_id'].'"><i class="icon-edit"></i></a> 
		<a class="btn btn-xs btn-success iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe" data-modal-window-title="<b>Topic: '.$rowTopic['topic_title'].'</b>" data-src="discussiontopicview.php?id='.$rowTopic['topic_id'].'" href="#"><i class="icon-zoom-in"></i></a> 
	</td>
</tr>';
//------------------------------------------------
	$sqllmslessonprgs  = $dblms->querylms("SELECT DISTINCT(clp.id_prg), clp.id, clp.id_topic, clp.semester, clp.section, clp.timing, 
										p.prg_name, p.prg_code, p.prg_id   
										FROM ".COURSES_DISTOPICPROGRAM." clp 
										INNER JOIN ".PROGRAMS." p ON p.prg_id = clp.id_prg  
										WHERE clp.id_topic = '".cleanvars($rowTopic['topic_id'])."' ORDER BY clp.id ASC");
//------------------------------------------------
echo '
<tr>
	<td colspan="7"><b>Programs:</b>';
//------------------------------------------------
while($rowprgams = mysqli_fetch_assoc($sqllmslessonprgs)) { 	
	
	echo '<span style="font-weight:600; margin-left:20px; font-size:12px; color:blue;">'.strtoupper($rowprgams['prg_code']).' '.addOrdinalNumberSuffix($rowprgams['semester']).' '.$rowprgams['section'].' ( '.get_programtiming($rowprgams['timing']).')</span>';
}
//------------------------------------------------
echo '
	</td>
	<td style="width:50px; text-align:center;">
		<a class="btn btn-xs btn-purple" href="courses.php?id='.$_GET['id'].'&view=Discussion&topicid='.$rowTopic['topic_id'].'"><i class="icon-group"></i></a>  
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