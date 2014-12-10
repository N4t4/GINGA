$(document).ready(function() {

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

	$('#sel_projeto').change(function(){
		var proj = $(this).find('option:selected').val();
		
		$.ajax({  
			type: "GET",  
			url: "s_gen.php",  
			data: {"proj":proj, "set_tarefa":true},  
			success: function( data )  
			{	
				$("#sel_tarefas").html(data);
			}  
		});		
		
		$.ajax({  
			type: "GET",  
			url: "s_gen.php",  
			data: {"proj":proj, "set_membro":true},  
			success: function( data )  
			{	
				$("#sel_membro_projeto").html(data);
			}  
		});
		
		$("#membro_tarefa").html("");
	});	
	
	$('#sel_tarefas').change(function(){
		var tarefa = $(this).find('option:selected').val();
		
		$.ajax({  
			type: "GET",  
			url: "s_gen.php",  
			data: {"taref":tarefa, "set_membro_tarefa":true},  
			success: function( data )  
			{	
				$("#membro_tarefa").html(data);
				$("#membro_tarefa").css("display","none");
				$("#membro_tarefa").show("slow");
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
	
	$('input[name="associar_tarefa"]').click(function(){
		
		var tarefa  = $('#sel_tarefas option:selected').val();
		var membrop = $('#sel_membro_projeto option:selected').val();
		
		$('#carregar').css('display', 'block');
		
		if(($('#sel_tarefas option:selected').length > 0) &&
			 ($('#sel_membro_projeto option:selected').length > 0))
		{
			
			var dados  = {"tarefa":tarefa, "membro":membrop, "associar_tarefa":true};
			
			$.ajax({  
				type: "POST",  
				url: "s_gen.php",  
				data: dados,  
				success: function( data )  
				{
					if(data != 0)
					{
						$("#membro_tarefa").append(data);
					}
					else
					{
						alert("Ocorreu um erro!");
					}
					$('#carregar').css('display', 'none');
				}  
			});
		}
		else
			alert("Selecione uma tarefa e um membro do projeto.")
	});
	
	$('#form_add_grupo').validate({  
		submitHandler: function( form ){  
		var array = new Array();
		var i = 0;
		
		$('#carregar').css('display', 'block');
		
		$('ul li').find('input[name="mbs"]:checked').each(function(){
			array[i] = $(this).val();
			i++;
		});
		var sel = $('#sel_projeto').find('option:selected').val();
		var dados  = {"vetor":array, "sel":sel, "associar_grupo":true}
		
		$.ajax({  
			type: "POST",  
			url: "s_gen.php",  
			data: dados,  
			success: function( data )  
			{
				if(data != 0)
				{
					$('ul li').find('input[name="mbs"]:checked').each(function(){
					 $('#gli'+$(this).val().toString()).remove();
					});
					
					$(".v_membros").append(data);
					$("#fm_add_membro").hide("slow");
					uBlock();
					
				}
				else
				{
					alert("Ocorreu um erro!");
				}
				$('#carregar').css('display', 'none');
			}  
		});  
		return false;  
		}  
	});	
	
	$('#form_add_projeto').validate({  
		submitHandler: function( form ){  
		var array = new Array();
		var i = 0;
		
		$('#carregar').css('display', 'block');
		
		$('ul li').find('input[name="mbgs"]:checked').each(function(){
			array[i] = $(this).val();
			i++;
		});
		var sel = $('#sel_projeto').find('option:selected').val();
		var dados  = {"vetor":array, "sel":sel, "associar_membro_projeto":true}
		
		$.ajax({  
			type: "POST",  
			url: "s_gen.php",  
			data: dados,  
			success: function( data )  
			{
				if(data != 0)
				{
					$('ul li').find('input[name="mbgs"]:checked').each(function(){
					 $('#li'+$(this).val().toString()).remove();
					});
					
					$("#sel_membro_projeto").append(data);
					$("#fm_c_membro_projeto").hide("slow");
					uBlock();
				}
				else
				{
					alert("Ocorreu um erro!");
				}
				$('#carregar').css('display', 'none');
			}  
		});  
		return false;  
		}  
	});	
	
	$('input[name="nova_tarefa"]').click(function(){
  	var sel = $('#sel_projeto').find('option:selected').val();
		$('#form_cad_tarefa').validate({  
			rules: {  
				trf_nome: { required: true},
				trf_descricao: { required: true}
			},  
				messages: {  
				trf_nome:  { required: '<p class="p_erro">Uma tarefa deve ter um nome.'}, 
				trf_descricao:  { required: '<p class="p_erro">A descri&ccedil&atilde n&atildeo foi informada.'}
			},
			submitHandler: function( form ){  			
				var nome = $('input[name="trf_nome"]').val();
				var descricao = $('textarea[name="trf_descricao"]').val();
				
				$.ajax({  
					type: 'GET',
					url: 's_gen.php',
					data: {"nome":nome,"descricao":descricao, "sel":sel,"nova_tarefa":true},
					success: function( data )  
					{ 
						if(data != 0)
						{
							$('#sel_tarefas').append(data);
							$("#fm_c_tarefa").hide("slow");
							uBlock();
						}
						else
							alert("Ocorreu um erro!");
					}
				});
				return false;  
			}  
		});
	});
	
	$('#form_cad_projeto').validate({  
		rules: {  
			proj_nome: { required: true}
		},  
			messages: {  
			proj_nome:  { required: '<p class="p_erro">Um nome deve ser informado para criar um projeto.'}, 
		},
		submitHandler: function( form ){  
		var dados = $( form ).serialize();  
		
		$.ajax({  
			type: "POST",  
			url: "s_gen.php",  
			data: dados,  
			success: function( data )  
			{
				if(data != 0)
				{
					$("#sel_projeto").append(data);
					$("#fm_c_projeto").hide("slow");
					uBlock();
				}
			}  
		});  
		return false;  
		}  
	});
	
	$('#view_c_projeto').click(function(){
		$("#fm_c_projeto").show("slow");
		Block();
	});
	
	$("#hide_c_projeto").click(function(){			
		$("#fm_c_projeto").hide("slow");
		uBlock();
  });
	
	$('#view_c_tarefa').click(function(){
		$("#fm_c_tarefa").show("slow");
		Block();
	});
	
	$("#hide_c_tarefa").click(function(){			
		$("#fm_c_tarefa").hide("slow");
		uBlock();
  });	
	
	$('#view_c_membro_projeto').click(function(){
		$("#fm_c_membro_projeto").show("slow");
		Block();
	});
	
	$("#hide_c_membro_projeto").click(function(){			
		$("#fm_c_membro_projeto").hide("slow");
		uBlock();
  });
	
	$('#view_add_membro').click(function(){
		$("#fm_add_membro").show("slow");
		Block();
	});
	
	$("#hide_add_membro").click(function(){			
		$("#fm_add_membro").hide("slow");
		uBlock();
  });
	
		$("a[name='view_membro']").click(function(){			
		var membro = $(this).attr("href").toString().substr(1);
		
		$.ajax({  
			type: 'GET',
			url: 's_desktop.php',
			data: {"view_membro":membro},
			success: function( data )  
			{  
				if (data != 0)	
				{
					$("#fm_perfil div").html(data);
				}
				else
				{
					alert('Ocoreu um ERRO!');
				}
			}
		});
	
		$('#fm_perfil').css("display", "block");
		$('#fm_perfil').animate({
		opacity: 1,
		top: '+=500'}, 400, function() {});
		Block();
	});		
	
	$("#hide_perfil").click(function(){			
		$('#fm_perfil').animate({
		opacity: 1,
		top: '+=500'}, 400, function() { 
		$('#fm_perfil').css("display", "none");
		$(this).css("top","-450px");
		});
		uBlock();
	});	
		
	uBlock();
});
