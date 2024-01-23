<?php 
//--------------- Status ------------------
$status = array (
					array('id'=>'1', 'name'=>'Active')		,
					array('id'=>'0', 'name'=>'Inactive')
				);
function get_status($id) {
	$liststatus= array (
							'1' => '<span class="label label-success" id="bns-status-badge">Active</span>', 
							'0' => '<span class="label label-danger" id="bns-status-badge">Inactive</span>');
	return $liststatus[$id];
}
//------------Slider Position---------
$sliderpost = array (
						array ('id' => '01'		,'name' => 'Left'),
						array ('id' => '02'		,'name' => 'Right'),
						array ('id' => '03'		,'name' => 'Center'),
);
//--------------- Payments Status ------------------
$eventinquiry = array (
						array('id'=>1, 'name'=>'Confirmed')		, 
						array('id'=>2, 'name'=>'Pending')	, 
						array('id'=>3, 'name'=>'Rejected')
				   );

function get_eventinquiry($id) {
	$listeventinquiry = array (
							'1' => '<span class="label label-info" id="bns-status-badge">Confirmed</span>'		, 
							'2' => '<span class="label label-warning" id="bns-status-badge">Pending</span>'	,
							'3' => '<span class="label label-danger" id="bns-status-badge">Rejected</span>'
						  );
	return $listeventinquiry[$id];
}

//--------------- Library Status ------------------
$couponstatus = array (
						array('id'=>1, 'name'=>'Issued')	, array('id'=>2, 'name'=>'Confirmed'), 
						array('id'=>3, 'name'=>'Returen')
				   );

function get_couponstatus($id) {
	$listcouponstatus = array (
							'1' => '<span class="label label-success" id="bns-status-badge">Issued</span>'		, 
							'2' => '<span class="label label-info" id="bns-status-badge">Confirmed</span>'		, 
							'3' => '<span class="label label-warning" id="bns-status-badge">Returen</span>'	
						  );
	return $listcouponstatus[$id];
}

//--------------- Admins Rights ----------
$admtypes = array (
					array('id'=>1, 'name'=>'Super Admin')	,
					array('id'=>2, 'name'=>'Accountant')	,
					array('id'=>3, 'name'=>'Simple User')
				   );

function get_admtypes($id) {
	$listadmrights = array (
							'1'	=> 'Super Admin'			,
							'2'	=> 'Accountant'				,
							'3'	=> 'Simple User'
							);
	return $listadmrights[$id];
}

//--------------- Status Yes No ----------
$statusyesno = array (
						array('id'=>1, 'name'=>'Yes'), 
						array('id'=>2, 'name'=>'No')
				   );

function get_statusyesno($id) {
	
	$liststatusyesno = array (
								'1' => '<span class="label label-info" id="bns-status-badge">Yes</span>', 
								'2' => '<span class="label label-warning" id="bns-status-badge">No</span>'	
							 );
	return $liststatusyesno[$id];
}
//--------------- Degree Names ------------------
$degreename = array (
	array('id'=>1	, 'name'=>'Bachelor')		,
	array('id'=>2	, 'name'=>'Master')			,
	array('id'=>3	, 'name'=>'M.Phil / MS')	,
	array('id'=>4	, 'name'=>'Phd')			,
	array('id'=>5	, 'name'=>'Other')
);

function get_degreename($id) {
	$lisdegreename= array (
			'1' => 'Bachelor'		, 
			'2' => 'Master'			,
			'3' => 'M.Phil / MS'	,
			'4' => 'Phd'			,
			'5' => 'Other');
	return $lisdegreename[$id];
}


//--------------- Programs Names ------------------
$programs = array (
	array('id'=>1	, 'name'=>'SE')		,
	array('id'=>2	, 'name'=>'IT')			,
	array('id'=>3	, 'name'=>'CS')	,
	array('id'=>4	, 'name'=>'DS')			,
	array('id'=>5	, 'name'=>'AI')
);

