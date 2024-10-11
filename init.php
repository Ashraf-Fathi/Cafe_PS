<?php
  include 'connect.php';

  $tpl  = "includes/templates/";  //directory of templates
  $func = "includes/functions/";
  $css  ="layout/css/";           //directory of css        
  $js   ="layout/js/";             //directory of js
  $lang ="includes/lang/";

  include 'includes/timezone.php';
  include $func . 'functions.php';

  

  $stmt6 = $con->prepare("SELECT * FROM config WHERE ID = 1 LIMIT 1 ");
  $stmt6 ->execute();
  $config  = $stmt6->fetch();

  $current_shift = $config['current_shift'];
  $shift_day     = $config['shift_day'];
  $shift_month   = $config['shift_month'];
  $shift_year    = $config['shift_year'];

  if($current_shift == "one"){
    $current_shift ="First Shift";
  }else{
    $current_shift ="Second Shift";
  }
  
   
  //include  $tpl . 'header.php';
  
  if (!isset($noheader)) {include  $tpl . 'header.php';}
  if (!isset($nonavbar)) {include  $tpl . 'navbar.php';}
  


    
