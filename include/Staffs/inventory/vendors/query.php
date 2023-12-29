<?php

if(isset($_GET['deleteId']))
{
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_VENDORS." WHERE vendor_id = '".cleanvars($_GET['deleteId'])."'");

    if($sqllms)
    {
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Delete"
            ,'affected_table'                   => SMS_VENDORS
            ,'action_detail'                    =>  'vendor_id: '.cleanvars($_GET['deleteId'])
            ,'path'                             =>  end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS , $data);

        $_SESSION['msg']['status'] = 'toastr.info("Deleted Succesfully");';
        header("Location: inventory-vendors.php");
        exit();
    }
}

if(isset($_POST['submit_vendor'])) 
{ 
    $data = [
        'vendor_name'                           => cleanvars($_POST['vendor_name'])
        ,'vendor_address'                       => cleanvars($_POST['vendor_address'])
        ,'vendor_contact_name'                  => cleanvars($_POST['vendor_contact_name'])
        ,'vendor_contact_phone1'                => cleanvars($_POST['vendor_contact_phone1'])
        ,'vendor_contact_phone2'                => cleanvars($_POST['vendor_contact_phone2'])
        ,'vendor_contact_email'                 => cleanvars($_POST['vendor_contact_email'])
        ,'vendor_status'                        => cleanvars($_POST['vendor_status'])
        ,'id_added'                             => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ,'date_added'                           => date('Y-m-d H:i:s')     
    ];
    $queryInsert = $dblms->Insert(SMS_VENDORS , $data);
    $latest_id = $dblms->lastestid();
    
    if($queryInsert) 
    {
        $data = [
            'vendor_code' => 'VENDOR-'.str_pad(cleanvars($latest_id), 5, '0', STR_PAD_LEFT)
        ];
        $conditions = "WHERE vendor_id  = ".cleanvars($latest_id)."";
        $queryUpdate = $dblms->Update(SMS_VENDORS,$data, $conditions);

        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Create"
            ,'affected_table'                   => SMS_VENDORS
            ,'action_detail'                    =>  'vendor_id: '.cleanvars($latest_id).
                                                    PHP_EOL.'vendor_code: '.'VENDOR-'.str_pad(cleanvars($latest_id), 5, '0', STR_PAD_LEFT).
                                                    PHP_EOL.'vendor_name: '.cleanvars($_POST['vendor_name']).
                                                    PHP_EOL.'vendor_address: '.cleanvars($_POST['vendor_address']).
                                                    PHP_EOL.'vendor_contact_name: '.cleanvars($_POST['vendor_contact_name']).
                                                    PHP_EOL.'vendor_contact_phone1: '.cleanvars($_POST['vendor_contact_phone1']).
                                                    PHP_EOL.'vendor_contact_phone2: '.cleanvars($_POST['vendor_contact_phone2']).
                                                    PHP_EOL.'vendor_contact_email: '.cleanvars($_POST['vendor_contact_email']).
                                                    PHP_EOL.'vendor_status: '.cleanvars($_POST['vendor_status']).
                                                    PHP_EOL.'id_added: '.cleanvars($_SESSION['userlogininfo']['LOGINIDA']).
                                                    PHP_EOL.'date_added: '.date('Y-m-d H:i:s')
            ,'path'                             =>  end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS , $data);

        $_SESSION['msg']['status'] = 'toastr.success("Inserted Succesfully");';
        header("Location: inventory-vendors.php", true, 301);
        exit(); 
    }
}

if(isset($_POST['edit_vendor'])) { 
    
    $data = [
        'vendor_name'                           => cleanvars($_POST['vendor_name'])
        ,'vendor_address'                       => cleanvars($_POST['vendor_address'])
        ,'vendor_contact_name'                  => cleanvars($_POST['vendor_contact_name'])
        ,'vendor_contact_phone1'                => cleanvars($_POST['vendor_contact_phone1'])
        ,'vendor_contact_phone2'                => cleanvars($_POST['vendor_contact_phone2'])
        ,'vendor_contact_email'                 => cleanvars($_POST['vendor_contact_email'])
        ,'vendor_status'                        => cleanvars($_POST['vendor_status']) 
        ,'id_modify'                            => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ,'date_modify'                          => date('Y-m-d H:i:s')            
    ];

    $conditions = "WHERE  vendor_id  = ".cleanvars($_GET['id'])."";
    $queryUpdate = $dblms->Update(SMS_VENDORS,$data, $conditions);

    if($queryUpdate) 
    { 
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Create"
            ,'affected_table'                   => SMS_VENDORS
            ,'action_detail'                    =>  'vendor_id: '.cleanvars($_GET['id']).
                                                    PHP_EOL.'vendor_name: '.cleanvars($_POST['vendor_name']).
                                                    PHP_EOL.'vendor_address: '.cleanvars($_POST['vendor_address']).
                                                    PHP_EOL.'vendor_contact_name: '.cleanvars($_POST['vendor_contact_name']).
                                                    PHP_EOL.'vendor_contact_phone1: '.cleanvars($_POST['vendor_contact_phone1']).
                                                    PHP_EOL.'vendor_contact_phone2: '.cleanvars($_POST['vendor_contact_phone2']).
                                                    PHP_EOL.'vendor_contact_email: '.cleanvars($_POST['vendor_contact_email']).
                                                    PHP_EOL.'vendor_status: '.cleanvars($_POST['vendor_status']).
                                                    PHP_EOL.'id_modify: '.cleanvars($_SESSION['userlogininfo']['LOGINIDA']).
                                                    PHP_EOL.'date_modify: '.date('Y-m-d H:i:s')
            ,'path'                             =>  end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS , $data);

        $_SESSION['msg']['status'] = 'toastr.info("Updated Succesfully");';
        header("Location: inventory-vendors.php", true, 301);
        exit();

    }

}