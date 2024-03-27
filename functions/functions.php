<?php 
//--------------- Status ------------------
$admstatus = array (
						array('status_id'=>1, 'status_name'=>'Active')		, array('status_id'=>0, 'status_name'=>'Inactive')
				   );
$ad_status = array (
						array('status_id'=>1, 'status_name'=>'Active')		, array('status_id'=>0, 'status_name'=>'Inactive')
				   );

function get_admstatus($id) {
	$listadmstatus= array (
							'1' => '<span class="label label-success" id="bns-status-badge">Active</span>', 
							'0' => '<span class="label label-danger" id="bns-status-badge">Inactive</span>');
	return $listadmstatus[$id];
}
//--------------- Status ------------------
$status = array (
						array('id'=>1, 'name'=>'Active')		, array('id'=>2, 'name'=>'Inactive')
				   );
function get_status($id) {
	$liststatus= array (
							'1' => '<span class="label label-success" id="bns-status-badge">Active</span>', 
							'2' => '<span class="label label-danger" id="bns-status-badge">Inactive</span>');
	return $liststatus[$id];
}

//--------------- Vendors Type ------------------
$vendorstype = array (
						  array('id'=>1, 'name'=>'Employees')
						, array('id'=>2, 'name'=>'Vendors') 		
				   );

function get_vendorstype($id) {
	$list	= array (
								  '1' => 'Employees'
								, '2' => 'Vendors'
							);
	return $list[$id];
}

//--------------- Vendors Batch Status ------------------
$batchstatus = array (
						  array('id'=>1, 'name'=>'Save & Hold')
						, array('id'=>2, 'name'=>'Verified')
						, array('id'=>3, 'name'=>'In-Process')
						, array('id'=>4, 'name'=>'Partially Paid')
						, array('id'=>5, 'name'=>'Paid')
				   	);

function get_batchstatus($id) {
	$list = array (
						  '1'	=> '<span class="label bg-warning-dark" id="bns-status-badge"> Save & Hold</span>'
						, '2'	=> '<span class="label bg-info-dark" id="bns-status-badge">Verified</span>'
						, '3'	=> '<span class="label bg-orange" id="bns-status-badge">In-Process</span>'
						, '4'	=> '<span class="label bg-success" id="bns-status-badge">Partially Paid</span>'
						, '5'	=> '<span class="label bg-success-dark" id="bns-status-badge">Paid</span>'
					);
	return $list[$id];
}


//--------------- Complaint Types ------------------
$complainttype = array (
						  array('id'=>1, 'name'=>'Complaint')
						, array('id'=>2, 'name'=>'Suggestion')
				   	);

function get_complainttype($id) {
	$list = array (
						  '1'	=> 'Complaint'
						, '2'	=> 'Suggestion'
					);
	return $list[$id];
}

//--------------- Complaint Status ------------------
$complaintstatus = array (
						  array('id'=>1, 'name'=>'New')
						, array('id'=>2, 'name'=>'In-Process')
						, array('id'=>3, 'name'=>'Answered by Email')
						, array('id'=>4, 'name'=>'Completed')
						, array('id'=>5, 'name'=>'Archive')
				   	);

function get_complaintstatus($id) {
	$list = array (
						  '1'	=> '<span class="label bg-warning-dark" id="bns-status-badge"> New</span>'
						, '2'	=> '<span class="label bg-orange" id="bns-status-badge">In-Process</span>'
						, '3'	=> '<span class="label bg-info-dark" id="bns-status-badge">Answered by Email</span>'
						, '4'	=> '<span class="label bg-success-dark" id="bns-status-badge">Completed</span>'
						, '5'	=> '<span class="label label-danger" id="bns-status-badge">Archive</span>'
					);
	return $list[$id];
}


//--------------- Course Work / Thesis ------------------
$cwthesis = array (
						array('id'=>1, 'name'=>'Course Work')	, 
						array('id'=>2, 'name'=>'Thesis') 	
				   );

function get_cwthesis($id) {
	$listcwthesis= array (
							'1' => 'Course Work'	, 
							'2' => 'Thesis'	
							);
	return $listcwthesis[$id];
}
//--------------- Loan Status ------------------
$loanstatus = array (
						array('id'=>1, 'name'=>'Active')	, 
						array('id'=>2, 'name'=>'Inactive') 	,
						array('id'=>3, 'name'=>'Completed')
				   );

function get_loanstatus($id) {
	$listloanstatus= array (
							'1' => '<span class="label label-success" id="bns-status-badge">Active</span>'	, 
							'2' => '<span class="label label-danger" id="bns-status-badge">Inactive</span>'	,
							'3' => '<span class="label label-info" id="bns-status-badge">Completed</span>'
							);
	return $listloanstatus[$id];
}

//--------------- HostelStatus ------------------
$hostelstatus = array (
						array('id'=>1, 'name'=>'Active'), array('id'=>2, 'name'=>'Inactive'), array('id'=>3, 'name'=>'Left')
				   );
function get_hostelstatus($id) {
	$liststatus= array (
							'1' => '<span class="label label-success" id="bns-status-badge">Active</span>', 
							'2' => '<span class="label label-danger" id="bns-status-badge">Inactive</span>', 
							'3' => '<span class="label label-warning" id="bns-status-badge">Left</span>');
	return $liststatus[$id];
}

function get_hostelstatus1($id) {
	$liststatus= array (
							'1' => 'Active', 
							'2' => 'Inactive', 
							'3' => 'Left');
	return $liststatus[$id];
}


function get_admstatus1($id) {
	$liststatus= array (
							'1' => 'Active', 
							'2' => 'Inactive');
	return $liststatus[$id];
}
//--------------- Status ------------------
$struckoff = array (
						array('id'=>1, 'name'=>'Struck Off')		, array('id'=>2, 'name'=>'Inactive')
				   );
function get_struckoff($id) {
	$liststruckoff = array (
							'1' => '<span class="label label-warning" id="bns-status-badge">Struck Off</span>', 
							'2' => '<span class="label label-danger" id="bns-status-badge">Inactive</span>');
	return $liststruckoff[$id];
}

//Original or Duplicate Status
$originalDuplicate = array (
	array('id'=>1, 'name'=>'Original') , array('id'=>2, 'name'=>'Duplicate')
);
function get_card_type($id) {
	$listOriginalDuplicate = array (
			'1' => '<span class="label label-success" id="bns-status-badge">Original</span>', 
			'2' => '<span class="label label-warning" id="bns-status-badge">Duplicate</span>');
	return $listOriginalDuplicate[$id];
}

//Original, Duplicate or Revised Status
$originalDuplicateRevisedStatus = array (
	array('id'=>1, 'name'=>'Original') , array('id'=>2, 'name'=>'Duplicate') , array('id'=>3, 'name'=>'Revised')
);
function get_degree_transcript_type($id) {
	$listOriginalDuplicate = array (
			'1' => '<span class="label label-success" id="bns-status-badge">Original</span>', 
			'2' => '<span class="label label-warning" id="bns-status-badge">Duplicate</span>', 
			'3' => '<span class="label label-info" id="bns-status-badge">Revised</span>');
	return $listOriginalDuplicate[$id];
}

//--------------- Vaccine Name ------------------
$VaccineName = array (
						array('id'=>1, 'name'=>'AstraZeneca')			, 
						array('id'=>2, 'name'=>'Moderna') 				,
						array('id'=>3, 'name'=>'CanSino/PakVac')		,
						array('id'=>4, 'name'=>'Pfizer')				,
						array('id'=>5, 'name'=>'Sinopharm')				,
						array('id'=>6, 'name'=>'Sinovac (CoronaVac)')	,
						array('id'=>7, 'name'=>'Sputnik V')
				   );

function get_VaccineName($id) {
	$list	= array (
								'1' => 'AstraZeneca'		, 
								'2' => 'Moderna'			,
								'3' => 'CanSino/PakVac'		,
								'4' => 'Pfizer'				,
								'5' => 'Sinopharm'			,
								'6' => 'Sinovac (CoronaVac)',
								'7' => 'Sputnik V'
							);
	return $list[$id];
}
//--------------- Published/Pending ------------------
$publishedstatus = array (
						array('id'=>1, 'name'=>'Published'), 
						array('id'=>2, 'name'=>'Pending') ,
						array('id'=>3, 'name'=>'Rejected'),
						array('id'=>4, 'name'=>'Confirmed')
				   );

function get_publishedstatus($id) {
	$listpublishedstatus= array (
							'1' => '<span class="label label-success" id="bns-status-badge">Published</span>', 
							'2' => '<span class="label label-warning" id="bns-status-badge">Pending</span>',
							'3' => '<span class="label label-danger" id="bns-status-badge">Rejected</span>',
							'4' => '<span class="label label-info" id="bns-status-badge">Confirmed</span>');
	return $listpublishedstatus[$id];
}
//--------------- Advance Salary Status ------------------
$advancestatus = array (
						array('id'=>1, 'name'=>'Approved'), 
						array('id'=>2, 'name'=>'Pending')
				   );

function get_advancestatus($id) {
	$listadvancestatus= array (
			'1' => '<span class="label label-success" id="bns-status-badge">Approved</span>', 
			'2' => '<span class="label label-warning" id="bns-status-badge">Pending</span>');
	return $listadvancestatus[$id];
}

//Employee Status
$employeeStatusList = array (
	array('id'=>1, 'name'=>'Active'), 
	array('id'=>2, 'name'=>'Resigned') ,
	array('id'=>3, 'name'=>'Terminated'),
	array('id'=>4, 'name'=>'Relieved from Service'),
	array('id'=>5, 'name'=>'On Leave'),
	array('id'=>6, 'name'=>'In Active')
);

function get_employeestatus($id) {
	$listEmployeeStatus = array (
			'1' => '<span class="label label-success" id="bns-status-badge">Active</span>', 
			'2' => '<span class="label label-warning" id="bns-status-badge">Resigned</span>',
			'3' => '<span class="label label-danger" id="bns-status-badge">Terminated</span>',
			'4' => '<span class="label label-warning" id="bns-status-badge">Relieved from Service</span>',
			'5' => '<span class="label label-info" id="bns-status-badge">On Leave</span>',
			'6' => '<span class="label label-danger" id="bns-status-badge">In Active</span>');
	return $listEmployeeStatus[$id];
}
//--------------- Course Resources Category ------------------

$CourseResources = array (
						array('id'=>1, 'name'=>'Lecture Slides')		, 
						array('id'=>2, 'name'=>'Lesson Video')			, 
						array('id'=>3, 'name'=>'Google Drive Link')		, 
						array('id'=>4, 'name'=>'Web Links')				,
						array('id'=>5, 'name'=>'General Downloads')	
						
				   );

function get_CourseResources1($id) {
	
	$list = array (
					'1' => '<span class="label label-success" id="bns-status-badge" style="background:#0672B3 !important;">
								Lecture Slides
							</span>'			, 
					'2' => '<span class="label label-success" id="bns-status-badge" style="background:#0D928F !important;">
								Lesson Video
							</span>'			, 
					'3' => '<span class="label label-success" id="bns-status-badge" style="background:#5C0A86 !important;">
								Google Drive Link
							</span>'			,
					'4' => '<span class="label label-success" id="bns-status-badge" style="background:#CE8802 !important;">
								Web Links
							</span>'			,
					'5' => '<span class="label label-success" id="bns-status-badge" style="background:#5B5B5B !important;">
								General Downloads
							</span>'	
				 );
	
	return $list[$id];
}

function get_CourseResources($id) {
	
	$list = array (
					'1' => 'Lecture Slides'		, 
					'2' => 'Lesson Video'		, 
					'3' => 'Google Drive Link'	,
					'4' => 'Web Links'			,
					'5' => 'General Downloads'	
				 );
	return $list[$id];
}

//--------------- Online Admission Status ------------------
$onlinetatus = array (
						array('id'=>1, 'name'=>'New')				, 
						array('id'=>3, 'name'=>'Accepted')			, 
						array('id'=>4, 'name'=>'Rejected')			,
						array('id'=>5, 'name'=>'Low-Merit')			,
						array('id'=>6, 'name'=>'Documents Issue')	,
						array('id'=>7, 'name'=>'Test Pending')		,
						array('id'=>8, 'name'=>'Test Failed')		,
						array('id'=>9, 'name'=>'Result Waiting')	,
						array('id'=>10, 'name'=>'Migration Case')	,
						array('id'=>11, 'name'=>'5th Semester')		,
						array('id'=>12, 'name'=>'Not Interested')	,
						array('id'=>2, 'name'=>'Pending')		 	,
						array('id'=>13, 'name'=>'Duplicate Apply')	
						
						
						
				   );

