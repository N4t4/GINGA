<?php 
	include("includes/machine.php"); 
	include("includes/Myclasses.php"); 
	require_once("includes/conexao.php"); 
	session_start();
	
	if(!$_SESSION['sessao']) header("Location: default.php");
	
	$controle_db = new ControleDB($conexao);
	
	$qry = "SELECT * FROM projetos WHERE id = '{$_SESSION['projeto_at_id']}';";
	$resultado = mysql_query($qry, $conexao);
	$linha		 = mysql_fetch_array($resultado);
	$projeto_atual = new Projeto();
	$projeto_atual->CaregarLinha($linha);

	$qry = "SELECT * FROM membros WHERE id = '{$_SESSION['membro_at_id']}';";
	$resultado = mysql_query($qry, $conexao);
	$linha		 = mysql_fetch_array($resultado);
	$membro_atual = new Membro();
	$membro_atual->CaregarLinha($linha);	
	
	$gerente = new Gerente();
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
			<h2>| Projeto: <?php echo $projeto_atual->nome; ?></h2>
				<ul>
					<?php if ($gerente->Acessar($conexao, $membro_atual->id)) echo "
						<li><a href='gen.php'>Gerente</a></li>
					" ?>
					<li><a href="sobre.html">Sobre</a></li>
					<li><a href="#">Editar Perfil</a></li>
					<li><a id="bt_change_projet" href="#">Ver Outro Projeto</a></li>
					<li><a id="sair" href="#">Sair</a></li>
				</ul>
				<a id="menu_bt_view" href="#"></a>
			</div>
	</header>
	
	<div class="container wspan10 hspan9">
		<header>
			<h2>Pend&ecircncias</h2>
		</header>
		<div class="square">
			<div class="wspan3 offwspan1">
				<header>	
					<h2>Criados</h2>
				</header>
				<ul id="ls-criados" class="arraste">
				</ul>
			</div>
			
			<div class="wspan3 offwspan1_2">
				<header>	
					<h2>Fazer</h2>
				</header>
				<ul id="ls-fazer" class="arraste">
				</ul>
			</div>
			
			<div class="wspan3 offwspan1_2">
				<header>	
					<h2>Prontos</h2>
				</header>
				<ul id="ls-pronto" class="arraste">
				</ul>
			</div>
		</div>
	</div>
	
	<div id="box_chat">
		<header>
			<h2>Membros</h2>
		</header>
		<ul>
			<li><img src="img/logo.png"/><a href="#">Membro1</a></li>
			<li><img src="img/logo.png"/><a href="#">Membro1</a></li>
			<li><img src="img/logo.png"/><a href="#">Membro1</a></li>
			<li><img src="img/logo.png"/><a href="#">Membro1</a></li>
			<li><img src="img/logo.png"/><a href="#">Membro1</a></li>
			<li><img src="img/logo.png"/><a href="#">Membro1</a></li>
			<li><img src="img/logo.png"/><a href="#">Membro1</a></li>
			<li><img src="img/logo.png"/><a href="#">Membro1</a></li>
			<li><img src="img/logo.png"/><a href="#">Membro1</a></li>
			<li><img src="img/logo.png"/><a href="#">Membro1</a></li>
			<li><img src="img/logo.png"/><a href="#">Membro1</a></li>
			<li><img src="img/logo.png"/><a href="#">Membro1</a></li>
			<li><img src="img/logo.png"/><a href="#">Membro1</a></li>
			<li><img src="img/logo.png"/><a href="#">Membro1</a></li>
			<li><img src="img/logo.png"/><a href="#">Membro1</a></li>
			<li><img src="img/logo.png"/><a href="#">Membro1</a></li>
			<li><img src="img/logo.png"/><a href="#">Membro1</a></li>
			<li><img src="img/logo.png"/><a href="#">Membro1</a></li>
		</ul>
	</div>
	
	<div id="box_at">
		<header>
			<h2>Atualizacoes</h2>
		</header>
		<input id="t1" type="Button" class="bt_ok" value="teste"/>
		<input id="t2" type="Button" class="bt_ok" value="teste"/>
	</div>
	
	<div id="box_notification">
		<header>
			<a href="#">
				<img src="img/gen.png"/>
			</a>
			<h2>Membro1</h2>
  		<input type="Button" class="bt_fechar"/>
  		<input type="Button" class="bt_mini"/>
		</header>
		<ul>
			<li><p>Oi =]</p><p class="date-time">13:20 31/05/2013</p></li>
			<li class="owner"><p>Olá, tudo bem com você</p><p class="date-time">13:20 31/05/2013</p></li>
			<li><p>Sim.</p><p class="date-time">13:20 31/05/2013</p></li>
		</ul>
		<textarea></textarea>
	</div>
	
	<div class="fm_evident" style="display:none;">
		<header>
			<h2>Titulo Janela</h2>	
			<input type="Button" class="bt_fechar"/>
		</header>
		<div>
		</div>
		<footer>
			<input type="Button" class="bt_cancel" value="Cancelar"/>
			<input type="Button" class="bt_ok" value="Salvar"/>
		</footer>
	</div>
	
	<div id="drag" style="display: none;"></div>
	
	<div class="edit wspan5 hspan5" id="fm_sel_proj" style="display: none">
		<header>			
			<h2>Projeto</h2>	
			<input type="Button" class="bt_fechar"/>
		</header>
	
		<article style="background-color: #D07F26;">
			<header>	
			</header>
			<ul id="ls-projetos">

<?php
	$qry = "SELECT * FROM projetos;";
	$ls  = mysql_query($qry, $conexao);

	while($linha = mysql_fetch_array($ls))
	if( $projeto_atual->id == $linha["id"])
	echo "<li class='offwspan1_2 wspan10 selected' style='background-image: url(imgpj01.png);'><a id='{$linha["id"]}' href='#' class='title'>{$linha["nome"]}</a><a id='{$linha["id"]}' href='#' class='view'></a></li>";
	else
	echo "<li class='offwspan1_2 wspan10' style='background-image: url(imgpj01.png);'><a id='{$linha["id"]}' href='#' class='title'>{$linha["nome"]}</a><a id='{$linha["id"]}' href='#' class='view'></a></li>";
?>
			</ul>
		</article>
			
		<footer>
		</footer>
	</div>

	<div id="carregar" style="display: none; z-index: 4;"><img  src="img/ld.gif" style="position: fixed; left: 45%; top:40%;"  width="100px"/></div>
	<div id="lock" style="display:none;"></div>
	<input type="Button" class="bt_chat" />
	<input type="Button" class="bt_at" />
	
	<script type="text/javascript" src="js/home.js"></script> 

<?php get_footer();?>
