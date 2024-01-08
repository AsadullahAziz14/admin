<?php

require 'vendor/autoload.php';
use \Milon\Barcode\DNS1D;

if(isset($_GET['deleteId'])) {
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_ISSUANCE_ITEM_JUNCTION." WHERE id_issuance = '".cleanvars($_GET['deleteId'])."'");
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_ITEM_ISSUANCES." WHERE issuance_id  = '".cleanvars($_GET['deleteId'])."'");

    if($sqllms) {
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                         => date('Y-m-d H:i:s')                                           ,
            'action'                           => "Delete"                                                      ,
            'affected_table'                   => SMS_ISSUANCE_ITEM_JUNCTION.', '.SMS_ITEM_ISSUANCES            ,
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
        'issuance_date'                    => date('Y-m-d H:i:s')                                   ,
        'issuance_to'                      => cleanvars($_SESSION['LOGINIDA_SSS'])                  ,
        'issuance_by'                      => cleanvars($_SESSION['LOGINIDA_SSS'])                  ,    
        'issuance_remarks'                 => cleanvars($_POST['issuance_remarks'])                 ,
        'issuance_status'                  => cleanvars($_POST['issuance_status'])                  ,
        'id_added'                         => cleanvars($_SESSION['LOGINIDA_SSS'])                  ,
        'date_added'                       => date('Y-m-d H:i:s')                
    ];
    $queryInsert = $dblms->Insert(SMS_ITEM_ISSUANCES, $data);
    
    $id_issuance = $dblms->lastestid();
    $isuance_code = 'ISSUE_NO_'.str_pad(cleanvars($id_issuance), 5, '0', STR_PAD_LEFT);
    $data = [
        'issuance_code' => $isuance_code
    ];
    $conditions = "WHERE issuance_id  = ".cleanvars($id_issuance)."";
    $queryUpdate = $dblms->Update(SMS_ITEM_ISSUANCES, $data, $conditions);

    if(isset($_POST['id_item'])) {
        foreach (cleanvars($_POST['id_item']) as $id_demand => $id_itemArray) {
            foreach ($id_itemArray as $id_item => $itemTitle) {
                $data = [
                    'id_issuance'                   => $id_issuance                                      ,
                    'id_requisition'                => $id_demand                                        ,
                    'id_item'                       => $id_item                                          ,
                    'quantity_issued'               => $_POST['quantity_ordered'][$id_demand][$id_item]  ,
                    'issuance_barcode'              => $isuance_code.$id_demand.$id_item
                ];
                $queryInsert = $dblms->Insert(SMS_ISSUANCE_ITEM_JUNCTION, $data);
            }

            $d = new DNS1D();
            $d->setStorPath(__DIR__.'/cache/');
            // echo $d->getBarcodeHTML('9780691147727', 'EAN13');
        }
    }
    
    if($queryInsert) {
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Create"
            ,'affected_table'                   => SMS_ITEM_ISSUANCES
            ,'action_detail'                    => 'issuance_id: '.cleanvars($id_issuance).
                                                   PHP_EOL.'issuance_code: '.'ISSUE_NO_'.str_pad(cleanvars($id_issuance), 5, '0', STR_PAD_LEFT).
                                                   PHP_EOL.'issuance_to: '. cleanvars($_SESSION['LOGINIDA_SSS']).
                                                   PHP_EOL.'issuance_by: '.cleanvars($_SESSION['LOGINIDA_SSS']).
                                                   PHP_EOL.'issuance_remarks: '.cleanvars($_POST['issuance_remarks']).
                                                   PHP_EOL.'issuance_status: '.cleanvars($_POST['issuance_status']).
                                                   PHP_EOL.'id_added: '.cleanvars($_SESSION['LOGINIDA_SSS']).
                                                   PHP_EOL.'date_added: '.date('Y-m-d H:i:s')
            ,'path'                             => end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['LOGINIDA_SSS'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);

        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Create"
            ,'affected_table'                   => SMS_ISSUANCE_ITEM_JUNCTION
            ,'action_detail'                    => 'id_issuance: '.cleanvars($id_issuance).
                                                    PHP_EOL.'id_requisition: 1'.
                                                    PHP_EOL.'quantity_issued: 1'.
                                                    PHP_EOL.'items_issued: '.implode(',',cleanvars($_POST['id_item'])).
                                                    PHP_EOL.'id_added: '.cleanvars($_SESSION['LOGINIDA_SSS']).
                                                    PHP_EOL.'date_added: '.date('Y-m-d H:i:s')
            ,'path'                             => end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['LOGINIDA_SSS'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);

        // $_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Record has been added successfully.</div>';
        // header("Location: inventory-issuance.php", true, 301);
        // exit(); 
    }
}

if(isset($_POST['edit_issuance'])) {
    $data = [
        'issuance_to'                      => cleanvars($_SESSION['LOGINIDA_SSS'])     ,
        'issuance_by'                      => cleanvars($_SESSION['LOGINIDA_SSS'])     ,
        'issuance_remarks'                 => cleanvars($_POST['issuance_remarks'])                 ,
        'issuance_status'                  => cleanvars($_POST['issuance_status'])                  ,
        'id_modify'                        => cleanvars($_SESSION['LOGINIDA_SSS'])     ,
        'date_modify'                      => date('Y-m-d H:i:s')   
    ];
    $conditions = "WHERE  issuance_id  = ".cleanvars($_GET['id'])."";
    $queryUpdate = $dblms->Update(SMS_ITEM_ISSUANCES,$data, $conditions);

    if(isset($_POST['id_item'])) {
        $data = [
            'id_item'                       => cleanvars($_POST['id_item'])
        ];
        $conditions = "WHERE  id_issuance  = ".cleanvars($_GET['id'])."";
        $queryUpdate = $dblms->Update(SMS_ISSUANCE_ITEM_JUNCTION,$data, $conditions);
    }

    if($queryUpdate) {
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Update"
            ,'affected_table'                   => SMS_ITEM_ISSUANCES
            ,'action_detail'                    =>  'issuance_id: '.cleanvars($_GET['id']).
                                                    PHP_EOL.'issuance_code: '.cleanvars($_POST['issuance_code']).
                                                    PHP_EOL.'issuance_date: '.cleanvars($_POST['issuance_description']).
                                                    PHP_EOL.'issuance_status: '.cleanvars($_POST['issuance_status']).
                                                    PHP_EOL.'id_modify: '.cleanvars($_SESSION['LOGINIDA_SSS']).
                                                    PHP_EOL.'date_modify: '.date('Y-m-d H:i:s')
            ,'path'                             =>  end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['LOGINIDA_SSS'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);

        $_SESSION['msg']['status'] = '<div class="alert-box info"><span>Success: </span>Record has been updated successfully.</div>';
        header("Location: inventory-issuance.php", true, 301);
        exit();
    }
}