function get_onlinetatus($id) {
	$list = array (
					'1' => '<span class="label label-success" id="bns-status-badge">New</span>'			, 
					'2' => '<span class="label label-warning" id="bns-status-badge">Pending</span>'		, 
					'3' => '<span class="label label-info" id="bns-status-badge">Accepted</span>'		,
					'4' => '<span class="label label-danger" id="bns-status-badge">Rejected</span>'		,
					'5' => '<span class="label label-danger" id="bns-status-badge" style="background:#B39D00 !important;">Low-Merit</span>'			,	
					'6' => '<span class="label label-danger" id="bns-status-badge" style="background:#E96B10 !important;">Documents Issue</span>'	,
					'7' => '<span class="label label-danger" id="bns-status-badge" style="background:#A83C0F !important;">Test Pending</span>'		,
					'8' => '<span class="label label-danger" id="bns-status-badge" style="background:#F91323 !important;">Test Failed</span>'		,
					'9' => '<span class="label label-danger" id="bns-status-badge" style="background:#A83C0F !important;">Result Waiting</span>'	,
					'10' => '<span class="label label-danger" id="bns-status-badge" style="background:#A83C0F !important;">Migration Case</span>'	,
					'11' => '<span class="label label-danger" id="bns-status-badge" style="background:#A83C0F !important;">5th Semester</span>'	,
					'12' => '<span class="label label-danger" id="bns-status-badge" style="background:#f00 !important;">Not Interested</span>'	,
					'13' => '<span class="label label-danger" id="bns-status-badge" style="background:#f00 !important;">Duplicate Apply</span>'		,
				 );
	return $list[$id];
}

function get_onlinetatus1($id) {
	
	$list = array (
					'1' => 'New'			, 
					'2' => 'Pending'		, 
					'3' => 'Accepted'		,
					'4' => 'Rejected'		,
					'5' => 'Low-Merit'		,	
					'6' => 'Documents Issue',
					'7' => 'Test Pending'	,
					'8' => 'Test Failed'	,
					'9' => 'Result Waiting'	,
					'10' => 'Migration Case'	,
					'11' => '5th Semester'		,
					'12' => 'Not Interested'	,
					'13' => 'Duplicate Apply'	,
				 );
	
	return $list[$id];
	
}

//Discussion Status
$discussionstatus = array (
	array('id'=>1, 'name'=>'New')		, 
	array('id'=>2, 'name'=>'Pending')	, 
	array('id'=>3, 'name'=>'Accepted')	, 
	array('id'=>4, 'name'=>'Rejected')	
	
);
function get_discussionstatus($id) {
	$list = array (
	'1' => '<span class="label label-success" id="bns-status-badge">New</span>'			, 
	'2' => '<span class="label label-warning" id="bns-status-badge">Pending</span>'		, 
	'3' => '<span class="label label-info" id="bns-status-badge">Accepted</span>'	,
	'4' => '<span class="label label-danger" id="bns-status-badge">Rejected</span>'	
	);
	return $list[$id];
}
function get_discussionstatus1($id) {
	$list = array (
	'1' => 'New'			, 
	'2' => 'Pending'		, 
	'3' => 'Accepted'		,
	'4' => 'Rejected'	
	);
	return $list[$id];
}
//--------------- Repeat/Re-take/Migration/Summer Status ------------------
$repeatstatus = array (
	array('id'=>1, 'name'=>'Repeat')		, 
	array('id'=>3, 'name'=>'Migration')
	
);

function get_repeatstatus($id) {
	$list = array (
	'1' => '<span class="label label-success" id="bns-status-badge">Repeat</span>'		, 
	'2' => '<span class="label label-info" id="bns-status-badge">Re-take</span>'		, 
	'3' => '<span class="label label-purple" id="bns-status-badge">Migration</span>'	, 
	'4' => '<span class="label label-warning" id="bns-status-badge">Summer</span>'
	);
	return $list[$id];
}
//--------------- Studdent Status ------------------
$std_status = array (
						array('id'=>1, 'name'=>'New')		, 
						array('id'=>2, 'name'=>'Confirmed')	, 
						array('id'=>3, 'name'=>'Pending')	, 
						array('id'=>4, 'name'=>'Rejected')	,
						array('id'=>5, 'name'=>'Refund')	,
						array('id'=>6, 'name'=>'Completed')	,
						array('id'=>7, 'name'=>'Provisionally Admitted'),
						array('id'=>8, 'name'=>'Withdraw'),
						array('id'=>9, 'name'=>'Freeze') ,
						array('id'=>10, 'name'=>'Provisionally Completed'),
						array('id'=>11, 'name'=>'Degree Issued'),
						array('id'=>12, 'name'=>'Transcript Issued')
						
				   );

function get_stdstatus($id) {
	$liststdstatus= array (
							'1' => '<span class="label label-success" id="bns-status-badge">New</span>'	, 
							'2' => '<span class="label label-info" id="bns-status-badge">Confirmed</span>'	, 
							'3' => '<span class="label label-warning" id="bns-status-badge">Pending</span>'	,
							'4' => '<span class="label label-danger" id="bns-status-badge">Rejected</span>'	,
							'5' => '<span class="label label-warning" id="bns-status-badge">Refund</span>'	,
							'6' => '<span class="label label-info" id="bns-status-badge">Completed</span>'	,
							'7' => '<span class="label label-info" id="bns-status-badge">Provisionally Admitted</span>',
							'8' => '<span class="label label-danger" id="bns-status-badge">Withdraw</span>'	,
							'9' => '<span class="label label-danger" id="bns-status-badge">Freeze</span>'	,
							'10' => '<span class="label label-warning" id="bns-status-badge">Provisionally Completed</span>',
							'11' => '<span class="label label-info" id="bns-status-badge">Degree Issued</span>'	, 
							'12' => '<span class="label label-info" id="bns-status-badge">Transcript Issued</span>'	, 
						  );
	return $liststdstatus[$id];
}
function get_stdstatus1($id) {
	$liststdstatus= array (
							'1' => 'New'		, 
							'2' => 'Confirmed'	, 
							'3' => 'Pending'	,
							'4' => 'Rejected'	,
							'5' => 'Refund'		,
							'6' => 'Completed'	,
							'7' => 'Provisionally Admitted'	,
							'8' => 'Withdraw'	,
							'9' => 'Freeze'		,
							'10' => 'Provisionally Completed'	,
							'11' => 'Degree Issued'	,
							'12' => 'Transcript Issued'	
						  );
	return $liststdstatus[$id];
}

//Bridging/5th Semester Status
$bridging5thSatusArray = array (
	array('id'=>1, 'name'=>'Bridging')		, 
	array('id'=>2, 'name'=>'5th Semester')
	
);
//--------------- Question difficulty level ------------------
$difficultylevel  = array (
						array('id'=>1, 'name'=>'Basic')			, 
						array('id'=>2, 'name'=>'Intermediate')	, 
						array('id'=>3, 'name'=>'Advance')	
						
				   );

function get_difficultylevel($id) {
	$list = array (
					'1' => '<span class="label label-info" id="bns-status-badge">Basic</span>'				, 
					'2' => '<span class="label label-warning" id="bns-status-badge">Intermediate</span>'	, 
					'3' => '<span class="label label-danger" id="bns-status-badge">Advance</span>'	
				 );
	return $list[$id];
}

function get_difficultylevel1($id) {
	$list = array (
					'1' => 'Basic'			, 
					'2' => 'Intermediate'	, 
					'3' => 'Advance'		
				 );
	return $list[$id];
}


//--------------- Quiz Question Type ------------------

$questiontype = array (
						array('id'=>1, 'name'=>'Multiple Choice')	, 
						array('id'=>2, 'name'=>'True / False')		, 
						array('id'=>3, 'name'=>'Descriptive Question')

					);

function get_questionid($id) {

		$list = array (
						'Multiple Choice' => '1'		, 
						'True / False' => '2'			, 
						'Descriptive Question' => '3'	
		);
	
	return $list[$id];
}

function get_questiontype($id) {

		$list = array (
						'1' => 'Multiple Choice'		, 
						'2' => 'True / False'			, 
						'3' => 'Descriptive Question'	
		);
	
	return $list[$id];
}


//--------------- Installment Period ------------------
$instperiod = array (
						array('id'=>1, 'name'=>'Monthly')		, 
						array('id'=>2, 'name'=>'Two Months')	, 
						array('id'=>3, 'name'=>'Three Months')	
				   );

function get_instperiod($id) {
	$listinstperiod= array (
							'1' => 'Monthly'		, 
							'2' => 'Two Months'		, 
							'3' => 'Three Months'	
						  );
	return $listinstperiod[$id];
}

//--------------- Tax File Status------------------
$taxlist = array (
						array('id'=>1, 'name'=>'Filer')		, 
						array('id'=>2, 'name'=>'Non Filer')		
				   );

function get_taxstatus($id) {
	$listtaxstatus = array (
							'1' => 'Filer'		, 
							'2' => 'Non Filer'			
						  );
	return $listtaxstatus[$id];
}

//--------------- Coupon Type ------------------
$coupontype = array (
						array('id'=>1, 'name'=>'Alumni')		, 
						array('id'=>2, 'name'=>'Student')		,
						array('id'=>3, 'name'=>'Tehreek')		
				   );

function get_coupontype($id) {
	$listtaxstatus = array (
							'1' => 'Alumni'		, 
							'2' => 'Student'	,		
							'3' => 'Tehreek'			
						  );
	return $listtaxstatus[$id];
}


//--------------- Credit Debit ------------------
$creditdebit = array (
						array('id'=>1, 'name'=>'Credit')		, 
						array('id'=>2, 'name'=>'Debit')		
				   );

function get_creditdebit($id) {
	$listcreditdebit = array (
							'1' => 'Credit'		, 
							'2' => 'Debit'			
						  );
	return $listcreditdebit[$id];
}

//--------------- API Type------------------
$apitype = array (
						array('id'=>1, 'name'=>'REST')		, 
						array('id'=>2, 'name'=>'SOAP')		
				   );

function get_apitype($id) {
	$listapitype = array (
							'1' => 'REST'		, 
							'2' => 'SOAP'			
						  );
	return $listapitype[$id];
}

//Authorities
$authority = array (
						array('id'=>1, 'name'=>'BOG')		, 
						array('id'=>2, 'name'=>'VC')		,
						array('id'=>5, 'name'=>'NBC')		,
						array('id'=>3, 'name'=>'Principal')	,
						array('id'=>4, 'name'=>'Vice Principal')
				   );

function get_authority($id) {
	$listauthority = array (
							'1' => 'BOG'				, 
							'2' => 'VC'					,
							'3' => 'Principal'			,
							'4' => 'Vice Principal'		,
							'5' => 'NBC'
						  );
	return $listauthority[$id];
}
function get_authority_complete($id) {
	$listauthority = array (
							'1' => 'Competent Authority'		, 
							'2' => 'Vice Chancellor'			
						  );
	return $listauthority[$id];
}

//Concession Types
$concessiontype = array (
						array('id'=>1, 'name'=>'Tuition Fees')		, 
						array('id'=>2, 'name'=>'Total Package')		
				   );

function get_concessiontype($id) {
	$list = array (
							'1' => 'Tuition Fees'		, 
							'2' => 'Total Package'			
						  );
	return $list[$id];
}
//--------------- Inquiry Status ------------------
$midstatus = array (
						array('id'=>1, 'name'=>'Not Publish')		, 
						array('id'=>2, 'name'=>'Publish')	
				   );

function get_midstatus($id) {
	$listmidstatus= array (
							'1' => '<span class="label label-warning" id="bns-status-badge">Not Publish</span>'		, 
							'2' => '<span class="label label-info" id="bns-status-badge">Publish</span>'	
						  );
	return $listmidstatus[$id];
}

//--------------- Result Status ------------------
$resultstatus = array (
						array('id'=>1, 'name'=>'Published')		, 
						array('id'=>2, 'name'=>'Pending')		, 
						array('id'=>3, 'name'=>'Approved')	
				   );

function get_resultstatus($id) {
	$listresultstatus= array (
							'1' => '<span class="label label-success" id="bns-status-badge">Published</span>', 
							'2' => '<span class="label label-warning" id="bns-status-badge">Pending</span>'	, 
							'3' => '<span class="label label-success" id="bns-status-badge">Approved</span>'	
							
						  );
	return $listresultstatus[$id];
}

//--------------- Inquiry Status ------------------
$inq_status = array (
						array('id'=>1, 'name'=>'New Inquiry')		, 
						array('id'=>2, 'name'=>'Prospectus Sold')	, 
						array('id'=>4, 'name'=>'Forum Submission')	, 
						array('id'=>3, 'name'=>'Pending')
				   );

function get_inqstatus($id) {
	$listinqstatus= array (
							'1' => '<span class="label label-success" id="bns-status-badge">New Inquiry</span>'		, 
							'2' => '<span class="label label-info" id="bns-status-badge">Prospectus Sold</span>'	, 
							'4' => '<span class="label label-info" id="bns-status-badge">Forum Submission</span>'	, 
							'3' => '<span class="label label-warning" id="bns-status-badge">Pending</span>'
						  );
	return $listinqstatus[$id];
}

function get_inqstatus1($id) {
	$listinqstatus= array (
							'1' => 'New Inquiry'		, 
							'2' => 'Prospectus Sold'	, 
							'3' => 'Pending'
						  );
	return $listinqstatus[$id];
}

//--------------- fees Status ------------------
$fee_status = array ( 
						array('id'=>2, 'name'=>'Paid')		, 
						array('id'=>3, 'name'=>'Pending')	, 
						array('id'=>4, 'name'=>'Arrears')	
				   );

function get_feestatus($id) {
	$listfeestatus= array (
							'2' => '<span class="label label-info" id="bns-status-badge">Paid</span>'		, 
							'3' => '<span class="label label-warning" id="bns-status-badge">Pending</span>'	,
							'4' => '<span class="label label-danger" id="bns-status-badge">Arrears</span>'	
						  );
	return $listfeestatus[$id];
}

