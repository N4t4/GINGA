------------criação------------------
-- Modelo físico
-- sexta-feira 26/10/2012.
-- Natã Elias Rafael
------------Alteração----------------
-- Natã Elias Rafael     30/11/2012..
-------------------------------------
CREATE TABLE membros (
  id       INTEGER PRIMARY KEY AUTO_INCREMENT,
  nome     VARCHAR(60),
  senha    VARCHAR(15),
  e_mail   VARCHAR(60),
  situacao SMALLINT
);

CREATE TABLE grupos (
  id   INTEGER PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(40)
);

CREATE TABLE membro_grupos (
  id        INTEGER PRIMARY KEY AUTO_INCREMENT,
  situacao  SMALLINT,
  id_membro INTEGER,
  id_grupo  INTEGER,
  FOREIGN KEY (id_membro) REFERENCES membros(id),
  FOREIGN KEY (id_grupo) REFERENCES grupos(id)
);

CREATE TABLE projetos (
  id       INTEGER PRIMARY KEY AUTO_INCREMENT,
  nome     VARCHAR(60),
  situacao SMALLINT,
  id_grupo INTEGER,
  FOREIGN KEY (id_grupo) REFERENCES grupos(id)
);

CREATE TABLE membros_projetos (
  id              INTEGER PRIMARY KEY AUTO_INCREMENT,
  situacao        SMALLINT,
  id_membro_grupo INTEGER,
  id_projeto      INTEGER,
  FOREIGN KEY (id_membro_grupo) REFERENCES membro_grupos(id),
  FOREIGN KEY (id_projeto) REFERENCES projetos(id)
);

CREATE TABLE tarefas (
  id          INTEGER PRIMARY KEY AUTO_INCREMENT,
  nome        VARCHAR(40),
  descricao   VARCHAR(200),
  id_projeto  INTEGER,
  FOREIGN KEY (id_projeto) REFERENCES projetos(id)
);

CREATE TABLE membros_tarefas (
  id                INTEGER PRIMARY KEY AUTO_INCREMENT,
  id_membro_projeto INTEGER,
  id_tarefa         INTEGER,
  FOREIGN KEY (id_membro_projeto) REFERENCES membros_projetos(id),
  FOREIGN KEY (id_tarefa) REFERENCES tarefas(id)
);

CREATE TABLE controle_tarefas (
  id        INTEGER PRIMARY KEY AUTO_INCREMENT,
  estado    SMALLINT,
  id_tarefa INTEGER,
  FOREIGN KEY (id_tarefa) REFERENCES tarefas(id)
);

CREATE TABLE gerentes (
  id        INTEGER PRIMARY KEY AUTO_INCREMENT,
  situacao  SMALLINT,
	senha     VARCHAR(15),
  id_membro INTEGER,
	id_grupo INTEGER,
  FOREIGN KEY (id_grupo)  REFERENCES grupos(id),
  FOREIGN KEY (id_membro) REFERENCES membros(id)
);

CREATE TABLE membros_fotos (
  id    INTEGER PRIMARY KEY AUTO_INCREMENT,
  tipo  SMALLINT,
  spath VARCHAR( 100 ) NOT NULL,
  id_membro INTEGER,
	FOREIGN KEY (id_membro) REFERENCES membros(id)
);

CREATE TABLE tarefas_arquivos (
  id        INTEGER PRIMARY KEY AUTO_INCREMENT,
  spath     VARCHAR( 100 ) NOT NULL,
  id_tarefa INTEGER,
	FOREIGN KEY (id_tarefa) REFERENCES tarefas(id)
);

CREATE TABLE chat
(
	id        INTEGER PRIMARY KEY AUTO_INCREMENT,
  conteudo  VARCHAR(300),
  id_grupo 	INTEGER,
	id_membro INTEGER,
	data_hora DATETIME,
	FOREIGN KEY (id_grupo) REFERENCES grupos(id),
	FOREIGN KEY (id_membro) REFERENCES membros(id)

);

CREATE TABLE expecificacoes(
  id        INTEGER PRIMARY KEY AUTO_INCREMENT,
	descricao VARCHAR(30)
);
INSERT INTO expecificacoes(descricao) VALUES ('Professor');
INSERT INTO expecificacoes(descricao) VALUES ('Aluno');
INSERT INTO expecificacoes(descricao) VALUES ('Ex-Aluno');
INSERT INTO expecificacoes(descricao) VALUES ('Comunidade');

CREATE TABLE cursos(
	id 				INTEGER PRIMARY KEY AUTO_INCREMENT,
	descricao VARCHAR(30)
);
INSERT INTO cursos(descricao)VALUES('TADS');
INSERT INTO cursos(descricao)VALUES('TEC Iinfo');
INSERT INTO cursos(descricao)VALUES('TEC Edf');
INSERT INTO cursos(descricao)VALUES('MAT');

