<?php 
	include("includes/Myclasses.php");
	include("includes/machine.php");
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
		$qry = "
		SELECT
			*
		FROM
			membros
		WHERE
			e_mail='{$_POST['log_email']}' AND
			senha ='{$_POST['log_senha']}';
		";
		$resultado 		= mysql_query($qry, $conexao);
		$linha 				= mysql_fetch_array($resultado);
		$membro_atual = new Membro();
		$membro_atual->CaregarLinha($linha);
		
		if($membro_atual->st == 0)
		{
			echo "Z";
			return;
		}
		
		$numLinhas     = mysql_num_rows($resultado);

		if($numLinhas == 1)
		{
				$_SESSION['membro_at_id']    =$membro_atual->id;
			
				$qry = "SELECT * FROM projetos;";
				
				$resultado = mysql_query($qry, $conexao);
				$linha		 = mysql_fetch_array($resultado);
				$projeto_atual = new Projeto();
				$projeto_atual->CaregarLinha($linha);
				$GLOBALS['projeto_atual'] =  $projeto_atual;

				$_SESSION['projeto_at_id']= $projeto_atual->id;
				$_SESSION['sessao']=true;
			echo 1;
		}
		else
		{
			echo "Dados incorretos.";
		}
	}
	
	if(isset($_POST['cadastro']) || isset($_POST['cad_senha']))
	{
		$novo_membro = new Membro();
		
		$novo_membro->e_mail        = converte_html($_POST["cad_e_mail"]);
		$novo_membro->st            = 0;
		$novo_membro->curso         = converte_html($_POST["cad_curso"]);
		$novo_membro ->telefone     = converte_html($_POST["cad_telefone"]);
		$novo_membro->modulo        = converte_html($_POST["cad_modulo"]);
		$novo_membro->senha         = converte_html($_POST["cad_senha"]);
		$novo_membro->nome          = converte_html($_POST["cad_nome"]);
		$novo_membro->dt_nascimento = converte_html($_POST["cad_dt_nascimento"]);
		$novo_membro->indicacao     = converte_html($_POST["cad_indicacao"]);
		$novo_membro->vinculo       = converte_html($_POST["cad_vinculo"]);
		$novo_membro->dt_entrada    = getdate();
		$novo_membro->sexo          = converte_html($_POST["cad_sexo"]);
		$novo_membro->dt_saida      = 'NULL';
		$novo_membro->id_area       = converte_html($_POST["cad_id_area"]);
		
		if ($controle_db->VerificaRegistro('e_mail',$novo_membro->e_mail,'membros') == 0)
		{
			if($controle_db->Membro->Inserir($novo_membro) == 1)
			{
				
				$novo_endereco = new Endereco();
				
				$novo_endereco->numero    = converte_html($_POST["end_numero"]);  
				$novo_endereco->cidade    = converte_html($_POST["end_cidade"]);
				$novo_endereco->estado    = converte_html($_POST["end_estado"]);
				$novo_endereco->bairro    = converte_html($_POST["end_bairro"]);
				$novo_endereco->rua       = converte_html($_POST["end_rua"]);
				$novo_endereco->id_membro = $novo_membro->id;
				$novo_endereco->Criar($conexao);
				echo 1;
			}
		}
		else
		{
			echo "J&aacute existe um mebro cadastrado com este e-mail.";
		}
	}
	
?>