function get_feestatus1($id) {
	$listfeestatus= array ( 
							'2' => 'Paid'		, 
							'3' => 'Pending'	,
							'4' => 'Unpaid'		
						  );
	return $listfeestatus[$id];
}

//--------------- Library Status ------------------
$lby_status = array (
						array('id'=>1, 'name'=>'Issued')	, array('id'=>2, 'name'=>'Return'), 
						array('id'=>3, 'name'=>'Pending')	, array('id'=>4, 'name'=>'Over Date')
				   );

function get_lbystatus($id) {
	$listlbystatus = array (
							'1' => '<span class="label label-success" id="bns-status-badge">Issued</span>'	, 
							'2' => '<span class="label label-info" id="bns-status-badge">Return</span>'		, 
							'3' => '<span class="label label-warning" id="bns-status-badge">Pending</span>'	,
							'4' => '<span class="label label-danger" id="bns-status-badge">Over Date</span>'
						  );
	return $listlbystatus[$id];
}

function get_lbystatus1($id) {
	$listlbystatus = array (
							'1' => 'Issued'		, 
							'2' => 'Return'		, 
							'3' => 'Pending'	,
							'4' => 'Over Date'
						  );
	return $listlbystatus[$id];
}

//--------------- Subject Types ------------------
$curstypes = array (
					array('id'=>1, 'name'=>'Required'),
					array('id'=>2, 'name'=>'Elective'),
					array('id'=>3, 'name'=>'General')
				   );

function get_curstypes($id) {
	$listcurstypes = array (
							'1'	=> 'Required',
							'2'	=> 'Elective',
							'3'	=> 'General'
							);
	return $listcurstypes[$id];
}

function get_curstypes12($id) {
	$listcurstypes12 = array (
							'Required'	=> '1',
							'Elective'	=> '2',
							'General'	=> '3'
							);
	return $listcurstypes12[$id];
}

//--------------- Admins Rights ----------
$admrights = array (
					array('rgt_id'=>1, 'rgt_name'=>'Administrator'),
					array('rgt_id'=>2, 'rgt_name'=>'Accountant')
				   );

function get_admrights($id) {
	$listadmrights = array (
							'1'	=> 'Administrator',
							'2'	=> 'Accountant'
							);
	return $listadmrights[$id];
}

//--------------- Admins Types ----------
$admtypes = array (
					array('id'=>1, 'name'=>'Super Administrator'),
					array('id'=>2, 'name'=>'Campus Administrator')
				   );

$admtypes1 = array (
					array('id'=>1, 'name'=>'Super Administrator')	,
					array('id'=>2, 'name'=>'Campus Administrator')	,
					array('id'=>3, 'name'=>'Librarian')				,
					array('id'=>4, 'name'=>'Hostel Warden')			,
					array('id'=>5, 'name'=>'Finance Director')		,
					array('id'=>6, 'name'=>'Accountant')			,
					array('id'=>7, 'name'=>'Clerk')					,
					array('id'=>8, 'name'=>'Dean')					,
					array('id'=>9, 'name'=>'HOD')					
					
				   );

function get_admtypes($id) {
	$listadmtypes = array (
							'1'	=> 'Super Administrator'		,
							'2'	=> 'Campus Administrator'		,
							'3'	=> 'Librarian'					,
							'4'	=> 'Hostel Warden'				,
							'5'	=> 'Finance Director'			,
							'6'	=> 'Accountant'					,
							'7'	=> 'Clerk'						,
							'8'	=> 'Dean'						,
							'9'	=> 'HOD'
							);
	return $listadmtypes[$id];
}

//--------------- inquiry Types----------
$inquirytype = array (
					array('id'=>1,  'name'=>'Walked In Inquiry'),
					array('id'=>2,  'name'=>'Telephone Inquiry')
				   );

function get_inquirytype($id) {
	$listinquirytype = array (
							'1'		=> 'Walked In Inquiry',
							'2'		=> 'Telephone Inquiry'
							);
	return $listinquirytype[$id];
}

//Source of Inquiry
$inquirysrc = array (
					array('id'=>1,  'name'=>'Newspaper Ad.'),
					array('id'=>2,  'name'=>'Through Website'),
					array('id'=>3,  'name'=>'Leaflet'),
					array('id'=>4,  'name'=>'SMS'),
					array('id'=>5,  'name'=>'E-Mail'),
					array('id'=>6,  'name'=>'Social Media'),
					array('id'=>7,  'name'=>'Through a friend'),
					array('id'=>13,  'name'=>'Old Student'),
					array('id'=>8,  'name'=>'Just walked In'),
					array('id'=>10, 'name'=>'TVC/Radio/Cable'),
					array('id'=>11, 'name'=>'Referred by Tehreek Member'),
					array('id'=>12, 'name'=>'Referred by Staff Member'),
					array('id'=>14, 'name'=>'Billboard'),
					array('id'=>15, 'name'=>'Poll Streamer'),
					array('id'=>9,  'name'=>'Other')
				   );

function get_inquirysrc($id) {
	$listinquirysrc = array (
							'1'		=> 'Newspaper Ad.',
							'2'		=> 'Through Website',
							'3'		=> 'Leaflet',
							'4'		=> 'SMS',
							'5'		=> 'E-Mail',
							'6'		=> 'Social Media',
							'7'		=> 'Through a friend',
							'8'		=> 'Just walked In',
							'10'	=> 'TVC/Radio/Cable',
							'11'	=> 'Referred by Tehreek Member',
							'12'	=> 'Referred by Staff Member',
							'13'	=> 'Old Student',
							'14'	=> 'Billboard',
							'15'	=> 'Poll Streamer'
							);
	return $listinquirysrc[$id];
}

//------------ Print Media ---------------------------
$PrintMedia = array (
					array('id'=>1,  'name'=>'Express News')			,
					array('id'=>2,  'name'=>'Daily Dunya')			,
					array('id'=>3,  'name'=>'Daily Nawa-e-Waqat')	,
					array('id'=>4,  'name'=>'Daily City 42')		,
					array('id'=>5,  'name'=>'Daily Jang')			,
					array('id'=>6,  'name'=>'The News')				,
					array('id'=>7,  'name'=>'Daily 92')				,
					array('id'=>8,  'name'=>'Daily Ausaf')			,
					array('id'=>9,  'name'=>'Road Campaign')
				   );

function get_PrintMedia($id) {
	$listPrintMedia = array (
							'1'		=> 'Express News'				,
							'2'		=> 'Daily Dunya'				,
							'3'		=> 'Daily Nawa-e-Waqat'			,
							'4'		=> 'Daily City 42'				,
							'5'		=> 'Daily Jang'					,
							'6'		=> 'The News'					,
							'7'		=> 'Daily 92'					,
							'8'		=> 'Daily Ausaf'				,
							'9'		=> 'Road Campaign'
							);
	return $listPrintMedia[$id];
}

//------------ Electronic Media ---------------------------
$ElectronicMedia = array (
					array('id'=>10,  'name'=>'Express News')	,
					array('id'=>11,  'name'=>'ARY News')		,
					array('id'=>12,  'name'=>'Daily Dunya')		,
					array('id'=>13,  'name'=>'24 News')			,
					array('id'=>14,  'name'=>'Daily City 42')	,
					array('id'=>15,  'name'=>'Channel 24')		,
					array('id'=>16,  'name'=>'LHR News HD')		,
					array('id'=>17,  'name'=>'Cable Ad.')		,
					array('id'=>18,  'name'=>'Radio')
				   );

function get_ElectronicMedia($id) {
	$listMedia = array (
							'10'		=> 'Express News'			,
							'11'		=> 'ARY News'				,
							'12'		=> 'Daily Dunya'			,
							'13'		=> '24 News'				,
							'14'		=> 'Daily City 42'			,
							'15'		=> 'Channel 24'				,
							'16'		=> 'LHR News HD'			,
							'17'		=> 'Cable Ad.'				,
							'18'		=> 'Radio'
							);
	return $listMedia[$id];
}

//------------ Social Media ---------------------------
$SocialMedia = array (
					array('id'=>19,  'name'=>'Facebook')				,
					array('id'=>28,  'name'=>'Whatsapp')				,
					array('id'=>20,  'name'=>'Instagram')				,
					array('id'=>21,  'name'=>'Twitter')					,
					array('id'=>22,  'name'=>'Youtube')					,
					array('id'=>23,  'name'=>'LED inside Campus')		,
					array('id'=>24,  'name'=>'From MUL Students')		,
					array('id'=>25,  'name'=>'Referred by a Friend')	,
					array('id'=>26,  'name'=>'Walk In')					,
					array('id'=>27,  'name'=>'Other')
				   );

function get_SocialMedia($id) {
	$listMedia = array (
							'19'	=> 'Facebook'				,
							'28'	=> 'Whatsapp'				,
							'20'	=> 'Instagram'				,
							'21'	=> 'Twitter'				,
							'22'	=> 'Youtube'				,
							'23'	=> 'LED inside Campus'		,
							'24'	=> 'From MUL Students'		,
							'25'	=> 'Referred by a Friend'	,
							'26'	=> 'Walk In'				,
							'27'	=> 'Other'
							);
	return $listMedia[$id];
}
//--------------- Source of inquiry ----------
$promotestatus = array (
					array('id'=>1,  'name'=>'Promoted')					,
					array('id'=>2,  'name'=>'Not Promoted')				,
					array('id'=>3,  'name'=>'1st Probation')			,
					array('id'=>4,  'name'=>'2nd Probation')			,
					array('id'=>5,  'name'=>'Provisionally Promoted')	,
					array('id'=>6,  'name'=>'Pass')						,
					array('id'=>7,  'name'=>'Fail')						,
					array('id'=>8,  'name'=>'Freeze')					,
					array('id'=>9,  'name'=>'Freeze/NP')				,
					array('id'=>10,  'name'=>'Freeze/1st P')			,
					array('id'=>11,  'name'=>'Freeze/2nd P')			,
					array('id'=>12,  'name'=>'RL/ill')
				   );

function get_promotestatus($id) {
	$listpromotestatus = array (
							'1'		=> 'Promoted'				,
							'2'		=> 'Not Promoted'			,
							'3'		=> '1st Probation'			,
							'4'		=> '2nd Probation'			,
							'5'		=> 'Provisionally Promoted'	,
							'6'		=> 'Pass'					,
							'7'		=> 'Fail'					,
							'8'		=> 'Freeze'					,
							'9'		=> 'Freeze/NP'				,
							'10'	=> 'Freeze/1st P'			,
							'11'	=> 'Freeze/2nd P'			,
							'12'	=> 'RL/ill'
							);
	return $listpromotestatus[$id];
}
//--------------- Hostel Registration ------------------
$reg_types = array (
						array('id'=>1, 'name'=>'Employee'), 
						array('id'=>2, 'name'=>'Student')
				   );

function get_regtypes($id) {
	$listregtypes= array (
							'1' => 'Employee', 
							'2' => 'Student');
	return $listregtypes[$id];
}
//--------------- Employee Types ------------------
$emplytypes = array (
						array('id'=>1, 'name'=>'Teaching'), 
						array('id'=>2, 'name'=>'Non-Teaching')
				    );

function get_emplytypes($id) {

	$listemplytypes = array (
								'1' => 'Teaching', 
								'2' => 'Non-Teaching');
	return $listemplytypes[$id];
}

//--------------- visiting ------------------
$visiting = array (
						array('id'=>1, 'name'=>'Permanent'), 
						array('id'=>2, 'name'=>'Visiting')
				    );

function get_visiting($id) {

	$lisvisiting = array (
								'1' => 'Permanent', 
								'2' => 'Visiting');
	return $lisvisiting[$id];
}

//--------------- Education Level ------------------
$edulevel = array (
						array('id'=>1, 'name'=>'Undergraduate')		, 
						array('id'=>2, 'name'=>'Graduate')			,
						array('id'=>3, 'name'=>'MS/M.Phil')			,
						array('id'=>4, 'name'=>'Ph.D')
				    );

function get_edulevel($id) {

	$listedulevel = array (
								'1' => 'Undergraduate'	, 
								'2' => 'Graduate'		,
								'3' => 'MS/M.Phil'		,
								'4' => 'Ph.D'		
						);
	return $listedulevel[$id];
}

//--------------- Payment Mode ------------------
$paymode = array (
						array('id'=>1, 'name'=>'Online Payment')	, 
						array('id'=>2, 'name'=>'Cheque')		
				   );

function get_paymode($id) {
	$listpaymode = array ('1' => 'Online Payment', '2' => 'Cheque');
	return $listpaymode[$id];
}

//--------------- Payment Types ------------------
$pay_types = array (
						array('id'=>1, 'name'=>'Bank')		, 
						array('id'=>2, 'name'=>'Cash')		, 
						array('id'=>3, 'name'=>'Cheque')	,
						array('id'=>4, 'name'=>'Finja')		,
						array('id'=>5, 'name'=>'Manual Paid'),
						array('id'=>6, 'name'=>'Donation'),
						array('id'=>7, 'name'=>'PayPro'),
						array('id'=>8, 'name'=>'PayFast')
				   );

function get_paytypes($id) {
	$listpaytypes = array ('1' => 'Bank', '2' => 'Cash', '3' => 'Cheque', '4' => 'Finja', '5' => 'Manual Paid', '6' => 'Donation', '7' => 'PayPro', '8' => 'PayFast');
	return $listpaytypes[$id];
}

