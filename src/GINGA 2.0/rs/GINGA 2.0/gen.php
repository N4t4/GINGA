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
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>
</head>
<body class="gen">

	<header>
		<div id="menu">
			<h1>GINGA</h1>
			<h2 id="bt_change_projet">| Projeto: <?php echo $projeto_atual->nome; ?></h2>
                <p style="display: none" id="proj_at_id"><?php echo $projeto_atual->id; ?></p>
				<ul>
					<li><a href="sobre.html">Sobre</a></li>
					<li><a id="add_pendencia" href="#">Add Pend&ecircncias</a></li>
					<li><a id="add_projeto" href="#">Add Projeto</a></li>
					<li><a id="new_membros" href="#">Permitir Novos Membros</a></li>
					<li><a href="">Gerentes</a></li>
					<li><a href="">Editar Perfil</a></li>
					<li><a href="home.php">Retornar</a></li>
					<li><a id="sair" href="#">Sair</a></li>
				</ul>
				<a id="menu_bt_view" href="#"></a>
			</div>
	</header>
	
	<div class="container wspan11 hspan9">
		<header>
			<h2>Operacional</h2>
		</header>
		<div class="square">
			<div class="wspan3 offwspan1">
				<header>	
					<h2>Projetos</h2>
				</header>
				<ul id="ls-projetos"></ul>
			</div>
			
			<div class="wspan3 offwspan1_2">
				<header>	
					<h2>Pend&ecircncias</h2>
				</header>
				<ul id="ls-pendencia" class="">
<?php
	$qry = "SELECT * FROM pendencias WHERE id_projeto='{$_SESSION['projeto_at_id']}';";
	$ls  = mysql_query($qry, $conexao);
	while($linha = mysql_fetch_array($ls))
		echo "<li><a id='{$linha['nome']}' href='#' class='title'>{$linha['nome']}</a></li>";
?>
				
				</ul>
			</div>
			
			<div id="div-membros" class="wspan3 offwspan1_2">
				<header>	
					<h2>Membros</h2>
				</header>
				<ul id="ls-membros" class="ls-membros"></ul>
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
	
	<form action="" method="post" id="submit_fm_pendencia">
	<div class="edit wspan5 hspan10" id="fm_pendencia" style="display: none">
			<header>			
				<h2>Cadastro de pend&ecircncia</h2>	
				<input type="Button" class="bt_fechar"/>
			</header>
			
			<article>
				<div class="wspan5 offwspan1_2">
					<p>Nome da pend&ecircncia:</p>
					<input type="text" name="pend_nome" value="Natã">
				</div>
				<div class="wspan5 offwspan1_2">
					<p>Data Termino:</p>
					<input type="text" name="pend_termino" value="2013-06-23">
				</div>
			
				<div class="wspan11 offwspan1_2">
					<p class="p_quebra_linha">Área</p>
					<ul class="ls_radio">
<?php
	$qry = "SELECT a.* FROM areas a;";
	$ls  = mysql_query($qry, $conexao);
	while($linha = mysql_fetch_array($ls))
		echo "<li><input type='radio' name='pend_id_area' value='{$linha["id"]}'><p>".converte_html($linha["descricao"])."</p></li>";
