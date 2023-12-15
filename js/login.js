function addPlaseHolder(){
	if(getElementId("loginForm")){
		if(window.innerWidth <= 415){
			
			getElementId("login_email").setAttribute("placeholder","Email:");
			getElementId("login_password").setAttribute("placeholder","Password:");
			
			var array = ["first_name","last_name","address_1","address_2","city","zip_code","email","password","confirm_password"];
			
			for(var i = 0; i < array.length; i++){
				
			var str = array[i].replace("_"," ");
			str = str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
				getElementId(array[i]).setAttribute("placeholder",str);
			}
		}else{
			var input = document.getElementsByTagName("input");
				for(var i = 0 ; i < input.length; i++){
					if(input[i].hasAttribute("placeholder")){
						input[i].removeAttribute("placeholder");
					}
				}
		}
	}
	if(getElementId("recoverForm")){
		if(window.innerWidth <= 415){
			
			getElementId("email").setAttribute("placeholder","Email:");
			
		}else{
			var input = document.getElementsByTagName("input");
				for(var i = 0 ; i < input.length; i++){
					if(input[i].hasAttribute("placeholder")){
						input[i].removeAttribute("placeholder");
					}
				}
		}
		
	}
	if(getElementId("checkoutForm")){
		if(window.innerWidth <= 415){
			
			var array = ["first_name","last_name","address_1","address_2","city","zip_code","email"];
			
			for(var i = 0; i < array.length; i++){
				
			var str = array[i].replace("_"," ");
			str = str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
				getElementId(array[i]).setAttribute("placeholder",str);
			}
		}else{
			var input = document.getElementsByTagName("input");
				for(var i = 0 ; i < input.length; i++){
					if(input[i].hasAttribute("placeholder")){
						input[i].removeAttribute("placeholder");
					}
				}
		}
	}
	if(getElementId("formcreditcards")){
		if(window.innerWidth <= 415){
			
			var array = ["card_number","csn_code"];
			
			for(var i = 0; i < array.length; i++){
				var str = array[i].replace("_"," ");
					str = str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
				getElementId(array[i]).setAttribute("placeholder",str);
			}
		}else{
			var input = document.getElementsByTagName("input");
				for(var i = 0 ; i < input.length; i++){
					if(input[i].hasAttribute("placeholder")){
						input[i].removeAttribute("placeholder");
					}
				}
		}
	}
	if(getElementId("changePasswordForm")){
		if(window.innerWidth <= 415){
			
			var array = ["password","confirm_password"];
			
			for(var i = 0; i < array.length; i++){
				var str = array[i].replace("_"," ");
					str = str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
				getElementId(array[i]).setAttribute("placeholder",str);
			}
		}else{
			var input = document.getElementsByTagName("input");
				for(var i = 0 ; i < input.length; i++){
					if(input[i].hasAttribute("placeholder")){
						input[i].removeAttribute("placeholder");
					}
				}
		}
	}
}

function checkInput(but){
	setTimeout(function(){
		but.setAttribute("disabled", "disabled");
		but.value = "Sent...";
		but.innerHTML = "Sent...";
		but.style.opacity = .6;
	},10);
	
}