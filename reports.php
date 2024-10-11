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

            ?>
   <!-- Begin Page Content -->
   <div class="container-fluid">    
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Reports</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                          <a href="reports.php?do=Day">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Day</div>
                                            
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </a>  
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                          <a href="reports.php?do=Month">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Month</div>
                                            
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </a>  
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                          <a href="reports.php?do=Year">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Year</div>
                                            
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </a>  
                        </div>

                        

                        
                    </div>
            </div>        
       <?php

         //==========================================================================================================//==============================================Manage Page=================================================
         //**********************************************************************************************************
          }elseif($do=="Day"){

            $stmt7 = $con->prepare("SELECT * FROM config ");
            $stmt7 ->execute();
            $config1  = $stmt7->fetch();

            if(isset($_GET['day'])){$day = $_GET['day'];}else{$day = $config1['shift_day'];}
            if(isset($_GET['month'])){$month = $_GET['month'];}else{$month = $config1['shift_month'];}
            if(isset($_GET['year'])){$year = $_GET['year'];}else{$year = $config1['shift_year'];}
 

            

            $stmt = $con->prepare('SELECT SUM(total_bill) AS total_bill,SUM(time_bill) AS time_bill,SUM(drinks_bill) AS drinks_bill FROM reports WHERE shift_day = ? AND shift_month = ? AND shift_year = ?');
            $stmt->execute(array($day,$month,$year));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $total_bill = $row['total_bill'];
            $time_bill = $row['time_bill'];
            $drinks_bill = $row['drinks_bill'];

            echo "<div class='container'>";
            $shift =  $year.'/'.$month.'/'.$day;
            echo $shift;
            echo "<br/>";

            ?>
            <div class="row">
              <div class="col-sm-12 col-md-12">
                <form  class="form-horizontal" action="reports.php" method="get">
                    <div class="form-row">
                    <input type="hidden" name="do" class="form-control" autocomplete="off"   value="Day" />
                    <!-- start Name -->
                    <div class="form-group col-md-3">
                      <label class="control-label">Day</label>
                      <div>
                        <input type="number" name="day" class="form-control" autocomplete="off"   value="<?php echo $day; ?>" />
                      </div>
                    </div>
                    <!--end Name-->
                    <!-- start Name -->
                    <div class="form-group col-md-3">
                      <label class="control-label">Month</label>
                      <div>
                        <input type="number" name="month" class="form-control" autocomplete="off"   value="<?php echo $month; ?>" />
                      </div>
                    </div>
                    <!--end Name-->
                    <!-- start Name -->
                    <div class="form-group col-md-3">
                      <label class="control-label">Year</label>
                      <div>
                        <input type="number" name="year" class="form-control" autocomplete="off"  value="<?php echo $year; ?>" />
                      </div>
                    </div>
                    <!--end Name-->
                    <!--start submit items-->
                    <div class="form-group col-md-3">
                      <label class="control-label">Search</label>
                      <div class="">
                        <input type="submit" value="Show Reports" class="btn btn-primary" />
                      </div>
                    </div>
                    <!--end submit items--> 
                    </div>

               </form>
              </div>
            </div>
            <div class="row">

                  <div class="col-md-6">
                  <table class="cash_tablee table">
                     <tbody>
                       <tr>
                         <th>Time Earnings :</th>
                         <td><?php echo $time_bill ." "."L.E"; ?></td>
                       </tr>
                       <tr>
                         <th>Drinks Earnings :</th>
                         <td><?php echo $drinks_bill ." "."L.E"; ?></td>
                       </tr>
                       <tr>
                         <th>Total Earnings</th>
                         <td class="last"><?php  echo $total_bill ." "."L.E"; ?></td>
                       </tr>
                     </tbody>
                   </table>
                   <?php
                   /*$day = date("l");
                   if($total_bill > 1000){
                    ?>
                    <div class="text-center laugh-emoji"><i class="far fa-laugh-wink fa-4x"></i><div class="laugh-text"> والعة معاكو بسم الله ما شاء الله</div></div>
                    <?php
                   }elseif($total_bill <= 1000 && $total_bill > 800){
                    ?>
                    <div class="text-center smile-emoji"><i class="far fa-smile-beam fa-4x"></i><div class="laugh-text">زى الفل الحمد الله بوس ايدك وش وضهر </div></div>
                    <?php

                   }elseif($total_bill <= 800 && $total_bill > 650){
                    ?>
                    <div class="text-center meh-emoji"><i class="far fa-meh fa-4x"></i><div class="laugh-text">مش وحش الى جاى احسن ان شاء الله</div></div>
                    <?php

                   }elseif($total_bill <= 650){
                    ?>
                    <div class="text-center sad-emoji"><i class="far fa-sad-tear fa-4x"></i><div class="laugh-text"> <i class="far fa-grin-tears"></i> لا انتو تشوفولكو شغلانة تانيه احسن   </div></div>
                    <?php

                   }
                   */
                   ?>
                   
                 </div>
                 

                 <div class="col-md-6">
                   <div class="row">
                                
                                <div class="col-lg-6 mb-4">
                                  <a href="reports.php?do=Bills&&day=<?php echo $day; ?>&&month=<?php echo $month; ?>&&year=<?php echo $year; ?>">
                                    <div class="card bg-primary text-white shadow">
                                        <div class="card-body">
                                            Bills
                                            <div class="text-white-50 small">more details</div>
                                        </div>
                                    </div>
                                  </a>  
                                </div>
                                
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-success text-white shadow">
                                        <div class="card-body">
                                            Orders
                                            <div class="text-white-50 small">more details</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-info text-white shadow">
                                        <div class="card-body">
                                            Info
                                            <div class="text-white-50 small">#36b9cc</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-warning text-white shadow">
                                        <div class="card-body">
                                            Warning
                                            <div class="text-white-50 small">#f6c23e</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-danger text-white shadow">
                                        <div class="card-body">
                                            Takeaway Orders
                                            <div class="text-white-50 small">more details</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-secondary text-white shadow">
                                        <div class="card-body">
                                            Secondary
                                            <div class="text-white-50 small">#858796</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-light text-black shadow">
                                        <div class="card-body">
                                            Light
                                            <div class="text-black-50 small">#f8f9fc</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-dark text-white shadow">
                                        <div class="card-body">
                                            Dark
                                            <div class="text-white-50 small">#5a5c69</div>
                                        </div>
                                    </div>
                                </div>
                     
                   </div>
                 </div>



            </div>
            <?php
            echo "</div>";
            

          }elseif($do=="Month"){

          }elseif($do=="Year"){

          }
          elseif($do=="Bills"){
            
            if(isset($_GET['day'])){$day = $_GET['day'];}else{$day = $config1['shift_day'];}
            if(isset($_GET['month'])){$month = $_GET['month'];}else{$month = $config1['shift_month'];}
            if(isset($_GET['year'])){$year = $_GET['year'];}else{$year = $config1['shift_year'];}
            ?>
            <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Reports</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Num</th>
                                            <th>Shift</th>
                                            <th>Device</th>
                                            <th>Type</th>
                                            <th>Start</th>
                                            <th>End</th>
                                            <th>Time</th>
                                            <th>Time Money</th>
                                            <th>Drinks Money</th>
                                            <th>Total Paid</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="thead-dark">
                                        <tr>1
                                            <th>Num</th>
                                            <th>Shift</th>
                                            <th>Device</th>
                                            <th>Type</th>
                                            <th>Start</th>
                                            <th>End</th>
                                            <th>Time</th>
                                            <th>Time Money</th>
                                            <th>Drinks Money</th>
                                            <th>Total Paid</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php

                                        /*$stmt = $con->prepare('SELECT SUM(total_bill) AS value_sum FROM reports WHERE Reports_bill = ?');
                                        $stmt->execute(array($id));
                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $sum = $row['value_sum'];*/
                                         
                                         $status ="done";
                                         $stmt4 = $con->prepare("SELECT * FROM reports WHERE status = ? AND shift_day = ? AND shift_month = ? AND shift_year = ? ");
                                         $stmt4 ->execute(array($status,$day,$month,$year));
                                         $reports  = $stmt4->fetchAll();

                                         foreach ($reports as $report) {
                                           
                                           ?>
                                           
                                           <tr>
                                            <th><?php echo $report['Reports_bill'] ?></th>
                                            <th>
                                              <?php
                                               echo $report['current_shift'] ."<hr/>"
                                               .$report['shift_year']."/".$report['shift_month']."/".$report['shift_day'];

                                              ?>

                                                
                                            </th>
                                            <th><?php echo $report['device_name'] ?></th>
                                            <th><?php echo $report['type'] ?></th>
                                            <th><?php echo $report['start_date']."<hr/> ".$report['start_time'] ?></th>
                                            <th><?php echo $report['end_date']."<hr/> ".$report['end_time'] ?></th>
                                            <th><?php echo gmdate('H:i:s',$report['all_time']) ?></th>
                                            <th><?php echo $report['time_bill']; ?></th>
                                            <th><?php $report_drinks = $report['drinks_bill']; if($report_drinks==0){echo "No Drinks";}else{
                                                 echo "<a href='reports.php?do=Orders&&report_bill=". $report['Reports_bill'] ."'>" . $report_drinks . "</a>";
                                                } ?></th>

                                                
                                            <th><?php
                                              $stmt = $con->prepare('SELECT SUM(total_bill) AS value_sum FROM reports WHERE Reports_bill = ?');
                                              $stmt->execute(array($report['Reports_bill']));
                                              $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                              $sum = $row['value_sum']; 
                                              echo "<a href='reports.php?do=Orders&&report_bill=". $report['Reports_bill'] ."'>" . $sum . "</a>"; 
                                            ?></th>

                                           </tr>
                                           
                                           <?php
                                         }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            
            <!-- End of Main Content -->
            <?php

          }elseif($do=="Orders"){

             $report_bill = isset($_GET['report_bill']) && is_numeric($_GET['report_bill']) ? intval($_GET['report_bill']) :0;

             $stmt1  =$con->prepare("SELECT Reports_bill FROM reports WHERE Reports_bill = ?");
             $stmt1  ->execute(array($report_bill));
             $count1  = $stmt1->rowCount();

             if($count1 > 0){       
               ?>
               <div class="container">
                <h2 class="text-center">Bill Details</h2>
                 <div class="row">
                   <div class="col-sm-12 col-md-12 col-lg-12">
                     <div class="table-responsive">
                     <table class="text-center table table-sm table-bordered">
                     <thead class="thead-dark">
                       <tr>
                         <th>Device</th>
                         <th>Type</th>
                         <th>Start</th>
                         <th>End</th>
                         <th>Time</th>
                         <th>Time Money</th>
                         <th>Drinks Money</th>
                         <th>Total Paid</th>
                       </tr>
                     </thead>
                     <tbody>
                      <?php
                      $stmt4 = $con->prepare("SELECT * FROM reports WHERE Reports_bill = ? ");
                      $stmt4 ->execute(array($report_bill));
                      $reports  = $stmt4->fetchAll();
                      foreach ($reports as $report) { 
                        ?>
                        <tr>
                         <th><?php echo $report['device_name']; ?></th>
                         <th><?php echo $report['type']; ?></th>
                         <th><?php echo $report['start_date'] ."<hr/>" .$report['start_time']; ?></th>
                         <th><?php echo $report['end_date'] ."<hr/>" .$report['end_time']; ?></th>
                         <th><?php $all=$report['all_time']; echo gmdate('H:i:s',$all);  ?></th>
                         <th><?php echo $report['time_bill']; ?></th>
                         <th><?php echo $report['drinks_bill']; ?></th>
                         <th><?php echo $report['total_bill']; ?></th>                          
                        </tr>
                        <?php
                      }
                         ?>           

        
                     </tbody>
                   </table>
                   </div>
                   </div>                  
                   <div class="col-sm-12 col-md-3 col-lg-3">
                     <div class="table-responsive">
                     <table class="table table-sm table-responsive table-bordered">
                     <thead class="thead-dark">
                       <tr>
                         <th scope="col">Item</th>
                         <th scope="col">Quantity</th>
                         <th scope="col">Price</th>
                       </tr>
                     </thead>
                     <tbody>
                      <?php
                      $stmt4 = $con->prepare("SELECT * FROM ps_orders WHERE status = ? AND Reports_bill = ? ");
                      $stmt4 ->execute(array('done',$report_bill));
                      $reports  = $stmt4->fetchAll();
                 
                      foreach ($reports as $report) {
                       
                                echo "<tr'>";
                                     echo "<td>" . $report['order_name']          . "</td>";
                                     echo "<td>" . $report['order_num']        . "</td>";
                                     echo "<td>" . $report['order_price']   . "</td>";
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
                 

             }else{
              //there is no such id
              echo "<div class='container'>"; 
                echo "<div class='alert alert-danger'>";
                  echo "There is no such Bill";
                echo "</div>";
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