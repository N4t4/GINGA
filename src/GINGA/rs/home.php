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
    mb.*
  FROM 
    membros mb
  WHERE 
    mb.id = {$_SESSION['id']};
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
    mg.id_membro = {$membro_atual->id};
  ";
	$resultado 		= mysql_query($consulta, $conexao);
	$linha 				= mysql_fetch_array($resultado);
	$grupo_atual 	= new Grupo();
	$grupo_atual->CaregarLinha($linha);
	
	$consulta = "
  SELECT 
		*
  FROM 
    projetos pj
  WHERE 
    pj.id_grupo = '{$grupo_atual->id}';
  ";
	$resultado 		 = mysql_query($consulta, $conexao);
	$linha 				 = mysql_fetch_array($resultado);
	$projeto_atual = new Projeto();
	$projeto_atual->CaregarLinha($linha);
	
  $consulta = " 
	SELECT
		*
	FROM
		membros_fotos
   WHERE
    id_proprietario='{$membro_atual->id}'
	";
	$resultado = mysql_query($consulta, $conexao);
  //$suafoto = mysql_fetch_array($resultado);
?>
	<title><?php echo $membro_atual->nome ?></title>
  <link rel="shortcut icon" href="img/ico.png" />
	<link rel="stylesheet" type="text/css" href="css/global.css" />
	<script type="text/javascript" src="java/jquery.min.js"></script>  
	<script type="text/javascript" src="java/jquery.validate.js"></script>
	<script type="text/javascript" src="java/home.js"></script> 
</head>
<body>
	<div id="carregar" style="display:none;"><img  src="img/ld.gif" style="position: fixed; left: 45%; top:40%;"  width="100px"/></div>
  <div class="cabecario">
    <h1><?php echo $membro_atual->nome ?></h1>
		<ul>
			<li><input type="button" id='view_perfil' value="Perfil" class="button" style="margin:0; margin-top:-10px; float:right; "/></li>
			<li><a name="sair" href='#'>Sair</a></li>
		</ul>
  </div>
  
	<div class="fm" style="height:280px; margin-top: 60px;">
		<form action="" method="post" id="form_proximo">
			<h2>Grupos</h2>
			<select name="sel_grupos" id="sel_grupos">
<?php

	$consulta = " 
  SELECT
    gp.*
  FROM
		membro_grupos  mg
		LEFT JOIN grupos gp ON gp.id = mg.id_grupo
	WHERE
		mg.id_membro = '{$membro_atual->id}'
	";
	$resultado = mysql_query($consulta, $conexao);
	
	while($linha = mysql_fetch_array($resultado))
	{
		echo "<option value=".$linha['id'].">".$linha['nome']."</option>";
	}		
	
?>
			</select>
			<h2>Projetos	</h2>
<?php

	$consulta = " 
  SELECT
    gp.*
  FROM
		membro_grupos  mg
		LEFT JOIN grupos gp ON gp.id = mg.id_grupo
	WHERE
		mg.id_membro = '{$membro_atual->id}'
	";
	$resultado = mysql_query($consulta, $conexao);
	
	while($linha = mysql_fetch_array($resultado))
	{
		$id_membro_grupo = $controle_db->Membro->GetIdMembroGrupo($membro_atual->id, $linha['id']);
	
		$consulta = " 
		SELECT
			pj.*
		FROM
			projetos pj
			LEFT JOIN membros_projetos mp ON pj.id = mp.id_projeto
		WHERE
			pj.id_grupo  = '{$linha['id']}' AND
			mp.id_membro_grupo = '{$id_membro_grupo}'
		";
		$sub_resultado = mysql_query($consulta, $conexao);
			
		echo "<select style='display: none;' name='sel_projeto_gr".$linha['id']."'>";
		while($sub_linha = mysql_fetch_array($sub_resultado))
		{
			echo "<option value=".$sub_linha['id'].">".$sub_linha['nome']."</option>";
		}
		echo "</select>";
	}
?>		
		
			<input type="submit" value="Prosseguir" name="prosseguir" class="button"/>
			<input id="view_c_g" type="button" value="Criar Grupo" class="button" style="font-size:15px;"/>
		</form>
  </div>
	
	<div class="fm_cd" id="fm_c_grupo" style="width:350px; height: 210px; display: none;">
		<form action="" method="post" id="form_novo_grupo">
			<input id="hide_c_g" type="button" class="bt_fechar"/>
			<h2>Criar um Grupo</h2>
			<p>nome:</p>
			<input type="text" name="grup_nome"/>
			<p>Senha de Gerente:</p>
			<input type="password" name="ger_senha"/>
			<input type="submit" value="Criar" name="novo_grupo" class="button"/>
		</form>
	</div>
  
  <div class="fm_perfil" id="fm_perfil" style="width:350px; height: 450px; display: none;">
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" name="cadastro" >
			<input id="hide_perfil" type="button" class="bt_fechar"/>
			<h2><?php echo $membro_atual->nome;?></h2>
      <img src='img/logo.png'/>
			<p>nome:</p>
			<input type="text" name="membro_nome" value="<?php echo $membro_atual->nome;?>"/>
			<p>Email:</p>
			<input type="text" name="membro_email" value="<?php echo $membro_atual->e_mail;?>"/>
  	</form>
	</div>
	
	<div id="lock" style="display:none"></div>
</body>
</html>
