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
	
	
	if(isset($_POST['load_mebros_pendentes'])){
		$qry = "SELECT * FROM membros WHERE st = 0;";
		$ls  = mysql_query($qry, $conexao);
		
		if($ls)
		while($linha = mysql_fetch_array($ls))
			echo "<li class='box-membro'><a href='#'><img class='talking' src='img/logo.png' alt='{$linha['nome']}'/></a><label>{$linha['nome']}</label><a href='#' id='{$linha['id']}' class='bt_cancel'>Remover</a><a id='{$linha['id']}' href='#' class='bt_ok'>Confirmar</a></li>";
	}	
	if(isset($_POST['permitir_membro'])){
		
		$gerente = new Gerente();
		
		$qry = "SELECT * FROM membros WHERE id = '{$_POST['id_membro']}';";
		$resultado = mysql_query($qry, $conexao);
		$linha		 = mysql_fetch_array($resultado);
		$membro    = new Membro();
		$membro->CaregarLinha($linha);
		
		echo $gerente->PermitirMembro($conexao,$membro);		
	}
	
	if(isset($_POST['change_projeto'])){
		$_SESSION['projeto_at_id'] = $_POST['id_projeto'];
		header("Location: default.php");
	}
	
	
	if(isset($_POST['get_projeto_by_id']))
	{
			$qry = "SELECT * FROM projetos WHERE id = '{$_POST['id_projeto']}';";
		$resultado   = mysql_query($qry, $conexao);
		$linha		 = mysql_fetch_array($resultado);
		$projeto = new Projeto();
		$projeto->CaregarLinha($linha);
			
			$my = array('nome'=>$projeto->nome,'id'=>$projeto->id);
			$myJSON = json_encode($my);

			echo($myJSON);
	}
	
	if(isset($_POST['get_all_projetos']))
	{
		$qry = "SELECT * FROM projetos;";
		$ls  = mysql_query($qry, $conexao);
		
		while($linha = mysql_fetch_array($ls))
		if( $projeto_atual->id == $linha["id"])
			echo "<li class='selected' style='background-image: url(imgpj01.png);'><a id='{$linha["id"]}' href='#' class='title'>{$linha["nome"]}</a><a id='{$linha["id"]}' href='#' class='view'></a></li>";
		else
			echo "<li style='background-image: url(imgpj01.png);'><a id='{$linha["id"]}' href='#' class='title'>{$linha["nome"]}</a><a id='{$linha["id"]}' href='#' class='view'></a></li>";
	}	
	if(isset($_POST['get_all_membros']))
	{
		$qry = "SELECT * FROM membros;";
		$ls  = mysql_query($qry, $conexao);
		
		while($linha = mysql_fetch_array($ls))
			echo "<li class='box-membro'><a id='{$linha['id']}' href='#'><img class='talking' alt='{$linha['nome']}' src='img/logo.png'/></a></li>";
	}	
	
	
	if(isset($_POST['get_ls_not_projeto']))
	{
		$qry = "
		SELECT DISTINCT
			mb.* 
		FROM membros mb
			LEFT JOIN membros_projetos mp ON mp.id_membro = mb.id
		WHERE 
			mp.id_projeto!='{$_POST['id_projeto']}' OR
			mp.id_projeto IS NULL "; 
        
		$ls  = mysql_query($qry, $conexao);
		if($ls)
		while($linha = mysql_fetch_array($ls))
			echo "<li class='box-membro'><a id='{$linha['id']}' href='#'><img class='talking' alt='{$linha['nome']}' src='img/logo.png'/></a></li>";
	}
	if(isset($_POST['get_ls_membros_in_projeto']))
	{
		$qry = "
		SELECT DISTINCT
			mb.* 
		FROM membros mb
			INNER JOIN membros_projetos mp ON mp.id_membro = mb.id
		WHERE mp.id_projeto='{$_POST['id_projeto']}';";

		$ls  = mysql_query($qry, $conexao);
		if($ls)
		while($linha = mysql_fetch_array($ls))
			echo "<li class='box-membro'><a id='{$linha['id']}' href='#'><img class='talking' alt='{$linha['nome']}' src='img/logo.png'/></a></li>";
	}	
	
	if(isset($_POST['get_ls_membros_in_pendencia']))
	{
		$qry = "
		SELECT DISTINCT
			mb.* 
		FROM membros mb
			INNER JOIN membros_pendencias mp ON mp.id_membro = mb.id
		WHERE mp.id_pendencia='{$_POST['id_pendencia']}';";

		$ls  = mysql_query($qry, $conexao);
		if($ls)
		while($linha = mysql_fetch_array($ls))
			echo "<li class='box-membro'><a id='{$linha['id']}' href='#'><img class='talking' alt='{$linha['nome']}' src='img/logo.png'/></a></li>";
	}	
	if(isset($_POST['get_ls_membros_not_pendencia']))
	{
		$qry = "
		SELECT DISTINCT
			mb.* 
		FROM membros mb
			LEFT JOIN membros_pendencias mp ON mp.id_membro = mb.id
		WHERE 
			mp.id_pendencia!='{$_POST['id_pendencia']}' OR
			mp.id_pendencia IS NULL;";
			
		$ls  = mysql_query($qry, $conexao);
		if($ls)
		while($linha = mysql_fetch_array($ls))
			echo "<li class='box-membro'><a id='{$linha['id']}' href='#'><img class='talking' alt='{$linha['nome']}' src='img/logo.png'/></a></li>";
	}	
	

  if(isset($_GET['get_session']))
	{
		echo $projeto_atual->id;
	}

	if(isset($_GET['sair']))
	{
		$_SESSION['id']    = -1;
		$_SESSION['sessao']= false;
		echo 1;
	}
	
	if(isset($_POST['add_pendencia']))
	{
		$nova_pendencia = new Pendencia();
		$nova_pendencia->dt_termino = $_POST["pend_termino"];
		$nova_pendencia->st         = 1;
		$nova_pendencia->nome       = $_POST["pend_nome"];
		$nova_pendencia->dt_inicio  = 'NOW()';
		$nova_pendencia->id_area    = $_POST["pend_id_area"];
		$nova_pendencia->id_projeto = $_SESSION['projeto_at_id'];
		
		if(!$nova_pendencia->Criar($conexao))
			echo 0; 
		else{
			if(count($_POST["pend_id_membros"]) > 1)
			for($i = 0; $i < count($_POST["pend_id_membros"]); $i++) 
			{
        $id_membro = $_POST["pend_id_membros"][$i];
				$nova_pendencia->AtrMembro($conexao, $id_membro);
			}
		
			$qry = "SELECT * FROM pendencias;";
			$ls  = mysql_query($qry, $conexao);
			while($linha = mysql_fetch_array($ls))
				echo "<li><a id='{$linha['nome']}' href='#' class='title'>{$linha['nome']}</a></li>";
		}
	}

	if(isset($_POST['add_projeto']))
	{
		$novo_projeto = new Projeto();
		$novo_projeto->nome = converte_html($_POST['proj_nome']);
		
		if(!$novo_projeto->Criar($conexao))
			echo 0; 
		else{
			if(count($_POST["proj_id_membros"]) >= 1)
			for($i = 0; $i < count($_POST["proj_id_membros"]); $i++) 
			{
				if($_POST["proj_id_membros"][$i])
				{
					$id_membro = $_POST["proj_id_membros"][$i];
					$novo_projeto->AtrMembro($conexao, $id_membro);
				}
			}	
				
			$qry = "SELECT * FROM projetos;";
			$ls  = mysql_query($qry, $conexao);
			while($linha = mysql_fetch_array($ls))
				echo "<li class='selected' style='background-image: url(imgpj01.png);'><a id='{$linha["id"]}' href='#' class='title'>{$linha["nome"]}</a><a href='#' class='view'></a></li>";
		}
	}

    if(isset($_POST['edit_projeto']))
	{
		$projeto = new Projeto();
		$projeto->nome = converte_html($_POST['proj_nome']);
        $projeto->id   = converte_html($_POST['proj_id']);
		
		if(!$projeto->Alterar($conexao))
			echo 0; 
		else{
            $controle_db->ExecuteQry("DELETE FROM membros_projetos WHERE id_projeto = {$projeto->id};");
            
			if(count($_POST["proj_id_membros"]) >= 1)
			for($i = 0; $i < count($_POST["proj_id_membros"]); $i++) 
			{
				if($_POST["proj_id_membros"][$i])
				{
					$id_membro = $_POST["proj_id_membros"][$i];
					$projeto->AtrMembro($conexao, $id_membro);
				}
			}	
				
			$qry = "SELECT * FROM projetos;";
			$ls  = mysql_query($qry, $conexao);
			while($linha = mysql_fetch_array($ls))
				echo "<li class='selected' style='background-image: url(imgpj01.png);'><a id='{$linha["id"]}' href='#' class='title'>{$linha["nome"]}</a><a href='#' class='view'></a></li>";
		}
	}


	
?>