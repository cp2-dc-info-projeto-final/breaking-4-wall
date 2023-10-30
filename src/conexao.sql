CREATE DATABASE IF NOT EXISTS CADASTRO;

USE CADASTRO;

drop USER if EXISTS 'cadastrados'@'localhost';

CREATE USER 'cadastrados'@'localhost' IDENTIFIED BY '123';

GRANT ALL PRIVILEGES ON CADASTRO.* TO 'cadastrados'@'localhost';

drop TABLE if EXISTS cadastrados;

CREATE TABLE cadastrados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL
);
