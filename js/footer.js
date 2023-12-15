	function positionGoTop(){
		var goTop = getElementId("goTop");
			var pageWidth = getElementId("page").offsetWidth;
				var bodyWidth = document.body.clientWidth;
					var rightMargin = bodyWidth - pageWidth != 0?(bodyWidth - pageWidth)/2:0;
				goTop.style.right = rightMargin + 10 + "px";
			var checkTop = getElementId("header").getBoundingClientRect().top + getElementId("header").offsetHeight;
		if(checkTop <=0){
					goTop.setAttribute("class","classGoTop");			
		}else{
				goTop.removeAttribute("class");
		}
	}

	if (document.addEventListener) {
		window.addEventListener('scroll', getOpacityGoTop);
	}else{
		window.attachEvent('scroll', getOpacityGoTop);
	}

	function getOpacityGoTop(){
		var goTop = getElementId("goTop");
		if(goTop){
			var checkTop = getElementId("header").getBoundingClientRect().top + getElementId("header").offsetHeight;
				if(checkTop <=0){
					goTop.setAttribute("class","classGoTop");
				}else{
						goTop.removeAttribute("class");
				}	
		}
	}

	function activeGoTop() {
		if (document.body.scrollTop!=0 || document.documentElement.scrollTop!=0){
			window.scrollBy(0,-50);
				setTimeout('activeGoTop()',20);
		}
	}
	