<!DOCTYPE HTML>
<html lang="pt-br">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Ginga 3</title>
	<script src="js/jquery.js"></script>
	<script src="js/jquery.validate.js"></script>
	<script src="js/global.js"></script>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="shortcut icon" href="img/ico.ico" />
	<style>
		
		.act:active{ background-color: #FFFFFF;	top: -2; }
		.bt{ float: right;}

		body{ background-image: url("img/lock.png");}
		body>section{
			background-color: #FFF;
			width: 320px;
			position: absolute;
			padding: 10px;
			border: 5px solid;
			border-top-left-radius: 5px;
			border-top-right-radius: 5px;
			border-bottom-right-radius: 5px;
			border-bottom-left-radius: 5px;
			box-shadow: 0px 0px 5px inset;
		}
		body>section input[type="email"],
		body>section input[type="password"]{ width: 99%;}
		body>section footer p{ font-size: 12px; }
		body>section img{
			margin: auto;
			display: block;
		}

		h1{	display: none;}
	</style>
</head>
<body class="color1 text-color">

	<header>
		<img src="img/ginga_logo.png" width="120px">
		<h1>Ginga 3.0</h1>
	</header>
	
	<section class="in-center">
		<form action="" method="post">
			<article>
				<header>
					<h2>Login</h2>
					<img style="display: none;" src="#" style="display: " height="142px" width="107px" id="preview" >
				</header>
				<section>
					<p>E-mail:</p>
					<input type="email" id="init" name="lg_email"> 
					<p>Senha:</p>
					<input type="password" name="lg_senha"> 
				</section>
				<footer>
					<p class="error" id="server_error"></p>
					<p>Ainda n&atilde;o &eacute; membro? Cadastre-se <a href="novo-membro.php">aqui</a>.</p>
					<input type="submit" class="bt color1" value="Entrar" name="entrar">
				</footer>
			</article>
		</form>
	</section>
	
	<div id="new-color"></div>

	<footer>
		<p>Ginga 3.0</p>
	</footer>

	<!--AJAX-->
	<script>

		function CarregarFoto(foto){

			$("#preview").css("display", "block");
			InCenter("section");
			$("#preview").height(0);
			$("#preview").attr("src", foto);
			$("#preview").animate(
				{height: $("#preview").attr("height")},
				450,
				function(){ InCenter("section"); }
			);
		}

		$('form').validate({  
			rules: {  
					lg_email: { required: true, email: true },  
					lg_senha: { required: true, minlength: 6}  
			},  
			messages: {  
					lg_email: { 
						required: '<p class="error">*Informe o seu e-mail.<p>', 
						email: '<p class="error">*Por Favor, informe um email v&aacutelido.</p>' },  
					lg_senha: { 
						required: '<p class="error">*Voc&ecirc n&atildeo informou a senha.<p>',  
						minlength: '<p class="error">*A senha &eacute composta por no m&iacute;nimo 6 d&iacute;gitos.</p>'}    
			},  
			submitHandler: function( form ){  
					var dados = $( form ).serialize();  

					$.ajax({  
						type: "POST",  
						url: "log.php",  
						data: dados,  
						success: function( data )  
						{ 	
							var json = $.parseJSON(data);

							if (json.log_code == 1)
							{
								$("#server_error").html("<span style='color: green;'>"+json.return+"</span>");							
								$(window.document.location).attr('href','home.php');											

							} else {

								if(json == 0){
									$("#preview").css("display", "none");
									InCenter("section");
									$("#server_error").html("*Usu&aacute;rio n&atilde;o encontrado. verifique a senha e e-mail.");							
								}
								if(json.log_code == 2){
									CarregarFoto(json.return);
									$("#server_error").html("*Aguardando confirma&ccedil;&atilde;o do cadastro, tente novamente mais tarde.");
								}
								if(json.log_code == 3){
											
									CarregarFoto(json.return);
									$("input[name='lg_senha']").val("");
									$("#server_error").html("*Usu&aacute;rio n&atilde;o autenticado. verifique a senha.");
								}
							}

							return false;
						}  
					});  

				return false;  
			}
		});
	</script>
	
	<!--Rand Color-->
	<script>
		$(document).ready(function(){
			var R = parseInt(Math.random()*195);
			var G = parseInt(Math.random()*195);
			var B = parseInt(Math.random()*195);

			$("#new-color").html("<style> .text-color{ color: rgb("+R+" ,"+G+" ,"+B+");} .color1{ background-color: rgb("+R+" ,"+G+" ,"+B+");} .box-color{ box-shadow: 0 0 25px rgb("+R+" ,"+G+" ,"+B+");} .act:active, .ed-file label{ border: solid 1px rgb("+R+" ,"+G+" ,"+B+");} </style>");

			$("#init").focus();
		});	
	</script>
	
</body>

</html>



