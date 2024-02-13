<?php 
	include "dbsetting/lms_vars_config.php";
	include "dbsetting/classdbconection.php";
	$dblms = new dblms();
	include "functions/login_func.php";
	include "functions/functions.php";
	checkCpanelLMSALogin();
	require_once("include/header.php");

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

if(!LMS_VIEW && !isset($_GET['id'])) {
    $sql2 = '';
    $sqlstring	= "";
    require_once("include/page_title.php"); 

echo '<title>'.TITLE_HEADER.'</title>
<!-- Matter -->
<div class="matter">
    <div class="container">
        <div class="row fullscreen-mode">
            <div class="col-lg-12">
                <div class="widget">
                    <div class="widget-content">';
                        echo'    
                        <div class="table-responsive" style="overflow: auto;" nowrap="nowrap">
                            <table class="footable table table-bordered table-hover table-with-avatar">';
                                $srno = 1;
                                if(COURSE_TYPE == '1') {
                                    echo '
                                <thead>
                                    <tr>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Sr. #</th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Program</th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Course</th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Type</th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Semester</th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Section</th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Session</th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Teacher</th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Manage CLOs </th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Manage Quiz </th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Manage Assignment </th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Manage Mid Term </th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Manage Final Term </th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Attainment Sheet </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td nowrap="nowrap">'.$srno.'</td>
                                        <td nowrap="nowrap">'.ID_PRG_ARRAY[ID_PRG].'</td>
                                        <td nowrap="nowrap">'.ID_COURSE_ARRAY[ID_COURSE].'</td>
                                        <td nowrap="nowrap">'.COURSE_TYPE_ARRAY[COURSE_TYPE].'</td>
                                        <td nowrap="nowrap">'.SEMESTER_ARRAY[SEMESTER].'</td>
                                        <td nowrap="nowrap">'.SECTION.'</td>
                                        <td nowrap="nowrap">'.ACADEMIC_SESSION.'</td>
                                        <td nowrap="nowrap">'.ID_TEACHER_ARRAY[ID_TEACHER].'</td>
                                        <td nowrap="nowrap"><a class="btn btn-success" href="obeclos.php"> Manage CLOs</a></td>
                                        <td nowrap="nowrap"><a class="btn btn-success" href="obequizzes.php"> Manage Quiz</a></td>
                                        <td nowrap="nowrap"><a class="btn btn-success" href="obeassignments.php"> Manage Assignment</a></td>
                                        <td nowrap="nowrap"><a class="btn btn-success" href="obemidterms.php"> Manage Mid Term</a></td>
                                        <td nowrap="nowrap"><a class="btn btn-success" href="obefinalterms.php"> Manage Final Term</a></td>
                                        <td nowrap="nowrap"><a class="btn btn-success" href="obetheoryattainmentsheet.php"> Attainment Sheet</a></td>
                                        <td nowrap="nowrap"></td>
                                    </tr>
                                </tbody>';
                                } elseif(COURSE_TYPE == '2') {
                                    echo '
                                <thead>
                                    <tr>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Sr. #</th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Program</th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Course</th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Type</th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Semester</th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Section</th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Session</th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Teacher</th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Manage PACs </th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Manage KPIs </th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Manage Paracticals </th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Manage Final Term </th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Sessionals Sheet </th>
                                        <th style="vertical-align: middle;" nowrap="nowrap"> Attainment Sheet</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="vertical-align: middle;" nowrap="nowrap">'.$srno.'</td>
                                        <td style="vertical-align: middle;" nowrap="nowrap">'.ID_PRG_ARRAY[ID_PRG].'</td>
                                        <td nowrap="nowrap">'.ID_COURSE_ARRAY[ID_COURSE].'</td>
                                        <td nowrap="nowrap">'.COURSE_TYPE_ARRAY[COURSE_TYPE].'</td>
                                        <td nowrap="nowrap">'.SEMESTER_ARRAY[SEMESTER].'</td>
                                        <td nowrap="nowrap">'.SECTION.'</td>
                                        <td nowrap="nowrap">'.ACADEMIC_SESSION.'</td>
                                        <td nowrap="nowrap">'.ID_TEACHER_ARRAY[ID_TEACHER].'</td>
                                        <td nowrap="nowrap"><a class="btn btn-success" href="obepacs.php"> Manage PACs</a></td>
                                        <td nowrap="nowrap"><a class="btn btn-success" href="obekpis.php"> Manage KPIs</a></td>
                                        <td nowrap="nowrap"><a class="btn btn-success" href="obeparacticals.php"> Manage Paracticals</a></td>
                                        <td nowrap="nowrap"><a class="btn btn-success" href="obefinalterms.php"> Manage Final Term</a></td>
                                        <td nowrap="nowrap"><a class="btn btn-success" href="obeparacticalsssionals.php"> Sessionals Sheet</a></td>
                                        <td nowrap="nowrap"><a class="btn btn-success" href="obeparacticalattainmentsheet.php"> Complete Award List</a></td>
                                    </tr>
                                </tbody>'; 
                                }
                                echo '
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';
}
echo '
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
			<div class="col-md-12">s
				<p class="copy">Powered by: | <a href="'.COPY_RIGHTS_URL.'" target="_blank">'.COPY_RIGHTS.'</a> </p>
			</div>
		</div>
	</div>
</footer>
<!-- Footer ends -->

<!-- Scroll to top -->
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>';
?>
<!--JS_SELECT_LISTS-->
<script type="text/javascript">
// close the div in 5 secs
window.setTimeout("closeHelpDiv();", 5000, 2500);

function closeHelpDiv(){
	document.getElementById("infoupdated").style.display=" none";
}
</script>


<script type="text/javascript" src="js/custom/all-vendors.js"></script>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="js/noty/jquery.noty.packaged.min.js"></script>
<script type="text/javascript">
	$(function () {
		$('.footable').footable();
	});
</script>
<script type="text/javascript" src="js/custom/custom.js"></script>
<script type="text/javascript" src="js/custom/custom.general.js"></script>
<!--JS_ADD_NEW_TASK_MODAL-->

	<!--JS_ADD_NEW_TASK_MODAL-->
</body>
</html>';