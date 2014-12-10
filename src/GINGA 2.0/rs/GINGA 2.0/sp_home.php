<?php 
	include("includes/Myclasses.php");
	include("includes/machine.php");
	require_once("includes/conexao.php");
	session_start(); 
	global $conexao;

	$controle_db = new ControleDB($conexao);
	
	$qry = "SELECT * FROM projetos WHERE id = '{$_SESSION['projeto_at_id']}';";
	$resultado = mysql_query($qry, $conexao);
	$linha		 = mysql_fetch_array($resultado);
	$projeto_atual = new Projeto();
	$projeto_atual->CaregarLinha($linha);
	
	
	
	if(isset($_POST['load_pendencias']))
	{
		$qry = "
			SELECT DISTINCT pd.* FROM pendencias pd
			LEFT JOIN membros_pendencias mp
            ON pd.id = mp.id_pendencia
			WHERE pd.st = {$_POST['st']} AND pd.id_projeto = {$projeto_atual->id};";
		$ls  = mysql_query($qry, $conexao);
		
		if($ls)
		while($linha = mysql_fetch_array($ls))
		if($linha["id"] == $_SESSION['membro_at_id'])
			echo "<li class='quarrel'><p style='display: none'>{$linha['id']}</p><a href='#' class='title'>{$linha['nome']}</a></a><a href='#' class='view_membros'></a><a href='#' class='view'></a></li>";
		else
			echo "<li class='quarrel'><p style='display: none'>{$linha['id']}</p><a href='#' class='title'>{$linha['nome']}</a><a href='#' class='arrastar'></a><a href='#' class='view_membros'></a><a href='#' class='view'></a></li>";
	}	
	
	if(isset($_GET['at_pendencia']))
	{
		$qry = "SELECT * FROM pendencias WHERE id = '{$_GET['id_pendencia']}';";
		
		$res     = mysql_query($qry, $conexao);
		$linha	 = mysql_fetch_array($res);
		
		$pendencia = new Pendencia();
		$pendencia->CaregarLinha($linha);
		$pendencia->st = $_GET['st'];
		$pendencia->Alterar($conexao);
	}
	
?>