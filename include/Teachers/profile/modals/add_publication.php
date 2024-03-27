<?php 
if(isset($_GET['add'])){
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:90%">
<form class="form-horizontal" action="profile.php?view=publications" method="post" id="addpubskill" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" onclick="location.href=\'profile.php?view=publications\'"><span>close</span></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Publication Detail</h4>
</div>

<div class="modal-body">

    <div class="form-group">
        <label class="control-label req col-lg-12" style="width:150px;"><b>Publication Type</b></label>
        <div class="col-lg-12">
            <select id="id_type" name="id_type" onchange="getPublicationForm(this.value)" style="width:100%" autocomplete="off" required>
                <option value="">Select Type</option>';
                foreach($publishtype as $listtype) {
                echo '<option value="'.$listtype['id'].'">'.$listtype['name'].'</option>';
            }
            echo'
            </select>
        </div>
    </div>

	<div style="clear:both;"></div>

    <div id="getPublicationForm"></div>

	<div style="clear:both;"></div>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" onclick="location.href=\'profile.php?view=publications\'" >Close</button>
	<input class="btn btn-primary" type="submit" value="Add Record" id="submit_publications" name="submit_publications">
</div>

</div>
</form>
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
             id_type		: "required"
		},
		messages: {
			id_degree		: "This field is required"
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
}
?>