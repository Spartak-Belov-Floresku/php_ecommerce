function sameHeight(){
	if(document.getElementsByClassName("buisnessFrom")[0]){
		if(window.innerWidth > 688){
			var h = document.getElementsByClassName("buisnessFrom")[0].clientHeight-35;
			document.getElementsByClassName("buisnessInfo")[0].style.height =  h +"px";
		}else{
			document.getElementsByClassName("buisnessInfo")[0].removeAttribute('style');
		}
	}
}

var cusEmail, cusName, cusSubject, cusMessage; 

function sendLetter(e,elem){
	
	if(checkIn()){
		desableFields();
		checkInput(elem);
		ajaxSender();
	}
}

function releaseForm(){
	
	desableFields();
	var bt = getElementId('requestF');
	setTimeout(function(){
		if(bt.hasAttribute('disabled')){
			bt.removeAttribute('disabled');
				bt.value = "Send";
					bt.removeAttribute("style");
		}
	},100);
	
}

function ajaxSender(){
	var trackbuisnessform = getElementId('trackbuisnessform').value;
	var hr = new XMLHttpRequest();
	hr.open("POST","mod/contact.php",true);
	hr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status == 200){
				releaseForm();
				protectRequistId();
				var st = hr.responseText;
				var i = st.search('SH');
				st = st.slice(i+2);
				setTimeout(function(){ getElementId('com').value = st });
		}
	}
	hr.send("cusEmail="+cusEmail
				+"&cusName="+cusName
					+"&cusSubject="+cusSubject
						+"&cusMessage="+cusMessage
						 +"&trackbuisnessform="+trackbuisnessform);
}

function desableFields(){
	
	var input = document.getElementsByTagName("input");
	var i = 0;
	while(i<input.length){
		
		if(input[i].getAttribute('name') == 'email'){
			if(!input[i].hasAttribute('disabled')){
				input[i].setAttribute('disabled','disabled');
					cusEmail = input[i].value;
			}else{
				input[i].removeAttribute('disabled');
					input[i].value = "";
			}
		}
		if(input[i].getAttribute('name') == 'name'){
			if(!input[i].hasAttribute('disabled')){
				input[i].setAttribute('disabled','disabled');
					cusName = input[i].value;
			}else{
				input[i].removeAttribute('disabled');
					input[i].value = "";
			}
		}
		if(input[i].getAttribute('name') == 'subject'){
			if(!input[i].hasAttribute('disabled')){
				input[i].setAttribute('disabled','disabled');
					cusSubject = input[i].value;
			}else{
				input[i].removeAttribute('disabled');
					input[i].value = "";
			}
		}
		i++;
	}
	
	if(!getElementId('com').hasAttribute('disabled')){
		getElementId('com').setAttribute('disabled','disabled');
			cusMessage = getElementId('com').value;
	}else{
		getElementId('com').removeAttribute('disabled');
		getElementId('com').value = "";
	}
	
	
}


function checkIn(){
	var check = true;
	var input = document.getElementsByTagName("input");
	
	var i = 0;
	
	while(i<input.length){
		
		if(input[i].getAttribute('name') == 'email'){
			var check = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
			var val = input[i].value;
			if(!check.test(val)){
				getElementId('email').innerHTML = "Email is incorrect...";
				getElementId('email').setAttribute('class','warn');
				check = false;
				break;
			}
		}
		if(input[i].getAttribute('name') == 'name'){
			var val = input[i].value;
			if(val.length < 2){
				getElementId('name').innerHTML = "Name cannot be empty...";
				getElementId('name').setAttribute('class','warn');
				check = false;
				break;
			}
		}
		if(input[i].getAttribute('name') == 'subject'){
			var val = input[i].value;
			if(val.length < 2){
				getElementId('subject').innerHTML = "Subject cannot be empty...";
				getElementId('subject').setAttribute('class','warn');
				check = false;
				break;
			}
		}
		i++;
	}
	
	var com = getElementId('com').value;
	if(com.length == 0 && check != false){
		getElementId('comment').innerHTML = "Message cannot be empty...";
		getElementId('comment').setAttribute('class','warn');
		check = false;
		
	}

	return check;
	
}


function checkInputCF(e,elem){
	
	var val = elem.value;
	var ch = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		
	if(elem.getAttribute("name") == "name"){
		var re = /^[a-zA-Z ]+$/;
		if(val.length > 40 || !re.test(ch)){
			e.preventDefault();
		}
		if(val.length > 40){
			val = val.substring(0, 40);
			elem.value = val;
		}
		var i = val.indexOf(' ');
		if(val.indexOf(' ',i+1) != i && val.indexOf(' ',i+1) != -1){
				val = val.trim();
		}
		elem.value = val;
	}
	
	if(elem.getAttribute("name") == "subject"){
		if(val.length > 50){
			e.preventDefault();
		}
		if(val.length > 50){
			val = val.substring(0, 50);
			elem.value = val;
		}
	}
	
	if(elem.getAttribute("name") == "comment"){
		if(val.length > 500){
			e.preventDefault();
		}
		if(val.length > 500){
			val = val.substring(0, 500);
			elem.value = val;
		}
	}
	
}



function removeWarn(elem){
	
	if(elem.getAttribute("name") == "email"){
		el = getElementId("email");
		if(el.hasAttribute("class")){
			var val = "Email<em>*</em>";
			el.removeAttribute("class");
			el.innerHTML = val;
		}
	}
	if(elem.getAttribute("name") == "name"){
		el = getElementId("name");
		if(el.hasAttribute("class")){
			var val = "Your name<em>*</em>";
			el.removeAttribute("class");
			el.innerHTML = val;
		}
	}
	if(elem.getAttribute("name") == "subject"){
		el = getElementId("subject");
		if(el.hasAttribute("class")){
			var val = "Subject<em>*</em>";
			el.removeAttribute("class");
			el.innerHTML = val;
		}
	}
	if(elem.getAttribute("name") == "comment"){
		el = getElementId("comment");
		if(el.hasAttribute("class")){
			var val = "Comment<em>*</em>";
			el.removeAttribute("class");
			el.innerHTML = val;
		}
	}
}