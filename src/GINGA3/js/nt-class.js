/*************************************LOAD*/
function InitLoad(){
	$("#load").css("display", "block");
	
	var location = GetCenterWindow( $("#load img") );
	$("#load img").css("top",  location.y+"px");
	$("#load img").css("left", location.x+"px");
	$("#load img").css("opacity", 0);

	$("#load img").animate({opacity: 1}, 500);		
}
function EndLoad(){
	var location = GetCenterWindow( $("#load") );
	
	$("#load img").animate({opacity: 0}, 500, function(){
		$("#load").css("display", "none");
	});		
}	
/*************************************LOAD*/

/*************************************LOCK*/
function LockOn(){
	return $("#lock").css("display") != "none";
}
function LockInit(){
	$("body").append('<div id="lock"></div>');
	$("#lock").css("display", "none");	
	$("#lock").height(0);
}
function UnLoock(){
	$("#lock").animate(
		{height: 0},
		250,
		function(){ $("#lock").css("display", "none"); }
	);
}
function Loock(){

	if(LockOn()) return;

	$("#lock").css("display", "block");
	$("#lock").animate(
		{height: "100%"},
		500
	);
}
LockInit();
/*************************************LOCK*/

/************************************FORMS*/
function FormPadrao_CloseAll(exec){

	for(var i = 0; i < $(".fm-padrao").length; i++)
	{
		$(".fm-padrao").eq(i).animate(
			{ top: ($(this).height()*-1)+"px" },
			250,
			function(){ $(this).css("display", "none"); }
		);
	}

	UnLoock();
	if(exec) exec();
}
function FormPadrao(){

	var obj_fm = this;
	var index;

	function Initialize(){

		$("body").append('<article class="color1 border-color1 fm-padrao"> <header> <h2>Title</h2> <div class="buttons-area"> <input type="button" class="bt-fechar"> <input type="button" class="bt-minimizar"> </div> </header> <section> </section> <footer> <input type="button" id="save" class="bt" value="Salvar"> <input type="button" id="cancel" class="bt-sk2" value="Cancelar"> </footer> </article>');
		index = $(".fm-padrao").length - 1;
		$(".fm-padrao").eq(index).css("display", "none");

		$(".fm-padrao").eq(index).find(".bt-fechar").unbind("click").click(function(){
			Close();
		});

		$(".fm-padrao").eq(index).find(".bt-minimizar").unbind("click").click(function(){
			$(".fm-padrao").eq(index).css("top", $(window).height() - $(".fm-padrao>header").eq(index).height());
		});

		$(".fm-padrao").eq(index).unbind("mousedown").mousedown(function(e){
			ZTop();
		});
	}

	function ZTop(){

		$(".fm-padrao").each(function(){
			var new_z_index = $(this).css("z-index") - 1;
			$(this).css("z-index", new_z_index);
		});

		$(".fm-padrao").eq(index).css("z-index", 90 + $(".fm-padrao").length);
	}
	
	function ChekLock(){

		var exec = true;
		var    i = 0; 

		while(i < $(".fm-padrao").length && exec ){

			if( $(".fm-padrao").eq(i).css("display") != "none")
				exec = false;
			i++;
		}

		if(exec)
			UnLoock();
	}

	function Close(){
		$(".fm-padrao").eq(index).animate(
			{ top: ($(".fm-padrao").eq(index).height()*-1)+"px" },
			250,
			function(){ 
				$(".fm-padrao").eq(index).css("display", "none"); 
				ChekLock();
				$(".fm-padrao>section").eq(index).html("");
				if($(".fm-padrao").eq(index).parent("form").length > 0){
					$(".fm-padrao").eq(index).unwrap();
				}
			}
		);
	}

	this.Open = function(parameters){
		
		$(".fm-padrao").eq(index).css("z-index", 900 + index);

		if(parameters["title"])     $(".fm-padrao>header>h2").eq(index).html(parameters["title"]);
		if(parameters["data"])      $(".fm-padrao>section").eq(index).html(parameters["data"]);
		if(parameters["init_open"]) parameters["init_open"]($(".fm-padrao>section").eq(index));
		if(!parameters["mini"])   $(".fm-padrao").eq(index).find(".bt-minimizar").remove();
		if(parameters["width"])   
			$(".fm-padrao>section").eq(index).width( parameters["width"]);
		else
			$(".fm-padrao>section").eq(index).css("width", "");
		if(parameters["height"])  
			$(".fm-padrao>section").eq(index).height(parameters["height"]);
		else
			$(".fm-padrao>section").eq(index).css("height", "");
		if(parameters["save"]){
			$(".fm-padrao>footer>#save").eq(index).css("display", "block");
			$(".fm-padrao>footer>#save").eq(index).unbind("click").click(function(){ 
				parameters["save"]($(".fm-padrao>section").eq(index)); 
			});
		} else {
			$(".fm-padrao>footer>#save").eq(index).css("display", "none");
		}
		if(parameters["cancel"]){
			$(".fm-padrao>footer>#cancel").eq(index).css("display", "block");
			$(".fm-padrao>footer>#cancel").eq(index).unbind("click").click(parameters["cancel"]);
		} else {
			$(".fm-padrao>footer>#cancel").eq(index).css("display", "none");
		}
		if(parameters["close"]){

			$(".fm-padrao").eq(index).find("header>.buttons-area>.bt-fechar").unbind("click").click( function(){
				Close();
				parameters["close"]();
			});
		}else{
			$(".fm-padrao").eq(index).find("header>.buttons-area>.bt-fechar").unbind("click").click( function(){
				Close();
			});
		}
		if(parameters["save_label"]) $(".fm-padrao").eq(index).find("#save").val( parameters["save_label"] );
		if(parameters["save_name"]) $(".fm-padrao").eq(index).find("#save").attr("name",  parameters["save_name"] );
		if(parameters["move"]){
			$(".fm-padrao>header").eq(index).css("cursor", "default");	
			$(".fm-padrao>header").eq(index).mousedown(function(e){

				ZTop();

				var the_fm = $(this).parent();
				var _top   = e.pageY - getTop(the_fm);
				var _left  = e.pageX - getLeft(the_fm);
				
				$(window).unbind("mousemove").mousemove(function(e){

					the_fm.css("top", e.pageY  - _top);							
					the_fm.css("left", e.pageX - _left);							

				});

				$(window).mouseup(function(e){

					var tolerance = 32;
					var top_at = getTop(the_fm);
					var left_at = getLeft(the_fm);

					if(
					   top_at  <  tolerance ){
						the_fm.css("top", 0);
					}

					if(left_at  > (tolerance*-1) && 
					   left_at  <  tolerance ){
						the_fm.css("left", 0);
					}

					if (top_at+the_fm.height() > ($(window).height() - tolerance) &&
						top_at+the_fm.height() < ($(window).height() + tolerance)
					) {
						the_fm.css("top", $(window).height() - the_fm.height() );
					};

					if(top_at > ($(window).height() - tolerance)){
						the_fm.css("top", $(window).height() - the_fm.find("header").height() );	
					}

					if (left_at+the_fm.width() > ($(window).width() - tolerance) &&
						left_at+the_fm.width() < ($(window).width() + tolerance)
					) {
						the_fm.css("left", $(window).width() - the_fm.width() );
					};

					$(window).unbind("mousemove");

				});

				return false;
			});
		}
		if(parameters["submit"]) { 
			$(".fm-padrao").eq(index).wrap("<form action='' method='post' enctype='multipart/form-data'></form>"); 	
			$(".fm-padrao>footer>#save").eq(index).css("display", "block");
			$(".fm-padrao>footer>#save").eq(index).attr("type", "submit");
		}else{
			if($(".fm-padrao").eq(index).parent("form").length > 0){
				$(".fm-padrao").eq(index).unwrap();
			}
		}

		//Animação-----------------------------------------

		$(".fm-padrao").eq(index).css("top", $(".fm-padrao").eq(index).height()*-1);
		$(".fm-padrao").eq(index).css("display", "block");

		var location = GetCenterWindow( $(".fm-padrao").eq(index) );
		$(".fm-padrao").eq(index).css("left", location.x+"px");
		$(".fm-padrao").eq(index).find(".bt-fechar").focus();

		Loock();


		$(".fm-padrao").eq(index).animate(
			{top: location.y},
			500, function(){
				$(".fm-padrao").eq(index).css("z-index", 90 + $(".fm-padrao").length);
				if(parameters["end_open"]) parameters["end_open"]($(".fm-padrao>section").eq(index));
			}
		);				
		//Fim-Animação-------------------------------------
	}

	Initialize();
}

