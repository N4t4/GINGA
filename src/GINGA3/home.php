<?php  
	require_once("includes/conexao.php"); 
	include("includes/Myclasses.php");
	global $conexao;
	session_start();

	if(!$_SESSION['sessao']) header("Location: default.php"); 
	
	$msm = "";
	$membro_atual = new Membro();
	$membro_atual->Get($conexao, $_SESSION['id_membro'] );

    if(isset($_POST['update-membro'])){

    	$controle_db = new ControleDB($conexao);

    	$membro_atual->nome    	 = $_POST["mb_nome"];
    	$membro_atual->apelido 	 = $_POST["mb_alias"]; 
    	$membro_atual->cor     	 = $_POST["mb_cor"];
    	$membro_atual->cor2      = $_POST["mb_cor2"];
    	$membro_atual->cor3      = $_POST["mb_cor3"];
    	$membro_atual->manifesto = $_POST["mb_manifesto"];

       	if (!empty($_FILES['mb_img'])) {

            $extensao = '.' . pathinfo($_FILES['mb_img']['name'], PATHINFO_EXTENSION);

            do {
                $filename = md5(microtime() . $_FILES['mb_img']['name']) . $extensao;
            } while (file_exists($filename));

       		if(move_uploaded_file($_FILES['mb_img']['tmp_name'], $uploadDir . $filename))
       			$membro_atual->foto = $filename;
       	}

    	if($membro_atual->email != $_POST["mb_email"]){

	    	if($controle_db->VerificaRegistro("email", $_POST["mb_email"], "ginga3_membros") == 0){
		    	$membro_atual->email = $_POST["mb_email"]; 
		    }else{
		    	$msm = "<div class='focos'><p class='the-border'>Este E-mail j&aacute; foi utilizado. Por este motivo n&atilde;o foi alterado.</p></div>";
		    }
		}else   
		
		if($membro_atual->Alterar($conexao)){ 
			$msm = "<div class='focos'><p class='the-border'>Dados alterados com sucesso.</p></div>"; 
		}
    }
?>

<!DOCTYPE HTML>
<html lang="pt-br">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title><?php echo "Ginga | ".$membro_atual->apelido; ?></title>
	<script src="js/jquery.js"></script>
	<script src="js/jquery.validate.js"></script>
	<script src="js/global.js"></script>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="shortcut icon" href="img/ico.ico" />
	<style>

		.act:hover { background-color: <?php echo $membro_atual->cor; ?>; }
		.act:active{ border: solid 1px <?php echo $membro_atual->cor; ?>; }
		.act{        border: solid 1px <?php echo $membro_atual->cor; ?>; }
		
		.color1{ background-color: <?php echo $membro_atual->cor; ?>;}
		.color2{ background-color: <?php echo $membro_atual->cor2; ?>;}
		.color3{ background-color: <?php echo $membro_atual->cor3; ?>; }
		
		.the-border-color1{ border: solid 1px <?php echo $membro_atual->cor; ?>; }
		.the-border-color2{ border: solid 1px <?php echo $membro_atual->cor2; ?>;}
		.the-border-color3{ border: solid 1px <?php echo $membro_atual->cor3; ?>;}

		.border-color1{ border-color: <?php echo $membro_atual->cor; ?>; }
		.border-color2{ border-color: <?php echo $membro_atual->cor2; ?>;}
		.border-color3{ border-color: <?php echo $membro_atual->cor3; ?>;}

		.box-color1{ border-radius: 5px; box-shadow: 0 0 12px <?php echo $membro_atual->cor; ?>; }
		.box-color2{ border-radius: 5px; box-shadow: 0 0 12px <?php echo $membro_atual->cor2; ?>; }
		.box-color3{ border-radius: 5px; box-shadow: 0 0 12px <?php echo $membro_atual->cor3; ?>; }
		
		.text-color1{ color: <?php echo $membro_atual->cor; ?>; }
		.text-color2{ color  <?php echo $membro_atual->cor2; ?>; }
		.text-color3{ color: <?php echo $membro_atual->cor3; ?>; }

		.ls-2{
			margin: auto;
			margin-top: 10%;
			display: block;
			width: 300px;
		}
		.focos{ top: 6px; }
		.bt-sk2{
			height: 5px;
			line-height: 7px;
		}
		.ls-2>ul>li>a>img{
			width: 80px;
			padding: 0;
		}
		body>section{
			width: 640px;
			height: 480px;
			position: absolute;
			padding: 34px;
		}
		body>section input[type="text"]{
			width: 99%;
		}
		body>section footer p{
			font-size: 12px;
		}
		body>section img{
			margin: auto;
			display: block;
		}
		body>section article{
			float: left;
			overflow: auto;
			height: 100%
		}
		body>section article footer>a{
			list-style: none;
			text-align: center;
			padding-top: 10px;
			padding-bottom: 10px;
		}
		body>section article footer>a:visited{
			color: #000;
		}
		body>section article .bt,
		body>section article .bt-sk2{
			float: right;
			margin-top: 30px;
			margin-left: 10px;
		}
		header>img{
			padding: 5px;
		}
		h1{ display: none; }
	</style>
