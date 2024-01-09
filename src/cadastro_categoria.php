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
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Categorias</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 300px; padding: 16px; background-color: white; }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
        }
        input[type=text]:focus, input[type=password]:focus {
            background-color: #ddd;
            outline: none;
        }
        .btn {
            background-color: #7b1fa2; /* Alterado para roxo */
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            opacity: 0.9;
        }
        .btn:hover {
            opacity:1;
        }
    </style>
</head>
<body>

<div class="container">
  <form action="cadastrar_categoria.php" method="POST">
    <label for="nomeCategoria">Nome da Categoria:</label>
    <input type="text" id="nomeCategoria" name="nomeCategoria" required>

    <button type="submit" class="btn">Cadastrar</button>
  </form>
</div>

</body>
</html>
