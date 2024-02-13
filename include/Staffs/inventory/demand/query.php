<?php

if(isset($_GET['deleteId'])) {
    $queryDeleteDemadItemJunction  = $dblms->querylms("DELETE FROM ".SMS_DEMAND_ITEM_JUNCTION." WHERE id_demand = '".cleanvars($_GET['deleteId'])."'");
    $queryDeleteDemand  = $dblms->querylms("DELETE FROM ".SMS_DEMAND." WHERE demand_id  = '".cleanvars($_GET['deleteId'])."'");

    if($queryDeleteDemand) {

        // -------------Logs------------------------
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                         => date('Y-m-d H:i:s')                                               ,
            'action'                           => "Delete"                                                          ,
            'affected_table'                   => SMS_DEMAND_ITEM_JUNCTION.', '.SMS_DEMAND                          ,
            'action_detail'                    => 'demand_id: '.cleanvars($_GET['deleteId'])                        ,
            'path'                             =>  end($filePath)                                                   ,
            'login_session_start_time'         => $_SESSION['login_time']                                           ,
            'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']       ,
            'id_user'                          => cleanvars($_SESSION['LOGINIDA_SSS'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);

        $_SESSION['msg']['status'] = '<div class="alert-box danger"><span>Success: </span>Record has been deleted successfully.</div>';
        header("Location: inventory-demand.php");
        exit();
    }
}


