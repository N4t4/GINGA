<?php  
	require_once("includes/conexao.php"); 
	include("includes/Myclasses.php");
	global $conexao;
	
	session_start(); 

	if(!$_SESSION['sessao']) header("Location: default.php");

	$msm = "";
	$membro_atual = new Membro();
	$membro_atual->Get($conexao, $_SESSION['id_membro'] );

	
	if($_SESSION["id_projeto"] == null){
		$qry = "SELECT id FROM ginga3_projetos LIMIT 1 ;";
		$resultado  = mysql_query($qry, $conexao);
		$linha = mysql_fetch_array($resultado);					
		$_SESSION["id_projeto"] =  $linha["id"];
	}

	$projeto_atual = new Projeto();
	$projeto_atual->Get($conexao, $_SESSION['id_projeto'] );
	
    if(isset($_POST['update-membro'])){

    	$controle_db = new ControleDB($conexao);

    	$membro_atual->nome    	 = $_POST["mb_nome"];
    	$membro_atual->apelido 	 = $_POST["mb_alias"]; 
    	$membro_atual->cor     	 = $_POST["mb_cor"];
    	$membro_atual->cor2      = $_POST["mb_cor2"];
    	$membro_atual->cor3      = $_POST["mb_cor3"];
    	$membro_atual->manifesto = $_POST["mb_manifesto"];

       	if (!empty($_FILES['mb_img'])) {

            $extensao = '.' . pathinfo($_FILES['mb_img']['name'], PATHINFO_EXTENSION);

            do {
                $filename = md5(microtime() . $_FILES['mb_img']['name']) . $extensao;
            } while (file_exists($filename));

       		if(move_uploaded_file($_FILES['mb_img']['tmp_name'], $uploadDir . $filename))
       			$membro_atual->foto = $filename;
       	}

    	if($membro_atual->email != $_POST["mb_email"]){

	    	if($controle_db->VerificaRegistro("email", $_POST["mb_email"], "ginga3_membros") == 0){
		    	$membro_atual->email = $_POST["mb_email"]; 
		    }else{
		    	$msm = "<div class='focos'><p class='the-border'>Este E-mail j&aacute; foi utilizado. Por este motivo n&atilde;o foi alterado.</p></div>";
		    }
		}else   
		
		if($membro_atual->Alterar($conexao)){ 
			$msm = "<div class='focos'><p class='the-border'>Dados alterados com sucesso.</p></div>"; 
		}
    }

    if(isset($_POST['update-projet'])){

    	$projeto_atual->nome      = $_POST['pj_nome'];
    	$projeto_atual->descricao = $_POST['pj_desc'];

      	if (!empty($_FILES['pj_img'])) {

            $extensao = '.' . pathinfo($_FILES['pj_img']['name'], PATHINFO_EXTENSION);

            do {
                $filename = md5(microtime() . $_FILES['pj_img']['name']) . $extensao;
            } while (file_exists($filename));

       		if(move_uploaded_file($_FILES['pj_img']['tmp_name'], $uploadDir . $filename))
       			$projeto_atual->img = $filename;
       	}

       	if($projeto_atual->Alterar($conexao)){
	    	$msm = "<div class='focos'><p class='the-border'>Projeto Alterado com sucesso.</p></div>";
       	} else {
       		$msm = "<div class='focos'><p class='the-border'>Ocorreu um erro, n&atilde;o foi poss&iacute;vel adicionar novo Projeto.</p></div>";
       	}
    }

    if(isset($_POST['new-projet'])){

    	$novo_projeto = new Projeto();
    	$novo_projeto->nome      = $_POST['pj_nome'];
    	$novo_projeto->descricao = $_POST['pj_desc'];
    	$novo_projeto->img       = "default2.png";

      	if (!empty($_FILES['pj_img'])) {

            $extensao = '.' . pathinfo($_FILES['pj_img']['name'], PATHINFO_EXTENSION);

            do {
                $filename = md5(microtime() . $_FILES['pj_img']['name']) . $extensao;
            } while (file_exists($filename));

       		if(move_uploaded_file($_FILES['pj_img']['tmp_name'], $uploadDir . $filename))
       			$novo_projeto->img = $filename;
       	}

       	if($novo_projeto->Inserir($conexao)){
	    	$msm = "<div class='focos'><p class='the-border'>Novo Projeto Adicionado com sucesso.</p></div>";
       	} else {
       		$msm = "<div class='focos'><p class='the-border'>Ocorreu um erro, n&atilde;o foi poss&iacute;vel adicionar novo Projeto.</p></div>";
       	}

       	$_SESSION["id_projeto"] = $novo_projeto->id;
       	$projeto_atual->Get($conexao, $_SESSION['id_projeto'] );
    }

    if(isset($_POST['add-arquivo'])){

    	$controle_db = new ControleDB($conexao);

    	$arq_nome  = "";
    	$arq_local = "";

      	if (!empty($_FILES['the_arq'])) {

            $extensao = '.' . pathinfo($_FILES['the_arq']['name'], PATHINFO_EXTENSION);
            $arq_nome = $_FILES['the_arq']['name'];
            do {
                $filename = md5(microtime() . $_FILES['the_arq']['name']) . $extensao;
            } while (file_exists($filename));

       		if(move_uploaded_file($_FILES['the_arq']['tmp_name'], $uploadDir . $filename))
       			$arq_local = $filename;
       	}

       	if($controle_db->Tarefas->InserirAquivo( $arq_nome, $arq_local,  $_POST['id_tarefa'] ))
			$msm = "<div class='focos'><p class='the-border'>Arquivo inserido.</p></div>";
		else
			$msm = "<div class='focos'><p class='the-border'>Ocoreu um erro n&atilde;o foi poss&iacutevel inserir arquivo.</p></div>";
    }
?>
<!DOCTYPE HTML>
<html lang="pt-br">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title><?php echo "Ginga | ".$membro_atual->apelido." | ".$projeto_atual->nome; ?></title>
	<script src="js/jquery.js"></script>
	<script src="js/global.js"></script>
	<script src="js/nt-class.js"></script>
	<link rel="stylesheet" href="css/style.css" />
	<link rel="shortcut icon" href="img/ico.ico" />
	<style>

		.act:hover { background-color: <?php echo $membro_atual->cor; ?>; }
		.act:active{ border: solid 1px <?php echo $membro_atual->cor; ?>; }
		.act{        border: solid 1px <?php echo $membro_atual->cor; ?>; }
		
		.color1{ background-color: <?php echo $membro_atual->cor; ?>;}
		.color2{ background-color: <?php echo $membro_atual->cor2; ?>;}
		.color3{ background-color: <?php echo $membro_atual->cor3; ?>; }
		
		.the-border-color1{ border: solid 1px <?php echo $membro_atual->cor; ?>; }
		.the-border-color2{ border: solid 1px <?php echo $membro_atual->cor2; ?>;}
		.the-border-color3{ border: solid 1px <?php echo $membro_atual->cor3; ?>;}

		.border-color1{ border-color: <?php echo $membro_atual->cor; ?>; }
		.border-color2{ border-color: <?php echo $membro_atual->cor2; ?>;}
		.border-color3{ border-color: <?php echo $membro_atual->cor3; ?>;}

		.box-color1{ border-radius: 5px; box-shadow: 0 0 12px <?php echo $membro_atual->cor; ?>; }
		.box-color2{ border-radius: 5px; box-shadow: 0 0 12px <?php echo $membro_atual->cor2; ?>; }
		.box-color3{ border-radius: 5px; box-shadow: 0 0 12px <?php echo $membro_atual->cor3; ?>; }
		
		.text-color1{ color: <?php echo $membro_atual->cor; ?>; }
		.text-color2{ color  <?php echo $membro_atual->cor2; ?>; }
		.text-color3{ color: <?php echo $membro_atual->cor3; ?>; }

		.tarefa ul>li,
		.tarefa-li{
			border-radius: 5px 5px 5px 5px;
			width: 94%;
			margin: auto;
			margin-bottom: 5px;
			min-height: 60px
		}
		.tarefa a{
			cursor: default;
		}

		
		.ls-2{ margin: auto; margin-top: 10%; display: block;}
		.ls-2>ul{ min-height: 338px; }
		.ls-3>ul{ height: 100%; }
		._atz,

		._chat{	position: absolute;	top: 84px; z-index: 2; right: 0; }
		._atz{ left: 0;	}
		.fm-membros-state .ls-2 img{
			float: left;
			margin-right: 15px;
		}
		.fm-membros-state .ls-2{
			box-shadow: none;
			margin-top: 0;
		}
		.fm-membros-state .ls-2>ul{
		    min-height: 398px
		}
		.fm-membros-state>section{
			overflow: hidden;
		}
		.ls-noticia>ul{
			max-height: 398px;
		}
		.box-entrada, .box-saida{	margin: 0; box-shadow: none; width: 340px; }
		.box-entrada ul, .box-saida ul{	max-height: initial; }

		body>header>h3{
			position:fixed; 
			left: 100px;
			z-index: 22;
			margin: 0;
			margin-left: 10px;
			margin-top: 8px;
		}
		body>section{
			width: 88%;
			height: 440px;
			position: absolute;
			padding: 10px;
		}
		body>section footer p{
			font-size: 12px;
		}
		body>section img{
			margin: auto;
			display: block;
		}
		body>section article{
			float: left;
		}
		body>section article footer>a:visited{
			color: #000;
		}
		body>footer{
			width: 100%;
			padding-left: 15px;
		}
		body>section>article>.ls-2{ width: 90%;	}
		h1{ display: none; }
	</style>
