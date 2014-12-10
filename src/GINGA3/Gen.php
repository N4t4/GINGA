<?php  
	require_once("includes/conexao.php"); 
	include("includes/Myclasses.php");
	global $conexao;
	session_start(); 

	if(!$_SESSION['sessao']) header("Location: default.php");

	$msm = "";
	$membro_atual  = new Membro();
	$projeto_atual = new Projeto(); 
	$controle_db   = new ControleDB($conexao);

	if(isset($_SESSION["id_membro"])){	
		$membro_atual->Get($conexao, $_SESSION['id_membro'] );
	}
	
	if($_SESSION["id_projeto"] == null){
		$qry = "SELECT id FROM ginga3_projetos LIMIT 1 ;";
		$resultado  = mysql_query($qry, $conexao);
		$linha = mysql_fetch_array($resultado);					
		$_SESSION["id_projeto"] =  $linha["id"];
	}
	$projeto_atual->Get($conexao, $_SESSION['id_projeto'] );
	
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

    if(isset($_POST['update-projet'])){

    	$projeto_atual->nome      = $_POST['pj_nome'];
    	$projeto_atual->descricao = $_POST['pj_desc'];

      	if (!empty($_FILES['pj_img'])) {

            $extensao = '.' . pathinfo($_FILES['pj_img']['name'], PATHINFO_EXTENSION);

            do {
                $filename = md5(microtime() . $_FILES['pj_img']['name']) . $extensao;
            } while (file_exists($filename));

       		if(move_uploaded_file($_FILES['pj_img']['tmp_name'], $uploadDir . $filename))
       			$projeto_atual->img = $filename;
       	}

       	if($projeto_atual->Alterar($conexao)){
	    	$msm = "<div class='focos'><p class='the-border'>Projeto Alterado com sucesso.</p></div>";
       	} else {
       		$msm = "<div class='focos'><p class='the-border'>Ocorreu um erro, n&atilde;o foi poss&iacute;vel adicionar novo Projeto.</p></div>";
       	}
    }

    if(isset($_POST['new-projet'])){

    	$novo_projeto = new Projeto();
    	$novo_projeto->nome      = $_POST['pj_nome'];
    	$novo_projeto->descricao = $_POST['pj_desc'];
    	$novo_projeto->img       = "default2.png";

      	if (!empty($_FILES['pj_img'])) {

            $extensao = '.' . pathinfo($_FILES['pj_img']['name'], PATHINFO_EXTENSION);

            do {
                $filename = md5(microtime() . $_FILES['pj_img']['name']) . $extensao;
            } while (file_exists($filename));

       		if(move_uploaded_file($_FILES['pj_img']['tmp_name'], $uploadDir . $filename))
       			$novo_projeto->img = $filename;
       	}

       	if($novo_projeto->Inserir($conexao)){
	    	$msm = "<div class='focos'><p class='the-border'>Novo Projeto Adicionado com sucesso.</p></div>";
       	} else {
       		$msm = "<div class='focos'><p class='the-border'>Ocorreu um erro, n&atilde;o foi poss&iacute;vel adicionar novo Projeto.</p></div>";
       	}

       	$_SESSION["id_projeto"] = $novo_projeto->id;
       	$projeto_atual->Get($conexao, $_SESSION['id_projeto'] );
    }

   	if(isset($_POST['new-tarefa'])){

    	$nova_tarefa = new Tarefa();
    	$nova_tarefa->nome       = $_POST['tf_nome'];
    	$nova_tarefa->descricao  = $_POST['tf_desc'];
    	$nova_tarefa->id_projeto = $projeto_atual->id;

       	if($nova_tarefa->Inserir($conexao)){
	    	$msm = "<div class='focos'><p class='the-border'>Nova Tarefa criada com sucesso.</p></div>";
       	} else {
       		$msm = "<div class='focos'><p class='the-border'>Ocorreu um erro, n&atilde;o foi poss&iacute;vel adicionar nova Tarefa.</p></div>";
       	}
    }

    if(isset($_POST['add-arquivo'])){

    	$controle_db = new ControleDB($conexao);

    	$arq_nome  = "";
    	$arq_local = "";

      	if (!empty($_FILES['the_arq'])) {

            $extensao = '.' . pathinfo($_FILES['the_arq']['name'], PATHINFO_EXTENSION);
            $arq_nome = $_FILES['the_arq']['name'];
            do {
                $filename = md5(microtime() . $_FILES['the_arq']['name']) . $extensao;
            } while (file_exists($filename));

       		if(move_uploaded_file($_FILES['the_arq']['tmp_name'], $uploadDir . $filename))
       			$arq_local = $filename;
       	}

       	if($controle_db->Tarefas->InserirAquivo( $arq_nome, $arq_local,  $_POST['id_tarefa'] ))
			$msm = "<div class='focos'><p class='the-border'>Arquivo inserido.</p></div>";
		else
			$msm = "<div class='focos'><p class='the-border'>Ocoreu um erro n&atilde;o foi poss&iacutevel inserir arquivo.</p></div>";
    }
