
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset:utf-8;">
<title>登录页面</title>
<?php include("head.php")?>
<script>
$(function(){
	$("#reg_btn").click(function(){
		var data = $("form").serialize();
		$.ajax({
			url:"../backend/user.php?method=login",
			type:'post',
			data:data,
			success:function(data){
				//登录成功
				if(data.status == 1){
					$.manhua_msgTips({
						msg:data.msg,
						type:'success'
					});
					setTimeout('location.href="./index.php"',2000);
				}
				else{
					$.manhua_msgTips({
						msg:data.msg,
						type:'error'
					})
				}
			},
			error:function(){
				//提示错误
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
<div class="container" style="width:300px;">
<div class="panel panel-primary" style="margin-top:50px;">
  <div class="panel-heading">用户登录</div>
  <div class="panel-body">
    <form class="form-horizontal" action="../backend/user.php?method=login" method="post">
  <div class="form-group">
    <label>用户名</label>
    <input type="text" name="username" class="form-control" placeholder="用户名">
  </div>
  <div class="form-group">
    <label>密码</label>
    <input type="password" name="password" class="form-control" placeholder="密码">
  </div>
  <button type="button" id="reg_btn" class="btn btn-primary">登录</button>
  <a class ="byn btn-default" href="register.php">注册</a>
</form>
  </div>
</div>
</div>
</body>

</html>
