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
-----------------------------Cadastro de atores-------------------------------            
  

CREATE DATABASE IF NOT EXISTS CADASTRO;

USE CADASTRO;

drop USER if EXISTS 'pedro'@'localhost';

CREATE USER 'pedro'@'localhost' IDENTIFIED BY '123456789';

GRANT ALL PRIVILEGES ON CADASTRO.* TO 'pedro'@'localhost';

drop TABLE if EXISTS Atuacoes;

CREATE TABLE Atuacoes (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    AtorID INT,
    FilmeID INT,
    FOREIGN KEY (AtorID) REFERENCES Atores(ID),
    FOREIGN KEY (FilmeID) REFERENCES Filmes(ID)
);
   --------------------------atuacoes---------------------------------------------


-- Cria o banco de dados 'cadastro'
CREATE DATABASE IF NOT EXISTS cadastro;

-- Seleciona o banco de dados 'cadastro'
USE cadastro;

drop USER if EXISTS 'alvaro'@'localhost';

CREATE USER 'alvaro'@'localhost' IDENTIFIED BY '12345';

GRANT ALL PRIVILEGES ON CADASTRO.* TO 'alvaro'@'localhost';

drop TABLE if EXISTS filmes;


-- Cria a tabela 'Filmes'
CREATE TABLE IF NOT EXISTS Filmes (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Titulo VARCHAR(255) NOT NULL,
    AnoLancamento YEAR NOT NULL,
    Diretor VARCHAR(255),
    Sinopse TEXT
);
------------------------------cadastro de filmes--------------------------------


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
----------------------------------categoria--------------------------------------


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
-------------------------------conexao--------------------------------------------




CREATE DATABASE IF NOT EXISTS CADASTRO;

USE CADASTRO;

drop USER if EXISTS 'vitor'@'localhost';

CREATE USER 'vitor'@'localhost' IDENTIFIED BY '1234567';

GRANT ALL PRIVILEGES ON CADASTRO.* TO 'vitor'@'localhost';

drop TABLE if EXISTS filmescategorias;

CREATE TABLE filmescategorias (
    FilmeID INT,
    CategoriaID INT,
    PRIMARY KEY (FilmeID, CategoriaID),
    FOREIGN KEY (FilmeID) REFERENCES Filmes(ID),
    FOREIGN KEY (CategoriaID) REFERENCES Categorias(ID)
);
---------------------------------vincular filme e categoria


