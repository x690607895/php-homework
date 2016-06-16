<?php include('login_auth.php');
$current_menu='vote_manger';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>主页</title>
	<?php include('head.php');?>
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
	</style>
	<script>
		 function changeState(text,textid,readtype){
  			document.getElementById(text+textid).readOnly=readtype;
  			  $("#update1").removeAttr("style"); 
 		}
 		var a="";var i=0;var j=0;
 		function deloption(buttonid){
 			$("#"+buttonid).parent().remove();
 		}
  		function addoption(buttonid,count){
  			if (buttonid==a) {
  				i++;j++;
  			}
  			else {
  				i=count+2;j=count;
  			}
  			a=buttonid;console.log(buttonid);
        	var id="#"+$("#addbtn"+buttonid).parent().parent().parent().attr('id');
        	  $(id).children('span').eq(j).after("<span id=\"option"+i+"\" class=\"xianshispan\">新增选择项"+i+"&nbsp;--&nbsp;<input type=\"text\" value=' ' size=\"15\"/>&nbsp;<a class=\" addbtn btn btn-success\"><span class=\"glyphicon glyphicon-ok\"></span></a>&nbsp;<a id=\"delbtn"+i+"\" onclick=\"deloption(id)\" class=\" addbtn btn btn-danger\"><span class=\"glyphicon glyphicon-remove\"></span></a></span>");
        	  $("#update1").removeAttr("style"); 
        	  
        }
	</script>
</head>
<body>
	<?php include('nav.php');?>
	<div class "container" style="width: 1200px;margin: 0 auto;">
		<h3 style="text-align: center;">投票查询列表</h3>
					<div class="panel-group" id="accordion">
  							<div class="panel panel-default">
    							<div class="panel-heading">
      								<h4 class="panel-title">
        								<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          								投票标题:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$votelist[0]['投票标题'].'
        								</a>
							      	</h4>
							    </div>
							    <div id="collapseOne" class="panel-collapse collapse in">
							      <div class="panel-body">
							      	<div style="width:600px;float:left">
							       		<canvas style="width: 600px;height: 300px;" />
							       	</div>
							       	<div style="float:left;" id="abd">
							       		<h2 style="margin-bottom:20px;"><b>投票标题:<input type="text" id="title1" onclick="changeState('title',1,false)" onblur="changeState('title',1,true)" readonly='readonly' value='1' size="10"/>&nbsp;<button type="button" id='addbtn1' onclick="addoption(1,1);" class="btn btn-default" style="height: 37px;margin-top: -6px;" >添加选项&nbsp;<span class="glyphicon glyphicon-plus"></span></button></b></h2><br />
										<span class="xianshispan">选择第1项--<input type="text" id="text1" value='text1' size="15" onclick="changeState('text',1,false)" onblur="changeState('text',1,true)" readonly="readonly" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;有XXX人</span>
										<span class="xianshispan">选择第1项--<input type="text" id="text1" value='text1' size="15" onclick="changeState('text',1,false)" onblur="changeState('text',1,true)" readonly="readonly" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;有XXX人</span>
										<span class="xianshispan">创建者--text1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;有XXX人</span>
										<span class="xianshispan">创建日期--text1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;有XXX人</span>
										<span class="xianshispan">修改日期--text1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;有XXX人</span>
										<span class="xianshispan"><a id="update1" style="display: none;" class="btn btn-primary" href="#">修改</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="#">删除</a></span>
							       	</div>
							      </div>
							    </div>
							  </div>
	</div>
</body>
</html>