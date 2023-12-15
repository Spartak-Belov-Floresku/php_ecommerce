
	function leftmenublock(heightLeftMenu){
		if(getElementId("leftmenublock")!= null){
			if(getElementId("leftmenublock").getElementsByTagName("a").length > 0){
				var links = getElementId("leftmenublock").getElementsByTagName("a");
					var i = 0;
						while(i<links.length){
							 links[i].style.height
									= getElementId("leftmenublock").offsetWidth*heightLeftMenu +"px";
									i++;
						}
						
					setTimeout(function(){
						i= 0;
						while(i<links.length){
							links[i].getElementsByTagName("div")[0].getElementsByTagName("img")[0].style.height = links[i].offsetHeight+"px";
								i++;
						}
					},50);
			}
		}
	}