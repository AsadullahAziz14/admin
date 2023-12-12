<?php

if(isset($_GET['deleteId']))
{
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_DEMAND_ITEM_JUNCTION." WHERE id_demand = '".cleanvars($_GET['deleteId'])."'");
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_DEMAND." WHERE demand_id  = '".cleanvars($_GET['deleteId'])."'");

    if($sqllms)
    {
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Delete"
            ,'affected_table'                   => SMS_DEMAND_ITEM_JUNCTION.', '.SMS_DEMAND
            ,'action_detail'                    =>  'demand_id: '.cleanvars($_GET['deleteId'])
            ,'path'                             =>  end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS , $data);

        $_SESSION['msg']['status'] = 'toastr.info("Deleted Succesfully");';
        header("Location: demand.php");
        exit();
    }
}


if(isset($_POST['submit_demand']))
{ 
    $data = [
        'demand_type'                           => cleanvars($_POST['demand_type'])
        ,'demand_date'                          => date('Y-m-d H:i:s')
        ,'demand_status'                        => cleanvars($_POST['demand_status'])
        ,'id_department'                        => cleanvars($_POST['id_department'])
        ,'id_added'                             => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ,'date_added'                           => date('Y-m-d H:i:s')          
    ];
    $queryInsert = $dblms->Insert(SMS_DEMAND , $data);

    if($queryInsert) 
    {
        $demand_id = $dblms->lastestid();
        
        if(isset($_POST['item']))
        {
            $items = cleanvars($_POST['item']);
            $itemIdsStr = implode(',', $items);

            $demand_quantity = 0;
            foreach ($items as $index => $item_id) 
            {
                $demand_due_date = cleanvars($_POST['item_due_date'][$index]);
                $demand_quantity += cleanvars($_POST['quantity_requested'][$index]);
                $data = [
                    'id_demand'                             => $demand_id
                    ,'id_item'                              => $item_id
                    ,'quantity_requested'                   => cleanvars($_POST['quantity_requested'][$index])
                    ,'item_due_date'                        => cleanvars($_POST['item_due_date'][$index])        
                ];
                $queryInsert = $dblms->Insert(SMS_DEMAND_ITEM_JUNCTION , $data);
            }
        }

        $data = [
            'demand_code'                                   => 'D'.str_pad($demand_id, 5, '0', STR_PAD_LEFT)
            ,'demand_quantity'                              => $demand_quantity
            ,'demand_due_date'                              => $demand_due_date
        ];
        
        $conditions = "WHERE demand_id  = ".$demand_id."";
        $queryUpdate = $dblms->Update(SMS_DEMAND, $data, $conditions);

        // Logs

        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Create"
            ,'affected_table'                   => SMS_DEMAND
            ,'action_detail'                    =>  'demand_id: '.$demand_id.
                                                    PHP_EOL.'demand_code: '.'D'.str_pad($demand_id, 5, '0', STR_PAD_LEFT).
                                                    PHP_EOL.'demand_type: '.cleanvars($_POST['demand_type']).
                                                    PHP_EOL.'demand_quantity: '.$demand_quantity.
                                                    PHP_EOL.'demand_date: '.date('Y-m-d H:i:s').
                                                    PHP_EOL.'demand_due_date: '.$demand_due_date.
                                                    PHP_EOL.'demand_status: '.cleanvars($_POST['demand_status']).
                                                    PHP_EOL.'id_added: '.cleanvars($_SESSION['userlogininfo']['LOGINIDA']).
                                                    PHP_EOL.'date_added: '.date('Y-m-d H:i:s')
            ,'path'                             =>  end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS , $data);

        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Create"
            ,'affected_table'                   => SMS_DEMAND_ITEM_JUNCTION
            ,'action_detail'                    =>  'demand_id: '.$demand_id.
                                                    PHP_EOL. implode(',',cleanvars($_POST['item'])).
                                                    PHP_EOL. implode(',',cleanvars($_POST['quantity_requested'])).
                                                    PHP_EOL. implode(',',cleanvars($_POST['item_due_date'])).
                                                    PHP_EOL.'id_modify: '.cleanvars($_SESSION['userlogininfo']['LOGINIDA']).
                                                    PHP_EOL.'date_modify: '.date('Y-m-d H:i:s')
            ,'path'                             =>  end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS , $data);
        
        $_SESSION['msg']['status'] = 'toastr.success("Inserted Succesfully");';
        header("Location: demand.php", true, 301);
        exit();

	} 
}

