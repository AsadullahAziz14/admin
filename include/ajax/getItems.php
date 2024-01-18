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
		$queryDemandItem = $dblms->querylms("SELECT distinct id_item, sum(quantity_demanded) as quantity_demanded
												FROM ".SMS_DEMAND_ITEM_JUNCTION."
												Where id_demand IN (".$selectedDemand.") AND is_ordered = ''
												GROUP BY id_item
											");
		while($valueDemandItem = mysqli_fetch_array($queryDemandItem)) {
			$queryItem = $dblms->querylms("SELECT item_id, item_code, item_title 
												FROM ".SMS_ITEM."
												Where item_id IN (".$valueDemandItem['id_item'].")
										");
			$valueItem = mysqli_fetch_array($queryItem);
			echo '
			<div class="item'.$selectedDemand.'">
				<div class="col-sm-42">
					<label for="id_item" class="req"><b>Item</b></label>
					<input class="form-control" type="text" value="'.$valueItem['item_title'].'" name="id_item['.$selectedDemand.']['.$valueItem['item_id'].']" id="id_item'.$selectedDemand.$valueItem['item_id'].'" readonly required>
				</div>
				<div class="col-sm-31">
					<label for="quantity_demanded" class="req">Demand Quantity</label>
					<input class="form-control" type="number"  value="'.$valueDemandItem['quantity_demanded'].'" name="quantity_demanded['.$selectedDemand.']['.$valueItem['item_id'].']" id="quantity_demanded'.$selectedDemand.$valueItem['item_id'].'" min="0" readonly required>
				</div>
				<div class="col-sm-31">
					<label for="quantity_ordered" class="req">Ordered Quantity</label>
					<input class="form-control" type="number" name="quantity_ordered['.$selectedDemand.']['.$valueItem['item_id'].']" id="quantity_ordered'.$selectedDemand.$valueItem['item_id'].'" min="0" required>
				</div>
				<div class="col-sm-31">
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
} elseif (isset($_GET['selectedDemandRequisition'])) {
	$selectedDemandRequisition = $_GET['selectedDemandRequisition'];
	if(isset($selectedDemandRequisition)) {
		$queryDemandItem = $dblms->querylms("SELECT distinct id_item, sum(quantity_demanded) as quantity_demanded
												FROM ".SMS_DEMAND_ITEM_JUNCTION."
												Where id_demand IN (".$selectedDemandRequisition.") AND is_ordered = ''
												GROUP BY id_item
											");
		while($valueDemandItem = mysqli_fetch_array($queryDemandItem)) {
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
					<input class="form-control" type="number" name="quantity_requested['.$selectedDemandRequisition.']['.$valueItem['item_id'].']" id="quantity_requested'.$selectedDemandRequisition.$valueItem['item_id'].'" min="0" required>
				</div>
				<div class="col-sm-21">
					<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
						<button type="button" class="btn btn-info" style="align-items: center;" onclick="removeItem(this)"><i class="icon-remove"></i></button>									
					</div>
				</div>
			</div>';
		}
	}
} elseif (isset($_GET['selectedPO'])) {
	$selectedPO = $_GET['selectedPO'];
	if(isset($selectedPO)){
		$queryPODemandItem = $dblms->querylms("SELECT distinct id_item, sum(quantity_ordered) as quantity_ordered
											FROM ".SMS_PO_DEMAND_ITEM_JUNCTION."
											Where id_po IN (".$selectedPO.")
											GROUP BY id_item
										");
		while($valuePODemandItem = mysqli_fetch_array($queryPODemandItem)) {
			$queryItem = $dblms->querylms("SELECT item_id, item_code, item_title 
												FROM ".SMS_ITEM."
												Where item_id IN (".$valuePODemandItem['id_item'].")
										");
			$valueItem = mysqli_fetch_array($queryItem); 
			echo '
			<div class="item'.$selectedPO.'">
				<div class="col-sm-61">
					<label for="id_item" class="req"><b>Item Name</b></label>
					<input class="form-control" type="text" value="'.$valueItem['item_title'].'" name="id_item['.$selectedPO.']['.$valueItem['item_id'].']" id="id_item'.$selectedPO.$valueItem['item_id'].'" readonly required>
				</div>
				<div class="col-sm-31">
					<label for="quantity_ordered" class="req">Quantity Ordered</label>
					<input class="form-control" type="number"  value="'.$valuePODemandItem['quantity_ordered'].'" name="quantity_ordered['.$selectedPO.']['.$valueItem['item_id'].']" id="quantity_ordered'.$selectedPO.$valueItem['item_id'].'" readonly required>
				</div>
				<div class="col-sm-31">
					<label for="quantity_received" class="req">Quantity Recieved</label>
					<input class="form-control" type="number"  name="quantity_received['.$selectedPO.']['.$valueItem['item_id'].']" id="quantity_received'.$selectedPO.$valueItem['item_id'].'" required>
				</div>
				<div class="col-sm-21">
					<div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
						<button type="button" class="btn btn-info" style="align-items: center;" onclick="removeItem(this)"><i class="icon-remove"></i></button>									
					</div>
				</div>
			</div>';
			
		}
	}
} elseif (isset($_GET['selectedRequisition'])) {
	$selectedRequisition = $_GET['selectedRequisition'];
	if(isset($selectedRequisition)){
		$queryRequisitionItem = $dblms->querylms("SELECT distinct id_item, sum(quantity_requested) as quantity_requested
											FROM ".SMS_REQUISITION_DEMAND_ITEM_JUNCTION."
											Where id_requisition IN (".$selectedRequisition.")
											GROUP BY id_item
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
				</div>
				';
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
} else {
	$queryItem = $dblms->querylms("SELECT item_id, item_code, item_title 
												FROM ".SMS_ITEM."
												Where item_id != ''
										");
	$valueItem = mysqli_fetch_array($queryItem);
	echo '<option value = "">Select Item</option>';
	while($valueItem = mysqli_fetch_array($queryItem)) {
			echo '<option value = "'.$valueItem['item_id'].'">'.$valueItem['item_code'].'</option>';
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