function get_program($id) {
	$listprogram = array (
			'1' => 'SE'		, 
			'2' => 'IT'			,
			'3' => 'CS'	,
			'4' => 'DS'			,
			'5' => 'AI');
	return $listprogram[$id];
}

//--------------- OBE_CLOS OBE_DOMAINSS ------------------
$domain_name = array (
	array('id'=>1	, 'name'=>'Cognitive'),
	array('id'=>2	, 'name'=>'Psychomotor'),
	array('id'=>3	, 'name'=>'Affective')	
	
);

function get_domain_name($id) {
	$listdomainname= array (
			'1' => 'Cognitive', 
			'2' => 'Psychomotor',
			'3' => 'Affective'	
		);
	return $listdomainname[$id];
}
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

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') 
{
	header('Content-Type: application/json');
	echo json_encode($ques_category);
}

//--------------- Units of Measurements ---------------
$units_of_measurement = array (
	array('id'	=>'1'		,	'name'	=>'Piece'),
	array('id'	=>'2'		,	'name'	=>'Dozen'),
	array('id' 	=>'3'		,	'name'	=>'Pound'),
	array('id'	=>'4'	,	'name'	=>'Kilogram'),
	array('id'	=>'5'		,	'name'	=>'Liter'),
	array('id'	=>'6'		,	'name'	=>'Meter'),
	array('id'	=>'7'		,	'name'	=>'Meter'),
	array('id'	=>'8'	,	'name'	=>'Centimeter'),
	array('id'	=>'9',	'name'	=>'Square Meter'),
	array('id'	=>'10'	,	'name'	=>'Cubic Meter')
);

function get_unit_of_measurement($id) {
	define('listunitofmeasurement'	,[
		'Piece' 		=> 'Piece',
		'Dozen' 		=> 'Dozen',
		'Pound' 		=> 'Pound',
		'Kilogram' 		=> 'Kilogram',
		'Liter' 		=> 'Liter',
		'Gallon' 		=> 'Gallon',
		'Meter' 		=> 'Meter',
		'Centimeter' 	=> 'Centimeter',
		'Square Meter' 	=> 'Square Meter',
		'Cubic Meter' 	=> 'Cubic Meter',
	]);
	return listunitofmeasurement[$id];
}

//--------------- Payment Types ------------------
$pay_types = array (
						array('id'=>1, 'name'=>'Bank'), 
						array('id'=>2, 'name'=>'Cash'), 
						array('id'=>3, 'name'=>'Cheque')
				   );

function get_paytypes($id) {
	$listpaytypes = array (	'1' => 'Bank', 
							'2' => 'Cash', 
							'3' => 'Cheque');
	return $listpaytypes[$id];
}

//-----------------CMS-OBE Variable---------------------
define('ID_TEACHER'	, 1);
define('ID_TEACHER_ARRAY'	,[
	1 => 'Ali',
	2 => 'Hasan',
	3 => 'Ahmad',
	4 => 'Shakeel',
	5 => 'Hussain' 
]);

define('ID_COURSE'	, 1);
define('ID_COURSE_ARRAY'	,[
	1 => 'Separation Process',
	2 => 'DSA',
	3 => 'PF',
	4 => 'OOP',
]);

define('COURSE_TYPE'	, 1);
define('COURSE_TYPE_ARRAY'	,[
	1 => 'Theory',
	2 => 'Lab',
]);

define('ID_PRG'	, 1);
define('ID_PRG_ARRAY'	,[
	1 => 'BS Chemical Engg',
	2 => 'BS CS',
	3 => 'BS IT',
	4 => 'BS SE',
	5 => 'BS AI' 
]);

define('SECTION'	, 'A');

define('SEMESTER'	, 1);
define('SEMESTER_ARRAY'	,[
	1 => '1st',
	2 => '2nd',
	3 => '3rd',
	4 => '4th',
	5 => '5th',
	6 => '6th',
	7 => '7th',
	8 => '8th',
]);

