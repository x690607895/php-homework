<?php
	header('Content-type:text/json;');
	require('conn.php');
	$method = $_GET['method'];
	if($method=='register'){
		$result=register();
		echo json_encode($result);
	}elseif($method=='login'){
		$result=login();
		echo json_encode($result);
	}elseif ($method =='logout'){
		logout();
	}elseif ($method=='save'){
		save();
	}elseif ($method=='delete'){
		$result=delete();
		echo json_encode($result);
	}
function delete(){
	$result = array();
	$id = $_GET['id'];
	if(empty($id)){
		$result['status'] = 0;
		$result['msg']='id不能为空';
		return $result;
	}
	global $conn;
	$sql="delete from m_user where id=".$id;
	$q_res = $conn->exec($sql);
	if($q_res !== false){
		$result['status'] = 1;
		$result['msg']='删除成功';
		return $result;
	}
	else{
		$result['status'] = 0;
		$result['msg']='删除失败';
		return $result;
	}
	
}
function save(){
		global $conn;
		$username = $_POST['username'];
		$relname = $_POST['relname'];
		$sex = $_POST['sex'];
		$age = $_POST['age'];
		$mobile = $_POST['mobile'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		$time=date("Y-m-d H:i:s");
		$sql="update m_user set realname=:realname,sex=:sex,age=:age,email=:email,address=:address,mobile=:mobile,update_time=:update_time where username=:username";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam('username',$username);
		$stmt->bindParam('realname',$relname);
		$stmt->bindParam('age',$age);
		$stmt->bindParam('sex',$sex);
		$stmt->bindParam('mobile',$mobile);
		$stmt->bindParam('email',$email);
		$stmt->bindParam('address',$address);
		$stmt->bindParam('update_time',$time);
		$check=$stmt->execute();
		if($check==true)
		{
			header('location:../front/username_manger.php');
		}
		else
		{
			exit('保存失败');
		}
	}
function logout(){
		session_start();
		session_unset($_SESSION);
		session_destroy($_SESSION);
		header('location:../front/login.php');
		if(empty($id)){
			exit('id不能为空');
	}
	}

function login(){
	global $conn;
	$username = $_POST['username'];
	$password = $_POST['password'];
	$check_pwd = "/^[0-9a-zA-Z]{0,10}$/";
	if(empty($username)){
		$result['status'] = 0;
		$result['msg']='用户名不能为空';
		return $result;
	}
	if(empty($password)){
		$result['status'] = 0;
		$result['msg']='密码不能为空';
		return $result;
	}
	if(!preg_match($check_pwd, $password)){
		$result['status'] = 0;
		$result['msg']='请不要输入非法字符';
		return $result;
	}
	$sql="select id,password from m_user where username='".$username."'";
	$check=$conn->query($sql);
	$password=md5($password);
	$check->setFetchMode(PDO::FETCH_ASSOC);
	while($row=$check->fetch(2)){
	if($row['password']==$password){
		session_start();
		$_SESSION['username']=$username;
		$_SESSION['id']=$row['id'];
		$result['status'] = 1;
		$result['msg']='登入成功';
		return $result;
	}
	else{
		$result['status'] = 0;
		$result['msg']='用户名或者密码错误';
		return $result;
	}
	}
}
function register(){
	global $conn;
	$username = $_POST['username'];
	$password = $_POST['password'];
	$repassword = $_POST['repassword'];
	$relname = $_POST['relname'];
	$sex = $_POST['sex'];
	$age = $_POST['age'];
	$mobile = $_POST['mobile'];
	$email = $_POST['email'];
	$address = $_POST['address'];
	$check_pwd = "/^[0-9a-zA-Z]{0,10}$/";
	$check_email = "/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/";
	$check_mobile = "/^1\d{2,11}$/";
	$result = array();
	if(empty($username)){
		$result['status'] = 0;
		$result['msg']='用户名不能为空';
		return $result;
	}
	if(empty($password)){
		$result['status'] = 0;
		$result['msg']='密码不能为空';
		return $result;
	}
	if(empty($repassword)){
		$result['status'] = 0;
		$result['msg']='确认密码不能为空';
		return $result;
	}
	if($password!=$repassword){
		$result['status'] = 0;
		$result['msg']='密码和确认密码不一致';
		return $result;
	}
	if(!preg_match($check_pwd, $password)&&!preg_match($check_pwd, $repassword)){
		$result['status'] = 0;
		$result['msg']='密码请输入A-Z、a-z、0-9，长度在0-10位之间';
		return $result;
	}
	if(!(int)$age){
		$result['status'] = 0;
		$result['msg']='请输入正确的年龄';
		return $result;
	}
	if((int)$age<=0||(int)$age>110){
		$result['status'] = 0;
		$result['msg']='请输入正确的年龄';
		return $result;
	}
	if(!preg_match($check_email, $email)){
		$result['status'] = 0;
		$result['msg']='请输入正确的邮箱地址';
		return $result;
	}
	if(!preg_match($check_mobile, $mobile)){
		$result['status'] = 0;
		$result['msg']='请输入正确的手机号';
		return $result;
	}
	$q_existz_sql="select count(id)as cnt from m_user where username='".$username."'";
	$q_res = $conn->query($q_existz_sql);
	$res_arr=$q_res->fetch();
	if($res_arr['cnt']>=1){
		$result['status'] = 0;
 		$result['msg'] = '用户名已存在，请重新输入 -_-/';
 		return $result;
	}
	$password=md5($password);
	$time=time();
	$sql="insert into m_user(username,password,realname,age,sex,mobile,email,address,create_time,update_time) values(:username,:password,:relname,:age,:sex,:mobile,:email,:address,:create_time,:update_time)";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam('username',$username);
	$stmt->bindParam('password',$password);
	$stmt->bindParam('relname',$relname);
	$stmt->bindParam('age',$age);
	$stmt->bindParam('sex',$sex);
	$stmt->bindParam('mobile',$mobile);
	$stmt->bindParam('email',$email);
	$stmt->bindParam('address',$address);
	$stmt->bindParam('create_time',$time);
	$stmt->bindParam('update_time',$time);
	$check=$stmt->execute();
	if($check==true)
	{
		$result['status'] = 1;
		$result['msg']='注册成功';
	}
	else
	{
		$result['status'] = 0;
		$result['msg']='注册失败';
	}
	return $result;
}
?>