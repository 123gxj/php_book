<?php
include_once("../includes/init.php");
checkLogin();  //判断管理员是否存在
$configlist = $db->select()->from("config")->all();

?>