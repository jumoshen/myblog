<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */

$this->title = 'share';
?>
 	<p>
        <button id="takePhoto">takePhoto</button>
    </p>
	<div>
		<img src="" class="photo" width="100%" style="width:200px">
	</div>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<?php  
	$js = <<<JS
		wx.config({
	        debug: false,
	        appId: "{$signPackage['appId']}",
	        timestamp: "{$signPackage['timestamp']}",
	        nonceStr: "{$signPackage['nonceStr']}",
	        signature: "{$signPackage['signature']}",
	        jsApiList: [
	        	'onMenuShareAppMessage',
	            'onMenuShareTimeline',
	            'chooseImage',// 所有要调用的 API 都要加到这个列表中
	        ]
	    });
		wx.ready(function () {
	        wx.onMenuShareAppMessage({
	          	title: 'so young so simple',
	          	desc: 'so young so simple',
	          	link: 'http://back.jumoshen.cn/',
	          	imgUrl: 'http://back.jumoshen.cn/uploads/user/head_avatar/2016_07_31/20160731_2145473781.jpg',
	          	success: function (res) {
                	    alert('share success');
	                },
	                cancel: function (res) {
	                   alert('share cancel');
	                },
	                fail: function (res) {
	                    alert('share fail');
	                }
	        });

	        wx.onMenuShareTimeline({
	          	title: 'so young so simple',
	         	link: 'http://back.jumoshen.cn/',
	          	imgUrl: 'http://back.jumoshen.cn/uploads/user/head_avatar/2016_07_31/20160731_2145473781.jpg',
	          	success: function (res) {
                	    alert('share success');
	                },
	                cancel: function (res) {
	                   alert('share cancel');
	                },
	                fail: function (res) {
	                    alert('share fail');
	                }
	        });
			
		});
		
		$('#takePhoto').on('click', function(){
			wx.chooseImage({
			    count: 1, // 默认9
			    sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
			    sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
			    success: function (res) {
			        var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
			        $('.photo').attr('src', localIds);
			    }
			})
		})
JS;
	$this->registerJs($js);
?>
