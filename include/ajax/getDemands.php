<?php
include "../../dbsetting/lms_vars_config.php";
include "../../dbsetting/classdbconection.php";
$dblms = new dblms();
include "../../functions/login_func.php";
include "../../functions/functions.php";
checkCpanelLMSALogin();

$selectedDemands = $_GET['selectedDemands'];

if($selectedDemands != '') {
	$queryDemand = $dblms->querylms("SELECT demand_id, demand_code
										FROM ".SMS_DEMANDS." 
										Where demand_id NOT IN (".$selectedDemands.")");

	echo '<option value = "">Select Demand</option>';
	while ($valueDemand = mysqli_fetch_array($queryDemand)) {
			echo '<option value = "'.$valueDemand['demand_id'].'">'.$valueDemand['demand_code'].'</option>';
	}

} else {
	$queryDemand = $dblms->querylms("SELECT demand_id, demand_code
										FROM ".SMS_DEMANDS);
	echo '<option value = "">Select Demand</option>';
	while ($valueDemand = mysqli_fetch_array($queryDemand)) {
			echo '<option value = "'.$valueDemand['demand_id'].'">'.$valueDemand['demand_code'].'</option>';
	}
}


?>
