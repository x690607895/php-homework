<?php include('login_auth.php');
$current_menu='edit_artcile';
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
				$title="您访问的文件不存在&nbsp;&nbsp;&nbsp;&nbsp;<a onclick=\"history.back(-1);\">请返回上一个页面</a>";
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
    <link href="../um/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="../um/third-party/jquery.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="../um/umeditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="../um/umeditor.min.js"></script>
    <script type="text/javascript" src="../um/lang/zh-cn/zh-cn.js"></script>
	<style>
	body{
		background: url(../images/edit_artcile.jpg);
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
	function submitcontent(){
		var data=UM.getEditor('myEditor').getContent();
		$.ajax({
			url:"../backend/article.php?method=update",
			type:'post',
			data:{content:data},
			success:function(data){
				if(data.status == 1){
					$.manhua_msgTips({
						msg:data.msg,
						type:'success'
					});
					setTimeout('history.go(-1)',2000);
				}
				else{
					$.manhua_msgTips({
						msg:data.msg,
						type:'error'
					})
				}
			},
			error:function(){
				$.manhua_msgTips({
						msg:"提交信息失败",
						type:'error'
					})
			}
		});
	}
</script>
</head>
<body>
	<?php include('nav.php');?>
	<div class="container">
	<form>
		<h1><?php echo $title;?></h1>
		<textarea type="text/plain" id="myEditor" style="width:1135px;height:400px;margin:0 auto;">
			<?php echo $content;?>
		</textarea><br />
		<button type="button" onclick="submitcontent()" class="btn btn-primary">提交</button>&nbsp;
		<button type="reset" onclick="history.go(0);" class="btn btn-default">重置</button>&nbsp;
		<button type="reset" onclick="history.go(-1);" class="btn btn-default">返回上一页面</button>&nbsp;
	</div>
	</form>
	<script type="text/javascript">
        var ue = UM.getEditor('myEditor');
       
    </script>
</body>
</html>