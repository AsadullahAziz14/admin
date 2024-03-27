<?php 
//Forward Application
if(isset($_POST['forward_application'])) { 
	
	$data = array(
		'id_application'	=> cleanvars($_POST['id_edit'])		            		, 
		'remarks'			=> cleanvars($_POST['remarks_edit'])		            , 
		'forwaded_to'		=> cleanvars(implode(",",$_POST['cclist']))		        , 
		'sess_id'			=> session_id()		           							, 
		'device_details'	=> $devicedetails		    							, 
		'ip'				=> $ip		            								, 
		'id_added'	    	=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])	, 
		'date_added'		=> date("Y-m-d H:i:s")		            				, 
	);

	$queryInsert = $dblms->Insert(DSA_APPLICATIONS_FORWARD, $data);
	
	if($queryInsert) { 

		foreach(cleanvars($_POST['cclist']) as $valueAdmin){

			$queryCheck = $dblms->querylms("SELECT id, view 
												FROM ".ADMIN_ROLES." 
												WHERE right_name = '190'
												AND id_adm = '".cleanvars($valueAdmin)."'");
			if(mysqli_num_rows($queryCheck) == 0){

				$dataRole = array(
					'right_name'	=> '190'		    , 
					'added'			=> '0'		        , 
					'updated'		=> '0'		        , 
					'deleted'		=> '0'		        , 
					'reporting'		=> '0'		        , 
					'reporting'		=> '0'		        , 
					'view'			=> '1'		        , 
					'right_type'	=> '7'		        , 
					'id_adm'		=> $valueAdmin		, 
				);
				$queryInsertRole = $dblms->Insert(ADMIN_ROLES, $dataRole);

			} else {

				$valueCheck = mysqli_fetch_array($queryCheck);

				$dataRole = array(
					'view'		    => '1'				,         					
				);
				$queryUpdateRole = $dblms->Update(ADMIN_ROLES, $dataRole, "WHERE id = '".$valueCheck['id']."'");
				
			}
		}
		
		//Latest PK of Table
		$latestID = $dblms->lastestid();

		//Check File is not empty
		if(!empty($_FILES['attachment']['name'])) { 

			//File Extension
			$path_parts 	= pathinfo($_FILES["attachment"]["name"]);
			$extension 		= strtolower($path_parts['extension']);

			//Check File extension
			if(in_array($extension , array('jpg','jpeg', 'png', 'pdf'))) {

				//File Path
				$directoryName 	= 'downloads/dsa/attachment/'.date('Y-m');

				//Create Directory if not exist
				if(!is_dir($directoryName)){
					mkdir($directoryName, 0777);
				}

				//Set File Name
				$img_dir		= $directoryName."/";
				$originalImage	= $directoryName."/".to_seo_url(strtolower(cleanvars($_POST['reference_no']))).'_'.$latestID.".".($extension);
				$imgFileName	= date('Y-m').'/'.to_seo_url(strtolower(cleanvars($_POST['reference_no']))).'_'.$latestID.".".($extension);

				//Update File Name in DB
				$sqllmsUpload  = $dblms->querylms("UPDATE ".DSA_APPLICATIONS_FORWARD."
															SET attachment = '".$imgFileName."'
															WHERE  id = '".$latestID."'");

				//Move File to the Directory
				$mode = '0644';
				move_uploaded_file($_FILES['attachment']['tmp_name'],$originalImage);
				chmod ($originalImage, octdec($mode));

			}

		}

		if($_SESSION['userlogininfo']['LOGINTYPE'] == 8 || $_SESSION['userlogininfo']['LOGINTYPE'] == 9) {

			$dataUpdate = array(
				'comprehensive_exam'		    => cleanvars($_POST['comprehensive_exam'])			, 
				'comprehensive_year'		    => cleanvars($_POST['comprehensive_year'])		    ,
				'comprehensive_passed'		    => cleanvars($_POST['comprehensive_passed'])		,
				'gat_test'		    			=> cleanvars($_POST['gat_test'])		        	,
				'gat_year'						=> cleanvars($_POST['gat_year'])		       		,
				'gat_passed'		    		=> cleanvars($_POST['gat_passed'])		        	,
				'coursework_thesis' 			=> cleanvars($_POST['coursework_thesis'])			,
				'thesis_submission_date'		=> cleanvars($_POST['thesis_submission_date'])		,
				'thesis_submission_date_islrc'	=> cleanvars($_POST['thesis_submission_date_islrc']),
				'thesis_title'		    		=> cleanvars($_POST['thesis_title'])            					
			);
			$queryUpdate = $dblms->Update(DSA_APPLICATIONS, $dataUpdate, "WHERE id = '".cleanvars($_POST['id_edit'])."'");

		}

		if(isset($_POST['redirect_url']) && cleanvars($_POST['redirect_url']) != ''){
			$redirectURL = cleanvars($_POST['redirect_url']);
		} else {
			$redirectURL = 'dsadegreetranscript.php';
		}

		//Set Success MSG in Session & Exit
		$_SESSION['msg']['status']  = '<div class="alert-box notice"><span>Success: </span>Application has been forwaded successfully.</div>';
		//header("Location: dsadegreetranscript.php", true, 301);
		header("Location: $redirectURL", true, 301);
		exit();

	}
}

//Update Details
if(isset($_POST['save_changes'])) { 

	$currentlyAt 		= 0;
	$issuanceDate 		= '0000-00-00';
	$documentNumber 	= '';
	$recepient 			= 0;
	$recepientName 		= '';
	$recepientRelation 	= '';
	$recepientCNIC 		= '';
	$deliveryDate 		= '0000-00-00';

	if(isset($_POST['currectly_at']) && cleanvars($_POST['currectly_at']) != ''){
		$currentlyAt = cleanvars($_POST['currectly_at']);
	}
	if(isset($_POST['issuance_date']) && cleanvars($_POST['issuance_date']) != ''){
		
		$issuanceDate = cleanvars($_POST['issuance_date']);
		$data = array(
			'issuance_date'		    		=> $issuanceDate		        							,		
		);
		$sqllmsUpdate = $dblms->Update(DSA_APPLICATIONS, $data, "WHERE id = '".cleanvars($_GET['id'])."'");
	}
	if(isset($_POST['document_number']) && cleanvars($_POST['document_number']) != ''){
		
		$documentNumber = cleanvars($_POST['document_number']);
		$data = array(
			'document_number'		    	=> $documentNumber		        							,	
		);
		$sqllmsUpdate = $dblms->Update(DSA_APPLICATIONS, $data, "WHERE id = '".cleanvars($_GET['id'])."'");
	}
	if(isset($_POST['recipient']) && cleanvars($_POST['recipient']) != ''){
		$recepient = cleanvars($_POST['recipient']);
	}
	if(isset($_POST['recipient_full_name']) && cleanvars($_POST['recipient_full_name']) != ''){
		$recepientName = cleanvars($_POST['recipient_full_name']);
	}
	if(isset($_POST['recipient_relationship']) && cleanvars($_POST['recipient_relationship']) != ''){
		$recepientRelation = cleanvars($_POST['recipient_relationship']);
	}
	if(isset($_POST['recipient_cnic']) && cleanvars($_POST['recipient_cnic']) != ''){
		$recepientCNIC = cleanvars($_POST['recipient_cnic']);
	}
	if(isset($_POST['delivered_date']) && cleanvars($_POST['delivered_date']) != ''){
		$deliveryDate = cleanvars($_POST['delivered_date']);
	}


	// Check if a field have new value
	$sqllmsApplications = $dblms->querylms("SELECT *
											FROM ".DSA_APPLICATIONS." sa 
											WHERE sa.id = '".cleanvars($_GET['id'])."' 
										");

	$valuesqllmsApplications = mysqli_fetch_assoc($sqllmsApplications);

	$requestedvars = "\n";
	$requestedvars .= '"ID:"' . '=>' . '"' . cleanvars($_GET['id']) . '",'.PHP_EOL;

	if($valuesqllmsApplications['status'] != cleanvars($_POST['status'])) {
	$requestedvars .= '"Status"' . '=>' . '"' . cleanvars($_POST['status']) . '",'.PHP_EOL;
	}
	if($valuesqllmsApplications['full_name'] != cleanvars($_POST['stdname_edit'])) {
	$requestedvars .= '"full_name"' . '=>' . '"' . cleanvars($_POST['stdname_edit']) . '",'.PHP_EOL;
	}
	if($valuesqllmsApplications['mobile'] != cleanvars($_POST['mobile_edit'])) {
	$requestedvars .= '"mobile"' . '=>' . '"' . cleanvars($_POST['mobile_edit']) . '",'.PHP_EOL;
	}
	if($valuesqllmsApplications['email'] != cleanvars($_POST['email_edit'])) {
	$requestedvars .= '"email"' . '=>' . '"' . cleanvars($_POST['email_edit']) . '",'.PHP_EOL;
	}
	if($valuesqllmsApplications['postal_address'] != cleanvars($_POST['postal_address_edit'])) {
	$requestedvars .= '"postal_address"' . '=>' . '"' . cleanvars($_POST['postal_address_edit']) . '",'.PHP_EOL;
	}
	if($valuesqllmsApplications['hod_verified'] != cleanvars($_POST['hod_verified'])) {
	$requestedvars .= '"hod_verified"' . '=>' . '"' . cleanvars($_POST['hod_verified']) . '",'.PHP_EOL;
	}
	if($valuesqllmsApplications['accounts_verified'] != cleanvars($_POST['accounts_verified'])) {
	$requestedvars .= '"accounts_verified"' . '=>' . '"' . cleanvars($_POST['accounts_verified']) . '",'.PHP_EOL;
	}
	if($valuesqllmsApplications['remarks_dsa'] != cleanvars($_POST['remarks_dsa'])) {
	$requestedvars .= '"remarks_dsa"' . '=>' . '"' . cleanvars($_POST['remarks_dsa']) . '",'.PHP_EOL;
	}
	$requestedvars .= '"Modefied By"' . '=>' . '"' . cleanvars($_SESSION['userlogininfo']['LOGINIDA']) . '",'.PHP_EOL;
	$requestedvars .= '"Date Modefied"' . '=>' . '"' . date("Y-m-d H:i:s") . '",'.PHP_EOL;
	$requestedvars .= ")\n";


	$data = array(
		'status'		        		=> cleanvars($_POST['status'])								, 
		'full_name'		        		=> cleanvars($_POST['stdname_edit'])						, 
		'mobile'		        		=> cleanvars($_POST['mobile_edit'])							, 
		'email'		        			=> cleanvars($_POST['email_edit'])							, 
		'postal_address'		        => cleanvars($_POST['postal_address_edit'])					, 
		'hod_verified'		    		=> cleanvars($_POST['hod_verified'])		        		  ,
		'accounts_verified'		    	=> cleanvars($_POST['accounts_verified'])		        	  ,
		'currently_at'		    	 	=> $currentlyAt		        	 							,
		'remarks_dsa'		    		=> cleanvars($_POST['remarks_dsa'])		        			,
		'recipient'		    			=> $recepient		        								,
		'recipient_full_name'		   	=> $recepientName		        							,
		'recipient_relationship'		=> $recepientRelation		        						,
		'recipient_cnic'		    	=> $recepientCNIC		        							,
		'delivery_date'		    		=> $deliveryDate		        							,
		'id_modify'	        			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])		, 
		'date_modify'		        	=> date("Y-m-d H:i:s")		            					
	);

	$sqllmsUpdate = $dblms->Update(DSA_APPLICATIONS, $data, "WHERE id = '".cleanvars($_GET['id'])."'");
	
	if($sqllmsUpdate) { 

		//Check File is not empty
		if(!empty($_FILES['picture']['name'])) { 

			//File Extension
			$path_parts 	= pathinfo($_FILES["picture"]["name"]);
			$extension 		= strtolower($path_parts['extension']);

			//Check File extension
			if(in_array($extension , array('jpg','jpeg', 'png'))) {

				//File Path
				$directoryName 	= 'downloads/dsa/pictures/'.date('Y-m');

				//Create Directory if not exist
				if(!is_dir($directoryName)){
					mkdir($directoryName, 0777);
				}

				//Set File Name
				$img_dir		= $directoryName."/";
				$originalImage	= $directoryName."/".to_seo_url(cleanvars($_POST['stdname_edit'])).'_'.cleanvars($_GET['id']).".".($extension);
				$imgFileName	= date('Y-m').'/'.to_seo_url(cleanvars($_POST['stdname_edit'])).'_'.cleanvars($_GET['id']).".".($extension);

				//Update File Name in DB
				$sqllmsUpload  = $dblms->querylms("UPDATE ".DSA_APPLICATIONS."
															SET photo = '".$imgFileName."'
															WHERE  id = '".cleanvars($_GET['id'])."'");

				//Move File to the Directory
				$mode = '0644';
				move_uploaded_file($_FILES['picture']['tmp_name'],$originalImage);
				chmod ($originalImage, octdec($mode));

			}

		}

		//Check File is not empty
		if(!empty($_FILES['cnic_picture']['name'])) { 

			//File Extension
			$path_parts 	= pathinfo($_FILES["cnic_picture"]["name"]);
			$extension 		= strtolower($path_parts['extension']);

			//Check File extension
			if(in_array($extension , array('jpg','jpeg', 'png', 'pdf'))) {

				//File Path
				$directoryName 	= 'downloads/dsa/documents/'.date('Y-m');

				//Create Directory if not exist
				if(!is_dir($directoryName)){
					mkdir($directoryName, 0777);
				}

				//Set File Name
				$img_dir		= $directoryName."/";
				$originalImage	= $directoryName."/".to_seo_url(cleanvars($_POST['stdname_edit'])).'-cnic_'.cleanvars($_GET['id']).".".($extension);
				$imgFileName	= date('Y-m').'/'.to_seo_url(cleanvars($_POST['stdname_edit'])).'-cnic_'.cleanvars($_GET['id']).".".($extension);

				//Update File Name in DB
				$sqllmsUpload  = $dblms->querylms("UPDATE ".DSA_APPLICATIONS."
															SET cnic_photo = '".$imgFileName."'
															WHERE  id = '".cleanvars($_GET['id'])."'");

				//Move File to the Directory
				$mode = '0644';
				move_uploaded_file($_FILES['cnic_picture']['tmp_name'],$originalImage);
				chmod ($originalImage, octdec($mode));

			}

		}

		//Check File is not empty
		if(!empty($_FILES['matric_result_card']['name'])) { 

			//File Extension
			$path_parts 	= pathinfo($_FILES["matric_result_card"]["name"]);
			$extension 		= strtolower($path_parts['extension']);

			//Check File extension
			if(in_array($extension , array('jpg','jpeg', 'png', 'pdf'))) {

				//File Path
				$directoryName 	= 'downloads/dsa/documents/'.date('Y-m');

				//Create Directory if not exist
				if(!is_dir($directoryName)){
					mkdir($directoryName, 0777);
				}

				//Set File Name
				$img_dir		= $directoryName."/";
				$originalImage	= $directoryName."/".to_seo_url(cleanvars($_POST['stdname_edit'])).'-matric_'.cleanvars($_GET['id']).".".($extension);
				$imgFileName	= date('Y-m').'/'.to_seo_url(cleanvars($_POST['stdname_edit'])).'-matric_'.cleanvars($_GET['id']).".".($extension);

				//Update File Name in DB
				$sqllmsUpload  = $dblms->querylms("UPDATE ".DSA_APPLICATIONS."
															SET matric_result_card = '".$imgFileName."'
															WHERE  id = '".cleanvars($_GET['id'])."'");

				//Move File to the Directory
				$mode = '0644';
				move_uploaded_file($_FILES['matric_result_card']['tmp_name'],$originalImage);
				chmod ($originalImage, octdec($mode));

			}

		}

		//Check File is not empty
		if(!empty($_FILES['transcript_picture']['name'])) { 

			//File Extension
			$path_parts 	= pathinfo($_FILES["transcript_picture"]["name"]);
			$extension 		= strtolower($path_parts['extension']);

			//Check File extension
			if(in_array($extension , array('jpg','jpeg', 'png', 'pdf'))) {

				//File Path
				$directoryName 	= 'downloads/dsa/documents/'.date('Y-m');

				//Create Directory if not exist
				if(!is_dir($directoryName)){
					mkdir($directoryName, 0777);
				}

				//Set File Name
				$img_dir		= $directoryName."/";
				$originalImage	= $directoryName."/".to_seo_url(cleanvars($_POST['stdname_edit'])).'-transcript_'.cleanvars($_GET['id']).".".($extension);
				$imgFileName	= date('Y-m').'/'.to_seo_url(cleanvars($_POST['stdname_edit'])).'-transcript_'.cleanvars($_GET['id']).".".($extension);

				//Update File Name in DB
				$sqllmsUpload  = $dblms->querylms("UPDATE ".DSA_APPLICATIONS."
															SET transcript = '".$imgFileName."'
															WHERE  id = '".cleanvars($_GET['id'])."'");

				//Move File to the Directory
				$mode = '0644';
				move_uploaded_file($_FILES['transcript_picture']['tmp_name'],$originalImage);
				chmod ($originalImage, octdec($mode));

			}
		}

		//Check Thesis File is not empty
		if(!empty($_FILES['thesis_title_image']['name'])) { 

			//File Extension
			$path_parts 	= pathinfo($_FILES["thesis_title_image"]["name"]);
			$extension 		= strtolower($path_parts['extension']);

			//Check File extension
			if(in_array($extension , array('jpg','jpeg', 'png', 'pdf'))) {

				//File Path
				$directoryName 	= 'downloads/dsa/documents/'.date('Y-m');

				//Create Directory if not exist
				if(!is_dir($directoryName)){
					mkdir($directoryName, 0777);
				}

				//Set File Name
				$img_dir		= $directoryName."/";
				$originalImage	= $directoryName."/".to_seo_url(cleanvars($_POST['stdname_edit'])).'-thesis_'.cleanvars($_GET['id']).".".($extension);
				$imgFileName	= date('Y-m').'/'.to_seo_url(cleanvars($_POST['stdname_edit'])).'-thesis_'.cleanvars($_GET['id']).".".($extension);

				//Update File Name in DB
				$sqllmsUpload  = $dblms->querylms("UPDATE ".DSA_APPLICATIONS."
															SET thesis_title_photo = '".$imgFileName."'
															WHERE  id = '".cleanvars($_GET['id'])."'");

				//Move File to the Directory
				$mode = '0644';
				move_uploaded_file($_FILES['thesis_title_image']['tmp_name'],$originalImage);
				chmod ($originalImage, octdec($mode));

			}
		}

		//Check GAT Test File is not empty
		if(!empty($_FILES['gat_test_photo']['name'])) { 

			//File Extension
			$path_parts 	= pathinfo($_FILES["gat_test_photo"]["name"]);
			$extension 		= strtolower($path_parts['extension']);

			//Check File extension
			if(in_array($extension , array('jpg','jpeg', 'png', 'pdf'))) {

				//File Path
				$directoryName 	= 'downloads/dsa/documents/'.date('Y-m');

				//Create Directory if not exist
				if(!is_dir($directoryName)){
					mkdir($directoryName, 0777);
				}

				//Set File Name
				$img_dir		= $directoryName."/";
				$originalImage	= $directoryName."/".to_seo_url(cleanvars($_POST['stdname_edit'])).'-gat_'.cleanvars($_GET['id']).".".($extension);
				$imgFileName	= date('Y-m').'/'.to_seo_url(cleanvars($_POST['stdname_edit'])).'-gat_'.cleanvars($_GET['id']).".".($extension);

				//Update File Name in DB
				$sqllmsUpload  = $dblms->querylms("UPDATE ".DSA_APPLICATIONS."
															SET gat_test_proof = '".$imgFileName."'
															WHERE  id = '".cleanvars($_GET['id'])."'");

				//Move File to the Directory
				$mode = '0644';
				move_uploaded_file($_FILES['gat_test_photo']['tmp_name'],$originalImage);
				chmod ($originalImage, octdec($mode));

			}
		}

		//Check File is not empty
		if(!empty($_FILES['fir_picture']['name'])) { 

			//File Extension
			$path_parts 	= pathinfo($_FILES["fir_picture"]["name"]);
			$extension 		= strtolower($path_parts['extension']);

			//Check File extension
			if(in_array($extension , array('jpg','jpeg', 'png', 'pdf'))) {

				//File Path
				$directoryName 	= 'downloads/dsa/documents/'.date('Y-m');

				//Create Directory if not exist
				if(!is_dir($directoryName)){
					mkdir($directoryName, 0777);
				}

				//Set File Name
				$img_dir		= $directoryName."/";
				$originalImage	= $directoryName."/".to_seo_url(cleanvars($_POST['stdname_edit'])).'-fir_'.cleanvars($_GET['id']).".".($extension);
				$imgFileName	= date('Y-m').'/'.to_seo_url(cleanvars($_POST['stdname_edit'])).'-fir_'.cleanvars($_GET['id']).".".($extension);

				//Update File Name in DB
				$sqllmsUpload  = $dblms->querylms("UPDATE ".DSA_APPLICATIONS."
															SET fir_photo = '".$imgFileName."'
															WHERE  id = '".cleanvars($_GET['id'])."'");

				//Move File to the Directory
				$mode = '0644';
				move_uploaded_file($_FILES['fir_picture']['tmp_name'],$originalImage);
				chmod ($originalImage, octdec($mode));

			}

		}

		// 'item_id: '.cleanvars($idItem).
		// 	PHP_EOL.'item_code: '.'ITEM'.str_pad(cleanvars($idItem), 5, '0', STR_PAD_LEFT).
		// 	PHP_EOL.'item_title: '.cleanvars($_POST['item_title']).
		// 	PHP_EOL.'item_description: '.cleanvars($_POST['item_description']).
		// 	PHP_EOL.'item_article_number: '.cleanvars($_POST['item_article_number']).
		// 	PHP_EOL.'item_style_number: '.cleanvars($_POST['item_style_number']).
		// 	PHP_EOL.'item_model_number: '.cleanvars($_POST['item_model_number']).
		// 	PHP_EOL.'item_dimensions: '.cleanvars($_POST['item_dimensions']).
		// 	PHP_EOL.'item_uom: '.cleanvars($_POST['item_uom']).
		// 	PHP_EOL.'item_image: '.$img_fileName.
		// 	PHP_EOL.'item_status: '.cleanvars($_POST['item_status']).
		// 	PHP_EOL.'id_category: '.cleanvars($_POST['id_category']).
		// 	PHP_EOL.'id_sub_category: '.cleanvars($_POST['id_sub_category']).
		// 	PHP_EOL.'id_added: '.cleanvars($_SESSION['LOGINIDA_SSS']).
		// 	PHP_EOL.'date_added: '.date('Y-m-d H:i:s')

		$dataLog = array(
			'id_application'	=> cleanvars($_GET['id'])		            			,
			'remarks'			=> 'Update'												,
			'details'			=> cleanvars($requestedvars)							, 
			'sess_id'			=> session_id()		           							, 
			'ip'				=> $ip		            								, 
			'id_added'	    	=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])	, 
			'date_added'		=> date("Y-m-d H:i:s")		            				, 
		);
		$sqllmsInsert  = $dblms->Insert(DSA_APPLICATIONS_LOG, $dataLog);


		if($_POST['status'] == 3){

			require('PHPMailer/PHPMailerAutoload.php');

			if(filter_var($_POST['email_edit'], FILTER_VALIDATE_EMAIL)) {

				//$_POST['email_edit'] = 'ibrar.hussain@mul.edu.pk';
		
				//Create a new PHPMailer instance
				$mail = new PHPMailer;
				//Set who the message is to be sent from
				$mail->setFrom('noreply@mul.edu.pk', 'Directorate of Students Affairs (DSA) - Minhaj University Lahore');
	
				//Set an alternative reply-to address
				$mail->addAddress($_POST['email_edit'], $_POST['stdname_edit']);
	
				//$mail->addBCC("ibrar.hussain@mul.edu.pk");

				//Set the subject line
				$mail->Subject = '[Important] '.get_dsa_degree_transcript($_POST['app_degree_transcript']).' application objection -  Minhaj University Lahore';
				$mail->isHTML(true);
				//Read an HTML message body from an external file, convert referenced images to embedded,
				$htmlcontents = '
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta name="x-apple-disable-message-reformatting"/>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
				<meta name="viewport" content="width=device-width, initial-scale=1.0 "/>
				<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
				<title>Announcement</title>
				<style type="text/css">
					@import url("https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i");
				body {
				margin: 0 !important;
				padding: 0 !important;
				width: 100% !important;
				-webkit-text-size-adjust: 100% !important;
				-ms-text-size-adjust: 100% !important;
				-webkit-font-smoothing: antialiased !important;
				}
				.ExternalClass * {line-height: 0%}
				table {border-collapse: collapse !important;  padding: 0px !important; }
				table td {border-collapse:collapse;}
				img {
				border: 0 !important;
				display: block !important;
				outline: none !important;
				}
	
				.imgcenter {
				margin-left: auto;
				margin-right: auto;
				
				}
				.text a {text-decoration:none !important;}
				.white a {text-decoration:none !important;}
				@media only screen and (max-width:480px){
				table[class=wrapper]{
				width:100% !important; margin-left: 0px !important;}
				table[class=wrapper_small]{
				width:96% !important; }
				table[class=hide]{
				display:none !important;}
				td[class=text]{
				text-align:left !important;}
				.wrapper { width: 100% !important; margin:0px !important}
				td[class=padding_onn]{
				padding-left:15px !important;
				padding-right:15px !important;}
				td[class=padding_onn_bullets]{
				padding-left:15px !important;
				padding-right:45px !important;}
				span[class=emailHideSPAN] {
				display: none !important;
				}
				*[class=erase] {display: none;}
				}
				@media only screen and (min-width:481px) and (max-width:599px) {
				table[class=wrapper]{
				width:100% !important; margin:0px !important}
				table[class=wrapper_small]{
				width:96% !important;}
				table[class=hide]{
				display:none !important;}
				td[class=text]{
				text-align:left !important;}
				td[class=padding_onn]{
				padding-left:24px !important;
				padding-right:24px !important;}
				td[class=padding_onn_bullets]{
				padding-left:24px !important;
				padding-right:46px !important;}
				span[class=emailHideSPAN] {
				display: none !important;
				}
				*[class=erase] {display: none;}
				}</style>
				<style type="text/css">
				</style>
				</head>
	
				<body marginwidth="0" style="padding:0" marginheight="0">
	
				<!--GMAIL APP MISALIGNMENT FIX: BEGIN-->
				<table>
					<tr>
						<span class="emailHideSPAN">
							<td>
								<table border="0" cellpadding="0" cellspacing="0" width="350px" align="center">
								<tr>
									<td style="line-height: 1px; font-size: 1px;" height="1"> </td>
								</tr>
								</table>
							</td>
						</span>
					</tr>
				</table>
				<!--GMAIL APP MISALIGNMENT FIX: END-->
	
				<!--Whole Table at 100%-->
				<table border="0" cellpadding="0" width="100%" cellspacing="0" style="border-right: 5px solid #f5f7fa;border-left: 5px solid #f5f7fa;" align="center">
				<tr>
				<td valign="top" style="background-color:#f5f7fa;" align="center">
				<!--Start Coursera Logo-->
				<table class="wrapper" border="0" cellpadding="0" width="900" cellspacing="0" style="max-width:900px;" align="center">
				<tr>
					<td bgcolor="#f5f7fa" style="background-color: #f5f7fa; padding: 30px 0px;" align="center">
						<table class="wrapper" border="0" cellpadding="0" width="600" cellspacing="0" style="max-width:600px;" align="center">
							<tr>
								<td bgcolor="#f5f7fa" style="background-color: #f5f7fa; padding: 0px 80px 15px;" align="center">
									<a href="https://www.mul.edu.pk/" target="_blank">
										<img src="https://www.mul.edu.pk/images/email-icons/mul-logo.png" width="190" alt="Minhaj University Lahore" style="display: block; width:190px;height: auto;" height="auto"/>
									</a>
									</td>
							</tr>
						</table>
				<!--Start Body-->
				<table class="wrapper" border="0" cellpadding="0" width="600" cellspacing="0" style="max-width:600px;" align="center">
				<!--Start Header-->
				<tr>
				<td style="font-family:\'Open Sans\', Arial, sans-serif; background-color: #ffffff; border-top: 4px solid #344E86;" align="center">
				<table class="wrapper" border="0" cellpadding="0" width="560" cellspacing="0" style="max-width:560px;" align="center">
				<!--Space-->
				<tr>
					<td style="font-size:1px; line-height:1px;" height="30px"> </td>
				</tr>
	
				<tr>
					<td class="padding_onn" valign="top" style="font-family:\'Open Sans\', Arial, sans-serif; padding: 0px 15px 5px 15px; font-size:16px; color:#444444; line-height:30px; text-align:left; font-weight:bold; font-style:normal" align="left"> 
						Dear Student,<br>
					</td>
				</tr>
	
				<!--Space-->
				<tr>
					<td style="font-size:1px; line-height:1px;" height="10px"> </td>
				</tr>
	
				<tr>
					<td class="padding_onn" valign="top" style="font-family:\'Open Sans\', Arial, sans-serif; padding: 0px 15px 15px 15px; font-size:14px; color:#444444; line-height:22px; text-align:left;" align="left">
						Referring to your application number <span style="text-decoration:none; font-weight:600;">'.cleanvars($_POST['reference_no']).'</span>, it is to inform you that your application has an objection. Please check your CMS for further details.
					</td>
				</tr>
	
				<!--Space-->
				<tr>
					<td style="font-size:1px; line-height:1px;" height="10px"> </td>
				</tr>
	
				<tr>
					<td class="padding_onn" valign="top" style="font-family:\'Open Sans\', Arial, sans-serif; padding: 0px 15px 15px 15px; font-size:14px; color:#444444; line-height:22px; text-align:left;" align="left">
						For more details/further correspondence, please write to us at support.students@mul.edu.pk
					</td>
				</tr>
	
				<!--Space-->
				<tr>
					<td style="font-size:1px; line-height:1px;" height="10px"> </td>
				</tr>
	
				<tr>
					<td class="padding_onn" valign="top" style="font-family:\'Open Sans\', Arial, sans-serif; padding: 0px 15px 5px 15px; font-size:14px; color:#444444; line-height:22px; text-align:left;" align="left">
						Best Regards,<br/>
						Directorate of Students Affairs (DSA),<br/>
						Minhaj University Lahore, Pakistan.
					</td>
				</tr>
	
				<tr>
					<td style="font-size:1px; line-height:1px;" height="30px"> </td>
				</tr>
	
				</table>
				</td>
				</tr>
				</table>
	
				<div style="background-color: #f9f9f9; max-width: 600px; font-size: 16px; font-family:\'Open Sans\', Arial, sans-serif; line-height: 1.5em; width: 100%; margin: 0 auto;" align="center">
	
				<table class="wrapper" border="0" cellpadding="0" width="625" cellspacing="0" style="max-width:625px;" align="center">
				<tr>
					<td style="font-family:\'Open Sans\', Arial, sans-serif; font-size:14px; color:#444444; text-align: center; padding: 30px 15px 15px" align="center">
						Download our mobile app and learn on the go
					</td>
				</tr>
	
				<tr>
					<td align="center" style="padding: 2.5% 0% 2.5% 0%;">
						<table style="display: inline-block;">
							<tr>
								<td style="padding:0px 7px">
									<a href="https://get.mul.edu.pk/?med=0c83f57c786a0b4a39efab23731c7ebc">
										<img src="https://mul.edu.pk/images/applystore-MUL.jpg" alt="App Store" width="175" height="auto" style="display: block; width: 175px !important; height: auto !important">
									</a>
								</td>
								<td style="padding:0px 8px">
									<a href="https://get.mul.edu.pk/?med=0c83f57c786a0b4a39efab23731c7ebc">
										<img src="https://mul.edu.pk/images/playstore-MUL.jpg" alt="Android" width=""175 height="auto" style="display: block; width: 175px !important; height: auto !important">
									</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
	
				<tr>
					<td style="font-family:\'Open Sans\', Arial, sans-serif; font-size:14px; color:#444444; text-align: center; padding: 10px 15px 15px" align="center">
						Connect with MUL
					</td>
				</tr>
	
				<tr>
					<td>
						<table style="border: 0px solid green" align="center">
							<tr>
	
								<td width="45" style="vertical-align: bottom" align="center">
									<a href="https://www.facebook.com/MinhajUniversityLahore/" target="_blank" >
										<img border="0" src="https://www.mul.edu.pk/images/email-icons/facebook_circle.png" width="35" alt="FB" style="display: block; width: 35px; border: 0px solid red !important"/>
									</a>
								</td>
	
								<td width="45" style="vertical-align: bottom" align="center">
									<a href="https://twitter.com/OfficialMUL/" target="_blank" >
										<img border="0" src="https://www.mul.edu.pk/images/email-icons/twitter_circle.png" width="35" alt="Twitter" style="display: block; width: 35px; border: 0px solid red !important"/>
									</a>
								</td>
	
								<td width="45" style="vertical-align: bottom" align="center">
									<a href="https://www.linkedin.com/company/minhajuniversitylahore/" target="_blank" >
										<img border="0" src="https://www.mul.edu.pk/images/email-icons/inkedin_circle.png" width="35" alt="LI" style="display: block;width: 35px; border: 0px solid red !important"/>
									</a>
								</td>
								
								<td width="45" style="vertical-align: bottom" align="center">
									<a href="https://www.youtube.com/MinhajUniversityLahore-Official/" target="_blank" >
										<img border="0" src="https://www.mul.edu.pk/images/email-icons/youtube_circle.png" width="35" alt="Youtube" style="display: block; width: 35px; border: 0px solid red !important"/>
									</a>
								</td>
	
								<td width="45" style="vertical-align: bottom" align="center">
									<a href="https://www.instagram.com/minhajuniversitylahore/" target="_blank" >
										<img border="0" src="https://www.mul.edu.pk/images/email-icons/Instagram_circle.png" width="35" alt="Insta" style="display: block; width: 35px; border: 0px solid red !important"/>
									</a>
								</td>
	
							</tr>
						</table>
					</td>
				</tr>
	
				<tr>
				<td style="font-family:\'Open Sans\', Arial, sans-serif; font-size:14px; line-height:17px; color:#444444; text-align: center; padding: 30px 15px" align="center">
	
					<a href="https://www.mul.edu.pk/english/about/mul-an-international-university/" style="text-decoration:underline !important;  color:#444444;">About Us</a> &nbsp;|&nbsp; 
					
					<a href="https://www.mul.edu.pk/english/news-events/" target="_blank" style="text-decoration:underline !important; color:#444444;">News & Events</a> &nbsp;|&nbsp; 
					
					<a href="https://www.mul.edu.pk/english/contact-us/" target="_blank" style="text-decoration:underline !important; color:#444444;">Contact</a>
					
					<br/>
					<br/>&#169; '.date('Y').' Minhaj University Lahore. All rights reserved. <br/>
					<br/>MUL | Hamdard Chowk, Township, Lahore, Pakistan.
					
				</td>
				</tr>
				</table>
				</div>
	
				</td>
				</tr>
				</table>
				</td>
				</tr>
				</table>
	
				</body>
				</html>';
				$mail->Body     = $htmlcontents;
				$mail->AltBody = 'This is a plain-text message body';
	
				//send the message, check for errors
				if (!$mail->send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					echo 'Message sent: '.$_POST['ap_email'].'<br>';
				}
			}
		}

		if(isset($_POST['redirect_url']) && cleanvars($_POST['redirect_url']) != ''){
			$redirectURL = cleanvars($_POST['redirect_url']);
		} else {
			$redirectURL = 'dsadegreetranscript.php';
		}

		//Set Success MSG in Session & Exit
		$_SESSION['msg']['status']  = '<div class="alert-box notice"><span>Success: </span>Record has been updated successfully.</div>';
		//header("Location: dsadegreetranscript.php", true, 301);
		header("Location: $redirectURL", true, 301);
		exit();

	}
}

//Notify Applicant
if(isset($_POST['notify_applicant'])) { 

	$queryUpdate  = $dblms->querylms("UPDATE ".DSA_APPLICATIONS." SET 
													notified_applicant	 = '1'
														, id_notify	= '".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'
														, date_notify	= NOW()
													WHERE id		= '".cleanvars($_POST['id_application'])."'");

	if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) == 1){

		require('PHPMailer/PHPMailerAutoload.php');

		if(filter_var($_POST['ap_email'], FILTER_VALIDATE_EMAIL)) {
	
			//Create a new PHPMailer instance
			$mail = new PHPMailer;
			//Set who the message is to be sent from
			$mail->setFrom('noreply@mul.edu.pk', 'Directorate of Students Affairs (DSA) - Minhaj University Lahore');

			//Set an alternative reply-to address
			$mail->addAddress($_POST['ap_email'], $_POST['ap_name']);

			//$mail->addCC("rahia307@gmail.com");
			//$mail->addBCC("ibrar.hussain@mul.edu.pk");
			//$mail->addBCC("webmaster@mul.edu.pk");
			//Set the subject line
			$mail->Subject = 'Notification: Issuance of '.get_stdaffairstypes(cleanvars($_POST['degree_transcript']));
			$mail->isHTML(true);
			//Read an HTML message body from an external file, convert referenced images to embedded,
			$htmlcontents = '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta name="x-apple-disable-message-reformatting"/>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
			<meta name="viewport" content="width=device-width, initial-scale=1.0 "/>
			<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
			<title>Announcement</title>
			<style type="text/css">
				@import url("https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i");
			body {
			margin: 0 !important;
			padding: 0 !important;
			width: 100% !important;
			-webkit-text-size-adjust: 100% !important;
			-ms-text-size-adjust: 100% !important;
			-webkit-font-smoothing: antialiased !important;
			}
			.ExternalClass * {line-height: 0%}
			table {border-collapse: collapse !important;  padding: 0px !important; }
			table td {border-collapse:collapse;}
			img {
			border: 0 !important;
			display: block !important;
			outline: none !important;
			}

			.imgcenter {
			margin-left: auto;
			margin-right: auto;
			
			}
			.text a {text-decoration:none !important;}
			.white a {text-decoration:none !important;}
			@media only screen and (max-width:480px){
			table[class=wrapper]{
			width:100% !important; margin-left: 0px !important;}
			table[class=wrapper_small]{
			width:96% !important; }
			table[class=hide]{
			display:none !important;}
			td[class=text]{
			text-align:left !important;}
			.wrapper { width: 100% !important; margin:0px !important}
			td[class=padding_onn]{
			padding-left:15px !important;
			padding-right:15px !important;}
			td[class=padding_onn_bullets]{
			padding-left:15px !important;
			padding-right:45px !important;}
			span[class=emailHideSPAN] {
			display: none !important;
			}
			*[class=erase] {display: none;}
			}
			@media only screen and (min-width:481px) and (max-width:599px) {
			table[class=wrapper]{
			width:100% !important; margin:0px !important}
			table[class=wrapper_small]{
			width:96% !important;}
			table[class=hide]{
			display:none !important;}
			td[class=text]{
			text-align:left !important;}
			td[class=padding_onn]{
			padding-left:24px !important;
			padding-right:24px !important;}
			td[class=padding_onn_bullets]{
			padding-left:24px !important;
			padding-right:46px !important;}
			span[class=emailHideSPAN] {
			display: none !important;
			}
			*[class=erase] {display: none;}
			}</style>
			<style type="text/css">
			</style>
			</head>

			<body marginwidth="0" style="padding:0" marginheight="0">

			<!--GMAIL APP MISALIGNMENT FIX: BEGIN-->
			<table>
				<tr>
					<span class="emailHideSPAN">
						<td>
							<table border="0" cellpadding="0" cellspacing="0" width="350px" align="center">
							<tr>
								<td style="line-height: 1px; font-size: 1px;" height="1"> </td>
							</tr>
							</table>
						</td>
					</span>
				</tr>
			</table>
			<!--GMAIL APP MISALIGNMENT FIX: END-->

			<!--Whole Table at 100%-->
			<table border="0" cellpadding="0" width="100%" cellspacing="0" style="border-right: 5px solid #f5f7fa;border-left: 5px solid #f5f7fa;" align="center">
			<tr>
			<td valign="top" style="background-color:#f5f7fa;" align="center">
			<!--Start Coursera Logo-->
			<table class="wrapper" border="0" cellpadding="0" width="900" cellspacing="0" style="max-width:900px;" align="center">
			<tr>
				<td bgcolor="#f5f7fa" style="background-color: #f5f7fa; padding: 30px 0px;" align="center">
					<table class="wrapper" border="0" cellpadding="0" width="600" cellspacing="0" style="max-width:600px;" align="center">
						<tr>
							<td bgcolor="#f5f7fa" style="background-color: #f5f7fa; padding: 0px 80px 15px;" align="center">
								<a href="https://www.mul.edu.pk/" target="_blank">
									<img src="https://www.mul.edu.pk/images/email-icons/mul-logo.png" width="190" alt="Minhaj University Lahore" style="display: block; width:190px;height: auto;" height="auto"/>
								</a>
								</td>
						</tr>
					</table>
			<!--Start Body-->
			<table class="wrapper" border="0" cellpadding="0" width="600" cellspacing="0" style="max-width:600px;" align="center">
			<!--Start Header-->
			<tr>
			<td style="font-family:\'Open Sans\', Arial, sans-serif; background-color: #ffffff; border-top: 4px solid #344E86;" align="center">
			<table class="wrapper" border="0" cellpadding="0" width="560" cellspacing="0" style="max-width:560px;" align="center">
			<!--Space-->
			<tr>
				<td style="font-size:1px; line-height:1px;" height="30px"> </td>
			</tr>

			<tr>
				<td class="padding_onn" valign="top" style="font-family:\'Open Sans\', Arial, sans-serif; padding: 0px 15px 5px 15px; font-size:16px; color:#444444; line-height:30px; text-align:left; font-weight:bold; font-style:normal" align="left"> 
					Dear '.cleanvars($_POST['ap_name']).',<br>
				</td>
			</tr>

			<!--Space-->
			<tr>
				<td style="font-size:1px; line-height:1px;" height="10px"> </td>
			</tr>
			
			<tr>
				<td class="padding_onn" valign="top" style="font-family:\'Open Sans\', Arial, sans-serif; padding: 0px 15px 15px 15px; font-size:14px; color:#444444; line-height:22px; text-align:left;" align="left">
					Thank you for choosing MUL as your graduating institution.
				</td>
			</tr>

			<!--Space-->
			<tr>
				<td style="font-size:1px; line-height:1px;" height="10px"> </td>
			</tr>

			<tr>
				<td class="padding_onn" valign="top" style="font-family:\'Open Sans\', Arial, sans-serif; padding: 0px 15px 15px 15px; font-size:14px; color:#444444; line-height:22px; text-align:left;" align="left">
				Referring to your application number <span style="text-decoration:none; font-weight:600;">'.cleanvars($_POST['reference_no']).'</span>, it is to inform you that your <span style="text-decoration:none; font-weight:600;">'.get_stdaffairstypes(cleanvars($_POST['degree_transcript'])).'</span> has been issued. You can collect the said document from the Directorate of Students Affairs (DSA) by visiting the University along with your original CNIC during the timings given below:
				</td>
			</tr>

			<!--Space-->
			<tr>
				<td style="font-size:1px; line-height:1px;" height="10px"> </td>
			</tr>

			<tr>
				<td class="padding_onn" valign="top" style="font-family:\'Open Sans\', Arial, sans-serif; padding: 0px 15px 15px 15px; font-size:14px; color:#444444; line-height:22px; text-align:left;" align="left">
					<span style="text-decoration:none; font-weight:600;">Monday to Thursday:</span> 9:00am to 6:30pm<br>
					<span style="text-decoration:none; font-weight:600;">Friday:</span> 9:00am to 8:00pm<br>
					<span style="text-decoration:none; font-weight:600;">Saturday:</span> 2:30pm to 8:00pm<br>
					<span style="text-decoration:none; font-weight:600;">Sunday:</span> 9:30am to 3:30pm
				</td>
			</tr>

			<!--Space-->
			<tr>
				<td style="font-size:1px; line-height:1px;" height="10px"> </td>
			</tr>

			<tr>
				<td class="padding_onn" valign="top" style="font-family:\'Open Sans\', Arial, sans-serif; padding: 0px 15px 15px 15px; font-size:14px; color:#444444; line-height:22px; text-align:left;" align="left">
					For more details/further correspondence, please write to us at support.students@mul.edu.pk
				</td>
			</tr>

			<!--Space-->
			<tr>
				<td style="font-size:1px; line-height:1px;" height="10px"> </td>
			</tr>

			<tr>
				<td class="padding_onn" valign="top" style="font-family:\'Open Sans\', Arial, sans-serif; padding: 0px 15px 15px 15px; font-size:14px; color:#444444; line-height:22px; text-align:left;" align="left">
					We wish you a very bright future ahead.
				</td>
			</tr>

			<!--Space-->
			<tr>
				<td style="font-size:1px; line-height:1px;" height="10px"> </td>
			</tr>

			<tr>
				<td class="padding_onn" valign="top" style="font-family:\'Open Sans\', Arial, sans-serif; padding: 0px 15px 5px 15px; font-size:14px; color:#444444; line-height:22px; text-align:left;" align="left">
					Best Regards,<br/>
					Directorate of Students Affairs (DSA),<br/>
					Minhaj University Lahore, Pakistan.
				</td>
			</tr>

			<tr>
				<td style="font-size:1px; line-height:1px;" height="30px"> </td>
			</tr>

			</table>
			</td>
			</tr>
			</table>

			<div style="background-color: #f9f9f9; max-width: 600px; font-size: 16px; font-family:\'Open Sans\', Arial, sans-serif; line-height: 1.5em; width: 100%; margin: 0 auto;" align="center">

			<table class="wrapper" border="0" cellpadding="0" width="625" cellspacing="0" style="max-width:625px;" align="center">
			<tr>
				<td style="font-family:\'Open Sans\', Arial, sans-serif; font-size:14px; color:#444444; text-align: center; padding: 30px 15px 15px" align="center">
					Download our mobile app and learn on the go
				</td>
			</tr>

			<tr>
				<td align="center" style="padding: 2.5% 0% 2.5% 0%;">
					<table style="display: inline-block;">
						<tr>
							<td style="padding:0px 7px">
								<a href="https://get.mul.edu.pk/?med=0c83f57c786a0b4a39efab23731c7ebc">
									<img src="https://mul.edu.pk/images/applystore-MUL.jpg" alt="App Store" width="175" height="auto" style="display: block; width: 175px !important; height: auto !important">
								</a>
							</td>
							<td style="padding:0px 8px">
								<a href="https://get.mul.edu.pk/?med=0c83f57c786a0b4a39efab23731c7ebc">
									<img src="https://mul.edu.pk/images/playstore-MUL.jpg" alt="Android" width=""175 height="auto" style="display: block; width: 175px !important; height: auto !important">
								</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td style="font-family:\'Open Sans\', Arial, sans-serif; font-size:14px; color:#444444; text-align: center; padding: 10px 15px 15px" align="center">
					Connect with MUL
				</td>
			</tr>

			<tr>
				<td>
					<table style="border: 0px solid green" align="center">
						<tr>

							<td width="45" style="vertical-align: bottom" align="center">
								<a href="https://www.facebook.com/MinhajUniversityLahore/" target="_blank" >
									<img border="0" src="https://www.mul.edu.pk/images/email-icons/facebook_circle.png" width="35" alt="FB" style="display: block; width: 35px; border: 0px solid red !important"/>
								</a>
							</td>

							<td width="45" style="vertical-align: bottom" align="center">
								<a href="https://twitter.com/OfficialMUL/" target="_blank" >
									<img border="0" src="https://www.mul.edu.pk/images/email-icons/twitter_circle.png" width="35" alt="Twitter" style="display: block; width: 35px; border: 0px solid red !important"/>
								</a>
							</td>

							<td width="45" style="vertical-align: bottom" align="center">
								<a href="https://www.linkedin.com/company/minhajuniversitylahore/" target="_blank" >
									<img border="0" src="https://www.mul.edu.pk/images/email-icons/inkedin_circle.png" width="35" alt="LI" style="display: block;width: 35px; border: 0px solid red !important"/>
								</a>
							</td>
							
							<td width="45" style="vertical-align: bottom" align="center">
								<a href="https://www.youtube.com/MinhajUniversityLahore-Official/" target="_blank" >
									<img border="0" src="https://www.mul.edu.pk/images/email-icons/youtube_circle.png" width="35" alt="Youtube" style="display: block; width: 35px; border: 0px solid red !important"/>
								</a>
							</td>

							<td width="45" style="vertical-align: bottom" align="center">
								<a href="https://www.instagram.com/minhajuniversitylahore/" target="_blank" >
									<img border="0" src="https://www.mul.edu.pk/images/email-icons/Instagram_circle.png" width="35" alt="Insta" style="display: block; width: 35px; border: 0px solid red !important"/>
								</a>
							</td>

						</tr>
					</table>
				</td>
			</tr>

			<tr>
			<td style="font-family:\'Open Sans\', Arial, sans-serif; font-size:14px; line-height:17px; color:#444444; text-align: center; padding: 30px 15px" align="center">

				<a href="https://www.mul.edu.pk/english/about/mul-an-international-university/" style="text-decoration:underline !important;  color:#444444;">About Us</a> &nbsp;|&nbsp; 
				
				<a href="https://www.mul.edu.pk/english/news-events/" target="_blank" style="text-decoration:underline !important; color:#444444;">News & Events</a> &nbsp;|&nbsp; 
				
				<a href="https://www.mul.edu.pk/english/contact-us/" target="_blank" style="text-decoration:underline !important; color:#444444;">Contact</a>
				
				<br/>
				<br/>&#169; '.date('Y').' Minhaj University Lahore. All rights reserved. <br/>
				<br/>MUL | Hamdard Chowk, Township, Lahore, Pakistan.
				
			</td>
			</tr>
			</table>
			</div>

			</td>
			</tr>
			</table>
			</td>
			</tr>
			</table>

			</body>
			</html>';
			$mail->Body     = $htmlcontents;
			$mail->AltBody = 'This is a plain-text message body';

			//send the message, check for errors
			if (!$mail->send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
				echo 'Message sent: '.$_POST['ap_email'].'<br>';
			}
			
		}
	}

	$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>Applicant has been notified successfully.</div>';
	header("Location: dsadegreetranscript.php", true, 301);
	exit();
	
}

if(isset($_POST['delete_picture'])) { 

	$queryUpdate  = $dblms->querylms("UPDATE ".DSA_APPLICATIONS." SET 
															photo	 	= ''
													WHERE id			= '".cleanvars($_POST['id_application'])."'");
	if($queryUpdate) { 

		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>File has been removed successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
		
	}
}

if(isset($_POST['delete_cnic'])) { 

	$queryUpdate  = $dblms->querylms("UPDATE ".DSA_APPLICATIONS." SET 
														cnic_photo	 	= ''
													WHERE id			= '".cleanvars($_POST['id_application'])."'");
	if($queryUpdate) { 

		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>File has been removed successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
		
	}
}

if(isset($_POST['delete_matric_result'])) { 

	$queryUpdate  = $dblms->querylms("UPDATE ".DSA_APPLICATIONS." SET 
												matric_result_card	 	= ''
													WHERE id			= '".cleanvars($_POST['id_application'])."'");
	if($queryUpdate) { 

		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>File has been removed successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
		
	}
}

if(isset($_POST['delete_transcript'])) { 

	$queryUpdate  = $dblms->querylms("UPDATE ".DSA_APPLICATIONS." SET 
														transcript	 	= ''
													WHERE id			= '".cleanvars($_POST['id_application'])."'");
	if($queryUpdate) { 

		$_SESSION['msg']['status'] = '<div class="alert-box success"><span>Success: </span>File has been removed successfully.</div>';
		header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
		exit();
		
	}
}

/*
//Delete Offered Courses
if($view == 'delete') {

	//Check right to delete
	if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || ($_SESSION['userlogininfo']['LOGINIDA'] == 22099)) {  
		
		if(isset($_GET['dc_id'])) { 

			$sqllms  	= $dblms->querylms("DELETE FROM ".LA_STUDENT_REGISTRATION_DETAIL." WHERE id = '".cleanvars($_GET['dc_id'])."'");

			if($sqllms) { 
					
				$detailPrams  = "";
				$detailPrams .= '"ID"	'.'=> '.'"'.$_GET['dc_id'].'"'."\n";

				//Query Insert Log
				$logRemarks = 'Deleted Registered Course: '.$_GET['dc_id'];
				
				$dataLog = array(
								'id_user'			=> cleanvars($_SESSION['userlogininfo']['LOGINIDA'])	, 
								'filename'			=> basename($_SERVER['REQUEST_URI'])					, 
								'id_record'			=> $_GET['dc_id']										, 
								'action'			=> 3													, 
								'dated'				=> date("Y-m-d H:i:s")									, 
								'ip'				=> $ip.':'.$_SERVER['REMOTE_PORT']						, 
								'remarks'			=> cleanvars($logRemarks)								,
								'details'			=> cleanvars($detailPrams)								,
								'sess_id'			=> cleanvars(session_id())								,
								'device_details'	=> cleanvars($devicedetails) 							,
								'id_campus'			=> cleanvars(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']))	
							);
			
				$sqllmsInsertDetail  = $dblms->Insert(LA_LOGFILE, $dataLog);
				
				//Set Success MSG in Session & Exit
				$_SESSION['msg']['status']  = '<div class="alert-box notice"><span>Success: </span>Record Deleted successfully.</div>';
				header("Location: ".$_SERVER['HTTP_REFERER']."", true, 301);
				exit();
		
			}

		}
		
	} else {

		$_SESSION['msg']['status']  = '<div class="alert-box notice"><span>Error: </span>You have no right to delete.</div>';
		header("Location: lacoursesregistration.php", true, 301);
		exit();
		
	}
	// end check delete right
	
}
*/