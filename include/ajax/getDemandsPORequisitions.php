<?php
include "../../dbsetting/lms_vars_config.php";
include "../../dbsetting/classdbconection.php";
$dblms = new dblms();
include "../../functions/login_func.php";
include "../../functions/functions.php";
checkCpanelLMSALogin();

if(isset($_GET['selectedDemands'])) {
	$selectedDemands = $_GET['selectedDemands'];
	if($selectedDemands != '') {
		$queryDemand = $dblms->querylms("SELECT demand_id, demand_code
											FROM ".SMS_DEMAND." 
											Where demand_id NOT IN (".$selectedDemands.")");

		echo '<option value = "">Select Demand</option>';
		while ($valueDemand = mysqli_fetch_array($queryDemand)) {
				echo '<option value = "'.$valueDemand['demand_id'].'">'.$valueDemand['demand_code'].'</option>';
		}
	} else {
		$queryDemand = $dblms->querylms("SELECT demand_id, demand_code
											FROM ".SMS_DEMAND."
										");
		echo '<option value = "">Select Demand</option>';
		while ($valueDemand = mysqli_fetch_array($queryDemand)) {
				echo '<option value = "'.$valueDemand['demand_id'].'">'.$valueDemand['demand_code'].'</option>';
		}
	}
} elseif (isset($_GET['selectedPOs'])) {
	$selectedPOs = $_GET['selectedPOs'];
	if($selectedPOs != '') {
		$queryPO = $dblms->querylms("SELECT po_id, po_code
										FROM ".SMS_PO." 
										Where po_id NOT IN (".$selectedPOs.")
									");
		echo '<option value = "">Select PO</option>';
		while ($valuePO = mysqli_fetch_array($queryPO)) {
				echo '<option value = "'.$valuePO['po_id'].'">'.$valuePO['po_code'].'</option>';
		}

	} else {
		$queryPO = $dblms->querylms("SELECT po_id, po_code
										FROM ".SMS_PO."
								");
		echo '<option value = "">Select PO</option>';
		while ($valuePO = mysqli_fetch_array($queryPO)) {
				echo '<option value = "'.$valuePO['po_id'].'">'.$valuePO['po_code'].'</option>';
		}
	}
} elseif (isset($_GET['selectedRequisitions'])) {
	$selectedRequisitions = $_GET['selectedRequisitions'];
	if($selectedRequisitions != '') {
		$queryRequisition = $dblms->querylms("SELECT requisition_id, requisition_code
										FROM ".SMS_REQUISITION." 
										Where requisition_id NOT IN (".$selectedRequisitions.")
									");
		echo '<option value = "">Select Requisition</option>';
		while ($valueRequisition = mysqli_fetch_array($queryRequisition)) {
				echo '<option value = "'.$valueRequisition['requisition_id'].'">'.$valueRequisition['requisition_code'].'</option>';
		}

	} else {
		$queryRequisition = $dblms->querylms("SELECT requisition_id, requisition_code
													FROM ".SMS_REQUISITION."
											");
		echo '<option value = "">Select Requisition</option>';
		while ($valueRequisition = mysqli_fetch_array($queryRequisition)) {
				echo '<option value = "'.$valueRequisition['requisition_id'].'">'.$valueRequisition['requisition_code'].'</option>';
		}
	}
}
