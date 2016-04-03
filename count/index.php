<?php
//error_reporting(0);
$install=fopen("include/install.txt","r");
fclose($install);
if(!$install){
	Header("Location:install.php");
} else {
	include("include/config.php");
	include("include/main.php");
	include("init.php");
}
?>