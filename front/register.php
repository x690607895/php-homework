
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset:utf-8;">
<title>注册页面</title>
<?php include("head.php")?>
<script>
$(function(){
	$("#reg_btn").click(function(){
		var data = $("form").serialize();
		$.ajax({
			url:"../backend/user.php?method=register",
			type:'post',
			data:data,
			success:function(data){
				if(data.status == 1){
					$.manhua_msgTips({
						msg:data.msg,
						type:'success'
					});
					setTimeout('location.href="./login.php"',2000);
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
<div class="container" style="width:800px;">
	<div class="panel panel-primary" style="margin-top:50px;">
		<div class="panel-heading">注册页面</div>
		<div class="panel-body">
			<form class="form-horizontal" action="../backend/user.php?method=register" method="post">
				<div class="form-group">
					<label class="col-md-2 control-label col-md-offset-2">用&nbsp;户&nbsp;名&nbsp;:</label>
					<input name="username" type="text" class="form-control" style="width:50%;" placeholder="用户名" value="abc" />
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label col-md-offset-2">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码:</label>
					<input name="password" type="password" class="form-control" style="width:50%;" placeholder="密码" value="abc"/>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label col-md-offset-2">确认密码:</label>
					<input name="repassword" type="password" class="form-control" style="width:50%;" placeholder="确认密码" value="abc"/>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label col-md-offset-2">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名:</label>
					<input name="relname" type="text" class="form-control" style="width:50%;" placeholder="姓名" value="abc" />
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label col-md-offset-2">性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别:</label>
					<label class="radio-group col-md-1">
						<input type="radio" name="sex" value="男" checked="checked">男
					</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp
					<label class="radio-group">
						<input type="radio" name="sex" value="女">女
					</label>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label col-md-offset-2">年&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;龄:</label>
					<input name="age" type="text" class="form-control" style="width:50%;" placeholder="年龄" value="15"/>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label col-md-offset-2">手机号码:</label>
					<input name="mobile" type="text" class="form-control" style="width:50%;" placeholder="手机号码" value="10000000000"/>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label col-md-offset-2">邮箱地址:</label>
					<input name="email" type="text" class="form-control" style="width:50%;" placeholder="邮箱地址" value="abc@abc.com"/>
					</div>
			<div class="form-group">
					<label class="col-md-2 control-label col-md-offset-2">通讯地址:</label>
					<input name="address" type="text" class="form-control" style="width:50%;" placeholder="通讯地址" value="abc"/>
				</div>
				<div class="form-group ">
					<button id="reg_btn" type="button" class="btn btn-primary col-md-2 col-md-offset-3">提&nbsp;&nbsp;&nbsp;&nbsp;交</button>
					<button type="reset" class="btn btn-default col-md-2 col-md-offset-1">重&nbsp;&nbsp;&nbsp;&nbsp;置</button>
					<a href="login.php" class="btn btn-default col-md-2 col-md-offset-1">登录</a>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</htm