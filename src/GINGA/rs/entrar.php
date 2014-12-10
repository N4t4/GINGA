<?php 
	include("includes/Myclasses.php");
	require_once("includes/conexao.php");
	session_start(); 
	global $conexao;

	$controle_db = new ControleDB($conexao);
	
	
	if(isset($_GET['sair']))
	{
		$_SESSION['id']    = -1;
		$_SESSION['sessao']= false;
		echo 1;
	}
	
	if(isset($_POST['entrar']) || isset($_POST['log_senha']))
	{

		$consulta = "
		SELECT
			*
		FROM
			membros
		WHERE
			e_mail='{$_POST['log_email']}' AND
			senha ='{$_POST['log_senha']}';
		";
		$resultado 		= mysql_query($consulta, $conexao);
		$linha 				= mysql_fetch_array($resultado);
		$membro_atual = new Membro();
		$membro_atual->CaregarLinha($linha);

		$numLinhas     = mysql_num_rows($resultado);

		if($numLinhas == 1)
		{
			$_SESSION['id']=$membro_atual->id;
			$_SESSION['sessao']=true;
			echo 1;
		}
		else
		{
			echo "O e-mail ou a senha inserido, est&atildeo incorretos.";
		}
	}
	else if(isset($_POST['cadastro']) || isset($_POST['cad_senha']))
	{
		$novo_membro = new Membro();
		$novo_membro->nome     = $_POST['cad_nome'];
		$novo_membro->senha    = $_POST['cad_senha'];
		$novo_membro->e_mail   = $_POST['cad_email'];
		$novo_membro->situacao = 1;
		
		if ($controle_db->VerificaRegistro('e_mail',$novo_membro->e_mail,'membros') == 0)
		{
			if($controle_db->Membro->Inserir($novo_membro) == 1)
			{
				$_SESSION['id']=$novo_membro->id;
				$_SESSION['sessao']=true;
				echo 1;
			}
		}
		else
		{
			echo "J&aacute existe um mebro cadastrado com este e-mail.";
		}
	}
	
?>