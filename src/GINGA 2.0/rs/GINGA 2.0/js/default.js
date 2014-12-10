function getHalfWidth(item){
	return $(item).parent().width() / 2 -  $(item).width() / 2;
}
function getHalfHeight(item){
	return $(item).parent().height() / 2 -  $(item).height() / 2;
}
function getLeft(item){
	var left = $(item).css("margin-left").toString().substr(0, $(item).css("left").toString().length-1)
	return  parseInt(left);
}
function InCenter(item){
	$(item).animate(
		{
			marginTop: getHalfHeight(item).toString() + "px",
			marginLeft: getHalfWidth(item).toString() + "px"
		},
		200,
		function(){}
	);
}

$(document).ready(function(){  
	
	function SetErrosEntrada(text){
		$(".error").html(text);
	}
	
	$('#fm_entrar').validate({  
		rules: {  
			log_email: { required: true, email: true },  
			log_senha: { required: true, minlength: 3}  
		},  
		messages: {  
				log_email: { required: 'Informe o seu email', email: 'Informe um email v&aacutelido' },  
				log_senha: { required: 'Voc&ecirc n&atildeo informou a senha',  minlength: 'A senha deve ter o m&iacutenimo de 3 letras'}    
		},  
		submitHandler: function( form ){  
			var dados = $( form ).serialize();  
			
			$.ajax({  
				type: "POST",  
				url: "entrar.php",  
				data: dados,  
				success: function( data )  
				{ 
					if(data == "Z")
						$(window.document.location).attr('href','bem_vindo.html');
					else	
					if (data ==  1)
					{
						$(window.document.location).attr('href','home.php');											
					}
					else
					{
						SetErrosEntrada(data);
					}
				}  
			});  
			
			return false;  
		}  
	});
	
	function Initialize(){
		
		//Position
		if($(window).width() > 400)
		{
			InCenter(".main");
		}
		else
		{
			$("#menu>ul").css("height", "");
		}
	}
	Initialize();
	
	$(window).bind('resize', function(e){
		window.resizeEvt;
		$(window).resize(function(){
		
			clearTimeout(window.resizeEvt);
			window.resizeEvt = setTimeout(function(){
				//alert("");
				Initialize();
			}, 80);
			
		});
	});
	
});

