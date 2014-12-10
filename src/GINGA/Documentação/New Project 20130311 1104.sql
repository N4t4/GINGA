-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.24-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema ts
--

CREATE DATABASE IF NOT EXISTS ts;
USE ts;

--
-- Definition of table `areas`
--

DROP TABLE IF EXISTS `areas`;
CREATE TABLE `areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `areas`
--

/*!40000 ALTER TABLE `areas` DISABLE KEYS */;
INSERT INTO `areas` (`id`,`descricao`) VALUES 
 (1,'Programação'),
 (2,'Modelagem 3D'),
 (3,'Desenho'),
 (4,'Qualidade'),
 (5,'Produção'),
 (6,'Administrativo'),
 (7,'Marketing'),
 (8,'Produção Musical'),
 (9,'Roteirista');
/*!40000 ALTER TABLE `areas` ENABLE KEYS */;


--
-- Definition of table `chat`
--

DROP TABLE IF EXISTS `chat`;
CREATE TABLE `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conteudo` varchar(300) DEFAULT NULL,
  `id_grupo` int(11) DEFAULT NULL,
  `id_membro` int(11) DEFAULT NULL,
  `data_hora` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_grupo` (`id_grupo`),
  KEY `id_membro` (`id_membro`),
  CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`),
  CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`id_membro`) REFERENCES `membros` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat`
--

/*!40000 ALTER TABLE `chat` DISABLE KEYS */;
INSERT INTO `chat` (`id`,`conteudo`,`id_grupo`,`id_membro`,`data_hora`) VALUES 
 (1,'Oi',1,1,'2012-11-05 14:20:41'),
 (2,'OlÃ¡',1,1,'2012-11-05 14:21:34'),
 (3,'Oiee :-) ',1,1,'2012-11-05 14:28:43'),
 (4,'Tudo bom?',1,1,'2012-11-05 14:29:23'),
 (5,'Sim',1,1,'2012-11-05 14:29:45'),
 (6,'oi',1,3,'2012-11-05 15:35:13'),
 (7,'Oi gente :-) ',1,1,'2012-11-05 15:39:14'),
 (8,'Oi',1,4,'2012-11-05 15:39:35'),
 (9,'Fala comigo.',1,1,'2012-11-05 15:39:49'),
 (10,'Oi',1,4,'2012-11-05 15:40:54'),
 (11,'oii',1,3,'2012-11-05 15:41:29'),
 (12,'Oiiii.....',1,2,'2012-11-05 15:41:29'),
 (13,'Boa noite caro colegas.',1,2,'2012-11-05 16:04:26'),
 (14,'',1,2,'2012-11-05 16:04:26'),
 (15,'Boa noite caros colegas....',1,2,'2012-11-05 16:05:03'),
 (16,'Hello!!!!!',1,2,'2012-11-05 16:35:19'),
 (17,'Oi',1,1,'2012-11-05 16:44:03'),
 (18,'OI TETEU',1,6,'2012-11-05 16:44:06'),
 (19,'\\o/',1,7,'2012-11-05 16:44:09'),
 (20,'obrigada pela atenÃ§ao de todos',1,4,'2012-11-05 16:44:17'),
 (21,'E ai galeraaaaaaaaaaaaaaa, blzzzzzzzzzzzz',1,8,'2012-11-05 16:44:18'),
 (22,'Ave Lino',1,8,'2012-11-05 16:44:19'),
 (23,'\\o/',1,5,'2012-11-05 16:44:21'),
 (24,'rsrsrs',1,8,'2012-11-05 16:44:22'),
 (25,'todo mundo no chat?',1,14,'2012-11-05 16:44:25'),
 (26,'Eai',1,10,'2012-11-05 16:44:27'),
 (27,'Eai galera',1,16,'2012-11-05 16:44:42'),
 (28,'aowwwww',1,18,'2012-11-05 16:44:43'),
 (29,'Alguem conta uma piada?',1,14,'2012-11-05 16:44:47'),
 (30,'haha :)',1,6,'2012-11-05 16:44:50'),
 (31,'aashuhasuha =)',1,5,'2012-11-05 16:44:54'),
 (32,'love of my liiiiiiiiiife! you hurt me!',1,7,'2012-11-05 16:44:56'),
 (33,'OI TETEU !',1,6,'2012-11-05 16:45:00'),
 (34,'AAAAAAAAAAAAVVVVVVVVVVVVVEEEEEEEEEEEE LIIIIIIINOOOOOOOOOOO',1,8,'2012-11-05 16:45:04'),
 (35,'quem leu com a voz do Ikki ae?',1,7,'2012-11-05 16:45:33'),
 (36,'toma um assaizinho',1,6,'2012-11-05 16:45:49'),
 (37,'OPPAN GANGNAM STYLE!',1,6,'2012-11-05 16:47:28'),
 (38,'Obrigado!  gente :-) ',1,1,'2012-11-05 17:04:12'),
 (39,'Oiii',1,1,'2012-11-27 18:34:34'),
 (40,'Oi nata',1,1,'2013-02-28 10:26:02'),
 (41,'Ola NatÃƒ',1,1,'2013-02-28 10:26:23'),
 (42,'Nlz',1,1,'2013-02-28 10:26:30'),
 (43,'Nzl rs',1,1,'2013-02-28 10:26:45');
