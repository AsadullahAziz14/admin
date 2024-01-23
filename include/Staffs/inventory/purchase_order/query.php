<?php

if(isset($_GET['deleteId'])) {
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_PO_DEMAND_ITEM_JUNCTION." WHERE id_po = '".cleanvars($_GET['deleteId'])."'");
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_PO." WHERE po_id  = '".cleanvars($_GET['deleteId'])."'");

    if($sqllms) {
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                         => date('Y-m-d H:i:s')                                           ,
            'action'                           => "Delete"                                                      ,
            'affected_table'                   => SMS_PO_DEMAND_ITEM_JUNCTION.', '.SMS_PO                      ,
            'action_detail'                    => 'po_id: '.cleanvars($_GET['deleteId'])                        ,
            'path'                             =>  end($filePath)                                               ,
            'login_session_start_time'         => $_SESSION['login_time']                                       ,
            'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']   ,
            'id_user'                          => cleanvars($_SESSION['LOGINIDA_SSS'])              
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);

        $_SESSION['msg']['status'] = '<div class="alert-box danger"><span>Success: </span>Record has been deleted successfully.</div>';
        header("Location: inventory-purchase_order.php");
        exit();
    }
}

if(isset($_POST['submit_po'])) { 
    $data = [
        'po_date'                          => date('Y-m-d H:i:s')                                   ,
        'po_delivery_date'                 => cleanvars($_POST['po_delivery_date'])                 ,
        'po_delivery_address'              => cleanvars($_POST['po_delivery_address'])              ,
        'po_remarks'                       => cleanvars($_POST['po_remarks'])                       ,
        'po_tax_perc'                      => cleanvars($_POST['po_tax_perc'])                      ,
        'po_payment_terms'                 => cleanvars($_POST['po_payment_terms'])                 ,
        'po_lead_time'                     => cleanvars($_POST['po_lead_time'])                     ,
        'po_status'                        => cleanvars($_POST['po_status'])                        ,
        'ordered_by'                       => cleanvars($_SESSION['LOGINIDA_SSS'])                  ,
        'date_ordered'                     => cleanvars($_POST['date_ordered'])                     ,
        'id_vendor'                        => cleanvars($_POST['id_vendor'])                        ,
        'id_added'                         => cleanvars($_SESSION['LOGINIDA_SSS'])                  ,
        'date_added'                       => date('Y-m-d H:i:s')
    ];
    $queryInsert = $dblms->Insert(SMS_PO, $data);

    if($queryInsert) {
        $id_po = $dblms->lastestid();

        // Logs
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                      => date('Y-m-d H:i:s')
            ,'action'                       => "Create"
            ,'affected_table'               => SMS_PO
            ,'action_detail'                =>  'po_id: '.$id_po.
                                                PHP_EOL.'po_code: '.'PO'.str_pad($id_po, 5, '0', STR_PAD_LEFT).
                                                PHP_EOL.'po_date: '.date('Y-m-d H:i:s').
                                                PHP_EOL.'po_tax_perc: '.cleanvars($_POST['po_tax_perc']).
                                                PHP_EOL.'po_delivery_date: '.cleanvars($_POST['po_delivery_date']).
                                                PHP_EOL.'po_delivery_address: '.cleanvars($_POST['po_delivery_address']).
                                                PHP_EOL.'po_remarks: '.cleanvars($_POST['po_remarks']).
                                                PHP_EOL.'po_payment_terms: '.cleanvars($_POST['po_payment_terms']).
                                                PHP_EOL.'po_lead_time: '.cleanvars($_POST['po_lead_time']).
                                                PHP_EOL.'po_status: '.cleanvars($_POST['po_status']).
                                                PHP_EOL.'ordered_by: '.cleanvars($_SESSION['LOGINIDA_SSS']).
                                                PHP_EOL.'date_ordered: '.cleanvars($_POST['date_ordered']).
                                                PHP_EOL.'id_vendor: '.cleanvars($_POST['id_vendor']).
                                                PHP_EOL.'id_added: '.cleanvars($_SESSION['LOGINIDA_SSS']).
                                                PHP_EOL.'date_added: '.date('Y-m-d H:i:s')
            ,'path'                         =>  end($filePath)
            ,'login_session_start_time'     => $_SESSION['login_time']
            ,'ip_address'                   => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                      => cleanvars($_SESSION['LOGINIDA_SSS'])             
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);

        foreach(cleanvars($_POST['id_item']) as $id_demand => $id_itemArray) {
            $queryDemand = $dblms->querylms("SELECT demand_id, demand_code
													FROM ".SMS_DEMAND."
                                                    Where demand_code = '".$id_demand."'
                                                ");
            $valueDemand = mysqli_fetch_array($queryDemand);
            $demand_id = $valueDemand['demand_id'];

            foreach ($id_itemArray as $id_item => $itemTitle) {
                $data = [
                    'id_po'                => $id_po                                            ,
                    'id_demand'            => $demand_id                                        ,
                    'id_item'              => $id_item                                          ,
                    'quantity_ordered'     => $_POST['quantity_ordered'][$id_demand][$id_item]  ,
                    'unit_price'           => $_POST['unit_price'][$id_demand][$id_item]
                ];
                $queryInsert = $dblms->Insert(SMS_PO_DEMAND_ITEM_JUNCTION, $data);

                $data = [
                    'is_ordered' => 1
                ];
                $conditions = "Where id_demand = ".$demand_id." AND id_item = ".$id_item."";
                $queryUpdate = $dblms->Update(SMS_DEMAND_ITEM_JUNCTION, $data, $conditions);
            }
        }
        
        $data = [
            'po_code'                       => 'PO'.str_pad($id_po, 5, '0', STR_PAD_LEFT)
        ];
        $conditions = "WHERE po_id  = ".$id_po."";
        $queryUpdate = $dblms->Update(SMS_PO, $data, $conditions);
        
        // $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been added successfully.</div>';
        // header("Location: inventory-purchase_order.php", true, 301);
        // exit();
	} 
}

