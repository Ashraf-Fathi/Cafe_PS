<?php
 ob_start();   
 session_start();
 if (isset($_SESSION['usertype'])) {
 $pageTitle = 'Users';
      

     include "init.php";

     $do = isset($_GET['do']) ? $_GET['do'] : "Manage";



         if($do=="Manage") //Manage page
          {

               

                 $stmt = $con->prepare("SELECT * FROM users");
                 $stmt ->execute();
                 $rows = $stmt->fetchAll();
                 
                 ?>
                <h1 class='text-center'>Manage Page</h1>  <br  />
                <div class="container">
                	<div class="table-responsiv">
                		<table class="main-table text-center table table-bordered">
                			<tr>
                				<th>#ID</th>
                				<th>Username</th>
                				<th>Control</th>
                			</tr>
                			<?php
                			  foreach ($rows as $row ) { 

                                echo "<tr>";
                                     echo "<td>" . $row['UserID']   . "</td>";
                                     echo "<td>" . $row['Username'] . "</td>";
                                     echo "<td>";
                                               echo "<a href='members.php?do=Edit&userid=" . $row['UserID'] . "' class='slim btn btn-success'><i class ='fa fa-edit'></i>Edit</a>";
                                               echo "<a href='members.php?do=Delete&userid=" . $row['UserID'] . "' class='slim btn btn-danger confirm'><i class ='fas fa-times'></i>Delete</a>";
                                     echo"</td>";
                                echo "</tr>";

                			  	
                			 }

                			?>
                		    
                			
                		</table>
                		
                	</div>
                	<a href='members.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i>New Member</a>
                </div>
                

               <?php 
         ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

         }elseif($do=="Add") //Add page
              { ?>
               <h1 class='text-center'>Add New Member</h1>  <br  /> 
               <div class="container">
               	 	<form class="form-horizontal" action="?do=Insert" method="POST">
               	 		
               	 		<!-- start username -->
               	 		<div class="form-group">
               	 			<label class="col-sm-2 control-label">Username</label>
               	 			<div class="col-sm-4">
               	 				<input type="text" name="username" class="form-control" autocomplete="off"  required = 'required' />
               	 			</div>
               	 		</div>
               	 		<!--end username-->

               	 		<!-- start password -->
               	 		<div class="form-group">
               	 			<label class="col-sm-2 control-label">Password</label>
               	 			<div class="col-sm-4">
               	 				<input type="password" name="password" class="form-control" autocomplete="password" required = 'required' />
               	 			</div>
               	 		</div>
               	 		<!--end password-->

               	 		<!-- start submit -->
               	 		<div class="form-group">
               	 			<div class="col-sm-offset-2 col-sm-4">
               	 				<input type="submit" name="ADD" value="Save" class="btn btn-primary" />
               	 			</div>
               	 		</div>
               	 		<!--end submit-->
               	 	</form>

               	 </div>


             <?php 
         ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////      
         }elseif($do == 'Insert'){   //insert page
         	    ?>
         	    <h1 class='text-center'>Insert Member</h1>  <br  />
         	    <div class="container">
         	    <?php
         	    if($_SERVER['REQUEST_METHOD'] == 'POST'){
         	        $user  = $_POST['username'];
         	        $passs  = $_POST['password'];

         	        $pass = sha1($passs);


         	         $formErrors = array();

         	   	        if(strlen($user) < 3){

         	   	  	           $formErrors[] = 'username cant be less than <strong>3 charachter</strong>';

         	   	            }

         	   	        if(empty($user)){

                               $formErrors[] = 'username cant be <strong>empty</strong>';

         	   	            } 



         	   	        foreach ($formErrors as $error ) {
         	   	   	           echo '<div class ="alert alert-danger">' . $error . '</div>' ;
         	   	            } 

                        if(empty($formErrors)){
                            
                            $check = checkItem("Username","users",$user);
                            if ($check == 1){
                            	echo "<div class='alert alert-danger'>Sorry this user is already exist</div>";
                            }else{

                                //insert userinfo in database
                        	    $stmt = $con->prepare("INSERT INTO users(Username,Password)
                        	                                 VALUES ( :iuser , :ipass )");
                        	    $stmt->execute(array(
                        		'iuser' => $user,
                        		'ipass' => $pass
                        	     ));
                        	    $icount = $stmt->rowCount();
         	   	                
                                 echo "<div class = 'container'>";
         	   	                 $theMsg ="<div class = 'alert alert-success'>" . $icount . ' ' . "Record Inserted" . "</div>";
                                 redirectHome($theMsg,'back',3);
                                 echo "</div>";
                            }

         	   	 
                        }
                        //INSERT INTO `shop`.`categories` (`ID`, `Name`, `Description`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES (NULL, 'pc', '', NULL, '0', '0', '0');





                }else{

                    echo "<div class= 'alert alert-danger'>Sorry you cant browse this page directly</div>";


                }
         //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

         }elseif($do=="Edit") //Edit page
               {

               	$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;

               	$stmt = $con->prepare("SELECT * FROM users  WHERE UserID = ?  LIMIT 1" );
      	        $stmt->execute(array($userid));
      	        $row   =$stmt->fetch();
      	        $count =$stmt->rowCount();
      	     
      	       
                
               	if($count > 0){ ?>
               	
               	 <h1 class='text-center'>Edit Member</h1>  <br  />

               	 <div class="container">
               	 	<form class="form-horizontal" action="?do=Update" method="POST">
               	 		<input type="hidden" name="userid" value="<?php echo $userid ?>" />
               	 		<!-- start username -->
               	 		<div class="form-group">
               	 			<label class="col-sm-2 control-label">Username</label>
               	 			<div class="col-sm-4">
               	 				<input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>" required = 'required' />
               	 			</div>
               	 		</div>
               	 		<!--end username-->

               	 		<!-- start password -->
               	 		<div class="form-group">
               	 			<label class="col-sm-2 control-label">Password</label>
               	 			<div class="col-sm-4">
               	 				<input type="hidden" name="old-password" value="<?php echo $row['Password'] ?>" class="form-control" autocomplete="new-password" />
               	 				<input type="password" name="new-password" class="form-control" autocomplete="new-password" />
               	 			</div>
               	 		</div>
               	 		<!--end password-->


               	 		<!-- start submit -->
               	 		<div class="form-group">
               	 			<div class="col-sm-offset-2 col-sm-4">
               	 				<input type="submit" name="save" value="Save" class="btn btn-primary" />
               	 			</div>
               	 		</div>
               	 		<!--end submit-->
               	 	</form>

               	 </div>

                <?php   
                }else{
          	      //echo "theres no such id";
                	   echo "<div class = 'container'>";
         	   	         $theMsg ="<div class = 'alert alert-danger'>theres no such id</div>";
                         redirectHome($theMsg,'back',3);
                       echo "</div>";

                   }
         /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

         }elseif($do == 'Update'){   //Update page
         	    ?>
         	    <h1 class='text-center'>Update Member</h1>  <br  />
         	    <div class="container">
         	    <?php

         	       if($_SERVER['REQUEST_METHOD'] == 'POST'){
         	   	        $id     = $_POST['userid'];
         	   	        $user   = $_POST['username'];
         	   	        $pass   = '';
         	   	  
         	   	        $pass= empty($_POST['new-password']) ? $_POST['old-password'] : sha1($_POST['new-password']);

         	   	        //validate form
         	   	        $formErrors = array();

         	   	        if(strlen($user) < 3){

         	   	  	           $formErrors[] = 'username cant be less than <strong>3 charachter</strong>';

         	   	            }

         	   	        if(empty($user)){

                               $formErrors[] = 'username cant be <strong>empty</strong>';

         	   	            } 

         	   	        foreach ($formErrors as $error ) {
         	   	   	           echo '<div class ="alert alert-danger">' . $error . '</div>' ;
         	   	            } 

                        if(empty($formErrors)){



                        //send update to database
         	   	        $stmt = $con->prepare("UPDATE users SET Username = ?, Password = ? WHERE UserID = ?");
         	   	        $stmt->execute(array($user, $pass, $id));
         	   	        $ecount = $stmt->rowCount();
         	   	                 echo "<div class = 'container'>";
         	   	                 $theMsg ="<div class = 'alert alert-success'>" . $ecount . ' ' . "Record Updated" . "</div>";
                                 redirectHome($theMsg,'back',3);
                                 echo "</div>";

         	   	 
                        }



                    }else {
                         //echo "sorry you cannot browse this page directly";
                    	 echo "<div class = 'container'>";
         	   	              $theMsg ="<div class ='alert alert-danger'>sorry you cannot browse this page directly</div>";
                              redirectHome($theMsg,'back');
                         echo "</div>";

         	        }

         	    echo "</div>";
         /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
         }elseif($do == "Delete") //delete member page
         {      
         	  echo "<h1 class='text-center'>Delete Member</h1>  <br  />";
         	    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;

               	$stmt  = $con->prepare("SELECT * FROM users  WHERE UserID = ?  LIMIT 1" );
      	        $stmt  ->execute(array($userid));
      	        $row   = $stmt->fetch();
      	        $count = $stmt->rowCount();
                  /*$stmt1  =$con->prepare("SELECT * FROM users WHERE UserID = $userid");
                  $stmt1  ->execute(array($userid));
  	              $count1  = $stmt1->rowCount();*/


      	        if ($count > 0){
      	        	$stmt = $con->prepare("DELETE FROM users WHERE UserID = :duser");
      	        	$stmt->bindParam(":duser", $userid);
      	        	$stmt->execute();
      	        	$dcount= $stmt->rowCount();

      	        	//echo '<div class ="alert alert-success">' . $dcount .' '. 'Record Deleted</div>';
      	        	echo "<div class = 'container'>";
         	   	        $theMsg ='<div class ="alert alert-success">' . $dcount .' '. 'Record Deleted</div>';
                        redirectHome($theMsg);
                    echo "</div>";


      	        	 

      	        } else {
      	        	//echo "This ID is not Exist";
      	        	echo "<div class = 'container'>";
         	   	        $theMsg ='<div class ="alert alert-danger">This ID is not Exist</div>';
                        redirectHome($theMsg);
                    echo "</div>";



      	        }

         }elseif($do=="Activate"){
         	echo "<h1 class='text-center'>Activate Member</h1>  <br  />";
         	    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;

               	/*$stmt  = $con->prepare("SELECT * FROM users  WHERE UserID = ?  LIMIT 1" );
      	        $stmt  ->execute(array($userid));
      	        $row   = $stmt->fetch();
      	        $count = $stmt->rowCount();*/
      	        $check = checkItem2("*","users","UserID","$userid");


      	        if ($check > 0){
      	        	$stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
      	        	$stmt->execute(array($userid));
      	        	$Acount= $stmt->rowCount();

      	        	//echo '<div class ="alert alert-success">' . $dcount .' '. 'Record Deleted</div>';
      	        	echo "<div class = 'container'>";
         	   	        $theMsg ='<div class ="alert alert-success">' . $Acount .' '. 'Record Updated</div>';
                        redirectHome($theMsg);
                    echo "</div>";


      	        	 

      	        } else {
      	        	//echo "This ID is not Exist";
      	        	echo "<div class = 'container'>";
         	   	        $theMsg ='<div class ="alert alert-danger">This ID is not Exist</div>';
                        redirectHome($theMsg);
                    echo "</div>";
                }
         }       

     include $tpl . 'footer.php';
}else{
   header('Location: login.php' );
   exit();
}
   ob_end_flush();
?>