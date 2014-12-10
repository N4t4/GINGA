<?php 
	include("includes/machine.php"); 
	include("includes/Myclasses.php"); 
	require_once("includes/conexao.php"); 
	session_start();

	$controle_db = new ControleDB($conexao);
?>

<?php the_header(); ?>
	<img src="img/logo.png" class="logo" style="margin: 5px; width: 150px;"/>
	<header>
		<h1 style="display: none;">GINGA</h1>
	</header>
	
	<form action="" method="post" id="fm_entrar">
		<div class="main">
			<div id="login-box">
				<header>
					<h1>Login</h1>
				</header>
				<p>E-mail</p>
				<input type="Text" name="log_email" style="height: 17px;"/>
				<p>Senha</p>
				<input type="password" name="log_senha" style="height: 17px;"/>
				<footer>
					<p class="error"></p>
					<input type="Submit" class="bt_ok"/>
				</footer>
			</div>
			<a href="fm_cad.php" type="Button" class="bt_evidence">Cadastrar-se</a>
		</div>
	</form>
	
	<script type="text/javascript" src="js/default.js"></script> 
	
<?php get_footer(); ?>