</head>
<body class="color1">

	<?php echo $msm; ?>

	<header class="text-color1">
		<h3 class="text-col1"><?php echo $projeto_atual->nome ; ?></h3>
		<nav id="nav-menu-01" class="box-padrao color2">
			<ul class="text-color1">
				<li><input class="color1 bt-am" type="button" ></li>
				<li><input class="bt-config color1" type="button" id="mb-conf" ></li>
				<li><a class="text-color1"  id="sair" href="#">Sair</a></li>
				<li><a class="text-color1" href="home.php">Retornar</a></li>
				<li><a class="text-color1" href="#" id="the-pjt">Mais Sobre o Projeto</a></li>
				<li>
					<a class="text-color1" href="#">Mensagem</a>
					<ul>
						<li><a class="text-color1" href="#" id="new-msm">Escrever</a></li>
						<li><a class="text-color1" href="#" id="ent-msm">Entrada</a></li>
						<li><a class="text-color1" href="#" id="sai-msm">Saida</a></li>
					</ul>
				</li>
				<li id="msm" class="color1">
					<label>
						<input type="button" id="bt-msm"><p class="evident"></p>
					</label>
				</li>
			</ul>
		</nav>
		<img src="img/ginga_logo.png" width="100px" class="color2" style="position:fixed; z-index: 999">
	</header>
	
	<section class="in-center box-padrao color2">

		<header>
			Tarefas do projeto...
		</header>

		<article class="wspan4 toLeft color2">
			<div class="ls-2 tarefa color3 box-color1">
				<header>
					<h2>Criados</h2>
				</header>
				<ul class="drag" group="ls-tarefas" id="ls-tfs-criadas">
					<?php $qry = "SELECT * FROM ginga3_tarefas WHERE id_projeto = '{$projeto_atual->id}' AND st = 1"; $ls  = mysql_query($qry, $conexao); ?>
					<?php while($tarefa = mysql_fetch_array($ls)): ?>
						<li class="color3 ls-2-li tarefa-li the-border-color1" moveId="<?php echo $tarefa['id']; ?>">
							<div class="<?php 
						 		switch ($tarefa["st"]) {
						 			case '1': echo "state1"; break;
						 			case '2': echo "state2"; break;
						 			case '3': echo "state3"; break;
						 			default : echo "state1"; break;
						 	}; ?>"></div>
							<a href="#">

								<div class="tre-buttons color1">
										<input tfId="<?php echo $tarefa["id"]; ?>" type="button" class="bt-view"  	onclick="TarefaViewClick(this);">
										<input tfId="<?php echo $tarefa["id"]; ?>" type="button" class="bt-membros" onclick="TarefaMembrosClick(this);">
								</div>
								
								<p><?php echo $tarefa["nome"]; ?></p>

								<div class="membros4">
									<?php 
										$qry = "
										SELECT 
											mt.id_tarefa, 
											m . *
										FROM 
											ginga3_membros m
											LEFT JOIN ginga3_membros_tarefas mt ON m.id = mt.id_membro
										WHERE
											mt.id_tarefa='{$tarefa["id"]}';
										"; 
										$ls1  = mysql_query($qry, $conexao); 
									?>
									<?php while($membro = mysql_fetch_array($ls1)): ?>
										<img src="<?php echo $uploadUrl.$membro["foto"]; ?>">
									<?php endwhile; ?>
								</div>
							</a>
							<div class="hidden view">
								<div class="view-tarefa">

									<h4>Descri&ccedil;&atilde;o</h4>
									<article class="desc"><?php echo $tarefa["descricao"]; ?></article>
									<strong>Estado da tarefa:
									<?php switch ($tarefa["nome"]) {
								 			case '1': echo "<span style='color1: red'>criada</span>"; break;
								 			case '2': echo "<span style='color1: darkgoldenrod'>sendo feita</span>"; break;
								 			case '3': echo "<span style='color1: green'>conclu&iacute;da</span>"; break;
								 			default : echo "<span style='color1: red'>criada</span>"; break;
								 	}; ?>.
							 		</strong>
									<h4>Coment&aacute;rios</h4>
								  	<article>
										<article class="last-job-coment-<?php echo $tarefa["id"]; ?>">
									  		<?php
												$qry = "
													SELECT
													  m.nome,
													  m.foto,
													  tc.data,
													  tc.conteudo
													FROM
														ginga3_tarefas_comentarios tc
														INNER JOIN ginga3_membros m ON tc.id_membro = m.id
													WHERE
													  tc.id_tarefa =  '{$tarefa["id"]}'
													ORDER BY tc.data DESC LIMIT 1
												;";
												$resultado  = mysql_query($qry, $conexao);
												$coment 	= mysql_fetch_array($resultado);
									  		?>
											<header><h4><?php echo $coment["nome"]; ?></h4></header>
											<img src="<?php echo $uploadUrl.$coment["foto"]; ?>" alt="#" style="float: right">
											<p class="data"><?php echo $coment["conteudo"]; ?></p>
											<strong><?php echo $coment["data"]; ?></strong>
										</article>

										<a class="act more the-border" href="#" onclick="ViewAllComentsTarefa(this);">Ver Todos</a> 

										<div class="new-coment color1">
											<p>Escrever:</p>
											<textarea rows="5"></textarea>
											<input type="button" id="save" class="bt color1" value="Enviar" onclick="EnviarComentarioTarefa(this, <?php echo $tarefa["id"]; ?>);">
										</div>
										
										<div class="all-coments hidden">
											<div class="ls-coments">
												<header></header>
												<ul class="job-coments-<?php echo $tarefa["id"]; ?>">
													<?php $qry = "
														SELECT
														  	m.nome,
														  	m.foto,
														  	tc.data,
														  	tc.conteudo
														FROM
															ginga3_tarefas_comentarios tc
															INNER JOIN ginga3_membros m ON tc.id_membro = m.id
														WHERE
														  	tc.id_tarefa = '{$tarefa["id"]}'
														ORDER BY tc.data DESC
													;"; $ls1  = mysql_query($qry, $conexao); ?>
													<?php while($coments = mysql_fetch_array($ls1)): ?>
														<li>
															<header><h4><?php echo $coments["nome"]; ?></h4></header>
															<img src="<?php echo $uploadUrl.$coments["foto"]; ?>" alt="#">
															<p><?php echo $coments["conteudo"]; ?></p>
															<strong><?php echo $coments["data"]; ?></strong>
														</li>					 	
													<?php endwhile; ?>
												</ul>
												<div class="new-coment color1">
													<p>Escrever:</p>
													<textarea rows="5"></textarea>
													<input type="button" id="save" class="bt color1" value="Enviar" onclick="EnviarComentarioTarefa(this, <?php echo $tarefa["id"]; ?>);">
												</div>	
											</div>
										</div>
								  	</article>
							
									<h4>Membros nesta Tarefa</h4>
						  			<article>
							  			<div class="ls-3 the-members">
											<ul>
												<?php 
													$qry = "
													SELECT 
														mt.id_tarefa, 
														m . *
													FROM 
														ginga3_membros m
														LEFT JOIN ginga3_membros_tarefas mt ON m.id = mt.id_membro
													WHERE
														mt.id_tarefa='{$tarefa["id"]}';
													"; 
													$ls1  = mysql_query($qry, $conexao); 
												?>
												<?php while($membro = mysql_fetch_array($ls1)): ?>
													<!--membro_modelo-->
													<li class="act ls-3-li"><a mbId="<?php echo $membro["id"]; ?>" href="#" onclick="ViewAllMembers(this);">
														<img style="background-color: <?php echo $membro["cor"]; ?>;" src="<?php echo $uploadUrl.$membro["foto"]; ?>" alt="#">
														<div id="the-member" class="hidden" color="<?php echo $membro["cor"]; ?>">
															<div id="view-the-member">
																<header>
																	<img src="<?php echo $uploadUrl.$membro["foto"]; ?>" height="142px" width="107px">
																</header>
																	
																<section>
																	<p>Nome: <span class="the-name"><?php echo $membro["nome"]; ?></span></p>
																	<p>Manifesto:</p>
																	<p class="manifest color1">"<?php echo $membro["manifesto"]; ?>"</p>
																	<p>Gargo: Programador</p>
																	<p><?php echo $membro["data"]; ?></p>
																	<p>Tarefas Feitas: 42</p>
																</section>
																	
																<footer>
																	<div id="more-actions">
																		<input type="button" id="bt-msm">
																		<input type="button" id="bt-chat">
																		<input type="button" id="bt-yes">
																	</div>
																</footer>
															</div>
														</div>
													</a></li>
												<?php endwhile; ?>
											</ul>
										</div>
										<div class="ls-3 not-members hidden">
											<ul>
												<?php 
													$qry = "
														SELECT DISTINCT
														  m . *
														FROM
															ginga3_membros m
															LEFT JOIN ginga3_membros_tarefas mt ON m.id = mt.id_membro
															LEFT JOIN ginga3_membros_projetos mp ON m.id = mp.id_membro
														WHERE
															(mt.id_tarefa IS NULL OR mt.id_tarefa !='{$tarefa["id"]}') AND
															m.id NOT IN( SELECT id_membro FROM ginga3_membros_tarefas WHERE id_tarefa ='{$tarefa["id"]}')
														   AND mp.id_projeto = '{$projeto_atual->id}';
													"; 
													$ls1  = mysql_query($qry, $conexao); 
													if(!mysql_num_rows($ls1)) echo "N&atilde;o existem mais membros neste projeto."
												?>
												<?php while($membro = mysql_fetch_array($ls1)): ?>
													<li class="act ls-3-li"><a mbId="<?php echo $membro["id"]; ?>" href="#" onclick="ViewAllMembers(this);">
														<img style="background-color: <?php echo $membro["cor"]; ?>;" src="<?php echo $uploadUrl.$membro["foto"]; ?>" alt="#">
														<div id="the-member" class="hidden" color="<?php echo $membro["cor"]; ?>">
															<div id="view-the-member">
																<header>
																	<img src="<?php echo $uploadUrl.$membro["foto"]; ?>" height="142px" width="107px">
																</header>
																	
																<section>
																	<p>Nome: <span class="the-name"><?php echo $membro["nome"]; ?></span></p>
																	<p>Manifesto:</p>
																	<p class="manifest color1">"<?php echo $membro["manifesto"]; ?>"</p>
																	<p>Gargo: Programador</p>
																	<p><?php echo $membro["data"]; ?></p>
																	<p>Tarefas Feitas: 42</p>
																</section>
																	
																<footer>
																	<div id="more-actions">
																		<input type="button" id="bt-msm">
																		<input type="button" id="bt-chat">
																		<input type="button" id="bt-yes">
																	</div>
																</footer>
															</div>
														</div>
													</a></li>
												<?php endwhile; ?>
											</ul>
										</div>
					 				</article>

									<h4>Anexos</h4>
								  	<article>
								    	<div class="ls-1">
											<header></header>
											<ul>
												<?php $qry = "
													SELECT
													  *
													FROM
													  ginga3_tarefas_arquivos
													WHERE
													  id_tarefa = '{$tarefa["id"]}';
												"; 
												$ls2  = mysql_query($qry, $conexao); ?>

												<?php while($arq = mysql_fetch_array($ls2)): ?>
													<li><a class="act" href="<?php echo $uploadUrl.$arq["local"]; ?>"><?php echo $arq["nome"];?></a> <input ArqId="<?php echo $arq["id"]; ?>" TfId="<?php echo $tarefa["id"]; ?>" class="bt-rem act color1" type="button" onclick="DeleteAnexo(this);"></li>
												<?php endwhile; ?>
											</ul>
										</div>
										<footer>
						                    <form action="" method="post" enctype="multipart/form-data">
											<div class="ed-file" style="float: left">
							                    <p>Enviar Arquivo:</p><br>
							                    <label>
								                    <input type="file" onchange="readFILE(this);" name="the_arq"/>
							                    	<p>VAZIO</p>
							                    	<input class="bt-add color1" type="button" >
							                    	<input type="hidden" name="id_tarefa" value="<?php echo $tarefa["id"]; ?>">
								                </label>
								                <input type="submit" value="Enviar" name="add-arquivo" class="bt color1" style="float: right; margin-left: 15px;">
							                </form>
							                </div>
										</footer>
								  	</article>
								</div>
							</div>
						</li>
					<?php endwhile; ?>
				</ul>
			</div>
		</article>

		<article class="wspan4 toLeft color2">
			<div class="ls-2 tarefa color3 box-color1">
				<header>
					<h2>Fazendo</h2>
				</header>
				<ul class="drag" group="ls-tarefas" id="ls-tfs-fazendo">
					<?php $qry = "SELECT * FROM ginga3_tarefas WHERE id_projeto = '{$projeto_atual->id}' AND st = 2"; $ls  = mysql_query($qry, $conexao); ?>
					<?php while($tarefa = mysql_fetch_array($ls)): ?>
						<li class="color3 ls-2-li tarefa-li the-border-color1" moveId="<?php echo $tarefa['id']; ?>">
							<div class="<?php 
						 		switch ($tarefa["st"]) {
						 			case '1': echo "state1"; break;
						 			case '2': echo "state2"; break;
						 			case '3': echo "state3"; break;
						 			default : echo "state1"; break;
						 	}; ?>"></div>
							<a href="#">

								<div class="tre-buttons color1">
										<input tfId="<?php echo $tarefa["id"]; ?>" type="button" class="bt-view"  	onclick="TarefaViewClick(this);">
										<input tfId="<?php echo $tarefa["id"]; ?>" type="button" class="bt-membros" onclick="TarefaMembrosClick(this);">
								</div>
								
								<p><?php echo $tarefa["nome"]; ?></p>

								<div class="membros4">
									<?php 
										$qry = "
										SELECT 
											mt.id_tarefa, 
											m . *
										FROM 
											ginga3_membros m
											LEFT JOIN ginga3_membros_tarefas mt ON m.id = mt.id_membro
										WHERE
											mt.id_tarefa='{$tarefa["id"]}';
										"; 
										$ls1  = mysql_query($qry, $conexao); 
									?>
									<?php while($membro = mysql_fetch_array($ls1)): ?>
										<img src="<?php echo $uploadUrl.$membro["foto"]; ?>">
									<?php endwhile; ?>
								</div>
							</a>
							<div class="hidden view">
								<div class="view-tarefa">

									<h4>Descri&ccedil;&atilde;o</h4>
									<article class="desc"><?php echo $tarefa["descricao"]; ?></article>
									<strong>Estado da tarefa:
									<?php switch ($tarefa["nome"]) {
								 			case '1': echo "<span style='color1: red'>criada</span>"; break;
								 			case '2': echo "<span style='color1: darkgoldenrod'>sendo feita</span>"; break;
								 			case '3': echo "<span style='color1: green'>conclu&iacute;da</span>"; break;
								 			default : echo "<span style='color1: red'>criada</span>"; break;
								 	}; ?>.
							 		</strong>
									<h4>Coment&aacute;rios</h4>
								  	<article>
										<article class="last-job-coment-<?php echo $tarefa["id"]; ?>">
									  		<?php
												$qry = "
													SELECT
													  m.nome,
													  m.foto,
													  tc.data,
													  tc.conteudo
													FROM
														ginga3_tarefas_comentarios tc
														INNER JOIN ginga3_membros m ON tc.id_membro = m.id
													WHERE
													  tc.id_tarefa =  '{$tarefa["id"]}'
													ORDER BY tc.data DESC LIMIT 1
												;";
												$resultado  = mysql_query($qry, $conexao);
												$coment 	= mysql_fetch_array($resultado);
									  		?>
											<header><h4><?php echo $coment["nome"]; ?></h4></header>
											<img src="<?php echo $uploadUrl.$coment["foto"]; ?>" alt="#" style="float: right">
											<p class="data"><?php echo $coment["conteudo"]; ?></p>
											<strong><?php echo $coment["data"]; ?></strong>
										</article>

										<a class="act more the-border" href="#" onclick="ViewAllComentsTarefa(this);">Ver Todos</a> 

										<div class="new-coment color1">
											<p>Escrever:</p>
											<textarea rows="5"></textarea>
											<input type="button" id="save" class="bt color1" value="Enviar" onclick="EnviarComentarioTarefa(this, <?php echo $tarefa["id"]; ?>);">
										</div>
										
										<div class="all-coments hidden">
											<div class="ls-coments">
												<header></header>
												<ul class="job-coments-<?php echo $tarefa["id"]; ?>">
													<?php $qry = "
														SELECT
														  	m.nome,
														  	m.foto,
														  	tc.data,
														  	tc.conteudo
														FROM
															ginga3_tarefas_comentarios tc
															INNER JOIN ginga3_membros m ON tc.id_membro = m.id
														WHERE
														  	tc.id_tarefa = '{$tarefa["id"]}'
														ORDER BY tc.data DESC
													;"; $ls1  = mysql_query($qry, $conexao); ?>
													<?php while($coments = mysql_fetch_array($ls1)): ?>
														<li>
															<header><h4><?php echo $coments["nome"]; ?></h4></header>
															<img src="<?php echo $uploadUrl.$coments["foto"]; ?>" alt="#">
															<p><?php echo $coments["conteudo"]; ?></p>
															<strong><?php echo $coments["data"]; ?></strong>
														</li>					 	
													<?php endwhile; ?>
												</ul>
												<div class="new-coment color1">
													<p>Escrever:</p>
													<textarea rows="5"></textarea>
													<input type="button" id="save" class="bt color1" value="Enviar" onclick="EnviarComentarioTarefa(this, <?php echo $tarefa["id"]; ?>);">
												</div>	
											</div>
										</div>
								  	</article>
							
									<h4>Membros nesta Tarefa</h4>
						  			<article>
							  			<div class="ls-3 the-members">
											<ul>
												<?php 
													$qry = "
													SELECT 
														mt.id_tarefa, 
														m . *
													FROM 
														ginga3_membros m
														LEFT JOIN ginga3_membros_tarefas mt ON m.id = mt.id_membro
													WHERE
														mt.id_tarefa='{$tarefa["id"]}';
													"; 
													$ls1  = mysql_query($qry, $conexao); 
												?>
												<?php while($membro = mysql_fetch_array($ls1)): ?>
													<!--membro_modelo-->
													<li class="act ls-3-li"><a mbId="<?php echo $membro["id"]; ?>" href="#" onclick="ViewAllMembers(this);">
														<img style="background-color: <?php echo $membro["cor"]; ?>;" src="<?php echo $uploadUrl.$membro["foto"]; ?>" alt="#">
														<div id="the-member" class="hidden" color="<?php echo $membro["cor"]; ?>">
															<div id="view-the-member">
																<header>
																	<img src="<?php echo $uploadUrl.$membro["foto"]; ?>" height="142px" width="107px">
																</header>
																	
																<section>
																	<p>Nome: <span class="the-name"><?php echo $membro["nome"]; ?></span></p>
																	<p>Manifesto:</p>
																	<p class="manifest color1">"<?php echo $membro["manifesto"]; ?>"</p>
																	<p>Gargo: Programador</p>
																	<p><?php echo $membro["data"]; ?></p>
																	<p>Tarefas Feitas: 42</p>
																</section>
																	
																<footer>
																	<div id="more-actions">
																		<input type="button" id="bt-msm">
																		<input type="button" id="bt-chat">
																		<input type="button" id="bt-yes">
																	</div>
																</footer>
															</div>
														</div>
													</a></li>
												<?php endwhile; ?>
											</ul>
										</div>
										<div class="ls-3 not-members hidden">
											<ul>
												<?php 
													$qry = "
														SELECT DISTINCT
														  m . *
														FROM
															ginga3_membros m
															LEFT JOIN ginga3_membros_tarefas mt ON m.id = mt.id_membro
															LEFT JOIN ginga3_membros_projetos mp ON m.id = mp.id_membro
														WHERE
															(mt.id_tarefa IS NULL OR mt.id_tarefa !='{$tarefa["id"]}') AND
															m.id NOT IN( SELECT id_membro FROM ginga3_membros_tarefas WHERE id_tarefa ='{$tarefa["id"]}')
														   AND mp.id_projeto = '{$projeto_atual->id}';
													"; 
													$ls1  = mysql_query($qry, $conexao); 
													if(!mysql_num_rows($ls1)) echo "N&atilde;o existem mais membros neste projeto."
												?>
												<?php while($membro = mysql_fetch_array($ls1)): ?>
													<li class="act ls-3-li"><a mbId="<?php echo $membro["id"]; ?>" href="#" onclick="ViewAllMembers(this);">
														<img style="background-color: <?php echo $membro["cor"]; ?>;" src="<?php echo $uploadUrl.$membro["foto"]; ?>" alt="#">
														<div id="the-member" class="hidden" color="<?php echo $membro["cor"]; ?>">
															<div id="view-the-member">
																<header>
																	<img src="<?php echo $uploadUrl.$membro["foto"]; ?>" height="142px" width="107px">
																</header>
																	
																<section>
																	<p>Nome: <span class="the-name"><?php echo $membro["nome"]; ?></span></p>
																	<p>Manifesto:</p>
																	<p class="manifest color1">"<?php echo $membro["manifesto"]; ?>"</p>
																	<p>Gargo: Programador</p>
																	<p><?php echo $membro["data"]; ?></p>
																	<p>Tarefas Feitas: 42</p>
																</section>
																	
																<footer>
																	<div id="more-actions">
																		<input type="button" id="bt-msm">
																		<input type="button" id="bt-chat">
																		<input type="button" id="bt-yes">
																	</div>
																</footer>
															</div>
														</div>
													</a></li>
												<?php endwhile; ?>
											</ul>
										</div>
					 				</article>

									<h4>Anexos</h4>
								  	<article>
								    	<div class="ls-1">
											<header></header>
											<ul>
												<?php $qry = "
													SELECT
													  *
													FROM
													  ginga3_tarefas_arquivos
													WHERE
													  id_tarefa = '{$tarefa["id"]}';
												"; 
												$ls2  = mysql_query($qry, $conexao); ?>

												<?php while($arq = mysql_fetch_array($ls2)): ?>
													<li><a class="act" href="<?php echo $uploadUrl.$arq["local"]; ?>"><?php echo $arq["nome"];?></a> <input ArqId="<?php echo $arq["id"]; ?>" TfId="<?php echo $tarefa["id"]; ?>" class="bt-rem act color1" type="button" onclick="DeleteAnexo(this);"></li>
												<?php endwhile; ?>
											</ul>
										</div>
										<footer>
						                    <form action="" method="post" enctype="multipart/form-data">
											<div class="ed-file" style="float: left">
							                    <p>Enviar Arquivo:</p><br>
							                    <label>
								                    <input type="file" onchange="readFILE(this);" name="the_arq"/>
							                    	<p>VAZIO</p>
							                    	<input class="bt-add color1" type="button" >
							                    	<input type="hidden" name="id_tarefa" value="<?php echo $tarefa["id"]; ?>">
								                </label>
								                <input type="submit" value="Enviar" name="add-arquivo" class="bt color1" style="float: right; margin-left: 15px;">
							                </form>
							                </div>
										</footer>
								  	</article>
								</div>
							</div>
						</li>
					<?php endwhile; ?>
				</ul>
			</div>
		</article>

		<article class="wspan4 toLeft color2">
			
			<div class="ls-2 tarefa color3 box-color1">
				<header>
					<h2>Prontos</h2>
				</header>
				<ul class="drag" group="ls-tarefas" id="ls-tfs-feitas">
					<?php $qry = "SELECT * FROM ginga3_tarefas WHERE id_projeto = '{$projeto_atual->id}' AND st = 3"; $ls  = mysql_query($qry, $conexao); ?>
					<?php while($tarefa = mysql_fetch_array($ls)): ?>
						<li class="color3 ls-2-li tarefa-li the-border-color1" moveId="<?php echo $tarefa['id']; ?>">
							<div class="<?php 
						 		switch ($tarefa["st"]) {
						 			case '1': echo "state1"; break;
						 			case '2': echo "state2"; break;
						 			case '3': echo "state3"; break;
						 			default : echo "state1"; break;
						 	}; ?>"></div>
							<a href="#">

								<div class="tre-buttons color1">
										<input tfId="<?php echo $tarefa["id"]; ?>" type="button" class="bt-view"  	onclick="TarefaViewClick(this);">
										<input tfId="<?php echo $tarefa["id"]; ?>" type="button" class="bt-membros" onclick="TarefaMembrosClick(this);">
								</div>
								
								<p><?php echo $tarefa["nome"]; ?></p>

								<div class="membros4">
									<?php 
										$qry = "
										SELECT 
											mt.id_tarefa, 
											m . *
										FROM 
											ginga3_membros m
											LEFT JOIN ginga3_membros_tarefas mt ON m.id = mt.id_membro
										WHERE
											mt.id_tarefa='{$tarefa["id"]}';
										"; 
										$ls1  = mysql_query($qry, $conexao); 
									?>
									<?php while($membro = mysql_fetch_array($ls1)): ?>
										<img src="<?php echo $uploadUrl.$membro["foto"]; ?>">
									<?php endwhile; ?>
								</div>
							</a>
							<div class="hidden view">
								<div class="view-tarefa">

									<h4>Descri&ccedil;&atilde;o</h4>
									<article class="desc"><?php echo $tarefa["descricao"]; ?></article>
									<strong>Estado da tarefa:
									<?php switch ($tarefa["nome"]) {
								 			case '1': echo "<span style='color1: red'>criada</span>"; break;
								 			case '2': echo "<span style='color1: darkgoldenrod'>sendo feita</span>"; break;
								 			case '3': echo "<span style='color1: green'>conclu&iacute;da</span>"; break;
								 			default : echo "<span style='color1: red'>criada</span>"; break;
								 	}; ?>.
							 		</strong>
									<h4>Coment&aacute;rios</h4>
								  	<article>
										<article class="last-job-coment-<?php echo $tarefa["id"]; ?>">
									  		<?php
												$qry = "
													SELECT
													  m.nome,
													  m.foto,
													  tc.data,
													  tc.conteudo
													FROM
														ginga3_tarefas_comentarios tc
														INNER JOIN ginga3_membros m ON tc.id_membro = m.id
													WHERE
													  tc.id_tarefa =  '{$tarefa["id"]}'
													ORDER BY tc.data DESC LIMIT 1
												;";
												$resultado  = mysql_query($qry, $conexao);
												$coment 	= mysql_fetch_array($resultado);
									  		?>
											<header><h4><?php echo $coment["nome"]; ?></h4></header>
											<img src="<?php echo $uploadUrl.$coment["foto"]; ?>" alt="#" style="float: right">
											<p class="data"><?php echo $coment["conteudo"]; ?></p>
											<strong><?php echo $coment["data"]; ?></strong>
										</article>

										<a class="act more the-border" href="#" onclick="ViewAllComentsTarefa(this);">Ver Todos</a> 

										<div class="new-coment color1">
											<p>Escrever:</p>
											<textarea rows="5"></textarea>
											<input type="button" id="save" class="bt color1" value="Enviar" onclick="EnviarComentarioTarefa(this, <?php echo $tarefa["id"]; ?>);">
										</div>
										
										<div class="all-coments hidden">
											<div class="ls-coments">
												<header></header>
												<ul class="job-coments-<?php echo $tarefa["id"]; ?>">
													<?php $qry = "
														SELECT
														  	m.nome,
														  	m.foto,
														  	tc.data,
														  	tc.conteudo
														FROM
															ginga3_tarefas_comentarios tc
															INNER JOIN ginga3_membros m ON tc.id_membro = m.id
														WHERE
														  	tc.id_tarefa = '{$tarefa["id"]}'
														ORDER BY tc.data DESC
													;"; $ls1  = mysql_query($qry, $conexao); ?>
													<?php while($coments = mysql_fetch_array($ls1)): ?>
														<li>
															<header><h4><?php echo $coments["nome"]; ?></h4></header>
															<img src="<?php echo $uploadUrl.$coments["foto"]; ?>" alt="#">
															<p><?php echo $coments["conteudo"]; ?></p>
															<strong><?php echo $coments["data"]; ?></strong>
														</li>					 	
													<?php endwhile; ?>
												</ul>
												<div class="new-coment color1">
													<p>Escrever:</p>
													<textarea rows="5"></textarea>
													<input type="button" id="save" class="bt color1" value="Enviar" onclick="EnviarComentarioTarefa(this, <?php echo $tarefa["id"]; ?>);">
												</div>	
											</div>
										</div>
								  	</article>
							
									<h4>Membros nesta Tarefa</h4>
						  			<article>
							  			<div class="ls-3 the-members">
											<ul>
												<?php 
													$qry = "
													SELECT 
														mt.id_tarefa, 
														m . *
													FROM 
														ginga3_membros m
														LEFT JOIN ginga3_membros_tarefas mt ON m.id = mt.id_membro
													WHERE
														mt.id_tarefa='{$tarefa["id"]}';
													"; 
													$ls1  = mysql_query($qry, $conexao); 
												?>
												<?php while($membro = mysql_fetch_array($ls1)): ?>
													<!--membro_modelo-->
													<li class="act ls-3-li"><a mbId="<?php echo $membro["id"]; ?>" href="#" onclick="ViewAllMembers(this);">
														<img style="background-color: <?php echo $membro["cor"]; ?>;" src="<?php echo $uploadUrl.$membro["foto"]; ?>" alt="#">
														<div id="the-member" class="hidden" color="<?php echo $membro["cor"]; ?>">
															<div id="view-the-member">
																<header>
																	<img src="<?php echo $uploadUrl.$membro["foto"]; ?>" height="142px" width="107px">
																</header>
																	
																<section>
																	<p>Nome: <span class="the-name"><?php echo $membro["nome"]; ?></span></p>
																	<p>Manifesto:</p>
																	<p class="manifest color1">"<?php echo $membro["manifesto"]; ?>"</p>
																	<p>Gargo: Programador</p>
																	<p><?php echo $membro["data"]; ?></p>
																	<p>Tarefas Feitas: 42</p>
																</section>
																	
																<footer>
																	<div id="more-actions">
																		<input type="button" id="bt-msm">
																		<input type="button" id="bt-chat">
																		<input type="button" id="bt-yes">
																	</div>
																</footer>
															</div>
														</div>
													</a></li>
												<?php endwhile; ?>
											</ul>
										</div>
										<div class="ls-3 not-members hidden">
											<ul>
												<?php 
													$qry = "
														SELECT DISTINCT
														  m . *
														FROM
															ginga3_membros m
															LEFT JOIN ginga3_membros_tarefas mt ON m.id = mt.id_membro
															LEFT JOIN ginga3_membros_projetos mp ON m.id = mp.id_membro
														WHERE
															(mt.id_tarefa IS NULL OR mt.id_tarefa !='{$tarefa["id"]}') AND
															m.id NOT IN( SELECT id_membro FROM ginga3_membros_tarefas WHERE id_tarefa ='{$tarefa["id"]}')
														   AND mp.id_projeto = '{$projeto_atual->id}';
													"; 
													$ls1  = mysql_query($qry, $conexao); 
													if(!mysql_num_rows($ls1)) echo "N&atilde;o existem mais membros neste projeto."
												?>
												<?php while($membro = mysql_fetch_array($ls1)): ?>
													<li class="act ls-3-li"><a mbId="<?php echo $membro["id"]; ?>" href="#" onclick="ViewAllMembers(this);">
														<img style="background-color: <?php echo $membro["cor"]; ?>;" src="<?php echo $uploadUrl.$membro["foto"]; ?>" alt="#">
														<div id="the-member" class="hidden" color="<?php echo $membro["cor"]; ?>">
															<div id="view-the-member">
																<header>
																	<img src="<?php echo $uploadUrl.$membro["foto"]; ?>" height="142px" width="107px">
																</header>
																	
																<section>
																	<p>Nome: <span class="the-name"><?php echo $membro["nome"]; ?></span></p>
																	<p>Manifesto:</p>
																	<p class="manifest color1">"<?php echo $membro["manifesto"]; ?>"</p>
																	<p>Gargo: Programador</p>
																	<p><?php echo $membro["data"]; ?></p>
																	<p>Tarefas Feitas: 42</p>
																</section>
																	
																<footer>
																	<div id="more-actions">
																		<input type="button" id="bt-msm">
																		<input type="button" id="bt-chat">
																		<input type="button" id="bt-yes">
																	</div>
																</footer>
															</div>
														</div>
													</a></li>
												<?php endwhile; ?>
											</ul>
										</div>
					 				</article>

									<h4>Anexos</h4>
								  	<article>
								    	<div class="ls-1">
											<header></header>
											<ul>
												<?php $qry = "
													SELECT
													  *
													FROM
													  ginga3_tarefas_arquivos
													WHERE
													  id_tarefa = '{$tarefa["id"]}';
												"; 
												$ls2  = mysql_query($qry, $conexao); ?>

												<?php while($arq = mysql_fetch_array($ls2)): ?>
													<li><a class="act" href="<?php echo $uploadUrl.$arq["local"]; ?>"><?php echo $arq["nome"];?></a> <input ArqId="<?php echo $arq["id"]; ?>" TfId="<?php echo $tarefa["id"]; ?>" class="bt-rem act color1" type="button" onclick="DeleteAnexo(this);"></li>
												<?php endwhile; ?>
											</ul>
										</div>
										<footer>
						                    <form action="" method="post" enctype="multipart/form-data">
											<div class="ed-file" style="float: left">
							                    <p>Enviar Arquivo:</p><br>
							                    <label>
								                    <input type="file" onchange="readFILE(this);" name="the_arq"/>
							                    	<p>VAZIO</p>
							                    	<input class="bt-add color1" type="button" >
							                    	<input type="hidden" name="id_tarefa" value="<?php echo $tarefa["id"]; ?>">
								                </label>
								                <input type="submit" value="Enviar" name="add-arquivo" class="bt color1" style="float: right; margin-left: 15px;">
							                </form>
							                </div>
										</footer>
								  	</article>
								</div>
							</div>
						</li>
					<?php endwhile; ?>
				</ul>
			</div>
		</article>
	</section>

	<input type="button" id="bt-chat" class="_chat">
	<input type="button" id="bt-atz" class="_atz">

	<article class="fm-notificao color1"> 
		<header> 
			<h2>Noticias</h2> 
			<div class="buttons-area">
			</div> 
		</header> 
		<section>

			<div class="ls-noticia">
				<header></header>
				<ul>
					
					<li><a class="act" href="#">
						<header><h4>Title</h4></header>
						<p class="data">Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1</p>
						<strong>Projeto esta em 90%</strong>
						<img src="gen.png" alt="#" style="background-color: red">
					</a></li>

					<li><a class="act" href="#"><header><h4>Natã Concluiu uma nove tarefa</h4></header><p class="data">Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1</p><img src="gen.png" alt="#"></a></li>
					<li><a class="act" href="#"><header><h4>Gerente criou nova tarefa para natã</h4></header><p class="data">Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Itemem1Item1Item1Item1Item1Item1Item1Item1</p></a></li>
				</ul>
			</div>
		</section> 
		<footer></footer> 
	</article>

	<article class="fm-membros-state color1">
		<header> 
			<h2>Membros</h2> 
			<div class="buttons-area"></div> 
		</header> 
		<section> 

			<div class="ls-2">
				<ul>
					<?php 
						$qry = "
						SELECT 
							*
						FROM 
							ginga3_membros
						WHERE
						    chat_st = 1 AND
						    id != '{$membro_atual->id}'
						;"; 
						$ls  = mysql_query($qry, $conexao); 
					?>
					<?php while($membro = mysql_fetch_array($ls)): ?>
						<li><a class="act" href="#" mbId="<?php echo $membro["id"]; ?>" color="<?php echo $membro["cor"]; ?>">
							<img src="<?php echo $uploadUrl.$membro["foto"]; ?>" alt="#" style="background-color: <?php echo $membro["cor"]; ?>;">
						<p><?php echo $membro["apelido"]; ?></p>
					</a></li>
					<?php endwhile; ?>
				</ul>
			</div>
		</section> 
		<footer></footer> 
	</article>

	<div id="the-projet" class="hidden" pjname="<?php echo $projeto_atual->nome; ?>">
		<div id="view-projet">
			
			<div class="capa color1 the-border">
				<img src="<?php echo $uploadUrl.$projeto_atual->img; ?>" alt="#" width="100%">
			</div>

			<h4>Descri&ccedil;&atilde;o</h4>
			<article class="desc">
				<p><?php echo $projeto_atual->descricao; ?></p>
				<strong>Data de Cria&ccedil;&atilde;o <?php echo $projeto_atual->data; ?></strong>
			</article>
			
			<h4>Situa&ccedil;&atilde;o</h4>
			<article>
				<div class="gafico the-border-color1">
					<div style="width: <?php echo $projeto_atual->GetNivel($conexao); ?>%" class="color1">
					</div>
					<p><?php echo $projeto_atual->GetNivel($conexao); ?>%</p>
				</div>
				<ul>
					<li>Total Tarefas: <?php echo $projeto_atual->GetTotalTarefas($conexao); ?></li>
					<li>Tarefas criadas: <?php echo $projeto_atual->GetTotalStTarefas($conexao, 1); ?></li>
					<li>Tarefas fazendo: <?php echo $projeto_atual->GetTotalStTarefas($conexao, 2); ?></li>
					<li>Tarefas feito: <?php echo $projeto_atual->GetTotalStTarefas($conexao, 3); ?></li>
					<li>Membros: <?php echo $projeto_atual->GetTotalMembros($conexao); ?></li>
				</ul>
			</article>

			<h4>Membros no Projeto</h4>
  			<article>
	  			<div class="ls-3 the-members">
					<ul class="ls-view-membros-in-projeto hspan12" ></ul>
				</div>	
			</article>

			<h4>Comentarios</h4>
		  	<article>
		  		<article class="last-projet-coment">
			  		<?php
						$qry = "
							SELECT
							  m.nome,
							  m.foto,
							  pc.data,
							  pc.conteudo
							FROM
								ginga3_projetos_comentarios pc
								INNER JOIN ginga3_membros m ON pc.id_membro = m.id
							WHERE
							  pc.id_projeto =  '{$projeto_atual->id}'
							ORDER BY pc.data DESC LIMIT 1
						;";

						$resultado  = mysql_query($qry, $conexao);
						$coment = mysql_fetch_array($resultado);
			  		?>
					<header><h4><?php echo $coment["nome"]; ?></h4></header>
					<img src="<?php echo $uploadUrl.$coment["foto"]; ?>" alt="#" style="float: right">
					<p class="data"><?php echo $coment["conteudo"]; ?></p>
					<strong><?php echo $coment["data"]; ?></strong>
				</article>

				<a class="act more the-border-color1" href="#" onclick="ViewAllComentsProj(this);">Ver Todos</a> 

				<div class="new-coment color1">
					<p>Escrever:</p>
					<textarea rows="5"></textarea>
					<input type="button" id="save" class="bt color" value="Enviar" onclick="EnviarComentarioProjeto(this);">
				</div>
				
				<div class="all-coments hidden">
					<div class="ls-coments">
						<ul class="projet-coments">
							<?php $qry = "
								SELECT
								  	m.nome,
								  	m.foto,
								  	pc.data,
								  	pc.conteudo
								FROM
									ginga3_projetos_comentarios pc
									INNER JOIN ginga3_membros m ON pc.id_membro = m.id
								WHERE
								  	pc.id_projeto =  '{$projeto_atual->id}'
								ORDER BY pc.data DESC
							;"; $ls  = mysql_query($qry, $conexao); ?>
							<?php while($coments = mysql_fetch_array($ls)): ?>
								<li>
									<header><h4><?php echo $coments["nome"]; ?></h4></header>
									<img src="<?php echo $uploadUrl.$coments["foto"]; ?>" alt="#">
									<p><?php echo $coments["conteudo"]; ?></p>
									<strong><?php echo $coments["data"]; ?></strong>
								</li>					 	
							<?php endwhile; ?>
						</ul>
						<div class="new-coment color">
							<p>Escrever:</p>
							<textarea rows="5"></textarea>
						<input type="button" id="save" class="bt color" value="Enviar" onclick="EnviarComentarioProjeto(this);">
				</div>
					</div>
				</div>
		  	</article>
		</div>
	</div>

	<div id="manter-projetos-membros" class="hidden">
		
		<article class="toLeft wspan5 offwspan1_2">
			<h4>No Projeto</h4>
			<div class="ls-3 the-members the-border">
			<ul class="hspan12 drag ls-membros-in-prjeto">
				<?php 
					$qry = "
					SELECT 
						mp.id_projeto, 
						m . *
					FROM 
						ginga3_membros m
						LEFT JOIN ginga3_membros_projetos mp ON m.id = mp.id_membro
					WHERE
						mp.id_projeto='{$projeto_atual->id}';
					"; 
					$ls  = mysql_query($qry, $conexao); 
				?>
				<?php while($membro = mysql_fetch_array($ls)): ?>
					<!--membro_modelo-->
					<li class="act ls-3-li"><a mbId="<?php echo $membro["id"]; ?>" href="#" onclick="ViewAllMembers(this);">
						<img style="background-color: <?php echo $membro["cor"]; ?>;" src="<?php echo $uploadUrl.$membro["foto"]; ?>" alt="#">
						<div id="the-member" class="hidden" color="<?php echo $membro["cor"]; ?>">
							<div id="view-the-member">
								<header>
									<img src="<?php echo $uploadUrl.$membro["foto"]; ?>" height="142px" width="107px">
								</header>
									
								<section>
									<p>Nome: <span class="the-name"><?php echo $membro["nome"]; ?></span></p>
									<p>Manifesto:</p>
									<p class="manifest color">"<?php echo $membro["manifesto"]; ?>"</p>
									<p>Gargo: Programador</p>
									<p><?php echo $membro["data"]; ?></p>
									<p>Tarefas Feitas: 42</p>
								</section>
									
								<footer>
									<div id="more-actions">
										<input type="button" id="bt-msm">
										<input type="button" id="bt-chat">
										<input type="button" id="bt-yes">
									</div>
								</footer>
							</div>
						</div>
					</a></li>
				<?php endwhile; ?>
			</ul>
			</div>	
		</article>

		<article class="toLeft wspan5 offwspan1">
			<h4>Fora do Projeto</h4>
			<div class="ls-3 the-members the-border">
				<ul class="hspan12 drag ls-membros-not-in-prjeto" >
					<?php 
						$qry = "
							SELECT DISTINCT
								m . *
							FROM 
								ginga3_membros m
							LEFT JOIN ginga3_membros_projetos mp ON m.id = mp.id_membro
							WHERE
								(mp.id_projeto IS NULL OR
								mp.id_projeto !='{$projeto_atual->id}') AND
								m.id NOT IN( SELECT id_membro FROM ginga3_membros_projetos WHERE id_projeto ='{$projeto_atual->id}');
						"; 
						$ls  = mysql_query($qry, $conexao); 
					?>
					<?php while($membro = mysql_fetch_array($ls)): ?>
						<li class="act ls-3-li"><a mbId="<?php echo $membro["id"]; ?>" href="#" onclick="ViewAllMembers(this);">
							<img style="background-color: <?php echo $membro["cor"]; ?>;" src="<?php echo $uploadUrl.$membro["foto"]; ?>" alt="#">
							<div id="the-member" class="hidden" color="<?php echo $membro["cor"]; ?>">
								<div id="view-the-member">
									<header>
										<img src="<?php echo $uploadUrl.$membro["foto"]; ?>" height="142px" width="107px">
									</header>
										
									<section>
										<p>Nome: <span class="the-name"><?php echo $membro["nome"]; ?></span></p>
										<p>Manifesto:</p>
										<p class="manifest color">"<?php echo $membro["manifesto"]; ?>"</p>
										<p>Gargo: Programador</p>
										<p><?php echo $membro["data"]; ?></p>
										<p>Tarefas Feitas: 42</p>
									</section>
										
									<footer>
										<div id="more-actions">
											<input type="button" id="bt-msm">
											<input type="button" id="bt-chat">
											<input type="button" id="bt-yes">
										</div>
									</footer>
								</div>
							</div>
						</a></li>
					<?php endwhile; ?>
				</ul>
			</div>	
		</article>
	</div>

	<div id="ls-msm" class="hidden">
		<?php $qry = "
			SELECT
			  ms.*,
			  m.nome,
			  m.cor,
			  m.foto
			FROM ginga3_mensagens ms
			INNER JOIN ginga3_membros m ON ms.id_emissor = m.id
			WHERE id_receptor = '{$membro_atual->id}' AND ms.st = 1
		;"; 
		$ls  = mysql_query($qry, $conexao); ?>
		<?php while($msm = mysql_fetch_array($ls)): ?>
			<article msmId="<?php echo $msm["id"]; ?>">
				<h3><?php echo $msm["titulo"]; ?></h3>
				<section >
					<header>
						<h4><?php echo $msm["titulo"]; ?></h4>
					</header>
					<p><?php echo $msm["conteudo"]; ?></p>
					<footer>
						De quem:<?php echo $msm["nome"]; ?><br>
						Quando:<?php echo $msm["data"]; ?>
					</footer>
				</section>
			</article>		
		<?php endwhile; ?>
	</div>

	<div id="view-membros" class="hidden">
		<div class="ls-3">
			<ul class="drag" group="ls-membros">
				<?php 
					$qry = "
					SELECT
						m . *
					FROM 
						ginga3_membros m
					WHERE
						m.st > 0;
					"; 
					$ls  = mysql_query($qry, $conexao); 
				?>
				<?php while($membro = mysql_fetch_array($ls)): ?>
					<!--membro_modelo-->
					<li class="act ls-3-li" text="<?php echo $membro["email"]; ?>;"><a mbId="<?php echo $membro["id"]; ?>" href="#" onclick="ViewAllMembers(this);">
						<img style="background-color: <?php echo $membro["cor"]; ?>;" src="<?php echo $uploadUrl.$membro["foto"]; ?>" alt="#">
						<div id="the-member" class="hidden" color="<?php echo $membro["cor"]; ?>">
							<div id="view-the-member">
								<header>
									<img src="<?php echo $uploadUrl.$membro["foto"]; ?>" height="142px" width="107px">
								</header>
									
								<section>
									<p>Nome: <span class="the-name"><?php echo $membro["nome"]; ?></span></p>
									<p>Manifesto:</p>
									<p class="manifest color">"<?php echo $membro["manifesto"]; ?>"</p>
									<p>Gargo: Programador</p>
									<p><?php echo $membro["data"]; ?></p>
									<p>Tarefas Feitas: 42</p>
								</section>
									
								<footer>
									<div id="more-actions">
										<input type="button" id="bt-msm">
										<input type="button" id="bt-chat">
										<input type="button" id="bt-yes">
									</div>
								</footer>
							</div>
						</div>
					</a></li>
				<?php endwhile; ?>
			</ul>
		</div>		
	</div>

	<div id="resp-msm" class="hidden">
		<article class="resp-msm">
			<header>
				<label class="line act drag"><input class="bt-membros color1" type="button" >Selecionar</label>
				<label>
				<p>Para:</p>
				<input type="text" class="drag" group="ls-membros" id="send-to"><br>
				</label>
			</header>
			
			<div>
				<p>Tit&uacute;lo:</p>
				<input type="text" id="msm-title"><br>
				<p>Corpo</p>
				<textarea cols="42" rows="12" id="themsm">Escrever...</textarea>
			</div>

			<footer>
				De quem:<?php echo $membro_atual->apelido; ?><br>
				Quando:
			</footer>
		</article>
	</div>

	<div id="entrada-msm" class="hidden">
		<div class="ls-2 box-entrada">
			<ul>
				<?php $qry = "
					SELECT
					  ms.*,
					  m.nome,
					  m.cor,
					  m.foto
					FROM ginga3_mensagens ms
					INNER JOIN ginga3_membros m ON ms.id_emissor = m.id
					WHERE id_receptor = '{$membro_atual->id}'
				;"; 
				$ls  = mysql_query($qry, $conexao); ?>
				<?php while($msm = mysql_fetch_array($ls)): ?>
				<li class="ls-2-li"><a class="act" href="#">
					<p><?php echo $msm["titulo"];  ?></p>
					<img src="<?php echo $uploadUrl.$msm["foto"]; ?>" alt="#" style="background-color: <?php echo $msm["cor"]; ?>;">
					<article class="hidden">
						<h3><?php echo $msm["titulo"];  ?></h3>
						<section>
							<p><?php echo $msm["conteudo"]; ?></p>
							<footer>
								De quem:<?php echo $msm["nome"]; ?><br>
								Quando:<?php echo $msm["data"]; ?>
							</footer>
						</section>
					</article>
				</a></li>
				<?php endwhile; ?>
			</ul>
		</div>
	</div>

	<div id="saida-msm" class="hidden">
		<div class="ls-2 box-saida">
			
			<ul class="drag" group="ls-tarefas">
				<?php $qry = "
					SELECT
					  ms.*,
					  m.nome,
					  m.cor,
					  m.foto
					FROM ginga3_mensagens ms
					INNER JOIN ginga3_membros m ON ms.id_receptor = m.id
					WHERE id_emissor = '{$membro_atual->id}'
				;"; 
				$ls  = mysql_query($qry, $conexao); ?>
				<?php while($msm = mysql_fetch_array($ls)): ?>
				<li class="ls-2-li"><a class="act" href="#">
					<p><?php echo $msm["titulo"];  ?></p>
					<img src="<?php echo $uploadUrl.$msm["foto"]; ?>" alt="#" style="background-color: <?php echo $msm["cor"]; ?>;">
					<article class="hidden">
						<h3><?php echo $msm["titulo"];  ?></h3>
						<section>
							<p><?php echo $msm["conteudo"]; ?></p>
							<footer>
								De quem:<?php echo $msm["nome"]; ?><br>
								Quando:<?php echo $msm["data"]; ?>
							</footer>
						</section>
					</article>
				</a></li>
				<?php endwhile; ?>	
			</ul>
		</div>
	</div>

	<div class="hidden"> 
		<textarea id="mb-preferences">
			<div class="edit">
				<div class="ed-img">
				    <p>Foto:</p>
				    <a href="#"><img class="color1" src="<?php echo $uploadUrl.$membro_atual->foto; ?>" height="216px" width="162px"></a>
				    <label>
				        <input type="file" name="mb_img" onchange="readIMG(this);"/>
				        <input type="button" class="bt color1" value="Selecionar">
				    </label>
				</div>
				<p style="position: relative;">Cor de Tema:</p>
				<input owner="color1" left="50px" type="button" value="<?php echo $membro_atual->cor; ?>" class="ed-nt-color"><input type="text" class="hidden" value="<?php echo $membro_atual->cor; ?>" name="mb_cor">
				<input owner="color2" left="89px" type="button" value="<?php echo $membro_atual->cor2; ?>" class="ed-nt-color"><input type="text" class="hidden" value="<?php echo $membro_atual->cor2; ?>" name="mb_cor2">
				<input owner="color3" left="128px" type="button" value="<?php echo $membro_atual->cor3; ?>" class="ed-nt-color"><input type="text" class="hidden" value="<?php echo $membro_atual->cor3; ?>" name="mb_cor3">
				<p>Nome:</p><input type="text" value="<?php echo $membro_atual->nome;?>" name="mb_nome">
				<p>Apelido:</p><input type="text" value="<?php echo $membro_atual->apelido; ?>" name="mb_alias">
				<p>E-mail:</p><input type="email" value="<?php echo $membro_atual->email; ?>" name="mb_email">
				<p>Manifesto:</p><textarea rows="5" name="mb_manifesto"><?php echo $membro_atual->manifesto; ?></textarea>
			</div>
		</textarea>
	</div>
	
	<footer class="box-padrao color2">
		<p>Ginga 3.0</p>
	</footer>

	<div id="load" style="display: none">
		<img src="img/load.gif">
	</div>

	<div id="new-color"></div>

	<!--Nav-Menu-->
	<script>
		function NavMenu1Init(){

			$("#nav-menu-01>ul>li>ul").each(function(){

				$(this).attr("height", $(this).height()+"px" );

				$(this).parent().mouseenter(function(){

					var ul = $(this).children("ul");
					if( ul.attr("animated") ) return;
					ul.attr("animated", true);					
					ul.animate(
						{height: ul.attr("height")},
						200,
						function(){ ul.attr("animated", ""); }
					);		
				});

				$(this).parent().mouseleave(function(){

					var ul = $(this).children("ul");

					ul.animate(
						{height: 0},
						200
					);
				});
			});
			
			$("#nav-menu-01>ul>li>ul").css("height", 0);		
		}
		NavMenu1Init();
	</script>

	<!-- Global Itens -->
	<script>
		var fm_padrao  = new FormPadrao();
		var fm_padrao2 = new FormPadrao();
		var fm_media   = new FormMedia();
		var fm_media2  = new FormMedia();
	</script>
	
	<!-- Local Itens -->
	<script>
		$(document).ready(function() {
			
			DragInit();

			EndLoad();

			execute_end_grag = function(group, id, item, list){
				
				item.children(".state1, .state2, .state3").remove();

				var st = 0;
				if(list.attr("id") == 'ls-tfs-criadas') st = 1;
				if(list.attr("id") == 'ls-tfs-fazendo') st = 2;
				if(list.attr("id") == 'ls-tfs-feitas') st = 3;
				
				$.ajax({ 
					type: "POST", 
					url: "actions.php", 
					data: {"at-tarefa": true, "id-tarefa": id, "st-tarefa": st},
					success: function (data) { 
						
						if(data != 0){
						  	item.append(data);

							$.ajax({ 
								type: "POST", 
								url: "actions.php", 
								data: {"GET-PROJET": true},
								success: function (data) { 
									$("#the-projet").html(data);
									$(bt).parent().children("textarea").val("")
								} 
							});

						} else {
							item.append(error);
						}
						
					} 
				});
			}

			$(".focos").css("opacity", 0);
			$(".focos").animate(
				{opacity: 1},
				500,
				function(){
					setTimeout(function(){
						$(".focos").animate(
							{opacity: 0},
							500,
							function(){ $(this).css("display", "none"); }
						);
					}, 3000);
				}
			);

			//Speed Menus
			$(".fm-notificao").css( "left", "-272px" );
			$("._atz").click(function(){
				if($(".fm-notificao").css("left") ==  "-272px")
					$(".fm-notificao").animate(
						{left: 0},
						500
					);
				else
					$(".fm-notificao").animate(
						{left: "-272px"},
						500
					);
			});
			$(".fm-membros-state").css( "right", "-272px" );
			$("._chat").click(function(){
				if($(".fm-membros-state").css("right") ==  "-272px")
					$(".fm-membros-state").animate(
						{right: 0},
						500
					);
				else
					$(".fm-membros-state").animate(
						{right: "-272px"},
						500
					);
			});
			//End Speed Menus

			//Mensagens
			if($("#ls-msm>article").length > 0){

				$("#nav-menu-01>ul>#msm .evident").html($("#ls-msm>article").length);
				$("#bt-msm").click(function(){

					if($("#ls-msm>article").length == 0) return;

					var array = new Array();

					$("#ls-msm>article").each(function(index){
						array[index] = new DataView(
							$(this).children("h3").html(), 
							$(this).children("section").html()
						);
					});

					$.ajax({ 
						type: "POST", 
						url: "actions.php", 
						data: {"ok-msm": true, "id": $("#ls-msm>article").attr("msmId")},
						success: function (data) { 
							$("#ls-msm>article").eq(0).remove();	
						} 
					});

					if($("#ls-msm>article").length != 0)
						$("#nav-menu-01>ul>#msm .evident").html($("#ls-msm>article").length);
					else
						$("#nav-menu-01>ul>#msm .evident").html("");
				
					fm_media.Open({
						data:   array,
						next:   function(index){

							$.ajax({ 
								type: "POST", 
								url: "actions.php", 
								data: {"ok-msm": true, "id": $("#ls-msm>article").attr("msmId")},
								success: function (data) { 
									$("#ls-msm>article").eq(0).remove();	
									if($("#ls-msm>article").length != 0)
										$("#nav-menu-01>ul>#msm .evident").html($("#ls-msm>article").length);
									else
										$("#nav-menu-01>ul>#msm .evident").html("");
								} 
							});

						},
						width:  300,
						height: 300
					});

				});
			}
			$("#new-msm").click(function(){

				fm_padrao.Open({
					title:  "Escrever",
					data:   $("#resp-msm").html(),
					save:   function(conteiner){ 
						
						var str = "";
						var start = 0;
						var end = 0;

						var membros = new Array();

						str = $(conteiner).find("#send-to").val();
						do{
							end 	   = str.indexOf(";");

							var membro = str.substr(start, end);
							do{
								membro = membro.substr(start, end).replace(" ","");
							}while(membro.indexOf(" ")!= -1);

							membros[membros.length] = membro;

							str = str.substr( str.indexOf(";") + 1);
						}while(str.indexOf(";") != -1);

						var title    = $(conteiner).find("#msm-title").val();
						var conteudo = $(conteiner).find("#themsm").val();

						$.ajax({  
							type: "POST",  
							url: "actions.php",  
							data: {"membros_email": membros, "send-msm": true, "titulo": title, "conteudo": conteudo}, 
							success: function( data )  
							{	
								if(data == 1){
									FormPadrao_CloseAll();
								}else{
									alert("Erro! tente novamente e verifique os dados da mensagem.");
								}
							}  
						});

					},
					cancel: function(){ alert("cancel"); },
					close:  function(){ FormPadrao_CloseAll(); },
					save_label: "Enviar"
				});

				$(".resp-msm .bt-membros").unbind("click").click(function(){
					
					fm_padrao2.Open({
						data: $("#view-membros").html(),
						move: true,
						title: "Membros"
					});

					DragInit();
				});
			});
			$("#ent-msm").click(function(){
				
				fm_padrao.Open({
					title:  "Entrada",
					data:   $("#entrada-msm").html(),
					move: true,
					height: 425
				});

				$(".box-entrada li").unbind("click").click(function(){
					
					var array = new Array();
					var index = $(this).parent().children("li").index(this);

					$(this).parent().children("li").children("a").each(function(index){
						var data = $(this).children("article").html();
						var name = $(this).children("article").children("h3").html();

						array[index] = new DataView(name, data);
					});

					fm_media.Open({
						data: array,
						width: 300,
						height: 300,
						at: index
					});
				});
			});
			$("#sai-msm").click(function(){
				
				fm_padrao.Open({
					title:  "Saida",
					data:   $("#saida-msm").html(),
					move: true,
					height: 425
				});

				$(".box-saida li").unbind("click").click(function(){

					var fm    = new FormMedia();
					var array = new Array();
					var index = $(this).parent().children("li").index(this);

					$(this).parent().children("li").children("a").each(function(index){
						var data = $(this).children("article").html();
						var name = $(this).children("article").children("h3").html();

						array[index] = new DataView(name, data);
					});

					fm.Open({
						data: array,
						width: 300,
						height: 300,
						at: index
					});
				});
			});
			//End-Mensagens

			//Menu
			$("#mb-conf").click(function(){

				fm_padrao.Open({
						title:  "Preferencias",
						data:   $("#mb-preferences").val(),
						cancel: function(){ FormPadrao_CloseAll(); $("#new-color").html(""); },
						close:  function(){ $("#new-color").html(""); },
						move: true,
						height: 540,
						submit: true,
						save_name: "update-membro"
				});

				$('form').submit(function(event){
					var erro = false;

					if(erro){
						$("section").animate({scrollTop: 0}, 500);
						event.preventDefault();
					}
					else
						return;
				});

				if($(".ed-nt-color").length > 0){
				
					var index = $(".ed-nt-color").index(this);
					
					$("body").append("<style> .ed-nt-color{ background: none; border: solid 5px #303030; border-radius: 5px; width: 30px; height: 30px; margin: 0; } .nt-color{ box-shadow: 1px 1px 5px; display: table; position: absolute; z-index: 9999; border-radius:5px 5px 5px 5px; overflow: hidden; border: solid 5px #303030; } .nt-color>div{ width: 282px; background-color: #505050; overflow: hidden; display: table; box-shadow: 0 0 15px inset; position: relative; } .nt-color>div>*{ float: left; } .nt-color>div>.conf{ display: block; width: 10px; margin-left: 5px; margin-right: 5px; position: relative; border: solid 1px #303030; height: 127.5px; } .nt-color>div>.conf>div{ position: absolute; bottom: 0; width: 10px; display: block; border-top: solid 1px #000; } .nt-color>div>.conf>div>div{ display: block; height: 1px; background-color: #fff; width: 16px; margin-left: -4px; border: solid 1px; margin-top: -2px; } .nt-color #primary-colors{ width: 51px; margin: 3px; } .nt-color #primary-colors>div{ width: 24px; height: 24px; float: left; margin-top: 1px; margin-left: 1px; box-shadow: 0 0 5px #000 inset; } .nt-color #intencao{ margin-left: 10px; margin-right: 10px; background-color: #000; box-shadow: 0 0 8px #808080 inset; } .nt-color #intencao>div{ box-shadow: 0 0 8px inset; background-color: #FFF; } .nt-color #r>div{ background-color: #FF0000; } .nt-color #g>div{ background-color: #00FF00; } .nt-color #b>div{ background-color: #0000FF; } .nt-color .view, .nt-color .at{ float: none; position: absolute; width: 60px; height: 40px; border: solid 5px #303030; border-radius: 5px; margin-right: 5px; margin-top: 5px; right: 5px; }.nt-color .at{ top: 45px; border-top: none; border-top-left-radius: 0; border-top-right-radius: 0; }.nt-color .view{ border-bottom-left-radius: 0; border-bottom-right-radius: 0; } .nt-color .view{ border-bottom: none; border-bottom-right-radius: 0; border-bottom-left-radius: 0; } .nt-color #bt-ok{ background:none; position: absolute; bottom: 0; right: 0; width: 30px; margin-right: 25px; margin-bottom: 8px; border: solid 1px #FFFFFF; border-radius: 3px; background-color: #FFF; } .nt-color #bt-ok:hover{ background-color: rgba( 255, 255, 255, 0.5); } .nt-color #bt-ok:active{ background-color: #303030; } .nt-color p{ margin: 0; margin-top: 12px; margin-right: 5px; } .nt-color p>input{ width: 22px; background: none; border: solid 1px #303030; } </style>");
					$(".ed-nt-color").parent().append("<div class='nt-color'> <div> <div id='primary-colors'> <div style='background-color: rgb(255, 255, 255);' R='255' G='255' B='255'></div> <div style='background-color: rgb(255,   0,   0);' R='255' G='0'   B='0'></div> <div style='background-color: rgb(  0, 255,   0);' R='0'   G='255' B='0'></div> <div style='background-color: rgb(  0,   0, 255);' R='0'   G='0'   B='255'></div> <div style='background-color: rgb(255, 255,   0);' R='255' G='255' B='0'></div> <div style='background-color: rgb(  0, 255, 255);' R='0'   G='255' B='255'></div> <div style='background-color: rgb(255,   0, 255);' R='255' G='0'   B='255'></div> <div style='background-color: rgb(  0,   0,   0);' R='0'   G='0'   B='0'></div>  <div style='background-color: rgb(255, 127,   0);' R='255' G='127' B='0'></div> <div style='background-color: rgb(127, 127, 255);' R='127' G='127' B='255'></div> </div> <div class='conf' id='intencao'><div style='height: 63.5px;'><div></div></div></div> <div class='conf' id='r'><div style='height: 127.5px;'><div></div></div></div> <div class='conf' id='g'><div style='height: 127.5px;'><div></div></div></div> <div class='conf' id='b'><div style='height: 127.5px;'><div></div></div></div> <div> <p>R:<input id='inputR' type='text'></p> <p>G:<input id='inputG' type='text'></p> <p>B:<input id='inputB' type='text'></p> </div> <div style='background-color: rgb(255, 255, 255);' R='255' G='255' B='255' class='view'></div> <div style='background-color: rgb(255, 255, 255);' R='255' G='255' B='255' class='at'></div> <input type='button' class='bt' value='Ok' id='bt-ok'> </div> </div>");
					
					$(".nt-color").css("display", "none");

					$(".ed-nt-color").each(function(){
						$(this).css("background-color", $(this).val());
						$(this).css("color", $(this).val());
					});				

					$(".ed-nt-color").click(function(){
						index = $(".ed-nt-color").index(this);

						$(".ed-nt-color").css("border-top-left-radius", "5px");
						$(".ed-nt-color").css("border-top-right-radius", "5px");
						$(".ed-nt-color").css("border-bottom-right-radius", "5px");
						$(".ed-nt-color").css("border-bottom-left-radius", "5px");

						if( $(".nt-color").css("display") == "table"){
							$(this).css("border-top-left-radius", "5px");
							$(this).css("border-top-right-radius", "5px");
							$(this).css("border-bottom-right-radius", "5px");
							$(this).css("border-bottom-left-radius", "5px");
							$(this).css("box-shadow", "");
							$(".nt-color").hide(10);	
							return;
						};
						
						$(".nt-color").css("top", 280 );
						$(".nt-color").css("left", $(this).attr("left"));

						$(this).css("border-top-left-radius", "5px");
						$(this).css("border-top-right-radius", "0px");
						$(this).css("border-bottom-right-radius", "0px");
						$(this).css("border-bottom-left-radius", "5px");
						$(this).css("box-shadow", "0 0 5px #000");
						 
						$(".nt-color").show();
						$(".nt-color input").focus();				

						$(".nt-color .at").css("background-color", $(this).val());
						 
						var str = "";
						var start = 0;
						var end = 0;

						str = $(".nt-color .at").css("background-color");
						start = str.indexOf("(")+1;
						end = str.indexOf(",");

						end = end - start;

						var sR = str.substr(start, end);
						str = str.substr( str.indexOf(",") + 1);
						var sG = str.substr(0,str.indexOf(","));
						str = str.substr( str.indexOf(",") + 1);
						str = str.substr( 0, str.length - 1);
						var sB = str;
						
						$(".nt-color .view").css("background-color", $(this).val());
						$(".nt-color .view").attr("R", parseInt(sR));
						$(".nt-color .view").attr("G", parseInt(sG));
						$(".nt-color .view").attr("B", parseInt(sB));

						$("#r").children("div").height( parseInt(sR)/2 );				
						$("#g").children("div").height( parseInt(sG)/2 );				
						$("#b").children("div").height( parseInt(sB)/2 );
						$("#intencao").children("div").height(63.5);

						$("#inputR").val(parseInt(sR)); $("#inputG").val(parseInt(sG)); $("#inputB").val(parseInt(sB)); 	
					});

					$("#bt-ok").click(function(){
						$(".nt-color").hide();
						
						$(".ed-nt-color").eq(index).css("border-top-left-radius", "5px");
						$(".ed-nt-color").eq(index).css("border-top-right-radius", "5px");
						$(".ed-nt-color").eq(index).css("border-bottom-right-radius", "5px");
						$(".ed-nt-color").eq(index).css("border-bottom-left-radius", "5px");
						$(".ed-nt-color").eq(index).css("box-shadow", "");
						
						$(".ed-nt-color").eq(index).val( $(".nt-color .view").css("background-color") );
						$(".ed-nt-color").eq(index).css("background-color", $(".ed-nt-color").eq(index).val());
						$(".ed-nt-color").eq(index).css("color", $(".ed-nt-color").eq(index).val());

						$("input[name='mb_cor']").val($(".ed-nt-color").eq(0).val());
						$("input[name='mb_cor2']").val($(".ed-nt-color").eq(1).val());
						$("input[name='mb_cor3']").val($(".ed-nt-color").eq(2).val());
						
						$("#new-color").html("");
						$(".ed-nt-color").each(function(index){
							if($(this).attr("owner"))
								$("#new-color").append("<style> ."+$(this).attr("owner")+"{ background-color: "+$(this).val()+";} .the-border-"+$(this).attr("owner")+"{ border: solid 1px "+$(this).val()+"; } .border-"+$(this).attr("owner")+"{ border-color: "+$(this).val()+"; } .box-"+$(this).attr("owner")+"{ border-radius: 5px; box-shadow: 0 0 12px "+$(this).val()+"; } <style>");
						});
					});

					$("#inputR, #inputG, #inputB").keyup(function(e){
						if(parseInt($(this).val()) > 255) $(this).val("255");
						if($(this).val() == "") $(this).val("0");

						$(".nt-color .view").attr("R", parseInt($("#inputR").val()));
						$(".nt-color .view").attr("G", parseInt($("#inputG").val()));
						$(".nt-color .view").attr("B", parseInt($("#inputB").val()));

						$("#r").children("div").height( parseInt($("#inputR").val())/2 );				
						$("#g").children("div").height( parseInt($("#inputG").val())/2 );				
						$("#b").children("div").height( parseInt($("#inputB").val())/2 );
						$("#intencao").children("div").height(63.5);

						$(".nt-color .view").css("background-color", "rgb("+ parseInt($("#inputR").val())+","+parseInt($("#inputG").val())+","+parseInt($("#inputB").val())+")");
						
						if(
							e.which >= 48 && e.which <= 57
						)
							$(this).val(parseInt($(this).val()));					
					});
					$("#inputR, #inputG, #inputB").keydown(function(e){
						var text = $(this).val();
						//alert(e.which);
						
						if(
							e.which == 37 ||
							e.which == 39 || 
							e.which ==  8 || 
							e.which ==  9 || 
							e.which == 46 ||
							e.which == 116 
						) return true;

						if(e.which == 38){
							$(this).val(parseInt($(this).val()) + 1); 
							if(parseInt($(this).val()) > 255) $(this).val("255");
							$(".nt-color .view").css("background-color", "rgb("+ parseInt($("#inputR").val())+","+parseInt($("#inputG").val())+","+parseInt($("#inputB").val())+")");
							$("#r").children("div").height( parseInt($("#inputR").val())/2 );				
							$("#g").children("div").height( parseInt($("#inputG").val())/2 );				
							$("#b").children("div").height( parseInt($("#inputB").val())/2 );
							$("#intencao").children("div").height(63.5);
							return true;
						}
						if(e.which == 40){
							$(this).val(parseInt($(this).val()) - 1); 
							if(parseInt($(this).val()) < 0) $(this).val("0");
							$(".nt-color .view").css("background-color", "rgb("+ parseInt($("#inputR").val())+","+parseInt($("#inputG").val())+","+parseInt($("#inputB").val())+")");
							$("#r").children("div").height( parseInt($("#inputR").val())/2 );				
							$("#g").children("div").height( parseInt($("#inputG").val())/2 );				
							$("#b").children("div").height( parseInt($("#inputB").val())/2 );
							$("#intencao").children("div").height(63.5);
							return true;
						}

						if(
							e.which < 48 || 
							e.which > 57
						) return false;

						if(text.length == 3) return false;
					});

					$(".nt-color #primary-colors>div").click(function(){
						$(".nt-color .view").css("background-color", $(this).css("background-color") );
						
						$(".nt-color .view").attr("R", $(this).attr("R"));
						$(".nt-color .view").attr("G", $(this).attr("G"));
						$(".nt-color .view").attr("B", $(this).attr("B"));

						$("#intencao").children("div").height(63.5);				
						$("#r").children("div").height( $(this).attr("R")/2 );				
						$("#g").children("div").height( $(this).attr("G")/2 );				
						$("#b").children("div").height( $(this).attr("B")/2 );

						$("#inputR").val($(this).attr("R")); $("#inputG").val($(this).attr("G")); $("#inputB").val($(this).attr("B"));				
					});

					$("#intencao").mousedown(function(e){
						
						var init_R = $(".nt-color .view").attr("r");
						var init_G = $(".nt-color .view").attr("g");
						var init_B = $(".nt-color .view").attr("b");
						var conf = $(this);

						var R = 0, G = 0, B = 0;

						var value = e.pageY - getTop(this);
						$("#intencao").children("div").height($("#intencao").height() - value);
						
						if(value > $("#intencao").height()/2){
							R = parseInt( $("#intencao").children("div").height() * (init_R/($("#intencao").height()/2)) );
							G = parseInt( $("#intencao").children("div").height() * (init_G/($("#intencao").height()/2)) );
							B = parseInt( $("#intencao").children("div").height() * (init_B/($("#intencao").height()/2)) );
						}else{
							R = 255 - parseInt( (($("#intencao").height()/2)-($("#intencao").children("div").height()-($("#intencao").height()/2))) * ((255-init_R)/($("#intencao").height()/2)) );
							G = 255 - parseInt( (($("#intencao").height()/2)-($("#intencao").children("div").height()-($("#intencao").height()/2))) * ((255-init_G)/($("#intencao").height()/2)) );
							B = 255 - parseInt( (($("#intencao").height()/2)-($("#intencao").children("div").height()-($("#intencao").height()/2))) * ((255-init_B)/($("#intencao").height()/2)) );
						}

						$("#r").children("div").height(R/2);
						$("#g").children("div").height(G/2);
						$("#b").children("div").height(B/2);
			
						$("#inputR").val(R); $("#inputG").val(G); $("#inputB").val(B); 			
						$(".nt-color .view").css("background-color", "rgb("+R+","+G+","+B+")");

						$(window).mousemove(function(e){

							var value = e.pageY - getTop(conf);

							if($("#intencao").height() - value > $("#intencao").height() ){	value = 0.5; } 
							if($("#intencao").height() - value < 0 ){ value = $("#intencao").height(); }

							$("#intencao").children("div").height($("#intencao").height() - value);
							
							if(value > $("#intencao").height()/2){
								R = parseInt( $("#intencao").children("div").height() * (init_R/($("#intencao").height()/2)) );
								G = parseInt( $("#intencao").children("div").height() * (init_G/($("#intencao").height()/2)) );
								B = parseInt( $("#intencao").children("div").height() * (init_B/($("#intencao").height()/2)) );
							}else{
								R = 255 - parseInt( (($("#intencao").height()/2)-($("#intencao").children("div").height()-($("#intencao").height()/2))) * ((255-init_R)/($("#intencao").height()/2)) );
								G = 255 - parseInt( (($("#intencao").height()/2)-($("#intencao").children("div").height()-($("#intencao").height()/2))) * ((255-init_G)/($("#intencao").height()/2)) );
								B = 255 - parseInt( (($("#intencao").height()/2)-($("#intencao").children("div").height()-($("#intencao").height()/2))) * ((255-init_B)/($("#intencao").height()/2)) );
							}

							$("#r").children("div").height(R/2);
							$("#g").children("div").height(G/2);
							$("#b").children("div").height(B/2);

							$("#inputR").val(R); $("#inputG").val(G); $("#inputB").val(B);
							$(".nt-color .view").css("background-color", "rgb("+R+","+G+","+B+")");
						});

						$(window).mouseup(function(){

							$(".nt-color .view").attr("R", R);
							$(".nt-color .view").attr("G", G);
							$(".nt-color .view").attr("B", B);

							$(window).unbind("mousemove");
						});

						return false;
					});
					$("#r").mousedown(function(e){
						
						var init_R = $(".nt-color .view").attr("r");
						var init_G = $(".nt-color .view").attr("g");
						var init_B = $(".nt-color .view").attr("b");
						var R = init_R, G = init_G, B = init_B;
						var conf = $(this);
						var value = e.pageY - getTop(this);
						
						conf.children("div").height($("#intencao").height() - value);
						init_R = parseInt( conf.children("div").height() * 2);

						$("#inputR").val(init_R); $("#inputG").val(init_G); $("#inputB").val(init_B);
						$(".nt-color .view").css("background-color", "rgb("+init_R+" ,"+init_G+" ,"+init_B+")");

						$(".nt-color .view").attr("r", init_R);
						$(".nt-color .view").attr("g", init_G);
						$(".nt-color .view").attr("b", init_B);

						R = init_R; 
						G = init_G; 
						B = init_B;

						$("#intencao").children("div").height(63.5);

						$(window).mousemove(function(e){
							
							var value = e.pageY - getTop(conf);

							if($("#intencao").height() - value > $("#intencao").height() ){	value = 0.5; } 
							if($("#intencao").height() - value < 0 ){ value = $("#intencao").height(); }

							conf.children("div").height( $("#intencao").height() - value );

							R = parseInt( conf.children("div").height() * 2);

							$("#inputR").val(R); $("#inputG").val(G); $("#inputB").val(B);
							$(".nt-color .view").css("background-color", "rgb("+R+" ,"+G+" ,"+B+")");

						});

						$(window).mouseup(function(){
							
							$(".nt-color .view").attr("R", R);
							$(".nt-color .view").attr("G", G);
							$(".nt-color .view").attr("B", B);
							$("#intencao").children("div").height(63.5);

							$(this).unbind("mousemove");
							$(this).unbind("mouseup");
						});

						return false;
					});
					$("#g").mousedown(function(e){
						
						var init_R = $(".nt-color .view").attr("r");
						var init_G = $(".nt-color .view").attr("g");
						var init_B = $(".nt-color .view").attr("b");
						var R = init_R, G = init_G, B = init_B;
						var conf = $(this);
						var value = e.pageY - getTop(this);
						
						conf.children("div").height($("#intencao").height() - value);
						init_G = parseInt( conf.children("div").height() * 2);

						$("#inputR").val(init_R); $("#inputG").val(init_G); $("#inputB").val(init_B);
						$(".nt-color .view").css("background-color", "rgb("+init_R+" ,"+init_G+" ,"+init_B+")");

						$(".nt-color .view").attr("r", init_R);
						$(".nt-color .view").attr("g", init_G);
						$(".nt-color .view").attr("b", init_B);

						R = init_R; 
						G = init_G; 
						B = init_B;

						$("#intencao").children("div").height(63.5);

						$(window).mousemove(function(e){
							
							var value = e.pageY - getTop(conf);

							if($("#intencao").height() - value > $("#intencao").height() ){	value = 0.5; } 
							if($("#intencao").height() - value < 0 ){ value = $("#intencao").height(); }

							conf.children("div").height( $("#intencao").height() - value );

							G = parseInt( conf.children("div").height() * 2);

							$("#inputR").val(R); $("#inputG").val(G); $("#inputB").val(B);
							$(".nt-color .view").css("background-color", "rgb("+R+" ,"+G+" ,"+B+")");

						});

						$(window).mouseup(function(){
							
							$(".nt-color .view").attr("R", R);
							$(".nt-color .view").attr("G", G);
							$(".nt-color .view").attr("B", B);
							$("#intencao").children("div").height(63.5);

							$(this).unbind("mousemove");
							$(this).unbind("mouseup");
						});

						return false;
					});
					$("#b").mousedown(function(e){
						
						var init_R = $(".nt-color .view").attr("r");
						var init_G = $(".nt-color .view").attr("g");
						var init_B = $(".nt-color .view").attr("b");
						var R = init_R, G = init_G, B = init_B;
						var conf = $(this);
						var value = e.pageY - getTop(this);
						
						conf.children("div").height($("#intencao").height() - value);
						init_B = parseInt( conf.children("div").height() * 2);

						$("#inputR").val(init_R); $("#inputG").val(init_G); $("#inputB").val(init_B);
						$(".nt-color .view").css("background-color", "rgb("+init_R+" ,"+init_G+" ,"+init_B+")");

						$(".nt-color .view").attr("r", init_R);
						$(".nt-color .view").attr("g", init_G);
						$(".nt-color .view").attr("b", init_B);

						R = init_R; 
						G = init_G; 
						B = init_B;

						$("#intencao").children("div").height(63.5);

						$(window).mousemove(function(e){
							
							var value = e.pageY - getTop(conf);

							if($("#intencao").height() - value > $("#intencao").height() ){	value = 0.5; } 
							if($("#intencao").height() - value < 0 ){ value = $("#intencao").height(); }

							conf.children("div").height( $("#intencao").height() - value );

							B = parseInt( conf.children("div").height() * 2);

							$("#inputR").val(R); $("#inputG").val(G); $("#inputB").val(B);
							$(".nt-color .view").css("background-color", "rgb("+R+" ,"+G+" ,"+B+")");

						});

						$(window).mouseup(function(){
							
							$(".nt-color .view").attr("R", R);
							$(".nt-color .view").attr("G", G);
							$(".nt-color .view").attr("B", B);
							$("#intencao").children("div").height(63.5);

							$(this).unbind("mousemove");
							$(this).unbind("mouseup");
						});

						return false;
					});
				}
			});
			$("#the-pjt").click(function(){

				$(".ls-view-membros-in-projeto").html($("#manter-projetos-membros").find(".ls-membros-in-prjeto").html());

				var array = new Array();
				var title = $("#the-projet").attr('pjname');

				array[0] = new DataView(title, $("#the-projet").html());
							
				fm_media.Open({
					data:   array,
					width:  480,
					height: 400
				});
			});
			//End-Menu

			//Chat
			$(".fm-membros-state li>a").unbind("click").click(function(){
				var other_id = $(this).attr("MbId");
				var nome     = $(this).children("p").html();
				var my_id    = $("#the-my-id").val();
				var my_fofo  = $("#the-my-foto").val();
				var dialog   = "";

				var link = $(this);

				$.ajax({ 
					type: "POST", 
					url: "actions.php", 
					data: {"chat-get-initial": true, "id_membro": other_id},
					success: function (data) {
					    dialog = data;

						fm_chat = new FormChat({
							name: nome,
							list: dialog,
							send: function(text){ 

								$.ajax({ 
									type: "POST", 
									url: "actions.php", 
									data: {"chat-send": true, "id_membro" : other_id, "conteudo": text},
									success: function (data) {} 
								});

								return "<li class='li_owner'><a href='#'><img class='mb_img' src='"+my_fofo+"'></a>"+text+"</li>";
							},
							color: link.attr("color"),
							mbstyle: link.attr("color"),
							reload: function(){

								$.ajax({ 
									type: "POST", 
									url: "actions.php", 
									data: {"chat-reload": true, "id_membro" : other_id},
									success: function (data) {
										dialog =  data;
									} 
								}); 

								return dialog;
							}
						});
					} 
				});
			});
			//End-Chat

			//Noticias
			$(".ls-noticia>ul>li").click(function(){

				var array = new Array();
				var atual = $(".ls-noticia>ul>li").index(this);

				$(".ls-noticia>ul>li").each(function(index){
					var titulo = $(this).find("h4").html();
					var data   = "<div class='the-noticia'>"+ $(this).children("a").html() + "</div>";

					array[index] = new DataView(titulo, data);

				});

				fm_media.Open({
					data: array,
					width: 400,
					at: atual,
					title: "Not&iacute;cias"
				});
			});
			//End-Noticias

			$('#sair').unbind("click").click(function(){		
				$.ajax({  
					type: 'GET',
					url: 'actions.php',
					data: {"sair":true},
					success: function( data )  
					{  
						if (data != 0)	
						{
							$(window.document.location).attr('href','default.php');
						}
						else
						{
							alert('Ocoreu um ERRO!');
						}
					}
				});
			});
		});
	</script>

	<!-- Actions Itens -->
	<script>
		function readIMG(input) { 
			if (input.files && input.files[0]) { 	
				var reader = new FileReader();  	
				reader.onload = function (e) { 	
					$(input).parent().parent().find("img") 	
					.attr('src', e.target.result); 	
				};  	
				reader.readAsDataURL(input.files[0]); 	
			} 	
		}
		function readFILE(input) { 	
			if (input.files && input.files[0]) { 	
				var reader = new FileReader();  	
				reader.onload = function (e) { 	
					$(input).parent().find("p") 	
					.html(input.files[0].name); 	
				};  	
				reader.readAsDataURL(input.files[0]); 	
			} 	
		}

		function EnviarComentario(){
			alert("Enviar");
		}; 	

		function ViewAllComentsTarefa(link){

			var coments = $(link).parent().parent().parent().parent().find(".all-coments").html();
			var array   = new Array();

			array[0] = new DataView("Coment&aacute;rios", coments);
			
			fm_media2.Open({
				data:   array,
				width: 500,
				height: 450,
				close: undefined
			});
		}

		function ViewAllComentsProj(link){

			var array = new Array();

			array[0] = new DataView("Comentarios", $(link).parent().parent().parent().parent().find(".all-coments").html());

			var fm = new FormMedia();
			
			fm.Open({
				data:   array,
				width:  480,
				height: 440
			});
		}

		function TarefaViewClick(bt){
			
			var array = new Array();

			var view   = $(bt).parent().parent().parent().find(".view").html();
			var titulo = $(bt).parent().parent().find("p").html();
			
			array[0] = new DataView(titulo, view);

			fm_media.Open({
				data: array,
				title: titulo,
				height: 420,
				width: 460
			});
		}
		function TarefaMembrosClick(bt){

			var membros = $(bt).parent().parent().parent().find(".view").find(".the-members").parent().html();
			var array = new Array();

			array[0] = new DataView("Membros - Terefa", $(bt).parent().parent().parent().find(".view").find(".the-members").parent().html());

			fm_media.Open({
				data: array
			});
		}		

		function ViewMember(link){
	
			var fm 	  = new FormMedia();
			var array = new Array();
			
			var color = $(link).parent().find("#the-member").attr("color");
			var style = "<style> #view-the-member .manifest, .fm-media input, #view-the-member #more-actions { background-color: "+color+"; } .fm-media h2{ color: "+color+"; } #view-the-member>header>img{ border-color: "+color+"; } </style>";
			var data  = style+$(link).parent().find("#the-member").html();
			var name  = $(link).parent().find("#the-member").find(".the-name").html();
			
			array[0] = new DataView(name, data);
						
			fm.Open({
				data:   array,
				width:  400,
				height: 440
			});
		}
		function ViewAllMembers(link){
	
			var fm 	  = new FormMedia();
			var array = new Array();
			var index = $(link).parent().parent().children("li").children("a").index(link);

			$(link).parent().parent().find("#the-member").each(function(index){
				var color = $(this).attr("color");
				var style = "<style> #view-the-member .manifest, .fm-media input, #view-the-member #more-actions { background-color: "+color+"; } .fm-media h2{ color: "+color+"; } #view-the-member>header>img{ border-color: "+color+"; } </style>";
				var data  = style+$(this).parent().find("#the-member").html();
				var name  = $(this).parent().find("#the-member").find(".the-name").html();
			

				array[index] = new DataView( name, data);
			});

						
			fm.Open({
				data:   array,
				width:  400,
				height: 450,
				at: index
			});
		}

		function EnviarComentarioProjeto(bt){
			var texto = $(bt).parent().children("textarea").val();

			$.ajax({ 
				type: "POST", 
				url: "actions.php", 
				data: {"coment-projet": true, "conteudo": texto},
				success: function (data) { 
					
					$.ajax({ 
						type: "POST", 
						url: "actions.php", 
						data: {"GET-LAST-PROJET-COMENT": true},
						success: function (data) { 
							$(".last-projet-coment").html(data);
						} 
					});	
					$.ajax({ 
						type: "POST", 
						url: "actions.php", 
						data: {"GET-PROJET-COMENTS": true},
						success: function (data) { 
							$(".projet-coments").html(data);
							$(bt).parent().children("textarea").val("")
						} 
					});


				} 
			});
		}; 	

		function EnviarComentarioTarefa(bt, tf_id){
			var texto = $(bt).parent().children("textarea").val();
	
			$.ajax({ 
				type: "POST", 
				url: "actions.php", 
				data: {"coment-job": true, "conteudo": texto, "id_tarefa": tf_id},
				success: function (data) { 
					
					$.ajax({ 
						type: "POST", 
						url: "actions.php", 
						data: {"GET-LAST-JOB-COMENT": true, "id_tarefa": tf_id},
						success: function (data) { 
							$(".last-job-coment-"+tf_id).html(data);
						} 
					});	
					$.ajax({ 
						type: "POST", 
						url: "actions.php", 
						data: {"GET-JOB-COMENTS": true, "id_tarefa": tf_id},
						success: function (data) { 
							$(".job-coments-"+tf_id).html(data);
							$(bt).parent().children("textarea").val("")
						} 
					});


				} 
			});
		}; 	
	</script>
	
</body>

</html>