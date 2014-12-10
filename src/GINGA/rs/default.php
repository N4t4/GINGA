<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US">
<head>
	<link rel="stylesheet" type="text/css" href="css/global.css" />
	<meta charset="UTF-8"/>
	<title>Login</title>
  <link rel="shortcut icon" href="img/ico.png" />
	<script type="text/javascript" src="java/jquery.min.js"></script>  
	<script type="text/javascript" src="java/jquery.validate.js"></script>
	<script type="text/javascript" src="java/default.js"></script> 
</head>
<body>
	<img src="img/logo.png" style="position: absolute; left: 0px; top:0;"  width="150px"/>
	<div id="carregar" style="display:none;"><img  src="img/ld.gif" style="position: fixed; left: 45%; top:40%;"  width="100px"/></div>
	<form action="" method="post" id="form_entrar">
		<div id="entrar">
			<div class="bloco">
					<h1>Login</h1>
					<p>E-mail:</p>
					<input type="text" name="log_email"/>
					<p>Senha:</p>
					<input type="password" name="log_senha"/>
					<input type="submit" value="Entrar" name="entrar" class="button"/>
					<p style="color: #7E0B0B;" id="p_erro_ent"></p>
			</div>
	</form>	
  
	<form action="" method="post" id="cad_form">  
			<div class="bloco">
				<h1>Cadastrar</h1>
				<p>Nome:</p>
				<input type="text" name="cad_nome"/>
				<p>E-mail:</p>
				<input type="text" name="cad_email"/>
				<p>Senha:</p>
				<input type="password" name="cad_senha"/>
				<input type="submit" value="Entrar" name="cadastro" class="button"/>
				<p style="color: #7E0B0B;" id="p_erro_cd"></p>
			</div>
		</div>
	</form>	
	
</body>
</html>