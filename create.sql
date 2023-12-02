CREATE DATABASE IF NOT EXISTS CADASTRO;

USE CADASTRO;

drop USER if EXISTS 'cadastrados'@'localhost';

CREATE USER 'cadastrados'@'localhost' IDENTIFIED BY '123';

GRANT ALL PRIVILEGES ON CADASTRO.* TO 'cadastrados'@'localhost';

drop TABLE if EXISTS Atores;

CREATE TABLE Atores (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(255) NOT NULL,
    DataNascimento DATE,
    Nacionalidade VARCHAR(50),
    Genero VARCHAR(20),
    Biografia TEXT
); 
  

CREATE DATABASE IF NOT EXISTS CADASTRO;

USE CADASTRO;

drop USER if EXISTS 'cadastrados'@'localhost';

CREATE USER 'cadastrados'@'localhost' IDENTIFIED BY '123';

GRANT ALL PRIVILEGES ON CADASTRO.* TO 'cadastrados'@'localhost';

drop TABLE if EXISTS Atuacoes;

CREATE TABLE Atuacoes (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    AtorID INT,
    FilmeID INT,
    FOREIGN KEY (AtorID) REFERENCES Atores(ID),
    FOREIGN KEY (FilmeID) REFERENCES Filmes(ID)
);


CREATE DATABASE IF NOT EXISTS cadastro;

USE cadastro;

drop USER if EXISTS 'cadastrados'@'localhost';

CREATE USER 'cadastrados'@'localhost' IDENTIFIED BY '123';

GRANT ALL PRIVILEGES ON CADASTRO.* TO 'cadastrados'@'localhost';

drop TABLE if EXISTS filmes;


CREATE TABLE IF NOT EXISTS Filmes (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Titulo VARCHAR(255) NOT NULL,
    AnoLancamento YEAR NOT NULL,
    Diretor VARCHAR(255),
    Sinopse TEXT
);


CREATE DATABASE IF NOT EXISTS CADASTRO;

USE CADASTRO;

drop USER if EXISTS 'cadastrados'@'localhost';

CREATE USER 'cadastrados'@'localhost' IDENTIFIED BY '123';

GRANT ALL PRIVILEGES ON CADASTRO.* TO 'cadastrados'@'localhost';

drop TABLE if EXISTS categorias;

CREATE TABLE Categorias (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(50) NOT NULL
);


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

ALTER TABLE cadastrados
ADD COLUMN is_admin BOOLEAN NOT NULL DEFAULT FALSE;

ALTER TABLE cadastrados
MODIFY COLUMN is_admin TINYINT NOT NULL DEFAULT 0;




CREATE DATABASE IF NOT EXISTS CADASTRO;

USE CADASTRO;

drop USER if EXISTS 'cadastrados'@'localhost';

CREATE USER 'cadastrados'@'localhost' IDENTIFIED BY '123';

GRANT ALL PRIVILEGES ON CADASTRO.* TO 'cadastrados'@'localhost';

drop TABLE if EXISTS filmescategorias;

CREATE TABLE filmescategorias (
    FilmeID INT,
    CategoriaID INT,
    PRIMARY KEY (FilmeID, CategoriaID),
    FOREIGN KEY (FilmeID) REFERENCES Filmes(ID),
    FOREIGN KEY (CategoriaID) REFERENCES Categorias(ID)
);


CREATE DATABASE IF NOT EXISTS CADASTRO;

USE CADASTRO;

drop USER if EXISTS 'cadastrados'@'localhost';

CREATE USER 'cadastrados'@'localhost' IDENTIFIED BY '123';

GRANT ALL PRIVILEGES ON CADASTRO.* TO 'cadastrados'@'localhost';

drop TABLE if EXISTS Administradores;


CREATE TABLE Administradores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL
);

ALTER TABLE Administradores ADD COLUMN is_admin BOOLEAN NOT NULL DEFAULT FALSE;

INSERT INTO Administradores (usuario, email, senha)
VALUES ('nomeusuario', 'email@dominio.com', 'senhacriptografada');

SELECT * FROM Administradores
WHERE usuario = 'nomeusuario' AND senha = 'senhacriptografada';

UPDATE Administradores
SET senha = 'novasenhacriptografada'
WHERE usuario = 'nomeusuario';

DELETE FROM Administradores
WHERE usuario = 'nomeusuario';

-- Cria o banco de dados 'cadastro'
CREATE DATABASE IF NOT EXISTS CADASTRO;

USE CADASTRO;

drop USER if EXISTS 'cadastrados'@'localhost';

CREATE USER 'cadastrados'@'localhost' IDENTIFIED BY '123';

GRANT ALL PRIVILEGES ON CADASTRO.* TO 'cadastrados'@'localhost';

drop TABLE if EXISTS comentarios;

CREATE TABLE IF NOT EXISTS Comentarios (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    FilmeId INT,
    UsuarioId INT,
    Comentario TEXT,
    DataHora DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (FilmeID) REFERENCES Filmes(ID),
    FOREIGN KEY (UsuarioID) REFERENCES cadastrados(id)
);

ALTER TABLE comentarios
ADD COLUMN usuario_id INT NULL,
ADD FOREIGN KEY (usuario_id) REFERENCES cadastrados(id);

ALTER TABLE comentarios
ADD COLUMN filme_id INT,
ADD FOREIGN KEY (filme_id) REFERENCES Filmes(ID);



