<?php include('login_auth.php');
$current_menu='edit_artcile';
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
		background: url(../images/add_article.jpg);
	}
	.container{
		border-radius: 20px;
		background: rgba(255,255,255,0.9);
		margin-top: 20px;
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
		var content=UM.getEditor('myEditor').getContent();
		var title=$('#title').val();
		$.ajax({
			url:"../backend/article.php?method=insert",
			type:'post',
			data:{title:title,content:content},
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
	<form class="form-inline">
		<h1><div class="form-group">标题：<input type="text" id="title" class="form-control" placeholder="标题" style="width: 300px;" /></div></h1>
		<textarea type="text/plain" id="myEditor" style="width:1135px;height:400px;margin:0 auto;">
			
		</textarea>
		<br />
		<button type="button" onclick="submitcontent()" class="btn btn-primary">发 表 文 章</button>
		<button  type="reset" onclick="history.go(-1);" class="btn btn-default">返回上一页面</button>
		
	</div>
	</form>
	<script type="text/javascript">
        var ue = UM.getEditor('myEditor');
    </script>
</body>
</html>