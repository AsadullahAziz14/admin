<?php

if(isset($_GET['deleteId']))
{
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_CATEGORIES." WHERE category_id = '".cleanvars($_GET['deleteId'])."'");

    if($sqllms)
    {
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Delete"
            ,'affected_table'                   => SMS_CATEGORIES
            ,'action_detail'                    =>  'category_id: '.cleanvars($_GET['deleteId'])
            ,'path'                             =>  end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS , $data);
        $_SESSION['msg']['status'] = 'toastr.info("Deleted Succesfully");';
        header("Location: categories.php");
        exit();
    }
}

if(isset($_POST['submit_category'])) 
{ 
    $data = [
        'category_name'                         => cleanvars($_POST['category_name'])
        ,'category_description'                 => cleanvars($_POST['category_description'])
        ,'category_status'                      => cleanvars($_POST['category_status'])
        ,'id_added'                             => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])           
        ,'date_added'                           => date('Y-m-d H:i:s')                
    ];
    $queryInsert = $dblms->Insert(SMS_CATEGORIES , $data);
    $latest_id = $dblms->lastestid();
    
    if($queryInsert) {

        $data = [
            'category_code' => 'CAT'.str_pad(cleanvars($latest_id), 5, '0', STR_PAD_LEFT)
        ];
        $conditions = "WHERE category_id  = ".cleanvars($latest_id)."";
        $queryUpdate = $dblms->Update(SMS_CATEGORIES,$data, $conditions);

        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Create"
            ,'affected_table'                   => SMS_CATEGORIES
            ,'action_detail'                    =>  'category_id: '.cleanvars($latest_id).
                                                    PHP_EOL.'category_code: '.'CAT'.str_pad(cleanvars($latest_id), 5, '0', STR_PAD_LEFT).
                                                    PHP_EOL.'category_name: '.cleanvars($_POST['category_name']).
                                                    PHP_EOL.'category_description: '.cleanvars($_POST['category_description']).
                                                    PHP_EOL.'category_status: '.cleanvars($_POST['category_status']).
                                                    PHP_EOL.'id_added: '.cleanvars($_SESSION['userlogininfo']['LOGINIDA']).
                                                    PHP_EOL.'date_added: '.date('Y-m-d H:i:s')
            ,'path'                             =>  end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS , $data);

        $_SESSION['msg']['status'] = 'toastr.success("Inserted Succesfully");';
        header("Location: categories.php", true, 301);
        exit(); 
    }
}

if(isset($_POST['edit_category'])) 
{ 
    $data = [
        'category_name'                         => cleanvars($_POST['category_name'])
        ,'category_description'                 => cleanvars($_POST['category_description'])
        ,'category_status'                      => cleanvars($_POST['category_status'])
        ,'id_modify'                            => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])           
        ,'date_modify'                          => date('Y-m-d H:i:s')                
    ];

    $conditions = "WHERE  category_id  = ".cleanvars($_GET['id'])."";
    $queryUpdate = $dblms->Update(SMS_CATEGORIES,$data, $conditions);

    if($queryUpdate) 
    {   
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Update"
            ,'affected_table'                   => SMS_CATEGORIES
            ,'action_detail'                    =>  'category_id: '.cleanvars($_GET['id']).
                                                    PHP_EOL.'category_name: '.cleanvars($_POST['category_name']).
                                                    PHP_EOL.'category_description: '.cleanvars($_POST['category_description']).
                                                    PHP_EOL.'category_status: '.cleanvars($_POST['category_status']).
                                                    PHP_EOL.'id_modify: '.cleanvars($_SESSION['userlogininfo']['LOGINIDA']).
                                                    PHP_EOL.'date_modify: '.date('Y-m-d H:i:s')
            ,'path'                             =>  end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS, $data);

        $_SESSION['msg']['status'] = 'toastr.info("Updated Succesfully");';
        header("Location: categories.php", true, 301);
        exit();
    }

}