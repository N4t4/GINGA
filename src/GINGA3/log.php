<?php 
	include("includes/Myclasses.php");
	require_once("includes/conexao.php");
	session_start(); 

	global $conexao;

	$controle_db = new ControleDB($conexao);
	
	
	if(isset($_POST['entrar']) || isset($_POST['lg_senha'])){
		
		$log_code = 0;
		$return   = "";

		$consulta = "
			SELECT
				*
			FROM
				ginga3_membros
			WHERE
				email ='{$_POST['lg_email']}' AND
				senha ='{$_POST['lg_senha']}';
		";

		$resultado 	  = mysql_query($consulta, $conexao);
		$linha 		  = mysql_fetch_array($resultado);
		$membro_atual = new Membro();
		$membro_atual->CarregarLinha($linha);

		$numLinhas     = mysql_num_rows($resultado);

		if($numLinhas == 1)
		{
			$_SESSION['id_membro']  = $membro_atual->id;
			$_SESSION['id_projeto'] = null;
			$_SESSION['sessao']     = true;

			$membro_atual->ChatIn($conexao);

			if($membro_atual->st == 0){
				$log_code = 2;
				$return   = $uploadUrl.$membro_atual->foto;
			} else {
				$log_code = 1;
				$return   = "Bem vindo!";
			}
		}
		else
		{

			$controle_db = new ControleDB($conexao);
			$the_membro  = $controle_db->Membros->GetByWhere("email = '{$_POST['lg_email']}'");

			if($the_membro->foto){
				$log_code = 3;
				$return   = $uploadUrl.$the_membro->foto;
			}else{
				$log_code = 0;
			}
		}

		$my = array( "log_code" => $log_code, "return" => $return); 
		
		$myJSON = json_encode($my);
		echo($myJSON);
	}
	
?>