<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */

$this->title = '我的聊天室';
$this->params['breadcrumbs'][] = $this->title;
?>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
	  name="viewport" />
<style type="text/css">
	.barrage .screen{
		width:100%;
		height:100%;
		position:absolute;
		top:0px;
		right:0px;
	}
	.barrage .screen .s_close{
		z-index:2;top:20px;
		right:20px;p
	osition:absolute;
		text-decoration:none;
		width:40px;
		height:40px;
		border-radius:20px;
		text-align:center;
		color:#fff;background:#000;
		line-height:40px;
		display:none;
	}
	.barrage .screen .mask{
		position:relative;
		width:100%;
		height:100%;
		background:#000;
		opacity:0.5;
		filter:alpha(opacity:1);
		z-index:1;
	}
	.barrage{
		display:none;
		width:100%;
		height:100%;
	}
	.barrage .screen .mask div{
		position:absolute;
		font-size:20px;
		font-weight:bold;
		white-space:nowrap;
		line-height:40px;
		z-index:40;
	}
	.barrage .send{
		z-index:1;
		width:100%;
		height:55px;
		background:#000;
		position:absolute;
		bottom:0px;
		text-align:center;
	}
	.barrage .send .s_text{
		width:600px;
		height:40px;
		line-height:10px;
		font-size:20px;
		font-family:"微软雅黑";
	}
	.barrage .send .s_btn{
		width:105px;
		height:40px;
		background:#22B14C;
		color:#fff;
	}
</style>
<script src='//cdn.bootcss.com/socket.io/1.3.7/socket.io.js'></script>
<script src='//cdn.bootcss.com/jquery/1.11.3/jquery.js'></script>

<div class="barrage">
	<div class="screen">
		<a href="#" class="s_close">
			X
		</a>
		<div class="mask">
			<!--内容在这里显示-->
		</div>
	</div>
	<!--Send Begin-->
	<div class="send">
		<input type="text" class="s_text"  name="message"/>
		<input type="button" class="s_btn" value="说两句"/>
	</div>
	<!--Send End-->
            <span class="s_close">
                X
            </span>
</div>
<button class="showBarrage">
	打开弹幕
</button>
<script>
	$(function() {
		$(".showBarrage,.s_close").click(function() {
			$(".barrage,.s_close").toggle("slow");
		});

		document.onkeydown = function(e){
			var keyCode = e.keyCode || e.which || e.charCode;
			if(keyCode == 13){
				sendMessage();
			}
		}

		$('.send .s_btn').click(function(){
			sendMessage();
		})
	})

	//初始化弹幕技术
	function init_barrage() {
		var _top = 0;
		$(".mask div").show().each(function() {
			var _left = $(window).width() - $(this).width(); //浏览器最大宽度，作为定位left的值
			var _height = $(window).height(); //浏览器最大高度
			_top += 75;
			if (_top >= (_height - 130)) {
				_top = 0;
			}
			$(this).css({
				left: _left,
				top: _top,
				//color: getRandomColor()
			});
			//定时弹出文字
			var time = 10000;
			if ($(this).index() % 2 == 0) {
				time = 15000;
			}
			$(this).animate({
					left: "-" + _left + "px"
				},
				time,
				function() {
					$(this).remove();
				});
		});
	}
	//获取随机颜色
	function getRandomColor() {
		return '#' + (function(h) {
				return new Array(7 - h.length).join("0") + h
			})((Math.random() * 0x1000000 << 0).toString(16))
	}

	var wsServer = '<?= $socket;?>';
	var websocket = new WebSocket(wsServer);
	websocket.onopen = function (evt) {
		var myDate = new Date();
		var timestamp = myDate.getTime();//时间戳
		var timestamp = timestamp.toString().substring(0,10);

		console.log("Connected to WebSocket server.");
		websocket.send('{"source":"brower","action":"connect","data":{"msg": "'+ timestamp +'"}}');
	};

	websocket.onclose = function (evt) {
		console.log("Disconnected");
	};

	websocket.onmessage = function (evt) {
		var data = JSON.parse(evt.data);
		var _lable = $("<div style='right:20px;top:0px;opacity:1;color:" + getRandomColor() + ";'>" + data.action + "</div>");
		//var _lable = $("<div class='chat-message' style='color:white'>" + data.action + "</div>");

		$(".mask").append(_lable.show());
		init_barrage();
		console.log('Retrieved data from server: ' + evt.data);

	};

	websocket.onerror = function (evt, e) {
		console.log('Error occured: ' + evt.data);
	};

	function sendMessage() {
		var message = $("input[name=message]").val();
		if(message){
			$("input[name=message]").val('')
			websocket.send('{"source":"brower","action":"ask","data":{"msg":"'+message+'"}}');
		}

	}
</script>
