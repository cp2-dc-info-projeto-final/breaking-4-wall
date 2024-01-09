<?php
session_start();

require_once 'conecta.php';

// A lógica para redirecionar para a tela de login foi removida. 

$sqlUsers = "SELECT id, nome, email FROM cadastrados";
$stmtUsers = $conn->prepare($sqlUsers);

if (!$stmtUsers) {
    die('Erro na preparação da consulta: ' . htmlspecialchars($conn->error));
}

$stmtUsers->execute();
$resultUsers = $stmtUsers->get_result();

$usersInfo = [];
if ($resultUsers->num_rows > 0) {
    while ($row = $resultUsers->fetch_assoc()) {
        $usersInfo[] = $row;
    }
}

$stmtUsers->close();
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
            background-color: #e74c3c; /* Vermelho */
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
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usersInfo as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['nome']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>
                            <form action="excluir_usuario.php" method="POST" style="display: inline-block; margin-right: 5px;">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit" name="delete">Excluir</button>
                            </form>
                            <a href="editar_cadastrados.php?id=<?php echo $user['id']; ?>">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
