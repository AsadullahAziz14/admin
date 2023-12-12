<?php
include "dbsetting/lms_vars_config.php";
include "dbsetting/classdbconection.php";
$dblms = new dblms();
include "functions/login_func.php";
include "functions/functions.php";
checkCpanelLMSALogin();

//------------------------------------------------
      echo '
      <style>
         /* CSS styling for the question paper */
         body {
            font-family: Arial, sans-serif;
            margin: 20px;
         }

         h1 {
            text-align: center;
         }

         .header {
            margin-bottom: 20px;
         }

         .header-item {
            font-weight: bold;
         }

         .header-table {
            width: 100%;
            border-collapse: collapse;
         }

         .header-table td {
            padding: 5px;
            border: 1px solid #000;
         }

         .question {
            margin-bottom: 20px;
         }

         .question-number {
            font-weight: bold;
         }

         .question-statement {
            margin-top: 10px;
         }

         .options {
            margin-left: 20px;
         }
   </style>
      <div id="print" class="row">
         <div class="container">
            <div class="container">
               <div class="header">
                  <table class="header-table">
                           <tr>
                           ';
                           if(isset($_GET['print']))
                           {
                              if ($_GET['print'] == 'po' && isset($_GET['id'])) 
                              {
                                 echo '<h1>Print PO</h1>'; 
                              }
                           }
?>

<script>
   window.print();
</script>
