<?php include('login_auth.php');
$current_menu='view_artcile';
if(isset($_GET['artcile_id'])){
			$id=$_GET['artcile_id'];
			$title="";
			$path="";
			$content="";
			$sql="select title,path from m_article where id='".$id."'";
			require('../backend/conn.php');
			$q_res=$conn->query($sql);
			$q_res->setFetchMode(PDO::FETCH_ASSOC);
			$artcile=$q_res->fetchALL();
			if(!empty($artcile)){
				$title=$artcile[0]['title'];				
				$path='../artcile/'.$artcile[0]['path'];
				$content=file_get_contents(iconv("UTF-8","gb2312",$path));
				$_SESSION['artcile_id']=$id;

			}
			else{
				$title="您访问的文件不存在&nbsp;&nbsp;&nbsp;&nbsp;";
				$content="您访问的文件不存在";
			}
		}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>文章</title>
	<?php include('head.php');?>
	<style>
	body{
		background: url(../images/view_artcile.jpg);
	}
	.container{
		background: rgba(255,255,255,0.9);
		margin-top: 20px;
		border-radius: 20px;
		padding-bottom: 20px;
		animation:myfirst 0.5s;
	}
	@keyframes myfirst
		{
			0%{opacity: 0;
			}
			100%{opacity: 1;
			}
		}
	</style>
	<script>
	$(document).ready(
	function(){
		$('.nav li:nth-child(3)').addClass("active");
	});
</script>
</head>
<body>
	<?php include('nav.php');?>
	<div class="container">
		<h1><?php echo $title;?><button type="reset" onclick="history.go(-1);" class="btn btn-default" style="float: right;">返回上一页面</button></h1>
			<?php echo $content;?><br />
	</div>
</body>
</html>