if(isset($_POST['update_po'])) {
    $id_po = cleanvars($_GET['id']);

    $data = [
        'po_delivery_date'                 => cleanvars($_POST['po_delivery_date'])                         ,
        'po_delivery_address'              => cleanvars($_POST['po_delivery_address'])                      ,
        'po_remarks'                       => cleanvars($_POST['po_remarks'])                               ,
        'po_tax_perc'                      => cleanvars($_POST['po_tax_perc'])                              ,
        'po_payment_terms'                 => cleanvars($_POST['po_payment_terms'])                         ,
        'po_lead_time'                     => cleanvars($_POST['po_lead_time'])                             ,
        'po_status'                        => cleanvars($_POST['po_status'])                                ,
        'ordered_by'                       => cleanvars($_SESSION['LOGINIDA_SSS'])                          ,
        'date_ordered'                     => cleanvars($_POST['date_ordered'])                             ,
        'id_vendor'                        => cleanvars($_POST['id_vendor'])                                ,
        'id_modify'                        => cleanvars($_SESSION['LOGINIDA_SSS'])                          ,
        'date_modify'                      => date('Y-m-d H:i:s')
    ];
    $conditions = "WHERE  po_id  = ".$id_po."";
    $queryUpdate = $dblms->Update(SMS_PO, $data, $conditions);

    if($queryUpdate) {
        foreach (cleanvars($_POST['id_item']) as $key => $id_itemArray) {
            if($key == "u") {
                foreach ($id_itemArray as $id_demand => $id_itemArray) {
                    foreach ($id_itemArray as $id_item => $item_title) {
                        $data = [
                            'quantity_ordered'             => $_POST['quantity_ordered'][$id_demand][$id_item]     ,
                            'unit_price'                   => $_POST['unit_price'][$id_demand][$id_item]
                        ];
                        $conditions = "Where id_po = ".$id_po." AND id_demand = ".$id_demand." AND id_item = ".$id_item."";
                        $queryUpdate = $dblms->Update(SMS_PO_DEMAND_ITEM_JUNCTION, $data, $conditions);
                    }   
                }
            } else {
                $id_demand = $key;
                foreach ($id_itemArray as $id_item => $itemTitle) {
                    $data = [
                        'id_po'                            => $id_po                                            ,
                        'id_demand'                        => $id_demand                                        ,
                        'id_item'                          => $id_item                                          ,
                        'quantity_ordered'                 => $_POST['quantity_ordered'][$id_demand][$id_item]  ,
                        'unit_price'                       => $_POST['unit_price'][$id_demand][$id_item]
                    ];
                    $queryInsert = $dblms->Insert(SMS_PO_DEMAND_ITEM_JUNCTION , $data);   
                }
            } 
        }

        $_SESSION['msg']['status'] = '<div class="alert-box info"><span>Success: </span>Record has been updated successfully.</div>';
        header("Location: inventory-purchase_order.php", true, 301);
        exit();
    }
}

if(isset($_POST["forward_po"])) {
    $data = [
        'forwarded_to'      => $_POST['forwarded_to']                                           ,
        'forwarded_by'      => cleanvars($_SESSION['LOGINIDA_SSS'])                             ,
        'date_forwarded'    => date('Y-m-d H:i:s')
    ];
    $conditions = " Where po_id = ".$_POST['po_id']."";
    $queryUpdate = $dblms->Update(SMS_PO, $data, $conditions);

    $_SESSION['msg']['status'] = '<div class="alert-box info"><span>Success: </span>Forwarded successfully.</div>';
    header("Location: inventory-purchase_order.php", true, 301);
    exit();
}