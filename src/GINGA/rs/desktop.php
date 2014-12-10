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
    mg.id_membro = '{$membro_atual->id}'
		AND mg.id_grupo = '{$_SESSION['grupo']}';
  ";
	$resultado 		= mysql_query($consulta, $conexao);
	$linha 				= mysql_fetch_array($resultado);
	$grupo_atual  = new Grupo();
	$grupo_atual->CaregarLinha($linha);
	
	$consulta = "
  SELECT 
		*
  FROM 
    projetos pj
  WHERE 
		pj.id = '{$_SESSION['projeto']}';
  ";
	$resultado 		 = mysql_query($consulta, $conexao);
	$linha 				 = mysql_fetch_array($resultado);
	$projeto_atual = new Projeto();
	$projeto_atual->CaregarLinha($linha);
	
	$consulta = "
	SELECT 
		*
	FROM 
		tarefas tr
	WHERE 
		tr.id_projeto = '{$projeto_atual->id}';
	";
	$resultado 		 = mysql_query($consulta, $conexao);
	$linha 				 = mysql_fetch_array($resultado);
	$tarefa_atual = new Tarefa();
	$tarefa_atual->CaregarLinha($linha);

?>
	<title><?php echo $membro_atual->nome ?></title>
  <link rel="shortcut icon" href="img/ico.png" />
	<link rel="stylesheet" type="text/css" href="css/global.css" />
	<script type="text/javascript" src="java/jquery.min.js"></script>  
	<script type="text/javascript" src="java/jquery.validate.js"></script>
	<script type="text/javascript" src="java/desktop.js"></script> 
  <script language="javascript" type="text/javascript" src="java/escripts.js"></script>

</head>
<body>
	<div id="carregar" style="display:none;"><img  src="img/ld.gif" style="position: fixed; left: 45%; top:40%;"  width="100px"/></div>
	<div class="cabecario">
    <h1><?php echo $membro_atual->nome ?></h1>
		<ul>
			<li><a id="arquivos" href='#'>Arquivos</a></li>
			<li><a href="#" id="view_chat">Chat</a></li>
			<li><a href="home.php">Retornar</a></li>
			<li><a name="sair" href='#'>Sair</a></li>
<?php

	$consulta = "
	SELECT 
		*
	FROM 
		gerentes
	WHERE 
		id_membro = '{$membro_atual->id}' AND
		id_grupo  = '{$grupo_atual->id}';
	";
	$resultado 		= mysql_query($consulta, $conexao);
	
	if (mysql_num_rows($resultado) > 0)
		echo '<li><a style="background:#003535; color:#FFFFFF" href="gerencia.php">Gerencia</a></spam></li>';
		
?>
		</ul>
  </div>
  
	<div class="fm" style="height:30px; margin-top: 60px">
		<h2><?php echo $grupo_atual->nome." - ".$projeto_atual->nome; ?></h2>
  </div>
  
	<div id='div_s_tarefas' class="fm_tarefas" style="height:150px; background: url(../img/cd.png)  no-repeat; background-position: -50px 0; background-size:108% 100%;">
    <h2>Suas Tarefas</h2>
<?php
	
	$id_membro_projeto = $controle_db->Membro->GetIdMembroGrupoProjeto($membro_atual->id, $grupo_atual->id, $projeto_atual->id);
	
	$qry = "
  SELECT 
    t.*
  FROM 
    membros_tarefas mt
		INNER JOIN tarefas t ON mt.id_tarefa = t.id
  WHERE 
    id_membro_projeto	= '{$id_membro_projeto}'
	;";
	$resultado 		= mysql_query($qry, $conexao);
	
	while($linha = mysql_fetch_array($resultado))
	{
		$estado = $controle_db->Tarefa->GetEstado($linha['id']);
	
		echo "<div class='tarefa' >
						<h2>".$linha['nome']."</h2>
						<div id='tarefa".$linha['id']."' class='acoes'>";	
		if($estado == 1)
		{
			echo	"<a name='subir_tarefa' class='subir' href='#".$linha['id']."'></a>";
			echo	"<a style='display: none' name='descer_tarefa' class='descer' href='#".$linha['id']."'></a>";
		}	
		if($estado == 2)	
		{
			echo	"<a name='subir_tarefa' class='subir' href='#".$linha['id']."'></a>";
			echo	"<a name='descer_tarefa' class='descer' href='#".$linha['id']."'></a>";
		}	
		if($estado == 3)	
		{
			echo	"<a style='display: none' name='subir_tarefa' class='subir' href='#".$linha['id']."'></a>";
			echo	"<a name='descer_tarefa' class='descer' href='#".$linha['id']."'></a>";
		}
		echo "<a class='visualizar' name='view_tarefa' href='#".$linha['id']."'></a>";
		echo		"</div>	
					</div>";
	/*
		if($estado == 1)
			echo "<a style='background: #d25858;' href='desktop.php?subir_tarefa=".$linha['id']."'>".$linha['nome']."</a>";
		if($estado == 2)
			echo "<a style='background: #5BD258;' href='desktop.php?subir_tarefa=".$linha['id']."'>".$linha['nome']."</a>";
		if($estado == 3)
			echo "<a style='background: #807DBC;' href='desktop.php?subir_tarefa=".$linha['id']."'>".$linha['nome']."</a>";
		
		if($estado < 3)
			echo "<a style='width:50px; height: 20px; float:left; color:#000000;' href='desktop.php?subir_tarefa=".$linha['id']."'>Subir</a>";
		if($estado >		1)
			echo "<a style='width:50px; height: 20px; float:left; color:#000000;' href='desktop.php?descer_tarefa=".$linha['id']."'>Descer</a>";
	*/
	}
	