?>

<!DOCTYPE HTML>
<html lang="pt-br">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title><?php echo "Ginga | ".$membro_atual->apelido; ?></title>
	<script src="js/jquery.js"></script>
	<script src="js/global.js"></script>
	<script src="js/nt-class.js"></script>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="shortcut icon" href="img/ico.ico" />
	<style>


		.act:hover { background-color: <?php echo $membro_atual->cor; ?>; }
		.act:active{ border: solid 1px <?php echo $membro_atual->cor; ?>; }
		.act{        border: solid 1px <?php echo $membro_atual->cor3; ?>; }
		
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

		.the-border-color1-bolde{ border: solid 4px <?php echo $membro_atual->cor; ?>; }
		.the-border-color2-bolde{ border: solid 4px <?php echo $membro_atual->cor2; ?>; }
		.the-border-color3-bolde{ border: solid 4px <?php echo $membro_atual->cor3; ?>; }
		
		.tarefa ul>li,
		.tarefa-li{
			border-radius: 5px 5px 5px 5px;
			width: 94%;
			margin: auto;
			margin-bottom: 5px;
			min-height: 60px
		}
		.color-text, .text-color{ color: <?php echo $membro_atual->cor; ?>; }
		.the-border-color{ border-color: <?php echo $membro_atual->cor; ?>;	}
		.the-box-color{    box-shadow: 0 0 12px <?php echo $membro_atual->cor; ?>;
		}

		.ls-2>ul{	min-height: 400px; }
		.tarefa a{
			cursor: default;
		}
		
		._atz,	._chat{
			position: absolute;
			top: 84px;
			z-index: 2; 
		}
		._atz{
			left: 0;
		}
		._chat{
			right: 0;
		}
		.fm-membros-state .ls-2 img{
			float: left;
			margin-right: 15px;
		}
		.fm-membros-state .ls-2{
			box-shadow: none;
			margin-top: 0;
		}
		.fm-membros-state .ls-2>ul{
		    min-height: 398px
		}
		.fm-membros-state>section{
			overflow: hidden;
		}
		.ls-noticia>ul{
			max-height: 398px;
		}
		.box-entrada,
		.box-saida{
			margin: 0;
			box-shadow: none;
			width: 340px;
		}
		.box-entrada ul,
		.box-saida ul{
			max-height: initial;
		}

		body>.main>header>h3{
			position:fixed; 
			left: 100px;
			z-index: 99;
			margin: 0;
			margin-left: 10px;
			margin-top: 8px;
		}
		body>.main>section{
			width: 88%;
			height: 500px;
			position: absolute;
			padding: 10px;
		}
		body>.main>section input[type="text"]{
			width: 99%;
		}
		body>.main>section footer p{
			font-size: 12px;
		}
		body>.main>section img{
			margin: auto;
			display: block;
		}
		body>.main>section>article{
			float: left;
		}
		body>.main>section .ls-2>header>h2{
			margin: 0;
			padding-bottom: 10px;
		}
		body>.main>section article footer>a{
			list-style: none;
			text-align: center;
			padding-top: 10px;
			padding-bottom: 10px;
		}
		body>.main>section article footer>a:visited{
			color: #000;
		}
		body>.main>section article .bt{
			float: right;
			bottom: 5px;
			right: 5px;
			position: absolute;
		}
		.ft{
			width: 100%;
			padding-left: 15px;
		}
		body>.main>section>article>.ls-2{
			width: 90%;
		}
		h1{ 
			display: none;
		}
		/*******/
		body{ background-image: url("img/lock.png");}
		body>.main>section{
			padding: 20px; 
			background: inherit;
		}
		.ls-projets{
			width: 100%;
			margin-top: 10%;
			position: relative;
		}
		.ls-projets>header{
			color: #FFF;
			background: inherit;
		}
		.ls-projets .sel-1{
			border-radius: 5px 5px 5px 5px;
			width: 94%;
			height: 30px;
			display: block;
			margin: auto;
			margin-bottom: 5px;
			min-height: 60px;	
		}
		
		.ls-projets .tre-buttons{
			border-radius: 15px 15px 15px 15px;
			position: absolute;
			left: -5px;
			top: 36px;
			padding: 0;
		}
		.ls-projets .tre-buttons>*{
			float: left;
		}
		.ls-descktop{
			position: relative;
			overflow: hidden;	
			display: block;
			margin: auto;
			width: 90%;
			max-height: 87.5%;
			border: none;
			padding: 0;
			border-radius: 3px;
		}
		.ls-descktop>input{
			position: absolute;
			right: 5px;
			border-top-left-radius: 0px;
			border-top-right-radius: 0px;
			border-bottom-right-radius: 5px;
			border-bottom-left-radius: 5px;
			box-shadow: 1px 1px 3px;
		}

		.ls-descktop{
			margin-top: 10%;
		}
		.ls-descktop>ul{
			border: none;
			display: block;
			margin: auto;
			height: 84%
		}

		/*******/
	</style>
