-- Cria o banco de dados 'cadastro'
CREATE DATABASE IF NOT EXISTS cadastro;

-- Seleciona o banco de dados 'cadastro'
USE cadastro;

-- Cria a tabela 'Filmes'
CREATE TABLE IF NOT EXISTS Filmes (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Titulo VARCHAR(255) NOT NULL,
    AnoLancamento YEAR NOT NULL,
    Diretor VARCHAR(255),
    Sinopse TEXT
);

-- Cria um novo usuário com permissões limitadas
CREATE USER IF NOT EXISTS '[alvaro]'@'localhost' IDENTIFIED BY '[12345]';

-- Concede permissões ao usuário para o banco de dados 'cadastro'
GRANT SELECT, INSERT, UPDATE, DELETE ON cadastro.* TO '[alvaro]'@'localhost';

-- Aplica as mudanças de permissões
FLUSH PRIVILEGES;

SET PASSWORD FOR 'alvaro'@'localhost' = PASSWORD('12345');

ALTER USER 'alvaro'@'localhost' IDENTIFIED WITH mysql_native_password BY '12345';