/*!40000 ALTER TABLE `chat` ENABLE KEYS */;


--
-- Definition of table `controle_tarefas`
--

DROP TABLE IF EXISTS `controle_tarefas`;
CREATE TABLE `controle_tarefas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` smallint(6) DEFAULT NULL,
  `id_tarefa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tarefa` (`id_tarefa`),
  CONSTRAINT `controle_tarefas_ibfk_1` FOREIGN KEY (`id_tarefa`) REFERENCES `tarefas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `controle_tarefas`
--

/*!40000 ALTER TABLE `controle_tarefas` DISABLE KEYS */;
INSERT INTO `controle_tarefas` (`id`,`estado`,`id_tarefa`) VALUES 
 (1,1,1),
 (2,1,2),
 (3,1,3),
 (4,2,2),
 (5,1,4),
 (6,2,3),
 (7,3,2),
 (8,3,3),
 (9,2,4),
 (10,3,4),
 (11,2,4),
 (12,3,4),
 (13,2,4),
 (14,1,5),
 (15,2,5),
 (16,3,5),
 (17,2,5),
 (18,3,5),
 (19,2,5),
 (20,3,5),
 (21,2,5),
 (22,1,5),
 (23,2,1),
 (24,1,1),
 (25,1,4),
 (26,2,4),
 (27,3,4),
 (28,2,1),
 (29,2,2),
 (30,2,3),
 (31,3,2),
 (32,2,2),
 (33,3,2),
 (34,1,3),
 (35,2,2),
 (36,3,2),
 (37,2,2),
 (38,1,2),
 (39,2,2),
 (40,2,4),
 (41,3,4),
 (42,2,4),
 (43,1,4),
 (44,3,2),
 (45,2,2),
 (46,1,2),
 (47,1,6),
 (48,2,6),
 (49,1,7),
 (50,1,8),
 (51,2,4),
 (52,1,4),
 (53,1,1),
 (54,2,1),
 (55,2,2),
 (56,2,3),
 (57,2,4),
 (58,1,1),
 (59,2,1);
/*!40000 ALTER TABLE `controle_tarefas` ENABLE KEYS */;


--
-- Definition of table `cursos`
--

DROP TABLE IF EXISTS `cursos`;
CREATE TABLE `cursos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cursos`
--

/*!40000 ALTER TABLE `cursos` DISABLE KEYS */;
INSERT INTO `cursos` (`id`,`descricao`) VALUES 
 (1,'TADS'),
 (2,'TEC Iinfo'),
 (3,'TEC Edf'),
 (4,'MAT');
/*!40000 ALTER TABLE `cursos` ENABLE KEYS */;


--
-- Definition of table `expecificacoes`
--

DROP TABLE IF EXISTS `expecificacoes`;
CREATE TABLE `expecificacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expecificacoes`
--

/*!40000 ALTER TABLE `expecificacoes` DISABLE KEYS */;
INSERT INTO `expecificacoes` (`id`,`descricao`) VALUES 
 (1,'Professor'),
 (2,'Aluno'),
 (3,'Ex-Aluno'),
 (4,'Comunidade');
/*!40000 ALTER TABLE `expecificacoes` ENABLE KEYS */;


--
-- Definition of table `fixas_membros`
--

DROP TABLE IF EXISTS `fixas_membros`;
CREATE TABLE `fixas_membros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) DEFAULT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `telefone` varchar(13) DEFAULT NULL,
  `dt_nasc` datetime DEFAULT NULL,
  `dt_inscr` datetime DEFAULT NULL,
  `indicacao` varchar(60) DEFAULT NULL,
  `id_exp` int(11) DEFAULT NULL,
  `id_membro` int(11) DEFAULT NULL,
  `id_curso` int(11) DEFAULT NULL,
  `modulo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_exp` (`id_exp`),
  KEY `id_membro` (`id_membro`),
  KEY `id_curso` (`id_curso`),
  CONSTRAINT `fixas_membros_ibfk_1` FOREIGN KEY (`id_exp`) REFERENCES `expecificacoes` (`id`),
  CONSTRAINT `fixas_membros_ibfk_2` FOREIGN KEY (`id_membro`) REFERENCES `membros` (`id`),
  CONSTRAINT `fixas_membros_ibfk_3` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fixas_membros`
--

/*!40000 ALTER TABLE `fixas_membros` DISABLE KEYS */;
INSERT INTO `fixas_membros` (`id`,`nome`,`endereco`,`telefone`,`dt_nasc`,`dt_inscr`,`indicacao`,`id_exp`,`id_membro`,`id_curso`,`modulo`) VALUES 
 (10,'z','z','(12)3664-5050','1992-05-05 00:00:00','2013-03-05 18:42:17','z',2,26,1,1),
 (11,'w','w','(15)1654-6465','1992-05-05 00:00:00','2013-03-05 18:54:37','w',1,1,1,5),
 (12,'Meu nome','l','(12)3664-5050','1995-12-18 00:00:00','2013-03-06 09:56:40','ll',1,27,1,3),
 (13,'p','p','(12)0541-4','1996-10-10 00:00:00','2013-03-06 12:17:26','p',2,28,1,5);
/*!40000 ALTER TABLE `fixas_membros` ENABLE KEYS */;


--
-- Definition of table `fixas_membros_areas`
--

DROP TABLE IF EXISTS `fixas_membros_areas`;
CREATE TABLE `fixas_membros_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_fixa` int(11) DEFAULT NULL,
  `id_area` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_fixa` (`id_fixa`),
  KEY `id_area` (`id_area`),
  CONSTRAINT `fixas_membros_areas_ibfk_1` FOREIGN KEY (`id_fixa`) REFERENCES `fixas_membros` (`id`),
  CONSTRAINT `fixas_membros_areas_ibfk_2` FOREIGN KEY (`id_area`) REFERENCES `areas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fixas_membros_areas`
