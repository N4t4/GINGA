$(document).ready(function(){  

		function SetErrosEntrada(valor)
		{
			$('#p_erro_ent').html(valor);
		}	
		
		function SetErrosCadastro(valor)
		{
			$('#p_erro_cd').html(valor);
		}	
		
		$('input').click( function() {
			SetErrosEntrada("");
			SetErrosCadastro("");
		});
		
		$('#form_entrar').validate({  
				rules: {  
						log_email: { required: true, email: true },  
						log_senha: { required: true, minlength: 3}  
				},  
				messages: {  
						log_email: { required: '<p style="color: #7E0B0B;">Informe o seu email<p>', email: '<p style="color: #7E0B0B;">*Informe um email v&aacutelido</p>' },  
						log_senha: { required: '<p style="color: #7E0B0B;">Voc&ecirc n&atildeo informou a senha<p>',  minlength: '<p style="color: #7E0B0B;">A senha deve ter o m&iacutenimo de 3 letras</p>'}    
				},  
				submitHandler: function( form ){  
						var dados = $( form ).serialize();  

						$.ajax({  
								type: "POST",  
								url: "entrar.php",  
								data: dados,  
								success: function( data )  
								{ 
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
		
		$('#cad_form').validate({  
				rules: {  
						cad_nome:  { required: true},  
						cad_email: { required: true, email: true },  
						cad_senha: { required: true, minlength: 3}
				},  
				messages: {  
						cad_nome:  { required: '<p class="p_erro">Voc&ecirc n&atildeo informou um nome.'}, 
						cad_email: { required: '<p class="p_erro">Informe o seu email<p>', email: '<p class="p_erro">*Informe um email va&aacutelido</p>' },  
						cad_senha: { required: '<p class="p_erro">Voc&ecirc n&atildeo informou a senha<p>',  minlength: '<p class="p_erro">A senha deve ter o m&iacutenimo de 3 letras</p>'}    
				},  
				submitHandler: function( form ){  
						var dados = $( form ).serialize();  

						$.ajax({  
								type: "POST",  
								url: "entrar.php",  
								data: dados,  
								success: function( data )  
								{  
									if (data ==  1)
									{
										$(window.document.location).attr('href','home.php');											
									}
									else
									{
										SetErrosCadastro(data);
									}
								}  
						});  

						return false;  
				}  
		});  
});