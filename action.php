<?php
 ob_start();   
 session_start();
 $pageTitle = 'Members';
      
 if (isset($_SESSION['username'])) {

     include "init.php";

     $do = isset($_GET['do']) ? $_GET['do'] : "Manage";


         //==========================================================================================================//==============================================Manage Page=================================================
         //**********************************************************************************************************

         if($do=="Manage") 
          {

         //==========================================================================================================//==============================================Manage Page=================================================
         //**********************************************************************************************************
          }elseif($do=="endDevice")
          {
          if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $device_id   = $_POST['device_id'];
            $all = $_POST['time'];
            $time_price = $_POST['time_price'];
            $drinks_price = $_POST['drinks_price'];
            $money = $_POST['wanted'];
            $date = date('Y:m:d');
            $time = date('H:i:s');
         
            
        
            $stmt7 = $con->prepare("SELECT * FROM config ");
            $stmt7 ->execute();
            $config1  = $stmt7->fetch();

            $current_shift = $config1['current_shift'];
            $shift_day = $config1['shift_day'];
            $shift_month =$config1['shift_month'];
            $shift_year =$config1['shift_year'];

          $stmt1  =$con->prepare("SELECT device_status FROM devices WHERE ID = ? AND device_status = ?");
          $stmt1  ->execute(array($device_id,"off"));
          $count1  = $stmt1->rowCount();
          
          //check if device already on
          if($count1 == 0) {
               $stmt6 = $con->prepare("SELECT Reports_bill FROM reports  WHERE Device_ID = ? AND status = ? LIMIT 1" );
               $stmt6->execute(array($device_id,'live'));
               $report=$stmt6->fetch();
               $report_bill = $report['Reports_bill'];

               //finish ps orders and set it done
               $stmt3 = $con->prepare("UPDATE ps_orders SET status = ?, Reports_bill = ?  WHERE Device_ID = ? AND status = ?");
               $stmt3->execute(array('done', $report_bill,$device_id,'live' ));
               $icount3 = $stmt3->rowCount();

              //send data to reports
               $stmt2 = $con->prepare("UPDATE reports SET all_time = ?, time_bill = ?, drinks_bill = ?, total_bill = ?, end_date = ?, end_time = ?,current_shift = ?,shift_day = ?,shift_month = ?,shift_year = ?, status = ?  WHERE Device_ID = ? AND status = ?");
               $stmt2->execute(array($all,$time_price,$drinks_price,$money,$date,$time,$current_shift,$shift_day,$shift_month,$shift_year,'done',$device_id,'live' ));
               $icount2 = $stmt2->rowCount();

               $stmt7 = $con->prepare("UPDATE reports SET status = ?  WHERE Reports_bill = ? AND status = ?");
               $stmt7->execute(array('link_done',$report_bill,'link' ));
               $icount7 = $stmt7->rowCount();


            //turn off device
            $stmt = $con->prepare("UPDATE devices SET device_status = ?, hour = ?, minute = ?, second = ?,type = ? WHERE ID = ?");
            $stmt->execute(array('off', '', '', '', '', $device_id));
            $icount = $stmt->rowCount();
            
            if($icount > 0 && $icount2 > 0){
              header('Location: home.php' );
              exit();
            }

           }//closing of if $count1

        }


         //==========================================================================================================//==============================================Manage Page=================================================
         //**********************************************************************************************************
          }elseif($do == 'Insert')
          {

          	if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $s_id     = $_POST['s_id'];
                $s_num      = $_POST['s_num'];
                $device_id      = $_POST['d_id'];



                $stmt = $con->prepare("SELECT s_name,s_price,s_quantity FROM stock  WHERE S_ID = ?  LIMIT 1" );
                $stmt->execute(array($s_id));
                $row   =$stmt->fetch();
                
                if($s_num <= $row['s_quantity']){
                  $s_name  = $row['s_name'];
                  $s_price = $row['s_price'];
                  $total_price = $s_price * $s_num;
                        


                        $stmt = $con->prepare("UPDATE stock SET s_quantity = s_quantity - ? WHERE S_ID = ?");
                        $stmt->execute(array($s_num, $s_id));
                        $icount = $stmt->rowCount();

                        $stmt5 = $con->prepare("SELECT * FROM ps_orders WHERE device_id = ? AND status = ? AND s_id = ? LIMIT 1" );
                        $stmt5->execute(array($device_id,'live', $s_id));
                        $count5 =$stmt5->rowCount();
                        
                        //if this item is already exist on this device just plus quantity of item
                        if($count5 > 0){
                          $stmt = $con->prepare("UPDATE ps_orders SET order_num = order_num + ? WHERE device_id = ? AND status = ? AND S_ID = ?");
                          $stmt->execute(array($s_num,$device_id ,'live',$s_id));
                          $icount = $stmt->rowCount();

                          $stmt1 = $con->prepare("UPDATE ps_orders SET total_price = total_price + ?  WHERE device_id = ? AND status = ? AND S_ID = ?");
                          $stmt1->execute(array($total_price,$device_id ,'live',$s_id));
                          $icount1 = $stmt1->rowCount();

                          echo "<div class = 'container'>";
                           $theMsg ="<div class = 'alert alert-success'>" . $icount . ' ' . "Record Inserted" . "</div>";
                           redirectHome($theMsg,'back',0.1);
                        echo "</div>";
                        }else{
                          //insert userinfo in database
                        $stmt = $con->prepare("INSERT INTO
                                ps_orders( device_id, s_id, order_name, order_price, order_num,total_price,status) 
                                               VALUES 
                                          (:idid, :isid, :iname, :iprice, :inum, :itotal, :istatus)");
                        $stmt->execute(array(
                          'idid'   => $device_id,
                          'isid'   => $s_id,
                          'iname'    => $s_name,
                          'iprice' => $s_price,
                          'inum'  => $s_num,
                          'itotal'  => $total_price,
                          'istatus'  => 'live'
                         ));
                        $icount = $stmt->rowCount();
                        
                        echo "<div class = 'container'>";
                           $theMsg ="<div class = 'alert alert-success'>" . $icount . ' ' . "Record Inserted" . "</div>";
                           redirectHome($theMsg,'back',0.1);
                        echo "</div>";
                        }
                      }else{
                        //echo "sorry you cannot browse this page directly";
                        echo "<div class = 'container'>";
                           $theMsg ="<div class ='alert alert-danger'>sorry there is no enough quantity</div>";
                           redirectHome($theMsg,'back');
                        echo "</div>";
                      }
                

                        

            }else{
                //echo "sorry you cannot browse this page directly";
                echo "<div class = 'container'>";
                    $theMsg ="<div class ='alert alert-danger'>sorry you cannot browse this page directly</div>";
                    redirectHome($theMsg,'back');
                echo "</div>";

            }

         //==========================================================================================================//==============================================Manage Page=================================================
         //**********************************************************************************************************
          }elseif($do=="endShift")
          {
            $real_day = date('d');
            $real_month = date('m');
            $real_year = date('Y');

            $stmt7 = $con->prepare("SELECT * FROM config ");
            $stmt7 ->execute();
            $config1  = $stmt7->fetch();

            $current_shiftt = $config1['current_shift'];
            $shift_day = $config1['shift_day'];
            $shift_month =$config1['shift_month'];
            $shift_year =$config1['shift_year'];

            if($current_shiftt == "one"){
              $current_shiftt ="two";
            }
            else{
              $current_shiftt ="one";
            }


            if($shift_day != $real_day && $current_shiftt == "one"){
              $shift_day = $real_day;
            }

            if($shift_month != $real_month){
              $shift_month = $real_month;
            }

            if($shift_year != $real_year){
              $shift_year = $real_year;
            }

            

            $stmt = $con->prepare("UPDATE config SET current_shift = ?,shift_day = ?,shift_month = ?,shift_year = ? WHERE ID = 1");
            $stmt->execute(array($current_shiftt,$shift_day,$shift_month,$shift_year));
            $icount = $stmt->rowCount();
            if($icount > 0){
              echo "<div class = 'container'>";
                    $theMsg ="<div class ='alert alert-success'>Shift ended successfuly</div>";
                    redirectHome($theMsg,'home',0.1);
                echo "</div>";
            }
            



         //==========================================================================================================//==============================================Manage Page=================================================
         //**********************************************************************************************************
          }elseif($do == 'ChangeType')
          {
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $d_id  = $_POST['d_id'];
                $type  = $_POST['type'];
                $all = $_POST['all'];
                $time_price = $_POST['time_price'];
                $drinks_price = $_POST['drinks_price'];
                $money = $_POST['wanted'];
                $date = date('Y:m:d');
                $time = date('H:i:s');
                $h = idate('H');
                $m = idate('i');
                $s = idate('s');
                if($type == 1){$type = 'single';}elseif($type == 2){$type = 'multi';}
         
            
        
                 $stmt7 = $con->prepare("SELECT * FROM config ");
                 $stmt7 ->execute();
                 $config1  = $stmt7->fetch();

                 $current_shift = $config1['current_shift'];
                 $shift_day = $config1['shift_day'];
                 $shift_month =$config1['shift_month'];
                 $shift_year =$config1['shift_year'];
                 
                 //check if device already on
                 $stmt1  =$con->prepare("SELECT device_status FROM devices WHERE ID = ? AND device_status = ?");
                 $stmt1  ->execute(array($d_id,"off"));
                 $count1  = $stmt1->rowCount();
          
                 //if device on
                 if($count1 == 0) {

                    //fetch Reports id
                    $stmt6 = $con->prepare("SELECT Reports_ID FROM reports  WHERE Device_ID = ? AND status = ? LIMIT 1" );
                    $stmt6->execute(array($d_id,'live'));
                    $report=$stmt6->fetch();
                    $report_id = $report['Reports_ID'];
                    //fetch Reports bill
                    $stmt5 = $con->prepare("SELECT Reports_bill FROM reports  WHERE Device_ID = ? AND status = ? LIMIT 1" );
                    $stmt5->execute(array($d_id,'live'));
                    $report=$stmt5->fetch();
                    $report_bill = $report['Reports_bill'];
                    
                    /*
                    //finish ps orders and set it done
                    $stmt3 = $con->prepare("UPDATE ps_orders SET status = ?, Reports_ID = ?  WHERE Device_ID = ? AND status = ?");
                    $stmt3->execute(array('done', $report_id,$device_id,'live' ));
                    $icount3 = $stmt3->rowCount();
                    */

                    //send linked bill to reports
                    $stmt2 = $con->prepare("UPDATE reports SET all_time = ?, time_bill = ?,total_bill = ?, end_date = ?, end_time = ?,current_shift = ?,shift_day = ?,shift_month = ?,shift_year = ?, status = ?  WHERE Device_ID = ? AND status = ?");
                    $stmt2->execute(array($all,$time_price,$time_price,$date,$time,$current_shift,$shift_day,$shift_month,$shift_year,'link',$d_id,'live' ));
                    $icount2 = $stmt2->rowCount();


                    //turn off device
                    $stmt = $con->prepare("UPDATE devices SET device_status = ?, hour = ?, minute = ?, second = ?,type = ? WHERE ID = ?");
                    $stmt->execute(array('off', '', '', '', '', $d_id));
                    $icount = $stmt->rowCount();

                    ///// return on device with new type//////
                    $stmt = $con->prepare("UPDATE devices SET device_status = ?, hour = ?, minute = ?, second = ?, type = ? WHERE ID = ?");
                    $stmt->execute(array('on', $h, $m, $s, $type, $d_id));
                    $icount = $stmt->rowCount();

            // fetch device name
            $stmt4 = $con->prepare("SELECT * FROM devices WHERE ID = ? ");
            $stmt4 ->execute(array($d_id));
            $devices  = $stmt4->fetchAll();
            foreach ($devices as $device ) {
               $device_name = $device['Name'];
            }
            $status ='live'; 
           //insert start reports in database
             $stmt2 = $con->prepare("INSERT INTO
                                reports( Reports_bill,Device_ID, device_name, type, start_date, start_time, status) 
                                    VALUES 
                                       (:ibill,:idid, :iname, :itype, :idate, :itime, :istatus)");
             $stmt2->execute(array(
                          'ibill'  => $report_bill,
                          'idid'   => $d_id,
                          'iname'   => $device_name,
                          'itype'   => $type,
                          'idate'    => $date,
                          'itime' => $time,
                          'istatus' => $status
                         ));
             $icount2 = $stmt2->rowCount();
             ////////////////////////////////////////////



            
                    if($icount > 0 && $icount2 > 0){
                        header('Location: home.php' );
                        exit();
                    }
                  }//closing of if $count1

                
            }else{
                //echo "sorry you cannot browse this page directly";
                echo "<div class = 'container'>";
                    $theMsg ="<div class ='alert alert-danger'>sorry you cannot browse this page directly</div>";
                    redirectHome($theMsg,'back');
                echo "</div>";

            }  

         //==========================================================================================================//==============================================Manage Page=================================================
         //**********************************************************************************************************
          }elseif($do == 'ChangeDevice'){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $d_id  = $_POST['d_id'];
                $new_device  = $_POST['new_device'];
                $type  = $_POST['type'];
                $all = $_POST['all'];
                $time_price = $_POST['time_price'];
                $drinks_price = $_POST['drinks_price'];
                $money = $_POST['wanted'];
                $date = date('Y:m:d');
                $time = date('H:i:s');
                $h = idate('H');
                $m = idate('i');
                $s = idate('s');
                if($type == 1){$type = 'single';}elseif($type == 2){$type = 'multi';}
         
            
        
                 $stmt7 = $con->prepare("SELECT * FROM config ");
                 $stmt7 ->execute();
                 $config1  = $stmt7->fetch();

                 $current_shift = $config1['current_shift'];
                 $shift_day = $config1['shift_day'];
                 $shift_month =$config1['shift_month'];
                 $shift_year =$config1['shift_year'];

          
                 //check if device already on
                 $stmt1  =$con->prepare("SELECT device_status FROM devices WHERE ID = ? AND device_status = ?");
                 $stmt1  ->execute(array($d_id,"off"));
                 $count1  = $stmt1->rowCount();
          
                 //if device on
                 if($count1 == 0) {

                    //fetch Reports id
                    $stmt6 = $con->prepare("SELECT Reports_ID FROM reports  WHERE Device_ID = ? AND status = ? LIMIT 1" );
                    $stmt6->execute(array($d_id,'live'));
                    $report=$stmt6->fetch();
                    $report_id = $report['Reports_ID'];
                    //fetch Reports bill
                    $stmt5 = $con->prepare("SELECT Reports_bill FROM reports  WHERE Device_ID = ? AND status = ? LIMIT 1" );
                    $stmt5->execute(array($d_id,'live'));
                    $report=$stmt5->fetch();
                    $report_bill = $report['Reports_bill'];
                    
                    
                    //transfare ps orders to new device
                    $stmt3 = $con->prepare("UPDATE ps_orders SET device_id = ? WHERE device_ID = ? AND status = ?");
                    $stmt3->execute(array( $new_device,$d_id,'live' ));
                    $icount3 = $stmt3->rowCount();
                    

                    //send linked bill to reports
                    $stmt2 = $con->prepare("UPDATE reports SET all_time = ?, time_bill = ?,total_bill = ?, end_date = ?, end_time = ?,current_shift = ?,shift_day = ?,shift_month = ?,shift_year = ?, status = ?  WHERE Device_ID = ? AND status = ?");
                    $stmt2->execute(array($all,$time_price,$time_price,$date,$time,$current_shift,$shift_day,$shift_month,$shift_year,'link',$d_id,'live' ));
                    $icount2 = $stmt2->rowCount();


                    //turn off device
                    $stmt = $con->prepare("UPDATE devices SET device_status = ?, hour = ?, minute = ?, second = ?,type = ? WHERE ID = ?");
                    $stmt->execute(array('off', '', '', '', '', $d_id));
                    $icount = $stmt->rowCount();

                    ///// return on new device //////
                    $stmt = $con->prepare("UPDATE devices SET device_status = ?, hour = ?, minute = ?, second = ?, type = ? WHERE ID = ?");
                    $stmt->execute(array('on', $h, $m, $s, $type, $new_device));
                    $icount = $stmt->rowCount();

            // fetch device name
            $stmt4 = $con->prepare("SELECT * FROM devices WHERE ID = ? ");
            $stmt4 ->execute(array($new_device));
            $devices  = $stmt4->fetchAll();
            foreach ($devices as $device ) {
               $device_name = $device['Name'];
            }
            $status ='live'; 
           //insert start reports in database
             $stmt2 = $con->prepare("INSERT INTO
                                reports( Reports_bill,Device_ID, device_name, type, start_date, start_time, status) 
                                    VALUES 
                                       (:ibill,:idid, :iname, :itype, :idate, :itime, :istatus)");
             $stmt2->execute(array(
                          'ibill'  => $report_bill,
                          'idid'   => $new_device,
                          'iname'   => $device_name,
                          'itype'   => $type,
                          'idate'    => $date,
                          'itime' => $time,
                          'istatus' => $status
                         ));
             $icount2 = $stmt2->rowCount();
             ////////////////////////////////////////////



            
                    if($icount > 0 && $icount2 > 0){
                        header('Location: home.php' );
                        exit();
                    }else{
                       echo "<div class = 'container'>";
                          $theMsg ="<div class ='alert alert-danger'>there is error</div>";
                          redirectHome($theMsg,'back');
                       echo "</div>";

                    }
                  }//closing of if device on $count1

                
            }else{
                //echo "sorry you cannot browse this page directly";
                echo "<div class = 'container'>";
                    $theMsg ="<div class ='alert alert-danger'>sorry you cannot browse this page directly</div>";
                    redirectHome($theMsg,'back');
                echo "</div>";

            } 
          }elseif($do=="Delete")
          {
          	echo "<h1 class='text-center'>Delete Device</h1>  <br  />";
                $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) :0;

                $stmt  = $con->prepare("SELECT * FROM ps_orders  WHERE ORDER_ID = ?  LIMIT 1" );
                $stmt  ->execute(array($id));
                $row   = $stmt->fetch();
                $count = $stmt->rowCount();

                $s_id      = $row['s_id'];
                $order_num = $row['order_num'];




                if ($count > 0){

                	$stmt = $con->prepare("UPDATE stock SET s_quantity = s_quantity + ? WHERE S_ID = ?");
                    $stmt->execute(array($order_num, $s_id));
                    $icount = $stmt->rowCount();


                  $stmt = $con->prepare("DELETE FROM ps_orders WHERE ORDER_ID = :did");
                  $stmt->bindParam(":did", $id);
                  $stmt->execute();
                  $dcount= $stmt->rowCount();

                  //echo '<div class ="alert alert-success">' . $dcount .' '. 'Record Deleted</div>';
                  echo "<div class = 'container'>";
                      $theMsg ='<div class ="alert alert-success">' . $dcount .' '. 'item Deleted</div>';
                      redirectHome($theMsg);
                    echo "</div>";


                   

                } else {
                  //echo "This ID is not Exist";
                  echo "<div class = 'container'>";
                      $theMsg ='<div class ="alert alert-danger">This ID is not Exist</div>';
                        redirectHome($theMsg);
                  echo "</div>";



                }

         //==========================================================================================================//==============================================Manage Page=================================================
         //**********************************************************************************************************
         	}       

     include $tpl . 'footer.php';




   }else {

    header('Location: home.php' );
    exit();

}
   ob_end_flush();
?>