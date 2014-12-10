function DataView(title, data){
	this.title = title;
	this.data  = data;
}
function Pos(x, y){
    this.x = x;
    this.y = y;
}
function getLeft(item) {
	return $(item).offset().left - $(window).scrollLeft();
}
function getTop(item){
	var pos = $(item).position();
	return (pos.top+getValorPx($(item).parent().css("margin-top").toString()));
}
function getHalfHeight(qry) {
  return ($(window).height() / 2 - $(qry).height() / 2);
}
function getHalfWidth(qry) {
  return ($(window).width() / 2 - $(qry).width() / 2);
}
function getHalfWidthParent(qry) {
  return ($(qry).parent().width() / 2 - $(qry).width() / 2);
}
function getValorPx(valor){
	var v = parseInt(valor.substr(0, valor.length-1));
	return v;
}
function getRealHeight(item){
	var retorno = 0;
	
	var size_margin_top;
	if($(item).css("margin-top"))
		size_margin_top = getValorPx($(item).css("margin-top").toString());
		
	var size_margin_bottom;
	if($(item).css("margin-bottom"))
		size_margin_bottom = getValorPx($(item).css("margin-bottom").toString()); 
		
	var size_border_top;
	if($(item).css("border-top-width"))
		size_border_top = getValorPx($(item).css("border-top-width").toString()); 
		
	var size_border_bottom;	
	if($(item).css("border-bottom-width"))
		size_border_bottom = getValorPx($(item).css("border-bottom-width").toString()); 
	
	var size_padding_top;
	if($(item).css("padding-top"))
		size_padding_top = getValorPx($(item).css("padding-top").toString()); 
	
	var size_padding_bottom;
		if($(item).css("padding-bottom"))
			size_padding_bottom = getValorPx($(item).css("padding-bottom").toString());; 
			
	var size_height		= $(item).height();
	
	if(size_margin_top)
		retorno += size_margin_top;    
	if(size_margin_bottom)
		retorno += size_margin_bottom; 
	if(size_border_top)
		retorno += size_border_top;    
	if(size_border_bottom)
		retorno += size_border_bottom;
	if(size_padding_top)
		retorno += size_padding_top;	
	if(size_padding_bottom)
		retorno += size_padding_bottom;
	if(size_height)
		retorno += size_height;		
	
	return retorno;
}
function getRealWidth(item){

	var retorno = 0;
	
	var size_margin_left   = getValorPx($(item).css("margin-left").toString()); 
	var size_margin_right  = getValorPx($(item).css("margin-right").toString()); 
	var size_border_left   = getValorPx($(item).css("border-left-width").toString()); 
	var size_border_right	 = getValorPx($(item).css("border-right-width").toString()); 
	var size_padding_left	 = getValorPx($(item).css("padding-left").toString()); 
	var size_padding_right = getValorPx($(item).css("padding-right").toString());; 
	var size_width   	     = $(item).width();
	
	if(size_margin_left && size_margin_left > 0)
		retorno += size_margin_left;    
	if(size_margin_right && size_margin_right > 0)
		retorno += size_margin_right; 
	if(size_border_left)
		retorno += size_border_left;    
	if(size_border_right)
		retorno += size_border_right;
	if(size_padding_left)
		retorno += size_padding_left;	
	if(size_padding_right)
		retorno += size_padding_right;
	if(size_width)
		retorno += size_width;		

	return retorno;
}
function getRealWidthTESTE(item){

	var retorno = 0;
	
	var size_margin_left   = getValorPx($(item).css("margin-left").toString()); 
	var size_margin_right  = getValorPx($(item).css("margin-right").toString()); 
	var size_border_left   = getValorPx($(item).css("border-left-width").toString()); 
	var size_border_right	 = getValorPx($(item).css("border-right-width").toString()); 
	var size_padding_left	 = getValorPx($(item).css("padding-left").toString()); 
	var size_padding_right = getValorPx($(item).css("padding-right").toString());; 
	var size_width   	     = $(item).width();
	
	if(size_margin_left)
		retorno += size_margin_left;    
	if(size_margin_right)
		retorno += size_margin_right; 
	if(size_border_left)
		retorno += size_border_left;    
	if(size_border_right)
		retorno += size_border_right;
	if(size_padding_left)
		retorno += size_padding_left;	
	if(size_padding_right)
		retorno += size_padding_right;
	if(size_width)
		retorno += size_width;		

	return retorno;
}
function GetCenter(item){
	var left;
	
	if($(item).width() > $(item).parent().width())
	{
		left = (($(item).width()/2) - ($(item).parent().width()/2));
		left*= left > 0 ? -1 : 1;
	}
	else
	{
		left = ($(item).parent().width()/2) - ($(item).width()/2);
		left*= left > 0 ? 1 : -1;
	}
	return left;
}
function GetCenterWH(item){
	var left;
	var top;

	if($(item).width() > $(item).parent().width())
	{
		left = (($(item).width()/2) - ($(item).parent().width()/2));
		left*= left > 0 ? -1 : 1;
	}
	else
	{
		left = ($(item).parent().width()/2) - ($(item).width()/2);
		left*= left > 0 ? 1 : -1;
	}
    
  if($(item).height() > $(item).parent().height())
	{
		top = (($(item).height()/2) - ($(item).parent().height()/2));
		top*= top > 0 ? -1 : 1;
	}
	else
	{
		top = ($(item).parent().height()/2) - ($(item).height()/2);
		top*= top > 0 ? 1 : -1;
	}

	return (new Pos(left ,top));
}
function SetInCenter(item){
	$(item).css("margin-left", GetCenter(item)+"px");
}
function GetMaginpaddingH(item){
	return getRealHeight(item) - $(item).height();
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
	
	$("#sair").click(function(){
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
    
    	
			$("#box_chat>ul>li>a").click(function(){
			
			$("#box_notification").animate(
				{ bottom: "10px" },
				500,
				function () {
						$("#box_notification").animate(
						{
					    bottom: "0px"
						},
						300,
						function () { }
					);
				}
			);
		
		});
			
	function LoadPendencias(ls, st){
		$.ajax({  
			type: 'POST',
			url: 'sp_home.php',
			data: {"load_pendencias":true, "st": st},
			success: function( data )  
			{ 
				$(ls).html(data);
				setupPendencias();
			}
		});
	}
	function AtualizarPendencia(id_pendencia, st){
	
		$.ajax({  
			type: 'GET',
			url: 'sp_home.php',
			data: {"at_pendencia":true,"id_pendencia": id_pendencia, "st": st},
			success: function( data )  
			{
				if (data != 0)	
				{
					alert('Ocoreu um ERRO!');
					Initialize();
				}
			}
		});
	}
	
	function Initialize(){
		
		//Position
		if($(window).width() > 400)
		{
		
			LoadPendencias("#ls-criados", 1);
			LoadPendencias("#ls-fazer", 2);
			LoadPendencias("#ls-pronto", 3);
		
			InCenter(".edit");
			InCenter(".fm_evident");
			InCenter(".container");
			InCenter(".main");
		}
		else
		{
			$("#menu>ul").css("height", "");
		}
		
		$("#box_chat").animate(
			{
				right: (($("#box_chat").width()+10)*-1).toString()+"px"
			},
			1,
			function(){}
		);
		
		$("#box_at").animate(
			{
				left: (($("#box_at").width()+10)*-1).toString()+"px"
			},
			1,
			function(){}
		);
		
		$("#box_notification").css("bottom","-"+($("#box_notification").height()).toString()+10 + "px");
	
	}
	Initialize();
	
	$(".bt_chat").click(function(){
		
		if($("#box_chat").css("right").toString() != "0px")
			$("#box_chat").animate(
				{
					right: (0).toString()+"px"
				},
				300,
				function(){}
			);
		else
			$("#box_chat").animate(
				{
					right: (($("#box_chat").width()+10)*-1).toString()+"px"
				},
				300,
				function(){}
			);
			
	});
	
	$(".bt_at").click(function(){
		if($("#box_at").css("left").toString() != "0px")
			$("#box_at").animate(
				{
					left: (0).toString()+"px"
				},
				300,
				function(){}
			);
		else
			$("#box_at").animate(
				{
					left: (($("#box_at").width()+10)*-1).toString()+"px"
				},
				300,
				function(){}
			);
			
	});
	
	$("#t1").click(function(){
		$("#lock").css("opacity", "0");
		$("#lock").css("display", "block");
		$(".fm_evident").css("opacity", "0");
		$(".fm_evident").css("display", "block");
		
		$("#lock").animate(
			{ opacity: 1},
			500,
			function(){
				$(".fm_evident").animate(
					{ opacity: 1},
					500,
					function(){}
				);
			}
		);		
	});
	
	$("#box_notification .bt_fechar").click(function(){
		$("#box_notification").css("bottom","-"+(10+$("#box_notification").height()).toString() + "px");
	});
	
	$("#box_notification .bt_mini").click(function(){
		if($("#box_notification").css("bottom") == '0px')
			$("#box_notification").animate(
				{bottom: (-1 * ($("#box_notification").height() - $("#box_notification").children("header").height()))},
				300,
				function(){}
			);
		else
			$("#box_notification").animate(
				{bottom: "0px"},
				300,
				function(){}
			);
	});
	
	$(".fm_evident .bt_fechar").click(function(){
			$(".fm_evident").animate(
			{ opacity: 0},
			400,
			function(){
				$("#lock").animate(
					{ opacity: 0},
					200,
					function(){
						$("#lock").css("display", "none");
						$(".fm_evident").css("display", "none");
					}
				);
			}
		);		
	});
	
	$(window).bind('resize', function(e){
		window.resizeEvt;
		$(window).resize(function(){
		
			clearTimeout(window.resizeEvt);
			window.resizeEvt = setTimeout(function(){
				Initialize();
			}, 80);
			
		});
	});
	
	$("#menu_bt_view").click(function(){
		if($("#menu>ul").height() != 0)
		{
			$("#menu>ul").animate(
				{height: "0px"},
				500,
				function(){}
			);
		}
		else 
		{
			var height_menu = $("#menu>ul>li").length * $("#menu>ul>li").height() + 10;
			
			$("#menu>ul").animate(
				{height: height_menu.toString()+"px"},
				500,
				function(){}
			);
		}
	});
	
	function setupPendencias(){
	
		function Soltar(pageX, pageY){
			
			var IN = null;
			var l = getLeft(".container");
			
			$('.arraste').each(function(){
				var lsfazer_position = $(this).position();
				if(
					pageX > (lsfazer_position.left+l) &&
					pageX < lsfazer_position.left+l+$(this).width()+10 &&
					pageY > lsfazer_position.top+60 &&
					pageY < (
										lsfazer_position.top + 10 +
										getValorPx($(".container").css("margin-top"))+
										$(this).height())
				 )
				{
					IN = $(this);
					$(this).parent("div").css("border-color","#FF0000");
				}else{
					$(this).parent("div").css("border-color","#000000");
				}
			});
			
			return IN;
		}
		$(".square>div>ul>li>.arrastar").mouseenter(function(){
			$(this).css("cursor", "move");
		});
		$(".arrastar, .all-arraste a").mousedown(function(e){
			
			$("#drag").css("left", e.pageX-($("#drag").width()*1)); 		
			$("#drag").css("top", e.pageY-15);
			
			var ls_origem_id    = $(this).parent("li").parent("ul").attr("id");
			var li_tmp          = $(this).parent("li");
			
			$("#drag").css("display","block");
			$("#drag").html($(this).parent("li").html());
			$("#drag").addClass($(this).parent("li").attr("class"));
			$(this).parent("li").css("display", "none");
			$("#drag").mouseup(function(e){
				$(".arrastar, .all-arraste a").mousedown(null);
				var ls_atual = Soltar(e.pageX, e.pageY);
				 
				if($("#drag").html() != "")
				{
					if(ls_atual)
					{
						var id_pendencia = parseInt($("#drag").children("p").html());	
						
						if(ls_atual.attr("id") == "ls-criados")
							AtualizarPendencia(id_pendencia, 1);
						if(ls_atual.attr("id") == "ls-fazer");
							AtualizarPendencia(id_pendencia, 2);
						if(ls_atual.attr("id") == "ls-pronto");
							AtualizarPendencia(id_pendencia, 3);
						
						ls_atual.append("<li id='1' class='quarrel'>"+$("#drag").html()+"</li>");
						li_tmp.remove();
						
						setupPendencias();
					}
					else
					{
						$(".arraste li, .all-arraste li").css("display", "block");
					}
					
					$("#drag").html("");
					$("#drag").css("display","none");
				}
				li_tmp.remove();
			});
			
			return false;
		});
		$(window).mousemove(function(e){
			
			if($("#drag").css("display") == "none") return;
			$("#drag").css("left", e.pageX-($("#drag").width()*1)); 		
			$("#drag").css("top", e.pageY-15);
			
			Soltar(e.pageX, e.pageY);
		});
		
	}
	setupPendencias();

	
	$(".edit #ls-projetos>li .title").click(function(){
				
				
				
				$.ajax({
					type: "POST",
					url: "sp_gen.php",
					data: {"change_projeto": true, "id_projeto": $(this).attr("id")},
					success: function (data) {
							//alert(data);
							$(window.document.location).attr('href','home.php');
					}
				});		
				
	});
	$("#bt_change_projet").click(function () {

      $("#lock").css("opacity", "0");
      $("#lock").css("display", "block");
      $("#fm_sel_proj").css("opacity", "0");
      $("#fm_sel_proj").css("display", "block");

      $("#lock").animate(
	  		{ opacity: 1 },
		  	500,
				function () {
				$("#fm_sel_proj").animate(
						{ opacity: 1 },
						500,
						function () { }
					);
				}
			);
	});
	function FecharEdit() {

        $("#lock").html("");
        $(".edit").animate(
		{ opacity: 0 },
		400,
			function () {
			    $("#lock").animate(
				{ opacity: 0 },
				200,
				function () {
				    $("#lock").css("display", "none");
				    $(".edit").css("display", "none");
				}
			);
			}
		);

  }
	$(".edit .bt_fechar").click(function () {
			FecharEdit();
	});
	
	$(".edit #ls-projetos>li").hover(function(){
		$(this).animate(
			{opacity: 0.4},
			200,
			function(){
				$(this).animate(
				{opacity: 1},
				200,
				function(){
				}
			);
			}
		);
	});
	
});
