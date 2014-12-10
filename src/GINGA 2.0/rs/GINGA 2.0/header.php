<?php
	include("includes/machine.php"); 
	include("includes/Myclasses.php"); 
	require_once("includes/conexao.php"); 
	session_start();

	if(!$_SESSION['sessao']) header("Location: default.php");
	
	$controle_db = new ControleDB($conexao);
	
	$qry = "SELECT * FROM projetos WHERE id = '{$_SESSION['projeto_id']}';";
	$resultado = mysql_query($qry, $conexao);
	$linha		 = mysql_fetch_array($resultado);
	$projeto_atual = new Projeto();
	$projeto_atual->CaregarLinha($linha);	
?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<script type="text/javascript" src="js/jquery.min.js"></script> 
	<script type="text/javascript" src="java/jquery.validate.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>
</head>
<body>
	<header>
		<div id="menu">
			<h1>GINGA</h1>
			<h2>| <?php echo $projeto_atual->nome; ?></h2>
				<ul>
					<li><a href="gen.php">Gerente</a></li>
					<li><a href="">Gerente</a></li>
					<li><a href="">Gerente</a></li>
					<li><a href="">Gerente</a></li>
					<li><a href="">Item5</a></li>
					<li><a href="">Item6</a></li>
					<li><a href="">Item7</a></li>
				</ul>
				<a id="menu_bt_view" href="#"></a>
			</div>
	</header>