if(isset($_POST['submit_demand'])) { 
    $data = [
        'demand_type'                          => cleanvars($_POST['demand_type'])                      ,
        'demand_date'                          => date('Y-m-d H:i:s')                                   ,
        'demand_status'                        => 1                                                     ,
        'id_department'                        => cleanvars($_POST['id_department'])                    ,
        'id_added'                             => cleanvars($_SESSION['LOGINIDA_SSS'])                  ,
        'date_added'                           => date('Y-m-d H:i:s')

    ];
    $queryInsert = $dblms->Insert(SMS_DEMAND, $data);

    if($queryInsert) {
        $demand_id = $dblms->lastestid();

        if(isset($_POST['item'])) {
            $items = cleanvars($_POST['item']);
            $item_ids_str = implode(',', $items);

            $demanded_items = $item_ids_str;
            $demand_due_date = [];

            foreach ($items as $index => $item_id) {
                $data = [
                    'id_demand'                         => $demand_id                                       ,
                    'id_item'                           => $item_id                                         ,
                    'quantity_demanded'                 => cleanvars($_POST['quantity_demanded'][$index])   ,
                    'item_due_date'                     => cleanvars($_POST['item_due_date'][$index])        
                ];
                $queryInsert = $dblms->Insert(SMS_DEMAND_ITEM_JUNCTION, $data);

                $demand_due_date[] = cleanvars($_POST['item_due_date'][$index]);
            }
            $min_demand_due_date = min($demand_due_date);
        }

        $data = [
            'demand_code'                                  => 'D'.str_pad($demand_id, 5, '0', STR_PAD_LEFT)     ,
            'demand_due_date'                              => $min_demand_due_date
        ];
        $conditions = "WHERE demand_id  = ".$demand_id."";
        $queryUpdate = $dblms->Update(SMS_DEMAND, $data, $conditions);

        // -------------Logs------------------------
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Create"
            ,'affected_table'                   => SMS_DEMAND.', '.SMS_DEMAND_ITEM_JUNCTION
            ,'action_detail'                    => 'demand_id: '.$demand_id.
                                                    PHP_EOL.'demand_code: '.'D'.str_pad($demand_id, 5, '0', STR_PAD_LEFT).
                                                    PHP_EOL.'demand_type: '.cleanvars($_POST['demand_type']).
                                                    PHP_EOL.'demanded_items: '.$demanded_items.
                                                    PHP_EOL.'demand_date: '.date('Y-m-d H:i:s').
                                                    PHP_EOL.'demand_status: '.'1'.
                                                    PHP_EOL.'demand_due_date: '.$min_demand_due_date.
                                                    PHP_EOL.'id_added: '.cleanvars($_SESSION['LOGINIDA_SSS']).
                                                    PHP_EOL.'date_added: '.date('Y-m-d H:i:s')                                  
            ,'path'                              =>  end($filePath)
            ,'login_session_start_time'          => $_SESSION['login_time']
            ,'ip_address'                        => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                           => cleanvars($_SESSION['LOGINIDA_SSS'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);
	}
    $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been added successfully.</div>';
    header("Location: inventory-demand.php", true, 301);
    exit(); 
}

if(isset($_POST['update_demand'])) {
    $demand_id = cleanvars($_GET['id']); 
    $data = [
        'demand_type'                      => cleanvars($_POST['demand_type'])          ,
        'id_department'                    => cleanvars($_POST['id_department'])        ,
        'id_modify'                        => cleanvars($_SESSION['LOGINIDA_SSS'])      ,
        'date_modify'                      => date('Y-m-d H:i:s')                   
    ];
    $conditions = "WHERE demand_id = ".$demand_id."";
    $queryUpdate = $dblms->Update(SMS_DEMAND, $data, $conditions);

    if($queryUpdate) {
        $min_demand_due_date = 0;
        $demanded_items_str = '';

        if(isset($_POST['item'])) {
            if(isset($_POST['deleted_item_ids'])) {
                $queryDelete  = $dblms->querylms("DELETE FROM ".SMS_DEMAND_ITEM_JUNCTION." WHERE id_demand = ".$demand_id." && id_item IN(".$_POST['deleted_item_ids'].")");
            }

            $items = cleanvars($_POST['item']);
            $demanded_items = [];
            $demand_due_date = [];

            foreach ($items as $index => $item_id) {
                if(isset($item_id['u'])) {
                    $data = [
                        'id_demand'                         => $demand_id                                               ,
                        'id_item'                           => $item_id['u']                                            ,
                        'quantity_demanded'                 => cleanvars($_POST['quantity_demanded'][$index]['u'])      ,
                        'item_due_date'                     => cleanvars($_POST['item_due_date'][$index]['u'])
                    ];
                    $conditions = "WHERE id_demand  = ".$demand_id." && id_item = ".$item_id['u'] ;
                    $query = $dblms->update(SMS_DEMAND_ITEM_JUNCTION, $data, $conditions);

                    $demand_due_date[] = cleanvars($_POST['item_due_date'][$index]['u']);
                    $demanded_items[] = $item_id['u'];
                } elseif (isset($item_id['n'])) {
                    $data = [
                        'id_demand'                             => $demand_id                                            ,
                        'id_item'                               => $item_id['n']                                         ,
                        'quantity_demanded'                     => cleanvars($_POST['quantity_demanded'][$index]['n'])   ,
                        'item_due_date'                         => cleanvars($_POST['item_due_date'][$index]['n'])        
                    ];
                    $queryInsert = $dblms->Insert(SMS_DEMAND_ITEM_JUNCTION, $data);

                    $demand_due_date[] = cleanvars($_POST['item_due_date'][$index]['n']);
                    $demanded_items[] = $item_id['n'];
                }   
            }
            $min_demand_due_date = min($demand_due_date);
            $demanded_items_str = implode(',',$demanded_items);
        }

        $data = [
            'demand_due_date'             => $min_demand_due_date
        ];
        $conditions = "WHERE demand_id  = ".$demand_id."";
        $queryUpdate = $dblms->Update(SMS_DEMAND, $data, $conditions);

        // -------------Logs------------------------
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                         => date('Y-m-d H:i:s')                                                           ,
            'action'                           => "Update"                                                                      ,
            'affected_table'                   => SMS_DEMAND.', '.SMS_DEMAND_ITEM_JUNCTION                                                                    ,
            'action_detail'                    =>  'demand_id: '.$demand_id.
                                                    PHP_EOL.'demand_type: '.cleanvars($_POST['demand_type']).
                                                    PHP_EOL.'demanded_items: '.$demanded_items_str.
                                                    PHP_EOL.'demand_due_date: '.$min_demand_due_date.
                                                    PHP_EOL.'id_modify: '.$_SESSION['LOGINIDA_SSS'].
                                                    PHP_EOL.'date_modify: '.date('Y-m-d H:i:s'),
            'path'                             =>  end($filePath)                                                               ,
            'login_session_start_time'         => $_SESSION['login_time']                                                       ,
            'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']                   ,
            'id_user'                          => cleanvars($_SESSION['LOGINIDA_SSS'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);

        $_SESSION['msg']['status'] = '<div class="alert-box info"><span>Success: </span>Record has been updated successfully.</div>';
        header("Location: inventory-demand.php", true, 301);
        exit();
    }
}

if(isset($_POST["forward_demand"])) {
    $data = [
        'forwarded_to'      => cleanvars($_POST['forwarded_to'])                    ,
        'forwarded_by'      => cleanvars($_SESSION['LOGINIDA_SSS'])                 ,
        'demand_status'     => 2                                                    ,
        'date_forwarded'    => date('Y-m-d H:i:s')
    ];
    $conditions = " Where demand_id = ".$_POST['demand_id']."";
    $queryUpdate = $dblms->Update(SMS_DEMAND, $data, $conditions);

    // -------------Logs------------------------
    $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
    $data = [
        'log_date'                         => date('Y-m-d H:i:s')                                                           ,
        'action'                           => "Update"                                                                      ,
        'affected_table'                   => SMS_DEMAND                                                                   ,
        'action_detail'                    =>  'demand_id: '.$_POST['demand_id'].
                                                PHP_EOL.'forwarded_to: '.cleanvars($_POST['forwarded_to']).
                                                PHP_EOL.'forwarded_by: '.cleanvars($_SESSION['LOGINIDA_SSS']).
                                                PHP_EOL.'demand_status: '.'2'.
                                                PHP_EOL.'date_forwarded: '.date('Y-m-d H:i:s').
                                                PHP_EOL.'id_modify: '.$_SESSION['LOGINIDA_SSS'].
                                                PHP_EOL.'date_modify: '.date('Y-m-d H:i:s'),
        'path'                             =>  end($filePath)                                                               ,
        'login_session_start_time'         => $_SESSION['login_time']                                                       ,
        'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']                   ,
        'id_user'                          => cleanvars($_SESSION['LOGINIDA_SSS'])
    ];
    $queryInsert = $dblms->Insert(SMS_LOGS, $data);

    $_SESSION['msg']['status'] = '<div class="alert-box info"><span>Success: </span>Forwarded successfully.</div>';
    header("Location: inventory-demand.php", true, 301);
    exit();
}

