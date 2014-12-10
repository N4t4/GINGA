<?php
/*---------------------------------------------
Criado por   Natã                19/10/2012 -
revisado por Natã                23/10/2012 -   
---------------------------------------------*/
	include("includes/Myfunctions.php"); 
	
	class Cargo
	{	
		public $id;
		public $nome;
		
		public function __construct()
		{
			$this->id         = null;
			$this->nome       = null;
		}
			
		public function CarregarLinha($linha)
		{
			$this->id         = $linha["id"];
			$this->nome       = $linha["nome"];
		} 
	
		public function Inserir($conexao)
		{
			$controle_db = new ControleDB($conexao);
			return $controle_db->Cargos->Inserir($this);
		}
	
		public function Alterar($conexao)
		{
			$controle_db = new ControleDB($conexao);
			return $controle_db->Cargos->Atualizar($this);
		}
		
		public function Excluir($conexao)
		{
			$controle_db = new ControleDB($conexao);
			return $controle_db->Cargos->Excluir($this->id);
		}

		public function Get($conexao, $_id)
		{
			$controle_db = new ControleDB($conexao);
			$the_cargo  = $controle_db->Cargos->GetById($_id);	
			
			$this->id   = $the_cargo->id;         
			$this->nome = $the_cargo->nome;
		}
	}	
	class Membro
	{
		public $id;
		public $nome;
		public $apelido;
		public $email;
		public $senha;
		public $cor;
		public $cor2;
		public $cor3;
		public $foto;
		public $manifesto;
		public $data;
		public $id_cargo;
		public $st;
		public $chat_st;

		public function __construct()
		{
			$this->id        = null;
			$this->nome      = null;
			$this->apelido   = null;
			$this->email     = null;
			$this->senha     = null;
			$this->cor       = null;
			$this->cor2      = null;
			$this->cor3      = null;
			$this->foto      = null;
			$this->manifesto = null;
			$this->data      = null;
			$this->id_cargo  = null;
			$this->st        = null;
			$this->chat_st   = null;
		}
			
		public function CarregarLinha($linha)
		{
			$this->id        = $linha["id"];
			$this->nome      = $linha["nome"];
			$this->apelido   = $linha["apelido"];
			$this->email     = $linha["email"];
			$this->senha     = $linha["senha"];
			$this->cor       = $linha["cor"];
			$this->cor2      = $linha["cor2"];
			$this->cor3      = $linha["cor3"];
			$this->foto      = $linha["foto"];
			$this->manifesto = $linha["manifesto"];
			$this->data      = $linha["data"];
			$this->id_cargo  = $linha["id_cargo"];
			$this->st        = $linha["st"];
			$this->chat_st   = $linha["st"];
		} 
	
		public function Inserir($conexao)
		{
			$controle_db = new ControleDB($conexao);
			return $controle_db->Membros->Inserir($this);
		}
	
		public function Alterar($conexao)
		{
			$controle_db = new ControleDB($conexao);
			return $controle_db->Membros->Atualizar($this);
		}
		
		public function Excluir($conexao)
		{
			$controle_db = new ControleDB($conexao);
			$controle_db->Membros->Excluir($this->id);
		}

		public function IsGerente($conexao)
		{
			$qry = "
				SELECT
					id
				FROM
					ginga3_membros
				WHERE
					id = {$this->id} AND
					st = 3
			;";

			$resultado = mysql_query($qry, $conexao);
			$numLinhas = mysql_num_rows($resultado);

			return $numLinhas == 1;
		}

		public function ChatIn($conexao)
		{
			$qry = "
				UPDATE ginga3_membros SET
					chat_st = '1'
				WHERE
					id = '{$this->id}';
			";
			mysql_query($qry, $conexao);
			if( mysql_affected_rows() == 1 )
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		public function ChatOut($conexao)
		{
			$qry = "
				UPDATE ginga3_membros SET
					chat_st = '0'
				WHERE
					id = '{$this->id}';
			";
			
			mysql_query($qry, $conexao);
			if( mysql_affected_rows() == 1 )
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		public function SendChat($conexao, $id_membro, $conteudo)
		{

			$id_mb1 = 0;
			$id_mb2 = 0;

			$qry = "
				SELECT
					COUNT( 1 ) AS qtd
				FROM ginga3_chat
				WHERE id_mb1 = '{$this->id}' AND id_mb2 = '{$id_membro}'
			;";

			$resultado  = mysql_query($qry, $conexao);
			$row 		= mysql_fetch_array($resultado);					
			
			if ($row["qtd"] == 0){
				$id_mb1 = $id_membro;
				$id_mb2 = $this->id;
			} else {
				$id_mb2 = $id_membro;
				$id_mb1 = $this->id;
			}

			$qry = "
				INSERT INTO ginga3_chat(
					conteudo,
					id_mb1,
					id_mb2,
					dono,
					data,
					st
				)
				VALUES (
					'{$conteudo}',
					'{$id_mb1}',
					'{$id_mb2}',
					'{$this->id}',
					NOW(),
					3
				)
			;";
			
			mysql_query($qry, $conexao);
      
			if(mysql_affected_rows()==1)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		public function ExistNewChat($conexao, $id_membro)
		{

			$qry = "
		       	SELECT
					COUNT( 1 ) AS qtd
				FROM
			      	ginga3_chat
				WHERE
			      dono != '{$this->id}' and
			      dono  = '{$id_membro}' and
			      st = 3
			;";

			$resultado  = mysql_query($qry, $conexao);
			$row 		= mysql_fetch_array($resultado);					
			
			return $row["qtd"] > 0;
		}

		public function Get($conexao, $_id)
		{
			$controle_db = new ControleDB($conexao);
			$the_membro  = $controle_db->Membros->GetById($_id);	

			$this->id        = $the_membro->id;
			$this->nome      = $the_membro->nome;
			$this->apelido   = $the_membro->apelido;
			$this->email     = $the_membro->email;
			$this->senha     = $the_membro->senha;
			$this->cor       = $the_membro->cor;
			$this->cor2      = $the_membro->cor2;
			$this->cor3      = $the_membro->cor3;
			$this->foto      = $the_membro->foto;
			$this->manifesto = $the_membro->manifesto;
			$this->data      = $the_membro->data;
			$this->st        = $the_membro->st;
			$this->chat_st   = $the_membro->chat_st;
		}
	}	
	class Projeto
	{
		
		public $id;
		public $nome;
		public $descricao;
		public $img;
		public $data;

		public function __construct()
		{
			$this->id        = null;
			$this->nome      = null;
			$this->descricao = null;
			$this->img       = null;
			$this->data      = null;
		}
			
		public function CarregarLinha($linha)
		{
			$this->id        = $linha["id"];
			$this->nome      = $linha["nome"];
			$this->descricao = $linha["descricao"];
			$this->img       = $linha["img"];
			$this->data      = $linha["data"];

		} 
	
		public function Inserir($conexao)
		{
			$controle_db = new ControleDB($conexao);
			return $controle_db->Projetos->Inserir($this);
		}
	
		public function Alterar($conexao)
		{
			$controle_db = new ControleDB($conexao);
			return $controle_db->Projetos->Atualizar($this);
		}
		
		public function Excluir($conexao)
		{
			$controle_db = new ControleDB($conexao);
			return $controle_db->Projetos->Excluir($this->id);
		}

		public function GetTotalTarefas($conexao){
			
			$qry = "
				SELECT 
					COUNT( 1 ) AS qtd
				FROM ginga3_tarefas
					WHERE id_projeto = '{$this->id}'
			;";

			$resultado  = mysql_query($qry, $conexao);
			
			$linha = mysql_fetch_array($resultado);					
			return $linha["qtd"];
		}

		public function GetTotalStTarefas($conexao, $st){
			
			$qry = "
				SELECT COUNT( 1 ) AS qtd
				FROM ginga3_tarefas
				WHERE id_projeto = '{$this->id}' AND st = '{$st}'
			;";

			$resultado  = mysql_query($qry, $conexao);
			
			$linha = mysql_fetch_array($resultado);					
			return $linha["qtd"];
		}

		public function GetTotalMembros($conexao){
			
			$qry = "
				SELECT COUNT( 1 ) AS qtd
				FROM ginga3_membros_projetos
				WHERE id_projeto = '{$this->id}'
			;";

			$resultado  = mysql_query($qry, $conexao);
			
			$linha = mysql_fetch_array($resultado);					
			return $linha["qtd"];
		}

		public function GetNivel($conexao){
			
			$total        = $this->GetTotalTarefas($conexao); 
			$total_feitas = $this->GetTotalStTarefas($conexao, 3);
			$total_fazend = $this->GetTotalStTarefas($conexao, 2)/2;

			if($total == 0) return 0;

			return (($total_feitas+$total_fazend)*100)/$total; 
			return (($total_feitas+$total_fazend)*100)/$total; 
		}

		public function Get($conexao, $_id)
		{
			$controle_db = new ControleDB($conexao);
			$the_projeto = $controle_db->Projetos->GetById($_id);	

			$this->id        = $the_projeto->id;        
			$this->nome      = $the_projeto->nome;      
			$this->descricao = $the_projeto->descricao; 
			$this->img       = $the_projeto->img;       
			$this->data      = $the_projeto->data;      
		}
	}	
	class Tarefa
	{
		
		public $id;
		public $nome;
		public $descricao;
		public $data;
		public $id_projeto;
		public $st;

		public function __construct()
		{
			$this->id         = null;
			$this->nome       = null;
			$this->descricao  = null;
			$this->data       = null;
			$this->id_projeto = null;
			$this->st         = null;
		}
			
		public function CarregarLinha($linha)
		{
			$this->id         = $linha["id"];
			$this->nome       = $linha["nome"];
			$this->descricao  = $linha["descricao"];
			$this->data       = $linha["data"];
			$this->id_projeto = $linha["id_projeto"];
			$this->st         = $linha["st"];
		} 
	
		public function Inserir($conexao)
		{
			$controle_db = new ControleDB($conexao);
			return $controle_db->Tarefas->Inserir($this);
		}
	
		public function Alterar($conexao)
		{
			$controle_db = new ControleDB($conexao);
			return $controle_db->Tarefas->Atualizar($this);
		}
		
		public function Excluir($conexao)
		{
			$controle_db = new ControleDB($conexao);
			return $controle_db->Tarefas->Excluir($this->id);
		}

		public function Get($conexao, $_id)
		{
			$controle_db = new ControleDB($conexao);
			$the_tarefa  = $controle_db->Tarefas->GetById($_id);	
			
			$this->id         = $the_tarefa->id;         
			$this->nome       = $the_tarefa->nome;       
			$this->descricao  = $the_tarefa->descricao;  
			$this->data       = $the_tarefa->data;       
			$this->id_projeto = $the_tarefa->id_projeto;     
		}
	}	


/*********************************************
*	Classes de interação com o Banco de dados  *
**********************************************/

	class ControleDB
	{
		public $Membros;
		public $Projetos;
		public $Tarefas;
		public $Cargos;

		private $conexao;
		
		
		public function __construct($conexao)
		{
			$this->Membros  = new C_Membro($conexao);
			$this->Projetos = new C_Projeto($conexao);
			$this->Tarefas  = new C_Tarefa($conexao);	
			$this->Cargos   = new C_Cargo($conexao);
			
			$this->conexao = $conexao;
		}
		
		public function SelectQry($qry)
		{
			return mysql_query($qry, $this->conexao);
		}
		
	  	public function ExecuteQry($qry)
		{
			return mysql_query($qry, $this->conexao);
		}	
	
		public function VerificaRegistro($campo, $valor, $tabela)
		{
			$qry = "
			SELECT
				{$campo}
			FROM
				{$tabela}
			WHERE
				{$campo}='{$valor}'
			;";

			$resultado = mysql_query($qry, $this->conexao);
			$numLinhas = mysql_num_rows($resultado);
			
			return $numLinhas;
		}
	}

/*SubClasses de ControleDB*/	
	
	class C_Cargo
	{
		private $conexao;
		
		public function __construct($conexao)
		{
			$this->conexao = $conexao;
		}

		public function GetById($_id){

			$the_cargo = new Cargo();

			$qry = "
				SELECT
					*
				FROM
					ginga3_cargos
				WHERE
					id = '{$_id}'
			;";

			$resultado  = mysql_query($qry, $this->conexao);
			
			if(count($resultado) > 0){
				
				$linha = mysql_fetch_array($resultado);					
				$the_cargo->CarregarLinha($linha);
				
				return $the_cargo;
			}
			else
				return null;
		}

		public function GetByWhere($where){

			$the_cargo = new Cargo();

			$qry = "
				SELECT
					*
				FROM
					ginga3_cargos
				WHERE
					{$where}
				LIMIT 1
			;";

			$resultado  = mysql_query($qry, $this->conexao);
			
			if(count($resultado) > 0){
				
				$linha = mysql_fetch_array($resultado);					
				$the_cargo->CarregarLinha($linha);
				
				return $the_cargo;
			}
			else
				return null;
		}
		
		public function Inserir($novo_cargo)
		{
			$qry = "
				INSERT INTO ginga3_cargos(
					nome
				) 
				VALUES (
					'{$novo_cargo->nome}'
				);
			";

			mysql_query($qry, $this->conexao);
      
			if(mysql_affected_rows()==1)
			{
				$novo_cargo->id = $this->SelecionaUltimoId();
				return 1;
			}
			else
			{
				return 0;
			}
		}
    
		public function Atualizar($cargo)
		{
			$qry = "
				UPDATE ginga3_cargos SET
					nome 	  = '{$cargo->nome}'
				WHERE
					id = '{$cargo->id}';
			";
			
			mysql_query($qry, $this->conexao);
			if( mysql_affected_rows() == 1 )
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		
		public function Excluir($_id)
		{
			$qry = "DELETE FROM ginga3_cargos WHERE id = '{$_id}';";
			mysql_query($qry, $this->conexao);

			if(mysql_affected_rows()==1)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		
		public function SelecionaUltimoId()
		{
			$consulta 		= "SELECT MAX(id) AS id	FROM ginga3_cargos;";
			$resultado 		= mysql_query($consulta, $this->conexao);
			$linha 			= mysql_fetch_array($resultado);
			return $linha['id'];
		}
	}	
	class C_Membro
	{
		private $conexao;
		
		public function __construct($conexao)
		{
			$this->conexao = $conexao;
		}

		public function GetById($_id)
		{

			$the_membro = new Membro();

			$qry = "
				SELECT
					*
				FROM
					ginga3_membros
				WHERE
					id = '{$_id}'
			;";

			$resultado  = mysql_query($qry, $this->conexao);
			
			if(count($resultado) > 0){
				
				$linha = mysql_fetch_array($resultado);					
				$the_membro->CarregarLinha($linha);
				
				return $the_membro;
			}
			else
				return null;
		}

		public function GetByWhere($where)
		{

			$the_membro = new Membro();

			$qry = "
				SELECT
					*
				FROM
					ginga3_membros
				WHERE
					{$where}
				LIMIT 1
			;";

			$resultado  = mysql_query($qry, $this->conexao);
			
			if(count($resultado) > 0){
				
				$linha = mysql_fetch_array($resultado);					
				$the_membro->CarregarLinha($linha);
				
				return $the_membro;
			}
			else
				return null;
		}
		
		public function Inserir($novo_membro)
		{

			$novo_membro->nome      = converte_html($novo_membro->nome);
			$novo_membro->apelido   = converte_html($novo_membro->apelido);
			$novo_membro->manifesto = converte_html($novo_membro->manifesto);

			$qry = "
				INSERT INTO ginga3_membros(
					nome, 
					apelido, 
					email, 
					senha, 
					cor, 
					cor2, 
					cor3, 
					foto,
					manifesto,
					data,
					id_cargo,
					st,
					chat_st
				) 
				VALUES (
					'{$novo_membro->nome}', 
					'{$novo_membro->apelido}', 
					'{$novo_membro->email}', 
					'{$novo_membro->senha}', 
					'{$novo_membro->cor}', 
					'{$novo_membro->cor2}', 
					'{$novo_membro->cor3}', 
					'{$novo_membro->foto}',
					'{$novo_membro->manifesto}',
					 NOW(),
					'{$novo_membro->id_cargo}',
					'0',
					'0'
				);
			";

			mysql_query($qry, $this->conexao);
      
			if(mysql_affected_rows()==1)
			{
				$novo_membro->id = $this->SelecionaUltimoId();
				return 1;
			}
			else
			{
				return 0;
			}
		}
    
		public function Atualizar($membro)
		{
			$nome      = converte_html($membro->nome);
			$membro->apelido   = converte_html($membro->apelido);
			$membro->manifesto = converte_html($membro->manifesto);
			
			$qry = "
				UPDATE ginga3_membros SET
					nome 	  = '{$nome}', 
					apelido   = '{$membro->apelido}', 
					email 	  = '{$membro->email}', 
					senha 	  = '{$membro->senha}', 
					cor 	  = '{$membro->cor}', 
					cor2 	  = '{$membro->cor2}', 
					cor3 	  = '{$membro->cor3}', 
					foto 	  = '{$membro->foto}',
					manifesto = '{$membro->manifesto}',
					st   	  = '{$membro->st}',
					chat_st   = '{$membro->chat_st}'
				WHERE
					id = '{$membro->id}';
			";
			
			mysql_query($qry, $this->conexao);
			if( mysql_affected_rows() == 1 )
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		public function SetSt($_st, $_id)
		{
			$qry = "
				UPDATE ginga3_membros SET
					st = '{$_st}'
				WHERE
					id = '{$_id}';
			";
			
			mysql_query($qry, $this->conexao);
			if( mysql_affected_rows() == 1 )
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		public function ChatSetSt($_st, $_id)
		{
			$qry = "
				UPDATE ginga3_chat SET
					st = '{$_st}'
				WHERE
					id = '{$_id}';
			";
			
			mysql_query($qry, $this->conexao);
			if( mysql_affected_rows() == 1 )
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		public function ComentarTarefa($id_membro, $id_tarefa, $conteudo )
		{

			$conteudo = converte_html($conteudo);

			$qry = "
				INSERT INTO ginga3_tarefas_comentarios(
					conteudo, 
					id_membro, 
					id_tarefa, 
					data, 
					st
				) 
				VALUES (
					'{$conteudo}', 
					'{$id_membro}', 
					'{$id_tarefa}',
					 NOW(),
					1
				);
			";

			mysql_query($qry, $this->conexao);
      
			if(mysql_affected_rows()==1)
			{
				return 1;
			}
			else
			{
				return 0;
			}	
		}

		public function ComentarProjeto($id_membro, $id_projeto, $conteudo )
		{
			converte_html($conteudo);

			$qry = "
				INSERT INTO ginga3_projetos_comentarios(
					conteudo, 
					id_membro, 
					id_projeto, 
					data, 
					st
				) 
				VALUES (
					'{$conteudo}', 
					'{$id_membro}', 
					'{$id_projeto}',
					 NOW(),
					1
				);
			";
			
			mysql_query($qry, $this->conexao);
      
			if(mysql_affected_rows()==1)
			{
				return 1;
			}
			else
			{
				return 0;
			}	
		}

		public function SetMembroProjeto($id_membro, $id_projeto)
		{
			$qry = "
				INSERT INTO ginga3_membros_projetos(
					data,
					id_membro,
					id_projeto
				)
				VALUES(
					NOW(),
					'{$id_membro}',
					'{$id_projeto}'
				);
			";

			mysql_query($qry, $this->conexao);
      
			if(mysql_affected_rows()==1)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		public function SetMembroTarefa($id_membro, $id_tarefa)
		{
			$qry = "
				INSERT INTO ginga3_membros_tarefas(
					data,
					id_membro,
					id_tarefa
				)
				VALUES(
					NOW(),
					'{$id_membro}',
					'{$id_tarefa}'
				);
			";

			mysql_query($qry, $this->conexao);
      
			if(mysql_affected_rows()==1)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		public function SendMsM($id_emissor, $id_receptor, $titulo, $conteudo)
		{
			$qry = "
				INSERT INTO ginga3_mensagens(
					titulo,
					conteudo,
					data,
					id_emissor,
					id_receptor,
					st
				)
				VALUES (
					'{$titulo}',
					'{$conteudo}',
					NOW(),
					'{$id_emissor}',
					'{$id_receptor}',
					1
				)
				;
			";

			mysql_query($qry, $this->conexao);
      
			if(mysql_affected_rows()==1)
			{
				return 1;
			}
			else
			{
				return 0;
			}

		}

		public function ClearGens()
		{
			$qry = "
				UPDATE ginga3_membros SET
					st = 1
				WHERE
					st = 3;
			";
			
			mysql_query($qry, $this->conexao);
			if( mysql_affected_rows() == 1 )
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		
		public function Excluir($_id)
		{
			$qry = "DELETE FROM ginga3_membros WHERE id = '{$_id}';";
			mysql_query($qry, $this->conexao);
      
			if(mysql_affected_rows()==1)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		
		public function SelecionaUltimoId()
		{
			$consulta 		= "SELECT MAX(id) AS id	FROM ginga3_membros;";
			$resultado 		= mysql_query($consulta, $this->conexao);
			$linha 			= mysql_fetch_array($resultado);
			return $linha['id'];
		}
	}	
	class C_Projeto
	{
		private $conexao;
		
		public function __construct($conexao)
		{
			$this->conexao = $conexao;
		}

		public function GetById($_id){

			$the_projeto = new Projeto();

			$qry = "
				SELECT
					*
				FROM
					ginga3_projetos
				WHERE
					id = '{$_id}'
			;";

			$resultado  = mysql_query($qry, $this->conexao);
			
			if(count($resultado) > 0){
				
				$linha = mysql_fetch_array($resultado);					
				$the_projeto->CarregarLinha($linha);
				
				return $the_projeto;
			}
			else
				return null;
		}

		public function GetByWhere($where){

			$the_projeto = new Projeto();

			$qry = "
				SELECT
					*
				FROM
					ginga3_projetos
				WHERE
					{$where}
				LIMIT 1
			;";

			$resultado  = mysql_query($qry, $this->conexao);
			
			if(count($resultado) > 0){
				
				$linha = mysql_fetch_array($resultado);					
				$the_projeto->CarregarLinha($linha);
				
				return $the_projeto;
			}
			else
				return null;
		}
		
		public function Inserir($novo_projeto)
		{
			$qry = "
				INSERT INTO ginga3_projetos(
					nome, 
					descricao, 
					img, 
					data) 
				VALUES (
					'{$novo_projeto->nome}', 
					'{$novo_projeto->descricao}', 
					'{$novo_projeto->img}', 
					NOW()
				);
			";

			mysql_query($qry, $this->conexao);
      
			if(mysql_affected_rows()==1)
			{
				$novo_projeto->id = $this->SelecionaUltimoId();
				return 1;
			}
			else
			{
				return 0;
			}
		}
    
		public function Atualizar($projeto)
		{
			$qry = "
				UPDATE ginga3_projetos SET
					nome 	   = '{$projeto->nome}',
					descricao  = '{$projeto->descricao}',
					img 	   = '{$projeto->img}',
					data 	   = '{$projeto->data}'
				WHERE
					id = '{$projeto->id}';
			";
			
			mysql_query($qry, $this->conexao);

			if( mysql_affected_rows() == 1 )
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		
		public function ClearMembros($_id)
		{
			$qry = "DELETE FROM ginga3_membros_projetos WHERE id_projeto = '{$_id}';";
			mysql_query($qry, $this->conexao);
      
			if(mysql_affected_rows()==1)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		public function Excluir($_id)
		{
			$qry = "DELETE FROM ginga3_projetos WHERE id = '{$_id}';";
			mysql_query($qry, $this->conexao);
      
			if(mysql_affected_rows()==1)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		
		public function SelecionaUltimoId()
		{
			$consulta 		= "SELECT MAX(id) AS id	FROM ginga3_projetos;";
			$resultado 		= mysql_query($consulta, $this->conexao);
			$linha 			= mysql_fetch_array($resultado);
			return $linha['id'];
		}
	}	
	class C_Tarefa
	{
		private $conexao;
		
		public function __construct($conexao)
		{
			$this->conexao = $conexao;
		}

		public function GetById($_id){

			$the_tarefa = new Tarefa();

			$qry = "
				SELECT
					*
				FROM
					ginga3_tarefas
				WHERE
					id = '{$_id}'
			;";

			$resultado  = mysql_query($qry, $this->conexao);
			
			if(count($resultado) > 0){
				
				$linha = mysql_fetch_array($resultado);					
				$the_tarefa->CarregarLinha($linha);
				
				return $the_tarefa;
			}
			else
				return null;
		}

		public function GetByWhere($where){

			$the_tarefa = new Tarefa();

			$qry = "
				SELECT
					*
				FROM
					ginga3_tarefas
				WHERE
					{$where}
				LIMIT 1
			;";

			$resultado  = mysql_query($qry, $this->conexao);
			
			if(count($resultado) > 0){
				
				$linha = mysql_fetch_array($resultado);					
				$the_tarefa->CarregarLinha($linha);
				
				return $the_tarefa;
			}
			else
				return null;
		}
		
		public function Inserir($nova_tarefa)
		{
			$qry = "
				INSERT INTO ginga3_tarefas (
					nome,
					descricao,
					data,
					id_projeto,
					st
				)
				VALUES(
					'{$nova_tarefa->nome}',
					'{$nova_tarefa->descricao}',
					NOW(),
					'{$nova_tarefa->id_projeto}',
					1
				);
			";

			mysql_query($qry, $this->conexao);
      
			if(mysql_affected_rows()==1)
			{
				$nova_tarefa->id = $this->SelecionaUltimoId();
				return 1;
			}
			else
			{
				return 0;
			}
		}

		public function InserirAquivo($nome, $local, $id_tarefa)
		{
			$qry = "
				INSERT INTO ginga3_tarefas_arquivos(
				  nome,
				  local,
				  id_tarefa
				)
				VALUES(
				  '{$nome}',
				  '{$local}',
				  '{$id_tarefa}'
				)
			";

			mysql_query($qry, $this->conexao);
      
			if(mysql_affected_rows()==1)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
    
		public function Atualizar($tarefa)
		{
			$qry = "
				UPDATE ginga3_tarefas SET
					nome 	   = '{$tarefa->nome}',
					descricao  = '{$tarefa->descricao}',
					data       = '{$tarefa->data}',
					id_projeto = '{$tarefa->id_projeto}',
					st         = '{$tarefa->st}'
				WHERE
					id = '{$tarefa->id}';
			";

			mysql_query($qry, $this->conexao);
			if( mysql_affected_rows() == 1 )
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		public function SetSt($_st, $_id)
		{
			$qry = "
				UPDATE ginga3_tarefas SET
					st = '{$_st}'
				WHERE
					id = '{$_id}';
			";

			mysql_query($qry, $this->conexao);
			if( mysql_affected_rows() == 1 )
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		public function ClearMembros($_id)
		{
			$qry = "DELETE FROM ginga3_membros_tarefas WHERE id_tarefa = '{$_id}';";
			mysql_query($qry, $this->conexao);
      
			if(mysql_affected_rows()==1)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		
		public function Excluir($_id)
		{
			$qry = "DELETE FROM ginga3_tarefas WHERE id = '{$_id}';";
			mysql_query($qry, $this->conexao);
      
			if(mysql_affected_rows()==1)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		
		public function SelecionaUltimoId()
		{
			$consulta 		= "SELECT MAX(id) AS id	FROM ginga3_tarefas;";
			$resultado 		= mysql_query($consulta, $this->conexao);
			$linha 			= mysql_fetch_array($resultado);
			return $linha['id'];
		}
	}

?>

