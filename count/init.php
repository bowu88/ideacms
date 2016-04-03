<?php
session_name("webjoker_count");
session_start();
$info="";
$ifcookie=0;
if(isset($_SESSION["webjoker_count_admin"]) and $_SESSION["webjoker_count_admin"]=="admin"){$ifcookie=1;}
if($ifcookie==0){
	if($_GET["mod"]=="log"){
		$admin=$_POST["admin"];
		$pass=$_POST["pass"];
		if(cheakPass($admin,$pass)){
			$_SESSION["webjoker_count_admin"]="admin";
			Header("Location:index.php");
		} else {
			$info="<script>alert('用户名或密码错误！');</script>";
		}
	}
	include("template/login.php");
} else {
	switch($_GET["mod"]){
		case "logout":
			session_destroy();
			Header("Location:index.php");
		break;
		case "setting":
			include("include/setting.php");
			mysqli_close($conn);
			exit(0);
		break;
		default:
			include("template/top.php");
			include("template/table.php");
		break;
	}
}
include("template/footer.php");
mysqli_close($conn);
?>