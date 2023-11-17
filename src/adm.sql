CREATE DATABASE IF NOT EXISTS CADASTRO_ADMIN;

USE CADASTRO_ADMIN;

DROP USER IF EXISTS 'administrador'@'localhost';

CREATE USER 'administrador'@'localhost' IDENTIFIED BY 'ney123'; -- Substitua '12345' por uma senha forte e segura

GRANT ALL PRIVILEGES ON CADASTRO_ADMIN.* TO 'administrador'@'localhost';

FLUSH PRIVILEGES; -- Não se esqueça de executar FLUSH PRIVILEGES após conceder permissões

DROP TABLE IF EXISTS administradores;

CREATE TABLE administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE, -- Adicionado UNIQUE para garantir que os e-mails sejam únicos na tabela
    senha VARCHAR(255) NOT NULL -- Certifique-se de armazenar uma hash da senha, não a senha em texto puro
);
