<?php
session_start();
require_once 'conecta.php';

// Verifica se o usuário está logado como administrador
if (!isset($_SESSION['admin_id'])) {
    header('Location: login_adm.php');
    exit;
}

// Suponha que esteja recebendo o ID do administrador pela URL (método GET)
$adminId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Verifica se estamos recebendo dados do formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Aqui você vai validar e sanitizar os dados recebidos
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    
    // Atualiza as informações do administrador no banco de dados
    $sql = "UPDATE Administradores SET nome = ?, email = ? WHERE id = ?";
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

// Busca as informações atuais do administrador para exibir no formulário
$sql = "SELECT nome, email FROM Administradores WHERE id = ?";
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
    <!-- Seu <head> aqui -->
</head>
<body>

<!-- Formulário de edição -->
<form action="editar_administrador.php?id=<?php echo $adminId; ?>" method="post">
    Nome: <input type="text" name="nome" value="<?php echo htmlspecialchars($adminInfo['nome']); ?>"><br>
    Email: <input type="email" name="email" value="<?php echo htmlspecialchars($adminInfo['email']); ?>"><br>
    <input type="submit" value="Salvar Alterações">
</form>

</body>
</html>
