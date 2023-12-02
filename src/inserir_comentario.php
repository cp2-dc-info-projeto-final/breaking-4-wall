<?php
session_start();
require_once 'conecta.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "cadastrados", "123", "CADASTRO");

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        // Usuário está logado
        $filmeId = $_POST['filme_id'];
        $comentario = $_POST['comentario'];
        $usuarioId = $_SESSION['id']; // Usando o ID do usuário logado

        // Insere o comentário no banco de dados
        $stmt = $conn->prepare("INSERT INTO comentarios (filme_id, usuario_id, comentario) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $filmeId, $usuarioId, $comentario);
        $stmt->execute();

        if ($stmt->error) {
            echo "Erro: " . $stmt->error;
        } else {
            header("Location: detalhes_filme.php?id=" . $filmeId);
            exit;
        }
        $stmt->close();
    } else {
        // Se o usuário não estiver logado, exibe uma mensagem
        echo "<p>Você precisa estar logado para comentar.</p>";
    }

    $conn->close();
} else {
    header("Location: index.html");
    exit;
}
?>
