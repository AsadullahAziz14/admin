
<?php
if(isset($_GET['deleteId'])) {
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_RECEIVING_PO_ITEM_JUNCTION." WHERE id_receiving = ".cleanvars($_GET['deleteId'])."");
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_RECEIVING." WHERE receiving_id  = ".cleanvars($_GET['deleteId'])."");

    if($sqllms) {
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                         => date('Y-m-d H:i:s')                                           ,
            'action'                           => "Delete"                                                      ,
            'affected_table'                   => SMS_RECEIVING_PO_ITEM_JUNCTION.', '.SMS_RECEIVING             ,
            'action_detail'                    => 'receiving_id: '.cleanvars($_GET['deleteId'])                 ,
            'path'                             =>  end($filePath)                                               ,
            'login_session_start_time'         => $_SESSION['login_time']                                       ,
            'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']   ,
            'id_user'                          => cleanvars($_SESSION['LOGINIDA_SSS'])                     
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);

        $_SESSION['msg']['status'] = '<div class="alert-box danger"><span>Success: </span>Record has been deleted successfully.</div>';
        header("Location: inventory-receiving.php");
        exit();
    }
}

if(isset($_POST['submit_receiving'])) { 
    $quantity_received = 0;
    foreach ($_POST['quantity_received'] as $key => $qauntityReceivedArray) {
        $quantity_received += array_sum($qauntityReceivedArray);
    }
    
    $data = [
        'receiving_date'                    => date('Y-m-d H:i:s')                                      ,
        'delivery_chalan_num'               => cleanvars($_POST['delivery_chalan_num'])                 ,
        'id_vendor'                         => cleanvars($_POST['id_vendor'])                           ,
        'receiving_remarks'                 => cleanvars($_POST['receiving_remarks'])                   ,
        'receiving_status'                  => cleanvars($_POST['receiving_status'])                    ,
        'id_added'                          => cleanvars($_SESSION['LOGINIDA_SSS'])                     ,
        'date_added'                        => date('Y-m-d H:i:s')          
    ];
    $queryInsert = $dblms->Insert(SMS_RECEIVING, $data);

    if($queryInsert) { 
        $id_receiving = $dblms->lastestid();
        
        $data = [
            'receiving_code'              => 'R'.str_pad($id_receiving, 5, '0', STR_PAD_LEFT)
        ];
        $conditions = "WHERE receiving_id  = ".$id_receiving."";
        $queryUpdate = $dblms->Update(SMS_RECEIVING, $data, $conditions);

        foreach (cleanvars($_POST['id_item']) as $id_po => $id_itemArray) {
            foreach ($id_itemArray as $id_item => $itemTitle) {

                $queryPO = $dblms->querylms("SELECT po_id
                                            FROM ".SMS_PO." 
                                            WHERE po_code IN ('".$id_po."')
                                        ");
	            $valuePO = mysqli_fetch_array($queryPO);
                echo $valuePO['po_id'];
                $data = [
                    'id_receiving'          => $id_receiving                                        ,
                    'id_po'                 => $valuePO['po_id']                                    ,
                    'id_item'               => $id_item                                             ,
                    'quantity_received'     => $_POST['quantity_received'][$id_po][$id_item]
                ];
                $queryInsert = $dblms->Insert(SMS_RECEIVING_PO_ITEM_JUNCTION, $data);

                $queryInventory = $dblms->querylms("SELECT DISTINCT inventory_id, id_item
                                                    FROM ".SMS_INVENTORY." 
                                                    WHERE id_item =  ".$id_item."
                                                ");
	            $valueInventory = mysqli_fetch_array($queryInventory);

                $data = [
                    'id_inventory'              => $valueInventory['inventory_id']     ,
                    'id_receiving'              => $id_receiving                       ,
                    'id_item'                   => $id_item                            ,
                    'quantity_added'            => $_POST['quantity_received'][$id_po][$id_item]
                ];
                $queryInsert = $dblms->Insert(SMS_INVENTORY_RECEIVING_ITEM_JUNCTION, $data);
            }
        }
	}
    $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been added successfully.</div>';
    header("Location: inventory-receiving.php", true, 301);
    exit();
}


if(isset($_POST['update_receiving'])) {
    $receiving_id = cleanvars($_GET['id']);

    $data = [
        'delivery_chalan_num'               => cleanvars($_POST['delivery_chalan_num'])                 ,
        'id_vendor'                         => cleanvars($_POST['id_vendor'])                           ,
        'receiving_remarks'                 => cleanvars($_POST['receiving_remarks'])                   ,
        'receiving_status'                  => cleanvars($_POST['receiving_status'])                    ,
        'id_modify'                         => cleanvars($_SESSION['LOGINIDA_SSS'])                     ,
        'date_modify'                       => date('Y-m-d H:i:s')
    ];
    $conditions = "WHERE  receiving_id  = ".$receiving_id."";
    $queryUpdate = $dblms->Update(SMS_RECEIVING, $data, $conditions);

    if($queryUpdate) {
        foreach (cleanvars($_POST['id_item']) as $key => $id_itemArray) {
            if($key == "u") {
                foreach ($id_itemArray as $id_po => $itemArray) {
                    foreach ($itemArray as $id_item => $item_title) {
                        $data = [
                            'quantity_received'             => $_POST['quantity_received'][$id_po][$id_item]     ,
                        ];
                        $conditions = "Where id_receiving = ".$receiving_id." AND id_po = ".$id_po." AND id_item = ".$id_item."";
                        $queryUpdate = $dblms->Update(SMS_RECEIVING_PO_ITEM_JUNCTION, $data, $conditions);

                        $data = [
                            'is_completed'              => "1"
                        ];
                        $conditions = "Where id_po = ".$id_po." AND id_item = ".$id_item."";
                        $queryUpdate = $dblms->Update(SMS_PO_DEMAND_ITEM_JUNCTION, $data, $conditions);


                        $queryInventory = $dblms->querylms("SELECT DISTINCT inventory_id, id_item
                                                                FROM ".SMS_INVENTORY." 
                                                                WHERE id_item =  ".$id_item."
                                                            ");
                        $valueInventory = mysqli_fetch_array($queryInventory);

                        $data = [
                            'quantity_added'            => $_POST['quantity_received'][$id_po][$id_item]
                        ];
                        $conditions = "Where id_inventory = ".$valueInventory['inventory_id']." AND id_receiving = ".$receiving_id." AND id_item = ".$id_item."";
                        $queryUpdate = $dblms->Update(SMS_INVENTORY_RECEIVING_ITEM_JUNCTION, $data, $conditions);
                    }   
                }
            } else {
                $po_id = $key;
                foreach ($id_itemArray as $item_id => $itemTitle) {
                    $data = [
                        'id_receiving'                 => $receiving_id                                     ,
                        'id_po'                        => $po_id                                            ,
                        'id_item'                      => $item_id                                          ,
                        'quantity_received'            => $_POST['quantity_received'][$po_id][$item_id]     ,
                    ];
                    $queryInsert = $dblms->Insert(SMS_RECEIVING_PO_ITEM_JUNCTION , $data); 
                    
                    $queryInventory = $dblms->querylms("SELECT DISTINCT inventory_id, id_item
                                        FROM ".SMS_INVENTORY." 
                                        WHERE id_item =  ".$item_id."
                                    ");
                    $valueInventory = mysqli_fetch_array($queryInventory);

                    $data = [
                        'id_inventory'              => $valueInventory['inventory_id']                  ,
                        'id_receiving'              => $receiving_id                                    ,
                        'id_item'                   => $item_id                                         ,
                        'quantity_added'            => $_POST['quantity_received'][$po_id][$item_id]
                    ];
                    $queryInsert = $dblms->Insert(SMS_INVENTORY_RECEIVING_ITEM_JUNCTION, $data);
                }
            }
        }
    }
    $_SESSION['msg']['status'] = '<div class="alert-box info"><span>Success: </span>Record has been updated successfully.</div>';
    header("Location: inventory-receiving.php", true, 301);
    exit();
}