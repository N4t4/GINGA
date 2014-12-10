<?php
	
	include("includes/Myclasses.php"); 
	require_once("includes/conexao.php"); 
	session_start(); 
	
	//header("Content-type: text/plain");
  //print_r($_REQUEST);
	
	global $conexao;
	$controle_db = new ControleDB($conexao);
	
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
	
	if(isset($_POST['novo_projeto']))
	{
		$novo_projeto = new Projeto();
		$novo_projeto->nome     = $_POST['proj_nome'];
		$novo_projeto->situacao = 1;
		$novo_projeto->id_grupo = $grupo_atual->id;
		
		if($controle_db->Projeto->Inserir($novo_projeto) == 1)
		{
			$_SESSION['projeto'] = $novo_projeto->id;
			echo "<option value=".$novo_projeto->id.">".$novo_projeto->nome."</option>";
		}
		else	
			echo 0;
	}
	
	if(isset($_GET['nova_tarefa']))
	{
		$_SESSION['projeto'] = $_REQUEST['sel'];
		
		$nova_tarefa = new Tarefa();
		$nova_tarefa->nome        = $_REQUEST['nome'];
		$nova_tarefa->descricao   = $_REQUEST['descricao'];
		$nova_tarefa->id_projeto  = $_REQUEST['sel'];
		
		if($controle_db->Tarefa->Inserir($nova_tarefa) == 1 &&  
			 $controle_db->ControlarTarefa($nova_tarefa->id, 1) == 1)
			echo "<option value=".$nova_tarefa->id.">".$nova_tarefa->nome."</option>";
		else
			echo 0;
	}
	
	if(isset($_POST['associar_membro_projeto']))
	{
		$erros = 0;
		$html = "";
		
		if(isset($_REQUEST["vetor"])) 
		{
      for($i = 0; $i < count($_REQUEST["vetor"]); $i++) 
			{
        $id_membro_grupo = $_REQUEST["vetor"][$i];
				if($controle_db->AssociarMembroGrupoProjeto($id_membro_grupo, $_REQUEST['sel']) == 1)
				{
				  $id_  = $controle_db->SelUltimo('membros_projetos');
				  $membro_projeto = new Membro();
				  $membro_projeto = $controle_db->Membro->GetMembroPorIdProjeto($id_);
					$html = $html."<option value={$id_}>{$membro_projeto->nome}</option>";
				}
				else
					$erros++;
			}
    }
		
		if($erros == 0)
			echo $html;
		else
			echo 0;
	}
	
	if(isset($_POST['associar_grupo']))
	{	
		$erros = 0;
		$html = "";
		
		if(isset($_REQUEST["vetor"])) 
		{
      for($i = 0; $i < count($_REQUEST["vetor"]); $i++) 
			{
        $id_membro = $_REQUEST["vetor"][$i];
				
				if($controle_db->AssociarMembroGrupo($id_membro, $grupo_atual->id) == 1)
				{
				  $id_  				= $controle_db->SelUltimo('membro_grupos');
				  $membro_grupo = new Membro();
				  $membro_grupo = $controle_db->Membro->GetMembroPorIdGrupo($id_);
					
					$html =	"<li>
										<img src='img/logo.png' width='150px'>
										<a href='Nata'>{$membro_grupo->nome}</a>
									</li>";
				}
				else
					$erros++;
			}
    }
		
		if($erros == 0)
			echo $html;
		else
			echo 0;
	}
	
	if(isset($_POST['associar_tarefa']))
	{
		$id_membro_projeto = $_REQUEST['membro'];
		$id_tarefa         = $_REQUEST['tarefa'];
			
		if($controle_db->AssociarMembroGrupoProjetoTarefa($id_membro_projeto, $id_tarefa) == 1) 
		{	
			$id_  				= $controle_db->SelUltimo('membros_tarefas'); 
			$membro_tarefa = new Tarefa();
			$membro_tarefa = $controle_db->Membro->GetMembroPorIdProjeto($id_membro_projeto);
			echo "<option value=".$id_.">".$membro_tarefa->nome."</option>";
		}
		else
		{
			echo 0;
		}
	}
	
	if(isset($_GET['set_membro_tarefa']))
	{		
		$qry = "
		SELECT
			m.*
		FROM
			membros_tarefas mt
			INNER JOIN membros_projetos mp ON mt.id_membro_projeto = mp.id
			INNER JOIN membro_grupos    mg ON mp.id_membro_grupo   = mg.id
			INNER JOIN membros          m  ON mg.id_membro         = m.id
		WHERE
			mt.id_tarefa = '{$_REQUEST['taref']}'
		;";
		
		$resultado = mysql_query($qry, $conexao);
		while($linha = mysql_fetch_array($resultado))
		{
			$estado = $controle_db->Tarefa->GetEstado($_REQUEST['taref']);
			if($estado == 1)
				echo "<option style='background: #d25858' value=".$linha['id'].">".$linha['nome']."</option>";
			if($estado == 2)
				echo "<option style='background: #5bd258' value=".$linha['id'].">".$linha['nome']."</option>";
			if($estado == 3)
				echo "<option style='background: #807dbc' value=".$linha['id'].">".$linha['nome']."</option>";
		}
	}
	
	if(isset($_GET['set_tarefa']))
	{		
		$_SESSION['projeto'] = $_REQUEST['proj'];
		
		$qry = " 
		SELECT
			*
		FROM
			tarefas
		WHERE
			id_projeto = '{$_REQUEST['proj']}'
		";
		$resultado = mysql_query($qry, $conexao);
		
		while($sub_linha = mysql_fetch_array($resultado))
		{
			echo "<option value=".$sub_linha['id'].">".$sub_linha['nome']."</option>";
		}
	}	
	
	if(isset($_GET['set_membro']))
	{		
		$_SESSION['projeto'] = $_REQUEST['proj'];
		
		$qry = " 
		SELECT
			mp.id,
			mb.nome
		FROM
			membros_projetos mp
			LEFT JOIN membro_grupos mg ON mg.id = mp.id_membro_grupo
			LEFT JOIN membros mb ON mg.id_membro = mb.id
		WHERE 
			mp.id_projeto = '{$projeto_atual->id}'
		";
		$resultado = mysql_query($qry, $conexao);

		while($linha = mysql_fetch_array($resultado))
		{
			echo "<option value=".$linha['id'].">".$linha['nome']."</option>";
		}
	}

	
?>
