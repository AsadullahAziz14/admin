<?php

require 'vendor/autoload.php';
use \Milon\Barcode\DNS1D;

if(isset($_GET['deleteId'])) {
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_ISSUANCE_REQUISITION_ITEM_JUNCTION." WHERE id_issuance = '".cleanvars($_GET['deleteId'])."'");
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_ISSUANCE." WHERE issuance_id  = '".cleanvars($_GET['deleteId'])."'");

    if($sqllms) {
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                         => date('Y-m-d H:i:s')                                           ,
            'action'                           => "Delete"                                                      ,
            'affected_table'                   => SMS_ISSUANCE_REQUISITION_ITEM_JUNCTION.', '.SMS_ISSUANCE            		,
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
    
    $id_issuance = $dblms->lastestid();
    
    $isuance_code = 'ISSUE_NO_'.str_pad(cleanvars($id_issuance), 5, '0', STR_PAD_LEFT);
    $data = [
        'issuance_code' => $isuance_code
    ];
    $conditions = "WHERE issuance_id  = ".cleanvars($id_issuance)."";
    $queryUpdate = $dblms->Update(SMS_ISSUANCE, $data, $conditions);

    if(isset($_POST['id_item'])) {
        foreach (cleanvars($_POST['id_item']) as $id_requisition => $id_itemArray) {
            foreach ($id_itemArray as $id_item => $itemTitle) {
                $data = [
                    'id_issuance'                   => $id_issuance                                      ,
                    'id_requisition'                => $id_requisition                                   ,
                    'id_item'                       => $id_item                                          ,
                    'quantity_issued'               => $_POST['quantity_issued'][$id_requisition][$id_item]  ,
                    'issuance_barcode'              => $isuance_code.$id_requisition.$id_item
                ];
                $queryInsert = $dblms->Insert(SMS_ISSUANCE_REQUISITION_ITEM_JUNCTION, $data);
            }
            
            $d = new DNS1D();
            $d->setStorPath(__DIR__.'/cache/');
            // echo $d->getBarcodeHTML('9780691147727', 'EAN13');
        }
    }
    
    if($queryInsert) {
        $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been added successfully.</div>';
        header("Location: inventory-issuance.php", true, 301);
        exit(); 
    }
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

    if($queryUpdate) {
        foreach (cleanvars($_POST['id_item']) as $key => $id_itemArray) {
            if($key == "u") {
                foreach ($id_itemArray as $id_requisition => $id_itemArray) {
                    foreach ($id_itemArray as $id_item => $item_title) {
                        $data = [
                            'quantity_issued'      => $_POST['quantity_issued'][$id_requisition][$id_item]
                        ];
                        $conditions = "Where id_issuance = ".$issuance_id." AND id_requisition = ".$id_requisition." AND id_item = ".$id_item."";
                        $queryUpdate = $dblms->Update(SMS_ISSUANCE_REQUISITION_ITEM_JUNCTION, $data, $conditions);
                    }   
                }
            } else {
                $id_requisition = $key;
                foreach ($id_itemArray as $id_item => $itemTitle) {
                    $data = [
                        'id_issuance'               => $issuance_id                                             ,
                        'id_requisition'            => $id_requisition                                          ,
                        'id_item'                   => $id_item                                                 ,
                        'quantity_issued'           => $_POST['quantity_issued'][$id_requisition][$id_item]     ,
                    ];
                    $queryInsert = $dblms->Insert(SMS_ISSUANCE_REQUISITION_ITEM_JUNCTION, $data);   
                }
            } 
        }

        $_SESSION['msg']['status'] = '<div class="alert-box info"><span>Success: </span>Record has been updated successfully.</div>';
        header("Location: inventory-issuance.php", true, 301);
        exit();
    }
}
