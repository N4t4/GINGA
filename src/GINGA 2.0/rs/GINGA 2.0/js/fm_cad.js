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
				//alert("sim");
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

	$('#fm_cad').validate({  
		rules: {  
			cad_nome:          {required: true},
			cad_senha:         {required: true},
			cad_e_mail:        {required: true, email: true },
			cad_sexo:          {required: true},
			cad_telefone:      {required: true},
			cad_endereco:      {required: true},
			cad_dt_nascimento: {required: true, date: true },
			cad_vinculo:       {required: true},
			cad_indicacao:     {required: true},
			cad_curso:         {required: true},
			cad_modulo:        {required: true},
			cad_id_area:	     {required: true}
		},  
		messages: {  
			cad_nome:  { required: '<p class="p_erro">Voc&ecirc n&atildeo informou um nome.'}, 
			cad_dt_nascimento: { date: '<p class="p_erro">Ex: 1992-09-26<p>'},  
			cad_email: { required: '<p class="p_erro">Informe o seu email<p>', email: '<p class="p_erro">*Informe um email va&aacutelido</p>' },  
			cad_senha: { required: '<p class="p_erro">Voc&ecirc n&atildeo informou a senha<p>',  minlength: '<p class="p_erro">A senha deve ter o m&iacutenimo de 3 letras</p>'}    
		},  
		submitHandler: function( form ){  
			
			var dados = {
				"cadastro":          true,
				"cad_nome":          $("input[name='cad_nome']").val(),
				"cad_senha":         $("input[name='cad_senha']").val(),
				"cad_e_mail":        $("input[name='cad_e_mail']").val(),
				"cad_indicacao":     $("input[name='cad_indicacao']").val(),
				"cad_telefone":      $("input[name='cad_telefone']").val(),
				"cad_dt_nascimento": $("input[name='cad_dt_nascimento']").val(),
				"cad_sexo": 				 $("input[name='cad_sexo']").val(),
				"cad_vinculo":       $("input[name='cad_vinculo']:checked").val(),
				"cad_curso":         $("input[name='cad_curso']").val(),
				"cad_modulo":        $("input[name='cad_modulo']").val(),
				"cad_id_area":       $("input[name='cad_id_area']:checked").val(),
				"end_rua":           $("input[name='end_rua']").val(),
				"end_numero":        $("input[name='end_numero']").val(),
				"end_bairro":        $("input[name='end_bairro']").val(),
				"end_cidade":        $("input[name='end_cidade']").val(),
				"end_estado":        $("input[name='end_estado']").val()
			};  
			
			$.ajax({  
				type: "POST",  
				url: "entrar.php",  
				data: dados,  
				success: function( data )  
				{
					if (data ==  1)
					{
						$(window.document.location).attr('href','bem_vindo.html');											
					}
					else
					{
						$(".error").html(data);
					}
				}  
			});  
			
			return false;  
		}  
	});  

	function FmCADInitialize(){
		
		if($(window).width() > 400)
		{
			InCenter(".container");
		}
		else
		{
			$("#menu>ul").css("height", "");
		}
		
	}
	
	FmCADInitialize();
	
});
