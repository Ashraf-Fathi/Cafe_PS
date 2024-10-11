<?php
 
   function getTitle() {

       global $pageTitle;

       if (isset($pageTitle)) {
       	echo $pageTitle;
       } else {
        echo 'OZOO';
       }
  }

// redirect home
  function redirectHome($theMsg , $url = null , $seconds = 3){

  	   if ($url === null){

  	   	    $url  ='home.php';

  	   	    $link ='Home Page';

  	   	}else{

  	   		  if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

  	   		      $url =$_SERVER['HTTP_REFERER'];

  	   		      $link='Previous Page';

  	   		  }else{

  	   			  $url  ='home.php';

  	   			  $link ='Home Page';
  	   			  
  	   		  }
 
  	   	}
  	   	
       echo $theMsg;
  	   echo "<div class ='alert alert-info'>" .'you will be redirect to' . $link . "</div>";

  	   header("refresh:$seconds;url=$url");
  	   exit();
  }


  //check item if exist

  function checkItem($select,$from,$value){
  	   global $con;

  	      $stmt1  =$con->prepare("SELECT $select FROM $from WHERE $select = ?");

  	      $stmt1  ->execute(array($value));

  	      $count1  = $stmt1->rowCount();

  	      return $count1;


  }
  
  function checkItem2($select,$from,$value,$value2){
  	   global $con;

  	      $stmt1  =$con->prepare("SELECT $select FROM $from WHERE $value = $value2");

  	      $stmt1  ->execute(array($value2));

  	      $count1  = $stmt1->rowCount();

  	      return $count1;


  }
 
 function checkItem3($select,$from,$value,$value2,$value3){
       global $con;

          $stmt1  =$con->prepare("SELECT $select FROM $from WHERE $value = $value2 AND $select = $value3");

          $stmt1  ->execute(array($value2));

          $count1  = $stmt1->rowCount();

          return $count1;


  }
 

  // count of number items

  function countItems($item,$table){

  	   global $con;

  	      $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

  	      $stmt2 -> execute();

  	      return $stmt2->fetchColumn();
  }
