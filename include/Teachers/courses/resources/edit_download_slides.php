<?php 
echo '
		
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> File Name</b></label>
		<div class="col-lg-12">
			<input type="text" name="file_name" id="file_name" class="form-control" required autocomplete="off" value="'.$rowlesson['file_name'].'" >
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-lg-12" style="width:150px;"><b> Attach File</b></label>
		<div class="col-lg-12">
			<input id="dwnl_file" name="dwnl_file" class="btn btn-mid btn-primary clearfix" type="file">
			<div style="color:blue;padding-top: 5px !important;">Upload valiid images. Only <span style="color:red; font-weight:600;">pdf, xlsx, xls, doc, docx, ppt, pptx, png, jpg, jpeg, rar, zip</span> are allowed.</div>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Detail</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="detail" name="detail" style="height:70px !important;" required autocomplete="off">'.$rowlesson['detail'].'</textarea>
		</div>
	</div>
	
	<div class="col-sm-61">
		<div class="form_sep" style="margin-top:5px;">
			<label class="req">Open With</label>
			<select id="open_with" name="open_with" style="width:100%" autocomplete="off" required>
				<option value="">Select</option>';
			foreach($fileopenwith as $fileopen) { 
				if($rowlesson['open_with'] == $fileopen) { 
					echo '<option value="'.$fileopen.'" selected>'.$fileopen.'</option>';
				} else { 
					echo '<option value="'.$fileopen.'">'.$fileopen.'</option>';
				}
				
			}
	echo'
			</select>
		</div> 
	</div>
<script type="text/javascript"> 

$("#dwnl_file").change(function () {
        var fileExtension = ["pdf", "xlsx", "xls", "doc", "docx", "ppt", "pptx", "png", "jpg", "jpeg", "rar", "zip"];
        if ($.inArray($(this).val().split(\'.\').pop().toLowerCase(), fileExtension) == -1) {
            alert("Only formats are allowed : "+fileExtension.join(\', \'));
        }
    });
        $(\'#dwnl_file\').on(\'change\', function() { 
  
            const size = (this.files[0].size / 1024 / 1024).toFixed(2); 
  
            if (size > 5) { 
                alert("Try to upload file less than 5MB!"); 
            } else { 
                $("#output").html(\'<b>\' + \'This file size is: \' + size + " MB" + \'</b>\'); 
            } 
        }); 
    </script> ';