--

/*!40000 ALTER TABLE `fixas_membros_areas` DISABLE KEYS */;
INSERT INTO `fixas_membros_areas` (`id`,`id_fixa`,`id_area`) VALUES 
 (26,10,1),
 (27,11,2),
 (28,11,4),
 (29,12,6),
 (30,13,1),
 (31,13,2),
 (32,13,4),
 (33,13,5),
 (34,13,6),
 (35,13,7),
 (36,13,8);
/*!40000 ALTER TABLE `fixas_membros_areas` ENABLE KEYS */;


--
-- Definition of table `gerentes`
--

DROP TABLE IF EXISTS `gerentes`;
CREATE TABLE `gerentes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `situacao` smallint(6) DEFAULT NULL,
  `senha` varchar(15) DEFAULT NULL,
  `id_membro` int(11) DEFAULT NULL,
  `id_grupo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_grupo` (`id_grupo`),
  KEY `id_membro` (`id_membro`),
  CONSTRAINT `gerentes_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`),
  CONSTRAINT `gerentes_ibfk_2` FOREIGN KEY (`id_membro`) REFERENCES `membros` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gerentes`
--

/*!40000 ALTER TABLE `gerentes` DISABLE KEYS */;
INSERT INTO `gerentes` (`id`,`situacao`,`senha`,`id_membro`,`id_grupo`) VALUES 
 (1,1,'123',1,1),
 (2,1,'ifspcampos',5,2),
 (3,1,'Denis270494?',7,3),
 (4,1,'teste',8,4),
 (5,1,'123',1,5),
 (6,1,'123456',1,6),
 (7,1,'nmnm',1,7),
 (8,1,'456',1,8);
