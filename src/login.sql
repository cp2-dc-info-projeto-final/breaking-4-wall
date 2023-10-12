USE CADASTRO; -- Certifique-se de usar o banco de dados correto

-- Crie uma tabela para armazenar informações de login
CREATE TABLE login (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL
);