CREATE TABLE fixas_membros (
  id        INTEGER PRIMARY KEY AUTO_INCREMENT,
  nome      VARCHAR(60),
	endereco  VARCHAR(100),
	telefone  VARCHAR(13),
	dt_nasc   DATETIME,
	dt_inscr  DATETIME,
	indicacao VARCHAR(60),
	id_exp    INTEGER,
	id_membro INTEGER,
	id_curso  INTEGER,
	modulo    INTEGER,
	FOREIGN KEY (id_exp)  REFERENCES expecificacoes(id),
	FOREIGN KEY (id_membro) REFERENCES membros(id),
	FOREIGN KEY (id_curso) REFERENCES cursos(id)
);

CREATE TABLE areas(
	id 		    INTEGER PRIMARY KEY AUTO_INCREMENT,
	descricao VARCHAR(30)
);
INSERT INTO areas(descricao) VALUES ('Programação');
INSERT INTO areas(descricao) VALUES ('Modelagem 3D');
INSERT INTO areas(descricao) VALUES ('Desenho');
INSERT INTO areas(descricao) VALUES ('Qualidade');
INSERT INTO areas(descricao) VALUES ('Produção');
INSERT INTO areas(descricao) VALUES ('Administrativo');
INSERT INTO areas(descricao) VALUES ('Marketing');
INSERT INTO areas(descricao) VALUES ('Produção Musical');
INSERT INTO areas(descricao) VALUES ('Roteirista');

CREATE TABLE fixas_membros_areas(
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	id_fixa INTEGER,
	id_area INTEGER,
	FOREIGN KEY (id_fixa) REFERENCES fixas_membros(id),
	FOREIGN KEY (id_area) REFERENCES areas(id)
);

CREATE TABLE sys_tabelas
(
	id 			INTEGER PRIMARY KEY AUTO_INCREMENT,
	nome 	  VARCHAR(30),
	alias   VARCHAR(30),
	qry     VARCHAR(900)

);
INSERT INTO sys_tabelas (nome,alias, qry) VALUES ("membros","Membros","FROM membros m INNER JOIN fixas_membros fm  ON m.id = fm.id_membro INNER JOIN expecificacoes ex  ON fm.id_exp = ex.id INNER JOIN cursos c ON fm.id_curso  = c.id LIMIT 20;");
INSERT INTO sys_tabelas (nome,alias, qry) VALUES ("tarefas","Tarefas",
"FROM
tarefas t
INNER JOIN membros_tarefas  mt ON t.id = mt.id_tarefa
INNER JOIN membros_projetos mp ON mt.id_membro_projeto = mp.id
INNER JOIN membro_grupos mg ON mp.id_membro_grupo = mg.id
INNER JOIN membros m ON mg.id_membro = m.id
INNER JOIN projetos p ON mp.id_projeto = p.id;");
CREATE TABLE sys_tbs_ginga
(
	id	  		INTEGER PRIMARY KEY AUTO_INCREMENT,
	campo 		VARCHAR(900),
	alias 		VARCHAR(30),
	caption		VARCHAR(30),
	st_campo  SMALLINT,
	id_tabela INTEGER,
	FOREIGN KEY (id_tabela) REFERENCES sys_tabelas(id)
);
INSERT INTO sys_tbs_ginga(campo, alias,caption, st_campo, id_tabela) VALUES
("fm.nome","nome","Nome", 1, 1),
("fm.endereco","endereco","Endereço", 1, 1),
("m.e_mail","e_mail","E-mail", 1, 1),
("fm.telefone","telefone","Telefone", 1, 1),
("DATE_FORMAT(fm.dt_nasc, '%d-%m-%Y') AS dt_nasc","dt_nasc","Data de Nascimento", 1, 1),
("ex.descricao AS expecifacacao","expecifacacao","Expecificação", 1, 1),
("fm.indicacao","indicacao","Indicação", 1, 1),
("DATE_FORMAT(fm.dt_inscr, '%d-%m-%Y') AS dt_inscr","dt_inscr","Data Inscrição", 1, 1),
("c.descricao AS curso","curso","Curso", 1, 1),
("fm.modulo","modulo","Módulo", 1, 1),
("(SELECT
			group_concat(descricao separator ', ')
		 FROM
      fixas_membros_areas fma
      INNER JOIN areas a ON fma.id_area = a.id
     WHERE fma.id_fixa = fm.id) as areas","areas","Áreas", 1, 1);
INSERT INTO sys_tbs_ginga(campo, alias,caption, st_campo, id_tabela) VALUES
("t.nome","nome","Tarefa", 1, 2),
("t.descricao","descricao","Descrição", 1, 2),
("GROUP_CONCAT(m.nome SEPARATOR ', ') as membros","membros","Membros em tarefa", 1, 2),
("p.nome as projeto","projeto","Projeto", 1, 2),
("(SELECT CASE ct.estado
WHEN 1 THEN 'Criada' WHEN 2 THEN 'Sendo Feita' WHEN 3 THEN 'Concluída' END
FROM
controle_tarefas ct
WHERE ct.id_tarefa = t.id
ORDER BY id DESC LIMIT 1) AS situacao","situacao","Estado da tarefa", 1, 2);
