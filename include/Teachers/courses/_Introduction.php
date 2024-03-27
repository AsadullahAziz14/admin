<?php 
//--------------------------------------------
echo '
<!--WI_PROJECT_NAV_CONTENT-->
<div class="col-lg-9">
<div class="widget">
<div class="widget-content widget-content-project">
<div class="project-info-tabs">

<!--WI_MILESTONES_NAVIGATION-->
<div class="row">
	<div class="col-lg-12">
		<div class="tabs-sub-nav">
			<span class="pull-left"><h3  style="font-weight:700;">Introduction</h3></span>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<!--WI_MILESTONES_NAVIGATION-->

<!--WI_MILESTONES_TABLE-->
<div class="row">
<div class="col-lg-12">
  
<div class="widget wtabs">
<div class="widget-content">
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:95%;">
<form class="form-horizontal" action="courses.php?id='.$_GET['id'].'" method="post" id="editAssign" enctype="multipart/form-data">
<input type="hidden" name="id_curs" name="id_curs" value="'.$_GET['id'].'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" onclick="location.href=\'courses.php?id='.$_GET['id'].'\'"><span>close</span></button>
	<h4 class="modal-title" style="font-weight:700;">Add Introducation</h4>
</div>

<div class="modal-body">

	
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:250px;"><b> Introducation of Course</b></label>
		<div class="col-lg-12">
			<textarea class="form-control ckeditor" id="detail" name="detail" required autocomplete="off"></textarea>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" onclick="location.href=\'courses.php?id='.$_GET['id'].'\'" >Close</button>
	<input class="btn btn-primary" type="submit" value="Add Record" id="submit_lesson" name="submit_lesson">
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
	$("#status").select2({
        allowClear: true
    });
	
	$("#weekno").select2({
        allowClear: true
    });
	
	
</script>
<script type="text/javascript" src="js/jquery/jquery.js"></script>
<script type="text/javascript">
$().ready(function() {
	$("#editAssign").validate({
		rules: {
             status_edit			: "required",
			 caption_edit			: "required",
			 date_start_edit		: "required",
			 date_end_edit			: "required",
			 detail_edit			: "required" ,
			 total_marks_edit: {
                required: true,
                number: true
            },
			passing_marks_edit: {
                required: true,
                number: true
            }
		},
		messages: {
			status_edit			: "This field is required",
			caption_edit		: "This field is required",
			date_start_edit		: "This field is required",
			date_end_edit		: "This field is required",
			detail_edit			: "This field is required" ,
		
		},
		submitHandler: function(form) {
        //alert("form submitted");
		form.submit();
        }
	});
});

</script>

<!--WI_ADD_NEW_TASK_MODAL-->
	
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