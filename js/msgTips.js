$(function() {
	$.extend({
		manhua_msgTips:function(options){
			var defaults = {
				timeOut : 2000,				//提示层显示的时间
				msg : "消息提示",			//显示的消息
				speed : 300,				//滑动速度
				type : "success"			//提示类型（1、success 2、error 3、warning）
			};
			var options = $.extend(defaults,options);
			if ($("#tip_container").length == 0 ) { 
				$("body").prepend('<div id="tip_container" class="tip_container"><div id="tip" class="mtip"><i class="micon"></i><span id="tsc"></span><i id="mclose" class="mclose"></i></div></div>');
			} 
			var $tip_container = $("#tip_container")
			var $tip = $("#tip");
			var $tipSpan = $("#tsc");
			var $colse = $("#mclose");	
			//先清楚定时器
			clearTimeout(window.timer);
			
			$tip.attr("class", options.type).addClass("mtip");	
			$tipSpan.html(options.msg);			
			$tip_container.slideDown(options.speed);
			//提示层隐藏定时器
			window.timer = setTimeout(function (){
				$tip_container.slideUp(options.speed);
			}, options.timeOut);
			
			//鼠标移到提示层时清除定时器
			$tip_container.on("mouseover",function() {
				clearTimeout(window.timer);
			});
			
			//鼠标移出提示层时启动定时器
			$tip_container.on("mouseout",function() {
				window.timer = setTimeout(function (){
					$tip_container.slideUp(options.speed);
				}, options.timeOut);
			});
		
			//关闭按钮绑定事件
			$colse.on("click",function() {
				$tip_container.slideUp(options.speed);
			});
		}
	});
});
