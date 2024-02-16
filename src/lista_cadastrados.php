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

// Consulta para buscar os usuários cadastrados na tabela Administradores
$sqlUsersAdmin = "SELECT id, usuario, email FROM Administradores";
$stmtUsersAdmin = $conn->prepare($sqlUsersAdmin);

if (!$stmtUsersAdmin) {
    die('Erro na preparação da consulta: ' . htmlspecialchars($conn->error));
}

$stmtUsersAdmin->execute();
$resultUsersAdmin = $stmtUsersAdmin->get_result();

$usersInfoAdmin = [];
if ($resultUsersAdmin->num_rows > 0) {
    while ($row = $resultUsersAdmin->fetch_assoc()) {
        $usersInfoAdmin[] = $row;
    }
}

$stmtUsersAdmin->close();

// Consulta para buscar os usuários cadastrados na tabela cadastrados
$sqlUsersCadastrados = "SELECT id, nome, email FROM cadastrados";
$stmtUsersCadastrados = $conn->prepare($sqlUsersCadastrados);

if (!$stmtUsersCadastrados) {
    die('Erro na preparação da consulta: ' . htmlspecialchars($conn->error));
}

$stmtUsersCadastrados->execute();
$resultUsersCadastrados = $stmtUsersCadastrados->get_result();

$usersInfoCadastrados = [];
if ($resultUsersCadastrados->num_rows > 0) {
    while ($row = $resultUsersCadastrados->fetch_assoc()) {
        $usersInfoCadastrados[] = $row;
    }
}

$stmtUsersCadastrados->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        .container {
            background-color: #fff;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        form, a {
            display: inline-block;
            vertical-align: middle;
        }

        button[type=submit] {
            padding: 8px 15px;
            border: none;
            color: white;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        button[type=submit]:hover {
            background-color: #c0392b; /* Vermelho mais escuro no hover */
        }

        .btn-excluir {
            background-color: #e74c3c; /* Vermelho */
        }

        .btn-excluir:hover {
            background-color: #c0392b; /* Vermelho mais escuro no hover */
        }

        .btn-adm {
            background: -webkit-linear-gradient(-135deg, #fff, rgb(233, 6, 249));
        }

        .btn-adm:hover {
            background-color: darkgreen; /* Verde mais escuro no hover */
        }

        a {
            padding: 8px 15px;
            border: none;
            background-color: #8e44ad; /* Roxo */
            color: white;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        a:hover {
            background-color: #6c3483; /* Roxo mais escuro no hover */
        }
    </style>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h1>Lista de Usuários</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário/Nome</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usersInfoAdmin as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['usuario']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>Administrador</td>
                        <td>
                            <form action="excluir_admin.php" method="POST" style="display: inline-block; margin-right: 5px;">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit" name="delete" class="btn-excluir">Excluir</button>
                            </form>
                            <a href="editar_administrador.php?id=<?php echo $user['id']; ?>">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php foreach ($usersInfoCadastrados as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['nome']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>Usuário</td>
                        <td>
                            <form action="excluir_usuario.php" method="POST" style="display: inline-block; margin-right: 5px;">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit" name="delete" class="btn-excluir">Excluir</button>
                            </form>
                            <a href="editar_cadastrados.php?id=<?php echo $user['id']; ?>">Editar</a>
                            <form action="transformar_admin.php" method="POST" style="display: inline-block; margin-right: 5px;">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit" name="transformar_admin" class="btn-adm">Tornar Adm </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
