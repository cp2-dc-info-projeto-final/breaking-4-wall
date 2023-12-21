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

        // Recupera o nome do usuário do banco de dados
        $stmt_usuario = $conn->prepare("SELECT nome FROM cadastrados WHERE ID = ?");
        $stmt_usuario->bind_param("i", $usuarioId);
        $stmt_usuario->execute();
        $stmt_usuario->bind_result($nomeUsuario);
        $stmt_usuario->fetch();
        $stmt_usuario->close();

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
            $stmt_inserir = $conn->prepare("INSERT INTO comentarios (filme_id, usuario_id, nome_usuario, comentario) VALUES (?, ?, ?, ?)");

            // Verifica se a preparação da declaração foi bem-sucedida
            if ($stmt_inserir === false) {
                die('Erro na preparação da declaração de inserção de comentário: ' . $conn->error);
            }
            
            // Substitua "s" por "ss" para acomodar a coluna nome_usuario que é do tipo VARCHAR
            $stmt_inserir->bind_param("iiss", $filmeId, $usuarioId, $nomeUsuario, $comentario);
            $stmt_inserir->execute();
            
            // Verifica se a execução foi bem-sucedida
            if ($stmt_inserir->error) {
                die('Erro na execução da inserção de comentário: ' . $stmt_inserir->error);
            }
            
            // Se a execução foi bem-sucedida, redirecione para a página de detalhes com um parâmetro de consulta indicando sucesso
            header("Location: detalhes_filme.php?id=" . $filmeId . "&comentario_enviado=1");
            exit();
            
            // Feche a declaração preparada
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
