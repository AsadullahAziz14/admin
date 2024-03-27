<?php 
//------------------------------------------------------
	$sqllmstotalmems  	= $dblms->querylms("SELECT COUNT(id) AS totalmem FROM ".MEMBERS."");
	$valuetotalmemes	= mysql_fetch_array($sqllmstotalmems);

	$sqllmstoalcaps		= $dblms->querylms("SELECT  SUM(halqa_capacity) AS total 
										FROM ".HALQAS." 
										WHERE  halqa_status = '1'"); 
    $totalcaps			= mysql_fetch_array($sqllmstoalcaps);
//------------------------------------------------------
	$sqllmstotalmale  	= $dblms->querylms("SELECT COUNT(id) AS totalmem FROM ".MEMBERS." WHERE gender = 'Male'");
	$valuetotalmales	= mysql_fetch_array($sqllmstotalmale);

	$sqllmstoalmcaps	= $dblms->querylms("SELECT  SUM(halqa_capacity) AS total 
										FROM ".HALQAS." 
										WHERE  halqa_status = '1' AND id_campus = '1'"); 
    $totalmalecaps		= mysql_fetch_array($sqllmstoalmcaps);

//------------------------------------------------------
	$sqllmstotalfmale  	= $dblms->querylms("SELECT COUNT(id) AS totalmem FROM ".MEMBERS." WHERE gender = 'Female'");
	$valuetotalfmales	= mysql_fetch_array($sqllmstotalfmale);

	$sqllmstoalfcaps	= $dblms->querylms("SELECT  SUM(halqa_capacity) AS total 
										FROM ".HALQAS." 
										WHERE  halqa_status = '1' AND id_campus = '2'"); 
    $totalfemalecaps	= mysql_fetch_array($sqllmstoalfcaps);
//------------------------------------------------------
echo '
<!--WI_HEADING_BAR-->
<div class="container">
<!--Start WI_STATS_TOP-->
<div class="row">
<!-- Total Income-->
<div class="col-lg-4 col-sm-6 col-xs-12 url-link" data-link="">
	<div class="box-content dashboard-top-stats display-table no-border">
		<div class="col-xs-3 display-cell no-padding"> <i class="icon-group dashboard-top-stats-icon bg-info"></i> </div>
		<div class="col-xs-3 display-cell no-padding">
			<div class="dashboard-top-stats-heading" style="text-align:left; margin-top:0; font-weight:700;">Grand Total</div>
			<div class="dashboard-top-stats-value"></div>
		</div>
		<div class="col-xs-3 display-cell no-padding">
			<div class="dashboard-top-stats-heading" style="font-size:11px; font-weight:700;">Capacity</div>
			<div class="dashboard-top-stats-value">'.number_format($totalcaps['total']).'</div>
		</div>
		<div class="col-xs-3 display-cell no-padding">
			<div class="dashboard-top-stats-heading" style="font-size:11px; font-weight:700;">Booking</div>
			<div class="dashboard-top-stats-value">'.number_format($valuetotalmemes['totalmem']).'</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- /Total Income-->
<!--  last 30 days Income-->
<div class="col-lg-4 col-sm-6 col-xs-12 url-link" data-link="">
	<div class="box-content dashboard-top-stats display-table no-border">
		<div class="col-xs-3 display-cell no-padding"> <i class="icon-group dashboard-top-stats-icon bg-info"></i> </div>
		<div class="col-xs-3 display-cell no-padding">
			<div class="dashboard-top-stats-heading" style="text-align:left; margin-top:0; font-weight:700;">Male</div>
			<div class="dashboard-top-stats-value" style="color:#fff;">0</div>
		</div>
		<div class="col-xs-3 display-cell no-padding">
			<div class="dashboard-top-stats-heading" style="font-size:11px; font-weight:700;">Capacity</div>
			<div class="dashboard-top-stats-value">'.number_format($totalmalecaps['total']).'</div>
		</div>
		<div class="col-xs-3 display-cell no-padding">
			<div class="dashboard-top-stats-heading" style="font-size:11px; font-weight:700;">Booking</div>
			<div class="dashboard-top-stats-value">'.number_format($valuetotalmales['totalmem']).'</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- /last 30 days Income-->
<!-- Pending Payments -->
<div class="col-lg-4 col-sm-6 col-xs-12 url-link" data-link="">
	<div class="box-content dashboard-top-stats display-table no-border">
		<div class="col-xs-3 display-cell no-padding"> <i class="icon-group dashboard-top-stats-icon bg-purple"></i> </div>
		<div class="col-xs-3 display-cell no-padding">
			<div class="dashboard-top-stats-heading" style="text-align:left; margin-top:0; font-weight:700;">Female</div>
			<div class="dashboard-top-stats-value" style="color:#fff;">0</div>
		</div>
		<div class="col-xs-3 display-cell no-padding">
			<div class="dashboard-top-stats-heading" style="font-size:11px; font-weight:700;">Capacity</div>
			<div class="dashboard-top-stats-value">'.number_format($totalfemalecaps['total']).'</div>
		</div>
		<div class="col-xs-3 display-cell no-padding">
			<div class="dashboard-top-stats-heading" style="font-size:11px; font-weight:700;">Booking</div>
			<div class="dashboard-top-stats-value">'.number_format($valuetotalfmales['totalmem']).'</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!--tickets end-->
<!--bugs end-->
	<div class="col-lg-3"></div>
</div>
<!-- End WI_STATS_TOP-->

<!--WI_TASKS_AND_PINNED_PROJECTS-->
<div class="row">
<div class="col-lg-4">

<!-- Forum wise -->
<div style="padding-bottom:20px;">
<div class="widget-content dashboard-widget-tasks slimScrollHomeTasks">
<table class="table">
<thead>
<tr>
	<th style="font-weight:bold; font-size:12px;">Forum Report</th>
	<th style="font-weight:bold; font-size:12px; text-align:right;">Quota</th>
    <th style="font-weight:bold; font-size:12px; text-align:right;">Booking</th>
</tr>
</thead>
<tbody>';
//-----------------------------------------
		$sqllmsforumq  = $dblms->querylms("SELECT q.quota, f.forum_name, f.forum_shortname, f.forum_id     
											FROM ".FORUMSQUOTA." q 
										  	INNER JOIN ".FORUMS." f ON f.forum_id = q.id_forum 
										  	WHERE q.status = '1' 
											ORDER BY q.quota DESC");
$totalfquota 	= 0;
$totalfbooking 	= 0;
//-----------------------------------------
while($valueforumq = mysql_fetch_array($sqllmsforumq)) { 
//-----------------------------------------
	$sqllmsforummems  	= $dblms->querylms("SELECT COUNT(id) AS totalmem FROM ".MEMBERS." WHERE id_forum = '".$valueforumq['forum_id']."'");
	$valueforummems		= mysql_fetch_array($sqllmsforummems);
//------------------------------------------------------
echo '
<tr>
	<td style="min-width:120px;" title="'.$valueforumq['forum_name'].'">'.$valueforumq['forum_shortname'].'</td>
	<td style="text-align:right;">'.number_format($valueforumq['quota']).'</td>
    <td style="text-align:right;">'.number_format($valueforummems['totalmem']).'</td>
</tr>';
$totalfquota = ($totalfquota + $valueforumq['quota']);
$totalfbooking = ($totalfbooking + $valueforummems['totalmem']);
//-----------------------------------------
}
//-----------------------------------------
echo '
<tr>
	<th style="font-weight:bold; font-size:12px;">Total</th>
	<th style="font-weight:bold; font-size:12px; text-align:right;">'.number_format($totalfquota).'</th>
    <th style="font-weight:bold; font-size:12px; text-align:right;">'.number_format($totalfbooking).'</th>
</tr>
</tbody>
</table>
</div>
</div>
<!-- /Forum wise -->


<!-- District wise -->
<div style="padding-bottom:20px;">
<div class="widget-content dashboard-widget-tasks slimScrollHomeTasks">
<table class="table">
<thead>
<tr>
	<th style="font-weight:bold; font-size:12px;">District Report</th>
	<th style="font-weight:bold; font-size:12px; text-align:right;">Quota</th>
    <th style="font-weight:bold; font-size:12px; text-align:right;">Booking</th>
</tr>
</thead>
<tbody>';
//-----------------------------------------
	$sqllmsdistricts  = $dblms->querylms("SELECT district_id, district_name    
											FROM ".DISTRICTS."  
										  	WHERE district_status = '1' 
											ORDER BY district_name ASC");
//-----------------------------------------
while($valuedistrict = mysql_fetch_array($sqllmsdistricts)) { 
//-----------------------------------------
	$sqllmsdistmems  	= $dblms->querylms("SELECT COUNT(id) AS totalmem FROM ".MEMBERS." WHERE id_district = '".$valuedistrict['district_id']."'");
	$valuedistmems		= mysql_fetch_array($sqllmsdistmems);
//------------------------------------------------------
if($valuedistmems['totalmem'] >0) {
echo '
<tr>
	<td style="min-width:150px;" title="'.$valuedistrict['district_name'].'">'.$valuedistrict['district_name'].'</td>
	<td style="text-align:right;">0</td>
    <td style="text-align:right;">'.number_format($valuedistmems['totalmem']).'</td>
</tr>';
}
//-----------------------------------------
}
//-----------------------------------------
echo '
</tbody>
</table>
</div>
</div>
<!-- /District wise -->



</div>
<!-- Latest Cash Flow -->
<div class="col-lg-4">

<!-- Male Block wise -->
<div style="padding-bottom:20px;">
<div class="widget-content dashboard-widget-tasks slimScrollHomeTasks">
<table class="table">
<thead>
<tr>
	<th style="font-weight:bold; font-size:13px;">Blocks (Male)</th>
	<th style="font-weight:bold; font-size:13px; text-align:right;">Halqat</th>
	<th style="font-weight:bold; font-size:13px; text-align:right;">Capacity</th>
    <th style="font-weight:bold; font-size:13px; text-align:right;">Booking</th>
</tr>
</thead>
<tbody>';
//-----------------------------------------
	$sqllmstopblocks  = $dblms->querylms("SELECT SUM(h.halqa_capacity) AS totalcapacity, COUNT(h.halqa_id) AS totalhalqa, b.block_name, b.block_id    
											FROM ".BLOCKS." b 
										  	RIGHT JOIN ".HALQAS." h ON b.block_id = h.id_block 
										  	WHERE b.block_status = '1' AND h.halqa_status = '1' AND b.id_campus  = '1'
											GROUP BY h.id_block  ORDER BY b.block_name ASC");
$totalcapacity = 0;
$totalbooking = 0;
$totalhalqas = 0;
//-----------------------------------------
while($valueblocks = mysql_fetch_array($sqllmstopblocks)) { 
//-----------------------------------------
	$sqllmsblockmems  	= $dblms->querylms("SELECT COUNT(id) AS totalmem FROM ".MEMBERS." WHERE id_block = '".$valueblocks['block_id']."'");
	$valueblockmems		= mysql_fetch_array($sqllmsblockmems);
//------------------------------------------------------
echo '
<tr>
	<td title="'.$valueblocks['block_name'].'"><a class="links-blue" href="members.php?block='.$valueblocks['block_id'].'">'.$valueblocks['block_name'].'</a></td>
	<td style="text-align:right;">'.number_format($valueblocks['totalhalqa']).'</td>
	<td style="text-align:right;">'.number_format($valueblocks['totalcapacity']).'</td>
    <td style="text-align:right;">'.number_format($valueblockmems['totalmem']).'</td>
</tr>';
//-----------------------------------------
	$totalhalqas 	= ($totalhalqas + $valueblocks['totalhalqa']);
	$totalcapacity 	= ($totalcapacity + $valueblocks['totalcapacity']);
	$totalbooking 	= ($totalbooking + $valueblockmems['totalmem']);
}
//-----------------------------------------
echo '
<tr>
	<th style="font-weight:bold; font-size:13px;">Total</th>
	<th style="font-weight:bold; font-size:13px; text-align:right;">'.number_format($totalhalqas).'</th>
	<th style="font-weight:bold; font-size:13px; text-align:right;">'.number_format($totalcapacity).'</th>
    <th style="font-weight:bold; font-size:13px; text-align:right;">'.number_format($totalbooking).'</th>
</tr>
</tbody>
</table>
</div>
</div>
<!-- /Male Block wise -->

<!-- Male Committees wise -->
<div style="padding-bottom:20px;">
<div class="widget-content dashboard-widget-tasks slimScrollHomeTasks">
<table class="table">
<thead>
<tr>
	<th style="font-weight:bold; font-size:12px;">Committees (Male)</th>
    <th style="font-weight:bold; font-size:12px; text-align:right;">Members</th>
</tr>
</thead>
<tbody>';
//-----------------------------------------
	$sqllmscoms  = $dblms->querylms("SELECT COUNT(e.id) AS totalworks, d.dept_name, d.dept_nameur, d.dept_id    
											FROM ".EMOBE_PLOSYEES." e 
										  	INNER JOIN ".DEPTS." d ON d.dept_id = e.id_dept 
										  	WHERE e.status = '1' AND e.id_campus = '1'
											GROUP BY e.id_dept ORDER BY d.dept_name ASC");
//-----------------------------------------
while($valuecoms = mysql_fetch_array($sqllmscoms)) { 
//------------------------------------------------------
echo '
<tr>
	<td style="min-width:150px;" title="'.$valuecoms['dept_nameur'].'"><a class="links-blue" href="employees.php?dept='.$valuecoms['dept_id'].'">'.$valuecoms['dept_name'].'</a></td>
    <td style="text-align:right;">'.number_format($valuecoms['totalworks']).'</td>
</tr>';
//-----------------------------------------
}
//-----------------------------------------
echo '
</tbody>
</table>
</div>
</div>
<!-- /Male Committees wise -->


</div>

<div class="col-lg-4">

<!-- Female Block wise -->
<div style="padding-bottom:20px;">
<div class="widget-content dashboard-widget-tasks slimScrollHomeTasks">
<table class="table">
<thead>
<tr>
	<th style="font-weight:bold; font-size:13px;">Blocks (Female)</th>
	<th style="font-weight:bold; font-size:13px; text-align:right;">Halqat</th>
	<th style="font-weight:bold; font-size:13px; text-align:right;">Capacity</th>
    <th style="font-weight:bold; font-size:13px; text-align:right;">Booking</th>
</tr>
</thead>
<tbody>';
//-----------------------------------------
	$sqllmstopblocksf  = $dblms->querylms("SELECT SUM(h.halqa_capacity) AS totalcapacity, COUNT(h.halqa_id) AS totalhalqa, b.block_name, b.block_id    
											FROM ".BLOCKS." b 
										  	RIGHT JOIN ".HALQAS." h ON b.block_id = h.id_block 
										  	WHERE b.block_status = '1' AND h.halqa_status = '1' AND b.id_campus  = '2'
											GROUP BY h.id_block  ORDER BY b.block_name ASC");
$totalcapacityf = 0;
$totalbookingf = 0;
$totalhalqasf = 0;
//-----------------------------------------
while($valueblocksf = mysql_fetch_array($sqllmstopblocksf)) { 
//-----------------------------------------
	$sqllmsblockmemsf  	= $dblms->querylms("SELECT COUNT(id) AS totalmem FROM ".MEMBERS." WHERE id_block = '".$valueblocksf['block_id']."'");
	$valueblockmemsf		= mysql_fetch_array($sqllmsblockmemsf);
//------------------------------------------------------
echo '
<tr>
	<td title="'.$valueblocksf['block_name'].'"><a class="links-blue" href="members.php?block='.$valueblocksf['block_id'].'">'.$valueblocksf['block_name'].'</a></td>
	<td style="text-align:right;">'.number_format($valueblocksf['totalhalqa']).'</td>
	<td style="text-align:right;">'.number_format($valueblocksf['totalcapacity']).'</td>
    <td style="text-align:right;">'.number_format($valueblockmemsf['totalmem']).'</td>
</tr>';
//-----------------------------------------
	$totalhalqasf 	= ($totalhalqasf + $valueblocksf['totalhalqa']);
	$totalcapacityf = ($totalcapacityf + $valueblocksf['totalcapacity']);
	$totalbookingf 	= ($totalbookingf + $valueblockmemsf['totalmem']);
}
//-----------------------------------------
echo '
<tr>
	<th style="font-weight:bold; font-size:13px;">Total</th>
	<th style="font-weight:bold; font-size:13px; text-align:right;">'.number_format($totalhalqasf).'</th>
	<th style="font-weight:bold; font-size:13px; text-align:right;">'.number_format($totalcapacityf).'</th>
    <th style="font-weight:bold; font-size:13px; text-align:right;">'.number_format($totalbookingf).'</th>
</tr>
</tbody>
</table>
</div>
</div>
<!-- /Female Block wise -->

<!-- Female Committees wise -->
<div style="padding-bottom:20px;">
<div class="widget-content dashboard-widget-tasks slimScrollHomeTasks">
<table class="table">
<thead>
<tr>
	<th style="font-weight:bold; font-size:12px;">Committees (Female)</th>
    <th style="font-weight:bold; font-size:12px; text-align:right;">Members</th>
</tr>
</thead>
<tbody>';
//-----------------------------------------
	$sqllmscomsf  = $dblms->querylms("SELECT COUNT(e.id) AS totalworks, d.dept_name, d.dept_nameur, d.dept_id    
											FROM ".EMOBE_PLOSYEES." e 
										  	INNER JOIN ".DEPTS." d ON d.dept_id = e.id_dept 
										  	WHERE e.status = '1' AND e.id_campus = '2'
											GROUP BY e.id_dept ORDER BY d.dept_name ASC");
//-----------------------------------------
while($valuecomsf = mysql_fetch_array($sqllmscomsf)) { 
//------------------------------------------------------
echo '
<tr>
	<td style="min-width:150px;" title="'.$valuecomsf['dept_nameur'].'"><a class="links-blue" href="employees.php?dept='.$valuecomsf['dept_id'].'">'.$valuecomsf['dept_name'].'</a></td>
    <td style="text-align:right;">'.number_format($valuecomsf['totalworks']).'</td>
</tr>';
//-----------------------------------------
}
//-----------------------------------------
echo '
</tbody>
</table>
</div>
</div>
<!-- /Female Committees wise -->


<!--WI_PINNED_PROJECT_NONE-->

<!--WI_TASKS_CHART-->
<div class="widget-content dashboard-widget">
<!--heading-->
	<div class="dashboard-panels-heading" style="font-weight:700;"> Forum Report </div>
<!--heading-->
	<div id="flot-dashboard-tasks" class="dashboard-chart-tasks"></div>
<!--wi_no_tasks-->
<!--wi_no_tasks-->
</div>
<!--WI_TASKS_CHART-->

</div>

</div>

</div>
<!--WI_TASKS_AND_PINNED_PROJECTS-->


<script type="text/javascript">

$().ready(function(){

        //chart data
		var data = [
		{ label: "MQI - 2,500",  data: 2500, color: "#8ec165"},
		{ label: "PAT - 1,500",  data: 1500, color: "#0993d3"},
		{ label: "MYL - 1,500",  data: 1500, color: "#857198"},
		{ label: "MSM - 500",  data: 500, color: "#828282"},
		{ label: "MWL - 700",  data: 700, color: "#d9534f"},
		{ label: "Ulama - 700",  data: 200, color: "#23272d"},
		{ label: "Overseas - 700",  data: 200, color: "#23272d"}
		];

    //plot the chart
$.plot($("#flot-dashboard-tasks"), data,
{
        series: {
            pie: {
			    innerRadius: 0.5,
                show: true
            }
        }
});
});

</script>';
?>