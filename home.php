<?php
session_start();
 
if (isset($_SESSION['username'])) {
 
  include 'init.php';

      $do = isset($_GET['do']) ? $_GET['do'] : "defult";
      $psid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) :0;
      



      $h = idate('H');
      $m = idate('i');
      $s = idate('s');

      if($_SERVER['REQUEST_METHOD'] == 'POST'){
         $id   = $_POST['id'];
         $type = $_POST['type'];
         $date = date('Y:m:d');
         $time = date('H:i:s');
         $status ='live';
         
         $stmt4 = $con->prepare("SELECT * FROM devices WHERE ID = ? ");
         $stmt4 ->execute(array($id));
         $devices  = $stmt4->fetchAll();
         foreach ($devices as $device ) {
           $device_name = $device['Name'];
         }
        

         if($type == 1){$type = 'single';}elseif($type == 2){$type = 'multi';}
         
         $stmt1  =$con->prepare("SELECT device_status FROM devices WHERE ID = ? AND device_status = ?");
         $stmt1  ->execute(array($id,"on"));
         $count1  = $stmt1->rowCount();

         if($count1 == 0) {
           $stmt = $con->prepare("UPDATE devices SET device_status = ?, hour = ?, minute = ?, second = ?, type = ? WHERE ID = ?");
           $stmt->execute(array('on', $h, $m, $s, $type, $id));
           $icount = $stmt->rowCount();
           
           //fetch reports bill to increase it 1
           $stmt2  =$con->prepare("SELECT Reports_bill FROM reports ORDER BY Reports_bill DESC LIMIT 1");
           $stmt2  ->execute(array());
           $reports_bill  = $stmt2->fetch();
           $count2  = $stmt2->rowCount();
           if($count2 == 1){$report_bill = $reports_bill['Reports_bill'] + 1;}
           else{$report_bill = 1;}
             
           //insert userinfo in database
             $stmt2 = $con->prepare("INSERT INTO
                                reports( Reports_bill,Device_ID, device_name, type, start_date, start_time, status) 
                                    VALUES 
                                       (:ibill,:idid, :iname, :itype, :idate, :itime, :istatus)");
             $stmt2->execute(array(
                          'ibill'  => $report_bill,
                          'idid'   => $id,
                          'iname'   => $device_name,
                          'itype'   => $type,
                          'idate'    => $date,
                          'itime' => $time,
                          'istatus' => $status
                         ));
             $icount2 = $stmt2->rowCount();
          }

      }


      

   
    
       if($do =='end'){ //end device actions

          //check if device status not on
          
        }//closing of if $do=end


      $h = idate('H');
      $m = idate('i');
      $s = idate('s');

      $stmt2 = $con->prepare("SELECT * FROM devices ");
      $stmt2 ->execute();
      $devices  = $stmt2->fetchAll();

      ?>
      <div class="container">
        <div class="row">
          <?php
            foreach ($devices as $device) {

               if($device['device_status'] == 'on'){// if device on start
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
                
                


                ?>
               
                <div class='col-lg-3 col-md-4 col-sm-6'>
                <a href='device-hall.php?id=<?php echo $device['ID']; ?> '>
                <div class='psbox thumbnail'>
                  <p class='text-center'><?php echo $device['Name']; ?></p>
                   
                     <?php if ($device['psversion'] =='PS4') { ?>

                       <div class='text-center'>
                         <img src='img/pss4.png' alt='' />
                       </div>

                     <?php }else{ ?>

                       <div class='text-center'>
                         <img src='img/xbox2.png' alt='' />
                       </div>

                     <?php } ?>
                     <p class='text-center'><?php echo $device['type']; ?></p>
                     <div class='text-center'>  
                       <h2 id="mytimer_<?php echo $device['ID'] ?>"><?php echo $all?> </h2>
                     </div>
                     
                     <div class='text-center'>
                       <a href='device-hall.php' class='start-devicee btn btn-primary'>Info</a>
                     </div>
                     <div class="busy">
                       <span >Busy</span>
                     </div>  
                  </div>
                 </a>
                </div>

<script type="text/javascript">
  secs       =  parseInt(document.getElementById('mytimer_<?php echo $device['ID'] ?>').innerHTML,10);
  setTimeout("countdown('mytimer_<?php echo $device['ID'] ?>',"+secs+")", 1000);

  function countdown(id, timer){
        timer++;
        hourRemain = Math.floor(timer / 3600)%24;
        minRemain  = Math.floor(timer / 60 )%60;
        secsRemain = new String(timer %60);
        // Pad the string with leading 0 if less than 2 chars long
        if (secsRemain.length < 2) {
          secsRemain = '0' + secsRemain;
        }

        // String format the remaining time
        clock      = hourRemain + ":" + minRemain + ":" + secsRemain;
        document.getElementById(id).innerHTML = clock;
        if ( timer > 0 ) {
          // Time still remains, call this function again in 1 sec
          setTimeout("countdown('" + id + "'," + timer + ")", 1000);
        } else {
          document.getElementById(id).style.display = 'none';

          //    alert("One Playstation Time Has ended Please Bill the Customers");
          //    window.location = "devices_ps.php?id=<? echo $deviceID;?>"
          //  document.write("<p>The text from the intro paragraph: " + x.innerHTML + "</p>");
          //document.getElementById("done_<? echo $deviceID;?>").innerHTML="Bill";
          // Time is out! Hide the countdown
        }
        
      }
</script>

                <?php
              //if device on end
              //if device on end


               }else{ // if device off start
                ?> 
                <div class='col-md-3 col-sm-6'>
                   <div class='psbox thumbnail'>
                     <p class='text-center'> <?php echo $device['Name']; ?> </p>

                     <?php if ($device['psversion'] =='PS4') { ?>

                         <div class='text-center'>
                             <img src='img/ps4.png' alt='' />
                         </div>

                    <?php }else{ ?>

                          <div class='text-center'>
                             <img src='img/xbox.png' alt='' />
                          </div>

                    <?php } ?>  
                     <form class="login100-form" action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
                        <input type="hidden" name="id" value="<?php echo $device['ID'] ?>">
                        <select class="single form-control" name="type">
                           <option value="1">Single</option>
                           <option value="2">Multi</option>                           
                        </select>
                      
                        <!--
                        <div class="container">
                           <span  class="show btn-circle" style="margin-bottom: 4px;">
                             <i class="fas fa-arrow-circle-down fa-2x"></i>
                           </span>
                        </div>
                        -->
                        
                        <!--start submit-->
                        <div class="container">
                           <button class="start-device btn btn-primary">
                             Start
                           </button>
                        </div>
                        <!--end submit-->
                     </form>

                     

                     <div class="available">
                       <span >Available</span>
                     </div>   
                   </div>                  
                 </div>
               <?php } // if device off end
            }
           ?>
        </div>
      </div>


      <?php
      
      
      
  
  
  include $tpl . 'footer.php';

}else{
   header('Location: login.php' );
   exit();
}