if(isset($_POST['update_demand'])) 
{
    $demand_id = cleanvars($_GET['id']); 
    $data = [
        'demand_type'                       => cleanvars($_POST['demand_type'])
        ,'id_department'                    => cleanvars($_POST['id_department'])
        ,'demand_status'                    => cleanvars($_POST['demand_status'])
        ,'id_modify'                        => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])           
        ,'date_modify'                      => date('Y-m-d H:i:s')                
    ];
    $conditions = "WHERE  demand_id  = ".$demand_id."";
    $queryUpdate = $dblms->Update(SMS_DEMAND,$data, $conditions);

    if($queryUpdate) 
    {
        if(isset($_POST['item']))
        {
            if(isset($_POST['deleted_item_ids']))
            {
                $sqllms  = $dblms->querylms("DELETE FROM ".SMS_DEMAND_ITEM_JUNCTION." WHERE id_demand = ".$demand_id." && id_item IN(".$_POST['deleted_item_ids'].")");
            }

            $items = cleanvars($_POST['item']);
            $demand_quantity = 0;
            foreach ($items as $index => $item_id) 
            {
                if(isset($item_id['u']))
                {
                    $data = [
                        'id_demand'                             => $demand_id
                        ,'id_item'                              => $item_id['u']
                        ,'quantity_requested'                   => cleanvars($_POST['quantity_requested'][$index]['u'])
                        ,'item_due_date'                        => cleanvars($_POST['item_due_date'][$index]['u'])        
                    ];
                    $conditions = "WHERE id_demand  = ".$demand_id." && id_item = ".$item_id['u'] ;
                    $query = $dblms->update(SMS_DEMAND_ITEM_JUNCTION , $data, $conditions);

                    $demand_quantity += cleanvars($_POST['quantity_requested'][$index]['u']);
                    $demand_due_date = cleanvars($_POST['item_due_date'][$index]['u']);
                }
                elseif (isset($item_id['n'])) 
                {
                    $data = [
                        'id_demand'                             => $demand_id
                        ,'id_item'                              => $item_id['n']
                        ,'quantity_requested'                   => cleanvars($_POST['quantity_requested'][$index]['n'])
                        ,'item_due_date'                        => cleanvars($_POST['item_due_date'][$index]['n'])        
                    ];
                    $queryInsert = $dblms->Insert(SMS_DEMAND_ITEM_JUNCTION , $data);

                    $demand_quantity += cleanvars($_POST['quantity_requested'][$index]['n']);
                    $demand_due_date = cleanvars($_POST['item_due_date'][$index]['n']);
                }   
            }
        }

        $data = [
            'demand_quantity'              => $demand_quantity
            ,'demand_due_date'             => $demand_due_date
        ];
        
        $conditions = "WHERE demand_id  = ".$demand_id."";
        $queryUpdate = $dblms->Update(SMS_DEMAND, $data, $conditions);

        // Logs

        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Update"
            ,'affected_table'                   => SMS_DEMAND
            ,'action_detail'                    =>  'demand_id: '.$demand_id.
                                                    PHP_EOL.'demand_type: '.cleanvars($_POST['demand_type']).
                                                    PHP_EOL.'demand_quantity: '.$demand_quantity.
                                                    PHP_EOL.'demand_due_date: '.$demand_due_date.
                                                    PHP_EOL.'demand_status: '.cleanvars($_POST['demand_status']).
                                                    PHP_EOL.'id_modify: '.cleanvars($_SESSION['userlogininfo']['LOGINIDA']).
                                                    PHP_EOL.'date_modify: '.date('Y-m-d H:i:s')
            ,'path'                             =>  end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS , $data);

        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Update"
            ,'affected_table'                   => SMS_DEMAND_ITEM_JUNCTION
            ,'action_detail'                    =>  'demand_id: '.$demand_id.
                                                    PHP_EOL. implode(',', array_map(function($item) { return implode(',', $item); }, cleanvars($_POST['item']))).
                                                    PHP_EOL. implode(',', array_map(function($item) { return implode(',', $item); }, cleanvars($_POST['quantity_requested']))).
                                                    PHP_EOL. implode(',', array_map(function($item) { return implode(',', $item); }, cleanvars($_POST['item_due_date']))).
                                                    PHP_EOL.'id_modify: '.cleanvars($_SESSION['userlogininfo']['LOGINIDA']).
                                                    PHP_EOL.'date_modify: '.date('Y-m-d H:i:s')
            ,'path'                             =>  end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS , $data);

        // $_SESSION['msg']['status'] = 'toastr.info("Updated Succesfully");';
        // header("Location: demand.php", true, 301);
        // exit();

    }

}