<?php 
echo '
	
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Title</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="caption" name="caption" value="'.$rowlesson['file_name'].'" required  autocomplete="off">
		</div>
	</div>

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Drive Link</b></label>
		<div class="col-lg-12">
			<input type="text" name="drive_link" id="drive_link" value="'.$rowlesson['url'].'" class="form-control" required autocomplete="off" >
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-lg-12" style="width:150px;"><b> Detail</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="detail" name="detail" autocomplete="off" style="height:70px !important;">'.$rowlesson['detail'].'</textarea>
		</div>
	</div>';