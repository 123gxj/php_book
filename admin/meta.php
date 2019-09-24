<?php
include_once("common.php");
include_once("../includes/init.php");
?>
<meta charset="utf-8">
<title><?php echo $configlist[0]['value']  ?></title>
<link rel="shortcut icon" href="<?php echo ASSETS_PATH.$configlist[1]['value'] ?>" type="image/x-icon" />
<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="<?php echo  $configlist[2]['name']  ?>" content="<?php echo  $configlist[2]['value']  ?>" />
<meta name="<?php  echo $configlist[3]['name']  ?>" content="<?php  echo $configlist[3]['value']  ?>" />


<!-- css样式 -->
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_PATH;?>/lib/bootstrap/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_PATH;?>/stylesheets/theme.css">
<link rel="stylesheet" href="<?php echo ADMIN_PATH;?>/lib/font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_PATH;?>/stylesheets/common.css">
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_PATH;?>/stylesheets/elements.css">
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_PATH;?>/stylesheets/page.css">

<!-- js样式 -->
<script src="<?php echo ADMIN_PATH;?>/lib/jquery-1.7.2.min.js" type="text/javascript"></script>