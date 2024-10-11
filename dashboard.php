<?php
 ob_start();   
 session_start();
 if (isset($_SESSION['usertype'])) {
 $pageTitle = 'Dashboard';
      

     include "init.php";

     
       ?>
   <!-- Begin Page Content -->
   <div class="container-fluid">    
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                          <a href="devices.php">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Devices</div>
                                            
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-tv fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </a>  
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                          <a href="stock.php">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Stock</div>
                                            
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-cubes fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </a>  
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                          <a href="games.php">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                 Games &  PSN</div>
                                            
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-cubes fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </a>  
                        </div>


                        

                        
                    </div>
            </div>        
       <?php





     include $tpl . 'footer.php';
}else{
   header('Location: login.php' );
   exit();
}
 ob_end_flush();
?>