//--------------- Degree Names ------------------
$degreename = array (
						array('id'=>1	, 'name'=>'Matric')			, 
						array('id'=>2	, 'name'=>'Intermediate') 	,
						array('id'=>3	, 'name'=>'Bachelor')		,
						array('id'=>4	, 'name'=>'Master')			,
						array('id'=>5	, 'name'=>'M.Phil / MS')	,
						array('id'=>7	, 'name'=>'BA/B.Sc.')		,
						array('id'=>6	, 'name'=>'Others<br>(HEC-LAT/GAT/NTS/GRE)')
				   );

function get_degreename($id) {
	$listregtypes= array (
							'1' => 'Matric'			, 
							'2' => 'Intermediate'	, 
							'3' => 'Bachelor'		, 
							'4' => 'Master'			,
							'5' => 'M.Phil / MS'	,
							'6' => 'Others<br>(HEC-LAT/GAT/NTS/GRE)'	,
							'7' => 'BA/B.Sc.'			
					);
	return $listregtypes[$id];
}

//--------------- Documents ------------------
$documentsname = array (
	array('id'=>1	, 'name'=>'Complete & Signed Application Form')			, 
	array('id'=>2	, 'name'=>'Matriculation Certificate') 					,
	array('id'=>3	, 'name'=>'Intermediate Certificate')					,
	array('id'=>4	, 'name'=>'Graduation Degree (if applicable)')			,
	array('id'=>5	, 'name'=>'Master Degree (if applicable)')				,
	array('id'=>6	, 'name'=>'Character Certificate')						,
	array('id'=>7	, 'name'=>'CNIC/B-Form Copy (Original to be seen)')		,
	array('id'=>8	, 'name'=>'Five photos (one attested on the book)')		, 
	array('id'=>9	, 'name'=>'Result Card NTS/Undertaking (for M.Phil)')	,
	array('id'=>10	, 'name'=>'MUL Registration #')							,
	array('id'=>12	, 'name'=>'Parent\'s CNIC')								,
	array('id'=>13	, 'name'=>'NOC')										,
	array('id'=>11	, 'name'=>'Others')
	
);

function get_documentsname($id) {
	$listdocumentsname = array (
				'1'  => 'Complete & Signed Application Form'					, 
				'2'  => 'Matriculation Certificate'								, 
				'3'  => 'Intermediate Certificate'								, 
				'4'  => 'Graduation Degree (if applicable)'						,
				'5'  => 'Master Degree (if applicable)'							,
				'6'  => 'Character Certificate'									,
				'7'  => 'CNIC Copy (Original to be seen)'						,
				'8'  => 'Five photos (one attested on the book)'				,
				'9'  => 'Result Card NTS/Undertaking (for M.Phil)'				,
				'10' => 'MUL Registration #'									,
				'11' => 'Others'												,
				'12' => 'Parent\'s CNIC'										,
				'13' => 'NOC'							
			);
	return $listdocumentsname[$id];
}

//--------------- Status Yes No ----------
$statusyesno = array (
						array('id'=>1, 'name'=>'Yes'), 
						array('id'=>0, 'name'=>'No')
				   );


function get_statusyesno($id) {
	
	$liststatusyesno = array (
								'1'	=> 'Yes',	'0'	=> 'No'
							 );
	return $liststatusyesno[$id];
}

function get_yesno1($id) {

	$listyesno= array (
							'1' => '<span class="label label-info" id="bns-status-badge">Yes</span>'	, 
							'2' => '<span class="label label-warning" id="bns-status-badge">No</span>'	
						  );
	return $listyesno[$id];

}

function get_yesno12($id) {

	$listyesno= array (
							'1' => 'Yes'	, 
							'2' => 'No'	
						  );
	return $listyesno[$id];

}


function get_statusyesno12($id) {
	
	$liststatusyesno12 = array (
								'Yes'	=> '1',	'No'	=> '0'
							 );
	return $liststatusyesno12[$id];
}

function get_statusyesnobg($id) {
	
	$liststatusyesnobg = array (
								'1'	=> '<span class="label label-success" id="bns-status-badge">Yes</span>',	
								'0'	=> '<span class="label label-warning" id="bns-status-badge">No</span>'
							 );
	return $liststatusyesnobg[$id];
}

//--------------- Status Student Affairs ----------
$stdaffairs = array (
						array('id'=>1, 'name'=>'New')		, 
						array('id'=>2, 'name'=>'Delivered')	, 
						array('id'=>3, 'name'=>'Verified')	, 
						array('id'=>4, 'name'=>'Pending')	,					
						array('id'=>5, 'name'=>'Rejected')
				   );

function get_stdaffairs($id) {

	$liststdaffairs= array (
							'1' => '<span class="label label-success" id="bns-status-badge">New</span>'		, 
							'2' => '<span class="label label-info" id="bns-status-badge">Delivered</span>'	, 
							'3' => '<span class="label label-info" id="bns-status-badge">Verified</span>'	, 
							'4' => '<span class="label label-warning" id="bns-status-badge">Pending</span>'	,
							'5' => '<span class="label label-danger" id="bns-status-badge">Rejected</span>'
						  );
	return $liststdaffairs[$id];

}
//---------------Student Affairs Types ----------
$stdaffairstypes = array (
							array('id'=>1, 'name'=>'Transcript')	, 
							array('id'=>2, 'name'=>'Degree')		, 
							array('id'=>3, 'name'=>'Verification')	, 
							array('id'=>4, 'name'=>'General')
				   );

function get_stdaffairstypes($id) {

	$liststdaffairstypes= array (
									'1' => 'Transcript'		, 
									'2' => 'Degree'			, 
									'3' => 'Verification'	,
									'4' => 'General'
						  		);
	return $liststdaffairstypes[$id];

}

//--------------- Action Through ----------
$actionthrough = array (
				array('id'=>1, 'name'=>'Email')			, 
				array('id'=>2, 'name'=>'Telephonic')	, 
				array('id'=>3, 'name'=>'Others')
			   );

function get_actionthrough($id) {
	$listactionthrough = array ('1'	=> 'Email',	'2'	=> 'Telephonic',	'3'	=> 'Others');
	return $listactionthrough[$id];
}


//--------------- Status Yes No ----------
$yesno = array (
				array('id'=>1, 'name'=>'Yes'), 
				array('id'=>2, 'name'=>'No')
			   );

function get_yesno($id) {
	
	$listyesno = array ('1'	=> 'Yes',	'2'	=> 'No');
	return $listyesno[$id];
}

//--------------- Status Yes No ----------
$prospectusyesno = array (
	array('id'=>1, 'name'=>'Yes'), 
	array('id'=>2, 'name'=>'No'), 
	array('id'=>3, 'name'=>'NA')
   );

function get_prospectus_yesno($id) {

	$listyesno = array ('1'	=> 'Yes', '2' => 'No', '3' => 'NA');
	return $listyesno[$id];
}

//--------------- Deficiency Status ----------
$deficiencystatus = array (
						array('id'=>1, 'name'=>'Paid'), 
						array('id'=>0, 'name'=>'Not Paid'),
						array('id'=>2, 'name'=>'Fee Refund')
				   );

function get_deficiencystatus($id) {
	
	$listdeficiencystatus = array (
								'1'	=> '<span class="label label-success" id="bns-status-badge">Paid</span>',	
								'0'	=> '<span class="label label-danger" id="bns-status-badge">Not Paid</span>',
								'2'	=> '<span class="label label-warning" id="bns-status-badge">Fee Refund</span>'
							 );
	return $listdeficiencystatus[$id];
}
function get_deficiencystatus1($id) {
	
	$listdeficiencystatus = array (
								'1'	=> 'Paid',	
								'0'	=> 'Not Paid'
							 );
	return $listdeficiencystatus[$id];
}

//--------------- program Timing ----------
$programtiming = array (
						array('id'=>1, 'name'=>'Morning')	, 
						array('id'=>2, 'name'=>'Weekend')	, 
						array('id'=>4, 'name'=>'Evening')	, 
						array('id'=>3, 'name'=>'Both')
				   );

function get_programtiming($id) {
	
	$listprogramtiming = array (
								'1'	=> 'Morning'			,	
								'2'	=> 'Weekend'			,	
								'3'	=> 'Both'				,
								'4'	=> 'Evening'
							 );
	return $listprogramtiming[$id];
}


//--------------- program Timing ----------
$timetablereport = array (
						array('id'=>1, 'name'=>'Building Wise')		, 
						array('id'=>2, 'name'=>'Room Wise')			, 
						array('id'=>3, 'name'=>'Period Wise')		,
						array('id'=>4, 'name'=>'Teacher Wise')		,
						array('id'=>5, 'name'=>'Program Wise')		,
						array('id'=>6, 'name'=>'Department Wise')	,
						array('id'=>7, 'name'=>'Faculty Wise')
				   );

function get_timetablereport($id) {
	
	$listtimetablereport = array (
								'1'	=> 'Building Wise'		,	
								'2'	=> 'Room Wise'			,	
								'3'	=> 'Period Wise'		,
								'4'	=> 'Teacher Wise'		,
								'5'	=> 'Program Wise'		,
								'6'	=> 'Department Wise'	,
								'7'	=> 'Faculty Wise'	
							 );
	return $listtimetablereport[$id];
}


//--------------- forward ----------
$forwards = array (
						array('id'=>1, 'name'=>'All Directors / HODs /Dean / Principle') , 
						array('id'=>2, 'name'=>'Controller Examination')	, 
						array('id'=>3, 'name'=>'Director Academic')			,
						array('id'=>4, 'name'=>'HODs / Dean / Principle')
				   );

function get_forwards($id) {
	
	$listforwards = array (
								'1'	=> 'All Directors / HODs /Dean / Principle'	,	
								'2'	=> 'Controller Examination'			,	
								'3'	=> 'Director Academic'				,
								'4'	=> 'HODs / Dean / Principle' 
							 );
	return $listforwards[$id];
}


//--------------- program Class days ----------
$programclassdays = array (
						array('id'=>1, 'name'=>'Monday to Friday')		, 
						array('id'=>5, 'name'=>'Monday to Wednesday')	, 
						array('id'=>6, 'name'=>'Thursday to Saturday')	, 
						array('id'=>2, 'name'=>'Friday to Sunday')		, 
						array('id'=>3, 'name'=>'Saturday to Sunday')	,
						array('id'=>4, 'name'=>'Sunday')
				   );

function get_programclassdays($id) {
	
	$listprogramclassdays = array (
								'1'	=> 'Monday to Friday'			,	
								'2'	=> 'Friday to Sunday'			,	
								'3'	=> 'Saturday to Sunday'			,
								'4'	=> 'Sunday'						,
								'5'	=> 'Monday to Wednesday'		,
								'6'	=> 'Thursday to Saturday'
							 );
	return $listprogramclassdays[$id];
}

//--------------- Hostel Types ----------
$hosteltypes = array (
						array('id'=>1, 'name'=>'Boys')		, 
						array('id'=>2, 'name'=>'Girls')		, 
						array('id'=>3, 'name'=>'Employees')
				   );

function get_hosteltypes($id) {
	
	$listhosteltypes = array (
								'1'	=> 'Boys'				,	
								'2'	=> 'Girls'				,	
								'3'	=> 'Employees'
							 );
	return $listhosteltypes[$id];
}

//--------------- Salary transfer Status ----------
$salarystatus = array (
						  array('id'=>0, 'name'=>'Cleared')
						, array('id'=>2, 'name'=>'Paid')		
						, array('id'=>3, 'name'=>'Error')
						, array('id'=>4, 'name'=>'In-Process')
				   );

function get_salarystatus($id) {
	
	$list = array (
								  '0'	=> '<span class="label label-success" id="bns-status-badge">Cleared</span>'	
								, '2'	=> '<span class="label label-info" id="bns-status-badge">Paid</span>'				
								, '3'	=> '<span class="label label-danger" id="bns-status-badge">Error</span>'				
								, '4'	=> '<span class="label label-warning" id="bns-status-badge">In-Process</span>'				
							 );
	return $list[$id];
}
//--------------- Salary Heads ----------
$salaryhead = array (
						array('id'=>1, 'name'=>'Allowance')		, 
						array('id'=>2, 'name'=>'Deduction')		
				   );

function get_salaryhead($id) {
	
	$listsalaryhead = array (
								'1'	=> 'Allowance'				,	
								'2'	=> 'Deduction'				
							 );
	return $listsalaryhead[$id];
}
//--------------- Account Heads ----------
$accounthead = array (
						array('id'=>1, 'name'=>'Income')		, 
						array('id'=>2, 'name'=>'Expense')		
				   );

function get_accounthead($id) {
	
	$listaccounthead = array (
								'1'	=> 'Income'					,	
								'2'	=> 'Expense'				
							 );
	return $listaccounthead[$id];
}
//--------------- Absent or Present ----------
$absentpresent = array (
						array('id'=>1, 'name'=>'Absent')		, 
						array('id'=>2, 'name'=>'Present')		
				   );

function get_absentpresent($id) { 
	
	$listabsentpresent = array (
								'1'	=> '<span class="label label-danger" id="bns-status-badge">Absent</span>'		,	
								'2'	=> '<span class="label label-success" id="bns-status-badge">Present</span>'				
							 );
	return $listabsentpresent[$id];
}

//Range Of Leave
$leaverange = array (
						array('id'=>1, 'name'=>'First Half')		, 
						array('id'=>2, 'name'=>'Second Half')		,
						array('id'=>3, 'name'=>'Full Day')		
				   );

