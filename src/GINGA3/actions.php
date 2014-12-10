<?php
/*---------------------------------------------
Criado por   Natã                19/10/2012 -
revisado por Natã                23/10/2012 -   
---------------------------------------------*/

	require_once("includes/conexao.php"); 
	include("includes/Myclasses.php");
	global $conexao;
	session_start(); 
	
	$msm = "";
	$membro_atual  = new Membro();
	$projeto_atual = new Projeto(); 
	$controle_db   = new ControleDB($conexao);

	if(isset($_SESSION["id_membro"])){	
		$membro_atual->Get($conexao, $_SESSION['id_membro'] );
	}

	if($_SESSION['id_projeto'] != null) {
		$projeto_atual->Get($conexao, $_SESSION['id_projeto'] );
	} else {
		$qry = "SELECT id FROM ginga3_projetos LIMIT 1 ;";
		$resultado  = mysql_query($qry, $conexao);
		$linha = mysql_fetch_array($resultado);					
		$_SESSION["id_projeto"] =  $linha["id"];
	}

	function ListarTarefas($projeto_atual, $conexao, $uploadUrl)
	{
		?><?php $qry = "SELECT * FROM ginga3_tarefas WHERE id_projeto = '{$projeto_atual->id}'"; $ls  = mysql_query($qry, $conexao); ?>
		<?php while($tarefa = mysql_fetch_array($ls)): ?>
		 	<li tfId="<?php echo $tarefa["id"]; ?>" class="ls-2-li tarefa-li">
				<a href="#">

					<div class="tre-buttons color">
						<input tfId="<?php echo $tarefa["id"]; ?>" type="button" class="bt-view"  	onclick="TarefaViewClick(this);">
						<input tfId="<?php echo $tarefa["id"]; ?>" type="button" class="bt-membros" onclick="TarefaMembrosClick(this);">
						<input tfId="<?php echo $tarefa["id"]; ?>" type="button" class="bt-ed"  	onclick="EditTarefas(this);">
						<input tfId="<?php echo $tarefa["id"]; ?>" type="button" class="bt-rem color" 	onclick="RemoveTarefas(this);">
					</div>
					
					<p><?php echo $tarefa["nome"]; ?></p>

					<div class="membros4">
						<img src="default.png">
						<img src="default.png">
					</div>	
				</a>
				<div class="hidden view">
					<div class="view-tarefa">

						<h4>Descri&ccedil;&atilde;o</h4>
						<article class="desc"><?php echo $tarefa["descricao"]; ?></article>
				
						<h4>Comentarios</h4>
					  	<article>
					  		<article>
								<header><h4>Nome</h4></header>
								<img src="default.png" alt="#" style="float: right">
								<p class="data">Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1</p>
								<strong>12 de Novembro 2012</strong>
							</article>

							<a class="act more the-border" href="#" onclick="ViewAllComentsTarefa(this);">Ver Todos</a> 

							<div class="new-coment">
								<p>Escrever:</p>
								<textarea rows="5"></textarea>
								<input type="button" id="save" class="bt color" value="Enviar" onclick="EnviarComentario();">
							</div>
							
							<div class="all-coments hidden">
								<div class="ls-coments">
									<header></header>
									<ul>
										<li>
											<header><h4>Nome1</h4></header>
											<img src="default.png" alt="#">
											<p>Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1</p>
											<strong>11 de Novembro de 2013, 20:43h</strong>
										</li>
										<li>
											<header><h4>Nome2</h4></header>
											<img src="default.png" alt="#">
											<p>Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1</p>
											<strong>11 de Novembro de 2013, 20:43h</strong>
										</li>
										<li>
											<header><h4>Nome3</h4></header>
											<img src="default.png" alt="#">
											<p>Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Itemem1Item1Item1Item1Item1Item1Item1Item1</p>
											<strong>11 de Novembro de 2013, 20:43h</strong>
										</li>
									</ul>
									<div class="new-coment color">
										<p>Escrever:</p>
										<textarea rows="5"></textarea>
										<input type="button" id="save" class="bt color" value="Enviar" onclick="EnviarComentario();">
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
							<div class="ls-3 not-members hidden">
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
												(mt.id_tarefa IS NULL OR
												mt.id_tarefa !='{$tarefa["id"]}') AND
												m.id NOT IN( SELECT id_membro FROM ginga3_membros_tarefas WHERE id_tarefa ='{$tarefa["id"]}');
										"; 
										echo $qry;
										$ls1  = mysql_query($qry, $conexao); 
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
										<li><a class="act" href="<?php echo $uploadUrl.$arq["local"]; ?>"><?php echo $arq["nome"];?></a> <input ArqId="<?php echo $arq["id"]; ?>" TfId="<?php echo $tarefa["id"]; ?>" class="bt-rem act color" type="button" onclick="DeleteAnexo(this);"></li>
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
					                <input type="submit" value="Enviar" name="add-arquivo" class="bt color" style="float: right; margin-left: 15px;">
				                </div>
					            </form>
							</footer>
					  	</article>
					</div>
				</div>
			</li>
		<?php endwhile; ?><?php
	}

	if(isset($_GET['sair']))
	{	
		$membro_atual->ChatOut($conexao);
		$_SESSION['sessao']     = false;
		$_SESSION['id_membro']  = null;
		$_SESSION["id_projeto"] = null;
		echo 1;
	}

	if(isset($_GET['entrar-projeto']))
	{	
		$_SESSION["id_projeto"] = $_GET['id_projeto'];
		header("Location: descktop.php");
	}

	if(isset($_POST['SET-PROJET'])){
		$_SESSION['id_projeto'] = $_POST['id_projeto']; 
		$projeto_atual->Get($conexao, $_SESSION['id_projeto'] );

		echo $projeto_atual->nome;
	}
	if(isset($_POST['GET-PROJET'])){
		?>
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
							  {SelectHtml(m.nome)},
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
		</div><?php
	}
	if(isset($_POST['GET-PROJET-JOBS'])){
		?><?php $qry = "SELECT * FROM ginga3_tarefas WHERE id_projeto = '{$projeto_atual->id}'"; $ls  = mysql_query($qry, $conexao); ?>
		<?php while($tarefa = mysql_fetch_array($ls)): ?>
		 	<li tfId="<?php echo $tarefa["id"]; ?>" class="ls-2-li tarefa-li">
				<a href="#">

					<div class="tre-buttons color">
						<input tfId="<?php echo $tarefa["id"]; ?>" type="button" class="bt-view"  	  onclick="TarefaViewClick(this);">
						<input tfId="<?php echo $tarefa["id"]; ?>" type="button" class="bt-membros"   onclick="TarefaMembrosClick(this);">
						<input tfId="<?php echo $tarefa["id"]; ?>" type="button" class="bt-ed"  	  onclick="EditTarefas(this);">
						<input tfId="<?php echo $tarefa["id"]; ?>" type="button" class="bt-rem color" onclick="RemoveTarefas(this);">
					</div>
					
					<p><?php echo $tarefa["nome"]; ?></p>

					<div class="membros4">
						<img src="default.png">
						<img src="default.png">
					</div>	
				</a>
				<div class="hidden view">
					<div class="view-tarefa">

						<h4>Descri&ccedil;&atilde;o</h4>
						<article class="desc"><?php echo $tarefa["descricao"]; ?></article>
				
						<h4>Comentarios</h4>
					  	<article>
					  		<article>
								<header><h4>Nome</h4></header>
								<img src="default.png" alt="#" style="float: right">
								<p class="data">Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1</p>
								<strong>12 de Novembro 2012</strong>
							</article>

							<a class="act more the-border" href="#" onclick="ViewAllComentsTarefa(this);">Ver Todos</a> 

							<div class="new-coment">
								<p>Escrever:</p>
								<textarea rows="5"></textarea>
								<input type="button" id="save" class="bt color" value="Enviar" onclick="EnviarComentario();">
							</div>
							
							<div class="all-coments hidden">
								<div class="ls-coments">
									<header></header>
									<ul>
										<li>
											<header><h4>Nome1</h4></header>
											<img src="default.png" alt="#">
											<p>Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1</p>
											<strong>11 de Novembro de 2013, 20:43h</strong>
										</li>
										<li>
											<header><h4>Nome2</h4></header>
											<img src="default.png" alt="#">
											<p>Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1</p>
											<strong>11 de Novembro de 2013, 20:43h</strong>
										</li>
										<li>
											<header><h4>Nome3</h4></header>
											<img src="default.png" alt="#">
											<p>Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Itemem1Item1Item1Item1Item1Item1Item1Item1</p>
											<strong>11 de Novembro de 2013, 20:43h</strong>
										</li>
									</ul>
									<div class="new-coment color">
										<p>Escrever:</p>
										<textarea rows="5"></textarea>
										<input type="button" id="save" class="bt color" value="Enviar" onclick="EnviarComentario();">
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
							<div class="ls-3 not-members hidden">
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
												(mt.id_tarefa IS NULL OR
												mt.id_tarefa !='{$tarefa["id"]}') AND
												m.id NOT IN( SELECT id_membro FROM ginga3_membros_tarefas WHERE id_tarefa ='{$tarefa["id"]}');
										"; 
										echo $qry;
										$ls1  = mysql_query($qry, $conexao); 
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
										<li><a class="act" href="<?php echo $uploadUrl.$arq["local"]; ?>"><?php echo $arq["nome"];?></a> <input ArqId="<?php echo $arq["id"]; ?>" TfId="<?php echo $tarefa["id"]; ?>" class="bt-rem act color" type="button" onclick="DeleteAnexo(this);"></li>
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
					                <input type="submit" value="Enviar" name="add-arquivo" class="bt color" style="float: right; margin-left: 15px;">
				                </div>
					        	</form>
							</footer>
					  	</article>
					</div>
				</div>
			</li>
		<?php endwhile; ?><?php
	}
	if(isset($_POST['GET-PROJET-MEMBERS'])){
		
		?><?php $qry = "
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
		<?php endwhile; ?><?php
	}
	if(isset($_POST['GET-PROJET-NOMEMBERS'])){
		
		?><?php $qry = "
							SELECT DISTINCT
								m . *
							FROM 
								ginga3_membros m
							LEFT JOIN ginga3_membros_projetos mp ON m.id = mp.id_membro
							WHERE
								(mp.id_projeto IS NULL OR
								mp.id_projeto !='{$projeto_atual->id}') AND
					m.id NOT IN( SELECT id_membro FROM ginga3_membros_projetos WHERE id_projeto ='{$projeto_atual->id}');"; 
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
		<?php endwhile; ?><?php
	}

	if(isset($_POST['GET-LAST-PROJET-COMENT'])){
		
		?><?php
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
		<?php
	}
	if(isset($_POST['GET-PROJET-COMENTS'])){
		
		?><?php $qry = "
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
		<?php endwhile; ?><?php
	}

	if(isset($_POST['GET-LAST-JOB-COMENT'])){
	
		?><?php
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
					  tc.id_tarefa =  '{$_POST["id_tarefa"]}'
					ORDER BY tc.data DESC LIMIT 1
				;";
				$resultado  = mysql_query($qry, $conexao);
				$coment 	= mysql_fetch_array($resultado);
				?>

			<header><h4><?php echo $coment["nome"]; ?></h4></header>
			<img src="<?php echo $uploadUrl.$coment["foto"]; ?>" alt="#" style="float: right">
			<p class="data"><?php echo $coment["conteudo"]; ?></p>
			<strong><?php echo $coment["data"]; ?></strong>
		<?php
	}
	if(isset($_POST['GET-JOB-COMENTS'])){
	
		?><?php $qry = "
			SELECT
			  	m.nome,
			  	m.foto,
			  	tc.data,
			  	tc.conteudo
			FROM
				ginga3_tarefas_comentarios tc
				INNER JOIN ginga3_membros m ON tc.id_membro = m.id
			WHERE
			  	tc.id_tarefa = '{$_POST["id_tarefa"]}'
			ORDER BY tc.data DESC
		;"; $ls  = mysql_query($qry, $conexao); ?>
		<?php while($coments = mysql_fetch_array($ls)): ?>
			<li>
				<header><h4><?php echo $coments["nome"]; ?></h4></header>
				<img src="<?php echo $uploadUrl.$coments["foto"]; ?>" alt="#">
				<p><?php echo $coments["conteudo"]; ?></p>
				<strong><?php echo $coments["data"]; ?></strong>
			</li>					 	
		<?php endwhile; ?><?php
	}	

	if(isset($_POST['GET-ALL'])){
?>
	<?php echo $msm; ?>

	<header>
		<h3 class="text-color1"><?php echo $projeto_atual->nome; ?></h3>
		<nav id="nav-menu-01" class="box-padrao color2">
			<ul class="text-color1">
				<li><input class="bt-am color1" type="button" ></li>
				<li><input id="mb-conf" class="bt-config color1	" type="button" ></li>
				<li><a class="text-color1" href="#" id="sair">Sair</a></li>
				<li><a class="text-color1" href="home.php">Retornar</a></li>
				<li><a class="text-color1" href="#" id="manter-gerentes">Gerentes</a></li>
				<li><a class="text-color1" href="#" id="add-membros">Adicinar Membros</a></li>
				<li><a class="text-color1" href="#" id="manter-cargos">Cargos</a></li>
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
	
	<section class="in-center">

		<article class="wspan4 toLeft hspan12">
			<div class="ls-projets">
				<header class="color1">
					<h2>Projetos</h2>
				</header>
			
				<select class="sel-1 .the-border-color1 box-color1 color3" id="select-projet">
					<?php $qry = "SELECT * FROM ginga3_projetos;"; $ls  = mysql_query($qry, $conexao); ?>
					<?php while($projeto = mysql_fetch_array($ls)): ?>
					 	<option value="<?php echo $projeto["id"];?>" <?php echo $projeto["id"] == $projeto_atual->id ? "selected" : ""; ?>><?php echo $projeto["nome"]; ?></option>
					<?php endwhile; ?>
				</select>

				<div class="tre-buttons color1">
					<input class="bt-view" type="button" id="the-pjt">
					<input class="bt-ed"   type="button" id="edt-pjt">
					<input class="bt-add"  type="button" id="new-pjt">
					<input class="bt-rem"  type="button" id="rem-pjt">
				</div>
			</div>
		</article>

		<article class="wspan4 toLeft hspan12">
			<div class="color3 ls-2 tarefa ls-descktop box-color1">
				<input class="bt-add color1" type="button" id="add-new-tarefa">
				<header class="text-color1">
					<h2>Terefas</h2>
				</header>	
				<ul id="ls-tarefas-projeto">
					<?php $qry = "SELECT * FROM ginga3_tarefas WHERE id_projeto = '{$projeto_atual->id}'"; $ls  = mysql_query($qry, $conexao); ?>
					<?php while($tarefa = mysql_fetch_array($ls)): ?>
					 	<li tfId="<?php echo $tarefa["id"]; ?>" class="ls-2-li tarefa-li color3 the-border-color1">
							
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
									<input tfId="<?php echo $tarefa["id"]; ?>" type="button" class="bt-ed"  	onclick="EditTarefas(this);">
									<input tfId="<?php echo $tarefa["id"]; ?>" type="button" class="bt-rem" 	onclick="RemoveTarefas(this);">
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
								 			case '1': echo "<span style='color: red'>criada</span>"; break;
								 			case '2': echo "<span style='color: darkgoldenrod'>sendo feita</span>"; break;
								 			case '3': echo "<span style='color: green'>conclu&iacute;da</span>"; break;
								 			default : echo "<span style='color: red'>criada</span>"; break;
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

										<a class="act more .the-border-color1 color" href="#" onclick="ViewAllComentsTarefa(this);">Ver Todos</a> 

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

		<article class="wspan4 toLeft hspan12">
			<div class="ls-3 ls-descktop the-box-color color3">
				<input class="bt-add color1" id="projeto-membro" type="button" >
				<header class="text-color1">
					<h2>Membros</h2>
				</header>
				
				<ul class="ls-membros-in-prjeto">
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
						<img src="default.png" alt="#" style="background-color: red">
					</a></li>

					<li><a class="act" href="#"><header><h4>Natã Concluiu uma nove tarefa</h4></header><p class="data">Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1Item1</p><img src="default.png" alt="#"></a></li>
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

	<div id="the-projet" class="hidden">
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

	<div id="edit-projetos" class="hidden">

		<div id="view-projet">
			<input type="hidden" id="the-id-project" value="<?php echo $projeto_atual->id; ?>">
			<h4>Nome:</h4>
			<input type="text" size="30" name="pj_nome" value="<?php echo $projeto_atual->nome; ?>">
			<h4>Descri&ccedil;&atilde;o:</h4>
			
			<article class="desc">
				<textarea rows="5" name="pj_desc"><?php echo $projeto_atual->descricao; ?></textarea>
			</article>

			<div class="ed-img">
			    <p>Imagem para progeto:</p>
			    <a href="#"><img id="the-img-projet" class="color1" src="<?php echo $uploadUrl.$projeto_atual->img; ?>" height="240px" width="320px"></a>
			    <label>
			        <input type="file" name="pj_img" onchange="readIMG(this);"/>
			        <input type="button" class="bt color1" value="Abrir">
			    </label>
			</div>
		</div>
	</div>

	<div id="edit-tarefas" class="hidden">
		<div class="view-tarefa">

			<h4>Nome</h4>
			<input type="text" size="30" name="tf_nome">
			<h4>Descri&ccedil;&atilde;o</h4>
			<article class="desc">
		    	<textarea rows="5" name="tf_desc"></textarea>
		  	</article>
			<div class="edt">
				<h4>Membros nesta Tarefa</h4>
	  			<article>
		  			<div class="ls-3 the-members">
						<ul class="drag" id="ls-ed-membros-tarefa"></ul>
						<input class="bt-add color1" type="button" onclick="addInTarefa(this);">
					</div>	
				</article>
				
				<div id="not-in-tarefa" class="hidden">
					<div class="ls-3 the-members">
						<ul class="drag" id="ls-ed-not-membros-tarefa"></ul>
					</div>
				</div>

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
			                    <input type="file" onchange="readFILE(this);" name="the_arq">
		                    	<p>VAZIO</p>
		                    	<input class="bt-add color1" type="button">
		                    	<input type="hidden" name="id_tarefa" value="<?php echo $tarefa["id"]; ?>">
			                </label>
			                <input type="submit" value="Enviar" name="add-arquivo" class="bt color1" style="float: right; margin-left: 15px;">
		                </div>
		                </form>
					</footer>
			  	</article>  
		  	</div>	
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
									<p>Nome: <span class="the-name"><?php echo $membro["nome"]."<-"; ?></span></p>
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

	<div class="gerentes-membros hidden">
		
		<article class="toLeft wspan5 offwspan1_2">
			<h4>Gerentes</h4>
			<div class="ls-3 the-members the-border">
				<ul class="hspan12 drag ls-new-gens">
					<?php $qry = "SELECT * FROM ginga3_membros WHERE st = 3;"; $ls  = mysql_query($qry, $conexao); ?>
					<?php while($membro = mysql_fetch_array($ls)): ?>
						<li class="ls-3-li act"><a mbId="<?php echo $membro["id"]; ?>" href="#" onclick="ViewAllMembers(this);">
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
										<p>Membro desde: <?php echo $membro["data"]; ?></p>
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
			<h4>N&atildeo Gerentes</h4>
				<div class="ls-3 the-members the-border">
				<ul class="hspan12 drag" >
					<?php $qry = "SELECT * FROM ginga3_membros WHERE st = 1;"; $ls  = mysql_query($qry, $conexao); ?>
					<?php while($membro = mysql_fetch_array($ls)): ?>
						<li class="ls-3-li act"><a mbId="<?php echo $membro["id"]; ?>" href="#" onclick="ViewAllMembers(this);">
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
										<p>Membro desde: <?php echo $membro["data"]; ?></p>
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
		<input type="hidden" id="the-my-id" value="<?php echo $membro_atual->id; ?>">
		<input type="hidden" id="the-my-foto" value="<?php echo $uploadUrl.$membro_atual->foto; ?>">
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

	<div id="view-new-membros" class="hidden">
		<div class="ls-2 wspan12">
			<ul class="ls-new-members">
				<?php $qry = "SELECT * FROM ginga3_membros WHERE st = 0;"; $ls  = mysql_query($qry, $conexao); ?>
				<?php while($membro = mysql_fetch_array($ls)): ?>
					<li>
						<input type="checkbox" name="check" value="<?php echo $membro["id"]; ?>" class="toLeft">
						<a class="act" href="#" onclick="ViewAllMembers(this);">
							<p><?php echo $membro["apelido"]; ?></p>
							<img style="background-color: <?php echo $membro["cor"]; ?>;" src="<?php echo $uploadUrl.$membro["foto"]; ?>" alt="#">
							<div id="the-member" class="hidden" color="<?php echo $membro["cor"]; ?>">
								<div id="view-the-member">
									<header>
										<img src="<?php echo $uploadUrl.$membro["foto"]; ?>" height="144px" width="108px">
									</header>
										
									<section>
										<p>Nome: <span class="the-name"><?php echo $membro["nome"]; ?></span></p>
										<p>Manifesto:</p>
										<p class="manifest color">"<?php echo $membro["manifesto"]; ?>"</p>
										<p>Gargo: Programador</p>
										<p>Membro desde: <?php echo $membro["data"]; ?></p>
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
						</a>
					</li>
				<?php endwhile; ?>
			</ul>
		</div>
	</div>

	<div id="mt-cargos" class="hidden">

		<h4>Nome:</h4>
		
			<p class="error" style="width: 100%; display: block"></p>
			<input type="text" class="toLeft" size="30" name="cargo-nome">
			<input class="bt toLeft color1" type="button" value="Criar" onclick="NovoCargo(this);">
		<br>
		<div class="ls-1 wspan12" style="margin-top: 10px;">
			<ul class="ls-cargos">
				<?php $qry = "SELECT * FROM ginga3_cargos;"; $ls  = mysql_query($qry, $conexao); ?>
				<?php while($cargo = mysql_fetch_array($ls)): ?>
					<li>
						<a class="act" href="#"><?php echo $cargo["nome"]; ?></a>
						<input cgID="<?php echo $cargo["id"]; ?>" class="bt-rem act color1" type="button" onclick="DeleteCargo(this);">
					</li>
				<?php endwhile; ?>
			</ul>
		</div>
	</div>

	<footer class="box-padrao ft color2 text-color">
		<p>Ginga 3.0</p>
	</footer>
<?php
	}

	if(isset($_POST['JSON'])){
			
		$my = array(
			'nome'=>"nata",
			'id'=>"28"
		);
		$myJSON = json_encode($my);

		echo($myJSON);
	}

	if(isset($_POST['send-msm'])){
		$erros = 0;
		if(isset($_POST["membros_email"])) 
		{
			for($i = 0; $i < count($_POST["membros_email"]); $i++) 
			{
				if($controle_db->Membros->GetByWhere("email = '{$_POST["membros_email"][$i]}'")){
					$the_membro = $controle_db->Membros->GetByWhere("email = '{$_POST["membros_email"][$i]}'");
					$controle_db->Membros->SendMsM($membro_atual->id, $the_membro->id , $_POST["titulo"], $_POST["conteudo"]); 
				}
				else
					$erros++;
			}
		}

		if($erros > 0)
			echo 0;
		else
			echo 1;
	}

	if(isset($_POST['ok-msm'])){

		$qry = "
			UPDATE ginga3_mensagens SET
				st = 2
			WHERE
				id = '{$_POST["id"]}';
		";
		
		mysql_query($qry, $conexao);
	}

	if(isset($_POST['chat-send'])){
		$membro_atual->SendChat( $conexao, $_POST['id_membro'], $_POST['conteudo'] );
	}

	if(isset($_POST['chat-reload'])){	

		$lista = "";
		$count = "";

		if(! $membro_atual->ExistNewChat( $conexao, $_POST["id_membro"] ) )	
			echo 0;
		else {
				?><?php $qry = "
					SELECT DISTINCT
					  m1.cor as mb1_cor,
					  m2.cor as mb2_cor,
					  m1.foto as mb1_foto,
					  m2.foto as mb2_foto,
					  c.conteudo,
					  c.data,
					  c.id,
					  c.id_mb1,
					  c.id_mb2,
					  c.dono
					FROM ginga3_chat c
					  INNER JOIN ginga3_membros m1 ON c.id_mb1 = m1.id
					  INNER JOIN ginga3_membros m2 ON c.id_mb2 = m2.id
					WHERE 
						(c.id_mb1 = '{$membro_atual->id}' AND c.id_mb2 = '{$_POST['id_membro']}') OR
						(c.id_mb2 = '{$membro_atual->id}' AND c.id_mb1 = '{$_POST['id_membro']}')
					ORDER BY c.data
				;"; 
				$ls  = mysql_query($qry, $conexao); if(mysql_num_rows($ls) > 0): ; ?>
				<?php while($chat = mysql_fetch_array($ls)): ?>

					<?php
						if($membro_atual->id != $chat["dono"])
							$controle_db->Membros->ChatSetSt(1, $chat["id"]);
					?>

						<!--ATUAL-->
					<?php if ($chat["dono"] == $membro_atual->id): ?>
						<?php if ($chat["dono"] == $chat["id_mb1"]): ?>
							<li class='li_owner the-border'><a href='#'><img class='mb_img' src='<?php echo $uploadUrl.$chat["mb1_foto"]; ?>'></a><?php echo $chat["conteudo"]; ?></li>
						<?php else :?>
							<li class='li_owner the-border'><a href='#'><img class='mb_img' src='<?php echo $uploadUrl.$chat["mb2_foto"]; ?>'></a><?php echo $chat["conteudo"]; ?></li>
						<?php endif; ?>
					<?php else :?>
						<?php if ($chat["dono"] == $chat["id_mb1"]): ?>
							<li class='li_mb' style="background-color: <?php echo $chat["mb1_cor"]; ?>;"><a href='#'><img class='mb_img' src='<?php echo $uploadUrl.$chat["mb1_foto"]; ?>'></a><?php echo $chat["conteudo"]; ?></li>
						<?php else :?>
							<li class='li_mb' style="background-color: <?php echo $chat["mb2_cor"]; ?>;"><a href='#'><img class='mb_img' src='<?php echo $uploadUrl.$chat["mb2_foto"]; ?>'></a><?php echo $chat["conteudo"]; ?></li>
						<?php endif; ?>
						<!--NAO ATUAL-->
					<?php endif; ?>
				<?php endwhile; else : echo 0; endif; ?><?php
		};
	}

	if(isset($_POST['chat-get-initial'])){	

		?><?php $qry = "
			SELECT DISTINCT
			  m1.cor as mb1_cor,
			  m2.cor as mb2_cor,
			  m1.foto as mb1_foto,
			  m2.foto as mb2_foto,
			  c.conteudo,
			  c.data,
			  c.id,
			  c.id_mb1,
			  c.id_mb2,
			  c.dono
			FROM ginga3_chat c
			  INNER JOIN ginga3_membros m1 ON c.id_mb1 = m1.id
			  INNER JOIN ginga3_membros m2 ON c.id_mb2 = m2.id
			WHERE 
				(c.id_mb1 = '{$membro_atual->id}' AND c.id_mb2 = '{$_POST['id_membro']}') OR
				(c.id_mb2 = '{$membro_atual->id}' AND c.id_mb1 = '{$_POST['id_membro']}')
			ORDER BY c.data
		;"; 
		$ls  = mysql_query($qry, $conexao); if(mysql_num_rows($ls) > 0): ; ?>
		<?php while($chat = mysql_fetch_array($ls)): ?>

			<?php
				if($membro_atual->id != $chat["dono"])
					$controle_db->Membros->ChatSetSt(1, $chat["id"]);
			?>

				<!--ATUAL-->
			<?php if ($chat["dono"] == $membro_atual->id): ?>
				<?php if ($chat["dono"] == $chat["id_mb1"]): ?>
					<li class='li_owner the-border'><a href='#'><img class='mb_img' src='<?php echo $uploadUrl.$chat["mb1_foto"]; ?>'></a><?php echo $chat["conteudo"]; ?></li>
				<?php else :?>
					<li class='li_owner the-border'><a href='#'><img class='mb_img' src='<?php echo $uploadUrl.$chat["mb2_foto"]; ?>'></a><?php echo $chat["conteudo"]; ?></li>
				<?php endif; ?>
			<?php else :?>
				<?php if ($chat["dono"] == $chat["id_mb1"]): ?>
					<li class='li_mb' style="background-color: <?php echo $chat["mb1_cor"]; ?>;"><a href='#'><img class='mb_img' src='<?php echo $uploadUrl.$chat["mb1_foto"]; ?>'></a><?php echo $chat["conteudo"]; ?></li>
				<?php else :?>
					<li class='li_mb' style="background-color: <?php echo $chat["mb2_cor"]; ?>;"><a href='#'><img class='mb_img' src='<?php echo $uploadUrl.$chat["mb2_foto"]; ?>'></a><?php echo $chat["conteudo"]; ?></li>
				<?php endif; ?>
				<!--NAO ATUAL-->
			<?php endif; ?>
		<?php endwhile; else : echo 0; endif; ?><?php
	}

	if(isset($_POST['coment-projet'])){

		if($controle_db->Membros->ComentarProjeto($membro_atual->id, $projeto_atual->id, $_POST["conteudo"])){
			echo $_POST["conteudo"]."-!";
		} else {
			echo $_POST["conteudo"];
		}
	}		
	if(isset($_POST['coment-job'])){

		if($controle_db->Membros->ComentarTarefa($membro_atual->id, $_POST["id_tarefa"], $_POST["conteudo"])){
			echo $_POST["conteudo"];
		} else {
			echo 0;
		}
	}	

	if(isset($_POST['add-new-membros'])){
		
		if(isset($_POST["membros_id"])) 
		{
			for($i = 0; $i < count($_POST["membros_id"]); $i++) 
			{
				$controle_db->Membros->SetSt( 1 , $_POST["membros_id"][$i]);
			}
		}

		?><?php $qry = "SELECT * FROM ginga3_membros WHERE st = 0;"; $ls  = mysql_query($qry, $conexao); while($membro = mysql_fetch_array($ls)): ?>
			<li>
				<input type="checkbox" name="check" value="<?php echo $membro["id"]; ?>" class="toLeft">
				<a class="act" href="#" onclick="ViewAllMembers(this);">
					<p><?php echo $membro["apelido"]; ?></p>
					<img style="background-color: <?php echo $membro["cor"]; ?>;" src="<?php echo $uploadUrl.$membro["foto"]; ?>" alt="#">
					<div id="the-member" class="hidden" color="<?php echo $membro["cor"]; ?>">
						<div id="view-the-member">
							<header>
								<img src="<?php echo $uploadUrl.$membro["foto"]; ?>" height="144px" width="108px">
							</header>
								
							<section>
								<p>Nome: <span class="the-name"><?php echo $membro["nome"]; ?></span></p>
								<p>Manifesto:</p>
								<p class="manifest color">"<?php echo $membro["manifesto"]; ?>"</p>
								<p>Gargo: Programador</p>
								<p>Membro de desde: <?php echo $membro["data"]; ?></p>
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
				</a>
			</li>
		<?php endwhile; ?><?php
	}
	if(isset($_POST['add-gens'])){
		
		$controle_db->Membros->ClearGens();

		if(isset($_POST["membros_id"])) 
		{
			for($i = 0; $i < count($_POST["membros_id"]); $i++) 
			{
				$controle_db->Membros->SetSt( 3 , $_POST["membros_id"][$i]);
			}
		}

		?><article class="toLeft wspan5 offwspan1_2">
			<h4>Gerentes</h4>
			<div class="ls-3 the-members the-border">
				<ul class="hspan12 drag ls-new-gens">
					<?php $qry = "SELECT * FROM ginga3_membros WHERE st = 3;"; $ls  = mysql_query($qry, $conexao); ?>
					<?php while($membro = mysql_fetch_array($ls)): ?>
						<li class="ls-3-li act"><a mbId="<?php echo $membro["id"]; ?>" href="#" onclick="ViewAllMembers(this);">
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
										<p>Membro desde: <?php echo $membro["data"]; ?></p>
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
			<h4>N&atildeo Gerentes</h4>
				<div class="ls-3 the-members the-border">
				<ul class="hspan12 drag" >
					<?php $qry = "SELECT * FROM ginga3_membros WHERE st = 1;"; $ls  = mysql_query($qry, $conexao); ?>
					<?php while($membro = mysql_fetch_array($ls)): ?>
						<li class="ls-3-li act"><a mbId="<?php echo $membro["id"]; ?>" href="#" onclick="ViewAllMembers(this);">
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
										<p>Membro desde: <?php echo $membro["data"]; ?></p>
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
		</article><?php
	}
	if(isset($_POST['add-membros-projeto'])){
		
		$controle_db->Projetos->ClearMembros($_POST["id_projeto"]);
		
		if(isset($_POST["membros_id"])) 
		{
			for($i = 0; $i < count($_POST["membros_id"]); $i++) 
			{
				$controle_db->Membros->SetMembroProjeto($_POST["membros_id"][$i], $_POST["id_projeto"]);
			}
		}

		?><article class="toLeft wspan5 offwspan1_2">
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
							mp.id_projeto='{$_POST["id_projeto"]}';
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
				<ul class="hspan12 drag" >
					<?php 
						$qry = "
							SELECT 
								mp.id_projeto, 
								m . *
							FROM 
								ginga3_membros m
							LEFT JOIN ginga3_membros_projetos mp ON m.id = mp.id_membro
							WHERE
								(mp.id_projeto IS NULL OR
								mp.id_projeto !='{$_POST["id_projeto"]}') AND
								m.id NOT IN( SELECT id_membro FROM ginga3_membros_projetos WHERE id_projeto ='{$_POST["id_projeto"]}' );
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
		</article><?php
	}
	if(isset($_POST['add-membros-tarefa'])){
		
		$controle_db->Tarefas->ClearMembros($_POST["id_tarefa"]);
		
		if(isset($_POST["membros_id"])) 
		{
			for($i = 0; $i < count($_POST["membros_id"]); $i++) 
			{
				$controle_db->Membros->SetMembroTarefa($_POST["membros_id"][$i], $_POST["id_tarefa"]);
			}
		}

		ListarTarefas($projeto_atual, $conexao, $uploadUrl);
	}

    if(isset($_POST['new-membro'])){

    	$novo_membro = new Membro();
    	$novo_membro->nome    	= converte_html($_POST["mb_nome"]);
    	$msm =  $novo_membro->nome;
    	$msm =  converte_html($_POST["mb_nome"]."");

    	$novo_membro->apelido 	= $_POST["mb_alias"];
    	$novo_membro->email   	= $_POST["mb_email"];
    	$novo_membro->senha   	= $_POST["mb_senha"];
    	$novo_membro->cor     	= $_POST["mb_cor"];
    	$novo_membro->manifesto = $_POST["mb_manifesto"];
    	$novo_membro->id_cargo  = $_POST["mb_cargo"];
    	$novo_membro->foto      = "default.png";

    	if($controle_db->VerificaRegistro("email", $_POST["mb_email"], "ginga3_membros") == 0){

	       	if (!empty($_FILES['mb_img'])) {

	            $extensao = '.' . pathinfo($_FILES['mb_img']['name'], PATHINFO_EXTENSION);

	            do {
	                $filename = md5(microtime() . $_FILES['mb_img']['name']) . $extensao;
	            } while (file_exists($filename));

	       		if(move_uploaded_file($_FILES['mb_img']['tmp_name'], $uploadDir . $filename))
	       			$novo_membro->foto = $filename;
	       	}

	       	if($novo_membro->Inserir($conexao)){
	       		echo 1;
	       	} else {
	    		echo "Ocorreu um erro!, tente novamente mais tarde.";
	       	}
	    }else{
	    	echo "Este E-mail j&aacute; foi utilizado.";
	    }
    }

    if(isset($_POST['at-tarefa'])){

    	if($controle_db->Tarefas->SetSt($_POST['st-tarefa'], $_POST['id-tarefa'])){
    		echo "<div class='state{$_POST['st-tarefa']}'></div>";
    	} else {
    		echo 0;
    	}
    }

	if(isset($_POST['update-tarefa'])){

		$tarefa = new Tarefa();
		$tarefa->Get($conexao, $_POST['_id']);

		$tarefa->nome = $_POST['tf_nome'];
		$tarefa->descricao = $_POST['tf_desc'];


		if($tarefa->Alterar($conexao)){
			ListarTarefas($projeto_atual, $conexao, $uploadUrl);
		}else{
			ListarTarefas($projeto_atual, $conexao, $uploadUrl);
		}
	}
	if(isset($_POST['del-tarefa'])){
		
		$the_tarefa = new Tarefa();
		$the_tarefa->Get($conexao, $_POST['_id']);
		
		if ( $the_tarefa->Excluir($conexao) == 1 ) {
			ListarTarefas($projeto_atual, $conexao, $uploadUrl);
		}else{
			echo 0;
		}
	}

	if(isset($_POST['del-projeto'])){
		
		if ( $projeto_atual->Excluir($conexao) ) {

			$qry = "SELECT id FROM ginga3_projetos LIMIT 1 ;";

			$resultado  = mysql_query($qry, $conexao);
			$linha = mysql_fetch_array($resultado);					
			$_SESSION["id_projeto"] =  $linha["id"];
			?>
				<?php $qry = "SELECT * FROM ginga3_projetos;"; $ls  = mysql_query($qry, $conexao); ?>
				<?php while($projeto = mysql_fetch_array($ls)): ?>
				<option value="<?php echo $projeto["id"];?>" <?php echo $projeto["id"] == $linha["id"] ? "selected" : ""; ?>><?php echo $projeto["nome"]; ?></option>
				<?php endwhile; ?>
			<?php
		}else{
			echo 0;
		}
	}

	if(isset($_POST['del-arquivo'])){
		
		$qry = "DELETE FROM ginga3_tarefas_arquivos WHERE id = '{$_POST['arq_id']}';";
		mysql_query($qry, $conexao);	

		?><?php $qry = "
		SELECT
		  *
		FROM
		  ginga3_tarefas_arquivos
		WHERE
		  id_tarefa = '{$_POST["tf_id"]}';
		"; 
		$ls2  = mysql_query($qry, $conexao); ?>

		<?php while($arq = mysql_fetch_array($ls2)): ?>
			<li><a class="act" href="<?php echo $uploadUrl.$arq["local"]; ?>"><?php echo $arq["nome"];?></a> <input ArqId="<?php echo $arq["id"]; ?>" TfId="<?php echo $_POST["tf_id"]; ?>" class="bt-rem act color" type="button" onclick="DeleteAnexo(this);"></li>
		<?php endwhile; ?><?php
	}

	if(isset($_POST['new-cargo'])){
		
		$novo_cargo       = new Cargo();
		$novo_cargo->nome = $_POST['cg_nome'];

		if($controle_db->VerificaRegistro("nome", $_POST["cg_nome"], "ginga3_cargos") == 0){

			?><?php if ( $novo_cargo->Inserir($conexao) ) : $qry = "SELECT * FROM ginga3_cargos;"; $ls  = mysql_query($qry, $conexao); while($cargo = mysql_fetch_array($ls)): ?>
				<li>
					<a class="act" href="#"><?php echo $cargo["nome"]; ?></a>
					<input cgID="<?php echo $cargo["id"]; ?>" class="bt-rem act color" type="button" onclick="DeleteCargo(this);">
				</li>
			<?php endwhile; endif;?><?php
		} else {
			echo 0;
		}
	}
	if(isset($_POST['del-cargo'])){
		
		$the_cargo = new Cargo();
		$the_cargo->Get($conexao, $_POST['_id']);
		
		if ( $the_cargo->Excluir($conexao) == 1 ) {
			?><?php  $qry = "SELECT * FROM ginga3_cargos;"; $ls  = mysql_query($qry, $conexao); while($cargo = mysql_fetch_array($ls)): ?>
				<li>
					<a class="act" href="#"><?php echo $cargo["nome"]; ?></a>
					<input cgID="<?php echo $cargo["id"]; ?>" class="bt-rem act color" type="button" onclick="DeleteCargo(this);">
				</li>
			<?php endwhile; ?><?php
		}else{
			echo 0;
		}
	}

	if(isset($_POST['del-nave'])){
		echo $controle_db->Nave->Excluir($_POST['_id']);
	}

	if(isset($_POST['del-arena'])){
		echo $controle_db->Arena->Excluir($_POST['_id']);
	}

	if(isset($_POST['racas_naves'])){
		$erros = 0;
		$controle_racas_naves = new Racas_Naves($conexao);
		$controle_racas_naves->Clear($_POST['id_raca']);

		if(isset($_POST["naves_id"])) 
		{
			for($i = 0; $i < count($_POST["naves_id"]); $i++) 
			{
				$controle_racas_naves->Mesclar($_POST['id_raca'], $_POST["naves_id"][$i]);
			}
		}

		echo 1;
	}

	if(isset($_POST['init-partida'])){

		$controle_partida = new Partida($conexao);

		if( $controle_partida->CriarPartida($_POST["jogador"], $_POST["rn_id"]) == 0){
				
			$controle_partida->EntrarPartida($_POST["jogador"], $_POST["rn_id"]);
			echo 0;
		}
		else
			echo 1;
	}

	if(isset($_POST['set-arena'])){

		$controle_partida = new Partida($conexao);

		if( $controle_partida->SetArena($_POST["id_arena"]) )
			echo 1;
		else
			echo 0;
	}

	if(isset($_POST['at'])){
		
		$controle_partida = new Partida($conexao);
		$controle_partida->GetPatida();
		
		$jogador_01 = new Jogador($conexao, $controle_partida->jogador_01 ,$controle_partida->id_raca_nave_j01);
		$jogador_02 = new Jogador($conexao, $controle_partida->jogador_02 ,$controle_partida->id_raca_nave_j02);
		$jogador_03 = new Jogador($conexao, $controle_partida->jogador_03 ,$controle_partida->id_raca_nave_j03);
		$jogador_04 = new Jogador($conexao, $controle_partida->jogador_04 ,$controle_partida->id_raca_nave_j04);
		
		if($_POST['jogador'] == "jogador_01")
		{
			if($controle_partida->jogador_01 != null){
				echo ' <div class="jog" style= "opacity: 0;"><h3 style="border-radius: 42px 0px 0px  0px;" >'.$jogador_01->nome.'</h3>
				<h2>'.$jogador_01->Raca->nome.'</h2>
				<img src="'.$uploadUrl.$jogador_01->Raca->logo.'" height="100px" style="margin: auto;display: block">
				<p>Niveis</p>
				<img src="'.$uploadUrl.$jogador_01->Raca->img_descricao.'" height="138px" style="margin: auto;display: block">
				<p>Nave</p>
				<img src="'.$uploadUrl.$jogador_01->Nave->imagem.'" width="70%" style="margin: auto;display: block"></div>';
			}
			else
				echo 0;			
		}
		if($_POST['jogador'] == "jogador_02")
		{
			if($controle_partida->jogador_02 != null){
				echo ' <div class="jog" style= "opacity: 0;"><h3>'.$jogador_02->nome.'</h3>
				<h2>'.$jogador_02->Raca->nome.'</h2>
				<img src="'.$uploadUrl.$jogador_02->Raca->logo.'" height="100px" style="margin: auto;display: block">
				<p>Niveis</p>
				<img src="'.$uploadUrl.$jogador_02->Raca->img_descricao.'" height="138px" style="margin: auto;display: block">
				<p>Nave</p>
				<img src="'.$uploadUrl.$jogador_02->Nave->imagem.'" width="70%" style="margin: auto;display: block"></div>';
			}
			else
				echo 0;						
		}
		if($_POST['jogador'] == "jogador_03")
		{
			if($controle_partida->jogador_03 != null){
				echo ' <div class="jog" style= "opacity: 0;"><h3>'.$jogador_03->nome.'</h3>
				<h2>'.$jogador_03->Raca->nome.'</h2>
				<img src="'.$uploadUrl.$jogador_03->Raca->logo.'" height="100px" style="margin: auto;display: block">
				<p>Niveis</p>
				<img src="'.$uploadUrl.$jogador_03->Raca->img_descricao.'" height="138px" style="margin: auto;display: block">
				<p>Nave</p>
				<img src="'.$uploadUrl.$jogador_03->Nave->imagem.'" width="70%" style="margin: auto;display: block"></div>';
			}
			else
				echo 0;			
		}
		if($_POST['jogador'] == "jogador_04")
		{
			if($controle_partida->jogador_04 != null){
				echo ' <div class="jog" style= "opacity: 0;"><h3 style="border-radius: 0px 42px 0px  0px;" >'.$jogador_04->nome.'</h3>
				<h2>'.$jogador_04->Raca->nome.'</h2>
				<img src="'.$uploadUrl.$jogador_04->Raca->logo.'" height="100px" style="margin: auto;display: block">
				<p>Niveis</p>
				<img src="'.$uploadUrl.$jogador_04->Raca->img_descricao.'" height="138px" style="margin: auto;display: block">
				<p>Nave</p>
				<img src="'.$uploadUrl.$jogador_04->Nave->imagem.'" width="70%" style="margin: auto;display: block"></div>';
			}
			else
				echo 0;
			
		}
	}

	if(isset($_POST['end-play'])){

		$controle_partida = new Partida($conexao);
	
		if( $controle_partida->EndPartida($_POST["pontos_j01"], $_POST["pontos_j02"], $_POST["pontos_j03"], $_POST["pontos_j04"]) )
			echo 1;
		else
			echo 0;	
	}
	
?>
