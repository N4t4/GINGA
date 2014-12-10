<?php
/*---------------------------------------------
Criado por   Natу                27/10/2012 -
revisado por Natу                30/10/2012 -   
---------------------------------------------*/

	class Grupo
	{
		public $id;
		public $nome;
		
		public function __construct()
		{
			$this->id 	= null;
			$this->nome = null;
		}
		
		public function CaregarLinha($linha)
		{
			$this->id  	= $linha['id'];
			$this->nome = $linha['nome'];
		}
	}

	class Projeto
	{
		public $id;
		public $nome;
		public $situacao;
		public $id_grupo;
		
		public function __construct()
		{
			$this->id 	  	= null;
			$this->nome 	  = null;
			$this->situacao = null;
			$this->id_grupo = null;	
		}
		
		public function CaregarLinha($linha)
		{
			$this->id 	  	= $linha['id'];
			$this->nome 	  = $linha['nome'];
			$this->situacao = $linha['situacao'];
			$this->id_grupo = $linha['id_grupo'];
		}
	}

	class Membro
	{
		public $id;
		public $nome;
		public $senha;
		public $e_mail;
		public $situacao;
		
		public function __construct()
		{
			$this->id 	  	= null;
			$this->nome 	  = null;
			$this->senha    = null;
			$this->e_mail   = null;
			$this->situacao = null;
		}
			
		public function CaregarLinha($linha)
		{
			$this->id 	  	= $linha['id'];
			$this->nome 	  = $linha['nome'];
			$this->senha    = $linha['senha'];
			$this->e_mail   = $linha['e_mail'];
			$this->situacao = $linha['situacao'];
		} 
	}

	class Gerente
	{
		public $id;
		public $situacao;
		public $senha;
		public $id_membro;
		public $id_grupo;
			
		public function __construct()
		{
			$this->id 	  	 = null;
			$this->situacao  = null;
			$this->senha 	   = null;
			$this->id_membro = null;
			$this->id_grupo  = null;
		}	
		
		public function CaregarLinha($linha)
		{
			$this->id 	  	 = $linha['id'];
			$this->situacao  = $linha['situacao'];
			$this->senha 	   = $linha['senha'];
			$this->id_membro = $linha['id_membro'];
			$this->id_grupo  = $linha['id_grupo'];
		}
	}

	class Tarefa
	{
		public $id;
		public $nome;
		public $descricao;
		public $id_projeto;
		
		public function __construct()
		{
			$this->id 	  	  = null;
			$this->nome 	    = null;
			$this->descricao  = null;
			$this->id_projeto = null;
		}
		
		public function CaregarLinha($linha)
		{
			$this->id 	  	  = $linha['id'];
			$this->nome 	    = $linha['nome'];
			$this->descricao  = $linha['descricao'];
			$this->id_projeto = $linha['id_projeto'];
		}
	}
	
	class Expecificacao
	{
		public $id;
		public $descricao;
		
		public function __construct()
		{
			$this->id 	  	  = null;
			$this->descricao  = null;
		}
		
		public function CaregarLinha($linha)
		{
			$this->id 	  	  = $linha['id'];
			$this->descricao  = $linha['descricao'];
		}
	}
	
	class Chat
	{
		public $id;
		public $conteudo;
		public $id_grupo;
		public $id_membro;
		
		public function __construct()
		{
			$this->id        = null;
			$this->conteudo  = null;
			$this->id_grupo  = null;
			$this->id_membro = null;
		}
		
		public function CaregarLinha($linha)
		{
			$this->id 			 = $linha['id'];
			$this->conteudo  = $linha['conteudo'];
			$this->id_grupo  = $linha['id_grupo'];
			$this->id_membro = $linha['id_membro'];
		}
	}