</head>
<body class="color1">

	<?php echo $msm; ?>

	<div class="main"></div>

	<div id="load" style="display: none">
		<img src="img/load.gif">
	</div>

	<div id="new-color"></div>

	<!--Nav-Menu-->
	<script>
		function NavMenu1Init(){

			$("#nav-menu-01>ul>li>ul").each(function(){

				$(this).attr("height", $(this).height()+"px" );

				$(this).parent().mouseenter(function(){

					var ul = $(this).children("ul");
					if( ul.attr("animated") ) return;
					ul.attr("animated", true);					
					ul.animate(
						{height: ul.attr("height")},
						200,
						function(){ ul.attr("animated", ""); }
					);		
				});

				$(this).parent().mouseleave(function(){

					var ul = $(this).children("ul");

					ul.animate(
						{height: 0},
						200
					);
				});
			});
			
			$("#nav-menu-01>ul>li>ul").css("height", 0);		
		}
	</script>

	<!-- Global Itens -->
	<script>
		var fm_padrao  = new FormPadrao();
		var fm_padrao2 = new FormPadrao();
		var fm_media   = new FormMedia();
		var fm_media2   = new FormMedia();
	</script>

	<!-- Local Itens -->
	<script>
		function RecaregarTuDo(){

			InitLoad();

			$("main *").css("opacity", 0.5);

			$.ajax({ 
				type: "POST", 
				url: "actions.php", 
				data: {"GET-ALL": true},
				success: function (data) { 
					EndLoad();

					$(".main").html(data);

					NavMenu1Init();
//****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA//
//GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA//
//****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA//
//GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA//
//****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA//
//GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA//
//****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA//

	var location = GetCenterWindow( $(".main>section") );

	$(".main>section").css("top", location.y);
	$(".main>section").css("left", location.x);

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

	$(".focos").css("opacity", 0);
	$(".focos").animate(
		{opacity: 1},
		500,
		function(){
			setTimeout(function(){
				$(".focos").animate(
					{opacity: 0},
					500,
					function(){ $(this).css("display", "none"); }
				);
			}, 3000);
		}
	);
	
	//Speed Menus
	$(".fm-notificao").css( "left", "-272px" );
	$("._atz").unbind("click").click(function(){
		if($(".fm-notificao").css("left") ==  "-272px")
			$(".fm-notificao").animate(
				{left: 0},
				500
			);
		else
			$(".fm-notificao").animate(
				{left: "-272px"},
				500
			);
	});
	$(".fm-membros-state").css( "right", "-272px" );
	$("._chat").unbind("click").click(function(){
		if($(".fm-membros-state").css("right") ==  "-272px")
			$(".fm-membros-state").animate(
				{right: 0},
				500
			);
		else
			$(".fm-membros-state").animate(
				{right: "-272px"},
				500
			);
	});
	//End Speed Menus

	//Mensagens
	if($("#ls-msm>article").length > 0){

		$("#nav-menu-01>ul>#msm .evident").html($("#ls-msm>article").length);
		$("#bt-msm").unbind("click").click(function(){

			if($("#ls-msm>article").length == 0) return;

			var array = new Array();

			$("#ls-msm>article").each(function(index){
				array[index] = new DataView(
					$(this).children("h3").html(), 
					$(this).children("section").html()
				);
			});

			$.ajax({ 
				type: "POST", 
				url: "actions.php", 
				data: {"ok-msm": true, "id": $("#ls-msm>article").attr("msmId")},
				success: function (data) { 
					$("#ls-msm>article").eq(0).remove();	
				} 
			});

			if($("#ls-msm>article").length != 0)
				$("#nav-menu-01>ul>#msm .evident").html($("#ls-msm>article").length);
			else
				$("#nav-menu-01>ul>#msm .evident").html("");
		
			fm_media.Open({
				data:   array,
				next:   function(index){

					$.ajax({ 
						type: "POST", 
						url: "actions.php", 
						data: {"ok-msm": true, "id": $("#ls-msm>article").attr("msmId")},
						success: function (data) { 
							$("#ls-msm>article").eq(0).remove();	
							if($("#ls-msm>article").length != 0)
								$("#nav-menu-01>ul>#msm .evident").html($("#ls-msm>article").length);
							else
								$("#nav-menu-01>ul>#msm .evident").html("");
						} 
					});

				},
				width:  300,
				height: 300
			});
		});
	}
	$("#new-msm").unbind("click").click(function(){

		fm_padrao.Open({
			title:  "Escrever",
			data:   $("#resp-msm").html(),
			save:   function(conteiner){ 
				
				var str = "";
				var start = 0;
				var end = 0;

				var membros = new Array();

				str = $(conteiner).find("#send-to").val();
				do{
					end 	   = str.indexOf(";");

					var membro = str.substr(start, end);
					do{
						membro = membro.substr(start, end).replace(" ","");
					}while(membro.indexOf(" ")!= -1);

					membros[membros.length] = membro;

					str = str.substr( str.indexOf(";") + 1);
				}while(str.indexOf(";") != -1);

				var title    = $(conteiner).find("#msm-title").val();
				var conteudo = $(conteiner).find("#themsm").val();

				$.ajax({  
					type: "POST",  
					url: "actions.php",  
					data: {"membros_email": membros, "send-msm": true, "titulo": title, "conteudo": conteudo}, 
					success: function( data )  
					{	
						if(data == 1){
							FormPadrao_CloseAll();
						}else{
							alert("Erro! tente novamente e verifique os dados da mensagem.");
						}
					}  
				});

			},
			cancel: function(){ alert("cancel"); },
			close:  function(){ FormPadrao_CloseAll(); },
			save_label: "Enviar"
		});

		$(".resp-msm .bt-membros").unbind("click").click(function(){
			
			fm_padrao2.Open({
				data: $("#view-membros").html(),
				move: true,
				title: "Membros"
			});

			DragInit();
		});
	});
	$("#ent-msm").unbind("click").click(function(){
		
		fm_padrao.Open({
			title:  "Entrada",
			data:   $("#entrada-msm").html(),
			move: true,
			height: 425
		});

		$(".box-entrada li").unbind("click").click(function(){
			
			var array = new Array();
			var index = $(this).parent().children("li").index(this);

			$(this).parent().children("li").children("a").each(function(index){
				var data = $(this).children("article").html();
				var name = $(this).children("article").children("h3").html();

				array[index] = new DataView(name, data);
			});

			fm_media.Open({
				data: array,
				width: 300,
				height: 300,
				at: index
			});
		});
	});
	$("#sai-msm").unbind("click").click(function(){
		
		fm_padrao.Open({
			title:  "Saida",
			data:   $("#saida-msm").html(),
			move: true,
			height: 425
		});

		$(".box-saida li").unbind("click").click(function(){

			var fm    = new FormMedia();
			var array = new Array();
			var index = $(this).parent().children("li").index(this);

			$(this).parent().children("li").children("a").each(function(index){
				var data = $(this).children("article").html();
				var name = $(this).children("article").children("h3").html();

				array[index] = new DataView(name, data);
			});

			fm.Open({
				data: array,
				width: 300,
				height: 300,
				at: index
			});
		});
	});
	//End-Mensagens

	//Menu
	$("#mb-conf").unbind("click").click(function(){

		fm_padrao.Open({
				title:  "Preferencias",
				data:   $("#mb-preferences").val(),
				cancel: function(){ FormPadrao_CloseAll(); $("#new-color").html(""); },
				close:  function(){ $("#new-color").html(""); },
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
	$("#the-pjt").unbind("click").click(function(){

		$(".ls-view-membros-in-projeto").html($("#manter-projetos-membros").find(".ls-membros-in-prjeto").html());

		var array = new Array();
		var title = $("#select-projet").find('option:selected').html();

		array[0] = new DataView(title, $("#the-projet").html());
					
		fm_media.Open({
			data:   array,
			width:  480,
			height: 400
		});
	});
	$("#manter-cargos").unbind("click").click(function(){
		
		fm_padrao.Open({
			title:  "Manter Cargos",
			data:   $("#mt-cargos").html(),
			width: 320,
			height: 400					
		});
	});
	$("#add-membros").unbind("click").click(function(){

		fm_padrao.Open({
			title:  "Adicionar Novos Membros",
			data: $("#view-new-membros").html(),
			save: function(conteiner){ 

				var membros = new Array();
				var i       = 0;

				$(conteiner).find('input[type="checkbox"]:checked').each(function(){
					membros[i] = $(this).val();
					i++;
				});
				
				var dados  = {"membros_id":membros, "add-new-membros": true}

				$.ajax({  
					type: "POST",  
					url: "actions.php",  
					data: dados, 
					success: function( data )  
					{
						FormPadrao_CloseAll();
						RecaregarTuDo();
					}  
				});						
			},
			cancel: function(){ FormPadrao_CloseAll() },
			close:  function(){ FormPadrao_CloseAll(); },
			move: true,
			width: 400
		});
		DragInit();
	});
	$("#manter-gerentes").unbind("click").click(function(){
		
		fm_padrao.Open({
			title:  "Manter Gerentes",
			data:   $(".gerentes-membros").html(),
			save: function(conteiner){ 

				var gerentes = new Array();
				var i       = 0;

				$(conteiner).find(".ls-new-gens").children("li").children("a").each(function(){
					gerentes[i] = $(this).attr("mbId");
					i++;
				});
				
				var dados  = {"membros_id":gerentes, "add-gens": true}

				$.ajax({  
					type: "POST",  
					url: "actions.php",  
					data: dados, 
					success: function( data )  
					{
						$(".gerentes-membros").html(data);
						FormPadrao_CloseAll();
					}  
				});

			},
			cancel: function(){ FormPadrao_CloseAll() },
			close:  function(){ FormPadrao_CloseAll(); },
			end_open: function(){ DragInit(); },
			width: 680
		});
	});
	//End-Menu

	//Chat
	$(".fm-membros-state li>a").unbind("click").click(function(){
		var other_id = $(this).attr("MbId");
		var nome     = $(this).children("p").html();
		var my_id    = $("#the-my-id").val();
		var my_fofo  = $("#the-my-foto").val();
		var dialog   = "";
		var link = $(this);

		$.ajax({ 
			type: "POST", 
			url: "actions.php", 
			data: {"chat-get-initial": true, "id_membro": other_id},
			success: function (data) {
			    dialog = data;

				fm_chat = new FormChat({
					name: nome,
					list: dialog,
					send: function(text){ 

						$.ajax({ 
							type: "POST", 
							url: "actions.php", 
							data: {"chat-send": true, "id_membro" : other_id, "conteudo": text},
							success: function (data) {} 
						});

						return "<li class='li_owner'><a href='#'><img class='mb_img' src='"+my_fofo+"'></a>"+text+"</li>";
					},
					color: link.attr("color"),
					mbstyle: link.attr("color"),
					reload: function(){

						$.ajax({ 
							type: "POST", 
							url: "actions.php", 
							data: {"chat-reload": true, "id_membro" : other_id},
							success: function (data) {
								dialog =  data;
							} 
						}); 

						return dialog;
					}
				});
			} 
		});
	});
	//End-Chat

	//Noticias
	$(".ls-noticia>ul>li").unbind("click").click(function(){

		var array = new Array();
		var atual = $(".ls-noticia>ul>li").index(this);

		$(".ls-noticia>ul>li").each(function(index){
			var titulo = $(this).find("h4").html();
			var data   = "<div class='the-noticia'>"+ $(this).children("a").html() + "</div>";

			array[index] = new DataView(titulo, data);

		});

		fm_media.Open({
			data: array,
			width: 400,
			at: atual,
			title: "Not&iacute;cias"
		});
	});
	//End-Noticias

	//News
	$("#add-new-tarefa").unbind("click").click(function(){
		
		var membros = $("#manter-projetos-membros").find(".ls-membros-in-prjeto").html();
		
		fm_padrao.Open({
			title:  "Nova Tarefa",
			data:   $("#edit-tarefas").html(),
			cancel: function(){ FormPadrao_CloseAll() },
			close:  function(){ FormPadrao_CloseAll(); },
			move: true,
			init_open: function(conteiner){
				$(conteiner).find(".edt").remove();
			},
			submit: true,
			save_name: "new-tarefa"
			
		});
	});
	//End-News

	//Projetos OPTs
	$("#edt-pjt").unbind("click").click(function(){
		
		fm_padrao.Open({
			title:  "Editar Projeto",
			data:   $("#edit-projetos").html(),
			cancel: function(){ FormPadrao_CloseAll() },
			close:  function(){ FormPadrao_CloseAll(); },
			move: true,
			submit: true,
			save_name: "update-projet",
			height: 360,
			width: 480
		});
		DragInit();
	});
	$("#new-pjt").unbind("click").click(function(){
		
		var at_img = $("#the-img-projet").attr("src");
		$("#the-img-projet").attr("src", "default2.png");

		fm_padrao.Open({
			title:  "Novo Projeto",
			data:   $("#edit-projetos").html(),
			cancel: function(){ 
				$("#the-img-projet").attr("src", at_img);
				FormPadrao_CloseAll() 
			},
			close:  function(){ 
				$("#the-img-projet").attr("src", at_img);
				FormPadrao_CloseAll(); 
			},
			move: true,
			init_open: function(conteiner){

				$(conteiner).find("input[name='pj_nome']").val("");
				$(conteiner).find("textarea[name='pj_desc']").val("");
				$(conteiner).find("input[name='pj_img']").val("");

			},
			submit: true,
			save_name: "new-projet",
			height: 360,
			width: 480
		});
	});
	$("#rem-pjt").unbind("click").click(function(){

		$.ajax({ 
			type: "POST", 
			url: "actions.php", 
			data: {"del-projeto": true},
			success: function (data) { 
				if(data != 0){
					RecaregarTuDo();
					$("#select-projet").html(data);
				} else {
					alert("Antes de Apagar o projeto remova todas tarefas e membros.");
				}
			}
		});
	});
	//End-Projetos OPTs

	//Membros X Projetos
	$("#projeto-membro").unbind("click").click(function(){
		
		fm_padrao.Open({
			title:  "Projeto X Membros",
			data:   $("#manter-projetos-membros").html(),
			save:   function(conteiner){ 
				
				FormPadrao_CloseAll(function(){InitLoad();});
				
				var membros = new Array();
				var i       = 0;
				var pj_id   = $("#the-id-project").val();

				$(conteiner).find(".ls-membros-in-prjeto").children("li").children("a").each(function(){
					membros[i] = $(this).attr("mbId");
					i++;
				});
				
				var dados  = {"membros_id": membros, "id_projeto":pj_id, "add-membros-projeto": true}

				$.ajax({  
					type: "POST",  
					url: "actions.php",  
					data: dados, 
					success: function( data )  
					{
						$("#manter-projetos-membros").html(data);
						$(".ls-membros-in-prjeto").html($("#manter-projetos-membros").find(".ls-membros-in-prjeto").html());
						RecaregarTuDo();
					}  
				});


			},
			cancel: function(){ FormPadrao_CloseAll() },
			close:  function(){ FormPadrao_CloseAll(); },
			height: 380,
			width: 680
		});
		DragInit();
	});
	//EndMembros X Projetos

	$("#select-projet").unbind("change").change(function(){

		var pj_id = $(this).find("option:selected").val();
		InitLoad();
		$.ajax({ 
			type: "POST", 
			url: "actions.php", 
			data: {"SET-PROJET": true, "id_projeto": pj_id},
			success: function (data) { 
				RecaregarTuDo();
			} 
		});
	});		
//****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA//
//GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA//
//****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA//
//GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA//
//****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA//
//GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA//
//****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA****GINGA//

				} 
			});
		}

		$(document).ready(function() {
			RecaregarTuDo();
		});

		var ginga_reoload;	

		function ginga_startReload() {

			timer_reoload = setTimeout(function(){		
				
				//alert("GINGA3");

				clearTimeout(timer_reoload);
				ginga_startReload();
			},3000);
		}
		ginga_startReload();
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
		function readFILE(input) { 	
			if (input.files && input.files[0]) { 	
				var reader = new FileReader();  	
				reader.onload = function (e) { 	
					$(input).parent().find("p") 	
					.html(input.files[0].name); 	
				};  	
				reader.readAsDataURL(input.files[0]); 	
			} 	
		}

		function EnviarComentarioTarefa(bt, tf_id){
			var texto = $(bt).parent().children("textarea").val();
			

			$.ajax({ 
				type: "POST", 
				url: "actions.php", 
				data: {"coment-job": true, "conteudo": texto, "id_tarefa": tf_id},
				success: function (data) { 
					
					$.ajax({ 
						type: "POST", 
						url: "actions.php", 
						data: {"GET-LAST-JOB-COMENT": true, "id_tarefa": tf_id},
						success: function (data) { 
							$(".last-job-coment-"+tf_id).html(data);
						} 
					});	
					$.ajax({ 
						type: "POST", 
						url: "actions.php", 
						data: {"GET-JOB-COMENTS": true, "id_tarefa": tf_id},
						success: function (data) { 
							$(".job-coments-"+tf_id).html(data);
							$(bt).parent().children("textarea").val("")
						} 
					});


				} 
			});
		}; 	

		function EnviarComentarioProjeto(bt){
			var texto = $(bt).parent().children("textarea").val();

			$.ajax({ 
				type: "POST", 
				url: "actions.php", 
				data: {"coment-projet": true, "conteudo": texto},
				success: function (data) { 
					
					$.ajax({ 
						type: "POST", 
						url: "actions.php", 
						data: {"GET-LAST-PROJET-COMENT": true},
						success: function (data) { 
							$(".last-projet-coment").html(data);
						} 
					});	
					$.ajax({ 
						type: "POST", 
						url: "actions.php", 
						data: {"GET-PROJET-COMENTS": true},
						success: function (data) { 
							$(".projet-coments").html(data);
							$(bt).parent().children("textarea").val("")
						} 
					});


				} 
			});
		}; 	

		function ViewAllComentsTarefa(link){

			var coments = $(link).parent().parent().parent().parent().find(".all-coments").html();
			var array   = new Array();

			array[0] = new DataView("Coment&aacute;rios", coments);
			
			fm_media.Open({
				data:   array,
				width: 500,
				height: 450
			});
		}

		function ViewAllComentsProj(link){

			var array = new Array();

			array[0] = new DataView("Comentarios", $(link).parent().parent().parent().parent().find(".all-coments").html());

			var fm = new FormMedia();
			
			fm.Open({
				data:   array,
				width:  480,
				height: 440
			});
		}

		function TarefaViewClick(bt){
			
			var array = new Array();

			var view   = $(bt).parent().parent().parent().find(".view").html();
			var titulo = $(bt).parent().parent().find("p").html();
			
			array[0] = new DataView(titulo, view);

			fm_media.Open({
				data: array,
				title: titulo,
				height: 420,
				width: 460
			});
		}
		function TarefaMembrosClick(bt){

			var membros = $(bt).parent().parent().parent().find(".view").find(".the-members").parent().html();
			var array = new Array();

			array[0] = new DataView("Membros - Terefa", $(bt).parent().parent().parent().find(".view").find(".the-members").parent().html());

			fm_media.Open({
				data: array
			});
		}		

		function ViewMember(link){
	
			var fm 	  = new FormMedia();
			var array = new Array();
			
			var color = $(link).parent().find("#the-member").attr("color");
			var style = "<style> #view-the-member .manifest, .fm-media input, #view-the-member #more-actions { background-color: "+color+"; } .fm-media h2{ color: "+color+"; } #view-the-member>header>img{ border-color: "+color+"; } </style>";
			var data  = style+$(link).parent().find("#the-member").html();
			var name  = $(link).parent().find("#the-member").find(".the-name").html();
			
			array[0] = new DataView(name, data);
						
			fm.Open({
				data:   array,
				width:  400,
				height: 440
			});
		}
		function ViewAllMembers(link){
	
			var fm 	  = new FormMedia();
			var array = new Array();
			var index = $(link).parent().parent().children("li").children("a").index(link);

			$(link).parent().parent().find("#the-member").each(function(index){
				var color = $(this).attr("color");
				var style = "<style> #view-the-member .manifest, .fm-media input, #view-the-member #more-actions { background-color: "+color+"; } .fm-media h2{ color: "+color+"; } #view-the-member>header>img{ border-color: "+color+"; } </style>";
				var data  = style+$(this).parent().find("#the-member").html();
				var name  = $(this).parent().find("#the-member").find(".the-name").html();
			

				array[index] = new DataView( name, data);
			});
			
			fm.Open({
				data:   array,
				width:  400,
				height: 450,
				at: index
			});
		}

		function EditTarefas(bt){

			var view = $(bt).parent().parent().parent().children(".view");
			var nome = $(bt).parent().parent().children("p").html();
			var desc = view.find(".desc").html();
			var _id  = $(bt).attr("tfId");
			var membros    = view.find(".the-members").children("ul").html();
			var no_membros = view.find(".not-members").children("ul").html();

			$("#ls-ed-membros-tarefa").html(membros);
			$("#ls-ed-not-membros-tarefa").html(no_membros);
			
			fm_padrao.Open({
				title:  "Editar Tarefa",
				data:   $("#edit-tarefas").html(),
				save:   function(conteiner){
					////////////////////TAREFA
					var nome  = $(conteiner).find("input[name='tf_nome']").val();
					var desc  = $(conteiner).find("textarea[name='tf_desc']").val();

					var dados = {"update-tarefa":true, "tf_nome": nome, "tf_desc": desc, "_id": _id}; 
					var url   = "actions.php"; 
					
					$.ajax({ 
						type: "POST", 
						url: url, 
						data: dados, 
						success: function (data) { 
							RecaregarTuDo();
							FormPadrao_CloseAll();
						} 
					});
					////////////////////TAREFA
					////////////////////TAREFAxMEMBRO
					var membros = new Array();
					var i       = 0;
					var pj_id   = $("#the-id-project").val();

					$(conteiner).find("#ls-ed-membros-tarefa").children("li").children("a").each(function(){
						membros[i] = $(this).attr("mbId");
						i++;
					});
				
					var dados  = {"membros_id": membros, "id_tarefa":_id, "add-membros-tarefa": true}

					$.ajax({  
						type: "POST",  
						url: "actions.php",  
						data: dados, 
						success: function( data )  
						{
							RecaregarTuDo();
							FormPadrao_CloseAll();
						}  
					});
					////////////////////TAREFAxMEMBRO
				},
				cancel: function(){ alert("cancel"); },
				close:  function(){ FormPadrao_CloseAll(); },
				init_open: function(conteiner){
					$(conteiner).find("input[name='tf_nome']").val(nome);
					$(conteiner).find("textarea[name='tf_desc']").val(desc);
				},
				move: true,
				height: 460
			});
		}
		function addInTarefa(bt){

			fm_padrao2.Open({
				data: $("#not-in-tarefa").html(),
				title: "Fora da Tarefa",
				move: true
			});

			DragInit();
		}
		function RemoveTarefas(bt){

			var _id   = $(bt).attr("tfID");
			var dados = {"del-tarefa":true, "_id": _id}; 
			var url   = "actions.php"; 
			
			$.ajax({ 
				type: "POST", 
				url: url, 
				data: dados, 
				success: function (data) { 
					
					if (data != 0) {
						RecaregarTuDo();
					} 
				} 
			});
		}
		function DeleteAnexo(bt){
			
			$.ajax({ 
				type: "POST", 
				url: "actions.php", 
				data: {"del-arquivo": true, "arq_id": $(bt).attr("ArqId"), "tf_id": $(bt).attr("TfId")}, 
				success: function (data) { 
					$(bt).parent().parent("ul").html(data);
				} 
			});
		}

		function NovoCargo(bt){
			
			var nome  = $(bt).parent().find("input[name='cargo-nome']").val();
			var dados = {"new-cargo":true, "cg_nome": nome}; 
			var url   = "actions.php"; 

			$(bt).parent().find(".error").html("");
			
			$.ajax({ 
				type: "POST", 
				url: url, 
				data: dados, 
				success: function (data) { 
					
					if (data != 0) {
						$(".ls-cargos").html(data);
						$(bt).parent().find("input[name='cargo-nome']").val("");
					} else {
						$(bt).parent().find(".error").html("*O cargo informado j&aacute; existe.");
					};

				} 
			});
		}
		function DeleteCargo(bt){

			var _id   = $(bt).attr("cgID");
			var dados = {"del-cargo":true, "_id": _id}; 
			var url   = "actions.php"; 
			
			$.ajax({ 
				type: "POST", 
				url: url, 
				data: dados, 
				success: function (data) { 
					
					if (data != 0) {
						$(".ls-cargos").html(data);
						$(bt).parent().find("input[name='cargo-nome']").val("");
					} 
				} 
			});
		}
	</script>

</body>

</html>
