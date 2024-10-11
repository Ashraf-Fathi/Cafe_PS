<?php
ob_start();
session_start();
 
if (isset($_SESSION['username'])) {
 
  include 'init.php';
    
    $do = isset($_GET['do']) ? $_GET['do'] : "Manage";


         //==========================================================================================================//==============================================Manage Page=================================================
         //**********************************************************************************************************

         if($do=="Manage") 
          {
          	?>
          <div class="container">	
           <div class="row">
              <div class="col-sm-12 col-md-6">
                <form  class="form-horizontal" action="?do=searchDevice" method="POST">

                    <div class="form-row">               
                    <!-- start Name -->
                    <div class="form-group col-md-3">
                      <label class="control-label">Device</label>
                      <div>
                        <select class="form-control" name="device">                           
                            <?php

                           $stmt =$con->prepare("SELECT * FROM devices");
                           $stmt ->execute();
                           $devices =$stmt->fetchAll();

                           foreach ($devices as  $device) {
                             
                              echo "<option value='" . $device['Name'] . "'>" . $device['Name'] . "</option>";           
                            } 
                           ?>
                        </select>
                      </div>
                    </div>
                    <!--end Name-->

                    <!--start submit items-->
                    <div class="form-group col-md-3">
                      <label class="control-label">Search</label>
                      <div class="">
                        <input type="submit" value="Show" class="btn btn-primary" />
                      </div>
                    </div>
                    <!--end submit items--> 
                    </div>
               </form>
              </div>
              <div class="col-sm-12 col-md-6">
              	<a href="?do=Add" class="addmail btn btn-secondary btn-icon-split">
                    <span class="icon text-white-50">
                         <i class="fas fa-arrow-right"></i>
                    </span>
                    <span class="text">Add Mail</span>
                 </a>
                 <a href="?do=Addgame" class="addmail btn btn-secondary btn-icon-split">
                    <span class="icon text-white-50">
                         <i class="fas fa-arrow-right"></i>
                    </span>
                    <span class="text">Add Game</span>
                 </a>
            	
              </div>
            </div>
            </div>
            <?php

            $stmt2 = $con->prepare("SELECT * FROM games ");
            $stmt2 ->execute();
            $mails  = $stmt2->fetchAll();
            echo "<h1 class='text-center'>" . "PSN Emails". "</h1>";

                ?>
                <div class="container">
                 <div class="table-responsiv">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                      <thead class="thead-dark">
                        <th>ID</th>
                        <th>Mail</th>
                        <th>Game</th>
                        <th>Primary</th>
                        <th>Secondary</th>
                        <th>Control</th>
                      </thead>
                      <tfoot class="thead-dark">
                        <tr>
                          <th>ID</th>
                          <th>Mail</th>
                          <th>Game</th>
                          <th>Primary</th>
                          <th>Secondary</th>
                          <th>Control</th>
                        </tr>
                      </tfoot>
                      <tbody>
                      <?php
                        foreach($mails as $mail ) { 

                                echo "<tr'>";
                                     echo "<td>" . $mail['ID']          . "</td>";
                                     echo "<td>" . $mail['mail']        . "</td>";
                                     echo "<td>" . $mail['game']        . "</td>";
                                     echo "<td>" . $mail['prim']        . "</td>";
                                     echo "<td>" . $mail['secondry']   . "</td>";
                                     echo "<td>";
                                               echo "<a href='games.php?do=EditMails&id=" . $mail['ID'] . "' class='slim btn btn-success'><i class ='fa fa-edit'></i></a>";
                                               echo "<a href='games.php?do=DeleteMails&id=" . $mail['ID'] . "' class='slim btn btn-danger confirm'><i class ='fas fa-times'></i></a>";  
                                     echo"</td>";
                                echo "</tr>";

                          
                       }

                      ?>
                      </tbody>
                        
                      
                    </table>
                    
                   </div>
                    <a href='games.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i>New Item</a>
                  </div>
                 <?php
          }elseif($do=="searchDevice"){

          	if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $device     = $_POST['device'];

                
                
                $stmt2 = $con->prepare("SELECT * FROM games WHERE prim = ? ");
                $stmt2 ->execute(array($device));
                $devices_pri  = $stmt2->fetchAll();
                $count2 =$stmt2->rowCount();

                $stmt3 = $con->prepare("SELECT * FROM games WHERE secondry = ? ");
                $stmt3 ->execute(array($device));
                $devices_sec  = $stmt3->fetchAll();
                $count3 =$stmt3->rowCount();


                if($count3 == 0 && $count2 == 0){
                	echo "no games";
                  
                }
                else{
              //primary games//////////////////////////////  	
                  ?>
               <div class="container">
                <h2>Primary</h2>
                 <div class="row">
                   <div class="col-sm-12 col-md-12 col-lg-12">
                     <div class="table-responsive">
                     <table class="table table-sm table-responsive table-bordered">
                     <thead class="thead-dark">
                       <tr>
                         <th scope="col">Games</th>
                         <th scope="col">Mail</th>
                       </tr>
                     </thead>
                     <tbody>
                      <?php 
                       foreach ($devices_pri as $device_pri) {               
                                echo "<tr'>";
                                     echo "<td>" . $device_pri['game']          . "</td>";
                                     echo "<td>" . $device_pri['mail']          . "</td>";
                                echo "</tr>";
                                
                         }      
                      ?> 
                     </tbody>
                   </table>
                   </div>
                   </div>
                 </div>
               </div>
                    <?php 
              /////////////////////////////////////////////
              //secondry games////////////////////////////
                    
                   ?>
               <div class="container">
                <h2>Secondry</h2>
                 <div class="row">
                   <div class="col-sm-12 col-md-12 col-lg-12">
                     <div class="table-responsive">
                     <table class="table table-sm table-responsive table-bordered">
                     <thead class="thead-dark">
                       <tr>
                         <th scope="col">Games</th>
                         <th scope="col">Mail</th>
                       </tr>
                     </thead>
                     <tbody>
                      <?php   
                             foreach ($devices_sec as $device_sec) {                  
                                echo "<tr'>";
                                     echo "<td>" . $device_sec['game']          . "</td>";
                                     echo "<td>" . $device_sec['mail']          . "</td>";
                                echo "</tr>"; 
                                
                              }       
                      ?> 
                     </tbody>
                   </table>
                   </div>
                   </div>
                 </div>
               </div>
                    <?php 
              ///////////////////////////////////////////                          
                 }



                }else{
                //echo "sorry you cannot browse this page directly";
                echo "<div class = 'container'>";
                    $theMsg ="<div class ='alert alert-danger'>sorry you cannot browse this page directly</div>";
                    redirectHome($theMsg,'back');
                echo "</div>";

            } 
          ///////////////////////////////////////////////////////////////////////////////////////////////////  
          }elseif($do=="Add"){ ?>
              <h1 class='text-center'>Add New Mail</h1>  <br  /> 
                <div class="container">
                  <form class="form-horizontal" action="?do=Insert" method="POST">
                    
                    <!-- start Name -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Mail</label>
                      <div class="col-sm-4">
                        <input type="text" name="mail" class="form-control" autocomplete="off"  />
                      </div>
                    </div>
                    <!--end Name-->

                    <!-- start description -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Primary Device</label>
                      <div class="col-sm-4">
                      	<select class="form-control" name="primary">                           
                            <?php

                           $stmt4 =$con->prepare("SELECT * FROM devices");
                           $stmt4 ->execute();
                           $devices =$stmt4->fetchAll();
                           echo "<option value='0' disabled selected>" . "Select Device" . "</option>";
                           echo "<option value='avail'>" . "Available" . "</option>";
                           foreach ($devices as  $device) {
                             
                              echo "<option value='" . $device['Name'] . "'>" . $device['Name'] . "</option>";           
                            } 
                           ?>
                        </select>
                      </div>
                    </div>
                    <!--end description-->

                    <!-- start ordering -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Secondary Device</label>
                      <div class="col-sm-4">
                        <select class="form-control" name="secondary">                           
                            <?php

                           $stmt5 =$con->prepare("SELECT * FROM devices");
                           $stmt5 ->execute();
                           $devices =$stmt5->fetchAll();
                           echo "<option value='0' disabled selected>" . "Select Device" . "</option>";
                           echo "<option value='avail'>" . "Available" . "</option>";
                           foreach ($devices as  $device) {
                              

                              echo "<option value='" . $device['Name'] . "'>" . $device['Name'] . "</option>";           
                            } 
                           ?>
                        </select>
                      </div>
                    </div>
                    <!--end ordering-->

                    <!-- start visibility -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Game</label>
                      <div class="col-sm-4">
                         <select class="form-control" name="game">                           
                            <?php

                           $stmt6 =$con->prepare("SELECT * FROM game");
                           $stmt6 ->execute();
                           $games =$stmt6->fetchAll();
                           echo "<option value='0' disabled selected>" . "Select Game" . "</option>";
                           foreach ($games as  $game) {
                              

                              echo "<option value='" . $game['name'] . "'>" . $game['name'] . "</option>";           
                            } 
                           ?>
                        </select>                       
                      </div>
                    </div>
                    <!--end visibility-->

                    <!-- start submit -->
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-4">
                        <input type="submit" value="Add Mail" class="btn btn-primary" />
                      </div>
                    </div>
                    <!--end submit-->
                  </form>

                 </div>
                 <?php
          }elseif($do=="Insert"){

             ?>
            <h1 class='text-center'>Insert Mail</h1>  <br  />
            <div class="container">
            <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $mail     = $_POST['mail'];
                $primary      = $_POST['primary'];
                $secondary   = $_POST['secondary'];
                $game    = $_POST['game'];
                

                $stmt1  =$con->prepare("SELECT mail,game FROM games WHERE mail = ? AND game = ?");
                $stmt1  ->execute(array($mail,$game));
                $count1  = $stmt1->rowCount();

                      if ($count1 == 1){
                        $theMsg = "<div class='alert alert-danger'>Sorry this Mail and Game is already exist</div>";
                        redirectHome($theMsg,'back');
                      }else{

                        //insert userinfo in database
                        $stmt = $con->prepare("INSERT INTO
                                games( mail, prim, secondry, game) 
                                               VALUES 
                                          (:imail, :iprim, :isec, :igame)");
                        $stmt->execute(array(
                          'imail'   => $mail,
                          'iprim'    => $primary,
                          'isec' => $secondary,
                          'igame'  => $game
                         ));
                        $icount = $stmt->rowCount();
                        
                        echo "<div class = 'container'>";
                           $theMsg ="<div class = 'alert alert-success'>" . $icount . ' ' . "Record Inserted" . "</div>";
                           redirectHome($theMsg,'back',0.3);
                        echo "</div>";
                      }
            }else{
                //echo "sorry you cannot browse this page directly";
                echo "<div class = 'container'>";
                    $theMsg ="<div class ='alert alert-danger'>sorry you cannot browse this page directly</div>";
                    redirectHome($theMsg,'back');
                echo "</div>";

            } 

          }elseif($do =="Addgame"){ ?>
             <h1 class='text-center'>Add New Game</h1>  <br  /> 
                <div class="container">
                  <form class="form-horizontal" action="?do=Insertgame" method="POST">
                    
                    <!-- start Name -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Game Name</label>
                      <div class="col-sm-4">
                        <input type="text" name="gameName" class="form-control" autocomplete="off"  />
                      </div>
                    </div>
                    <!--end Name-->

                    <!-- start submit -->
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-4">
                        <input type="submit" value="Add Game" class="btn btn-primary" />
                      </div>
                    </div>
                    <!--end submit-->
                  </form>

                 </div>
                 <?php

          }elseif($do =="Insertgame"){
              ?>
            <h1 class='text-center'>Insert Mail</h1>  <br  />
            <div class="container">
            <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $name     = $_POST['gameName'];

                      $check = checkItem("name","game",$name);

                      if ($check == 1){
                        $theMsg = "<div class='alert alert-danger'>Sorry this Mail and Game is already exist</div>";
                        redirectHome($theMsg,'back');
                      }else{

                        //insert userinfo in database
                        $stmt = $con->prepare("INSERT INTO
                                          game( name) 
                                               VALUES 
                                          (:iname)");
                        $stmt->execute(array(
                          'iname'   => $name
                         ));
                        $icount = $stmt->rowCount();
                        
                        echo "<div class = 'container'>";
                           $theMsg ="<div class = 'alert alert-success'>" . $icount . ' ' . "Record Inserted" . "</div>";
                           redirectHome($theMsg,'back',0.3);
                        echo "</div>";
                      }
            }else{
                //echo "sorry you cannot browse this page directly";
                echo "<div class = 'container'>";
                    $theMsg ="<div class ='alert alert-danger'>sorry you cannot browse this page directly</div>";
                    redirectHome($theMsg,'back');
                echo "</div>";

            } 
          }elseif($do=="EditMails")
          {


         //==========================================================================================================//==============================================Manage Page=================================================
         //**********************************************************************************************************
            $mail_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) :0;

                $stmt = $con->prepare("SELECT * FROM games  WHERE ID = ?  LIMIT 1" );
                $stmt->execute(array($mail_id));
                $row   =$stmt->fetch();
                $count =$stmt->rowCount();
             
               
                
                if($count > 0){ ?>
                
                 <h1 class='text-center'>Edit PSN Mail</h1>  <br  />
 
                <div class="container">
                  <form class="form-horizontal" action="?do=UpdateMails" method="POST">
                    
                    <input type="hidden" name="id" value="<?php echo $mail_id ?>" />
                    <!-- start Name -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Mail</label>
                      <div class="col-sm-4">
                        <input type="text" name="mail" class="form-control" autocomplete="off"   placeholder="Name of the device" value="<?php echo $row['mail'] ?>" />
                      </div>
                    </div>
                    <!--end Name-->

                    <!-- start description -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Primary Device</label>
                      <div class="col-sm-4">
                        <select class="form-control" name="prim">                           
                            <?php

                           $stmt4 =$con->prepare("SELECT * FROM devices");
                           $stmt4 ->execute();
                           $devices =$stmt4->fetchAll();
                           
                           echo "<option value='avail'>" . "Available" . "</option>";
                           foreach ($devices as  $device) {
                             
                              /*echo "<option value='"
                               . $device['Name'] .
                               "'" . if($device['Name'] == $row['prim']){"selected"} .
                               ">"
                               . $device['Name'] . 
                               "</option>";*/
                               if($device['Name'] == $row['prim']){
                                echo "<option value='". $device['Name'] ."' selected>";
                                  echo $device['Name'];
                                echo "</option>";
                               }else{
                                echo "<option value='". $device['Name'] ."'>";
                                  echo $device['Name'];
                                echo "</option>";
                               }
                                    
                            } 
                           ?>
                        </select>
                      </div>
                    </div>
                    <!--end description-->

                    <!-- start ordering -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Secondary Device</label>
                      <div class="col-sm-4">
                        <select class="form-control" name="sec">                           
                            <?php

                           $stmt5 =$con->prepare("SELECT * FROM devices");
                           $stmt5 ->execute();
                           $devices =$stmt5->fetchAll();
                           
                           echo "<option value='avail'>" . "Available" . "</option>";
                           foreach ($devices as  $device) {
                              

                              if($device['Name'] == $row['secondry']){
                                echo "<option value='". $device['Name'] ."' selected>";
                                  echo $device['Name'];
                                echo "</option>";
                               }else{
                                echo "<option value='". $device['Name'] ."'>";
                                  echo $device['Name'];
                                echo "</option>";
                               }           
                            } 
                           ?>
                        </select>
                      </div>
                    </div>
                    <!--end ordering-->

                    <!-- start visibility -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Game</label>
                      <div class="col-sm-4">
                         <select class="form-control" name="game">                           
                            <?php

                           $stmt6 =$con->prepare("SELECT * FROM game");
                           $stmt6 ->execute();
                           $games =$stmt6->fetchAll();
                           echo "<option value='0' disabled selected>" . "Select Game" . "</option>";
                           foreach ($games as  $game) {
                              

                              if($game['name'] == $row['game']){
                                echo "<option value='". $game['name'] ."' selected>";
                                  echo $game['name'];
                                echo "</option>";
                               }else{
                                echo "<option value='". $game['name'] ."'>";
                                  echo $game['name'];
                                echo "</option>";
                               }           
                            } 
                           ?>
                        </select>                       
                      </div>
                    </div>
                    <!--end visibility-->

                    <!-- start submit -->
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-4">
                        <input type="submit" value="Update Device" class="btn btn-primary" />
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

          }elseif($do=="UpdateMails")
          {
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $id         = $_POST['id'];
                $mail       = $_POST['mail'];
                $prim       = $_POST['prim'];
                $sec       = $_POST['sec'];
                $game       = $_POST['game'];


              
                        //Update userinfo in database
                        $stmt = $con->prepare("UPDATE games SET mail = ?, prim = ?, secondry = ?, game = ? WHERE ID = ?");
                        $stmt->execute(array($mail, $prim, $sec, $game, $id));
                        $icount = $stmt->rowCount();
                        
                        echo "<h1 class='text-center'>Update Items</h1>  <br  />";
                        echo "<div class = 'container'>";
                            $theMsg ="<div class = 'alert alert-success'>" . $icount . ' ' . "Mail Updated" . "</div>";
                            redirectHome($theMsg,'back',2);
                          echo "</div>";
              }else{
                //echo "sorry you cannot browse this page directly";
                echo "<div class = 'container'>";
                    $theMsg ="<div class ='alert alert-danger'>sorry you cannot browse this page directly</div>";
                    redirectHome($theMsg,'back');
                echo "</div>";

            } 
          }elseif($do=="DeleteMails"){
            echo "<h1 class='text-center'>Delete Mail</h1>  <br  />";
                $mail_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) :0;

                /*$stmt  = $con->prepare("SELECT * FROM users  WHERE UserID = ?  LIMIT 1" );
                $stmt  ->execute(array($userid));
                $row   = $stmt->fetch();
                $count = $stmt->rowCount();*/
                $check = checkItem2("*","games","ID","$mail_id");


                if ($check > 0){
                  $stmt = $con->prepare("DELETE FROM games WHERE ID = :did");
                  $stmt->bindParam(":did", $mail_id);
                  $stmt->execute();
                  $dcount= $stmt->rowCount();

                  //echo '<div class ="alert alert-success">' . $dcount .' '. 'Record Deleted</div>';
                  echo "<div class = 'container'>";
                      $theMsg ='<div class ="alert alert-success">' . $dcount .' '. 'mail Deleted</div>';
                      redirectHome($theMsg);
                    echo "</div>";


                   

                } else {
                  //echo "This ID is not Exist";
                  echo "<div class = 'container'>";
                      $theMsg ='<div class ="alert alert-danger">This ID is not Exist</div>';
                        redirectHome($theMsg);
                  echo "</div>";



                }

          }//closig do page
           
           


  include $tpl . 'footer.php';

}else{
   header('Location: home.php' );
   exit();
}
ob_end_flush();
?>