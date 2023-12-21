<?php
session_start(); // Inicia a sessão para verificar o login do usuário

// Configuração das variáveis de conexão com o banco de dados
$servername = "localhost";
$username = "cadastrados";
$password = "123";
$dbname = "CADASTRO";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$filmeId = isset($_GET['id']) ? $_GET['id'] : die('ID do filme não foi especificado.');

$filmeId = isset($_GET['id']) ? $_GET['id'] : null;
if (empty($filmeId)) {
    die('ID do filme não foi especificado.');
}

// Consulta para obter detalhes do filme
$stmt_filme = $conn->prepare("SELECT Titulo, AnoLancamento, Diretor, Sinopse FROM Filmes WHERE ID = ?");
$stmt_filme->bind_param("i", $filmeId);

// Verifica se a preparação da declaração foi bem-sucedida
if ($stmt_filme === false) {
    die('Erro na preparação da consulta do filme: ' . $conn->error);
}

$stmt_filme->execute();
$result_filme = $stmt_filme->get_result();
if ($result_filme->num_rows == 0) {
    die('Nenhum filme encontrado com o ID especificado.');
}

$filme = $result_filme->fetch_assoc();

// Consulta para buscar os atores do filme
$stmt_atores = $conn->prepare("SELECT a.Nome FROM Atores a JOIN Atuacoes at ON a.ID = at.AtorID WHERE at.FilmeID = ?");
$stmt_atores->bind_param("i", $filmeId);
$stmt_atores->execute();
$result_atores = $stmt_atores->get_result();
$atores = $result_atores->fetch_all(MYSQLI_ASSOC);

// Consulta para buscar as categorias do filme
$stmt_categorias = $conn->prepare("SELECT c.Nome FROM Categorias c JOIN filmescategorias fc ON c.ID = fc.CategoriaID WHERE fc.FilmeID = ?");
$stmt_categorias->bind_param("i", $filmeId);
$stmt_categorias->execute();
$result_categorias = $stmt_categorias->get_result();
$categorias = $result_categorias->fetch_all(MYSQLI_ASSOC);

// Consulta para buscar os comentários do filme com nome do usuário
$stmt_comentarios = $conn->prepare("SELECT c.comentario, u.nome AS nome_usuario FROM comentarios c JOIN cadastrados u ON c.usuario_id = u.ID WHERE c.filme_id = ?");
$stmt_comentarios->bind_param("i", $filmeId);

// Verifica se a preparação da declaração foi bem-sucedida
if ($stmt_comentarios === false) {
    die('Erro na preparação da consulta de comentários: ' . $conn->error);
}

$stmt_comentarios->execute();
$result_comentarios = $stmt_comentarios->get_result();
$comentarios = $result_comentarios->fetch_all(MYSQLI_ASSOC);


// Fechar as declarações preparadas
$stmt_filme->close();
$stmt_atores->close();
$stmt_categorias->close();
$stmt_comentarios->close();

// Fechar conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($filme['Titulo']); ?></title>
    <!-- Adicionei um estilo básico para os comentários -->
    <style>
         body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #1a1a2e; /* Fundo escuro para realçar as cores */
    color: #ffffff;
    margin: 0;
    padding: 0;
}

.filme-container {
    background-color: #2c2f33; /* Cor de fundo escura */
    border: 1px solid #676767; /* Borda sutil */
    border-radius: 8px;
    padding: 2em;
    margin: 20px auto;
    width: 80%;
    max-width: 800px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); /* Sombra para efeito 3D */
}

.filme-titulo {
    font-size: 2.5em;
    color: #e4e6eb;
    text-shadow: 1px 1px 5px #000; /* Sombra no texto para efeito 3D */
    margin-bottom: 0.5em;
}

.filme-ano,
.filme-diretor {
    color: #b9bbbe;
    margin-bottom: 0.25em;
}

.filme-sinopse,
.filme-atores,
.filme-categorias {
    background-color: #3a3b3c; /* Fundo levemente mais claro para seção */
    border-radius: 4px;
    padding: 1em;
    margin-top: 1em;
}

.filme-sinopse strong,
.filme-atores strong,
.filme-categorias strong {
    color: #0099ff; /* Azul brilhante para títulos das seções */
}

ul {
    list-style-type: none;
    padding: 0;
}

li {
    background: linear-gradient(45deg, #ff0084, #3300ff); /* Gradiente nos itens */
    color: white;
    padding: 0.5em;
    margin-bottom: 0.5em;
    border-radius: 4px;
    box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5); /* Sombra para efeito 3D */
}

textarea {
    width: 100%;
    border-radius: 4px;
    border: 1px solid #555;
    padding: 0.5em;
    margin-top: 1em;
}

button {
    background-color: #ff0084; /* Botão rosa para combinar com a logo */
    border: none;
    padding: 1em 2em;
    color: #fff;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 1em;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); /* Sombra para efeito 3D */
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #3300ff; /* Cor de hover para combinar com a logo */
}

/* Responsividade para dispositivos móveis */
@media (max-width: 768px) {
    .filme-container {
        width: 95%;
        padding: 1em;
    }

    .filme-titulo {
        font-size: 1.8em;
    }
}

        .comentario {
            margin-top: 1em;
            border-top: 1px solid #676767;
            padding-top: 1em;
        }

        .comentario p {
            margin: 0;
        }

        .comentario strong {
            color: #0099ff;
        }
    </style>
</head>
<body>
    <div class="filme-container">
    <div class="filme-container">
        <h1 class="filme-titulo"><?php echo htmlspecialchars($filme['Titulo']); ?></h1>
        <p class="filme-ano"><strong>Ano de Lançamento:</strong> <?php echo htmlspecialchars($filme['AnoLancamento']); ?></p>
        <p class="filme-diretor"><strong>Diretor:</strong> <?php echo htmlspecialchars($filme['Diretor']); ?></p>
        <div class="filme-sinopse">
            <strong>Sinopse:</strong>
            <p><?php echo htmlspecialchars($filme['Sinopse']); ?></p>
        </div>
        <div class="filme-atores">
            <strong>Atores:</strong>
            <ul>
                <?php foreach ($atores as $ator): ?>
                    <li><?php echo htmlspecialchars($ator['Nome']); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="filme-categorias">
            <strong>Categorias:</strong>
            <ul>
                <?php foreach ($categorias as $categoria): ?>
                    <li><?php echo htmlspecialchars($categoria['Nome']); ?></li>
                <?php endforeach; ?>
            </ul>
                </div>
        <div id="secao-comentarios">
            <h3>Comentários</h3>
            <form action="inserir_comentario.php" method="post">
                <input type="hidden" name="filme_id" value="<?php echo $filmeId; ?>">
                <textarea name="comentario" placeholder="Escreva seu comentário aqui..." required></textarea>
                <button type="submit">Enviar Comentário</button>
            </form>
            <?php foreach ($comentarios as $comentario): ?>
                <div class="comentario">
                    <strong><?php echo htmlspecialchars($comentario['nome_usuario']); ?>:</strong>
                    <p><?php echo htmlspecialchars($comentario['comentario']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
