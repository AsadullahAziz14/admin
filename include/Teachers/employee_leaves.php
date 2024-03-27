<?php

        require_once('include/Teachers/leaves/query.php');

        $sdate		= (isset($_GET['sdate']) && $_GET['sdate'] != '') ? $_GET['sdate'] : '';
        $edate		= (isset($_GET['edate']) && $_GET['edate'] != '') ? $_GET['edate'] : '';
        $cat		= (isset($_GET['cat'])   && $_GET['cat']   != '') ? $_GET['cat']   : '';

        $sql2 = '';

        if($sdate != '') {
            $sql2 .= "AND l.leave_start_date = '".$sdate."'";
        }

        if($edate != '') {
            $sql2  .= "AND l.leave_end_date = '".$edate."'";
        }

        if($cat   != '') {
            $sql2  .= "AND l.id_cat = ".$cat;
        }

        $categories = array();
        $sqllmsLeavesCats = $dblms->querylms("SELECT cat_id , cat_name 
                                                FROM ".SALARY_EMPLYS_LEAVES_CATS."
                                                WHERE cat_status = 1
                                                AND id_campus = '".cleanvars($_SESSION['userlogininfo']['LOGINIDCOM'])."'");
        while($valueLeavesCat = mysqli_fetch_array($sqllmsLeavesCats)) {
            $categories[] = $valueLeavesCat;
        }
        
        $queryEmployee	= $dblms->querylms("SELECT emply_id, emply_name, id_dept
                                                FROM ".EMPLYS." 
                                                WHERE emply_loginid = '".cleanvars($_SESSION['LOGINIDA_SSS'])."' 
                                                LIMIT 1");
        $valueEmployee	= mysqli_fetch_array($queryEmployee);

        echo '
        <title>Employees Leaves - '.TITLE_HEADER.'</title>
        <div class="matter">
            <div class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle Navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <form class="navbar-form navbar-left form-small" action="" method="get">
                            <div class="form-group">
                                <input type="text" class="form-control pickadate" name="sdate" placeholder="Search by Start date" style="width:150px;" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control pickadate" name="edate" placeholder="Search by End date" style="width:150px;" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <select class="" name="cat" id="leave_cat" placeholder="Search by Leave Category" style="width:200px;">
                                    <option value=""></option>';
                                    foreach($categories as $cat) { 
                                        echo '<option value="'.$cat['cat_id'].'">'.$cat['cat_name'].'</option> ';
                                    }
                                    echo '
                                </select>
                            </div>
                            <button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-search"></i> Search</button>
                            <a href="employee_leaves.php" class="btn btn-xs btn-purple"><i class="fa fa-list"></i> All Leaves</a>
                            <a href="employee_leaves.php?add" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Add Application</a>
                            
                        </form>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row fullscreen-mode">
                    <div class="col-md-12">
                        <div class="widget">
                            <div class="widget-content">';
                                if(isset($_SESSION['msg'])) {
                                    echo $_SESSION['msg']['status'];
                                    unset($_SESSION['msg']);
                                }
                                
                                include_once('include/Teachers/leaves/list.php');
                                include_once('include/Teachers/leaves/add.php');

                                echo '
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="copy">Powered by: | <a href="'.COPY_RIGHTS_URL.'" target="_blank">'.COPY_RIGHTS.'</a> </p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Scroll to top -->
    <span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span>

    <script type="text/javascript" src="js/ebro_form_validate.js"></script>
    <script type="text/javascript" src="js/custom/all-vendors.js"></script>
    <script type="text/javascript">
        // USED BY: All date picking forms
        $(document).ready(function(){
            $(".pickadate").datepicker({
            format: "yyyy-mm-dd",
            language: "lang",
            autoclose: true,
            todayHighlight: true
            });	
        });
        // USED BY: All date picking forms
        $(document).ready(function(){
            $(".pickayearmonth").datepicker({
            format: "yyyy-mm",
            language: "lang",
            autoclose: true,
            todayHighlight: true
            });	
        });
    </script>
    <script type="text/javascript">
        $("#leave_cat").select2({
            allowClear    :   true
        });
    </script>
    
    <script type="text/javascript">
        
        function get_emplyleavedata() {
            var cat = $("#category").val();
            $.ajax({
                type : "POST"                                                                       ,
                url  : "include/Teachers/leaves/get_emplyleavedata.php"                             ,
                data : "cat_id="+cat+"&emply_id="+$("#id_emply").val()                              ,
                success : function(data) {
                    
                    data = JSON.parse(data);
                    $("#allowed").val(data.allowed);
                    $("#availed").val(data.availed);
                    $("#balance").val(data.balance);

                    if(data.balance == 0) {
                        $("#applied_for").val("You are out of leaves in this category");
                    } else {
                        $("#applied_for").val("");
                    }

                }
            });
        }

    </script>

    <script type="text/javascript">
        $("#to").change(function() {
            var date1 = new Date($("#from").val());
            var date2 = new Date($("#to").val());

            if(date1 == date2) {
                var differenceInDays = 1;
            } else {
                var differenceInTime = date2.getTime() - date1.getTime();
                var differenceInDays = (differenceInTime / (1000 * 3600 * 24) + 1) ;
            }
            console.log(differenceInDays);

            if($("#balance").val() < differenceInDays) { 
                $("#applied_for").val("Enter the days equal or less than Balance");
            } else {
                $("#applied_for").val(differenceInDays);
            }
        });
    </script>

    <script type="text/javascript">
        $(function () {
            $(".footable").footable();
        });
    </script>
    <script type="text/javascript" src="js/custom/custom.js"></script>
    <script type="text/javascript" src="js/custom/custom.general.js"></script>
</body>
</html>';

?>