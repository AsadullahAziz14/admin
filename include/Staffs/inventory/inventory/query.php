<?php

if(isset($_GET['deleteId'])) {
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_INVENTORY_RECEIVING_ITEM_JUNCTION." WHERE id_inventory = '".cleanvars($_GET['deleteId'])."'");
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_INVENTORY." WHERE inventory_id  = '".cleanvars($_GET['deleteId'])."'");

    if($sqllms) {
        //------------Logs-----------
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                         => date('Y-m-d H:i:s')                                           ,
            'action'                           => "Delete"                                                      ,
            'affected_table'                   => SMS_INVENTORY_RECEIVING_ITEM_JUNCTION.', '.SMS_INVENTORY      ,
            'action_detail'                    => 'inventory_id: '.cleanvars($_GET['deleteId'])                 ,
            'path'                             =>  end($filePath)                                               ,
            'login_session_start_time'         => $_SESSION['login_time']                                       ,
            'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']   ,
            'id_user'                          => cleanvars($_SESSION['LOGINIDA_SSS'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);

        $_SESSION['msg']['status'] = '<div class="alert-box danger"><span>Success: </span>Record has been deleted successfully.</div>';
        header("Location: inventory-inventory.php");
        exit();
    }
}

if(isset($_POST['submit_inventory'])) { 
    $data = [
        'inventory_status'              => cleanvars($_POST['inventory_status'])                ,
        'inventory_description'         => cleanvars($_POST['inventory_description'])           ,
        'inventory_reorder_point'       => cleanvars($_POST['inventory_reorder_point'])         ,
        'inventory_date'                => date('Y-m-d H:i:s')                                  ,
        'id_item'                       => cleanvars($_POST['id_item'])                         ,
        'id_added'                      => cleanvars($_SESSION['LOGINIDA_SSS'])                 ,
        'date_added'                    => date('Y-m-d H:i:s')
    ];
    $queryInsert = $dblms->Insert(SMS_INVENTORY, $data);

    if($queryInsert) {
        $inventory_id = $dblms->lastestid();
        
        $data = [
            'inventory_code'        => 'INV'.str_pad($inventory_id, 5, '0', STR_PAD_LEFT)
        ];
        $conditions = "WHERE inventory_id  = ".$inventory_id."";
        $queryUpdate = $dblms->Update(SMS_INVENTORY, $data, $conditions);

        // -------------Logs------------------------
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                      => date('Y-m-d H:i:s')                                                              ,
            'action'                        => "Create"                                                                         ,
            'affected_table'                => SMS_INVENTORY                                                                    ,
            'action_detail'                 =>  'inventory_id: '.$_POST['inventory_id'].
                                                PHP_EOL.'inventory_status: '.cleanvars($_POST['inventory_status']).
                                                PHP_EOL.'inventory_description: '.cleanvars($_POST['inventory_description']).
                                                PHP_EOL.'inventory_reorder_point: '.cleanvars($_POST['inventory_reorder_point']).
                                                PHP_EOL.'inventory_date: '.date('Y-m-d H:i:s').
                                                PHP_EOL.'id_item: '.cleanvars($_POST['id_item']).
                                                PHP_EOL.'inventory_code: '.'INV'.str_pad($inventory_id, 5, '0', STR_PAD_LEFT).
                                                PHP_EOL.'id_added: '.$_SESSION['LOGINIDA_SSS'].
                                                PHP_EOL.'date_added: '.date('Y-m-d H:i:s'),
            'path'                          =>  end($filePath)                                                                  ,
            'login_session_start_time'      => $_SESSION['login_time']                                                          ,
            'ip_address'                    => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']                      ,
            'id_user'                       => cleanvars($_SESSION['LOGINIDA_SSS'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);
        
        $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been added successfully.</div>';
        header("Location: inventory-inventory.php", true, 301);
        exit();
	} 
}

if(isset($_POST['update_inventory'])) {
    $inventory_id = cleanvars($_GET['id']);
    $data = [
        'inventory_status'              => cleanvars($_POST['inventory_status'])                        ,
        'inventory_description'         => cleanvars($_POST['inventory_description'])                   ,
        'inventory_reorder_point'       => cleanvars($_POST['inventory_reorder_point'])                 ,
        'id_item'                       => cleanvars($_POST['id_item'])                                 ,
        'id_modify'                     => cleanvars($_SESSION['LOGINIDA_SSS'])                         ,
        'date_modify'                   => date('Y-m-d H:i:s')
    ];
    $conditions = "WHERE  inventory_id  = ".$inventory_id."";
    $queryUpdate = $dblms->Update(SMS_INVENTORY, $data, $conditions);

    if($queryUpdate) {
        // -------------Logs------------------------
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                      => date('Y-m-d H:i:s')                                                              ,
            'action'                        => "Update"                                                                         ,
            'affected_table'                => SMS_INVENTORY                                                                    ,
            'action_detail'                 =>  'inventory_id: '.cleanvars($_GET['id']).
                                                PHP_EOL.'inventory_status: '.cleanvars($_POST['inventory_status']).
                                                PHP_EOL.'inventory_description: '.cleanvars($_POST['inventory_description']).
                                                PHP_EOL.'inventory_reorder_point: '.cleanvars($_POST['inventory_reorder_point']).
                                                PHP_EOL.'inventory_date: '.date('Y-m-d H:i:s').
                                                PHP_EOL.'id_item: '.cleanvars($_POST['id_item']).
                                                PHP_EOL.'id_modify: '.$_SESSION['LOGINIDA_SSS'].
                                                PHP_EOL.'date_modify: '.date('Y-m-d H:i:s'),
            'path'                          =>  end($filePath)                                                                  ,
            'login_session_start_time'      => $_SESSION['login_time']                                                          ,
            'ip_address'                    => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']                      ,
            'id_user'                       => cleanvars($_SESSION['LOGINIDA_SSS'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);

        $_SESSION['msg']['status'] = '<div class="alert-box info"><span>Success: </span>Record has been updated successfully.</div>';
        header("Location: inventory-inventory.php", true, 301);
        exit();
    }
}