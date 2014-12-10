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
		
		<!--
		<div style="border: solid #555555;">
		<?php echo 'grupo:"'.$grupo_atual->nome.'" > projeto:"'.$projeto_atual->nome?>			
		</div>
		-->
		
		<div class="fm_modulos">
			<ul>
				<li><a href="gerencia.php">Atividades</a></li>
				<li><a class="selected" href="g_membros.php">Membros</a></li>
				<li><a href="g_graficos.php">Graficos</a></li>
			</ul>
		</div>
		
		<div class="fm" style="height:100px; margin-top:75px; ">
			<h2>Projetos</h2>
			<select id='sel_projeto' id='sel_projeto' style="float: left">
<?php

	$consulta = " 
	SELECT
		*
	FROM
		projetos
	WHERE
		id_grupo = '{$grupo_atual->id}'
	";
	$sub_resultado = mysql_query($consulta, $conexao);
	
	while($sub_linha = mysql_fetch_array($sub_resultado))
	{
		echo "<option value=".$sub_linha['id'].">".$sub_linha['nome']."</option>";
	}
	
?>
			</select>	
			<input id="view_c_projeto" type="button" class="button_mais"/>
		</div>
		
		<div class="fm" style="height:570px; margin-top:5px;">
		
			<table class="tabela_00">
				<caption>Exemple wich fruits</caption>
				<tbody>
				  <tr>
						<th>Fruits</th>
						<th>Preference</th>
						<th>Preference</th>
					</tr>
					<tr>
						<td>Apples</td>
						<td>Apples</td>
						<td>44%</td>
					</tr>
					<tr>
						<td>Bananas</td>
						<td>Bananas</td>
						<td>23%</td>
					</tr>
					<tr>
						<td>Oranges</td>
						<td>Oranges</td>
						<td>13%</td>
					</tr>
					<tr>
						<td>Other</td>
						<td>Other</td>
						<td>10%</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="fm" style="height:250px; margin-top:5px;">
			<h2 style='float:left;'>Membros deste Grupo</h2>
			<input id="view_add_membro" type="button" class="button_mais" style=" margin-left: -3px; width:20px; height:20px;"/>
			<ul class="v_membros">
<?php

	$consulta = " 
  SELECT
		*
  FROM
		membro_grupos mg
		LEFT JOIN membros mb ON mb.id = mg.id_membro 
	WHERE 
		id_grupo = '{$grupo_atual->id}'		
	;";
	$resultado = mysql_query($consulta, $conexao);
	
	while($linha = mysql_fetch_array($resultado))
	{
    echo "<li>
            <img src='img/logo.png' width='150px'/>
            <a name='view_membro' href='#".$linha['id']."'>".$linha['nome']."</a>
          </li>";
		//echo "<li style='float: left;'><a href=#{$linha['id']}>".$linha['nome']."</a></li>";
	}
	
?>
			</ul>
		</div>

	
	<div class="fm_cd" id="fm_add_membro" style="width:350px; height: 320px; display: none;">
		<form action="" method="post" id="form_add_grupo">
			<input id="hide_add_membro" type="button" class="bt_fechar"/>
			<h2>Adicionar ao grupo</h2>
			<ul>
<?php

	$consulta = " 
  SELECT
		mb.*
  FROM
		membros mb
		LEFT JOIN membro_grupos mg ON mb.id = mg.id_membro 
	WHERE 
	  mg.id_grupo IS NULL	OR
		mg.id_grupo <> {$grupo_atual->id} AND
		NOT mb.id IN (SELECT id_membro FROM membro_grupos WHERE id_grupo = '{$grupo_atual->id}')
	;";
	$resultado = mysql_query($consulta, $conexao);
	
	while($linha = mysql_fetch_array($resultado))
	{
		echo "<li id='gli{$linha['id']}'><input name='mbs' class='rb' type='checkbox' value={$linha['id']} /><p>".$linha['nome']."</p></li>";
	}		
	
?>
			</ul>
			<input type="submit" value="Adicionar" name='associar_membro_grupo' class="button"/>
		</form>
	</div>
	
	<div class="fm_cd" id="fm_c_membro_projeto" style="width:350px; height: 320px; display: none;">
		<form action="" method="post" id="form_add_projeto">
			<input id="hide_c_membro_projeto" type="button" class="bt_fechar"/>
			<h2>Adicionar ao projeto</h2>
			<ul>
<?php

  $consulta = " 
  SELECT
		mg.id,
		mb.nome
  FROM
		membro_grupos mg
		LEFT JOIN membros mb ON mb.id = mg.id_membro 
	WHERE 
		mg.id_grupo = {$grupo_atual->id} AND
		NOT mg.id IN (SELECT
										mp.id_membro_grupo
									FROM
										membros_projetos mp
										LEFT JOIN membro_grupos mg ON mg.id = mp.id_membro_grupo
										LEFT JOIN membros mb ON mg.id_membro = mb.id
									WHERE 
										mp.id_projeto = '{$projeto_atual->id}')
	;";
	$resultado = mysql_query($consulta, $conexao);
	
	while($linha = mysql_fetch_array($resultado))
	{
		echo "<li id='li{$linha['id']}'><input name='mbgs' type='checkbox' value={$linha['id']}>".$linha['nome']."<br></li>";
	}				
	
