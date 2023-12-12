<?php 
//------------------------------------------------------
	$sqllmstotalscholars  = $dblms->querylms("SELECT COUNT(id) AS totalscholar FROM ".SCHOLARS."");
	$valuetotalscholars	  = mysql_fetch_array($sqllmstotalscholars);
//------------------------------------------------------
	$sqllmstotalcentres   = $dblms->querylms("SELECT COUNT(id) AS totalcentres FROM ".CENTERS."");
	$valuetotalcentres    = mysql_fetch_array($sqllmstotalcentres);
//------------------------------------------------------
	$sqllmstotalschools   = $dblms->querylms("SELECT COUNT(id) AS totalschools FROM ".SCHOOLS."");
	$valuetotalschools    = mysql_fetch_array($sqllmstotalschools);
//------------------------------------------------------
	$sqllmstotalnecs	  = $dblms->querylms("SELECT COUNT(id_country) AS totalnecs FROM ".EXECUTIVES." 
										WHERE type = '6' GROUP BY id_country");
	$countnecs			  = mysql_num_rows($sqllmstotalnecs);
//------------------------------------------------------
	$sqllmsnecsexpire	  = $dblms->querylms("SELECT COUNT(id_country) AS totalnecs FROM ".EXECUTIVES." 
										WHERE type = '6'  AND end_date <= '".date('Y-m-d', strtotime('today + 60 days'))."' GROUP BY id_country");
	$countnecsexpire	  = mysql_num_rows($sqllmsnecsexpire);
//------------------------------------------------------
	$sqllmstotallecs	  = $dblms->querylms("SELECT COUNT(id_country) AS totalnecs FROM ".EXECUTIVES." 
										WHERE type = '7' GROUP BY id_country");
	$countlecs			  = mysql_num_rows($sqllmstotallecs);	
//------------------------------------------------------
	$sqllmslecsexpire	  = $dblms->querylms("SELECT COUNT(id_country) AS totalnecs FROM ".EXECUTIVES." 
										WHERE type = '7'  AND end_date <= '".date('Y-m-d', strtotime('today + 60 days'))."' GROUP BY id_country");
	$countlecsexpire	  = mysql_num_rows($sqllmslecsexpire);
//------------------------------------------------------
echo '
<!--WI_HEADING_BAR-->
<div class="container">
<!--Start WI_STATS_TOP-->
<div class="row">
<!-- Total Income-->
<div class="col-lg-4 col-sm-6 col-xs-12 url-link" data-link="">
	<div class="box-content dashboard-top-stats display-table no-border">
		<div class="col-xs-3 display-cell no-padding"> <i class="icon-list-ul dashboard-top-stats-icon bg-info"></i> </div>
		<div class="col-xs-2 display-cell no-padding">
			<div class="dashboard-top-stats-heading" style="font-size:11px; font-weight:700;">Exisiting</div>
			<div class="dashboard-top-stats-value">&nbsp;</div>
		</div>
		<div class="col-xs-3 display-cell no-padding">
			<div class="dashboard-top-stats-heading" style="font-size:11px; font-weight:700;">SHURA</div>
			<div class="dashboard-top-stats-value">0</div>
		</div>
		<div class="col-xs-3 display-cell no-padding">
			<div class="dashboard-top-stats-heading"" style="font-size:11px; font-weight:700;">NECs</div>
			<div class="dashboard-top-stats-value">'.number_format($countnecs).'</div>
		</div>
		<div class="col-xs-3 display-cell no-padding">
			<div class="dashboard-top-stats-heading" style="font-size:11px; font-weight:700;">LECs</div>
			<div class="dashboard-top-stats-value">'.number_format($countlecs).'</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- /Total Income-->
<!-- Pending Payments -->
<div class="col-lg-4 col-sm-6 col-xs-12 url-link" data-link="">
	<div class="box-content dashboard-top-stats display-table no-border">
		<div class="col-xs-4 display-cell no-padding"> <i class="icon-list-ul dashboard-top-stats-icon bg-warning"></i> </div>
		<div class="col-xs-2 display-cell no-padding">
			<div class="dashboard-top-stats-heading text-warning" style="font-size:11px; font-weight:700;">Expiring</div>
			<div class="dashboard-top-stats-value">&nbsp;</div>
		</div>
		<div class="col-xs-3 display-cell no-padding">
			<div class="dashboard-top-stats-heading" style="font-size:11px; font-weight:700;">SHURA</div>
			<div class="dashboard-top-stats-value">0</div>
		</div>
		<div class="col-xs-3 display-cell no-padding">
			<div class="dashboard-top-stats-heading" style="font-size:11px; font-weight:700;">NECs</div>
			<div class="dashboard-top-stats-value">'.number_format($countnecsexpire).'</div>
		</div>
		<div class="col-xs-3 display-cell no-padding">
			<div class="dashboard-top-stats-heading" style="font-size:11px; font-weight:700;">LECs</div>
			<div class="dashboard-top-stats-value">'.number_format($countlecsexpire).'</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!--tickets end-->
<!--  last 30 days Income-->
<div class="col-lg-4 col-sm-6 col-xs-12 url-link" data-link="">
	<div class="box-content dashboard-top-stats display-table no-border">
		<div class="col-xs-3 display-cell no-padding"> <i class="icon-list-ul dashboard-top-stats-icon bg-success"></i> </div>
		<div class="col-xs-3 display-cell no-padding">
			<div class="dashboard-top-stats-heading" style="font-size:11px; font-weight:700;">CENTRES</div>
			<div class="dashboard-top-stats-value">'.number_format($valuetotalcentres['totalcentres']).'</div>
		</div>
		<div class="col-xs-3 display-cell no-padding">
			<div class="dashboard-top-stats-heading"" style="font-size:11px; font-weight:700;">SCHOLARS</div>
			<div class="dashboard-top-stats-value">'.number_format($valuetotalscholars['totalscholar']).'</div>
		</div>
		<div class="col-xs-3 display-cell no-padding">
			<div class="dashboard-top-stats-heading" style="font-size:11px; font-weight:700;">SCHOOLS</div>
			<div class="dashboard-top-stats-value">'.number_format($valuetotalschools['totalschools']).'</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- /last 30 days Income-->
<!--bugs-->

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
	<th style="font-weight:bold; font-size:13px;">Top 10 Centres</th>
	<th style="font-weight:bold; font-size:13px;">Centres</th>
    <th style="font-weight:bold; font-size:13px;">Scholars</th>
</tr>
</thead>
<tbody>';
//-----------------------------------------
	$sqllmstopcentres  = $dblms->querylms("SELECT COUNT(cen.id_country) AS totalcentres, zon.country_name, zon.country_code, zon.country_id    
											FROM ".CENTERS." cen  
										  	LEFT JOIN ".COUNTRIES." zon ON zon.country_id = cen.id_country 
										  	WHERE cen.status = '1' GROUP BY cen.id_country 
											ORDER BY totalcentres DESC");
//-----------------------------------------
while($valuetotalcentres = mysql_fetch_array($sqllmstopcentres)) { 
//-----------------------------------------
	$sqllmstotalscholars = $dblms->querylms("SELECT COUNT(id) AS totalscholar 
													FROM ".SCHOLARS." 
													WHERE id_country = '".$valuetotalcentres['country_id']."'");
	$valuetotalscholars  = mysql_fetch_array($sqllmstotalscholars);
//------------------------------------------------------
echo '
<tr>
	<td class="links-blue" title="'.$valuetotalcentres['country_name'].'">'.$valuetotalcentres['country_code'].'</td>
	<td style="text-align:center; width:70px;">'.number_format($valuetotalcentres['totalcentres']).'</td>
    <td style="text-align:center; width:70px;">'.number_format($valuetotalscholars['totalscholar']).'</td>
</tr>';
//-----------------------------------------
}
//-----------------------------------------
echo '
<tr>
	<td colspan="4" style="text-align:center;"><a class="links-blue" href="centers.php"> See More</a></td>
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
	<th style="font-weight:bold; font-size:13px;">Top 10 Scholars</th>
	<th style="font-weight:bold; font-size:13px; text-align:left;">Country</th>
    <th style="font-weight:bold; font-size:13px; text-align:left;">City</th>
</tr>
</thead>
<tbody>';
//------------------------------------------------
	$sqllmsscholars  = $dblms->querylms("SELECT rep.scholarname, rep.id_city, zon.country_name, zon.country_code   
											FROM ".SCHOLARS." rep 
										  	LEFT JOIN ".COUNTRIES." zon ON zon.country_id = rep.id_country 
										  	ORDER BY rep.scholarname ASC LIMIT 10");
//-----------------------------------------
while($valuescholar = mysql_fetch_array($sqllmsscholars)) { 
//-----------------------------------------
if($valuescholar['id_city']) {
	$sqllmscity	= $dblms->querylms("SELECT city_id, city_name FROM ".CITIES." WHERE city_id = '".$valuescholar['id_city']."' LIMIT 1");
	$valuecity  = mysql_fetch_array($sqllmscity);
	$cityname	= $valuecity['city_name'];
} else { 
	$cityname	= '';
}
//------------------------------------------------------
echo '
<tr>
	<td class="links-blue">'.$valuescholar['scholarname'].'</td>
	<td style="text-align:left;" title="'.$valuescholar['country_name'].'">'.$valuescholar['country_code'].'</td>
    <td style="text-align:left;">'.$cityname.'</td>
</tr>';
//-----------------------------------------
}
//-----------------------------------------
echo '
<tr>
	<td colspan="4" style="text-align:center;"><a class="links-blue" href="scholars.php"> See More</a></td>
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
	<div class="dashboard-panels-heading" style="font-weight:700;"> Latest Designations</div>
<!-- /heading -->
<!--WI_PROJECT_EVENTS-->
<div class="project-info-tabs project-details">
<ul class="timeline">
<!--left event-->';
//-----------------------------------------
	$sqllmstans  = $dblms->querylms("SELECT rep.id, rep.status, rep.type, rep.start_date, rep.end_date, rep.extend_date, rep.memno, rep.name, 
										rep.id_designation, rep.forum, rep.contactno, rep.email, rep.skypeid, rep.postal_address, rep.id_city, 
										rep.id_country, rep.remarks, des.designation_name, zon.country_name  
										FROM ".EXECUTIVES." rep 
										LEFT JOIN ".COUNTRIES." zon ON zon.country_id = rep.id_country 
										LEFT JOIN ".DESIGNATIONS." des ON des.designation_id = rep.id_designation 
										ORDER BY rep.start_date DESC LIMIT 30");



$srnod = 0;
//-----------------------------------------
while($valuereceipts = mysql_fetch_array($sqllmstans)) { 
//------------------------------------------------
$srno++;
//------------------------------------------------
	if($srnod&1) {
		$dlistatus =  '';
	} else {
		$dlistatus =  'class="timeline-inverted"';
	}
//------------------------------------------------
	if($valuereceipts['forum']) {
		$forum = get_forums($valuereceipts['forum']); 
	} else { 
		$forum = ''; 
	}
//------------------------------------------------
	if($valuereceipts['type']) {
		$councils = get_councils($valuereceipts['type']); 
	} else { 
		$councils = ''; 
	}
//------------------------------------------------
echo '
	<li '.$dlistatus.'>
		<div class="tl-circ bg-info"><i class="icon-credit-card"></i></div>
		<div class="timeline-panel">
			<div class="tl-heading">
				<div><strong>'.$valuereceipts['name'].'</strong></div>
				<div>Forum: '.$forum.'</div>
				<div>Country: '.$valuereceipts['country_name'].'</div>
				<div style="color:#0993d3;"><strong>'.$councils.'</strong></div>
                <div><small class="text-muted"><i class="icon-time"></i> '.$valuereceipts['start_date'].'</small></div>
			</div>
			<div class="tl-body">
				<div style="font-weight:700;">'.$valuereceipts['designation_name'].'</div>
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