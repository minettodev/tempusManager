USE `db`;

DROP TABLE
  IF EXISTS `users`;

DROP TABLE
  IF EXISTS `tarefas`;

DROP TABLE
  IF EXISTS `horarios`;

CREATE TABLE
  `users` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
  );

CREATE TABLE
  `tarefas` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(200) NOT NULL,
    `categoria` VARCHAR(200),
    `data` DATE NOT NULL,
    primary key(id)
  );

CREATE TABLE
  `agendas` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(200) NOT NULL,
    `categoria` VARCHAR(200),
    `data` DATE NOT NULL,
    primary key(id)
  );

CREATE TABLE
  `horarios` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `dia` VARCHAR(20) NOT NULL,
    `task` VARCHAR(200) NOT NULL,
    `tempo` TIME NOT NULL,
    primary key(id)
  );