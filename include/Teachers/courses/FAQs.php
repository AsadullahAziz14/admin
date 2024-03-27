<?php 
//--------------------------------------------
	include_once("faqs/query.php");
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
if(isset($_GET['archive'])) { $captionh = 'Archive of Frequently Asked Questions'; } else { $captionh = 'Frequently Asked Questions'; }
//--------------------------------------
echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">'.$captionh.'</h3></span> 
			<a class="btn btn-mid btn-success pull-right" href="courses.php?id='.$_GET['id'].'&view=FAQs&archive"><i class="icon-list"></i> Archive</a> 
			<a  class="btn btn-mid btn-info pull-right" href="courses.php?id='.cleanvars($_GET['id']).'&view=FAQs&add"><i class="icon-plus"></i> Add FAQs </a> <a class="btn btn-mid btn-purple pull-right" href="courses.php?id='.$_GET['id'].'&view=FAQs"><i class="icon-list"></i> List</a> 
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
//--------------------------------------------
	include_once("faqs/list.php");
	include_once("faqs/add.php");
	include_once("faqs/archive.php");
	include_once("faqs/edit.php");
//--------------------------------------------
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

?>