<?php

if(isset($_GET['deleteId'])) {
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_PO_DEMAND_ITEM_JUNCTION." WHERE id_po = '".cleanvars($_GET['deleteId'])."'");
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_PO." WHERE po_id  = '".cleanvars($_GET['deleteId'])."'");

    if($sqllms) {

        //--------------- Logs ----------------------------------------
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
    }
    $_SESSION['msg']['status'] = '<div class="alert-box danger"><span>Success: </span>Record has been deleted successfully.</div>';
    header("Location: inventory-purchase_order.php");
    exit();
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
        'po_status'                        => 1                                                     ,
        'id_vendor'                        => cleanvars($_POST['id_vendor'])                        ,
        'id_added'                         => cleanvars($_SESSION['LOGINIDA_SSS'])                  ,
        'date_added'                       => date('Y-m-d H:i:s')
    ];
    $queryInsert = $dblms->Insert(SMS_PO, $data);

    if($queryInsert) {
        $po_id = $dblms->lastestid();

        $data = [
            'po_code'               => 'PO'.str_pad($po_id, 5, '0', STR_PAD_LEFT)
        ];
        $conditions = "WHERE po_id = ".$po_id."";
        $queryUpdate = $dblms->Update(SMS_PO, $data, $conditions);

        if(isset($_POST['id_item'])) {
            $items = cleanvars($_POST['id_item']);
            $po_items = implode(',', $items);

            foreach(cleanvars($_POST['id_item']) as $demand_code => $id_itemArray) {
                $queryDemand = $dblms->querylms("SELECT demand_id, demand_code
                                                    FROM ".SMS_DEMAND."
                                                    Where demand_code = '".$demand_code."'
                                                ");
                $valueDemand = mysqli_fetch_array($queryDemand);
                $demand_id = $valueDemand['demand_id'];

                foreach ($id_itemArray as $id_item => $itemTitle) {
                    $data = [
                        'id_po'                => $po_id                                            ,
                        'id_demand'            => $demand_id                                        ,
                        'id_item'              => $id_item                                          ,
                        'quantity_ordered'     => $_POST['quantity_ordered'][$demand_code][$id_item]  ,
                        'unit_price'           => $_POST['unit_price'][$demand_code][$id_item]
                    ];
                    $queryInsert = $dblms->Insert(SMS_PO_DEMAND_ITEM_JUNCTION, $data);
                }
            }
        }

        // -------------Logs------------------------
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Create"
            ,'affected_table'                   => SMS_PO.', '.SMS_PO_DEMAND_ITEM_JUNCTION
            ,'action_detail'                    => 'po_id: '.$po_id.
                                                    PHP_EOL.'po_status: '.'1'.
                                                    PHP_EOL.'po_code: '.'PO'.str_pad($po_id, 5, '0', STR_PAD_LEFT).
                                                    PHP_EOL.'po_delivery_date: '.cleanvars($_POST['po_delivery_date']).
                                                    PHP_EOL.'po_delivery_address: '.cleanvars($_POST['po_delivery_address']).
                                                    PHP_EOL.'po_remarks: '.cleanvars($_POST['po_remarks']).
                                                    PHP_EOL.'po_tax_perc: '.cleanvars($_POST['po_tax_perc']).
                                                    PHP_EOL.'po_payment_terms: '.cleanvars($_POST['po_payment_terms']).                                                    
                                                    PHP_EOL.'po_remarks: '.cleanvars($_POST['po_remarks']).
                                                    PHP_EOL.'po_remarks: '.cleanvars($_POST['po_remarks']).
                                                    PHP_EOL.'po_lead_time: '.cleanvars($_POST['po_remarks']).
                                                    PHP_EOL.'po_date: '.date('Y-m-d H:i:s').
                                                    PHP_EOL.'po_items: '.$po_items.
                                                    PHP_EOL.'id_vendor: '.cleanvars($_POST['id_vendor']).
                                                    PHP_EOL.'id_demand: '.cleanvars($_POST['id_vendor']).
                                                    PHP_EOL.'id_added: '.cleanvars($_SESSION['LOGINIDA_SSS']).
                                                    PHP_EOL.'date_added: '.date('Y-m-d H:i:s')                                  
            ,'path'                              => end($filePath)
            ,'login_session_start_time'          => $_SESSION['login_time']
            ,'ip_address'                        => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                           => cleanvars($_SESSION['LOGINIDA_SSS'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);
	} 
    $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been added successfully.</div>';
    header("Location: inventory-purchase_order.php", true, 301);
    exit();
}

if(isset($_POST['update_po'])) {
    $po_id = cleanvars($_GET['id']);

    $data = [
        'po_delivery_date'                 => cleanvars($_POST['po_delivery_date'])                         ,
        'po_delivery_address'              => cleanvars($_POST['po_delivery_address'])                      ,
        'po_remarks'                       => cleanvars($_POST['po_remarks'])                               ,
        'po_tax_perc'                      => cleanvars($_POST['po_tax_perc'])                              ,
        'po_payment_terms'                 => cleanvars($_POST['po_payment_terms'])                         ,
        'po_lead_time'                     => cleanvars($_POST['po_lead_time'])                             ,
        'ordered_by'                       => cleanvars($_SESSION['LOGINIDA_SSS'])                          ,
        'date_ordered'                     => cleanvars($_POST['date_ordered'])                             ,
        'id_vendor'                        => cleanvars($_POST['id_vendor'])                                ,
        'id_modify'                        => cleanvars($_SESSION['LOGINIDA_SSS'])                          ,
        'date_modify'                      => date('Y-m-d H:i:s')
    ];
    $conditions = "WHERE po_id  = ".$po_id."";
    $queryUpdate = $dblms->Update(SMS_PO, $data, $conditions);
    
    if(isset($_POST['deleted_item_ids']) && isset($_POST['deleted_demand_ids']) && $_POST['deleted_demand_ids'] != '' && $_POST['deleted_item_ids'] != '' ) {
        $deleteDemands = explode(',',cleanvars($_POST['deleted_demand_ids']));
        foreach ($deleteDemands as $key => $demandId) {
            $queryDelete  = $dblms->querylms("DELETE FROM ".SMS_PO_DEMAND_ITEM_JUNCTION." WHERE id_po = ".$po_id." AND id_demand IN ('".$demandId."') AND id_item IN ('".$_POST['deleted_item_ids'][$key]."')");
        }
    }

    if(isset($_POST['deleted_demand']) && $_POST['deleted_demand'] != '') {
        $deleteDemands = cleanvars($_POST['deleted_demand']);
        $queryDelete  = $dblms->querylms("DELETE FROM ".SMS_PO_DEMAND_ITEM_JUNCTION." WHERE id_po = ".$po_id." AND id_demand IN ('".$deleteDemands."')");
    }

    if($queryUpdate) {
        if(isset($_POST['id_item'])) {
            $items = cleanvars($_POST['id_item']);
            $po_items = [];
            foreach (cleanvars($_POST['id_item']) as $key => $id_itemArray) {
                if($key == "u") {
                    foreach ($id_itemArray as $demand_id => $id_itemArray) {
                        foreach ($id_itemArray as $id_item => $item_title) {
                            $data = [
                                'quantity_ordered'             => $_POST['quantity_ordered'][$demand_id][$id_item]     ,
                                'unit_price'                   => $_POST['unit_price'][$demand_id][$id_item]
                            ];
                            $conditions = "Where id_po = ".$po_id." AND id_demand = ".$demand_id." AND id_item = ".$id_item."";
                            $queryUpdate = $dblms->Update(SMS_PO_DEMAND_ITEM_JUNCTION, $data, $conditions);

                            $po_items = $id_item;
                        }   
                    }
                } else {
                    $demand_code = $key;
                    $queryDemand = $dblms->querylms("SELECT demand_id, demand_code
                                                        FROM ".SMS_DEMAND." 
                                                        WHERE demand_code = '".$demand_code."'
                                                    ");
                    $valueDemand = mysqli_fetch_array($queryDemand);
                    foreach ($id_itemArray as $id_item => $itemTitle) {
                        $data = [
                            'id_po'                            => $po_id                                                ,
                            'id_demand'                        => $valueDemand['demand_id']                             ,
                            'id_item'                          => $id_item                                              ,
                            'quantity_ordered'                 => $_POST['quantity_ordered'][$demand_code][$id_item]    ,
                            'unit_price'                       => $_POST['unit_price'][$demand_code][$id_item]
                        ];
                        $queryInsert = $dblms->Insert(SMS_PO_DEMAND_ITEM_JUNCTION, $data);
                        $po_items = $id_item; 
                    }
                } 
            }
            // -------------Logs------------------------
            $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
            $data = [
                'log_date'                          => date('Y-m-d H:i:s')
                ,'action'                           => "Update"
                ,'affected_table'                   => SMS_PO.', '.SMS_PO_DEMAND_ITEM_JUNCTION
                ,'action_detail'                    => 'po_id: '.$po_id.
                                                        PHP_EOL.'po_delivery_date: '.cleanvars($_POST['po_delivery_date']).
                                                        PHP_EOL.'po_delivery_address: '.cleanvars($_POST['po_delivery_address']).
                                                        PHP_EOL.'po_remarks: '.cleanvars($_POST['po_remarks']).
                                                        PHP_EOL.'po_tax_perc: '.cleanvars($_POST['po_tax_perc']).
                                                        PHP_EOL.'po_payment_terms: '.cleanvars($_POST['po_payment_terms']).                                                    
                                                        PHP_EOL.'po_lead_time: '.cleanvars($_POST['po_lead_time']).
                                                        PHP_EOL.'po_date: '.date('Y-m-d H:i:s').
                                                        PHP_EOL.'po_items: '.$po_items.
                                                        PHP_EOL.'id_vendor: '.cleanvars($_POST['id_vendor']).
                                                        PHP_EOL.'id_modify: '.cleanvars($_SESSION['LOGINIDA_SSS']).
                                                        PHP_EOL.'date_modify: '.date('Y-m-d H:i:s')                                  
                ,'path'                             =>  end($filePath)
                ,'login_session_start_time'         => $_SESSION['login_time']
                ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
                ,'id_user'                          => cleanvars($_SESSION['LOGINIDA_SSS'])
            ];
            $queryInsert = $dblms->Insert(SMS_LOGS, $data);
        }
    }
    $_SESSION['msg']['status'] = '<div class="alert-box info"><span>Success: </span>Record has been updated successfully.</div>';
    header("Location: inventory-purchase_order.php", true, 301);
    exit();
}

if(isset($_POST["forward_po"])) {
    $data = [
        'forwarded_to'      => $_POST['forwarded_to']                       ,
        'forwarded_by'      => cleanvars($_SESSION['LOGINIDA_SSS'])         ,
        'po_status'         => 2                                            ,
        'date_forwarded'    => date('Y-m-d H:i:s')
    ];
    $conditions = " Where po_id = ".$_POST['po_id']."";
    $queryUpdate = $dblms->Update(SMS_PO, $data, $conditions);

     // -------------Logs------------------------
     $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
     $data = [
         'log_date'                         => date('Y-m-d H:i:s')                                                   ,
         'action'                           => "Update"                                                              ,
         'affected_table'                   => SMS_PO                                                                ,
         'action_detail'                    =>  'po_id: '.$_POST['po_id'].
                                                 PHP_EOL.'forwarded_to: '.cleanvars($_POST['forwarded_to']).
                                                 PHP_EOL.'forwarded_by: '.cleanvars($_SESSION['LOGINIDA_SSS']).
                                                 PHP_EOL.'po_status: '.'2'.
                                                 PHP_EOL.'date_forwarded: '.date('Y-m-d H:i:s').
                                                 PHP_EOL.'id_modify: '.$_SESSION['LOGINIDA_SSS'].
                                                 PHP_EOL.'date_modify: '.date('Y-m-d H:i:s')                         ,
         'path'                             =>  end($filePath)                                                       ,
         'login_session_start_time'         => $_SESSION['login_time']                                               ,
         'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']           ,
         'id_user'                          => cleanvars($_SESSION['LOGINIDA_SSS'])
     ];
     $queryInsert = $dblms->Insert(SMS_LOGS, $data);

    $_SESSION['msg']['status'] = '<div class="alert-box info"><span>Success: </span>Forwarded successfully.</div>';
    header("Location: inventory-purchase_order.php", true, 301);
    exit();
}

if(isset($_POST["approve_po"])) {
    $data = [
        'id_approved_rejected'          => cleanvars($_SESSION['LOGINIDA_SSS'])       ,
        'po_status'                     => 3                                          ,
        'date_approved_rejected'        => date('Y-m-d H:i:s')
    ];
    $conditions = " Where po_id = ".$_POST['po_id']."";
    $queryUpdate = $dblms->Update(SMS_PO, $data, $conditions);

    // -------------Logs------------------------
    $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
    $data = [
        'log_date'                         => date('Y-m-d H:i:s')                                                       ,
        'action'                           => "Update"                                                                  ,
        'affected_table'                   => SMS_PO                                                                    ,
        'action_detail'                    =>  'po_id: '.$_POST['po_id'].
                                                PHP_EOL.'id_approved_rejected: '.cleanvars($_SESSION['LOGINIDA_SSS']).
                                                PHP_EOL.'po_status: '.'3'.
                                                PHP_EOL.'date_approved_rejected: '.date('Y-m-d H:i:s').
                                                PHP_EOL.'id_modify: '.$_SESSION['LOGINIDA_SSS'].
                                                PHP_EOL.'date_modify: '.date('Y-m-d H:i:s'),
        'path'                             =>  end($filePath)                                                           ,
        'login_session_start_time'         => $_SESSION['login_time']                                                   ,
        'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']               ,
        'id_user'                          => cleanvars($_SESSION['LOGINIDA_SSS'])
    ];
    $queryInsert = $dblms->Insert(SMS_LOGS, $data);

    $_SESSION['msg']['status'] = '<div class="alert-box info"><span>Success: </span>Forwarded successfully.</div>';
    header("Location: inventory-purchase_order.php", true, 301);
    exit();
}

