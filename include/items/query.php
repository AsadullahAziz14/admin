<?php

if(isset($_GET['deleteId']))
{
    $sqllms  = $dblms->querylms("DELETE FROM ".SMS_ITEMS." WHERE item_id = '".cleanvars($_GET['deleteId'])."'");

    if($sqllms)
    {
        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Delete"
            ,'affected_table'                   => SMS_ITEMS
            ,'action_detail'                    =>  'item_id: '.cleanvars($_GET['deleteId'])
            ,'path'                             =>  end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS , $data);

        $_SESSION['msg']['status'] = 'toastr.info("Deleted Succesfully");';
        header("Location: items.php");
        exit();
    }
}


if(isset($_POST['submit_item']))
{ 
    $data = [
        'item_title'                        => cleanvars($_POST['item_title'])
        ,'item_description'                 => cleanvars($_POST['item_description'])
        ,'item_article_number'              => cleanvars($_POST['item_article_number'])
        ,'item_style_number'                => cleanvars($_POST['item_style_number'])
        ,'item_model_number'                => cleanvars($_POST['item_model_number'])
        ,'item_dimensions'                  => cleanvars($_POST['item_dimensions'])
        ,'item_uom'                         => cleanvars($_POST['item_uom'])
        ,'item_status'                      => cleanvars($_POST['item_status'])
        ,'id_category'                      => cleanvars($_POST['id_category'])
        ,'id_sub_category'                  => cleanvars($_POST['id_sub_category'])
        ,'id_added'                         => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ,'date_added'                       => date('Y-m-d H:i:s')          
    ];
    $queryInsert = $dblms->Insert(SMS_ITEMS , $data);

    if($queryInsert) 
    { 
        $item_id = $dblms->lastestid();
        
        if(!empty($_FILES['item_image']['name'])) 
        {
            $img = explode('.', $_FILES['item_image']['name']);
            $extension = strtolower(end($img));

            $img_dir		= "images/item_images/";
            $originalImage = $img_dir.cleanvars(to_seo_url(cleanvars($_POST['item_title']))).'_'.$item_id.'.'.$extension;
            $img_fileName = cleanvars(to_seo_url(cleanvars($_POST['item_title']))).'_'.$item_id.'.'.$extension;
            
            if(in_array($extension , array('jpg','jpeg', 'gif', 'png'))) 
            { 
                $data = [
                    'item_code' => 'ITEM'.str_pad(cleanvars($item_id), 5, '0', STR_PAD_LEFT)
                    ,'item_image' => $img_fileName
                ];
                
                $conditions = "WHERE item_id  = ".cleanvars($item_id)."";
                $queryUpdate = $dblms->Update(SMS_ITEMS, $data, $conditions);
                
                move_uploaded_file($_FILES['item_image']['tmp_name'],$originalImage);
            }   
        }

        $filePath = explode("/", $_SERVER["HTTP_REFERER"]);
        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Create"
            ,'affected_table'                   => SMS_CATEGORIES
            ,'action_detail'                    =>  'item_id: '.cleanvars($item_id).
                                                    PHP_EOL.'item_code: '.'ITEM'.str_pad(cleanvars($item_id), 5, '0', STR_PAD_LEFT).
                                                    PHP_EOL.'item_title: '.cleanvars($_POST['item_title']).
                                                    PHP_EOL.'item_description: '.cleanvars($_POST['item_description']).
                                                    PHP_EOL.'item_article_number: '.cleanvars($_POST['item_article_number']).
                                                    PHP_EOL.'item_style_number: '.cleanvars($_POST['item_style_number']).
                                                    PHP_EOL.'item_model_number: '.cleanvars($_POST['item_model_number']).
                                                    PHP_EOL.'item_dimensions: '.cleanvars($_POST['item_dimensions']).
                                                    PHP_EOL.'item_uom: '.cleanvars($_POST['item_uom']).
                                                    PHP_EOL.'item_image: '.$img_fileName.
                                                    PHP_EOL.'item_status: '.cleanvars($_POST['item_status']).
                                                    PHP_EOL.'id_category: '.cleanvars($_POST['id_category']).
                                                    PHP_EOL.'id_sub_category: '.cleanvars($_POST['id_sub_category']).
                                                    PHP_EOL.'id_added: '.cleanvars($_SESSION['userlogininfo']['LOGINIDA']).
                                                    PHP_EOL.'date_added: '.date('Y-m-d H:i:s')
            ,'path'                             =>  end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS , $data);
        
        $_SESSION['msg']['status'] = 'toastr.success("Inserted Succesfully");';
        header("Location: items.php", true, 301);
        exit();

	} 
}

