<?php include('login_auth.php');
$current_menu='fileedit_manger';
if(isset($_GET['filepath'])){
				if(dirname($_GET['filepath'])>=$_SERVER['DOCUMENT_ROOT']){
					if (is_file(iconv("UTF-8","gb2312",$_GET['filepath']))){
						$_SESSION['filetitle']=$_GET['filepath'];
						$a=dirname($_SESSION['filetitle']);
					}
				}
			}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>文件修改</title>
	<?php include('head.php');?>
	<style>
	body{
		background: url(../images/file_edit.jpg);
	}
		.container{
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
		$('.nav li:nth-child(5)').addClass("active");
	});
	$(function(){
		$("#sub_btn").click(function(){
			var data = $("form").serialize();
			$.ajax({
				url:"../backend/file.php?method=save",
				type:'post',
				data:data,
				success:function(data){
					if(data.status == 1){
						$.manhua_msgTips({
							msg:data.msg,
							type:'success'
						});
						setTimeout('location.href="file_manger.php?path=<?php echo $a?>"',2000);
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
		});	
	});
</script>
</head>
<body>
	<?php include('nav.php');?>
	<div class="container" style="opacity: 0.9;margin-top: 50px;border-radius: 20px;">
	<form action="../backend/file.php?method=save" method="post">
	<div class="panel panel-default">
	<div class ="panel-heading"><label><?php echo isset($_GET['filepath'])?  $_GET['filepath'] : '你访问的文件出错了';?></label><button type="reset" onclick="history.go(-1);" class="btn btn-default" style="float: right;">返回上一页面</button></div>
	<div class="panel-body">
		<?php 
			$check=0;
			if(isset($_GET['filepath'])){
				if(dirname($_GET['filepath'])>$_SERVER['DOCUMENT_ROOT']."/"){
					if (is_file(iconv("UTF-8","gb2312",$_GET['filepath']))){
						$file=file(iconv("UTF-8","gb2312",$_GET['filepath']));
						echo '<textarea name="content" class="form-control" rows="3" style="height:600px;resize:none">';
						foreach($file as $v){
							echo htmlspecialchars($v);
						}
						echo'</textarea>';
						echo '<br /><button id="sub_btn" type="button" class="btn btn-primary">修&nbsp;&nbsp;&nbsp;&nbsp;改</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button type="reset" class="btn btn-default">重&nbsp;&nbsp;&nbsp;&nbsp;置</button>';

						$_SESSION['filetitle']=$_GET['filepath'];
					}
					else{
						echo "你访问的文件不存在！！！（´Д`）<br />";
						echo '<a href="file_manger.php?path='.dirname($_GET['filepath']).'">请点击此链接返回</a>';
					}
				}
				else{
					$check=1;
				}
			}
			else{
				$check=1;
			}
			if($check==1)
			{
				echo "你没有访问该文件的权限！！！（´Д`）<br />";
				echo '<a href="file_manger.php">请点击此链接返回</a>';
			}
		?>
		
		
	</div>
	</div>
	</form>
	</div>
</body>
</html>