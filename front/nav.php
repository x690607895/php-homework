<nav class ="navbar navbar-default" style="z-index:100;margin: 0px;">
	<div class="contatiner">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">LOGO</a>
		</div>
		<div class = "collapse navbar-collapse">
			<ul class ="nav navbar-nav">

				<li><a href="index.php">首页</a></li>
				<li><a href="username_manger.php">用户</a></li>
				<li><a href="article_manager.php">文章</a></li>
				<li><a href="vote.php">投票</a></li>
				<li><a href="file_manger.php">文件</a></li>
				<li><a href="vote_manger.php">投票管理</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href ="#" class ="dropdown-toggle" data-toggle="dropdown" role="button" >
				<?php echo $_SESSION['username'];?>
				<span class="caret"></span></a>
				<ul class ="dropdown-menu">
					<li><a href="#">我的主页</a></li>
					<li class ="divider"></li>
					<li><a href="../backend/user.php?method=logout">退出登录</a></li>
				</ul>
			</li>
		</ul>
		</div>
	</div>
</nav>

