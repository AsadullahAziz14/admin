<?php
error_reporting(0);
include "../../dbsetting/lms_vars_config.php";
include "../../dbsetting/classdbconection.php";
$dblms = new dblms();
include "../../functions/login_func.php";
include "../../functions/functions.php";
checkCpanelLMSALogin();

$selectedDemand = $_GET['selectedDemand'];

if(isset($selectedDemand)){
	$queryDemandItem = $dblms->querylms("SELECT id_item, quantity_requested 
											FROM ".SMS_DEMAND_ITEM_JUNCTION."
											Where id_demand IN (".$selectedDemand.") && is_ordered = ''
										");
	while($valueDemandItem = mysqli_fetch_array($queryDemandItem)) {
		$queryItems = $dblms->querylms("SELECT item_id, item_code, item_title 
											FROM ".SMS_ITEMS."
											Where item_id IN (".$valueDemandItem['id_item'].")
									");
		while($valueItem = mysqli_fetch_array($queryItems)) {
			echo '
			<div class="item'.$selectedDemand.'">
				<div class="col-sm-70">
					<label for="id_item" class="req"><b>Item Name</b></label>
					<input class="form-control" type="text" value="'.$valueItem['item_title'].'" name="id_item['.$selectedDemand.']['.$valueItem['item_id'].']" id="id_item'.$selectedDemand.$valueItem['item_id'].'" required>
				</div>
				<div class="col-sm-31">
					<label for="quantity_requested" class="req">Quantity</label>
					<input class="form-control" type="number"  value="'.$valueDemandItem['quantity_requested'].'" name="quantity_ordered['.$selectedDemand.']['.$valueItem['item_id'].']" id="quantity_ordered'.$selectedDemand.$valueItem['item_id'].'" min="0" required>
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
									FROM ".SMS_ITEMS);

	echo '<option value = "">Select Items</option>';
	while ($valueItems = mysqli_fetch_array($queryItem)) {
			echo '<option value = "'.$valueItems['item_id'].'">'.$valueItems['item_code'].' '.$valueItems['item_title'].'</option>';
	}    
}


echo '
<script>
	function removeItem(button)
	{
		var parentDiv = button.closest("[class*=item]");
		if (parentDiv) 
		{
				parentDiv.removeChild(parentDiv);
		}
	}			
</script>

';

?>