/*!40000 ALTER TABLE `gerentes` ENABLE KEYS */;


--
-- Definition of table `grupos`
--

DROP TABLE IF EXISTS `grupos`;
CREATE TABLE `grupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grupos`
--

/*!40000 ALTER TABLE `grupos` DISABLE KEYS */;
INSERT INTO `grupos` (`id`,`nome`) VALUES 
 (1,'Fantastic Four'),
 (2,'Nerds'),
 (3,'DAHORA A VIDA'),
 (4,'ti'),
 (5,'Grupo do Nata'),
 (6,'Grupo de Estudos'),
 (7,'Novo Crupo'),
 (8,'tt');
/*!40000 ALTER TABLE `grupos` ENABLE KEYS */;


--
-- Definition of table `membro_grupos`
--

DROP TABLE IF EXISTS `membro_grupos`;
CREATE TABLE `membro_grupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `situacao` smallint(6) DEFAULT NULL,
  `id_membro` int(11) DEFAULT NULL,
  `id_grupo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_membro` (`id_membro`),
  KEY `id_grupo` (`id_grupo`),
  CONSTRAINT `membro_grupos_ibfk_1` FOREIGN KEY (`id_membro`) REFERENCES `membros` (`id`),
  CONSTRAINT `membro_grupos_ibfk_2` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `membro_grupos`
--

/*!40000 ALTER TABLE `membro_grupos` DISABLE KEYS */;
INSERT INTO `membro_grupos` (`id`,`situacao`,`id_membro`,`id_grupo`) VALUES 
 (1,1,1,1),
 (2,1,2,1),
 (3,1,3,1),
 (4,1,4,1),
 (5,1,5,2),
 (6,1,7,3),
 (7,1,8,4),
 (8,1,5,1),
 (9,1,6,1),
 (10,1,7,1),
 (11,1,8,1),
 (12,1,9,1),
 (13,1,10,1),
 (14,1,11,1),
 (15,1,12,1),
 (16,1,13,1),
 (17,1,14,1),
 (18,1,15,1),
 (19,1,16,1),
 (20,1,17,1),
 (21,1,18,1),
 (22,1,19,1),
 (23,1,20,1),
 (24,1,1,5),
 (25,1,2,5),
 (26,1,3,5),
 (27,1,4,5),
 (28,1,20,5),
 (29,1,6,5),
 (30,1,9,5),
 (31,1,27,1),
 (32,1,1,6),
 (33,1,1,7),
 (34,1,1,8),
 (35,1,6,8);
/*!40000 ALTER TABLE `membro_grupos` ENABLE KEYS */;


--
-- Definition of table `membros`
--

DROP TABLE IF EXISTS `membros`;
CREATE TABLE `membros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) DEFAULT NULL,
  `senha` varchar(15) DEFAULT NULL,
  `e_mail` varchar(60) DEFAULT NULL,
  `situacao` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `membros`
--