define('TIMING'	, 1);
define('TIMING_ARRAY'	,[
	1 => 'Morning',
	2 => 'Evening',
	3 => 'Week Night'
]);

define('ACADEMIC_SESSION', 'Spring 2023');

// 1,2,3,4,5,... represents Roll numbers in below STUDENTS Array
define('STUDENTS' , array(
	1 			=> array("id" => "2023F-mul-1", "name" => "Ali")
	,2 			=> array("id" => "2023F-mul-2", "name" => "Ahmad" )
	,3 			=> array("id" => "2023F-mul-3", "name" => "Hammad")
));

define('GRADES'	,[
	'f' 	=> 'F'
	,'d' 	=> 'D'
	,'c-' 	=> 'C-'
	,'c' 	=> 'C'
	,'c+' 	=> 'C+'
	,'b-' 	=> 'B-'
	,'b' 	=> 'B'
	,'b+' 	=> 'B+'
	,'a' 	=> 'A'
	,'a+' 	=> 'A+'
]);

define('LIBREL_ARTS'	, 1);


//-----------------CMS-SMS Variable-----------

$SMS_STATUS = array (
	array('id'=>'1', 'name'=>'Created')			,
	array('id'=>'2', 'name'=>'Forwarded')		,
	array('id'=>'3', 'name'=>'Approved')		,
	array('id'=>'4', 'name'=>'Rejected')		,
	array('id'=>'5', 'name'=>'Ordered')			,	// PO of demand is ordered
	array('id'=>'6', 'name'=>'In-Process')		,	// PO of demand is on-receiving
	array('id'=>'7', 'name'=>'Completed')		,   // PO of demand is Completed
	array('id'=>'8', 'name'=>'Requested')		,	// Demand is requested
	array('id'=>'9', 'name'=>'Issued')			,	// Requisition is issued is issued
	array('id'=>'10', 'name'=>'Full-Filled')	,	// Demand/Request is Full-Filled
);
function get_sms_status($id) {
$liststatus= array (
			'1' => '<span class="label label-primary" id="bns-status-badge">Created</span>', 
			'2' => '<span class="label label-purple" id="bns-status-badge">Forwarded</span>',
			'3' => '<span class="label label-success" id="bns-status-badge">Approved</span>',
			'4' => '<span class="label label-danger" id="bns-status-badge">Rejected</span>',
			'5' => '<span class="label label-info-dark" id="bns-status-badge">Ordered</span>',
			'6' => '<span class="label label-warning" id="bns-status-badge">In-Process</span>',
			'7' => '<span class="label label-success-dark" id="bns-status-badge">Full-Filled</span>',
			'8' => '<span class="label label-success-dark" id="bns-status-badge">Completed</span>',
			'9' => '<span class="label label-success-dark" id="bns-status-badge">Issued</span>',
			'10' => '<span class="label label-info-dark" id="bns-status-badge">Requested</span>',
);
return $liststatus[$id];
}

define('DEMAND_TYPES'	,[
	'n' 	=> '<span class="label label-info" id="bns-status-badge">Normal</span>'	,
	'u' 	=> '<span class="label label-warning" id="bns-status-badge">Urgent</span>'
]);

define('PAYMENT_TERMS'	,[
	'cr' 	=> 'Credit'
	,'ca' 	=> 'Cash'
]);

define('REQUISITION_TYPES'	,[
	'1' 	=> 'Tengible'
	,'2' 	=> 'Non-Tengible'
]);