</head>
<body class="color1">

	<?php echo $msm; ?>

	<header>
		<img src="img/ginga_logo.png" width="120px">
		<h1>Ginga 3.0</h1>
	</header>
	
	<section class="in-center box-padrao color2">
		
		<article class="wspan6 toLeft box-color3 the-border-color2" style="margin-left: -13px; padding: 5px;">
			<header>
				<h2><?php echo $membro_atual->apelido; ?></h2>
				<img src="<?php echo $uploadUrl.$membro_atual->foto; ?>" class="color1" style="display: " height="144px" width="108px">
			</header>
			<section>

				<p>Nome: <?php echo $membro_atual->nome; ?></p>
				<p>Membro de desde: <?php echo $membro_atual->data; ?></p>
				<p>Manifesto:</p>
				<p style="padding: 10px; padding-left: 30px; width: 74%; display: block; margin: auto; margin-bottom: 8px;" class="color1">"<?php echo $membro_atual->manifesto; ?>"</p>

			</section>
			<footer>
				<a class="act" id="ed-perfil" href="#">Editar dados pessoais</a>
			</footer>
		</article>

		<article class="wspan6 toRight">
			<header>
				<span style="padding-left: 10px;">Selecione o projeto e continue...</span>
			</header>
			<div class="ls-2 box-color color3">
				<header>
					<h2>Projetos</h2>
				</header>
				<ul>
					<?php 
						$qry = "
							SELECT p.* FROM ginga3_projetos p
							INNER JOIN ginga3_membros_projetos mp ON mp.id_projeto = p.id
							WHERE mp.id_membro = '{$membro_atual->id}'
						;"; 
						$ls  = mysql_query($qry, $conexao);  
					?>
					<?php while($projeto = mysql_fetch_array($ls)): ?>
						<li><a  pjId="<?php echo $projeto["id"];  ?>" class="act" href="#"><p><?php echo $projeto["nome"];  ?></p><img src="<?php echo $uploadUrl.$projeto["img"];  ?>" alt="#"></a></li>
					<?php endwhile; ?>
				</ul>
			</div>
			<footer>
				<input type="button" id="sair" class="bt color1" value="Sair">
				<?php if($membro_atual->IsGerente($conexao)): ?>
					<a href="Gen.php" class="bt-sk2 color1">Gerenciar</a>
				<?php endif; ?>
			</footer>
		</article>
	</section>
	
	<div class="hidden">
		<textarea id="mb-preferences">

			<div class="edit">
				<div class="ed-img">
				    <p>Foto:</p>
				    <a href="#"><img class="color1" src="<?php echo $uploadUrl.$membro_atual->foto; ?>" height="216px" width="162px"></a>
				    <label>
				        <input type="file" name="mb_img" onchange="readIMG(this);"/>
				        <input type="button" class="bt color1" value="Selecionar">
				    </label>
				</div>
				<p style="position: relative;">Cor de Tema:</p>
				<input owner="color1" left="50px" type="button" value="<?php echo $membro_atual->cor; ?>" class="ed-nt-color"><input type="text" class="hidden" value="<?php echo $membro_atual->cor; ?>" name="mb_cor">
				<input owner="color2" left="89px" type="button" value="<?php echo $membro_atual->cor2; ?>" class="ed-nt-color"><input type="text" class="hidden" value="<?php echo $membro_atual->cor2; ?>" name="mb_cor2">
				<input owner="color3" left="128px" type="button" value="<?php echo $membro_atual->cor3; ?>" class="ed-nt-color"><input type="text" class="hidden" value="<?php echo $membro_atual->cor3; ?>" name="mb_cor3">
				<p>Nome:</p><input type="text" value="<?php echo $membro_atual->nome;?>" name="mb_nome">
				<p>Apelido:</p><input type="text" value="<?php echo $membro_atual->apelido; ?>" name="mb_alias">
				<p>E-mail:</p><input type="email" value="<?php echo $membro_atual->email; ?>" name="mb_email">
				<p>Manifesto:</p><textarea rows="5" name="mb_manifesto"><?php echo $membro_atual->manifesto; ?></textarea>
			</div>
		</textarea>
	</div>

	<footer>
		<p>Ginga 3.0</p>
	</footer>

	<div id="new-color"></div>

	<!-- Forms -->
	<script>

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

				$("body").append('<article class="fm-padrao color1 border-color1"> <header> <h2>Title</h2> <div class="buttons-area"> <input type="button" class="bt-fechar color"> <input type="button" class="bt-minimizar"> </div> </header> <section> </section> <footer> <input type="button" id="save" class="bt" value="Salvar"> <input type="button" id="cancel" class="bt-sk2" value="Cancelar"> </footer> </article>');
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

			$("body").append('<article class="fm-media"> <header> <h2>Title</h2> <div class="buttons-area"> <input type="button" class="bt-fechar color"> </div> </header> <section> </section> <footer> <input class="bt-next color" type="button" id="next" style="float: right"> <input class="bt-add"  type="button" id="add"  style="float: right"> <input class="bt-prev color" type="button" id="prev" style="float: left"> </footer> </article>');
			
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

			$("body").append('<article class="fm-chat"> <header> <h2>Nome do Maluco</h2> <div class="buttons-area"> <input class="bt-fechar" type="button" > <input class="bt-minimizar" type="button" > </div> </header> <section> <ul>  </ul> </section> <footer> <textarea id="send"></textarea> </footer> </article>');
			
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
	</script>

	<!-- Local Itens -->
	<script>

		$(document).ready(function() {
			
			var fm_padrao = new FormPadrao();

			$(".focos").css("opacity", 0);
			$(".focos").animate(
				{opacity: 1},
				500,
				function(){
					setTimeout(function(){
						$(".focos").animate(
							{opacity: 0},
							500,
							function(){ $(this).css("display", none) }
						);
					}, 3000);
				}
			);

			$("#ed-perfil").click(function(){

				fm_padrao.Open({
						title:  "Preferencias",
						data:   $("#mb-preferences").val(),
						move: true,
						height: 540,
						submit: true,
						save_name: "update-membro"
				});

				$('form').submit(function(event){
					var erro = false;

					if(erro){
						$("section").animate({scrollTop: 0}, 500);
						event.preventDefault();
					}
					else
						return;
				});

				if($(".ed-nt-color").length > 0){
				
					var index = $(".ed-nt-color").index(this);
					
					$("body").append("<style> .ed-nt-color{ background: none; border: solid 5px #303030; border-radius: 5px; width: 30px; height: 30px; margin: 0; } .nt-color{ box-shadow: 1px 1px 5px; display: table; position: absolute; z-index: 9999; border-radius:5px 5px 5px 5px; overflow: hidden; border: solid 5px #303030; } .nt-color>div{ width: 282px; background-color: #505050; overflow: hidden; display: table; box-shadow: 0 0 15px inset; position: relative; } .nt-color>div>*{ float: left; } .nt-color>div>.conf{ display: block; width: 10px; margin-left: 5px; margin-right: 5px; position: relative; border: solid 1px #303030; height: 127.5px; } .nt-color>div>.conf>div{ position: absolute; bottom: 0; width: 10px; display: block; border-top: solid 1px #000; } .nt-color>div>.conf>div>div{ display: block; height: 1px; background-color: #fff; width: 16px; margin-left: -4px; border: solid 1px; margin-top: -2px; } .nt-color #primary-colors{ width: 51px; margin: 3px; } .nt-color #primary-colors>div{ width: 24px; height: 24px; float: left; margin-top: 1px; margin-left: 1px; box-shadow: 0 0 5px #000 inset; } .nt-color #intencao{ margin-left: 10px; margin-right: 10px; background-color: #000; box-shadow: 0 0 8px #808080 inset; } .nt-color #intencao>div{ box-shadow: 0 0 8px inset; background-color: #FFF; } .nt-color #r>div{ background-color: #FF0000; } .nt-color #g>div{ background-color: #00FF00; } .nt-color #b>div{ background-color: #0000FF; } .nt-color .view, .nt-color .at{ float: none; position: absolute; width: 60px; height: 40px; border: solid 5px #303030; border-radius: 5px; margin-right: 5px; margin-top: 5px; right: 5px; }.nt-color .at{ top: 45px; border-top: none; border-top-left-radius: 0; border-top-right-radius: 0; }.nt-color .view{ border-bottom-left-radius: 0; border-bottom-right-radius: 0; } .nt-color .view{ border-bottom: none; border-bottom-right-radius: 0; border-bottom-left-radius: 0; } .nt-color #bt-ok{ background:none; position: absolute; bottom: 0; right: 0; width: 30px; margin-right: 25px; margin-bottom: 8px; border: solid 1px #FFFFFF; border-radius: 3px; background-color: #FFF; } .nt-color #bt-ok:hover{ background-color: rgba( 255, 255, 255, 0.5); } .nt-color #bt-ok:active{ background-color: #303030; } .nt-color p{ margin: 0; margin-top: 12px; margin-right: 5px; } .nt-color p>input{ width: 22px; background: none; border: solid 1px #303030; } </style>");
					$(".ed-nt-color").parent().append("<div class='nt-color'> <div> <div id='primary-colors'> <div style='background-color: rgb(255, 255, 255);' R='255' G='255' B='255'></div> <div style='background-color: rgb(255,   0,   0);' R='255' G='0'   B='0'></div> <div style='background-color: rgb(  0, 255,   0);' R='0'   G='255' B='0'></div> <div style='background-color: rgb(  0,   0, 255);' R='0'   G='0'   B='255'></div> <div style='background-color: rgb(255, 255,   0);' R='255' G='255' B='0'></div> <div style='background-color: rgb(  0, 255, 255);' R='0'   G='255' B='255'></div> <div style='background-color: rgb(255,   0, 255);' R='255' G='0'   B='255'></div> <div style='background-color: rgb(  0,   0,   0);' R='0'   G='0'   B='0'></div>  <div style='background-color: rgb(255, 127,   0);' R='255' G='127' B='0'></div> <div style='background-color: rgb(127, 127, 255);' R='127' G='127' B='255'></div> </div> <div class='conf' id='intencao'><div style='height: 63.5px;'><div></div></div></div> <div class='conf' id='r'><div style='height: 127.5px;'><div></div></div></div> <div class='conf' id='g'><div style='height: 127.5px;'><div></div></div></div> <div class='conf' id='b'><div style='height: 127.5px;'><div></div></div></div> <div> <p>R:<input id='inputR' type='text'></p> <p>G:<input id='inputG' type='text'></p> <p>B:<input id='inputB' type='text'></p> </div> <div style='background-color: rgb(255, 255, 255);' R='255' G='255' B='255' class='view'></div> <div style='background-color: rgb(255, 255, 255);' R='255' G='255' B='255' class='at'></div> <input type='button' class='bt' value='Ok' id='bt-ok'> </div> </div>");
					
					$(".nt-color").css("display", "none");

					$(".ed-nt-color").each(function(){
						$(this).css("background-color", $(this).val());
						$(this).css("color", $(this).val());
					});				

					$(".ed-nt-color").click(function(){
						index = $(".ed-nt-color").index(this);

						$(".ed-nt-color").css("border-top-left-radius", "5px");
						$(".ed-nt-color").css("border-top-right-radius", "5px");
						$(".ed-nt-color").css("border-bottom-right-radius", "5px");
						$(".ed-nt-color").css("border-bottom-left-radius", "5px");

						if( $(".nt-color").css("display") == "table"){
							$(this).css("border-top-left-radius", "5px");
							$(this).css("border-top-right-radius", "5px");
							$(this).css("border-bottom-right-radius", "5px");
							$(this).css("border-bottom-left-radius", "5px");
							$(this).css("box-shadow", "");
							$(".nt-color").hide(10);	
							return;
						};
						
						$(".nt-color").css("top", 280 );
						$(".nt-color").css("left", $(this).attr("left"));

						$(this).css("border-top-left-radius", "5px");
						$(this).css("border-top-right-radius", "0px");
						$(this).css("border-bottom-right-radius", "0px");
						$(this).css("border-bottom-left-radius", "5px");
						$(this).css("box-shadow", "0 0 5px #000");
						 
						$(".nt-color").show();
						$(".nt-color input").focus();				

						$(".nt-color .at").css("background-color", $(this).val());
						 
						var str = "";
						var start = 0;
						var end = 0;

						str = $(".nt-color .at").css("background-color");
						start = str.indexOf("(")+1;
						end = str.indexOf(",");

						end = end - start;

						var sR = str.substr(start, end);
						str = str.substr( str.indexOf(",") + 1);
						var sG = str.substr(0,str.indexOf(","));
						str = str.substr( str.indexOf(",") + 1);
						str = str.substr( 0, str.length - 1);
						var sB = str;
						
						$(".nt-color .view").css("background-color", $(this).val());
						$(".nt-color .view").attr("R", parseInt(sR));
						$(".nt-color .view").attr("G", parseInt(sG));
						$(".nt-color .view").attr("B", parseInt(sB));

						$("#r").children("div").height( parseInt(sR)/2 );				
						$("#g").children("div").height( parseInt(sG)/2 );				
						$("#b").children("div").height( parseInt(sB)/2 );
						$("#intencao").children("div").height(63.5);

						$("#inputR").val(parseInt(sR)); $("#inputG").val(parseInt(sG)); $("#inputB").val(parseInt(sB)); 	
					});

					$("#bt-ok").click(function(){
						$(".nt-color").hide();
						
						$(".ed-nt-color").eq(index).css("border-top-left-radius", "5px");
						$(".ed-nt-color").eq(index).css("border-top-right-radius", "5px");
						$(".ed-nt-color").eq(index).css("border-bottom-right-radius", "5px");
						$(".ed-nt-color").eq(index).css("border-bottom-left-radius", "5px");
						$(".ed-nt-color").eq(index).css("box-shadow", "");
						
						$(".ed-nt-color").eq(index).val( $(".nt-color .view").css("background-color") );
						$(".ed-nt-color").eq(index).css("background-color", $(".ed-nt-color").eq(index).val());
						$(".ed-nt-color").eq(index).css("color", $(".ed-nt-color").eq(index).val());

						$("input[name='mb_cor']").val($(".ed-nt-color").eq(0).val());
						$("input[name='mb_cor2']").val($(".ed-nt-color").eq(1).val());
						$("input[name='mb_cor3']").val($(".ed-nt-color").eq(2).val());
						
						$("#new-color").html("");
						$(".ed-nt-color").each(function(index){
							if($(this).attr("owner"))
								$("#new-color").append("<style> ."+$(this).attr("owner")+"{ background-color: "+$(this).val()+";} .the-border-"+$(this).attr("owner")+"{ border: solid 1px "+$(this).val()+"; } .border-"+$(this).attr("owner")+"{ border-color: "+$(this).val()+"; } .box-"+$(this).attr("owner")+"{ border-radius: 5px; box-shadow: 0 0 12px "+$(this).val()+"; } <style>");
						});
					});

					$("#inputR, #inputG, #inputB").keyup(function(e){
						if(parseInt($(this).val()) > 255) $(this).val("255");
						if($(this).val() == "") $(this).val("0");

						$(".nt-color .view").attr("R", parseInt($("#inputR").val()));
						$(".nt-color .view").attr("G", parseInt($("#inputG").val()));
						$(".nt-color .view").attr("B", parseInt($("#inputB").val()));

						$("#r").children("div").height( parseInt($("#inputR").val())/2 );				
						$("#g").children("div").height( parseInt($("#inputG").val())/2 );				
						$("#b").children("div").height( parseInt($("#inputB").val())/2 );
						$("#intencao").children("div").height(63.5);

						$(".nt-color .view").css("background-color", "rgb("+ parseInt($("#inputR").val())+","+parseInt($("#inputG").val())+","+parseInt($("#inputB").val())+")");
						
						if(
							e.which >= 48 && e.which <= 57
						)
							$(this).val(parseInt($(this).val()));					
					});
					$("#inputR, #inputG, #inputB").keydown(function(e){
						var text = $(this).val();
						//alert(e.which);
						
						if(
							e.which == 37 ||
							e.which == 39 || 
							e.which ==  8 || 
							e.which ==  9 || 
							e.which == 46 ||
							e.which == 116 
						) return true;

						if(e.which == 38){
							$(this).val(parseInt($(this).val()) + 1); 
							if(parseInt($(this).val()) > 255) $(this).val("255");
							$(".nt-color .view").css("background-color", "rgb("+ parseInt($("#inputR").val())+","+parseInt($("#inputG").val())+","+parseInt($("#inputB").val())+")");
							$("#r").children("div").height( parseInt($("#inputR").val())/2 );				
							$("#g").children("div").height( parseInt($("#inputG").val())/2 );				
							$("#b").children("div").height( parseInt($("#inputB").val())/2 );
							$("#intencao").children("div").height(63.5);
							return true;
						}
						if(e.which == 40){
							$(this).val(parseInt($(this).val()) - 1); 
							if(parseInt($(this).val()) < 0) $(this).val("0");
							$(".nt-color .view").css("background-color", "rgb("+ parseInt($("#inputR").val())+","+parseInt($("#inputG").val())+","+parseInt($("#inputB").val())+")");
							$("#r").children("div").height( parseInt($("#inputR").val())/2 );				
							$("#g").children("div").height( parseInt($("#inputG").val())/2 );				
							$("#b").children("div").height( parseInt($("#inputB").val())/2 );
							$("#intencao").children("div").height(63.5);
							return true;
						}

						if(
							e.which < 48 || 
							e.which > 57
						) return false;

						if(text.length == 3) return false;
					});

					$(".nt-color #primary-colors>div").click(function(){
						$(".nt-color .view").css("background-color", $(this).css("background-color") );
						
						$(".nt-color .view").attr("R", $(this).attr("R"));
						$(".nt-color .view").attr("G", $(this).attr("G"));
						$(".nt-color .view").attr("B", $(this).attr("B"));

						$("#intencao").children("div").height(63.5);				
						$("#r").children("div").height( $(this).attr("R")/2 );				
						$("#g").children("div").height( $(this).attr("G")/2 );				
						$("#b").children("div").height( $(this).attr("B")/2 );

						$("#inputR").val($(this).attr("R")); $("#inputG").val($(this).attr("G")); $("#inputB").val($(this).attr("B"));				
					});

					$("#intencao").mousedown(function(e){
						
						var init_R = $(".nt-color .view").attr("r");
						var init_G = $(".nt-color .view").attr("g");
						var init_B = $(".nt-color .view").attr("b");
						var conf = $(this);

						var R = 0, G = 0, B = 0;

						var value = e.pageY - getTop(this);
						$("#intencao").children("div").height($("#intencao").height() - value);
						
						if(value > $("#intencao").height()/2){
							R = parseInt( $("#intencao").children("div").height() * (init_R/($("#intencao").height()/2)) );
							G = parseInt( $("#intencao").children("div").height() * (init_G/($("#intencao").height()/2)) );
							B = parseInt( $("#intencao").children("div").height() * (init_B/($("#intencao").height()/2)) );
						}else{
							R = 255 - parseInt( (($("#intencao").height()/2)-($("#intencao").children("div").height()-($("#intencao").height()/2))) * ((255-init_R)/($("#intencao").height()/2)) );
							G = 255 - parseInt( (($("#intencao").height()/2)-($("#intencao").children("div").height()-($("#intencao").height()/2))) * ((255-init_G)/($("#intencao").height()/2)) );
							B = 255 - parseInt( (($("#intencao").height()/2)-($("#intencao").children("div").height()-($("#intencao").height()/2))) * ((255-init_B)/($("#intencao").height()/2)) );
						}

						$("#r").children("div").height(R/2);
						$("#g").children("div").height(G/2);
						$("#b").children("div").height(B/2);
			
						$("#inputR").val(R); $("#inputG").val(G); $("#inputB").val(B); 			
						$(".nt-color .view").css("background-color", "rgb("+R+","+G+","+B+")");

						$(window).mousemove(function(e){

							var value = e.pageY - getTop(conf);

							if($("#intencao").height() - value > $("#intencao").height() ){	value = 0.5; } 
							if($("#intencao").height() - value < 0 ){ value = $("#intencao").height(); }

							$("#intencao").children("div").height($("#intencao").height() - value);
							
							if(value > $("#intencao").height()/2){
								R = parseInt( $("#intencao").children("div").height() * (init_R/($("#intencao").height()/2)) );
								G = parseInt( $("#intencao").children("div").height() * (init_G/($("#intencao").height()/2)) );
								B = parseInt( $("#intencao").children("div").height() * (init_B/($("#intencao").height()/2)) );
							}else{
								R = 255 - parseInt( (($("#intencao").height()/2)-($("#intencao").children("div").height()-($("#intencao").height()/2))) * ((255-init_R)/($("#intencao").height()/2)) );
								G = 255 - parseInt( (($("#intencao").height()/2)-($("#intencao").children("div").height()-($("#intencao").height()/2))) * ((255-init_G)/($("#intencao").height()/2)) );
								B = 255 - parseInt( (($("#intencao").height()/2)-($("#intencao").children("div").height()-($("#intencao").height()/2))) * ((255-init_B)/($("#intencao").height()/2)) );
							}

							$("#r").children("div").height(R/2);
							$("#g").children("div").height(G/2);
							$("#b").children("div").height(B/2);

							$("#inputR").val(R); $("#inputG").val(G); $("#inputB").val(B);
							$(".nt-color .view").css("background-color", "rgb("+R+","+G+","+B+")");
						});

						$(window).mouseup(function(){

							$(".nt-color .view").attr("R", R);
							$(".nt-color .view").attr("G", G);
							$(".nt-color .view").attr("B", B);

							$(window).unbind("mousemove");
						});

						return false;
					});
					$("#r").mousedown(function(e){
						
						var init_R = $(".nt-color .view").attr("r");
						var init_G = $(".nt-color .view").attr("g");
						var init_B = $(".nt-color .view").attr("b");
						var R = init_R, G = init_G, B = init_B;
						var conf = $(this);
						var value = e.pageY - getTop(this);
						
						conf.children("div").height($("#intencao").height() - value);
						init_R = parseInt( conf.children("div").height() * 2);

						$("#inputR").val(init_R); $("#inputG").val(init_G); $("#inputB").val(init_B);
						$(".nt-color .view").css("background-color", "rgb("+init_R+" ,"+init_G+" ,"+init_B+")");

						$(".nt-color .view").attr("r", init_R);
						$(".nt-color .view").attr("g", init_G);
						$(".nt-color .view").attr("b", init_B);

						R = init_R; 
						G = init_G; 
						B = init_B;

						$("#intencao").children("div").height(63.5);

						$(window).mousemove(function(e){
							
							var value = e.pageY - getTop(conf);

							if($("#intencao").height() - value > $("#intencao").height() ){	value = 0.5; } 
							if($("#intencao").height() - value < 0 ){ value = $("#intencao").height(); }

							conf.children("div").height( $("#intencao").height() - value );

							R = parseInt( conf.children("div").height() * 2);

							$("#inputR").val(R); $("#inputG").val(G); $("#inputB").val(B);
							$(".nt-color .view").css("background-color", "rgb("+R+" ,"+G+" ,"+B+")");

						});

						$(window).mouseup(function(){
							
							$(".nt-color .view").attr("R", R);
							$(".nt-color .view").attr("G", G);
							$(".nt-color .view").attr("B", B);
							$("#intencao").children("div").height(63.5);

							$(this).unbind("mousemove");
							$(this).unbind("mouseup");
						});

						return false;
					});
					$("#g").mousedown(function(e){
						
						var init_R = $(".nt-color .view").attr("r");
						var init_G = $(".nt-color .view").attr("g");
						var init_B = $(".nt-color .view").attr("b");
						var R = init_R, G = init_G, B = init_B;
						var conf = $(this);
						var value = e.pageY - getTop(this);
						
						conf.children("div").height($("#intencao").height() - value);
						init_G = parseInt( conf.children("div").height() * 2);

						$("#inputR").val(init_R); $("#inputG").val(init_G); $("#inputB").val(init_B);
						$(".nt-color .view").css("background-color", "rgb("+init_R+" ,"+init_G+" ,"+init_B+")");

						$(".nt-color .view").attr("r", init_R);
						$(".nt-color .view").attr("g", init_G);
						$(".nt-color .view").attr("b", init_B);

						R = init_R; 
						G = init_G; 
						B = init_B;

						$("#intencao").children("div").height(63.5);

						$(window).mousemove(function(e){
							
							var value = e.pageY - getTop(conf);

							if($("#intencao").height() - value > $("#intencao").height() ){	value = 0.5; } 
							if($("#intencao").height() - value < 0 ){ value = $("#intencao").height(); }

							conf.children("div").height( $("#intencao").height() - value );

							G = parseInt( conf.children("div").height() * 2);

							$("#inputR").val(R); $("#inputG").val(G); $("#inputB").val(B);
							$(".nt-color .view").css("background-color", "rgb("+R+" ,"+G+" ,"+B+")");

						});

						$(window).mouseup(function(){
							
							$(".nt-color .view").attr("R", R);
							$(".nt-color .view").attr("G", G);
							$(".nt-color .view").attr("B", B);
							$("#intencao").children("div").height(63.5);

							$(this).unbind("mousemove");
							$(this).unbind("mouseup");
						});

						return false;
					});
					$("#b").mousedown(function(e){
						
						var init_R = $(".nt-color .view").attr("r");
						var init_G = $(".nt-color .view").attr("g");
						var init_B = $(".nt-color .view").attr("b");
						var R = init_R, G = init_G, B = init_B;
						var conf = $(this);
						var value = e.pageY - getTop(this);
						
						conf.children("div").height($("#intencao").height() - value);
						init_B = parseInt( conf.children("div").height() * 2);

						$("#inputR").val(init_R); $("#inputG").val(init_G); $("#inputB").val(init_B);
						$(".nt-color .view").css("background-color", "rgb("+init_R+" ,"+init_G+" ,"+init_B+")");

						$(".nt-color .view").attr("r", init_R);
						$(".nt-color .view").attr("g", init_G);
						$(".nt-color .view").attr("b", init_B);

						R = init_R; 
						G = init_G; 
						B = init_B;

						$("#intencao").children("div").height(63.5);

						$(window).mousemove(function(e){
							
							var value = e.pageY - getTop(conf);

							if($("#intencao").height() - value > $("#intencao").height() ){	value = 0.5; } 
							if($("#intencao").height() - value < 0 ){ value = $("#intencao").height(); }

							conf.children("div").height( $("#intencao").height() - value );

							B = parseInt( conf.children("div").height() * 2);

							$("#inputR").val(R); $("#inputG").val(G); $("#inputB").val(B);
							$(".nt-color .view").css("background-color", "rgb("+R+" ,"+G+" ,"+B+")");

						});

						$(window).mouseup(function(){
							
							$(".nt-color .view").attr("R", R);
							$(".nt-color .view").attr("G", G);
							$(".nt-color .view").attr("B", B);
							$("#intencao").children("div").height(63.5);

							$(this).unbind("mousemove");
							$(this).unbind("mouseup");
						});

						return false;
					});
				}
			});

			$(".ls-2>ul>li>a").click(function(){
				
				$.ajax({  
					type: 'GET',
					url: 'actions.php',
					data: {"entrar-projeto":true, "id_projeto": $(this).attr("pjId") },
					success: function( data )  
					{  
						if (data != 0)	
						{
							$(window.document.location).attr('href','descktop.php');
						}
						else
						{
							alert('Ocoreu um ERRO!');
						}
					}
				});
			});

			$('#sair').unbind("click").click(function(){		
				$.ajax({  
					type: 'GET',
					url: 'actions.php',
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
		});
	</script>

	<!-- Actions Itens -->
	<script>
		function readIMG(input) { 
			if (input.files && input.files[0]) { 	
				var reader = new FileReader();  	
				reader.onload = function (e) { 	
					$(input).parent().parent().find("img") 	
					.attr('src', e.target.result); 	
				};  	
				reader.readAsDataURL(input.files[0]); 	
			} 	
		}
	</script>
	
</body>

</html>
