<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="empNewPubModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="profile.php?view=publications" method="post" id="addpubskill" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Publication Detail</h4>
</div>

<div class="modal-body">

	
	<div class="col-sm-61">
		<div class="form_sep" >
			<label class="req">Publication Type </label>
			<select id="id_type" name="id_type" style="width:100%" autocomplete="off" required>
				<option value="">Select Type</option>';
				foreach($publishtype as $listtype) {
				echo '<option value="'.$listtype['id'].'">'.$listtype['name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep">
			<label>Date/year</label>
			<input type="text" name="year_date" id="year_date" class="form-control" autocomplete="off">
		</div> 
	</div>

	<div style="clear:both;"></div>
	
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Title</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="title" name="title" required autofocus autocomplete="off">
		</div>
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Author </label>
			<input type="text" name="author" id="author" class="form-control" required autocomplete="off" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Co-Author</label>
			<input type="text" name="co_author" id="co_author" class="form-control" required autocomplete="off">
		</div> 
	</div>

	<div style="clear:both;"></div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"><b> URL</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="url" name="url" autocomplete="off">
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
		<input class="btn btn-primary" type="submit" value="Add Record" id="submit_publications" name="submit_publications">
	</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
	$("#id_type").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
	$("#addpubskill").validate({
		rules: {
             id_type		: "required",
			 program		: "required",
			 subjects		: "required",
			 institute		: "required"
		},
		messages: {
			id_degree		: "This field is required",
			program			: "This field is required",
			subjects		: "This field is required",
			institute		: "This field is required"
		},
		submitHandler: function(form) {
        //alert("form submitted");
		form.submit();
        }
	});
});
</script>
<!--WI_ADD_NEW_TASK_MODAL-->

<div class="row">
<div id="empEditPubModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="profile.php?view=publications" method="post" id="editEdukill" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Publication Detail</h4>
</div>

<div class="modal-body">

	<div class="col-sm-61">
		<div class="form_sep" >
			<label class="req">Publication Type </label>
			<select id="id_type_edit" name="id_type_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Type</option>';
				foreach($publishtype as $listtype) {
				echo '<option value="'.$listtype['id'].'">'.$listtype['name'].'</option>';
			}
	echo'
			</select>
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep">
			<label>Date/year</label>
			<input type="text" name="year_date_edit" id="year_date_edit" class="form-control" autocomplete="off">
		</div> 
	</div>

	<div style="clear:both;"></div>
	
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Title</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="title_edit" name="title_edit" required autofocus autocomplete="off">
		</div>
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Author </label>
			<input type="text" name="author_edit" id="author_edit" class="form-control" required autocomplete="off" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Co-Author</label>
			<input type="text" name="co_author_edit" id="co_author_edit" class="form-control" required autocomplete="off">
		</div> 
	</div>

	<div style="clear:both;"></div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label col-lg-12" style="width:150px;"><b> URL</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="url_edit" name="url_edit" autocomplete="off">
		</div>
	</div>


</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
	<input type="hidden" id="pubid_edit" name="pubid_edit" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_publications" name="changes_publications">
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
	$("#id_type_edit").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
	$("#editPubkill").validate({
		rules: {
             id_degree_edit		: "required",
			 program_edit		: "required",
			 subjects_edit		: "required",
			 institute_edit		: "required"
		},
		messages: {
			id_degree_edit		: "This field is required",
			program_edit		: "This field is required",
			subjects_edit		: "This field is required",
			institute_edit		: "This field is required"
		},
		submitHandler: function(form) {
        //alert("form submitted");
		form.submit();
        }
	});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
    $(".edit-pub-modal").click(function(){
    

        var id_type_edit 		= $(this).attr("data-pub-type");
		var title_edit 			= $(this).attr("data-pub-title");
		var author_edit 		= $(this).attr("data-pub-author");
		var co_author_edit 		= $(this).attr("data-pub-coauthor");
		var year_date_edit 		= $(this).attr("data-pub-yeardate");
		var url_edit 			= $(this).attr("data-pub-url");
		var pubid_edit 			= $(this).attr("data-pubid");

		$("#title_edit")		.val(title_edit);
		$("#author_edit")		.val(author_edit);
		$("#co_author_edit")	.val(co_author_edit);
		$("#year_date_edit")	.val(year_date_edit);
		$("#url_edit")			.val(url_edit);
		$("#pubid_edit")		.val(pubid_edit);

        $("#id_type_edit")		.select2().select2("val", id_type_edit); 
  });
    
});
</script>';