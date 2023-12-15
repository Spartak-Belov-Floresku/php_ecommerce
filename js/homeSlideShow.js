	
	//aplling functions to drive elemnts
	
	function displayNone(){
		var a = getElementId("homeSlideShow").getElementsByTagName("a");
			var i = 0;
		while(i<a.length){
			a[i].style.display = "none";
			i++;
		}
	}
	
	var slideIndex = 0;
	
	function carousel() {
		
		var a = getElementId("homeSlideShow").getElementsByTagName("a");
		
		if (slideIndex == a.length || slideIndex < 0)
			{slideIndex = 0}
		
		var k = slideIndex;
			
		if(k == 0)
			{k = a.length}
		
		a[slideIndex].style.display = "block";
		a[slideIndex].getElementsByTagName("img")[0].setAttribute("class","classTrFisrt");
		a[slideIndex].getElementsByTagName("img")[0].style.transition = ".35s linear";
		a[slideIndex].getElementsByTagName("img")[0].style.webkitTransition = ".35s linear";
		a[slideIndex].getElementsByTagName("img")[0].style.mozTransition = ".35s linear";
		a[slideIndex].getElementsByTagName("img")[0].style.msTransition = ".35s linear";
		a[slideIndex].getElementsByTagName("img")[0].style.oTransition = ".35s linear";
		var j = slideIndex;
		setTimeout(function(){
			a[j].getElementsByTagName("img")[0].style.opacity = 1;
		},20);
		
		
		a[k-1].getElementsByTagName("img")[0].setAttribute("class","classTrSecond");
		a[k-1].getElementsByTagName("img")[0].style.opacity = 0;
		if(a[k-1].style.display == "block"){
			setTimeout(function(){
				a[k-1].style.display = "none";
			},360);
		}
		
		markSpanImg(slideIndex);
		slideIndex++;
	}
	
	function carouselBack() {
		slideIndex--;
		var a = getElementId("homeSlideShow").getElementsByTagName("a");
		
		if (slideIndex < 0) {slideIndex = a.length-1}
		
		a[slideIndex].getElementsByTagName("img")[0].setAttribute("class","classTrSecond");
		a[slideIndex].getElementsByTagName("img")[0].style.opacity = 0;
		if(a[slideIndex].style.display == "block"){
			setTimeout(function(){
				a[slideIndex].style.display = "none";
			},360);
		}
		
		
		var k = slideIndex;
		
		k -= 1;
		
		if (k < 0) {k = a.length-1}
		
		
		a[k].style.display = "block";
		a[k].getElementsByTagName("img")[0].setAttribute("class","classTrFisrt");
		var j = k;
		setTimeout(function(){
			a[j].getElementsByTagName("img")[0].style.opacity = 1;
		},20);		
		
		markSpanImg(k);
		
		
	}
	
	function switchImg(){
		stopSlide();
			slideIndex = this.getAttribute("data-number-img");
			
				var a = getElementId("homeSlideShow").getElementsByTagName("a");
					a[slideIndex].style.display = "block";
						a[slideIndex].getElementsByTagName("img")[0].setAttribute("class","classTrFisrt");
							a[slideIndex].getElementsByTagName("img")[0].style.transition = ".35s linear";
							a[slideIndex].getElementsByTagName("img")[0].style.webkitTransition = ".35s linear";
							a[slideIndex].getElementsByTagName("img")[0].style.mozTransition = ".35s linear";
							a[slideIndex].getElementsByTagName("img")[0].style.msTransition = ".35s linear";
							a[slideIndex].getElementsByTagName("img")[0].style.oTransition = ".35s linear";
							var j = slideIndex;
							setTimeout(function(){
								a[j].getElementsByTagName("img")[0].style.opacity = 1;
							},20);
					
					var i = 0;
					while(i < a.length){
						if(a[i].style.display == "block" && i != slideIndex){
							a[i].getElementsByTagName("img")[0].setAttribute("class","classTrSecond");
								a[i].getElementsByTagName("img")[0].style.opacity = 0;
									var o = i;
										setTimeout(function(){
											a[o].style.display = "none";
										},360);		
						}
						i++;
					}
					
					
				markSpanImg(slideIndex);
			slideIndex++;
		startSlide();
		
	}
		
	function markSpanImg(num){
			
			var spanImgNum = getElementId("imgpoints").getElementsByClassName("imgpoint");
				var sp = 0;
					while(sp < spanImgNum.length){
						 if(spanImgNum[sp].hasAttribute("style")){
							 spanImgNum[sp].removeAttribute("style")
						 }
						 sp++;
					}
				spanImgNum[num].style.borderColor = "rgb(245,147,10)";	
				
	}
	
	function growRunScale(){
		if(getElementId("runscale").hasAttribute("class")){
			getElementId("runscale").removeAttribute("class");
		}
				setTimeout(function(){getElementId("runscale").className = "grow";},50);	
	}
	
	//functions to drive home's slid show
	var interval = setInterval(function(){
		if(getElementId("homeSlideShow") != null){
			growRunScale();
				carousel();
		}else{
			clearInterval(interval);
		}
	;}, 5000);
	
	function stopSlide(){
		clearInterval(interval);
		if(getElementId("runscale").hasAttribute("class")){
			getElementId("runscale").removeAttribute("class");
		}
	}
	
	function startSlide(){
		interval = setInterval(function(){
											carousel();
												growRunScale();
											}, 5000);
		growRunScale();
	}
	
	function goRight(){
		carousel();
	}
	
	function goLeft(){
		carouselBack();
	}
	
	
	
	//put slide show on the home page
	
	function homeSlideShowSize(){
		
			getElementId("homeSlideShow").style.height = getElementId("right").offsetWidth/2.1+"px";
				var links = getElementId("homeSlideShow").getElementsByTagName("a");
		
		setTimeout(function(){
			for (i = 0; i < links.length; i++) {
				links[i].getElementsByTagName("img")[0].style.width = getElementId("homeSlideShow").offsetWidth+"px"; 
			}
			var leftSide = getElementId("homeSlideShow").offsetLeft;
					var widthSlide = getElementId("homeSlideShow").offsetWidth;
				var heightSlide = getElementId("homeSlideShow").offsetHeight;
			var topT = (heightSlide/2)-20+"px";
				getElementId("goRight").style.left = leftSide + widthSlide - 50 +"px";;
					getElementId("goRight").style.marginTop = topT; 
				getElementId("goLeft").style.left = leftSide + 10 +"px";;
			getElementId("goLeft").style.marginTop = topT;
			
		  },60);
	}