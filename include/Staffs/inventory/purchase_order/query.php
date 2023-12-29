<?php

if(isset($_GET['deleteId']))
{
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_PO_DEMAND_ITEM_JUNCTION." WHERE id_po = '".cleanvars($_GET['deleteId'])."'");
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_PO." WHERE po_id  = '".cleanvars($_GET['deleteId'])."'");

    if($sqllms)
    {
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Delete"
            ,'affected_table'                   => SMS_PO_DEMAND_ITEM_JUNCTION.', '.SMS_PO
            ,'action_detail'                    => 'po_id: '.cleanvars($_GET['deleteId'])
            ,'path'                             =>  end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS , $data);

        $_SESSION['msg']['status'] = 'toastr.info("Deleted Succesfully");';
        header("Location: inventory-purchase_order.php");
        exit();
    }
}


if(isset($_POST['submit_po']))
{ 
    $po_quantity = 0;
    foreach ($_POST['quantity_ordered'] as $key => $qauntityOrderedArray) {
        $po_quantity += array_sum($qauntityOrderedArray);
    }
    
    $data = [
        'po_date'                           => date('Y-m-d H:i:s') 
        ,'po_delivery_date'                 => cleanvars($_POST['po_delivery_date'])
        ,'po_delivery_address'              => cleanvars($_POST['po_delivery_address'])
        ,'po_remarks'                       => cleanvars($_POST['po_remarks'])
        ,'po_tax_perc'                      => cleanvars($_POST['po_tax_perc'])
        ,'po_quantity'                      => $po_quantity
        ,'po_payment_terms'                 => cleanvars($_POST['po_payment_terms'])
        ,'po_credit_terms'                  => cleanvars($_POST['po_credit_terms'])
        ,'po_lead_time'                     => cleanvars($_POST['po_lead_time'])
        ,'po_status'                        => cleanvars($_POST['po_status'])
        ,'ordered_by'                       => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ,'date_ordered'                     => cleanvars($_POST['date_ordered'])
        ,'id_vendor'                        => cleanvars($_POST['id_vendor'])
        ,'id_added'                         => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ,'date_added'                       => date('Y-m-d H:i:s')
    ];
    $queryInsert = $dblms->Insert(SMS_PO, $data);

    if($queryInsert) 
    {
        $po_id = $dblms->lastestid();

        // Logs
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                      => date('Y-m-d H:i:s')
            ,'action'                       => "Create"
            ,'affected_table'               => SMS_PO
            ,'action_detail'                =>  'po_id: '.$po_id.
                                                PHP_EOL.'po_code: '.'PO'.str_pad($po_id, 5, '0', STR_PAD_LEFT).
                                                PHP_EOL.'po_date: '.date('Y-m-d H:i:s').
                                                PHP_EOL.'po_tax_perc: '.cleanvars($_POST['po_tax_perc']).
                                                PHP_EOL.'po_quantity: '.$po_quantity.
                                                PHP_EOL.'po_delivery_date: '.cleanvars($_POST['po_delivery_date']).
                                                PHP_EOL.'po_delivery_address: '.cleanvars($_POST['po_delivery_address']).
                                                PHP_EOL.'po_remarks: '.cleanvars($_POST['po_remarks']).
                                                PHP_EOL.'po_payment_terms: '.cleanvars($_POST['po_payment_terms']).
                                                PHP_EOL.'po_credit_terms: '.cleanvars($_POST['po_credit_terms']).
                                                PHP_EOL.'po_lead_time: '.cleanvars($_POST['po_lead_time']).
                                                PHP_EOL.'po_status: '.cleanvars($_POST['po_status']).
                                                PHP_EOL.'ordered_by: '.cleanvars($_SESSION['userlogininfo']['LOGINIDA']).
                                                PHP_EOL.'date_ordered: '.cleanvars($_POST['date_ordered']).
                                                PHP_EOL.'id_vendor: '.cleanvars($_POST['id_vendor']).
                                                PHP_EOL.'id_added: '.cleanvars($_SESSION['userlogininfo']['LOGINIDA']).
                                                PHP_EOL.'date_added: '.date('Y-m-d H:i:s')
            ,'path'                         =>  end($filePath)
            ,'login_session_start_time'     => $_SESSION['login_time']
            ,'ip_address'                   => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                      => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS , $data);


        $po_amount = 0;
        foreach (cleanvars($_POST['id_item']) as $id_demand => $id_itemArray) 
        {
            foreach ($id_itemArray as $id_item => $itemTitle) 
            {
                $data = [
                    'id_po'                 => $po_id
                    ,'id_demand'            => $id_demand
                    ,'id_item'              => $id_item
                    ,'quantity_ordered'     => $_POST['quantity_ordered'][$id_demand][$id_item]
                    ,'unit_price'           => $_POST['unit_price'][$id_demand][$id_item]
                ];
                $queryInsert = $dblms->Insert(SMS_PO_DEMAND_ITEM_JUNCTION , $data);
                $po_amount = $po_amount + ($_POST['quantity_ordered'][$id_demand][$id_item] * $_POST['unit_price'][$id_demand][$id_item]);

                $data = [
                    'is_ordered'                    => "1"
                ];
                $conditions = "Where id_demand = ".$id_demand." && id_item = ".$id_item."";
                $queryUpdate = $dblms->Update(SMS_DEMAND_ITEM_JUNCTION, $data, $conditions);
            }
        }
        
        $po_amount = $po_amount + ((cleanvars($_POST['po_tax_perc']) / 100) * $po_amount);
        
        $data = [
            'po_amount'                     => $po_amount
            ,'po_code'                       => 'PO'.str_pad($po_id, 5, '0', STR_PAD_LEFT)
        ];
        $conditions = "WHERE po_id  = ".$po_id."";
        $queryUpdate = $dblms->Update(SMS_PO, $data, $conditions);
        
        // $_SESSION['msg']['status'] = 'toastr.success("Inserted Succesfully");';
        // header("Location: inventory-purchase_order.php", true, 301);
        // exit();

	} 
}

