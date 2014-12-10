<?php
	include("includes/Myclasses.php"); 
	require_once("includes/conexao.php"); 
	session_start(); 

	global $conexao;	
	$controle_db = new ControleDB($conexao);
	 
	$consulta = "
  SELECT 
    mb.*
  FROM 
    membros mb
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
    mg.id_membro = '{$membro_atual->id}';
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
	
	if(isset($_POST['novo_grupo']))
	{
		$novo_grupo 			= new Grupo();
		$novo_grupo->nome = $_POST['grup_nome'];
		
		$controle_db->Grupo->Inserir($novo_grupo);
		
		$novo_gerente = new Gerente();
		$novo_gerente->situacao  = 1;
		$novo_gerente->senha     = $_POST['ger_senha'];
		$novo_gerente->id_membro = $membro_atual->id;
		$novo_gerente->id_grupo  = $novo_grupo->id;
		
		if ($controle_db->Gerente->Inserir($novo_gerente) == 1 &&
		$controle_db->AssociarMembroGrupo($membro_atual->id, $novo_grupo->id) == 1)
			echo $novo_grupo->id;
		else
			echo -1;			
	}

	if(isset($_POST['prosseguir']))
	{
		$_SESSION['grupo']=$_POST['sel_grupos'];
		$_SESSION['projeto']=$_POST['sel_projeto_gr'.$_POST['sel_grupos']];
		echo "Teste";
	}

if (isset($_POST['env_foto'])) 
{
	$foto = $_FILES['arquivo'];
	if (!empty($foto['name'])) 
	{
		$auxiliar_arq = new InArquivos();
		$caminho_arq = $auxiliar_arq->InserirArquivo($foto, "dp_arq/");
		if($controle_db->Membro->InserirFoto($caminho_arq, $membro_atual->id) == 1)
			header("Location: home.php");
	}
}
?>