
function widthlstIcon(){
	var li = document.getElementsByClassName("smallImage");
	if(li.length>0){
		var wUl = (parseInt(li[0].offsetWidth)*li.length)+(li.length*10);
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
	var wUl = (parseInt(li[0].offsetWidth)*li.length)+(li.length*10);
		
	if(ele.getAttribute("id") == "goRightMini"){
		var merLeft = parseInt(ul.style.marginLeft);
		document.getElementById("goLeftMini").setAttribute("class","putArrow");
		document.getElementById("goLeftMini").setAttribute("onclick","goRightOrLeft(this);");
		if(isNaN(merLeft)){
			merLeft = 0;
		}
		
		var li4 = (document.getElementsByClassName("smallImage")[0].offsetWidth + 10)*4;
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
			
		
		
		var li4 = (document.getElementsByClassName("smallImage")[0].offsetWidth + 10)*4;
		var totalMerLeft = merLeft + li4;
		
		
		if(totalMerLeft >= 0){
			ele.removeAttribute("onclick");
			ele.removeAttribute("class");
		}
		ul.style.marginLeft = totalMerLeft+"px";
	}
	
	
}