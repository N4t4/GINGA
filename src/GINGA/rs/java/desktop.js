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
	
	$("#arquivos").click(function(){			
		$("#fm_baixar").show("slow");
		Block();
	});
	
	$("#hide_baixar").click(function(){			
		$("#fm_baixar").hide("slow");
		uBlock();
	});

	$("#view_chat").click(function(){			
		$("#fm_chat").show("slow");
		comecarReload();
	});
	
	$("#hide_chat").click(function(){			
		clearTimeout(timer);
		$("#fm_chat").hide("slow");
	});

	var timer;
	function parar() { 
		window.clearTimeout(this.timer);
	}

	function comecarReload() {
	 timer = setTimeout(function(){		
		$.ajax({  
			type: 'GET',
			url: 's_desktop.php',
			data: {"at_chat":"at_chat"},
			success: function( data )  
			{  
				if (data != 0)	
				{
					$('#fm_chat div').html(data);
				}
				else
				{
					alert('Ocoreu um ERRO!');
				}
			}
		});
		clearTimeout(timer);
		comecarReload();
	 },4000);  
	}		
	
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
	
	$("a[name='view_tarefa']").click(function(){			
	
		var tarefa = $(this).attr("href").toString().substr(1);
		var nome = $("#fm_view_tarefa h2")
		
		$.ajax({  
			type: 'GET',
			url: 's_desktop.php',
			data: {"tarefa":tarefa},
			success: function( data )  
			{  
				if (data != 0)	
				{
					$("#fm_view_tarefa").html(data);
					
					$("#hide_tarefa").click(function(){			
						//$("#fm_view_tarefa").hide("slow");
						$('#fm_view_tarefa').animate({
						opacity: 1,
						top: '+=600'}, 500, function() { 
						$('#fm_view_tarefa').css("display", "none");
						$(this).css("top","-210px")
						});
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
									$("#fm_view_tarefa").css('z-index', '19');
									$("#fm_perfil").css('z-index', '20');
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
						top: '100'}, 800, function() {});
						Block();
					});
				}
				else
				{
					alert('Ocoreu um ERRO!');
				}
			}
		});
		
		$('#fm_view_tarefa').css("display", "block");
		$('#fm_view_tarefa').animate({
		opacity: 1,
		top: '+=400'}, 800, function() {});
		Block();
	});		
  
	function AtualizarTarefa(tarefa, estado)
	{	
		var estado_at = -1;
		var starefa = "#tf" + tarefa.toString();
		if($('#tf_criadas').find(starefa).length	> 0) estado_at = 1;
		if($('#tf_fezendo').find(starefa).length	> 0) estado_at = 2;
		if($('#tf_feita').find(starefa).length   >	0) estado_at = 3;
		
		estado = estado + estado_at;
		
		if(estado == 1) 
		{
			$("#tarefa"+tarefa.toString()+" a[name='subir_tarefa']").css("display", "block");
			$("#tarefa"+tarefa.toString()+" a[name='descer_tarefa']").css("display", "none");
		}
		if(estado == 2) 
		{
			$("#tarefa"+tarefa.toString()+" a[name='subir_tarefa']").css("display", "block");
			$("#tarefa"+tarefa.toString()+" a[name='descer_tarefa']").css("display", "block");
		}
		if(estado == 3) 
		{
			$("#tarefa"+tarefa.toString()+" a[name='subir_tarefa']").css("display", "none");
			$("#tarefa"+tarefa.toString()+" a[name='descer_tarefa']").css("display", "block");
		}
	}
	
	function MudarTarefa(tarefa, estado)
	{
		var estado_at = -1;
		var starefa = "#tf" + tarefa.toString();
		if($('#tf_criadas').find(starefa).length	> 0) estado_at = 1;
		if($('#tf_fezendo').find(starefa).length	> 0) estado_at = 2;
		if($('#tf_feita').find(starefa).length   >	0) estado_at = 3;
		
		estado = estado_at + estado;
		var inf_tarefa = $(starefa).html().toString();
		$(starefa).remove();
		
		if(estado == 1) $('#tf_criadas ul').append('<li id="tf'+tarefa+'">'+inf_tarefa+'</li>');
		if(estado == 2) $('#tf_fezendo ul').append('<li id="tf'+tarefa+'">'+inf_tarefa+'</li>');
		if(estado == 3) $('#tf_feita   ul').append('<li id="tf'+tarefa+'">'+inf_tarefa+'</li>');
	}
	
	$("a[name='subir_tarefa']").click(function(){		
		var tarefa = $(this).attr("href").toString().substr(1);
		
		$('#carregar').css('display', 'block');
		
		$.ajax({  
		type: 'GET',
		url: 's_desktop.php',
		data: {"subir_tarefa":tarefa},
		success: function( data )  
		{  
			if (data != 0)	
			{
				AtualizarTarefa(tarefa,1)
				MudarTarefa(tarefa, 1);
			}
			else
			{
				alert('Ocoreu um ERRO!');
			}
			$('#carregar').css('display', 'none');
		}
		});
	});
	
	$("a[name='descer_tarefa']").click(function(){		
		var tarefa = $(this).attr("href").toString().substr(1);
		
		$('#carregar').css('display', 'block');
		
		$.ajax({  
			type: 'GET',
			url: 's_desktop.php',
			data: {"descer_tarefa":tarefa},
			success: function( data )  
			{  
				if (data != 0)	
				{
					AtualizarTarefa(tarefa,-1)
					MudarTarefa(tarefa, -1);
				}
				else
				{
					alert('Ocoreu um ERRO!');
				}
			
				$('#carregar').css('display', 'none');
			}
		});
	});
	
	$("a[name='view_membro']").click(function(){			
		var membro = $(this).attr("href").toString().substr(1);
		
		$("#fm_perfil div").html("");
		
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
		
		if ($('#fm_view_tarefa').css('display').toString() == 'none')
			uBlock();
	});	
	
	
	$("textarea").keypress(function(event) {
		
		if ( event.which == 13 ) 
		{
			var conteudo = $(this).val();
			$.ajax({  
			type: 'GET',
			url: 's_desktop.php',
			data: {"chat":"chat", "conteudo":conteudo},
			success: function( data )  
			{  
				if (data != 0)	
				{
					$('#fm_chat div').html(data);
				}
				else
				{
					alert('Ocoreu um ERRO!');
				}
			}
			});
			
			$(this).val("");
			return false;
		}
	});		
});