function FormMedia(){

	$("body").append('<article class="fm-media"> <header> <h2>Title</h2> <div class="buttons-area"> <input type="button" class="bt-fechar color1"> </div> </header> <section> </section> <footer> <input class="bt-next  color1" type="button" id="next" style="float: right"> <input class="bt-add  color1"  type="button" id="add"  style="float: right"> <input class="bt-prev color1" type="button" id="prev" style="float: left"> </footer> </article>');
	
	var $form = $(".fm-media").eq($(".fm-media").length-1);
	var index = $(".fm-media").length-1;
	var at   = 0;
	var List = null;
	var global_title = false;

	$form.css("display", "none");

	function  Close() {
		
		$form.animate(
			{top: $form.height()*-1},
			250,
			function(){ 
				$(".fm-media, .fm-padrao").css("opacity", 1);
				$form.css("display", "none"); 
				$form.children("section").html("");
				$form.children("header").find("h2").html("");
				ChekLock();
			}
		);
	}

	function ChekLock(){

		var exec = true;
		var    i = 0; 

		while(i < $(".fm-media, .fm-padrao").length && exec ){

			if( $(".fm-media, .fm-padrao").eq(i).css("display") != "none")
				exec = false;
			i++;
		}

		if(exec)
			UnLoock();
	}

	this.Open = function(parameters){

		$(".fm-media, .fm-padrao").css("opacity", 0.25)
			
		$form.css("opacity", 1);

		at = 0;
		if(parameters["at"]){ at = parameters["at"]; }
		if(parameters["title"]) $(".fm-media>header>h2").eq(index).html(parameters["title"]);
		if(parameters["data"]){
			List = parameters["data"];
			if(List.length == 1){
				$(".fm-media>footer>.bt-prev").eq(index).css("display", "none");
				$(".fm-media>footer>.bt-next").eq(index).css("display", "none");
			}else{
				$(".fm-media>footer>.bt-prev").eq(index).css("display", "block");
				$(".fm-media>footer>.bt-next").eq(index).css("display", "block");
			}
			global_title = parameters["title"] != undefined;
			$(".fm-media>header>h2").eq(index).html(global_title ? parameters["title"] : List[at].title);
			Atualiza(0);
		}
		if(parameters["next"]){
			$(".fm-media #next").eq(index).unbind("click").click(function(){
				parameters["next"](at);
				Atualiza(1);
			});
		}
		if(parameters["prev"]){
			$(".fm-media #prev").eq(index).unbind("click").click(function(){
				parameters["prev"](at);
				Atualiza(-1);
			});
		}
		if(parameters["add"]){
			$(".fm-media #add").eq(index).unbind("click").click(function(){
				
				Close();

				var item = List[at].data;

				parameters["add"](item);
			});
		} else {
			$(".fm-media #add").eq(index).css("display", "none");
		}
		if(parameters["close"]){

			$(".fm-media>header>.buttons-area>.bt-fechar").eq(index).unbind("click").click( function(){
				
				Close();

				parameters["close"]();
			});
		}
		if(parameters["width"])   
			$(".fm-media>section").eq(index).width( parameters["width"]);
		else
			$(".fm-media>section").eq(index).width( "auto" );
		if(parameters["height"])  
			$(".fm-media>section").eq(index).height(parameters["height"]);
		else
			$(".fm-media>section").eq(index).height("auto");
			
		$form.css("top", $form.height()*-1);
		
		//Animação-----------------------------------------
		$form.css("display", "block");
		var location = GetCenterWindow($form);
		$form.css("left", location.x+"px");
		$(".fm-media .bt-fechar").eq(index).focus();

		Loock();
		
		$form.animate(
			{top: location.y},
			500
		);				
		//Fim-Animação-------------------------------------
	}
	function Atualiza(index){
		at += index;

		if(at < 0) at = 0;
		if(at == List.length){
			at = List.length - 1;
		}
		
		if(at+1 == List.length){
			$form.find(".bt-next").css("display", "none");
		}else{
			$form.find(".bt-next").css("display", "block");
		}
		if(at == 0){
			$form.find(".bt-prev").css("display", "none");
		}else{
			$form.find(".bt-prev").css("display", "block");
		}

		$form.children("section").html( List[at].data);
		if(!global_title)
			$form.children("header").find("h2").html( List[at].title );

	}
	function Events(){

		$(".fm-media>header>.buttons-area>.bt-fechar").eq(index).unbind("click").click(function(){
			
			Close();

		});

		$(".fm-media #next").eq(index).unbind("click").click(function(){
			Atualiza(1);
		});

		$(".fm-media #prev").eq(index).unbind("click").click(function(){
			Atualiza(-1);
		});
	}
	Events();
}

