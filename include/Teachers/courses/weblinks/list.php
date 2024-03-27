<?php 
//------------------------------------------------
if(!isset($_GET['editid']) && !isset($_GET['add']) && !isset($_GET['archive'])) { 
//------------------------------------------------
	$sqllmsweblink  = $dblms->querylms("SELECT * 
										FROM ".COURSES_LINKS." cl 
										WHERE cl.id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND cl.academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND cl.id_curs = '".cleanvars($_GET['id'])."' 
										AND cl.id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										ORDER BY cl.id DESC");
//--------------------------------------------------
if (mysqli_num_rows($sqllmsweblink) > 0) {
echo '
<div style="clear:both;"></div>
<div class="navbar-form navbar-right" style="font-weight:700; color:blue; margin-right:10px; margin-top:0px;padding:0;"> 
	Total: ('.number_format(mysqli_num_rows($sqllmsweblink)).') 
</div>
<div style="clear:both;"></div>
<table class="footable table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600;">Sr.#</th>
	<th style="font-weight:600;">URL</th>
	<th style="font-weight:600;">Detail</th>
	<th style="font-weight:600;text-align:center">Status</th>
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
	<td style="width:40px;text-align:center;">'.$srwl.'</td>
	<td style="width:200px;"><a href="'.$rowweblink['url'].'" target="_blank" class="links-blue">'.$rowweblink['url'].'</a></td>
	<td>'.$rowweblink['detail'].'</td> 
	<td style="width:50px; text-align:center;">'.get_admstatus($rowweblink['status']).'</td>
	<td style="width:50px; text-align:center;">
		<a class="btn btn-xs btn-info edit-weblink-modal" data-toggle="modal" data-modal-window-title="Edit Web Link" data-height="350" data-width="100%" data-weblink-status="'.$rowweblink['status'].'" data-weblink-detail="'.$rowweblink['detail'].'" data-weblink-url="'.$rowweblink['url'].'" data-weblid="'.$rowweblink['id'].'" data-target="#cursEditWeblinkModal"><i class="icon-pencil"></i></a>
		<a class="btn btn-xs btn-danger delete-fee-modal bootbox-confirm" href="#" data-popconfirm-yes="Yes" data-popconfirm-no="No" data-popconfirm-title="Are you sure?"> <i class="icon-trash"></i></a>
	</td>
</tr>';
//------------------------------------------------
	$sqllmslessonprgs  = $dblms->querylms("SELECT DISTINCT(clp.id_prg), clp.id, clp.id_setup, clp.semester, clp.section, clp.timing, 
										p.prg_name, p.prg_code, p.prg_id   
										FROM ".COURSES_LINKSPROGRAM." clp 
										INNER JOIN ".PROGRAMS." p ON p.prg_id = clp.id_prg  
										WHERE clp.id_setup = '".cleanvars($rowweblink['id'])."' ORDER BY clp.id ASC");
//------------------------------------------------
echo '
<tr>
	<td colspan="4"><b>Programs:</b>';
//------------------------------------------------
while($rowprgams = mysqli_fetch_assoc($sqllmslessonprgs)) { 	
	
	echo '<span style="font-weight:600; margin-left:20px; font-size:12px; color:blue;">'.strtoupper($rowprgams['prg_code']).' '.addOrdinalNumberSuffix($rowprgams['semester']).' '.$rowprgams['section'].' ( '.get_programtiming($rowprgams['timing']).')</span>';
}
//------------------------------------------------
echo '
	</td>
	<td style="width:50px; text-align:center;">
		<a class="btn btn-xs btn-info" href="courses.php?id='.$_GET['id'].'&view=Weblinks&editid='.$rowweblink['id'].'"><i class="icon-edit"></i></a> 
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