<?php 
	include("includes/machine.php"); 
	include("includes/Myclasses.php"); 
	require_once("includes/conexao.php"); 
	session_start();

	$controle_db = new ControleDB($conexao);
	
	if(!isset($_SESSION['cad_sucess']))
	{
		$_SESSION['cad_sucess'] = true;
	}
	else
	{
		if($_SESSION['cad_sucess'])
		{
			$_SESSION['cad_sucess'] = false;
			header("Location: default.php");
		}
		else
			$_SESSION['cad_sucess'] = true;
	}
		
?>

<?php	the_header();?>

<form action="" method="post" id="fm_cad">
<div class="container wspan8 hspan7" style="border:none; background: none;">

	<div class="edit wspan10 offwspan1_2 hspan12">
			<header>
				<img src="img/logo.png">
				<h2>Ficha de Cadastro</h2>
			</header>
			
			<article>
				<div class="wspan11 offwspan1_2">
					<p>Nome:</p>
					<input type="text" name="cad_nome" value="membro">
				</div>
				
				<div class="wspan5 offwspan1_2">
					<p>E-mail:</p>
					<input type="text" name="cad_e_mail" value="membro@teste.com">
					<p>Senha:</p>
					<input type="password" name="cad_senha" value="123">
					<p>Sexo:</p>
					<ul class="ls_radio">
						<li><input type="radio" name="cad_sexo" value="1"/><p>M</p></li>
						<li><input type="radio" name="cad_sexo" value="2"/><p>F</p></li>
					</ul>
				</div>
				
				<div class="wspan5 offwspan1">
					<p>Telefone:</p>
					<input type="text" name="cad_telefone" value="(12)3662-4070">
					<p>Data Nascimento:</p>
					<input type="text" name="cad_dt_nascimento" value="2013-06-23">
				</div>
				
				<div class="wspan11 offwspan1_2">
					<p class="p_quebra_linha">Você é um:</p>
					<ul class="ls_radio">
						<li><input type="radio" name="cad_vinculo" value="1"/><p>Aluno</p></li>
						<li><input type="radio" name="cad_vinculo" value="2"/><p>Ex-aluno</p></li>
						<li><input type="radio" name="cad_vinculo" value="3"/><p>Professor</p></li>
						<li><input type="radio" name="cad_vinculo" value="4"/><p>Comunidade</p></li>
					</ul>
				</div>
				
				<div class="wspan11 offwspan1_2">
					<p>Por quem ficou sabendo do groupo:</p>
					<input type="text" name="cad_indicacao" value="Professor avelino.">
				</div>
				
				<div class="wspan5 offwspan1_2">
					<p>Curso</p>
					<input type="text" name="cad_curso" value="TADS">
				</div>
				
				<div class="wspan5 offwspan1">
					<p>Modulo</p>
					<input type="text" name="cad_modulo" value="3ro modulo">
				</div>
				
				<div class="wspan11 offwspan1_2">
					<p class="p_quebra_linha">Área que vai atuar: (pode ser mais de uma)</p>
					<ul class="ls_radio">
<?php
	$qry = "SELECT a.* FROM areas a;";
	$ls  = mysql_query($qry, $conexao);
	while($linha = mysql_fetch_array($ls))
		echo "<li><input type='radio' name='cad_id_area' value='{$linha["id"]}'><p>".converte_html($linha["descricao"])."</p></li>";
?>
					</ul>
				</div>
				
				<div class="wspan5 offwspan1_2">
					<p>Rua</p>
					<input type="text" name="end_rua" value="Rua de Teste"/>
					<p>Numero</p>
					<input type="text" name="end_numero"/>
				</div>
				<div class="wspan5 offwspan1">
					<p>Bairro</p>
					<input type="text" name="end_bairro"/>
					<p>Cidade</p>
					<input type="text" name="end_cidade"/>
					<p>Estado</p>
					<input type="text" name="end_estado"/>
				</div>
				
			</article>
			
			
			<footer>
					<p class="error"></p>
					<input type="submit" value="Enviar" name="fixa_membro" class="bt_ok">
			</footer>

	</div>
	
</div>
</form>

<script type="text/javascript" src="js/fm_cad.js"></script> 

<?php
	get_footer();
?>