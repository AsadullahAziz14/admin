<?php
//----------------------------------------------------
	// error_reporting(E_ALL);
	ob_start();
	ob_clean();
//----------------------------------------------------

	define('LMS_HOSTNAME'			, 'localhost');
	// define('LMS_NAME'				, 'obe_database');
	define('LMS_NAME'				, 'sms');
	// define('LMS_NAME'				, 'mul');
	define('LMS_USERNAME'			, 'root');
	define('LMS_USERPASS'			, '');

///-----------------DB Tables ------------------------
	define('ADMINS'										, 'mul_admins');
	define('CONTACT_INQUIRY' 							, 'mul_contact_inquiry');
	define('EVENT_INQUIRY'								, 'mul_event_inquiry');
	define('GALLERY'									, 'mul_gallery');
	define('LOGFILE' 									, 'mul_logfile');
	define('NOTIFICATION'								, 'mul_app_notification');
	define('POSTS' 										, 'mul_posts');
	define('POSTS_CATS' 								, 'mul_post_category');
	define('SLIDER' 									, 'mul_slider');
	define('TESTIMONIAL' 								, 'mul_testimonial');
	define('DEPARTMENTS' 								, 'cms_departments');
	define('EMPLOYEES' 									, 'cms_employees');
	define('FACULTY'									, 'cms_faculties');
	define('PROGRAMS'									, 'cms_programs');
	define('PROGRAM_CATS'								, 'cms_programs_categories');
	define('WEBSITES' 			    					, 'websites');
	define('SLIDER_WEB' 								, 'slider_web');
	define('OBE_DOMAINS'								, 'cms_obe_domain_levels');
	define('OBE_PLOS' 			        				, 'cms_obe_plos');
	define('OBE_CLOS'									, 'cms_obe_clo');
	define('OBE_CLOS_PROGRAMS'           				, 'cms_obe_clo_programs');
	define('OBE_QUIZZES'								, 'cms_obe_quiz');
	define('OBE_QUESTIONS'								, 'cms_obe_question');
	define('OBE_MCQS'									, 'cms_obe_mcq_options');
	define('OBE_ASSIGNMENTS'							, 'cms_obe_assignment');
	define('OBE_MIDTERMS'								, 'cms_obe_midterm');
	define('OBE_FINALTERMS'								, 'cms_obe_finalterm');
	define('OBE_RESULTS'								, 'cms_obe_result');
	define('OBE_QUESTIONS_RESULTS'						, 'cms_obe_question_result');
	define('OBE_PACS'									, 'cms_obe_paractical_assessment_criteria');
	define('OBE_KPIS'									, 'cms_obe_paractical_kpi');
	define('OBE_PARACTICAL_PERFORMANCES'				, 'cms_obe_paractical_performance');
	define('SMS_DEMAND'									, 'cms_sms_demand');
	define('SMS_DEMAND_ITEM_JUNCTION'					, 'cms_sms_demand_item_junction');
	define('SMS_ITEM'									, 'cms_sms_item');
	define('SMS_CATEGORY' 								, 'cms_sms_category');
	define('SMS_SUB_CATEGORY'							, 'cms_sms_sub_category');
	define('SMS_VENDOR' 								, 'cms_sms_vendor');
	define('SMS_PO' 									, 'cms_sms_po');
	define('SMS_PO_DEMAND_ITEM_JUNCTION' 				, 'cms_sms_po_demand_item_junction');
	define('SMS_RECEIVING' 								, 'cms_sms_receiving');
	define('SMS_RECEIVING_PO_ITEM_JUNCTION'	 			, 'cms_sms_receiving_po_item_junction');
	define('SMS_INVENTORY' 								, 'cms_sms_inventory');
	define('SMS_INVENTORY_RECEIVING_ITEM_JUNCTION'		, 'cms_sms_inventory_receiving_item_junction');
	define('SMS_REQUISITION' 							, 'cms_sms_requisition');
	define('SMS_REQUISITION_DEMAND_ITEM_JUNCTION'		, 'cms_sms_requisition_demand_item_junction');
	define('SMS_ISSUANCE' 								, 'cms_sms_issuance');
	define('SMS_ISSUANCE_REQUISITION_ITEM_JUNCTION'		, 'cms_sms_issuance_requisition_item_junction');
	define('SMS_LOCATION' 								, 'cms_sms_location');
	define('SMS_LOGS' 									, 'cms_sms_logs');
	

	define("SITE_URL", "https://oric.mul.edu.pk/");
//--------------------------------------------------
	$ip	  							= (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != '') ? $_SERVER['REMOTE_ADDR'] : '';
	$do	  							= (isset($_REQUEST['do']) && $_REQUEST['do'] != '') ? $_REQUEST['do'] : '';
	$srch	  						= (isset($_REQUEST['srch']) && $_REQUEST['srch'] != '') ? $_REQUEST['srch'] : '';
	$view 							= (isset($_REQUEST['view']) && $_REQUEST['view'] != '') ? $_REQUEST['view'] : '';
	$page							= (isset($_REQUEST['page']) && $_REQUEST['page'] != '') ? $_REQUEST['page'] : '';
	$Limit							= (isset($_REQUEST['Limit']) && $_REQUEST['Limit'] != '') ? $_REQUEST['Limit'] : '';
//--------------------------------------------------
	define('ONESIGNAL_APP_ID'		, '');
	define('ONESIGNAL_REST_KEY'		, '');

	define('LMS_IP'					, $ip);
	define('LMS_DO'					, $do);
	define('LMS_EPOCH'				, date("U"));
	define('LMS_VIEW'				, $view);
	define('TITLE_HEADER'			, 'Admin Panel - Minhaj University Lahore');
	define("SITE_NAME"				, "Admin Panel - Minhaj University Lahore");
	define("SITE_ADDRESS"			, "");
	define("COPY_RIGHTS"			, "Minhaj Internet Bureau");
	define("COPY_RIGHTS_ORG"		, "&copy; ".date("Y")." - All Rights Reserved.");
	define("COPY_RIGHTS_URL"		, "https://www.facebook.com/MinhajUniversityLahore/");

