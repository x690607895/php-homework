<?php include('login_auth.php');
$current_menu='vote_manger';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>主页</title>
	<?php include('head.php');?>
	<script src="../js/Chart.js"></script>
	<script src="../js/Chart.bundle.js"></script>
	<style>
		.xianshispan{
			margin-left: 30px;
			margin-top: 15px;
			display: block;
		}
		.addbtn{
			width: 24px;
			height: 26px;
			border-radius: 50%;
		}
		.addbtn span.glyphicon{
			margin-top: -3px;
   	 		margin-left: -7px;
    		display: flex;
		}
		@keyframes myfirst
		{
			0%{opacity: 0;}
			100%{opacity: 1;}
		}
		body{
			background: url(../images/vote_manager.jpg);
			background-attachment: fixed;
		}
		div.container{
			background: rgba(255,255,255,0.9);
			border-radius: 20px;
			margin: 30px auto;
			animation:myfirst 0.5s;
		}
	</style>
	<script>
	$(document).ready(
	function(){
		$('.nav li:nth-child(6)').addClass("active");
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
 	var a="";var i=2;
 	function deloption(buttonid){
 		$("#"+buttonid).parent().remove();
 		i--;
 	}
  	function addoption(buttonid){
  		if (buttonid==a) {
  			i++;
  		}
  		a=buttonid;
        $("#addbtn"+buttonid).parent().parent().parent().children("span:last-child").after("<span id=\"option"+i+"\" class=\"xianshispan\">新增选择项"+i+"&nbsp;--&nbsp;<input type=\"text\" value='' size=\"15\"/>&nbsp;<a id=\"insbtn"+i+"\" onclick=\"insoption("+i+")\" class=\" addbtn btn btn-success\"><span class=\"glyphicon glyphicon-ok\"></span></a>&nbsp;<a id=\"delbtn"+i+"\" onclick=\"deloption(id)\" class=\" addbtn btn btn-danger\"><span class=\"glyphicon glyphicon-remove\"></span></a></span>");
    }
    var votetitle="";
    function insoption(id){console.log(votetitle);
     	var title=votetitle;console.log(title);
     	var option=$("#option"+id).children().val();
     	var data = "title="+title+"&option="+option;
		$.ajax({
			url:"../backend/vote.php?method=addoptionitem",
			type:'get',
			data:data,
			success:function(data){
				if(data.status == 1){
					$.manhua_msgTips({
						msg:data.msg,
						type:'success'
					});
					$("#option"+id).replaceWith("<span id=\"option"+id+"\" class=\"xianshispan\">选择项"+id+"&nbsp;--&nbsp;"+option+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;有0人</span>");
					$("#delbtn"+id).remove();
					$("#insbtn"+id).remove();
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
     }
     
     function addvote(){
     	var id=$('div.panel-group').length+1;
     	var text='	<div class="panel-group" id="accordion">\
  						<div class="panel panel-default">\
    						<div class="panel-heading">\
      							<h4 class="panel-title">\
      								<form id="form'+id+'">\
          								投票标题:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\
          								<input id="vote-title'+id+'" name="title" type="text" size="20" value="" />\
       									<button type="button" onclick="insvote('+id+')" class="btn btn-primary">发起</button>\
       								</form>\
						     	</h4>\
						    </div>\
						</div>\
					</div>';
     	$('div.panel-group:last-child').after(text);
     }

     function insvote(id){
     	var data = $("#form"+id).serialize();
     	$.ajax({
			url:"../backend/vote.php?method=insvote",
			type:'post',
			data:data,
			success:function(data){
				if(data.status == 1){
					$.manhua_msgTips({
						msg:data.msg,
						type:'success'
					});
					var id=$('div.panel-group').length;
					var title=$('#vote-title'+id).val();
					votetitle=title;console.log(votetitle);
     				var text='	<div class="panel-group" id="accordion">\
  						<div class="panel panel-default">\
    						<div class="panel-heading">\
      							<h4 class="panel-title">\
      								<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne'+id+'">\
          								投票标题:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+title+'\
        							</a>\
						     	</h4>\
						    </div>\
						     <div id="collapseOne'+id+'" class="panel-collapse collapse in">\
							      <div class="panel-body">\
							      	<div style="width:600px;float:left"> </div>\
							       	<div style="float:left;">\
								       	<h2 style="margin-bottom:20px;">\
								       		<b>投票标题:'+title+'\
								       			<button type="button" id="addbtn'+id+'" onclick="addoption('+id+');" class="btn btn-default" style="height: 37px;margin-top: -6px;" >添加选项&nbsp;<span class="glyphicon glyphicon-plus"></span></button>\
								       		</b>\
								       	</h2>\
								       	<span id="option1" class="xianshispan">新增选择项1&nbsp;--&nbsp;\
								   			<input type="text" value="" size="15"/>&nbsp;\
								   			<a id="insbtn1" onclick="insoption(1)" class=" addbtn btn btn-success">\
							  					<span class="glyphicon glyphicon-ok"></span>\
						       				</a>\
						     			</span>\
							       	</div>\
							      </div>\
							    </div>\
						</div>\
					</div>';
     				$('div.panel-group:last-child').replaceWith(text);
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
     }
</script>
</head>
<body>
	<?php include('nav.php');?>
	<div class="container">
		<h3 style="text-align: center;margin-bottom: 20px;">投票查询列表 <button type="button" class="btn btn-default" style="float:right;" onclick="addvote();">发起新的投票</button></h3>
		<div class="panel-group"></div>
		<?php
			require('../backend/conn.php');
			$sql="select count(*) as 投票总数 from m_vote_list";
			$q_res=$conn->query($sql);
			$q_res->setFetchMode(PDO::FETCH_ASSOC);
			$votecount=$q_res->fetchALL();
			$count_all=1;
			$count_title=1;
			for($i=1;$i<=$votecount[0]['投票总数'];$i++)
			{	
				$where = ' where m_vote_list.id ='.$i;
				$sql = "select m_vote_list.id as 投票ID ,m_vote_list.creator_id as 投票创建者ID , m_user.username as 投票创建者 , m_vote_list.create_time as 投票创建日期 , m_vote_list.update_time as 投票修改日期 ,m_vote_list.title as 投票标题 , m_vote_option.name as 投票选项 ,count(m_vote_result.num) as 投票票数 from m_vote_option right join m_vote_list on m_vote_option.pid=m_vote_list.id  left join m_vote_result on m_vote_result.item_id=m_vote_option.id join m_user on m_user.id=m_vote_list.creator_id".$where." GROUP by m_vote_option.id";
				$q_res=$conn->query($sql);
				$q_res->setFetchMode(PDO::FETCH_ASSOC);
				$votelist=$q_res->fetchALL();
				if(!empty($votelist)){
					?>
					<script>
					<?php
					echo 'var data'.$i.'=[];';
					echo 'var label'.$i.'=[];';
					echo 'var color'.$i.'=[];';
						 for($j=0;$j<count($votelist);$j++){
							echo 'data'.$i.'.push("'.$votelist[$j]['投票票数'].'");';
							echo 'label'.$i.'.push("'.$votelist[$j]['投票选项'].'");';
							echo 'color'.$i.'.push("rgb('.rand(0,255).','.rand(0,255).','.rand(0,255).')");';
						}?>
					</script>
					
					<div class="panel-group" id="accordion">
  							<div class="panel panel-default">
    							<div class="panel-heading">
      								<h4 class="panel-title">
        								<?php echo '<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne'.$i.'">
          								投票标题:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$votelist[0]['投票标题'];?>
        								</a>
							      	</h4>
							    </div>
							    <div id="collapseOne<?php echo $i;?>" class="panel-collapse collapse">
							      <div class="panel-body">
							      	<div style="width:600px;float:left">
							       		<canvas id="pie<?php echo $i;?>"/>
							       	</div>
							       	<div style="float:left;">
							       	<h2 style="margin-bottom:20px;">
							       		<b>投票标题:<?php echo $votelist[0]['投票标题']?>
							       		</b>
							       	</h2><br />
											<?php for($j=0;$j<count($votelist);$j++){
												echo ' <span class="xianshispan">选择项'.($j+1)	.'&nbsp;--&nbsp;'.$votelist[$j]['投票选项'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;有'.$votelist[$j]['投票票数'].'人</span>';
												$count_all++;
											 } ?>
										<span class="xianshispan">创建者&nbsp;--&nbsp;<?php echo $votelist[0]['投票创建者']?></span>
										<span class="xianshispan">创建日期&nbsp;--&nbsp;<?php echo date("Y-n-t",$votelist[0]['投票创建日期'])?></span>
										<span class="xianshispan">修改日期&nbsp;--&nbsp;<?php echo date("Y-n-t",$votelist[0]['投票修改日期'])?></span>
							       	</div>
							      </div>
							    </div>
							  </div>
					<script>
					<?php		  
						echo "$('#collapseOne".$i."').on('shown.bs.collapse', function () {
							  drawpie(data".$i.",color".$i.",label".$i.",'pie".$i."','".$votelist[0]['投票标题']."');
							});";
						?>
					</script>
				</div>
					
				<?php }
			}


		?>
	</div>
	
</body>
</html>