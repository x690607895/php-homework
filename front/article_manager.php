<?php include('login_auth.php');
$current_menu='artcile_manger';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>文章</title>
	<?php include('head.php');?>
	<style>
	a{
		cursor: pointer;
	}
	body{
		background: url(../images/article_manager.jpg);
		background-attachment: fixed;
	}
	.container{
		background: rgba(255,255,255,0.9);
		border-radius: 20px;
		margin-top: 30px;
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
		$('.nav li:nth-child(3)').addClass("active");
	});
	$(function(){
		$('.js_del').click(function(){
			var $that=$(this);
			var id=$that.data('id');
			var txt=  "确定要删除吗";
			window.wxc.xcConfirm(txt, window.wxc.xcConfirm.typeEnum.confirm,{
				onOk:function(v){
					doajax(id);
			},
				onCancel:function(v){},
			});
		});
		function doajax(id){
			$.ajax({
				type:'post',
				data:{id,id},
				url:'../backend/article.php?method=delete',
				success:function(data){
					if(data.status==1){
						$.manhua_msgTips({
							msg:data.msg,
							type:'success'
						});
						setTimeout('location.reload();',2000);
					}else{
						$.manhua_msgTips({
							msg:data.msg,
							type:'error'
							});
						}
					},
				error:function(){
					$.manhua_msgTips({
							msg:"失败",
							type:'error'
						});
					}
			});
		}
	});
</script>
</head>
<body>
	<?php include('nav.php');?>
	<div class="container">
		<table class="table">
			<caption>
				<h3 style="font-weight:800;text-align:center;">文章列表<a type="button" class="btn btn-default" style="float:right;" href="add_article.php">发表文章</a></h3>
			</caption>
			<thead>
				<tr>
						<th>文章名称</th>
						<th>文章创建者</th>
						<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$sql="select id,title,creator_id from m_article";
					require('../backend/conn.php');
					$q_res=$conn->query($sql);
					$q_res->setFetchMode(PDO::FETCH_ASSOC);
					$artcilelist=$q_res->fetchALL();
					for($i=0;$i<count($artcilelist);$i++)
					{
						$sql="select username from m_user where id='".$artcilelist[$i]['creator_id']."'";
						$q_res=$conn->query($sql);
						$q_res->setFetchMode(PDO::FETCH_ASSOC);
						$creator=$q_res->fetchALL();
						echo '<tr>';
						echo '<td><a href="view_artcile.php?artcile_id='.$artcilelist[$i]['id'].'">'.$artcilelist[$i]['title'].'</a></td>';
						echo '<td>'.$creator[0]['username'].'</td>';
						echo '<td>';
						echo '<a href="edit_artcile.php?artcile_id='.$artcilelist[$i]['id'].'">修改</a>&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '<a data-id="'.$artcilelist[$i]['id'].'" class="js_del">删除</a>';
						echo '</td>';
						echo '</tr>';
					}
				?>
			</tbody>
		</table>
	</div>
</body>
</html>