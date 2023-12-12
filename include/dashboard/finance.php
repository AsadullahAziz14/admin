<?php 
//------------------------------------------------------
	$sqllmstotalincome  = $dblms->querylms("SELECT SUM(approx_pkr) AS totalincome FROM ".RECEIPTS." WHERE status = '1'");
	$valuetotalincome	= mysql_fetch_array($sqllmstotalincome);
//------------------------------------------------------
	$sqllmspendingincome = $dblms->querylms("SELECT SUM(approx_pkr) AS pendingincome FROM ".RECEIPTS." WHERE status = '2'");
	$valuependingincome	 = mysql_fetch_array($sqllmspendingincome);
//------------------------------------------------------
	$sqllmslast30income = $dblms->querylms("SELECT SUM(approx_pkr) AS last30income FROM ".RECEIPTS." 
													WHERE status = '1' AND dated >= '".date('Y-m-d', strtotime('today - 30 days'))."'");
	$valuelast30income  = mysql_fetch_array($sqllmslast30income);
//------------------------------------------------------
	$sqllmsunpaidincome = $dblms->querylms("SELECT SUM(approx_pkr) AS unpaidincome FROM ".RECEIPTS." WHERE status = '3'");
	$valueunpaidincome  = mysql_fetch_array($sqllmsunpaidincome);
//------------------------------------------------------
echo '
<!--WI_HEADING_BAR-->
<div class="container">
<!--Start WI_STATS_TOP-->
<div class="row">
<!-- Total Income-->
<div class="col-lg-3 col-sm-6 col-xs-12 url-link" data-link="">
	<div class="box-content dashboard-top-stats display-table no-border">
		<div class="col-xs-4 display-cell no-padding"> <i class="icon-credit-card dashboard-top-stats-icon bg-info"></i> </div>
		<div class="col-xs-8 display-cell no-padding">
			<div class="dashboard-top-stats-heading">Total Income</div>
			<div class="dashboard-top-stats-value">'.number_format($valuetotalincome['totalincome']).'</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- /Total Income-->
<!--  last 30 days Income-->
<div class="col-lg-3 col-sm-6 col-xs-12 url-link" data-link="">
	<div class="box-content dashboard-top-stats display-table no-border">
		<div class="col-xs-4 display-cell no-padding"> <i class="icon-credit-card dashboard-top-stats-icon bg-success"></i> </div>
		<div class="col-xs-8 display-cell no-padding">
			<div class="dashboard-top-stats-heading">Income Last 30 Days</div>
			<div class="dashboard-top-stats-value">'.number_format($valuelast30income['last30income']).'</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- /last 30 days Income-->
<!-- Pending Payments -->
<div class="col-lg-3 col-sm-6 col-xs-12 url-link" data-link="">
	<div class="box-content dashboard-top-stats display-table no-border">
		<div class="col-xs-4 display-cell no-padding"> <i class="icon-credit-card dashboard-top-stats-icon bg-warning"></i> </div>
		<div class="col-xs-8 display-cell no-padding">
			<div class="dashboard-top-stats-heading">Unpaid Amount</div>
			<div class="dashboard-top-stats-value">'.number_format($valuependingincome['pendingincome']).'</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!--tickets end-->
<!--bugs-->
<div class="col-lg-3 col-sm-6 col-xs-12 url-link" data-link="">
	<div class="box-content dashboard-top-stats display-table no-border">
		<div class="col-xs-5 display-cell no-padding"> <i class="icon-credit-card dashboard-top-stats-icon bg-danger"></i> </div>
		<div class="col-xs-7 display-cell no-padding">
			<!--div class="dashboard-top-stats-heading">Partially Unpaid</div-->
			<!--div class="dashboard-top-stats-value">'.number_format($valueunpaidincome['unpaidincome']).'</div-->
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!--bugs end-->
	<div class="col-lg-3"></div>
</div>
<!-- End WI_STATS_TOP-->

<!--WI_TASKS_AND_PINNED_PROJECTS-->
<div class="row">
<div class="col-lg-4">
<!-- Top 10 Country wise -->
<div style="padding-bottom:20px;">
<div class="widget-content dashboard-widget-tasks slimScrollHomeTasks">
<table class="table">
<thead>
<tr>
	<th style="font-weight:bold; font-size:12px;">Top 10 Countries</th>
	<th style="font-weight:bold; font-size:12px;">Total</th>
    <th style="font-weight:bold; font-size:12px;">Last 30 Days</th>
</tr>
</thead>
<tbody>';
//-----------------------------------------
	$sqllmstopcountry  = $dblms->querylms("SELECT SUM(rep.approx_pkr) AS totalamount, zon.country_name, zon.country_code, zon.country_id    
											FROM ".RECEIPTS." rep 
										  	LEFT JOIN ".COUNTRIES." zon ON zon.country_id = rep.id_country 
										  	WHERE rep.status = '1' GROUP BY rep.id_country 
											ORDER BY totalamount DESC LIMIT 10");
//-----------------------------------------
while($valuecountryamount = mysql_fetch_array($sqllmstopcountry)) { 
//-----------------------------------------
	$sqllmslast30country = $dblms->querylms("SELECT SUM(approx_pkr) AS last30country FROM ".RECEIPTS." 
													WHERE status = '1' AND id_country = '".$valuecountryamount['country_id']."'
													AND dated >= '".date('Y-m-d', strtotime('today - 30 days'))."'");
	$valuelast30country  = mysql_fetch_array($sqllmslast30country);
//------------------------------------------------------
echo '
<tr>
	<td style="min-width:150px;" title="'.$valuecountryamount['country_name'].'"><a class="links-blue" href="receipts.php?country='.$valuecountryamount['country_id'].'">'.$valuecountryamount['country_code'].'</a></td>
	<td style="text-align:right;">'.number_format($valuecountryamount['totalamount']).'</td>
    <td style="text-align:right;">'.number_format($valuelast30country['last30country']).'</td>
</tr>';
//-----------------------------------------
}
//-----------------------------------------
echo '
<tr>
	<td colspan="4" style="text-align:center;"><a class="links-blue" href=""> See More</a></td>
</tr>
</tbody>
</table>
</div>
</div>
<!-- /Top 10 Country wise -->

<!-- Top 10 Project wise -->
<div style="padding-bottom:20px;">
<div class="widget-content dashboard-widget-tasks slimScrollHomeTasks">
<table class="table">
<thead>
<tr>
	<th style="font-weight:bold; font-size:12px;">Top 10 Projects</th>
	<th style="font-weight:bold; font-size:12px;">Total</th>
    <th style="font-weight:bold; font-size:12px;">Last 30 Days</th>
</tr>
</thead>
<tbody>';
//-----------------------------------------
	$sqllmstopheads  = $dblms->querylms("SELECT SUM(rep.approx_pkr) AS totalhdamount, hd.head_name, hd.head_id    
											FROM ".RECEIPTS." rep 
										  	 LEFT JOIN ".ACCOUNT_HEADS." hd ON hd.head_id = rep.id_head 
										  	WHERE rep.status = '1' GROUP BY rep.id_head 
											ORDER BY totalhdamount DESC LIMIT 10");
//-----------------------------------------
while($valueheadamount = mysql_fetch_array($sqllmstopheads)) { 
//-----------------------------------------
	$sqllmslast30heads = $dblms->querylms("SELECT SUM(approx_pkr) AS last30head 
													FROM ".RECEIPTS." 
													WHERE status = '1' AND id_head = '".$valueheadamount['head_id']."'
													AND dated >= '".date('Y-m-d', strtotime('today - 30 days'))."'");
	$valuelast30head  = mysql_fetch_array($sqllmslast30heads);
//------------------------------------------------------
echo '
<tr>
	<td><a class="links-blue" href="receipts.php?head='.$valueheadamount['head_id'].'">'.$valueheadamount['head_name'].'</a></td>
	<td style="text-align:right;">'.number_format($valueheadamount['totalhdamount']).'</td>
    <td style="text-align:right; width:90px;">'.number_format($valuelast30head['last30head']).'</td>
</tr>';
//-----------------------------------------
}
//-----------------------------------------
echo '
<tr>
	<td colspan="4" style="text-align:center;"><a class="links-blue" href=""> See More</a></td>
</tr>
</tbody>
</table>
</div>
</div>
<!-- /Top 10 Project wise -->
</div>
<!-- Latest Cash Flow -->
<div class="col-lg-4">
<div class="widget" style="margin-top:0px;">
<div class="widget-content widget-content-project slimScrollAdminProjectTimeline" style="padding-top:7px;">
<!--heading-->
	<div class="dashboard-panels-heading" style="font-weight:700;"> Latest Cash Flow </div>
<!-- /heading -->
<!--WI_PROJECT_EVENTS-->
<div class="project-info-tabs project-details">
<ul class="timeline">
<!--left event-->';
//-----------------------------------------
	$sqllmsreceipts  = $dblms->querylms("SELECT rep.status, rep.title, rep.dfa_receipt, rep.finance_receipt, 
												rep.approx_pkr, rep.dated, hd.head_name  
											FROM ".RECEIPTS." rep 
										  	LEFT JOIN ".ACCOUNT_HEADS." hd ON hd.head_id = rep.id_head 
										  	LEFT JOIN ".CURRENCIES." cur ON cur.currency_id = rep.id_currency 
										  	LEFT JOIN ".COUNTRIES." zon ON zon.country_id = rep.id_country 
										  	WHERE rep.id != '' ORDER BY rep.dated DESC LIMIT 30");


$srnod = 0;
//-----------------------------------------
while($valuereceipts = mysql_fetch_array($sqllmsreceipts)) { 
//------------------------------------------------
$srno++;
//------------------------------------------------
if($srnod&1) {
	$dlistatus =  '';
} else {
	$dlistatus =  'class="timeline-inverted"';
}
//------------------------------------------------
if($valuereceipts['status'] == 1) { 
	$bgcolor = 'bg-info';
} else if($valuereceipts['status'] == 2) { 
	$bgcolor = 'bg-warning';
} else if($valuereceipts['status'] == 3) { 
	$bgcolor = 'bg-danger';
}
//------------------------------------------------
echo '
	<li>
		<div class="tl-circ '.$bgcolor.'"><i class="icon-credit-card"></i></div>
		<div class="timeline-panel">
			<div class="tl-heading">
				<div><strong>'.$valuereceipts['title'].'</strong></div>
				<div>DFA Rec. '.$valuereceipts['dfa_receipt'].'</div>
				<div>FIN Rec. '.$valuereceipts['finance_receipt'].'</div>
				<div style="color:#0993d3;"><strong>Rs. '.number_format($valuereceipts['approx_pkr']).'</strong></div>
                <div><small class="text-muted"><i class="icon-time"></i> '.$valuereceipts['dated'].'</small></div>
			</div>
			<div class="tl-body">
				<div style="font-weight:700;">'.$valuereceipts['head_name'].'</div>
				<!--div>Status: '.get_payments($valuereceipts['status']).'</div-->
			</div>
		</div>
	</li>';
//------------------------------------------------
}
//------------------------------------------------
echo '
<!--right event-->
</ul>
<!--wi_no_timeline-->
<!--wi_no_timeline-->
</div>
<!--WI_PROJECT_EVENTS-->
</div>
</div>
</div>
<!-- /Latest Cash Flow -->
<div class="col-lg-4">
<!--WI_PINNED_PROJECT_NONE-->

<!--WI_TASKS_CHART-->
<div class="widget-content dashboard-widget">
<!--heading-->
	<div class="dashboard-panels-heading" style="font-weight:700;"> Membership Info </div>
<!--heading-->
	<div id="flot-dashboard-tasks" class="dashboard-chart-tasks"></div>
<!--wi_no_tasks-->
<!--wi_no_tasks-->
</div>
<!--WI_TASKS_CHART-->
<!-- Magzine status-->
<div class="dashboard-pending-income bg-purple-dark">
<!--permissions-->            
	<div class="income-total bg-success-dark">
		<div><span class="amount">2,500</span></div>
		<div class="income-description allcaps" style="font-size:11px;">Monthly Minhaj-ul-Quran</div>
		<div> <span class="uppercase">(December 2015)</span></div>
	</div>

	<div class="income-breakdown">
		<div><span class="amount">1,615</span></div>
		<div class="income-description allcaps" style="font-size:11px;">Dukhtran-e-Islam</div>
		<div> <span class="uppercase">(December 2015)</span></div>
	</div>

</div>
<!-- /Magzine status -->
<!--WI_TIME_HISTORY-->
<div class="dashboard-time-history">
<!--permissions-->            
	<div class="each-time time-summary border-right bg-info text-white"> 
		Projected Income<span class="period period-today"> 68,36,306</span>
	</div>
	<div class="each-time border-right"> 
		<span class="text-info"><i class="icon-credit-card"></i></span> 
		<span class="period allcaps" style="font-weight:700; font-size:11px;"> Actual Income</span> 
		<span class="period period-today"> 57,38,215</span> 
	</div>
	<div class="each-time border-right"> 
		<span class="text-info"><i class="icon-credit-card"></i></span> 
		<span class="period allcaps" style="font-weight:700; font-size:11px;"> Balance</span> 
		<span class="period period-today">11,38,105</span> 
	</div>
</div>
<!--WI_TIME_HISTORY-->
<!--WI_TIME_HISTORY-->
<div class="dashboard-time-history">
<!--permissions-->            
	<div class="each-time time-summary border-right bg-info text-white"> 
		Projected Expenses<span class="period period-today"> 68,36,306</span>
	</div>
	<div class="each-time border-right"> 
		<span class="text-info"><i class="icon-credit-card"></i></span> 
		<span class="period allcaps" style="font-weight:700; font-size:11px;"> Actual Expenses</span> 
		<span class="period period-today"> 87,72,542</span> 
	</div>
	<div class="each-time border-right"> 
		<span class="text-info"><i class="icon-credit-card"></i></span> 
		<span class="period allcaps" style="font-weight:700; font-size:11px;"> Balance</span> 
		<span class="period period-today text-danger"> -34,306</span> 
	</div>
</div>
<!--WI_TIME_HISTORY-->
</div>

</div>

</div>
<!--WI_TASKS_AND_PINNED_PROJECTS-->


<script type="text/javascript">

$().ready(function(){

        //chart data
		var data = [
		{ label: "RF - 2,500",  data: 2500, color: "#8ec165"},
		{ label: "LM - 1,500",  data: 1500, color: "#0993d3"},
		{ label: "LMI - 1,500",  data: 1500, color: "#857198"},
		{ label: "LWOM - 500",  data: 500, color: "#828282"},
		{ label: "LMF - 700",  data: 700, color: "#d9534f"},
		{ label: "MM - 700",  data: 200, color: "#23272d"}
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