document.onkeydown = function(e){
	var keyCode = e.keyCode || e.which || e.charCode;
	var form = document.getElementsByTagName('form')[0];
		if(form != undefined){
			if(keyCode == 13){
			form.submit();
		}	
	}
	
}