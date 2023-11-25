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
