<?php
	header('Content-type:text/json;');
	if($_GET['method']=="insertUserList")
	{	
		echo json_encode(insertUserList());
	}	

	function randusername(){
		$namelist="abcdefghijklmnopqrstuvvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_";
		$name="";
		$j=rand(6,20);
		for($i=0;$i<$j;$i++)
		{
			$k=rand(6,20);
			$name=substr($namelist,$k,1).$name;
		}
		return $name;
	}
	
	function data(){
		$data=array();
		$data['username']=randusername();
		$data['password']=md5("123");
		$data['realname']=randusername();
		$data['age']=rand(20,50);
		if(rand(0,1)==1)
		{
			$data['sex']="男";
		}
		else
		{
			$data['sex']="女";
		}
		
		$data['mobile']="10000000000";
		$data['email']="abc@abc.com";
		$data['create_time']=time();
		$data['update_time']=time();
		return $data;
	}

	function userlist($total=20){
		$userlist=array();
		for($i=0;$i<$total;$i++)
		{
				$userlist[$i]=data();
		}
		return $userlist;
	}

	function insertUserList($num=20){
		$userlist=array();
		$result=array();
		$result['total']=$num;
		$result['success']=0;
		$result['faild']=0;
		$result['chongfu']=0;
		$userlist=userlist($result['total']);
		require('conn.php');
		$sql="INSERT into m_user (username, password,realname, age,sex,mobile,email,create_time,update_time) values (:username,:password,:realname,:age,:sex,:mobile,:email,:create_time,:update_time)";
		for($i=0;$i<$result['total'];$i++)
		{
			$q_existz_sql="select count(id)as cnt from m_user where username='".$userlist[$i]['username']."'";
			$q_res = $conn->query($q_existz_sql);
			$res_arr=$q_res->fetch();
			if($res_arr['cnt']>=1){
				$result['chongfu']++;
				break;
			}
			$stmt = $conn->prepare($sql);
			$stmt->bindParam('username',$userlist[$i]['username']);
			$stmt->bindParam('password',$userlist[$i]['password']);
			$stmt->bindParam('realname',$userlist[$i]['realname']);
			$stmt->bindParam('age',$userlist[$i]['age']);
			$stmt->bindParam('sex',$userlist[$i]['sex']);
			$stmt->bindParam('mobile',$userlist[$i]['mobile']);
			$stmt->bindParam('email',$userlist[$i]['email']);
			$stmt->bindParam('create_time',$userlist[$i]['create_time']);
			$stmt->bindParam('update_time',$userlist[$i]['update_time']);
			$check=$stmt->execute();
			if($check==true)
			{
				$result['success']++;
			}
			else
			{	
				$result['faild']++;
			}
		}
		return $result;
	}
?>