?>	
  </div>
		
	<div class="fm" style="height:400px;">
    <h2>Tarefas</h2>
    
		<div id="tf_criadas">
      <h3>Criadas</h3>
      <ul>
<?php

	$consulta = " 
  SELECT
		t.*
  FROM
		tarefas t
		INNER JOIN controle_tarefas c ON c.id_tarefa = t.id 
	WHERE
		t.id_projeto = '{$projeto_atual->id}'
	GROUP BY t.id
	;";
	$resultado = mysql_query($consulta, $conexao);
		
	while($linha = mysql_fetch_array($resultado))
	{
		if($controle_db->Tarefa->GetEstado($linha['id']) == 1)
			echo "<li id='tf".$linha['id']."'><a name='view_tarefa' href='#".$linha['id']."'>".$linha['nome']."</a></li>";
	}
	
?>
      </ul>
		</div>
    
		<div id="tf_fezendo">
			<h3>Fazendo</h3>
			<ul>
<?php

	$consulta = " 
  SELECT
		t.*
  FROM
		tarefas t
		INNER JOIN controle_tarefas c ON c.id_tarefa = t.id 
	WHERE
		t.id_projeto = '{$projeto_atual->id}'
	GROUP BY t.id
	;";
	$resultado = mysql_query($consulta, $conexao);
	
	while($linha = mysql_fetch_array($resultado))
	{
		if($controle_db->Tarefa->GetEstado($linha['id']) == 2)
		echo "<li id='tf".$linha['id']."'><a name='view_tarefa' href='#".$linha['id']."'>".$linha['nome']."</a></li>";
	}
	
?>
			</ul>
		</div>
    
		<div id="tf_feita">
			<h3>Feitas</h3>
			<ul>
<?php

	$consulta = " 
  SELECT
		t.*
  FROM
		tarefas t
		INNER JOIN controle_tarefas c ON c.id_tarefa = t.id 
	WHERE
		t.id_projeto = '{$projeto_atual->id}'
	GROUP BY t.id
	;";
	$resultado = mysql_query($consulta, $conexao);
	
	while($linha = mysql_fetch_array($resultado))
	{
		if($controle_db->Tarefa->GetEstado($linha['id']) == 3)
		echo "<li id='tf".$linha['id']."'><a name='view_tarefa' href='#".$linha['id']."'>".$linha['nome']."</a></li>";
	}		
	
?>
			</ul>
		</div>
  </div>
	
  <div class="fm" style="height:250px;">
    <h2 style="color: #003535;">Membros</h2>
		<ul class="v_membros">
<?php

	$consulta = " 
  SELECT
		mb.*
  FROM
		membros_projetos mp
		LEFT JOIN membro_grupos mg ON mg.id = mp.id_membro_grupo
		LEFT JOIN membros mb ON mg.id_membro = mb.id
	WHERE 
		mp.id_projeto = '{$projeto_atual->id}'
	;";
	$resultado = mysql_query($consulta, $conexao);
	
	while($linha = mysql_fetch_array($resultado))
	{
    echo "<li>
              <img src='img/logo.png' width='150px'/>
              <a href='#{$linha['id']}' name='view_membro'>".$linha['nome']."</a>
          </li>";
  
	}		
	
?>
		</ul>
  </div>
  
	<div class="fm_perfil" id="fm_perfil" style="width:350px; height: 450px; top: -450px; display: none;">
		<input id="hide_perfil" type="button" class="bt_fechar"/>
		<div>
			<img src='img/logo.png'/>
			<h2><?php echo $membro_atual->nome;?></h2>
			<p>nome:</p>
			<input type="text" name="membro_nome" value="<?php echo $membro_atual->nome;?>"/>
			<p>Email:</p>
			<input type="text" name="membro_email" value="<?php echo $membro_atual->e_mail;?>"/>
		</div>
  </div>
	
	<div class="fm_chat" id="fm_chat" style="width:450px; height: 550px; display: none;">
		<input id="hide_chat" type="button" class="bt_fechar"/>
		<h2><?php echo $membro_atual->nome;?></h2>
		<textarea></textarea>
		<div>
<?php

	$consulta = " 
	SELECT
		c.*,
		m.nome
	FROM
		chat c
	INNER JOIN membros m ON c.id_membro = m.id
	ORDER BY c.data_hora DESC
	;";
	$resultado = mysql_query($consulta, $conexao);
	
	while($linha = mysql_fetch_array($resultado))
	{
		echo '<h3>'.$linha['nome'].'<p>'.$linha['data_hora'].'</p></h3>';
    echo "<p style='margin-bottom:15px; margin-top: -10px; background: #85cecf; margin-left: 20px;'>{$linha['conteudo']}</p>";
  
	}		
	
?>
	
		</div>
  </div>
	
	<div class="fm_view" id="fm_view_tarefa" style="width:450px; height: 210px; top: -210px; display: none;">
			<h2></h2>
			<input id="hide_tarefa" type="button" class="bt_fechar"/>
			<p></p>
	</div>
	
	<div class="fm_cd" id="fm_baixar" style="width:350px; height: 210px; display: none;">
			<input style="margin-left:300px;" id="hide_baixar" type="button" class="bt_fechar"/>
			<h2>Arquivos</h2>
			<a href="Folha Resumo.pdf">Folha Resumo click para baixar!</a>
	</div>
	
	<div id="lock" style="display: none; background:#FFFFFF"></div>		
	
</body>
</html>
