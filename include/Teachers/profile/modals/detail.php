<?php 

echo '

<!--WI_EDIT_TASK_MODAL-->
<div class="row">
<div id="editEmplyModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editEmp" enctype="multipart/form-data">
<div class="modal-content">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Employee Detail</h4>
</div>

<div class="modal-body">

	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Employee Number</label>
			<input type="text" name="emply_regno_edit" id="emply_regno_edit" class="form-control" required readonly >
		</div> 
	</div>
	
	<div class="col-sm-71">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Employee Name</label>
			<input type="text" name="emply_name_edit" id="emply_name_edit" class="form-control" required autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Date of Birth</label>
			<input type="text" name="emply_dob_edit" id="emply_dob_edit" class="form-control pickadate" required autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">CNIC #</label>
			<input type="text" name="emply_cnic_edit" id="emply_cnic_edit" class="form-control" required autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;"></div>

	<div class="form-group" style="margin-bottom:2px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Father Name</b></label>
		<div class="col-lg-12">
			<input type="text" name="emply_fathername_edit" id="emply_fathername_edit" class="form-control" autocomplete="off">
		</div>
	</div>
	
	
	<div style="clear:both;"></div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Phone No.</label>
			<input type="text" id="emply_phone_edit" name="emply_phone_edit" class="form-control" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Mobile No.</label>
			<input type="text" name="emply_mobile_edit" id="emply_mobile_edit" class="form-control" autocomplete="off">
		</div> 
	</div>
	
	<div class="col-sm-41">
		<div class="form_sep" style="margin-top:5px;">
			<label>Personal Email Address</label>
			<input type="email" name="emply_email_edit" id="emply_email_edit" class="form-control" autocomplete="off" autocomplete="off">
		</div> 
	</div>
	
	<div style="clear:both;"></div>
	
	<div class="form-group" style="margin-bottom:2px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Present Address</b></label>
		<div class="col-lg-12">
			<input type="text" id="emply_postal_address_edit" name="emply_postal_address_edit" class="form-control" autocomplete="off">
		</div>
	</div>
	
	

	<div style="clear:both;"></div>

	<div class="form-group" style="margin-bottom:2px;">
		<label class="control-label col-lg-12" style="width:150px;"> <b>Permanent Address</b></label>
		<div class="col-lg-12">
			<input type="text" name="emply_permanent_address_edit" id="emply_permanent_address_edit" class="form-control" autocomplete="off">
		</div>
	</div>
	<div style="clear:both;"></div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;margin-bottom:5px;">
			<label>Photo</label>
			<input id="emply_photo" name="emply_photo" class="btn btn-mid btn-primary clearfix" type="file"> 
			<span style="color:#f00;">size should be less then 200KB</span>
		</div>
	</div>
		
</div>
<div style="clear:both;"></div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" tabindex="23">Close</button>
	<input type="hidden" id="emply_id_edit" name="emply_id" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="submit_changes" name="submit_changes" tabindex="22">
</div>
</div>
</form>
</div>
</div>
</div>
<!--WI_EDIT_TASK_MODAL-->



<script type="text/javascript">
$().ready(function() {
    //USED BY: WI_EDIT_NEW_TASK_MODAL
	//ACTIONS: validates the form and submits it
	//REQUIRES: jquery.validate.js
	$("#editEmp").validate({
		rules: {
             emply_regno_edit: "required",
			 id_type_edit: "required",
			 emply_joining_date_edit: "required",
			 id_dept_edit: "required",
			 id_designation_edit: "required",
			 emply_job_title_edit: "required",
			 emply_name_edit: "required",
			 emply_gender_edit: "required",
			 id_city_edit_edit: "required",
			 emply_status_edit: "required"
		},
		messages: {
			emply_regno_edit: "This field is required",
			id_type_edit: "This field is required",
			emply_joining_date_edit: "This field is required",
			id_dept_edit: "This field is required",
			id_designation_edit: "This field is required",
			emply_job_title_edit: "This field is required",
			emply_name_edit: "This field is required",
			emply_gender_edit: "This field is required",
			id_city_edit: "This field is required",
			emply_status_edit: "This field is required"
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

    $(".edit-emply-modal").click(function(){

        var emply_regno_edit 				= $(this).attr("data-emp-no");
		var emply_name_edit 				= $(this).attr("data-emp-name");
		var emply_fathername_edit 			= $(this).attr("data-emp-fname");
		var emply_cnic_edit 				= $(this).attr("data-emp-cnic");
		var emply_dob_edit 					= $(this).attr("data-emp-dob");
		var emply_postal_address_edit 		= $(this).attr("data-emp-paddress");
		var emply_permanent_address_edit 	= $(this).attr("data-emp-peaddress");
		var emply_phone_edit 				= $(this).attr("data-emp-phone");
		var emply_mobile_edit 				= $(this).attr("data-emp-mobile");
		var emply_email_edit 				= $(this).attr("data-emp-email");
		var emply_id_edit 					= $(this).attr("data-emp-id");

        //set modal input values dynamically
		$("#emply_regno_edit")				.val(emply_regno_edit);
		$("#emply_name_edit")				.val(emply_name_edit);
		$("#emply_fathername_edit")			.val(emply_fathername_edit);
		$("#emply_dob_edit")				.val(emply_dob_edit);
		$("#emply_postal_address_edit")		.val(emply_postal_address_edit);
		$("#emply_permanent_address_edit")	.val(emply_permanent_address_edit);
		$("#emply_phone_edit")				.val(emply_phone_edit);
		$("#emply_mobile_edit")				.val(emply_mobile_edit);
		$("#emply_email_edit")				.val(emply_email_edit);
		$("#emply_cnic_edit")				.val(emply_cnic_edit);
		$("#emply_id_edit")					.val(emply_id_edit);
  });
    
});
</script>


<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="addNewHstModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="addNewHst" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Change Password</h4>
</div>

<div class="modal-body">
	<div class="form-group" style="margin-bottom:5px;">
		<label class="control-label req col-lg-12" style="width:250px;"> <b>New Password</b></label>
		<div class="col-lg-12">
			<input type="password" class="form-control" id="new_password" name="new_password" required autocomplete="off">
		</div>
	</div>

	<div class="form-group" style="margin-bottom:5px;">
		<label class="control-label req col-lg-12" style="width:250px;"> <b>Confirm Password</b></label>
		<div class="col-lg-12">
			<input type="password" class="form-control" id="confirm_password" name="confirm_password" required autocomplete="off">
		</div>
	</div>
	
</div>

<div class="modal-footer">
	<input class="btn btn-primary" type="submit" value="Change Password" id="submit_password" name="submit_password">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script type="text/javascript">
$().ready(function() {
    //USED BY: WI_ADD_NEW_TASK_MODAL
	//ACTIONS: validates the form and submits it
	//REQUIRES: jquery.validate.js
	$("#addNewHst").validate({
		rules: {
			 new_password: {
                required	: true,
                minlength	: 6
            },
            confirm_password: {
                required	: true,
                minlength	: 6,
                equalTo		: $("#new_password")
            },
		},
		messages: {
			new_password: {
                required	: "Please provide a password",
                minlength	: "Your password must be at least 6 characters long"
            },
            confirm_password: {
                required	: "Please provide a password",
                minlength	: "Your password must be at least 6 characters long",
                equalTo		: "Please enter the same password as above"
            },
		},
		submitHandler: function(form) {
		form.submit();
        }
	});
});
</script>';