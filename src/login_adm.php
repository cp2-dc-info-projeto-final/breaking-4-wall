<?php
session_start();
require_once 'conecta.php';

// Verifica se já estamos logados e redireciona para o dashboard se estivermos
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

$mensagemErro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['password'];

    $sql = "SELECT id, senha FROM Administradores WHERE email = ?";
    $stmt = $conn->prepare($sql); // Mudança aqui: de $conexao para $conn

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows == 1) {
            $admin = $resultado->fetch_assoc();

            if (password_verify($senha, $admin['senha'])) {
                // Senha correta, registre o ID do administrador na sessão
                $_SESSION['admin_id'] = $admin['id'];
                header("Location: dashboard.php"); // Redirecione para o painel de administração
                exit;
            } else {
                // Senha incorreta
                $mensagemErro = 'Senha incorreta.';
            }
        } else {
            // E-mail não encontrado
            $mensagemErro = 'E-mail não encontrado.';
        }
        $stmt->close();
    } else {
        $mensagemErro = "Erro ao preparar a consulta: " . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <!-- Metadados e estilo aqui -->
</head>
<body>
    <?php if ($mensagemErro !== ''): ?>
    <p class="error"><?php echo $mensagemErro; ?></p>
    <?php endif; ?>
    
    <!-- Formulário de login aqui -->
</body>
</html>
