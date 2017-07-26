<?php

	class db{

		// Properties
		private $dbhost = "localhost";
		private $dbuser = "root";
		private $dbpass = "";
		private $dbname = "crearp";


        // Connect
        public function connect(){
            $mysql_connect_str = "mysql:host=$this->dbhost;dbname=$this->dbname";
            $dbConnection = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbConnection;
        }

	}

/*
SQL DATABASE

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `is_admin` boolean NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    primary key (id)
 ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


CREATE TABLE `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fk_teacher` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
    foreign key (fk_teacher) references user(id),
    primary key (id)
 ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


CREATE TABLE `inscription` (
  `fk_user` int(11) NOT NULL,
  `fk_course` int(11) NOT NULL,
    foreign key (fk_user) references user(id),
    foreign key (fk_course) references course(id),
    primary key (fk_user, fk_course)
 ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci


INSERT INTO `crearp`.`user` (`id`, `is_admin`, `name`) VALUES ('0', 'true', 'Administrador');
INSERT INTO `crearp`.`user` (`id`, `is_admin`, `name`) VALUES ('1', 'false', 'Usuario 1');
INSERT INTO `crearp`.`user` (`id`, `is_admin`, `name`) VALUES ('2', 'false', 'Usuario 2');
INSERT INTO `crearp`.`user` (`id`, `is_admin`, `name`) VALUES ('3', 'false', 'Usuario 3');
INSERT INTO `crearp`.`user` (`id`, `is_admin`, `name`) VALUES ('4', 'false', 'Usuario 4');
INSERT INTO `crearp`.`user` (`id`, `is_admin`, `name`) VALUES ('5', 'false', 'Usuario 5');
INSERT INTO `crearp`.`user` (`id`, `is_admin`, `name`) VALUES ('100', 'false', 'Profesor 0');
INSERT INTO `crearp`.`user` (`id`, `is_admin`, `name`) VALUES ('101', 'false', 'Profesor 1');
INSERT INTO `crearp`.`user` (`id`, `is_admin`, `name`) VALUES ('102', 'false', 'Profesor 2');
INSERT INTO `crearp`.`user` (`id`, `is_admin`, `name`) VALUES ('103', 'false', 'Profesor 3');

INSERT INTO `crearp`.`course` (`id`, `name`, `description`, `fk_teacher`, `capacity`) VALUES (1, 'Ingles', 'Idiomas', '100', '5');
INSERT INTO `crearp`.`course` (`id`, `name`, `description`, `fk_teacher`, `capacity`) VALUES (2, 'Español', 'Idiomas', '101', '8');
INSERT INTO `crearp`.`course` (`id`, `name`, `description`, `fk_teacher`, `capacity`) VALUES (3, 'Portugues', 'Idiomas', '102', '2');
INSERT INTO `crearp`.`course` (`id`, `name`, `description`, `fk_teacher`, `capacity`) VALUES (4, 'Ruso', 'Idiomas', '102', '10');
INSERT INTO `crearp`.`course` (`id`, `name`, `description`, `fk_teacher`, `capacity`) VALUES (5, 'Italiano', 'Idiomas', '103', '5');
INSERT INTO `crearp`.`course` (`id`, `name`, `description`, `fk_teacher`, `capacity`) VALUES (6, 'Frances', 'Idiomas', '103', '3');
INSERT INTO `crearp`.`course` (`id`, `name`, `description`, `fk_teacher`, `capacity`) VALUES (7, 'Arabe', 'Idiomas', '102', '15');
INSERT INTO `crearp`.`course` (`id`, `name`, `description`, `fk_teacher`, `capacity`) VALUES (8, 'Latin', 'Idiomas', '101', '11');
INSERT INTO `crearp`.`course` (`id`, `name`, `description`, `fk_teacher`, `capacity`) VALUES (9, 'Hungaro', 'Idiomas', '100', '8');
INSERT INTO `crearp`.`course` (`id`, `name`, `description`, `fk_teacher`, `capacity`) VALUES (10, 'Catalan', 'Idiomas', '100', '4');

INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('1', '1');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('1', '2');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('1', '3');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('1', '4');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('1', '5');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('1', '6');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('1', '7');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('1', '8');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('1', '9');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('1', '10');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('3', '1');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('2', '2');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('3', '3');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('2', '4');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('3', '5');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('2', '6');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('3', '7');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('2', '8');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('3', '9');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('2', '10');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('4', '4');
INSERT INTO `crearp`.`inscription` (`fk_user`, `fk_course`) VALUES ('4', '8');


*/


?>