function get_leaverange($id) {
	
	$listleaverange = array (
								'1'	=> 'First Half'					,	
								'2'	=> 'Second Half'				,
								'3'	=> 'Full Day'				
							);
	return $listleaverange[$id];
}

//Sessions
$session = array(
				'Fall 2023' ,'Spring 2023' ,
				'Fall 2022' , 'Spring 2022' ,
				'Fall 2021' , 'Spring 2021' ,
				'Fall 2020' , 'Spring 2020' ,
				'Fall 2019'	, 'Spring 2019' ,
				'Fall 2018' , 'Spring 2018'	,
				'Fall 2017'	, 'Spring 2017'	,
				'Fall 2016'	, 'Spring 2016'	, 
				'Fall 2015'	, 'Spring 2015'	, 
				'Fall 2014'	, 'Spring 2014'	, 
				'Fall 2013'	, 'Spring 2013'	, 
				'Fall 2012'	, 'Spring 2012'	, 
				'Fall 2011'	, 'Spring 2011'	, 
				'Fall 2010'	, 'Spring 2010'	, 
				'Fall 2009'	, 'Spring 2009'	, 
				'Fall 2008'	, 'Spring 2008'	,
				'Fall 2007'	, 'Spring 2007'	,
				'Fall 2006'	, 'Spring 2006'	,
				'Fall 2005'	, 'Spring 2005'	,
				'Fall 2004'	, 'Spring 2004'	,
				'Fall 2003'	, 'Spring 2003'	,
				'Fall 2002'	, 'Spring 2002'
			);

function get_loopsessionid($id) {

	$listloopsession = array (
							'Fall 2023' 	=> '44'		,
							'Spring 2023' 	=> '43'		,   'Fall 2022' 	=> '42'		,   'Spring 2022' 	=> '41'		,
							'Fall 2021' 	=> '40'		,	'Spring 2021' 	=> '39'		,	'Fall 2020' 	=> '38'		,
							'Spring 2020' 	=> '37'		,	'Fall 2019' 	=> '36'		,	'Spring 2019' 	=> '35'		,
							'Fall 2018' 	=> '34'		,	'Spring 2018' 	=> '33'		,	'Fall 2017' 	=> '32'		,
							'Spring 2017'	=> '31'		,	'Fall 2016' 	=> '30'		, 	'Spring 2016' 	=> '29'		, 
							'Fall 2015' 	=> '28'		, 	'Spring 2015' 	=> '27'		,	'Fall 2014' 	=> '26'		,
							'Spring 2014' 	=> '25'		,	'Fall 2013' 	=> '24'		,	'Spring 2013' 	=> '23'		,
							'Fall 2012' 	=> '22'		,	'Spring 2012' 	=> '21'		,	'Fall 2011' 	=> '20'		,
							'Spring 2011' 	=> '19'		,	'Fall 2010' 	=> '18'		, 	'Spring 2010' 	=> '17'		, 
							'Fall 2009' 	=> '16'		, 	'Spring 2009' 	=> '15'		,	'Fall 2008' 	=> '14'		,
							'Spring 2008' 	=> '13'		,	'Fall 2007' 	=> '12'		,	'Spring 2007' 	=> '11'		,
							'Fall 2006' 	=> '10'		,	'Spring 2006' 	=> '9'		,	'Fall 2005' 	=> '8'		,
							'Spring 2005' 	=> '7'		,	'Fall 2004' 	=> '6'		, 	'Spring 2004' 	=> '5'		, 
							'Fall 2003' 	=> '4'		, 	'Spring 2003' 	=> '3'		,	'Fall 2002' 	=> '2'		,
							'Spring 2002' 	=> '1'
						  );
	return $listloopsession[$id];

}

//Session Function
$loopsession = array (
					array('id'=>44, 'name'=>'Fall 2023')	,   array('id'=>43, 'name'=>'Spring 2023')	,
					array('id'=>42, 'name'=>'Fall 2022')	,   array('id'=>41, 'name'=>'Spring 2022')	, 
					array('id'=>40, 'name'=>'Fall 2021')	,  	array('id'=>39, 'name'=>'Spring 2021')	, 
					array('id'=>38, 'name'=>'Fall 2020')	, 	array('id'=>37, 'name'=>'Spring 2020')	, 
					array('id'=>36, 'name'=>'Fall 2019')	,	array('id'=>35, 'name'=>'Spring 2019')	,
					array('id'=>34, 'name'=>'Fall 2018')	,	array('id'=>33, 'name'=>'Spring 2018')	, 
					array('id'=>32, 'name'=>'Fall 2017')	,	array('id'=>31, 'name'=>'Spring 2017')	,
					array('id'=>30, 'name'=>'Fall 2016')	,  	array('id'=>29, 'name'=>'Spring 2016')	, 
					array('id'=>28, 'name'=>'Fall 2015')	, 	array('id'=>27, 'name'=>'Spring 2015')	, 
					array('id'=>26, 'name'=>'Fall 2014')	,	array('id'=>25, 'name'=>'Spring 2014')	,
					array('id'=>24, 'name'=>'Fall 2013')	,  	array('id'=>23, 'name'=>'Spring 2013')	, 
					array('id'=>22, 'name'=>'Fall 2012')	, 	array('id'=>21, 'name'=>'Spring 2012')	, 
					array('id'=>20, 'name'=>'Fall 2011')	, 	array('id'=>19, 'name'=>'Spring 2011')	,
					array('id'=>18, 'name'=>'Fall 2010')	, 	array('id'=>17, 'name'=>'Spring 2010')	, 
					array('id'=>16, 'name'=>'Fall 2009')	, 	array('id'=>15, 'name'=>'Spring 2009')	, 
					array('id'=>14, 'name'=>'Fall 2008')	, 	array('id'=>13, 'name'=>'Spring 2008')	,
					array('id'=>12, 'name'=>'Fall 2007')	, 	array('id'=>11, 'name'=>'Spring 2007')	, 
					array('id'=>10, 'name'=>'Fall 2006')	, 	array('id'=>9, 'name'=>'Spring 2006')	, 
					array('id'=>8, 'name'=>'Fall 2005')		, 	array('id'=>7, 'name'=>'Spring 2005')	, 
					array('id'=>6, 'name'=>'Fall 2004')		, 	array('id'=>5, 'name'=>'Spring 2004')	, 
					array('id'=>4, 'name'=>'Fall 2003')		, 	array('id'=>3, 'name'=>'Spring 2003')	,					
					array('id'=>2, 'name'=>'Fall 2002')		,	array('id'=>1, 'name'=>'Spring 2002')
				);

function get_loopsession($id) {
	$listloopsession = array (
							
							'44' => 'Fall 2023'		,
							'43' => 'Spring 2023'	,
							'42' => 'Fall 2022'	 	,
							'41' => 'Spring 2022'	,
							'40' => 'Fall 2021'	    ,
							'39' => 'Spring 2021'	,
							'38' => 'Fall 2020'		,
							'37' => 'Spring 2020'	,
							'36' => 'Fall 2019'		,
							'35' => 'Spring 2019'	,
							'34' => 'Fall 2018'		,
							'33' => 'Spring 2018'	,
							'32' => 'Fall 2017'		, 
							'31' => 'Spring 2017'	, 
							'30' => 'Fall 2016'		, 
							'29' => 'Spring 2016'	,
							'28' => 'Fall 2015'		,
							'27' => 'Spring 2015'
						  );
	return $listloopsession[$id];
}

//--------------- Daily Logs Status ----------
$logstatus = array (
						array('id'=>1, 'name'=>'New')		, 
						array('id'=>2, 'name'=>'Open')		, 
						array('id'=>3, 'name'=>'Close')		, 
						array('id'=>4, 'name'=>'Delivered')	, 
						array('id'=>5, 'name'=>'Verified')	, 
						array('id'=>6, 'name'=>'Pending')	,					
						array('id'=>7, 'name'=>'Rejected')
				   );

function get_logstatus($id) {

	$listlogstatus = array (
							'1' => '<span class="label label-success" id="bns-status-badge">New</span>'		,
							'2' => '<span class="label label-success" id="bns-status-badge">Open</span>'	,
							'3' => '<span class="label label-warning" id="bns-status-badge">Close</span>'	, 
							'4' => '<span class="label label-info" id="bns-status-badge">Delivered</span>'	, 
							'5' => '<span class="label label-info" id="bns-status-badge">Verified</span>'	, 
							'6' => '<span class="label label-warning" id="bns-status-badge">Pending</span>'	,
							'7' => '<span class="label label-danger" id="bns-status-badge">Rejected</span>'
						  );
	return $listlogstatus[$id];

}

//--------------- Fee Setup Status ----------
$feeperiod = array (
						array('id'=>4, 'name'=>'Monthly')		, 
						array('id'=>3, 'name'=>'Semester')		, 
						array('id'=>2, 'name'=>'Yearly')		, 
						array('id'=>1, 'name'=>'Once')	
				   );

function get_feeperiod($id) {

	$listfeeperiod = array (
							'4' => 'Monthly'		,
							'3' => 'Semester'		,
							'2' => 'Yearly'		, 
							'1' => 'Once'	
						  );
	return $listfeeperiod[$id];

}
//--------------- Daily Logs Types ----------
$logtypes = array (
						array('id'=>1, 'name'=>'Registered')		, 
						array('id'=>2, 'name'=>'Unregistered')		
				   );

function get_logtypes($id) {

	$listlogtypes = array (
							'1' => 'Registered'		,
							'2' => 'Unregistered'	
						  );
	return $listlogtypes[$id];

}

//--------------- Exam Term----------
$examterm = array (
						array('id'=>1, 'name'=>'Mid Term')		, 
						array('id'=>2, 'name'=>'Final Term')		
				   );

function get_examterm($id) {

	$listexamterm = array (
							'1' => 'Mid Term'		,
							'2' => 'Final Term'	
						  );
	return $listexamterm[$id];

}

//--------------- Exam Date Sheet----------
$datesheet = array (
						array('id'=>1, 'name'=>'Mid Term')		, 
						array('id'=>2, 'name'=>'Final Term')	, 
						array('id'=>3, 'name'=>'Summer')		
				   );

function get_datesheet($id) {

	$listdatesheet = array (
							'1' => 'Mid Term'		,
							'2' => 'Final Term'		,
							'2' => 'Summer'	
						  );
	return $listdatesheet[$id];

}

//--------------- Theory  Practical----------
$theorypractical = array (
						array('id'=>1, 'name'=>'Theory')		, 
						array('id'=>2, 'name'=>'Practical')		
				   );

function get_theorypractical($id) {

	$listtheorypractical = array (
							'1' => 'Theory'		,
							'2' => 'Practical'	
						  );
	return $listtheorypractical[$id];

}
//--------------- Room Types ----------
$roomtypes = array (
						array('id'=>1, 'name'=>'Students')		, 
						array('id'=>2, 'name'=>'Staffs')		,
						array('id'=>3, 'name'=>'Guest Room')
				   );

function get_roomtypes($id) {

	$listroomtypes = array (
							'1' => 'Students'		,
							'2' => 'Staffs'			,
							'3' => 'Guests Room'	
						  );
	return $listroomtypes[$id];

}
//Offered on Campus/Online
$courseOfferedOn = array (
	array('id'=>1, 'name'=>'On-Campus')	, 
	array('id'=>2, 'name'=>'Online')
);

function get_courseofferedon($id) {

	$listCourseOfferedOn = array (
			'1' => 'On-Campus'			,
			'2' => 'Online'	
		);
	return $listCourseOfferedOn[$id];
}

//Role Types (Admin Rights)
$roletypes = array (
						array('id'=>1,  'name'=>'Admissions')			, 
						array('id'=>15, 'name'=>'Online Admissions')	,
						array('id'=>2,  'name'=>'Academic')			,
						array('id'=>16,  'name'=>'Repeat/Migration'),
						array('id'=>13,  'name'=>'Summer')			,
						array('id'=>12,  'name'=>'Examination')		,
						array('id'=>3,  'name'=>'Human Resource')	,
						array('id'=>4,  'name'=>'Fee')				,
						array('id'=>14,  'name'=>'Salary')			,
						array('id'=>17,  'name'=>'Budget')			,
						array('id'=>5,  'name'=>'Library')			,
						array('id'=>6,  'name'=>'Hostel')			,
						array('id'=>7,  'name'=>'Students Affairs')	,
						array('id'=>8,  'name'=>'Setting')			,
						array('id'=>9,  'name'=>'Timetable')		,
						array('id'=>10, 'name'=>'Finance')			,
						array('id'=>11, 'name'=>'QEC')				,
						array('id'=>18, 'name'=>'Liberal Arts')		,
						array('id'=>19, 'name'=>'Message/Downloads'),
						array('id'=>20, 'name'=>'Notifications')	,
						array('id'=>22, 'name'=>'Advancement')		,
						array('id'=>24, 'name'=>'CRD')				,
						array('id'=>21, 'name'=>'Conference')	
				   );

