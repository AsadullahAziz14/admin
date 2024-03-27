<?php 
//------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add']) && !isset($_GET['replyid']) && isset($_GET['topicid'])) { 
//------------------------------------------------
	$sqllmsTopic  = $dblms->querylms("SELECT topic_id, topic_status, topic_title, topic_detail, topic_minwords, 
											 topic_weekno, topic_startdate, topic_enddate, id_curs   
											FROM ".COURSES_DISTOPIC." 
											WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
											AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
											AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
											AND topic_id = '".cleanvars($_GET['topicid'])."' 
											AND id_curs = '".cleanvars($_GET['id'])."' LIMIT 1");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsTopic) > 0) {

$rowTopic = mysqli_fetch_array($sqllmsTopic);
//----------------------------------------
	if($rowTopic['topic_enddate'] >= date("Y-m-d")) {

		$mnthcls = 'hpressmonthgreen';

	} else {

		$mnthcls = 'hpressmonth';
	}
	
echo '
<!-- Row -->
<div class="tb_widget_recent_listpr clearfix">
<!-- Post item -->
	<div class="item clearfix">
		<div class="item_thumb clearfix">
		<span class="hpresstime">
			<span class="'.$mnthcls.'">Week</span>
			<span class="hpressday">'.substr($rowTopic['topic_weekno'], 6).'</span>
		</span>
		</div>
		<div class="item_content">
			<h3 style="font-weight:600; font-size:16px;">'.$rowTopic['topic_title'].'</h3>
			<p class="pull-right"><a class="btn btn-sm btn-info iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe" data-modal-window-title="<b>Topic: '.$rowTopic['topic_title'].'</b>" data-src="discussiontopicview.php?id='.$rowTopic['topic_id'].'" href="#"><i class="icon-zoom-in"></i> Read More</a>  </p>
			<p style="margin-top:10px;">Min <strong style="color:#f00;">'.$rowTopic['topic_minwords'].'</strong> word is required.</p>
			<div style="clean:both;"></div>
			<div class="item_meta pull-right clearfix" style="text-align:right; width:98%;">
				<span style="color:#888; font-size:11px;"><i class="icon-calendar"></i> Date: '.$rowTopic['topic_startdate'].' - '.$rowTopic['topic_enddate'].'</span>
			</div>
			
		</div>
	</div>
<!-- End Post item -->
</div>
<!-- Row -->';
//-----------------------------------------
	$sqllmsdiss  = $dblms->querylms("SELECT ds.id, ds.status, ds.publish, ds.message, ds.reply, ds.rating, 
											ds.date_added, ds.reply_date, ds.reply_id, std.std_id, std.std_name, 
											std.std_regno, std.std_photo,std.std_rollno, std.std_session   
											FROM ".COURSES_DISCUSSION." ds   
											INNER JOIN ".STUDENTS." std ON std.std_id = ds.id_std  
											WHERE ds.id_topic = '".cleanvars($_GET['topicid'])."' ");
	$countdiss 	= mysqli_num_rows($sqllmsdiss);
//-----------------------------------------
if(mysqli_num_rows($sqllmsdiss)>0) {
echo '
<h3 style="font-weight:600;border-bottom: 1px dotted #999; padding-bottom: 5px;">Students Discussion</h3>

<div style="font-weight:700; color:#00f; margin-top:5px;  margin-bottom:5px;" class="pull-right"> 
	Total Records: ('.mysqli_num_rows($sqllmsdiss).')
</div>

<div style="clear:both;"></div>

<table class="footable table table-bordered table-hover table-with-avatar">
<thead>
<tr>
	<th style="font-weight:600; text-align:center;">Sr.#</th>
	<th style="font-weight:600; text-align:center;">Roll #</th>
	<th style="font-weight:600;">Reg #</th>
	<th width="35px" style="text-align:center;font-weight:600;">Pic</th>
	<th style="font-weight:600;">Student Name</th>
	<th style="font-weight:600;text-align:center;">Date</th>
	<th style="font-weight:600;text-align:center;">Status</th>
	<th style="width:50px; text-align:center; font-size:14px;"> <i class="icon-reorder"></i></th>
</tr>
</thead>
<tbody>';
$srbk = 0;
//------------------------------------------------
while($itemstd =  mysqli_fetch_array($sqllmsdiss)) {
//------------------------------------------------
$srbk++;
//------------Student photo------------------------------------
if($itemstd['std_photo']) { 
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/'.$itemstd['std_photo'].'" alt="'.$itemstd['std_name'].'"/>';
} else {
	$stdphoto = '<img class="avatar-smallest image-boardered" src="images/students/default.png" alt="'.$itemstd['std_name'].'"/>';
}
// end student photo
echo '

<tr>
	<td style="width:50px; text-align:center;vertical-align:middle;">'.$srbk.'</td>
	<td style="width:55px;text-align:center;vertical-align:middle;">'.$itemstd['std_rollno'].'</td>
	<td style="vertical-align:middle;">'.$itemstd['std_regno'].'</td>
	<td style="vertical-align:middle;">'.$stdphoto.'</td>
	<td style="vertical-align:middle;"><a class="links-blue iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe"  data-modal-window-title="<b>Profile of '.$itemstd['std_name'].' ('.$itemstd['std_session'].')</b>" data-src="studentdetail.php?std_id='.$itemstd['std_id'].'" href="#">'.$itemstd['std_name'].'</a> </td>
	<td style="text-align:left;vertical-align:middle; width:60px;">'.date("d/m/Y", strtotime($itemstd['date_added'])).'</td>
	<td style="text-align:center;vertical-align:middle; width:60px;">'.get_discussionstatus($itemstd['status']).'</td>
	<td style="text-align:center;vertical-align:middle;">
		<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&view=Discussion&replyid='.$itemstd['id'].'"><i class="icon-pencil"></i></a>  
		<a class="btn btn-xs btn-success iframeModal" data-height="450" data-width="100%" data-toggle="modal" data-target="#modalIframe" data-modal-window-title="<b>'.$itemstd['std_name'].' ('.$itemstd['std_session'].') Roll #: '.$itemstd['std_rollno'].'</b>" data-src="discussionstudentview.php?id='.$itemstd['id'].'" href="#"><i class="icon-zoom-in"></i></a> 
	</td>
</tr>';
	
//------------------------------------------------
}
// end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
}
// end count discussion 
	
}
// end check if topic exist
	
}
// end check topic id