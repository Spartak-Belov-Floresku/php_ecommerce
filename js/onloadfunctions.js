window.onload = function (){

		// body opacity

		document.body.style.transition = ".2s linear";
		document.body.style.webkitTransition = ".2s linear";
		document.body.style.mozTransition = ".2s linear";
		document.body.style.msTransition = ".2s linear";
		document.body.style.oTransition = ".2s linear";
		setTimeout(function(){document.body.style.opacity = 1},50);
		// header -----------------------------------------------------------------------------------------------------
		
		protectRequistId();
		
		//home slide show----------------------------------------------------------------------------------------------

		if(getElementId("homeSlideShow") != null){
			
			var a = getElementId("homeSlideShow").getElementsByTagName("a");
				for(var i = 0;i< a.length; i++){
					if (document.addEventListener) {
								a[i].getElementsByTagName("img")[0].addEventListener('mousemove', stopSlide);
									a[i].getElementsByTagName("img")[0].addEventListener('mouseout', startSlide);
					}else{
								a[i].getElementsByTagName("img")[0].attachEvent('mousemove', stopStart);
									a[i].getElementsByTagName("img")[0].attachEvent('mouseout', startSlide);
					}
				}


				if (document.addEventListener) {
								getElementId("goRight").addEventListener('mousemove', stopSlide);
									getElementId("goLeft").addEventListener('mousemove', stopSlide);
										getElementId("goRight").addEventListener('mouseout', startSlide);
										getElementId("goLeft").addEventListener('mouseout', startSlide);
									getElementId("goRight").addEventListener('click', goRight);
								getElementId("goLeft").addEventListener('click', goLeft);
				}else{
								getElementId("goRight").attachEvent('mousemove', stopStart);
									getElementId("goLeft").attachEvent('mousemove', stopStart);
										getElementId("goRight").attachEvent('mouseout', startSlide);
										getElementId("goLeft").attachEvent('mouseout', startSlide);
									getElementId("goRight").attachEvent('click', goRight);
								getElementId("goLeft").attachEvent('click', goLeft);
				}

		
				var spanImgNum = getElementId("imgpoints").getElementsByClassName("imgpoint");
				var l = 0
				while(l < spanImgNum.length){
					if (document.addEventListener) {
								spanImgNum[l].addEventListener('click', switchImg);
					}else{
								spanImgNum[l].attachEvent('click', switchImg);
					}
					l++;
				}
		}
	
		// menu block-------------------------------------------------------------------------------------------------------
		
		setupListenerMainMenu();
		
		setupListenerMobMenu();
		var inst0 = new addClassAct();
		var inst1 = new addClassAct();
		inst0.putClass(1);
		inst1.putClass(0);
		// mobile review block----------------------------------------------------------------------------------------------

		if(getElementId("mobileReviewBlockInside") != null){
			var links = getElementId("mobileReviewBlockInside").getElementsByTagName("a");
				for(var i = 0;i< links.length; i++){
					if (document.addEventListener) {
						links[i].addEventListener('click', popupInfo);
					}else{
						links[i].attachEvent('click', popupInfo);
					}

				}
		}

		

		// review block-------------------------------------------------------------------------------------------------------

		if(getElementId("reviewblock") != null){
			var links = getElementId("reviewblock").getElementsByTagName("a");
				for(var i = 0;i< links.length; i++){
					if (document.addEventListener) {
						links[i].addEventListener('click', popupInfo);
					}else{
						links[i].attachEvent('click', popupInfo);
					}
				}
		}

		

		// new items block----------------------------------------------------------------------------------------------

		placeNewItemsBlock(GlobalVarNewItemsBlock);
		
		if(getElementId("newItemsInStore") != null){
			var links = getElementId("newItemsInStore").getElementsByTagName("a");
				for(var i = 0;i< links.length; i++){
					if (document.addEventListener) {
						links[i].addEventListener('click', popupInfo);
					}else{
						links[i].attachEvent('click', popupInfo);
					}

				}
		}
		// product page -------------------------------------------------------------------------------------------------
		
		putSizeInProduct();
		putZoom();
		
		var fs_imag = document.getElementsByClassName("fs_imag")[0];
		if(fs_imag){
			fs_imag.addEventListener('touchstart', handleTouchStart, false); 
			fs_imag.addEventListener('touchmove', handleTouchMove, false);
		}		
		
		// login page------------------------------------------------------------------
		
		addPlaseHolder();
		
		// footer -------------------------------------------------------------------------------------------------------
		
		positionGoTop();
		
		// contact page ------------------------------------------------------------------------------------------------------
		
		sameHeight();

	}