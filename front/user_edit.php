<?php include('login_auth.php');
$current_menu='username_manger';
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset:utf-8;">
<title>用户修改</title>
<?php include('head.php');?>
<style>
	body{
		background: url(../images/user_edit.jpg);
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
		$('.nav li:nth-child(2)').addClass("active");
	});
</script>
</head>
<body>
<?php include('nav.php');
require('../backend/conn.php');
$sql="select username,realname,sex,age,mobile,email,address from m_user where id='".$_GET['uid']."'";
	$check=$conn->query($sql);
	$check->setFetchMode(PDO::FETCH_ASSOC);
	$userlist=$check->fetch();
?>
<div class="container" style="width:800px;margin-left: 250px;margin-top: 150px;padding: 0px;">
<div class="panel panel-default" style="opacity: 0.9;border-radius: 20px;padding-bottom: 20px;">
<div class="page-header"><h3 style="text-align:center;">用户信息修改</h3></div>
			<form class="form-horizontal" action="../backend/user.php?method=save" method="post">
				<div class="form-group">
					<label class="col-md-2 control-label col-md-offset-2" style="float:left;">用&nbsp;户&nbsp;名&nbsp;:</label>
					<input name="username" type="text" class="form-control" style="width:50%;" placeholder="用户名" value="<?php echo $userlist['username']?>" />
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label col-md-offset-2" style="float:left;">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名:</label>
					<input name="relname" type="text" class="form-control" style="width:50%;" placeholder="姓名" value="<?php echo $userlist['realname']?>" />
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label col-md-offset-2">性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别:</label>
					<label class="radio-group col-md-2">
						<?php
							if($userlist['sex']=='男')
								echo '<input type="radio" name="sex" value="男" checked="checked">男 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="sex" value="女" >女';
							else
								echo '<input type="radio" name="sex" value="男" >男 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="sex" value="女" checked="checked" >女';
						?>
					</label>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label col-md-offset-2" style="float:left;">年&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;龄:</label>
					<input name="age" type="text" class="form-control" style="width:50%;" placeholder="年龄" value="<?php echo $userlist['age']?>" />
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label col-md-offset-2" style="float:left;">手机号码:</label>
					<input name="mobile" type="text" class="form-control" style="width:50%;" placeholder="手机号码" value="<?php echo $userlist['mobile']?>"/>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label col-md-offset-2" style="float:left;">邮箱地址:</label>
					<input name="email" type="text" class="form-control" style="width:50%;" placeholder="邮箱地址" value="<?php echo $userlist['email']?>"/>
					</div>
			<div class="form-group">
					<label class="col-md-2 control-label col-md-offset-2" style="float:left;">通讯地址:</label>
					<input name="address" type="text" class="form-control" style="width:50%;" placeholder="通讯地址" value="<?php echo $userlist['address']?>"/>
				</div>
				<div class="form-group ">
					<button type="submit" type="button" class="btn btn-primary col-md-2 col-md-offset-2">保&nbsp;&nbsp;&nbsp;&nbsp;存</button>
					<button type="reset" class="btn btn-default col-md-2 col-md-offset-1">重&nbsp;&nbsp;&nbsp;&nbsp;置</button>
					<button type="button" onclick="history.back(-1)" class="btn btn-default col-md-2 col-md-offset-1">返回上一层页面</button>
				</div>
			</form>
		</div>
</div>
</body>
</html>