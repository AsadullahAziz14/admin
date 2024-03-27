<?php 
if(isset($_GET['id'])){

    //Publiation Query for Edit
    $sqllmsPub  = $dblms->querylms("SELECT ed.* 
											FROM ".EMPLYS_PUBLICATIONS." ed  
											INNER JOIN ".EMPLYS." emp ON emp.emply_id = ed.id_employee  
											WHERE ed.id_employee = '".cleanvars($rowempid['emply_id'])."' AND ed.id = '".$_GET['id']."'
                                            AND emp.id_campus	= '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
                                            LIMIT 1");
    $rowsPub = mysqli_fetch_array($sqllmsPub);

    if($rowsPub['id_type'] == 1){
        $title = 'Book';
    } else if ($rowsPub['id_type'] == 2){
        $title = 'Article';
    } else if ($rowsPub['id_type'] == 3){
        $title = 'Thesis';
    }

    $sqllmsdept		= $dblms->querylms("SELECT dept_id, dept_name 
                                            FROM ".DEPTS." 
                                            WHERE dept_status = '1' 
                                            AND id_campus = '".$_SESSION['userlogininfo']['LOGINIDCOM']."' 
                                            ORDER BY dept_name ASC");
    while($rowDept 	= mysqli_fetch_assoc($sqllmsdept)) {
        $dptArr[] = $rowDept; 
    }

    $sqllmszone	= $dblms->querylms("SELECT country_id, country_name 
                                            FROM ".COUNTRIES." 
				  							WHERE country_status = '1' 
                                            ORDER BY country_name ASC");
    while($rowzone 	= mysqli_fetch_assoc($sqllmszone)) {
        $ZoneArr[] = $rowzone; 
    }  

    $sqllmsLanguage	= $dblms->querylms("SELECT lang_id, lang_name 
                                            FROM ".LANGS." 
				  							WHERE lang_status = '1' 
                                            ORDER BY lang_id ASC");
    while($rowLanguage 	= mysqli_fetch_assoc($sqllmsLanguage)) {
        $langArr[] = $rowLanguage; 
    }  

    if($rowsPub['id_type'] == 1){ //Books Form Feilds

        $Fields = array(

            "title"		        =>  array( "title" => "Title"           		,       "class" => "col-sm-61"    , "inputAttr" => "required"                               )         ,
            "sub_title"	        =>  array( "title" => "Sub Title"       		,       "class" => "col-sm-61"    								                            )         ,
            "author"		    =>  array( "title" => "Author"          		,       "class" => "col-sm-61"    								                            )         ,
            "corporate_name"	=>  array( "title" => "Corporate Name"          ,       "class" => "col-sm-61"                                                              )         ,
            "isbn"			    =>  array( "title" => "ISBN"           			,       "class" => "col-sm-61"    								                            )         ,
            "issn"			    =>  array( "title" => "ISSN"           			,       "class" => "col-sm-61"    								                            )         ,	
            "book_type"			=>  array( "title" => "Book Type"           	,       "class" => "col-sm-61" , "after" => '<div style="clear:both;"></div>'               )         ,
            "page"		        =>  array( "title" => "Pages"           		,       "class" => "col-sm-41"    								                            )         ,
            "vloume"		    =>  array( "title" => "Volume"          		,       "class" => "col-sm-41"    								                            )         ,
            "id_language"		=>  array( "title" => "Language"        		,       "class" => "col-sm-41"  , "type" => "select" ,  "options" => 	$langArr            )         ,
            "subject"		    =>  array( "title" => "Subject"    				,       "class" => "col-sm-61"    								                            )         ,
            "keywords"		    =>  array( "title" => "Keywords"   				,       "class" => "col-sm-61"    								                            )         ,
            "year_date"	        =>  array( "title" => "Date of Publication" 	,       "class" => "col-sm-61"  , "inputClass" => "pickadate" 								)         ,
            "publisher_name"	=>  array( "title" => "Publisher Name"      	,       "class" => "col-sm-61"    								                            )         ,
            "edition"		    =>  array( "title" => "Edition"        			,       "class" => "col-sm-61"    								                            )         ,
            "editor"		    =>  array( "title" => "Editor Name"         	,       "class" => "col-sm-61"    								                            )         ,
            "series_name"		=>  array( "title" => "Series Name"         	,       "class" => "col-sm-61"    								                                                                           )         ,
            "series_num"		=>  array( "title" => "Series Number"       	,       "class" => "col-sm-61"    								                                                                           )         ,
            "url"               =>  array( "title" => "Download Link"  			,       "class" => "col-sm-61"    								                                                                           )         ,		
            "id_dept"			=>  array( "title" => "Department"          	,       "class" => "col-sm-61"  , "type" => "select" ,  "options" =>	$dptArr , "after" => '<div style="clear:both;"></div>'             )         ,
            
        );
        
    } else if ($rowsPub['id_type'] == 2){ // Article Form Feilds

        $Fields = array(
            "title"		        =>  array( "title" => "Title"           		,       "class" => "col-sm-61"  , "inputAttr" => "required"  								)         ,
            "sub_title"	        =>  array( "title" => "Sub Title"       		,       "class" => "col-sm-61"    								                            )         ,
            "journal"		    =>  array( "title" => "Name of Journal"    		,       "class" => "col-sm-61"    								                            )         ,
            "author"		    =>  array( "title" => "Author"          		,       "class" => "col-sm-61" 							                                    )         ,
            "co_author"		    =>  array( "title" => "Co-Author"          		,       "class" => "col-sm-61" 							                                    )         ,
            "id_country"		=>  array( "title" => "Country of Journal"      ,       "class" => "col-sm-61"  , "type" => "select" ,  "options" => 		$ZoneArr        )         ,	
            "issn"			    =>  array( "title" => "ISSN"           			,       "class" => "col-sm-61"    								                            )         ,	
            "doi"			    =>  array( "title" => "DOI"           			,       "class" => "col-sm-61"    								                            )         ,
			 "vloume"		    =>  array( "title" => "Volume"          		,       "class" => "col-sm-32"    								                            )         ,
            "issue_num"	        =>  array( "title" => "Issue Number"          	,       "class" => "col-sm-32"    								                            )         ,
            "page"		        =>  array( "title" => "Pages"           		,       "class" => "col-sm-32"    								                            )         ,
           
            "id_language"		=>  array( "title" => "Language"        		,       "class" => "col-sm-32"  , "type" => "select" ,  "options" => 		$langArr	    )         ,
            "subject"		    =>  array( "title" => "Subject"    				,       "class" => "col-sm-61"    								                            )         ,
            "keywords"		    =>  array( "title" => "Keywords"   				,       "class" => "col-sm-61"    								                            )         ,
            "abstract"	        =>  array( "title" => "Article Abstract"    	,       "class" => "col-sm-61"    								                            )         ,	
            "year_date"	        =>  array( "title" => "Date of Publication"     ,       "class" => "col-sm-61"  , "inputClass" => "pickadate"  	                            )         ,
            "publisher_name"	=>  array( "title" => "Publisher Name"      	,       "class" => "col-sm-61"    								                            )         ,
            "url"				=>  array( "title" => "URL"           			,       "class" => "col-sm-61"    								                            )         ,	
            "hec_category"		=>  array( "title" => "HEC Category"           	,       "class" => "col-sm-61"  , "type" => "select" ,  "options" => $acqCat	            )         ,	
            "hec_medallion"		=>  array( "title" => "HEC Medallion"           ,       "class" => "col-sm-61"  , "type" => "select" ,  "options" => $hec_medallion         )         ,	
            "affiliation"	    =>  array( "title" => "Affiliation"             ,       "class" => "col-sm-61"  , "type" => "select" ,  "options" => $journalAffiliation	)         ,	
            "impact_factor"		=>  array( "title" => "Impact Factor"       	,       "class" => "col-sm-61"    								                            )         ,
            
        );
        
    } else if ($rowsPub['id_type'] == 3){ //Thesis Form Feilds

        $Fields = array(
            "title"		        =>  array( "title" => "Title"           		    ,       "class" => "col-sm-61" , "inputAttr" => "required"  								)         ,
            "sub_title"	        =>  array( "title" => "Sub Title"       		    ,       "class" => "col-sm-61"    								                            )         ,
            "page"		        =>  array( "title" => "Pages"           		    ,       "class" => "col-sm-41"    								                            )         ,
            "id_language"		=>  array( "title" => "Language"        		    ,       "class" => "col-sm-41" , "type" => "select" ,  "options" => 		$langArr        )         ,
            "id_dept"			=>  array( "title" => "Department"          	    ,       "class" => "col-sm-41" , "type" => "select" ,  "options" => 		$dptArr      ,"after" => '<div style="clear:both;"></div>'    )         ,
            "id_prg_cat"		=>  array( "title" => "Class"        			    ,       "class" => "col-sm-61" , "type" => "select" ,  "options" => 		$postDegreeName         )         ,
            "material"		    =>  array( "title" => "Accompanying Material"       ,       "class" => "col-sm-61"    															)         ,	
            "barcode"			=>  array( "title" => "Barcode"           		    ,       "class" => "col-sm-61"    															)         ,	
            "session"			=>  array( "title" => "Session"           		    ,       "class" => "col-sm-61"    															)         ,
            "std_regno"			=>  array( "title" => "Students's Registration #"   ,       "class" => "col-sm-41"                                                              )         ,
            "submitted_by"		=>  array( "title" => "Submitted By"                ,       "class" => "col-sm-41"    															)         ,
            "submitted_to"		=>  array( "title" => "Submitted To Supervisor"     ,       "class" => "col-sm-41"    															)         ,
            
        );
        
    } 

    
echo '
<script type="text/javascript" src="js/select2/jquery.select2.js"></script>
<!--WI_ADD_NEW_TASK_MODAL-->
<div class="row">
<div class="modal-dialog" style="width:90%">
<form class="form-horizontal" action="profile.php?view=publications" method="post" id="addpubskill" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" onclick="location.href=\'profile.php?view=publications\'"><span>close</span></button>
	<h4 class="modal-title" style="font-weight:700;"> Edit '.$title.' Detail</h4>
</div>

<div class="modal-body">';

    $srno = 0;
	foreach ($Fields as $key => $value) {
        $srno++;
        
		if(isset($value['inputClass']) && !empty($value['inputClass'])){
			$cls = $value['inputClass']; 
		} else {
			$cls = '';
        }
        
		if(isset($value['inputAttr']) && !empty($value['inputAttr'])){
            $attr = $value['inputAttr']; 
            $lblCls = ($attr == 'required') ? 'req' : '';
		} else {
            $attr = '';
            $lblCls = '';
        }
        
        if(isset($value['type']) && ($value['type'] == 'select') ){

            $input =  '<select id="'.$key.'" style="width:100%;"  name="'.$key.'" autocomplete="off"  '.$attr.'  >
                           ';
            if(isset($value['options'])){
                foreach ($value['options'] as $option){
                    $simple_arr = array_values($option);
                    if($simple_arr[0] == $rowsPub[$key]){
						$input .= '<option value="'.$simple_arr[0].'" selected>'.$simple_arr[1].'</option>';
					} 
					else{
						$input .= '<option value="'.$simple_arr[0].'">'.$simple_arr[1].'</option>';
					}
                }   
            }
            $input .= '</select>';
            $clearBth = '';

        } else {

            $input = '<input type="text"  value="'.$rowsPub[$key].'" class="form-control '.$cls.'" '.$attr.' id="'.$key.'" name="'.$key.'"  autocomplete="off"  >';
            $clearBth = '';
        }
       
        echo'
        <div class="'.$value['class'].'">
            <div class="form_sep" style="margin-top:10px;">
                <label class="'.$lblCls.'" for="'.$key.'">'.$value['title'].'</label>
                '.$input.'
            </div> 
        </div>
        '.$clearBth.'';

		if(isset($value['after']) && !empty($value['after'])){
            echo $value['after'];
        }

    }
    
    if($rowsPub['id_type'] == 2){
        echo'
        <div style="clear:both;"></div>
        <div class="form-group" style="padding-bottom:10px;">
            <label class="control-label col-lg-12 req" style="width:150px;"> <b>Indexed On</b></label>
            <div class="col-lg-12">
                <select id="indexed_on" name="indexed_on" style="width:100%" autocomplete="off" required>';
                foreach($indexedOn as $indexed_On){
                    if($indexed_On['id'] == $rowsPub['indexed_on']){
                        echo'<option value="'.$indexed_On['id'].'" selected>'.$indexed_On['name'].'</option>';
                    } else{
                        echo'<option value="'.$indexed_On['id'].'">'.$indexed_On['name'].'</option>';
                    }
                }
                echo'    
                </select>
            </div>
        </div>
        <div style="clear:both;"></div>';
    }

    echo '
	<div style="clear:both;"></div>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" onclick="location.href=\'profile.php?view=publications\'" >Close</button>
	<input type="hidden" value="'.$rowsPub['id'].'" id="id_edit" name="id_edit">
	<input class="btn btn-primary" type="submit" value="Save Changes" id="changes_publications" name="changes_publications">
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
<script>
    //USED BY: VARIOUS
    //ACTIONS: creates a nice pull down/select for each specified field
    //REQUIRES: select2.js
    //NOTES: no need for "$().ready(function()" as this only need jquery & select2.js which are loaded up top
    $("#id_language").select2({
        allowClear: true
    });
    $("#id_dept").select2({
        allowClear: true
    });
    $("#indexed_on").select2({
        allowClear: true
    });
    $("#id_prg_cat").select2({
        allowClear: true
    });
    $("#book_type").select2({
        allowClear: true
    });
    $("#id_country").select2({
        allowClear: true
    });
    $("#hec_category").select2({
        allowClear: true
    });
    $("#affiliation").select2({
        allowClear: true
    });
    $("#hec_medallion").select2({
        allowClear: true
    });
    
</script>

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