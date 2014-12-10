<?php
	include("includes/Myclasses.php"); 
	require_once("includes/conexao.php"); 
	session_start(); 
	
	if(!$_SESSION['sessao']) header("Location: default.php");

	global $conexao;	
	$controle_db = new ControleDB($conexao);
	
	//header("Content-type: text/plain");
  //print_r($_REQUEST);
	
	$qry = "
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
	$resultado 		= mysql_query($qry, $conexao);
	$linha 				= mysql_fetch_array($resultado);
  $membro_atual = new Membro();
  $membro_atual->CaregarLinha($linha);
	
	$qry = "
  SELECT 
    gp.*
  FROM 
    membro_grupos mg
		LEFT JOIN grupos gp ON mg.id_grupo = gp.id 
  WHERE 
    mg.id_membro = '{$membro_atual->id}'
		AND mg.id_grupo = '{$_SESSION['grupo']}';
  ";
	$resultado 		= mysql_query($qry, $conexao);
	$linha 				= mysql_fetch_array($resultado);
	$grupo_atual 			 = new Grupo();
	$grupo_atual->CaregarLinha($linha);
	
	$qry = "
  SELECT 
		*
  FROM 
    projetos pj
  WHERE 
    pj.id_grupo = '{$grupo_atual->id}' AND
		pj.id = '{$_SESSION['projeto']}';
  ";
	$resultado 		 = mysql_query($qry, $conexao);
	$linha 				 = mysql_fetch_array($resultado);
	$projeto_atual = new Projeto();
	$projeto_atual->CaregarLinha($linha);

	if(isset($_GET['subir_tarefa']))
	{
		$consulta = "
		SELECT 
			*
		FROM 
			tarefas
		WHERE 
			id = '{$_GET['subir_tarefa']}';
		";
		$resultado 		 = mysql_query($consulta, $conexao);
		$linha 				 = mysql_fetch_array($resultado);
		$tarefa = new Tarefa();
		$tarefa->CaregarLinha($linha);
		
		$estado    = $controle_db->Tarefa->GetEstado($tarefa->id) + 1;
		
		if ($estado <= 3)
		{
			if($controle_db->ControlarTarefa($tarefa->id, $estado) == 1)
				echo 1;
			else
				echo 0;
		}
		else
			echo 0;
	}
	
	if(isset($_GET['descer_tarefa']))
	{
		$consulta = "
		SELECT 
			*
		FROM 
			tarefas
		WHERE 
			id = '{$_GET['descer_tarefa']}';
		";
		$resultado 		 = mysql_query($consulta, $conexao);
		$linha 				 = mysql_fetch_array($resultado);
		$tarefa = new Tarefa();
		$tarefa->CaregarLinha($linha);
		
		$estado    = $controle_db->Tarefa->GetEstado($tarefa->id) - 1;
		if ($estado >= 1)
		{
			if($controle_db->ControlarTarefa($tarefa->id, $estado) == 1)
				echo 1;
			else
				echo 0;
		}
		else
			echo 0;
	}	
	
	if(isset($_GET['tarefa']))
	{
		$consulta = "
		SELECT 
			*
		FROM 
			tarefas t
		WHERE 
			t.id = '{$_GET['tarefa']}'
		;";
		$resultado 		 = mysql_query($consulta, $conexao);
		$linha 				 = mysql_fetch_array($resultado);
		$tarefa = new Tarefa();
		$tarefa->CaregarLinha($linha);
		
		echo	"<input id='hide_tarefa' type='button' class='bt_fechar'/>
					 <h2>{$tarefa->nome}</h2>
					 <p>Descri&ccedil&atildeo: {$tarefa->descricao}</p>";
					
		$qry = " 
		SELECT
			m.*
		FROM
			membros m
			LEFT JOIN membro_grupos mg ON m.id = mg.id_membro
			LEFT JOIN membros_projetos mp ON mg.id = mp.id_membro_grupo
			LEFT JOIN membros_tarefas mt  ON mt.id_membro_projeto = mp.id
		WHERE
			mt.id_tarefa = '{$tarefa->id}'
		;";
		$result = mysql_query($qry, $conexao);
		echo "<h3>Envolvidos nesta tarefa:</h3>";
		echo "<ul>";
		while($linha = mysql_fetch_array($result))
		{
			echo "<li id='tf".$linha['id']."'><a name='view_membro' href='#{$linha['id']}'>".$linha['nome']."</a></li>";
		}		
		echo "</ul>";
	}
	
	if(isset($_GET['view_membro']))
	{
		$consulta = " 
		SELECT
			*
		FROM
			membros
		WHERE id = {$_GET['view_membro']}
		;";
		$resultado = mysql_query($consulta, $conexao);
		
		while($linha = mysql_fetch_array($resultado))
		{						
			echo "<h2 style='width: 100%;'>".$linha["nome"]."</h2>
						<img src='img/logo.png'/>						
						<p>nome:</p>
						<input type='text' name='membro_nome' value='".$linha["nome"]."'/>
						<p>Email:</p>
						<input type='text' name='membro_email' value='".$linha["e_mail"]."'/>";
		}	
		
	}
	
	if(isset($_GET['chat']))
	{
		$novo_chat = new Chat();
		$novo_chat->conteudo  = $_REQUEST['conteudo'];
		$novo_chat->id_grupo  = $_SESSION['grupo'];
		$novo_chat->id_membro = $_SESSION['id'];
		
		if($controle_db->Chat($novo_chat) == 1)
		{
			$qry = " 
			SELECT
				c.*,
				m.nome
			FROM
				chat c
			INNER JOIN membros m ON c.id_membro = m.id
			ORDER BY c.data_hora DESC
			;";
			$resultado = mysql_query($qry, $conexao);
			
			while($linha = mysql_fetch_array($resultado))
			{
				echo '<h3>'.$linha['nome'].'<p>'.$linha['data_hora'].'</p></h3>';
				echo "<p style='margin-bottom:15px; margin-top: -10px; background: #85cecf; margin-left: 20px;'>{$linha['conteudo']}</p>";
			}	
		}
		else
			echo "Erro!";
	}	
	
	if(isset($_GET['at_chat']))
	{
		$qry = " 
		SELECT
			c.*,
			m.nome
		FROM
			chat c
		INNER JOIN membros m ON c.id_membro = m.id
		ORDER BY c.data_hora DESC
		;";
		$resultado = mysql_query($qry, $conexao);
		
		while($linha = mysql_fetch_array($resultado))
		{
			echo '<h3>'.$linha['nome'].'<p>'.$linha['data_hora'].'</p></h3>';
			echo "<p style='margin-bottom:15px; margin-top: -10px; background: #85cecf; margin-left: 20px;'>{$linha['conteudo']}</p>";
		}
	}
	
	

?>