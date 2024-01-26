<?php
session_start();
require_once 'conecta.php';

$adminId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = isset($_POST['nome']) ? $_POST['nome'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $senhaAtual = isset($_POST['senha_atual']) ? $_POST['senha_atual'] : null;
    $novaSenha = isset($_POST['nova_senha']) ? $_POST['nova_senha'] : null;

    $sqlSelect = "SELECT senha FROM Administradores WHERE id = ?";
    $stmtSelect = $conn->prepare($sqlSelect);
    $stmtSelect->bind_param("i", $adminId);
    $stmtSelect->execute();
    $resultSelect = $stmtSelect->get_result();
    $row = $resultSelect->fetch_assoc();
    $senhaAtualBanco = $row['senha'];

    if (empty($senhaAtual) || password_verify($senhaAtual, $senhaAtualBanco) || empty($senhaAtualBanco)) {
        // A senha atual está correta ou não há senha definida, então podemos proceder com a atualização

        if (!empty($novaSenha)) {
            $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
        } else {
            $senhaHash = $senhaAtualBanco; // Mantém a senha existente se não for fornecida uma nova senha
        }

        $sqlUpdate = "UPDATE Administradores SET usuario = COALESCE(?, usuario), email = COALESCE(?, email), senha = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        
        if ($stmtUpdate) {
            $stmtUpdate->bind_param("sssi", $nome, $email, $senhaHash, $adminId);
            $stmtUpdate->execute();

            if ($stmtUpdate->affected_rows > 0) {
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Nenhuma informação foi alterada.";
            }

            $stmtUpdate->close();
        } else {
            echo "Erro ao preparar a consulta: " . $conn->error;
        }
    } else {
        echo "Senha atual incorreta. Tente novamente.";
    }

    $stmtSelect->close();
}

$sql = "SELECT usuario, email FROM Administradores WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $adminId);
$stmt->execute();
$result = $stmt->get_result();
$adminInfo = $result->fetch_assoc();
$stmt->close();
?>


<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração - Perfil</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        form {
            background: #fff;
            max-width: 500px;
            margin: 30px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #ff6b6b;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 10px;
            color: #333;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4ecdc4;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #3b9b8f;
        }
        @media (max-width: 768px) {
            form {
                width: 90%;
                padding: 15px;
            }
        }
    </style>
</head>
<body>

<form action="editar_administrador.php?id=<?php echo $adminId; ?>" method="post">
    Usuário: <input type="text" name="nome" value="<?php echo htmlspecialchars($adminInfo['usuario']); ?>"><br>
    Email: <input type="email" name="email" value="<?php echo htmlspecialchars($adminInfo['email']); ?>"><br>
    Senha Atual: <input type="password" name="senha_atual"><br>
    Nova Senha: <input type="password" name="nova_senha"><br>
    <input type="submit" value="Salvar Alterações">
</form>

</body>
</html>
