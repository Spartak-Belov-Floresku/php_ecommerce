
function placeNewItemsBlock(add){
	if(getElementId("newItemsInStore")){
		var maxHeight = 0;
		var items = document.getElementsByClassName("newItemInStore");
		for(var i = 0; i < items.length; i++){
			var checkHeight = items[i].getElementsByTagName("img")[0].offsetHeight;
				checkHeight += items[i].getElementsByTagName("p")[0].offsetHeight;
					checkHeight += items[i].getElementsByTagName("p")[1].offsetHeight;
						if(checkHeight > maxHeight){
							maxHeight = checkHeight;
						}
			
		}
		maxHeight *= add;
		setTimeout(function(){
			for(var i = 0; i < items.length; i++){
				items[i].style.height = maxHeight+"px";
			}
		},50);
	}
}