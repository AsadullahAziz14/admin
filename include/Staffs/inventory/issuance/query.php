<?php

require 'vendor/autoload.php';
use \Milon\Barcode\DNS1D;

if(isset($_GET['deleteId'])) {
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_ISSUANCE_REQUISITION_ITEM_JUNCTION." WHERE id_issuance = '".cleanvars($_GET['deleteId'])."'");
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_ISSUANCE." WHERE issuance_id  = '".cleanvars($_GET['deleteId'])."'");

    if($sqllms) {
        // -------------Logs------------------------
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                         => date('Y-m-d H:i:s')                                           ,
            'action'                           => "Delete"                                                      ,
            'affected_table'                   => SMS_ISSUANCE.', '.SMS_ISSUANCE_REQUISITION_ITEM_JUNCTION      ,
            'action_detail'                    => 'issuance_id: '.cleanvars($_GET['deleteId'])                  ,
            'path'                             => end($filePath)                                                ,
            'login_session_start_time'         => $_SESSION['login_time']                                       ,
            'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']   ,
            'id_user'                          => cleanvars($_SESSION['LOGINIDA_SSS'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);

        $_SESSION['msg']['status'] = '<div class="alert-box danger"><span>Success: </span>Record has been deleted successfully.</div>';
        header("Location: inventory-issuance.php");
        exit();
    }
}