function FormChat(parameters){

	$("body").append('<article class="fm-chat" style="background-color: '+parameters["mbstyle"]+'"; > <header> <h2>Nome do Maluco</h2> <div class="buttons-area"> <input class="bt-fechar" type="button" > <input class="bt-minimizar" type="button" > </div> </header> <section> <ul>  </ul> </section> <footer> <textarea id="send"></textarea> </footer> </article>');
	
	var $form = $(".fm-chat").eq( $(".fm-chat").length -1 );
	$form.css("z-index", 90 + ($(".fm-chat").length -1) );

	var $list = $form.children("section").children("section ul");
	var obj   = this;

	var timer_reoload;	
	
	function ZTop(){

		$(".fm-chat").each(function(){
			var new_z_index = $(this).css("z-index") - 1;
			$(this).css("z-index", new_z_index);
		});

		$form.css("z-index", 90 + $(".fm-padrao").length);
	}

	function endReload() { window.clearTimeout(timer_reoload); }

	function Init(){
		//Defines
		$form.css("bottom", $form.height()*-1);
		$form.css("left",getRealWidth($form) * ($(".fm-chat").length-1));
		
		if(parameters["color"]) $form.css( "background-color", parameters["color"] );
		if(parameters["name"]) $form.find("h2").html(parameters["name"]);
		if(parameters["list"]){
			if(parameters["mbstyle"])
				$list.html("<style>.fm-chat>section ul>.li_mb { border: solid 1px "+parameters["mbstyle"]+"}</style>"+parameters["list"]);
			else
				$list.html(parameters["list"]);
			$form.children("section").animate({scrollTop: $list.height()},1500);
		}
		if(parameters["reload"]){
			
			function startReload() {

				timer_reoload = setTimeout(function(){		
					
					var resp = parameters["reload"]();
					//alert(resp);
					if(resp != 0){
						$list.html(resp);
						$form.children("section").animate({scrollTop: $list.height()},1500);
					}

					clearTimeout(timer_reoload);
					startReload();
				},1500);
			}
			startReload();
		}
		//End-Defines

		//Events
		$form.find(".bt-fechar").unbind("click").click(function(){
			
			endReload();
			$form.animate(
				{bottom: $form.height()*-1 - 10}, 
				250, 
				function(){ 
					$form.remove(); 
					$(".fm-chat").each( function(index){
						$(this).animate({
							left: (getRealWidth(this) * index)-1
						}, 500);
					});
				}
			);
		});
		$form.find(".bt-minimizar").unbind("click").click(function(){
			
			if(getValorPx($form.css("bottom")) == 0)
				$form.animate(
					{bottom: ($form.height() - $form.children("header").height())*-1}, 
					250
				);
			else
				$form.animate(
					{bottom: 0}, 
					250
				);
		});
		$form.find(".bt-minimizar").unbind("click").click(function(){
			
			if(getValorPx($form.css("bottom")) == 0)
				$form.animate(
					{bottom: ($form.height() - $form.children("header").height())*-1}, 
					250
				);
			else
				$form.animate(
					{bottom: 0}, 
					250
				);
		});
		$form.find("#send").unbind("keydown").keydown(function(e){
			var text = $(this).val();

			if(e.which == 13 && text != ""){
				if(parameters["send"]){
					$list.append(parameters["send"](text));	
					$form.children("section").animate({scrollTop: $list.height()},1500);
				}
				$(this).val("");
				return false;
			}
		});
		$form.unbind("mousedown").mousedown(function(){
			ZTop();
		});
		//End-Events

		//View
		$form.animate(
			{bottom: "50px"},
			250,
			function(){
				$(this).animate(
					{bottom: 0}, 
					250
				);
			}
		);
		//End-View
	}

	Init();
}
/************************************FORMS*/

