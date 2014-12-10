<?php
	require_once("includes/conexao.php"); 
	include("includes/Myclasses.php");
	global $conexao;

	$msm = "";
	$novo_membro = new Membro();

    if(isset($_POST['new-membro'])){

    	$controle_db = new ControleDB($conexao);

    	$novo_membro->nome    	= $_POST["mb_nome"];
    	$novo_membro->apelido 	= $_POST["mb_alias"];
    	$novo_membro->email   	= $_POST["mb_email"];
    	$novo_membro->senha   	= $_POST["mb_senha"];
    	$novo_membro->cor     	= $_POST["mb_cor"];
    	$novo_membro->manifesto = $_POST["mb_manifesto"];
    	$novo_membro->id_cargo  = $_POST["mb_cargo"];
    	$novo_membro->foto      = "default.png";

    	if($controle_db->VerificaRegistro("email", $_POST["mb_email"], "ginga3_membros") == 0){

	       	if (!empty($_FILES['mb_img'])) {

	            $extensao = '.' . pathinfo($_FILES['mb_img']['name'], PATHINFO_EXTENSION);

	            do {
	                $filename = md5(microtime() . $_FILES['mb_img']['name']) . $extensao;
	            } while (file_exists($filename));

	       		if(move_uploaded_file($_FILES['mb_img']['tmp_name'], $uploadDir . $filename))
	       			$novo_membro->foto = $filename;
	       	}

	       	if($novo_membro->Inserir($conexao)){
	       		header("Location: default.php");
	       	}
	    }else{
	    	$msm = "Este E-mail j&aacute; foi utilizado.";
	    }
    }
?>

<!DOCTYPE HTML>
<html lang="pt-br">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Ginga | Entrar</title>
	<script src="js/jquery.js"></script>
	<script src="js/jquery.validate.js"></script>
	<script src="js/global.js"></script>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="shortcut icon" href="img/ico.ico" />
	<style>


		.act{
			display: initial;
		}
		h1{
			margin: 0;
			text-align: center;
			margin-bottom: 5px;
		}
		body{
			overflow: auto;
			height: auto;
		}
		body>section{
			background-color: #FFF;
			padding: 10px;
			padding-left: 50px;
			padding-right: 50px;
			top: 0;
			height: 100%;
			overflow: hidden;
		}
		body>section footer p{
			font-size: 12px;
		}

		body>section strong{
		}
		body>section strong p{
			width: auto;
			display: inline-block;
			min-width: 135px;
			text-align: right;
			margin-top: 10px;
			margin-bottom: 10px;
			padding-left: 10px;
		}
		body>section strong textarea{
			width: 80%;
			display: block;
			margin: auto
		}
		body>section .bt-2{
			position: relative;
			bottom: 20px;
			right: -25px;
			float: right;
		}
		body>section>header>img{
			display: block;
			margin: auto;
		}
	</style>
