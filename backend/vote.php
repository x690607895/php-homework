<?php
	session_start();
	require('conn.php');
	header('Content-type:text/json;');
	$method = $_GET['method'];
	if($method=='addoptionitem'){
		$result=addoptionitem();
		echo json_encode($result);
	}
	else if($method=='insvote'){
		$result=insvote();
		echo json_encode($result);
	}
	else if($method=='vote'){
		$result=vote();
		echo json_encode($result);
	}
	else if($method=='data'){
		$result=data();
		echo json_encode($result);
	}

	function trimall($str)//删除空格
	{
    	$qian=array(" ","　","\t","\n","\r");$hou=array("","","","","");
    	return str_replace($qian,$hou,$str);    
	}

	function data(){
		$result=array();
		$label=array();
		$data=array();
		$color=array();
		$id=$_POST['id'];
		global $conn;
		$sql="select title from m_vote_list where id='".$id."'";
		$q_res=$conn->query($sql);
		$q_res->setFetchMode(PDO::FETCH_ASSOC);
		$title=$q_res->fetchALL();
		if(empty($title)){
			$result['status'] = 0;
			$result['msg']="您所要查看的投票不存在";
			return $result;
		}
		$sql="select id,name from m_vote_option where pid='".$id."'";
		$q_res=$conn->query($sql);
		$q_res->setFetchMode(PDO::FETCH_ASSOC);
		$optioncount=$q_res->fetchALL();
		if(!empty($optioncount)){
			for($i=0;$i<count($optioncount);$i++){
				$sql='select count(*) as total from m_vote_result where item_id=\''.$optioncount[$i]['id'].'\'';
				$q_res=$conn->query($sql);
				$q_res->setFetchMode(PDO::FETCH_ASSOC);
				$total=$q_res->fetchALL();
				if(!empty($total)){
					array_push($data, $total[0]['total']);
					array_push($label, $optioncount[$i]['name']);
					array_push($color, 'rgb('.rand(0,255).','.rand(0,255).','.rand(0,255).')');
				}
			}
			$result['status'] = 1;
			$result['data']=$data;
			$result['color']=$color;
			$result['label']=$label;
			$result['title']=$title[0]['title'];
			return $result;
		}


	}

	function vote(){
		$result=array();
		$check=current($_POST);
		$ip=$_SESSION['ip'];
		$vote_time=time();
		if(empty(trimall($check)))
		{
			$result['status'] = 0;
			$result['msg']='请选择投票项';
			return $result;
		}
		$sql="select * from m_vote_result where ip='".$ip."' and item_id='".$check."'";
		global $conn;
		$query_sql=$conn->query($sql);
		if($query_sql->rowCount()==null){
			$sql="insert into m_vote_result (ip,vote_time,item_id) values (:ip,:vote_time,:item_id)";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam('ip',$ip);
			$stmt->bindParam('vote_time',$vote_time);
			$stmt->bindParam('item_id',$check);
			$check=$stmt->execute();
			if($check==true)
			{
				$result['status'] = 1;
				$result['msg']='投票成功';
				return $result;
			}
			else
			{
				$result['status'] = 0;
				$result['msg']='投票失败';
				return $result;
			}
		}
		else
		{
			$result['status'] = 0;
			$result['msg']="您已经投过票了";
			return $result;
		}
		

	}

	function insvote(){
		$result=array();
		$title=$_POST['title'];
		$checktitle=trimall($title);
		global $conn;
		if(!empty($checktitle)){
			$sql="select id from m_vote_list where title='".$title."'";
			$query_sql=$conn->query($sql);
			if($query_sql->rowCount()==null){
				session_start();
				$create_time=time();
				$update_time=time();
				$creator_id=$_SESSION['id'];
				$sql="insert into m_vote_list(title,create_time,update_time,creator_id) values (:title,:create_time,:update_time,:creator_id)";
				$ins_sql=$conn->prepare($sql);
				$ins_sql->bindParam('title',$title);
				$ins_sql->bindParam('create_time',$create_time);
				$ins_sql->bindParam('update_time',$update_time);
				$ins_sql->bindParam('creator_id',$creator_id);
				$check_ins=$ins_sql->execute();
				if($check_ins!=false){
					$result['status'] = 1;
					$result['msg']='操作成功';
					return $result;
				}
				else{
					$result['status'] = 0;
					$result['msg']='操作失败';
					return $result;
				}
			}
			else{
				$result['status'] = 0;
				$result['msg']='已经存在这个标题的投票';
				return $result;
			}
		}
		else{
			$result['status'] = 0;
			$result['msg']='请填写需要发起投票的标题';
			return $result;
		}
	}

	function addoptionitem(){
		$result=array();
		$title=$_GET['title'];
		$option=$_GET['option'];
		$checkoption=trimall($option);
		if(!empty($option)&&(!empty($checkoption))){
			global $conn;
			$sql="select id from m_vote_list where title='".$title."'";
			$check=$conn->query($sql);
			$check->setFetchMode(PDO::FETCH_ASSOC);
			while($row=$check->fetch(2)){
				if(!empty($row['id'])){
					$titleid=$row['id'];
					$sql="select * from m_vote_option where name='".$option."' and pid=".$titleid;
					$stmt = $conn->prepare($sql);
					$check2=$conn->query($sql);
					$check2->setFetchMode(PDO::FETCH_ASSOC);
					if($check2->rowCount()==null){
						$sql="insert into m_vote_option(name,pid) values (:name,:pid)";
						$q_res = $conn->prepare($sql);
						$q_res->bindParam('name',$option);
						$q_res->bindParam('pid',$titleid);
						$check1=$q_res->execute();
						if($check1!= false){
							$result['status'] = 1;
							$result['msg']='操作成功';
							return $result;
						}
						else{
							$result['status'] = 0;
							$result['msg']='操作失败';
							return $result;
						}
					}
					else{
						$result['status'] = 0;
						$result['msg']='已存在相同选项';
						return $result;
					}
				}
				else{
					$result['status'] = 0;
					$result['msg']='你所操纵的投票标题不存在';
					return $result;
				}
			}
		}
		else{
			$result['status'] = 0;
			$result['msg']='选项名称不能为空';
			return $result;
		}
	}
?>



