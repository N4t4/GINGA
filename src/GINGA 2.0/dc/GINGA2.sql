
DROP TABLE IF EXISTS arquivos;
DROP TABLE IF EXISTS membros_pendencias;
DROP TABLE IF EXISTS pendencias;
DROP TABLE IF EXISTS membros_projetos;
DROP TABLE IF EXISTS projetos;
DROP TABLE IF EXISTS enderecos;
DROP TABLE IF EXISTS gerentes;
DROP TABLE IF EXISTS chat;
DROP TABLE IF EXISTS membros;
DROP TABLE IF EXISTS areas;

CREATE TABLE areas (
	descricao VARCHAR(30),	
	id INTEGER PRIMARY KEY AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE membros (
	id INTEGER PRIMARY KEY AUTO_INCREMENT PRIMARY KEY,
	e_mail VARCHAR(30),
	st SMALLINT,
	curso VARCHAR(10),
	telefone VARCHAR(13),
	modulo VARCHAR(5),
	senha VARCHAR(8),
	nome VARCHAR(30),
	dt_nascimento DATETIME,
	indicacao VARCHAR(30),
	vinculo INTEGER,
	dt_entrada DATETIME,
	sexo SMALLINT,
	dt_saida DATETIME,
	id_area INTEGER,
	FOREIGN KEY(id_area) REFERENCES areas (id)
);

CREATE TABLE chat (
	membro1 INTEGER,
	membro2 INTEGER,
	dth_ini DATETIME,
	msm VARCHAR(300),
	id_membro INTEGER,
	FOREIGN KEY(id_membro) REFERENCES membros (id)
);

CREATE TABLE gerentes (
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	id_membro INTEGER,
	FOREIGN KEY(id_membro) REFERENCES membros (id)
);

CREATE TABLE enderecos (
	numero INTEGER,
	cidade VARCHAR(30),
	estado VARCHAR(30),
	bairro VARCHAR(30),
	rua VARCHAR(30),
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	id_membro INTEGER,
	FOREIGN KEY(id_membro) REFERENCES membros (id)
);

CREATE TABLE projetos (
	nome VARCHAR(30),
	id INTEGER PRIMARY KEY AUTO_INCREMENT
);

CREATE TABLE membros_projetos (
	id_membro INTEGER,
	id_projeto INTEGER,
	FOREIGN KEY(id_membro) REFERENCES membros (id),
	FOREIGN KEY(id_projeto) REFERENCES projetos (id)
);

CREATE TABLE pendencias (
	dt_termino DATETIME,
	st SMALLINT,
	nome VARCHAR(30),
	dt_inicio DATETIME,
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	id_area INTEGER,
	id_projeto INTEGER,
	FOREIGN KEY(id_area) REFERENCES areas (id),
	FOREIGN KEY(id_projeto) REFERENCES projetos (id)
);

CREATE TABLE membros_pendencias (
	id_pendencia INTEGER,
	id_membro INTEGER,
	FOREIGN KEY(id_pendencia) REFERENCES pendencias (id),
	FOREIGN KEY(id_membro) REFERENCES membros (id)
);

CREATE TABLE arquivos (
	id INTEGER PRIMARY KEY AUTO_INCREMENT PRIMARY KEY,
	tipo VARCHAR(30),
	nome VARCHAR(30),
	id_membro INTEGER,
	id_pendencia INTEGER,
	FOREIGN KEY(id_pendencia) REFERENCES pendencias (id),
	FOREIGN KEY(id_membro) REFERENCES membros (id)
);

INSERT INTO areas(descricao) VALUES("Programacao");
INSERT INTO areas(descricao) VALUES("Modelagem 3D");
INSERT INTO areas(descricao) VALUES("Desenho");
INSERT INTO areas(descricao) VALUES("Qualidade");
INSERT INTO areas(descricao) VALUES("Procução");
INSERT INTO areas(descricao) VALUES("Administrativo");
INSERT INTO areas(descricao) VALUES("Marketing");
INSERT INTO areas(descricao) VALUES("Musica");
INSERT INTO areas(descricao) VALUES("Roterista");

INSERT INTO membros (id, e_mail, st, curso, telefone, modulo, senha, nome, dt_nascimento, indicacao, vinculo, dt_entrada, sexo, dt_saida, id_area) VALUES
(1, 'nata.erafael@gmail.com', 0, 'TADS', '(12)3662-4070', '3ro m', '123', 'Nat&atild', '2013-06-23 00:00:00', 'Professor avelino.', 1, '2013-06-23 00:00:00', 1, '1992-09-26 00:00:00', 2),
(2, 'a@a.com', 0, 'TADS', '(12)3662-4070', '3ro m', '123', 'NatÃ£', '2013-06-23 00:00:00', 'Professor avelino.', 2, '2013-06-23 22:55:25', 1, '0000-00-00 00:00:00', 2),
(3, 'b@b.com', 0, 'TADS', '(12)3662-4070', '3ro m', '123', 'NatÃ£', '2013-06-23 00:00:00', 'Professor avelino.', 1, '2013-06-23 23:03:18', 1, '0000-00-00 00:00:00', 3),
(4, 'c@c.com', 0, 'TADS', '(12)3662-4070', '3ro m', '123', 'NatÃ£', '2013-06-23 00:00:00', 'Professor avelino.', 1, '2013-06-23 23:10:15', 1, '0000-00-00 00:00:00', 3),
(5, 'dl@d.com', 0, 'TADS', '(12)3662-4070', '3ro m', '123', 'NatÃ£', '2013-06-23 00:00:00', 'Professor avelino.', 1, '2013-06-23 23:11:55', 1, '0000-00-00 00:00:00', 3);

INSERT INTO gerentes(id_membro) VALUES(1);

