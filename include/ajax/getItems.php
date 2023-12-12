<?php
error_reporting(0);
include "../../dbsetting/lms_vars_config.php";
include "../../dbsetting/classdbconection.php";
$dblms = new dblms();
include "../../functions/login_func.php";
include "../../functions/functions.php";
checkCpanelLMSALogin();

//--------------------------------------------

$selectedDemand = $_GET['selectedDemand'];



if(isset($selectedDemand))
{
        $sqllms1 = $dblms->querylms("SELECT id_item, quantity_requested 
                                        FROM ".SMS_DEMAND_ITEM_JUNCTION.
                                        " Where id_demand IN (".$selectedDemand.") && is_ordered = ''");
        while($rowstd1 = mysqli_fetch_array($sqllms1))
        {
                $sqllms2 = $dblms->querylms("SELECT item_id, item_code, item_title 
                                                FROM ".SMS_ITEMS.
                                                " where item_id IN (".$rowstd1['id_item'].")");

                while ($rowstd2 = mysqli_fetch_array($sqllms2)) 
                {
                        echo '
                        <div class="item'.$selectedDemand.'">
                                <div class="col-sm-70">
                                        <label for="id_item" class="req"><b>Item Name</b></label>
                                        <input class="form-control" type="text" value="'.$rowstd2['item_title'].'" name="id_item['.$selectedDemand.']['.$rowstd2['item_id'].']" id="id_item'.$selectedDemand.$rowstd2['item_id'].'" required>
                                </div>
                                <div class="col-sm-21">
                                        <label for="quantity_requested" class="req">Quantity</label>
                                        <input class="form-control" type="number"  value="'.$rowstd1['quantity_requested'].'" name="quantity_ordered['.$selectedDemand.']['.$rowstd2['item_id'].']" id="quantity_ordered'.$selectedDemand.$rowstd2['item_id'].'" min="0" required>
                                </div>
                                <div class="col-sm-21">
                                        <label for="unit_price" class="req">Rate</label>
                                        <input class="form-control" type="number" name="unit_price['.$selectedDemand.']['.$rowstd2['item_id'].']" id="unit_price'.$selectedDemand.$rowstd2['item_id'].'" min="0" required>
                                </div>
                                <div class="col-sm-21">
                                        <div style="display: flex; justify-content: center; align-items: center; margin: 15px;">
                                                <button type="button" class="btn btn-info" style="align-items: center;" onclick="removeItem(this)"><i class="icon-remove"></i></button>									
                                        </div>
                                </div>
                        </div>
                                ';
                }
                echo '
        </select>
        ';    

        }
  
}
else
{
        $sqllms = $dblms->querylms("SELECT * FROM ".SMS_ITEMS);

        echo '<option value = "">Select Items</option>';
        while ($rowstd = mysqli_fetch_array($sqllms)) {
                echo '<option value = "'.$rowstd['item_id'].'">'.$rowstd['item_code'].' '.$rowstd['item_title'].'</option>';
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
