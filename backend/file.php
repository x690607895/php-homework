<?php
	header('Content-type:text/json;');
	$method = $_GET['method'];
	if($method=='save'){
		$result=save();
		echo json_encode($result);
	}

	function save(){
		session_start();
		$result=array();
		$myfile = fopen($_SESSION['filetitle'], "w");
		fwrite($myfile, $_POST['content']);
		fclose($myfile);
		unset ($_SESSION['filetitle']);
		$result['status'] = 1;
		$result['msg']='修改成功';
		return $result;
	}
?>