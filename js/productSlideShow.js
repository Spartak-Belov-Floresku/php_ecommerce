	if(document.getElementsByClassName("largeImage").length > 0){
		if (document.addEventListener) {
						document.getElementById("zoom").addEventListener('mousemove', zoomIn);
						document.getElementById("zoom").addEventListener('mouseout', zoomOut);
			}else{
						document.getElementById("zoom").attachEvent('mousemove', zoomIn);
						document.getElementById("zoom").attachEvent('mouseout', zoomOut);
			}
	}
	
	    function zoomIn(e) {
		
				var zoomInside = getElementId("zoomInside");
				var mainImageHolder = document.getElementsByClassName("lft")[0].getElementsByTagName("div")[0];
				var mainImageHolderWidth = mainImageHolder.offsetWidth;
				var mainImageHolderHeight = mainImageHolder.offsetHeight;
				
				var element1 = document.getElementById("overlay");
				var element2 = document.getElementById("insideOverlay");
				var img = document.getElementsByClassName("largeImage")[0];
				var posX = zoomInside.offsetLeft ? zoomInside.offsetLeft : zoomInside.offsetLeft - img.offsetLeft;
				var posY = zoomInside.offsetTop ? zoomInside.offsetTop : zoomInside.offsetTop - img.offsetTop;
				
				if(diployDiv()){
					zoomInside.style.display = "block";
					element1.style.display = "block";
				}
				
				 
				var goX = e.pageX - mainImageHolder.offsetLeft-(zoomInside.offsetWidth/2);
				var goY = e.pageY - mainImageHolder.offsetTop-(zoomInside.offsetHeight/2);
			
				
				if(e.pageX  >= mainImageHolder.offsetLeft &&
						e.pageX <= (mainImageHolder.offsetLeft+mainImageHolderWidth) &&
							e.pageY >=  mainImageHolder.offsetTop && 
								e.pageY <=(mainImageHolder.offsetTop+mainImageHolderHeight)){
									
					if(e.pageX < (mainImageHolder.offsetLeft+(zoomInside.offsetWidth/2))){
						goX = 1;
					}
					if(e.pageX > (mainImageHolder.offsetLeft+mainImageHolderWidth-(zoomInside.offsetWidth/2))){
						goX = mainImageHolderWidth - zoomInside.offsetHeight;
					}
					if(e.pageY < (mainImageHolder.offsetTop+(zoomInside.offsetHeight/2))){
						goY = 1 ;
					}					
					if(e.pageY > (mainImageHolder.offsetTop+mainImageHolderHeight-(zoomInside.offsetHeight/2))){
						goY = mainImageHolder.offsetHeight - zoomInside.offsetHeight;
					}
					zoomInside.style.left = goX+"px";
					zoomInside.style.top = goY+"px";
					zoomInside.style.position = "absolute";
					 
					element2.style.backgroundImage = "url("+img.src+")";
					element2.style.left = (-posX * 2.65) + "px ";
					element2.style.top = (-posY * 2.65) + "px ";
				
				}else{
					zoomOut();
				}
	}
	
	function zoomOut() {
		var zoomInside = document.getElementById("zoomInside");
			zoomInside.style.display = "none";
		var element1 = document.getElementById("overlay");
			element1.style.display = "none";
	}
	
	function diployDiv(){
		var imageDiv = getElementId("overlay");
			var imageDiv2 = getElementId("insideOverlay");
				var mainImage = document.getElementsByClassName("lft")[0].getElementsByTagName("div")[0].offsetWidth;
					var mainLeft = document.getElementsByClassName("lft")[0].getElementsByTagName("div")[0].offsetLeft;
					var mainTop = document.getElementsByClassName("lft")[0].getElementsByTagName("div")[0].offsetTop;
				var windowWidth = window.innerWidth;
			var testWidth = windowWidth - mainLeft - mainImage;
        var widthZoom  = testWidth>350?350:testWidth;
		
		if((widthZoom+5) == 355){
			var bigIconeDiv = document.getElementsByClassName("lft")[0].children[0];
				var leftSide = parseFloat(bigIconeDiv.offsetLeft);
			var w = parseFloat(bigIconeDiv.offsetWidth);
			
			imageDiv.style.width = widthZoom +"px";
				imageDiv2.style.width = (widthZoom*2.66)+"px";
					var topSide = parseFloat(bigIconeDiv.offsetTop);
						var h = parseFloat(bigIconeDiv.offsetHeight);
						imageDiv.style.top = mainTop +"px";
					imageDiv.style.height ="350px";
				imageDiv2.style.height = 350*2.66+"px";
			imageDiv.style.left = mainLeft + 5 + mainImage+"px";
			return true;
		}
		return false;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/*if(document.getElementsByClassName("largeImage").length > 0){
		if (document.addEventListener) {
						document.getElementsByClassName("largeImage")[0].addEventListener('click', slideShow);
			}else{
						document.getElementsByClassName("largeImage")[0].attachEvent('click', slideShow);
			}
	}
	
	function slideShow(e){
		
		slideShowBackground();
			setTimeout(function(){document.getElementsByClassName("slideShowBackground")[0].style.opacity = "1"}, 50);
		 
			
		
	}
	
	function polusDivs(){
		var newDiv = document.createElement('div');
			var mainDiv = document.getElementsByClassName("inSlideShow")[0];
				mainDiv.appendChild(newDiv);
					newDiv.className = "northDiv"
					
		newDiv = document.createElement('div');
				mainDiv.appendChild(newDiv);
					newDiv.className = "westDiv"
					
		newDiv = document.createElement('div');
				mainDiv.appendChild(newDiv);
					newDiv.className = "centerDiv"
	
		newDiv = document.createElement('div');
				mainDiv.appendChild(newDiv);
					newDiv.className = "eastDiv"
	
		
	}
	
	function inSlideShow(){
		var newDiv = document.createElement('div');
			var mainDiv = document.getElementsByClassName("slideShowBackground")[0];
				mainDiv.appendChild(newDiv);
					newDiv.className = "inSlideShow"
						newDiv.onclick = function(e){e.stopPropagation();};
				polusDivs();
		
	}
	
	function slideShowBackground(){
		if(window.innerWidth > 740){
			if(document.getElementsByClassName("slideShowBackground").length > 0){
				destroySlideShowBackground();
			}
			var footer = document.getElementById('footer');
				var locationDiv = document.getElementsByClassName("lft")[0].children;
					var newElement = document.createElement('div');
						newElement.className = "slideShowBackground";
							newElement.setAttribute("style","width:"+window.innerWidth+"px");
								newElement.style.height = window.innerHeight+"px";
									newElement.onclick = function(){destroySlideShowBackground();};
					var elementParent = footer.parentNode;
				elementParent.insertBefore(newElement, footer.nextSibling);
			inSlideShow();
		}
	}
	
	function destroySlideShowBackground(){
		document.getElementsByClassName("slideShowBackground")[0].parentNode.removeChild(document.getElementsByClassName("slideShowBackground")[0]);
	}*/