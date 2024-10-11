<?php
if (isset($_SESSION['username'])) {
	include 'init.php';
	include $tpl . 'footer.php';
}else{
   header('Location: login.php' );
   exit();
}