/*!40000 ALTER TABLE `membros` DISABLE KEYS */;
INSERT INTO `membros` (`id`,`nome`,`senha`,`e_mail`,`situacao`) VALUES 
 (1,'Nata Elias Rafael','naa123','nata.erafael@gmail.com',1),
 (2,'Susane','andre2','susi-chaves@hotmail.com',1),
 (3,'Fernanda Carneiro','210590','fernandalaboratorista06@gmail.com',1),
 (4,'Rafaela Faria','2004','rafacamposlan@hotmail.com',1),
 (5,'Victor','ifspcampos','victorcarlquist@gmail.com',1),
 (6,'Pedro','123456','bariotogames@gmail.com',1),
 (7,'Denis','Denis270494?','denisfournier1994@gmail.com',1),
 (8,'Marcelo Fernandes de Araujo','teste','marcelomaidden@gmail.com',1),
 (9,'Danilo Alves','senhateste','daniloa47@gmail.com',1),
 (10,'Kelvin Nachbar','kener19','kelvin_nachbar@hotmail.com',1),
 (11,'rodrigo','testerodrigo','led.rodrigo@yahoo.com.br',1),
 (12,'Guilherme A. de Macedo','apreummg','gaugustomacedo@gmail.com',1),
 (13,'Bruno','12341234','brunofcosouza@gmail.com',1),
 (14,'anderson','anonimos','malcanvader@hotmail.com',1),
 (15,'emer','123456','emerson12moreira@outlook.com',1),
 (16,'Cristiano','SENHA','cristiano.cesar.oliveira@gmail.com',1),
 (17,'Matheus Liberato','1234','matheusliberatosbs@gmail.com',1),
 (18,'Thiago Farias','123456','thiago.farias@outlook.com',1),
 (19,'thiago','8202682026','thiago.printf@gmail.com',1),
 (20,'Membro de Teste','123','membro@gmail.com',1),
 (21,'a','123','a@a.com',1),
 (22,'b','123','b@b.com',1),
 (23,'c','123','c@c.com',1),
 (24,'d','123','d@d.com',1),
 (25,'Nata','1234','nata@nata.com',1),
 (26,'z','123','z@z.com',1),
 (27,'l','lll','l@l.com',1),
 (28,'p','naa123','p@p.com',1);
/*!40000 ALTER TABLE `membros` ENABLE KEYS */;


--
-- Definition of table `membros_fotos`
--

DROP TABLE IF EXISTS `membros_fotos`;
CREATE TABLE `membros_fotos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` smallint(6) DEFAULT NULL,
  `spath` varchar(100) NOT NULL,
  `id_membro` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_membro` (`id_membro`),
  CONSTRAINT `membros_fotos_ibfk_1` FOREIGN KEY (`id_membro`) REFERENCES `membros` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `membros_fotos`
--

/*!40000 ALTER TABLE `membros_fotos` DISABLE KEYS */;
/*!40000 ALTER TABLE `membros_fotos` ENABLE KEYS */;


--
-- Definition of table `membros_projetos`
--

DROP TABLE IF EXISTS `membros_projetos`;
CREATE TABLE `membros_projetos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `situacao` smallint(6) DEFAULT NULL,
  `id_membro_grupo` int(11) DEFAULT NULL,
  `id_projeto` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_membro_grupo` (`id_membro_grupo`),
  KEY `id_projeto` (`id_projeto`),
  CONSTRAINT `membros_projetos_ibfk_1` FOREIGN KEY (`id_membro_grupo`) REFERENCES `membro_grupos` (`id`),
  CONSTRAINT `membros_projetos_ibfk_2` FOREIGN KEY (`id_projeto`) REFERENCES `projetos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `membros_projetos`
--

/*!40000 ALTER TABLE `membros_projetos` DISABLE KEYS */;
INSERT INTO `membros_projetos` (`id`,`situacao`,`id_membro_grupo`,`id_projeto`) VALUES 
 (1,1,1,1),
 (2,1,2,1),
 (3,1,3,1),
 (4,1,4,1),
 (5,1,8,1),
 (6,1,9,1),
 (7,1,10,1),
 (8,1,11,1),
 (9,1,12,1),
 (10,1,13,1),
 (11,1,14,1),
 (12,1,15,1),
 (13,1,16,1),
 (14,1,17,1),
 (15,1,18,1),
 (16,1,19,1),
 (17,1,20,1),
 (18,1,21,1),
 (19,1,22,1),
 (20,1,1,2),
 (21,1,25,3),
 (22,1,24,3),
 (23,1,35,4);
