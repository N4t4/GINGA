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
			top: getHalfHeight(item).toString() + "px",
			left: getHalfWidth(item).toString() + "px"
		},
		200,
		function(){}
	);
}

$(document).ready(function () {



		

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





    $("#sair").click(function () {
        $.ajax({
            type: 'GET',
            url: 'entrar.php',
            data: { "sair": true },
            success: function (data) {
                if (data != 0) {
                    $(window.document.location).attr('href', 'default.php');
                }
                else {
                    alert('Ocorreu um ERRO!');
                }
            }
        });
    });

    function AtProjetos(ls) {
        $.ajax({
            type: 'POST',
            url: 'sp_gen.php',
            data: { "get_all_projetos": true },
            success: function (data) {
                $(ls).html(data);
                SetupViewProjetos();
								SetupChageProjeto();								
            }
        });
    }
    function AtMembros(ls) {
        $.ajax({
            type: 'POST',
            url: 'sp_gen.php',
            data: { "get_all_membros": true },
            success: function (data) {
                $(ls).html(data);
                setupArrastar();			
								SetupTalk();
            }
        });
    }

    function AtMembrosProjeto(ls, id_projeto) {
        $.ajax({
            type: 'POST',
            url: 'sp_gen.php',
            data: { "get_ls_membros_in_projeto": true, "id_projeto": id_projeto },
            success: function (data) {
                $(ls).html(data);                
                setupArrastar();
								SetupTalk();
            }
        });
    }
    function AtMembrosNotProjeto(ls, id_projeto) {
        $.ajax({
            type: 'POST',
            url: 'sp_gen.php',
            data: { "get_ls_not_projeto": true, "id_projeto": id_projeto },
            success: function (data) {
                $(ls).html(data);
                setupArrastar();
								SetupTalk();
            }
        });
    }

    function AtMembrosPendencia(ls) {
        $.ajax({
            type: 'POST',
            url: 'sp_gen.php',
            data: { "get_ls_membros_in_pendencia": true, "id_pendencia": "" },
            success: function (data) {
                $(ls).html(data);
                setupArrastar();
								SetupTalk();
            }
        });
    }
    function AtMembrosNotPendencia(ls) {
        $.ajax({
            type: 'POST',
            url: 'sp_gen.php',
            data: { "get_ls_membros_not_pendencia": true, "id_pendencia": "" },
            success: function (data) {
                $(ls).html(data);
                setupArrastar();
								SetupTalk();
            }
        });
    }

    function Initialize() {

        AtProjetos("#ls-projetos");
        AtMembrosProjeto("#ls-membros", $("#proj_at_id").html());
        //Position
        if ($(window).width() > 400) {
            InCenter(".edit");
            InCenter(".fm_evident");
            InCenter(".edit");
            InCenter(".container");
            InCenter(".main");
        }
        else {
            $("#menu>ul").css("height", "");
        }

        $("#box_chat").animate(
			{
			    right: (($("#box_chat").width() + 10) * -1).toString() + "px"
			},
			1,
			function () { }
		);

        $("#box_at").animate(
			{
			    left: (($("#box_at").width() + 10) * -1).toString() + "px"
			},
			1,
			function () { }
		);

			$("#box_notification").css("bottom", "-" + ($("#box_notification").height()).toString() + "px");
    }
    Initialize();

    //Adicionar
    $("#add_projeto").click(function () {

        $("#ls-membros-projeto").html("");

        //AtMembrosProjeto("#ls-membros-projeto");
        //AtProjetos("#ls-projetos");

        $("#lock").css("opacity", "0");
        $("#lock").css("display", "block");
        $("#fm_projeto").css("opacity", "0");
        $("#fm_projeto").css("display", "block");

        $("#lock").animate(
					{ opacity: 1 },
					500,
					function () {
						$("#fm_projeto").animate(
							{ opacity: 1 },
							500,
							function () { }
						);
					}
				);
    });
    $("#add_pendencia").click(function () {

        $("#ls-membros-pendencia").html("");

        $("#lock").css("opacity", "0");
        $("#lock").css("display", "block");
        $("#fm_pendencia").css("opacity", "0");
        $("#fm_pendencia").css("display", "block");

        $("#lock").animate(
			{ opacity: 1 },
			500,
			function () {
			    $("#fm_pendencia").animate(
					{ opacity: 1 },
					500,
					function () { }
				);
			}
		);
    });

    $('#submit_fm_projeto .bt_ok').click(function () {

        var array = new Array();
        var i = 0;
        $('#fm_projeto #ls-membros-projeto>li>a').each(function () {
            array[i] = $(this).attr("id");
            i++;
        });
        var dados = {
            "add_projeto": true,
            "proj_nome": $("input[name='proj_nome']").val(),
            "proj_id_membros": array
        };

        $.ajax({
            type: "POST",
            url: "sp_gen.php",
            data: dados,
            success: function (data) {
                if (data == 0) {											
                    alert("!-Ocorreu um erro-!");
                }
                else {
                    AtProjetos("#ls-projetos");
                    FecharEdit();
                }
            }
        });
    });
    $('#submit_fm_pendencia .bt_ok').click(function () {

        var array = new Array();
        var i = 0;
        $('#ls-membros-pendencia>li>a').each(function () {
            array[i] = $(this).attr("id");
            i++;
        });

        var dados = {
            "add_pendencia": true,
            "pend_nome": $("input[name='pend_nome']").val(),
            "pend_termino": $("input[name='pend_termino']").val(),
            "pend_id_area": $("input[name='pend_id_area']:checked").val(),
            "pend_id_membros": array
        };

        $.ajax({
            type: "POST",
            url: "sp_gen.php",
            data: dados,
            success: function (data) {
                //$("body").html(data);
                if (data == 0) {
                    alert("!-Ocorreu um erro-!");
                }
                else {
                    $("#ls-pendencia").html(data);
                    FecharEdit();
                }
            }
        });
    });

    $("#bt_add_membros_projeto").click(function () {
        $("#lock").append($("#div-membros").html());
        $("#lock ul").html("");
        $("#lock ul").addClass("all-arraste");
        AtMembros("#lock ul");
    });
    $("#bt_add_membros_pendencia").click(function () {
        $("#lock").append($("#div-membros").html());
        $("#lock ul").html("");
        $("#lock ul").addClass("all-arraste");
        AtMembros("#lock ul");
    });

    //Fim Adicionar
		
   




	  //Editar
    function SetupViewProjetos() {
        $("#ls-projetos .view").click(function () {
            var id_projeto = $(this).attr("id");

            $("#ls-membros-projeto").html("");

            $.ajax({
                type: 'POST',
                url: 'sp_gen.php',
                //dataType : "json",
                data: { "get_projeto_by_id": true, "id_projeto": id_projeto },
                success: function (data) {
                    var obj = $.parseJSON(data);
                    $("#ed_fm_projeto input[name='proj_nome']").val(obj.nome);
                    $("#ed_fm_projeto #the_id_proj").html(obj.id);

                }
            });

            AtMembrosProjeto("#submit_fm_edit_projeto #ls-membros-projeto", id_projeto);
            
            $("#lock").css("opacity", "0");
            $("#lock").css("display", "block");
            $("#ed_fm_projeto").css("opacity", "0");
            $("#ed_fm_projeto").css("display", "block");

            $("#lock").animate(
				{ opacity: 1 },
				500,
				function () {
				    $("#ed_fm_projeto").animate(
						{ opacity: 1 },
						500,
						function () { }
					);
				}
			);


        });
    }

    $('#submit_fm_edit_projeto .bt_ok').click(function () {

        var array = new Array();
        var i = 0;
        $('#ed_fm_projeto #ls-membros-projeto>li>a').each(function () {
            array[i] = $(this).attr("id");
            i++;
        });

        var dados = {
            "edit_projeto": true,
            "proj_nome": $("#ed_fm_projeto input[name='proj_nome']").val(),
            "proj_id": $("#ed_fm_projeto #the_id_proj").html(),
            "proj_id_membros": array
        };

        $.ajax({
            type: "POST",
            url: "sp_gen.php",
            data: dados,
            success: function (data) {
                if (data == 0) {
                    alert("!-Ocorreu um erro-!");
                }
                else {
                    AtProjetos("#ls-projetos");
                    FecharEdit();
                }
            }
        });
    });
    $("#submit_fm_edit_projeto #bt_add_membros_projeto").click(function () {
        $("#lock").append($("#div-membros").html());
        $("#lock ul").html("");
        $("#lock ul").addClass("all-arraste");
        AtMembrosNotProjeto("#lock ul", $("#ed_fm_projeto #the_id_proj").html());
    });
    //FIM EDITAR

		
		//ChageProjeto
		function SetupChageProjeto(){
			$("#ls-projetos .title").click(function(){
				//alert($(this).attr("id"));
				
				$.ajax({
					type: "POST",
					url: "sp_gen.php",
					data: {"change_projeto": true, "id_projeto": $(this).attr("id")},
					success: function (data) {
							//alert(data);
							$(window.document.location).attr('href','gen.php');
					}
				});		
				
			});
		}
		//END - ChageProjeto
		
		
		//Membros Pendentes
		function EventsMembrosPendentes(){
			//Confirmar membro						
			$(".ls-new-membros .bt_ok").click(function () {
					var item = $(this).parent("li");
					
					alert($(this).attr("id"));
						
					$.ajax({
            type: "POST",
            url: "sp_gen.php",
            data: {"permitir_membro": true, "id_membro": $(this).attr("id")},
            success: function (data) {
                if (data == 0) {											
                    alert("!-Ocorreu um erro-!");
                }
                else {
                    item.remove()
                }
            }
					});
			});
			//Cancelar membro						
			$(".ls-new-membros .bt_cancel").click(function () {
					
			});
		}
		function LoadMembrosPendentes(ls){
			$.ajax({
					type: 'POST',
					url: 'sp_gen.php',
					data: { "load_mebros_pendentes": true },
					success: function (data) {
						$(ls).html(data);
						EventsMembrosPendentes();						
					}
      });
		}
		$("#new_membros").click(function () {

        $(".ls-new-membros").html("");
				LoadMembrosPendentes(".ls-new-membros");
				
        $("#lock").css("opacity", "0");
        $("#lock").css("display", "block");
        $("#fm_new_membros").css("opacity", "0");
        $("#fm_new_membros").css("display", "block");

        $("#lock").animate(
			{ opacity: 1 },
			500,
			function () {
			    $("#fm_new_membros").animate(
					{ opacity: 1 },
					500,
					function () { }
				);
			}
		);
    });
		//FIM Membros Pendentes






		
		
		
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

    $(".bt_chat").click(function () {

        if ($("#box_chat").css("right").toString() != "0px")
            $("#box_chat").animate(
				{
				    right: (0).toString() + "px"
				},
				300,
				function () { }
			);
        else
            $("#box_chat").animate(
				{
				    right: (($("#box_chat").width() + 10) * -1).toString() + "px"
				},
				300,
				function () { }
			);

    });

    $(".bt_at").click(function () {
        if ($("#box_at").css("left").toString() != "0px")
            $("#box_at").animate(
				{
				    left: (0).toString() + "px"
				},
				300,
				function () { }
			);
        else
            $("#box_at").animate(
				{
				    left: (($("#box_at").width() + 10) * -1).toString() + "px"
				},
				300,
				function () { }
			);

    });

    $("#t1").click(function () {
        $("#lock").css("opacity", "0");
        $("#lock").css("display", "block");
        $(".fm_evident").css("opacity", "0");
        $(".fm_evident").css("display", "block");

        $("#lock").animate(
			{ opacity: 1 },
			500,
			function () {
			    $(".fm_evident").animate(
					{ opacity: 1 },
					500,
					function () { }
				);
			}
		);
    });

    $("#box_notification .bt_fechar").click(function () {
        $("#box_notification").css("bottom", "-" + (10 + $("#box_notification").height()).toString() + "px");
    });

    $("#box_notification .bt_mini").click(function () {
        if ($("#box_notification").css("bottom") == '0px')
            $("#box_notification").animate(
				{ bottom: (-1 * ($("#box_notification").height() - $("#box_notification").children("header").height())) },
				300,
				function () { }
			);
        else
            $("#box_notification").animate(
				{ bottom: "0px" },
				300,
				function () { }
			);
    });

    $(window).bind('resize', function (e) {
        window.resizeEvt;
        $(window).resize(function () {

            clearTimeout(window.resizeEvt);
            window.resizeEvt = setTimeout(function () {
                //alert("");
                Initialize();
            }, 80);

        });
    });

    $("#menu_bt_view").click(function () {
        if ($("#menu>ul").height() != 0) {
            $("#menu>ul").animate(
				{ height: "0px" },
				500,
				function () { }
			);
        }
        else {
            var height_menu = $("#menu>ul>li").length * $("#menu>ul>li").height() + 10;

            $("#menu>ul").animate(
				{ height: height_menu.toString() + "px" },
				500,
				function () { }
			);
        }
    });

    function setupArrastar() {

        function Soltar(pageX, pageY) {

            var IN = null;
            var l = getLeft(".container");

            $('.arraste, .solte').each(function () {

                var lsfazer_position = $(this).position();
                l = getLeft($(this).parent());

                if (
					pageX > (lsfazer_position.left + l) &&
					pageX < lsfazer_position.left + l + $(this).width() + 10 &&
					pageY > lsfazer_position.top + 60 &&
					pageY < (
										lsfazer_position.top - 50 +
										getValorPx($(".container").css("top")) +
										$(this).height())
				 ) {
                    IN = $(this);
                    $(this).parent("div").css("background-color", "#232323");
                } else {
                    $(this).parent("div").css("background-color", "");
                }
            });

            return IN;
        }
        $(".square>div>ul>li>.arrastar").mouseenter(function () {
            $(this).css("cursor", "move");
        });
        $(".arrastar, .all-arraste a").mousedown(function (e) {

            $("#drag").css("left", e.pageX - ($("#drag").width() * 1));
            $("#drag").css("top", e.pageY - 15);

            var ls_origem_id = $(this).parent("li").parent("ul").attr("id");
            var ls_origem = $(this).parent("li").parent("ul");
            var li_tmp = $(this).parent("li");
            var li_tmp_conteudo = li_tmp.html();
            li_tmp.remove();

            $("#drag").css("display", "block");
            $("#drag").html($(this).parent("li").html());
            $("#drag").addClass($(this).parent("li").attr("class"));
            $("#drag").css("width", $(this).parent("li").width());
            $("#drag").css("height", $(this).parent("li").height());
            $(this).parent("li").css("display", "none");

            $("#drag").mouseup(function (e) {
                var ls_atual = Soltar(e.pageX, e.pageY);

                if ($("#drag").html() != "") {
                    if (ls_atual) {
                        ls_atual.append("<li class='" + li_tmp.attr("class") + "' >" + $("#drag").html() + "</li>");
                        setupArrastar();
                    }
                    else {
                        if (ls_origem.attr("id") != "ls-membros-pendencia")
                            ls_origem.append("<li class='" + li_tmp.attr("class") + "' >" + li_tmp_conteudo + "</li>");
                        $(".arraste li, .all-arraste li").css("display", "block");
                        setupArrastar();
                    }

                    $("#drag").html("");
                    $("#drag").css("display", "none");
                }
            });

            return false;
        });
        $(window).mousemove(function (e) {

            if ($("#drag").css("display") == "none")
                return;

            $("#drag").css("left", e.pageX - ($("#drag").width() * 1));
            $("#drag").css("top", e.pageY - 15);

            Soltar(e.pageX, e.pageY);
        });
				
				SetupTalk();
    }

    setupArrastar();

    $(".edit").css("display", "none");
		
		function SetupTalk()
		{
			
				/******************TALKING********************/
				if ($(".talking").length > 0) {
        function InitTalk() {
            var on_an = false;
            $("#talk").css("opacity", 0);
            $("#talk").css("display", "none");
            $(".talking").mousemove(function (e) {
                if (on_an) return;

                var talk = $("#talk");
                if (talk.css("display") == "none") {
                    talk.css("display", "block");
                    talk.animate(
							{ opacity: 1 },
							200,
							null
					);
                }

                talk.html($(this).attr("alt"));
                talk.css("top", (e.pageY - 22 - talk.height()));
                talk.css("left", (e.pageX - 22 - talk.width()));
            });
            $(".main, .talking").mouseleave(function () {
                $("#talk").animate(
					{ opacity: 0 },
					200,
					function () { $("#talk").css("display", "none"); }
			 );
            });
            $("#talk").mouseenter(function (e) {
                if (on_an) return;
                on_an = true;

                var talk = $(this);
                talk.animate(
					{
					    opacity: 0,
					    top: (getValorPx(talk.css("top")) - 10),
					    left: (getValorPx(talk.css("left")) - 10)
					},
					150,
					function () {
					    talk.css("display", "none");
					    on_an = false;
					}
			);

            });
        }
        InitTalk();
    }
				/*********************************************/
		
		}
		
		setTimeout(function () { 
		
		SetupTalk();
		
		}, 1500);
			
});
