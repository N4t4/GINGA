<?php 
	include("includes/machine.php"); 
	require_once("includes/conexao.php"); 
	session_start(); 
?>

<?php
//$response=file_get_contents("header.php");
//echo $response;
get_header();
?>

<div>
			<img src="img/sala3_logo.png">
			<h2>Ficha de Cadastro</h2>
			<p>Nome:</p>
			<input style="width: 680px;" type="text" name="fixa_nome" value="NatÃ£">
			<p>Endereço:</p>
			<input style="width: 660px;" type="text" name="membro_nome" value="NatÃ£">
			<p>E-mail:</p>
			<input disabled="" style="width: 680px;" type="text" name="membro_email" value="nata.erafael@gmail.com">
			<p>Telefone:</p>
			<input disabled="" style="width: 90px;" type="text" name="membro_email" value="(12)3662-4070">
			<p>Data Nascimento:</p>
			<input disabled="" style="width: 90px;" type="text" name="membro_email" value="(12)3662-4070">
			<p class="p_quebra_linha">Você é um:</p>
			<input type="radio" name="sex" value="male"><p>Professor</p><br>
			<input type="radio" name="sex" value="male"><p>Aluno</p><br>
			<input type="radio" name="sex" value="male"><p>Ex-aluno</p><br>
			<input type="radio" name="sex" value="male"><p>Comunidade</p><br>
			<p class="p_quebra_linha"></p>
			<p>Quem indicou:</p>
			<input disabled="" style="width: 630px;" type="text" name="membro_email" value="nata.erafael@gmail.com">
			<p>Data Inscrição:</p>
			<input disabled="" style="width: 90px;" type="text" name="membro_email" value="(12)3662-4070">
			<p>Curso</p>
			<input disabled="" style="width: 90px;" type="text" name="membro_email" value="(12)3662-4070">
			<p>Modulo</p>
			<input disabled="" style="width: 90px;" type="text" name="membro_email" value="(12)3662-4070">
			<p class="p_quebra_linha">Áreas que deseja atuar: (pode ser mais de uma)</p>
			<input type="checkbox" name="vehicle" value="Bike"><p>Programação </p><br>
			<input type="checkbox" name="vehicle" value="Bike"><p>Modelagem 3D </p><br>
			<input type="checkbox" name="vehicle" value="Bike"><p>Desenho </p><br>
			<input type="checkbox" name="vehicle" value="Bike"><p>Qualidade </p><br>
			<input type="checkbox" name="vehicle" value="Bike"><p>Produção</p><br>
			<input type="checkbox" name="vehicle" value="Bike"><p>Administrativo   </p><br>
			<input type="checkbox" name="vehicle" value="Bike"><p>Marketing </p><br>
			<input type="checkbox" name="vehicle" value="Bike"><p>Produção Musical </p><br>
			<input type="checkbox" name="vehicle" value="Bike"><p>Roteirista</p><br>
			<input style="margin-left: 80%;" type="submit" value="Enviar" name="fixa_membro" class="button">
</div>
		
		