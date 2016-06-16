<?php
//判断用户是否已登录，如果登录则显示此页面，没有，则跳转到登录
session_start();
if(empty($_SESSION['username']))
{
	header('location:login.php');
}

?>
