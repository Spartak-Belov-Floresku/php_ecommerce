	function putSizeInProduct(){
		
		if(document.getElementsByClassName("rgt").length && document.getElementsByClassName("fl_l").length && window.innerWidth > 702){
			var widthDes = document.getElementsByClassName("fl_l")[0].offsetWidth - 350 - 30;
			document.getElementsByClassName("rgt")[0].style.width = widthDes +"px";
			
		}else if(document.getElementsByClassName("rgt").length && document.getElementsByClassName("fl_l").length){
			if(document.getElementsByClassName("rgt")[0].hasAttribute("style")){
				document.getElementsByClassName("rgt")[0].removeAttribute("style");
			}
		}
	}

	function putZoom(){
			if(getElementId("zoom")){
				setTimeout(function(){
					var zoom = getElementId("zoom");
						var nav = getElementId("navigator");
							var height = nav.offsetHeight;
								var topNav = nav.offsetTop;
								var sum = height + topNav;
							var point = document.getElementsByClassName("lft")[0].offsetTop;
						point = sum + (point - sum);
					zoom.style.top = point+"px";
				},700);
			
			}
			
		}
		
	function widthlstIcon(){
		var li = document.getElementsByClassName("smallImage");
		if(li.length>0){
			var wUl = (parseInt(li[0].offsetWidth)*li.length);
			document.getElementsByClassName("lstIcon")[0].style.width = wUl+"px";
		}
	}

	function goRightOrLeft(ele){
		
		var ul = document.getElementsByClassName("lstIcon")[0];
			ul.style.transition = ".35s linear";
			ul.style.webkitTransition = ".35s linear";
			ul.style.mozTransition = ".35s linear";
			ul.style.msTransition = ".35s linear";
			ul.style.oTransition = ".35s linear";
			
		var li = document.getElementsByClassName("smallImage");
		var wUl = parseInt(li[0].offsetWidth)*li.length;
			
		if(ele.getAttribute("id") == "goRightMini"){
			var merLeft = parseInt(ul.style.marginLeft);
			document.getElementById("goLeftMini").setAttribute("class","putArrow");
			document.getElementById("goLeftMini").setAttribute("onclick","goRightOrLeft(this);");
			if(isNaN(merLeft)){
				merLeft = 0;
			}
			
			var li4 = document.getElementsByClassName("smallImage")[0].offsetWidth*4;
			var totalMerLeft = merLeft - li4;
			
			var remSpace = totalMerLeft + wUl;
			
			if(remSpace < li4 || remSpace == li4){
				ele.removeAttribute("onclick");
				ele.removeAttribute("class");
			}
			ul.style.marginLeft = totalMerLeft+"px";
		}
		
		if(ele.getAttribute("id") == "goLeftMini"){
			
			var merLeft = parseInt(ul.style.marginLeft);
			
			document.getElementById("goRightMini").setAttribute("class","putArrow");
			document.getElementById("goRightMini").setAttribute("onclick","goRightOrLeft(this);");
				
			
			
			var li4 = document.getElementsByClassName("smallImage")[0].offsetWidth*4;
			var totalMerLeft = merLeft + li4;
			
			
			if(totalMerLeft >= 0){
				ele.removeAttribute("onclick");
				ele.removeAttribute("class");
			}
			ul.style.marginLeft = totalMerLeft+"px";
		}
	}

	var xDown = null;  
		
	function handleTouchStart(evt) {                                         
		xDown = evt.touches[0].clientX;                                       
	};                                                

	function handleTouchMove(evt) {
		
		if(!xDown){
			return;
		}

		var xUp = evt.touches[0].clientX; 

		var xDiff = xDown - xUp;

			if ( xDiff > 0 ) {
				if(getElementId("goRightMini")){
					if(getElementId("goRightMini").className == "putArrow"){
						goRightOrLeft(getElementId("goRightMini"));
					}
				}
			} else {
				if(getElementId("goLeftMini")){
					if(getElementId("goLeftMini").className == "putArrow"){
						goRightOrLeft(getElementId("goLeftMini"));
					}
				}
			}                       
	   
		xDown = null; 
		
	};


	/*document.addEventListener('touchstart', handleTouchStart, false);        
	document.addEventListener('touchmove', handleTouchMove, false);

	var xDown = null;                                                        
	var yDown = null;                                                        

	function handleTouchStart(evt) {                                         
		xDown = evt.touches[0].clientX;                                      
		yDown = evt.touches[0].clientY;                                      
	};                                                

	function handleTouchMove(evt) {
		if ( ! xDown || ! yDown ) {
			return;
		}

		var xUp = evt.touches[0].clientX;                                    
		var yUp = evt.touches[0].clientY;

		var xDiff = xDown - xUp;
		var yDiff = yDown - yUp;

		if ( Math.abs( xDiff ) > Math.abs( yDiff ) ) {// most significant
			if ( xDiff > 0 ) {
				// left swipe 
			} else {
				// right swipe 
			}                       
		} else {
			if ( yDiff > 0 ) {
				// up swipe 
			} else { 
				// down swipe 
			}                                                                 
		}
		// reset values 
		xDown = null;
		yDown = null;                                             
	};
	*/