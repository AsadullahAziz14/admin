<?php
//----------------------------------------------------
	error_reporting(E_ALL);
	ob_start();
	ob_clean();
//----------------------------------------------------

	define('LMS_HOSTNAME'			, 'localhost');
	define('LMS_NAME'				, 'obe_database');
	// define('LMS_NAME'				, 'sms');
	// define('LMS_NAME'				, 'mul');
	define('LMS_USERNAME'			, 'root');
	define('LMS_USERPASS'			, '');

//-----------------DB Tables ------------------------
	// define('ADMINS'										, 'mul_admins');
	define('CONTACT_INQUIRY' 							, 'mul_contact_inquiry');
	define('EVENT_INQUIRY'								, 'mul_event_inquiry');
	define('GALLERY'									, 'mul_gallery');
	define('LOGFILE' 									, 'mul_logfile');
	define('NOTIFICATION'								, 'mul_app_notification');
	define('POSTS' 										, 'mul_posts');
	define('POSTS_CATS' 								, 'mul_post_category');
	define('SLIDER' 									, 'mul_slider');
	define('TESTIMONIAL' 								, 'mul_testimonial');
	define('WEBSITES' 			    					, 'websites');
	define('SLIDER_WEB' 								, 'slider_web');

//---------------------- CMS Tables ----------------------
	define('ADMINS'										, 'cms_admins');
	define('DEPTS' 										, 'cms_departments');
	define('EMPLYS' 									, 'cms_employees');
	define('FACULTIES'									, 'cms_faculties');
	define('COURSES'									, 'cms_courses');
	define('PROGRAMS'									, 'cms_programs');
	define('PROGRAM_CATS'								, 'cms_programs_categories');
	define('STUDENTS'									, 'cms_students');
	define('COURSES_ASSIGNMENTS'						, 'cms_courses_assignments');
	define('COURSES_ASSIGNMENTSPROGRAM'					, 'cms_courses_assignmentsprogram');
	define('COURSES_ANNOUCEMENTS'						, 'cms_courses_annoucements');
	define('CAMPUSES'									, 'cms_campuses');
	define('SETTINGS'									, 'cms_settings');
	define('TIMETABLE'									, 'cms_timetable');
	define('TIMETABLE_DETAILS'							, 'cms_timetable_details');
	define('TIMETABLE_ROOMS'							, 'cms_timetable_rooms');
	define('TIMETABLE_PERIODS'							, 'cms_timetable_periods');
	define('COURSES_INFO'								, 'cms_courses_info');
	define('DESIGNATIONS'								, 'cms_designations');

//--------------------- OBE Tables ----------------------
	define('OBE_DOMAINS'								, 'cms_obe_domains');
	define('OBE_DOMAIN_LEVELS'							, 'cms_obe_domain_levels');
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

// --------------------- SMS Tables ------------------
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

	// DSA Tables
	define('DSA_APPLICATIONS' 									, 'cms_dsa_applications');
	define('DSA_APPLICATIONS_LOG' 								, 'cms_dsa_application_log');
	define('DSA_APPLICATIONS_FORWARD' 							, 'cms_dsa_application_forward');
	define('DSA_APPLICATIONS_REPEAT_COURSES' 					, 'cms_dsa_application_repeat_courses');


	

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