/*!40000 ALTER TABLE `membros_projetos` ENABLE KEYS */;


--
-- Definition of table `membros_tarefas`
--

DROP TABLE IF EXISTS `membros_tarefas`;
CREATE TABLE `membros_tarefas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_membro_projeto` int(11) DEFAULT NULL,
  `id_tarefa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_membro_projeto` (`id_membro_projeto`),
  KEY `id_tarefa` (`id_tarefa`),
  CONSTRAINT `membros_tarefas_ibfk_1` FOREIGN KEY (`id_membro_projeto`) REFERENCES `membros_projetos` (`id`),
  CONSTRAINT `membros_tarefas_ibfk_2` FOREIGN KEY (`id_tarefa`) REFERENCES `tarefas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `membros_tarefas`
--

/*!40000 ALTER TABLE `membros_tarefas` DISABLE KEYS */;
INSERT INTO `membros_tarefas` (`id`,`id_membro_projeto`,`id_tarefa`) VALUES 
 (1,3,1),
 (2,1,2),
 (3,1,3),
 (4,2,4),
 (5,4,4),
 (6,1,4),
 (7,11,3),
 (8,20,5),
 (9,1,1),
 (10,21,6),
 (11,21,6),
 (12,22,6),
 (13,23,7);
/*!40000 ALTER TABLE `membros_tarefas` ENABLE KEYS */;


--
-- Definition of table `projetos`
--

DROP TABLE IF EXISTS `projetos`;
CREATE TABLE `projetos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) DEFAULT NULL,
  `situacao` smallint(6) DEFAULT NULL,
  `id_grupo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_grupo` (`id_grupo`),
  CONSTRAINT `projetos_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projetos`
--

/*!40000 ALTER TABLE `projetos` DISABLE KEYS */;
INSERT INTO `projetos` (`id`,`nome`,`situacao`,`id_grupo`) VALUES 
 (1,'Trabalho de Redes',1,1),
 (2,'Projeto AS1',1,1),
 (3,'Projeto1',1,5),
 (4,'pj-01',1,8);
/*!40000 ALTER TABLE `projetos` ENABLE KEYS */;


--
-- Definition of table `sys_tabelas`
--

DROP TABLE IF EXISTS `sys_tabelas`;
CREATE TABLE `sys_tabelas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) DEFAULT NULL,
  `alias` varchar(30) DEFAULT NULL,
  `qry` varchar(900) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_tabelas`
--

/*!40000 ALTER TABLE `sys_tabelas` DISABLE KEYS */;
INSERT INTO `sys_tabelas` (`id`,`nome`,`alias`,`qry`) VALUES 
 (1,'membros','Membros','FROM membros m INNER JOIN fixas_membros fm  ON m.id = fm.id_membro INNER JOIN expecificacoes ex  ON fm.id_exp = ex.id INNER JOIN cursos c ON fm.id_curso  = c.id LIMIT 20;'),
 (2,'tarefas','Tarefas','FROM\r\ntarefas t\r\nINNER JOIN membros_tarefas  mt ON t.id = mt.id_tarefa\r\nINNER JOIN membros_projetos mp ON mt.id_membro_projeto = mp.id\r\nINNER JOIN membro_grupos mg ON mp.id_membro_grupo = mg.id\r\nINNER JOIN membros m ON mg.id_membro = m.id\r\nINNER JOIN projetos p ON mp.id_projeto = p.id;');
/*!40000 ALTER TABLE `sys_tabelas` ENABLE KEYS */;


--
-- Definition of table `sys_tbs_ginga`
--

DROP TABLE IF EXISTS `sys_tbs_ginga`;
CREATE TABLE `sys_tbs_ginga` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campo` varchar(900) DEFAULT NULL,
  `alias` varchar(30) DEFAULT NULL,
  `caption` varchar(30) DEFAULT NULL,
  `st_campo` smallint(6) DEFAULT NULL,
  `id_tabela` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tabela` (`id_tabela`),
  CONSTRAINT `sys_tbs_ginga_ibfk_1` FOREIGN KEY (`id_tabela`) REFERENCES `sys_tabelas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_tbs_ginga`
