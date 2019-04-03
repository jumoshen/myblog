<p> 
   <label>请选择一个图像文件：</label> 
   <input type="file" id="file_input" /> 
</p>  
<div id="result" style="width:100px"></div> 

<script type="text/javascript">
	var wsServer = '<?= $socket;?>';
	var websocket = new WebSocket(wsServer);
	websocket.onopen = function (evt) {
	    console.log("Connected to WebSocket server.");
	};

	websocket.onclose = function (evt) {
	    console.log("Disconnected");
	};

	websocket.onmessage = function (evt) {
	    console.log('Retrieved data from server: ' + evt.data);
	};

	websocket.onerror = function (evt, e) {
	    console.log('Error occured: ' + evt.data);
	};

	function sendMessage(data) {
		websocket.send('{"source":"brower","action":"ask","data":{"msg":"'+data+'"}}');
	}
	var result = document.getElementById("result"); 
	var input = document.getElementById("file_input"); 
	 
	if(typeof FileReader==='undefined'){ 
	    result.innerHTML = "抱歉，你的浏览器不支持 FileReader"; 
	    input.setAttribute('disabled','disabled'); 
	}else{ 
	    input.addEventListener('change',readFile,false); 
	}
	function readFile(){ 
	    var file = this.files[0]; 
	    var reader = new FileReader(); 
	    reader.readAsBinaryString(file);
	    reader.onload = function(e){ 
	        sendMessage(this.result);

	    } 
	} 
</script>