?>
			</ul>
			<input type="submit" value="Adicionar" name='associar_membro_projeto' class="button"/>
		</form>
	</div>
	
	<div class="fm_cd" id="fm_c_tarefa" style="width:350px; height: 300px; display: none;">
		<form action="" method="post" id="form_cad_tarefa">
			<input id="hide_c_tarefa" type="button" class="bt_fechar"/>
			<h2>Criar Tarefa</h2>
			<p>Nome:</p>
			<input type="text" name="trf_nome"/>
			<p>Descrição:</p>
			<textarea name="trf_descricao" rows="4" cols="40"></textarea><br />
			<input type="submit" value="Criar" name='nova_tarefa' class="button"/>
		</form>
	</div>
	
	<div class="fm_cd" id="fm_c_projeto" style="width:350px; height: 150px; display: none;">
		<form action="" method="post" id="form_cad_projeto">
			<input id="hide_c_projeto" type="button" class="bt_fechar"/>
			<h2>Criar Projeto</h2>
			<p>Nome:</p>
			<input type="text" name="proj_nome"/>
			<input type="submit" value="Criar" name="novo_projeto" class="button"/>
		</form>
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
	
<!-- </div>  -->

	<div class="fm_cd_membro" id="fixa_cad" style="padding:50px; width:750px; top:50px; margin-left:-150px; display: none;">
		<input id="hide_fixa_cad" type="button" class="bt_fechar"/>
		<div>
			<img src='img/sala3_logo.png'/>
			<h2>Ficha de Cadastro</h2>
			<p>Nome:</p>
			<input style="width: 680px;" type="text" name="membro_nome" value="<?php echo $membro_atual->nome;?>"/>
			<p>Endereço:</p>
			<input style="width: 660px;" type="text" name="membro_nome" value="<?php echo $membro_atual->nome;?>"/>
			<p>E-mail:</p>
			<input disabled style="width: 680px;" type="text" name="membro_email" value="<?php echo $membro_atual->e_mail;?>"/>
			<p>Telefone:</p>
			<input disabled style="width: 90px;" type="text" name="membro_email" value="(12)3662-4070"/>
			<p>Data Nascimento:</p>
			<input disabled style="width: 90px;" type="text" name="membro_email" value="(12)3662-4070"/>
			<p class="p_quebra_linha">Você é um:</p>
			<input type="radio" name="sex" value="male"><p>Professor</p><br>
			<input type="radio" name="sex" value="male"><p>Aluno</p><br>
			<input type="radio" name="sex" value="male"><p>Ex-aluno</p><br>
			<input type="radio" name="sex" value="male"><p>Comunidade</p><br>
			<p class="p_quebra_linha"></p>
			<p>Quem indicou:</p>
			<input disabled style="width: 630px;" type="text" name="membro_email" value="<?php echo $membro_atual->e_mail;?>"/>
			<p>Data Inscrição:</p>
			<input disabled style="width: 90px;" type="text" name="membro_email" value="(12)3662-4070"/>
			<p>Curso</p>
			<input disabled style="width: 90px;" type="text" name="membro_email" value="(12)3662-4070"/>
			<p>Modulo</p>
			<input disabled style="width: 90px;" type="text" name="membro_email" value="(12)3662-4070"/>
			<p class="p_quebra_linha">Áreas que deseja atuar: (pode ser mais de uma)</p>
			<input type="checkbox" name="vehicle" value="Bike"><p>Programação </p><br>
			<input type="checkbox" name="vehicle" value="Bike"><p>Modelagem 3D </p><br>
			<input type="checkbox" name="vehicle" value="Bike"><p>Desenho </p><br>
			<input type="checkbox" name="vehicle" value="Bike"><p>Qualidade </p><br>
			<input type="checkbox" name="vehicle" value="Bike"><p>Produção</p><br>
			<input type="checkbox" name="vehicle" value="Bike"><p>Administrativo   </p><br>
			<input type="checkbox" name="vehicle" value="Bike"><p>Marketing </p><br>
			<input type="checkbox" name="vehicle" value="Bike"><p>Produção Musical </p><br>
			<input type="checkbox" name="vehicle" value="Bike"><p>Roteirista</p><br>
			<input style="margin-left: 80%;" type="submit" value="Enviar" name="fixa_membro" class="button"/>
		</div>
  </div>
	
	<div id="lock" style="display:none"></div>
</body>
</html>
