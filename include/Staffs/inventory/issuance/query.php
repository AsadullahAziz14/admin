<?php

require 'vendor/autoload.php';
use \Milon\Barcode\DNS1D;

if(isset($_GET['deleteId']))
{
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_ISSUANCE_ITEM_JUNCTION." WHERE id_issuance = '".cleanvars($_GET['deleteId'])."'");
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_ITEM_ISSUANCE." WHERE issuance_id  = '".cleanvars($_GET['deleteId'])."'");

    if($sqllms)
    {
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Delete"
            ,'affected_table'                   => SMS_ISSUANCE_ITEM_JUNCTION.', '.SMS_ITEM_ISSUANCE
            ,'action_detail'                    => 'issuance_id: '.cleanvars($_GET['deleteId'])
            ,'path'                             => end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS , $data);

        $_SESSION['msg']['status'] = 'toastr.info("Deleted Succesfully");';
        header("Location: inventory-issuance.php");
        exit();
    }
}

if(isset($_POST['submit_issuance'])) 
{ 
    $data = [
        'issuance_date'                     => date('Y-m-d H:i:s')
        ,'issuance_to'                      => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ,'issuance_by'                      => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ,'issuance_remarks'                 => cleanvars($_POST['issuance_remarks'])
        ,'issuance_status'                  => cleanvars($_POST['issuance_status'])
        ,'id_added'                         => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])           
        ,'date_added'                       => date('Y-m-d H:i:s')                
    ];
    $queryInsert = $dblms->Insert(SMS_ITEM_ISSUANCE , $data);
    
    $id_issuance = $dblms->lastestid();

    if(isset($_POST['id_item']))
    {
        foreach (cleanvars($_POST['id_item']) as $item) 
        {
            $data = [
                'id_issuance'               => $id_issuance
                ,'id_requisition'           => '1' 
                ,'id_item'                  => $item
                ,'quantity_issued'          => '1'
            ];
            $queryInsert = $dblms->Insert(SMS_ISSUANCE_ITEM_JUNCTION , $data);

            $issuance_barcode_text = $id_issuance.cleanvars($_POST['issuance_code']).$item;

            $data = [
                        'issuance_barcode' => $issuance_barcode_text            
                    ];
            $conditions = "WHERE id_issuance  = ".$id_issuance." && id_item = ".$item." && id_requisition = 1";
            $queryUpdate = $dblms->Update(SMS_ISSUANCE_ITEM_JUNCTION,$data, $conditions);

            $d = new DNS1D();
            $d->setStorPath(__DIR__.'/cache/');
            // echo $d->getBarcodeHTML('9780691147727', 'EAN13');
        } 
    }
    
    if($queryInsert) 
    {
        $data = [
            'issuance_code' => 'ISSUE_NO_'.str_pad(cleanvars($id_issuance), 5, '0', STR_PAD_LEFT)
        ];
        
        $conditions = "WHERE issuance_id  = ".cleanvars($id_issuance)."";
        $queryUpdate = $dblms->Update(SMS_ITEM_ISSUANCE,$data, $conditions);

        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Create"
            ,'affected_table'                   => SMS_ITEM_ISSUANCE
            ,'action_detail'                    => 'issuance_id: '.cleanvars($id_issuance).
                                                   PHP_EOL.'issuance_code: '.'ISSUE_NO_'.str_pad(cleanvars($id_issuance), 5, '0', STR_PAD_LEFT).
                                                   PHP_EOL.'issuance_to: '. cleanvars($_SESSION['userlogininfo']['LOGINIDA']).
                                                   PHP_EOL.'issuance_by: '.cleanvars($_SESSION['userlogininfo']['LOGINIDA']).
                                                   PHP_EOL.'issuance_remarks: '.cleanvars($_POST['issuance_remarks']).
                                                   PHP_EOL.'issuance_status: '.cleanvars($_POST['issuance_status']).
                                                   PHP_EOL.'id_added: '.cleanvars($_SESSION['userlogininfo']['LOGINIDA']).
                                                   PHP_EOL.'date_added: '.date('Y-m-d H:i:s')
            ,'path'                             => end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS , $data);

        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Create"
            ,'affected_table'                   => SMS_ISSUANCE_ITEM_JUNCTION
            ,'action_detail'                    => 'id_issuance: '.cleanvars($id_issuance).
                                                    PHP_EOL.'id_requisition: 1'.
                                                    PHP_EOL.'quantity_issued: 1'.
                                                    PHP_EOL.'issuance_barcode: '.$issuance_barcode_text.
                                                    PHP_EOL.'items_issued: '.implode(',',cleanvars($_POST['id_item'])).
                                                    PHP_EOL.'id_added: '.cleanvars($_SESSION['userlogininfo']['LOGINIDA']).
                                                    PHP_EOL.'date_added: '.date('Y-m-d H:i:s')
            ,'path'                             => end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS , $data);

        $_SESSION['msg']['status'] = 'toastr.success("Inserted Succesfully");';
        header("Location: inventory-issuance.php", true, 301);
        exit(); 
    }
}

if(isset($_POST['edit_issuance'])) 
{
    $data = [
        'issuance_to'                      => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ,'issuance_by'                      => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ,'issuance_remarks'                 => cleanvars($_POST['issuance_remarks'])
        ,'issuance_status'                  => cleanvars($_POST['issuance_status'])
        ,'id_modify'                        => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ,'date_modify'                      => date('Y-m-d H:i:s')   
    ];
    $conditions = "WHERE  issuance_id  = ".cleanvars($_GET['id'])."";
    $queryUpdate = $dblms->Update(SMS_ITEM_ISSUANCE,$data, $conditions);

    if(isset($_POST['id_item']))
    {
        $data = [
            'id_item'                       => cleanvars($_POST['id_item'])
        ];
        $conditions = "WHERE  id_issuance  = ".cleanvars($_GET['id'])."";
        $queryUpdate = $dblms->Update(SMS_ISSUANCE_ITEM_JUNCTION,$data, $conditions);
    }

    if($queryUpdate) 
    {
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Update"
            ,'affected_table'                   => SMS_ITEM_ISSUANCE
            ,'action_detail'                    =>  'issuance_id: '.cleanvars($_GET['id']).
                                                    PHP_EOL.'issuance_code: '.cleanvars($_POST['issuance_code']).
                                                    PHP_EOL.'issuance_date: '.cleanvars($_POST['issuance_description']).
                                                    PHP_EOL.'issuance_status: '.cleanvars($_POST['issuance_status']).
                                                    PHP_EOL.'id_modify: '.cleanvars($_SESSION['userlogininfo']['LOGINIDA']).
                                                    PHP_EOL.'date_modify: '.date('Y-m-d H:i:s')
            ,'path'                             =>  end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);

        $_SESSION['msg']['status'] = 'toastr.info("Updated Succesfully");';
        header("Location: inventory-issuance.php", true, 301);
        exit();
    }
}