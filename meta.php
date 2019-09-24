<?php
include_once("includes/init.php");
include_once("common.php");
?>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="applicable-device" content="mobile">
  <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0" />
  <meta content="yes" name="apple-mobile-web-app-capable" />
  <meta content="black" name="apple-mobile-web-app-status-bar-style"  />
  <meta content="telephone=no" name="format-detection" />
  <meta http-equiv="Cache-Control" content="no-transform" />
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <title><?php echo $configlist[0]['value']  ?></title>
  <link rel="shortcut icon" href="<?php echo HOME_ASSETS.$configlist[1]['value'] ?>" type="image/x-icon" />

  <meta name="<?php echo  $configlist[2]['name']  ?>" content="<?php echo  $configlist[2]['value']  ?>" />
<meta name="<?php  echo $configlist[3]['name']  ?>" content="<?php  echo $configlist[3]['value']  ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
  <link rel="stylesheet" href="<?php echo HOME_PATH;?>/css/m.css" />

  <script src="<?php echo HOME_PATH;?>/js/jquery-1.9.1.min.js"></script>
  <script src="<?php echo HOME_PATH;?>/js/touchslide.1.1.js"></script>