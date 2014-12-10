$(document).ready(function()
{

	$('a[name="sair"]').click(function(){
		$.ajax({  
			type: 'GET',
			url: 'entrar.php',
			data: {"sair":true},
			success: function( data )  
			{  
				if (data != 0)	
				{
					$(window.document.location).attr('href','default.php');
				}
				else
				{
					alert('Ocoreu um ERRO!');
				}
			}
		});
	});
	
	function Block()
	{
		$(".fm").css("display" , "none");
		$(".cabecario").css("display" , "none");
		$("#lock").css("display" , "block");
	}
	function uBlock()
	{
		$(".fm").css("display" , "block");
		$(".cabecario").css("display" , "block");
		$("#lock").css("display" , "none");
	}

	var ssel;
	
	if ($('#sel_grupos').find('option:selected').length > 0)
	{
		ssel = "select[name='sel_projeto_gr"+$('#sel_grupos').find('option:selected').val().toString()+"']";
		$(ssel).css("display" , "block");
	}
	
	$('#sel_grupos').change(function(){
		$(ssel).css("display" , "none");
		ssel = "select[name='sel_projeto_gr"+$('#sel_grupos').find('option:selected').val().toString()+"']";
		$(ssel).css("display" , "block");  
	});

	$("#view_c_g").click(function(){			
		$("#fm_c_grupo").show("slow");
		Block();
	});		
	
	$("#hide_c_g").click(function(){			
		$("#fm_c_grupo").hide("slow");
		uBlock();
	});
  
  
	$("#view_perfil").click(function(){			
		$("#fm_perfil").show("slow");
		Block();
	});		
	
	$("#hide_perfil").click(function(){			
		$("#fm_perfil").hide("slow");
		uBlock();
	});

	$('#form_novo_grupo').validate({  
		rules: {  
			grup_nome: { required: true},  
			ger_senha: { required: true, minlength: 3}  
		},  
		messages: {  
			grup_nome:  { required: '<p class="p_erro">Você não informou um nome.'}, 
			ger_senha: { required: '<p style="color: #7E0B0B;">Você não informou a senha<p>',  minlength: '<p style="color: #7E0B0B;">A senha deve ter o mínimo de 3 letras</p>'}    
		},
		submitHandler: function( form ){  
		var dados = $( form ).serialize();  

		$.ajax({  
			type: "POST",  
			url: "s_home.php",  
			data: dados,  
			success: function( data )  
			{  
				if(data != -1)
				{
					var nome = $('input[name="grup_nome"]').val().toString();					
					var op = "<option value="+data+">"+nome+"</option>";
					var aux = $('#sel_grupos').html().toString();
					$("#fm_c_grupo").hide("slow");
					uBlock();					
					$('#sel_grupos').html(aux+op);
				}
			}  
		});  
			return false;  
		}  
	});
	
	$('#form_proximo').validate({  
		rules: {  
			sel_grupos: { required: true}
		},  
		messages: {  
			sel_grupos:  { required: '<p class="p_erro">Um grupo deve ser selecionado para proxeguir daqui.'}, 
		},
		submitHandler: function( form ){  
		var dados = $( form ).serialize();  

		$.ajax({  
			type: "POST",  
			url: "s_home.php",  
			data: dados,  
			success: function( data )  
			{  
				if(data != -1)
				{
					$(window.document.location).attr('href','desktop.php');
				}
			}  
		});  
		return false;  
		}  
	});
	
	
		
});