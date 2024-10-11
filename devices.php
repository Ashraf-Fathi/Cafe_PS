<?php
 ob_start();   
 session_start();
 if (isset($_SESSION['usertype'])) {
 $pageTitle = 'Devices';
      

     include "init.php";

     $do = isset($_GET['do']) ? $_GET['do'] : "Manage";


         //==========================================================================================================//==============================================Manage Page=================================================
         //**********************************************************************************************************

         if($do=="Manage") 
          {
         //==========================================================================================================//==============================================Manage Page=================================================
         //**********************************************************************************************************
            $stmt2 = $con->prepare("SELECT * FROM devices ");
            $stmt2 ->execute();
            $devices  = $stmt2->fetchAll();
            echo "<h1 class='text-center'>" . "Manage Page". "</h1>";

                ?>
                <div class="container">
                 <div class="table-responsiv">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                      <thead class="thead-dark">
                      <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Ps Version</th>
                        <th>Single</th>
                        <th>Multi</th>
                        <th>Control</th>
                      </tr>
                      </thead>
                      <?php
                        foreach($devices as $device ) { 

                                echo "<tr'>";
                                     echo "<td>" . $device['ID']          . "</td>";
                                     echo "<td>" . $device['Name']        . "</td>";
                                     echo "<td>" . $device['psversion']  . "</td>";
                                     echo "<td>" . $device['single']      . "</td>";
                                     echo "<td>" . $device['multi']       . "</td>";
                                     echo "<td>";
                                               echo "<a href='devices.php?do=Edit&id=" . $device['ID'] . "' class='slim btn btn-success'><i class ='fa fa-edit'></i>Edit</a>";
                                               echo "<a href='devices.php?do=Delete&id=" . $device['ID'] . "' class='slim btn btn-danger confirm'><i class ='fas fa-times'></i>Delete</a>";   
                                     echo"</td>";
                                echo "</tr>";

                          
                       }

                      ?>
                        
                      
                    </table>
                    
                   </div>
                    <a href='devices.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i>New Device</a>
                  </div>
                 <?php
          }elseif($do=="Add")
          { 

         //==========================================================================================================//==============================================Manage Page=================================================
         //******************************************************************************************************
              ?>
              <h1 class='text-center'>Add New Device</h1>  <br  /> 
                <div class="container">
                  <form class="form-horizontal" action="?do=Insert" method="POST">
                    
                    <!-- start Name -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Name</label>
                      <div class="col-sm-4">
                        <input type="text" name="name" class="form-control" autocomplete="off"   placeholder="Name of the device" />
                      </div>
                    </div>
                    <!--end Name-->

                    <!-- start description -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Ps Version</label>
                      <div class="col-sm-4">
                        <input type="text" name="ps-version" class="form-control"  placeholder="describe the device" />
                      </div>
                    </div>
                    <!--end description-->

                    <!-- start ordering -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Single Price</label>
                      <div class="col-sm-4">
                        <input type="text" name="single" class="form-control" />
                      </div>
                    </div>
                    <!--end ordering-->

                    <!-- start visibility -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Multi Price</label>
                      <div class="col-sm-4">
                         <input type="text" name="multi" class="form-control" />
                        
                        
                      </div>
                    </div>
                    <!--end visibility-->

                    <!-- start submit -->
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-4">
                        <input type="submit" value="Add Device" class="btn btn-primary" />
                      </div>
                    </div>
                    <!--end submit-->
                  </form>

                 </div>

          <?php
          }elseif($do == 'Insert')
          {

         //==========================================================================================================//==============================================Manage Page=================================================
         //**********************************************************************************************************
            ?>
            <h1 class='text-center'>Insert Device</h1>  <br  />
            <div class="container">
            <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $name     = $_POST['name'];
                $ver      = $_POST['ps-version'];
                $single   = $_POST['single'];
                $multi    = $_POST['multi'];
                

                $check = checkItem("Name","devices",$name);

                      if ($check == 1){
                        $theMsg = "<div class='alert alert-danger'>Sorry this category is already exist</div>";
                        redirectHome($theMsg,'back');
                      }else{

                        //insert userinfo in database
                        $stmt = $con->prepare("INSERT INTO
                                devices( Name, psversion, single, multi) 
                                               VALUES 
                                          (:iname, :iver, :isingle, :imulti)");
                        $stmt->execute(array(
                          'iname'   => $name,
                          'iver'    => $ver,
                          'isingle' => $single,
                          'imulti'  => $multi
                         ));
                        $icount = $stmt->rowCount();
                        
                        echo "<div class = 'container'>";
                           $theMsg ="<div class = 'alert alert-success'>" . $icount . ' ' . "Record Inserted" . "</div>";
                           redirectHome($theMsg,'back',3);
                        echo "</div>";
                      }
            }else{
                //echo "sorry you cannot browse this page directly";
                echo "<div class = 'container'>";
                    $theMsg ="<div class ='alert alert-danger'>sorry you cannot browse this page directly</div>";
                    redirectHome($theMsg,'back');
                echo "</div>";

            } 
         	}elseif($do=="Edit")
          {


         //==========================================================================================================//==============================================Manage Page=================================================
         //**********************************************************************************************************
            $psid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) :0;

                $stmt = $con->prepare("SELECT * FROM devices  WHERE ID = ?  LIMIT 1" );
                $stmt->execute(array($psid));
                $row   =$stmt->fetch();
                $count =$stmt->rowCount();
             
               
                
                if($count > 0){ ?>
                
                 <h1 class='text-center'>Edit Device</h1>  <br  />
 
                <div class="container">
                  <form class="form-horizontal" action="?do=Update" method="POST">
                    
                    <input type="hidden" name="id" value="<?php echo $psid ?>" />
                    <!-- start Name -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Name</label>
                      <div class="col-sm-4">
                        <input type="text" name="name" class="form-control" autocomplete="off"   placeholder="Name of the device" value="<?php echo $row['Name'] ?>" />
                      </div>
                    </div>
                    <!--end Name-->

                    <!-- start description -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Ps Version</label>
                      <div class="col-sm-4">
                        <input type="text" name="ps-version" class="form-control"  placeholder="describe the device" value="<?php echo $row['psversion'] ?>" />
                      </div>
                    </div>
                    <!--end description-->

                    <!-- start ordering -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Single Price</label>
                      <div class="col-sm-4">
                        <input type="text" name="single" class="form-control" value="<?php echo $row['single'] ?>" />
                      </div>
                    </div>
                    <!--end ordering-->

                    <!-- start visibility -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Multi Price</label>
                      <div class="col-sm-4">
                         <input type="text" name="multi" class="form-control" value="<?php echo $row['multi'] ?>" />
                        
                        
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

          }elseif($do == 'Update')
          {

         //==========================================================================================================//==============================================Manage Page=================================================
         //**********************************************************************************************************
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $id         = $_POST['id'];
                $name       = $_POST['name'];
                $psversion       = $_POST['ps-version'];
                $single      = $_POST['single'];
                $multi      = $_POST['multi'];


                

                      
                        
                        //Update userinfo in database
                        $stmt = $con->prepare("UPDATE devices SET Name = ?, psversion = ?, single = ?, multi = ? WHERE ID = ?");
                        $stmt->execute(array($name, $psversion, $single, $multi, $id));
                        $icount = $stmt->rowCount();
                        
                        echo "<h1 class='text-center'>Update Decice</h1>  <br  />";
                        echo "<div class = 'container'>";
                            $theMsg ="<div class = 'alert alert-success'>" . $icount . ' ' . "Device Updated" . "</div>";
                            redirectHome($theMsg,'back',2);
                          echo "</div>";
              }else{
                //echo "sorry you cannot browse this page directly";
                echo "<div class = 'container'>";
                    $theMsg ="<div class ='alert alert-danger'>sorry you cannot browse this page directly</div>";
                    redirectHome($theMsg,'back');
                echo "</div>";

            } 
                          ////////////////////////////////////////////////////////////////////////////////
                          ///////////////////////////////////////////////////////////////////////////////
            }elseif($do == 'Delete'){

                echo "<h1 class='text-center'>Delete Device</h1>  <br  />";
                $psid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) :0;

                /*$stmt  = $con->prepare("SELECT * FROM users  WHERE UserID = ?  LIMIT 1" );
                $stmt  ->execute(array($userid));
                $row   = $stmt->fetch();
                $count = $stmt->rowCount();*/
                $check = checkItem2("*","devices","ID","$psid");


                if ($check > 0){
                  $stmt = $con->prepare("DELETE FROM devices WHERE ID = :did");
                  $stmt->bindParam(":did", $psid);
                  $stmt->execute();
                  $dcount= $stmt->rowCount();

                  //echo '<div class ="alert alert-success">' . $dcount .' '. 'Record Deleted</div>';
                  echo "<div class = 'container'>";
                      $theMsg ='<div class ="alert alert-success">' . $dcount .' '. 'device Deleted</div>';
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