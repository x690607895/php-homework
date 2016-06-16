<?php include('login_auth.php');
$current_menu='vote';
if (getenv('HTTP_CLIENT_IP')) { 
$ip = getenv('HTTP_CLIENT_IP'); 
} 
elseif (getenv('HTTP_X_FORWARDED_FOR')) { 
$ip = getenv('HTTP_X_FORWARDED_FOR'); 
} 
elseif (getenv('HTTP_X_FORWARDED')) { 
$ip = getenv('HTTP_X_FORWARDED'); 
} 
elseif (getenv('HTTP_FORWARDED_FOR')) { 
$ip = getenv('HTTP_FORWARDED_FOR'); 

} 
elseif (getenv('HTTP_FORWARDED')) { 
$ip = getenv('HTTP_FORWARDED'); 
} 
else { 
$ip = $_SERVER['REMOTE_ADDR']; 
} 
$_SESSION['ip']=$ip;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>投票</title>
	<?php include('head.php');?>
	<script src="../js/Chart.js"></script>
	<script src="../js/Chart.bundle.js"></script>
	<style>
		a{
			cursor: pointer;
		}
		.table td,.table th{
			text-align: center;
		}
		@keyframes myfirst
		{
			0%{opacity: 0;
			}
			100%{opacity: 1;
			}
		}
		body{
			background: url(../images/vote.jpg);
			background-attachment: fixed;
		}
		.container{
			background: rgba(255,255,255,0.9);
			margin-top: 30px;
			border-radius: 20px;
			animation:myfirst 0.5s;
		}
	</style>
	<script>
	$(document).ready(
	function(){
		$('.nav li:nth-child(4)').addClass("active");
	});
	 function getdata(data,background,label){
       	DataArray=data;
       	ColorArray=background;
       	LabelArray=label;
       }

	function drawpie(data,background,label,canvasid,title){
	getdata(data,background,label);
	var config = {
        type: 'pie',
        data: {
            datasets: [{
                data: DataArray,
                backgroundColor: ColorArray,
                label: 'Dataset 1',
            }],
            labels: LabelArray,
        },
        options: {
            legend: {
               position: 'bottom',
            },
            title: {
                display: true,
                position:'bottom',
                 scaleFontSize : '200px',
                text: title
            },
            animation: {
            	animateRotate: true,
                animateScale: true,

            }
        }
    };
    var ctx = document.getElementById(canvasid).getContext("2d");
    window.myDoughnut = new Chart(ctx, config);
	}

	function showpie(id){
		$.ajax({
			type:'post',
			data:{id,id},
			url:'../backend/vote.php?method=data',
			success:function(data){
				if(data.status==1){
					$('#watchvote .modal-header').html(data.title+'<span class="close" data-dismiss="modal">×</span>');
					$('#watchvote').on('shown.bs.modal', function () {
			 					drawpie(data.data,data.color,data.label,'pie',data.title);
			 				});
					$('#watchvote').on('hidden.bs.modal', function () {
			 					drawpie('','','','pie','');
			 				});
					
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
</script>
</head>
<body>
	<?php include('nav.php');?>
	<div class="container">
		<table class ="table" style="margin-left:auto;margin-right:auto;">
				<caption>
					<h3 style="font_weight:800;text-align:center">投票列表</h3>
				</caption>
				<thead>
					<tr>
						<th>投票名称</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
						<?php
							
							require('../backend/conn.php');
							$ip=$_SERVER['REMOTE_ADDR'];
							$sql="select * from m_vote_list";
							$q_res=$conn->query($sql);
							$q_res->setFetchMode(PDO::FETCH_ASSOC);
							$votecount=$q_res->fetchALL();
							for($i=0;$i<count($votecount);$i++)
							{
								$id=$votecount[$i]['id'];
								echo '<tr>';
								echo '<td>'.$votecount[$i]['title'].'</td>';
								$where="where pid='".$id."'";
								$sql="select id from m_vote_option ".$where;
								$q_res=$conn->query($sql);
								$q_res->setFetchMode(PDO::FETCH_ASSOC);
								$optioncount=$q_res->fetchALL();
								echo '<td>';
								$check=0;
								for($j=0;$j<count($optioncount);$j++)
								{
									
									$sql="select * from m_vote_result where item_id='".$optioncount[$j]['id']."' and ip='".$ip."'";
									$q_res=$conn->query($sql);
									$q_res->setFetchMode(PDO::FETCH_ASSOC);
									$checkvote=$q_res->fetchALL();
									if(!empty($checkvote)){
										$check=1;
									}
								}
								if($check==0)
								{
									echo '<a data-toggle="modal" data-target="#subvote'.$id.'">投票</a>';	
								}
								else
								{
									echo '<a data-toggle="modal" data-target="#watchvote" onclick="showpie('.$id.')">查看</a>';
								}
								echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="share.php?method=vote&id='.$id.'">分享</a>';
								echo '</td>';
								echo '</tr>';
							}
							
						?>
					
				</tbody>
		</table>
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
							setTimeout('location.reload()',2000);
						}
						else{
							$.manhua_msgTips({
								msg:data.msg,
								type:'error',
							});
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
		<?php 
			for($i=0;$i<count($votecount);$i++)
			{
				$id=$votecount[$i]['id'];
				$title=$votecount[$i]['title'];
				$optioncount="";
		?>
		<div class="modal fade" id="subvote<?php echo $id;?>" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog" style="margin-top: 10%">
				<div class="modal-content">
				<form id="vote<?php echo $id;?>">
					<div class="modal-header"><?php echo $title;?><span class="close" data-dismiss="modal">×</span></div>
					<div class="modal-body">
						<?php 
							$sql="select id,name from m_vote_option where pid='".$id."'";
							$q_res=$conn->query($sql);
							$q_res->setFetchMode(PDO::FETCH_ASSOC);
							$optioncount=$q_res->fetchALL();
							for($j=0;$j<count($optioncount);$j++){
								echo '<input type="radio" name="'.$title.'" value="'.$optioncount[$j]['id'].'" /> '.$optioncount[$j]['name'].' <br /> ';
							}

						?>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" onclick="submitvote('#vote<?php echo $id;?>')">提交</button>
						<button type="reset" class="btn btn-default">重置</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
					</div>
				</form>
				</div>
			</div>
		</div><?php }?>
		<div class="modal fade" id="watchvote" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog" style="margin-top: 10%">
				<div class="modal-content">
					<div class="modal-header"></div>
					<div class="modal-body">
						<canvas id="pie"/>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</body>
</html>