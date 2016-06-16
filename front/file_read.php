<?php include('login_auth.php');
$current_menu='fileread_manger';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>文件查看</title>
	<?php include('head.php');?>
	<style>
	body{
		background: url(../images/file_read.jpg);
		background-attachment: fixed;
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
</script>
</head>
<body>
	<div style="position: fixed;width: 100%;z-index: 100;">
	<?php include('nav.php');?>
	</div>
	<div class="container" style="opacity: 0.95">
	<div class="panel panel-default" style="width:1200px;margin:80px auto 20px auto;z-index: 5">
	<div class ="panel-heading" style="position: fixed; width: 1198px;"><div style="width: 800px;margin-top: 5px;float: left;"><?php echo isset($_GET['filepath'])?  $_GET['filepath'] : '你访问的文件出错了';?></div><button type="reset" onclick="history.go(-1);" class="btn btn-default" style="float: right;">返回上一页面</button></div>
	<div class="panel-body">
		<?php 
			$check=0;
			if(isset($_GET['filepath'])){
				if(dirname($_GET['filepath'])>=$_SERVER['DOCUMENT_ROOT']){
					if (is_file($_GET['filepath'])) {
						$file=file(iconv("UTF-8","gb2312",$_GET['filepath']));
						foreach($file as $v){
							echo nl2br(htmlspecialchars($v));
						}
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
	</div>
</body>
</html>