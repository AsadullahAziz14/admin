
<?php

$str1 = "Manage";
$filename = pathinfo($_SERVER["SCRIPT_FILENAME"], PATHINFO_FILENAME);
$filename = str_replace('_', ' ', $filename);
$namestr = ucfirst($str1)." ".strtoupper($filename);


echo '
<!-- start page title -->
<div class="row">

    <div>

        <div class="widget-head d-flex align-items-center justify-content-between">

            <h4 class="mb-0"  style="font-weight:700; margin-left: 10px" >'.$namestr.'</h4>


        </div>

    </div>

</div>

<!-- end page title -->
';

?>