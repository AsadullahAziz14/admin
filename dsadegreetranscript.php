<?php 
//Require Vars, DB Connection and Function Files
require_once('dbsetting/lms_vars_config.php');
require_once('dbsetting/classdbconection.php');
$dblms = new dblms();
require_once('functions/login_func.php');
require_once('functions/functions.php');
require_once('functions/studentservices.php');

//User Authentication
checkCpanelLMSALogin();

//If User Type isn't Staff
if(($_SESSION['userlogininfo']['LOGINAFOR'] != 1)) { 

	//Redirects to Index
	header('location: index.php');

//Check If User has rights
} else if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 8) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 9) || arrayKeyValueSearch($_SESSION['userroles'], 'right_name', '190')) {  

    // require_once 'functions/UserInfo.php';
    // $devicedetails 	= UserInfo::get_device().' '.UserInfo::get_os().' '.UserInfo::get_browser() .'<br>'.htmlentities($_SERVER['HTTP_USER_AGENT']);

    include_once("include/header.php");
    
    $sql2 			    = '';
	$sql13 		  	    = '';
    $sqlstring		    = "";
    $srch	  	  	    = (isset($_GET['srch']) && $_GET['srch'] != '') ? $_GET['srch'] : '';
    $fromDate	        = (isset($_GET['fromdate']) && $_GET['fromdate'] != '') ? $_GET['fromdate'] : '';
	$toDate	  	        = (isset($_GET['todate']) && $_GET['todate'] != '') ? $_GET['todate'] : '';
    $sts	  	  	    = (isset($_GET['sts']) && $_GET['sts'] != '') ? $_GET['sts'] : '';
    $currentlyAt	  	= (isset($_GET['ca']) && $_GET['ca'] != '') ? $_GET['ca'] : '';
	$sems	  	  	    = (isset($_GET['sems']) && $_GET['sems'] != '') ? $_GET['sems'] : '';
	$degreeTranscript	= (isset($_GET['degree_tran']) && $_GET['degree_tran'] != '') ? $_GET['degree_tran'] : '';
	$originalDuplicate	= (isset($_GET['od']) && $_GET['od'] != '') ? $_GET['od'] : '';
	$normalUrgent	    = (isset($_GET['nu']) && $_GET['nu'] != '') ? $_GET['nu'] : '';
	$completePartial	= (isset($_GET['cp']) && $_GET['cp'] != '') ? $_GET['cp'] : '';
	$programID	        = (isset($_GET['prg']) && $_GET['prg'] != '') ? $_GET['prg'] : '';
	$departmentID	    = (isset($_GET['dept']) && $_GET['dept'] != '') ? $_GET['dept'] : '';
	$facultyID	        = (isset($_GET['faculty']) && $_GET['faculty'] != '') ? $_GET['faculty'] : '';
	$paidDate	        = (isset($_GET['paid_date']) && $_GET['paid_date'] != '') ? $_GET['paid_date'] : '';
	$awaitingResposne	= (isset($_GET['ar']) && $_GET['ar'] != '') ? $_GET['ar'] : '';
	$recentActivity	    = (isset($_GET['ra']) && $_GET['ra'] != '') ? $_GET['ra'] : '';


    // if($_SESSION['userlogininfo']['LOGINDEPT']) {
    //     $studentDepartment = "AND std.id_dept = '".cleanvars($_SESSION['userlogininfo']['LOGINDEPT'])."'";
    // } else { 
    //     $studentDepartment = "";
    // }

    // if($_SESSION['userlogininfo']['LOGINFACULTIES']) {
    //     $studentFaculty = "AND std.id_faculty = '".cleanvars($_SESSION['userlogininfo']['LOGINFACULTIES'])."'";
    // } else { 
    //     $studentFaculty = "";
    // }

    if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '190', 'add' => '1'))) {
        
        $sqlLastForwadedCondition = "";

    } else {

        $sqlLastForwadedCondition = "AND EXISTS (
                SELECT la.id
                    FROM ".DSA_APPLICATIONS_FORWARD." la
                    WHERE la.id_application = sa.id AND la.id = (SELECT MAX(laf.id) FROM ".DSA_APPLICATIONS_FORWARD." laf WHERE laf.id_application = sa.id) 
                    AND FIND_IN_SET('".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."', la.forwaded_to) 
                    ORDER BY la.id DESC LIMIT 1
            )
        ";
    }

    $programsArray = array();
	$queryPrograms	= $dblms->querylms("SELECT prg_id, prg_name 
                                            FROM ".PROGRAMS." 
                                            WHERE prg_status = '1' 
                                            AND id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
                                            ORDER BY prg_name ASC");
	while($valueProgram  = mysqli_fetch_array($queryPrograms)) {
		$programsArray[] = $valueProgram;
	}

    $departmentssarray = array();
	$sqllmsDepartment	= $dblms->querylms("SELECT dept_id, dept_name, dept_domain  
                                                FROM ".DEPTS." 
                                                WHERE dept_status = '1' AND dept_type = '1'
                                                AND id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
                                                ORDER BY dept_name ASC");
	while($valueDepartment  = mysqli_fetch_array($sqllmsDepartment)) {
		$departmentssarray[] = $valueDepartment;
	}

    $facultiesArray = array();
	$queryFaculty = $dblms->querylms("SELECT faculty_id, faculty_name
                                            FROM ".FACULTIES." 
                                            WHERE faculty_status = '1' 
                                            AND id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."' 
                                            ORDER BY faculty_name ASC");
	while($valueFaculty  = mysqli_fetch_array($queryFaculty)) {
		$facultiesArray[] = $valueFaculty;
	}
	
    if(($srch)) { 
        $sql2 		.= " AND (sa.reference_no LIKE '%".$srch."%' OR sa.full_name LIKE '%".$srch."%' OR sa.mobile LIKE '%".$srch."%' OR std.std_name LIKE '%".$srch."%' OR std.std_regno LIKE '%".$srch."%')"; 
        $sqlstring	.= "&srch=".$srch."";
    }

    if($fromDate && $toDate) { 
		$sql2 		.= " AND sa.dated BETWEEN '".$fromDate."' AND '".$toDate."'"; 
		$sqlstring	.= "&fromdate=".$fromDate."&todate=".$toDate."";
	}

	if($fromDate && !$toDate) { 
		$sql2 		.= " AND sa.dated = '".$fromDate."'"; 
		$sqlstring	.= "&fromdate=".$fromDate."";
	}

	if(!$fromDate && $toDate) { 
		$sql2 		.= " AND sa.dated = '".$toDate."'"; 
		$sqlstring	.= "&todate=".$toDate."";
	}
	
	if(($sts)) { 
        $sql2 		.= " AND sa.status = '".$sts."'"; 
        $sqlstring	.= "&sts=".$sts."";
    }

    if(($currentlyAt)) { 
        $sql2 		.= " AND sa.currently_at = '".$currentlyAt."'"; 
        $sqlstring	.= "&ca=".$currentlyAt."";
    }


    if(($degreeTranscript)) { 
        $sql2 		.= " AND sa.degree_transcript = '".$degreeTranscript."'"; 
        $sqlstring	.= "&degree_tran=".$degreeTranscript."";
    }

    if(($originalDuplicate)) { 
        $sql2 		.= " AND sa.original_duplicate = '".$originalDuplicate."'"; 
        $sqlstring	.= "&od=".$originalDuplicate."";
    }

    if(($normalUrgent)) { 
        $sql2 		.= " AND sa.normal_urgent = '".$normalUrgent."'"; 
        $sqlstring	.= "&nu=".$normalUrgent."";
    }

    if(($completePartial)) { 
        $sql2 		.= " AND sa.complete_partial = '".$completePartial."'"; 
        $sqlstring	.= "&cp=".$completePartial."";
    }

    if(($programID)) { 
        $sql2 		.= " AND std.id_prg = '".$programID."'"; 
        $sqlstring	.= "&prg=".$programID."";
    }

    if(($departmentID)) { 
        $sql2 		.= " AND std.id_dept = '".$departmentID."'"; 
        $sqlstring	.= "&dept=".$departmentID."";
    }

    if(($facultyID)) { 
        $sql2 		.= " AND std.id_faculty = '".$facultyID."'"; 
        $sqlstring	.= "&faculty=".$facultyID."";
    }

    if(($paidDate)) { 
        $sql2 		.= " AND fee.paid_date = '".$paidDate."'"; 
        $sqlstring	.= "&paid_date=".$paidDate."";
    }

    if(($awaitingResposne)) { 
        $sqlLastForwadedCondition = "AND sa.status NOT IN ('4','5') AND EXISTS (
                SELECT la.id
                    FROM ".DSA_APPLICATIONS_FORWARD." la
                    WHERE la.id_application = sa.id AND la.id = (SELECT MAX(laf.id) FROM ".DSA_APPLICATIONS_FORWARD." laf WHERE laf.id_application = sa.id) 
                    AND FIND_IN_SET('".cleanvars($_SESSION['userlogininfo']['LOGINIDA'])."', la.forwaded_to) 
                    ORDER BY la.id DESC LIMIT 1
            )
        ";
        $sqlstring	.= "&ar=".$awaitingResposne."";
    }

    if(($recentActivity)) { 
        $sql2 = " AND EXISTS (SELECT l.id, l.date_added
						                        FROM ".DSA_APPLICATIONS_LOG." l
                                                WHERE l.id_application = sa.id
                                                AND l.date_added >= DATE_SUB(NOW(), INTERVAL 1 WEEK)
                                                ORDER BY l.date_added ASC
                             )";
        $sqlstring	.= "&ra=".$recentActivity."";
    }
    
    //Include Query
	include_once("include/Staffs/dsa/degree_transcript/query.php");

    echo '
    <title>Manage Degree/Transcript - '.TITLE_HEADER.'</title>
    <!-- Matter -->
    <div class="matter">
    <!--WI_CLIENTS_SEARCH-->
    <div class="navbar navbar-default" role="navigation">
    <!-- .container-fluid -->
    <div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle Navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    </div>
    <!-- .navbar-collapse -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <form class="navbar-form navbar-left form-small" action="" method="get">
        <div class="form-group">
            <input type="text" class="form-control" name="srch" placeholder="Ref #, Student RN, Name, Cell #" style="width:220px;" >
        </div>

        <div class="form-group">
            <input type="text" class="form-control pickadate" name="fromdate" placeholder="Date From" title="Date From" autocomplete="off" style="width:130px;" >
        </div>
        <div class="form-group">
            <input type="text" class="form-control pickadate" name="todate" placeholder="Date To" title="Date To" autocomplete="off" style="width:130px;" >
        </div>

		<div class="form-group">
		    <select id="degree_tran" data-placeholder="Degree/Transcript" name="degree_tran" style="width:200px">
                <option></option>';
                $i = 0;
                foreach($stdaffairstypes as $degreeTranscript){
                    echo '<option value="'.$degreeTranscript['id'].'">'.$degreeTranscript['name'].'</option>';
                    $i++;
                    if($i == 2) break;
                }
            echo '	
            </select>
        </div>

        <div class="form-group">
		    <select id="original_duplicate" name="od" data-placeholder="Original/Duplicate" style="width:180px">
                <option></option>';
                foreach($originalDuplicateArray as $od){
                    echo '<option value="'.$od['id'].'">'.$od['name'].'</option>';
                }
            echo '	
            </select>
        </div>

        <div class="form-group">
            <select id="normal_urgent" name="nu" data-placeholder="Normal/Urgent" style="width:180px">
                <option></option>';
                foreach($regularUrgentArray as $nu){
                    echo '<option value="'.$nu['id'].'">'.$nu['name'].'</option>';
                }
            echo '	
            </select>
        </div>

        <div class="form-group">
            <select id="complete_partial" name="cp" data-placeholder="Complete/Partial" style="width:180px">
                <option></option>
                <option value="1">Complete</option>
                <option value="2">Partial</option>
            </select>
        </div>

		<div class="form-group">
		    <select id="sts" data-placeholder="Status" name="sts" style="width:130px">
                <option></option>';
            foreach($dsaStatus as $status) {
                echo '<option value="'.$status['id'].'"'; if($sts == $status['id']) {echo 'selected';} echo '>'.$status['name'].'</option>';   
            }
            echo '	
            </select>
        </div>

        <div class="form-group">
		    <select id="ca" data-placeholder="Currently At" name="ca" style="width:130px">
                <option></option>';
            foreach($dsaApplicationCurrentLocation as $caStatus) {
                echo '<option value="'.$caStatus['id'].'"'; if($currentlyAt == $caStatus['id']) {echo 'selected';} echo '>'.$caStatus['name'].'</option>';   
            }
            echo '	
            </select>
        </div>


        <div class="form-group">
            <select id="program" name="prg" data-placeholder="Program" style="width:300px">
                <option></option>';
                foreach($programsArray as $valueProgram){
                    echo '<option value="'.$valueProgram['prg_id'].'">'.$valueProgram['prg_name'].'</option>';
                }
            echo '	
            </select>
        </div>

        <div class="form-group">
            <select id="department" name="dept" data-placeholder="Department" style="width:250px">
                <option></option>';
                foreach($departmentssarray as $valueDepartment){
                    echo '<option value="'.$valueDepartment['dept_id'].'">'.$valueDepartment['dept_name'].'</option>';
                }
            echo '	
            </select>
        </div>

        <div class="form-group">
            <select id="faculty" name="faculty" data-placeholder="Faculty" style="width:270px">
                <option></option>';
                foreach($facultiesArray as $valueFaculty){
                    echo '<option value="'.$valueFaculty['faculty_id'].'">'.$valueFaculty['faculty_name'].'</option>';
                }
            echo '	
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Search</button>
        <a href="dsadegreetranscript.php" class="btn btn-purple"><i class="icon-list"></i> All</a>
        <a href="dsadegreetranscript.php?ar=1" class="btn btn-warning"><i class="icon-list"></i> Awaiting Response</a>
        <a href="dsadegreetranscript.php?ra=1" class="btn btn-success"><i class="icon-list"></i> Recent Activity</a>';

    //--------------------------------------------
    if(($_SESSION['userlogininfo']['LOGINTYPE'] == 1) || ($_SESSION['userlogininfo']['LOGINTYPE'] == 2) || Stdlib_Array::multiSearch($_SESSION['userroles'], array('right_name' => '190', 'add' => '1'))) { 
        //echo ' <a class="btn btn-success" href="dsadegreetranscript.php?view=add"><i class="icon-plus"></i> Add Record</a>';
    }
    //--------------------------------------------
    echo '
    </form>
    </div>
    <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
    </div>
    <!--WI_CLIENTS_SEARCH END-->
    <div class="container">
    <!--WI_MY_TASKS_TABLE-->
    <div class="row fullscreen-mode">
    <div class="col-md-12">';

    if(isset($_SESSION['msg'])) { 
        echo $_SESSION['msg']['status'];
        unset($_SESSION['msg']);
    }

    include_once("include/Staffs/dsa/degree_transcript/list.php");
    // include_once("include/Staffs/dsa/degree_transcript/add.php");
    include_once("include/Staffs/dsa/degree_transcript/edit_detail.php");
    include_once("include/Staffs/dsa/degree_transcript/forward_hod.php");
    include_once("include/Staffs/dsa/degree_transcript/forward.php");

    echo '
    </div>
    </div>
    </div>
    </div>
    <!--WI_MY_TASKS_TABLE-->    
    <!--WI_NOTIFICATION-->
    </div>
    </div>
    <!-- Matter ends -->
    </div>
    <!-- Mainbar ends -->
    <div class="clearfix"></div>
    </div>
    <!-- Content ends -->

    <!-- Footer starts -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="copy">Powered by: | <a href="'.COPY_RIGHTS_URL.'" target="_blank">'.COPY_RIGHTS.'</a> </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer ends -->

    <!-- Scroll to top -->
    <span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>';
//------------------------------------------------
	//include_once("include/Staffs/dsa/degree_transcript/edit.php");
//------------------------------------------------
echo '
    <!--WI_IFRAME_MODAL-->
    <div class="row">
        <div id="modalIframe" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                        <button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
                        <h4 class="modal-title" id="modal-iframe-title"> Edit</h4>
                        <div class="clearfix"></div>
                    </div>
                    <div class="modal-body">
                        <iframe frameborder="0" class="slimScrollBarModal----"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--WI_IFRAME_MODAL-->
    <!--JS_SELECT_LISTS-->
    <script type="text/javascript" src="js/ebro_form_validate.js"></script>
    <script>
        $("#degree_tran").select2({
            allowClear: true
        });
        $("#original_duplicate").select2({
            allowClear: true
        });
        $("#normal_urgent").select2({
            allowClear: true
        });
        $("#complete_partial").select2({
            allowClear: true
        });
        $("#status").select2({
            allowClear: true
        });
        $("#program").select2({
            allowClear: true
        });
        $("#department").select2({
            allowClear: true
        });
        $("#faculty").select2({
            allowClear: true
        });
		$("#sts").select2({
            allowClear: true
        });
        $("#ca").select2({
            allowClear: true
        });
		$("#rr").select2({
            allowClear: true
        });
		$("#sems").select2({
            allowClear: true
        });
		$("#topadsess").select2({
            allowClear: true
        });
    </script>
    <!--JS_SELECT_LISTS-->
    
    <script>
        //USED BY: All date picking forms
        $(document).ready(function(){
            $(".pickadate").datepicker({
            format: "yyyy-mm-dd",
            language: "lang",
            autoclose: true,
            todayHighlight: true
            });	
        });
        $(document).ready(function(){
            $(".pickayear").datepicker({
            format: "yyyy",
            language: "lang",
            autoclose: true,
            todayHighlight: true
            });	
        });
        function CheckForm(){
            var checked=false;
            var elements = document.getElementsByName("curdel[]");
            for(var i=0; i < elements.length; i++){
                if(elements[i].checked) {
                    checked = true;
                }
            }
            if (!checked) {
                alert("at least one checkbox should be selected");
                return checked;
            } else if(confirm("Do you want to take action?")==true)  {  
                return true;  
            }  else  {  
                return false;  
            }  
        }
        function ClickCheckAll(vol) {  
            var iji=1;  
            for(iji=1;iji<=document.frmMain.hdnCount.value;iji++)  {  
                if(vol.checked == true)  {  
                    eval("document.frmMain.curdel"+iji+".checked=true");  
                } else  {  
                    eval("document.frmMain.curdel"+iji+".checked=false");  
                }  
            }  
        } 
    </script>

    <script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>
    <script>
        jQuery(function($) {
            $.mask.definitions["~"]="[+-]";
            $("#recipient_cnic").mask("99999-9999999-9");
            $("#dis_phone").mask("9999-9999999");
        });
    </script>

    <script type="text/javascript" src="js/custom/all-vendors.js"></script>
    <script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $(".footable").footable();
        });
    </script>
    <script type="text/javascript" src="js/custom/custom.js"></script>
    <script type="text/javascript" src="js/custom/custom.general.js"></script>
    </body>
    </html>';
}