if(isset($_POST['submit_issuance'])) { 
    $data = [
        'issuance_status'                  => cleanvars($_POST['issuance_status'])                  ,
        'issuance_date'                    => date('Y-m-d H:i:s')                                   ,
        'issuance_to'                      => cleanvars($_POST['issuance_to'])         	         	,
        'issuance_by'                      => cleanvars($_SESSION['LOGINIDA_SSS'])                  ,    
        'issuance_remarks'                 => cleanvars($_POST['issuance_remarks'])                 ,
        'id_added'                         => cleanvars($_SESSION['LOGINIDA_SSS'])                  ,
        'date_added'                       => date('Y-m-d H:i:s')                
    ];
    $queryInsert = $dblms->Insert(SMS_ISSUANCE, $data);
    
    if($queryInsert) {
        $issuance_id = $dblms->lastestid();
    
        $isuance_code = 'ISSUE'.str_pad(cleanvars($issuance_id), 5, '0', STR_PAD_LEFT);
        $data = [
            'issuance_code' => $isuance_code
        ];
        $conditions = "WHERE issuance_id  = ".$issuance_id."";
        $queryUpdate = $dblms->Update(SMS_ISSUANCE, $data, $conditions);

        if(isset($_POST['id_item'])) {
            $issued_items = [];
            
            foreach (cleanvars($_POST['id_item']) as $requisition_code => $id_itemArray) {
                $queryRequisition = $dblms->querylms("SELECT requisition_id, requisition_code
                                                        FROM ".SMS_REQUISITION."
                                                        Where requisition_code = '".$requisition_code."'
                                                    ");
                $valueRequisition = mysqli_fetch_array($queryRequisition);
                foreach ($id_itemArray as $id_item => $itemTitle) {
                    $data = [
                        'id_issuance'                   => $issuance_id                                                                 ,
                        'id_requisition'                => $valueRequisition['requisition_id']                                          ,
                        'id_item'                       => $id_item                                                                     ,
                        'quantity_issued'               => $_POST['quantity_issued'][$requisition_code][$id_item]                       ,
                        'issuance_barcode'              => $isuance_code.$valueRequisition['requisition_id'].$id_item
                    ];
                    $queryInsert = $dblms->Insert(SMS_ISSUANCE_REQUISITION_ITEM_JUNCTION, $data);
                    $issued_items[] = $id_item;
                }
                
                $d = new DNS1D();
                $d->setStorPath(__DIR__.'/cache/');
                // echo $d->getBarcodeHTML('9780691147727', 'EAN13');
            }
        }

        // -------------Logs------------------------
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Create"
            ,'affected_table'                   => SMS_ISSUANCE.', '.SMS_ISSUANCE_REQUISITION_ITEM_JUNCTION
            ,'action_detail'                    => 'issuance_id: '.$issuance_id.
                                                    PHP_EOL.'issuance_code: '.'ISSUE'.str_pad($issuance_id, 5, '0', STR_PAD_LEFT).
                                                    PHP_EOL.'issuance_to: '.cleanvars($_POST['issuance_to']).
                                                    PHP_EOL.'issuance_by: '.cleanvars($_SESSION['LOGINIDA_SSS']).
                                                    PHP_EOL.'issuance_remarks: '.cleanvars($_POST['issuance_remarks']).
                                                    PHP_EOL.'issued_items: '.implode(',',$issued_items).
                                                    PHP_EOL.'issuance_date: '.date('Y-m-d H:i:s').
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
    header("Location: inventory-issuance.php", true, 301);
    exit(); 
}

if(isset($_POST['update_issuance'])) {
    $issuance_id = cleanvars($_GET['id']);

    $data = [
        'issuance_status'                  => cleanvars($_POST['issuance_status'])                  ,
        'issuance_to'                      => cleanvars($_POST['issuance_to'])         	         	,   
        'issuance_remarks'                 => cleanvars($_POST['issuance_remarks'])                 ,
        'id_modify'                        => cleanvars($_SESSION['LOGINIDA_SSS'])                  ,
        'date_modify'                      => date('Y-m-d H:i:s')
    ];
    $conditions = "WHERE issuance_id = ".$issuance_id."";
    $queryUpdate = $dblms->Update(SMS_ISSUANCE, $data, $conditions);

    if(isset($_POST['deleted_item_ids']) && isset($_POST['deleted_requisition_ids']) && $_POST['deleted_requisition_ids'] != '' && $_POST['deleted_item_ids'] != '' ) {
        $deleteRequisition = explode(',',cleanvars($_POST['deleted_requisition_ids']));
        foreach ($deleteRequisition as $key => $requisitionId) {
            $queryDelete  = $dblms->querylms("DELETE FROM ".SMS_ISSUANCE_REQUISITION_ITEM_JUNCTION." WHERE id_issuance = ".$issuance_id." AND id_requisition IN ('".$requisitionId."') AND id_item IN ('".$_POST['deleted_item_ids'][$key]."')");
        }
    }

    if($queryUpdate) {
        if(isset($_POST['id_item'])) {
            if(isset($_POST['deleted_item_ids']) && isset($_POST['deleted_requisition_ids']) && $_POST['deleted_requisition_ids'] != '' && $_POST['deleted_item_ids'] != '' ) {
                $deleteReqisition = explode(',',cleanvars($_POST['deleted_requisition_ids']));
                foreach ($deleteReqisition as $key => $requisitionId) {
                    $queryDelete  = $dblms->querylms("DELETE FROM ".SMS_ISSUANCE_REQUISITION_ITEM_JUNCTION." WHERE id_issuance = ".$issuance_id." AND id_demand IN ('".$requisitionId."') AND id_item IN ('".$_POST['deleted_item_ids'][$key]."')");
                }
            }

            $items = cleanvars($_POST['id_item']);
            $issued_items = [];

            foreach (cleanvars($_POST['id_item']) as $key => $items_array) {
                if($key == "u") {
                    foreach ($items_array as $requisition_id => $id_itemArray) {
                        foreach ($id_itemArray as $id_item => $item_title) {
                            $data = [
                                'quantity_issued'      => $_POST['quantity_issued'][$requisition_id][$id_item]
                            ];
                            $conditions = "Where id_issuance = ".$issuance_id." AND id_requisition = ".$requisition_id." AND id_item = ".$id_item."";
                            $queryUpdate = $dblms->Update(SMS_ISSUANCE_REQUISITION_ITEM_JUNCTION, $data, $conditions);
                            $issued_items[] = $id_item;
                        }   
                    }

                } else {
                    $requisition_code = $key;
                    $queryRequisition = $dblms->querylms("SELECT requisition_id, requisition_code
                                        FROM ".SMS_REQUISITION."
                                        Where requisition_code = '".$requisition_code."'
                                    ");
                    $valueRequisition = mysqli_fetch_array($queryRequisition);
                    foreach ($items_array as $id_item => $itemTitle) {
                        $data = [
                            'id_issuance'               => $issuance_id                                             ,
                            'id_requisition'            => $valueRequisition['requisition_id']                      ,
                            'id_item'                   => $id_item                                                 ,
                            'quantity_issued'           => $_POST['quantity_issued'][$requisition_code][$id_item]   ,
                        ];
                        $queryInsert = $dblms->Insert(SMS_ISSUANCE_REQUISITION_ITEM_JUNCTION, $data);
                        $issued_items[] = $id_item;   
                    }
                } 
            }
            // -------------Logs------------------------
            $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
            $data = [
                'log_date'                         => date('Y-m-d H:i:s')
                ,'action'                           => "Update"
                ,'affected_table'                   => SMS_ISSUANCE.', '.SMS_ISSUANCE_REQUISITION_ITEM_JUNCTION
                ,'action_detail'                    => 'issuance_id: '.$issuance_id.
                                                        PHP_EOL.'issuance_to: '.cleanvars($_POST['issuance_to']).
                                                        PHP_EOL.'issuance_remarks: '.cleanvars($_POST['issuance_remarks']).
                                                        PHP_EOL.'issued_items: '.implode(',',$issued_items).
                                                        PHP_EOL.'id_modify: '.$_SESSION['LOGINIDA_SSS'].
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
    header("Location: inventory-issuance.php", true, 301);
    exit();
}