function get_roletypes($id) {

	$listroletypes = array (
							'1'  => 'Admissions'			,
							'2'  => 'Academic'				,
							'3'  => 'Human Resource'		,
							'4'  => 'Fee'					,
							'5'  => 'Library'				,
							'6'  => 'Hostel'				,
							'7'  => 'Students Affairs'		,
							'8'  => 'Setting'				,
							'9'  => 'Timetable'				,
							'10' => 'Finance'				,
							'11' => 'QEC'					,
							'12' => 'Examination'			,
							'13' => 'Summer'				,
							'14' => 'Salary'				,
							'15' => 'Online Admissions'		,
							'16' => 'Repeat/Migration'		,
							'17' => 'Budget'				,
							'18' => 'Liberal Arts'			,	
							'19' => 'Message/Downloads'		,	
							'20' => 'Notifications'			,	
							'21' => 'Conference'			,	
							'22' => 'Advancement'			,	
							'24' => 'CRD'				
							
						  );
	return $listroletypes[$id];

}
//--------------- Degree Transcript Issue type ----------
$issueto = array (
						array('id'=>1, 'name'=>'Him/Her Self')		, 
						array('id'=>2, 'name'=>'Others')	
				   );

function get_issueto($id) {

	$listissueto = array (
							'1' => '<span class="label label-success" id="bns-status-badge">Him/Her Self</span>'	, 
							'2' => '<span class="label label-info" id="bns-status-badge">Others</span>'	
						  );
	return $listissueto[$id];

}

//--------------- Library Status ------------------
$searchFunctions = array (
	array('id'=>'LIKE', 'name'=>'LIKE')		,
	array('id'=>'=', 'name'=>'EQUAL TO')	, array('id'=>'!=', 'name'=>'NOT EQUAL TO'),
	
);

function get_searchFunc($id) {
	$searchFunctions = array (
		"LIKE"	=>	'LIKE'			,
		"="   	=>	'EQUALTO'		,	 
		"!=" 	=>	'NOTEQUALTO'
	);
	return $searchFunctions[$id];
}



$book_type = array (
	array('id'=>1, 'name'=>'General Book')		, array('id'=>2, 'name'=>'Text Book'),
	array('id'=>3, 'name'=>'Reference Book')	, array('id'=>4, 'name'=>'Literature/Fiction Book'),
	array('id'=>5, 'name'=>'Other Books')	
);
$tag_untag = array (
	array('id'=>1, 'name'=>'Tagged')		, array('id'=>2, 'name'=>'Untagged')
);
$book_languages = array (
	array('id'=>'English', 'name'=>'English')	, array('id'=>'Urdu', 'name'=>'Urdu'),
	array('id'=>'Arabic', 'name'=>'Arabic')		, array('id'=>'Other Language', 'name'=>'Other Language')	
);
$materialType = array (
	array('id'=>1, 'name'=>'Paper Back (PB)')	, array('id'=>2, 'name'=>'Hard Back(HB)')
);
$mulPub = array (
	array('id'=>1, 'name'=>'Journals')	, array('id'=>2, 'name'=>'News Letter'),
	array('id'=>3, 'name'=>'Conference Proceeding')	, array('id'=>4, 'name'=>'Others')
);
$printStatus = array (
	array('id'=>1, 'name'=>'Print')	, array('id'=>2, 'name'=>'Online')
);
$formType = array (
	array('id'=>1, 'name'=>'Book')	, array('id'=>2, 'name'=>'Journal/Magazine'),
	//array('id'=>3, 'name'=>'Magazine')	, array('id'=>4, 'name'=>'Newspaper'),
	//array('id'=>5, 'name'=>'Others')	
);
function get_acqFormType($id){
	
	$formType = array (
			'1'=>'Book' ,
			'2'=>'Journal/Magazine'	
		);
	return $formType[$id];
}
function get_biblioFormType($id){
	
	$biblioformType = array (
		'1'=>'<span class="label label-success" id="bns-status-badge">Articles</span>'	, 
		'2'=>'<span class="label label-info" id="bns-status-badge">Thesis</span>'		,
		'3'=>'<span class="label label-danger" id="bns-status-badge">Online Books</span>',	
		'4'=>'<span class="label label-danger" id="bns-status-badge">MUL Publications</span>',	
	);
	return $biblioformType[$id];
}


$biblioformType = array (
	array('id'=>1, 'name'=>'Articles')			, array('id'=>2, 'name'=>'Thesis'),
	array('id'=>3, 'name'=>'Online Books')		,
	array('id'=>4, 'name'=>'MUL Publications')	,
		
);

$biblioClass = array (
	array('id'=>'Masters', 'name'=>'Masters')			, array('id'=>'MPhil', 'name'=>'MPhil'),
	array('id'=>'Ph.D', 'name'=>'Ph.D')		
		
);

$acqSource = array (
	array('id'=>1, 'name'=>'Publisher')	, array('id'=>2, 'name'=>'Donation'),
	array('id'=>3, 'name'=>'Gift')	
	
);
$acqCurrency = array (
	array('id'=>'PKR', 'name'=>'PKR')	, array('id'=>'USD', 'name'=>'USD($)'),
	array('id'=>'EUR', 'name'=>'EUR(ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã¢â‚¬Â¦Ãƒâ€šÃ‚Â¡ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¬)'),	
	array('id'=>'GBP', 'name'=>'POUND(ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â£)')
	
);
$acqCat = array (
	array('id'=>1, 'name'=>'w')	, array('id'=>2, 'name'=>'x') ,
	array('id'=>3, 'name'=>'y')	, array('id'=>4, 'name'=>'z')  ,
	array('id'=>5, 'name'=>'Peer Reviewed')	
	
);
$hec_medallion = array (
	array('id'=>'Platinum', 'name'=>'Platinum')	, array('id'=>'Gold', 'name'=>'Gold') ,
	array('id'=>'Silver', 'name'=>'Silver')	, array('id'=>'Bronze', 'name'=>'Bronze')  ,
	array('id'=>'Honorable Mention', 'name'=>'Honorable Mention'),
	array('id'=>'Clay', 'name'=>'Clay'),	
	array('id'=>null, 'name'=>'Null'),	
	
);

$journalAffiliation = array (
	array('id'=>1, 'name'=>'MUL')	
	, array('id'=>2, 'name'=>'Other Institution') 
	
);
$indexedOn = array (
	  array('id'=>1, 'name'=>'Scopus')	
	, array('id'=>2, 'name'=>'WOS')	
	, array('id'=>3, 'name'=>'Google Scholar') 
	, array('id'=>4, 'name'=>'Other') 
	
);

$acqStatus = array (
	array('status_id'=>1, 'status_name'=>'Recieved')		, 
	array('status_id'=>2, 'status_name'=>'Pending')			,
	array('status_id'=>3, 'status_name'=>'Not Recieved')
);

$orderStatus = array (
	array('status_id'=>1, 'status_name'=>'Complete')	, 
	array('status_id'=>2, 'status_name'=>'Incomplete')			
	
);

function get_order_status($id) {

	$listOrderStatus = array (
							'1' => '<span class="label label-success" id="bns-status-badge">Complete</span>'	, 
							'2' => '<span class="label label-warning" id="bns-status-badge">Incomplete</span>'	
						  );
	return $listOrderStatus[$id];

}

function get_hec_degree_transcript_status($id) {

	$listStatus = array (
							'1' => '<span class="label label-success" id="bns-status-badge">Complete</span>'	, 
							'2' => '<span class="label label-warning" id="bns-status-badge">Incomplete</span>'	, 
							'3' => '<span class="label label-danger" id="bns-status-badge">Cancel</span>'	
						  );
	return $listStatus[$id];

}
$couponstatus = array (
	array('id'=>1, 'name'=>'Issued')	, array('id'=>2, 'name'=>'Reissued'), 
	array('id'=>3, 'name'=>'Returned ')  
);
function get_couponstatus($id) {
	
	$listcouponstatus = array (
		'0' => '<small class="label label-success" id="bns-status-badge">On Shelf</small>'	, 
		'1' => '<span class="label label-info" id="bns-status-badge">Issued</span>'			, 
		'2' => '<span class="label label-info" id="bns-status-badge">Reissued</span>'		, 
		'3' => '<span class="label label-success" id="bns-status-badge">Returned</span>'	
  	);
	return $listcouponstatus[$id];
}
function get_borrowerlist($id) {
	
	$listborrowerstatus = array (

		'0' => 'On Shelf'													,
		'1' => 'Issued'														,
		'2' => '<span style="color:blue;">Reissued</span>'					,
		'3' => '<span style="color:green;">Returned/Avaialable</span>'		,
		'4' => '<span style="color:red;">Overdue</span>'					

  	);
	return $listborrowerstatus[$id];
}
function get_borrowers($id) { 
	
	$listborrowerstatus = array (

		'0' => 'On Shelf'					,
		'1' => 'Issued'						,
		'2' => 'Reissued'					,
		'3' => 'Returned'					,
		'4' => 'Overdue'					

  	);
	return $listborrowerstatus[$id];
}
function get_book_type($id) {
$listBookType = array (
		
		'1' => '<span class="label label-info" id="bns-status-badge">Book</span>'			, 
		'2' => '<span class="label label-info" id="bns-status-badge">Refrence Book</span>'	, 
		
	  );
return $listBookType[$id];
}
//--------------- Borrowed Type ------------------
$borrowertype = array (
	array('id'=>1, 'name'=>'Employee')	,
	array('id'=>2, 'name'=>'Student')
);

function get_borrowertype($id) {
	$listborrowertype = array (
	'1' => 'Employee'	, 
	'2' => 'Student'		
	);
	return $listborrowertype[$id];
}

//Student Admission Type
$admissionType = array (
	array('id'=>1, 'name'=>'Regular')		, 
	array('id'=>2, 'name'=>'Private')				
);

function get_admission_type($id) {

	$listAdmissionTypes	= array (
				'1' => 'Regular'			, 
				'2' => 'Private'		
			);
	return $listAdmissionTypes[$id];

}
//Daughter or Son Array
$daughterSon = array (
	array('id'=>1, 'name'=>'Son')		, 
	array('id'=>2, 'name'=>'Daughter')				
);

function get_daughter_son($id) {

	$daughterSon	= array (
				'1' => 'Son'			, 
				'2' => 'Daughter'		
			);
	return $daughterSon[$id];

}
//Pending or Notified Status
$pendingNotified = array (
	array('id'=>1, 'name'=>'Notified')		, 
	array('id'=>2, 'name'=>'Pending')		
);

function get_pendingnotified($id) { 

	$listPendingNotified = array (
				'1'	=> '<span class="label label-success" id="bns-status-badge">Notified</span>'		,	
				'2'	=> '<span class="label label-warning" id="bns-status-badge">Pending</span>'				
			);
	return $listPendingNotified[$id];
}
//Internship Duration
$internshipDuration = array (
	array('id'=>1, 'name'=>'2 Weeks')					, 
	array('id'=>2, 'name'=>'1 Month')					,	
	array('id'=>8, 'name'=>'2 Months')					,	
	array('id'=>3, 'name'=>'3 Months')					,	
	array('id'=>4, 'name'=>'6 Months')					,	
	array('id'=>5, 'name'=>'1 Year')					,	
	array('id'=>6, 'name'=>'MTO')						,	
	array('id'=>7, 'name'=>'Other Traineeship Program')	
);

function get_internship_duration($id) {

	$listInternshipDuration	= array (
				'1' => '2 Weeks'					, 
				'2' => '1 Month'					, 
				'3' => '3 Months'					, 
				'4' => '6 Months'					, 
				'5' => '1 Year'						,
				'6' => 'MTO'						,
				'7' => 'Other Traineeship Program'	,
				'8' => '2 Months'					,
			);
	return $listInternshipDuration[$id];

}

//Internship Duration
$internshipStatus = array (
	array('id'=>1, 'name'=>'Issued')					,
	array('id'=>2, 'name'=>'Pending')					,
	array('id'=>3, 'name'=>'Approved')					,
	array('id'=>4, 'name'=>'Rejected')
);

function get_internship_status($id) {

	$listInternshipStatus = array (
		'1'	=> '<span class="label label-success" id="bns-status-badge">Issued</span>'		,	
		'2'	=> '<span class="label label-warning" id="bns-status-badge">Pending</span>'		,		
		'3'	=> '<span class="label label-info" id="bns-status-badge">Approved</span>'		,		
		'4'	=> '<span class="label label-danger" id="bns-status-badge">Rejected</span>'		
	);
	return $listInternshipStatus[$id];

}
function get_internship_status1($id) {

	$listInternshipStatus = array (
									'1'	=> 'Issued'			,	
									'2'	=> 'Pending'		,		
									'3'	=> 'Approved'		,		
									'4'	=> 'Rejected'		
							);
	return $listInternshipStatus[$id];

}
//--------------- Religion ----------
$religion = array('Muslim', 'Christian', 'Hindu', 'Sikh', 'Buddhist', 'Jewish', 'Parsi', 'Other', 'Non-Mulsim');
//--------------- Gender ----------
$gender = array('Female', 'Male');
//--------------- Marital Status ----------
$marital = array('Single', 'Married', 'Un-married', 'Widow/Widower', 'Divorced');
//--------------- Sections ----------
$sections = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N');
//----------------Blood Groups------------------------------
$bloodgroup = array('A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-');
//--------------- Open With ----------
$fileopenwith = array('Adobe Acrobat Reader', 'MS Excel', 'MS Paint', 'MS Powerpoint', 'MS Word', 'WinRAR', 'WinZip');
//---------------------------------------
/*function cleanvars($str) {
		$str = trim($str);
		$str = mysql_escape_string($str);

	return($str);
}
*/
function cleanvars($str1){ 
	$str = ($str1);
	return $str1;
	// return is_array($str) ? array_map('cleanvars', $str) : str_replace("\\", "\\\\", htmlspecialchars((get_magic_quotes_gpc() ? stripslashes($str) : $str), ENT_QUOTES));
	//return $str;
}

