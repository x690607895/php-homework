<?php
	session_start();
	require('../backend/conn.php');
	header('Content-type:text/json;');
	$method = $_GET['method'];
	if($method=='update'){
		$result=update();
		echo json_encode($result);
	}
	else if($method=='insert'){
		$result=insert();
		echo json_encode($result);
	}
	else if($method=='delete'){
		$result=deleteart();
		echo json_encode($result);
	}

	function trimall($str)//删除空格
	{
    	$qian=array(" ","　","\t","\n","\r");$hou=array("","","","","");
    	return str_replace($qian,$hou,$str);    
	}

	function deleteart(){
		$id=$_POST['id'];
		global $conn;
		$sql="delete from m_article where id='".$id."'";
		$q_res=$conn->exec($sql);
		if($q_res==true){
			$result['status'] = 1;
			$result['msg']='删除成功';
			return $result;
		}
		else
		{
			$result['status'] = 0;
			$result['msg']='删除失败';
			return $result;
		}

	}

	function insert(){
		global $conn;
		$title=$_POST['title'];
		$content=$_POST['content'];
		$creator_id=$_SESSION['id'];
		$filename="";
		if(empty(trimall($title))){
			$result['status'] = 0;
			$result['msg']='请填写文章标题';
			return $result;
		}
		if(empty(trimall($content))){
			$result['status'] = 0;
			$result['msg']='请填写文章内容';
			return $result;
		}
		$sql="select count(*) as count from m_article";
		$q_res=$conn->query($sql);
		$q_res->setFetchMode(PDO::FETCH_ASSOC);
		$artciletotal=$q_res->fetchALL();
		if(!empty($artciletotal)){
			$count=$artciletotal[0]['count'];
			if(strlen($title)>5){
				$filename=substr($title,0,5).($count+1).'.txt';
			}
			else{
				$filename=$title.($count+1).'.txt';
			}
			$num=file_put_contents('../artcile/'.$filename, $content);
			if($num==strlen($content)){
				$sql="insert into m_article (title,path,creator_id) values (:title,:path,:creator_id)";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam('title',$title);
				$stmt->bindParam('path',$filename);
				$stmt->bindParam('creator_id',$creator_id);
				$check=$stmt->execute();
				if($check==true)
				{
					$result['status'] = 1;
					$result['msg']='发表成功';
					return $result;
				}
				else
				{
					$result['status'] = 0;
				$result['msg']='发表失败';
				return $result;
				}
			}
			else{
				$result['status'] = 0;
				$result['msg']='发表失败';
				return $result;
			}
		}
		
	}

	function update(){
		$id=$_SESSION['artcile_id'];
		$content=$_POST['content'];
		global $conn;
		$sql="select path from m_article where id='".$id."'";
		$q_res=$conn->query($sql);
		$q_res->setFetchMode(PDO::FETCH_ASSOC);
		$artcilepath=$q_res->fetchALL();
		if(!empty($artcilepath)){
			$path='../artcile/'.$artcilepath[0]['path'];
			$num=file_put_contents($path, $content);
			if($num==strlen($content)){
				$result['status'] = 1;
				$result['msg']='修改成功';
				return $result;
			}
			else{
				$result['status'] = 0;
				$result['msg']='修改失败';
				return $result;

			}
		}
		
	}
?>