--

/*!40000 ALTER TABLE `sys_tbs_ginga` DISABLE KEYS */;
INSERT INTO `sys_tbs_ginga` (`id`,`campo`,`alias`,`caption`,`st_campo`,`id_tabela`) VALUES 
 (1,'fm.nome','nome','Nome',1,1),
 (2,'fm.endereco','endereco','Endereço',2,1),
 (3,'m.e_mail','e_mail','E-mail',1,1),
 (4,'fm.telefone','telefone','Telefone',1,1),
 (5,'DATE_FORMAT(fm.dt_nasc, \'%d-%m-%Y\') AS dt_nasc','dt_nasc','Data de Nascimento',2,1),
 (6,'ex.descricao AS expecifacacao','expecifacacao','Expecificação',2,1),
 (7,'fm.indicacao','indicacao','Indicação',2,1),
 (8,'DATE_FORMAT(fm.dt_inscr, \'%d-%m-%Y\') AS dt_inscr','dt_inscr','Data Inscrição',2,1),
 (9,'c.descricao AS curso','curso','Curso',2,1),
 (10,'fm.modulo','modulo','Módulo',2,1),
 (11,'(SELECT\r\n			group_concat(descricao separator \', \')\r\n		 FROM\r\n      fixas_membros_areas fma\r\n      INNER JOIN areas a ON fma.id_area = a.id\r\n     WHERE fma.id_fixa = fm.id) as areas','areas','Áreas',2,1),
 (12,'t.nome','nome','Tarefa',1,2),
 (13,'t.descricao','descricao','Descrição',1,2),
 (14,'GROUP_CONCAT(m.nome SEPARATOR \', \') as membros','membros','Membros em tarefa',1,2),
 (15,'p.nome as projeto','projeto','Projeto',1,2),
 (16,'(SELECT CASE ct.estado\r\nWHEN 1 THEN \'Criada\' WHEN 2 THEN \'Sendo Feita\' WHEN 3 THEN \'Concluída\' END\r\nFROM\r\ncontrole_tarefas ct\r\nWHERE ct.id_tarefa = t.id\r\nORDER BY id DESC LIMIT 1) AS situacao','situacao','Estado da tarefa',1,2);
/*!40000 ALTER TABLE `sys_tbs_ginga` ENABLE KEYS */;


--
-- Definition of table `tarefas`
--

DROP TABLE IF EXISTS `tarefas`;
CREATE TABLE `tarefas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) DEFAULT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `id_projeto` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_projeto` (`id_projeto`),
  CONSTRAINT `tarefas_ibfk_1` FOREIGN KEY (`id_projeto`) REFERENCES `projetos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tarefas`
--

/*!40000 ALTER TABLE `tarefas` DISABLE KEYS */;
INSERT INTO `tarefas` (`id`,`nome`,`descricao`,`id_projeto`) VALUES 
 (1,'Imprimir o Resumo ','Fernanda imprima o resumo por favor!',1),
 (2,'Construir o GINGA','Construir um prototipo do ginga e com ele aprender os conhecimentos necessÃ¡rios.',1),
 (3,'Tarefa 2 teste','teste',1),
 (4,'Revisar o Trabalho Escrito','Por favor revisem a parte teorica do trabalho.',1),
 (5,'aa','aa',2),
 (6,'Tarefa 01','wqeqwe',3),
 (7,'tf1','45',4),
 (8,'tf2','0',4);
/*!40000 ALTER TABLE `tarefas` ENABLE KEYS */;


--
-- Definition of table `tarefas_arquivos`
--

DROP TABLE IF EXISTS `tarefas_arquivos`;
CREATE TABLE `tarefas_arquivos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spath` varchar(100) NOT NULL,
  `id_tarefa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tarefa` (`id_tarefa`),
  CONSTRAINT `tarefas_arquivos_ibfk_1` FOREIGN KEY (`id_tarefa`) REFERENCES `tarefas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tarefas_arquivos`
--

/*!40000 ALTER TABLE `tarefas_arquivos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tarefas_arquivos` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