function generateSeoURL($string, $wordLimit = 0){
    $separator = '-';
    
    if($wordLimit != 0){
        $wordArr = explode(' ', $string);
        $string = implode(' ', array_slice($wordArr, 0, $wordLimit));
    }

    $quoteSeparator = preg_quote($separator, '#');

    $trans = array(
        '&.+?;'                    => '',
        '[^\w\d _-]'            => '',
        '\s+'                    => $separator,
        '('.$quoteSeparator.')+'=> $separator
    );

    $string = strip_tags($string);
    foreach ($trans as $key => $val){
        $string = preg_replace('#'.$key.'#i'.(UTF8_ENABLED ? 'u' : ''), $val, $string);
    }

    $string = strtolower($string);

    return trim(trim($string, $separator));
}
//----------------------------------------
function to_seo_url($str){
   // if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
      //  $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
    $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
    $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
    $str = trim($str, '-');
    return $str;
}
//Get Array's Column and ID value
function getColumnValue($array, $columnName, $index) {
	$columnValues = array_column($array, $columnName);
	$index = ($index-1);
	if (isset($columnValues[$index])) {
		return $columnValues[$index];
	}
	return null; // Or you can handle the case when the index is out of range
}
//-------Rupees in Word-------------------------------
function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'Zero',
        1                   => 'One',
        2                   => 'Two',
        3                   => 'Three',
        4                   => 'Four',
        5                   => 'Five',
        6                   => 'Six',
        7                   => 'Seven',
        8                   => 'Eight',
        9                   => 'Nine',
        10                  => 'Ten',
        11                  => 'Eleven',
        12                  => 'Twelve',
        13                  => 'Thirteen',
        14                  => 'Fourteen',
        15                  => 'Fifteen',
        16                  => 'Sixteen',
        17                  => 'Seventeen',
        18                  => 'Eighteen',
        19                  => 'Nineteen',
        20                  => 'Twenty',
        30                  => 'Thirty',
        40                  => 'Fourty',
        50                  => 'Fifty',
        60                  => 'Sixty',
        70                  => 'Seventy',
        80                  => 'Eighty',
        90                  => 'Ninety',
        100                 => 'Hundred',
        1000                => 'Thousand',
        1000000             => 'Million',
        1000000000          => 'Billion',
        1000000000000       => 'Trillion',
        1000000000000000    => 'Quadrillion',
        1000000000000000000 => 'Quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;

        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}

//-------find working day--------------------------
function get_workingday($date){
	 if(date('l', strtotime($date)) == 'Sunday') { 
		$duedatefinal  	= date('Y-m-d', strtotime('1 days', strtotime($date)));
	} else if(date('l', strtotime($date)) == 'Saturday') { 
		$duedatefinal  	= date('Y-m-d', strtotime('2 days', strtotime($date)));
	} else { 
		$duedatefinal  	= $date;
	}
 return $duedatefinal; 
}

//--------------- No of days----------
function get_noofdays($id) {

	$listnoofdays = array (
							'2' => '75'	, 
							'3' => '50'	, 
							'4' => '40'	, 
							'5' => '30'	
						  );
	return $listnoofdays[$id];

}

//--------------- Log File Action----------
function get_logfile($id) {

	$listlogfile = array (
							'1' => 'Add'		, 
							'2' => 'Update'		, 
							'3' => 'Delete'	
						  );
	return $listlogfile[$id];

}
//--------------- Name of Days ----------
$daysname = array (
					'Monday'		,
					'Tuesday'		,
					'Wednesday'		,
					'Thursday'		,
					'Friday' 		,
					'Saturday'		,
					'Sunday'
				);
				
$daysname2 = array (
					'Monday'		,
					'Tuesday'		,
					'Wednesday'		,
					'Thursday'		,
					'Friday'		,
					'Saturday'		,
					'Sunday'
				);				
$dayweekend = array (
					'Monday'		,
					'Tuesday'		,
					'Wednesday'		,
					'Thursday'		,
					'Friday'		,
					'Saturday'		,
					'Sunday'
				);
$weekdays = array (
					'Monday'		,
					'Tuesday'		,
					'Wednesday'		,
					'Thursday'		,
					'Friday'		,
					'Saturday'		,
					'Sunday'
				);
//--------------- Class Room types ----------

$classroomtypes = array (
							array('id'=>1, 'name'=>'Lecture Room')		, 
							array('id'=>2, 'name'=>'Lab')				,
							array('id'=>3, 'name'=>'Board Room')		,
							array('id'=>4, 'name'=>'Auditorium')		,
							array('id'=>5, 'name'=>'Conference Room')	,
							array('id'=>6, 'name'=>'Center Room')		,
							array('id'=>7, 'name'=>'Marquee 1')			,
							array('id'=>8, 'name'=>'Marquee 2')				
				  		);

function get_classroomtypes($id) {

	$listclassroomtypes	= array (
									'1' => 'Lecture Room'		, 
									'2' => 'Lab'				,
									'3' => 'Board Room'			,
									'4' => 'Auditorium'			,
									'5' => 'Conference Room'	,
									'6' => 'Center Room'		,
									'7' => 'Marquee 1'			,
									'8' => 'Marquee 2'		
						  		);
	return $listclassroomtypes[$id];

}

//--------------- Login Types ------------------
$logintypes = array (
					array('id'=>1, 'name'=>'Staffs')		,
					array('id'=>2, 'name'=>'Teachers')		,
					array('id'=>3, 'name'=>'Students')		,
					array('id'=>4, 'name'=>'Parents')		,
					array('id'=>5, 'name'=>'Vigilators')
				   );

function get_logintypes($id) {
	$listlogintypes = array (

							'1'	=> 'Staffs'				,
							'2'	=> 'Teachers'			,
							'3'	=> 'Students'			,
							'4'	=> 'Parents'			,
							'5'	=> 'Vigilators'
							);
	return $listlogintypes[$id];
}

//--------------- Usrr Verifications ------------------
$userverify = array (
	
					array('id'=>1, 'name'=>'Email Address')		,
					array('id'=>2, 'name'=>'Mobile #')	
	
				   );

function get_userverify($id) {
	
	$list = array (

							'1'	=> 'Email Address'		,
							'2'	=> 'Mobile #'			
							);
	return $list[$id];
}
	

function get_emailverify($id) {
	$list= array (
							'1' => '<span class="label label-success" id="bns-status-badge">Verified</span>', 
							'0' => '<span class="label label-danger" id="bns-status-badge">Not Verified</span>');
	return $list[$id];
}


//---------------------- QEC ------------------------------------

//--------------- Evaluation Options ------------------
$evaluationoptions = array (
								array('id'=>5, 'name'=>'Strongly Agree')			,
								array('id'=>4, 'name'=>'Agree')						,
								array('id'=>3, 'name'=>'Neutral / No Opinion')		,
								array('id'=>2, 'name'=>'Disagree')					,
								array('id'=>1, 'name'=>'Strongly Disagree')
						   );

function get_evaluationoptions($id) {
	$listevaluationoptions = array (
									'5'	=> 'Strongly Agree'					,
									'4'	=> 'Agree'							,
									'3'	=> 'Neutral / No Opinion'			,
									'2'	=> 'Disagree'						,
									'1'	=> 'Strongly Disagree'
								);
	return $listevaluationoptions[$id];
}


//--------------- Survey of PHD ------------------
$surveyphd = array (
					array('id'=>'1', 'name'=>'General Information')		,
					array('id'=>'2', 'name'=>'Faculty Resources')		,
					array('id'=>'3', 'name'=>'Research Output')			,
					array('id'=>'4', 'name'=>'Student Information')		,

					array('id'=>'5', 'name'=>'Program Information')		,
					array('id'=>'6', 'name'=>'Additional Information')
				   );

function get_surveyphd($id) {
	$listsurveyphd = array (
									'1'	=> 'General Information'	,
									'2'	=> 'Faculty Resources'		,
									'3'	=> 'Research Output'		,
									'4'	=> 'Student Information'	,
									'5'	=> 'Program Information'	,
									'6'	=> 'Additional Information'
								);
	return $listsurveyphd[$id];
}

//--------------- Survey of Graduating Students ------------------
$surveyoptions = array (
								array('id'=>'A', 'name'=>'Very satisfied')		,
								array('id'=>'B', 'name'=>'Satisfied')			,
								array('id'=>'C', 'name'=>'Uncertain')			,
								array('id'=>'D', 'name'=>'Dissatisfied')		,
								array('id'=>'E', 'name'=>'Very dissatisfied')
						   );

function get_surveyoptions($id) {
	$listsurveyoptions = array (
									'A'	=> 'Very satisfied'						,
									'B'	=> 'Satisfied'							,
									'C'	=> 'Uncertain'							,
									'D'	=> 'Dissatisied'						,
									'E'	=> 'Very dissatisfied'
								);
	return $listsurveyoptions[$id];
}

//--------------- Date Formats ------------------
$dateformat = array (
					array('value'=>'d-m-Y'	, 'name'=>'DD-MM-YYYY')		,
					array('value'=>'d/m/Y'	, 'name'=>'DD/MM/YYYY')		,
					array('value'=>'d/m/y'	, 'name'=>'DD/MM/YY')		,
					array('value'=>'m/d/y'	, 'name'=>'MM/DD/YYYY')		,
					array('value'=>'m-d-y'	, 'name'=>'MM-DD-YYYY')		,
					array('value'=>'Y-m-d'	, 'name'=>'YYYY-MM-DD')
				   );

//--------------- Arrary Search ------------------
function arrayKeyValueSearch($array, $key, $value)
{
    $results = array();
    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }
        foreach ($array as $subArray) {
            $results = array_merge($results, arrayKeyValueSearch($subArray, $key, $value));
        }
    }
    return $results;
}
//--------------- todo priority ------------------
$todopriority = array (
						array('id'=>1, 'name'=>'Low')			, 
						array('id'=>2, 'name'=>'Medium')		, 
						array('id'=>3, 'name'=>'High')	
				   );

function get_todopriority($id) {
	$listtodopriority = array (
							'1' => '<span class="label label-success" id="bns-status-badge">Low</span>'		, 
							'2' => '<span class="label label-info" id="bns-status-badge">Medium</span>'		, 
							'3' => '<span class="label label-warning" id="bns-status-badge">High</span>'	
						  );
	return $listtodopriority[$id];
}

//--------------- publishtype ------------------
$publishtype = array (
						array('id'=>1, 'name'=>'Book')			, 
						array('id'=>2, 'name'=>'Article')		, 
						array('id'=>3, 'name'=>'Thesis')	
				   );

function get_publishtype($id) {
	$listpublishtype = array (
							'1' => 'Book'		, 
							'2' => 'Article'	, 
							'3' => 'Thesis'	
						  );
	return $listpublishtype[$id];
}

//--------------- Challan Type ------------------
$challantype = array (
						array('id'=>4, 'name'=>'Online Admission'),
						array('id'=>5, 'name'=>'Final Term')
				   );

function get_challantype($id) {
	$listchallantype = array (
							'4' => 'Online Admission'	,
							'5' => 'Final Term'	
						  );
	return $listchallantype[$id];
}

//--------------- Levels ------------------
$levels = array (
						array('id'=>1, 'name'=>'Beginner')			, 
						array('id'=>2, 'name'=>'Intermediate')		, 
						array('id'=>3, 'name'=>'Expert')	
				   );

function get_levels($id) {
	$listlevels = array (
							'1' => '<span class="label label-success" id="bns-status-badge">Beginner</span>'		, 
							'2' => '<span class="label label-info" id="bns-status-badge">Intermediate</span>'		, 
							'3' => '<span class="label label-warning" id="bns-status-badge">Expert</span>'	
						  );
	return $listlevels[$id];
}

//Salutation 
$salutation = array (
	array('id'=>1,  'name'=>'Mr.')				,
	array('id'=>2,  'name'=>'Mrs.')				,
	array('id'=>3,  'name'=>'Ms.')				,
	array('id'=>4,  'name'=>'Dr.')				,
	array('id'=>5,  'name'=>'Prof.')			,
	array('id'=>6,  'name'=>'Other')
);

function get_Salutation($id) {
	$listSalutation = array (
				'1'	=> 'Mr.'				,
				'2'	=> 'Mrs.'				,
				'3'	=> 'Ms.'				,
				'4'	=> 'Dr.'				,
				'5'	=> 'Prof.'				,
				'6'	=> 'Other'
				);
	return $listSalutation[$id];
}
//Relation 
$relation = array (
	array('id'=>1,  'name'=>'S/O')				,
	array('id'=>2,  'name'=>'D/O')				,
	array('id'=>3,  'name'=>'W/O')
);

function get_relation($id) {
	$listRelation = array (
				'1'	=> 'S/O'				,
				'2'	=> 'D/O'				,
				'3'	=> 'W/O'
				);
	return $listRelation[$id];
}

