<?php 
//--------------------------------------------
	include_once("drivelinks/query.php");
//--------------------------------------------
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">';
//--------------------------------------
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
} 
if(isset($_GET['archive'])) { $captionh = 'Archive of Web Links'; } else { $captionh = 'Google Drive Links'; }
//--------------------------------------
echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">'.$captionh.'</h3></span>
			
			<!--a class="btn btn-mid btn-info pull-right" href="courses.php?id='.cleanvars($_GET['id']).'&view=Drivelinks&add"><i class="icon-plus"></i> Add More </a--> 
			<a class="btn btn-mid btn-purple pull-right" href="courses.php?id='.$_GET['id'].'&view=Drivelinks"><i class="icon-list"></i> List</a>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<!--WI_MILESTONES_NAVIGATION-->

<!--WI_MILESTONES_TABLE-->
<div class="row">
<div class="col-lg-12">
  
<div class="widget wtabs">
<div class="widget-content">';
//------------------------------------------------
	include_once("drivelinks/list.php");
	include_once("drivelinks/add.php");
	include_once("drivelinks/edit.php");
//------------------------------------------------
echo '

</div>
</div>
</div>
</div>

<!--WI_MILESTONES_TABLE-->
<!--WI_TABS_NOTIFICATIONS-->

</div>
<div class="clearfix"></div>
</div>
</div>
</div>'; 