?>
					</ul>
				</div>
				
				<div class="wspan12">
					<header>	
						<p>Membros</p>
					</header>
					<ul id="ls-membros-pendencia" class="ls-membros all-arraste solte arraste-remova">
					</ul>
				</div>
				<input id="bt_add_membros_pendencia" type="Button" class="bt_cancel" value="Adicionar Membros"/>
			
			</article>
			
			<footer>
				<input type="Button" class="bt_ok" value="Salvar"/>
				<input type="submit" class="bt_cancel" value="Cancelar"/>
			</footer>

	</div>
	</form>
	
	<form action="" method="post" id="submit_fm_projeto">
	<div class="edit wspan5 hspan10" id="fm_projeto" style="display: none">
			<header>			
				<h2>Novo Projeto</h2>	
				<input type="Button" class="bt_fechar"/>
			</header>
			
			<article>
				<div class="wspan11 offwspan1_2">
					<p>Nome do projeto:</p>
					<input type="text" name="proj_nome" value="">
				</div>
				
				<div class="wspan12">
					<header>	
						<p>Membros</p>
					</header>
					<ul id="ls-membros-projeto" class="ls-membros all-arraste solte arraste-remova">
						<li class='box-membro'><a id='1' href='#'><img src='img/logo.png'/></a></li>
					</ul>
				</div>
				<input id="bt_add_membros_projeto" class="bt_cancel" type="Button" value="Adicionar Membros"/>
			
			</article>
			
			<footer>
				<input type="Button" class="bt_ok" value="Salvar"/>
				<input type="submit" class="bt_cancel" value="Cancelar"/>
			</footer>

	</div>
	</form>

  <form action="" method="post" id="submit_fm_edit_projeto">
	<div class="edit wspan5 hspan10" id="ed_fm_projeto" style="display: none">
			<p id="the_id_proj" style="display: none"></p>
            <header>			
				<h2>Novo Projeto</h2>	
				<input type="Button" class="bt_fechar"/>
			</header>
			
			<article>
				<div class="wspan11 offwspan1_2">
					<p>Nome do projeto:</p>
					<input type="text" name="proj_nome" value="">
				</div>
				
				<div class="wspan12">
					<header>	
						<p>Membros</p>
					</header>
					<ul id="ls-membros-projeto" class="ls-membros all-arraste solte arraste-remova">
						<li class='box-membro'><a id='1' href='#'><img src='img/logo.png'/></a></li>
					</ul>
				</div>
				<input id="bt_add_membros_projeto" class="bt_cancel" type="Button" value="Adicionar Membros"/>
			
			</article>
			
			<footer>
				<input type="Button" class="bt_ok" value="Salvar"/>
				<input type="submit" class="bt_cancel" value="Cancelar"/>
			</footer>

	</div>
	</form>
	
	<div class="edit wspan5 hspan10" id="fm_new_membros" style="display: none">
			<header>			
				<h2>Novos membros</h2>	
				<input type="Button" class="bt_fechar"/>
			</header>
	
			<article>
				<div class="wspan12">
					<header>	
						<p>Membros</p>
					</header>
					<ul id="ls-membros-projeto" class="ls-new-membros">
						<li class='box-membro'><a href='#'><img src='img/logo.png'/></a><label>nome</label><a href="#" id='1' class="bt_cancel">Remover</a><a id='1' href="#" class="bt_ok">Confirmar</a></li>
					</ul>
				</div>
			</article>
			
			<footer>
			</footer>
	</div>
	
	<div class="edit wspan5 hspan10" id="fm_change_at_proj" style="display: block">
			<header>			
				<h2>Novos membros</h2>	
				<input type="Button" class="bt_fechar"/>
			</header>
	
			<article>
				<div class="wspan12">
					<header>	
						<p>Membros</p>
					</header>
					<ul id="ls-membros-projeto" class="ls-new-membros">
						<li class='box-membro'><a href='#'><img src='img/logo.png'/></a><label>nome</label><a href="#" id='1' class="bt_cancel">Remover</a><a id='1' href="#" class="bt_ok">Confirmar</a></li>
					</ul>
				</div>
			</article>
			
			<footer>
			</footer>
	</div>
	
	<div id="drag" style="display: none;"></div>
	<div id="carregar" style="display: none; z-index: 4;"><img  src="img/ld.gif" style="position: fixed; left: 45%; top:40%;"  width="100px"/></div>
	<div id="lock" style="display:none;"></div>
	<input type="Button" class="bt_chat" />
	<input type="Button" class="bt_at" />
	
	<div id="talk">nome</div>
		
	<script type="text/javascript" src="js/gen.js"></script> 
<?php get_footer(); ?>
