<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<?php include('head.php');?>
	<title>投票</title>
	<style>
		body{
			background: url(../images/share.jpg);
			background-attachment: fixed;
		}
	</style>
</head>
<body>
	<div class="container">
		<?php
			if($_GET['method']=='vote')
				{
				$id=$_GET['id'];
				require('../backend/conn.php');
				$sql="select title from m_vote_list where id='".$id."'";
				$q_res=$conn->query($sql);
				$q_res->setFetchMode(PDO::FETCH_ASSOC);
				$votecount=$q_res->fetchALL();
				if(!empty($votecount)){
					$title=$votecount[0]['title'];
					$sql="select id,name from m_vote_option where pid='".$id."'";
					$q_res=$conn->query($sql);
					$q_res->setFetchMode(PDO::FETCH_ASSOC);
					$optioncount=$q_res->fetchALL();
				}
			

		?>
			<div class="panel panel-default" >
				<div class ="panel-heading"><?php echo $title; ?></div>
				<div class="panel-body">
				<form  id="vote">
					<?php
					for($j=0;$j<count($optioncount);$j++){
						echo '<input type="radio" name="'.$title.'" value="'.$optioncount[$j]['id'].'" /> '.$optioncount[$j]['name'].' <br /> ';
					}
					?>
					<center>
					<button type="button" class="btn btn-primary" onclick="submitvote('#vote')">提交</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<button type="reset" class="btn btn-default">重置</button></center>
					</form>
				</div>
			</div>
			<?php 
		}
		?>
		<script>
			function submitvote(id){
				var data=$(id).serialize();
				$.ajax({
					url:"../backend/vote.php?method=vote",
					type:'post',
					data:data,
					success:function(data){
						if(data.status == 1){
							$.manhua_msgTips({
								msg:data.msg,
								type:'success'
							});
							setTimeout('open(location, \'_self\').close();',2000);
						}
						else{
							$.manhua_msgTips({
								msg:data.msg,
								type:'error',
							});
							setTimeout('open(location, \'_self\').close();',2000);
						}
					},
					error:function(){
						$.manhua_msgTips({
								msg:"提交信息失败",
								type:'error'
							})
					}
				});
			}
		</script>
	</div>
</body>
</html>