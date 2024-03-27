<?php 
echo '
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Title</b></label>
		<div class="col-lg-12">
			<input type="text" name="file_name" id="file_name" class="form-control" value="'.$rowlesson['file_name'].'" required autocomplete="off" >
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> URL</b></label>
		<div class="col-lg-12">
			<input type="text" class="form-control" id="url" name="url" required  value="'.$rowlesson['url'].'" autocomplete="off">
		</div>
	</div>

	<div class="form-group">
		<label class="control-label req col-lg-12" style="width:150px;"><b> Detail</b></label>
		<div class="col-lg-12">
			<textarea class="form-control" id="detail" name="detail" required autocomplete="off" style="height:70px !important;">'.$rowlesson['detail'].'</textarea>
		</div>
	</div>';