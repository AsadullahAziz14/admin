<?php
if(isset($_POST['submit_annoucements'])) { 

	$queryCheck = $dblms->querylms("SELECT id  
										FROM ".COURSES_ANNOUCEMENTS." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
										AND academic_session = '".cleanvars($_SESSION['userlogininfo']['LOGINIDACADYEAR'])."' 
										AND id_curs = '".cleanvars($_GET['id'])."'
										AND id_teacher = '".cleanvars($rowsstd['emply_id'])."' 
										AND caption = '".cleanvars($_POST['caption'])."' 
										AND dated = '".cleanvars(date("Y-m-d"))."' LIMIT 1");
	if(mysqli_num_rows($queryCheck) > 0) { 
		
		$_SESSION['msg']['status'] = '<div class="alert-box warning"><span>Notice: </span>Record already exists.</div>';
		header("Location:courses.php?id=".$_GET['id']."&view=Annoucements", true, 301);
		exit();
	
	} else { 

		$queryInsert = $dblms->querylms("INSERT INTO ".COURSES_ANNOUCEMENTS." (
																			status								, 
																			dated								, 
																			caption								, 
																			detail								,
																			id_curs								,
																			id_teacher							,
																			academic_session					,
																			id_campus							,
																			id_added							, 
																			date_added 
																	)
																VALUES (
																			'".cleanvars($_POST['status'])."'			,
																			'".cleanvars(date("Y-m-d"))."'				,
																			'".cleanvars($_POST['caption'])."'			,
																			'".cleanvars($_POST['detail'])."'			, 
																			'".cleanvars($_POST['id_curs'])."'			, 
																			'".cleanvars($rowsstd['emply_id'])."'		, 
																			'".$_SESSION['userlogininfo']['LOGINIDACADYEAR']."' 		,
																			'".$_SESSION['userlogininfo']['LOGINIDCOM']."' 				,
																			'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		, 
																			NOW() 
																	)"
								);
		if($queryInsert) { 

			$latestID = $dblms->lastestid();

			$arraychecked = $_POST['idprg'];
			$topicprograms = "\n";

			if(!empty(sizeof($_POST['idprg']))) {

				for($ichkj=0; $ichkj<count($_POST['idprg']); $ichkj++){ 

					$arr 		= $_POST['idprg'][$ichkj];

					$splitted 	= explode(",",trim($arr));  
					$idprg 		= $splitted[0];
					$semester 	= $splitted[1];
					$timing 	= $splitted[2];
					$section 	= $splitted[3];

					$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_ANNOUCEMENTSPROGRAM." (
																						id_setup				, 
																						id_prg					, 
																						semester				,
																						section					,
																						timing							
																				)
																			VALUES (
																						'".cleanvars($latestID)."'	,
																						'".cleanvars($idprg)."'		,
																						'".cleanvars($semester)."'	, 
																						'".cleanvars($section)."'	, 
																						'".cleanvars($timing)."'		 
																						
																				)"
											);

					$topicprograms 	.= '"id_prg:"'.'=>'.'"'.($idprg).'",'."\n";
					$topicprograms 	.= '"semester:"'.'=>'.'"'.($semester).'",'."\n";
					$topicprograms 	.= '"section:"'.'=>'.'"'.($section).'",'."\n";
					$topicprograms 	.= '"timing:"'.'=>'.'"'.($timing).'"'."\n";
				}
			}
			
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$latestID.'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$_POST['status'].'",'."\n";
			$requestedvars .= '"Dated:"'.'=>'.'"'.date("Y-m-d").'",'."\n";
			$requestedvars .= '"Caption:"'.'=>'.'"'.$_POST['caption'].'",'."\n";
			$requestedvars .= '"Details:"'.'=>'.'"'.$_POST['detail'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'",'."\n";
			$requestedvars .= '"programs:"'.'=>'.'array('."\n";
			$requestedvars .= $topicprograms."\n";
			$requestedvars .= ")\n";

			$logremarks = 'Add Annoucement #: '.$dblms->lastestid().' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
			$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGSTEACHER." (
																id_user										, 
																filename									, 
																action										,
																dated										,
																ip											,
																remarks										,
																details										,
																sess_id						,
																device_details				,
																id_campus				
															)
			
														VALUES(
																'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		,
																'".basename($_SERVER['REQUEST_URI'])."'		, 
																'1'											, 
																NOW()										,
																'".cleanvars($ip)."'						,
																'".cleanvars($logremarks)."'				,
																'".cleanvars($requestedvars)."'				,
																'".cleanvars(session_id())."'				,
																'".cleanvars($devicedetails)."'				,
																'".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'			
															)
										");

			if(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']) == 1){

				require('PHPMailer/PHPMailerAutoload.php');

				$daName = 'Director Academics';
				$daEmailAddress = 'director.academics@mul.edu.pk';

				if(filter_var($daEmailAddress, FILTER_VALIDATE_EMAIL)) {
				
					$srno++;
		
					//Create a new PHPMailer instance
					$mail = new PHPMailer;
					//Set who the message is to be sent from
					$mail->setFrom('noreply@mul.edu.pk', 'Minhaj University Lahore');
		
					//Set an alternative reply-to address
					$mail->addAddress($daEmailAddress, $daName);

					//$mail->addCC("rahia307@gmail.com");
					//$mail->addBCC("ibrar.hussain@mul.edu.pk");
					//$mail->addBCC("webmaster@mul.edu.pk");
					//Set the subject line
					$mail->Subject = 'Announcement - '.$rowsstd['emply_name'].' - '.$rowsurs['curs_code'].' - '.$rowsurs['curs_name'];
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
							Dear '.$rowsstd['emply_name'].',<br>
							<span style="font-weight:normal;">'.$rowsstd['designation_name'].'</span>,<br>
							<span style="font-weight:normal;">'.$rowsstd['dept_name'].'</span>
						</td>
					</tr>
		
					<!--Space-->
					<tr>
						<td style="font-size:1px; line-height:1px;" height="10px"> </td>
					</tr>
					<tr>
						<td class="padding_onn" valign="top" style="font-family:\'Open Sans\', Arial, sans-serif; padding: 0px 15px 15px 15px; font-size:14px; color:#444444; line-height:22px; text-align:left;" align="left">
							<span style="text-decoration:none; font-weight:600;">Course Code & Name:</span> '.$rowsurs['curs_code'].' - '.$rowsurs['curs_name'].'<br>
							<span style="text-decoration:none; font-weight:600;">Announcement:</span> '.cleanvars($_POST['detail']).'
						</td>
					</tr>
		
					<!--Space-->
					<tr>
						<td style="font-size:1px; line-height:1px;" height="10px"> </td>
					</tr>
		
					<tr>
						<td class="padding_onn" valign="top" style="font-family:\'Open Sans\', Arial, sans-serif; padding: 0px 15px 5px 15px; font-size:14px; color:#444444; line-height:22px; text-align:left;" align="left">
							Sincerely,<br/>
							'.$rowsstd['emply_name'].',<br/>
							'.$rowsstd['designation_name'].',<br/>
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
						//echo "Mailer Error: " . $mail->ErrorInfo;
					} else {
						//echo 'Message sent!'.$srno.'-: '.$daEmailAddress.'<br>';
					}
					
				}
			}

			
			$_SESSION['msg']['status'] = '<div class="alert-box success"><span>success: </span>Record added successfully.</div>';
			header("Location:courses.php?id=".$_GET['id']."&view=Annoucements", true, 301);
			exit();
		}
	}
}

