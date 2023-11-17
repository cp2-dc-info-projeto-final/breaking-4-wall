-- Cria o banco de dados 'cadastro'
CREATE DATABASE IF NOT EXISTS cadastro;

-- Seleciona o banco de dados 'cadastro'
USE cadastro;

drop USER if EXISTS 'alvaro'@'localhost';

CREATE USER 'alvaro'@'localhost' IDENTIFIED BY '12345';

GRANT ALL PRIVILEGES ON CADASTRO.* TO 'alvaro'@'localhost';

drop TABLE if EXISTS cadastrados;


-- Cria a tabela 'Filmes'
CREATE TABLE IF NOT EXISTS Filmes (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Titulo VARCHAR(255) NOT NULL,
    AnoLancamento YEAR NOT NULL,
    Diretor VARCHAR(255),
    Sinopse TEXT
);


