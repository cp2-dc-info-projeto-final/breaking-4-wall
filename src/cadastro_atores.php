<?php
session_start();

require_once 'conecta.php';

// Verifica se o usuário está logado e se é um administrador
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header('Location: login.php');
    exit;
}

$adminId = $_SESSION["id"];

// Busca as informações do administrador logado no banco de dados
$sqlAdminLogado = "SELECT nome, email, is_admin FROM Cadastrados WHERE id = ?";
$stmtAdminLogado = $conn->prepare($sqlAdminLogado);
$stmtAdminLogado->bind_param("i", $adminId);
$stmtAdminLogado->execute();
$resultAdminLogado = $stmtAdminLogado->get_result();

if ($resultAdminLogado->num_rows > 0) {
    $adminInfo = $resultAdminLogado->fetch_assoc();
    if ($adminInfo['is_admin'] != 1) { // Se não for administrador
        header('Location: index.html'); // Redireciona para a página inicial
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}

$stmtAdminLogado->close();

// O restante do seu código HTML segue aqui...
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Cadastro de Atores</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }
    .container {
        background-color: #fff;
        max-width: 500px;
        margin: 20px auto;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .input-group {
        margin-bottom: 1em;
    }
    .input-group label {
        display: block;
        margin-bottom: 0.5em;
    }
    .input-group input,
    .input-group select,
    .input-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .input-group textarea {
        height: 100px;
    }
    button {
        width: 100%;
        padding: 10px;
        background-color: #7b1fa2; /* Alterado para roxo */
        border: none;
        border-radius: 4px;
        color: white;
        cursor: pointer;
        font-size: 16px;
    }
    button:hover {
        background-color: #5e1770; /* Alterado para um tom mais escuro de roxo ao passar o mouse */
    }
</style>
</head>
<body>

<div class="container">
    <h2>Cadastro de Atores</h2>
    <form action="cadastrar_ator.php" method="POST">
        <div class="input-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        <div class="input-group">
            <label for="dataNascimento">Data de Nascimento:</label>
            <input type="date" id="dataNascimento" name="dataNascimento">
        </div>
        <div class="input-group">
            <label for="nacionalidade">Nacionalidade:</label>
            <input type="text" id="nacionalidade" name="nacionalidade">
        </div>
        <div class="input-group">
            <label for="genero">Gênero:</label>
            <select id="genero" name="genero">
                <option value="Masculino">Masculino</option>
                <option value="Feminino">Feminino</option>
                <option value="Outro">Outro</option>
            </select>
        </div>
        <div class="input-group">
            <label for="biografia">Biografia:</label>
            <textarea id="biografia" name="biografia"></textarea>
        </div>
        <button type="submit">Cadastrar Ator</button>
    </form>
</div>

</body>
</html>