if(isset($_POST["reject_po"])) {
    $data = [
        'id_approved_rejected'          => cleanvars($_SESSION['LOGINIDA_SSS'])         ,
        'po_status'                     => 4                                            ,
        'date_approved_rejected'        => date('Y-m-d H:i:s')
    ];
    $conditions = " Where po_id = ".$_POST['po_id']."";
    $queryUpdate = $dblms->Update(SMS_PO, $data, $conditions);

    // -------------Logs------------------------
    $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
    $data = [
        'log_date'                         => date('Y-m-d H:i:s')                                                       ,
        'action'                           => "Update"                                                                  ,
        'affected_table'                   => SMS_PO                                                                    ,
        'action_detail'                    =>  'po_id: '.$_POST['po_id'].
                                                PHP_EOL.'id_approved_rejected: '.cleanvars($_SESSION['LOGINIDA_SSS']).
                                                PHP_EOL.'po_status: '.'4'.
                                                PHP_EOL.'date_approved_rejected: '.date('Y-m-d H:i:s').
                                                PHP_EOL.'id_modify: '.$_SESSION['LOGINIDA_SSS'].
                                                PHP_EOL.'date_modify: '.date('Y-m-d H:i:s'),
        'path'                             =>  end($filePath)                                                           ,
        'login_session_start_time'         => $_SESSION['login_time']                                                   ,
        'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']               ,
        'id_user'                          => cleanvars($_SESSION['LOGINIDA_SSS'])
    ];
    $queryInsert = $dblms->Insert(SMS_LOGS, $data);

    $_SESSION['msg']['status'] = '<div class="alert-box info"><span>Success: </span>Forwarded successfully.</div>';
    header("Location: inventory-purchase_order.php", true, 301);
    exit();
}