CREATE DATABASE IF NOT EXISTS CADASTRO;

USE CADASTRO;

drop USER if EXISTS 'paulo'@'localhost';

CREATE USER 'paulo'@'localhost' IDENTIFIED BY '12345678';

GRANT ALL PRIVILEGES ON CADASTRO.* TO 'paulo'@'localhost';

drop TABLE if EXISTS Atores;

CREATE TABLE Atores (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(255) NOT NULL,
    DataNascimento DATE,
    Nacionalidade VARCHAR(50),
    Genero VARCHAR(20),
    Biografia TEXT
);
