	

	// functions that plases reviewblock items
	
	var refDiv;
	
	function reviewBlock(GlobalGetHeightReviewBlock){
		if(getElementId("reviewblock").getElementsByTagName("a").length > 0){
			
			setTimeout(function(){
				var links = getElementId("reviewblock").getElementsByTagName("a");
					var i = 0;
						while(i<links.length){
							links[i].style.height
								= getElementId("reviewblock").offsetWidth*GlobalGetHeightReviewBlock +"px";
									i++;
						}
			},100);
			
		}
		if(getElementId("mobileReviewBlockInside").getElementsByTagName("a").length > 0){
			var links = getElementId("mobileReviewBlockInside").getElementsByTagName("a");
				var i = 0;
					while(i<links.length){
						 links[i].style.height
								= getElementId("mobileReviewBlockInside").offsetWidth*GlobalGetHeightReviewBlock +"px";
								i++;
					}
		}

	}

	

	

	

	function insertAfter(el, referenceNode) {
				referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
	}

	

	function sizeDiv(div,topspace,leftspace,width,height){
			div.style.top = topspace+"px";
				div.style.left = leftspace+"px";
			div.style.width = width+"px";
		div.style.height = height+"px";
	}

	

	function popupInfo(e){
		e.preventDefault();
			var productId = this.getAttribute("data-product-id");
				var thisDiv = this.getBoundingClientRect();
					refDiv = this;

		//create or remove main popUpInfo
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
			var aGoTo = document.createElement('a');
				newDiv2.appendChild(aGoTo);
			var img = document.createElement('img');
				newDiv2.appendChild(img);
			var label = document.createElement('label');
				newDiv2.appendChild(label);
			var p = document.createElement('p');
				newDiv2.appendChild(p);
			var a = document.createElement('a');
				p.appendChild(a);
			var p2 = document.createElement('p');
				p2.setAttribute("class","popUpDescription");
					newDiv2.appendChild(p2);

			setTimeout(function(){sizeDiv(newDiv, 0, 0, window.innerWidth, window.innerHeight);},100);

		}else{
			hideInfo();
		}

				

		

		// ajax request
		var hr = new XMLHttpRequest();
		hr.open("POST","mod/reviewblockajax.php",true);
		hr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function(){
			if(hr.readyState == 4 && hr.status == 200){
					newDiv.appendChild(newDiv2);
						closeButton();
				var d = JSON.parse(hr.responseText);
					var linkGo = "?page=catalogue-item&category="+d["category"] +"&id="+d["id"];
					aGoTo.setAttribute("href",linkGo);
					aGoTo.setAttribute("title","Go to the Product page");
					aGoTo.innerHTML = d["name"];
						img.setAttribute("alt",d["name"]);
							var stringImg = d["image"]!= null?d["image"].split('/'):null;
								var strImg = stringImg != null && stringImg != ""?stringImg[0]:"unavailable.png";
								var scr = "media/catalogue/"+strImg;
									img.setAttribute("src",scr)
								label.innerHTML = "Price: <strong>&dollar;"+ d["price"]+"</strong>";
							p2.innerHTML = d["description"]

							var stringBsket;
							var alink = document.getElementsByClassName("add_to_basket");

								for(var i = 0; i<alink.length ; i++){
									var r = alink[i].getAttribute('rel');
										var j = r.split("_");
											if(j[0] == d["id"] && j[1] >= 1){
												a.setAttribute("class","add_to_basket");
													var rel = d["id"]+"_1";
														a.setAttribute("rel",rel);
															stringBsket = "Add to the basket";
														break;
											}else if(j[0] == d["id"] && j[1] == 0){
												a.setAttribute("class","add_to_basket red");
													var rel = d["id"]+"_0";
														a.setAttribute("rel",rel);
															stringBsket = "Remove from basket";
														break;
											}
								}

							
							if(!a.hasAttribute("rel")){
									if(basketjs != ""){
										var itemsPHP = basketjs.split(",");
											for(var i=0;i<itemsPHP.length;i++){
												var itemPHP = itemsPHP[i].split("_");
													if(itemPHP[0] == d["id"] && itemPHP[1] >= 1){
														a.setAttribute("class","add_to_basket red");
															var rel = d["id"]+"_0";
																a.setAttribute("rel",rel);
																	stringBsket = "Remove from basket";
														break;
													}else if(itemPHP[0] == d["id"] && itemPHP[1] == 0){
														a.setAttribute("class","add_to_basket");
															var rel = d["id"]+"_1";
																a.setAttribute("rel",rel);
																	stringBsket = "Add to the basket";
														break;
													}else{
														a.setAttribute("class","add_to_basket");
															var rel = d["id"]+"_1";
																a.setAttribute("rel",rel);
																	stringBsket = "Add to the basket";
													} 
											}
									}else{
										a.setAttribute("class","add_to_basket");
											var rel = d["id"]+"_1";
												a.setAttribute("rel",rel);
													stringBsket = "Add to the basket";
									}
								}

				a.setAttribute("onclick","return false;");
				a.innerHTML = stringBsket;
				if (document.addEventListener) {
						a.addEventListener('click', addItem, false);
				}else{
						a.attachEvent('click', addItem, false);
				}
				setTimeout(function(){
					newDiv2.style.opacity = 1;
					setTimeout(function(){
							newDiv.removeAttribute("class");
						},600);
				},400);
					
			}
			
		}
		hr.send("id="+productId);
		
		
	}

	

	// function remove popupinfo window
	function hideInfo(evt){
        eve = evt || window.event;
		var ref = eve.target || eve.srcElement || eve.originalTarget || eve.originalEvent;
		if(ref.id == "popupInfo" || ref.id == "closePopupInfo"){
			var popupInfo = getElementId("popupInfo");
			if(getElementId("inPopupInfo")){
				getElementId("inPopupInfo").style.opacity = 0;
				getElementId("closePopupInfo").style.opacity = 0;
			}
				setTimeout(function(){
					var thisDiv = refDiv.getBoundingClientRect();
						sizeDiv(getElementId("popupInfo"), thisDiv.top, thisDiv.left, thisDiv.width, thisDiv.height);
							setTimeout(function(){getElementId("popupInfo").style.opacity = 0;},100);
								setTimeout(function(){popupInfo.parentNode.removeChild(popupInfo);},500);
					},300);
		}
	}

	

	//function for selphonove

	function closeButton(){
		var closePopupInfo = getElementId("closePopupInfo");
		var inPopupInfo = getElementId("inPopupInfo");
		closePopupInfo.style.opacity = 0;
		setTimeout(function(){					
			var leftInPopupInfo = inPopupInfo.offsetLeft;
			var topInPopupInfo = inPopupInfo.offsetTop;
			var widthInPopupInfo = inPopupInfo.offsetWidth;
			closePopupInfo.style.left = leftInPopupInfo + widthInPopupInfo - 15 +"px";
			closePopupInfo.style.top = topInPopupInfo - 15 +"px";
			closePopupInfo.style.opacity = 1;
		},500);
	}

	

	function sizeInPopupInfo(){
		var inPopupinfo = getElementId("inPopupInfo");
		if(getElementId("popupInfo")!= null){
			sizeDiv(getElementId("popupInfo"), 0, 0, window.innerWidth, window.innerHeight);
				if(getElementId("closePopupInfo")){
					closeButton();
				}
		}

		

		if(inPopupinfo!= null && window.innerWidth <= 770 ){
			sizeDiv(inPopupinfo, 0, 0, window.innerWidth*.9, window.innerHeight*.9);
				inPopupinfo.style.marginTop = window.innerHeight*.05+"px";
		}else if(inPopupinfo != null && window.innerWidth > 770){
			var widthDiv2 = window.innerWidth > 769?window.innerWidth*.6:window.innerWidth*.85;
				sizeDiv(inPopupinfo, 0, 0, widthDiv2, window.innerHeight*.8);
					inPopupinfo.style.marginTop = window.innerHeight*.1+"px";
		}

	}

	

	

	