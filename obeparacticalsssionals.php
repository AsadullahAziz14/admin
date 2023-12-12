<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
	include_once("include/header.php");

if(isset($_SESSION['msg'])) { 
    echo'
    <script>
        $().ready(function() 
        {
            toastr.options = 
            {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": 300,
                "hideDuration": 1000,
                "timeOut": 5000,
                "extendedTimeOut": 1000,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            } 

              '.$_SESSION['msg']['status'].'
        }); 
    </script>';
    unset($_SESSION['msg']);
}

$sql2 = '';
$sqlstring	= "";
if(isset($_GET['srch'])) { 
	// $sql2 		.= " b.block_name LIKE '".$stdsrch."%' ";
	$sqlstring	.= "&srch=".$_GET['srch']."";
}
if(isset($_GET['campus'])) { 
	$sql2 		.= " AND b.id_campus = '".$_GET['campus']."'"; 
	$sqlstring	.= "&campus=".$_GET['campus']."";
}
if(isset($_GET['event'])) { 
	$sql2 		.= " AND b.id_event = '".$_GET['event']."'"; 
	$sqlstring	.= "&event=".$_GET['event']."";
}
//----------------------------------------
echo '<title>'.TITLE_HEADER.'</title>
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
		<input type="text" class="form-control" name="srch" placeholder="Name" style="width:250px;" >
	</div>
	<button type="submit" class="btn btn-primary">Search</button>
	<a href="obeparacticalattainmentsheet.php" class="btn btn-purple"><i class="icon-list"></i> All</a>
</div>
<!-- /.navbar-collapse -->
</div>
<!-- /.container-fluid -->
</div>
<!--WI_CLIENTS_SEARCH END-->
<div class="container">
<!--WI_MY_TASKS_TABLE-->
<div class="row fullscreen-mode">
<div class="col-lg-12">
<div class="widget">';

echo '<div class="widget-content">';

    include ("include/Staffs/obe/paracticalsssionals/report.php");
         
echo'
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

</div>
</div>
<!--WI_MY_TASKS_TABLE-->
<!--WI_NOTIFICATION-->       
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
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>
';
?>
<!--JS_SELECT_LISTS-->
<script type="text/javascript">
// close the div in 5 secs
window.setTimeout("closeHelpDiv();", 5000, 2500);

function closeHelpDiv(){
	document.getElementById("infoupdated").style.display=" none";
}
</script>
<script>
//USED BY: VARIOUS
//ACTIONS: creates a nice pull down/select for each specified field
//REQUIRES: select2.js
//NOTES: no need for '$().ready(function()' as this only need jquery & select2.js which are loaded up top
    $("#status").select2({
        allowClear: true
    });
	$("#status_edit").select2({
        allowClear: true
    });
    $("#id_cat").select2({
        allowClear: true
    });
	$("#id_cat_edit").select2({
        allowClear: true
    });
</script>
<!--JS_SELECT_LISTS-->


<!--JS_ADD_NEW_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
    //USED BY: WI_ADD_NEW_TASK_MODAL
	//ACTIONS: validates the form and submits it
	//REQUIRES: jquery.validate.js
	$("#addNewPost").validate({
		rules: {
             caption	: "required",
		  	 metadetail	: "required",
			 detail		: "required",
			 status		: "required"
		},
		messages: {
			caption		: "This field is required",
			metadetail	: "This field is required",
			brief		: "This field is required",
			status		: "This field is required"
		},
		submitHandler: function(form) {
        //alert('form submitted');
		form.submit();
        }
	});
});
</script>
<!--JS_ADD_NEW_TASK_MODAL-->



<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>

<script>
//USED BY: All date picking forms
$(document).ready(function(){
    $('.pickadate').datepicker({
       format: "yyyy-mm-dd",
       language: "lang",
       autoclose: true,
       todayHighlight: true
    });	
});
</script>
<script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js"></script>
<script type="text/javascript">
	$(function () {
		$('.footable').footable();
	});
</script>
<script type="text/javascript" src="js/custom/custom.js"></script>
<script type="text/javascript" src="js/custom/custom.general.js"></script>
<script type="text/javascript">
	$().ready(function() {
		//USED BY: WI_ADD_NEW_TASK_MODAL
		//ACTIONS: validates the form and submits it
		//REQUIRES: jquery.validate.js
		$("#addNewBcat").validate({
			rules: {
				 event_name: "required",
				 event_status: "required"
			},
			messages: {
				event_name: "This field is required",
				event_status: "This field is required"
			},
			submitHandler: function(form) {
			//alert('form submitted');
			form.submit();
			}
		});
	});
	</script>
</body>
</html>

















