<?php
session_start();

require_once 'conecta.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['transformar_admin'])) {
    $userId = $_POST["id"];

    // Consulta para buscar as informações do usuário na tabela cadastrados
    $sqlUserInfo = "SELECT nome, email, senha FROM cadastrados WHERE id = ?";
    $stmtUserInfo = $conn->prepare($sqlUserInfo);

    if (!$stmtUserInfo) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    $stmtUserInfo->bind_param("i", $userId);
    $stmtUserInfo->execute();
    $resultUserInfo = $stmtUserInfo->get_result();

    if ($resultUserInfo->num_rows > 0) {
        $userInfo = $resultUserInfo->fetch_assoc();
        $nome = $userInfo['nome'];
        $email = $userInfo['email'];
        $senha = $userInfo['senha'];

        // Inserir o usuário na tabela Administradores com a mesma senha
        $sqlInsertAdmin = "INSERT INTO Administradores (usuario, email, senha) VALUES (?, ?, ?)";
        $stmtInsertAdmin = $conn->prepare($sqlInsertAdmin);

        if (!$stmtInsertAdmin) {
            die("Erro na preparação da consulta: " . $conn->error);
        }

        // Gerar um nome de usuário a partir do email (pode ser personalizado de acordo com a lógica desejada)
        $usuario = explode('@', $email)[0]; // Usando a parte do email antes do '@' como nome de usuário

        $stmtInsertAdmin->bind_param("sss", $usuario, $email, $senha);
        $stmtInsertAdmin->execute();
        $stmtInsertAdmin->close();

        // Excluir o usuário da tabela cadastrados
        $sqlDeleteUser = "DELETE FROM cadastrados WHERE id = ?";
        $stmtDeleteUser = $conn->prepare($sqlDeleteUser);

        if (!$stmtDeleteUser) {
            die("Erro na preparação da consulta: " . $conn->error);
        }

        $stmtDeleteUser->bind_param("i", $userId);
        $stmtDeleteUser->execute();
        $stmtDeleteUser->close();
    }

    $stmtUserInfo->close();
}

$conn->close();

header('Location: dashboard.php');
exit;
?>
