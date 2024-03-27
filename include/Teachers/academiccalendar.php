<?php 
//----------------------------------------
echo '<title>Academic Calendar for Session: '.$_SESSION['userlogininfo']['LOGINIDACADYEAR'].' - '.TITLE_HEADER.'</title>
<script type="text/javascript" src="js/jquery/jquery.js"></script>
<!-- Matter -->
<div class="matter">
<div class="widget headerbar-widget">
	<div class="pull-left dashboard-user-picture"><img class="avatar-small" src="'.$_SESSION['userlogininfo']['LOGINIDAPIC'].'" alt="'.$_SESSION['userlogininfo']['LOGINFNAMEA'].'"/></div>
	<div class="headerbar-project-title pull-left">
		<h3 style="font-weight:600;">'.$_SESSION['userlogininfo']['LOGINFNAMEA'].'</h3>
	</div>
	<div class="dashboard-user-group pull-right">
		<label class="label label-default">'.$_SESSION['userlogininfo']['LOGINFNAMEA'].'</label>
	</div>
	<div class="clearfix"></div>
</div>
<!--WI_CLIENTS_SEARCH END-->
<div class="container">
<!--WI_MY_TASKS_TABLE-->
<div class="row fullscreen-mode">
<div class="col-md-12">
<div class="widget">
<div class="widget-content">';

