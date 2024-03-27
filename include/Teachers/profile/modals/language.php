<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="empNewLangModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="profile.php?view=language" method="post" id="addLangskill" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Language Skill</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Language</b></label>
		<div class="col-lg-12">
			<select id="id_language" name="id_language" style="width:100%" autocomplete="off" required>
				<option value="">Select Language</option>';
			$sqllmslang		= $dblms->querylms("SELECT lang_id, lang_name FROM ".LANGS." WHERE lang_status = '1' ORDER BY lang_name ASC");
			while($rowlang 	= mysqli_fetch_array($sqllmslang)) {
				echo '<option value="'.$rowlang['lang_id'].'">'.$rowlang['lang_name'].'</option>';
			}
	echo'
			</select>
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Speaking Level</b></label>
		<div class="col-lg-12">
			<select id="speaking" name="speaking" style="width:100%" autocomplete="off" required>
				<option value="">Select Level</option>';
			foreach($levels as $speaklevels) {
				echo "<option value='$speaklevels[id]'>$speaklevels[name]</option>";
			}
	echo'
			</select>
		</div>
	</div>

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Reading Level</b></label>
		<div class="col-lg-12">
			<select id="reading" name="reading" style="width:100%" autocomplete="off" required>
				<option value="">Select Level</option>';
			foreach($levels as $readlevels) {
				echo "<option value='$readlevels[id]'>$readlevels[name]</option>";
			}
	echo'
			</select>
		</div>
	</div>


	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Writing Level</b></label>
		<div class="col-lg-12">
			<select id="writing" name="writing" style="width:100%" autocomplete="off" required>
				<option value="">Select Level</option>';
			foreach($levels as $writelevels) {
				echo "<option value='$writelevels[id]'>$writelevels[name]</option>";
			}
	echo'
			</select>
		</div>
	</div>
	


</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
		<input class="btn btn-primary" type="submit" value="Add Skill" id="submit_skill" name="submit_skill">
	</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>

    $("#writing").select2({
        allowClear: true
    });
	$("#reading").select2({
        allowClear: true
    });
	$("#speaking").select2({
        allowClear: true
    });
	$("#id_language").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
	$("#addLangskill").validate({
		rules: {
             id_language	: "required",
			 writing		: "required",
			 speaking		: "required",
			 reading		: "required"
		},
		messages: {
			id_language		: "This field is required",
			writing			: "This field is required",
			speaking		: "This field is required",
			reading			: "This field is required"
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
<div id="empEditSkillModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="profile.php?view=language" method="post" id="editLangskill" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Language Skill</h4>
</div>

<div class="modal-body">

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Language</b></label>
		<div class="col-lg-12">
			<select id="id_language_edit" name="id_language_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Language</option>';
			$sqllmslang		= $dblms->querylms("SELECT lang_id, lang_name FROM ".LANGS." WHERE lang_status = '1' ORDER BY lang_name ASC");
			while($rowlang 	= mysqli_fetch_array($sqllmslang)) {
				echo '<option value="'.$rowlang['lang_id'].'">'.$rowlang['lang_name'].'</option>';
			}
	echo'
			</select>
		</div>
	</div>
	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Speaking Level</b></label>
		<div class="col-lg-12">
			<select id="speaking_edit" name="speaking_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Level</option>';
			foreach($levels as $speaklevels) {
				echo "<option value='$speaklevels[id]'>$speaklevels[name]</option>";
			}
	echo'
			</select>
		</div>
	</div>

	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Reading Level</b></label>
		<div class="col-lg-12">
			<select id="reading_edit" name="reading_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Level</option>';
			foreach($levels as $readlevels) {
				echo "<option value='$readlevels[id]'>$readlevels[name]</option>";
			}
	echo'
			</select>
		</div>
	</div>


	
	<div class="form-group" style="margin-bottom:10px;">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Writing Level</b></label>
		<div class="col-lg-12">
			<select id="writing_edit" name="writing_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Level</option>';
			foreach($levels as $writelevels) {
				echo "<option value='$writelevels[id]'>$writelevels[name]</option>";
			}
	echo'
			</select>
		</div>
	</div>
	


</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
	<input type="hidden" id="skill_id_edit" name="skill_id" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_skill" name="changes_skill">
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>

    $("#writing_edit").select2({
        allowClear: true
    });
	$("#reading_edit").select2({
        allowClear: true
    });
	$("#speaking_edit").select2({
        allowClear: true
    });
	$("#id_language_edit").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
	$("#editLangskill").validate({
		rules: {
             id_language_edit	: "required",
			 writing_edit		: "required",
			 speaking_edit		: "required",
			 reading_edit		: "required"
		},
		messages: {
			id_language_edit	: "This field is required",
			writing_edit		: "This field is required",
			speaking_edit		: "This field is required",
			reading_edit		: "This field is required"
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
    //USED BY: WI_EDIT_TASK_MODAL
	//ACTIONS: dynamically add data into modal form
	//REQUIRES: jquery.js
	//ACTIONS-2: creates a pull down/select for each specified field (with preselected values)
    //REQUIRES-2: select2.js
		
    //---edit item link clicked-------
//---edit item link clicked-------
    $(".edit-skill-modal").click(function(){
    

        var id_language_edit 	= $(this).attr("data-skl-lng");
		var speaking_edit 		= $(this).attr("data-skl-speak");
		var writing_edit 		= $(this).attr("data-skl-write");
		var reading_edit 		= $(this).attr("data-skl-read");
		var skill_id_edit 		= $(this).attr("data-skl-id");

		$("#skill_id_edit")		.val(skill_id_edit);

        $("#id_language_edit")	.select2().select2("val", id_language_edit); 
		$("#speaking_edit")		.select2().select2("val", speaking_edit); 
		$("#writing_edit")		.select2().select2("val", writing_edit); 
		$("#reading_edit")		.select2().select2("val", reading_edit); 
  });
    
});
</script>';