/*********************************************
*	Classes de interaчуo com o Banco de dados  *
**********************************************/

	class ControleDB
	{
		public  $Membro; 
		public  $Grupo; 
		public  $Gerente; 
		public  $Projeto; 
		public  $Tarefa; 
		public  $Expecificacao; 
		
		private $conexao;
		
		public function __construct($conexao)
		{
			$this->Projeto       = new C_Projeto($conexao);
			$this->Tarefa        = new C_Tarefa($conexao);
			$this->Grupo         = new C_Grupo($conexao);
			$this->Membro        = new C_Membro($conexao);
			$this->Gerente       = new C_Gerente($conexao);
			$this->Expecificacao = new C_Expecificacao($conexao);
			
			$this->conexao = $conexao;
		}

		public function AssociarMembroGrupo($id_membro, $id_grupo)
		{
			$qry = "
			INSERT INTO	membro_grupos
			(
				id_membro,
				id_grupo,
				situacao
			)
			values
			(
				{$id_membro},
				{$id_grupo},
				1
			)
			;";
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
		
		public function AssociarMembroGrupoProjeto($id_membro_grupo, $id_projeto)
		{
			$qry = "
			INSERT INTO	membros_projetos
			(
				id_membro_grupo,
				id_projeto,
				situacao
			)
			values
			(
				{$id_membro_grupo},
				{$id_projeto},
				1
			)
			;";
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

		public function AssociarMembroGrupoProjetoTarefa($id_membro_projeto, $id_tarefa)
		{
			$qry = "
			INSERT INTO	membros_tarefas
			(
				id_membro_projeto,
				id_tarefa
			)
			values
			(
				{$id_membro_projeto},
				{$id_tarefa}
			)
			;";
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
		
		public function ControlarTarefa($id_tarefa, $estado)
		{
			$qry = "
			INSERT INTO	controle_tarefas
			(
				estado,
				id_tarefa
			)
			values
			(
				{$estado},
				{$id_tarefa}
			)
			;";
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
	
		public function SelUltimo($tabela)
		{
			$consulta 		= "SELECT MAX(id) AS id	FROM ".$tabela.";";
			$resultado 		= mysql_query($consulta, $this->conexao);
			$linha 				= mysql_fetch_array($resultado);
			return $linha['id'];
		}

		public function SelCampoPorId($tabela,$campo,$id)
		{
			$consulta 		= "SELECT ".$campo." FROM ".$tabela." WHERE id ='{$id}';";
			$resultado 		= mysql_query($consulta, $this->conexao);
			$linha 				= mysql_fetch_array($resultado);
			return $linha[$campo];
		}
	
		public function Chat($chat)
		{
			$qry = "
			INSERT INTO chat
			(
				conteudo,
				id_grupo,
				id_membro,
				data_hora
			)
			VALUES
			(
				'{$chat->conteudo}',
				{$chat->id_grupo},
				{$chat->id_membro},
				NOW()
			)
			;";
			
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
	
	}
/*SubClasses de ControleDB*/	
	class C_Membro
	{
		private $conexao;
		
		public function __construct($conexao)
		{
			$this->conexao = $conexao;
		}
		
		public function GetIdMembroGrupo($id_membro,$id_grupo)
		{
			$consulta = "
			SELECT 
				id
			FROM
				membro_grupos
			WHERE
				id_grupo  ='{$id_grupo}' AND
				id_membro ='{$id_membro}'
			";
			$resultado 		= mysql_query($consulta, $this->conexao);
			
			$linha 				= mysql_fetch_array($resultado);
			
			return $linha['id'];
		}
		
		public function GetIdMembroGrupoProjeto($id_membro,$id_grupo,$id_projeto)
		{
			$id_membro_grupo = $this->GetIdMembroGrupo($id_membro,$id_grupo);
			
			$consulta = "
			SELECT 
				id
			FROM
				membros_projetos
			WHERE
				id_membro_grupo  ='{$id_membro_grupo}' AND
				id_projeto = '{$id_projeto}'
			";
			$resultado 		= mysql_query($consulta, $this->conexao);
			
			$linha 				= mysql_fetch_array($resultado);
			
			return $linha['id'];
		}
	
		public function GetMembroPorIdProjeto($id_membro_projeto)
		{
			$qry = "
			SELECT 
				m.*
			FROM 
				membros m
				LEFT JOIN membro_grupos    mg ON  m.id = mg.id_membro
				LEFT JOIN membros_projetos mp ON mg.id = mp.id_membro_grupo
			WHERE 
				mp.id = '{$id_membro_projeto}';
			";
			
			$resultado 				= mysql_query($qry, $this->conexao);
			$linha 						= mysql_fetch_array($resultado);
			$membro_procurado = new Membro();
			$membro_procurado->CaregarLinha($linha);
			
			return $membro_procurado;
		}
		
		public function GetMembroPorIdGrupo($id_membro_grupo)
		{
			$qry = "
			SELECT 
				m.*
			FROM 
				membros m
				LEFT JOIN membro_grupos mg ON  m.id = mg.id_membro
			WHERE 
				mg.id = '{$id_membro_grupo}';
			";
			
			$resultado 				= mysql_query($qry, $this->conexao);
			$linha 						= mysql_fetch_array($resultado);
			$membro_procurado = new Membro();
			$membro_procurado->CaregarLinha($linha);
			
			return $membro_procurado;
		}
		
		public function Inserir($novo_membro)
		{
		
			$qry = "
			INSERT INTO membros
			(
				nome,
				senha,
				e_mail,
				situacao
			)
			VALUES
			(
				'{$novo_membro->nome}',
				'{$novo_membro->senha}',
				'{$novo_membro->e_mail}',
				'{$novo_membro->situacao}'
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
    
    public function InserirFoto($sfoto, $id_proprietario)
		{
      $qry = "
        INSERT INTO membros_fotos(
          tipo,
          spath,
          id_proprietario
        ) 
        VALUES(
          1,
          '{$sfoto}',
          '{$id_proprietario}'
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
		
		public function SelecionaUltimoId()
		{
			$consulta 		= "SELECT MAX(id) AS id	FROM membros;";
			$resultado 		= mysql_query($consulta, $this->conexao);
			$linha 				= mysql_fetch_array($resultado);
			return $linha['id'];
		}
	
		public function GerenteDeGrupo($id_membro, $id_grupo)
		{
      $qry = "
        SELECT
					id
				FROM
					gerentes
				WHERE
					id_membro='{$id_membro}' AND
					id_grupo='{$id_grupo}'
			;";
      $resultado = mysql_query($qry, $this->conexao);
      $num = mysql_num_rows($resultado);
      if($num>0)
			{
				return 1;
			}
			else
			{
				return 0;
			}
    }
	}

	class C_Grupo
	{
		private $conexao;
		
		public function __construct($conexao)
		{
			$this->conexao = $conexao;
		}
		
		public function Inserir($novo_grupo)
		{
			$qry = "
			INSERT INTO grupos
			(
				nome
			)
			VALUES
			(
				'{$novo_grupo->nome}'
			);
			";
		
			mysql_query($qry, $this->conexao);
			if(mysql_affected_rows()==1)
			{
				$novo_grupo->id = $this->SelecionaUltimoId();
				return 1;
			}
			else
			{
				return 0;
			}
		}
		
		public function SelecionaUltimoId()
		{
			$consulta 		= "SELECT MAX(id) AS id	FROM grupos;";
			$resultado 		= mysql_query($consulta, $this->conexao);
			$linha 				= mysql_fetch_array($resultado);
			return $linha['id'];
		}
	}
	
	class C_Gerente
	{
		private $conexao;
		
		public function __construct($conexao)
		{
			$this->conexao = $conexao;
		}
		
		public function Inserir($novo_gerente)
		{
			$qry = "
			INSERT INTO gerentes
			(
				situacao,
				senha,
				id_membro,
				id_grupo
			)
			VALUES
			(
				 {$novo_gerente->situacao},
				'{$novo_gerente->senha}',
				 {$novo_gerente->id_membro},
				 {$novo_gerente->id_grupo}
			);
			";
		
			mysql_query($qry, $this->conexao);
			if(mysql_affected_rows()==1)
			{
				$novo_gerente->id = $this->SelecionaUltimoId();
				return 1;
			}
			else
			{
				return 0;
			}
		}
		
		public function SelecionaUltimoId()
		{
			$consulta 		= "SELECT MAX(id) AS id	FROM gerentes;";
			$resultado 		= mysql_query($consulta, $this->conexao);
			$linha 				= mysql_fetch_array($resultado);
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
		
		public function Inserir($novo_projeto)
		{
			$qry = "
			INSERT INTO projetos
			(
				nome,
				situacao,
				id_grupo
			)
			VALUES
			(
				'{$novo_projeto->nome}',
				'{$novo_projeto->situacao}',
				 {$novo_projeto->id_grupo}
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
		
		public function SelecionaUltimoId()
		{
			$consulta 		= "SELECT MAX(id) AS id	FROM projetos;";
			$resultado 		= mysql_query($consulta, $this->conexao);
			$linha 				= mysql_fetch_array($resultado);
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
		
		public function Inserir($nova_tarefa)
		{
			$qry = "
			INSERT INTO tarefas
			(
				nome,
				descricao,
				id_projeto
			)
			VALUES
			(
				'{$nova_tarefa->nome}',
				'{$nova_tarefa->descricao}',
				 {$nova_tarefa->id_projeto}
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
		
		public function GetEstado($id_tarefa)
		{
			$consulta = "
			SELECT 
				estado
			FROM
				controle_tarefas
			WHERE
				id_tarefa  = '{$id_tarefa}' AND
				id IN (
								SELECT
									MAX(id)
								FROM
									controle_tarefas
								WHERE
									id_tarefa  ='{$id_tarefa}'
							)
			;
			";
			$resultado 		= mysql_query($consulta, $this->conexao);
			
			$linha 				= mysql_fetch_array($resultado);
			
			return $linha['estado'];
		}
	
	
		public function SelecionaUltimoId()
		{
			$consulta 		= "SELECT MAX(id) AS id	FROM tarefas;";
			$resultado 		= mysql_query($consulta, $this->conexao);
			$linha 				= mysql_fetch_array($resultado);
			return $linha['id'];
		}
		
	}
	
	class C_Expecificacao
	{
		private $conexao;
		
		public function __construct($conexao)
		{
			$this->conexao = $conexao;
		}
		
		public function Inserir($nova_expecificacao)
		{
			$qry = "
			INSERT INTO expecificacoes
			(
				descricao
			)
			VALUES
			(
				'{$nova_expecificacao->descricao}'
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
		
		public function SelecionaUltimoId()
		{
			$consulta 		= "SELECT MAX(id) AS id	FROM expecificacoes";
			$resultado 		= mysql_query($consulta, $this->conexao);
			$linha 				= mysql_fetch_array($resultado);
			return $linha['id'];
		}
	}	
	
?>