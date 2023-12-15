
function checknumber(e, elem){
	
	var ch = String.fromCharCode(e.which);
	
		creditNumberPut(elem);
		
		if(getElementId("csn_code").getAttribute("id") == elem.getAttribute("id")){
			var val = getElementId("csn_code").value;
			if(isNaN(ch) && (e.which != 8 ) || val.length > 2 || (e.which == 32)){
				e.preventDefault();
			}else{
				if(getElementId("csncode")){
					getElementId("csncode").remove();
				}
			}
		}
		
		
		
		
		
		
}

function creditNumberPut(elem){
	
	if(getElementId("card_number").getAttribute("id") == elem.getAttribute("id")){
			
			var val = getElementId("card_number").value;
			
			var str = val.substring(0, 2);
				var tag = document.getElementsByTagName("option");
					var i = 0;
			
			while(i < tag.length){
				tag[i].removeAttribute("selected");
					i++;
			}
			
			if(getElementId("creditnumber")){
				getElementId("creditnumber").remove();
			}
			
			i=0;
			var j = 0;
			
			while(i < tag.length){
					
				if(/^5/.test(str.substring(0, 1)) && val.length >= 16 ){
					if(!validateCardNumber(val)){
						if(!getElementId("creditnumber")){
							addErorrTag('card_number', 'creditnumber', 'Card number is incorrect...');
						}
					}else if(tag[i].getAttribute("value") == "mastercard"){
						tag[i].setAttribute("selected","true");
							j = i;
								if(!/[1-5]/.test(str.substring(1, 2))){
									addErorrTag('card_number', 'creditnumber', 'Card number is incorrect...');
										tag[j].removeAttribute("selected");
								}
					}
				}else if(/^4/.test(str.substring(0, 1)) && val.length >= 16){
					if(!validateCardNumber(val)){
						if(!getElementId("creditnumber")){
							addErorrTag('card_number', 'creditnumber', 'Card number is incorrect...');
						}
					}else if(tag[i].getAttribute("value") == "visa"){
						tag[i].setAttribute("selected","true");
					}
				}else if(/^3/.test(str.substring(0, 1)) && val.length >= 15){
					if(!validateCardNumber(val)){
						if(!getElementId("creditnumber")){
							addErorrTag('card_number', 'creditnumber', 'Card number is incorrect...');
						}
					}else if(tag[i].getAttribute("value") == "americanexpress"){
						tag[i].setAttribute("selected","true");
							j = i;
						if(!/[47]/.test(str.substring(1, 2))){
							addErorrTag('card_number', 'creditnumber', 'Card number is incorrect...');
								tag[j].removeAttribute("selected");
						}
					}
				}else if(/^6/.test(str.substring(0, 1)) && val.length >= 16){
					if(!validateCardNumber(val)){
						if(!getElementId("creditnumber")){
							addErorrTag('card_number', 'creditnumber', 'Card number is incorrect...');
						}
					}else if(tag[i].getAttribute("value") == "discover"){
						tag[i].setAttribute("selected","true");
						j = i;
						if(!/[0245]/.test(str.substring(1, 2))){
							addErorrTag('card_number', 'creditnumber', 'Card number is incorrect...');
								tag[j].removeAttribute("selected");
						}
					}
				}else if(/^[127890]/.test(str.substring(0, 1)) || isNaN(val) || val.indexOf(' ') >= 0){
					
					if(!getElementId("creditnumber")){
						addErorrTag('card_number', 'creditnumber', 'Card number is incorrect...');
					}
					if(val.length == 0){
						if(getElementId('creditnumber')){
							getElementId('creditnumber').remove();
						}
					}
					
					
				}
				 
				i++;
			}
		}

	
}

function validateCardNumber(value){
	
	var numberString = value.split('');
		numberString.reverse();
	
	var totalSum = 0;
		var i = 1;
	
	for(var num in numberString){
		if(i%2 == 0){
			var creditLocal = 2 * parseInt(numberString[num],10);
				if(creditLocal < 10){
					totalSum += creditLocal;
				}else if(creditLocal == 10){
					totalSum += 1;
				}else if(creditLocal != 0){
					var stringLocal = creditLocal.toString();
					var stringLocal2 = stringLocal.split('');
					totalSum += (parseInt(stringLocal2[0],10) + parseInt(stringLocal2[1],10));
				}
					i++;
				continue;
		}
			
				totalSum += parseInt(numberString[num],10);
			i++;
		
		
	}
	
	return totalSum%10 == 0? true:false;
}


function focusDate(){
	if(getElementId("m_c")){
		getElementId("m_c").remove();
	}
	var d = new Date();
		var curM = d.getMonth();
			var curY = d.getFullYear();
		var m2  = getElementId("month").options[getElementId("month").selectedIndex].getAttribute("value");
	var y2 = getElementId("year").options[getElementId("year").selectedIndex].getAttribute("value");
	
	if( (y2 == curY && curM+1 > m2) || y2 > curY+10 || y2 < curY || m2 == 0){
		if(!getElementId('m_c')){
			addErorrTag('month', 'm_c', 'Date is incorrect...');
		}
	}
}


function sendCardNumber(e,elem){
	var check = true;
	
	creditNumberPut(getElementId("card_number"));
	
	if(getElementId("card_number").value.length != 16){
		if(!getElementId('creditnumber')){
			addErorrTag('card_number', 'creditnumber', 'Card number is incorrect...');
		}
		check = false;
	}
	if(getElementId('creditnumber')){
		check = false;
	}
	
	if(getElementId("csn_code").value.length < 3){
		if(!getElementId('csncode')){
			addErorrTag('csn_code', 'csncode', 'CSN code is incorrect...');
		}
			check = false;
	}
	

	var d = new Date();
		var curM = d.getMonth();
			var curY = d.getFullYear();
		var m2  = getElementId("month").options[getElementId("month").selectedIndex].getAttribute("value");
	var y2 = getElementId("year").options[getElementId("year").selectedIndex].getAttribute("value");
	
	if( (y2 == curY && curM+1 > m2) || y2 > curY+10 || y2 < curY || m2 == 0){
		if(!getElementId('m_c')){
			addErorrTag('month', 'm_c', 'Date is incorrect...');
		}
			check = false;
	}
	
		
	check == true ? checkInput(elem): e.preventDefault();
}


function addErorrTag(id, subid, string){
	var el = getElementId(id);
		var span = document.createElement('span');
			span.setAttribute('id',subid);
				span.className = 'warn';
		span.innerHTML = string;
	el.parentNode.insertBefore(span, el);
}

function removeError(){
	getElementId("radionCheck").innerHTML = "";
}

function checkRadio(e,elem){
	var radios = document.getElementsByTagName('input');
	var value = false;
	for (var i = 0; i < radios.length; i++) {
		if (radios[i].type === 'radio' && radios[i].checked) {
			value = true;
			break;
		}
	}
	if(!value){
		e.preventDefault();
		getElementId("radionCheck").innerHTML = "Please choose a credit / debit card";
	}else{
		 checkInput(elem)
	}
}
