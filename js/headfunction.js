	function getElementId(id) {
	
		if (document.getElementById) {
			return document.getElementById(id);
		}

		else if (document.all) {
			return window.document.all[id];
		}

		else if (document.layers) {
			return window.document.layers[id];
		}
	} 
	
	//layOutHeader functions
	function layoutHeader(){
		var pageContent = getElementId("page"); 
			var logo = getElementId("logo"); 
			var insideLogo = getElementId("insideLogo");
				var advertising = getElementId("advertising");
					var logged_as = getElementId("logged_as");
						var quickSearch = getElementId("quickSearch1");
							var nav = getElementId("nav");
							var blocknavigator = getElementId("navigator");
							
		if(pageContent.offsetWidth <= 770 ){
			logo.removeAttribute("style");
				advertising.removeAttribute("style");
					logged_as.removeAttribute("style");
					
					insideLogo.style.width = pageContent.offsetWidth*.7+"px";
						insideLogo.style.marginLeft = pageContent.offsetWidth*.15+"px";

							advertising.style.width = pageContent.offsetWidth*.5+"px";
								advertising.style.marginLeft = pageContent.offsetWidth*.25+"px";
				
										logged_as.style.marginLeft = (pageContent.offsetWidth-logged_as.offsetWidth)/2+"px";
										
											blocknavigator.style.display = "none";
												blocknavigator.style.opacity = "0"; 
		}else{
			
			logo.style.width = pageContent.offsetWidth*.3+"px";
				logo.style.marginLeft = pageContent.offsetWidth*.025+"px";
												
				advertising.style.width = pageContent.offsetWidth*.3+"px";
					advertising.style.marginLeft = pageContent.offsetWidth*.025+"px";
						insideLogo.removeAttribute("style");
					
					logged_as.style.width = pageContent.offsetWidth*.3+"px";
						logged_as.style.marginLeft = pageContent.offsetWidth*.025+"px";
							
							quickSearch.style.width = parseInt(logged_as.style.width)*.85 +"px";
				
				blocknavigator.style.display = "block";
			mainCategoriesMenu(pageContent, blocknavigator);	
		}
		
		
	}
	
	// adv function
	
	function popInf(ele){
		
		var thisDiv = ele.getBoundingClientRect();
			refDiv = ele;
		
		if(getElementId("popupInfo") == null){
			var newDiv = document.createElement('div');
				newDiv.style.transition = ".4s ease-in-out";
				newDiv.style.webkitTransition = ".4s ease-in-out";
				newDiv.style.mozTransition = ".4s ease-in-out";
					newDiv.setAttribute("id","popupInfo");
					newDiv.setAttribute("onclick","hideInfo(event);");
					setTimeout(function(){
						newDiv.style.transition = "0s";
						newDiv.style.webkitTransition = "0s";
						newDiv.style.mozTransition = "0s";
							setTimeout(function(){
								newDiv.setAttribute("class","addLoading")
							},40);
							setTimeout(function(){
								newDiv.style.transition = ".4s ease-in-out";
								newDiv.style.webkitTransition = ".4s ease-in-out";
								newDiv.style.mozTransition = ".4s ease-in-out";
							},100)}
					,600);
						sizeDiv(newDiv, thisDiv.top, thisDiv.left, thisDiv.width, thisDiv.height);
							setTimeout(function(){newDiv.style.opacity = 1;},20);
				insertAfter(newDiv, getElementId("page"));
			var newDiv2 = document.createElement('div');
				newDiv2.setAttribute("id","inPopupInfo");
					var widthDiv2 = window.innerWidth > 769?window.innerWidth*.6:window.innerWidth*.85;
						sizeDiv(newDiv2, 0, 0, widthDiv2, window.innerHeight*.8);
							newDiv2.style.marginTop = window.innerHeight*.1+"px";
								newDiv2.style.transition = "all .2s ease-in-out";
								newDiv2.style.webkitTransition = "all .2s ease-in-out";
								newDiv2.style.mozTransition = "all .2s ease-in-out";
					//newDiv.appendChild(newDiv2);
			var span = document.createElement('span');
				span.setAttribute("id","closePopupInfo");
					span.setAttribute("onclick","hideInfo(event);");
						newDiv2.appendChild(span);
					//closeButton();
			setTimeout(function(){sizeDiv(newDiv, 0, 0, window.innerWidth, window.innerHeight);},100);

		}else{
			hideInfo();
		}
		
		
		// ajax request
		var hr = new XMLHttpRequest();
		hr.open("GET","mod/popinf.php",true);
		hr.setRequestHeader('Content-type', 'text/html');
		hr.onreadystatechange = function(){
			if(hr.readyState == 4 && hr.status == 200){
				newDiv.appendChild(newDiv2);
					var inDiv = document.createElement('div');
						inDiv.setAttribute("id","indivinfo");
						inDiv.innerHTML = hr.responseText;
					newDiv2.appendChild(inDiv);
				closeButton();
				
				setTimeout(function(){
					newDiv2.style.opacity = 1;
						setTimeout(function(){
							newDiv.removeAttribute("class");
						},600);
				},400);
		
			}
		}
		
		hr.send(null);
		
	}
	
	// new functions for new main menu
	
	function mainCategoriesMenu(page, nave){
		
		var mainMenu = document.getElementsByClassName("uplevel");
		
		var widthForOneLink = page.offsetWidth/mainMenu.length;
		var lenghtLiElements = 0;
		
			for(var i = 0; i < mainMenu.length; i++){
				mainMenu[i].getElementsByTagName("a")[0].style.fontSize = page.offsetWidth*.008+"px";
			}
			if(parseInt(mainMenu[0].getElementsByTagName("a")[0].style.fontSize,20) < 10){
				for(var i = 0; i < mainMenu.length; i++){
					mainMenu[i].getElementsByTagName("a")[0].style.fontSize = "10px";
				}
			}else if(parseInt(mainMenu[0].getElementsByTagName("a")[0].style.fontSize,20) > 12){
				for(var i = 0; i < mainMenu.length; i++){
					mainMenu[i].getElementsByTagName("a")[0].style.fontSize = "12px";
				}
			}
				
				
				
					for(var i = 0; i < mainMenu.length; i++){
						var textLength = mainMenu[i].getElementsByTagName("a")[0].offsetWidth;
							lenghtLiElements += textLength;
							
					}
					
				setTimeout(function(){
					var fullAvailabelLength = page.offsetWidth - lenghtLiElements;
						var marginForOneElement = (fullAvailabelLength/mainMenu.length)*.95;
				
						
					for(var i = 0; i < mainMenu.length; i++){
						if(marginForOneElement < 1){
							marginForOneElement = 1;
						}
						i==0? mainMenu[i].style.marginLeft = marginForOneElement/2+"px":
							mainMenu[i].style.marginLeft = marginForOneElement+"px";
								if(i+1==mainMenu.length){
									nave.style.transition ="opacity .3s";
									nave.style.opacity = "1";
									break;
								}
					}
				},100);
		
	}
	
	
	function setupListenerMainMenu(){
		var elem = document.getElementsByTagName('li');
		
		for(var i = 0; i < elem.length; i++){
			if(elem[i].className == "uplevel"){
				if(elem[i].addEventListener){
						elem[i].addEventListener("mouseover", addTrack);
						elem[i].addEventListener("mouseout", removeTrack);
				}else{
						elem[i].attachEvent("on"+"mouseover",  addTrack);
						elem[i].attachEvent("on"+"mouseout", removeTrack);
				}
			}
			
		}
	}
	
	function addTrack(){
		this.className = "track";
	}
	function removeTrack(){
		this.className = "uplevel";
	}
	
	function setupListenerMobMenu(){
		var elem = document.getElementsByTagName('span');
		
		for(var i = 0; i < elem.length; i++){
			if(elem[i].hasAttribute("data-listener")){
				if(elem[i].addEventListener){
						elem[i].addEventListener("click", operateSubMenu);
				}else{
						elem[i].attachEvent("on"+"click",  operateSubMenu);
				}
			}
			
		}
	}
	
	function operateSubMenu(){
		
		var span = this;
		var id = span.getAttribute("data-id");
		var elem = getElementId(id);
		var ulTags = document.getElementsByClassName("mobSubcategory");
		
		var sp = document.getElementsByTagName("span");
		
		for(var i =0; i < sp.length; i++){
			if(sp[i].hasAttribute("data-listener")){
				sp[i].style.backgroundImage = "url(media/menu/plus.png)";
			}
		}
		
		for(var i = 0; i < ulTags.length; i++){
			if(ulTags[i].getAttribute("id") != id){
				ulTags[i].className = "mobSubcategory mobSubcategoryClose";
			}
		}
		
		var el = id;
		var li2 = "";
		while(el != ''){
			var li = getElementId(el).parentElement;
			el = li.getAttribute("data-up");
			if(getElementId(el)){			
				getElementId(el).className = "mobSubcategory mobSubcategoryOpen";
				li2 = getElementId(el).parentElement;
				li2.getElementsByTagName("span")[0].style.backgroundImage = "url(media/menu/minus.png)";
			}
		}
		
		if(elem.className == "mobSubcategory mobSubcategoryClose"){
			span.style.backgroundImage = "url(media/menu/minus.png)";
			elem.className = "mobSubcategory mobSubcategoryOpen"; 
		}else if(elem.className == "mobSubcategory mobSubcategoryOpen"){
			span.style.backgroundImage = "url(media/menu/plus.png)";
			elem.className = "mobSubcategory mobSubcategoryClose"; 
		}
		
		
	}
	
	
	function addClassAct(){
		this.putClass = function putClass(index){
			var tagA = document.getElementsByClassName("act")[index];
			if(tagA){
				var li
				while(tagA != ""){
					li = tagA.parentElement;
					var ul = "";
					try{
						ul = li.parentElement;
					}catch(err){
						break;
					}
					if(ul.tagName.toLowerCase() == "ul"){
						var parentLi = ul.parentElement;
						var a = parentLi.childNodes;
						a[0].className="act";
						tagA = a[0];
					}else{
						tagA = '';
					}
				}
			}
		}	
	}
	

	
	
	/*
	function popUpSubMenu(){
		var pop = this.getAttribute("data-subcat");
		pop = "sub_"+pop;
		var el = this.getBoundingClientRect();
		var topEl = el.top;
		var leftEl = el.left;
		var heightEl = this.offsetHeight
		var popUpSub = document.getElementsByClassName(pop)[0];
		popUpSub.style.display = "block";
		popUpSub.style.top = topEl+heightEl+"px";
		popUpSub.style.left = leftEl+"px";
	}

	*/
	
	//end layoutHeader
	
	//MobMenu functions
	
	function ModMenu(){
		var mobSkipLinks = getElementId("mobSkipLinks");
			
		for(var i = 0; i < mobSkipLinks.getElementsByTagName("a").length; i++){
			if (mobSkipLinks.getElementsByTagName("a")[i].addEventListener){
					mobSkipLinks.getElementsByTagName("a")[i]
						.addEventListener('click', function(e){
									e.preventDefault();
										showSubMenu(this.getAttribute("href"));
									});
			}else{
					mobSkipLinks.getElementsByTagName("a")[i]
						.attachEvent('onclick', function(e){
									e.preventDefault();
										showSubMenu(this.getAttribute("href"));
									});
				
			}
		}
	}
	
	//function show items subMobMenu
	
	function showSubMenu(id){
		var mobSkipLinks = getElementId("mobSkipLinks");
		
			for(var i = 0; i < mobSkipLinks.getElementsByTagName("a").length; i++){
				if(getElementId(mobSkipLinks.getElementsByTagName("a")[i].getAttribute("href")).hasAttribute("style")){
					if(id != mobSkipLinks.getElementsByTagName("a")[i].getAttribute("href")){
						getElementId(mobSkipLinks.getElementsByTagName("a")[i].getAttribute("href")).removeAttribute("style");
					}
				}
			}
		
			getElementId(id).style.height != "auto"?
				getElementId(id).style.height  = "auto":
					getElementId(id).removeAttribute("style");
					
			for(var i = 0; i < mobSkipLinks.getElementsByTagName("a").length; i++){		
				if(getElementId(mobSkipLinks.getElementsByTagName("a")[i].getAttribute("href")).hasAttribute("style")){
							mobSkipLinks.getElementsByTagName("a")[i].style.background = "#ededed";
				}else{
					mobSkipLinks.getElementsByTagName("a")[i].removeAttribute("style");
				}
			}
		
	}
	//end MobMenu functions
	
	//function for search productSub
	function goToSerch(e,el){
		e.preventDefault();
			var forma = getElementId(el.getAttribute("data-form"));
				var val = forma.getElementsByTagName("input")[0].value;
				val = val.replace(/ /g,"+");
			var url = "?page=searchresult&search="+val;
		window.location.href =url;
	}
	//end search products
	
	//function for tracking id
	function protectRequistId(){
			var hr = new XMLHttpRequest();
			hr.open("GET","mod/trackingId.php",true);
			hr.setRequestHeader("Content-Type", "application/json");
			hr.onreadystatechange = function(){
				if(hr.readyState == 4 && hr.status == 200){
						var d = JSON.parse(hr.responseText);
						//alert(JSON.stringify(d));
						for(var o in d){
							if(o == "mobLogin"){
								if(getElementId("mobLogin").getElementsByTagName("form")[0]){
									getElementId("mobLogin")
										.getElementsByTagName("form")[0]
											.getElementsByTagName("input")[0].value = d[o];
								}
							}else if(o == "registeredForm"){
								if(getElementId("registeredForm")){
									getElementId("registeredForm")
											.getElementsByTagName("input")[0].value = d[o];
								}
							}else if(o == "loginForm"){
								if(getElementId("loginForm")){
									getElementId("loginForm")
											.getElementsByTagName("input")[0].value = d[o];
								}
							}else if(o == "recoverForm"){
								if(getElementId("recoverForm")){
									getElementId("recoverForm")
											.getElementsByTagName("input")[0].value = d[o];
								}
							}else if(o == "checkoutForm"){
								if(getElementId("checkoutForm")){
									getElementId("checkoutForm")
											.getElementsByTagName("input")[0].value = d[o];
								}
							}else if(o == "formcreditcards"){
								if(getElementId("formcreditcards")){
									getElementId("formcreditcards")
											.getElementsByTagName("input")[0].value = d[o];
								}
							}else if(o == "changePasswordForm"){
								if(getElementId("changePasswordForm")){
									getElementId("changePasswordForm")
											.getElementsByTagName("input")[0].value = d[o];
								}
							}else if(o == "permanetcards"){
								if(getElementId("permanetcards")){
									getElementId("permanetcards")
											.getElementsByTagName("input")[0].value = d[o];
								}
							}else if(o == "trackbuisnessform"){
								if(getElementId("trackbuisnessform")){
									getElementId("trackbuisnessform").value = d[o];
								}
							}/*else{
								getElementId(""+o+"").getElementsByTagName("input")[0].value = d[o];
							}*/
							
						}
				}
			}
			hr.send(null);
	}