//WIEFC Confrenece Source
$wiefcSource = array (
	array('id'=>1,  'name'=>'Conference Alert')								,
	array('id'=>2,  'name'=>'Email')										,
	array('id'=>3,  'name'=>'Social Media')									,
	array('id'=>4,  'name'=>'Search on Web')								,
	array('id'=>5,  'name'=>'Advertisement')								,
	array('id'=>6,  'name'=>'Through University / Institution / College')	,
	array('id'=>7,  'name'=>'WhatsApp')										,
	array('id'=>8,  'name'=>'Friend')										,
	array('id'=>9,  'name'=>'Other')
);

function get_WiefcSource($id) {
	$listwiefcSource = array (
				'1'	=> 'Conference Alert'								,
				'2'	=> 'Email'											,
				'3'	=> 'Social Media'									,
				'4'	=> 'Search on Web'									,
				'5'	=> 'Advertisement'									,
				'6'	=> 'Through University / Institution / College'		,
				'7'	=> 'WhatsApp'										,
				'8'	=> 'Friend'											,
				'9'	=> 'Other'
				);
	return $listwiefcSource[$id];
}
//--------------- Get Uploaded file size ------------------
function formatSizeUnits($bytes) {
		if ($bytes >= 1073741824) {
			$bytes = number_format($bytes / 1073741824, 2) . ' GB';
		} elseif ($bytes >= 1048576) {
			$bytes = number_format($bytes / 1048576, 2) . ' MB';
		} elseif ($bytes >= 1024) {
			$bytes = number_format($bytes / 1024, 2) . ' KB';
		} elseif ($bytes > 1) {
			$bytes = $bytes . ' bytes';
		} elseif ($bytes == 1) {
			$bytes = $bytes . ' byte';
		} else {
			$bytes = '0 bytes';
		}
	return $bytes;
}
//--------------- Generate Random Password ------------------
function generatePassword( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}
//--------------- Generate Spcee Free String ------------------
function generateregno($string, $wordLimit = 0){
    $separator = '';
    
    if($wordLimit != 0){
        $wordArr = explode(' ', $string);
        $string = implode(' ', array_slice($wordArr, 0, $wordLimit));
    }

    $quoteSeparator = preg_quote($separator, '#');

    $trans = array(
        '&.+?;'                  => '',
        '[^\w\d _-]'           	 => '',
        '\s+'                    => $separator,
        '('.$quoteSeparator.')+'=> $separator
    );

    $string = strip_tags($string);
    foreach ($trans as $key => $val){
        $string = preg_replace('#'.$key.'#i'.(UTF8_ENABLED ? 'u' : ''), $val, $string);
    }

    $string = strtolower($string);

    return trim(trim($string, $separator));
}

//--------------- Current Page Url ------------------
function currentPageURL() {
	$pageURL = 'http';
	if (isset($_SERVER["HTTPS"]) == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}


//--------------- addOrdinalNumberSuffix ------------------
function addOrdinalNumberSuffix($num) {
	if (!in_array(($num % 100),array(11,12,13))){
		switch ($num % 10) {
	// Handle 1st, 2nd, 3rd

			case 1:  return $num.'st';
			case 2:  return $num.'nd';
			case 3:  return $num.'rd';
		}
	}
	return $num.'th';
}

//-----------------------------------------
function thousandsCurrencyFormat($num) {

  if($num>1000) {

        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;

        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];

        return $x_display;

  }

  return $num;
}

function print_number_count($number) {
    $units = array( '', 'K', 'M', 'B');
    $power = $number > 0 ? floor(log($number, 1000)) : 0;
    if($power > 0)
        return @number_format($number / pow(1000, $power), 2, ',', ' ').' '.$units[$power];
    else
        return @number_format($number / pow(1000, $power), 0, '', '');
}
//---------------Remove multiple space with single--------------------------
function removeWhiteSpace($text) {
    $text = preg_replace('/[\t\n\r\0\x0B]/', '', $text);
    $text = preg_replace('/([\s])\1+/', ' ', $text);
    $text = trim($text);
    return $text;
}
//---------------Months Names--------------------------
$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December');

$monthsArray = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');


function get_month($id) {
	$listMonth = array (1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
	return $listMonth[$id];
}

$taxmonthsArray = array(7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December', 1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June');
//---------------------------------------
function generateCode($characters) { 
    $possible = '234567-89ABCDEFGHJKLMNPQR-STUVWXYZabcdefghijklmnopqrstuvwxyz-'; 
    $possible = $possible.$possible.'2345678923456789'; 
    $code = ''; 
    $i = 0; 
    while ($i < $characters) {  
      $code .= substr($possible, mt_rand(0, strlen($possible)-1), 1); 
      $i++; 
    } 
    return $code; 
  }


function curPageURL( $trim_query_string = false ) {
    $pageURL = (isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on') ? "https://" : "http://";
    $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    if( ! $trim_query_string ) {
        return $pageURL;
    } else {
        $url = explode( '?', $pageURL );
        return $url[0];
    }
}

// remove words from a string
function substrwords($text, $maxchar, $end='...') {
    if (strlen($text) > $maxchar || $text == '') {
        $words = preg_split('/\s/', $text);      
        $output = '';
        $i      = 0;
        while (1) {
            $length = strlen($output)+strlen($words[$i]);
            if ($length > $maxchar) {
                break;
            } 
            else {
                $output .= " " . $words[$i];
                ++$i;
            }
        }
        $output .= $end;
    } 
    else {
        $output = $text;
    }
    return $output;
}
//---------------star Rating--------------------------
function starrating($number) {
   if($number == 1) {
	  $rating = '
	  	<span class="fa fa-star starchecked" style="font-size:16px;"></span>
		<span class="fa fa-star" style="font-size:16px;"></span>
		<span class="fa fa-star" style="font-size:16px;"></span>
		<span class="fa fa-star" style="font-size:16px;"></span>
		<span class="fa fa-star" style="font-size:16px;"></span>';
   } else if($number == 2) {
	  $rating = '
	  	<span class="fa fa-star starchecked" style="font-size:16px;"></span>
		<span class="fa fa-star starchecked" style="font-size:16px;"></span>
		<span class="fa fa-star" style="font-size:16px;"></span>
		<span class="fa fa-star" style="font-size:16px;"></span>
		<span class="fa fa-star" style="font-size:16px;"></span>';
   } else if($number == 3) {
	  $rating = '
	  	<span class="fa fa-star starchecked" style="font-size:16px;"></span>
		<span class="fa fa-star starchecked" style="font-size:16px;"></span>
		<span class="fa fa-star starchecked" style="font-size:16px;"></span>
		<span class="fa fa-star" style="font-size:16px;"></span>
		<span class="fa fa-star" style="font-size:16px;"></span>';
   } else if($number == 4) {
	  $rating = '
	  	<span class="fa fa-star starchecked" style="font-size:16px;"></span>
		<span class="fa fa-star starchecked" style="font-size:16px;"></span>
		<span class="fa fa-star starchecked" style="font-size:16px;"></span>
		<span class="fa fa-star starchecked" style="font-size:16px;"></span>
		<span class="fa fa-star" style="font-size:16px;"></span>';
   } else if($number == 5) {
	  $rating = '
	  	<span class="fa fa-star starchecked" style="font-size:16px;"></span>
		<span class="fa fa-star starchecked" style="font-size:16px;"></span>
		<span class="fa fa-star starchecked" style="font-size:16px;"></span>
		<span class="fa fa-star starchecked" style="font-size:16px;"></span>
		<span class="fa fa-star starchecked" style="font-size:16px;"></span>';
   }
   
    return $rating;
}

// check file url
function url_exists($url) {

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_NOBODY, true);
	curl_exec($ch);
	$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	
	if($responseCode == 200){
		return true;
	} else {
		return false;
	}
}

//Count Number of Words in String
//Count Number of Words in String
function get_num_of_words($string) {
    $string = preg_replace('/\s+/', ' ', trim($string));
    $words = explode(" ", $string);
    return count($words);
}

function ageCalculator($dob){
    if(!empty($dob)){
        $birthdate = new DateTime($dob);
        $today   = new DateTime('today');
        $age = $birthdate->diff($today)->y;
        return $age;
    }else{
        return 0;
    }
}

function searchArrayKeyVal($sKey, $id, $array) {
	foreach ($array as $key => $val) {
		if ($val[$sKey] == $id) {
			return $key;
		}
	}
	return null;
}


// compare upload image file

function compress_image($source_file, $target_file, $nwidth, $nheight, $quality) {
	//Return an array consisting of image type, height, widh and mime type.
	$image_info = getimagesize($source_file);
	if(!($nwidth > 0)) $nwidth = $image_info[0];
	if(!($nheight > 0)) $nheight = $image_info[1];
	

	/*echo '<pre>';
	print_r($image_info);*/
	if(!empty($image_info)) {
		switch($image_info['mime']) {
			case 'image/jpeg' :
				if($quality == '' || $quality < 0 || $quality > 100) $quality = 50; //Default quality
				// Create a new image from the file or the url.
				$image = imagecreatefromjpeg($source_file);
				$thumb = imagecreatetruecolor($nwidth, $nheight);
				//Resize the $thumb image
				imagecopyresized($thumb, $image, 0, 0, 0, 0, $nwidth, $nheight, $image_info[0], $image_info[1]);
				// Output image to the browser or file.
				return imagejpeg($thumb, $target_file, $quality); 
				
				break;
			
			case 'image/png' :
				if($quality == '' || $quality < 0 || $quality > 9) $quality = 4; //Default quality
				// Create a new image from the file or the url.
				$image = imagecreatefrompng($source_file);
				$thumb = imagecreatetruecolor($nwidth, $nheight);
				//Resize the $thumb image
				imagecopyresized($thumb, $image, 0, 0, 0, 0, $nwidth, $nheight, $image_info[0], $image_info[1]);
				// Output image to the browser or file.
				return imagepng($thumb, $target_file, $quality);
				break;
				
			case 'image/gif' :
				if($quality == '' || $quality < 0 || $quality > 100) $quality = 50; //Default quality
				// Create a new image from the file or the url.
				$image = imagecreatefromgif($source_file);
				$thumb = imagecreatetruecolor($nwidth, $nheight);
				//Resize the $thumb image
				imagecopyresized($thumb, $image, 0, 0, 0, 0, $nwidth, $nheight, $image_info[0], $image_info[1]);
				// Output image to the browser or file.
				return imagegif($thumb, $target_file, $quality); //$success = true;
				break;
				
			default:
				echo "<h4>Not supported file type!</h4>";
				break;
		}
	}
}


// Payfast functions

function getAccessToken($merchant_id, $secured_key, $basket_id, $trans_amount, $tokenApiUrl)  {
	//$tokenApiUrl = 'https://ipguat.apps.net.pk/Ecommerce/api/Transaction/GetAccessToken';

	$urlPostParams = sprintf(
            //'MERCHANT_ID=%s&SECURED_KEY=%s',
			 'MERCHANT_ID=%s&SECURED_KEY=%s&TXNAMT=%s&BASKET_ID=%s',
            $merchant_id,
            $secured_key,
          $trans_amount,
          $basket_id
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenApiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $urlPostParams);
        curl_setopt($ch, CURLOPT_USERAGENT, 'CURL/PHP PayFast Example');
        $response = curl_exec($ch);
        curl_close($ch);
        $payload = json_decode($response);
        $token = isset($payload->ACCESS_TOKEN) ? $payload->ACCESS_TOKEN : '';
        return $token;
    }

function processResponse($merchant_id, $original_basket_id, $txnamt, $response) {
        /**
         * following parameters sent from PayFast after success/failed transaction
         * 
         */
		
		
        $trans_id = $response['transaction_id'];
        $err_code = $response['err_code'];
        $err_msg = $response['err_msg'];
        $basket_id = $response['basket_id'];
        $order_date = $response['order_date'];
        $response_key = $response['Response_Key'];
        $payment_name = $response['PaymentName'];

        $secretword = ''; // No secret code defined for merchant id 102, secret code can be entered in merchant portal.

        $response_string = sprintf("%s%s%s%s%s", $merchant_id, $original_basket_id, $secretword, $txnamt, $err_code);
        $response_hash = hash('MD5', $response_string);

        if (strtolower($response_hash) != strtolower($response_key)) {
            echo "<br/>Transaction could not be varified<br/>";
		
            return;
        }

        if ($err_code == '000' || $err_code == '00') {
            echo "<strong>Transaction Successfully Completed. Transaction ID: " . $trans_id . "</strong><br/>";
            echo "<br/>Date: " . $order_date;
		
            return;
        }

        echo "<br/>Transaction Failed. Message: " . $err_msg;
    }

//------------------- 20-02-2024-----------------
//------------------------- OBE Arrays / Functions -------------------------
//---------------Question Category ---------------
$ques_category = array (
	array('id'=>1	, 'name'=>'SQ'),
	array('id'=>2	, 'name'=>'MCQ'),
	array('id'=>3	, 'name'=>'LQ'),
	array('id'=>4	, 'name'=>'T/F'),
	array('id'=>5	, 'name'=>'Fill in Blank')	
);
function get_ques_category($id) {
	$listquescategory= array (
			'1' => 'SQ', 
			'2' => 'MCQ',
			'3' => 'LQ',
			'4' => 'T/F',
			'5' => 'Fill in Blank'	
		);
	return $listquescategory[$id];
}
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
	header('Content-Type: application/json');
	echo json_encode($ques_category);
}

define('COURSE_TYPE'	, 1);
define('COURSE_TYPE_ARRAY'	,[
	1 => 'Theory',
	2 => 'Lab',
]);