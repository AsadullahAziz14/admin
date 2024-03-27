<?php 
//--------------------------------------------
	include_once("resources/query.php");
//--------------------------------------------
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>';
//--------------------------------------
if(isset($_SESSION['msg'])) { 
	echo $_SESSION['msg']['status'];
	unset($_SESSION['msg']);
} 
if(isset($_GET['archive'])) { $captionh = 'Archives'; } else { $captionh = 'Course Resources'; }
//--------------------------------------
echo '
<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">'.$captionh.'</h3></span>
			<span class="form-group">
			<select id="projects-list6" data-placeholder="Select Type" style="width:200px; text-align:left !important;" onChange="if (this.options[this.options.selectedIndex].value.length > 1) top.location.href = this.options[this.options.selectedIndex].value;" >
			<option></option>';
			foreach($CourseResources as $itemtype) {
				echo '<option value="courses.php?id='.$_GET['id'].'&view=Resources&idtype='.$itemtype['id'].'">'.$itemtype['name'].'</option>';
			}
echo '	</select>
	</span>  
			<a class="btn btn-mid btn-success pull-right" href="courses.php?id='.$_GET['id'].'&view=Resources&archive"><i class="icon-list"></i> Archive</a>
			<a class="btn btn-mid btn-info pull-right" href="courses.php?id='.$_GET['id'].'&view=Resources&add"><i class="icon-plus"></i> Add Record </a> 
			<a class="btn btn-mid btn-purple pull-right" href="courses.php?id='.$_GET['id'].'&view=Resources"><i class="icon-list"></i> List</a>
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
	include_once("resources/list.php");
	include_once("resources/add.php");
	include_once("resources/archive.php");
	include_once("resources/edit.php");
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
</div>
<script>

    $("#projects-list6").select2({
        allowClear: true
    });

</script>'; 