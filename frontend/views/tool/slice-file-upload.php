<?php
    use yii\helpers\Url;
    $this->registerJsFile('/my-layer/layer.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="progress">
    <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0" id="progress">
    </div>
    <span id="progress-num">0%</span>
</div>

<input type="file" class="form-control" id="file">

<button type="button" id="bg_to" class="btn btn-default">上传</button>
<button type="button" id="sendStop" class="btn btn-default">停止</button>
<button type="button" id="sendStart" class="btn btn-default">继续</button>

<?php
$uploadUrl = Url::to(['tool/upload']);
$mergeUrl = Url::to(['tool/merge-files']);
$js = <<<JS
    const BYTES_PER_CHUNK = 1024 * 102.4; // 每个文件切片大小定为1/2MB .
    var slices;
    var totalSlices;
    var start = 0;
    var end = BYTES_PER_CHUNK;
    var index = 0;
    var stop = 0;
    var uploadUrl = '$uploadUrl';
    var mergeUrl = '$mergeUrl';
    var allowSuffix = ["jpg", "png", "gif"];

    function init(){
        slices = 0;
        totalSlices = 0;
        start = 0;
        end = 0;
        index = 0;
        stop = 0;
        document.getElementById("progress").style.width = "0";
        document.getElementById("progress").setAttribute('aria-valuenow', 0);
        document.getElementById("progress-num").innerHTML = "0%";
    }

    function inArray(array, value){  
    　　var testStr = ',' + array.join(",") + ",";  
    　　return testStr.indexOf("," + value + ",") != -1;  
    }

    $("#bg_to").click(function(){
        var file=$("#file");
        if($.trim(file.val())==""){
            layer.msg("请选择文件");
            return false;
        }else{
	     var index = $.trim(file.val()).lastIndexOf(".");
            var suffix = $.trim(file.val()).substr(index+1);
            
            if(!inArray(allowSuffix, suffix)){
                layer.msg('请选择格式正确的文件');
                return false;   
            }
	     sendRequest()
	}
    });

    $('#sendStop').click(function(){
        if(start==0){
            layer.msg("未检测到文件上传");
            return false
        }
        stop = 1
    });

    $('#sendStart').click(function(){
        if(start==0){
            layer.msg("未检测到文件上传");
            return false
        }
        stop = 0;
        sendRequest();
    })

    //发送请求
    sendRequest =  function () {
        var blob = document.getElementById('file').files[0];
        // 计算文件切片总数
        slices = Math.ceil(blob.size / BYTES_PER_CHUNK);
        totalSlices= slices;
        if(stop == 1){
            layer.msg("停止上传");
            return false
        }
        if(start < blob.size) {
            if(end > blob.size) {
                end = blob.size;
            }
            uploadFile(blob, index, start, end);
            start = end;
            end = start + BYTES_PER_CHUNK;
            index++;
        }
    }
    //上传文件
    uploadFile =   function (blob, index, start, end) {
        var xhr;
        var fd;
        var chunk;
        xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4) {
                if(xhr.responseText) {
                    layer.msg(xhr.responseText);
                }
                if(slices>1){
                    slices--;
                }
                var percent=100*index/slices;
                if(percent>100){
                    percent=100;
                }else if(percent==0&&slices==1){
                    percent=100;
                }
                document.getElementById("progress").style.width = percent+"%";
                document.getElementById("progress").setAttribute('aria-valuenow', percent);
                document.getElementById("progress-num").innerHTML = parseInt(percent)+"%";
                // 如果所有文件切片都成功发送，发送文件合并请求。
                if(percent == 100) {
                    mergeFile(blob);
                    start = 0;
                    layer.msg('文件上传完毕');
                    setTimeout(function(){init();}, 1000);
                }else{
                    if(stop!=1){
                        sendRequest();
                    }
                }
            }
        };
	
	//r.upload.onprogress = function(event){
            //var pre = (100 * event.loaded / event.total);
           // console.log(pre);
           // document.getElementById("progress").style.width = (100 * index / totalSlices) + pre +"%";
            //document.getElementById("progress").setAttribute('aria-valuenow', (100 * index / totalSlices) + pre );
          //  document.getElementById("progress-num").innerHTML = parseInt((100 * index / totalSlices) + pre )+"%";
        //}

        chunk = blob.slice(start,end);//切割文件
        //构造form数据
        fd = new FormData();
        fd.append("file", chunk);
        fd.append("name", blob.name);
        fd.append("index", index);
        xhr.open("POST", uploadUrl, true);
        //设置二进制文边界件头
        xhr.setRequestHeader("X_Requested_With", location.href.split("/")[3].replace(/[^a-z]+/g, "$"));
        xhr.send(fd);
    };

    mergeFile = function (blob) {
        var xhr;
        var fd;
        xhr = new XMLHttpRequest();
        fd = new FormData();
        fd.append("name", blob.name);
        fd.append("index", totalSlices);
        xhr.open("POST", mergeUrl, true);
        xhr.setRequestHeader("X_Requested_With", location.href.split("/")[3].replace(/[^a-z]+/g, "$"));
        xhr.send(fd);
    }
JS;
$this->registerJs($js);
?>
