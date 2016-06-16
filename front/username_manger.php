<?php include('login_auth.php');
$current_menu='username_manger';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>主页</title>
	<?php include('head.php');?>
	<style>
	div{
		animation:myfirst 0.5s;
	}
	@keyframes myfirst
		{
			0%{opacity: 0;}
			100%{opacity: 1;}
		}
	body{
		background: url(../images/username_manger.jpg);
		background-attachment: fixed;
	}
	form.form-inline,table,caption{
		background-color: rgba(255,255,255,0.95);
	}
	</style>
	<script>
	$(document).ready(
	function(){
		$('.nav li:nth-child(2)').addClass("active");
	});
</script>
</head>
<body>
	<?php include('nav.php');?>
	<div class="container" style="margin-top: 20px;">
		<form class="form-inline" method="get" action="./username_manger.php" style="width: 1200px;margin: 0 auto;padding: 10px 0px; border-radius: 10px 10px 0px 0px;">
			<div style="width: 1100px;margin:10px auto;">
				<div class="form-group">
				<label>用户名:</label>
				<input type="text" name="username" class="form-control" placeholder="用户名"
	    value="<?php echo isset($_GET['username'])?$_GET['username']:''?>"></div>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<div class="form-group">
				<label>姓名:</label>
				<input type="text" name="realname" class="form-control" placeholder="姓名"
	    value="<?php echo isset($_GET['realname'])?$_GET['realname']:''?>"></div>
			<button type="submit" class="btn btn-default">查询</button>
			<button  type="button" style="float:right;" id="regvol_btn" class="btn btn-default">批量添加用户</button>
			</div>
		</form>
		<table class ="table" style="width:1200px;margin:0px auto;">
			<caption>
				<h3 style="font_weight:800;text-align:center">用户列表</h3>
			</caption>
			<thead>
				<tr>
					<th>编号</th>
					<th>用户名</th>
					<th>姓名</th>
					<th>年龄</th>
					<th>性别</th>
					<th>手机</th>
					<th>邮箱</th>
					<th>地址</th>
					<th>注册时间</th>
					<th>操作</th>
				</rt>
			</thead>
			<tbody>
			<?php
				require('../backend/conn.php');
				$where=" where ";
				$limit=" limit ";
				$start_limit=0;
				$fenye_total=0;
				$page=0;
				if(isset($_GET['username'])||isset($_GET['realname'])){
					if($_GET['username']==""){
						$where=$where."realname like '%".$_GET['realname']."%'";
					}
					else if ($_GET['realname']==""){
						$where=$where."username like '%".$_GET['username']."%'";
					}
					else{
						$where=$where."username like '%".$_GET['username']."%' and realname like '%".$_GET['realname']."%'";
					}
				}
				else{
					$where="";
				}
				$sql="select count(*) as total from m_user".$where;
				$q_fenye=$conn->query($sql);
				$q_fenye->setFetchMode(PDO::FETCH_ASSOC);
				$fenye=$q_fenye->fetchALL(); 
				$fenye_total=ceil(($fenye[0]['total']-1)/10);

				if(isset($_GET['page'])){
					if($_GET['page']<=1){
						$page=1;
					}
					else if($_GET['page']>=$fenye_total){
						$page=$fenye_total;
					}
					else{
						$page=$_GET['page'];
					}
				}
				else{
					$page=1;
				}

				if($page==1){
					$limit=$limit."0,10";
				}
				else{
					$start_limit=10*($page-1)+1;
					$limit=$limit.$start_limit.",10";
				}

				$sql="select id,username,realname,age,sex,mobile,email,address,create_time from m_user where status=1".str_replace('where', 'and',$where).$limit;
				$q_res=$conn->query($sql);
				$q_res->setFetchMode(PDO::FETCH_ASSOC);
				$userlist=$q_res->fetchALL();
				if(!empty($userlist)){
					foreach($userlist as $k=>$v){
						echo'<tr>';
						echo'<td>'.$v['id'].'</td>';
						echo'<td>'.$v['username'].'</td>';
						echo'<td>'.$v['realname'].'</td>';
						echo'<td>'.$v['age'].'</td>';
						echo'<td>'.$v['sex'].'</td>';
						echo'<td>'.$v['mobile'].'</td>';
						echo'<td>'.$v['email'].'</td>';
						echo'<td>'.$v['address'].'</td>';
						echo'<td>'.date('Y-m-d H:m:s',intval($v['create_time'])).'</td>';
						echo'
						<td>
							<a href="user_edit.php?uid='.$v['id'].'">修改</a>
							&nbsp;&nbsp;&nbsp;
							<a href="javascript:;" data-id="'.$v['id'].'" class="js_del">删除</a>
						</td>
						';
						echo '</tr>';
					}
				}

			?>
			</table>
			<center style="margin-top: -20px;padding-top: 20px;background: rgba(255,255,255,0.95);width: 1200px; padding-bottom: 20px;border-radius: 0px 0px 10px 10px;">
				<ul class="pager">
					<?php
					$xianshi=0;
					$url="";
					//确定URL
					if($where!=""){
						$url="?username=".$_GET['username']."&realname=".$_GET['realname']."&";
					}
					else{
						$url="?";
					}
					//确定往前一页的表现方式
					if($page==1||$fenye_total==1){
						echo '<li class="disabled" title="没法往前啦o(≧∩≦)o">
									<a href="'.$url.'page=1">&larr; Preivous</a>
								</li>';
					}
					else{
						$pre_page=$page-1;
						echo '<li>
									<a href="'.$url.'page='.$pre_page.'" title="往前一页(￣┰￣*) ">&larr; Preivous</a>
								</li>';
					}
					//确定前三个按钮
					if($fenye_total>=3){
						$xianshi=3;
					}
					else{
						$xianshi=$fenye_total;
					}
					for($i=1;$i<=$xianshi;$i++){
						if($page==$i){
							echo '<li class="disabled">';
						}
						else{
							echo '<li>'	;
						}
						echo '<a href="'.$url.'page='.$i.'"title="'.$i.'">'.$i.'</a>
									</li>';
					}
					//确定前方省略号
					if($page>=7){
						echo '<li>...</li>';
					}
					//确定中间显示按钮
						for($i=$page-2;$i<=$page+2;$i++){
							if($i>3&&$i<$fenye_total-2){
								if($page==$i){
									echo '<li class="disabled">';
								}
								else{
									echo '<li>'	;
								}
							echo '<a href="'.$url.'page='.$i.'"title="'.$i.'">'.$i.'</a>
									</li>';
							}
						}
					//确定后方神略号
					if($page<=$fenye_total-6){
						echo '<li>...</li>';
					}
					//确定后三个按钮
					for($i=$fenye_total-2;$i<=$fenye_total;$i++){
						if($i>3){
							if($page==$i){
								echo '<li class="disabled">';
							}
							else{
								echo '<li>'	;
							}
							echo '<a href="'.$url.'page='.$i.'"title="'.$i.'">'.$i.'</a>
									</li>';
						}
					}
					//确定往后一页的表现方式
					if($page>=$fenye_total){
						echo '<li class="disabled">
											<a href="'.$url.'page='.$fenye_total.'" title="没法往后啦o(≧∩≦)o">Next &rarr;</a>
										</li>';
					}
					else{
						$next_page=$page+1;
						echo '<li>
											<a href="'.$url.'page='.$next_page.'" title="往后一页(￣┰￣*) ">Next &rarr;</a>
										</li>';
					}
				?>
					</ul>
				</center>
				<script>
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
								type:'GET',
								data:{id,id},
								url:'../backend/user.php?method=delete',
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
						$('#regvol_btn').click(function(){
							$.ajax({
								type:'get',
								url:'../backend/test.php?method=insertUserList',
								success:function(data){
									if(data.faild==0){
										$.manhua_msgTips({
											msg:"一共增加"+data.total+"用户，成功插入"+data.success+"用户，存在"+data.chongfu+"用户。",
											type:'success'
										});
										setTimeout('location.reload();',2000);
									}else{
										$.manhua_msgTips({
											msg:"一共增加"+data.total+"用户，失败插入"+data.faild+"用户",
											type:'error'
										});}
								},
								error:function(){
									$.manhua_msgTips({
											msg:"失败",
											type:'error'
										});
								},
							});
						});
					});
				</script>
</body>
</html>