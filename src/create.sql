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
  

drop TABLE if EXISTS Atuacoes;

CREATE TABLE Atuacoes (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    AtorID INT,
    FilmeID INT,
    FOREIGN KEY (AtorID) REFERENCES Atores(ID),
    FOREIGN KEY (FilmeID) REFERENCES Filmes(ID)
);



drop TABLE if EXISTS filmes;


CREATE TABLE IF NOT EXISTS Filmes (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Titulo VARCHAR(255) NOT NULL,
    AnoLancamento YEAR NOT NULL,
    Diretor VARCHAR(255),
    Sinopse TEXT
);

ALTER TABLE Filmes
ADD COLUMN AvaliacaoImdb DECIMAL(3,1) DEFAULT NULL;


drop TABLE if EXISTS categorias;

CREATE TABLE Categorias (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(50) NOT NULL
);


drop TABLE if EXISTS cadastrados;

CREATE TABLE cadastrados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL
); 


drop TABLE if EXISTS filmescategorias;

CREATE TABLE filmescategorias (
    FilmeID INT,
    CategoriaID INT,
    PRIMARY KEY (FilmeID, CategoriaID),
    FOREIGN KEY (FilmeID) REFERENCES Filmes(ID),
    FOREIGN KEY (CategoriaID) REFERENCES Categorias(ID)
);


drop TABLE if EXISTS Administradores;


CREATE TABLE Administradores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL
);

INSERT INTO Administradores (usuario, email, senha)
VALUES ('nomeusuario', 'email@dominio.com', 'senhacriptografada');

SELECT * FROM Administradores
WHERE usuario = 'nomeusuario' AND senha = 'senhacriptografada';

UPDATE Administradores
SET senha = 'novasenhacriptografada'
WHERE usuario = 'nomeusuario';

DELETE FROM Administradores
WHERE usuario = 'nomeusuario';

ALTER TABLE Administradores ADD COLUMN tipo VARCHAR(20) NOT NULL DEFAULT 'Admin';

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
ADD COLUMN filme_id INT,
ADD COLUMN nome_usuario VARCHAR(255),
ADD FOREIGN KEY (usuario_id) REFERENCES cadastrados(id),
ADD FOREIGN KEY (filme_id) REFERENCES Filmes(ID);


-- Inserir dados na tabela Atores
INSERT INTO Atores (Nome, DataNascimento, Nacionalidade, Genero, Biografia) VALUES
  ('Oscar Isaac', '1979-03-15', 'Guatemala', 'Masculino', 'Oscar Isaac Hernández Estrada é um ator, músico e produtor guatemalteco. É mais conhecido por ter protagonizado o filme Inside Llewyn Davis e por papéis como o de Poe Dameron na saga Star Wars, Nathan em Ex-Machina e o Duque Leto Atreides em Dune.'),
  ('Keanu Reeves', '1964-05-20', 'Americano', 'Masculino', 'Keanu Charles Reeves é um ator naturalizado canadense. Nascido em Beirute e criado em Toronto, Reeves começou a atuar em produções teatrais e em filmes de televisão antes de fazer sua estreia no cinema em Youngblood.'),
  ('Tobin Bell', '1958-09-10', 'Americano', 'Masculino', 'Joseph Henry Tobin Jr., conhecido profissionalmente como Tobin Bell, é um ator norte-americano, mais conhecido por sua interpretação de John Kramer / Jigsaw, o personagem central da franquia Saw'),
  ('Cillian Murphy', '1978-03-25', 'irlandês', 'Masculino', 'Cillian Murphy é um ator e músico irlandês de teatro, cinema e televisão. Tendo iniciado sua carreira artística como vocalista, pianista e compositor de uma banda de rock, Murphy recusou um contrato com uma gravadora no final dos anos 1990 e começou a atuar no palco, em curtas-metragens e filmes independentes'),
  ('Roy Scheider', '1932-11-05', 'Americano', 'Masculino', 'Roy Richard Scheider foi um ator estadunidense. Estudou no Franklin & Marshall College, em Lancaster, na Pensilvânia. Sua carreira no cinema começou em 1964, no filme The Curse of the Living Corpse. A seguir estrelou Star!, Paper Lion, Stiletto e Puzzle of a Downfall Child.'),
  ('Robert Downey Jr.', '1977-08-18', 'Americano', 'Masculino', 'Robert John Downey Jr. é um ator, cantor, compositor e pianista americano. Estreou como ator em 1970 aos 5 anos, no filme Pound, dirigido por seu pai, Robert Downey, Sr., e desde então tem atuado constantemente em trabalhos para televisão, cinema e ópera'),
  ('Linda Blair', '1963-02-28', 'Americana', 'Feminino', 'Linda Denise Blair é uma atriz norte-americana, mais conhecida por interpretar Regan McNeil no filme O Exorcista');

