<?php
date_default_timezone_set('Africa/Cairo');
$script_tz = date_default_timezone_get();
if (strcmp($script_tz, ini_get('date.timezone'))){} else {}
?>