if(isset($_POST["approve_demand"])) {
    $data = [
        'id_approved_rejected'          => cleanvars($_SESSION['LOGINIDA_SSS'])     ,
        'demand_status'                 => 3                                        ,
        'date_approved_rejected'        => date('Y-m-d H:i:s')
    ];
    $conditions = " Where demand_id = ".$_POST['demand_id']."";
    $queryUpdate = $dblms->Update(SMS_DEMAND, $data, $conditions);

    // -------------Logs------------------------
    $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
    $data = [
        'log_date'                         => date('Y-m-d H:i:s')                                                           ,
        'action'                           => "Update"                                                                      ,
        'affected_table'                   => SMS_DEMAND                                                                   ,
        'action_detail'                    =>  'demand_id: '.$_POST['demand_id'].
                                                PHP_EOL.'id_approved_rejected: '.cleanvars($_SESSION['LOGINIDA_SSS']).
                                                PHP_EOL.'demand_status: '.'3'.
                                                PHP_EOL.'date_approved_rejected: '.date('Y-m-d H:i:s').
                                                PHP_EOL.'id_modify: '.$_SESSION['LOGINIDA_SSS'].
                                                PHP_EOL.'date_modify: '.date('Y-m-d H:i:s'),
        'path'                             =>  end($filePath)                                                               ,
        'login_session_start_time'         => $_SESSION['login_time']                                                       ,
        'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']                   ,
        'id_user'                          => cleanvars($_SESSION['LOGINIDA_SSS'])
    ];
    $queryInsert = $dblms->Insert(SMS_LOGS, $data);

    $_SESSION['msg']['status'] = '<div class="alert-box info"><span>Success: </span>Forwarded successfully.</div>';
    header("Location: inventory-demand.php", true, 301);
    exit();
}

if(isset($_POST["reject_demand"])) {
    $data = [
        'id_approved_rejected'          => cleanvars($_SESSION['LOGINIDA_SSS'])            ,
        'demand_status'                 => 4                                               ,
        'date_approved_rejected'        => date('Y-m-d H:i:s')
    ];
    $conditions = " Where demand_id = ".$_POST['demand_id']."";
    $queryUpdate = $dblms->Update(SMS_DEMAND, $data, $conditions);

    // -------------Logs------------------------
    $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
    $data = [
        'log_date'                         => date('Y-m-d H:i:s')                                                           ,
        'action'                           => "Update"                                                                      ,
        'affected_table'                   => SMS_DEMAND                                                                   ,
        'action_detail'                    =>  'demand_id: '.$_POST['demand_id'].
                                                PHP_EOL.'id_approved_rejected: '.cleanvars($_SESSION['LOGINIDA_SSS']).
                                                PHP_EOL.'demand_status: '.'4'.
                                                PHP_EOL.'date_approved_rejected: '.date('Y-m-d H:i:s').
                                                PHP_EOL.'id_modify: '.$_SESSION['LOGINIDA_SSS'].
                                                PHP_EOL.'date_modify: '.date('Y-m-d H:i:s'),
        'path'                             =>  end($filePath)                                                               ,
        'login_session_start_time'         => $_SESSION['login_time']                                                       ,
        'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']                   ,
        'id_user'                          => cleanvars($_SESSION['LOGINIDA_SSS'])
    ];
    $queryInsert = $dblms->Insert(SMS_LOGS, $data);

    $_SESSION['msg']['status'] = '<div class="alert-box info"><span>Success: </span>Forwarded successfully.</div>';
    header("Location: inventory-demand.php", true, 301);
    exit();
}