<?php
session_start();

require_once 'conecta.php';

// Verifica se o usuário está logado e se é um administrador
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header('Location: login.php');
    exit;
}

$adminId = $_SESSION["id"];

// Busca as informações do administrador logado na tabela Administradores
$sqlAdminLogado = "SELECT usuario, email FROM Administradores WHERE id = ?";
$stmtAdminLogado = $conn->prepare($sqlAdminLogado);

if (!$stmtAdminLogado) {
    die("Erro na preparação da consulta: " . $conn->error);
}

$stmtAdminLogado->bind_param("i", $adminId);
$stmtAdminLogado->execute();
$resultAdminLogado = $stmtAdminLogado->get_result();

if ($resultAdminLogado->num_rows > 0) {
    $adminInfo = $resultAdminLogado->fetch_assoc();
} else {
    // Se não encontrar o administrador, redireciona para o login
    header('Location: login.php');
    exit;
}

$stmtAdminLogado->close();


// Buscar atores
$stmt_atores = $conn->prepare("SELECT ID, Nome FROM Atores");
$stmt_atores->execute();
$result_atores = $stmt_atores->get_result();
$atores_options = '';
while ($ator = $result_atores->fetch_assoc()) {
    $atores_options .= '<option value="' . $ator['ID'] . '">' . htmlspecialchars($ator['Nome']) . '</option>';
}
$stmt_atores->close();

// Buscar filmes
$stmt_filmes = $conn->prepare("SELECT ID, Titulo FROM Filmes");
$stmt_filmes->execute();
$result_filmes = $stmt_filmes->get_result();
$filmes_options = '';
while ($filme = $result_filmes->fetch_assoc()) {
    $filmes_options .= '<option value="' . $filme['ID'] . '">' . htmlspecialchars($filme['Titulo']) . '</option>';
}
$stmt_filmes->close();

// Fechar a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Vincular Atuação</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            padding: 40px;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
            box-sizing: border-box; /* Ensures padding doesn't affect overall width */
        }
        button {
            color: #fff;
            background-color: #7b1fa2; /* Alterado para roxo */
            border-color: #7b1fa2; /* Alterado para a mesma cor roxa */
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background-color: #5e1770; /* Alterado para um tom mais escuro de roxo ao passar o mouse */
            border-color: #5e1770; /* Mantido o mesmo tom mais escuro de roxo */
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Vincular Ator a Filme</h2>
    <form action="processar_vinculo.php" method="POST">
        <label for="ator">Ator:</label>
        <select id="ator" name="atorID">
            <?php echo $atores_options; ?>
        </select>

        <label for="filme">Filme:</label>
        <select id="filme" name="filmeID">
            <?php echo $filmes_options; ?>
        </select>

        <button type="submit">Vincular Atuação</button>
    </form>
</div>

</body>
</html>
