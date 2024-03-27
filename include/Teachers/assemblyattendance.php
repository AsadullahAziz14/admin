<?php 
//--------------------------------------------
	include_once("assemblyattendance/query.php");
//--------------------------------------------
echo '<title>Assembly Attendance - '.TITLE_HEADER.'</title>
<script type="text/javascript" src="js/jquery/jquery.js"></script>
<!----------------------COMMON PAGE HEADING--------------------------------->
<div class="matter">
<!----------------------COMMON PROJECT HEAD--------------------------------->
<!--WI_PROJECT_HEADER-->
<div class="headerbar">
	<div class="widget headerbar-widget">
	</div>
</div>
<!--WI_PROJECT_HEADER-->
<!----------------------COMMON PROJECT HEAD--------------------------------->
<div class="container">
<div class="row">';
//-------------------------------------
	include_once("assemblyattendance/list_programs.php");
	include_once("assemblyattendance/list_program-detail.php");
	include_once("assemblyattendance/edit.php");
//-------------------------------------
echo '
</div>
<!--WI_NOTIFICATION-->
</div>
</div>
</div>
<div class="clearfix"></div>
</div>
<!----------------------COMMON FOOTER--------------------------------->

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
//-------------------------------------
	include_once("assemblyattendance/addModal.php");
//-------------------------------------
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
<script type="text/javascript">
	// close the div in 5 secs
	window.setTimeout("closeHelpDiv();", 5000, 2500);
	function closeHelpDiv(){
		document.getElementById("infoupdated").style.display=" none";
	}
</script>
<script type="text/javascript" src="js/courses.js"></script>
<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>
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
</script>
<script type="text/javascript" src="js/custom/custom.js"></script>
<script type="text/javascript" src="js/custom/custom.general.js"></script>
</body>
</html>';
?>