</head>
<body class="color1">
	<section class="box-padrao wspan5 offwspan3">
		
		<header>
			<img src="img/ginga_logo.png" width="120px">
		</header>

		<form action="" method="post" enctype="multipart/form-data">

			<p class="error" id="view-erros"><?php echo $msm; ?></p>
			<h1>Entrar no GINGA</h1>
			<strong>
				<div class="ed-img color1">
				    <p>Foto:</p>
				    <a href="#"><img class="" src="default.png" alt="VAZIO" width="150" height="200"></a>
				    <label>
				        <input type="file" name="mb_img" onchange="readIMG(this);"/>
				        <input type="button" class="bt color" value="Abrir">
				    </label>
				</div>
			</strong>
			<div class="the-border" style="padding: 5px">
				<br>
				<p>
					<strong>Cor 1:</strong>
					<input owner="color1" type="button" value="rgb(255, 255, 255)" class="ed-nt-color">
				</p>
				<strong>
					<p>Nome:</p>
					<input type="text" size="30" name="mb_nome" value="<?php echo $novo_membro->nome; ?>">
				</strong>
				<br>
				<strong>
					<p>Apelido:</p>
					<input type="text" size="30" name="mb_alias" value="<?php echo $novo_membro->apelido; ?>">
				</strong>
				<br>
				<strong>
					<p>E-mail:</p>
					<input type="text" size="30" name="mb_email" value="<?php echo $novo_membro->email; ?>">
				</strong>
				<br>
				<strong>
					<p>Repitir E-mail:</p>
					<input type="text" size="30" name="mb_rp_email">
				</strong>
				<br>
				<strong>
					<p>Senha:</p>
					<input type="password" size="30" name="mb_senha">
				</strong>
				<br>
				<strong>
					<p>Repetir Senha:</p>
					<input type="password" size="30" name="mb_rp_senha">
				</strong>
				<br>
				<strong>
					<p>Manifesto:</p>
					<textarea cols="72" rows="5" name="mb_manifesto"><?php echo $novo_membro->manifesto; ?></textarea>
				</strong>
				<br>
				<strong>
					<p>Cargo:</p>
					<select class="sel-1 act" name="mb_cargo">
						<?php $qry = "SELECT * FROM ginga3_cargos;"; $ls  = mysql_query($qry, $conexao); ?>
						<?php while($cargo = mysql_fetch_array($ls)): ?>
							<option value="<?php echo $cargo["id"];?>"><?php echo $cargo["nome"]; ?></option>
						<?php endwhile; ?>
					</select>
				</strong>
			</div>
			<input type="submit" class="bt-2 color1" value="Enviar" name="new-membro">
		</form>
	</section>

	<footer>
		<p>Ginga 3.0</p>
	</footer>

	<div id="new-color"></div>

	<!--REQUEST-->
	<script>
		$('form').validate({  
			rules: {  
					mb_nome:     { required: true},  
					mb_alias:    { required: true},  
					mb_email:    { required: true, email: true },  
					mb_rp_email: { required: true, email: true },  
					mb_senha:    { required: true, minlength: 6},
					mb_rp_senha: { required: true, minlength: 6}
			},  
			messages: {  
					mb_nome:{
						required:'<br><p class="error">*Informe seu Nome.<p>'
					},
					mb_alias:{
						required:'<br><p class="error">*Informe um Apelido.<p>'
					},
					mb_email: { 
						required: '<br><p class="error">*Informe o seu e-mail.<p>', 
						email: '<br><p class="error">*Por Favor, informe um email v&aacutelido.</p>' 
					},
					mb_rp_email: { 
						required: '<br><p class="error">*Por Favor repita o seu e-mail.<p>', 
						email: '<br><p class="error">*Por Favor, informe um email v&aacutelido.</p>' 
					},  
					mb_senha: { 
						required: '<br><p class="error">*Crie uma senha senha.<p>',  
						minlength: '<br><p class="error">*A senha deve ter o m&iacutenimo de 6 digitos.</p>'},    
					mb_rp_senha: { 
						required: '<br><p class="error">*Por Favor Repita a senha.<p>',  
						minlength: '<br><p class="error">*A senha deve ter o m&iacutenimo de 6 digitos.</p>'}    
			}
		});

		$('form').submit(function(event){
			var erro = false;

			if($("input[name='mb_email']").val() != $("input[name='mb_rp_email']").val()){
				$("#view-erros").html("Os e-mails informados n&atilde;o coincidem.");
				erro = true;
			}
			if($("input[name='mb_senha']").val() != $("input[name='mb_rp_senha']").val()){
				$("#view-erros").html("As senhas informadas n&atilde;o coincidem.");
				erro = true;
			}

			if(erro){
				$("section").animate({scrollTop: 0}, 500);
				event.preventDefault();
			}
			else
				return;
		});
	</script>

	<!-- Random Color -->
	<script>
		$(document).ready(function(){
			var R = parseInt(Math.random()*155);
			var G = parseInt(Math.random()*155);
			var B = parseInt(Math.random()*155);

			$("#new-color").html("<style> .color1, .act:hover { background-color: rgb("+R+" ,"+G+" ,"+B+"); }  .act:active, .the-border{ border: solid 1px rgb("+R+" ,"+G+" ,"+B+"); }.act:active, .ed-file label, input, textarea, select, .act { border: solid 1px rgb("+R+" ,"+G+" ,"+B+"); } <style>");
			$(".ed-nt-color").eq(0).val("rgb("+R+","+G+","+B+")");
			$("input[name='mb_cor']").eq(0).val("rgb("+R+","+G+","+B+")");
		});	
	</script>

	<!-- Local Itens -->
	<script>
		$(document).ready(function() {
			
			if($(".ed-nt-color").length > 0){
			
				var index = 0;
				
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
					
					$(".nt-color").css("top", 336);
					$(".nt-color").css("left", getLeft(this) + 30);

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

					$("input[name='mb_cor']").val($(".ed-nt-color").eq(index).val());

					if($(".ed-nt-color").eq(index).attr("owner"))
						$("#new-color").html("<style> ."+$(".ed-nt-color").attr("owner")+", .act:hover { background-color: "+$(".ed-nt-color").eq(index).val()+"; }  .act:active, .the-border{ border: solid 1px "+$(".ed-nt-color").eq(0).val()+"; }.act:active, .ed-file label, input, textarea, select, .act { border: solid 1px "+$(".ed-nt-color").eq(0).val()+"; } <style>");
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
