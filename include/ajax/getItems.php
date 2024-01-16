<?php
include "../../dbsetting/lms_vars_config.php";
include "../../dbsetting/classdbconection.php";
$dblms = new dblms();
include "../../functions/login_func.php";
include "../../functions/functions.php";
checkCpanelLMSALogin();


if(isset($_GET['selectedDemand'])) {
	$selectedDemand = $_GET['selectedDemand'];
	if(isset($selectedDemand)){
		$queryDemandItem = $dblms->querylms("SELECT id_item, quantity_demanded 
												FROM ".SMS_DEMAND_ITEM_JUNCTION."
												Where id_demand IN (".$selectedDemand.") && is_ordered = ''
											");
		while($valueDemandItem = mysqli_fetch_array($queryDemandItem)) {
			$queryItems = $dblms->querylms("SELECT item_id, item_code, item_title 
												FROM ".SMS_ITEM."
												Where item_id IN (".$valueDemandItem['id_item'].")
										");
			while($valueItem = mysqli_fetch_array($queryItems)) {
				echo '
				<div class="item'.$selectedDemand.'">
					<div class="col-sm-70">
						<label for="id_item" class="req"><b>Item Name</b></label>
						<input class="form-control" type="text" value="'.$valueItem['item_title'].'" name="id_item['.$selectedDemand.']['.$valueItem['item_id'].']" id="id_item'.$selectedDemand.$valueItem['item_id'].'" readonly required>
					</div>
					<div class="col-sm-31">
						<label for="quantity" class="req">Quantity</label>
						<input class="form-control" type="number"  value="'.$valueDemandItem['quantity_demanded'].'" name="quantity['.$selectedDemand.']['.$valueItem['item_id'].']" id="quantity'.$selectedDemand.$valueItem['item_id'].'" min="0" required>
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
		$queryPOItem = $dblms->querylms("SELECT id_item, quantity_ordered 
											FROM ".SMS_PO_DEMAND_ITEM_JUNCTION."
											Where id_po IN (".$selectedPO.")
										");
		while($valuePOItem = mysqli_fetch_array($queryPOItem)) {
			$queryItems = $dblms->querylms("SELECT item_id, item_code, item_title 
												FROM ".SMS_ITEM."
												Where item_id IN (".$valuePOItem['id_item'].")
										");
			while($valueItem = mysqli_fetch_array($queryItems)) {
				echo '
				<div class="item'.$selectedPO.'">
					<div class="col-sm-61">
						<label for="id_item" class="req"><b>Item Name</b></label>
						<input class="form-control" type="text" value="'.$valueItem['item_title'].'" name="id_item['.$selectedPO.']['.$valueItem['item_id'].']" id="id_item'.$selectedPO.$valueItem['item_id'].'" readonly required>
					</div>
					<div class="col-sm-31">
						<label for="quantity_ordered" class="req">Quantity Ordered</label>
						<input class="form-control" type="number"  value="'.$valuePOItem['quantity_ordered'].'" name="quantity_ordered['.$selectedPO.']['.$valueItem['item_id'].']" id="quantity_ordered'.$selectedPO.$valueItem['item_id'].'" readonly required>
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

?>