//----------------------------------------------------------------
	$sqllms  = $dblms->querylms("SELECT  id, status, session, dated, for_program   
										FROM ".ACALENDAR." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
										AND for_program = '1' AND published = '1' AND status = '1' 
										AND session ='".cleanvars($_SESSION['userlogininfo']['LOGINIDCALENDAR'])."' LIMIT 1");
	
//--------------------------------------------------
if (mysqli_num_rows($sqllms) > 0) {
$rowacd = mysqli_fetch_array($sqllms);
//------------------------------------------------
echo '
<h4 class="modal-title" style="font-weight:700; margin:10px;"> 
	Academic Calendar for Morning Session ('.$_SESSION['userlogininfo']['LOGINIDCALENDAR'].')
</h4>';

//---------------------------------------
echo '
<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600; text-align:center;">Sr #</th>
	<th style="font-weight:600;">Particular</th>
	<th style="font-weight:600;">Start Date</th>
	<th style="font-weight:600;">End Date</th>
	<th style="font-weight:600;">Remarks</th>
</tr>
</thead>
<tbody>';
//--------------Fee History----------------------------------
$sqllmsfeecats  = $dblms->querylms("SELECT d.id, d.id_setup, d.id_cat, d.date_start, d.date_end, d.remarks, c.cat_name  
										FROM ".ACALENDAR_DETAILS." d 
										INNER JOIN ".ACALENDAR_PARTICULARS." c ON c.cat_id = d.id_cat
										WHERE c.cat_status = '1' AND d.id_setup = '".cleanvars($rowacd['id'])."' 
										ORDER BY d.date_start ASC");
$sri1 = 0;
//------------------------------------------------
while($rowfeecats = mysqli_fetch_array($sqllmsfeecats)) { 
$sri1++;

//------------------------------------------------
	if($rowfeecats['date_start'] == '0000-00-00') { 
		$sdatee = '';
	} else { 
		$sdatee = date("d, F Y", strtotime($rowfeecats['date_start']));
	}
	if($rowfeecats['date_end'] == '0000-00-00') { 
		$edatee = '';
	} else { 
		$edatee = date("d, F Y", strtotime($rowfeecats['date_end']));
	}
//------------------------------------------------
echo '
<tr>
	<td style="text-align:center;width:50px;">'.$sri1.'</td>
	<td>'.$rowfeecats['cat_name'].'</td>
	<td style="width:150px;">'.$sdatee.'</td>
    <td style="width:150px;">'.$edatee.'</td>
	<td style="width:250px;">'.$rowfeecats['remarks'].'</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//-----------------------------------------

//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}


//----------------------------------------------------------------
	$sqllmsevening  = $dblms->querylms("SELECT  id, status, session, dated, for_program   
										FROM ".ACALENDAR." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
										AND for_program = '4' AND published = '1' AND status = '1' 
										AND session ='".cleanvars($_SESSION['userlogininfo']['LOGINIDCALENDAR'])."' LIMIT 1");
	
//--------------------------------------------------
if (mysqli_num_rows($sqllmsevening) > 0) {
$rowacdeven = mysqli_fetch_array($sqllmsevening);
//------------------------------------------------
echo '
<h4 class="modal-title" style="font-weight:700; margin:10px;"> 
	Academic Calendar for Evening Session ('.$_SESSION['userlogininfo']['LOGINIDCALENDAR'].')
</h4>';

//---------------------------------------
echo '
<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600; text-align:center;">Sr #</th>
	<th style="font-weight:600;">Particular</th>
	<th style="font-weight:600;">Start Date</th>
	<th style="font-weight:600;">End Date</th>
	<th style="font-weight:600;">Remarks</th>
</tr>
</thead>
<tbody>';
//--------------Fee History----------------------------------
$sqllmsevencats  = $dblms->querylms("SELECT d.id, d.id_setup, d.id_cat, d.date_start, d.date_end, d.remarks, c.cat_name  
										FROM ".ACALENDAR_DETAILS." d 
										INNER JOIN ".ACALENDAR_PARTICULARS." c ON c.cat_id = d.id_cat
										WHERE c.cat_status = '1' AND d.id_setup = '".cleanvars($rowacdeven['id'])."' 
										ORDER BY d.date_start ASC");
$sr1 = 0;
//------------------------------------------------
while($rowevencats = mysqli_fetch_array($sqllmsevencats)) { 
$sr1++;

//------------------------------------------------
	if($rowevencats['date_start'] == '0000-00-00') { 
		$evensdatee = '';
	} else { 
		$evensdatee = date("d, F Y", strtotime($rowevencats['date_start']));
	}
	if($rowevencats['date_end'] == '0000-00-00') { 
		$evenedatee = '';
	} else { 
		$evenedatee = date("d, F Y", strtotime($rowevencats['date_end']));
	}
//------------------------------------------------
echo '
<tr>
	<td style="text-align:center;width:50px;">'.$sr1.'</td>
	<td>'.$rowevencats['cat_name'].'</td>
	<td style="width:150px;">'.$evensdatee.'</td>
    <td style="width:150px;">'.$evenedatee.'</td>
	<td style="width:250px;">'.$rowevencats['remarks'].'</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//-----------------------------------------

//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}

//----------------------------------------------------------------
	$sqllmsweekend  = $dblms->querylms("SELECT  id, status, session, dated, for_program   
										FROM ".ACALENDAR." 
										WHERE id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'  
										AND for_program = '2' AND published = '1' AND status = '1' 
										AND session ='".cleanvars($_SESSION['userlogininfo']['LOGINIDCALENDAR'])."' LIMIT 1");
	
//--------------------------------------------------
if (mysqli_num_rows($sqllmsweekend) > 0) {
$rowacdweekend = mysqli_fetch_array($sqllmsweekend);
//------------------------------------------------
echo '
<h4 class="modal-title" style="font-weight:700; margin:10px;"> 
	Academic Calendar for Weekend Session ('.$_SESSION['userlogininfo']['LOGINIDCALENDAR'].')
</h4>';

//---------------------------------------
echo '
<div style="clear:both;"></div>
<table class="table table-bordered table-hover">
<thead>
<tr>
	<th style="font-weight:600; text-align:center;">Sr #</th>
	<th style="font-weight:600;">Particular</th>
	<th style="font-weight:600;">Start Date</th>
	<th style="font-weight:600;">End Date</th>
	<th style="font-weight:600;">Remarks</th>
</tr>
</thead>
<tbody>';
//--------------Fee History----------------------------------
$sqllmsweekendcats  = $dblms->querylms("SELECT d.id, d.id_setup, d.id_cat, d.date_start, d.date_end, d.remarks, c.cat_name  
										FROM ".ACALENDAR_DETAILS." d 
										INNER JOIN ".ACALENDAR_PARTICULARS." c ON c.cat_id = d.id_cat
										WHERE c.cat_status = '1' AND d.id_setup = '".cleanvars($rowacdweekend['id'])."' 
										ORDER BY d.date_start ASC");
$sr2 = 0;
//------------------------------------------------
while($rowweekcats = mysqli_fetch_array($sqllmsweekendcats)) { 
$sr2++;

//------------------------------------------------
	if($rowweekcats['date_start'] == '0000-00-00') { 
		$weekendsdatee = '';
	} else { 
		$weekendsdatee = date("d, F Y", strtotime($rowweekcats['date_start']));
	}
	if($rowweekcats['date_end'] == '0000-00-00') { 
		$weekendedatee = '';
	} else { 
		$weekendedatee = date("d, F Y", strtotime($rowweekcats['date_end']));
	}
//------------------------------------------------
echo '
<tr>
	<td style="text-align:center;width:50px;">'.$sr2.'</td>
	<td>'.$rowweekcats['cat_name'].'</td>
	<td style="width:150px;">'.$weekendsdatee.'</td>
    <td style="width:150px;">'.$weekendedatee.'</td>
	<td style="width:250px;">'.$rowweekcats['remarks'].'</td>
</tr>';
//------------------------------------------------
} // end while loop
//------------------------------------------------
echo '
</tbody>
</table>';
//-----------------------------------------

//------------------------------------------------
} else { 
//------------------------------------------------
echo '
<div class="col-lg-12">
	<div class="widget-tabs-notification">No Result Found</div>
</div>';
//------------------------------------------------
}
echo '
</div>
</div>
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
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>';
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
					<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Closed</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!--WI_IFRAME_MODAL-->
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
		$(".footable").footable();
	});
</script>
<script type="text/javascript" src="js/custom/custom.js"></script>
<script type="text/javascript" src="js/custom/custom.general.js"></script>
</body>
</html>'; 
//--------------------------------
?>