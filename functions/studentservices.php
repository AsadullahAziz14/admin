<?php 

// 13-3-24 Start
//DSA Status
$dsaStatus = array (
	array('id'=>1, 'name'=>'Pending')		, 
	array('id'=>2, 'name'=>'In Process')	, 
	array('id'=>3, 'name'=>'Objection')		, 
	array('id'=>4, 'name'=>'Issued')		,					
	array('id'=>5, 'name'=>'Delivered')		,
	array('id'=>6, 'name'=>'Verification')	
);

function get_dsa_status($id) {

	$listdsastatus = array (
			'1' => '<span class="label label-warning" id="bns-status-badge">Pending</span>'		, 
			'2' => '<span class="label label-info" id="bns-status-badge">In Process</span>'		, 
			'3' => '<span class="label label-danger" id="bns-status-badge">Objection</span>'	, 
			'4' => '<span class="label label-info" id="bns-status-badge">Issued</span>'			,
			'5' => '<span class="label label-success" id="bns-status-badge">Delivered</span>'	,
			'6' => '<span class="blog-post-info-tag btn btn-soft-secondary">Verification</span>'
		);
	return $listdsastatus[$id];
}

function get_dsa_status1($id) {

	$listdsastatus = array (
			'1' => 'Pending'		, 
			'2' => 'In Process'		, 
			'3' => 'Objection'		, 
			'4' => 'Issued'			,
			'5' => 'Delivered'		,
			'6' => 'Verification'		

		);
	return $listdsastatus[$id];
}

function get_dsa_status_student($id) {

	$listdsastatus = array (
			'1' => '<span class="blog-post-info-tag btn btn-soft-warning">Pending</span>'	, 
			'2' => '<span class="blog-post-info-tag btn btn-soft-info">In Process</span>'	, 
			'3' => '<span class="blog-post-info-tag btn btn-soft-danger">Objection</span>'	, 
			'4' => '<span class="blog-post-info-tag btn btn-soft-info">Issued</span>'		,
			'5' => '<span class="blog-post-info-tag btn btn-soft-success">Delivered</span>'	,
			'6' => '<span class="blog-post-info-tag btn btn-soft-secondary">Verification</span>'
		);
	return $listdsastatus[$id];
}

// 13-3-24 End

$degreeTranscriptArray = array (
	array('id'=>1, 'name'=>'Transcript')	,
	array('id'=>2, 'name'=>'Degree'),
);
function get_dsa_degree_transcript($id) {
	$listdsastatus = array (
			'1' => 'Transcript'	, 
			'2' => 'Degree'
		);
	return $listdsastatus[$id];
}

function get_dsa_degree_transcript1($id) {
	$regular = 	array (
					'1' => 'Transcript'	, 
					'2' => 'Degree'	
				);
	return $regular[$id];
}

$regularUrgentArray = array (
	array('id'=>1, 'name'=>'Normal')	, 
	array('id'=>2, 'name'=>'Urgent')	,					
);

function get_dsa_regular_urgent($id) {
	$regular = 	array (
					'1' => '<span class="label label-info" id="bns-status-badge">Normal</span>'	, 
					'2' => '<span class="label label-danger" id="bns-status-badge">Urgent</span>'	
				);
	return $regular[$id];
}

function get_dsa_regular_urgent1($id) {
	$regular = 	array (
					'1' => '<span class="label label-info" id="bns-status-badge">Normal</span>'	, 
					'2' => '<span class="label label-danger" id="bns-status-badge">Urgent</span>'	
				);
	return $regular[$id];
}

function get_dsa_regular_urgent2($id) {
	$regular = 	array (
					'1' => 'Normal'	, 
					'2' => 'Urgent'	
				);
	return $regular[$id];
}

$originalDuplicateArray = array (
	array('id'=>1, 'name'=>'Original')	, 
	array('id'=>2, 'name'=>'Duplicate')
);

function get_dsa_original_duplicate($id) {
	$originalduplicate = 	array (
					'1' => '<span class="label label-success" id="bns-status-badge">Original</span>'	, 
					'2' => '<span class="label label-warning" id="bns-status-badge">Duplicate</span>'	
				);
	return $originalduplicate[$id];
}

function get_dsa_original_duplicate1($id) {
	$originalduplicate = 	array (
					'1' => '<span class="label label-success" id="bns-status-badge">Original</span>'	, 
					'2' => '<span class="label label-warning" id="bns-status-badge">Duplicate</span>'	
				);
	return $originalduplicate[$id];
}

function get_dsa_original_duplicate2($id) {
	$originalduplicate = 	array (
					'1' => 'Original'	, 
					'2' => 'Duplicate'	
				);
	return $originalduplicate[$id];
}

$dsaTranscriptTestsArray = array (
	array('id'=>1, 'name'=>'MAT (Minhaj Aptitude Test)')	, 
	array('id'=>2, 'name'=>'GAT (General Aptitude Test) ')
);

function get_dsa_transcript_test($id) {
	$dsaTranscriptTests = 	array (
					'1' => 'MAT (Minhaj Aptitude Test)'	, 
					'2' => 'GAT (General Aptitude Test)'	
				);
	return $dsaTranscriptTests[$id];
}

$dsaRecipientsArray = array (
	array('id'=>1, 'name'=>'Self')	, 
	array('id'=>2, 'name'=>'Authorized')
);

function get_dsa_recipient($id) {
	$dsaRecipients = 	array (
					'1' => 'Self'	, 
					'2' => 'Authorized'	
				);
	return $dsaRecipients[$id];
}

$dsaApplicationCurrentLocation = array (
	array('id'=>1, 'name'=>'HOD')			, 
	array('id'=>2, 'name'=>'Accounts')		, 
	array('id'=>3, 'name'=>'Examination')	, 
	array('id'=>4, 'name'=>'DSA')
);

function get_dsa_current_loc($id) {
	$dsaRecipients = 	array (
					'1' => 'HOD'			, 
					'2' => 'Accounts'		, 
					'3' => 'Examination'	, 
					'4' => 'DSA'	
				);
	return $dsaRecipients[$id];
}

function getWorkingDaysDate($days,$fromDate){

	for($i=0;$i<$days;$i++){
		$day = date('N',strtotime("+".($i+1)."day"));

		if($day>5)
			$days++;
	}
	return date("Y-m-d",strtotime("+$i day", strtotime($fromDate)));
}

//--------------- program Timing ----------
$programtiming = array (
                        array('id'=>1, 'name'=>'Morning')   ,
                        array('id'=>2, 'name'=>'Weekend')   ,
                        array('id'=>4, 'name'=>'Evening')   ,
                        array('id'=>3, 'name'=>'Both')
                   );
