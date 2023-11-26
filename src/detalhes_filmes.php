<?php
session_start(); // Inicia a sessão para verificar o login do usuário

// Configuração das variáveis de conexão com o banco de dados
$servername = "localhost";
$username = "alvaro";
$password = "12345";
$dbname = "cadastro";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Certifique-se de que um ID foi passado na URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID do filme não foi especificado.');
}

$filmeId = $_GET['id'];

// Consulta atualizada para incluir as categorias
$stmt = $conn->prepare("
    SELECT f.Titulo, f.AnoLancamento, f.Diretor, f.Sinopse, GROUP_CONCAT(c.Nome SEPARATOR ', ') AS Categorias
    FROM Filmes f
    LEFT JOIN FilmesCategorias fc ON f.ID = fc.FilmeID
    LEFT JOIN Categorias c ON fc.CategoriaID = c.ID
    WHERE f.ID = ?
    GROUP BY f.ID
");
$stmt->bind_param("i", $filmeId);
$stmt->execute();
$result = $stmt->get_result();

// Se nenhum filme for encontrado, exiba uma mensagem
if ($result->num_rows === 0) {
    die('Filme não encontrado.');
}

// Pegue os dados do filme, incluindo as categorias
$filme = $result->fetch_assoc();

// Defina o caminho da imagem do poster diretamente aqui
$caminhoImagem = "mengo.png"; // Este valor deve ser o caminho correto da imagem do poster

// Feche a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($filme['Titulo']); ?></title>
    <style>
        .filme-imagem {
    max-width: 70%; /* Diminui para 70% da largura do container */
    border-radius: 8px;
    margin-top: 1em;
    display: block; /* Garante que a imagem seja tratada como um bloco */
    margin-left: auto; /* Centraliza a imagem horizontalmente */
    margin-right: auto;
}

          body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f0f2f5;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.filme-container {
    background-color: #fff;
    width: 80%;
    max-width: 800px;
    margin: 20px auto;
    padding: 2em;
    border-radius: 8px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.filme-titulo {
    color: #1a1a2e;
    font-size: 2em;
    margin-bottom: 0.5em;
}

.filme-ano,
.filme-diretor {
    color: #525252;
    margin-bottom: 0.25em;
}

.filme-sinopse {
    margin-top: 1em;
    line-height: 1.6;
}

.filme-categorias {
    background-color: #eaeaea;
    color: #333;
    padding: 0.5em;
    border-radius: 4px;
    display: inline-block;
    margin-top: 1em;
}

.filme-imagem {
    width: 100%;
    border-radius: 8px;
    margin-top: 1em;
}

/* Adaptação para dispositivos móveis */
@media (max-width: 768px) {
    .filme-container {
        width: 95%;
        padding: 1em;
    }

    .filme-titulo {
        font-size: 1.5em;
    }
}


    </style>
</head>
<body>
    <div class="filme-container">
        <h1 class="filme-titulo"><?php echo htmlspecialchars($filme['Titulo']); ?></h1>
        <p class="filme-ano"><strong>Ano de Lançamento:</strong> <?php echo htmlspecialchars($filme['AnoLancamento']); ?></p>
        <p class="filme-diretor"><strong>Diretor:</strong> <?php echo htmlspecialchars($filme['Diretor']); ?></p>
        <div class="filme-sinopse">
            <strong>Sinopse:</strong>
            <p><?php echo htmlspecialchars($filme['Sinopse']); ?></p>
        </div>
        <!-- Adiciona a exibição das categorias aqui -->
        <p><strong>Categoria(s):</strong> <?php echo htmlspecialchars($filme['Categorias']); ?></p>
        <img class="filme-imagem" src="<?php echo $caminhoImagem; ?>" alt="Poster do filme">
    </div>
</body>
</html>