//--------------------------------------
if(isset($_POST['changes_detailannoucements'])) { 
//------------------------------------------------
$sqllmsannoucements  = $dblms->querylms("UPDATE ".COURSES_ANNOUCEMENTS." SET  status	= '".cleanvars($_POST['status'])."'
														, caption			= '".cleanvars($_POST['caption'])."'
														, detail			= '".cleanvars($_POST['detail'])."'
														, id_campus			= '".$_SESSION['userlogininfo']['LOGINIDCOM']."'
														, id_modify			= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														, date_modify		= NOW()
													WHERE id				= '".cleanvars($_POST['editid'])."'");
//--------------------------------------
if($sqllmsannoucements) {
	$topicprograms = "\n";
if(!empty(sizeof($_POST['idprg']))) {
	$sqllmsdelte  = $dblms->querylms("DELETE FROM ".COURSES_ANNOUCEMENTSPROGRAM." WHERE id_setup = '".cleanvars($_POST['editid'])."'");
//--------------------------------------
	for($ichkj=0; $ichkj<count($_POST['idprg']); $ichkj++){ 
//--------------------------------------
	$arr 		= $_POST['idprg'][$ichkj];
	$splitted 	= explode(",",trim($arr));  

	$idprg 		= $splitted[0];
	$semester 	= $splitted[1];
	$timing 	= $splitted[2];
	$section 	= $splitted[3];
//--------------------------------------
	$sqllmsrel = $dblms->querylms("INSERT INTO ".COURSES_ANNOUCEMENTSPROGRAM." (
																		id_setup				, 
																		id_prg					, 
																		semester				,
																		section					,
																		timing							
																   )
	   														VALUES (
																		'".cleanvars($_POST['editid'])."'	,
																		'".cleanvars($idprg)."'				,
																		'".cleanvars($semester)."'			, 
																		'".cleanvars($section)."'			, 
																		'".cleanvars($timing)."'		 
																		
													 			 )"
							);
		//--------------------------------------
					$topicprograms 	.= '"id_prg:"'.'=>'.'"'.($idprg).'",'."\n";
					$topicprograms 	.= '"semester:"'.'=>'.'"'.($semester).'",'."\n";
					$topicprograms 	.= '"section:"'.'=>'.'"'.($section).'",'."\n";
					$topicprograms 	.= '"timing:"'.'=>'.'"'.($timing).'"'."\n";
//--------------------------------------
	}
	}
//--------------------------------------
	
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$_POST['editid'].'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$_POST['status'].'",'."\n";
			$requestedvars .= '"Dated:"'.'=>'.'"",'."\n";
			$requestedvars .= '"Caption:"'.'=>'.'"'.$_POST['caption'].'",'."\n";
			$requestedvars .= '"Details:"'.'=>'.'"'.$_POST['detail'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'",'."\n";
			$requestedvars .= '"programs:"'.'=>'.'array('."\n";
			$requestedvars .= $topicprograms."\n";
			$requestedvars .= ")\n";
//--------------------------------------	
		$logremarks = 'Update Annoucement #:'.$_POST['editid'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGSTEACHER." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															details										,
															sess_id						,
															device_details				,
															id_campus				
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		,
															'".basename($_SERVER['REQUEST_URI'])."'		, 
															'2'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($logremarks)."'				,
															'".cleanvars($requestedvars)."'				,
															'".cleanvars(session_id())."'				,
															'".cleanvars($devicedetails)."'				,
															'".cleanvars(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']))."'			
														  )
									");
		
			$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
			header("Location:courses.php?id=".$_GET['id']."&view=Annoucements", true, 301);
			exit();
		}
