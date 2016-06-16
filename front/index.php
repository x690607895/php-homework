<?php include('login_auth.php');

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>主页</title>
<?php include('head.php');?>
<style>
body{
	background:url(../images/index.jpg);
	z-index: -1;
}
</style>
<script>
	$(document).ready(
	function(){
		$('.nav li:first').addClass("active");
	});
</script>
</head>
<body>
<?php include('nav.php');?>
	<div class ="container">&nbsp;
	</div>
</body>
</html>
