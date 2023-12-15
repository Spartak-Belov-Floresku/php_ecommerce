
	if(document.getElementsByClassName("smallImage").length > 0){
		var classesAddToBasket = document.getElementsByClassName("smallImage");
		for (var i = 0; i < classesAddToBasket.length; i++){
				if (document.addEventListener) {
					classesAddToBasket[i].addEventListener('mouseover', overImage);
						classesAddToBasket[i].addEventListener('mouseout', outImage);
							classesAddToBasket[i].addEventListener('click', putImage);
				}else{
					classesAddToBasket[i].attachEvent('mouseover', overImage);
						classesAddToBasket[i].attachEvent('mouseout', outImage);
							classesAddToBasket[i].attachEvent('click', putImage);
				}
			}
		}
	
	var href1;
		var href2 = document.getElementsByClassName("lft")[0].getElementsByTagName('div')[0].
				getElementsByTagName('img')[0].getAttribute("src");
		
	function putImage(){
		href1 = this.getElementsByTagName('img')[0].getAttribute("src");
			href2 = href1;
				var classesAddToBasket = document.getElementsByClassName("activeRed");
		for (var i = 0; i < classesAddToBasket.length; i++) 
					document.getElementsByClassName("activeRed")[i].setAttribute("class", "smallImage");

						this.setAttribute("class", "activeRed");
					document.getElementsByClassName("lft")[0].getElementsByTagName('div')[0].
				getElementsByTagName('img')[0].src = href1; 
		}
		
	function overImage(){
		href1 = this.getElementsByTagName('img')[0].getAttribute("src");
			document.getElementsByClassName("largeImage")[0].setAttribute("style","opacity:0; -moz-opacity:0;-webkit-opacity:0;filter:alpha(opacity=0);margin:0;width:350px;");
				document.getElementsByClassName("lft")[0].getElementsByTagName('div')[0].getElementsByTagName('img')[0].src = href1; 
			resizImage(350);
		}
	
	
	function outImage(){
		document.getElementsByClassName("largeImage")[0].setAttribute("style","opacity:0; -moz-opacity:0;-webkit-opacity:0;filter:alpha(opacity=0);margin:0;width:350px;");
			document.getElementsByClassName("lft")[0].getElementsByTagName('div')[0].getElementsByTagName('img')[0].src = href2; 
		resizImage(350);
		
		}
	
	function resizImage(need){
		var h = document.getElementsByClassName("lft")[0].getElementsByTagName('div')[0].
						getElementsByTagName('img')[0].clientHeight;
			var w_sorce = document.getElementsByClassName("lft")[0].getElementsByTagName('div')[0].
						getElementsByTagName('img')[0].clientWidth;
				var w = w_sorce;
					var margin = 0;
						if(h > need) w *= need/h;
							if(w > need)w = need;
								h *= w/w_sorce;
									if(h < need)margin = (need-h)/2;
										document.getElementsByClassName("largeImage")[0].width = w;
									document.getElementsByClassName("largeImage")[0].style.marginTop = margin+'px';
								document.getElementsByClassName("largeImage")[0].style.width = w+'px';
							document.getElementsByClassName("largeImage")[0].style.opacity = '1';
		}
	