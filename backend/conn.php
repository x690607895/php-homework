<?php
	define('DSN','mysql:host=localhost;dbname=mem_mgr');
	define('USERNAME','root');
	define('PASSWORD','');
	$conn = new PDO(DSN,USERNAME,PASSWORD);
	$conn->query('set names utf8');
?>