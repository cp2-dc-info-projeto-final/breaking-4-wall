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

        // Verifica se a ação é para excluir um comentário
        if (isset($_POST['excluir_comentario'])) {
            $comentarioId = $_POST['excluir_comentario'];

            // Exclui o comentário se o usuário for o autor
            $stmt_excluir = $conn->prepare("DELETE FROM comentarios WHERE ID = ? AND usuario_id = ?");
            $stmt_excluir->bind_param("ii", $comentarioId, $usuarioId);
            $stmt_excluir->execute();

            if ($stmt_excluir->error) {
                echo "Erro ao excluir comentário: " . $stmt_excluir->error;
            } else {
                echo "Comentário excluído com sucesso!";
            }

            $stmt_excluir->close();
        } else {
            // Insere o comentário no banco de dados
            $stmt_inserir = $conn->prepare("INSERT INTO comentarios (filme_id, usuario_id, comentario) VALUES (?, ?, ?)");
            $stmt_inserir->bind_param("iis", $filmeId, $usuarioId, $comentario);
            $stmt_inserir->execute();

            if ($stmt_inserir->error) {
                echo "Erro ao inserir comentário: " . $stmt_inserir->error;
            } else {
                header("Location: detalhes_filme.php?id=" . $filmeId);
                exit;
            }

            $stmt_inserir->close();
        }
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
