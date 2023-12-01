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

// Consulta para obter detalhes do filme
$stmt_filme = $conn->prepare("SELECT Titulo, AnoLancamento, Diretor, Sinopse FROM Filmes WHERE ID = ?");
$stmt_filme->bind_param("i", $filmeId);
$stmt_filme->execute();
$result_filme = $stmt_filme->get_result();
$filme = $result_filme->fetch_assoc();
$stmt_filme->close();

// Consulta para buscar os comentários do filme
$stmt_comentarios = $conn->prepare("SELECT comentario FROM comentarios WHERE filme_id = ?");
$stmt_comentarios->bind_param("i", $filmeId);
$stmt_comentarios->execute();
$result_comentarios = $stmt_comentarios->get_result();
$comentarios = $result_comentarios->fetch_all(MYSQLI_ASSOC);
$stmt_comentarios->close();


$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($filme['Titulo']); ?></title>
      <!-- Estilos existentes -->
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

        body {
            font-family: Arial, sans-serif;
        }
        /* Adicione mais estilos conforme necessário */
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

       <!-- Seção de comentários -->
<div id="secao-comentarios">
    <h3>Comentários</h3>
    
    <!-- Formulário para adicionar comentário -->
    <form action="inserir_comentario.php" method="post">
        <input type="hidden" name="filme_id" value="<?php echo $filmeId; ?>">
        <textarea name="comentario" placeholder="Escreva seu comentário aqui..." required></textarea>
        <button type="submit">Enviar Comentário</button>
    </form>

    <!-- Listar comentários existentes -->
    <?php foreach ($comentarios as $comentario): ?>
        <div class="comentario">
            <p><?php echo htmlspecialchars($comentario['comentario']); ?></p>
        </div>
    <?php endforeach; ?>
</div>