//--------------- Gender ----------
$gender = array('Female', 'Male');
//--------------- Marital Status ----------
$marital = array('Married', 'Single');
//--------------- Sections ----------
$sections = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');
//----------------Blood Groups------------------------------
$bloodgroup = array('A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-');
//---------------------------------------
/*function cleanvars($str) {
$str = trim($str);
$str = mysql_escape_string($str);

return($str);
}
*/
function cleanvars($str){ 
return is_array($str) ? array_map('cleanvars', $str) : str_replace("\\", "\\\\", htmlspecialchars($str, ENT_QUOTES)); 
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

// function generateSeoURL($string, $wordLimit = 0){
//     $separator = '-';
    
//     if($wordLimit != 0){
//         $wordArr = explode(' ', $string);
//         $string = implode(' ', array_slice($wordArr, 0, $wordLimit));
//     }

//     $quoteSeparator = preg_quote($separator, '#');

//     $trans = array(
//         '&.+?;'                    => '',
//         '[^\w\d _-]'            => '',
//         '\s+'                    => $separator,
//         '('.$quoteSeparator.')+'=> $separator
//     );

//     $string = strip_tags($string);
//     foreach ($trans as $key => $val){
//         $string = preg_replace('#'.$key.'#i'.(UTF8_ENABLED ? 'u' : ''), $val, $string);
//     }

//     $string = strtolower($string);

//     return trim(trim($string, $separator));
// }

//Create Thumb Image
function create_thumb_image($target_folder ='',$thumb_folder = '', $thumb_width = '',$thumb_height = ''){
	  
	//folder path setup
	$target_path = $target_folder;
	$thumb_path = $thumb_folder;
		

		$thumbnail = $thumb_path;
		$upload_image = $target_path;

		list($width,$height) = getimagesize($upload_image);
		$thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
		switch($file_ext){
			case 'jpg':
				$source = imagecreatefromjpeg($upload_image);
				break;
			case 'jpeg':
				$source = imagecreatefromjpeg($upload_image);
				break;
			case 'png':
				$source = imagecreatefrompng($upload_image);
				break;
			case 'gif':
				$source = imagecreatefromgif($upload_image);
					break;
			default:
				$source = imagecreatefromjpeg($upload_image);
		}
	imagecopyresized($thumb_create, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width,$height);
		switch($file_ext){
			case 'jpg' || 'jpeg':
				imagejpeg($thumb_create,$thumbnail,80);
				break;
			case 'png':
				imagepng($thumb_create,$thumbnail,80);
				break;
			case 'gif':
				imagegif($thumb_create,$thumbnail,80);
					break;
			default:
				imagejpeg($thumb_create,$thumbnail,80);
		}
}

function pagination($count, $Limit,$page, $lastpage,$sqlstring,$pagename)
{
    $p = explode('?',$pagename);
    $pagenam = $p[0];
    if($count>$Limit) {
        echo '
        <div class="widget-foot">
        <!--WI_PAGINATION-->
        <ul class="pagination flex-wrap">';
           $Nav= ""; 
        if($page > 1) { 
           $Nav .= '<li><a class="page-link" href="'.$pagenam.'?page='.($page-1).$sqlstring.'">Prev</a></li>'; 
        } 
        for($i = 1 ; $i <= $lastpage ; $i++) { 
        if($i == $page) { 
           $Nav .= '<li class="page-item active"><a class="page-link" href="">'.$i.'</a></li>'; 
        } else { 
           $Nav .= '<li><a class="page-link" href="'.$pagenam.'?page='.$i.$sqlstring.'">'.$i.'</a></li>';
        } } 
        if($page < $lastpage) { 
           $Nav .= '<li><a class="page-link"  href="'.$pagenam.'?page='.($page+1).$sqlstring.'">Next</a><li>'; 
        } 
           echo $Nav;
        echo '
        </ul>
        <!--WI_PAGINATION-->
           <div class="clearfix"></div>
        </div>';
        }
        // ------------------------------------------------
        else if($count == 0) { 
        //------------------------------------------------
        echo '
        <div class="col-lg-12">
           <div class="widget-tabs-notification" style="overflow: auto;">No Result Found</div>
        </div>';
        //------------------------------------------------
        }
}

function calculateElapsedTime() {
    if (isset($_SESSION['login_time'])) {
        $currentTime = time();
        $loginTime = $_SESSION['login_time'];
        $elapsedTime = $currentTime - $loginTime;
        return $elapsedTime;
    }
    return 0; // If the login time is not set, return 0
}
?>