<?php
	require("constantes.php");
	// 1. Cria a conexao com o banco de dados
	$conexao = mysql_connect($mysql_host, $mysql_user, $mysql_password);
	
	if(!$conexao) {
		die("Falha na conexao: " . mysql_error());
	}
	
	// 2. Seleciona o banco de dados a ser utilizado
	$banco = mysql_select_db($mysql_database, $conexao);
	if(!$banco) {
		die("Falha na selecao do banco: " . mysql_error());
	}
?>