/*************************************DRAG*/
var execute_end_grag = function(group, id, item, list){};
function DragInit(){

	if($("#move").length == 0)
		$("body").append('<div id="move">Oi</div>');

	$(".drag>li").each(function(){
		if($(this).children(".bt-move").length == 0)
			$(this).append('<input class="bt-move color1" type="button">');	
	});
	
	$(".drag .bt-move").css("opacity", 0);
	var view_move = function(){

		$(this).find(".bt-move").animate(
			{opacity: 1},
			500
		);

		$(this).unbind("mouseleave").mouseleave(function(){

			if($(this).css("opacity") != 1) return;

			$(this).find(".bt-move").animate(
				{opacity: 0},
				250
			);
		});
	}
	$(".bt-move").parent().unbind("mouseenter").mouseenter(view_move);
	$("#move").css("display", "none");

	var Actions = function(e){
		
		var bt   = $(this);
		var item = $(this).parent();

		bt.unbind("mouseleave");
		item.css("opacity", 0.42);

		$("#move").css("display", "block");
		$("#move").css("backgroundColor", item.css("backgroundColor"));
		$("#move").html( item.html() );
		$("#move").width( item.width() );
		$("#move").height( item.height() );
		$("#move").attr("class", item.attr("class"));
		$("#move").attr("text", item.attr("text"));
		
		$("#move").css("top", e.pageY - bt.width());
		$("#move").css("left", e.pageX - ($("#move").width() - bt.width()) );									
		
		function Soltar(pageX, pageY, owner){
		
			var IN = undefined;
			
			$('.drag').each(function(){
				
				var pos = getPosition(this);
				
				if($(this).is($(owner))) return;

				if(
					(pageX > pos.x && (pageX  < (pos.x + $(this).width()))) 
					&&
					(pageY > pos.y && (pageY  < (pos.y + $(this).height())))
				)
				{
					IN = $(this);
					
					if( IN.attr("group") != owner.attr("group") ){

						IN = undefined;
						return false;
					}


					IN.addClass("drag-in");
					
					if($(this).find(".temp").length == 0){
						IN.append("<li class='temp'>"+item.html()+"</li>");
						IN.animate({scrollTop: getTop( $(this).find(".temp") )}, 500);
					}
					
					
				}else{
					$(this).find(".temp").remove();
					$(this).removeClass("drag-in");
				}
			});

			return IN;					
		}

		$(window).mousemove(function(e){
			
			$("#move").css("top", e.pageY - bt.width());
			$("#move").css("left", e.pageX - ($("#move").width() - bt.width()) );					
			Soltar(e.pageX, e.pageY, item.parent());
		});

		$(window).mouseup(function(e){

			var new_list = Soltar(e.pageX, e.pageY, item.parent());
			
			if(new_list != undefined){

				var pos = null;

				if( new_list.is("input") ){
					
					new_list.val(new_list.val() + $("#move").attr("text"));	

					pos = getPosition(new_list);

					$("#move").animate(
						{top: pos.y, left: pos.x},
						500,
						function(){
							$("#move").html("");
							$("#move").css("display", "none");
							$("#move").attr("class", "");
							$("#move").attr("text", null);
							$(".temp").attr("class", item.attr("class"));
							item.css("opacity", 0);
							item.remove();
							$(".temp").removeClass("temp");
							$(".drag").removeClass("drag-in");
							$(".drag .bt-move").unbind("mousedown").mousedown(Actions);
							$(".bt-move").parent().unbind("mouseenter").mouseenter(view_move);
							execute_end_grag(new_list.attr("group"), item.attr("moveId"), null, new_list);
						}
					);
				}

				if(new_list.is("ul"))
				{
					$(".temp").html(item.html());
					$(".temp").attr("moveId", item.attr("moveId"));

					pos = getPosition(".temp");

					$("#move").animate(
						{top: pos.y, left: pos.x},
						500,
						function(){

							var new_item = $(".temp");

							$("#move").html("");
							$("#move").css("display", "none");
							$("#move").attr("class", "");
							$(".temp").attr("class", item.attr("class"));
							item.css("opacity", 0);
							item.remove();
							$(".temp").removeClass("temp");
							$(".drag").removeClass("drag-in");
							$(".drag .bt-move").unbind("mousedown").mousedown(Actions);
							$(".bt-move").parent().unbind("mouseenter").mouseenter(view_move);
							execute_end_grag(new_list.attr("group"), item.attr("moveId"), new_item, new_list);
						}
					);
				}

			} else {
				var pos = getPosition(item);
				
				$("#move").animate(
					{top: pos.y, left: pos.x},
					250,
					function(){
						$("#move").html("");
						$("#move").css("display", "none");
						item.css("opacity", 1);
						$(".drag").removeClass("drag-in");
						$(".drag .bt-move").unbind("mousedown").mousedown(Actions);
						$(".bt-move").parent().unbind("mouseenter").mouseenter(view_move);
					}
				);
			}

			$(".bt-move").animate( {opacity: 0}, 1000);

			$(this).unbind("mousemove");
			$(this).unbind("mouseup");
		});
	}

	$(".drag .bt-move").unbind("mousedown").mousedown(Actions);
}
/*************************************DRAG*/


$(document).ready(function () {
});
