CREATE DATABASE IF NOT EXISTS CADASTRO;

USE CADASTRO;

drop USER if EXISTS 'categorais'@'localhost';

CREATE USER 'categorais'@'localhost' IDENTIFIED BY '123456';

GRANT ALL PRIVILEGES ON CADASTRO.* TO 'categorais'@'localhost';

drop TABLE if EXISTS categorias;

CREATE TABLE Categorias (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(50) NOT NULL
);
