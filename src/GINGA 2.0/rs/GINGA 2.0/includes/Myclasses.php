<?php
/*---------------------------------------------
Criado por   Natã                27/10/2012 -
revisado por Natã                30/10/2012 -   
---------------------------------------------*/

	class Membro
	{
		public $id;
		public $e_mail;
		public $st;
		public $curso;
		public $telefone;
		public $modulo;
		public $senha;
		public $nome;
		public $dt_nascimento;
		public $indicacao;
		public $vinculo;
		public $dt_entrada;
		public $sexo;
		public $dt_saida;
		public $id_area;

		public function __construct()
		{
			$this->id            =null;
			$this->e_mail        =null;
			$this->st            =null;
			$this->curso         =null;
			$this->telefone      =null;
			$this->modulo        =null;
			$this->senha         =null;
			$this->nome          =null;
			$this->dt_nascimento =null;
			$this->indicacao     =null;
			$this->vinculo       =null;
			$this->dt_entrada    =null;
			$this->sexo          =null;
			$this->dt_saida      =null;
			$this->id_area       =null;
		}
			
		public function CaregarLinha($linha)
		{
			$this->id            =$linha["id"];
			$this->e_mail        =$linha["e_mail"];
			$this->st            =$linha["st"];
			$this->curso         =$linha["curso"];
			$this->telefone      =$linha["telefone"];
			$this->modulo        =$linha["modulo"];
			$this->senha         =$linha["senha"];
			$this->nome          =$linha["nome"];
			$this->dt_nascimento =$linha["dt_nascimento"];
			$this->indicacao     =$linha["indicacao"];
			$this->vinculo       =$linha["vinculo"];
			$this->dt_entrada    =$linha["dt_entrada"];
			$this->sexo          =$linha["sexo"];
			$this->dt_saida      =$linha["dt_saida"];
			$this->id_area       =$linha["id_area"];
		} 
	
		public function Registrar($conexao)
		{
			$controle_db = new ControleDB($conexao);
			$controle_db->Membro->Registrar($this);
		}
		
		public function Inserir($conexao)
		{
			$controle_db = new ControleDB($conexao);
			$controle_db->Membro->Inserir($this);
		}
	
		public function Alterar($conexao)
		{
			$controle_db = new ControleDB($conexao);
			return $controle_db->Membro->Atualizar($this);
		}
		
		public function Excluir($conexao)
		{
			$controle_db = new ControleDB($conexao);
			$controle_db->Membro->Excluir($membro);
		}
		
		public function ListarMembroPendente($conexao)
		{
			$controle_db = new ControleDB($conexao);
			
			$reply = $controle_db->SelectQry("
				SELECT * FROM membros
				WHERE st  = 0;
			");
			
			$i  = 0;
			$ar = array();
			while($linha = mysql_fetch_array($reply)){
				$ar[$i] = CaregarLinha($linha);
				$i++;
			}
			
			return array("lista"=>$ar, "Count"=>$i);
		}
		
	}

	class Area  
	{
		public $id;
		public $descricao;
		
		public function __construct()
		{
			$this->id         = null;
			$this->descricao  = null;
		}
		
		public function CaregarLinha($linha)
		{
			$this->id            = $linha["id"];
			$this->descricao     = $linha["descricao"];
		}
		public function Crair($conexao)
		{
			$controle_db = new ControleDB($conexao);
			$controle_db->Area->Inserir($this);
		}
		public function Alterar($conexao)
		{
			$controle_db = new ControleDB($conexao);
			$controle_db->Area->Alterar($this);
		}
		public function Excluir($conexao)
		{
			$controle_db = new ControleDB($conexao);
			$controle_db->Area->Excluir($this);
		}
		
	}
	
	class Chat
	{
		public $membro1;
		public $membro2;
		public $dth_ini;
		public $msm;
		public $id_membro;
		
		public function __construct()
		{
			$this->membro1   = null;
			$this->membro2   = null;
			$this->dth_ini   = null;
			$this->msm       = null;
			$this->id_membro = null;
		}
		
		public function CaregarLinha($linha)
		{
			$this->membro1   = $linha["membro1"];
			$this->membro2   = $linha["membro2"];
			$this->dth_ini   = $linha["dth_ini"];
			$this->msm       = $linha["msm"];
			$this->id_membro = $linha["id_membro"];
		}
		
		public function Criar()
		{
			$controle_db = new ControleDB($conexao);
			$controle_db->Chat->Inserir($this);
		}
	}

	class Gerente
	{
		public $id;
		public $id_membro;
		
		public function __construct()
		{
			$this->id         = null;
			$this->id_membro  = null;
		}
		
		public function CaregarLinha($linha)
		{
			$this->id            = $linha["id"];
			$this->id_membro     = $linha["id_membro"];
		}
		public function Crair($conexao)
		{
			$controle_db = new ControleDB($conexao);
			$controle_db->Gerente->Inserir($this);
		}
		public function Alterar($conexao)
		{
			$controle_db = new ControleDB($conexao);
			$controle_db->Gerente->Alterar($this);
		}
		public function Excluir($conexao)
		{
			$controle_db = new ControleDB($conexao);
			$controle_db->Gerente->Excluir($this);
		}
		
		public function Acessar($conexao, $id_membro){
			$controle_db = new ControleDB($conexao);
			return $controle_db->Gerente->EhGerente($id_membro);
		}
		
		public function PermitirMembro($conexao,$membro){
			$controle_db = new ControleDB($conexao);
			
			$membro->st = 1;
			return $membro->Alterar($conexao);
		}
	}
	
	class Endereco
	{
		public $numero;
		public $cidade;
		public $estado;
		public $bairro;
		public $rua;
		public $id;
		public $id_membro;
		
		public function __construct()
		{
			$this->numero    = null;
			$this->cidade    = null;
			$this->estado    = null;
			$this->bairro    = null;
			$this->rua       = null;
			$this->id        = null;
			$this->id_membro = null;
		}
		
		public function CaregarLinha($linha)
		{
			$this->numero    = $linha["numero"];
			$this->cidade    = $linha["cidade"];
			$this->estado    = $linha["estado"];
			$this->bairro    = $linha["bairro"];
			$this->rua       = $linha["rua"];
			$this->id        = $linha["id"];
			$this->id_membro = $linha["id_membro"];
		}
		
		public function Criar($conexao)
		{
			$controle_db = new ControleDB($conexao);
			$controle_db->Endereco->Inserir($this);
		}
	}
	
	class Projeto
	{
		public $id;
		public $nome;
		
		public function __construct()
		{
			$this->id         = null;
			$this->nome  = null;
		}
		
		public function CaregarLinha($linha)
		{
			$this->id       = $linha["id"];
			$this->nome     = $linha["nome"];
		}
		public function Criar($conexao)
		{
			$controle_db = new ControleDB($conexao);
			return $controle_db->Projeto->Inserir($this);
		}
		public function Alterar($conexao)
		{
			$controle_db = new ControleDB($conexao);
			return $controle_db->Projeto->Alterar($this);
		}
		public function Excluir($conexao)
		{
			$controle_db = new ControleDB($conexao);
			$controle_db->Projeto->Excluir($this);
		}
		
		public function AtrMembro($conexao, $id_membro)
		{
			$controle_db = new ControleDB($conexao);
			$controle_db->Projeto->AtrMembro($this, $id_membro);
		}
		
	}
	
	class Pendencia
	{
		public $dt_termino;
		public $st;
		public $nome;
		public $dt_inicio;
		public $id;
		public $id_area;
		public $id_projeto;
		
		public function __construct()
		{
			$this->dt_termino = null;
			$this->st         = null;
			$this->nome       = null;
			$this->dt_inicio  = null;
			$this->id         = null;
			$this->id_area    = null;
			$this->id_projeto = null;
		}
		public function CaregarLinha($linha)
		{
			$this->dt_termino = $linha["dt_termino"];
			$this->st         = $linha["st"];
			$this->nome       = $linha["nome"];
			$this->dt_inicio  = $linha["dt_inicio"];
			$this->id         = $linha["id"];
			$this->id_area    = $linha["id_area"];
			$this->id_projeto = $linha["id_projeto"];
		}
		public function Criar($conexao)
		{
			$controle_db = new ControleDB($conexao);
			return $controle_db->Pendencia->Inserir($this);
		}
		public function Alterar($conexao)
		{
			$controle_db = new ControleDB($conexao);
			$controle_db->Pendencia->Alterar($this);
		}
		public function Excluir($conexao)
		{
			$controle_db = new ControleDB($conexao);
			$controle_db->Pendencia->Excluir($this);
		}
	
		public function AtrMembro($conexao, $id_membro)
		{
			$controle_db = new ControleDB($conexao);
			$controle_db->Pendencia->AtrMembro($this, $id_membro);
		}
		
	}
	
	class Arquivos
	{

	}
	
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

/*********************************************
*	Classes de interação com o Banco de dados  *
**********************************************/

	class ControleDB
	{
		public  $Membro; 
		public  $Area;
		public  $Chat;
		public  $Gerente; 
    public  $Endereco;
		public  $Projeto;
    public  $Pendencia;
		
		private $conexao;
		
		
		public function __construct($conexao)
		{
			$this->Membro        = new C_Membro($conexao);
			$this->Area          = new C_Area($conexao);
			$this->Chat          = new C_Chat($conexao);
			$this->Endereco      = new C_Endereco($conexao);
			$this->Projeto       = new C_Projeto($conexao);
			$this->Pendencia     = new C_Pendencia($conexao);
			$this->Gerente       = new C_Gerente($conexao);
						
			$this->conexao = $conexao;
		}
		
		public function SelectQry($qry)
		{
			return mysql_query($qry, $this->conexao);
		}
		
	  public function ExecuteQry($qry)
		{
			mysql_query($qry, $this->conexao);
			return;
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
	
	
	class C_Membro
	{
		private $conexao;
		
		public function __construct($conexao)
		{
			$this->conexao = $conexao;
		}
		
		public function Inserir($novo_membro)
		{
			$qry = "
			INSERT INTO membros
			(
				e_mail,
				st,            			
				curso,         			
				telefone,      			
				modulo,        			
				senha,         			
				nome,          			
				dt_nascimento,
				indicacao,     			
				vinculo,      			
				dt_entrada,    			
				sexo,          			
				dt_saida,      			
				id_area			
			)
			VALUES
			(
				'{$novo_membro->e_mail}',
				'{$novo_membro->st}',            			
				'{$novo_membro->curso}',         			
				'{$novo_membro ->telefone}',      			
				'{$novo_membro->modulo}',        			
				'{$novo_membro->senha}',         			
				'{$novo_membro->nome}',          			
				'{$novo_membro->dt_nascimento}',
				'{$novo_membro->indicacao}',     			
				'{$novo_membro->vinculo}',      			
				NOW(),    			
				'{$novo_membro->sexo}',          			
				'{$novo_membro->dt_saida}',      			
				'{$novo_membro->id_area}'
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
			$qry = "
			UPDATE membros
			SET
				e_mail        = '{$membro->e_mail}',
				st            = '{$membro->st}',            			
				curso         = '{$membro->curso}',         			
				telefone      = '{$membro ->telefone}',      			
				modulo        = '{$membro->modulo}',        			
				senha         = '{$membro->senha}',         			
				nome          = '{$membro->nome}',          			
				dt_nascimento = '{$membro->dt_nascimento}',
				indicacao     = '{$membro->indicacao}',     			
				vinculo       = '{$membro->vinculo}',      			
				dt_entrada    = '{$membro->dt_entrada}',    			
				sexo          = '{$membro->sexo}',          			
				dt_saida      = '{$membro->dt_saida}',      			
				id_area		 	  = '{$membro->id_area}'
			WHERE
				id            = '{$membro->id}'
			;";
			
     // echo $qry;
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
		
		public function Excluir($membro)
		{
			$qry = "DELETE FROM membros WHERE	id = '{$membro->id}';";
			
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
	
		public function Registrar($membro){
			$qry = "
			UPDATE membros
			SET
				st = 1
			WHERE
				id = '{$membro->id}'
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
		
		public function EhGerente($id_membro, $id_grupo)
		{
      $qry = "
        SELECT
					id
				FROM
					gerentes
				WHERE
					id_membro='{$id_membro}'
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
	
	class C_Area
	{
		private $conexao;
		
		public function __construct($conexao)
		{
			$this->conexao = $conexao;
		}
		
		public function Inserir($nova_area)
		{
			$qry = "
			INSERT INTO areas
			(
				descricao
			)
			VALUES
			(
				'{$nova_area->descricao}'
			);
			";
		
			mysql_query($qry, $this->conexao);
			if(mysql_affected_rows()==1)
			{
				$nova_area->id = $this->SelecionaUltimoId();
				return 1;
			}
			else
			{
				return 0;
			}
		}
		public function Alterar($area)
		{
			$qry = "
			UPDATE areas
			SET descricao = '{$area->descricao}'
			WHERE id = '{$area->id}'
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
		public function Excluir($area)
		{
			$qry = "DELETE FROM areas WHERE	id = '{$area->id}';";
			
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
			$consulta 		= "SELECT MAX(id) AS id	FROM areas;";
			$resultado 		= mysql_query($consulta, $this->conexao);
			$linha 				= mysql_fetch_array($resultado);
			return $linha['id'];
		}	
	}
	
	class C_Chat
	{
		private $conexao;
		
		public function __construct($conexao)
		{
			$this->conexao = $conexao;
		}
		
		public function Inserir($novo_chat)
		{
			$qry = "
			INSERT INTO chat
			(
				membro1,
				membro2,  
				dth_ini,  
				msm,      
				id_membro
			)
			VALUES
			(
				'{$novo_chat->membro1}',
				'{$novo_chat->membro2}',
				NOW(),
				'{$novo_chat->msm}',
				'{$novo_chat->msm}',
				'{$novo_chat->id_membro}'
			);
			";
		
			mysql_query($qry, $this->conexao);
			if(mysql_affected_rows()==1)
			{
				$novo_chat->id = $this->SelecionaUltimoId();
				return 1;
			}
			else
			{
				return 0;
			}
		}
		
		public function SelecionaUltimoId()
		{
			$consulta 		= "SELECT MAX(id) AS id	FROM chat;";
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
				id_membro
			)
			VALUES
			(
				'{$novo_gerente->id_membro}'
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
		public function Alterar($gerente)
		{
			$qry = "
			UPDATE gerentes
			SET id_membro = '{$gerente->descricao}'
			WHERE id = '{$gerente->id}'
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
		public function Excluir($gerente)
		{
			$qry = "DELETE FROM gerentes WHERE	id = '{$gerente->id}';";
			
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
			$consulta 		= "SELECT MAX(id) AS id	FROM gerentes;";
			$resultado 		= mysql_query($consulta, $this->conexao);
			$linha 				= mysql_fetch_array($resultado);
			return $linha['id'];
		}	
	
		public function EhGerente($id_membro)
		{
	    $qry = "
        SELECT
					id
				FROM
					gerentes
				WHERE
					id_membro='{$id_membro}'
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
	
	class C_Endereco
	{
	private $conexao;
		
		public function __construct($conexao)
		{
			$this->conexao = $conexao;
		}
		
		public function Inserir($novo_endereco)
		{
			$qry = "
			INSERT INTO enderecos
			(
				numero,    
				cidade,    
				estado,    
				bairro,    
				rua,       
				id_membro 
			)
			VALUES
			(
				'{$novo_endereco->numero}',
				'{$novo_endereco->cidade}',
				'{$novo_endereco->estado}',
				'{$novo_endereco->bairro}',
				'{$novo_endereco->rua}',
				'{$novo_endereco->id_membro}'
			);
			";
		
			mysql_query($qry, $this->conexao);
			if(mysql_affected_rows()==1)
			{
				$novo_endereco->id = $this->SelecionaUltimoId();
				return 1;
			}
			else
			{
				return 0;
			}
		}
		public function Alterar($endereco)
		{
			$qry = "
			UPDATE enderecos
			SET
				numero    = '{$endereco->numero}',
				cidade    = '{$endereco->cidade}',
				estado    = '{$endereco->estado}',
				bairro    = '{$endereco->bairro}',
				rua       = '{$endereco->rua}',
				id_membro = '{$endereco->id_membro}'
			WHERE
			 id = '{$endereco->id}'
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
		public function Excluir($endereco)
		{
			$qry = "DELETE FROM enderecos WHERE	id = '{$endereco->id}';";
			
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
			$consulta 		= "SELECT MAX(id) AS id	FROM enderecos;";
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
				nome
			)
			VALUES
			(
				'{$novo_projeto->nome}'
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
		public function Alterar($projeto)
		{
			$qry = "
			UPDATE projetos
			SET nome = '{$projeto->nome}'
			WHERE id = '{$projeto->id}'
			";

			
			if(mysql_query($qry, $this->conexao))
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		public function Excluir($projeto)
		{
			$qry = "DELETE FROM projetos WHERE	id = '{$projeto->id}';";
			
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
			$consulta 		= "SELECT MAX(id) AS id	FROM projetos;";
			$resultado 		= mysql_query($consulta, $this->conexao);
			$linha 				= mysql_fetch_array($resultado);
			return $linha['id'];
		}	
		
		public function AtrMembro($projeto, $id_membro)
		{
			$qry = "
			INSERT INTO membros_projetos
			(
				id_projeto, 
				id_membro 
			)
			VALUES
			(
				'{$projeto->id}',
				'{$id_membro}'
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
	
	}
	
	class C_Pendencia
	{
		private $conexao;
		
		public function __construct($conexao)
		{
			$this->conexao = $conexao;
		}
		
		public function Inserir($nova_pendencia)
		{
			$qry = "
			INSERT INTO pendencias
			(
				dt_termino, 
				st,
				nome,       
				dt_inicio,  
				id_area,    
				id_projeto 
			)
			VALUES
			(
				'{$nova_pendencia->dt_termino}',
				'{$nova_pendencia->st}',
				'{$nova_pendencia->nome}',
				NOW(),
				'{$nova_pendencia->id_area}',
				'{$nova_pendencia->id_projeto}'
			);
			";
		
			mysql_query($qry, $this->conexao);
			if(mysql_affected_rows()==1)
			{
				$nova_pendencia->id = $this->SelecionaUltimoId();
				return 1;
			}
			else
			{
				return 0;
			}
		}
		public function Alterar($pendencia)
		{
			$qry = "
			UPDATE pendencias
			SET 
				dt_termino = '{$pendencia->dt_termino}',
				st         = '{$pendencia->st}',
				nome       = '{$pendencia->nome}',
				dt_inicio  = '{$pendencia->dt_inicio}',
				id_area    = '{$pendencia->id_area}',
				id_projeto = '{$pendencia->id_projeto}'
			WHERE id = '{$pendencia->id}'
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
		public function Excluir($pendencia)
		{
			$qry = "DELETE FROM pendencias WHERE	id = '{$pendencia->id}';";
			
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
			$consulta 		= "SELECT MAX(id) AS id	FROM pendencias;";
			$resultado 		= mysql_query($consulta, $this->conexao);
			$linha 				= mysql_fetch_array($resultado);
			return $linha['id'];
		}	
	
		public function AtrMembro($pendencia, $id_membro)
		{
			$qry = "
			INSERT INTO membros_pendencias
			(
				id_pendencia, 
				id_membro 
			)
			VALUES
			(
				'{$pendencia->id}',
				'{$id_membro}'
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
	}
?>
