<?php
session_start();
require_once 'conecta.php';

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Informações de conexão com o banco de dados
    $servername = "localhost";
    $username = "cadastrados"; // Seu nome de usuário do banco de dados
    $password = "123"; // Sua senha do banco de dados
    $dbname = "CADASTRO";

    // Cria uma conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica se ocorreu algum erro na conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    $filmeId = $_POST['filme_id'];
    $comentario = $_POST['comentario'];
    $usuarioId = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null; // Define null se o usuário não estiver logado

    // Prepara a consulta SQL para inserir o comentário
    $stmt = $conn->prepare("INSERT INTO comentarios (filme_id, usuario_id, comentario) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $filmeId, $usuarioId, $comentario);
    $stmt->execute();

    if ($stmt->error) {
        // Tratar erro ao inserir o comentário
        echo "Erro: " . $stmt->error;
    } else {
        // Redireciona de volta para a página do filme após inserir o comentário
        header("Location: detalhes_filme.php?id=" . $filmeId);
    }

    $stmt->close();
    $conn->close();
} else {
    // Redireciona para a página principal se o script for acessado diretamente
    header("Location: index.html");
}
?>
