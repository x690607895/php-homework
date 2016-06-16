<?php include('login_auth.php');
$current_menu='file_manger';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>文件列表</title>
	<?php include('head.php');?>
	<style>
	body{
		background: url(../images/file_manger.jpg);
		background-attachment: fixed;
	}
	.container{
		background: rgba(255,255,255,0.95);
		margin-top:50px;
		border-radius: 20px;
	}
	div{
		animation:myfirst 0.5s;
	}
	@keyframes myfirst
		{
			0%{opacity: 0;}
			100%{opacity: 1;}
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
	<?php include('nav.php');?>
	<div class="container">
		<?php 
			if(isset($_GET['path'])&&$_GET['path']>=$_SERVER['DOCUMENT_ROOT']."/")
			{	
				$dir=$_GET['path']."/";
			}
			else
			{
				$dir=$_SERVER['DOCUMENT_ROOT']."/demo/";
				
			}
			$dirh = opendir($dir);
		?>
		<table class="table" style="width:1100px;margin-left:auto;margin-right:auto;">
			<caption>
				<h3 style="font-weight:800;text-align:center;"><?php echo $dir?>的内容</h3>
				<?php
					if(isset($_GET['path'])&&$_GET['path']>=$_SERVER['DOCUMENT_ROOT']."/")
					{	
						echo '<a href="?path='.dirname($dir).'" class="btn btn-default" style="float:right">返回上层目录</a>';
					}
				?>
			</caption>
			<thead>
				<tr>
						<th>文件名</th>
						<th>类型</th>
						<th>大小</th>
						<th>修改时间</th>
						<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php
					while($file=readdir($dirh)){
						if($file!="."&&$file!=".."){
							$dirfile=$dir.$file;
							echo '<tr>';
							if(is_dir($dirfile))
							{
								echo '<td> <a href="?path='.iconv("GBK","UTF-8",$dirfile).'">'.iconv("GBK","UTF-8",$dirfile).'</a></td>';
								echo '<td>'.filetype($dirfile).'</td>';
								echo '<td>'.filesize($dirfile).'</td>';
								echo '<td>'.date("Y-n-t",filemtime($dirfile)).'</td>';
								echo '<td></td>';
							}
							else
							{
								$check_filetype='/^php|txt|sql|css|js$/';
								echo '<td>'.iconv("GBK","UTF-8",$dirfile).'</td>';
								echo '<td>'.pathinfo($file, PATHINFO_EXTENSION).'</td>';
								echo '<td>'.filesize($dirfile).'</td>';
								echo '<td>'.date("Y-n-t",filemtime($dirfile)).'</td>';
								echo '<td>';
								if(preg_match($check_filetype, pathinfo($file, PATHINFO_EXTENSION))){
									echo '<a href="file_read.php?filepath='.iconv("GBK","UTF-8",$dirfile).'">查看</a>&nbsp;&nbsp;&nbsp;';
									echo '<a href="file_edit.php?filepath='.iconv("GBK","UTF-8",$dirfile).'">修改</a>';
								}
								echo '</td>';

							}

							echo '</tr>';
						}
					}
					closedir($dirh);
				?>
			</tbody>
		</table>

			
</body>
</html>