if(isset($_POST['update_po'])) 
{
    $po_id = cleanvars($_GET['id']);
    $po_quantity = 0;
    foreach ($_POST['quantity_ordered'] as $key => $qauntityOrderedArray) {
        $po_quantity += array_sum($qauntityOrderedArray);
    }

    $data = [
        'po_delivery_date'                  => cleanvars($_POST['po_delivery_date'])
        ,'po_delivery_address'              => cleanvars($_POST['po_delivery_address'])
        ,'po_remarks'                       => cleanvars($_POST['po_remarks'])
        ,'po_tax_perc'                      => cleanvars($_POST['po_tax_perc'])
        ,'po_quantity'                      => $po_quantity
        ,'po_payment_terms'                 => cleanvars($_POST['po_payment_terms'])
        ,'po_credit_terms'                  => cleanvars($_POST['po_credit_terms'])
        ,'po_lead_time'                     => cleanvars($_POST['po_lead_time'])
        ,'po_status'                        => cleanvars($_POST['po_status'])
        ,'ordered_by'                       => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ,'date_ordered'                     => cleanvars($_POST['date_ordered'])
        ,'id_vendor'                        => cleanvars($_POST['id_vendor'])
        ,'id_modify'                        => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ,'date_modify'                      => date('Y-m-d H:i:s')
    ];
    $conditions = "WHERE  po_id  = ".$po_id."";
    $queryUpdate = $dblms->Update(SMS_PO, $data, $conditions);

    if($queryUpdate) 
    {
        foreach (cleanvars($_POST['id_item']) as $key => $id_itemArray)
        {
            if($key == "u")
            {
                foreach ($id_itemArray as $id_demand => $id_itemArray) 
                {
                    foreach ($id_itemArray as $id_item => $item_title) 
                    {
                        $data = [
                            'quantity_ordered'              => $_POST['quantity_ordered'][$id_demand][$id_item]
                            ,'unit_price'                   => $_POST['unit_price'][$id_demand][$id_item]
                        ];
                        $conditions = "Where id_po = ".$po_id." && id_demand = ".$id_demand." && id_item = ".$id_item."";
                        $queryUpdate = $dblms->Update(SMS_PO_DEMAND_ITEM_JUNCTION, $data, $conditions);

                        $data = [
                            'is_ordered'                    => "1"
                        ];
                        $conditions = "Where id_demand = ".$id_demand." && id_item = ".$id_item."";
                        $queryUpdate = $dblms->Update(SMS_DEMAND_ITEM_JUNCTION, $data, $conditions);
                    }   
                }
            }
            else
            {
                $id_demand = $key;
                foreach ($id_itemArray as $id_item => $itemTitle) 
                {
                    $data = [
                        'id_po'                             => $po_id
                        ,'id_demand'                        => $id_demand
                        ,'id_item'                          => $id_item
                        ,'quantity_ordered'                 => $_POST['quantity_ordered'][$id_demand][$id_item]
                        ,'unit_price'                       => $_POST['unit_price'][$id_demand][$id_item]
                    ];
                    $queryInsert = $dblms->Insert(SMS_PO_DEMAND_ITEM_JUNCTION , $data);   
                }
            } 
        }

        // $_SESSION['msg']['status'] = 'toastr.info("Updated Succesfully");';
        // header("Location: inventory-purchase_order.php", true, 301);
        // exit();
    }

}

if(isset($_POST["forward_po"]))
{
    $data = [
        'forwarded_to'   => $_POST['forwarded_to']
        ,'forwarded_by' => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ,'date_forwarded'    => date('Y-m-d H:i:s')
    ];
    $conditions = " Where po_id = ".$_POST['po_id']."";
    $queryUpdate = $dblms->Update(SMS_PO, $data, $conditions);

    $_SESSION['msg']['status'] = 'toastr.info("Updated Succesfully");';
    header("Location: inventory-purchase_order.php?view=forward_po", true, 301);
    exit();
}