if(isset($_POST['edit_item'])) 
{
    $item_id = cleanvars($_GET['id']); 
    $data = [
        'item_title'                        => cleanvars($_POST['item_title'])
        ,'item_description'                 => cleanvars($_POST['item_description'])
        ,'item_article_number'              => cleanvars($_POST['item_article_number'])
        ,'item_style_number'                => cleanvars($_POST['item_style_number'])
        ,'item_model_number'                => cleanvars($_POST['item_model_number'])
        ,'item_dimensions'                  => cleanvars($_POST['item_dimensions'])
        ,'item_uom'                         => cleanvars($_POST['item_uom'])
        ,'item_status'                      => cleanvars($_POST['item_status'])
        ,'id_category'                      => cleanvars($_POST['id_category'])
        ,'id_sub_category'                  => cleanvars($_POST['id_sub_category'])
        ,'id_modify'                        => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])           
        ,'date_modify'                      => date('Y-m-d H:i:s')                
    ];

    $conditions = "WHERE  item_id  = ".$item_id."";
    $queryUpdate = $dblms->Update(SMS_ITEMS,$data, $conditions);

    if($queryUpdate) 
    {
        if(!empty($_FILES['item_image']['name'])) 
        {
            $img = explode('.', $_FILES['item_image']['name']);
            $extension = strtolower(end($img));
    
            $img_dir	   = "images/item_images/";
            $originalImage = $img_dir.cleanvars(to_seo_url(cleanvars($_POST['item_title']))).'_'.$item_id.'.'.$extension;
            $img_fileName = cleanvars(to_seo_url(cleanvars($_POST['item_title']))).'_'.$item_id.'.'.$extension;
        
            if(in_array($extension , array('jpg','jpeg', 'gif', 'png'))) 
            {
                $data = [
                    'item_image' => $img_fileName
                ];
                
                $conditions = "WHERE item_id  = ".$item_id."";
                $queryUpdate = $dblms->Update(SMS_ITEMS, $data, $conditions);

                move_uploaded_file($_FILES['item_image']['tmp_name'],$originalImage);
            }                
        }

        $data = [
            'log_date'                          => date('Y-m-d H:i:s')
            ,'action'                           => "Update"
            ,'affected_table'                   => SMS_CATEGORIES
            ,'action_detail'                    =>  'item_id: '.cleanvars($item_id).
                                                    PHP_EOL.'item_title: '.cleanvars($_POST['item_title']).
                                                    PHP_EOL.'item_description: '.cleanvars($_POST['item_description']).
                                                    PHP_EOL.'item_article_number: '.cleanvars($_POST['item_article_number']).
                                                    PHP_EOL.'item_style_number: '.cleanvars($_POST['item_style_number']).
                                                    PHP_EOL.'item_model_number: '.cleanvars($_POST['item_model_number']).
                                                    PHP_EOL.'item_dimensions: '.cleanvars($_POST['item_dimensions']).
                                                    PHP_EOL.'item_uom: '.cleanvars($_POST['item_uom']).
                                                    PHP_EOL.'item_image: '.$img_fileName.
                                                    PHP_EOL.'item_status: '.cleanvars($_POST['item_status']).
                                                    PHP_EOL.'id_category: '.cleanvars($_POST['id_category']).
                                                    PHP_EOL.'id_sub_category: '.cleanvars($_POST['id_sub_category']).
                                                    PHP_EOL.'id_modify: '.cleanvars($_SESSION['userlogininfo']['LOGINIDA']).
                                                    PHP_EOL.'date_modify: '.date('Y-m-d H:i:s')
            ,'path'                             =>  end($filePath)
            ,'login_session_start_time'         => $_SESSION['login_time']
            ,'ip_address'                       => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']
            ,'id_user'                          => cleanvars($_SESSION['userlogininfo']['LOGINIDA'])
        ];
        $queryInsert = $dblms->Insert(SMS_LOGS , $data);

        $_SESSION['msg']['status'] = 'toastr.info("Updated Succesfully");';
        header("Location: items.php", true, 301);
        exit();

    }

}