-- Inserir dados na tabela Filmes
INSERT INTO Filmes (Titulo, AnoLancamento, Diretor, Sinopse) VALUES
  ('Homem-Aranha: Através do Aranhaverso', 2023, 'Joaquim Dos Santos', 'Depois de se reunir com Gwen Stacy, Homem-Aranha é jogado no multiverso. Lá, o super-herói aracnídeo encontra uma numerosa equipe encarregada de proteger sua própria existência.'),
  ('John Wick 4: Baba Yaga', 2023, 'Chad Stahelski', 'O ex-assassino de aluguel John Wick é procurado pelo mundo todo e a recompensa por sua captura aumenta cada vez mais'),
  ('Jogos Mortais x', 2023, 'Kevin Greutert', 'Esperando por uma cura milagrosa, o adoecido John Kramer viaja para o México para um procedimento médico arriscado e experimental. Mas ao chegar no destino, se depara com um ambiente macabro, e descobre que toda a operação é uma farsa para enganar pessoas já vulneráveis. Agora armado com um novo propósito, o infame serial killer usa armadilhas insanas e engenhosas para virar o jogo contra os vigaristas, relembrando o motivo de ser conhecido como o terrível vilão Jigsaw.'),
  ('Oppenheimer', 2023, 'Christopher Nolan', 'O físico J. Robert Oppenheimer trabalha com uma equipe de cientistas durante o Projeto Manhattan, levando ao desenvolvimento da bomba atômica.'),
  ('Tubarão', 1975, 'Steven Spielberg', 'Um terrível ataque a banhistas é o sinal de que a praia da pequena cidade de Amity, na Nova Inglaterra, virou refeitório de um gigantesco tubarão branco. O chefe de polícia Martin Brody quer fechar as praias, mas o prefeito Larry Vaughn não permite, com medo de que o faturamento com a receita dos turistas deixe a cidade sem recursos. O cientista Matt Hooper e o pescador Quint se oferecem para ajudar Brody a capturar e matar a fera, mas a missão vai ser mais complicada do que eles imaginavam.'),
  ('Vingadores: Ultimato', 2019, 'Joe Russo', 'Após Thanos eliminar metade das criaturas vivas, os Vingadores têm de lidar com a perda de amigos e entes queridos. Com Tony Stark vagando perdido no espaço sem água e comida, Steve Rogers e Natasha Romanov lideram a resistência contra o titã louco.'),
  ('O Exorcista', 1973, ' William Friedkin', 'Uma atriz vai gradativamente tomando consciência de que a sua filha de doze anos está tendo um comportamento completamente assustador. Deste modo, ela pede ajuda a um padre, que também é um psiquiatra, e este chega a conclusão de que a garota está possuída pelo demônio. Ele solicita então a ajuda de um segundo sacerdote, especialista em exorcismo, para tentar livrar a menina desta terrível possessão.');

-- Inserir dados na tabela Atuacoes
INSERT INTO Atuacoes (AtorID, FilmeID) VALUES
  (1, 1),
  (2, 2),
  (3, 3),
  (4, 4),
  (5, 5),
  (6, 6),
  (7, 7);

-- Inserir dados na tabela Categorias
INSERT INTO Categorias (Nome) VALUES
  ('Ação'),
  ('Suspense'),
  ('Animação'),
  ('Ficção Científica'),
  ('Terror'),
  ('Biografico');

-- Inserir dados na tabela filmescategorias
INSERT INTO filmescategorias (FilmeID, CategoriaID) VALUES
  (1, 3),
  (2, 1),
  (3, 5),
  (4, 6),
  (5, 2),
  (6, 4),
  (7, 5);


-- Inserir avaliações para os filmes
UPDATE Filmes SET AvaliacaoImdb = 8.6 WHERE Titulo = 'Homem-Aranha: Através do Aranhaverso';
UPDATE Filmes SET AvaliacaoImdb = 7.7 WHERE Titulo = 'John Wick 4: Baba Yaga';
UPDATE Filmes SET AvaliacaoImdb = 6.6 WHERE Titulo = 'Jogos Mortais x';
UPDATE Filmes SET AvaliacaoImdb = 8.4 WHERE Titulo = 'Oppenheimer';
UPDATE Filmes SET AvaliacaoImdb = 8.1 WHERE Titulo = 'Tubarão';
UPDATE Filmes SET AvaliacaoImdb = 8.4 WHERE Titulo = 'Vingadores: Ultimato';
UPDATE Filmes SET AvaliacaoImdb = 8.6 WHERE Titulo = 'O Exorcista';


-- ADM que ja vem cadastro 
INSERT INTO Administradores (usuario, email, senha)
VALUES ('br4wadm tcc', 'breakingwall4@gmail.com', '$2y$10$VjzjZqi3s1IlpoZuqrVBVOz2iAfFO76N68eWDebY5/Y9Awjjh1n2W');
