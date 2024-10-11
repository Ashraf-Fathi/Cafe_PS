<?php
 ob_start();   
 session_start();
 $pageTitle = 'Device hall';

    include "init.php";

    $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) :0;
    $ds = "on";

      $h = idate('H');
      $m = idate('i');
      $s = idate('s');

      $stmt = $con->prepare("SELECT Reports_bill FROM reports  WHERE Device_ID = ? AND status = ? LIMIT 1" );
      $stmt->execute(array($id,'live'));
      $reports_bills   =$stmt->fetchAll();
      foreach ($reports_bills as $reports_bill ) {
               $reportss_bill = $reports_bill['Reports_bill'];
            }
      

      $stmt = $con->prepare("SELECT * FROM devices  WHERE ID = ? AND device_status = ? LIMIT 1" );
      $stmt->execute(array($id,$ds));
      $device   =$stmt->fetch();
      $count =$stmt->rowCount();

      if($count > 0){

       $start_h = $device['hour'];
       $start_m = $device['minute'];
       $start_s = $device['second'];

       $hdif = $h - $start_h;
       $mdif = $m - $start_m;
       $sdif = $s - $start_s;

           if($hdif < 0){$hdif = $hdif + 24;}

            $all  = ($hdif * 60 * 60) + ($mdif * 60) + $sdif;
            if($device['type']=='single'){$price = $device['single'];}elseif($device['type']=='multi'){$price = $device['multi'];}
            $fprice= ($price / 3600) * $all;
            $ffprice= ceil( $fprice);
            if($ffprice < 1){$ffprice=1;}
            $time = gmdate('H:i:s',$all);


      
      ?>
      <div class="container">
      	<div class="row">
      		<div class="col-sm-6"><!-- start left side (control)-->
           <div class="row">
            <!--start first part left side-->
      			<div class="rb-border col-sm-6"> 
              <form  class="form-horizontal" action="action.php?do=Insert" method="POST">
              <input type="hidden" name="d_id" value="<?php echo $id ?>" />
                    <!--start select item-->
                    <div class="form-group">
                      <label class="control-label">Item</label>
                      <div class="">
                        <select class="form-control" name="s_id">
                           <option value="0">...</option>
                           <?php

                           $stmt =$con->prepare("SELECT * FROM stock");
                           $stmt ->execute();
                           $items =$stmt->fetchAll();

                           foreach ($items as  $item) {
                             if($item['s_quantity'] > 0){
                              echo "<option value='" . $item['S_ID'] . "'>" . $item['s_name'] . "</option>";
                             }
                              
                            } 
                           ?>
                        </select>
                      </div>
                    </div>
                    <!--end select item-->
                    <!--start num items-->
                    <div class="form-group">
                      <label class="control-label">Num</label>
                      <div class="">
                        <input type="number" step="1" name="s_num" class="form-control"  required = 'required' />
                      </div>
                    </div>
                    <!--end num items-->
                    <!--start submit items-->
                    <div class="form-group">
                      <div class="">
                        <input type="submit" value="Add Order" class="btn btn-primary" />
                      </div>
                    </div>
                    <!--end submit items--> 

            </form>
            </div> 
            <!--end first part left side-->

            <!--start second part left side-->
            <div class="lb-border col-sm-6">
              <form  class="form-horizontal" action="action.php?do=ChangeType" method="POST">
              <input type="hidden" name="d_id" value="<?php echo $id ?>" />
              <input type="hidden" name="all" value="<?php echo $all ?>" />
              <input type="hidden" name="time_price" value="<?php echo $ffprice ?>" />
                    <!--start select item-->
                    <div class="form-group">
                      <label class="control-label">Change Type</label>
                      <div class="">
                        <select class="form-control" name="type">
                           <?php if( $device['type'] == "single" ){
                            ?>
                            <option value="2">Multi</option>
                            <?php
                           }
                            elseif( $device['type'] == "multi" ){
                            ?>
                            <option value="1">Single</option>
                            <?php
                           } ?>
                        </select>
                      </div>
                    </div>
                    <!--end select item-->
                    <!--start submit items-->
                    <div class="form-group">
                      <div class="">
                        <input type="submit" value="Change" class="btn btn-primary" />
                      </div>
                    </div>
                    <!--end submit items--> 

            </form>
            </div>
            <!--end second part left side-->
            <!--start third part left side-->
            <div class="rb-border col-sm-6">
            </div>
            <!--end third part left side-->  
            <!--start fourth part left side-->
            <div class="rb-border col-sm-6"> 
              <form  class="form-horizontal" action="action.php?do=ChangeDevice" method="POST">
              <input type="hidden" name="d_id" value="<?php echo $id ?>" />
              <input type="hidden" name="all" value="<?php echo $all ?>" />
              <input type="hidden" name="time_price" value="<?php echo $ffprice ?>" />
              <input type="hidden" name="type" value="<?php echo $device['type'] ?>" />
                    <!--start select item-->
                    <div class="form-group">
                      <label class="control-label">Change Device</label>
                      <div class="">
                        <select class="form-control" name="new_device">
                           <?php
                           $stmt =$con->prepare("SELECT * FROM devices WHERE device_status ='off'");
                           $stmt ->execute();
                           $devicess =$stmt->fetchAll();

                           foreach ($devicess as  $devicee) {
                              
                              echo "<option value='" . $devicee['ID'] . "'>" . $devicee['Name'] . "</option>";           
                            }
                           ?>
                        </select>
                      </div>
                    </div>
                    <!--end select item-->
                    <!--start submit items-->
                    <div class="form-group">
                      <div class="">
                        <input type="submit" value="Change" class="btn btn-primary" />
                      </div>
                    </div>
                    <!--end submit items--> 

            </form>
            </div>
            <!--end fourth part left side-->

      			
      		</div><!-- end left side (control)-->
          </div>

      		<div class="l-border col-sm-6"><!-- start right side (bill)-->
                
            <div class="time"><!-- start of time-->
      			   <h4>Time</h4>
      			   <table class="table table-dark">
                     <thead>
                       <tr>
                         <th scope="col">Device Name</th>
                         <th scope="col">Type</th>
                         <th scope="col">time</th>
                         <th scope="col">Bill</th>
                       </tr>
                     </thead>
                     <tbody>
                       <tr>
                         <th><?php echo $device['Name'] ?></th>
                         <th><?php echo $device['type'] ?></th>
                         <td><?php echo $time ?></td>
                         <td><?php echo $ffprice ?></td>
                       </tr>
                     </tbody>
               </table>
               <h4>Old Time</h4>
               <table class="table table-sm table-light">
                     <thead>
                       <tr>
                         <th scope="col">Device Name</th>
                         <th scope="col">Type</th>
                         <th scope="col">Time</th>
                         <th scope="col">Bill</th>
                       </tr>
                     </thead>
                     <tbody> <?php
                       $stmt = $con->prepare("SELECT * FROM reports  WHERE Reports_bill = ? AND status = ?" );
                       $stmt->execute(array($reportss_bill,'link'));
                       $old_times   =$stmt->fetchAll();

                       foreach ($old_times as $old_time ) { ?>
                       <tr>
                         <th><?php echo $old_time['device_name'] ?></th>
                         <th><?php echo $old_time['type'] ?></th>
                         <td><?php echo gmdate('H:i',$old_time['all_time']) ?></td>
                         <td><?php echo $old_time['time_bill'] ?></td>
                       </tr>                         
                        <?php } ?>

                     </tbody>
               </table>
      			</div><!-- end of time-->
      			<div><!-- start drinks -->
      				<h4>Drinks</h4>
      			   <table class="table table-dark">
                     <thead>
                       <tr>
                         <th scope="col">Item</th>
                         <th scope="col">Quantity</th>
                         <th scope="col">Price</th>
                         <th scope="col">Delete</th>
                       </tr>
                     </thead>
                     <tbody>
                       
                         <?php
                          $stmt =$con->prepare("SELECT * FROM ps_orders WHERE device_id = ? AND status = ? ");
                           $stmt ->execute(array($id,'live'));
                           $orders =$stmt->fetchAll();

                           foreach($orders as $order ) { 

                                echo "<tr'>";
                                     echo "<td>" . $order['order_name']          . "</td>";
                                     echo "<td>" . $order['order_num']        . "</td>";
                                     echo "<td>" . $order['order_price']   . "</td>";
                                     echo "<td>";
                                               echo "<a href='action.php?do=Delete&id=" . $order['ORDER_ID'] . "' class='btn btn-danger btn-circle confirm'><i class ='fas fa-trash'></i></a>";  
                                     echo"</td>";
                                echo "</tr>";
                            }
                         ?>
                       
                     </tbody>
                   </table>

                   <?php
                   //$stmt =$con->prepare("SELECT SUM(total_price) AS prices FROM ps_orders WHERE device_id = ? ");
                   //$stmt ->execute(array($id));
                   //$drinks_money =$stmt->fetchAll();
                   $stmt = $con->prepare('SELECT SUM(total_price) AS value_sum FROM ps_orders WHERE device_id = ? AND status = ?');
                   $stmt->execute(array($id,'live'));
                   $row = $stmt->fetch(PDO::FETCH_ASSOC);
                   $sum = $row['value_sum'];

                   $stmt8 = $con->prepare('SELECT SUM(time_bill) AS value_sum1 FROM reports WHERE Reports_bill = ? AND status = ?');
                   $stmt8->execute(array($reportss_bill,'link'));
                   $row8 = $stmt8->fetch(PDO::FETCH_ASSOC);
                   $sum8 = $row8['value_sum1'];
                   ?>

                   <table class="cash_table table">
                     <tbody>
                       <tr>
                         <th>Time :</th>
                         <td><?php $fffprice = $ffprice + $sum8; echo $fffprice ." "."L.E"; ?></td>
                       </tr>
                       <tr>
                         <th>Drinks :</th>
                         <td><?php echo $sum ." "."L.E"; ?></td>
                       </tr>
                       <tr>
                         <th>Total</th>
                         <td class="last"><?php $wanted = $ffprice + $sum; $wantedd = $ffprice + $sum + $sum8; echo $wantedd ." "."L.E"; ?></td>
                       </tr>
                     </tbody>
                   </table>
      				
      			</div><!-- end drinks -->
      			<div><!-- start button & form-->
              <form action="action.php?do=endDevice" method="POST">
                <input type="hidden" name="device_id" value="<?php echo $id; ?>">
                <input type="hidden" name="time" value="<?php echo $all; ?>">
                <input type="hidden" name="time_price" value="<?php echo $ffprice; ?>">
                <input type="hidden" name="drinks_price" value="<?php echo $sum; ?>">
                <input type="hidden" name="wanted" value="<?php echo $wanted; ?>">
                
                <button class="btn btn-primary btn-icon-split btn-lg">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-flag"></i>
                                        </span>
                                        <span class="text">E N D</span>
                                    </button>
                
              </form>
                   	 <?php
                   	 //echo "<a href='home.php?do=end&id=" . $device['ID'] . "' class='btn btn-primary'><i class='fas fa-play'></i>End</a>";
                   	 ?>
                </div><!-- end button-->
      			
      		</div><!-- start right side (bill)-->
      		
      	</div>

      </div>
      <?php
      }else{
      	header('Location: home.php' );
        exit();
      }








    include $tpl . 'footer.php';

 ob_end_flush();
?>