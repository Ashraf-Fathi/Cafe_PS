<?php

      session_start();
      
      $nonavbar = '';
      $noheader = '';
      $pageTitle= 'Login';
      if (isset($_SESSION['username'])) {
        header('Location: home.php');
      }

      include "init.php";

      function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }



         if($_SERVER['REQUEST_METHOD'] == 'POST'){

             $username  = $_POST['user'];
             $pass      = $_POST['pass'];
             $hashedPass= sha1($pass);


             $stmt = $con->prepare("SELECT
                                          UserID,Username, Password
                                    FROM
                                          users 
                                    WHERE
                                          Username = ? 
                                    AND
                                          Password = ? 
                                    LIMIT 1" );
             $stmt->execute(array($username, $hashedPass));
             $row   =$stmt->fetch();
             $count =$stmt->rowCount();
             
            if($count > 0) {
              $_SESSION['username'] = $username;
              $_SESSION['ID']   = $row['UserID'];
               $_SESSION['usertype'] = 1;
              header('Location: home.php');
              
             }else{
                 header('Location: login.php?error=wrong');
             }

             
         }
                    //   header('Location: login.php?error=wrong');


         if(isset($_GET['error'])){$error = $_GET['error'];}

         

    
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login V3</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
  <link rel="icon" type="image/png" href="login-page/images/icons/control.ico"/>
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="login-page/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="login-page/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="login-page/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="login-page/vendor/animate/animate.css">
<!--===============================================================================================-->  
  <link rel="stylesheet" type="text/css" href="login-page/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="login-page/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="login-page/vendor/select2/select2.min.css">
<!--===============================================================================================-->  
  <link rel="stylesheet" type="text/css" href="login-page/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="login-page/css/util.css">
  <link rel="stylesheet" type="text/css" href="login-page/css/main.css">
<!--===============================================================================================-->
</head>
<body>
  
  <div class="limiter">
    <div class="container-login100" style="background-image: url('login-page/images/bg-01.jpg');">
      
      <div class="wrap-login100" style="background-color: #b92525;
    background-image: linear-gradient(
180deg
,#d04040 10%,#47484c 100%);
    background-size: cover;">
        <?php if(isset($error)){
          echo "<div class='text-center alert alert-danger'>";
            echo "Username or password is incorrect";
          echo "</div>";
        } ?>
        <!--start form-->
        <form class="login100-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

          <span class="login100-form-logo">
            <img class="rounded-circle" style="width: 100px;" 
                                    src="img/undraw_gaming_6oy3.svg">
          </span>

          <span class="login100-form-title p-b-34 p-t-27">
            Log in
          </span>

          <!--start username-->
          <div class="wrap-input100">
            <input class="input100" type="text" name="user" placeholder="Username" required="required" autocomplete="off">
            <span class="focus-input100" data-placeholder="&#xf207;"></span>
          </div>
          <!--end username-->

          <!--start pass-->
          <div class="wrap-input100">
            <input class="input100" type="password" name="pass" placeholder="Password" required="required">
            <span class="focus-input100" data-placeholder="&#xf191;"></span>
          </div>
          <!--end pass-->

          <!--start submit-->
          <div class="container-login100-form-btn">
            <button class="login100-form-btn">
              Login
            </button>
          </div>
          <!--end submit-->

        </form>
        <!--end form-->
      </div>
    </div>
  </div>
  

  <div id="dropDownSelect1"></div>
  
<!--===============================================================================================-->
  <script src="login-page/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
  <script src="login-page/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
  <script src="login-page/vendor/bootstrap/js/popper.js"></script>
  <script src="login-page/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
  <script src="login-page/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
  <script src="login-page/vendor/daterangepicker/moment.min.js"></script>
  <script src="login-page/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
  <script src="login-page/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
  <script src="login-page/js/main.js"></script>

</body>
</html>