//--------------------------------------
	}
//--------------------------------------
if(isset($_POST['changes_annoucements'])) { 
//------------------------------------------------
$sqllmsannoucements  = $dblms->querylms("UPDATE ".COURSES_ANNOUCEMENTS." SET  status	= '".cleanvars($_POST['status_edit'])."'
														, caption			= '".cleanvars($_POST['caption_edit'])."'
														, detail			= '".cleanvars($_POST['detail_edit'])."'
														, id_campus			= '".$_SESSION['userlogininfo']['LOGINIDCOM']."'
														, id_modify			= '".$_SESSION['userlogininfo']['LOGINIDA']."'
														, date_modify		= NOW()
													WHERE id				= '".cleanvars($_POST['annoucementid_edit'])."'");
//--------------------------------------
		if($sqllmsannoucements) {
//--------------------------------------
	
			$requestedvars = "\n";
			$requestedvars .= '"ID:"'.'=>'.'"'.$_POST['annoucementid_edit'].'",'."\n";
			$requestedvars .= '"Status:"'.'=>'.'"'.$_POST['status_edit'].'",'."\n";
			$requestedvars .= '"Dated:"'.'=>'.'"",'."\n";
			$requestedvars .= '"Caption:"'.'=>'.'"'.$_POST['caption_edit'].'",'."\n";
			$requestedvars .= '"Details:"'.'=>'.'"'.$_POST['detail_edit'].'",'."\n";
			$requestedvars .= '"Course ID:"'.'=>'.'"'.$_GET['id'].'",'."\n";
			$requestedvars .= '"Course Code:"'.'=>'.'"'.$rowsurs['curs_code'].'",'."\n";
			$requestedvars .= '"Course Name:"'.'=>'.'"'.$rowsurs['curs_name'].'",'."\n";
			$requestedvars .= '"Emply ID:"'.'=>'.'"'.$rowsstd['emply_id'].'"';
//--------------------------------------	
		$logremarks = 'Update Annoucement #:'.$_POST['annoucementid_edit'].' for Course: '.$rowsurs['curs_code'].'-'.$rowsurs['curs_name'];
		$sqllmslog  = $dblms->querylms("INSERT INTO ".LOGSTEACHER." (
															id_user										, 
															filename									, 
															action										,
															dated										,
															ip											,
															remarks										,
															details										,
															sess_id										,
															device_details								,
															id_campus				
														  )
		
													VALUES(
															'".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."'		,
															'".basename($_SERVER['REQUEST_URI'])."'		, 
															'2'											, 
															NOW()										,
															'".cleanvars($ip)."'						,
															'".cleanvars($logremarks)."'				,
															'".cleanvars($requestedvars)."'				,
															'".cleanvars(session_id())."'				,
															'".cleanvars($devicedetails)."'				,
															'".cleanvars(cleanvars($_SESSION['userlogininfo']['LOGINIDCOM']))."'			
														  )
									");
			
			$_SESSION['msg']['status'] = '<div class="alert-box notice"><span>success: </span>Record update successfully.</div>';
			header("Location:courses.php?id=".$_GET['id']."&view=Annoucements", true, 301);
			exit();
		}
//--------------------------------------
	}
