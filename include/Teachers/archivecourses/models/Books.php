<?php 
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div id="cursAddBookModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="addBook" enctype="multipart/form-data">
<input type="hidden" name="id_curs" name="id_curs" value="'.$_GET['id'].'">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Add Book Detail</h4>
</div>

<div class="modal-body">

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Book Name </label>
			<input type="text" name="book_name" id="book_name" class="form-control" required autocomplete="off" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Author</label>
			<input type="text" name="author_name" id="author_name" class="form-control" required autocomplete="off" >
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Edition </label>
			<input type="text" name="edition" id="edition" class="form-control" required autocomplete="off" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>ISBN</label>
			<input type="text" name="isbn" id="isbn" class="form-control" autocomplete="off" >
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Publisher </label>
			<input type="text" name="publisher" id="publisher" class="form-control" autocomplete="off" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>URL</label>
			<input type="text" name="url" id="url" class="form-control" autocomplete="off" >
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Status</b></label>
		<div class="col-lg-12">
			<select id="status" name="status" style="width:100%" autocomplete="off" required>';
			foreach($admstatus as $itemadm_status) {
				echo "<option value='$itemadm_status[status_id]'>$itemadm_status[status_name]</option>";
			}
	echo'
			</select>
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
		<input class="btn btn-primary" type="submit" value="Add Record" id="submit_book" name="submit_book">
	</button>
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
</script>
<script type="text/javascript">
$().ready(function() {
	$("#addBook").validate({
		rules: {
             status			: "required",
			 book_name		: "required",
			 author_name	: "required"
		},
		messages: {
			status			: "This field is required",
			book_name		: "This field is required",
			author_name		: "This field is required" 
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
<div id="cursEditBookModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<form class="form-horizontal" action="#" method="post" id="editBook" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	<button type="button" class="full-screen-modal close" aria-hidden="true"><i class="icon-fullscreen"></i></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit Book Detail</h4>
</div>

<div class="modal-body">

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Book Name </label>
			<input type="text" name="book_name_edit" id="book_name_edit" class="form-control" required autocomplete="off" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep">
			<label class="req">Author</label>
			<input type="text" name="author_name_edit" id="author_name_edit" class="form-control" required autocomplete="off" >
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Edition </label>
			<input type="text" name="edition_edit" id="edition_edit" class="form-control" required autocomplete="off" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>ISBN</label>
			<input type="text" name="isbn_edit" id="isbn_edit" class="form-control" autocomplete="off" >
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>Publisher </label>
			<input type="text" name="publisher_edit" id="publisher_edit" class="form-control" autocomplete="off" >
		</div> 
	</div>

	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label>URL</label>
			<input type="text" name="url_edit" id="url_edit" class="form-control" autocomplete="off" >
		</div> 
	</div>
	<div style="clear:both;"></div>
	
	
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Status</b></label>
		<div class="col-lg-12">
			<select id="status_edit" name="status_edit" style="width:100%" autocomplete="off" required>
				<option value="">Select Status</option>';
			foreach($admstatus as $itemadm_status) {
				echo "<option value='$itemadm_status[status_id]'>$itemadm_status[status_name]</option>";
			}
	echo'
			</select>
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
	<input type="hidden" id="bookid_edit" name="bookid_edit" value="">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_book" name="changes_book">
</div>

</div>
</form>
</div>
</div>
</div>
<!--WI_ADD_NEW_TASK_MODAL-->
<script>
	$("#status_edit").select2({
        allowClear: true
    });
</script>
<script type="text/javascript">
$().ready(function() {
	$("#editBook").validate({
		rules: {
             status_edit			: "required",
			 book_name_edit			: "required",
			 author_name_edit		: "required"
		},
		messages: {
			status_edit				: "This field is required",
			book_name_edit			: "This field is required",
			author_name_edit		: "This field is required"
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
    $(".edit-book-modal").click(function(){
    

        var status_edit 		= $(this).attr("data-bookstatus");
		var book_name_edit 		= $(this).attr("data-bookname");
		var author_name_edit 	= $(this).attr("data-bookauthor");
		var edition_edit 		= $(this).attr("data-bookedition");
		var isbn_edit 			= $(this).attr("data-bookisbn");
		var publisher_edit 		= $(this).attr("data-bookpublisher");
		var url_edit 			= $(this).attr("data-bookurl");
		var bookid_edit			= $(this).attr("data-booklid");

		$("#book_name_edit")	.val(book_name_edit);
		$("#author_name_edit")	.val(author_name_edit);
		$("#edition_edit")		.val(edition_edit);
		$("#isbn_edit")			.val(isbn_edit);
		$("#publisher_edit")	.val(publisher_edit);
		$("#url_edit")			.val(url_edit);
		$("#bookid_edit")		.val(bookid_edit);
        $("#status_edit")		.select2().select2("val", status_edit); 
  });
    
});
</script>';
?>