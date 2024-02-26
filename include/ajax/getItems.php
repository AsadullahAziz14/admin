<?php
include "../../dbsetting/lms_vars_config.php";
include "../../dbsetting/classdbconection.php";
$dblms = new dblms();
include "../../functions/login_func.php";
include "../../functions/functions.php";
checkCpanelLMSALogin();

if(isset($_GET['selectedDemand'])) {
	$selectedDemand = $_GET['selectedDemand'];
	if(isset($selectedDemand)) {
		$queryDemandItem = $dblms->querylms("SELECT di.id_demand, di.id_item, di.quantity_demanded, SUM(pdi.quantity_ordered) as total_ordered,
												(di.quantity_demanded - COALESCE(SUM(pdi.quantity_ordered), 0)) as quantity_remaining
												FROM ".SMS_DEMAND_ITEM_JUNCTION." di 
												JOIN ".SMS_DEMAND." d ON d.demand_id = di.id_demand
												LEFT JOIN ".SMS_PO_DEMAND_ITEM_JUNCTION." pdi ON di.id_item = pdi.id_item AND di.id_demand = pdi.id_demand
												LEFT JOIN ".SMS_PO." p ON pdi.id_po = p.po_id 
												WHERE d.demand_code IN ('".$selectedDemand."') 
												AND d.demand_status = 3
												GROUP BY di.id_demand, di.id_item, di.quantity_demanded
												HAVING total_ordered IS NULL OR total_ordered < SUM(di.quantity_demanded)
											");
		while($valueDemandItem = mysqli_fetch_array($queryDemandItem)) {
			if($valueDemandItem['quantity_demanded'] != $valueDemandItem['total_ordered'])
			{
				$queryItem = $dblms->querylms("SELECT item_id, item_code, item_title 
												FROM ".SMS_ITEM."
												Where item_id IN (".$valueDemandItem['id_item'].")
											");
				$valueItem = mysqli_fetch_array($queryItem);
				echo '
				<div class="item'.$selectedDemand.'">
					<div class="col-sm-51">
						<label for="id_item" class="req"><b>Item</b></label>
						<input class="form-control" type="text" value="'.$valueItem['item_title'].'" name="id_item['.$selectedDemand.']['.$valueItem['item_id'].']" id="id_item'.$selectedDemand.$valueItem['item_id'].'" readonly required>
					</div>
					<div class="col-sm-31">
						<label for="quantity_demanded" class="req">Demand Quantity</label>
						<input class="form-control" type="number"  value="'.$valueDemandItem['quantity_demanded'].'" name="quantity_demanded['.$selectedDemand.']['.$valueItem['item_id'].']" id="quantity_demanded'.$selectedDemand.$valueItem['item_id'].'" min="0" readonly required>
					</div>
					<div class="col-sm-31">
						<label for="quantity_ordered" class="req">Ordered Quantity</label>
						<input class="form-control" type="number" value="'.$valueDemandItem['quantity_remaining'].'"  name="quantity_ordered['.$selectedDemand.']['.$valueItem['item_id'].']"  id="quantity_ordered'.$selectedDemand.$valueItem['item_id'].'" min="0" required>
					</div>
					<div class="col-sm-21">
						<label for="unit_price" class="req">Rate</label>
						<input class="form-control" type="number" name="unit_price['.$selectedDemand.']['.$valueItem['item_id'].']" id="unit_price'.$selectedDemand.$valueItem['item_id'].'" min="0" required>
					</div>
					<div class="col-sm-21">
						<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
							<button type="button" class="btn btn-info" style="align-items: center;" onclick="removeItem(this)"><i class="icon-remove"></i></button>									
						</div>
					</div>
				</div>';
			}
		}
	}
} elseif (isset($_GET['selectedDemandRequisition'])) {
	$selectedDemandRequisition = $_GET['selectedDemandRequisition'];
	if(isset($selectedDemandRequisition)) {
		$queryDemandItem = $dblms->querylms("SELECT di.id_demand, di.id_item, di.quantity_demanded, SUM(rdi.quantity_requested) as total_requested,
												(di.quantity_demanded - COALESCE(SUM(rdi.quantity_requested), 0)) as quantity_remaining
												FROM ".SMS_DEMAND_ITEM_JUNCTION." di 
												JOIN ".SMS_DEMAND." d ON d.demand_id = di.id_demand
												LEFT JOIN ".SMS_REQUISITION_DEMAND_ITEM_JUNCTION." rdi ON di.id_item = rdi.id_item AND di.id_demand = rdi.id_demand
												LEFT JOIN ".SMS_REQUISITION." r ON rdi.id_requisition = r.requisition_id 
												WHERE d.demand_code IN ('".$selectedDemandRequisition."') 
												AND d.demand_status = 3
												GROUP BY di.id_demand, di.id_item, di.quantity_demanded
												HAVING total_requested IS NULL OR total_requested < SUM(di.quantity_demanded)
											");
		while($valueDemandItem = mysqli_fetch_array($queryDemandItem)) {
			if($valueDemandItem['quantity_demanded'] != $valueDemandItem['total_requested'])
			{
				$queryItem = $dblms->querylms("SELECT item_id, item_code, item_title 
													FROM ".SMS_ITEM."
													Where item_id IN (".$valueDemandItem['id_item'].")
											");
				$valueItem = mysqli_fetch_array($queryItem);
				echo '
				<div class="item'.$selectedDemandRequisition.'">
					<div class="col-sm-61">
						<label for="id_item" class="req"><b>Item</b></label>
						<input class="form-control" type="text" value="'.$valueItem['item_title'].'" name="id_item['.$selectedDemandRequisition.']['.$valueItem['item_id'].']" id="id_item'.$selectedDemandRequisition.$valueItem['item_id'].'" readonly required>
					</div>
					<div class="col-sm-31">
						<label for="quantity_demanded" class="req">Demand Quantity</label>
						<input class="form-control" type="number"  value="'.$valueDemandItem['quantity_demanded'].'" name="quantity_demanded['.$selectedDemandRequisition.']['.$valueItem['item_id'].']" id="quantity_demanded'.$selectedDemandRequisition.$valueItem['item_id'].'" min="0" readonly required>
					</div>
					<div class="col-sm-31">
						<label for="quantity_requested" class="req">Quantity Requested</label>
						<input class="form-control" type="number" value="'.$valueDemandItem['quantity_remaining'].'" name="quantity_requested['.$selectedDemandRequisition.']['.$valueItem['item_id'].']" id="quantity_requested'.$selectedDemandRequisition.$valueItem['item_id'].'" min="0" required>
					</div>
					<div class="col-sm-21">
						<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
							<button type="button" class="btn btn-info" style="align-items: center;" onclick="removeItem(this)"><i class="icon-remove"></i></button>									
						</div>
					</div>
				</div>';
			}
		}
	}
} elseif (isset($_GET['selectedPO'])) {
	$selectedPO = $_GET['selectedPO'];
	if(isset($selectedPO)){
		$queryPODemandItem = $dblms->querylms("SELECT pdi.id_po, pdi.id_item, pdi.quantity_ordered, sum(rpi.quantity_received) as total_received,
												(pdi.quantity_ordered - COALESCE(SUM(rpi.quantity_received), 0)) as quantity_remaining
												FROM ".SMS_PO_DEMAND_ITEM_JUNCTION." pdi
												JOIN ".SMS_PO." p ON pdi.id_po = p.po_id
												LEFT JOIN ".SMS_RECEIVING_PO_ITEM_JUNCTION." rpi ON pdi.id_item = rpi.id_item AND pdi.id_po = rpi.id_po
												LEFT JOIN ".SMS_RECEIVING." r ON rpi.id_receiving = r.receiving_id
												Where p.po_code IN ('".$selectedPO."')
												AND p.po_status = 3
												GROUP BY pdi.id_po, pdi.id_item, pdi.quantity_ordered
												HAVING total_received IS NULL OR total_received < SUM(pdi.quantity_ordered)
											");
		while($valuePODemandItem = mysqli_fetch_array($queryPODemandItem)) {
			if($valuePODemandItem['quantity_ordered'] != $valuePODemandItem['total_received']){
				$queryItem = $dblms->querylms("SELECT item_id, item_code, item_title 
													FROM ".SMS_ITEM."
													Where item_id IN (".$valuePODemandItem['id_item'].")
											");
				$valueItem = mysqli_fetch_array($queryItem); 
				echo '
				<div class="item'.$selectedPO.'">
					<div class="col-sm-61">
						<label for="id_item" class="req"><b>Item</b></label>
						<input class="form-control" type="text" value="'.$valueItem['item_title'].'" name="id_item['.$selectedPO.']['.$valueItem['item_id'].']" id="id_item'.$selectedPO.$valueItem['item_id'].'" readonly required>
					</div>
					<div class="col-sm-31">
						<label for="quantity_ordered" class="req">Quantity Ordered</label>
						<input class="form-control" type="number"  value="'.$valuePODemandItem['quantity_ordered'].'" name="quantity_ordered['.$selectedPO.']['.$valueItem['item_id'].']" id="quantity_ordered'.$selectedPO.$valueItem['item_id'].'" readonly required>
					</div>
					<div class="col-sm-31">
						<label for="quantity_received" class="req">Quantity Recieved</label>
						<input class="form-control" type="number" value="'.$valuePODemandItem['quantity_remaining'].'" name="quantity_received['.$selectedPO.']['.$valueItem['item_id'].']" id="quantity_received'.$selectedPO.$valueItem['item_id'].'" required>
					</div>
					<div class="col-sm-21">
						<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
							<button type="button" class="btn btn-info" style="align-items: center;" onclick="removeItem(this)"><i class="icon-remove"></i></button>									
						</div>
					</div>
				</div>';
			}
		}
	}
} elseif (isset($_GET['selectedRequisition'])) {
	$selectedRequisition = $_GET['selectedRequisition'];
	if(isset($selectedRequisition)){
		$queryRequisitionItem = $dblms->querylms("SELECT pdi.id_requisition, pdi.id_item, pdi.quantity_requested, sum(rpi.quantity_issued) as total_issued,
													(pdi.quantity_requested - COALESCE(SUM(rpi.quantity_issued), 0)) as quantity_remaining
													FROM ".SMS_REQUISITION_DEMAND_ITEM_JUNCTION." pdi
													JOIN ".SMS_REQUISITION." p ON pdi.id_requisition = p.requisition_id
													LEFT JOIN ".SMS_ISSUANCE_REQUISITION_ITEM_JUNCTION." rpi ON pdi.id_item = rpi.id_item AND pdi.id_requisition = rpi.id_requisition
													LEFT JOIN ".SMS_ISSUANCE." r ON rpi.id_issuance = r.issuance_id
													Where p.requisition_code IN ('".$selectedRequisition."')
													AND p.requisition_status = 3
													GROUP BY pdi.id_requisition, pdi.id_item, pdi.quantity_requested
													HAVING total_issued IS NULL OR total_issued < SUM(pdi.quantity_requested)
												");
		while($valueRequisitionItem = mysqli_fetch_array($queryRequisitionItem)) {
			$queryItem = $dblms->querylms("SELECT item_id, item_code, item_title 
												FROM ".SMS_ITEM."
												Where item_id IN (".$valueRequisitionItem['id_item'].")
										");
			$valueItem = mysqli_fetch_array($queryItem);
			echo '
			<div class="item'.$selectedRequisition.'">
				<div class="col-sm-42">
					<label for="id_item" class="req"><b>Item</b></label>
					<input class="form-control" type="text" value="'.$valueItem['item_title'].'" name="id_item['.$selectedRequisition.']['.$valueItem['item_id'].']" id="id_item'.$selectedRequisition.$valueItem['item_id'].'" readonly required>
				</div>
				<div class="col-sm-31">
					<label for="quantity_requested" class="req">Quantity Requested</label>
					<input class="form-control" type="number"  value="'.$valueRequisitionItem['quantity_requested'].'" name="quantity_requested['.$selectedRequisition.']['.$valueItem['item_id'].']" id="quantity_ordered'.$selectedRequisition.$valueItem['item_id'].'" readonly required>
				</div>';
				$queryInventory = $dblms->querylms("SELECT distinct id_item, sum(quantity_added) as quantity_instock
														FROM ".SMS_INVENTORY_RECEIVING_ITEM_JUNCTION."
														Where id_item = ".$valueRequisitionItem['id_item']."
													");
				$valueInventory = mysqli_fetch_array($queryInventory);
				echo '
				<div class="col-sm-31">
					<label for="quantity_instock" class="req">Quantity In-Stock</label>
					<input class="form-control" type="number"  value="'.$valueInventory['quantity_instock'].'" name="quantity_instock['.$selectedRequisition.']['.$valueItem['item_id'].']" id="quantity_instock'.$selectedRequisition.$valueItem['item_id'].'" readonly required>
				</div>
				<div class="col-sm-31">
					<label for="quantity_issued" class="req">Quantity Issued</label>
					<input class="form-control" type="number"  name="quantity_issued['.$selectedRequisition.']['.$valueItem['item_id'].']" id="quantity_issued'.$selectedRequisition.$valueItem['item_id'].'" required>
				</div>
				<div class="col-sm-21">
					<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
						<button type="button" class="btn btn-info" style="align-items: center;" onclick="removeItem(this)"><i class="icon-remove"></i></button>									
					</div>
				</div>
			</div>';
		}
	}
} elseif (isset($_GET['stationaryItems'])) {
	$queryItem = $dblms->querylms("SELECT item_id, item_code, item_title 
									FROM ".SMS_ITEM."
									Where item_id != ''
									AND item_type = 1
								");
	echo '<option value = "">Select Item</option>';
	while($valueItem = mysqli_fetch_array($queryItem)) {
		echo '<option value = "'.$valueItem['item_id'].'">'.$valueItem['item_code'].' '.$valueItem['item_title'].'</option>';
	}
} else {
	$queryItem = $dblms->querylms("SELECT item_id, item_code, item_title 
									FROM ".SMS_ITEM."
									Where item_id != ''
									AND item_type = 2
								");
	echo '<option value = "">Select Item</option>';
	while($valueItem = mysqli_fetch_array($queryItem)) {
		echo '<option value = "'.$valueItem['item_id'].'">'.$valueItem['item_code'].' '.$valueItem['item_title'].'</option>';
	}
}

echo '
	<script>
		function removeItem(button) {
			var parentDiv = button.closest("[class*=item]");
			if (parentDiv) {
					parentDiv.removeChild(parentDiv);
			}
		}			
	</script>
';

