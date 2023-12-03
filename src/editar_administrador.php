<?php
session_start();
require_once 'conecta.php';

$adminId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$adminId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    
    $sql = "UPDATE Cadastrado SET nome = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssi", $nome, $email, $adminId);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "Informações atualizadas com sucesso!";
        } else {
            echo "Nenhuma informação foi alterada.";
        }
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }
}

$sql = "SELECT nome, email FROM Cadastrados WHERE id = ?";
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
        input[type="email"] {
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
    Usuario: <input type="text" name="nome" value="<?php echo htmlspecialchars($adminInfo['nome']); ?>"><br>
    Email: <input type="email" name="email" value="<?php echo htmlspecialchars($adminInfo['email']); ?>"><br>
    <input type="submit" value="Salvar Alterações">
</form>

</body>
</html>


