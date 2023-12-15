	function ASEorDESC(){
		var attr = document.getElementById("ASDDESC").getAttribute('data-input');
		var hr = new XMLHttpRequest();
		hr.open("POST","mod/rules4viewing.php",true);
		hr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function(){
			if(hr.readyState == 4 && hr.status == 200){
					var url = window.location.href;
					if(url.indexOf('pg') != -1){
						url = url.slice(0,url.indexOf('pg')-1);
					}
					window.location = url;
			}
		}
		hr.send("aseDesc="+attr);
	}
	
	function setLimit(value){
		var hr = new XMLHttpRequest();
		hr.open("POST","mod/rules4viewing.php",true);
		hr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function(){
			if(hr.readyState == 4 && hr.status == 200){
					var url = window.location.href;
					if(url.indexOf('pg') != -1){
						url = url.slice(0,url.indexOf('pg')-1);
					}
					window.location = url;
			}
		}
		hr.send("limit="+value);
	}
	
	function sortBy(value){
		var hr = new XMLHttpRequest();
		hr.open("POST","mod/rules4viewing.php",true);
		hr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function(){
			if(hr.readyState == 4 && hr.status == 200){
					var url = window.location.href;
					if(url.indexOf('pg') != -1){
						url = url.slice(0,url.indexOf('pg')-1);
					}
					window.location = url;
			}
		}
		hr.send("sort="+value);
	}

	function initBinds(){
		if(document.getElementsByClassName("remove_basket").length > 0){
			var classRemoveBasket = document.getElementsByClassName("remove_basket");
			for (var i = 0; i < classRemoveBasket.length; i++){
				if (document.addEventListener) {
					classRemoveBasket[i].addEventListener('click', removeBasket, false);
				}else{
					classRemoveBasket[i].attachEvent('click', removeBasket, false);
				}
			}
	}

	if(document.getElementsByClassName("update_basket").length > 0){
			var classUpdateBasket = document.getElementsByClassName("update_basket");
			for (var i = 0; i < classUpdateBasket.length; i++){
				if (document.addEventListener) {
					classUpdateBasket[i].addEventListener('click', updateBasket, false);
				}else{
					classUpdateBasket[i].attachEvent('click', updateBasket, false);
				}
			}
	}

	if(document.getElementsByClassName("fld_qty").length > 0){
			var classFldQty = document.getElementsByClassName("fld_qty");
			for (var i = 0; i < classFldQty.length; i++){
				if (document.addEventListener) {
					classFldQty[i].addEventListener('keypress', function(event){
						var code = (window.Event) ? event.which : event.keyCode;
						if(code == 13){
							updateBasket();
						}
					});
				}else{
					classFldQty[i].attachEvent('keypress', function(event){
						var code = (window.Event) ? event.which : event.keyCode;
						if(code == 13){
							updateBasket();
						}
					});
				}
			}
		}
	}

	var removeBasket = function(){
		var trigger = this;
		var param = null;
		var item = trigger.getAttribute('rel');
		var hr = new XMLHttpRequest();
		hr.open("POST","mod/basket_remove.php",true);
		hr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function(){
			if(hr.readyState == 4 && hr.status == 200){
				changeButton(item);
				refreshBigBasket();
				refreshSmallBasket();
			}
		}
		hr.send("id="+item);
	}

	var refreshSmallBasket = function(){
		var hr = new XMLHttpRequest();
		hr.open("GET","mod/basket_small_refresh.php",true);
		hr.setRequestHeader("Content-Type", "application/json");
		hr.onreadystatechange = function(){
			if(hr.readyState == 4 && hr.status == 200){
				var d = JSON.parse(hr.responseText);
				//alert(JSON.stringify(d));
					for(var o in d){
						
						document.getElementsByClassName(""+ o +"")[0].getElementsByTagName("span")[0].innerHTML = d[o];
						
						// was added for mobile second basket
						
						document.getElementsByClassName(""+ o +"")[1].getElementsByTagName("span")[0].innerHTML = d[o];
					}
			}
		}
		hr.send(null);
	}

	var refreshBigBasket = function(){
		var hr = new XMLHttpRequest();
		hr.open("GET","mod/basket_view.php",true);
		hr.setRequestHeader('Content-type', 'text/html');
		hr.onreadystatechange = function(){
			if(hr.readyState == 4 && hr.status == 200){
				if(getElementId("emptyBascket")){
					getElementId("emptyBascket").parentNode.removeChild(getElementId("emptyBascket"));
				}
				document.getElementById('big_basket').innerHTML = hr.responseText;
				initBinds();
			}
		}
		hr.send(null);
	}

	

	function updateBasket(){
		var classesFldQty = document.getElementsByClassName("fld_qty");
		for(var i=0; i < classesFldQty.length; i++){
			var std = classesFldQty[i].getAttribute('id').split('-');
			var val = parseInt(classesFldQty[i].value,10);
			var hr = new XMLHttpRequest();
			hr.open("POST","mod/basket_qty.php",true);
			hr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			hr.onreadystatechange = function(){
				if(hr.readyState == 4 && hr.status == 200){
					refreshSmallBasket();	
					refreshBigBasket();	
				}
			}
			hr.send("id="+std[1]+"&qty="+val);
		}
	}

	
	
	
	
	
	var addItem = function(e){
		var trigger = this;
		var param = null;
		param = trigger.getAttribute('rel');
		var item = param.split("_");
		var hr = new XMLHttpRequest();
		hr.open("POST","mod/basket.php",true);
		hr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function(){
			if(hr.readyState == 4 && hr.status == 200){
				var d = JSON.parse(hr.responseText);
				for(var o in d){
					var new_id = item[0] + '_' + d[o];
					if(d[o] != item[1]){
						if(d[o] == 0){
							
							trigger.setAttribute('rel',new_id);
								trigger.innerHTML = "Remove from basket";
									trigger.classList.add('red');
							
							// code for recently viewed	
							var a = document.getElementsByClassName("add_to_basket");
							for(var i = 0; i<a.length ; i++){
								var r = a[i].getAttribute('rel');
									var j = r.split("_");
									if(j[0] == item[0]){
										a[i].setAttribute('rel',new_id);
											a[i].innerHTML = "Remove from basket";
												a[i].classList.add('red');
													break;
									}
							}
							
							basketjs += basketjs==""? item[0] + '_' +'1' :","+item[0] + '_' +'1'; 
							
							
						}else{
							
							// code for recently viewed	
							var itemsPHP = basketjs.split(",");
							for(var i = itemsPHP.length - 1; i >= 0; i--) {
								var items1 = itemsPHP[i].split("_");
									var items2 = new_id.split("_");
										if(items1[0] == items2[0]) {
												itemsPHP.splice(i, 1);
													break;
										}
							}
							
							basketjs = itemsPHP.join(",");
									
								
							trigger.setAttribute('rel',new_id);
								trigger.innerHTML = "Add to basket";
									trigger.classList.remove('red');
									
							var a = document.getElementsByClassName("add_to_basket");
							
							for(var i = 0; i<a.length ; i++){
								var r = a[i].getAttribute('rel');
									var j = r.split("_");
									if(j[0] == item[0]){
										a[i].setAttribute('rel',new_id);
											a[i].innerHTML = "Add to basket";
												a[i].classList.remove('red');
													break;
									}
							}
							
							
							
							
						}
						refreshSmallBasket();
						if(document.getElementsByClassName("titleBasket").length){
							refreshBigBasket();
						}
					}
				}
				
				// code to reload summary page
				
				var currentUrl = window.location.href;
					if(currentUrl.includes("?page=summary")){
						location.reload();
					}
					
			}
		}
		hr.send("id="+item[0]+"&job="+item[1]);
	}
	
	if(document.getElementsByClassName("add_to_basket").length > 0){
		var classesAddToBasket = document.getElementsByClassName("add_to_basket");
		for (var i = 0; i < classesAddToBasket.length; i++){
			if (document.addEventListener) {
				classesAddToBasket[i].addEventListener('click', addItem, false);
			}else{
				classesAddToBasket[i].attachEvent('click', addItem, false);
			}
		}
	}
	
	
	// code for recently viewed -------------------------------------------------------------------------------
	
	function changeButton(item){
		var itemsPHP = basketjs.split(",");
			for(var i = itemsPHP.length - 1; i >= 0; i--) {
				var items1 = itemsPHP[i].split("_");
					if(items1[0] == item) {
						itemsPHP.splice(i, 1);
							break;
					}
			}
							
		basketjs = itemsPHP.join(",");
	}
	
	
	
	
	
	// proceed to paypal
	
	var paypal = function(){
		var token = this.getAttribute('id');
		var img = "<div class='loading' style=\"text-align:center;\">";
		img += "<img src=\"images/loading.gif\"";
		img += " alt=\"Proceeding to PayPal\"/>";
		img += "<br/>Please wait while we are redirecting you to PayPal...";
		img += "</div><div id=\"frm_pp\"></div>";
		document.getElementById('big_basket').style.transition = "opacity .2s ease-in 0s";
		document.getElementById('big_basket').style.opacity = 0;
		setTimeout(function(){document.getElementById('big_basket').innerHTML = img;},210);
		setTimeout(function(){document.getElementById('big_basket').style.opacity = 1;},210);
		//alert("E Commerce is under construction!");
		setTimeout(function(){send2PP(token);},220);
	}
	
	function send2PP(token){
		var hr = new XMLHttpRequest();
		hr.open("POST","mod/paypal.php",true);
		hr.setRequestHeader('Content-type', "application/x-www-form-urlencoded");
		hr.onreadystatechange = function(){
			if(hr.readyState == 4 && hr.status == 200){
					getElementId('frm_pp').innerHTML = hr.responseText;
					//alert(hr.responseText);
					//submit form automatically
					getElementId('frm_paypal').submit();
			}else if(hr.status == 404){
				alert('An error has occured1');
			}
		}
		hr.send("token="+token);
	}
	
	if(document.getElementsByClassName("paypal").length > 0){
		var PayPal = document.getElementsByClassName("paypal");
		for (var i = 0; i < PayPal.length; i++){
			if (document.addEventListener) {
				PayPal[i].addEventListener('click', paypal, false);
			}else{
				PayPal[i].attachEvent('click', paypal, false);
			}
		}
	}

	

	initBinds();