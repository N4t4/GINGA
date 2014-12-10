<?php 
	include("includes/Myclasses.php"); 
	require_once("includes/conexao.php"); 
	session_start(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<?php

	if(!$_SESSION['sessao']) header("Location: default.php");
	
	global $conexao;
	$controle_db = new ControleDB($conexao);
	
	$consulta = "
  SELECT 
    mb.*,
		gr.nome AS nome_grupo,
		gr.id AS id_grupo
  FROM 
    membros mb
		LEFT JOIN membro_grupos mbg ON mb.id = mbg.id_membro
		LEFT JOIN grupos gr ON gr.id = mbg.id_grupo
  WHERE 
    mb.id = '{$_SESSION['id']}';
  ";
	$resultado 		= mysql_query($consulta, $conexao);
	$linha 				= mysql_fetch_array($resultado);
  $membro_atual = new Membro();
  $membro_atual->CaregarLinha($linha);
								
	$consulta = "
  SELECT 
    gp.*
  FROM 
    membro_grupos mg
		LEFT JOIN grupos gp ON mg.id_grupo = gp.id 
  WHERE 
    mg.id_membro = '{$membro_atual->id}'
		AND mg.id_grupo = '{$_SESSION['grupo']}';
  ";
	$resultado 		= mysql_query($consulta, $conexao);
	$linha 				= mysql_fetch_array($resultado);
	$grupo_atual 			 = new Grupo();
	$grupo_atual->CaregarLinha($linha);
	
	if($_SESSION['projeto'])
		$consulta = "
		SELECT 
			*
		FROM 
			projetos pj
		WHERE 
			pj.id_grupo = '{$grupo_atual->id}' AND
			pj.id = '{$_SESSION['projeto']}';
		";
	else
		$consulta = "
		SELECT 
			*
		FROM 
			projetos pj
		WHERE 
			pj.id_grupo = '{$grupo_atual->id}'
		";
		
	$resultado 		 = mysql_query($consulta, $conexao);
	$linha 				 = mysql_fetch_array($resultado);
	$projeto_atual = new Projeto();
	$projeto_atual->CaregarLinha($linha);
	
	if($controle_db->Membro->GerenteDeGrupo($membro_atual->id,$grupo_atual->id) == 0)
	{
		$_SESSION['sessao'] = false;
		$_SESSION['id']     = false;
		echo "<script type='text/javascript'> alert('Você será Investigado!');</script>";		
		header("Location: default.php");
	};
	
	
?>
	<title><?php echo $membro_atual->nome?></title>
  <link rel="shortcut icon" href="img/ico.png" />
	<link rel="stylesheet" type="text/css" href="css/global.css" />
	<script type="text/javascript" src="java/jquery.min.js"></script>  
	<script type="text/javascript" src="java/jquery.validate.js"></script>
  <script language="javascript" type="text/javascript" src="java/escripts_g.js"></script>
</head>
<body>
<!-- <div style="display: none"> -->
		
		<div id="carregar" style="display:none;"><img  src="img/ld.gif" style="position: fixed; left: 45%; top:40%;"  width="100px"/></div>
		<div class="cabecario">
			<h1><?php echo $membro_atual->nome." - >"?></h1>
			<h1><?php echo $grupo_atual->nome?></h1>
			<ul>
				<li><a href="desktop.php">Retorna</a></li>
				<li><a name="sair" href='#'>Sair</a></li>
			</ul>
		</div>
				
		<div class="fm_modulos">
			<ul>
				<li><a href="gerencia.php">Atividades</a></li>
				<li><a href="g_membros.php">Membros</a></li>
				<li><a class="selected" href="g_graficos.php">Graficos</a></li>
			</ul>
		</div>
			
		<div class="fm" style="margin-top:75px;">
			<div id="div_grafico" style="height:570px; margin-top:5px;">
				oi
			</div>
		</div>
		
	<div id="lock" style="display:none"></div>
</body>
</html>
