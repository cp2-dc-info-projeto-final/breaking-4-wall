<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    exit("Usuário não está logado.");
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["newName"], $_SESSION["id"])) {
    $servername = "localhost";
    $username_db = "cadastrados";
    $password_db = "123";
    $database = "CADASTRO";

    // Cria a conexão com o banco de dados
    $conn = new mysqli($servername, $username_db, $password_db, $database);

    // Verifica se a conexão foi bem-sucedida
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Escapa caracteres especiais na string fornecida para uso em uma instrução SQL
    $newName = $conn->real_escape_string(trim($_POST["newName"]));
    $userId = $_SESSION["id"]; // A chave primária do usuário na sessão

    // Prepara a declaração de atualização na tabela 'cadastrados'
    $stmt = $conn->prepare("UPDATE cadastrados SET nome = ? WHERE id = ?");
    if (!$stmt) {
        die("Erro ao preparar a declaração: " . $conn->error);
    }

    // Vincula os parâmetros e executa a declaração
    $stmt->bind_param("si", $newName, $userId);

    if ($stmt->execute()) {
        // Atualiza a variável de sessão
        $_SESSION["nome"] = $newName;
        $stmt->close();
        $conn->close();

        

        // Redireciona para a página do perfil ou outra página conforme necessário
        header("Location: perfil.php");
        exit;
    } else {
        echo "Erro ao atualizar o nome: " . $stmt->error;
    }

    // Fecha a declaração e a conexão
    $stmt->close();
    $conn->close();
} else {
    echo "Solicitação inválida.";
}
?>

